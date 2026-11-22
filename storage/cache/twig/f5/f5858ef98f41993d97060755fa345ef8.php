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

/* auth/login.twig */
class __TwigTemplate_abd6986bb17c1d3e57aae3dda7592745 extends Template
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
        <h1>Entrar</h1>

        ";
        // line 5
        if ((($tmp = ($context["error"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 6
            yield "            <div class=\"alert alert-error\">";
            yield (string) $this->escaper->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>
        ";
        }
        // line 8
        yield "
        <form method=\"post\" action=\"";
        // line 9
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/login"), "html", null, true);
        yield "\">
            <label>
                E-mail ou nome de usuário
                <input type=\"text\" name=\"login\" value=\"";
        // line 12
        yield (string) $this->escaper->escape(((array_key_exists("identifier", $context)) ? (Twig\Extension\CoreExtension::default(($context["identifier"] ?? null), "")) : ("")), "html", null, true);
        yield "\" required autofocus>
            </label>
            <label>
                Senha
                <input type=\"password\" name=\"password\" required>
            </label>
            <button type=\"submit\" class=\"btn btn-primary btn-block\">Entrar</button>
        </form>

        <p class=\"auth-switch\">Não tem conta? <a href=\"";
        // line 21
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/register"), "html", null, true);
        yield "\">Criar conta</a></p>
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
        return "auth/login.twig";
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
        return array (  82 => 21,  70 => 12,  64 => 9,  61 => 8,  55 => 6,  53 => 5,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"auth-wrap\">
    <div class=\"card\">
        <h1>Entrar</h1>

        {% if error %}
            <div class=\"alert alert-error\">{{ error }}</div>
        {% endif %}

        <form method=\"post\" action=\"{{ url(\x27/login\x27) }}\">
            <label>
                E-mail ou nome de usuário
                <input type=\"text\" name=\"login\" value=\"{{ identifier|default(\x27\x27) }}\" required autofocus>
            </label>
            <label>
                Senha
                <input type=\"password\" name=\"password\" required>
            </label>
            <button type=\"submit\" class=\"btn btn-primary btn-block\">Entrar</button>
        </form>

        <p class=\"auth-switch\">Não tem conta? <a href=\"{{ url(\x27/register\x27) }}\">Criar conta</a></p>
    </div>
</div>
", "auth/login.twig", "D:\\buglivreoficial\\app\\Views\\auth\\login.twig");
    }
}
