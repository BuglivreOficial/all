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

/* admin/types/index.twig */
class __TwigTemplate_26d67dc052bee0834770635b8d90255c extends Template
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
    <h1>Tipos de mangá</h1>
</div>

<div class=\"alert alert-error\" id=\"entity-alert\" hidden></div>

<section class=\"card\">
    <h2>Novo tipo</h2>
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
                    <textarea name=\"description\" maxlength=\"1000\" placeholder=\"Breve descrição do tipo.\"></textarea>
                </label>
            </div>
        </div>
        <button type=\"submit\">Criar tipo</button>
    </form>
</section>

<section class=\"card\">
    <h2>Tipos cadastrados</h2>

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
            <tr><td colspan=\"6\" class=\"muted\">Carregando tipos…</td></tr>
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
        return "admin/types/index.twig";
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
    <h1>Tipos de mangá</h1>
</div>

<div class=\"alert alert-error\" id=\"entity-alert\" hidden></div>

<section class=\"card\">
    <h2>Novo tipo</h2>
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
                    <textarea name=\"description\" maxlength=\"1000\" placeholder=\"Breve descrição do tipo.\"></textarea>
                </label>
            </div>
        </div>
        <button type=\"submit\">Criar tipo</button>
    </form>
</section>

<section class=\"card\">
    <h2>Tipos cadastrados</h2>

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
            <tr><td colspan=\"6\" class=\"muted\">Carregando tipos…</td></tr>
        </tbody>
    </table>
</section>
", "admin/types/index.twig", "D:\\buglivreoficial\\app\\Views\\admin\\types\\index.twig");
    }
}
