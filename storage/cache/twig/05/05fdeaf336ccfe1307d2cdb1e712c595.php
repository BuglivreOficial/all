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
class __TwigTemplate_5b0f19b487f733e0b3a692e82a878860 extends Template
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

        <nav class=\"nav\">
            <a href=\"";
        // line 19
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/"), "html", null, true);
        yield "\" class=\"";
        yield (string) (((($context["current_path"] ?? null) == "/")) ? ("active") : (""));
        yield "\">Início</a>
            <a href=\"";
        // line 20
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\" class=\"";
        yield (string) (((is_string($_v0 = ($context["current_path"] ?? null)) && is_string($_v1 = "/mangas") && str_starts_with($_v0, $_v1))) ? ("active") : (""));
        yield "\">Catálogo</a>
        </nav>

        <form class=\"topbar-search search\" action=\"";
        // line 23
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\" method=\"get\">
            <input type=\"search\" name=\"q\" placeholder=\"Buscar mangás...\" value=\"";
        // line 24
        yield (string) $this->escaper->escape(((array_key_exists("search", $context)) ? (Twig\Extension\CoreExtension::default(($context["search"] ?? null), "")) : ("")), "html", null, true);
        yield "\">
        </form>

        <div class=\"topbar-actions\">
            ";
        // line 28
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "check", [], "any", false, false, false, 28)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 29
            yield "                ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "can_manage", [], "any", false, false, false, 29)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 30
                yield "                    <a class=\"btn btn-ghost\" href=\"";
                yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin"), "html", null, true);
                yield "\">Admin</a>
                ";
            }
            // line 32
            yield "                <a class=\"btn btn-ghost\" href=\"";
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/dashboard"), "html", null, true);
            yield "\">";
            yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "name", [], "any", true, true, false, 32)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "name", [], "any", false, false, false, 32), "Conta")) : ("Conta")), "html", null, true);
            yield "</a>
                <form method=\"post\" action=\"";
            // line 33
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/logout"), "html", null, true);
            yield "\">
                    <button type=\"submit\" class=\"link-btn\">Sair</button>
                </form>
            ";
        } else {
            // line 37
            yield "                <a class=\"btn btn-ghost\" href=\"";
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/login"), "html", null, true);
            yield "\">Entrar</a>
                <a class=\"btn btn-primary\" href=\"";
            // line 38
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/register"), "html", null, true);
            yield "\">Criar conta</a>
            ";
        }
        // line 40
        yield "        </div>
    </div>
</header>

<main class=\"container\">
    ";
        // line 45
        yield (string) ($context["content"] ?? null);
        yield "
</main>

<footer class=\"footer\">
    <div class=\"container footer-inner\">
        <span>&copy; ";
        // line 50
        yield (string) $this->escaper->escape(($context["year"] ?? null), "html", null, true);
        yield " ";
        yield (string) $this->escaper->escape(($context["app_name"] ?? null), "html", null, true);
        yield " — Todos os direitos reservados.</span>
        <span>
            <a href=\"";
        // line 52
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\">Catálogo</a> ·
            <a href=\"";
        // line 53
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
        return array (  167 => 53,  163 => 52,  156 => 50,  148 => 45,  141 => 40,  136 => 38,  131 => 37,  124 => 33,  117 => 32,  111 => 30,  108 => 29,  106 => 28,  99 => 24,  95 => 23,  87 => 20,  81 => 19,  73 => 16,  65 => 11,  56 => 7,  49 => 2,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "layout/app/main.twig", "D:\\buglivreoficial\\app\\Views\\layout\\app\\main.twig");
    }
}
