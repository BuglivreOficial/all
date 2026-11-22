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

/* dashboard.twig */
class __TwigTemplate_6fbbe2994615654d66a5d930a8204ece extends Template
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
    <h1>Olá, ";
        // line 2
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "name", [], "any", false, false, false, 2), "html", null, true);
        yield "</h1>
    <a class=\"btn btn-ghost\" href=\"";
        // line 3
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/"), "html", null, true);
        yield "\">Ver site</a>
</div>

<div class=\"card\">
    <p class=\"muted\">Você está autenticado na área web (sessão).</p>
    <dl style=\"display: grid; grid-template-columns: auto 1fr; gap: 10px 20px; margin: 0;\">
        <dt class=\"muted\">ID</dt><dd style=\"margin: 0;\">";
        // line 9
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "id", [], "any", false, false, false, 9), "html", null, true);
        yield "</dd>
        <dt class=\"muted\">Nome</dt><dd style=\"margin: 0;\">";
        // line 10
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "name", [], "any", false, false, false, 10), "html", null, true);
        yield "</dd>
        <dt class=\"muted\">Usuário</dt><dd style=\"margin: 0;\">";
        // line 11
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "username", [], "any", false, false, false, 11), "html", null, true);
        yield "</dd>
        <dt class=\"muted\">E-mail</dt><dd style=\"margin: 0;\">";
        // line 12
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "email", [], "any", false, false, false, 12), "html", null, true);
        yield "</dd>
        <dt class=\"muted\">Perfil</dt><dd style=\"margin: 0;\"><span class=\"badge\">";
        // line 13
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["role_labels"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "role", [], "any", false, false, false, 13), [], "array", true, true, false, 13)) ? (Twig\Extension\CoreExtension::default((($_v0 = ($context["role_labels"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[(($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "role", [], "any", false, false, false, 13)) instanceof \Stringable && (is_array($_v0) || $_v0 instanceof \ArrayObject || $_v0 instanceof \ArrayIterator) ? (string) $_v1 : $_v1)] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "role", [], "any", false, false, false, 13))) : (CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "role", [], "any", false, false, false, 13))), "html", null, true);
        yield "</span></dd>
        <dt class=\"muted\">Desde</dt><dd style=\"margin: 0;\">";
        // line 14
        yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "created_at", [], "any", false, false, false, 14), "html", null, true);
        yield "</dd>
    </dl>
</div>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "dashboard.twig";
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
        return array (  83 => 14,  79 => 13,  75 => 12,  71 => 11,  67 => 10,  63 => 9,  54 => 3,  50 => 2,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"page-head\">
    <h1>Olá, {{ user.name }}</h1>
    <a class=\"btn btn-ghost\" href=\"{{ url(\x27/\x27) }}\">Ver site</a>
</div>

<div class=\"card\">
    <p class=\"muted\">Você está autenticado na área web (sessão).</p>
    <dl style=\"display: grid; grid-template-columns: auto 1fr; gap: 10px 20px; margin: 0;\">
        <dt class=\"muted\">ID</dt><dd style=\"margin: 0;\">{{ user.id }}</dd>
        <dt class=\"muted\">Nome</dt><dd style=\"margin: 0;\">{{ user.name }}</dd>
        <dt class=\"muted\">Usuário</dt><dd style=\"margin: 0;\">{{ user.username }}</dd>
        <dt class=\"muted\">E-mail</dt><dd style=\"margin: 0;\">{{ user.email }}</dd>
        <dt class=\"muted\">Perfil</dt><dd style=\"margin: 0;\"><span class=\"badge\">{{ role_labels[user.role]|default(user.role) }}</span></dd>
        <dt class=\"muted\">Desde</dt><dd style=\"margin: 0;\">{{ user.created_at }}</dd>
    </dl>
</div>
", "dashboard.twig", "D:\\buglivreoficial\\app\\Views\\dashboard.twig");
    }
}
