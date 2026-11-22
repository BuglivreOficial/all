<?php
namespace App\Models;

use Core\Database\Connection;
use Core\Exceptions\ValidationException;
use Core\Support\Str;
use PDO;

class MangaType {
    public int $id = 0;
    public string $name = '';
    public string $slug = '';
    public ?string $description = null;
    public bool $is_active = true;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public static function fromRow(array $row): self {
        $type = new self();
        $type->id = (int) $row['id'];
        $type->name = (string) $row['name'];
        $type->slug = (string) $row['slug'];
        $type->description = $row['description'] ?? null;
        $type->is_active = (bool) $row['is_active'];
        $type->created_at = $row['created_at'] ?? null;
        $type->updated_at = $row['updated_at'] ?? null;
        return $type;
    }

    /**
     * @return self[]
     */
    public static function all(bool $onlyActive = false): array {
        $sql = 'SELECT * FROM manga_types';
        if ($onlyActive) {
            $sql .= ' WHERE is_active = 1';
        }
        $sql .= ' ORDER BY name ASC';

        $stmt = Connection::pdo()->query($sql);

        return array_map(static fn(array $row): self => self::fromRow($row), $stmt->fetchAll());
    }

    public static function find(int $id): ?self {
        $stmt = Connection::pdo()->prepare('SELECT * FROM manga_types WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function nameExists(string $name, ?int $exceptId = null): bool {
        $sql = 'SELECT 1 FROM manga_types WHERE name = ?';
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
        $sql = 'SELECT 1 FROM manga_types WHERE slug = ?';
        $params = [$slug];
        if ($exceptId !== null) {
            $sql .= ' AND id <> ?';
            $params[] = $exceptId;
        }
        $stmt = Connection::pdo()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }

    public static function create(string $name, string $slug, ?string $description, bool $isActive = true): self {
        $pdo = Connection::pdo();
        $stmt = $pdo->prepare(
            'INSERT INTO manga_types (name, slug, description, is_active) VALUES (?, ?, ?, ?)'
        );
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $slug);
        $stmt->bindValue(3, $description);
        $stmt->bindValue(4, $isActive ? 1 : 0, PDO::PARAM_INT);
        $stmt->execute();

        return self::find((int) $pdo->lastInsertId());
    }

    public static function update(int $id, string $name, string $slug, ?string $description): void {
        $stmt = Connection::pdo()->prepare(
            'UPDATE manga_types SET name = ?, slug = ?, description = ? WHERE id = ?'
        );
        $stmt->execute([$name, $slug, $description, $id]);
    }

    public static function setActive(int $id, bool $active): void {
        $stmt = Connection::pdo()->prepare('UPDATE manga_types SET is_active = ? WHERE id = ?');
        $stmt->bindValue(1, $active ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(2, $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function delete(int $id): void {
        $stmt = Connection::pdo()->prepare('DELETE FROM manga_types WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function slugify(string $value): string {
        return Str::slugify($value, 140, 'tipo');
    }

    public static function uniqueSlug(string $name, ?int $exceptId = null): string {
        $base = self::slugify($name);
        $slug = $base;
        $counter = 2;

        while (self::slugExists($slug, $exceptId)) {
            $suffix = '-' . $counter;
            $slug = substr($base, 0, 140 - strlen($suffix)) . $suffix;
            $counter++;
        }

        return $slug;
    }

    /**
     * Valida e normaliza os dados de um tipo de mangá.
     *
     * @return array{name: string, description: ?string}
     * @throws ValidationException
     */
    public static function validate(array $data, ?int $exceptId = null): array {
        $name = trim((string) ($data['name'] ?? ''));
        $description = trim((string) ($data['description'] ?? ''));

        $errors = [];

        if ($name === '') {
            $errors['name'][] = 'O nome é obrigatório.';
        } elseif (mb_strlen($name) < 2) {
            $errors['name'][] = 'O nome deve ter ao menos 2 caracteres.';
        } elseif (mb_strlen($name) > 120) {
            $errors['name'][] = 'O nome deve ter no máximo 120 caracteres.';
        } elseif (self::nameExists($name, $exceptId)) {
            $errors['name'][] = 'Já existe um tipo com este nome.';
        }

        if (mb_strlen($description) > 1000) {
            $errors['description'][] = 'A descrição deve ter no máximo 1000 caracteres.';
        }

        if ($errors !== []) {
            throw new ValidationException($errors);
        }

        return ['name' => $name, 'description' => $description === '' ? null : $description];
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
