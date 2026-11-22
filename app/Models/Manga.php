<?php
namespace App\Models;

use Core\Database\Connection;
use Core\Exceptions\ValidationException;
use Core\Support\Str;
use PDO;

class Manga {
    public const STATUS_ONGOING = 'ongoing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_HIATUS = 'hiatus';
    public const STATUS_CANCELLED = 'cancelled';

    private const STATUS_LABELS = [
        self::STATUS_ONGOING => 'Em publicação',
        self::STATUS_COMPLETED => 'Completo',
        self::STATUS_HIATUS => 'Em hiato',
        self::STATUS_CANCELLED => 'Cancelado',
    ];

    public int $id = 0;
    public int $type_id = 0;
    public string $type_name = '';
    public ?int $author_id = null;
    public ?string $author_name = null;
    public string $title = '';
    public string $slug = '';
    public ?string $description = null;
    public ?string $cover = null;
    public string $status = self::STATUS_ONGOING;
    public bool $is_active = true;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    /** @var array<int, array{id: int, name: string}> */
    public array $categories = [];

    /**
     * @return array<string, string>
     */
    public static function statuses(): array {
        return self::STATUS_LABELS;
    }

    public static function statusLabel(string $status): string {
        return self::STATUS_LABELS[$status] ?? $status;
    }

    public static function isValidStatus(string $status): bool {
        return isset(self::STATUS_LABELS[$status]);
    }

    /**
     * @return string[]
     */
    public function categoryNames(): array {
        return array_map(static fn(array $category): string => $category['name'], $this->categories);
    }

    public function categoryLabel(): string {
        return implode(', ', $this->categoryNames());
    }

    public static function fromRow(array $row): self {
        $manga = new self();
        $manga->id = (int) $row['id'];
        $manga->type_id = (int) $row['type_id'];
        $manga->type_name = (string) ($row['type_name'] ?? '');
        $manga->author_id = ($row['author_id'] ?? null) === null ? null : (int) $row['author_id'];
        $manga->author_name = $row['author_name'] ?? null;
        $manga->title = (string) $row['title'];
        $manga->slug = (string) $row['slug'];
        $manga->description = $row['description'] ?? null;
        $manga->cover = $row['cover'] ?? null;
        $manga->status = (string) $row['status'];
        $manga->is_active = (bool) $row['is_active'];
        $manga->created_at = $row['created_at'] ?? null;
        $manga->updated_at = $row['updated_at'] ?? null;
        return $manga;
    }

    /**
     * @return self[]
     */
    public static function all(string $search = '', ?int $categoryId = null, ?int $typeId = null, bool $onlyActive = false): array {
        $sql = 'SELECT DISTINCT m.*, t.name AS type_name, a.name AS author_name FROM mangas m'
            . ' LEFT JOIN manga_types t ON t.id = m.type_id'
            . ' LEFT JOIN authors a ON a.id = m.author_id';
        $conditions = [];
        $params = [];

        if ($categoryId !== null) {
            $sql .= ' INNER JOIN manga_categories mc ON mc.manga_id = m.id';
            $conditions[] = 'mc.category_id = ?';
            $params[] = $categoryId;
        }
        if ($typeId !== null) {
            $conditions[] = 'm.type_id = ?';
            $params[] = $typeId;
        }
        if ($search !== '') {
            $conditions[] = '(m.title LIKE ? OR a.name LIKE ?)';
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
        }
        if ($onlyActive) {
            $conditions[] = 'm.is_active = 1';
        }
        if ($conditions !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $sql .= ' ORDER BY m.title ASC';

        $stmt = Connection::pdo()->prepare($sql);
        $stmt->execute($params);
        $mangas = array_map(static fn(array $row): self => self::fromRow($row), $stmt->fetchAll());

        self::loadCategories($mangas);

        return $mangas;
    }

    public static function find(int $id): ?self {
        $stmt = Connection::pdo()->prepare(
            'SELECT m.*, t.name AS type_name, a.name AS author_name FROM mangas m'
            . ' LEFT JOIN manga_types t ON t.id = m.type_id'
            . ' LEFT JOIN authors a ON a.id = m.author_id'
            . ' WHERE m.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }

        $manga = self::fromRow($row);
        self::loadCategories([$manga]);

        return $manga;
    }

    public static function findBySlug(string $slug): ?self {
        $stmt = Connection::pdo()->prepare(
            'SELECT m.*, t.name AS type_name, a.name AS author_name FROM mangas m'
            . ' LEFT JOIN manga_types t ON t.id = m.type_id'
            . ' LEFT JOIN authors a ON a.id = m.author_id'
            . ' WHERE m.slug = ? LIMIT 1'
        );
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }

        $manga = self::fromRow($row);
        self::loadCategories([$manga]);

        return $manga;
    }

    /**
     * Mangás mais recentes (usado na vitrine da home).
     *
     * @return self[]
     */
    public static function latest(int $limit = 12, bool $onlyActive = true): array {
        $sql = 'SELECT m.*, t.name AS type_name, a.name AS author_name FROM mangas m'
            . ' LEFT JOIN manga_types t ON t.id = m.type_id'
            . ' LEFT JOIN authors a ON a.id = m.author_id';
        if ($onlyActive) {
            $sql .= ' WHERE m.is_active = 1';
        }
        $sql .= ' ORDER BY m.created_at DESC, m.id DESC LIMIT ' . max(1, $limit);

        $stmt = Connection::pdo()->query($sql);
        $mangas = array_map(static fn(array $row): self => self::fromRow($row), $stmt->fetchAll());

        self::loadCategories($mangas);

        return $mangas;
    }

    /**
     * Carrega as categorias de cada mangá em uma única consulta.
     *
     * @param self[] $mangas
     */
    private static function loadCategories(array $mangas): void {
        if ($mangas === []) {
            return;
        }

        $ids = array_map(static fn(self $manga): int => $manga->id, $mangas);
        $placeholders = implode(', ', array_fill(0, count($ids), '?'));

        $stmt = Connection::pdo()->prepare(
            'SELECT mc.manga_id, c.id, c.name FROM manga_categories mc '
            . 'INNER JOIN categories c ON c.id = mc.category_id '
            . "WHERE mc.manga_id IN ($placeholders) ORDER BY c.name ASC"
        );
        $stmt->execute($ids);

        $map = [];
        foreach ($stmt->fetchAll() as $row) {
            $map[(int) $row['manga_id']][] = ['id' => (int) $row['id'], 'name' => (string) $row['name']];
        }

        foreach ($mangas as $manga) {
            $manga->categories = $map[$manga->id] ?? [];
        }
    }

    public static function titleExists(string $title, ?int $exceptId = null): bool {
        $sql = 'SELECT 1 FROM mangas WHERE title = ?';
        $params = [$title];
        if ($exceptId !== null) {
            $sql .= ' AND id <> ?';
            $params[] = $exceptId;
        }
        $stmt = Connection::pdo()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }

    public static function slugExists(string $slug, ?int $exceptId = null): bool {
        $sql = 'SELECT 1 FROM mangas WHERE slug = ?';
        $params = [$slug];
        if ($exceptId !== null) {
            $sql .= ' AND id <> ?';
            $params[] = $exceptId;
        }
        $stmt = Connection::pdo()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }

    public static function countByCategory(int $categoryId): int {
        $stmt = Connection::pdo()->prepare('SELECT COUNT(*) FROM manga_categories WHERE category_id = ?');
        $stmt->execute([$categoryId]);
        return (int) $stmt->fetchColumn();
    }

    public static function countByType(int $typeId): int {
        $stmt = Connection::pdo()->prepare('SELECT COUNT(*) FROM mangas WHERE type_id = ?');
        $stmt->execute([$typeId]);
        return (int) $stmt->fetchColumn();
    }

    public static function countByAuthor(int $authorId): int {
        $stmt = Connection::pdo()->prepare('SELECT COUNT(*) FROM mangas WHERE author_id = ?');
        $stmt->execute([$authorId]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * @param array{type_id: int, author_id: ?int, title: string, slug: string, category_ids: int[], description: ?string, cover: ?string, status: string} $data
     */
    public static function create(array $data): self {
        $pdo = Connection::pdo();
        $stmt = $pdo->prepare(
            'INSERT INTO mangas (type_id, author_id, title, slug, description, cover, status) VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bindValue(1, $data['type_id'], PDO::PARAM_INT);
        if ($data['author_id'] === null) {
            $stmt->bindValue(2, null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(2, $data['author_id'], PDO::PARAM_INT);
        }
        $stmt->bindValue(3, $data['title']);
        $stmt->bindValue(4, $data['slug']);
        $stmt->bindValue(5, $data['description']);
        $stmt->bindValue(6, $data['cover']);
        $stmt->bindValue(7, $data['status']);
        $stmt->execute();

        $id = (int) $pdo->lastInsertId();
        self::syncCategories($id, $data['category_ids'] ?? []);

        return self::find($id);
    }

    /**
     * @param array{type_id: int, author_id: ?int, title: string, slug: string, category_ids: int[], description: ?string, cover: ?string, status: string} $data
     */
    public static function update(int $id, array $data): void {
        $stmt = Connection::pdo()->prepare(
            'UPDATE mangas SET type_id = ?, author_id = ?, title = ?, slug = ?, description = ?, cover = ?, status = ? WHERE id = ?'
        );
        $stmt->bindValue(1, $data['type_id'], PDO::PARAM_INT);
        if ($data['author_id'] === null) {
            $stmt->bindValue(2, null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(2, $data['author_id'], PDO::PARAM_INT);
        }
        $stmt->bindValue(3, $data['title']);
        $stmt->bindValue(4, $data['slug']);
        $stmt->bindValue(5, $data['description']);
        $stmt->bindValue(6, $data['cover']);
        $stmt->bindValue(7, $data['status']);
        $stmt->bindValue(8, $id, PDO::PARAM_INT);
        $stmt->execute();

        self::syncCategories($id, $data['category_ids'] ?? []);
    }

    /**
     * Substitui as categorias vinculadas a um mangá (N:N).
     *
     * @param int[] $categoryIds
     */
    private static function syncCategories(int $id, array $categoryIds): void {
        $pdo = Connection::pdo();
        $ids = array_values(array_unique(array_map('intval', $categoryIds)));

        $pdo->beginTransaction();
        try {
            $delete = $pdo->prepare('DELETE FROM manga_categories WHERE manga_id = ?');
            $delete->execute([$id]);

            if ($ids !== []) {
                $insert = $pdo->prepare('INSERT INTO manga_categories (manga_id, category_id) VALUES (?, ?)');
                foreach ($ids as $categoryId) {
                    $insert->execute([$id, $categoryId]);
                }
            }

            $pdo->commit();
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function setActive(int $id, bool $active): void {
        $stmt = Connection::pdo()->prepare('UPDATE mangas SET is_active = ? WHERE id = ?');
        $stmt->bindValue(1, $active ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(2, $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function delete(int $id): void {
        $stmt = Connection::pdo()->prepare('DELETE FROM mangas WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function slugify(string $value): string {
        return Str::slugify($value, 220, 'manga');
    }

    /**
     * Gera um slug único, adicionando sufixo numérico quando necessário.
     */
    public static function uniqueSlug(string $title, ?int $exceptId = null): string {
        $base = self::slugify($title);
        $slug = $base;
        $counter = 2;

        while (self::slugExists($slug, $exceptId)) {
            $suffix = '-' . $counter;
            $slug = substr($base, 0, 220 - strlen($suffix)) . $suffix;
            $counter++;
        }

        return $slug;
    }

    /**
     * Valida e normaliza os dados de um mangá.
     *
     * @return array{type_id: int, author_id: ?int, title: string, category_ids: int[], description: ?string, cover: ?string, status: string}
     * @throws ValidationException
     */
    public static function validate(array $data, ?int $exceptId = null): array {
        $typeId = (int) ($data['type_id'] ?? 0);
        $rawAuthor = $data['author_id'] ?? null;
        $authorId = ($rawAuthor === null || $rawAuthor === '') ? null : (int) $rawAuthor;
        $title = trim((string) ($data['title'] ?? ''));
        $description = trim((string) ($data['description'] ?? ''));
        $cover = trim((string) ($data['cover'] ?? ''));
        $status = trim((string) ($data['status'] ?? ''));

        $rawCategories = $data['category_ids'] ?? [];
        if (!is_array($rawCategories)) {
            $rawCategories = [$rawCategories];
        }
        $categoryIds = [];
        foreach ($rawCategories as $categoryId) {
            $categoryId = (int) $categoryId;
            if ($categoryId > 0) {
                $categoryIds[] = $categoryId;
            }
        }
        $categoryIds = array_values(array_unique($categoryIds));

        $errors = [];

        if ($typeId <= 0 || MangaType::find($typeId) === null) {
            $errors['type_id'][] = 'Selecione um tipo válido.';
        }

        if ($authorId !== null && Author::find($authorId) === null) {
            $errors['author_id'][] = 'Selecione um autor válido.';
        }

        if ($title === '') {
            $errors['title'][] = 'O título é obrigatório.';
        } elseif (mb_strlen($title) < 2) {
            $errors['title'][] = 'O título deve ter ao menos 2 caracteres.';
        } elseif (mb_strlen($title) > 200) {
            $errors['title'][] = 'O título deve ter no máximo 200 caracteres.';
        } elseif (self::titleExists($title, $exceptId)) {
            $errors['title'][] = 'Já existe um mangá com este título.';
        }

        if ($categoryIds === []) {
            $errors['category_ids'][] = 'Selecione ao menos uma categoria.';
        } else {
            foreach ($categoryIds as $categoryId) {
                if (Category::find($categoryId) === null) {
                    $errors['category_ids'][] = 'Uma ou mais categorias selecionadas são inválidas.';
                    break;
                }
            }
        }

        if (mb_strlen($description) > 5000) {
            $errors['description'][] = 'A sinopse deve ter no máximo 5000 caracteres.';
        }

        if ($cover !== '' && mb_strlen($cover) > 255) {
            $errors['cover'][] = 'A capa deve ter no máximo 255 caracteres.';
        } elseif ($cover !== '' && filter_var($cover, FILTER_VALIDATE_URL) === false && !str_starts_with($cover, '/')) {
            $errors['cover'][] = 'Informe uma URL ou um caminho de capa válido.';
        }

        if (!self::isValidStatus($status)) {
            $errors['status'][] = 'Selecione um status válido.';
        }

        if ($errors !== []) {
            throw new ValidationException($errors);
        }

        return [
            'type_id' => $typeId,
            'author_id' => $authorId,
            'title' => $title,
            'category_ids' => $categoryIds,
            'description' => $description === '' ? null : $description,
            'cover' => $cover === '' ? null : $cover,
            'status' => $status,
        ];
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'type_id' => $this->type_id,
            'type_name' => $this->type_name,
            'author_id' => $this->author_id,
            'author_name' => $this->author_name,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'cover' => $this->cover,
            'status' => $this->status,
            'status_label' => self::statusLabel($this->status),
            'is_active' => $this->is_active,
            'categories' => $this->categories,
            'category_names' => $this->categoryNames(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
