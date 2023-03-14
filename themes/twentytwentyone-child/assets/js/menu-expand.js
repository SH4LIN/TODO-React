/**
 * This file is used to open and close the header menu in mobile view.
 */
(function () {
	document
		.querySelector('.st-header-menu-container')
		.addEventListener('click', function () {
			document
				.querySelector('.st-header-primary-menu-expanded-container')
				.classList.toggle('hidden');
			document
				.querySelector('#hamburger_menu_icon')
				.classList.toggle('hidden');
			document
				.querySelector('#close_menu_icon')
				.classList.toggle('hidden');
		});
})();
