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

/* partials/manga-card.twig */
class __TwigTemplate_d26abac5eee9696c739c3afbed9deca3 extends Template
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
        $context["meta"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["manga_statuses"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 1), [], "array", true, true, false, 1)) ? (Twig\Extension\CoreExtension::default((($_v0 = ($context["manga_statuses"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[(($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 1)) instanceof \Stringable && (is_array($_v0) || $_v0 instanceof \ArrayObject || $_v0 instanceof \ArrayIterator) ? (string) $_v1 : $_v1)] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 1))) : (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 1)));
        // line 2
        yield "<article class=\"manga-card\">
    <a class=\"cover\" href=\"";
        // line 3
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url(("/mangas/" . CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "slug", [], "any", false, false, false, 3))), "html", null, true);
        yield "\">
        ";
        // line 4
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "cover", [], "any", false, false, false, 4)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 5
            yield "            <img src=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "cover", [], "any", false, false, false, 5), "html", null, true);
            yield "\" alt=\"Capa de ";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "title", [], "any", false, false, false, 5), "html", null, true);
            yield "\" loading=\"lazy\">
        ";
        } else {
            // line 7
            yield "            <div class=\"cover-ph\">";
            yield (string) $this->escaper->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "title", [], "any", false, false, false, 7), 0, 1), "html", null, true);
            yield "</div>
        ";
        }
        // line 9
        yield "        ";
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "type_name", [], "any", false, false, false, 9)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 10
            yield "            <span class=\"type-tag\">";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "type_name", [], "any", false, false, false, 10), "html", null, true);
            yield "</span>
        ";
        }
        // line 12
        yield "    </a>
    <div class=\"card-body\">
        <a class=\"card-title\" href=\"";
        // line 14
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url(("/mangas/" . CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "slug", [], "any", false, false, false, 14))), "html", null, true);
        yield "\">";
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "title", [], "any", false, false, false, 14), "html", null, true);
        yield "</a>
        <div class=\"card-meta\">
            <span class=\"badge badge-";
        // line 16
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 16), "html", null, true);
        yield "\">";
        yield (string) $this->escaper->escape(($context["meta"] ?? null), "html", null, true);
        yield "</span>
            ";
        // line 17
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "author_name", [], "any", false, false, false, 17)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<span>";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "author_name", [], "any", false, false, false, 17), "html", null, true);
            yield "</span>";
        }
        // line 18
        yield "        </div>
    </div>
</article>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "partials/manga-card.twig";
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
        return array (  104 => 18,  98 => 17,  92 => 16,  85 => 14,  81 => 12,  75 => 10,  72 => 9,  66 => 7,  58 => 5,  56 => 4,  52 => 3,  49 => 2,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% set meta = manga_statuses[manga.status]|default(manga.status) %}
<article class=\"manga-card\">
    <a class=\"cover\" href=\"{{ url(\x27/mangas/\x27 ~ manga.slug) }}\">
        {% if manga.cover %}
            <img src=\"{{ manga.cover }}\" alt=\"Capa de {{ manga.title }}\" loading=\"lazy\">
        {% else %}
            <div class=\"cover-ph\">{{ manga.title|slice(0, 1) }}</div>
        {% endif %}
        {% if manga.type_name %}
            <span class=\"type-tag\">{{ manga.type_name }}</span>
        {% endif %}
    </a>
    <div class=\"card-body\">
        <a class=\"card-title\" href=\"{{ url(\x27/mangas/\x27 ~ manga.slug) }}\">{{ manga.title }}</a>
        <div class=\"card-meta\">
            <span class=\"badge badge-{{ manga.status }}\">{{ meta }}</span>
            {% if manga.author_name %}<span>{{ manga.author_name }}</span>{% endif %}
        </div>
    </div>
</article>
", "partials/manga-card.twig", "D:\\buglivreoficial\\app\\Views\\partials\\manga-card.twig");
    }
}
