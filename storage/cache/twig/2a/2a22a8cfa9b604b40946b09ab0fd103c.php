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
class __TwigTemplate_f5a4cbe4de1c0312852045a020a067c7 extends Template
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
        $context["isEdit"] =  !(null === ($context["manga"] ?? null));
        // line 2
        $context["action"] = (((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->extensions['Core\View\TwigExtension']->url(("/admin/mangas/" . CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "id", [], "any", false, false, false, 2)))) : ($this->extensions['Core\View\TwigExtension']->url("/admin/mangas")));
        // line 3
        yield "
";
        // line 4
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "type_id", [], "any", true, true, false, 4) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "type_id", [], "any", false, false, false, 4)))) {
            // line 5
            yield "    ";
            $context["selectedType"] = CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "type_id", [], "any", false, false, false, 5);
        } elseif ((($tmp =         // line 6
($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 7
            yield "    ";
            $context["selectedType"] = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "type_id", [], "any", false, false, false, 7);
        } else {
            // line 9
            yield "    ";
            $context["selectedType"] = 0;
        }
        // line 11
        yield "
";
        // line 12
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "author_id", [], "any", true, true, false, 12) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "author_id", [], "any", false, false, false, 12)))) {
            // line 13
            yield "    ";
            $context["selectedAuthor"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "author_id", [], "any", false, false, false, 13) == "")) ? (0) : (CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "author_id", [], "any", false, false, false, 13)));
        } elseif ((($tmp =         // line 14
($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 15
            yield "    ";
            $context["selectedAuthor"] = (((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "author_id", [], "any", false, false, false, 15)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "author_id", [], "any", false, false, false, 15)) : (0));
        } else {
            // line 17
            yield "    ";
            $context["selectedAuthor"] = 0;
        }
        // line 19
        yield "
";
        // line 20
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "category_ids", [], "any", true, true, false, 20) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "category_ids", [], "any", false, false, false, 20)))) {
            // line 21
            yield "    ";
            $context["selectedCategories"] = CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "category_ids", [], "any", false, false, false, 21);
        } elseif ((($tmp =         // line 22
($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 23
            yield "    ";
            $context["selectedCategories"] = Twig\Extension\CoreExtension::map($this->env, $this->env->hasExtension(\Twig\Extension\SandboxExtension::class) && $this->env->getExtension(\Twig\Extension\SandboxExtension::class)->getChecker()->isSandboxed($this->source), CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "categories", [], "any", false, false, false, 23), function ($__c__) use ($context, $macros) { $context["c"] = $__c__; return CoreExtension::getAttribute($this->env, $this->source, ($context["c"] ?? null), "id", [], "any", false, false, false, 23); });
        } else {
            // line 25
            yield "    ";
            $context["selectedCategories"] = [];
        }
        // line 27
        yield "
";
        // line 28
        $context["selectedStatus"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "status", [], "any", true, true, false, 28)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "status", [], "any", false, false, false, 28), (((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 28)) : ("ongoing")))) : ((((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "status", [], "any", false, false, false, 28)) : ("ongoing"))));
        // line 29
        yield "
<div class=\"page-head\">
    <h1>";
        // line 31
        yield (string) (((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Editar mangá") : ("Novo mangá"));
        yield "</h1>
    <a class=\"btn-link\" href=\"";
        // line 32
        yield (string) $this->escaper->escape($this->extensions['Core\View\TwigExtension']->url("/admin/mangas"), "html", null, true);
        yield "\">&larr; Voltar</a>
</div>

";
        // line 35
        if ((($tmp = ($context["error"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"alert alert-error\">";
            yield (string) $this->escaper->escape(($context["error"] ?? null), "html", null, true);
            yield "</div>";
        }
        // line 36
        yield "
<section class=\"card\">
    <form method=\"post\" action=\"";
        // line 38
        yield (string) $this->escaper->escape(($context["action"] ?? null), "html", null, true);
        yield "\" enctype=\"multipart/form-data\">
        <div class=\"form-grid\">
            <div>
                <label>
                    Título
                    <input type=\"text\" name=\"title\" maxlength=\"200\" value=\"";
        // line 43
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "title", [], "any", true, true, false, 43)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "title", [], "any", false, false, false, 43), (((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "title", [], "any", false, false, false, 43)) : ("")))) : ((((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "title", [], "any", false, false, false, 43)) : ("")))), "html", null, true);
        yield "\" required autofocus>
                </label>
                ";
        // line 45
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "title", [], "any", true, true, false, 45) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "title", [], "any", false, false, false, 45))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 46
            yield "                    <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "title", [], "any", false, false, false, 46)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[0] ?? null) : null), "html", null, true);
            yield "</div>
                ";
        }
        // line 48
        yield "
                <label>
                    Tipo
                    <select name=\"type_id\" required>
                        <option value=\"\">Selecione um tipo...</option>
                        ";
        // line 53
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["types"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
            // line 54
            yield "                            <option value=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 54), "html", null, true);
            yield "\" ";
            yield (string) (((($context["selectedType"] ?? null) == CoreExtension::getAttribute($this->env, $this->source, $context["type"], "id", [], "any", false, false, false, 54))) ? ("selected") : (""));
            yield ">
                                ";
            // line 55
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["type"], "name", [], "any", false, false, false, 55), "html", null, true);
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["type"], "is_active", [], "any", false, false, false, 55)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : (" (inativo)"));
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['type'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 58
        yield "                    </select>
                </label>
                ";
        // line 60
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "type_id", [], "any", true, true, false, 60) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "type_id", [], "any", false, false, false, 60))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 61
            yield "                    <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "type_id", [], "any", false, false, false, 61)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[0] ?? null) : null), "html", null, true);
            yield "</div>
                ";
        }
        // line 63
        yield "
                <label>
                    Autor (opcional)
                    <select name=\"author_id\">
                        <option value=\"\">Sem autor</option>
                        ";
        // line 68
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["authors"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["author"]) {
            // line 69
            yield "                            <option value=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["author"], "id", [], "any", false, false, false, 69), "html", null, true);
            yield "\" ";
            yield (string) (((($context["selectedAuthor"] ?? null) == CoreExtension::getAttribute($this->env, $this->source, $context["author"], "id", [], "any", false, false, false, 69))) ? ("selected") : (""));
            yield ">
                                ";
            // line 70
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["author"], "name", [], "any", false, false, false, 70), "html", null, true);
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["author"], "is_active", [], "any", false, false, false, 70)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : (" (inativo)"));
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['author'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 73
        yield "                    </select>
                </label>
                ";
        // line 75
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "author_id", [], "any", true, true, false, 75) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "author_id", [], "any", false, false, false, 75))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 76
            yield "                    <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "author_id", [], "any", false, false, false, 76)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[0] ?? null) : null), "html", null, true);
            yield "</div>
                ";
        }
        // line 78
        yield "            </div>

            <div>
                <label>
                    Categorias
                    <select name=\"category_ids[]\" multiple size=\"6\" required>
                        ";
        // line 84
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 85
            yield "                            <option value=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 85), "html", null, true);
            yield "\" ";
            yield (string) ((CoreExtension::inFilter(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "id", [], "any", false, false, false, 85), ($context["selectedCategories"] ?? null))) ? ("selected") : (""));
            yield ">
                                ";
            // line 86
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 86), "html", null, true);
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["category"], "is_active", [], "any", false, false, false, 86)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : (" (inativa)"));
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['category'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 89
        yield "                    </select>
                    <small class=\"muted\">Use Ctrl (ou Cmd) para selecionar várias categorias.</small>
                </label>
                ";
        // line 92
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "category_ids", [], "any", true, true, false, 92) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "category_ids", [], "any", false, false, false, 92))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 93
            yield "                    <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "category_ids", [], "any", false, false, false, 93)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[0] ?? null) : null), "html", null, true);
            yield "</div>
                ";
        }
        // line 95
        yield "
                <label>
                    Status
                    <select name=\"status\" required>
                        ";
        // line 99
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["manga_statuses"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["label"]) {
            // line 100
            yield "                            <option value=\"";
            yield (string) $this->escaper->escape($context["key"], "html", null, true);
            yield "\" ";
            yield (string) (((($context["selectedStatus"] ?? null) == $context["key"])) ? ("selected") : (""));
            yield ">
                                ";
            // line 101
            yield (string) $this->escaper->escape($context["label"], "html", null, true);
            yield "
                            </option>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['label'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 104
        yield "                    </select>
                </label>
                ";
        // line 106
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "status", [], "any", true, true, false, 106) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "status", [], "any", false, false, false, 106))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 107
            yield "                    <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v4 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "status", [], "any", false, false, false, 107)) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4[0] ?? null) : null), "html", null, true);
            yield "</div>
                ";
        }
        // line 109
        yield "            </div>
        </div>

        <div class=\"form-grid\">
            <div>
                <label>
                    Capa &mdash; upload para o servidor
                    <input type=\"file\" name=\"cover_file\" accept=\"image/png,image/jpeg,image/webp,image/gif\">
                </label>
                ";
        // line 118
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "cover_file", [], "any", true, true, false, 118) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "cover_file", [], "any", false, false, false, 118))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 119
            yield "                    <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v5 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "cover_file", [], "any", false, false, false, 119)) && is_array($_v5) || $_v5 instanceof ArrayAccess ? ($_v5[0] ?? null) : null), "html", null, true);
            yield "</div>
                ";
        }
        // line 121
        yield "                <small class=\"muted\">Envie JPG, PNG, WEBP ou GIF (até 5 MB). O upload substitui o caminho abaixo.</small>
            </div>
            <div>
                <label>
                    Caminho/URL da capa (opcional)
                    <input type=\"text\" name=\"cover\" maxlength=\"255\" value=\"";
        // line 126
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "cover", [], "any", true, true, false, 126)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "cover", [], "any", false, false, false, 126), (((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "cover", [], "any", false, false, false, 126)) : ("")))) : ((((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "cover", [], "any", false, false, false, 126)) : ("")))), "html", null, true);
        yield "\" placeholder=\"/uploads/covers/... ou https://...\">
                </label>
                ";
        // line 128
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "cover", [], "any", true, true, false, 128) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "cover", [], "any", false, false, false, 128))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 129
            yield "                    <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v6 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "cover", [], "any", false, false, false, 129)) && is_array($_v6) || $_v6 instanceof ArrayAccess ? ($_v6[0] ?? null) : null), "html", null, true);
            yield "</div>
                ";
        }
        // line 131
        yield "
                ";
        // line 132
        if (((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp) && (($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "cover", [], "any", false, false, false, 132)) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 133
            yield "                    <p class=\"muted\" style=\"font-size: 13px;\">Capa atual:</p>
                    <img src=\"";
            // line 134
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "cover", [], "any", false, false, false, 134), "html", null, true);
            yield "\" alt=\"\" class=\"thumb\" style=\"width: 88px; height: 124px;\">
                ";
        }
        // line 136
        yield "            </div>
        </div>

        <label>
            Sinopse (opcional)
            <textarea name=\"description\" maxlength=\"5000\">";
        // line 141
        yield (string) $this->escaper->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "description", [], "any", true, true, false, 141)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["old"] ?? null), "description", [], "any", false, false, false, 141), (((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "description", [], "any", false, false, false, 141)) : ("")))) : ((((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "description", [], "any", false, false, false, 141)) : ("")))), "html", null, true);
        yield "</textarea>
        </label>
        ";
        // line 143
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "description", [], "any", true, true, false, 143) && (($tmp = Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "description", [], "any", false, false, false, 143))) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 144
            yield "            <div class=\"field-error\">";
            yield (string) $this->escaper->escape((($_v7 = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "description", [], "any", false, false, false, 144)) && is_array($_v7) || $_v7 instanceof ArrayAccess ? ($_v7[0] ?? null) : null), "html", null, true);
            yield "</div>
        ";
        }
        // line 146
        yield "
        ";
        // line 147
        if ((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 148
            yield "            <p class=\"muted\" style=\"font-size: 13px;\">
                Slug (gerado automaticamente): <code>";
            // line 149
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["manga"] ?? null), "slug", [], "any", false, false, false, 149), "html", null, true);
            yield "</code>
            </p>
        ";
        }
        // line 152
        yield "
        <button type=\"submit\">";
        // line 153
        yield (string) (((($tmp = ($context["isEdit"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Salvar alterações") : ("Criar mangá"));
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
        return array (  408 => 153,  405 => 152,  399 => 149,  396 => 148,  394 => 147,  391 => 146,  385 => 144,  383 => 143,  378 => 141,  371 => 136,  366 => 134,  363 => 133,  361 => 132,  358 => 131,  352 => 129,  350 => 128,  345 => 126,  338 => 121,  332 => 119,  330 => 118,  319 => 109,  313 => 107,  311 => 106,  307 => 104,  297 => 101,  290 => 100,  286 => 99,  280 => 95,  274 => 93,  272 => 92,  267 => 89,  256 => 86,  249 => 85,  245 => 84,  237 => 78,  231 => 76,  229 => 75,  225 => 73,  214 => 70,  207 => 69,  203 => 68,  196 => 63,  190 => 61,  188 => 60,  184 => 58,  173 => 55,  166 => 54,  162 => 53,  155 => 48,  149 => 46,  147 => 45,  142 => 43,  134 => 38,  130 => 36,  124 => 35,  118 => 32,  114 => 31,  110 => 29,  108 => 28,  105 => 27,  101 => 25,  97 => 23,  95 => 22,  92 => 21,  90 => 20,  87 => 19,  83 => 17,  79 => 15,  77 => 14,  74 => 13,  72 => 12,  69 => 11,  65 => 9,  61 => 7,  59 => 6,  56 => 5,  54 => 4,  51 => 3,  49 => 2,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/mangas/form.twig", "D:\\buglivreoficial\\app\\Views\\admin\\mangas\\form.twig");
    }
}
