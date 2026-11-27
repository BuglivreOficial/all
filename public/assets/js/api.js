/*
 * BugLivre — cliente HTTP da API e helpers de UI compartilhados.
 *
 * Autenticação: sessão web compartilhada (cookie). Todas as chamadas usam
 * `credentials: 'same-origin'`, portanto não há gerenciamento de token no front.
 */
(function (window, document) {
    'use strict';

    var BASE = '/api';

    /**
     * Executa uma requisição à API e devolve o JSON de resposta.
     * Lança um Error com `status` e `errors` em caso de falha.
     */
    async function request(method, path, options) {
        options = options || {};

        var fetchOptions = {
            method: method,
            credentials: 'same-origin',
            headers: { Accept: 'application/json' }
        };

        if (options.json !== undefined) {
            fetchOptions.headers['Content-Type'] = 'application/json';
            fetchOptions.body = JSON.stringify(options.json);
        } else if (options.form !== undefined) {
            fetchOptions.body = options.form;
        }

        var response;
        try {
            response = await fetch(BASE + path, fetchOptions);
        } catch (e) {
            var netError = new Error('Falha de conexão com o servidor.');
            netError.status = 0;
            netError.errors = {};
            throw netError;
        }

        var text = await response.text();
        var payload = null;
        if (text) {
            try { payload = JSON.parse(text); } catch (e) { payload = null; }
        }

        if (!response.ok) {
            var error = new Error((payload && payload.message) || ('Erro ' + response.status));
            error.status = response.status;
            error.errors = (payload && payload.errors) || {};
            error.payload = payload;
            throw error;
        }

        return payload;
    }

    var Api = {
        get: function (path) { return request('GET', path); },
        post: function (path, json) { return request('POST', path, { json: json }); },
        put: function (path, json) { return request('PUT', path, { json: json }); },
        delete: function (path) { return request('DELETE', path); },
        /** Envia multipart/form-data via POST (usado em uploads de capa). */
        form: function (path, formData) { return request('POST', path, { form: formData }); }
    };

    var STATUS_LABELS = {
        ongoing: 'Em publicação',
        completed: 'Completo',
        hiatus: 'Em hiato',
        cancelled: 'Cancelado'
    };

    var ROLE_LABELS = {
        user: 'Usuário',
        vip: 'VIP',
        moderador: 'Moderador',
        suporte: 'Suporte',
        admin: 'Administrador'
    };

    var ROLE_LEVELS = { user: 1, vip: 2, moderador: 3, suporte: 4, admin: 5 };

    var Ui = {
        qs: function (selector, root) { return (root || document).querySelector(selector); },
        qsa: function (selector, root) {
            return Array.prototype.slice.call((root || document).querySelectorAll(selector));
        },

        escape: function (value) {
            return String(value == null ? '' : value).replace(/[&<>"']/g, function (ch) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch];
            });
        },

        excerpt: function (value, length) {
            value = String(value == null ? '' : value).trim();
            if (!value) { return ''; }
            length = length || 120;
            return value.length <= length ? value : value.slice(0, length - 1) + '…';
        },

        statusLabel: function (status) { return STATUS_LABELS[status] || status || ''; },
        roleLabel: function (role) { return ROLE_LABELS[role] || role || ''; },
        roleLevel: function (role) { return ROLE_LEVELS[role] || 0; },
        canManage: function (role) { return (ROLE_LEVELS[role] || 0) >= 3; },

        /** HTML de capa (imagem ou placeholder com a inicial do título). */
        cover: function (manga, className) {
            var cls = className ? ' class="' + className + '"' : '';
            if (manga.cover) {
                return '<img' + cls + ' src="' + Ui.escape(manga.cover) + '" alt="Capa de '
                    + Ui.escape(manga.title) + '" loading="lazy">';
            }
            var initial = String(manga.title || '?').trim().charAt(0).toUpperCase();
            return '<div class="cover-ph"' + (className ? ' style="width:100%;height:100%"' : '')
                + '>' + Ui.escape(initial) + '</div>';
        },

        /** Card de mangá (espelha partials/manga-card.twig). */
        mangaCard: function (manga) {
            var typeTag = manga.type_name
                ? '<span class="type-tag">' + Ui.escape(manga.type_name) + '</span>' : '';
            var author = manga.author_name
                ? '<span>' + Ui.escape(manga.author_name) + '</span>' : '';
            var href = '/mangas/' + encodeURIComponent(manga.slug);

            return '<article class="manga-card">'
                + '<a class="cover" href="' + href + '">' + Ui.cover(manga) + typeTag + '</a>'
                + '<div class="card-body">'
                + '<a class="card-title" href="' + href + '">' + Ui.escape(manga.title) + '</a>'
                + '<div class="card-meta">'
                + '<span class="badge badge-' + Ui.escape(manga.status) + '">'
                + Ui.escape(Ui.statusLabel(manga.status)) + '</span>' + author
                + '</div></div></article>';
        },

        /** Renderiza uma grade de cards ou o estado vazio. */
        mangaGrid: function (container, mangas, emptyMessage, emptyIcon) {
            if (!container) { return; }
            if (!mangas || !mangas.length) {
                container.innerHTML = '<div class="empty"><div class="big">'
                    + (emptyIcon || '📚') + '</div><p>'
                    + Ui.escape(emptyMessage || 'Nenhum mangá encontrado.') + '</p></div>';
                return;
            }
            container.innerHTML = mangas.map(Ui.mangaCard).join('');
        },

        alert: function (container, type, message) {
            if (!container) { return; }
            container.className = 'alert alert-' + (type || 'error');
            container.textContent = message || '';
            container.hidden = false;
        },

        clearAlert: function (container) {
            if (!container) { return; }
            container.textContent = '';
            container.hidden = true;
        },

        /** Valor normalizado de um campo do formulário. */
        value: function (form, name) {
            var input = form && form.elements[name];
            return input ? String(input.value || '').trim() : '';
        },

        /** Marca o campo como inválido e mostra a mensagem logo abaixo dele. */
        fieldError: function (input, message) {
            if (!input) { return; }
            Ui.clearFieldError(input);
            input.setAttribute('aria-invalid', 'true');
            var box = document.createElement('div');
            box.className = 'field-error';
            box.textContent = message || 'Valor inválido.';
            (input.closest('label') || input).insertAdjacentElement('afterend', box);
        },

        clearFieldError: function (input) {
            if (!input) { return; }
            input.removeAttribute('aria-invalid');
            var anchor = input.closest('label') || input;
            var next = anchor.nextElementSibling;
            while (next && next.classList && next.classList.contains('field-error')) {
                var current = next;
                next = next.nextElementSibling;
                current.remove();
            }
        },

        /**
         * Validação personalizada: `rules` é `{ campo: [fn, ...] }`, onde cada função
         * recebe `(valor, form)` e devolve a mensagem de erro (ou string vazia se ok).
         * Devolve `true` quando tudo passa; caso contrário destaca os campos e foca o primeiro.
         */
        validate: function (form, rules) {
            Ui.clearFieldErrors(form);
            var firstInvalid = null;

            Object.keys(rules || {}).forEach(function (name) {
                var input = form.elements[name];
                if (!input) { return; }
                var value = Ui.value(form, name);
                var checks = rules[name];
                var message = '';
                for (var i = 0; i < checks.length && !message; i++) {
                    message = checks[i](value, form) || '';
                }
                if (message) {
                    Ui.fieldError(input, message);
                    if (!firstInvalid) { firstInvalid = input; }
                }
            });

            if (firstInvalid) { firstInvalid.focus(); }
            return firstInvalid === null;
        },

        /** Revalida o campo ao sair dele e limpa o erro assim que o usuário digita. */
        watchValidation: function (form, rules) {
            Object.keys(rules || {}).forEach(function (name) {
                var input = form.elements[name];
                if (!input) { return; }
                var checks = rules[name];

                input.addEventListener('blur', function () {
                    var value = Ui.value(form, name);
                    var message = '';
                    for (var i = 0; i < checks.length && !message; i++) {
                        message = checks[i](value, form) || '';
                    }
                    Ui.clearFieldError(input);
                    if (message) { Ui.fieldError(input, message); }
                });

                input.addEventListener('input', function () { Ui.clearFieldError(input); });
            });
        },

        /** Exibe erros vindos da API (422) nos respectivos campos. */
        showFieldErrors: function (form, errors) {
            Ui.clearFieldErrors(form);
            Object.keys(errors || {}).forEach(function (field) {
                var input = form.elements[field];
                if (!input) { return; }
                Ui.fieldError(input, (errors[field] || [])[0]);
            });
        },

        clearFieldErrors: function (form) {
            Ui.qsa('.field-error', form).forEach(function (el) { el.remove(); });
            Ui.qsa('[aria-invalid="true"]', form).forEach(function (el) {
                el.removeAttribute('aria-invalid');
            });
        },

        /**
         * Estado de carregamento do formulário: desabilita o botão de envio e mostra
         * um spinner. Se o botão tiver `data-loading-text`, o rótulo é substituído
         * (ex.: "Entrando…") para deixar claro que a requisição está em andamento.
         */
        setLoading: function (form, loading) {
            if (!form) { return; }
            form.dataset.loading = loading ? '1' : '';
            form.setAttribute('aria-busy', loading ? 'true' : 'false');

            var button = form.querySelector('button[type="submit"]');
            if (!button) { return; }

            // Sem `data-loading-text`, apenas desabilita o botão.
            if (!button.dataset.loadingText) {
                button.disabled = loading;
                return;
            }

            if (loading) {
                if (button.dataset.label === undefined) {
                    button.dataset.label = button.innerHTML;
                }
                button.disabled = true;
                button.classList.add('is-loading');
                button.innerHTML = '<span class="spinner" aria-hidden="true"></span>'
                    + '<span>' + Ui.escape(button.dataset.loadingText) + '</span>';
            } else {
                button.disabled = false;
                button.classList.remove('is-loading');
                if (button.dataset.label !== undefined) {
                    button.innerHTML = button.dataset.label;
                }
            }
        },

        /** Bloqueia links de navegação durante uma requisição em andamento. */
        notify: function (type, message) {
            window.console && window.console.log('[' + type + '] ' + message);
        }
    };

    window.Api = Api;
    window.Ui = Ui;
})(window, document);
