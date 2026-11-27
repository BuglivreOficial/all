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

/* maintenance.twig */
class __TwigTemplate_a60aebeb538dbbda42fb33c95f4e2312 extends Template
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
        yield "<!DOCTYPE html>
<html lang=\"pt-BR\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"robots\" content=\"noindex\">
    <title>Em manutenção · ";
        // line 7
        yield (string) $this->escaper->escape(($context["app_name"] ?? null), "html", null, true);
        yield "</title>
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap\" rel=\"stylesheet\">
    <style>
        :root {
            --bg: #0a0b11;
            --panel: #161927;
            --border: #272c40;
            --text: #e8eaf2;
            --muted: #9298ac;
            --brand: #ff3d68;
            --brand-2: #8b5cf6;
            --grad: linear-gradient(135deg, var(--brand), var(--brand-2));
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: \"Inter\", system-ui, -apple-system, \"Segoe UI\", Roboto, sans-serif;
            background: radial-gradient(1200px 600px at 80% -10%, rgba(139, 92, 246, .18), transparent 60%),
                        radial-gradient(900px 500px at 0% 0%, rgba(255, 61, 104, .14), transparent 55%),
                        var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }
        .maintenance {
            width: 100%;
            max-width: 480px;
            padding: 40px 32px;
            text-align: center;
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, .45);
        }
        .maintenance .mark {
            width: 56px;
            height: 56px;
            margin: 0 auto 20px;
            border-radius: 16px;
            background: var(--grad);
            display: grid;
            place-items: center;
            font-size: 26px;
            font-weight: 800;
            box-shadow: 0 10px 26px rgba(255, 61, 104, .45);
        }
        .maintenance h1 {
            margin: 0 0 12px;
            font-size: 24px;
            letter-spacing: -.02em;
        }
        .maintenance p {
            margin: 0;
            line-height: 1.6;
        }
        .maintenance .muted { color: var(--muted); }
        .maintenance .hint {
            margin-top: 20px;
            font-size: 14px;
            color: var(--muted);
        }
    </style>
</head>
<body>
    <main class=\"maintenance\">
        <span class=\"mark\">B</span>
        <h1>Estamos em manutenção</h1>
        <p class=\"muted\">";
        // line 79
        yield (string) $this->escaper->escape(($context["message"] ?? null), "html", null, true);
        yield "</p>
        <p class=\"hint\">Voltamos em breve. Obrigado pela paciência.</p>
    </main>
</body>
</html>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "maintenance.twig";
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
        return array (  130 => 79,  55 => 7,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"pt-BR\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"robots\" content=\"noindex\">
    <title>Em manutenção · {{ app_name }}</title>
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap\" rel=\"stylesheet\">
    <style>
        :root {
            --bg: #0a0b11;
            --panel: #161927;
            --border: #272c40;
            --text: #e8eaf2;
            --muted: #9298ac;
            --brand: #ff3d68;
            --brand-2: #8b5cf6;
            --grad: linear-gradient(135deg, var(--brand), var(--brand-2));
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: \"Inter\", system-ui, -apple-system, \"Segoe UI\", Roboto, sans-serif;
            background: radial-gradient(1200px 600px at 80% -10%, rgba(139, 92, 246, .18), transparent 60%),
                        radial-gradient(900px 500px at 0% 0%, rgba(255, 61, 104, .14), transparent 55%),
                        var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }
        .maintenance {
            width: 100%;
            max-width: 480px;
            padding: 40px 32px;
            text-align: center;
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, .45);
        }
        .maintenance .mark {
            width: 56px;
            height: 56px;
            margin: 0 auto 20px;
            border-radius: 16px;
            background: var(--grad);
            display: grid;
            place-items: center;
            font-size: 26px;
            font-weight: 800;
            box-shadow: 0 10px 26px rgba(255, 61, 104, .45);
        }
        .maintenance h1 {
            margin: 0 0 12px;
            font-size: 24px;
            letter-spacing: -.02em;
        }
        .maintenance p {
            margin: 0;
            line-height: 1.6;
        }
        .maintenance .muted { color: var(--muted); }
        .maintenance .hint {
            margin-top: 20px;
            font-size: 14px;
            color: var(--muted);
        }
    </style>
</head>
<body>
    <main class=\"maintenance\">
        <span class=\"mark\">B</span>
        <h1>Estamos em manutenção</h1>
        <p class=\"muted\">{{ message }}</p>
        <p class=\"hint\">Voltamos em breve. Obrigado pela paciência.</p>
    </main>
</body>
</html>
", "maintenance.twig", "D:\\buglivreoficial\\app\\Views\\maintenance.twig");
    }
}
