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
class __TwigTemplate_b74455169f7d17e59e5bef57e0d2e46c extends Template
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
        yield "<p style=\"margin: 28px 0 0;\"><a class=\"see-all\" href=\"";
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\">← Voltar ao catálogo</a></p>

<div class=\"detail\">
    <div class=\"detail-cover\">
        <div class=\"cover\">
            ";
        // line 6
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "cover", [], "any", false, false, false, 6)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 7
            yield "                <img src=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "cover", [], "any", false, false, false, 7), "html", null, true);
            yield "\" alt=\"Capa de ";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "title", [], "any", false, false, false, 7), "html", null, true);
            yield "\">
            ";
        } else {
            // line 9
            yield "                <div class=\"cover-ph\">";
            yield (string) $this->escaper->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "title", [], "any", false, false, false, 9), 0, 1), "html", null, true);
            yield "</div>
            ";
        }
        // line 11
        yield "        </div>
    </div>

    <div>
        <h1>";
        // line 15
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "title", [], "any", false, false, false, 15), "html", null, true);
        yield "</h1>
        <p class=\"byline\">
            ";
        // line 17
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "type_name", [], "any", false, false, false, 17), "html", null, true);
        yield "
            ";
        // line 18
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "author_name", [], "any", false, false, false, 18)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " · ";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "author_name", [], "any", false, false, false, 18), "html", null, true);
        }
        // line 19
        yield "        </p>

        <div class=\"detail-tags\">
            <span class=\"badge badge-";
        // line 22
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 22), "html", null, true);
        yield "\">";
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["manga_statuses"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 22), [], "array", true, true, false, 22)) ? (Twig\Extension\CoreExtension::default((($_v0 = ($context["manga_statuses"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[(($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 22)) instanceof \Stringable && (is_array($_v0) || $_v0 instanceof \ArrayObject || $_v0 instanceof \ArrayIterator) ? (string) $_v1 : $_v1)] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 22))) : (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 22))), "html", null, true);
        yield "</span>
            ";
        // line 23
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "categories", [], "any", false, false, false, 23));
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 24
            yield "                <a class=\"chip\" href=\"";
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
            yield "?category=";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 24), "html", null, true);
            yield "\">";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 24), "html", null, true);
            yield "</a>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['category'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 26
        yield "        </div>

        <dl>
            <dt>Tipo</dt><dd>";
        // line 29
        yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "type_name", [], "any", false, false, false, 29)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "type_name", [], "any", false, false, false, 29), "html", null, true)) : ("—"));
        yield "</dd>
            <dt>Autor</dt><dd>";
        // line 30
        yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "author_name", [], "any", false, false, false, 30)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "author_name", [], "any", false, false, false, 30), "html", null, true)) : ("—"));
        yield "</dd>
            <dt>Status</dt><dd>";
        // line 31
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["manga_statuses"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 31), [], "array", true, true, false, 31)) ? (Twig\Extension\CoreExtension::default((($_v2 = ($context["manga_statuses"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[(($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 31)) instanceof \Stringable && (is_array($_v2) || $_v2 instanceof \ArrayObject || $_v2 instanceof \ArrayIterator) ? (string) $_v3 : $_v3)] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 31))) : (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 31))), "html", null, true);
        yield "</dd>
            <dt>Atualizado em</dt><dd>";
        // line 32
        yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "updated_at", [], "any", false, false, false, 32)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "updated_at", [], "any", false, false, false, 32), "html", null, true)) : ((((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "created_at", [], "any", false, false, false, 32)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "created_at", [], "any", false, false, false, 32), "html", null, true)) : ("—"))));
        yield "</dd>
        </dl>

        <h2 style=\"font-size: 18px;\">Sinopse</h2>
        <p class=\"synopsis\">";
        // line 36
        yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "description", [], "any", false, false, false, 36)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "description", [], "any", false, false, false, 36), "html", null, true)) : ("Sinopse ainda não disponível."));
        yield "</p>
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
        return array (  145 => 36,  138 => 32,  134 => 31,  130 => 30,  126 => 29,  121 => 26,  107 => 24,  103 => 23,  97 => 22,  92 => 19,  87 => 18,  83 => 17,  78 => 15,  72 => 11,  66 => 9,  58 => 7,  56 => 6,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "mangas/show.twig", "D:\\buglivreoficial\\app\\Views\\mangas\\show.twig");
    }
}
