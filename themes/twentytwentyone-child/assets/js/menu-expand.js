(function () {
	document.querySelector( ".st-header-menu-container" ).addEventListener(
		'click',
		function (e) {
			document.querySelector( '.st-header-primary-menu-expanded-container' ).classList.toggle( 'hidden' );
			document.querySelector( '#hamburger_menu_icon' ).classList.toggle( 'hidden' );
			document.querySelector( '#close_menu_icon' ).classList.toggle( 'hidden' );
		}
	);
})();
