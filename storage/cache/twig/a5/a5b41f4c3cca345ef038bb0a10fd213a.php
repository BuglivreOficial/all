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
class __TwigTemplate_b7513ea8ab29cdcf05c2f1c4dd5f98eb extends Template
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
    <h1>Tipos de mangá</h1>
</div>

";
        // line 5
        if ((($tmp = ($context["error"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"alert alert-error\">";
            yield (string) $this->escaper->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>";
        }
        // line 6
        if ((($tmp = ($context["success"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"alert alert-success\">";
            yield (string) $this->escaper->escape(($context["success"] ?? null), "html", null, true);
            yield "</div>";
        }
        // line 7
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["errors"] ?? null))) {
            yield "<div class=\"alert alert-error\">Corrija os campos destacados abaixo.</div>";
        }
        // line 8
        yield "
<section class=\"card\">
    <h2>Novo tipo</h2>
    <form method=\"post\" action=\"";
        // line 11
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/types"), "html", null, true);
        yield "\">
        <div class=\"form-grid\">
            <div>
                <label>
                    Nome
                    <input type=\"text\" name=\"name\" maxlength=\"120\" value=\"";
        // line 16
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "name", [], "any", true, true, false, 16)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "name", [], "any", false, false, false, 16), "")) : ("")), "html", null, true);
        yield "\" required autofocus>
                </label>
                ";
        // line 18
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "name", [], "any", true, true, false, 18) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "name", [], "any", false, false, false, 18))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 19
            yield "                    <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "name", [], "any", false, false, false, 19)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[0] ?? null) : null), "html", null, true);
            yield "</div>
                ";
        }
        // line 21
        yield "            </div>
            <div>
                <label>
                    Descrição (opcional)
                    <textarea name=\"description\" maxlength=\"1000\" placeholder=\"Breve descrição do tipo.\">";
        // line 25
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "description", [], "any", true, true, false, 25)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "description", [], "any", false, false, false, 25), "")) : ("")), "html", null, true);
        yield "</textarea>
                </label>
                ";
        // line 27
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "description", [], "any", true, true, false, 27) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "description", [], "any", false, false, false, 27))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 28
            yield "                    <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "description", [], "any", false, false, false, 28)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[0] ?? null) : null), "html", null, true);
            yield "</div>
                ";
        }
        // line 30
        yield "            </div>
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
        <tbody>
            ";
        // line 51
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["types"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
            // line 52
            yield "                <tr>
                    <td>";
            // line 53
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 53), "html", null, true);
            yield "</td>
                    <td>";
            // line 54
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "name", [], "any", false, false, false, 54), "html", null, true);
            yield "</td>
                    <td class=\"muted\">";
            // line 55
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "slug", [], "any", false, false, false, 55), "html", null, true);
            yield "</td>
                    <td class=\"muted\">";
            // line 56
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->excerpt(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "description", [], "any", false, false, false, 56), 80), "html", null, true);
            yield "</td>
                    <td>
                        <span class=\"badge ";
            // line 58
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["type"], "is_active", [], "any", false, false, false, 58)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : ("badge-off"));
            yield "\">
                            ";
            // line 59
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["type"], "is_active", [], "any", false, false, false, 59)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Ativo") : ("Inativo"));
            yield "
                        </span>
                    </td>
                    <td>
                        <div class=\"actions\">
                            <a class=\"btn-link\" href=\"";
            // line 64
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url((("/admin/types/" . CoreExtension::getAttribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 64)) . "/edit")), "html", null, true);
            yield "\">Editar</a>

                            <form method=\"post\" action=\"";
            // line 66
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url((("/admin/types/" . CoreExtension::getAttribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 66)) . "/status")), "html", null, true);
            yield "\">
                                <button type=\"submit\" class=\"btn-muted btn-sm\">
                                    ";
            // line 68
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["type"], "is_active", [], "any", false, false, false, 68)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Desativar") : ("Ativar"));
            yield "
                                </button>
                            </form>

                            <form method=\"post\" action=\"";
            // line 72
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url((("/admin/types/" . CoreExtension::getAttribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 72)) . "/delete")), "html", null, true);
            yield "\"
                                  onsubmit=\"return confirm(\x27Excluir o tipo &quot;";
            // line 73
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "name", [], "any", false, false, false, 73), "html", null, true);
            yield "&quot;? Esta ação não pode ser desfeita.\x27);\">
                                <button type=\"submit\" class=\"btn-danger btn-sm\">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            ";
            $context['_iterated'] = true;
        }
        // line 79
        if (!$context['_iterated']) {
            // line 80
            yield "                <tr><td colspan=\"6\" class=\"muted\">Nenhum tipo cadastrado.</td></tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['type'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 82
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
        return "admin/types/index.twig";
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
        return array (  216 => 82,  208 => 80,  206 => 79,  195 => 73,  191 => 72,  184 => 68,  179 => 66,  174 => 64,  166 => 59,  162 => 58,  157 => 56,  153 => 55,  149 => 54,  145 => 53,  142 => 52,  137 => 51,  114 => 30,  108 => 28,  106 => 27,  101 => 25,  95 => 21,  89 => 19,  87 => 18,  82 => 16,  74 => 11,  69 => 8,  65 => 7,  59 => 6,  53 => 5,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/types/index.twig", "D:\\buglivreoficial\\app\\Views\\admin\\types\\index.twig");
    }
}
