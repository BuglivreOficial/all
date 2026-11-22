# API BugLivre

Documentação das rotas JSON da API. Todas as rotas ficam sob o prefixo `/api`
(registradas em [routes/api.php](file:///d:/buglivreoficial/routes/api.php)).

- **Formato**: `application/json; charset=utf-8`
- **Corpo de entrada**: JSON (`Content-Type: application/json`)
- **Autenticação**: token opaco Bearer no cabeçalho `Authorization: Bearer <token>` (stateless)
- **Base URL (dev)**: `http://localhost:8000/api`

Leitura do catálogo é **pública**. Escrita exige autenticação e perfil
`moderador` ou superior (`moderador`, `suporte`, `admin`).

---

## Envelope de resposta

Respostas de sucesso dos controllers usam o formato:

```json
{
  "success": true,
  "message": "OK",
  "data": {}
}
```

- `201 Created` é usado em criação (`created`), com a mesma estrutura.
- `data` pode ser `null` (ex.: logout, exclusão).

Erros de validação retornam **422** com o mapa de campos:

```json
{
  "success": false,
  "message": "Dados inválidos.",
  "errors": {
    "title": ["O título é obrigatório."]
  }
}
```

Erros de middleware (`401`/`403`) e exceções HTTP (ex.: `404`) usam um formato
enxuto:

```json
{ "status": 404, "message": "Categoria não encontrada." }
```

### Códigos de status

| Código | Significado                                                        |
| ------ | ------------------------------------------------------------------ |
| `200`  | Sucesso                                                            |
| `201`  | Recurso criado                                                     |
| `401`  | Não autenticado (token ausente, inválido ou expirado)             |
| `403`  | Perfil insuficiente (exige `moderador` ou superior)               |
| `404`  | Recurso não encontrado                                             |
| `409`  | Conflito (exclusão bloqueada por vínculos)                         |
| `422`  | Erro de validação (campo `errors`)                                 |
| `500`  | Erro interno do servidor                                           |

### Perfis (roles) e hierarquia

`user (1) < vip (2) < moderador (3) < suporte (4) < admin (5)`.
Um perfil de nível maior satisfaz exigências menores — por exemplo, `admin`
atende a exigência `moderador`.

---

## Autenticação

### `POST /api/auth/register`

Cria usuário (perfil inicial `user`) e já emite um token.

**Corpo**

| Campo                   | Tipo   | Obrigatório | Regras                                                        |
| ----------------------- | ------ | ----------- | ------------------------------------------------------------- |
| `name`                  | string | sim         | mín. 3 caracteres                                             |
| `username`              | string | sim         | 3–60 chars: `A-Z a-z 0-9 . _ -`; único                         |
| `email`                 | string | sim         | e-mail válido; único (normalizado em minúsculas)              |
| `password`              | string | sim         | mín. 8 caracteres                                             |
| `password_confirmation` | string | não         | se informado, deve conferir com `password`                    |

**Resposta `201`**

```json
{
  "success": true,
  "message": "Usuário registrado com sucesso.",
  "data": {
    "user": {
      "id": 1,
      "name": "Ana",
      "username": "ana",
      "email": "ana@exemplo.com",
      "role": "user",
      "role_label": "Usuário",
      "created_at": "2026-11-22 10:00:00"
    },
    "token": "6f1c...e9",
    "expires_at": "2026-12-22 10:00:00"
  }
}
```

### `POST /api/auth/login`

Aceita **e-mail ou nome de usuário** no mesmo campo.

**Corpo**

| Campo      | Tipo   | Obrigatório | Notas                              |
| ---------- | ------ | ----------- | ---------------------------------- |
| `login`    | string | sim         | e-mail ou username (`email` também é aceito como alternativa) |
| `password` | string | sim         |                                    |

**Resposta `200`** — mesmo formato de `register` (`user`, `token`, `expires_at`).
Falha de credenciais retorna **401** `{ "success": false, "message": "Credenciais inválidas." }`.

### `POST /api/auth/logout`

Revoga o token enviado no cabeçalho. Sempre retorna `200`.

```json
{ "success": true, "message": "Sessão encerrada.", "data": null }
```

### `POST /api/auth/refresh`

Revoga o token atual e emite um novo. Requer `Authorization: Bearer <token>`.

```json
{
  "success": true,
  "message": "Token renovado com sucesso.",
  "data": { "token": "novo...token", "expires_at": "2026-12-22 10:00:00" }
}
```

Token ausente/inválido retorna **401** `{ "success": false, "message": "Não autenticado." }`.

### `GET /api/auth/me`

Retorna o usuário do token. Requer `Authorization: Bearer <token>`.

```json
{
  "success": true,
  "message": "OK",
  "data": {
    "id": 1,
    "name": "Ana",
    "username": "ana",
    "email": "ana@exemplo.com",
    "role": "admin",
    "role_label": "Administrador",
    "created_at": "2026-11-22 10:00:00"
  }
}
```

---

## Categorias

Objeto de categoria:

```json
{
  "id": 1,
  "name": "Ação",
  "slug": "acao",
  "description": null,
  "is_active": true,
  "created_at": "2026-11-22 10:00:00",
  "updated_at": "2026-11-22 10:00:00"
}
```

| Método | Rota                        | Auth                       | Descrição                    |
| ------ | --------------------------- | -------------------------- | ---------------------------- |
| GET    | `/api/categories`           | pública                    | Lista (aceita `?only_active=1`) |
| GET    | `/api/categories/{id}`      | pública                    | Detalhe                      |
| POST   | `/api/categories`           | `auth` + `role:moderador`  | Cria                         |
| PUT/PATCH | `/api/categories/{id}`   | `auth` + `role:moderador`  | Atualiza                     |
| POST   | `/api/categories/{id}/status` | `auth` + `role:moderador` | Alterna ativa/inativa      |
| DELETE | `/api/categories/{id}`      | `auth` + `role:moderador`  | Exclui (409 se houver mangás) |

**Corpo de criação/atualização**

| Campo         | Tipo   | Obrigatório | Regras                          |
| ------------- | ------ | ----------- | ------------------------------- |
| `name`        | string | sim         | 2–120 caracteres; único         |
| `description` | string | não         | máx. 1000 caracteres            |

O `slug` é gerado automaticamente a partir de `name` (transliterado para ASCII;
ex.: `"Ação & Aventura"` → `acao-aventura`). `only_active` aceita `1`, `true` ou `yes`.

- **404** se o `id` não existir.
- **409** na exclusão se houver mangás vinculados.

---

## Tipos de mangá

Mesmo modelo de Categorias, com `description`. Tipos iniciais: Mangá, Manhwa,
Manhua, Webtoon, Comic, HQ, Pornhwa.

| Método | Rota                   | Auth                      | Descrição                       |
| ------ | ---------------------- | ------------------------- | ------------------------------- |
| GET    | `/api/types`           | pública                   | Lista (aceita `?only_active=1`) |
| GET    | `/api/types/{id}`      | pública                   | Detalhe                         |
| POST   | `/api/types`           | `auth` + `role:moderador` | Cria                            |
| PUT/PATCH | `/api/types/{id}`   | `auth` + `role:moderador` | Atualiza                        |
| POST   | `/api/types/{id}/status` | `auth` + `role:moderador` | Alterna ativo/inativo        |
| DELETE | `/api/types/{id}`      | `auth` + `role:moderador` | Exclui (409 se houver mangás)   |

**Corpo**: `name` (2–120, único) e `description` (máx. 1000).

Objeto de resposta:

```json
{
  "id": 1,
  "name": "Mangá",
  "slug": "manga",
  "description": null,
  "is_active": true,
  "created_at": "2026-11-22 10:00:00",
  "updated_at": "2026-11-22 10:00:00"
}
```

---

## Autores

Mesmo modelo de Tipos, usando `bio` no lugar de `description`.

| Método | Rota                     | Auth                      | Descrição                       |
| ------ | ------------------------ | ------------------------- | ------------------------------- |
| GET    | `/api/authors`           | pública                   | Lista (aceita `?only_active=1`) |
| GET    | `/api/authors/{id}`      | pública                   | Detalhe                         |
| POST   | `/api/authors`           | `auth` + `role:moderador` | Cria                            |
| PUT/PATCH | `/api/authors/{id}`   | `auth` + `role:moderador` | Atualiza                        |
| POST   | `/api/authors/{id}/status` | `auth` + `role:moderador` | Alterna ativo/inativo        |
| DELETE | `/api/authors/{id}`      | `auth` + `role:moderador` | Exclui (409 se houver mangás)   |

**Corpo**: `name` (2–150, único) e `bio` (máx. 3000).

Objeto de resposta:

```json
{
  "id": 1,
  "name": "Kenji",
  "slug": "kenji",
  "bio": null,
  "is_active": true,
  "created_at": "2026-11-22 10:00:00",
  "updated_at": "2026-11-22 10:00:00"
}
```

---

## Mangás

Objeto de mangá:

```json
{
  "id": 1,
  "type_id": 1,
  "type_name": "Mangá",
  "author_id": 2,
  "author_name": "Kenji",
  "title": "Exemplo",
  "slug": "exemplo",
  "description": "Sinopse...",
  "cover": "/uploads/covers/2026/11/abc.png",
  "status": "ongoing",
  "status_label": "Em publicação",
  "is_active": true,
  "categories": [{ "id": 1, "name": "Ação" }],
  "category_names": ["Ação"],
  "created_at": "2026-11-22 10:00:00",
  "updated_at": "2026-11-22 10:00:00"
}
```

| Método | Rota                     | Auth                      | Descrição                       |
| ------ | ------------------------ | ------------------------- | ------------------------------- |
| GET    | `/api/mangas`            | pública                   | Lista com filtros               |
| GET    | `/api/mangas/{id}`       | pública                   | Detalhe                         |
| POST   | `/api/mangas`            | `auth` + `role:moderador` | Cria                            |
| PUT/PATCH | `/api/mangas/{id}`    | `auth` + `role:moderador` | Atualiza                        |
| POST   | `/api/mangas/{id}/status` | `auth` + `role:moderador` | Alterna ativo/inativo        |
| DELETE | `/api/mangas/{id}`       | `auth` + `role:moderador` | Exclui                          |

### Filtros de `GET /api/mangas`

| Query          | Descrição                                        |
| -------------- | ------------------------------------------------ |
| `q`            | Busca por título ou nome do autor (`LIKE`)       |
| `category`     | ID da categoria                                  |
| `type`         | ID do tipo de mangá                              |
| `only_active`  | `1` / `true` / `yes` para apenas ativos          |

### Corpo de criação/atualização

| Campo          | Tipo    | Obrigatório | Regras                                                       |
| -------------- | ------- | ----------- | ------------------------------------------------------------ |
| `type_id`      | int     | sim         | deve existir                                                 |
| `author_id`    | int     | não         | se informado, deve existir                                   |
| `title`        | string  | sim         | 2–200 caracteres; único                                      |
| `category_ids` | int[]   | sim         | ao menos uma categoria válida                                |
| `description`  | string  | não         | máx. 5000 caracteres                                         |
| `cover`        | string  | não         | URL absoluta ou caminho iniciado por `/`; máx. 255 chars     |
| `status`       | string  | sim         | `ongoing`, `completed`, `hiatus` ou `cancelled`              |

- O `slug` é gerado a partir de `title`.
- `category_ids` é um **array** (ex.: `[1, 2]`); os vínculos N:N são sincronizados.
- Rótulos de status: `ongoing` → *Em publicação*, `completed` → *Completo*,
  `hiatus` → *Em hiato*, `cancelled` → *Cancelado*.

**Exemplo**

```json
POST /api/mangas
{
  "type_id": 1,
  "author_id": 2,
  "title": "Exemplo",
  "category_ids": [1, 3],
  "description": "Sinopse...",
  "cover": "/uploads/covers/2026/11/abc.png",
  "status": "ongoing"
}
```

---

## Observações

- Ao excluir categoria, tipo ou autor com mangás vinculados, a API retorna **409**.
- A API é stateless: nenhuma sessão é criada; a identidade vem apenas do token Bearer.
- Erros de validação nunca retornam os dados enviados; apenas o mapa `errors`.
