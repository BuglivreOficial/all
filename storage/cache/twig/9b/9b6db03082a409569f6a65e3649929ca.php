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

/* auth/reset.twig */
class __TwigTemplate_76a9712117148f98c85b80d8e8d5920a extends Template
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
        <h1>Redefinir senha</h1>

        <div class=\"alert alert-error\" id=\"reset-alert\" hidden></div>

        <form id=\"reset-form\" novalidate>
            <label>
                Nova senha
                <input type=\"password\" name=\"password\" required autofocus autocomplete=\"new-password\">
            </label>

            <label>
                Confirmar nova senha
                <input type=\"password\" name=\"password_confirmation\" required autocomplete=\"new-password\">
            </label>

            <button type=\"submit\" class=\"btn btn-primary btn-block\" data-loading-text=\"Salvando…\">Redefinir senha</button>
        </form>

        <p class=\"auth-switch\"><a href=\"";
        // line 21
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/login"), "html", null, true);
        yield "\">Voltar para o login</a></p>
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
        return "auth/reset.twig";
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
        return array (  69 => 21,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"auth-wrap\">
    <div class=\"card\">
        <h1>Redefinir senha</h1>

        <div class=\"alert alert-error\" id=\"reset-alert\" hidden></div>

        <form id=\"reset-form\" novalidate>
            <label>
                Nova senha
                <input type=\"password\" name=\"password\" required autofocus autocomplete=\"new-password\">
            </label>

            <label>
                Confirmar nova senha
                <input type=\"password\" name=\"password_confirmation\" required autocomplete=\"new-password\">
            </label>

            <button type=\"submit\" class=\"btn btn-primary btn-block\" data-loading-text=\"Salvando…\">Redefinir senha</button>
        </form>

        <p class=\"auth-switch\"><a href=\"{{ url(\x27/login\x27) }}\">Voltar para o login</a></p>
    </div>
</div>
", "auth/reset.twig", "D:\\buglivreoficial\\app\\Views\\auth\\reset.twig");
    }
}
