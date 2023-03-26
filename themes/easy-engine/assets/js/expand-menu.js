/**
 * This file contains the code for the expanded menu open close settings.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		const menuButton = document.getElementById('menu');
		const closeButton = document.getElementById('close');
		const menuWrapper = document.querySelector('.expanded-menu-wrapper');

		menuButton?.addEventListener('click', toggleMenu);
		closeButton?.addEventListener('click', toggleMenu);

		function toggleMenu() {
			if (menuButton.getAttribute('aria-expanded') === 'false') {
				menuButton.setAttribute('aria-expanded', 'true');
				closeButton?.setAttribute('aria-expanded', 'true');

				if(menuWrapper != null){
					menuWrapper.style.width = "100%";
				}
			}else {
				menuButton.setAttribute('aria-expanded', 'false');
				closeButton?.setAttribute('aria-expanded', 'false');

				if(menuWrapper != null){
					menuWrapper.style.width = "0";
				}
			}

			menuButton.classList.toggle('hidden');
			closeButton?.classList.toggle('hidden');
		}
	});
})();