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

/* admin/mangas/index.twig */
class __TwigTemplate_d528c0aac94aca9af8a56010f7dfbc58 extends Template
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
        yield "<div class=\"page-head\">
    <h1>Mangás</h1>
    <a class=\"btn btn-primary\" href=\"";
        // line 3
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/mangas/create"), "html", null, true);
        yield "\">+ Novo mangá</a>
</div>

<div class=\"alert alert-error\" id=\"manga-alert\" hidden></div>

<section class=\"card\">
    <form method=\"get\" id=\"manga-filters\" class=\"form-grid\">
        <div>
            <label>
                Buscar (título ou autor)
                <input type=\"text\" name=\"q\" placeholder=\"Digite para filtrar...\">
            </label>
        </div>
        <div>
            <label>
                Categoria
                <select name=\"category\">
                    <option value=\"\">Todas</option>
                </select>
            </label>
        </div>
        <div>
            <label>
                Tipo
                <select name=\"type\">
                    <option value=\"\">Todos</option>
                </select>
            </label>
        </div>
        <div>
            <button type=\"submit\">Filtrar</button>
        </div>
    </form>
</section>

<section class=\"card\">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Capa</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Categoria</th>
                <th>Autor</th>
                <th>Status</th>
                <th>Situação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id=\"manga-table-body\">
            <tr><td colspan=\"9\" class=\"muted\">Carregando mangás…</td></tr>
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
        return "admin/mangas/index.twig";
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
        return array (  51 => 3,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"page-head\">
    <h1>Mangás</h1>
    <a class=\"btn btn-primary\" href=\"{{ url(\x27/admin/mangas/create\x27) }}\">+ Novo mangá</a>
</div>

<div class=\"alert alert-error\" id=\"manga-alert\" hidden></div>

<section class=\"card\">
    <form method=\"get\" id=\"manga-filters\" class=\"form-grid\">
        <div>
            <label>
                Buscar (título ou autor)
                <input type=\"text\" name=\"q\" placeholder=\"Digite para filtrar...\">
            </label>
        </div>
        <div>
            <label>
                Categoria
                <select name=\"category\">
                    <option value=\"\">Todas</option>
                </select>
            </label>
        </div>
        <div>
            <label>
                Tipo
                <select name=\"type\">
                    <option value=\"\">Todos</option>
                </select>
            </label>
        </div>
        <div>
            <button type=\"submit\">Filtrar</button>
        </div>
    </form>
</section>

<section class=\"card\">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Capa</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Categoria</th>
                <th>Autor</th>
                <th>Status</th>
                <th>Situação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id=\"manga-table-body\">
            <tr><td colspan=\"9\" class=\"muted\">Carregando mangás…</td></tr>
        </tbody>
    </table>
</section>
", "admin/mangas/index.twig", "D:\\buglivreoficial\\app\\Views\\admin\\mangas\\index.twig");
    }
}
