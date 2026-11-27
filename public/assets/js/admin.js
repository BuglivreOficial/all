/*
 * BugLivre — comportamento da área administrativa.
 * Consome a API (/api) para dashboard e CRUDs (categorias, tipos, autores, mangás).
 */
(function (window, document) {
    'use strict';

    var config = window.BUGLIVRE || {};

    /* Entidades simples (mesma estrutura: nome + campo de texto + status). */
    var SIMPLE = {
        categories: { path: '/categories', field: 'description', label: 'categoria' },
        types: { path: '/types', field: 'description', label: 'tipo' },
        authors: { path: '/authors', field: 'bio', label: 'autor' }
    };

    var SIMPLE_PAGES = {
        'admin-categories': 'categories',
        'admin-types': 'types',
        'admin-authors': 'authors'
    };

    function field(form, name) {
        return form.elements[name] ? String(form.elements[name].value || '').trim() : '';
    }

    function setField(form, name, value) {
        if (form.elements[name]) { form.elements[name].value = value == null ? '' : value; }
    }

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

    /* ------------------------------------------------------------ Dashboard */

    function initDashboard() {
        var body = Ui.qs('#users-table-body');
        if (!body) { return; }

        Api.get('/users').then(function (res) {
            var users = res.data || [];
            if (!users.length) {
                body.innerHTML = '<tr><td colspan="6" class="muted">Nenhum usuário cadastrado.</td></tr>';
                return;
            }
            body.innerHTML = users.map(function (user) {
                return '<tr>'
                    + '<td>' + user.id + '</td>'
                    + '<td>' + Ui.escape(user.name) + '</td>'
                    + '<td class="muted">' + Ui.escape(user.username) + '</td>'
                    + '<td class="muted">' + Ui.escape(user.email) + '</td>'
                    + '<td><span class="badge">' + Ui.escape(user.role_label || Ui.roleLabel(user.role)) + '</span></td>'
                    + '<td class="muted">' + Ui.escape(user.created_at) + '</td>'
                    + '</tr>';
            }).join('');
        }).catch(function (err) {
            body.innerHTML = '<tr><td colspan="6" class="muted">' + Ui.escape(err.message) + '</td></tr>';
        });
    }

    /* -------------------------------------------------------- Entidades simples */

    function initSimple(kind) {
        var cfg = SIMPLE[kind];
        if (!cfg) { return; }

        var createForm = Ui.qs('#entity-create-form');
        var editForm = Ui.qs('#entity-edit-form');
        var alertBox = Ui.qs('#entity-alert');

        if (createForm) {
            createForm.addEventListener('submit', function (event) {
                event.preventDefault();
                submitSimple(cfg, createForm, null, alertBox);
            });
            loadSimpleList(cfg, alertBox);
        }

        if (editForm) {
            var id = config.id;
            Api.get(cfg.path + '/' + id).then(function (res) {
                var item = res.data;
                setField(editForm, 'name', item.name);
                setField(editForm, cfg.field, item[cfg.field] || '');
                var slug = Ui.qs('#entity-slug');
                if (slug) { slug.textContent = item.slug; }
            }).catch(function (err) {
                Ui.alert(alertBox, 'error', err.message);
            });

            editForm.addEventListener('submit', function (event) {
                event.preventDefault();
                submitSimple(cfg, editForm, id, alertBox);
            });
        }
    }

    function submitSimple(cfg, form, id, alertBox) {
        Ui.clearAlert(alertBox);
        Ui.clearFieldErrors(form);
        Ui.setLoading(form, true);

        var payload = { name: field(form, 'name') };
        payload[cfg.field] = field(form, cfg.field);

        var request = id === null ? Api.post(cfg.path, payload) : Api.put(cfg.path + '/' + id, payload);

        request.then(function () {
            if (id === null) {
                form.reset();
                Ui.setLoading(form, false);
                Ui.alert(alertBox, 'success', 'Registro criado com sucesso.');
                loadSimpleList(cfg, alertBox);
            } else {
                window.location.href = window.location.pathname.replace(/\/\d+\/edit$/, '');
            }
        }).catch(function (err) {
            Ui.setLoading(form, false);
            if (err.status === 422) {
                Ui.showFieldErrors(form, err.errors);
                Ui.alert(alertBox, 'error', 'Corrija os campos destacados abaixo.');
            } else {
                Ui.alert(alertBox, 'error', err.message);
            }
        });
    }

    function loadSimpleList(cfg, alertBox) {
        var body = Ui.qs('#entity-table-body');
        if (!body) { return; }

        Api.get(cfg.path).then(function (res) {
            var items = res.data || [];
            if (!items.length) {
                body.innerHTML = '<tr><td colspan="6" class="muted">Nenhum registro cadastrado.</td></tr>';
                return;
            }
            body.innerHTML = items.map(function (item) {
                return '<tr>'
                    + '<td>' + item.id + '</td>'
                    + '<td>' + Ui.escape(item.name) + '</td>'
                    + '<td class="muted">' + Ui.escape(item.slug) + '</td>'
                    + '<td class="muted">' + Ui.escape(Ui.excerpt(item[cfg.field] || '', 80)) + '</td>'
                    + '<td><span class="badge ' + (item.is_active ? '' : 'badge-off') + '">'
                    + (item.is_active ? 'Ativo' : 'Inativo') + '</span></td>'
                    + '<td><div class="actions">'
                    + '<a class="btn-link" href="' + window.location.pathname.replace(/\/$/, '')
                    + '/' + item.id + '/edit">Editar</a>'
                    + '<button type="button" class="btn-muted btn-sm" data-toggle="' + item.id + '">'
                    + (item.is_active ? 'Desativar' : 'Ativar') + '</button>'
                    + '<button type="button" class="btn-danger btn-sm" data-delete="' + item.id
                    + '" data-name="' + Ui.escape(item.name) + '">Excluir</button>'
                    + '</div></td></tr>';
            }).join('');
            bindRowActions(cfg, body, alertBox);
        }).catch(function (err) {
            body.innerHTML = '<tr><td colspan="6" class="muted">' + Ui.escape(err.message) + '</td></tr>';
        });
    }

    function bindRowActions(cfg, body, alertBox) {
        Ui.qsa('[data-toggle]', body).forEach(function (button) {
            button.addEventListener('click', function () {
                Api.post(cfg.path + '/' + button.dataset.toggle + '/status').then(function () {
                    loadSimpleList(cfg, alertBox);
                }).catch(function (err) {
                    Ui.alert(alertBox, 'error', err.message);
                });
            });
        });

        Ui.qsa('[data-delete]', body).forEach(function (button) {
            button.addEventListener('click', function () {
                if (!window.confirm('Excluir "' + button.dataset.name + '"? Esta ação não pode ser desfeita.')) {
                    return;
                }
                Api.delete(cfg.path + '/' + button.dataset.delete).then(function () {
                    loadSimpleList(cfg, alertBox);
                }).catch(function (err) {
                    Ui.alert(alertBox, 'error', err.message);
                });
            });
        });
    }

    /* --------------------------------------------------------------- Mangás */

    function initMangasIndex() {
        var form = Ui.qs('#manga-filters');
        var body = Ui.qs('#manga-table-body');
        if (!form || !body) { return; }
        var alertBox = Ui.qs('#manga-alert');

        Promise.all([
            Api.get('/categories'),
            Api.get('/types')
        ]).then(function (responses) {
            fillSelect(form.elements['category'], responses[0].data || [], 'Todas');
            fillSelect(form.elements['type'], responses[1].data || [], 'Todos');
        }).catch(function () {});

        function load() {
            var query = [];
            var q = field(form, 'q');
            var category = field(form, 'category');
            var type = field(form, 'type');
            if (q) { query.push('q=' + encodeURIComponent(q)); }
            if (category) { query.push('category=' + encodeURIComponent(category)); }
            if (type) { query.push('type=' + encodeURIComponent(type)); }

            Api.get('/mangas' + (query.length ? '?' + query.join('&') : '')).then(function (res) {
                var mangas = res.data || [];
                if (!mangas.length) {
                    body.innerHTML = '<tr><td colspan="9" class="muted">Nenhum mangá encontrado.</td></tr>';
                    return;
                }
                body.innerHTML = mangas.map(renderMangaRow).join('');
                bindMangaActions(body, alertBox);
            }).catch(function (err) {
                body.innerHTML = '<tr><td colspan="9" class="muted">' + Ui.escape(err.message) + '</td></tr>';
            });
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            load();
        });

        load();
    }

    function renderMangaRow(manga) {
        var cover = manga.cover
            ? '<img src="' + Ui.escape(manga.cover) + '" alt="" class="thumb" loading="lazy">'
            : '<span class="muted">—</span>';
        var categories = (manga.category_names || []).join(', ') || '—';
        return '<tr>'
            + '<td>' + manga.id + '</td>'
            + '<td>' + cover + '</td>'
            + '<td>' + Ui.escape(manga.title)
            + '<div class="muted" style="font-size: 12px;">' + Ui.escape(manga.slug) + '</div></td>'
            + '<td>' + (manga.type_name ? '<span class="badge">' + Ui.escape(manga.type_name) + '</span>'
                : '<span class="muted">—</span>') + '</td>'
            + '<td>' + Ui.escape(categories) + '</td>'
            + '<td class="muted">' + (Ui.escape(manga.author_name) || '—') + '</td>'
            + '<td><span class="badge badge-' + Ui.escape(manga.status) + '">'
            + Ui.escape(manga.status_label || Ui.statusLabel(manga.status)) + '</span></td>'
            + '<td><span class="badge ' + (manga.is_active ? '' : 'badge-off') + '">'
            + (manga.is_active ? 'Ativo' : 'Inativo') + '</span></td>'
            + '<td><div class="actions">'
            + '<a class="btn-link" href="/admin/mangas/' + manga.id + '/edit">Editar</a>'
            + '<button type="button" class="btn-muted btn-sm" data-toggle="' + manga.id + '">'
            + (manga.is_active ? 'Desativar' : 'Ativar') + '</button>'
            + '<button type="button" class="btn-danger btn-sm" data-delete="' + manga.id
            + '" data-name="' + Ui.escape(manga.title) + '">Excluir</button>'
            + '</div></td></tr>';
    }

    function bindMangaActions(body, alertBox) {
        Ui.qsa('[data-toggle]', body).forEach(function (button) {
            button.addEventListener('click', function () {
                Api.post('/mangas/' + button.dataset.toggle + '/status').then(function () {
                    Ui.qs('#manga-filters').dispatchEvent(new Event('submit', { cancelable: true }));
                }).catch(function (err) {
                    Ui.alert(alertBox, 'error', err.message);
                });
            });
        });

        Ui.qsa('[data-delete]', body).forEach(function (button) {
            button.addEventListener('click', function () {
                if (!window.confirm('Excluir "' + button.dataset.name + '"? Esta ação não pode ser desfeita.')) {
                    return;
                }
                Api.delete('/mangas/' + button.dataset.delete).then(function () {
                    Ui.qs('#manga-filters').dispatchEvent(new Event('submit', { cancelable: true }));
                }).catch(function (err) {
                    Ui.alert(alertBox, 'error', err.message);
                });
            });
        });
    }

    function initMangaForm() {
        var form = Ui.qs('#manga-form');
        if (!form) { return; }
        var alertBox = Ui.qs('#manga-alert');
        var isEdit = config.mode === 'edit' && config.id;

        Promise.all([
            Api.get('/categories'),
            Api.get('/types'),
            Api.get('/authors')
        ]).then(function (responses) {
            fillSelect(form.elements['type_id'], responses[1].data || [], 'Selecione um tipo...');
            fillSelect(form.elements['author_id'], responses[2].data || [], 'Sem autor');
            renderCategoryChips(form, responses[0].data || []);

            if (isEdit) {
                return Api.get('/mangas/' + config.id).then(function (res) {
                    fillMangaForm(form, res.data);
                });
            }
        }).catch(function (err) {
            Ui.alert(alertBox, 'error', err.message);
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            submitManga(form, alertBox, isEdit);
        });
    }

    function fillMangaForm(form, manga) {
        setField(form, 'title', manga.title);
        setField(form, 'type_id', manga.type_id);
        setField(form, 'author_id', manga.author_id || '');
        setField(form, 'status', manga.status);
        setField(form, 'cover', manga.cover || '');
        setField(form, 'description', manga.description || '');

        var selected = (manga.categories || []).map(function (category) { return String(category.id); });
        setCategoryChips(form, selected);

        var slug = Ui.qs('#manga-slug');
        if (slug) { slug.textContent = manga.slug; }
        if (manga.cover) {
            var preview = Ui.qs('#manga-cover-preview');
            if (preview) { preview.innerHTML = '<img src="' + Ui.escape(manga.cover) + '" alt="" class="thumb" style="width: 88px; height: 124px;">'; }
        }
    }

    function submitManga(form, alertBox, isEdit) {
        Ui.clearAlert(alertBox);
        Ui.clearFieldErrors(form);
        Ui.setLoading(form, true);

        var fileInput = form.elements['cover_file'];
        var hasFile = fileInput && fileInput.files && fileInput.files.length > 0;
        var request;

        if (hasFile) {
            var formData = new FormData(form);
            request = Api.form(isEdit ? '/mangas/' + config.id : '/mangas', formData);
        } else {
            var selected = form.elements['category_ids']
                ? Array.prototype.map.call(form.elements['category_ids'].selectedOptions, function (option) {
                    return parseInt(option.value, 10);
                })
                : [];
            var payload = {
                title: field(form, 'title'),
                type_id: parseInt(field(form, 'type_id'), 10) || 0,
                author_id: field(form, 'author_id') || null,
                category_ids: selected,
                status: field(form, 'status'),
                cover: field(form, 'cover'),
                description: field(form, 'description')
            };
            request = isEdit ? Api.put('/mangas/' + config.id, payload) : Api.post('/mangas', payload);
        }

        request.then(function () {
            window.location.href = '/admin/mangas';
        }).catch(function (err) {
            Ui.setLoading(form, false);
            if (err.status === 422) {
                Ui.showFieldErrors(form, err.errors);
                Ui.alert(alertBox, 'error', 'Corrija os campos destacados abaixo.');
            } else {
                Ui.alert(alertBox, 'error', err.message);
            }
        });
    }

    /* ------------------------------------------------------------- Utilitários */

    function fillSelect(select, items, placeholder, selected) {
        if (!select) { return; }
        var options = ['<option value="">' + Ui.escape(placeholder) + '</option>'];
        items.forEach(function (item) {
            options.push('<option value="' + item.id + '"'
                + (String(selected) === String(item.id) ? ' selected' : '') + '>'
                + Ui.escape(item.name) + (item.is_active ? '' : ' (inativo)') + '</option>');
        });
        select.innerHTML = options.join('');
    }

    /**
     * Seleção múltipla de categorias como chips.
     *
     * Os chips são a interface visível; o `<select multiple hidden name="category_ids">`
     * continua sendo a fonte de dados do formulário (usado pelo payload JSON e pelo
     * FormData quando há upload de capa).
     */
    function renderCategoryChips(form, items) {
        var box = Ui.qs('#manga-category-chips', form);
        var select = form.elements['category_ids'];
        if (!box || !select) { return; }

        select.innerHTML = items.map(function (item) {
            return '<option value="' + item.id + '">' + Ui.escape(item.name) + '</option>';
        }).join('');

        box.innerHTML = items.length
            ? items.map(function (item) {
                return '<button type="button" class="chip-toggle" data-category="' + item.id
                    + '" aria-pressed="false">' + Ui.escape(item.name)
                    + (item.is_active ? '' : ' (inativa)') + '</button>';
            }).join('')
            : '<p class="muted" style="font-size: 13px; margin: 0;">Nenhuma categoria cadastrada.</p>';

        box.addEventListener('click', function (event) {
            var chip = event.target.closest('button[data-category]');
            if (!chip) { return; }

            var option = select.querySelector('option[value="' + chip.dataset.category + '"]');
            var on = chip.getAttribute('aria-pressed') !== 'true';
            chip.setAttribute('aria-pressed', on ? 'true' : 'false');
            chip.classList.toggle('is-on', on);
            if (option) { option.selected = on; }
            Ui.clearFieldError(select);
        });
    }

    /** Aplica aos chips e ao select oculto a lista de IDs de categoria. */
    function setCategoryChips(form, ids) {
        var box = Ui.qs('#manga-category-chips', form);
        var select = form.elements['category_ids'];
        if (!box || !select) { return; }

        var values = (ids || []).map(String);
        Ui.qsa('option', select).forEach(function (option) {
            option.selected = values.indexOf(option.value) !== -1;
        });
        Ui.qsa('button[data-category]', box).forEach(function (chip) {
            var on = values.indexOf(chip.dataset.category) !== -1;
            chip.setAttribute('aria-pressed', on ? 'true' : 'false');
            chip.classList.toggle('is-on', on);
        });
    }

    /* -------------------------------------------------------------- Roteador */

    function route() {
        bindLogout();

        if (config.page === 'admin-dashboard') {
            initDashboard();
            return;
        }
        if (SIMPLE_PAGES[config.page]) {
            initSimple(SIMPLE_PAGES[config.page]);
            return;
        }
        if (config.page === 'admin-mangas') {
            if (config.mode === 'index') { initMangasIndex(); } else { initMangaForm(); }
        }
    }

    document.addEventListener('DOMContentLoaded', route);
})(window, document);
