<?php
namespace App\Services;

use Core\Exceptions\ValidationException;

/**
 * Armazena as capas no próprio servidor (document root público).
 *
 * Os arquivos são gravados em public/uploads/{pasta}/AAAA/MM/<hex>.<ext>
 * e a URL devolvida é relativa à raiz (ex.: /uploads/covers/2026/11/abc.png),
 * servida diretamente pelo document root (public/).
 */
class CoverStorage {
    private const ALLOWED_MIME = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];

    private const MAX_BYTES = 5 * 1024 * 1024; // 5 MB

    public function upload(array $file, string $folder = 'covers'): string {
        $this->assertValidFile($file);

        $mime = $this->detectMime($file['tmp_name']);
        $extension = self::ALLOWED_MIME[$mime];

        $relativeDir = trim($folder, '/') . '/' . date('Y/m');
        $relativePath = $relativeDir . '/' . bin2hex(random_bytes(16)) . '.' . $extension;

        $absoluteDir = base_path('public/uploads/' . $relativeDir);
        if (!is_dir($absoluteDir) && !mkdir($absoluteDir, 0775, true) && !is_dir($absoluteDir)) {
            throw new ValidationException([
                'cover_file' => ['Não foi possível criar a pasta de uploads no servidor.'],
            ]);
        }

        $absolutePath = base_path('public/uploads/' . $relativePath);
        if (!move_uploaded_file($file['tmp_name'], $absolutePath)) {
            throw new ValidationException([
                'cover_file' => ['Não foi possível salvar a capa no servidor.'],
            ]);
        }

        return '/uploads/' . $relativePath;
    }

    /**
     * @param array{tmp_name?: string, error?: int, size?: int, type?: string, name?: string} $file
     * @throws ValidationException
     */
    private function assertValidFile(array $file): void {
        $error = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
        if ($error === UPLOAD_ERR_NO_FILE) {
            throw new ValidationException(['cover_file' => ['Selecione um arquivo de capa.']]);
        }
        if ($error !== UPLOAD_ERR_OK) {
            throw new ValidationException(['cover_file' => ['Falha no upload do arquivo de capa.']]);
        }

        $tmp = (string) ($file['tmp_name'] ?? '');
        if ($tmp === '' || !is_file($tmp) || !is_uploaded_file($tmp)) {
            throw new ValidationException(['cover_file' => ['Arquivo de capa inválido.']]);
        }

        if ((int) ($file['size'] ?? 0) > self::MAX_BYTES) {
            throw new ValidationException(['cover_file' => ['A capa deve ter no máximo 5 MB.']]);
        }

        $mime = $this->detectMime($tmp);
        if (!isset(self::ALLOWED_MIME[$mime])) {
            throw new ValidationException([
                'cover_file' => ['Formato inválido. Envie uma imagem JPG, PNG, WEBP ou GIF.'],
            ]);
        }
    }

    private function detectMime(string $path): string {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        return (string) $finfo->file($path);
    }
}
