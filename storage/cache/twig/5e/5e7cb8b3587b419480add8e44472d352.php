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
    <h1>Autores</h1>
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
    <h2>Novo autor</h2>
    <form method=\"post\" action=\"";
        // line 11
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/authors"), "html", null, true);
        yield "\">
        <div class=\"form-grid\">
            <div>
                <label>
                    Nome
                    <input type=\"text\" name=\"name\" maxlength=\"150\" value=\"";
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
                    Biografia (opcional)
                    <textarea name=\"bio\" maxlength=\"3000\" placeholder=\"Breve biografia do autor.\">";
        // line 25
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "bio", [], "any", true, true, false, 25)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "bio", [], "any", false, false, false, 25), "")) : ("")), "html", null, true);
        yield "</textarea>
                </label>
                ";
        // line 27
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "bio", [], "any", true, true, false, 27) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "bio", [], "any", false, false, false, 27))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 28
            yield "                    <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "bio", [], "any", false, false, false, 28)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[0] ?? null) : null), "html", null, true);
            yield "</div>
                ";
        }
        // line 30
        yield "            </div>
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
        <tbody>
            ";
        // line 51
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["authors"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["author"]) {
            // line 52
            yield "                <tr>
                    <td>";
            // line 53
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["author"], "id", [], "any", false, false, false, 53), "html", null, true);
            yield "</td>
                    <td>";
            // line 54
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["author"], "name", [], "any", false, false, false, 54), "html", null, true);
            yield "</td>
                    <td class=\"muted\">";
            // line 55
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["author"], "slug", [], "any", false, false, false, 55), "html", null, true);
            yield "</td>
                    <td class=\"muted\">";
            // line 56
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->excerpt(CoreExtension::getAttribute($this->env, $this->source, $context["author"], "bio", [], "any", false, false, false, 56), 80), "html", null, true);
            yield "</td>
                    <td>
                        <span class=\"badge ";
            // line 58
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["author"], "is_active", [], "any", false, false, false, 58)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : ("badge-off"));
            yield "\">
                            ";
            // line 59
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["author"], "is_active", [], "any", false, false, false, 59)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Ativo") : ("Inativo"));
            yield "
                        </span>
                    </td>
                    <td>
                        <div class=\"actions\">
                            <a class=\"btn-link\" href=\"";
            // line 64
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url((("/admin/authors/" . CoreExtension::getAttribute($this->env, $this->source, $context["author"], "id", [], "any", false, false, false, 64)) . "/edit")), "html", null, true);
            yield "\">Editar</a>

                            <form method=\"post\" action=\"";
            // line 66
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url((("/admin/authors/" . CoreExtension::getAttribute($this->env, $this->source, $context["author"], "id", [], "any", false, false, false, 66)) . "/status")), "html", null, true);
            yield "\">
                                <button type=\"submit\" class=\"btn-muted btn-sm\">
                                    ";
            // line 68
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["author"], "is_active", [], "any", false, false, false, 68)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Desativar") : ("Ativar"));
            yield "
                                </button>
                            </form>

                            <form method=\"post\" action=\"";
            // line 72
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url((("/admin/authors/" . CoreExtension::getAttribute($this->env, $this->source, $context["author"], "id", [], "any", false, false, false, 72)) . "/delete")), "html", null, true);
            yield "\"
                                  onsubmit=\"return confirm(\x27Excluir o autor &quot;";
            // line 73
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["author"], "name", [], "any", false, false, false, 73), "html", null, true);
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
            yield "                <tr><td colspan=\"6\" class=\"muted\">Nenhum autor cadastrado.</td></tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['author'], $context['_parent'], $context['_iterated']);
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
        return "admin/authors/index.twig";
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
        return new Source("<div class=\"page-head\">
    <h1>Autores</h1>
</div>

{% if error %}<div class=\"alert alert-error\">{{ error }}</div>{% endif %}
{% if success %}<div class=\"alert alert-success\">{{ success }}</div>{% endif %}
{% if errors is not empty %}<div class=\"alert alert-error\">Corrija os campos destacados abaixo.</div>{% endif %}

<section class=\"card\">
    <h2>Novo autor</h2>
    <form method=\"post\" action=\"{{ url(\x27/admin/authors\x27) }}\">
        <div class=\"form-grid\">
            <div>
                <label>
                    Nome
                    <input type=\"text\" name=\"name\" maxlength=\"150\" value=\"{{ old.name|default(\x27\x27) }}\" required autofocus>
                </label>
                {% if errors.name is defined and errors.name|length %}
                    <div class=\"field-error\">{{ errors.name[0] }}</div>
                {% endif %}
            </div>
            <div>
                <label>
                    Biografia (opcional)
                    <textarea name=\"bio\" maxlength=\"3000\" placeholder=\"Breve biografia do autor.\">{{ old.bio|default(\x27\x27) }}</textarea>
                </label>
                {% if errors.bio is defined and errors.bio|length %}
                    <div class=\"field-error\">{{ errors.bio[0] }}</div>
                {% endif %}
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
        <tbody>
            {% for author in authors %}
                <tr>
                    <td>{{ author.id }}</td>
                    <td>{{ author.name }}</td>
                    <td class=\"muted\">{{ author.slug }}</td>
                    <td class=\"muted\">{{ author.bio|excerpt(80) }}</td>
                    <td>
                        <span class=\"badge {{ author.is_active ? \x27\x27 : \x27badge-off\x27 }}\">
                            {{ author.is_active ? \x27Ativo\x27 : \x27Inativo\x27 }}
                        </span>
                    </td>
                    <td>
                        <div class=\"actions\">
                            <a class=\"btn-link\" href=\"{{ url(\x27/admin/authors/\x27 ~ author.id ~ \x27/edit\x27) }}\">Editar</a>

                            <form method=\"post\" action=\"{{ url(\x27/admin/authors/\x27 ~ author.id ~ \x27/status\x27) }}\">
                                <button type=\"submit\" class=\"btn-muted btn-sm\">
                                    {{ author.is_active ? \x27Desativar\x27 : \x27Ativar\x27 }}
                                </button>
                            </form>

                            <form method=\"post\" action=\"{{ url(\x27/admin/authors/\x27 ~ author.id ~ \x27/delete\x27) }}\"
                                  onsubmit=\"return confirm(\x27Excluir o autor &quot;{{ author.name }}&quot;? Esta ação não pode ser desfeita.\x27);\">
                                <button type=\"submit\" class=\"btn-danger btn-sm\">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            {% else %}
                <tr><td colspan=\"6\" class=\"muted\">Nenhum autor cadastrado.</td></tr>
            {% endfor %}
        </tbody>
    </table>
</section>
", "admin/authors/index.twig", "D:\\buglivreoficial\\app\\Views\\admin\\authors\\index.twig");
    }
}
