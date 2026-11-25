/* Zamin theme interactions. No external dependencies. */
(function () {
  'use strict';

  var config = window.zaminConfig || {};

  function ready(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn);
    } else {
      fn();
    }
  }

  ready(function () {
    initMenu();
    initForms();
    initCounters();
    initSort();
    initSavedListings();
    initDependentAreas();
    initSearchHistory();
  });

  /* Mobile navigation -------------------------------------------------- */
  function initMenu() {
    var toggle = document.querySelector('.z-menu-toggle');
    var nav = document.getElementById('zamin-primary-nav');
    if (!toggle || !nav) return;

    toggle.addEventListener('click', function () {
      var open = document.body.classList.toggle('zamin-menu-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    });

    nav.addEventListener('click', function (event) {
      if (event.target.closest('a') && document.body.classList.contains('zamin-menu-open')) {
        document.body.classList.remove('zamin-menu-open');
        toggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  /* AJAX forms --------------------------------------------------------- */
  function initForms() {
    var forms = document.querySelectorAll('form[data-zamin-form]');
    Array.prototype.forEach.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        event.preventDefault();

        var message = form.querySelector('[data-form-message]');
        var button = form.querySelector('button[type="submit"]');
        var original = button ? button.textContent : '';

        if (message) {
          message.className = 'z-form-message';
          message.textContent = '';
        }
        if (button) {
          button.disabled = true;
          button.textContent = 'Sending…';
        }

        var data = new FormData(form);
        data.append('action', 'zamin_form_submit');

        fetch(config.ajaxUrl || '/wp-admin/admin-ajax.php', {
          method: 'POST',
          body: data,
          credentials: 'same-origin'
        })
          .then(function (response) { return response.json(); })
          .then(function (result) {
            if (message) {
              var success = !!(result && result.success);
              message.className = 'z-form-message z-form-message--' + (success ? 'ok' : 'err') + ' is-visible';
              message.textContent = (result && result.data && result.data.message)
                ? result.data.message
                : 'Something went wrong. Please try again.';
              if (success) form.reset();
            }
          })
          .catch(function () {
            if (message) {
              message.className = 'z-form-message z-form-message--err is-visible';
              message.textContent = 'Could not send your message. Please check your connection or call us.';
            }
          })
          .finally(function () {
            if (button) {
              button.disabled = false;
              button.textContent = original;
            }
          });
      });
    });
  }

  /* Character counters -------------------------------------------------- */
  function initCounters() {
    var fields = document.querySelectorAll('[data-counter]');
    Array.prototype.forEach.call(fields, function (field) {
      var counter = field.parentElement.querySelector('.z-field__counter');
      if (!counter) return;
      var update = function () { counter.textContent = field.value.length + '/' + field.maxLength; };
      field.addEventListener('input', update);
      update();
    });
  }

  /* Sort dropdown ------------------------------------------------------- */
  function initSort() {
    var selects = document.querySelectorAll('[data-sort-select]');
    Array.prototype.forEach.call(selects, function (select) {
      select.addEventListener('change', function () {
        var url = new URL(window.location.href);
        url.searchParams.set('sort', select.value);
        window.location.href = url.toString();
      });
    });
  }

  /* Saved listings stored locally, per the site's privacy policy -------- */
  function initSavedListings() {
    var key = 'zamin_saved_listings';
    var saved = [];
    try { saved = JSON.parse(localStorage.getItem(key) || '[]'); } catch (e) { saved = []; }

    function paint() {
      var buttons = document.querySelectorAll('[data-save-listing]');
      Array.prototype.forEach.call(buttons, function (button) {
        var id = button.getAttribute('data-save-listing');
        var isSaved = saved.indexOf(id) !== -1;
        button.classList.toggle('is-saved', isSaved);
        button.innerHTML = isSaved ? '&#9829;' : '&#9825;';
        button.setAttribute('aria-pressed', isSaved ? 'true' : 'false');
      });
    }

    document.addEventListener('click', function (event) {
      var button = event.target.closest('[data-save-listing]');
      if (!button) return;
      event.preventDefault();
      var id = button.getAttribute('data-save-listing');
      var index = saved.indexOf(id);
      if (index === -1) saved.push(id); else saved.splice(index, 1);
      try { localStorage.setItem(key, JSON.stringify(saved)); } catch (e) { /* private mode */ }
      paint();
    });

    paint();
  }

  /* Destination -> area select in the host application ----------------- */
  function initDependentAreas() {
    var selects = document.querySelectorAll('select[data-area-map]');
    Array.prototype.forEach.call(selects, function (select) {
      select.addEventListener('change', function () {
        var target = document.querySelector('select[name="' + select.getAttribute('data-dependent') + '"]');
        if (!target) return;
        var map = {};
        try { map = JSON.parse(select.getAttribute('data-area-map') || '{}'); } catch (e) { map = {}; }
        var areas = map[select.value] || [];
        target.innerHTML = '';
        var first = document.createElement('option');
        first.value = '';
        first.textContent = areas.length ? 'Choose an area' : 'Choose a destination first';
        target.appendChild(first);
        areas.forEach(function (area) {
          var option = document.createElement('option');
          option.value = area;
          option.textContent = area;
          target.appendChild(option);
        });
      });
    });
  }

  /* Remember recent search filters locally ------------------------------ */
  function initSearchHistory() {
    var searches = document.querySelectorAll('form.z-search-card');
    Array.prototype.forEach.call(searches, function (form) {
      form.addEventListener('submit', function () {
        try {
          var history = JSON.parse(localStorage.getItem('zamin_recent_searches') || '[]');
          var entry = { path: form.getAttribute('action'), params: {}, at: Date.now() };
          Array.prototype.forEach.call(new FormData(form).entries(), function (pair) {
            if (pair[1]) entry.params[pair[0]] = pair[1];
          });
          history.unshift(entry);
          localStorage.setItem('zamin_recent_searches', JSON.stringify(history.slice(0, 10)));
        } catch (e) { /* private mode */ }
      });
    });
  }
})();
