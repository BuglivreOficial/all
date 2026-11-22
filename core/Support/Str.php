<?php
namespace Core\Support;

class Str {
    /** Transliteração de caracteres acentuados para ASCII (evita artefatos do iconv no Windows). */
    private const TRANSLITERATION = [
        'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a', 'å' => 'a',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
        'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
        'ç' => 'c', 'ñ' => 'n', 'ý' => 'y', 'ÿ' => 'y',
        'æ' => 'ae', 'œ' => 'oe', 'ø' => 'o', 'ß' => 'ss',
    ];

    /**
     * Gera um slug ASCII a partir de um texto (ex.: "Ação & Aventura" => "acao-aventura").
     */
    public static function slugify(string $value, int $maxLength = 140, string $fallback = 'item'): string {
        $value = mb_strtolower(trim($value), 'UTF-8');
        $value = strtr($value, self::TRANSLITERATION);
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
        $value = trim($value, '-');

        return $value === '' ? $fallback : substr($value, 0, $maxLength);
    }
}
