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
		'.primary-menu-expanded-explore-menu'
	);

	exploreBtn?.addEventListener('click', function () {
		if (exploreMenu !== null) {
			if (exploreOpen) {
				exploreMenu.style.display = 'none';
				exploreBtn.style.transform = 'rotate(0deg)';
				exploreOpen = false;
			} else {
				exploreMenu.style.display = 'block';
				exploreBtn.style.transform = 'rotate(180deg)';
				exploreOpen = true;
			}
		}
	});

	const settingsBtn = document.getElementById('settings-btn');
	let settingsOpen = true;
	const settingsMenu = document.querySelector(
		'.primary-menu-expanded-settings-menu'
	);

	settingsBtn?.addEventListener('click', function () {
		if (settingsMenu !== null) {
			if (settingsOpen) {
				settingsMenu.style.display = 'none';
				settingsBtn.style.transform = 'rotate(0deg)';
				settingsOpen = false;
			} else {
				settingsMenu.style.display = 'block';
				settingsBtn.style.transform = 'rotate(180deg)';
				settingsOpen = true;
			}
		}
	});
}
