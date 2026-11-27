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

        <div class=\"alert alert-error\" id=\"login-alert\" hidden></div>
        <div class=\"alert alert-success\" id=\"login-success\" hidden></div>

        <form id=\"login-form\" novalidate>
            <label>
                E-mail ou nome de usuário
                <input type=\"text\" name=\"login\" required autofocus autocomplete=\"username\">
            </label>
            <label>
                Senha
                <input type=\"password\" name=\"password\" required autocomplete=\"current-password\">
            </label>
            <button type=\"submit\" class=\"btn btn-primary btn-block\" data-loading-text=\"Entrando…\">Entrar</button>
        </form>

        <p class=\"auth-switch\"><a href=\"";
        // line 20
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/forgot-password"), "html", null, true);
        yield "\">Esqueci minha senha</a></p>
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
        return array (  72 => 21,  68 => 20,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"auth-wrap\">
    <div class=\"card\">
        <h1>Entrar</h1>

        <div class=\"alert alert-error\" id=\"login-alert\" hidden></div>
        <div class=\"alert alert-success\" id=\"login-success\" hidden></div>

        <form id=\"login-form\" novalidate>
            <label>
                E-mail ou nome de usuário
                <input type=\"text\" name=\"login\" required autofocus autocomplete=\"username\">
            </label>
            <label>
                Senha
                <input type=\"password\" name=\"password\" required autocomplete=\"current-password\">
            </label>
            <button type=\"submit\" class=\"btn btn-primary btn-block\" data-loading-text=\"Entrando…\">Entrar</button>
        </form>

        <p class=\"auth-switch\"><a href=\"{{ url(\x27/forgot-password\x27) }}\">Esqueci minha senha</a></p>
        <p class=\"auth-switch\">Não tem conta? <a href=\"{{ url(\x27/register\x27) }}\">Criar conta</a></p>
    </div>
</div>
", "auth/login.twig", "D:\\buglivreoficial\\app\\Views\\auth\\login.twig");
    }
}
