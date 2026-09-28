(function () {
	'use strict';

	function getConfig() {
		return window.NovaShopTheme || {};
	}

	function postAjax(data) {
		var config = getConfig();
		var body = new window.FormData();

		Object.keys(data).forEach(function (key) {
			body.append(key, data[key]);
		});

		body.append('nonce', config.nonce || '');

		return window.fetch(config.ajaxUrl || '', {
			method: 'POST',
			credentials: 'same-origin',
			body: body
		}).then(function (response) {
			return response.json();
		});
	}

	function togglePanel(button, target) {
		var isOpen = button.getAttribute('aria-expanded') === 'true';
		button.setAttribute('aria-expanded', String(!isOpen));

		if (target.hasAttribute('hidden')) {
			target.removeAttribute('hidden');
		} else {
			target.setAttribute('hidden', '');
		}

		target.classList.toggle('is-open', !isOpen);
	}

	function updateCollectionCount(type, count) {
		document.querySelectorAll('[data-novashop-count="' + type + '"]').forEach(function (item) {
			item.textContent = String(count);
		});
	}

	function ensureModal() {
		var modal = document.querySelector('[data-novashop-modal]');

		if (modal) {
			return modal;
		}

		modal = document.createElement('div');
		modal.className = 'novashop-modal';
		modal.setAttribute('data-novashop-modal', '');
		modal.setAttribute('hidden', '');
		modal.innerHTML = '<div class="novashop-modal__overlay" data-novashop-modal-close></div><div class="novashop-modal__dialog" role="dialog" aria-modal="true"><button class="novashop-modal__close" type="button" data-novashop-modal-close>' + ((getConfig().i18n && getConfig().i18n.close) || 'Close') + '</button><div class="novashop-modal__body" data-novashop-modal-body></div></div>';
		document.body.appendChild(modal);

		modal.addEventListener('click', function (event) {
			if (event.target.hasAttribute('data-novashop-modal-close')) {
				modal.setAttribute('hidden', '');
			}
		});

		return modal;
	}

	document.addEventListener('DOMContentLoaded', function () {
		var navToggle = document.querySelector('.site-nav-toggle');
		var nav = document.querySelector('.site-navigation');
		var searchToggle = document.querySelector('.site-search-toggle');
		var searchPanel = document.getElementById('site-search-panel');

		if (navToggle && nav) {
			navToggle.addEventListener('click', function () {
				var isOpen = navToggle.getAttribute('aria-expanded') === 'true';
				navToggle.setAttribute('aria-expanded', String(!isOpen));
				nav.classList.toggle('is-open', !isOpen);
			});
		}

		if (searchToggle && searchPanel) {
			searchToggle.addEventListener('click', function () {
				togglePanel(searchToggle, searchPanel);

				if (!searchPanel.hasAttribute('hidden')) {
					var searchInput = searchPanel.querySelector('input[type="search"]');
					if (searchInput) {
						searchInput.focus();
					}
				}
			});
		}

		document.addEventListener('click', function (event) {
			var collectionButton = event.target.closest('[data-novashop-collection]');
			var quickViewButton = event.target.closest('[data-novashop-quick-view]');

			if (collectionButton) {
				event.preventDefault();
				collectionButton.disabled = true;

				postAjax({
					action: 'novashop_toggle_collection',
					type: collectionButton.getAttribute('data-novashop-collection'),
					productId: collectionButton.getAttribute('data-product-id')
				}).then(function (response) {
					if (response && response.success && response.data) {
						collectionButton.classList.toggle('is-active', Boolean(response.data.active));
						updateCollectionCount(response.data.type, response.data.count);
					}
				}).finally(function () {
					collectionButton.disabled = false;
				});
			}

			if (quickViewButton) {
				event.preventDefault();
				quickViewButton.disabled = true;

				postAjax({
					action: 'novashop_quick_view',
					productId: quickViewButton.getAttribute('data-novashop-quick-view')
				}).then(function (response) {
					var modal = ensureModal();
					var body = modal.querySelector('[data-novashop-modal-body]');

					if (response && response.success && response.data && body) {
						body.innerHTML = response.data.html;
						modal.removeAttribute('hidden');
					}
				}).finally(function () {
					quickViewButton.disabled = false;
				});
			}
		});

		document.querySelectorAll('[data-novashop-product-filters]').forEach(function (form) {
			form.addEventListener('submit', function (event) {
				var wrapper = form.closest('[data-novashop-ajax-products]');
				var results = wrapper ? wrapper.querySelector('[data-novashop-filter-results]') : null;
				var data = {
					action: 'novashop_filter_products'
				};

				event.preventDefault();

				new window.FormData(form).forEach(function (value, key) {
					data[key] = value;
				});

				form.classList.add('is-loading');

				postAjax(data).then(function (response) {
					if (response && response.success && response.data && results) {
						results.innerHTML = response.data.html;
					}
				}).finally(function () {
					form.classList.remove('is-loading');
				});
			});
		});
	});
}());
