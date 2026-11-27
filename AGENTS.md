# AGENTS.md — BugLivre Oficial

Informações para agentes de IA e desenvolvedores que trabalharem neste repositório.

## Visão geral

Micro-framework PHP próprio, no padrão MVC, com duas áreas separadas no mesmo núcleo:

- **Web** (`routes/web.php`): **shells HTML** (templates **Twig** + sessão). As páginas
  não renderizam dados no servidor — o **JavaScript** busca os dados em `/api` e monta
  listas, detalhes e formulários no navegador.
- **API** (`routes/api.php`, sob o prefixo `/api`): respostas em **JSON** (fonte única da
  verdade dos dados). Aceita **token Bearer** (clientes externos) ou a **sessão web**
  compartilhada via cookie (usada pelo próprio front-end).

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
  para o painel) e **JavaScript sem framework** em `public/assets/js` (`api.js` — cliente
  HTTP e helpers de UI; `site.js` — site público; `admin.js` — painel), servidos
  diretamente pelo servidor web (front controller não atende arquivos existentes).
- **Armazenamento de capas no próprio servidor**: uploads gravados em
  `public/uploads/covers/AAAA/MM/`, encapsulados em `App\Services\CoverStorage`.
- **Redis opcional** via **Predis** (`predis/predis`): conexão encapsulada em
  `Core\Redis\RedisClient` (lazy singleton), usada pelo limitador de taxa, com
  fallback automático para arquivos quando desabilitado/indisponível.
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
  RateLimit/          RateLimiter (limite de taxa: Redis ou arquivo)
  Redis/              RedisClient (conexão Predis opcional, lazy singleton)
  Routing/            Router, MiddlewareInterface
  Support/            Env (.env loader), Str (slugify/transliteração)
  View/               View (Twig Environment), TwigExtension (url/asset/env/excerpt)
app/                  Aplicação (namespace App\)
  Auth/               Auth (guard), Role (perfis/hierarquia)
  Controllers/        BaseController, Api/, Web/ (Home, Catalog, Auth, Admin, Category, MangaType, Author, Manga)
  Middleware/         Authenticate, EnsureRole, ThrottleRequests
  Models/             User, AuthToken, Category, MangaType, Author, Manga
  Services/           AuthService, CoverStorage
  Views/              *.twig — auth/, admin/, mangas/, errors/, partials/, layout/{app,admin}/, dashboard.twig, home.twig (shells)
database/             schema.sql + migrate.php
docs/api.md           Referência textual da API (rotas, corpos, códigos)
public/index.php      Front controller
public/assets/css/    site.css (site), admin.css (painel)
public/assets/js/     api.js (cliente HTTP), site.js (site público), admin.js (painel)
public/docs/          index.html (Swagger UI) + openapi.yaml (spec), servidos em /docs/
public/uploads/covers/ Capas enviadas (AAAA/MM/), fora do controle de versão
routes/               web.php (HTML), api.php (JSON)
storage/cache/twig/   Cache compilado do Twig
storage/logs/         Logs diários app-AAAA-MM-DD.log
storage/rate_limit/   Contadores do limite de taxa (um JSON por chave)
```

## Como rodar

```bash
composer install                                   # dependências
composer dump-autoload -o                           # após criar/mover classes
php database/migrate.php                            # cria/atualiza as tabelas
php -S localhost:8000 -t public                     # servidor de desenvolvimento
```

Configuração em `.env` (veja `.env.example`). O `.env` já está configurado localmente.

## Documentação

- [`docs/api.md`](docs/api.md) — referência textual da API (rotas, corpos, códigos de status, rate limit).
- `public/docs/` — documentação interativa (**Swagger UI**, `index.html`) consumindo a spec
  `public/docs/openapi.yaml`. São arquivos estáticos servidos diretamente pelo servidor web
  em `/docs/` (ex.: `http://localhost:8000/docs/`), sem passar pelo front controller.

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
| `APP_MAINTENANCE` | Modo manutenção: bloqueia o público (503)   | `false`           |
| `APP_MAINTENANCE_MESSAGE` | Texto exibido na tela de manutenção | (mensagem padrão) |
| `REDIS_ENABLED`   | Habilita o Redis (limitador de taxa)        | `false`           |
| `REDIS_SCHEME`    | `tcp` / `tls` / `unix`                      | `tcp`             |
| `REDIS_HOST`      | Host do Redis                               | `127.0.0.1`       |
| `REDIS_PORT`      | Porta                                       | `6379`            |
| `REDIS_USERNAME`  | Usuário (ACL; ex.: `default`)               | (vazio)           |
| `REDIS_PASSWORD`  | Senha                                       | (vazio)           |
| `REDIS_DB`        | Índice do banco                             | (vazio)           |
| `REDIS_PREFIX`    | Prefixo das chaves                          | `buglivre:`       |
| `REDIS_TIMEOUT`   | Timeout de conexão/leitura (s)              | `2.5`             |

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

### Estrutura das views (shells)

Os templates são **estruturas base** (shells) sem dados renderizados no servidor:
o JavaScript (`site.js`/`admin.js`) busca em `/api` e preenche listas, detalhes e
formulários no navegador. Cada controller injeta a variável `page` (e `mode`/`id`/`slug`
quando aplicável) que o layout converte em `window.BUGLIVRE`.

```
app/Views/
  layout/app/main.twig        # site público (topbar, busca, footer) + window.BUGLIVRE + scripts
  layout/admin/main.twig      # painel (sidebar) + window.BUGLIVRE + scripts
  home.twig                   # hero + #home-categories-section + #home-featured
  mangas/index.twig           # catálogo: #catalog-count, #catalog-filters, #catalog-results
  mangas/show.twig            # detalhe: #manga-detail (placeholder)
  partials/manga-card.twig    # card reutilizável (render no servidor; o JS espelha em Ui.mangaCard)
  auth/{login,register}.twig  # formulários que consomem /api/auth via JS
  dashboard.twig              # #dashboard-body (preenchido via JS)
  admin/dashboard.twig        # boas-vindas + #users-table-body
  admin/{categories,types,authors,mangas}/{index,form}.twig
  errors/error.twig
```


## Front-end (JavaScript)

A área web **não renderiza dados no servidor**: os três scripts em `public/assets/js`
(nenhum framework) consomem a API e montam o DOM no navegador.

- **`api.js`** — expõe dois globais:
  - `window.Api` — cliente HTTP (`get/post/put/delete/form`), sempre com
    `credentials: 'same-origin'` (autentica pela sessão). Em falha, lança um `Error` com
    `status`, `errors` (mapa 422) e `payload`.
  - `window.Ui` — helpers de UI: `qs/qsa`, `escape`, `excerpt`, `cover`,
    `mangaCard`/`mangaGrid` (espelham `partials/manga-card.twig`), `alert`/`clearAlert`,
    `statusLabel`/`roleLabel`/`roleLevel`/`canManage` e os utilitários de formulário abaixo.
- **`site.js`** — roteia pela variável `window.BUGLIVRE.page`
  (`home`, `catalog`, `manga-show`, `login`, `register`, `dashboard`); monta home, catálogo
  (filtros + querystring sincronizada em `?q=&category=&type=`), detalhe do mangá (via `slug`)
  e os formulários de autenticação.
- **`admin.js`** — CRUDs do painel (categorias/tipos/autores via mapa `SIMPLE`; mangás com
  upload multipart) e a tabela de usuários do dashboard.

### Validação e estado de carregamento (helpers `Ui`)

- `Ui.validate(form, rules)` / `Ui.watchValidation(form, rules)`: validação **client-side**
  com `rules = { campo: [fn, ...] }`, cada função recebendo `(valor, form)` e devolvendo a
  mensagem de erro (ou `''`). `validate` roda no `submit` e foca o primeiro campo inválido;
  `watchValidation` revalida no `blur` e limpa o erro assim que o usuário digita.
- `Ui.fieldError(input, msg)` / `Ui.clearFieldError` / `Ui.showFieldErrors(form, errors)`:
  marcam o campo com `aria-invalid="true"` e inserem um `div.field-error` logo após o
  `label`. Erros **422** da API são exibidos via `showFieldErrors`.
- `Ui.setLoading(form, loading)`: alterna `aria-busy`/`data-loading` no form, desabilita o
  botão de envio e, se ele tiver `data-loading-text`, troca o rótulo por um spinner
  (`.spinner`).
- **Convenções dos formulários:** `novalidate` (a validação é do JS), `<div class="alert" hidden>`
  para erros gerais e `data-loading-text` no botão de envio (ex.: `"Entrando…"`).


## Autenticação

- **Web**: sessão PHP (`$_SESSION['user_id']`, `user_name`, `user_role`), com
  `session_regenerate_id(true)` no login. Guard: `App\Auth\Auth`.
- **API**: aceita **duas identidades**:
  - **Token opaco Bearer** em `Authorization: Bearer <token>`
    (`Request::bearerToken()`), validado por `AuthService::userFromToken()` — para
    clientes externos (stateless).
  - **Sessão web compartilhada** (cookie): o `Api\AuthController` é *session-aware* e os
    middlewares aceitam a sessão ativa. É assim que o **próprio front-end** (fetch com
    `credentials: 'same-origin'`) autentica nas rotas protegidas, sem gerenciar tokens.
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

A área web serve apenas **páginas (GET)**; toda mutação é feita via API (JavaScript).
A variável `page` (e `mode`/`id`/`slug`) alimenta o roteamento do JS.

| Método | Caminho     | Ação                        | Middleware                  |
| ------ | ----------- | --------------------------- | --------------------------- |
| GET    | `/`         | `HomeController@index`      | —                           |
| GET    | `/login`    | `AuthController@showLogin`  | —                           |
| GET    | `/register` | `AuthController@showRegister` | —                         |
| GET    | `/dashboard`| `AuthController@dashboard`  | `auth`                      |
| GET    | `/mangas`                | `CatalogController@index`   | —                           |
| GET    | `/mangas/{slug}`         | `CatalogController@show`    | —                           |
| GET    | `/admin`    | `AdminController@index`     | `auth`, `role:moderador`    |
| GET    | `/admin/categories`             | `CategoryController@index`   | `auth`, `role:moderador`    |
| GET    | `/admin/categories/{id}/edit`   | `CategoryController@edit`    | `auth`, `role:moderador`    |
| GET    | `/admin/types`                  | `MangaTypeController@index`  | `auth`, `role:moderador`    |
| GET    | `/admin/types/{id}/edit`        | `MangaTypeController@edit`   | `auth`, `role:moderador`    |
| GET    | `/admin/authors`                | `AuthorController@index`     | `auth`, `role:moderador`    |
| GET    | `/admin/authors/{id}/edit`      | `AuthorController@edit`      | `auth`, `role:moderador`    |
| GET    | `/admin/mangas`                 | `MangaController@index`      | `auth`, `role:moderador`    |
| GET    | `/admin/mangas/create`          | `MangaController@create`     | `auth`, `role:moderador`    |
| GET    | `/admin/mangas/{id}/edit`       | `MangaController@edit`       | `auth`, `role:moderador`    |

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
| GET    | `/api/mangas/slug/{slug}`    | `Api\MangaController@showBySlug`  | —                        |
| POST   | `/api/mangas`                | `Api\MangaController@store`       | `auth`, `role:moderador` |
| POST   | `/api/mangas/{id}`           | `Api\MangaController@update`      | `auth`, `role:moderador` |
| PUT    | `/api/mangas/{id}`           | `Api\MangaController@update`      | `auth`, `role:moderador` |
| PATCH  | `/api/mangas/{id}`           | `Api\MangaController@update`      | `auth`, `role:moderador` |
| POST   | `/api/mangas/{id}/status`    | `Api\MangaController@toggle`      | `auth`, `role:moderador` |
| DELETE | `/api/mangas/{id}`           | `Api\MangaController@destroy`     | `auth`, `role:moderador` |
| GET    | `/api/users`                 | `Api\UserController@index`        | `auth`, `role:moderador` |

- `GET /api/mangas` aceita os filtros `?q=` (título/autor), `?category=<id>`,
  `?type=<id>` e `?only_active=1`; `GET /api/categories`, `GET /api/types` e
  `GET /api/authors` aceitam `?only_active=1`.
- Em mangás, `type_id` (obrigatório) e `author_id` (opcional) são escalares;
  `category_ids` é um **array** (ex.: `"category_ids": [1, 2]`). A resposta inclui
  `type_name`, `author_name`, `categories` (lista de `{id, name}`), `category_names` e `status_label`.
- `POST /api/mangas/{id}` aceita **multipart** (`cover_file`) — usado pelo painel para
  upload de capa; `PUT`/`PATCH` recebem JSON.
- `GET /api/users` alimenta a tabela de usuários do dashboard administrativo.
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
  - `throttle:maxAttempts,decayMinutes` → `App\Middleware\ThrottleRequests` (padrão `60,1`)

Sem autenticação, o middleware responde **redirect `/login`** (web) ou **HTTP 401 JSON** (API);
sem perfil suficiente, **HTTP 403** (HTML/JSON conforme o contexto).

### Rate limit (limite de taxa)

`App\Middleware\ThrottleRequests` limita requisições por **identificador** (usuário
autenticado ou IP) **e rota**, usando o serviço `Core\RateLimit\RateLimiter`
(janela fixa). O armazenamento é escolhido em tempo de execução:

- **Redis** (quando `REDIS_ENABLED=true` e acessível): contador atômico por chave
  (`INCR` + `EXPIRE` num script Lua), com prefixo `REDIS_PREFIX` + `rate_limit:<hash>`.
- **Arquivo** (fallback): `storage/rate_limit/<hash>.json`, protegido por `flock`.
  É usado quando o Redis está desabilitado, indisponível ou falha durante a requisição.

A conexão Redis fica em `Core\Redis\RedisClient` (lazy singleton via Predis): se o
servidor não responder ao `PING`, devolve `null` e o limitador cai para arquivo — o
evento é registrado no log. Assim o projeto continua portável, sem exigir Redis.

- Formato do apelido: `throttle:maxAttempts,decayMinutes` (ex.: `throttle:10,1`).
- Ao exceder: **HTTP 429** com cabeçalhos `Retry-After`, `X-RateLimit-Limit` e
  `X-RateLimit-Remaining` (JSON na API, HTML na web). O evento é registrado no log.
- Aplicação atual: o grupo `/api` inteiro usa `throttle:120,1` (em `Core\Application`),
  e as rotas sensíveis de autenticação (`/api/auth/login`, `register`, `refresh`)
  usam `throttle:10,1` (em `routes/api.php`).
- Como a chave inclui a rota, cada endpoint tem seu próprio contador; limitadores
  diferentes (ex.: global da API e do login) não compartilham contagem.

## Convenções

- Caminhos de rota são normalizados por `Router::normalize()` (barras duplicadas, prefixo de grupo, barra final).
- Parâmetros tipados: `{id:int}`, `{peso:float}`, `{ativo:bool}`, `{slug:str}` (padrão) e `{caminho:mixed}`.
- Controllers estendem `App\Controllers\BaseController` (helpers `ok()`, `created()`, `error()`, `view()`, `redirect()`, `logger()`).
- Views: templates **Twig** em `App\Views\{template}.twig`; layouts em
  `App\Views\layout\{app|admin}\main.twig` (selecionados pelo 3º parâmetro de
  `BaseController::view()`). Ver a seção **Templates (Twig)**.
- Erros globais são capturados em `Core\Application` e formatados conforme o contexto (JSON/HTML).
- Logs diários em `storage/logs/app-AAAA-MM-DD.log` via `Core\Logging\Logger`.

## graphify

This project has a knowledge graph at graphify-out/ with god nodes, community structure, and cross-file relationships.

When the user types `/graphify`, use the installed graphify skill or instructions before doing anything else.

Rules:
- When graphify-out/graph.json exists, run `graphify query "<question>"` before your first grep, search or source-file read for a codebase question, and put this rule in every subagent prompt that explores code. Read raw files only for lines the graph or an earlier read already located. Use `graphify path "<A>" "<B>"` for relationships and `graphify explain "<concept>"` for focused concepts. When the answer is under a Markdown heading, `graphify section "<heading>"` prints that section's text, so the .md need not be opened. These return a scoped subgraph, usually much smaller than GRAPH_REPORT.md or raw grep output.
- Dirty graphify-out/ files are expected after hooks or incremental updates; dirty graph files are not a reason to skip graphify. Only skip graphify if the task is about stale or incorrect graph output, or the user explicitly says not to use it.
- If graphify-out/wiki/index.md exists, use it for broad navigation instead of raw source browsing.
- Read graphify-out/GRAPH_REPORT.md only for broad architecture review or when query/path/explain do not surface enough context.
- After modifying code, run `graphify update .` to keep the graph current (AST-only, no API cost).
- A committed graphify-out/graph.json is rewritten whole on every build, so a large diff to it in a pull request is expected. Do not flag it as churn or suggest skipping the graph rebuild or its hooks.
