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

/* admin/categories/index.twig */
class __TwigTemplate_570134461b5212aef9b064c030e1dd93 extends Template
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
    <h1>Categorias de mangás</h1>
</div>

<div class=\"alert alert-error\" id=\"entity-alert\" hidden></div>

<section class=\"card\">
    <h2>Nova categoria</h2>
    <form id=\"entity-create-form\">
        <div class=\"form-grid\">
            <div>
                <label>
                    Nome
                    <input type=\"text\" name=\"name\" maxlength=\"120\" required autofocus>
                </label>
            </div>
            <div>
                <label>
                    Descrição (opcional)
                    <textarea name=\"description\" maxlength=\"1000\" placeholder=\"Breve descrição da categoria.\"></textarea>
                </label>
            </div>
        </div>
        <button type=\"submit\">Criar categoria</button>
    </form>
</section>

<section class=\"card\">
    <h2>Categorias cadastradas</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Slug</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id=\"entity-table-body\">
            <tr><td colspan=\"6\" class=\"muted\">Carregando categorias…</td></tr>
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
        return "admin/categories/index.twig";
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
    <h1>Categorias de mangás</h1>
</div>

<div class=\"alert alert-error\" id=\"entity-alert\" hidden></div>

<section class=\"card\">
    <h2>Nova categoria</h2>
    <form id=\"entity-create-form\">
        <div class=\"form-grid\">
            <div>
                <label>
                    Nome
                    <input type=\"text\" name=\"name\" maxlength=\"120\" required autofocus>
                </label>
            </div>
            <div>
                <label>
                    Descrição (opcional)
                    <textarea name=\"description\" maxlength=\"1000\" placeholder=\"Breve descrição da categoria.\"></textarea>
                </label>
            </div>
        </div>
        <button type=\"submit\">Criar categoria</button>
    </form>
</section>

<section class=\"card\">
    <h2>Categorias cadastradas</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Slug</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id=\"entity-table-body\">
            <tr><td colspan=\"6\" class=\"muted\">Carregando categorias…</td></tr>
        </tbody>
    </table>
</section>
", "admin/categories/index.twig", "D:\\buglivreoficial\\app\\Views\\admin\\categories\\index.twig");
    }
}
