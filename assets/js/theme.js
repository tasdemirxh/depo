(function () {
	'use strict';

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
	});
}());
