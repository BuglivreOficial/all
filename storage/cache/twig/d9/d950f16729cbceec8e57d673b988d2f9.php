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
        if ((($tmp = ($context["user"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield ", ";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "name", [], "any", false, false, false, 7), "html", null, true);
        }
        yield ".
        Você acessa esta área com o perfil
        <span class=\"badge\">";
        // line 9
        yield (string) (((($tmp = ($context["user"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["role_labels"] ?? null), CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "role", [], "any", false, false, false, 9), [], "array", true, true, false, 9)) ? (Twig\Extension\CoreExtension::default((($_v0 = ($context["role_labels"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[(($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "role", [], "any", false, false, false, 9)) instanceof \Stringable && (is_array($_v0) || $_v0 instanceof \ArrayObject || $_v0 instanceof \ArrayIterator) ? (string) $_v1 : $_v1)] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "role", [], "any", false, false, false, 9))) : (CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "role", [], "any", false, false, false, 9))), "html", null, true)) : (""));
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
        <tbody>
            ";
        // line 27
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["users"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 28
            yield "                <tr>
                    <td>";
            // line 29
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "id", [], "any", false, false, false, 29), "html", null, true);
            yield "</td>
                    <td>";
            // line 30
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "name", [], "any", false, false, false, 30), "html", null, true);
            yield "</td>
                    <td class=\"muted\">";
            // line 31
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "username", [], "any", false, false, false, 31), "html", null, true);
            yield "</td>
                    <td class=\"muted\">";
            // line 32
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "email", [], "any", false, false, false, 32), "html", null, true);
            yield "</td>
                    <td><span class=\"badge\">";
            // line 33
            yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["role_labels"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["row"], "role", [], "any", false, false, false, 33), [], "array", true, true, false, 33)) ? (Twig\Extension\CoreExtension::default((($_v2 = ($context["role_labels"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[(($_v3 = CoreExtension::getAttribute($this->env, $this->source, $context["row"], "role", [], "any", false, false, false, 33)) instanceof \Stringable && (is_array($_v2) || $_v2 instanceof \ArrayObject || $_v2 instanceof \ArrayIterator) ? (string) $_v3 : $_v3)] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source, $context["row"], "role", [], "any", false, false, false, 33))) : (CoreExtension::getAttribute($this->env, $this->source, $context["row"], "role", [], "any", false, false, false, 33))), "html", null, true);
            yield "</span></td>
                    <td class=\"muted\">";
            // line 34
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "created_at", [], "any", false, false, false, 34), "html", null, true);
            yield "</td>
                </tr>
            ";
            $context['_iterated'] = true;
        }
        // line 36
        if (!$context['_iterated']) {
            // line 37
            yield "                <tr><td colspan=\"6\" class=\"muted\">Nenhum usuário cadastrado.</td></tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['row'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 39
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
        return array (  132 => 39,  124 => 37,  122 => 36,  115 => 34,  111 => 33,  107 => 32,  103 => 31,  99 => 30,  95 => 29,  92 => 28,  87 => 27,  66 => 9,  58 => 7,  52 => 4,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<section class=\"card\">
    <div class=\"page-head\">
        <h1>Dashboard</h1>
        <a class=\"btn btn-ghost\" href=\"{{ url(\x27/admin/mangas/create\x27) }}\">+ Novo mangá</a>
    </div>
    <p class=\"muted\">
        Bem-vindo{% if user %}, {{ user.name }}{% endif %}.
        Você acessa esta área com o perfil
        <span class=\"badge\">{{ user ? role_labels[user.role]|default(user.role) : \x27\x27 }}</span>.
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
        <tbody>
            {% for row in users %}
                <tr>
                    <td>{{ row.id }}</td>
                    <td>{{ row.name }}</td>
                    <td class=\"muted\">{{ row.username }}</td>
                    <td class=\"muted\">{{ row.email }}</td>
                    <td><span class=\"badge\">{{ role_labels[row.role]|default(row.role) }}</span></td>
                    <td class=\"muted\">{{ row.created_at }}</td>
                </tr>
            {% else %}
                <tr><td colspan=\"6\" class=\"muted\">Nenhum usuário cadastrado.</td></tr>
            {% endfor %}
        </tbody>
    </table>
</section>
", "admin/dashboard.twig", "D:\\buglivreoficial\\app\\Views\\admin\\dashboard.twig");
    }
}
