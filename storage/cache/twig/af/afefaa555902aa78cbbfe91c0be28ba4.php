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
class __TwigTemplate_afd3fa3a5cc27b4a5c18cd3dd1225252 extends Template
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
    <h1>Catálogo de mangás</h1>
    <span class=\"muted\">";
        // line 3
        yield (string) $this->escaper->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["mangas"] ?? null)), "html", null, true);
        yield " título(s)</span>
</div>

<section class=\"card\">
    <form class=\"filters\" method=\"get\" action=\"";
        // line 7
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\">
        <label>
            Buscar
            <input type=\"search\" name=\"q\" value=\"";
        // line 10
        yield (string) $this->escaper->escape(($context["search"] ?? null), "html", null, true);
        yield "\" placeholder=\"Título ou autor\">
        </label>
        <label>
            Categoria
            <select name=\"category\">
                <option value=\"\">Todas</option>
                ";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 17
            yield "                    <option value=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 17), "html", null, true);
            yield "\" ";
            yield (string) (((($context["categoryId"] ?? null) == CoreExtension::getAttribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 17))) ? ("selected") : (""));
            yield ">";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 17), "html", null, true);
            yield "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['category'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 19
        yield "            </select>
        </label>
        <label>
            Tipo
            <select name=\"type\">
                <option value=\"\">Todos</option>
                ";
        // line 25
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["types"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
            // line 26
            yield "                    <option value=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 26), "html", null, true);
            yield "\" ";
            yield (string) (((($context["typeId"] ?? null) == CoreExtension::getAttribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 26))) ? ("selected") : (""));
            yield ">";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "name", [], "any", false, false, false, 26), "html", null, true);
            yield "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['type'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 28
        yield "            </select>
        </label>
        <div>
            <button type=\"submit\" class=\"btn btn-primary\">Filtrar</button>
        </div>
    </form>
</section>

<section class=\"section\">
    ";
        // line 37
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["mangas"] ?? null))) {
            // line 38
            yield "        <div class=\"grid-mangas\">
            ";
            // line 39
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["mangas"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["manga"]) {
                // line 40
                yield "                ";
                yield from $this->load("partials/manga-card.twig", 40)->unwrap()->yield(CoreExtension::toArray(["manga" => $context["manga"]]));
                // line 41
                yield "            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['manga'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 42
            yield "        </div>
    ";
        } else {
            // line 44
            yield "        <div class=\"empty\">
            <div class=\"big\">🔍</div>
            <p>Nenhum mangá encontrado com esses filtros.</p>
            <p><a class=\"see-all\" href=\"";
            // line 47
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
            yield "\">Limpar filtros</a></p>
        </div>
    ";
        }
        // line 50
        yield "</section>
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
        return array (  162 => 50,  156 => 47,  151 => 44,  147 => 42,  140 => 41,  137 => 40,  133 => 39,  130 => 38,  128 => 37,  117 => 28,  103 => 26,  99 => 25,  91 => 19,  77 => 17,  73 => 16,  64 => 10,  58 => 7,  51 => 3,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "mangas/index.twig", "D:\\buglivreoficial\\app\\Views\\mangas\\index.twig");
    }
}
