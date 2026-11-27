/*
 * BugLivre — comportamento da área pública (site).
 * Consome a API (/api) e monta home, catálogo, detalhe, autenticação e painel do usuário.
 */
(function (window, document) {
    'use strict';

    var config = window.BUGLIVRE || {};

    function field(form, name) {
        return form.elements[name] ? String(form.elements[name].value || '').trim() : '';
    }

    function setField(form, name, value) {
        if (form.elements[name]) { form.elements[name].value = value == null ? '' : value; }
    }

    /** Botões "Sair" enviam POST /api/auth/logout e recarregam a página. */
    function bindLogout() {
        Ui.qsa('[data-action="logout"]').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                Api.post('/auth/logout').then(function () {
                    window.location.href = '/';
                }).catch(function () {
                    window.location.href = '/';
                });
            });
        });
    }

    /* ---------------------------------------------------------------- Home */

    function initHome() {
        Api.get('/categories?only_active=1').then(function (res) {
            var categories = res.data || [];
            var section = Ui.qs('#home-categories-section');
            var chips = Ui.qs('#home-categories');
            if (!categories.length) {
                if (section) { section.remove(); }
                return;
            }
            if (chips) {
                chips.innerHTML = categories.map(function (category) {
                    return '<a class="chip" href="/mangas?category=' + category.id + '">'
                        + Ui.escape(category.name) + '</a>';
                }).join('');
            }
            if (section) { section.hidden = false; }
        }).catch(function () {});

        Api.get('/mangas?only_active=1').then(function (res) {
            var mangas = (res.data || []).sort(function (a, b) {
                return String(b.created_at || '').localeCompare(String(a.created_at || ''));
            }).slice(0, 12);
            Ui.mangaGrid(Ui.qs('#home-featured'), mangas,
                'Nenhum mangá publicado ainda. Volte em breve!', '📚');
        }).catch(function () {
            Ui.mangaGrid(Ui.qs('#home-featured'), [],
                'Não foi possível carregar os destaques.', '⚠️');
        });
    }

    /* -------------------------------------------------------------- Catálogo */

    function fillSelect(select, items, placeholder, selected) {
        if (!select) { return; }
        var options = ['<option value="">' + Ui.escape(placeholder) + '</option>'];
        items.forEach(function (item) {
            options.push('<option value="' + item.id + '"'
                + (String(selected) === String(item.id) ? ' selected' : '') + '>'
                + Ui.escape(item.name) + '</option>');
        });
        select.innerHTML = options.join('');
    }

    function initCatalog() {
        var form = Ui.qs('#catalog-filters');
        var results = Ui.qs('#catalog-results');
        var counter = Ui.qs('#catalog-count');
        if (!form) { return; }

        var params = new URLSearchParams(window.location.search);
        var state = {
            q: params.get('q') || '',
            category: params.get('category') || '',
            type: params.get('type') || ''
        };

        setField(form, 'q', state.q);

        Promise.all([
            Api.get('/categories?only_active=1'),
            Api.get('/types?only_active=1')
        ]).then(function (responses) {
            fillSelect(form.elements['category'], responses[0].data || [], 'Todas', state.category);
            fillSelect(form.elements['type'], responses[1].data || [], 'Todos', state.type);
        }).catch(function () {});

        function load() {
            var query = [];
            if (state.q) { query.push('q=' + encodeURIComponent(state.q)); }
            if (state.category) { query.push('category=' + encodeURIComponent(state.category)); }
            if (state.type) { query.push('type=' + encodeURIComponent(state.type)); }
            query.push('only_active=1');

            if (counter) { counter.textContent = 'Carregando…'; }

            Api.get('/mangas?' + query.join('&')).then(function (res) {
                var mangas = res.data || [];
                if (counter) { counter.textContent = mangas.length + ' título(s)'; }
                Ui.mangaGrid(results, mangas,
                    'Nenhum mangá encontrado com esses filtros.', '🔍');
            }).catch(function (err) {
                if (counter) { counter.textContent = ''; }
                Ui.mangaGrid(results, [], err.message, '⚠️');
            });
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            state.q = field(form, 'q');
            state.category = field(form, 'category');
            state.type = field(form, 'type');

            var params = new URLSearchParams();
            if (state.q) { params.set('q', state.q); }
            if (state.category) { params.set('category', state.category); }
            if (state.type) { params.set('type', state.type); }
            var qs = params.toString();
            window.history.replaceState({}, '', '/mangas' + (qs ? '?' + qs : ''));

            load();
        });

        load();
    }

    /* --------------------------------------------------------- Detalhe mangá */

    function initMangaShow() {
        var container = Ui.qs('#manga-detail');
        if (!container || !config.slug) { return; }

        Api.get('/mangas/slug/' + encodeURIComponent(config.slug)).then(function (res) {
            container.innerHTML = renderMangaDetail(res.data);
        }).catch(function (err) {
            container.innerHTML = '<div class="empty"><div class="big">⚠️</div><p>'
                + Ui.escape(err.status === 404 ? 'Mangá não encontrado.' : err.message)
                + '</p><p><a class="see-all" href="/mangas">Voltar ao catálogo</a></p></div>';
        });
    }

    function renderMangaDetail(manga) {
        var tags = manga.categories.map(function (category) {
            return '<a class="chip" href="/mangas?category=' + category.id + '">'
                + Ui.escape(category.name) + '</a>';
        }).join('');

        return '<p style="margin: 28px 0 0;"><a class="see-all" href="/mangas">← Voltar ao catálogo</a></p>'
            + '<div class="detail">'
            + '<div class="detail-cover"><div class="cover">' + Ui.cover(manga) + '</div></div>'
            + '<div><h1>' + Ui.escape(manga.title) + '</h1>'
            + '<p class="byline">' + Ui.escape(manga.type_name)
            + (manga.author_name ? ' · ' + Ui.escape(manga.author_name) : '') + '</p>'
            + '<div class="detail-tags">'
            + '<span class="badge badge-' + Ui.escape(manga.status) + '">'
            + Ui.escape(manga.status_label || Ui.statusLabel(manga.status)) + '</span>' + tags + '</div>'
            + '<dl>'
            + '<dt>Tipo</dt><dd>' + (Ui.escape(manga.type_name) || '—') + '</dd>'
            + '<dt>Autor</dt><dd>' + (Ui.escape(manga.author_name) || '—') + '</dd>'
            + '<dt>Status</dt><dd>' + Ui.escape(manga.status_label || Ui.statusLabel(manga.status)) + '</dd>'
            + '<dt>Atualizado em</dt><dd>' + Ui.escape(manga.updated_at || manga.created_at || '—') + '</dd>'
            + '</dl>'
            + '<h2 style="font-size: 18px;">Sinopse</h2>'
            + '<p class="synopsis">' + (manga.description ? Ui.escape(manga.description)
                : 'Sinopse ainda não disponível.') + '</p>'
            + '</div></div>';
    }

    /* ------------------------------------------------------- Autenticação */

    /**
     * Regras de validação personalizadas (espelham as regras do AuthService).
     * Cada checagem devolve a mensagem de erro ou string vazia quando o valor está ok.
     */
    var LOGIN_RULES = {
        login: [
            function (value) {
                return value === '' ? 'Informe seu e-mail ou nome de usuário.' : '';
            }
        ],
        password: [
            function (value) { return value === '' ? 'Informe sua senha.' : ''; }
        ]
    };

    var REGISTER_RULES = {
        name: [
            function (value) { return value === '' ? 'Informe seu nome.' : ''; },
            function (value) {
                return value.length < 3 ? 'O nome deve ter ao menos 3 caracteres.' : '';
            }
        ],
        username: [
            function (value) { return value === '' ? 'Escolha um nome de usuário.' : ''; },
            function (value) {
                return /^[a-zA-Z0-9_.-]{3,60}$/.test(value) ? ''
                    : 'Use de 3 a 60 caracteres: letras, números, ponto, hífen ou underline.';
            }
        ],
        email: [
            function (value) { return value === '' ? 'Informe seu e-mail.' : ''; },
            function (value) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(value) ? ''
                    : 'Informe um e-mail válido.';
            }
        ],
        password: [
            function (value) { return value === '' ? 'Crie uma senha.' : ''; },
            function (value) {
                return value.length < 8 ? 'A senha deve ter no mínimo 8 caracteres.' : '';
            }
        ],
        password_confirmation: [
            function (value) { return value === '' ? 'Repita a senha para confirmar.' : ''; },
            function (value, form) {
                return value !== Ui.value(form, 'password') ? 'A confirmação de senha não confere.' : '';
            }
        ]
    };

    function initLogin() {
        var form = Ui.qs('#login-form');
        if (!form) { return; }
        var alertBox = Ui.qs('#login-alert');
        var successBox = Ui.qs('#login-success');

        if (successBox && new URLSearchParams(window.location.search).get('reset') === '1') {
            Ui.alert(successBox, 'success', 'Senha redefinida com sucesso. Entre com a nova senha.');
        }

        Ui.watchValidation(form, LOGIN_RULES);

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Ui.clearAlert(alertBox);

            if (!Ui.validate(form, LOGIN_RULES)) { return; }

            Ui.setLoading(form, true);

            Api.post('/auth/login', {
                login: field(form, 'login'),
                password: field(form, 'password')
            }).then(function (res) {
                var user = (res.data && res.data.user) || {};
                window.location.href = Ui.canManage(user.role) ? '/admin' : '/dashboard';
            }).catch(function (err) {
                Ui.alert(alertBox, 'error', err.message || 'Não foi possível entrar.');
                Ui.setLoading(form, false);
            });
        });
    }

    function initRegister() {
        var form = Ui.qs('#register-form');
        if (!form) { return; }
        var alertBox = Ui.qs('#register-alert');

        Ui.watchValidation(form, REGISTER_RULES);

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Ui.clearAlert(alertBox);

            if (!Ui.validate(form, REGISTER_RULES)) { return; }

            Ui.setLoading(form, true);

            Api.post('/auth/register', {
                name: field(form, 'name'),
                username: field(form, 'username'),
                email: field(form, 'email'),
                password: field(form, 'password'),
                password_confirmation: field(form, 'password_confirmation')
            }).then(function () {
                window.location.href = '/dashboard';
            }).catch(function (err) {
                if (err.status === 422) {
                    Ui.showFieldErrors(form, err.errors);
                    Ui.alert(alertBox, 'error', 'Corrija os campos destacados abaixo.');
                } else {
                    Ui.alert(alertBox, 'error', err.message || 'Não foi possível criar a conta.');
                }
                Ui.setLoading(form, false);
            });
        });
    }

    /* ------------------------------------------------- Recuperar senha */

    var FORGOT_RULES = {
        email: [
            function (value) { return value === '' ? 'Informe seu e-mail.' : ''; },
            function (value) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(value) ? ''
                    : 'Informe um e-mail válido.';
            }
        ]
    };

    var RESET_RULES = {
        password: [
            function (value) { return value === '' ? 'Crie uma senha.' : ''; },
            function (value) {
                return value.length < 8 ? 'A senha deve ter no mínimo 8 caracteres.' : '';
            }
        ],
        password_confirmation: [
            function (value) { return value === '' ? 'Repita a senha para confirmar.' : ''; },
            function (value, form) {
                return value !== Ui.value(form, 'password') ? 'A confirmação de senha não confere.' : '';
            }
        ]
    };

    function initForgot() {
        var form = Ui.qs('#forgot-form');
        if (!form) { return; }
        var alertBox = Ui.qs('#forgot-alert');
        var successBox = Ui.qs('#forgot-success');

        Ui.watchValidation(form, FORGOT_RULES);

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Ui.clearAlert(alertBox);
            Ui.clearAlert(successBox);

            if (!Ui.validate(form, FORGOT_RULES)) { return; }

            Ui.setLoading(form, true);

            Api.post('/auth/forgot-password', { email: field(form, 'email') }).then(function (res) {
                Ui.setLoading(form, false);
                form.reset();
                Ui.alert(successBox, 'success', res.message
                    || 'Se este e-mail estiver cadastrado, enviaremos um link para redefinir a senha.');
            }).catch(function (err) {
                if (err.status === 422) {
                    Ui.showFieldErrors(form, err.errors);
                    Ui.alert(alertBox, 'error', 'Verifique o e-mail informado.');
                } else {
                    Ui.alert(alertBox, 'error', err.message || 'Não foi possível enviar o link.');
                }
                Ui.setLoading(form, false);
            });
        });
    }

    function initReset() {
        var form = Ui.qs('#reset-form');
        if (!form) { return; }
        var alertBox = Ui.qs('#reset-alert');

        Ui.watchValidation(form, RESET_RULES);

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Ui.clearAlert(alertBox);

            if (!Ui.validate(form, RESET_RULES)) { return; }

            Ui.setLoading(form, true);

            Api.post('/auth/reset-password', {
                token: config.token || '',
                password: field(form, 'password'),
                password_confirmation: field(form, 'password_confirmation')
            }).then(function () {
                window.location.href = '/login?reset=1';
            }).catch(function (err) {
                if (err.errors && err.errors.token) {
                    Ui.alert(alertBox, 'error', (err.errors.token || [])[0]);
                } else if (err.status === 422) {
                    Ui.showFieldErrors(form, err.errors);
                    Ui.alert(alertBox, 'error', 'Corrija os campos destacados abaixo.');
                } else {
                    Ui.alert(alertBox, 'error', err.message || 'Não foi possível redefinir a senha.');
                }
                Ui.setLoading(form, false);
            });
        });
    }

    /* ------------------------------------------------------------- Painel */

    function initDashboard() {
        var container = Ui.qs('#dashboard-body');
        if (!container) { return; }

        Api.get('/auth/me').then(function (res) {
            var user = res.data;
            container.innerHTML = '<div class="page-head"><h1>Olá, ' + Ui.escape(user.name)
                + '</h1><a class="btn btn-ghost" href="/">Ver site</a></div>'
                + '<div class="card"><p class="muted">Você está autenticado (sessão compartilhada com a API).</p>'
                + '<dl style="display: grid; grid-template-columns: auto 1fr; gap: 10px 20px; margin: 0;">'
                + kv('ID', user.id)
                + kv('Nome', user.name)
                + kv('Usuário', user.username)
                + kv('E-mail', user.email)
                + kv('Perfil', '<span class="badge">' + Ui.escape(user.role_label || Ui.roleLabel(user.role)) + '</span>')
                + kv('Desde', user.created_at)
                + '</dl></div>';
        }).catch(function (err) {
            if (err.status === 401) {
                window.location.href = '/login';
                return;
            }
            container.innerHTML = '<div class="alert alert-error">' + Ui.escape(err.message) + '</div>';
        });
    }

    function kv(label, value) {
        return '<dt class="muted">' + Ui.escape(label) + '</dt>'
            + '<dd style="margin: 0;">' + (value == null ? '—' : value) + '</dd>';
    }

    /* ------------------------------------------------------------ Roteador */

    var pages = {
        'home': initHome,
        'catalog': initCatalog,
        'manga-show': initMangaShow,
        'login': initLogin,
        'register': initRegister,
        'forgot': initForgot,
        'reset': initReset,
        'dashboard': initDashboard
    };

    document.addEventListener('DOMContentLoaded', function () {
        bindLogout();
        var init = pages[config.page];
        if (init) { init(); }
    });
})(window, document);
