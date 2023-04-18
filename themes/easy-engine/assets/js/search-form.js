/**
 * This file contains the code for the search form.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		const searchButton = document.getElementById('search');
		const closeButton = document.getElementById('search-close');
		const searchInput = document.getElementById('search-input');
		const searchForm = document.querySelector('.search-form');

		searchButton?.addEventListener('click', toggleSearch);
		closeButton?.addEventListener('click', toggleSearch);

		function toggleSearch() {
			if (searchButton?.getAttribute('aria-expanded') === 'false') {
				searchButton?.setAttribute('aria-expanded', 'true');
				closeButton?.setAttribute('aria-expanded', 'true');

				if (searchForm !== null) {
					searchForm.style.width = '200px';
					searchForm.style.opacity = '1';
					searchForm.style.overflow = 'visible';
					searchInput?.focus();
				}
			} else {
				searchButton?.setAttribute('aria-expanded', 'false');
				closeButton?.setAttribute('aria-expanded', 'false');

				if (searchForm !== null) {
					searchForm.style.width = '0';
					searchForm.style.opacity = '0';
					searchForm.style.overflow = 'hidden';
					searchInput?.blur();
				}
			}

			searchButton.classList.toggle('hidden');
			closeButton?.classList.toggle('hidden');
		}
	});
})();
