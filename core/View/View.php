<?php
namespace Core\View;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Renderizador de views baseado em Twig.
 *
 * Os templates ficam em app/Views e usam a extensão .twig (ex.: 'home' => home.twig,
 * 'admin/mangas/index' => admin/mangas/index.twig). A API antiga é mantida, então os
 * controllers continuam chamando View::render($template, $data, $layout).
 */
class View {
    private static string $basePath = '';
    private static ?Environment $twig = null;

    /** @var array<string, mixed> */
    private static array $globals = [];

    public static function setBasePath(string $path): void {
        self::$basePath = rtrim($path, '/');
        self::$twig = null;
    }

    /**
     * Registra uma variável global disponível em todos os templates.
     */
    public static function addGlobal(string $name, mixed $value): void {
        self::$globals[$name] = $value;
        self::$twig?->addGlobal($name, $value);
    }

    /**
     * Renderiza um template e, opcionalmente, o envolve em um layout.
     * O layout fica em app/Views/layout/{layout}/main.twig (ex.: "app" ou "admin").
     *
     * @param array<string, mixed> $data
     */
    public static function render(string $template, array $data = [], ?string $layout = null): string {
        $name = str_replace('.', '/', $template) . '.twig';
        $content = self::twig()->render($name, $data);

        if ($layout !== null) {
            return self::twig()->render('layout/' . trim($layout, '/') . '/main.twig', $data + ['content' => $content]);
        }

        return $content;
    }

    private static function twig(): Environment {
        if (self::$twig !== null) {
            return self::$twig;
        }

        $cacheDir = storage_path('cache/twig');
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0775, true);
        }

        $twig = new Environment(new FilesystemLoader(self::$basePath), [
            'cache' => (is_dir($cacheDir) && is_writable($cacheDir)) ? $cacheDir : false,
            'auto_reload' => true,
            'debug' => config_bool('APP_DEBUG', false),
            'strict_variables' => false,
        ]);

        $twig->addExtension(new TwigExtension());

        foreach (self::$globals as $name => $value) {
            $twig->addGlobal($name, $value);
        }

        self::$twig = $twig;

        return $twig;
    }
}
