<?php
namespace App\Models;

use Core\Database\Connection;
use Core\Exceptions\ValidationException;
use Core\Support\Str;
use PDO;

class Author {
    public int $id = 0;
    public string $name = '';
    public string $slug = '';
    public ?string $bio = null;
    public bool $is_active = true;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public static function fromRow(array $row): self {
        $author = new self();
        $author->id = (int) $row['id'];
        $author->name = (string) $row['name'];
        $author->slug = (string) $row['slug'];
        $author->bio = $row['bio'] ?? null;
        $author->is_active = (bool) $row['is_active'];
        $author->created_at = $row['created_at'] ?? null;
        $author->updated_at = $row['updated_at'] ?? null;
        return $author;
    }

    /**
     * @return self[]
     */
    public static function all(bool $onlyActive = false): array {
        $sql = 'SELECT * FROM authors';
        if ($onlyActive) {
            $sql .= ' WHERE is_active = 1';
        }
        $sql .= ' ORDER BY name ASC';

        $stmt = Connection::pdo()->query($sql);

        return array_map(static fn(array $row): self => self::fromRow($row), $stmt->fetchAll());
    }

    public static function find(int $id): ?self {
        $stmt = Connection::pdo()->prepare('SELECT * FROM authors WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function nameExists(string $name, ?int $exceptId = null): bool {
        $sql = 'SELECT 1 FROM authors WHERE name = ?';
        $params = [$name];
        if ($exceptId !== null) {
            $sql .= ' AND id <> ?';
            $params[] = $exceptId;
        }
        $stmt = Connection::pdo()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }

    public static function slugExists(string $slug, ?int $exceptId = null): bool {
        $sql = 'SELECT 1 FROM authors WHERE slug = ?';
        $params = [$slug];
        if ($exceptId !== null) {
            $sql .= ' AND id <> ?';
            $params[] = $exceptId;
        }
        $stmt = Connection::pdo()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }

    public static function create(string $name, string $slug, ?string $bio, bool $isActive = true): self {
        $pdo = Connection::pdo();
        $stmt = $pdo->prepare(
            'INSERT INTO authors (name, slug, bio, is_active) VALUES (?, ?, ?, ?)'
        );
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $slug);
        $stmt->bindValue(3, $bio);
        $stmt->bindValue(4, $isActive ? 1 : 0, PDO::PARAM_INT);
        $stmt->execute();

        return self::find((int) $pdo->lastInsertId());
    }

    public static function update(int $id, string $name, string $slug, ?string $bio): void {
        $stmt = Connection::pdo()->prepare(
            'UPDATE authors SET name = ?, slug = ?, bio = ? WHERE id = ?'
        );
        $stmt->execute([$name, $slug, $bio, $id]);
    }

    public static function setActive(int $id, bool $active): void {
        $stmt = Connection::pdo()->prepare('UPDATE authors SET is_active = ? WHERE id = ?');
        $stmt->bindValue(1, $active ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(2, $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function delete(int $id): void {
        $stmt = Connection::pdo()->prepare('DELETE FROM authors WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function slugify(string $value): string {
        return Str::slugify($value, 170, 'autor');
    }

    public static function uniqueSlug(string $name, ?int $exceptId = null): string {
        $base = self::slugify($name);
        $slug = $base;
        $counter = 2;

        while (self::slugExists($slug, $exceptId)) {
            $suffix = '-' . $counter;
            $slug = substr($base, 0, 170 - strlen($suffix)) . $suffix;
            $counter++;
        }

        return $slug;
    }

    /**
     * Valida e normaliza os dados de um autor.
     *
     * @return array{name: string, bio: ?string}
     * @throws ValidationException
     */
    public static function validate(array $data, ?int $exceptId = null): array {
        $name = trim((string) ($data['name'] ?? ''));
        $bio = trim((string) ($data['bio'] ?? ''));

        $errors = [];

        if ($name === '') {
            $errors['name'][] = 'O nome é obrigatório.';
        } elseif (mb_strlen($name) < 2) {
            $errors['name'][] = 'O nome deve ter ao menos 2 caracteres.';
        } elseif (mb_strlen($name) > 150) {
            $errors['name'][] = 'O nome deve ter no máximo 150 caracteres.';
        } elseif (self::nameExists($name, $exceptId)) {
            $errors['name'][] = 'Já existe um autor com este nome.';
        }

        if (mb_strlen($bio) > 3000) {
            $errors['bio'][] = 'A biografia deve ter no máximo 3000 caracteres.';
        }

        if ($errors !== []) {
            throw new ValidationException($errors);
        }

        return ['name' => $name, 'bio' => $bio === '' ? null : $bio];
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'bio' => $this->bio,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
