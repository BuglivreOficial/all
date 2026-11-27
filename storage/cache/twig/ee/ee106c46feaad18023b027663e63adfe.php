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

/* auth/forgot.twig */
class __TwigTemplate_be288fdc97ce3fd7cbf679182cbf3ad1 extends Template
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
        <h1>Recuperar senha</h1>
        <p class=\"muted\">Informe o e-mail da sua conta e enviaremos um link para redefinir a senha.</p>

        <div class=\"alert alert-error\" id=\"forgot-alert\" hidden></div>
        <div class=\"alert alert-success\" id=\"forgot-success\" hidden></div>

        <form id=\"forgot-form\" novalidate>
            <label>
                E-mail
                <input type=\"email\" name=\"email\" required autofocus autocomplete=\"email\">
            </label>
            <button type=\"submit\" class=\"btn btn-primary btn-block\" data-loading-text=\"Enviando…\">Enviar link</button>
        </form>

        <p class=\"auth-switch\">Lembrou a senha? <a href=\"";
        // line 17
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
        return "auth/forgot.twig";
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
        return array (  65 => 17,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"auth-wrap\">
    <div class=\"card\">
        <h1>Recuperar senha</h1>
        <p class=\"muted\">Informe o e-mail da sua conta e enviaremos um link para redefinir a senha.</p>

        <div class=\"alert alert-error\" id=\"forgot-alert\" hidden></div>
        <div class=\"alert alert-success\" id=\"forgot-success\" hidden></div>

        <form id=\"forgot-form\" novalidate>
            <label>
                E-mail
                <input type=\"email\" name=\"email\" required autofocus autocomplete=\"email\">
            </label>
            <button type=\"submit\" class=\"btn btn-primary btn-block\" data-loading-text=\"Enviando…\">Enviar link</button>
        </form>

        <p class=\"auth-switch\">Lembrou a senha? <a href=\"{{ url(\x27/login\x27) }}\">Entrar</a></p>
    </div>
</div>
", "auth/forgot.twig", "D:\\buglivreoficial\\app\\Views\\auth\\forgot.twig");
    }
}
