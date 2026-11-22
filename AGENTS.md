# AGENTS.md — BugLivre Oficial

Informações para agentes de IA e desenvolvedores que trabalharem neste repositório.

## Visão geral

Micro-framework PHP próprio, no padrão MVC, com duas áreas separadas no mesmo núcleo:

- **Web** (`routes/web.php`): respostas em **HTML** (templates **Twig** + sessão).
- **API** (`routes/api.php`, sob o prefixo `/api`): respostas em **JSON** (token Bearer, stateless).

Além do painel administrativo (`/admin`), a área web expõe um **catálogo público**
(`/mangas` e `/mangas/{slug}`) e uma home repaginada com tema escuro.

A negociação de resposta é automática via `Core\Http\Request::wantsJson()`
(caminho sob `/api` ou cabeçalho `Accept: application/json`).

## Stack

- **PHP 8.5** (usa propriedades tipadas, `match`, enums de atributos, `str_contains`, `readonly`-style).
- **Composer** com autoload PSR-4:
  - `Core\` → `core/`
  - `App\` → `app/`
  - Funções auxiliares em `core/helpers.php` (carregadas via `files` no `composer.json`).
- **MySQL** acessado via **PDO** (conexão lazy singleton em `Core\Database\Connection`).
- **Twig 3** (`twig/twig`) como motor de templates da área web. O `Core\View\View`
  encapsula o `Environment` (cache em `storage/cache/twig`, `auto_reload`).
- **CSS próprio** em `public/assets/css` (`site.css` para o site público, `admin.css`
  para o painel), servido diretamente pelo front controller.
- **Armazenamento de capas no próprio servidor**: uploads gravados em
  `public/uploads/covers/AAAA/MM/`, encapsulados em `App\Services\CoverStorage`.
- Sem framework externo de rotas/HTTP: tudo implementado em `core/`.

## Estrutura de diretórios

```
core/                 Núcleo do framework (namespace Core\)
  Application.php     Bootstrap: carrega .env, timezone, views, error handling e router
  helpers.php         base_path, app_path, storage_path, env, config_bool, logger
  Database/           Connection (PDO singleton)
  Exceptions/         HttpException, ValidationException
  Http/               Request, Response, Session
  Logging/            Logger (arquivo diário em storage/logs)
  Routing/            Router, MiddlewareInterface
  Support/            Env (.env loader), Str (slugify/transliteração)
  View/               View (Twig Environment), TwigExtension (url/asset/env/excerpt)
app/                  Aplicação (namespace App\)
  Auth/               Auth (guard), Role (perfis/hierarquia)
  Controllers/        BaseController, Api/, Web/ (Home, Catalog, Auth, Admin, Category, MangaType, Author, Manga)
  Middleware/         Authenticate, EnsureRole
  Models/             User, AuthToken, Category, MangaType, Author, Manga
  Services/           AuthService, CoverStorage
  Views/              *.twig — auth/, admin/, mangas/, errors/, partials/, layout/{app,admin}/, dashboard.twig, home.twig
database/             schema.sql + migrate.php
public/index.php      Front controller
public/assets/        css/site.css (site), css/admin.css (painel)
routes/               web.php (HTML), api.php (JSON)
storage/cache/twig/   Cache compilado do Twig
storage/logs/         Logs diários app-AAAA-MM-DD.log
```

## Como rodar

```bash
composer install                                   # dependências
composer dump-autoload -o                           # após criar/mover classes
php database/migrate.php                            # cria/atualiza as tabelas
php -S localhost:8000 -t public                     # servidor de desenvolvimento
```

Configuração em `.env` (veja `.env.example`). O `.env` já está configurado localmente.

## Banco de dados

- **Driver**: MySQL via PDO. DSN: `mysql:host={DB_HOST};port={DB_PORT};dbname={DB_DATABASE};charset=utf8mb4`.
- **Charset/Collation**: `utf8mb4` / `utf8mb4_unicode_ci`.
- **Engine**: InnoDB.
- O schema canônico está em [`database/schema.sql`](database/schema.sql) e é aplicado por [`database/migrate.php`](database/migrate.php).

### Variáveis de ambiente relevantes

| Variável          | Descrição                                   | Padrão            |
| ----------------- | ------------------------------------------- | ----------------- |
| `DB_HOST`         | Host do MySQL                               | `127.0.0.1`       |
| `DB_PORT`         | Porta                                       | `3306`            |
| `DB_DATABASE`     | Nome do banco                               | `buglivre`        |
| `DB_USERNAME`     | Usuário                                     | `root`            |
| `DB_PASSWORD`     | Senha                                       | (vazio)           |
| `DB_CHARSET`      | Charset da conexão                          | `utf8mb4`         |
| `AUTH_TOKEN_TTL`  | TTL do token de API, em segundos            | `2592000` (30d)   |
| `APP_DEBUG`       | Exibe detalhes de erro em HTML/JSON         | `true`            |
| `APP_TIMEZONE`    | Timezone (afeta `NOW()`/datas de exibição)  | `America/Bahia`   |
| `APP_NAME`        | Nome exibido no site/painel (global Twig)   | `BugLivre`        |
| `APP_URL`         | Prefixo base usado pela função `url()`      | (vazio → relativo)|

### Tabela `users`

| Coluna       | Tipo                                                              | Notas                          |
| ------------ | ----------------------------------------------------------------- | ------------------------------ |
| `id`         | `BIGINT UNSIGNED AUTO_INCREMENT`                                  | PK                             |
| `name`       | `VARCHAR(120) NOT NULL`                                           | Nome de exibição               |
| `username`   | `VARCHAR(60) NOT NULL`                                            | **UNIQUE** `uq_users_username` |
| `email`      | `VARCHAR(190) NOT NULL`                                           | **UNIQUE** `uq_users_email`    |
| `password`   | `VARCHAR(255) NOT NULL`                                           | Hash `password_hash()`         |
| `role`       | `ENUM('user','vip','moderador','suporte','admin')` `DEFAULT 'user'` | Indexed `idx_users_role`       |
| `created_at` | `TIMESTAMP DEFAULT CURRENT_TIMESTAMP`                             |                                |
| `updated_at` | `TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`                           |                                |

### Tabela `auth_tokens`

| Coluna         | Tipo                        | Notas                                |
| -------------- | --------------------------- | ------------------------------------ |
| `id`           | `BIGINT UNSIGNED` PK        |                                      |
| `user_id`      | `BIGINT UNSIGNED NOT NULL`  | FK → `users.id` (`ON DELETE CASCADE`)|
| `token`        | `CHAR(64)` **UNIQUE**       | Armazena o **hash SHA-256** do token |
| `expires_at`   | `DATETIME NOT NULL`         |                                      |
| `revoked_at`   | `DATETIME NULL`             | Logout/refresh                       |
| `last_used_at` | `DATETIME NULL`             | Atualizado a cada uso                |
| `created_at`   | `TIMESTAMP`                 |                                      |

> O token em texto puro **nunca** é gravado: apenas `hash('sha256', $token)`. O valor cru
> é devolvido uma única vez ao cliente (login/registro/refresh).

> `migrate.php` executa `CREATE TABLE IF NOT EXISTS`, portanto **não** altera tabelas
> existentes. Se a estrutura mudar, ajuste `schema.sql` e recrie as tabelas afetadas.

### Tabela `categories`

Categorias de mangás, gerenciadas na área administrativa.

| Coluna        | Tipo                        | Notas                                 |
| ------------- | --------------------------- | ------------------------------------- |
| `id`          | `BIGINT UNSIGNED` PK        |                                       |
| `name`        | `VARCHAR(120) NOT NULL`     | Nome de exibição (único na aplicação) |
| `slug`        | `VARCHAR(140) NOT NULL`     | **UNIQUE** `uq_categories_slug`       |
| `description` | `TEXT NULL`                 |                                       |
| `is_active`   | `TINYINT(1) DEFAULT 1`      | `1` ativa / `0` inativa (soft state)  |
| `created_at`  | `TIMESTAMP`                 |                                       |
| `updated_at`  | `TIMESTAMP ON UPDATE`       |                                       |

- O `slug` é gerado automaticamente a partir do nome (`Category::uniqueSlug`), com
  transliteração de acentos para ASCII (ex.: `"Ação & Aventura"` → `acao-aventura`).
- A desativação (`is_active = 0`) oculta a categoria sem removê-la; a exclusão
  (`Category::delete()`) é definitiva, mas é bloqueada enquanto houver mangás vinculados.

### Tabela `manga_types`

Tipos de mangá (ex.: Mangá, Manhwa, Manhua, Webtoon, Comic, HQ, Pornhwa), gerenciados
na área administrativa (`/admin/types`). Os 7 tipos iniciais são semeados pela migração.

| Coluna        | Tipo                        | Notas                                 |
| ------------- | --------------------------- | ------------------------------------- |
| `id`          | `BIGINT UNSIGNED` PK        |                                       |
| `name`        | `VARCHAR(120) NOT NULL`     | Nome de exibição (único na aplicação) |
| `slug`        | `VARCHAR(140) NOT NULL`     | **UNIQUE** `uq_manga_types_slug`      |
| `description` | `TEXT NULL`                 |                                       |
| `is_active`   | `TINYINT(1) DEFAULT 1`      | `1` ativo / `0` inativo (soft state)  |
| `created_at`  | `TIMESTAMP`                 |                                       |
| `updated_at`  | `TIMESTAMP ON UPDATE`       |                                       |

- Espelha o modelo de `Category` (`MangaType::all/find/create/update/setActive/delete`,
  `slugify` via `Str::slugify($value, 140, 'tipo')`).
- `Manga::countByType(int)` bloqueia a exclusão de tipos em uso (FK `RESTRICT`).

### Tabela `authors`

Autores de mangá, gerenciados na área administrativa (`/admin/authors`).

| Coluna        | Tipo                        | Notas                                 |
| ------------- | --------------------------- | ------------------------------------- |
| `id`          | `BIGINT UNSIGNED` PK        |                                       |
| `name`        | `VARCHAR(150) NOT NULL`     | Nome (único na aplicação)             |
| `slug`        | `VARCHAR(170) NOT NULL`     | **UNIQUE** `uq_authors_slug`          |
| `bio`         | `TEXT NULL`                 | Biografia                             |
| `is_active`   | `TINYINT(1) DEFAULT 1`      | `1` ativo / `0` inativo (soft state)  |
| `created_at`  | `TIMESTAMP`                 |                                       |
| `updated_at`  | `TIMESTAMP ON UPDATE`       |                                       |

- Mesma estrutura de `MangaType`, com `bio` no lugar de `description`
  (`slugify` via `Str::slugify($value, 170, 'autor')`).
- `Manga::countByAuthor(int)` bloqueia a exclusão de autores em uso (FK `RESTRICT`).

### Tabela `mangas`

Mangás gerenciados na área administrativa. Cada mangá tem **um tipo** (`type_id`,
obrigatório) e **no máximo um autor** (`author_id`, opcional), além de poder pertencer
a **várias categorias** (relação N:N via `manga_categories`).

| Coluna        | Tipo                                            | Notas                                    |
| ------------- | ----------------------------------------------- | ---------------------------------------- |
| `id`          | `BIGINT UNSIGNED` PK                            |                                          |
| `type_id`     | `BIGINT UNSIGNED NOT NULL`                      | FK → `manga_types.id` (`ON DELETE RESTRICT`) |
| `author_id`   | `BIGINT UNSIGNED NULL`                          | FK → `authors.id` (`ON DELETE RESTRICT`) |
| `title`       | `VARCHAR(200) NOT NULL`                         | Título (único na aplicação)              |
| `slug`        | `VARCHAR(220) NOT NULL`                         | **UNIQUE** `uq_mangas_slug`              |
| `description` | `TEXT NULL`                                     | Sinopse                                  |
| `cover`       | `VARCHAR(255) NULL`                             | Caminho/URL da capa (ex.: `/uploads/covers/...`) |
| `status`      | `ENUM('ongoing','completed','hiatus','cancelled')` `DEFAULT 'ongoing'` | Situação de publicação |
| `is_active`   | `TINYINT(1) DEFAULT 1`                          | `1` ativo / `0` inativo (soft state)     |
| `created_at`  | `TIMESTAMP`                                     |                                          |
| `updated_at`  | `TIMESTAMP ON UPDATE`                           |                                          |

- O `slug` é gerado a partir do título (`Manga::uniqueSlug`), reutilizando a
  transliteração de `Core\Support\Str::slugify()`.
- `Manga::statuses()` retorna os rótulos legíveis dos status (`Em publicação`,
  `Completo`, `Em hiato`, `Cancelado`).
- `Manga::all($search, $categoryId, $typeId, $onlyActive)` faz `LEFT JOIN` em
  `manga_types`/`authors`, expondo `type_name` e `author_name`.
- A desativação (`is_active = 0`) oculta o mangá sem removê-lo; a exclusão
  (`Manga::delete()`) é definitiva. Tipos/autores/categorias com mangás vinculados não
  podem ser excluídos.

### Tabela `manga_categories` (pivô N:N)

Vincula mangás a categorias: cada linha liga um `manga_id` a um `category_id`.

| Coluna        | Tipo                        | Notas                                          |
| ------------- | --------------------------- | ---------------------------------------------- |
| `manga_id`    | `BIGINT UNSIGNED`           | FK → `mangas.id` (`ON DELETE CASCADE`); PK     |
| `category_id` | `BIGINT UNSIGNED`           | FK → `categories.id` (`ON DELETE RESTRICT`); PK|
| `created_at`  | `TIMESTAMP`                 |                                                |

- Chave primária composta `(manga_id, category_id)`; índice em `category_id`.
- `Manga::create(array $data)` / `Manga::update(int $id, array $data)` recebem
  `category_ids` (array) e sincronizam os vínculos via `syncCategories()`
  (transação: DELETE + INSERT).
- `Manga::all()` / `Manga::find()` carregam as categorias em lote (`loadCategories`,
  sem N+1) e as expõem em `$manga->categories` (`[['id' => int, 'name' => string], ...]`),
  além dos helpers `categoryNames()` e `categoryLabel()`.
- `Manga::countByCategory(int)` conta vínculos na tabela pivô (usado para bloquear a
  exclusão de categorias em uso).

## Upload de capas (servidor local)

- Classe `App\Services\CoverStorage`.
  - `upload(array $file, string $folder = 'covers'): string` valida o arquivo (MIME real via
    `finfo`, JPG/PNG/WEBP/GIF, ≤ 5 MB), grava com `move_uploaded_file` em
    `public/uploads/covers/AAAA/MM/<hex>.<ext>` (criando as pastas) e devolve o caminho
    relativo à raiz, ex.: `/uploads/covers/2026/11/<hex>.png`.
  - Lança `ValidationException` (chave `cover_file`) se o arquivo for inválido ou não puder
    ser gravado.
- No admin (`/admin/mangas`), o formulário tem `enctype="multipart/form-data"` com o campo
  `cover_file`. Se houver arquivo, ele é salvo no servidor e o caminho resultante vai para
  `cover`; caso contrário, usa-se o **caminho/URL manual** informado em `cover` (fallback).
  O controlador resolve isso em `MangaController::resolveCover()`.
- `Manga::validate()` aceita como `cover` tanto uma **URL absoluta** quanto um **caminho
  relativo** iniciado por `/` (ex.: `/uploads/covers/...`).
- A API (`POST/PUT/PATCH /api/mangas`) recebe apenas a URL/caminho no campo `cover` (JSON).


## Templates (Twig)

A área web é renderizada com **Twig 3**, encapsulado em `Core\View\View`:

- `View::render(string $template, array $data = [], ?string $layout = null): string`.
  - `$template` usa a notação `pasta/arquivo` (ex.: `admin/mangas/index`) e resolve para
    `app/Views/{template}.twig` (pontos também são convertidos em `/`).
  - `$layout` renderiza o conteúdo dentro de `app/Views/layout/{layout}/main.twig`
    (layouts `app` e `admin`), expondo a variável `content`.
- Os controllers continuam chamando apenas `BaseController::view($template, $data, $layout)`,
  sem depender do motor — a troca PHP→Twig ficou encapsulada em `Core\View\View`.
- Cache compilado em `storage/cache/twig` (desativado automaticamente se a pasta não for
  gravável). `APP_DEBUG` liga o modo debug do Twig.

### Globais disponíveis nos templates

Adicionadas no bootstrap (`Core\Application`):

| Global           | Conteúdo                                                        |
| ---------------- | --------------------------------------------------------------- |
| `app_name`       | `APP_NAME` (padrão `BugLivre`)                                  |
| `year`           | Ano atual                                                       |
| `manga_statuses` | `Manga::statuses()` — mapa `status => rótulo`                   |
| `role_labels`    | `Role::options()` — mapa `role => rótulo`                       |
| `current_path`   | Caminho da requisição (destaca o item ativo do menu)            |
| `auth`           | `{ check, name, role, can_manage }` (sessão web)                |

### Funções e filtros (`Core\View\TwigExtension`)

- `url('/mangas')` — monta a URL com o prefixo de `APP_URL`.
- `asset('css/site.css')` — resolve `/assets/...` e anexa `?v=<mtime>` (cache busting).
- `env('APP_NAME', 'padrão')` — lê variáveis de ambiente.
- filtro `excerpt(120)` — trunca textos longos com reticências.

### Estrutura das views

```
app/Views/
  layout/app/main.twig        # site público (topbar, busca, footer)
  layout/admin/main.twig      # painel (sidebar)
  home.twig                   # hero + categorias + destaques
  mangas/index.twig           # catálogo (busca/filtros)
  mangas/show.twig            # detalhe do mangá
  partials/manga-card.twig    # card reutilizável (include)
  auth/{login,register}.twig
  dashboard.twig
  admin/dashboard.twig
  admin/{categories,types,authors,mangas}/{index,form}.twig
  errors/error.twig
```


## Autenticação

- **Web**: sessão PHP (`$_SESSION['user_id']`, `user_name`, `user_role`), com
  `session_regenerate_id(true)` no login. Guard: `App\Auth\Auth`.
- **API**: token opaco Bearer em `Authorization: Bearer <token>`
  (`Request::bearerToken()`), validado por `AuthService::userFromToken()`.
- **Login alternativo**: `AuthService::attempt($login, $senha)` aceita **e-mail OU
  nome de usuário** (`User::findByLogin`). Se o valor contiver `@`, é tratado como
  e-mail (normalizado em minúsculas); caso contrário, como `username`.
- Senhas: `password_hash()` / `password_verify()`.

## Perfis (roles) e hierarquia

Definidos em `App\Auth\Role`. Um perfil de nível maior satisfaz exigências de níveis menores.

| Perfil      | Nível | Rótulo        |
| ----------- | :---: | ------------- |
| `user`      | 1     | Usuário       |
| `vip`       | 2     | VIP           |
| `moderador` | 3     | Moderador     |
| `suporte`   | 4     | Suporte       |
| `admin`     | 5     | Administrador |

- `User::hasRole(string|array $roles)` — verdadeiro se o nível do usuário ≥ o menor nível exigido.
- `Role::atLeast($role, $minimo)`, `Role::level()`, `Role::label()`, `Role::options()`.

## Rotas

### Web (`routes/web.php`)

| Método | Caminho     | Ação                        | Middleware                  |
| ------ | ----------- | --------------------------- | --------------------------- |
| GET    | `/`         | `HomeController@index`      | —                           |
| GET    | `/login`    | `AuthController@showLogin`  | —                           |
| POST   | `/login`    | `AuthController@login`      | —                           |
| GET    | `/register` | `AuthController@showRegister` | —                         |
| POST   | `/register` | `AuthController@register`   | —                           |
| POST   | `/logout`   | `AuthController@logout`     | —                           |
| GET    | `/dashboard`| `AuthController@dashboard`  | `auth`                      |
| GET    | `/mangas`                | `CatalogController@index`   | —                           |
| GET    | `/mangas/{slug}`         | `CatalogController@show`    | —                           |
| GET    | `/admin`    | `AdminController@index`     | `auth`, `role:moderador`    |
| GET    | `/admin/categories`             | `CategoryController@index`   | `auth`, `role:moderador`    |
| POST   | `/admin/categories`             | `CategoryController@store`   | `auth`, `role:moderador`    |
| GET    | `/admin/categories/{id}/edit`   | `CategoryController@edit`    | `auth`, `role:moderador`    |
| POST   | `/admin/categories/{id}`        | `CategoryController@update`  | `auth`, `role:moderador`    |
| POST   | `/admin/categories/{id}/status` | `CategoryController@toggle`  | `auth`, `role:moderador`    |
| POST   | `/admin/categories/{id}/delete` | `CategoryController@destroy` | `auth`, `role:moderador`    |
| GET    | `/admin/types`                  | `MangaTypeController@index`  | `auth`, `role:moderador`    |
| POST   | `/admin/types`                  | `MangaTypeController@store`  | `auth`, `role:moderador`    |
| GET    | `/admin/types/{id}/edit`        | `MangaTypeController@edit`   | `auth`, `role:moderador`    |
| POST   | `/admin/types/{id}`             | `MangaTypeController@update` | `auth`, `role:moderador`    |
| POST   | `/admin/types/{id}/status`      | `MangaTypeController@toggle` | `auth`, `role:moderador`    |
| POST   | `/admin/types/{id}/delete`      | `MangaTypeController@destroy`| `auth`, `role:moderador`    |
| GET    | `/admin/authors`                | `AuthorController@index`     | `auth`, `role:moderador`    |
| POST   | `/admin/authors`                | `AuthorController@store`     | `auth`, `role:moderador`    |
| GET    | `/admin/authors/{id}/edit`      | `AuthorController@edit`      | `auth`, `role:moderador`    |
| POST   | `/admin/authors/{id}`           | `AuthorController@update`    | `auth`, `role:moderador`    |
| POST   | `/admin/authors/{id}/status`    | `AuthorController@toggle`    | `auth`, `role:moderador`    |
| POST   | `/admin/authors/{id}/delete`    | `AuthorController@destroy`   | `auth`, `role:moderador`    |
| GET    | `/admin/mangas`                 | `MangaController@index`      | `auth`, `role:moderador`    |
| GET    | `/admin/mangas/create`          | `MangaController@create`     | `auth`, `role:moderador`    |
| POST   | `/admin/mangas`                 | `MangaController@store`      | `auth`, `role:moderador`    |
| GET    | `/admin/mangas/{id}/edit`       | `MangaController@edit`       | `auth`, `role:moderador`    |
| POST   | `/admin/mangas/{id}`            | `MangaController@update`     | `auth`, `role:moderador`    |
| POST   | `/admin/mangas/{id}/status`     | `MangaController@toggle`     | `auth`, `role:moderador`    |
| POST   | `/admin/mangas/{id}/delete`     | `MangaController@destroy`    | `auth`, `role:moderador`    |

### API (`routes/api.php`, prefixo `/api`)

Leitura do catálogo é pública; escrita exige `auth` + `role:moderador`.

| Método | Caminho                      | Ação                              | Middleware               |
| ------ | ---------------------------- | --------------------------------- | ------------------------ |
| POST   | `/api/auth/register`         | `Api\AuthController@register`     | —                        |
| POST   | `/api/auth/login`            | `Api\AuthController@login`        | —                        |
| POST   | `/api/auth/logout`           | `Api\AuthController@logout`       | —                        |
| POST   | `/api/auth/refresh`          | `Api\AuthController@refresh`      | —                        |
| GET    | `/api/auth/me`               | `Api\AuthController@me`           | —                        |
| GET    | `/api/categories`            | `Api\CategoryController@index`    | —                        |
| GET    | `/api/categories/{id}`       | `Api\CategoryController@show`     | —                        |
| POST   | `/api/categories`            | `Api\CategoryController@store`    | `auth`, `role:moderador` |
| PUT    | `/api/categories/{id}`       | `Api\CategoryController@update`   | `auth`, `role:moderador` |
| PATCH  | `/api/categories/{id}`       | `Api\CategoryController@update`   | `auth`, `role:moderador` |
| POST   | `/api/categories/{id}/status`| `Api\CategoryController@toggle`   | `auth`, `role:moderador` |
| DELETE | `/api/categories/{id}`       | `Api\CategoryController@destroy`  | `auth`, `role:moderador` |
| GET    | `/api/types`                 | `Api\MangaTypeController@index`   | —                        |
| GET    | `/api/types/{id}`            | `Api\MangaTypeController@show`    | —                        |
| POST   | `/api/types`                 | `Api\MangaTypeController@store`   | `auth`, `role:moderador` |
| PUT    | `/api/types/{id}`            | `Api\MangaTypeController@update`  | `auth`, `role:moderador` |
| PATCH  | `/api/types/{id}`            | `Api\MangaTypeController@update`  | `auth`, `role:moderador` |
| POST   | `/api/types/{id}/status`     | `Api\MangaTypeController@toggle`  | `auth`, `role:moderador` |
| DELETE | `/api/types/{id}`            | `Api\MangaTypeController@destroy` | `auth`, `role:moderador` |
| GET    | `/api/authors`               | `Api\AuthorController@index`      | —                        |
| GET    | `/api/authors/{id}`          | `Api\AuthorController@show`       | —                        |
| POST   | `/api/authors`               | `Api\AuthorController@store`      | `auth`, `role:moderador` |
| PUT    | `/api/authors/{id}`          | `Api\AuthorController@update`     | `auth`, `role:moderador` |
| PATCH  | `/api/authors/{id}`          | `Api\AuthorController@update`     | `auth`, `role:moderador` |
| POST   | `/api/authors/{id}/status`   | `Api\AuthorController@toggle`     | `auth`, `role:moderador` |
| DELETE | `/api/authors/{id}`          | `Api\AuthorController@destroy`    | `auth`, `role:moderador` |
| GET    | `/api/mangas`                | `Api\MangaController@index`       | —                        |
| GET    | `/api/mangas/{id}`           | `Api\MangaController@show`        | —                        |
| POST   | `/api/mangas`                | `Api\MangaController@store`       | `auth`, `role:moderador` |
| PUT    | `/api/mangas/{id}`           | `Api\MangaController@update`      | `auth`, `role:moderador` |
| PATCH  | `/api/mangas/{id}`           | `Api\MangaController@update`      | `auth`, `role:moderador` |
| POST   | `/api/mangas/{id}/status`    | `Api\MangaController@toggle`      | `auth`, `role:moderador` |
| DELETE | `/api/mangas/{id}`           | `Api\MangaController@destroy`     | `auth`, `role:moderador` |

- `GET /api/mangas` aceita os filtros `?q=` (título/autor), `?category=<id>`,
  `?type=<id>` e `?only_active=1`; `GET /api/categories`, `GET /api/types` e
  `GET /api/authors` aceitam `?only_active=1`.
- Em mangás, `type_id` (obrigatório) e `author_id` (opcional) são escalares;
  `category_ids` é um **array** (ex.: `"category_ids": [1, 2]`). A resposta inclui
  `type_name`, `author_name`, `categories` (lista de `{id, name}`), `category_names` e `status_label`.
- Erros de validação retornam **422** com o campo `errors`; exclusão de categoria, tipo
  ou autor em uso retorna **409**.


Exemplo de login aceitando e-mail ou usuário:

```json
POST /api/auth/login
{ "login": "admin", "password": "senha-forte" }
```

## Middleware

- Contrato: `Core\Routing\MiddlewareInterface::handle(Request $request, callable $next): mixed`.
- Rotas e grupos aceitam middleware: `$router->get($path, $cb, ['auth'])` ou
  `$router->group('/admin', $cb, ['auth', 'role:moderador'])`.
- Apelidos disponíveis (em `Router::MIDDLEWARE_ALIASES`):
  - `auth` → `App\Middleware\Authenticate`
  - `role:perfil1,perfil2` → `App\Middleware\EnsureRole` (recebe os perfis como argumentos)

Sem autenticação, o middleware responde **redirect `/login`** (web) ou **HTTP 401 JSON** (API);
sem perfil suficiente, **HTTP 403** (HTML/JSON conforme o contexto).

## Convenções

- Caminhos de rota são normalizados por `Router::normalize()` (barras duplicadas, prefixo de grupo, barra final).
- Parâmetros tipados: `{id:int}`, `{peso:float}`, `{ativo:bool}`, `{slug:str}` (padrão) e `{caminho:mixed}`.
- Controllers estendem `App\Controllers\BaseController` (helpers `ok()`, `created()`, `error()`, `view()`, `redirect()`, `logger()`).
- Views: templates **Twig** em `App\Views\{template}.twig`; layouts em
  `App\Views\layout\{app|admin}\main.twig` (selecionados pelo 3º parâmetro de
  `BaseController::view()`). Ver a seção **Templates (Twig)**.
- Erros globais são capturados em `Core\Application` e formatados conforme o contexto (JSON/HTML).
- Logs diários em `storage/logs/app-AAAA-MM-DD.log` via `Core\Logging\Logger`.
