/**
 * This file is used to display the search on the screen.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		const searchContainer = document.querySelector(
			'.header-search-container'
		);
		searchContainer?.addEventListener('click', function () {
			const searchForm = document.querySelector('.search-form');
			const searchInput = document.getElementById('search-input');
			searchForm.style.display = 'flex';

			searchForm?.addEventListener('click', function () {
				searchForm.style.display = 'none';
			});

			searchInput?.addEventListener('click', function (e) {
				e.stopPropagation();
			});
		});
	});
})();
