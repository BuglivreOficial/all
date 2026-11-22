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

/* errors/error.twig */
class __TwigTemplate_d96848ca6ff2027887487a451f5833c8 extends Template
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
        yield "<section class=\"card\" style=\"max-width: 520px; margin: 56px auto; text-align: center;\">
    <h1 style=\"font-size: 44px; margin: 0 0 8px;\">";
        // line 2
        yield (string) $this->escaper->escape(((array_key_exists("status", $context)) ? (Twig\Extension\CoreExtension::default(($context["status"] ?? null), 500)) : (500)), "html", null, true);
        yield "</h1>
    <p class=\"muted\">";
        // line 3
        yield (string) $this->escaper->escape(((array_key_exists("message", $context)) ? (Twig\Extension\CoreExtension::default(($context["message"] ?? null), "Ocorreu um erro.")) : ("Ocorreu um erro.")), "html", null, true);
        yield "</p>
    <a class=\"btn btn-primary\" href=\"";
        // line 4
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/"), "html", null, true);
        yield "\">Voltar ao início</a>
</section>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "errors/error.twig";
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
        return array (  58 => 4,  54 => 3,  50 => 2,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<section class=\"card\" style=\"max-width: 520px; margin: 56px auto; text-align: center;\">
    <h1 style=\"font-size: 44px; margin: 0 0 8px;\">{{ status|default(500) }}</h1>
    <p class=\"muted\">{{ message|default(\x27Ocorreu um erro.\x27) }}</p>
    <a class=\"btn btn-primary\" href=\"{{ url(\x27/\x27) }}\">Voltar ao início</a>
</section>
", "errors/error.twig", "D:\\buglivreoficial\\app\\Views\\errors\\error.twig");
    }
}
