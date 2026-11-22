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

/* layout/app/main.twig */
class __TwigTemplate_3afbe296fd62bf8d7313e8cdc810a8b0 extends Template
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
        yield (string) $this->escaper->escape(((array_key_exists("title", $context)) ? (Twig\Extension\CoreExtension::default(($context["title"] ?? null), "Início")) : ("Início")), "html", null, true);
        yield " · ";
        yield (string) $this->escaper->escape(($context["app_name"] ?? null), "html", null, true);
        yield "</title>
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"";
        // line 11
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->asset("css/site.css"), "html", null, true);
        yield "\">
</head>
<body>
<header class=\"topbar\">
    <div class=\"container topbar-inner\">
        <a href=\"";
        // line 16
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/"), "html", null, true);
        yield "\" class=\"brand\"><span class=\"mark\">B</span> ";
        yield (string) $this->escaper->escape(($context["app_name"] ?? null), "html", null, true);
        yield "</a>

        <input type=\"checkbox\" id=\"nav-toggle\" class=\"nav-toggle\" hidden>
        <label for=\"nav-toggle\" class=\"nav-burger\" aria-label=\"Abrir menu\">
            <span></span><span></span><span></span>
        </label>

        <label for=\"nav-toggle\" class=\"drawer-backdrop\" aria-hidden=\"true\"></label>

        <div class=\"topbar-menu\">
            <div class=\"drawer-head\">
                <span class=\"brand\"><span class=\"mark\">B</span> ";
        // line 27
        yield (string) $this->escaper->escape(($context["app_name"] ?? null), "html", null, true);
        yield "</span>
                <label for=\"nav-toggle\" class=\"drawer-close\" aria-label=\"Fechar menu\">&times;</label>
            </div>

            <nav class=\"nav\">
                <a href=\"";
        // line 32
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/"), "html", null, true);
        yield "\" class=\"";
        yield (string) (((($context["current_path"] ?? null) == "/")) ? ("active") : (""));
        yield "\">Início</a>
                <a href=\"";
        // line 33
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\" class=\"";
        yield (string) (((is_string($_v0 = ($context["current_path"] ?? null)) && is_string($_v1 = "/mangas") && str_starts_with($_v0, $_v1))) ? ("active") : (""));
        yield "\">Catálogo</a>
            </nav>

            <form class=\"topbar-search search\" action=\"";
        // line 36
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\" method=\"get\">
                <input type=\"search\" name=\"q\" placeholder=\"Buscar mangás...\" value=\"";
        // line 37
        yield (string) $this->escaper->escape(((array_key_exists("search", $context)) ? (Twig\Extension\CoreExtension::default(($context["search"] ?? null), "")) : ("")), "html", null, true);
        yield "\">
            </form>

            <div class=\"topbar-actions\">
                ";
        // line 41
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "check", [], "any", false, false, false, 41)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 42
            yield "                    ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "can_manage", [], "any", false, false, false, 42)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 43
                yield "                        <a class=\"btn btn-ghost\" href=\"";
                yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin"), "html", null, true);
                yield "\">Admin</a>
                    ";
            }
            // line 45
            yield "                    <a class=\"btn btn-ghost\" href=\"";
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/dashboard"), "html", null, true);
            yield "\">";
            yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "name", [], "any", true, true, false, 45)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "name", [], "any", false, false, false, 45), "Conta")) : ("Conta")), "html", null, true);
            yield "</a>
                    <form method=\"post\" action=\"";
            // line 46
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/logout"), "html", null, true);
            yield "\">
                        <button type=\"submit\" class=\"link-btn\">Sair</button>
                    </form>
                ";
        } else {
            // line 50
            yield "                    <a class=\"btn btn-ghost\" href=\"";
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/login"), "html", null, true);
            yield "\">Entrar</a>
                    <a class=\"btn btn-primary\" href=\"";
            // line 51
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/register"), "html", null, true);
            yield "\">Criar conta</a>
                ";
        }
        // line 53
        yield "            </div>
        </div>
    </div>
</header>

<main class=\"container\">
    ";
        // line 59
        yield (string) ($context["content"] ?? null);
        yield "
</main>

<footer class=\"footer\">
    <div class=\"container footer-inner\">
        <span>&copy; ";
        // line 64
        yield (string) $this->escaper->escape(($context["year"] ?? null), "html", null, true);
        yield " ";
        yield (string) $this->escaper->escape(($context["app_name"] ?? null), "html", null, true);
        yield " — Todos os direitos reservados.</span>
        <span>
            <a href=\"";
        // line 66
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\">Catálogo</a> ·
            <a href=\"";
        // line 67
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/login"), "html", null, true);
        yield "\">Entrar</a>
        </span>
    </div>
</footer>
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
        return "layout/app/main.twig";
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
        return array (  184 => 67,  180 => 66,  173 => 64,  165 => 59,  157 => 53,  152 => 51,  147 => 50,  140 => 46,  133 => 45,  127 => 43,  124 => 42,  122 => 41,  115 => 37,  111 => 36,  103 => 33,  97 => 32,  89 => 27,  73 => 16,  65 => 11,  56 => 7,  49 => 2,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% set auth = auth|default({check: false, name: \x27\x27, role: \x27user\x27, can_manage: false}) %}
<!DOCTYPE html>
<html lang=\"pt-BR\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>{{ title|default(\x27Início\x27) }} · {{ app_name }}</title>
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"{{ asset(\x27css/site.css\x27) }}\">
</head>
<body>
<header class=\"topbar\">
    <div class=\"container topbar-inner\">
        <a href=\"{{ url(\x27/\x27) }}\" class=\"brand\"><span class=\"mark\">B</span> {{ app_name }}</a>

        <input type=\"checkbox\" id=\"nav-toggle\" class=\"nav-toggle\" hidden>
        <label for=\"nav-toggle\" class=\"nav-burger\" aria-label=\"Abrir menu\">
            <span></span><span></span><span></span>
        </label>

        <label for=\"nav-toggle\" class=\"drawer-backdrop\" aria-hidden=\"true\"></label>

        <div class=\"topbar-menu\">
            <div class=\"drawer-head\">
                <span class=\"brand\"><span class=\"mark\">B</span> {{ app_name }}</span>
                <label for=\"nav-toggle\" class=\"drawer-close\" aria-label=\"Fechar menu\">&times;</label>
            </div>

            <nav class=\"nav\">
                <a href=\"{{ url(\x27/\x27) }}\" class=\"{{ current_path == \x27/\x27 ? \x27active\x27 : \x27\x27 }}\">Início</a>
                <a href=\"{{ url(\x27/mangas\x27) }}\" class=\"{{ current_path starts with \x27/mangas\x27 ? \x27active\x27 : \x27\x27 }}\">Catálogo</a>
            </nav>

            <form class=\"topbar-search search\" action=\"{{ url(\x27/mangas\x27) }}\" method=\"get\">
                <input type=\"search\" name=\"q\" placeholder=\"Buscar mangás...\" value=\"{{ search|default(\x27\x27) }}\">
            </form>

            <div class=\"topbar-actions\">
                {% if auth.check %}
                    {% if auth.can_manage %}
                        <a class=\"btn btn-ghost\" href=\"{{ url(\x27/admin\x27) }}\">Admin</a>
                    {% endif %}
                    <a class=\"btn btn-ghost\" href=\"{{ url(\x27/dashboard\x27) }}\">{{ auth.name|default(\x27Conta\x27) }}</a>
                    <form method=\"post\" action=\"{{ url(\x27/logout\x27) }}\">
                        <button type=\"submit\" class=\"link-btn\">Sair</button>
                    </form>
                {% else %}
                    <a class=\"btn btn-ghost\" href=\"{{ url(\x27/login\x27) }}\">Entrar</a>
                    <a class=\"btn btn-primary\" href=\"{{ url(\x27/register\x27) }}\">Criar conta</a>
                {% endif %}
            </div>
        </div>
    </div>
</header>

<main class=\"container\">
    {{ content|raw }}
</main>

<footer class=\"footer\">
    <div class=\"container footer-inner\">
        <span>&copy; {{ year }} {{ app_name }} — Todos os direitos reservados.</span>
        <span>
            <a href=\"{{ url(\x27/mangas\x27) }}\">Catálogo</a> ·
            <a href=\"{{ url(\x27/login\x27) }}\">Entrar</a>
        </span>
    </div>
</footer>
</body>
</html>
", "layout/app/main.twig", "D:\\buglivreoficial\\app\\Views\\layout\\app\\main.twig");
    }
}
