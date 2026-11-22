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

/* auth/register.twig */
class __TwigTemplate_2085c5c8b80ae39da9b8c074b32ebfa9 extends Template
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
        yield "<div class=\"auth-wrap\">
    <div class=\"card\">
        <h1>Criar conta</h1>

        ";
        // line 5
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["errors"] ?? null))) {
            // line 6
            yield "            <div class=\"alert alert-error\">Corrija os campos destacados abaixo.</div>
        ";
        }
        // line 8
        yield "
        <form method=\"post\" action=\"";
        // line 9
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/register"), "html", null, true);
        yield "\">
            <label>
                Nome
                <input type=\"text\" name=\"name\" value=\"";
        // line 12
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "name", [], "any", true, true, false, 12)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "name", [], "any", false, false, false, 12), "")) : ("")), "html", null, true);
        yield "\" required autofocus>
            </label>
            ";
        // line 14
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "name", [], "any", true, true, false, 14)) {
            yield "<div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "name", [], "any", false, false, false, 14)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[0] ?? null) : null), "html", null, true);
            yield "</div>";
        }
        // line 15
        yield "
            <label>
                Nome de usuário
                <input type=\"text\" name=\"username\" value=\"";
        // line 18
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "username", [], "any", true, true, false, 18)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "username", [], "any", false, false, false, 18), "")) : ("")), "html", null, true);
        yield "\" required>
            </label>
            ";
        // line 20
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "username", [], "any", true, true, false, 20)) {
            yield "<div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "username", [], "any", false, false, false, 20)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[0] ?? null) : null), "html", null, true);
            yield "</div>";
        }
        // line 21
        yield "
            <label>
                E-mail
                <input type=\"email\" name=\"email\" value=\"";
        // line 24
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "email", [], "any", true, true, false, 24)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "email", [], "any", false, false, false, 24), "")) : ("")), "html", null, true);
        yield "\" required>
            </label>
            ";
        // line 26
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "email", [], "any", true, true, false, 26)) {
            yield "<div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "email", [], "any", false, false, false, 26)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[0] ?? null) : null), "html", null, true);
            yield "</div>";
        }
        // line 27
        yield "
            <label>
                Senha
                <input type=\"password\" name=\"password\" required>
            </label>
            ";
        // line 32
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "password", [], "any", true, true, false, 32)) {
            yield "<div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "password", [], "any", false, false, false, 32)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[0] ?? null) : null), "html", null, true);
            yield "</div>";
        }
        // line 33
        yield "
            <label>
                Confirmar senha
                <input type=\"password\" name=\"password_confirmation\" required>
            </label>

            <button type=\"submit\" class=\"btn btn-primary btn-block\">Criar conta</button>
        </form>

        <p class=\"auth-switch\">Já tem conta? <a href=\"";
        // line 42
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/login"), "html", null, true);
        yield "\">Entrar</a></p>
    </div>
</div>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "auth/register.twig";
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
        return array (  135 => 42,  124 => 33,  118 => 32,  111 => 27,  105 => 26,  100 => 24,  95 => 21,  89 => 20,  84 => 18,  79 => 15,  73 => 14,  68 => 12,  62 => 9,  59 => 8,  55 => 6,  53 => 5,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "auth/register.twig", "D:\\buglivreoficial\\app\\Views\\auth\\register.twig");
    }
}
