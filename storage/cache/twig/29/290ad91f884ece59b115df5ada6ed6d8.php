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
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "check", [], "any", false, false, false, 6)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 7
            yield "            <a class=\"btn btn-ghost\" href=\"";
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/dashboard"), "html", null, true);
            yield "\">Minha conta</a>
        ";
        } else {
            // line 9
            yield "            <a class=\"btn btn-ghost\" href=\"";
            yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/register"), "html", null, true);
            yield "\">Criar conta grátis</a>
        ";
        }
        // line 11
        yield "    </div>
</section>

<section class=\"section\" id=\"home-categories-section\" hidden>
    <div class=\"section-head\">
        <h2 class=\"section-title\">Categorias</h2>
        <a class=\"see-all\" href=\"";
        // line 17
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\">Ver todas →</a>
    </div>
    <div class=\"chips\" id=\"home-categories\"></div>
</section>

<section class=\"section\">
    <div class=\"section-head\">
        <h2 class=\"section-title\">Em <span class=\"accent\">destaque</span></h2>
        <a class=\"see-all\" href=\"";
        // line 25
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/mangas"), "html", null, true);
        yield "\">Ver catálogo →</a>
    </div>
    <div class=\"grid-mangas\" id=\"home-featured\">
        <div class=\"empty\">
            <div class=\"big\">📚</div>
            <p>Carregando destaques…</p>
        </div>
    </div>
</section>
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
        return array (  90 => 25,  79 => 17,  71 => 11,  65 => 9,  59 => 7,  57 => 6,  53 => 5,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<section class=\"hero\">
    <h1>Descubra sua próxima <span class=\"accent\">obsessão</span> em mangás</h1>
    <p>Explore mangás, manhwas, manhuas, webtoons e muito mais. Atualizações constantes e uma coleção que cresce todos os dias.</p>
    <div class=\"hero-actions\">
        <a class=\"btn btn-primary\" href=\"{{ url(\x27/mangas\x27) }}\">Explorar catálogo</a>
        {% if auth.check %}
            <a class=\"btn btn-ghost\" href=\"{{ url(\x27/dashboard\x27) }}\">Minha conta</a>
        {% else %}
            <a class=\"btn btn-ghost\" href=\"{{ url(\x27/register\x27) }}\">Criar conta grátis</a>
        {% endif %}
    </div>
</section>

<section class=\"section\" id=\"home-categories-section\" hidden>
    <div class=\"section-head\">
        <h2 class=\"section-title\">Categorias</h2>
        <a class=\"see-all\" href=\"{{ url(\x27/mangas\x27) }}\">Ver todas →</a>
    </div>
    <div class=\"chips\" id=\"home-categories\"></div>
</section>

<section class=\"section\">
    <div class=\"section-head\">
        <h2 class=\"section-title\">Em <span class=\"accent\">destaque</span></h2>
        <a class=\"see-all\" href=\"{{ url(\x27/mangas\x27) }}\">Ver catálogo →</a>
    </div>
    <div class=\"grid-mangas\" id=\"home-featured\">
        <div class=\"empty\">
            <div class=\"big\">📚</div>
            <p>Carregando destaques…</p>
        </div>
    </div>
</section>
", "home.twig", "D:\\buglivreoficial\\app\\Views\\home.twig");
    }
}
