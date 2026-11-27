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

/* admin/dashboard.twig */
class __TwigTemplate_09be80ed999f18cacb0114fed714cd61 extends Template
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
        yield "<section class=\"card\">
    <div class=\"page-head\">
        <h1>Dashboard</h1>
        <a class=\"btn btn-ghost\" href=\"";
        // line 4
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/mangas/create"), "html", null, true);
        yield "\">+ Novo mangá</a>
    </div>
    <p class=\"muted\">
        Bem-vindo";
        // line 7
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "name", [], "any", false, false, false, 7)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield ", ";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "name", [], "any", false, false, false, 7), "html", null, true);
        }
        yield ".
        Você acessa esta área com o perfil
        <span class=\"badge\">";
        // line 9
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["role_labels"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "role", [], "any", false, false, false, 9), [], "array", true, true, false, 9)) ? (Twig\Extension\CoreExtension::default((($_v0 = ($context["role_labels"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[(($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "role", [], "any", false, false, false, 9)) instanceof \Stringable && (is_array($_v0) || $_v0 instanceof \ArrayObject || $_v0 instanceof \ArrayIterator) ? (string) $_v1 : $_v1)] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "role", [], "any", false, false, false, 9))) : (CoreExtension::getAttribute($this->env, $this->source, ($context["auth"] ?? null), "role", [], "any", false, false, false, 9))), "html", null, true);
        yield "</span>.
    </p>
</section>

<section class=\"card\">
    <h2>Usuários recentes</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Usuário</th>
                <th>E-mail</th>
                <th>Perfil</th>
                <th>Desde</th>
            </tr>
        </thead>
        <tbody id=\"users-table-body\">
            <tr><td colspan=\"6\" class=\"muted\">Carregando usuários…</td></tr>
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
        return "admin/dashboard.twig";
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
        return array (  66 => 9,  58 => 7,  52 => 4,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<section class=\"card\">
    <div class=\"page-head\">
        <h1>Dashboard</h1>
        <a class=\"btn btn-ghost\" href=\"{{ url(\x27/admin/mangas/create\x27) }}\">+ Novo mangá</a>
    </div>
    <p class=\"muted\">
        Bem-vindo{% if auth.name %}, {{ auth.name }}{% endif %}.
        Você acessa esta área com o perfil
        <span class=\"badge\">{{ role_labels[auth.role]|default(auth.role) }}</span>.
    </p>
</section>

<section class=\"card\">
    <h2>Usuários recentes</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Usuário</th>
                <th>E-mail</th>
                <th>Perfil</th>
                <th>Desde</th>
            </tr>
        </thead>
        <tbody id=\"users-table-body\">
            <tr><td colspan=\"6\" class=\"muted\">Carregando usuários…</td></tr>
        </tbody>
    </table>
</section>
", "admin/dashboard.twig", "D:\\buglivreoficial\\app\\Views\\admin\\dashboard.twig");
    }
}
