/**
 * This file contains the code for the language switcher. and expanded menu open close functionality.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		expandMenu();
		languageSwitcher();
		openMenu();
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
	const hamburgerMenuIcon = document.querySelector('#hamburger_menu_icon');
	const closeMenuIcon = document.querySelector('#close_menu_icon');
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

		hamburgerMenuIcon?.classList.toggle('hidden');

		closeMenuIcon?.classList.toggle('hidden');
	});
}

/**
 * This function is used to open and close the individual menus in the header menu in mobile view.
 */
function openMenu() {
	const exploreBtn = document.getElementById('explore-btn');
	let exploreOpen = true;
	const exploreMenu = document.querySelector(
		'.primary-menu-expanded-explore-menu-list'
	);

	exploreBtn?.addEventListener('click', function () {
		if (exploreMenu !== null) {
			if (exploreOpen) {
				exploreMenu.style.maxHeight = '0';
				exploreMenu.style.overflow = 'hidden';
				exploreOpen = false;
				exploreBtn.style.transform = 'rotate(0deg)';
			} else {
				exploreMenu.style.maxHeight = '1000px';
				exploreMenu.style.overflow = 'visible';
				exploreOpen = true;
				exploreBtn.style.transform = 'rotate(180deg)';
			}
		}
	});

	const settingsBtn = document.getElementById('settings-btn');
	let settingsOpen = true;
	const settingsMenu = document.querySelector(
		'.primary-menu-expanded-settings-menu-list'
	);

	settingsBtn?.addEventListener('click', function () {
		if (settingsMenu !== null) {
			if (settingsOpen) {
				settingsMenu.style.maxHeight = '0';
				settingsMenu.style.overflow = 'hidden';
				settingsOpen = false;
				settingsBtn.style.transform = 'rotate(0deg)';
			} else {
				settingsMenu.style.maxHeight = '1000px';
				settingsMenu.style.overflow = 'visible';
				settingsOpen = true;
				settingsBtn.style.transform = 'rotate(180deg)';
			}
		}
	});
}
