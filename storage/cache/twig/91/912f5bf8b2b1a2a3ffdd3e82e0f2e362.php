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
class __TwigTemplate_251d9a600750008bfc784a3a5214ff6f extends Template
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

        <div class=\"alert alert-error\" id=\"register-alert\" hidden></div>

        <form id=\"register-form\" novalidate>
            <label>
                Nome
                <input type=\"text\" name=\"name\" required autofocus autocomplete=\"name\">
            </label>

            <label>
                Nome de usuário
                <input type=\"text\" name=\"username\" required autocomplete=\"username\">
            </label>

            <label>
                E-mail
                <input type=\"email\" name=\"email\" required autocomplete=\"email\">
            </label>

            <label>
                Senha
                <input type=\"password\" name=\"password\" required autocomplete=\"new-password\">
            </label>

            <label>
                Confirmar senha
                <input type=\"password\" name=\"password_confirmation\" required autocomplete=\"new-password\">
            </label>

            <button type=\"submit\" class=\"btn btn-primary btn-block\" data-loading-text=\"Criando conta…\">Criar conta</button>
        </form>

        <p class=\"auth-switch\">Já tem conta? <a href=\"";
        // line 36
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
        return array (  84 => 36,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"auth-wrap\">
    <div class=\"card\">
        <h1>Criar conta</h1>

        <div class=\"alert alert-error\" id=\"register-alert\" hidden></div>

        <form id=\"register-form\" novalidate>
            <label>
                Nome
                <input type=\"text\" name=\"name\" required autofocus autocomplete=\"name\">
            </label>

            <label>
                Nome de usuário
                <input type=\"text\" name=\"username\" required autocomplete=\"username\">
            </label>

            <label>
                E-mail
                <input type=\"email\" name=\"email\" required autocomplete=\"email\">
            </label>

            <label>
                Senha
                <input type=\"password\" name=\"password\" required autocomplete=\"new-password\">
            </label>

            <label>
                Confirmar senha
                <input type=\"password\" name=\"password_confirmation\" required autocomplete=\"new-password\">
            </label>

            <button type=\"submit\" class=\"btn btn-primary btn-block\" data-loading-text=\"Criando conta…\">Criar conta</button>
        </form>

        <p class=\"auth-switch\">Já tem conta? <a href=\"{{ url(\x27/login\x27) }}\">Entrar</a></p>
    </div>
</div>
", "auth/register.twig", "D:\\buglivreoficial\\app\\Views\\auth\\register.twig");
    }
}
