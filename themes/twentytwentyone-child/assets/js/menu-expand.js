/**
 * This file is used to open and close the header menu in mobile view.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		const menu = document.querySelector('.st-header-menu-container');
		if (menu !== null) {
			menu.addEventListener('click', function () {
				const expandedMenu = document.querySelector(
					'.st-header-primary-menu-expanded-container'
				);
				if (expandedMenu !== null) {
					expandedMenu.classList.toggle('hidden');
				}
				const hamburgerMenuIcon = document.querySelector(
					'#hamburger_menu_icon'
				);
				if (hamburgerMenuIcon !== null) {
					hamburgerMenuIcon.classList.toggle('hidden');
				}
				const closeMenuIcon =
					document.querySelector('#close_menu_icon');
				if (closeMenuIcon !== null) {
					closeMenuIcon.classList.toggle('hidden');
				}
			});
		}
	});
})();
