/**
 * This file contains the code for the language switcher. and expanded menu open close functionality.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		expandMenu();
		languageSwitcher();
	});
})();

/**
 * This function contains the code for the language switcher.
 */
function languageSwitcher() {
	const languageSwitch = document.querySelector('.header-language-container');
	const dropDownButton = document.querySelector(
		'.header-language-container img'
	);
	let down = true;
	if (dropDownButton !== null) {
		languageSwitch?.addEventListener('click', function () {
			if (down) {
				dropDownButton.style.transform = 'rotate(180deg)';
				down = false;
			} else {
				dropDownButton.style.transform = 'rotate(0deg)';
				down = true;
			}
		});
	}
}

/**
 * This function is used to open and close the header menu in mobile view.
 */
function expandMenu() {
	const menu = document.querySelector('.header-menu-container');
	let isExpandedMenuHidden = true;

	menu?.addEventListener('click', function () {
		const expandedMenu = document.querySelector(
			'.primary-menu-expanded-container'
		);
		if (expandedMenu !== null) {
			if (!isExpandedMenuHidden) {
				expandedMenu.style.height = '0';
				isExpandedMenuHidden = true;
			} else {
				expandedMenu.style.height = '1000px';
				isExpandedMenuHidden = false;
			}
		}
		const hamburgerMenuIcon = document.querySelector(
			'#hamburger_menu_icon'
		);
		if (hamburgerMenuIcon !== null) {
			hamburgerMenuIcon.classList.toggle('hidden');
		}
		const closeMenuIcon = document.querySelector('#close_menu_icon');
		if (closeMenuIcon !== null) {
			closeMenuIcon.classList.toggle('hidden');
		}
	});
}
