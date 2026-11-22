<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\MacroNamespace;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* layout/admin/main.twig */
class __TwigTemplate_062ef3769bae7bd0807eff613b99c2c1 extends Template
{
    private Source $source;
    /**
     * @var array<string, MacroNamespace>
     */
    private array $macros = [];
    private \Twig\Runtime\EscaperRuntime $escaper;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->escaper = $env->getRuntime('Twig\Runtime\EscaperRuntime');

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        $context["auth"] = ((array_key_exists("auth", $context)) ? (Twig\Extension\CoreExtension::default(($context["auth"] ?? null), ["check" => false, "name" => "", "role" => "user", "can_manage" => false])) : (["check" => false, "name" => "", "role" => "user", "can_manage" => false]));
        // line 2
        yield "<!DOCTYPE html>
<html lang=\"pt-BR\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>";
        // line 7
        yield (string) $this->escaper->escape(((array_key_exists("title", $context)) ? (Twig\Extension\CoreExtension::default(($context["title"] ?? null), "Administração")) : ("Administração")), "html", null, true);
        yield " · Admin · ";
        yield (string) $this->escaper->escape(($context["app_name"] ?? null), "html", null, true);
        yield "</title>
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"";
        // line 11
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->asset("css/admin.css"), "html", null, true);
        yield "\">
</head>
<body>
<div class=\"shell\">
    <aside class=\"sidebar\">
        <a href=\"";
        // line 16
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin"), "html", null, true);
        yield "\" class=\"brand\"><span class=\"mark\">B</span> ";
        yield (string) $this->escaper->escape(($context["app_name"] ?? null), "html", null, true);
        yield "</a>

        <div class=\"nav-group\">
            <div class=\"nav-label\">Gestão</div>
            <a class=\"nav-item ";
        // line 20
        yield (string) (((($context["current_path"] ?? null) == "/admin")) ? ("active") : (""));
        yield "\" href=\"";
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin"), "html", null, true);
        yield "\">
                <span class=\"ico\">▤</span> Dashboard
            </a>
            <a class=\"nav-item ";
        // line 23
        yield (string) (((is_string($_v0 = ($context["current_path"] ?? null)) && is_string($_v1 = "/admin/categories") && str_starts_with($_v0, $_v1))) ? ("active") : (""));
        yield "\" href=\"";
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/categories"), "html", null, true);
        yield "\">
                <span class=\"ico\">❏</span> Categorias
            </a>
            <a class=\"nav-item ";
        // line 26
        yield (string) (((is_string($_v2 = ($context["current_path"] ?? null)) && is_string($_v3 = "/admin/types") && str_starts_with($_v2, $_v3))) ? ("active") : (""));
        yield "\" href=\"";
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/types"), "html", null, true);
        yield "\">
                <span class=\"ico\">◈</span> Tipos
            </a>
            <a class=\"nav-item ";
        // line 29
        yield (string) (((is_string($_v4 = ($context["current_path"] ?? null)) && is_string($_v5 = "/admin/authors") && str_starts_with($_v4, $_v5))) ? ("active") : (""));
        yield "\" href=\"";
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/authors"), "html", null, true);
        yield "\">
                <span class=\"ico\">✎</span> Autores
            </a>
            <a class=\"nav-item ";
        // line 32
        yield (string) (((is_string($_v6 = ($context["current_path"] ?? null)) && is_string($_v7 = "/admin/mangas") && str_starts_with($_v6, $_v7))) ? ("active") : (""));
        yield "\" href=\"";
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/mangas"), "html", null, true);
        yield "\">
                <span class=\"ico\">★</span> Mangás
            </a>
        </div>

        <div class=\"nav-group\">
            <div class=\"nav-label\">Site</div>
            <a class=\"nav-item\" href=\"";
        // line 39
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/dashboard"), "html", null, true);
        yield "\"><span class=\"ico\">◉</span> Minha conta</a>
            <a class=\"nav-item\" href=\"";
        // line 40
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/"), "html", null, true);
        yield "\"><span class=\"ico\">↗</span> Ver site</a>
        </div>

        <div class=\"who\">
            ";
        // line 44
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "name", [], "any", false, false, false, 44)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 45
            yield "                <strong>";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "name", [], "any", false, false, false, 45), "html", null, true);
            yield "</strong>
                <span class=\"role\">";
            // line 46
            yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["role_labels"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "role", [], "any", false, false, false, 46), [], "array", true, true, false, 46)) ? (Twig\Extension\CoreExtension::default((($_v8 = ($context["role_labels"] ?? null)) && is_array($_v8) || $_v8 instanceof ArrayAccess ? ($_v8[(($_v9 = CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "role", [], "any", false, false, false, 46)) instanceof \Stringable && (is_array($_v8) || $_v8 instanceof \ArrayObject || $_v8 instanceof \ArrayIterator) ? (string) $_v9 : $_v9)] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "role", [], "any", false, false, false, 46))) : (CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "role", [], "any", false, false, false, 46))), "html", null, true);
            yield "</span>
            ";
        }
        // line 48
        yield "            <form method=\"post\" action=\"";
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/logout"), "html", null, true);
        yield "\">
                <button type=\"submit\" class=\"btn-link\">Sair</button>
            </form>
        </div>
    </aside>

    <div class=\"main\">
        ";
        // line 55
        yield (string) ($context["content"] ?? null);
        yield "
    </div>
</div>
</body>
</html>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "layout/admin/main.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDefaultEscapeStrategy(): string|false
    {
        return "html";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  160 => 55,  149 => 48,  144 => 46,  139 => 45,  137 => 44,  130 => 40,  126 => 39,  114 => 32,  106 => 29,  98 => 26,  90 => 23,  82 => 20,  73 => 16,  65 => 11,  56 => 7,  49 => 2,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "layout/admin/main.twig", "D:\\buglivreoficial\\app\\Views\\layout\\admin\\main.twig");
    }
}
