# Graph Report - buglivreoficial  (2026-11-26)

## Corpus Check
- cluster-only mode — file stats not available

## Summary
- 817 nodes · 2196 edges · 60 communities (12 shown, 48 thin omitted)
- Extraction: 97% EXTRACTED · 3% INFERRED · 0% AMBIGUOUS · INFERRED: 57 edges (avg confidence: 0.85)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `3bd405c9`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- Response
- Logger
- User
- .pdo
- MangaType
- Category
- .ok
- admin.js
- Twig\Source
- Request
- ValidationException
- .error
- Author
- Connection
- Twig\Environment
- Router
- Session
- .json
- site.js
- composer.json
- .run
- Twig\Sandbox\SecurityError
- Twig\TemplateWrapper
- Twig\Markup
- Twig\Error\LoaderError
- Twig\Template
- Twig\Sandbox\SecurityNotAllowedTestError
- Twig\Sandbox\SecurityNotAllowedFilterError
- Twig\Error\RuntimeError
- Twig\Sandbox\SecurityNotAllowedTagError
- 4c6f3a466b7f1cb67d98be6f15979da0.php
- 4ea119146ff3dfcb3add511e58202672.php
- 57fc49334e4107078123ad8a8bd76286.php
- 69f1a8a5e352877580fbbcb3fe1961ad.php
- 7c273e9ddb4bd960dff00f9c7c1508ed.php
- 912f5bf8b2b1a2a3ffdd3e82e0f2e362.php
- 936723306ab541d36a2aa656a0c40236.php
- 994a1755999beeb35d69d57378ce21ca.php
- a53d23ac0c30e41c07c6c8691668f626.php
- a5b41f4c3cca345ef038bb0a10fd213a.php
- a90cae6d55486b2571557c892894bcf7.php
- afefaa555902aa78cbbfe91c0be28ba4.php
- b2348a5257c239113b294f4376b472b8.php
- c49653f379dcd0619bd4ca52cd02bda0.php
- d950f16729cbceec8e57d673b988d2f9.php
- e231a5986d8d3663e25624b09726889d.php
- e7f4fd023b22732b4e0f7b96f690bdec.php
- f5858ef98f41993d97060755fa345ef8.php
- fa9561717f6d4b360b0104aaa12792a3.php
- faa875f68b0a8cd3e3bc9a76aae0646d.php
- MiddlewareInterface
- Twig\Extension\CoreExtension
- Twig\MacroNamespace
- Twig\Extension\SandboxExtension
- Twig\Sandbox\SecurityNotAllowedFunctionError
- .handle
- Router.php

## God Nodes (most connected - your core abstractions)
1. `Response` - 85 edges
2. `BaseController` - 40 edges
3. `Request` - 37 edges
4. `Manga` - 32 edges
5. `ValidationException` - 22 edges
6. `Router` - 19 edges
7. `User` - 18 edges
8. `Author` - 17 edges
9. `MangaType` - 17 edges
10. `Category` - 17 edges

## Surprising Connections (you probably didn't know these)
- `BaseController` --references--> `Request`  [EXTRACTED]
  app/Controllers/BaseController.php → core/Http/Request.php
- `ThrottleRequests` --implements--> `MiddlewareInterface`  [EXTRACTED]
  app/Middleware/ThrottleRequests.php → core/Routing/MiddlewareInterface.php
- `Authenticate` --implements--> `MiddlewareInterface`  [EXTRACTED]
  app/Middleware/Authenticate.php → core/Routing/MiddlewareInterface.php
- `EnsureRole` --implements--> `MiddlewareInterface`  [EXTRACTED]
  app/Middleware/EnsureRole.php → core/Routing/MiddlewareInterface.php
- `{closure#3}()` --calls--> `config_bool()`  [INFERRED]
  core/Application.php → core/helpers.php

## Import Cycles
- None detected.

## Communities (60 total, 48 thin omitted)

### Community 0 - "Response"
Cohesion: 0.10
Nodes (11): UserController, BaseController, AdminController, AuthController, AuthorController, CatalogController, CategoryController, HomeController (+3 more)

### Community 1 - "Logger"
Cohesion: 0.07
Nodes (10): app_path(), base_path(), env(), logger(), storage_path(), Logger, RateLimiter, RedisClient (+2 more)

### Community 2 - "User"
Cohesion: 0.11
Nodes (6): Role, {closure#1}(), AuthToken, {closure#1}(), User, AuthService

### Community 4 - "MangaType"
Cohesion: 0.16
Nodes (4): {closure#1}(), MangaTypeController, {closure#1}(), MangaType

### Community 5 - "Category"
Cohesion: 0.16
Nodes (3): CategoryController, {closure#1}(), Category

### Community 7 - "admin.js"
Cohesion: 0.22
Nodes (19): bindLogout(), bindMangaActions(), bindRowActions(), field(), fillMangaForm(), fillSelect(), initDashboard(), initMangaForm() (+11 more)

### Community 10 - "ValidationException"
Cohesion: 0.19
Nodes (3): CoverStorage, HttpException, ValidationException

### Community 12 - "Author"
Cohesion: 0.19
Nodes (3): {closure#1}(), Author, {closure#1}()

### Community 13 - "Connection"
Cohesion: 0.21
Nodes (6): {closure#1}(), {closure#2}(), {closure#3}(), {closure#4}(), Connection, Str

### Community 18 - "site.js"
Cohesion: 0.22
Nodes (10): field(), fillSelect(), initCatalog(), initDashboard(), initLogin(), initMangaShow(), initRegister(), kv() (+2 more)

### Community 19 - "composer.json"
Cohesion: 0.15
Nodes (12): authors, autoload, files, psr-4, name, App\\, Core\\, require (+4 more)

### Community 50 - "MiddlewareInterface"
Cohesion: 0.28
Nodes (3): Authenticate, EnsureRole, MiddlewareInterface

## Knowledge Gaps
- **48 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `View` connect `Twig\Environment` to `Response`, `.json`, `MiddlewareInterface`, `.run`, `Router.php`?**
  _High betweenness centrality (0.358) - this node is a cross-community bridge._
- **Should `Response` be split into smaller, more focused modules?**
  _Cohesion score 0.0975177304964539 - nodes in this community are weakly interconnected._
- **Why does `Response` connect `Response` to `MangaType`, `Category`, `.ok`, `Request`, `ValidationException`, `.error`, `.json`, `MiddlewareInterface`, `.run`, `Router.php`?**
  _High betweenness centrality (0.246) - this node is a cross-community bridge._
- **Should `Logger` be split into smaller, more focused modules?**
  _Cohesion score 0.06938020351526364 - nodes in this community are weakly interconnected._
- **Why does `BaseController` connect `Response` to `MangaType`, `Category`, `.ok`, `Request`, `ValidationException`, `.error`, `Session`?**
  _High betweenness centrality (0.065) - this node is a cross-community bridge._
- **Should `User` be split into smaller, more focused modules?**
  _Cohesion score 0.10634920634920635 - nodes in this community are weakly interconnected._
- **Should `Twig\Source` be split into smaller, more focused modules?**
  _Cohesion score 0.14035087719298245 - nodes in this community are weakly interconnected._