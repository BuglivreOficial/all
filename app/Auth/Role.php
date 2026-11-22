<?php
namespace App\Auth;

class Role {
    public const USER      = 'user';
    public const VIP       = 'vip';
    public const MODERATOR = 'moderador';
    public const SUPPORT   = 'suporte';
    public const ADMIN     = 'admin';

    /** Nível hierárquico de cada perfil. */
    private const LEVELS = [
        self::USER      => 1,
        self::VIP       => 2,
        self::MODERATOR => 3,
        self::SUPPORT   => 4,
        self::ADMIN     => 5,
    ];

    private const LABELS = [
        self::USER      => 'Usuário',
        self::VIP       => 'VIP',
        self::MODERATOR => 'Moderador',
        self::SUPPORT   => 'Suporte',
        self::ADMIN     => 'Administrador',
    ];

    /** @return string[] */
    public static function all(): array {
        return array_keys(self::LEVELS);
    }

    public static function exists(string $role): bool {
        return isset(self::LEVELS[$role]);
    }

    public static function level(string $role): int {
        return self::LEVELS[$role] ?? 0;
    }

    public static function label(string $role): string {
        return self::LABELS[$role] ?? $role;
    }

    /** Indica se $role tem nível igual ou superior a $minimum. */
    public static function atLeast(string $role, string $minimum): bool {
        return self::level($role) >= self::level($minimum);
    }

    /** @return array<string, string> value => rótulo, para formulários. */
    public static function options(): array {
        return self::LABELS;
    }
}
