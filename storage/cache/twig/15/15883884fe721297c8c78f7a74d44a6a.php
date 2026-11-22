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

/* admin/categories/form.twig */
class __TwigTemplate_ea97110edcbdbd2fa2a1ef1130576cb3 extends Template
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
    <h1>Editar categoria</h1>
    <a class=\"btn-link\" href=\"";
        // line 3
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/categories"), "html", null, true);
        yield "\">&larr; Voltar</a>
</div>

";
        // line 6
        if ((($tmp = ($context["error"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"alert alert-error\">";
            yield (string) $this->escaper->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>";
        }
        // line 7
        yield "
<section class=\"card\">
    <form method=\"post\" action=\"";
        // line 9
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url(("/admin/categories/" . CoreExtension::getAttribute($this->env, $this->source, ($context["category"] ?? null), "id", [], "any", false, false, false, 9))), "html", null, true);
        yield "\">
        <label>
            Nome
            <input type=\"text\" name=\"name\" maxlength=\"120\" value=\"";
        // line 12
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "name", [], "any", true, true, false, 12)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "name", [], "any", false, false, false, 12), CoreExtension::getAttribute($this->env, $this->source, ($context["category"] ?? null), "name", [], "any", false, false, false, 12))) : (CoreExtension::getAttribute($this->env, $this->source, ($context["category"] ?? null), "name", [], "any", false, false, false, 12))), "html", null, true);
        yield "\" required autofocus>
        </label>
        ";
        // line 14
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "name", [], "any", true, true, false, 14) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "name", [], "any", false, false, false, 14))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 15
            yield "            <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "name", [], "any", false, false, false, 15)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[0] ?? null) : null), "html", null, true);
            yield "</div>
        ";
        }
        // line 17
        yield "
        <label>
            Descrição (opcional)
            <textarea name=\"description\" maxlength=\"1000\">";
        // line 20
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "description", [], "any", true, true, false, 20)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "description", [], "any", false, false, false, 20), CoreExtension::getAttribute($this->env, $this->source, ($context["category"] ?? null), "description", [], "any", false, false, false, 20))) : (CoreExtension::getAttribute($this->env, $this->source, ($context["category"] ?? null), "description", [], "any", false, false, false, 20))), "html", null, true);
        yield "</textarea>
        </label>
        ";
        // line 22
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "description", [], "any", true, true, false, 22) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "description", [], "any", false, false, false, 22))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 23
            yield "            <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "description", [], "any", false, false, false, 23)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[0] ?? null) : null), "html", null, true);
            yield "</div>
        ";
        }
        // line 25
        yield "
        <p class=\"muted\" style=\"font-size: 13px;\">
            Slug (gerado automaticamente): <code>";
        // line 27
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["category"] ?? null), "slug", [], "any", false, false, false, 27), "html", null, true);
        yield "</code>
        </p>

        <button type=\"submit\">Salvar alterações</button>
    </form>
</section>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/categories/form.twig";
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
        return array (  108 => 27,  104 => 25,  98 => 23,  96 => 22,  91 => 20,  86 => 17,  80 => 15,  78 => 14,  73 => 12,  67 => 9,  63 => 7,  57 => 6,  51 => 3,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/categories/form.twig", "D:\\buglivreoficial\\app\\Views\\admin\\categories\\form.twig");
    }
}
