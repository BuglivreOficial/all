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

/* mangas/show.twig */
class __TwigTemplate_3ec09a95e479e572d465735b13453751 extends Template
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
        yield "<div id=\"manga-detail\">
    <p style=\"margin: 28px 0 0;\"><a class=\"see-all\" href=\"";
        // line 2
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\">← Voltar ao catálogo</a></p>
    <div class=\"empty\">
        <div class=\"big\">📖</div>
        <p>Carregando mangá…</p>
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
        return "mangas/show.twig";
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
        return array (  50 => 2,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div id=\"manga-detail\">
    <p style=\"margin: 28px 0 0;\"><a class=\"see-all\" href=\"{{ url(\x27/mangas\x27) }}\">← Voltar ao catálogo</a></p>
    <div class=\"empty\">
        <div class=\"big\">📖</div>
        <p>Carregando mangá…</p>
    </div>
</div>
", "mangas/show.twig", "D:\\buglivreoficial\\app\\Views\\mangas\\show.twig");
    }
}
