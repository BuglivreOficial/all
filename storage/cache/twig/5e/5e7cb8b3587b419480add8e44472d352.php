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

/* admin/authors/index.twig */
class __TwigTemplate_59c8bd2ad0f6f6b240998882ddbd5010 extends Template
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
    <h1>Autores</h1>
</div>

<div class=\"alert alert-error\" id=\"entity-alert\" hidden></div>

<section class=\"card\">
    <h2>Novo autor</h2>
    <form id=\"entity-create-form\">
        <div class=\"form-grid\">
            <div>
                <label>
                    Nome
                    <input type=\"text\" name=\"name\" maxlength=\"150\" required autofocus>
                </label>
            </div>
            <div>
                <label>
                    Biografia (opcional)
                    <textarea name=\"bio\" maxlength=\"3000\" placeholder=\"Breve biografia do autor.\"></textarea>
                </label>
            </div>
        </div>
        <button type=\"submit\">Criar autor</button>
    </form>
</section>

<section class=\"card\">
    <h2>Autores cadastrados</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Slug</th>
                <th>Biografia</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id=\"entity-table-body\">
            <tr><td colspan=\"6\" class=\"muted\">Carregando autores…</td></tr>
        </tbody>
    </table>
</section>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/authors/index.twig";
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
    <h1>Autores</h1>
</div>

<div class=\"alert alert-error\" id=\"entity-alert\" hidden></div>

<section class=\"card\">
    <h2>Novo autor</h2>
    <form id=\"entity-create-form\">
        <div class=\"form-grid\">
            <div>
                <label>
                    Nome
                    <input type=\"text\" name=\"name\" maxlength=\"150\" required autofocus>
                </label>
            </div>
            <div>
                <label>
                    Biografia (opcional)
                    <textarea name=\"bio\" maxlength=\"3000\" placeholder=\"Breve biografia do autor.\"></textarea>
                </label>
            </div>
        </div>
        <button type=\"submit\">Criar autor</button>
    </form>
</section>

<section class=\"card\">
    <h2>Autores cadastrados</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Slug</th>
                <th>Biografia</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id=\"entity-table-body\">
            <tr><td colspan=\"6\" class=\"muted\">Carregando autores…</td></tr>
        </tbody>
    </table>
</section>
", "admin/authors/index.twig", "D:\\buglivreoficial\\app\\Views\\admin\\authors\\index.twig");
    }
}
