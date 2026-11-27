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

/* mangas/index.twig */
class __TwigTemplate_fd3ff4b7bca0e0445dfc7fdb3c4c278c extends Template
{
    private Source $source;
    /**
     * @var array<string, MacroNamespace>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<div class=\"page-head\">
    <h1>Catálogo de mangás</h1>
    <span class=\"muted\" id=\"catalog-count\">Carregando…</span>
</div>

<section class=\"card\">
    <form class=\"filters\" id=\"catalog-filters\">
        <label>
            Buscar
            <input type=\"search\" name=\"q\" placeholder=\"Título ou autor\">
        </label>
        <label>
            Categoria
            <select name=\"category\">
                <option value=\"\">Todas</option>
            </select>
        </label>
        <label>
            Tipo
            <select name=\"type\">
                <option value=\"\">Todos</option>
            </select>
        </label>
        <div>
            <button type=\"submit\" class=\"btn btn-primary\">Filtrar</button>
        </div>
    </form>
</section>

<section class=\"section\">
    <div class=\"grid-mangas\" id=\"catalog-results\">
        <div class=\"empty\">
            <div class=\"big\">🔍</div>
            <p>Carregando catálogo…</p>
        </div>
    </div>
</section>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "mangas/index.twig";
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
        return array (  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"page-head\">
    <h1>Catálogo de mangás</h1>
    <span class=\"muted\" id=\"catalog-count\">Carregando…</span>
</div>

<section class=\"card\">
    <form class=\"filters\" id=\"catalog-filters\">
        <label>
            Buscar
            <input type=\"search\" name=\"q\" placeholder=\"Título ou autor\">
        </label>
        <label>
            Categoria
            <select name=\"category\">
                <option value=\"\">Todas</option>
            </select>
        </label>
        <label>
            Tipo
            <select name=\"type\">
                <option value=\"\">Todos</option>
            </select>
        </label>
        <div>
            <button type=\"submit\" class=\"btn btn-primary\">Filtrar</button>
        </div>
    </form>
</section>

<section class=\"section\">
    <div class=\"grid-mangas\" id=\"catalog-results\">
        <div class=\"empty\">
            <div class=\"big\">🔍</div>
            <p>Carregando catálogo…</p>
        </div>
    </div>
</section>
", "mangas/index.twig", "D:\\buglivreoficial\\app\\Views\\mangas\\index.twig");
    }
}
