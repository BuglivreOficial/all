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

/* home.twig */
class __TwigTemplate_53ad714330571affcf1da7fca50f6c91 extends Template
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
        yield "<section class=\"hero\">
    <h1>Descubra sua próxima <span class=\"accent\">obsessão</span> em mangás</h1>
    <p>Explore mangás, manhwas, manhuas, webtoons e muito mais. Atualizações constantes e uma coleção que cresce todos os dias.</p>
    <div class=\"hero-actions\">
        <a class=\"btn btn-primary\" href=\"";
        // line 5
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\">Explorar catálogo</a>
        ";
        // line 6
        if ( !(($tmp = ($context["logged"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 7
            yield "            <a class=\"btn btn-ghost\" href=\"";
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/register"), "html", null, true);
            yield "\">Criar conta grátis</a>
        ";
        } else {
            // line 9
            yield "            <a class=\"btn btn-ghost\" href=\"";
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/dashboard"), "html", null, true);
            yield "\">Minha conta</a>
        ";
        }
        // line 11
        yield "    </div>
</section>

";
        // line 14
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["categories"] ?? null))) {
            // line 15
            yield "<section class=\"section\">
    <div class=\"section-head\">
        <h2 class=\"section-title\">Categorias</h2>
        <a class=\"see-all\" href=\"";
            // line 18
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
            yield "\">Ver todas →</a>
    </div>
    <div class=\"chips\">
        ";
            // line 21
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["categories"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                // line 22
                yield "            <a class=\"chip\" href=\"";
                yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
                yield "?category=";
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 22), "html", null, true);
                yield "\">";
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 22), "html", null, true);
                yield "</a>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['category'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 24
            yield "    </div>
</section>
";
        }
        // line 27
        yield "
<section class=\"section\">
    <div class=\"section-head\">
        <h2 class=\"section-title\">Em <span class=\"accent\">destaque</span></h2>
        <a class=\"see-all\" href=\"";
        // line 31
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\">Ver catálogo →</a>
    </div>

    ";
        // line 34
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["featured"] ?? null))) {
            // line 35
            yield "        <div class=\"grid-mangas\">
            ";
            // line 36
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["featured"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["manga"]) {
                // line 37
                yield "                ";
                yield from $this->load("partials/manga-card.twig", 37)->unwrap()->yield(CoreExtension::toArray(["manga" => $context["manga"]]));
                // line 38
                yield "            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['manga'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 39
            yield "        </div>
    ";
        } else {
            // line 41
            yield "        <div class=\"empty\">
            <div class=\"big\">📚</div>
            <p>Nenhum mangá publicado ainda. Volte em breve!</p>
        </div>
    ";
        }
        // line 46
        yield "</section>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "home.twig";
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
        return array (  154 => 46,  147 => 41,  143 => 39,  136 => 38,  133 => 37,  129 => 36,  126 => 35,  124 => 34,  118 => 31,  112 => 27,  107 => 24,  93 => 22,  89 => 21,  83 => 18,  78 => 15,  76 => 14,  71 => 11,  65 => 9,  59 => 7,  57 => 6,  53 => 5,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<section class=\"hero\">
    <h1>Descubra sua próxima <span class=\"accent\">obsessão</span> em mangás</h1>
    <p>Explore mangás, manhwas, manhuas, webtoons e muito mais. Atualizações constantes e uma coleção que cresce todos os dias.</p>
    <div class=\"hero-actions\">
        <a class=\"btn btn-primary\" href=\"{{ url(\x27/mangas\x27) }}\">Explorar catálogo</a>
        {% if not logged %}
            <a class=\"btn btn-ghost\" href=\"{{ url(\x27/register\x27) }}\">Criar conta grátis</a>
        {% else %}
            <a class=\"btn btn-ghost\" href=\"{{ url(\x27/dashboard\x27) }}\">Minha conta</a>
        {% endif %}
    </div>
</section>

{% if categories is not empty %}
<section class=\"section\">
    <div class=\"section-head\">
        <h2 class=\"section-title\">Categorias</h2>
        <a class=\"see-all\" href=\"{{ url(\x27/mangas\x27) }}\">Ver todas →</a>
    </div>
    <div class=\"chips\">
        {% for category in categories %}
            <a class=\"chip\" href=\"{{ url(\x27/mangas\x27) }}?category={{ category.id }}\">{{ category.name }}</a>
        {% endfor %}
    </div>
</section>
{% endif %}

<section class=\"section\">
    <div class=\"section-head\">
        <h2 class=\"section-title\">Em <span class=\"accent\">destaque</span></h2>
        <a class=\"see-all\" href=\"{{ url(\x27/mangas\x27) }}\">Ver catálogo →</a>
    </div>

    {% if featured is not empty %}
        <div class=\"grid-mangas\">
            {% for manga in featured %}
                {% include \x27partials/manga-card.twig\x27 with {manga: manga} only %}
            {% endfor %}
        </div>
    {% else %}
        <div class=\"empty\">
            <div class=\"big\">📚</div>
            <p>Nenhum mangá publicado ainda. Volte em breve!</p>
        </div>
    {% endif %}
</section>
", "home.twig", "D:\\buglivreoficial\\app\\Views\\home.twig");
    }
}
