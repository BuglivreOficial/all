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

/* admin/mangas/form.twig */
class __TwigTemplate_cb3fefed7df7a6348e4afeeac7d5ac4d extends Template
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
    <h1>";
        // line 2
        yield (string) (((($context["mode"] ?? null) == "edit")) ? ("Editar mangá") : ("Novo mangá"));
        yield "</h1>
    <a class=\"btn-link\" href=\"";
        // line 3
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/mangas"), "html", null, true);
        yield "\">&larr; Voltar</a>
</div>

<div class=\"alert alert-error\" id=\"manga-alert\" hidden></div>

<section class=\"card\">
    <form id=\"manga-form\" enctype=\"multipart/form-data\">
        <div class=\"form-grid\">
            <div>
                <label>
                    Título
                    <input type=\"text\" name=\"title\" maxlength=\"200\" required autofocus>
                </label>

                <label>
                    Tipo
                    <select name=\"type_id\" required>
                        <option value=\"\">Selecione um tipo...</option>
                    </select>
                </label>

                <label>
                    Autor (opcional)
                    <select name=\"author_id\">
                        <option value=\"\">Sem autor</option>
                    </select>
                </label>
            </div>

            <div>
                <div class=\"chips-field\">
                    <span class=\"field-label\">Categorias</span>
                    <div class=\"chips-select\" id=\"manga-category-chips\" role=\"group\"
                         aria-label=\"Selecione uma ou mais categorias\"></div>
                    <select name=\"category_ids\" multiple hidden></select>
                    <small class=\"muted\">Clique para marcar uma ou mais categorias.</small>
                </div>

                <label>
                    Status
                    <select name=\"status\" required>
                        ";
        // line 44
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["manga_statuses"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["label"]) {
            // line 45
            yield "                            <option value=\"";
            yield (string) $this->escaper->escape($context["key"], "html", null, true);
            yield "\">";
            yield (string) $this->escaper->escape($context["label"], "html", null, true);
            yield "</option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['label'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 47
        yield "                    </select>
                </label>
            </div>
        </div>

        <div class=\"form-grid\">
            <div>
                <label>
                    Capa &mdash; upload para o servidor
                    <input type=\"file\" name=\"cover_file\" accept=\"image/png,image/jpeg,image/webp,image/gif\">
                </label>
                <small class=\"muted\">Envie JPG, PNG, WEBP ou GIF (até 5 MB). O upload substitui o caminho abaixo.</small>
            </div>
            <div>
                <label>
                    Caminho/URL da capa (opcional)
                    <input type=\"text\" name=\"cover\" maxlength=\"255\" placeholder=\"/uploads/covers/... ou https://...\">
                </label>

                <p class=\"muted\" style=\"font-size: 13px;\">Capa atual:</p>
                <div id=\"manga-cover-preview\"></div>
            </div>
        </div>

        <label>
            Sinopse (opcional)
            <textarea name=\"description\" maxlength=\"5000\"></textarea>
        </label>

        <p class=\"muted\" style=\"font-size: 13px;\">
            Slug (gerado automaticamente): <code id=\"manga-slug\"></code>
        </p>

        <button type=\"submit\">";
        // line 80
        yield (string) (((($context["mode"] ?? null) == "edit")) ? ("Salvar alterações") : ("Criar mangá"));
        yield "</button>
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
        return "admin/mangas/form.twig";
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
        return array (  149 => 80,  114 => 47,  102 => 45,  98 => 44,  54 => 3,  50 => 2,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"page-head\">
    <h1>{{ mode == \x27edit\x27 ? \x27Editar mangá\x27 : \x27Novo mangá\x27 }}</h1>
    <a class=\"btn-link\" href=\"{{ url(\x27/admin/mangas\x27) }}\">&larr; Voltar</a>
</div>

<div class=\"alert alert-error\" id=\"manga-alert\" hidden></div>

<section class=\"card\">
    <form id=\"manga-form\" enctype=\"multipart/form-data\">
        <div class=\"form-grid\">
            <div>
                <label>
                    Título
                    <input type=\"text\" name=\"title\" maxlength=\"200\" required autofocus>
                </label>

                <label>
                    Tipo
                    <select name=\"type_id\" required>
                        <option value=\"\">Selecione um tipo...</option>
                    </select>
                </label>

                <label>
                    Autor (opcional)
                    <select name=\"author_id\">
                        <option value=\"\">Sem autor</option>
                    </select>
                </label>
            </div>

            <div>
                <div class=\"chips-field\">
                    <span class=\"field-label\">Categorias</span>
                    <div class=\"chips-select\" id=\"manga-category-chips\" role=\"group\"
                         aria-label=\"Selecione uma ou mais categorias\"></div>
                    <select name=\"category_ids\" multiple hidden></select>
                    <small class=\"muted\">Clique para marcar uma ou mais categorias.</small>
                </div>

                <label>
                    Status
                    <select name=\"status\" required>
                        {% for key, label in manga_statuses %}
                            <option value=\"{{ key }}\">{{ label }}</option>
                        {% endfor %}
                    </select>
                </label>
            </div>
        </div>

        <div class=\"form-grid\">
            <div>
                <label>
                    Capa &mdash; upload para o servidor
                    <input type=\"file\" name=\"cover_file\" accept=\"image/png,image/jpeg,image/webp,image/gif\">
                </label>
                <small class=\"muted\">Envie JPG, PNG, WEBP ou GIF (até 5 MB). O upload substitui o caminho abaixo.</small>
            </div>
            <div>
                <label>
                    Caminho/URL da capa (opcional)
                    <input type=\"text\" name=\"cover\" maxlength=\"255\" placeholder=\"/uploads/covers/... ou https://...\">
                </label>

                <p class=\"muted\" style=\"font-size: 13px;\">Capa atual:</p>
                <div id=\"manga-cover-preview\"></div>
            </div>
        </div>

        <label>
            Sinopse (opcional)
            <textarea name=\"description\" maxlength=\"5000\"></textarea>
        </label>

        <p class=\"muted\" style=\"font-size: 13px;\">
            Slug (gerado automaticamente): <code id=\"manga-slug\"></code>
        </p>

        <button type=\"submit\">{{ mode == \x27edit\x27 ? \x27Salvar alterações\x27 : \x27Criar mangá\x27 }}</button>
    </form>
</section>
", "admin/mangas/form.twig", "D:\\buglivreoficial\\app\\Views\\admin\\mangas\\form.twig");
    }
}
