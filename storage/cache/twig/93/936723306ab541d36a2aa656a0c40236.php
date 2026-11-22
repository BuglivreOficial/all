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
class __TwigTemplate_d41bad14b3627dadde0a8673699603d9 extends Template
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

";
        // line 6
        if ((($tmp = ($context["error"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"alert alert-error\">";
            yield (string) $this->escaper->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>";
        }
        // line 7
        if ((($tmp = ($context["success"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"alert alert-success\">";
            yield (string) $this->escaper->escape(($context["success"] ?? null), "html", null, true);
            yield "</div>";
        }
        // line 8
        yield "
<section class=\"card\">
    <form method=\"get\" action=\"";
        // line 10
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/mangas"), "html", null, true);
        yield "\" class=\"form-grid\">
        <div>
            <label>
                Buscar (título ou autor)
                <input type=\"text\" name=\"q\" value=\"";
        // line 14
        yield (string) $this->escaper->escape(($context["search"] ?? null), "html", null, true);
        yield "\" placeholder=\"Digite para filtrar...\">
            </label>
        </div>
        <div>
            <label>
                Categoria
                <select name=\"category\">
                    <option value=\"\">Todas</option>
                    ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 23
            yield "                        <option value=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 23), "html", null, true);
            yield "\" ";
            yield (string) (((($context["categoryId"] ?? null) == CoreExtension::getAttribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 23))) ? ("selected") : (""));
            yield ">
                            ";
            // line 24
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 24), "html", null, true);
            yield "
                        </option>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['category'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 27
        yield "                </select>
            </label>
        </div>
        <div>
            <label>
                Tipo
                <select name=\"type\">
                    <option value=\"\">Todos</option>
                    ";
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["types"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
            // line 36
            yield "                        <option value=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 36), "html", null, true);
            yield "\" ";
            yield (string) (((($context["typeId"] ?? null) == CoreExtension::getAttribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 36))) ? ("selected") : (""));
            yield ">
                            ";
            // line 37
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "name", [], "any", false, false, false, 37), "html", null, true);
            yield "
                        </option>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['type'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 40
        yield "                </select>
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
        <tbody>
            ";
        // line 65
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["mangas"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["manga"]) {
            // line 66
            yield "                <tr>
                    <td>";
            // line 67
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "id", [], "any", false, false, false, 67), "html", null, true);
            yield "</td>
                    <td>
                        ";
            // line 69
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "cover", [], "any", false, false, false, 69)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 70
                yield "                            <img src=\"";
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "cover", [], "any", false, false, false, 70), "html", null, true);
                yield "\" alt=\"\" class=\"thumb\" loading=\"lazy\">
                        ";
            } else {
                // line 72
                yield "                            <span class=\"muted\">—</span>
                        ";
            }
            // line 74
            yield "                    </td>
                    <td>
                        ";
            // line 76
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "title", [], "any", false, false, false, 76), "html", null, true);
            yield "
                        <div class=\"muted\" style=\"font-size: 12px;\">";
            // line 77
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "slug", [], "any", false, false, false, 77), "html", null, true);
            yield "</div>
                    </td>
                    <td>
                        ";
            // line 80
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "type_name", [], "any", false, false, false, 80)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 81
                yield "                            <span class=\"badge\">";
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "type_name", [], "any", false, false, false, 81), "html", null, true);
                yield "</span>
                        ";
            } else {
                // line 83
                yield "                            <span class=\"muted\">—</span>
                        ";
            }
            // line 85
            yield "                    </td>
                    <td>
                        ";
            // line 87
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "categoryLabel", [], "method", false, false, false, 87)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "categoryLabel", [], "method", false, false, false, 87), "html", null, true)) : ("—"));
            yield "
                    </td>
                    <td class=\"muted\">";
            // line 89
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "author_name", [], "any", false, false, false, 89)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "author_name", [], "any", false, false, false, 89), "html", null, true)) : ("—"));
            yield "</td>
                    <td><span class=\"badge badge-";
            // line 90
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "status", [], "any", false, false, false, 90), "html", null, true);
            yield "\">";
            yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["manga_statuses"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "status", [], "any", false, false, false, 90), [], "array", true, true, false, 90)) ? (Twig\Extension\CoreExtension::default((($_v0 = ($context["manga_statuses"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[(($_v1 = CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "status", [], "any", false, false, false, 90)) instanceof \Stringable && (is_array($_v0) || $_v0 instanceof \ArrayObject || $_v0 instanceof \ArrayIterator) ? (string) $_v1 : $_v1)] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "status", [], "any", false, false, false, 90))) : (CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "status", [], "any", false, false, false, 90))), "html", null, true);
            yield "</span></td>
                    <td>
                        <span class=\"badge ";
            // line 92
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "is_active", [], "any", false, false, false, 92)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : ("badge-off"));
            yield "\">
                            ";
            // line 93
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "is_active", [], "any", false, false, false, 93)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Ativo") : ("Inativo"));
            yield "
                        </span>
                    </td>
                    <td>
                        <div class=\"actions\">
                            <a class=\"btn-link\" href=\"";
            // line 98
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url((("/admin/mangas/" . CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "id", [], "any", false, false, false, 98)) . "/edit")), "html", null, true);
            yield "\">Editar</a>

                            <form method=\"post\" action=\"";
            // line 100
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url((("/admin/mangas/" . CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "id", [], "any", false, false, false, 100)) . "/status")), "html", null, true);
            yield "\">
                                <button type=\"submit\" class=\"btn-muted btn-sm\">
                                    ";
            // line 102
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "is_active", [], "any", false, false, false, 102)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Desativar") : ("Ativar"));
            yield "
                                </button>
                            </form>

                            <form method=\"post\" action=\"";
            // line 106
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url((("/admin/mangas/" . CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "id", [], "any", false, false, false, 106)) . "/delete")), "html", null, true);
            yield "\"
                                  onsubmit=\"return confirm(\x27Excluir o mangá &quot;";
            // line 107
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["manga"], "title", [], "any", false, false, false, 107), "html", null, true);
            yield "&quot;? Esta ação não pode ser desfeita.\x27);\">
                                <button type=\"submit\" class=\"btn-danger btn-sm\">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            ";
            $context['_iterated'] = true;
        }
        // line 113
        if (!$context['_iterated']) {
            // line 114
            yield "                <tr><td colspan=\"9\" class=\"muted\">Nenhum mangá encontrado.</td></tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['manga'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 116
        yield "        </tbody>
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
        return array (  295 => 116,  287 => 114,  285 => 113,  274 => 107,  270 => 106,  263 => 102,  258 => 100,  253 => 98,  245 => 93,  241 => 92,  234 => 90,  230 => 89,  225 => 87,  221 => 85,  217 => 83,  211 => 81,  209 => 80,  203 => 77,  199 => 76,  195 => 74,  191 => 72,  185 => 70,  183 => 69,  178 => 67,  175 => 66,  170 => 65,  143 => 40,  133 => 37,  126 => 36,  122 => 35,  112 => 27,  102 => 24,  95 => 23,  91 => 22,  80 => 14,  73 => 10,  69 => 8,  63 => 7,  57 => 6,  51 => 3,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/mangas/index.twig", "D:\\buglivreoficial\\app\\Views\\admin\\mangas\\index.twig");
    }
}
