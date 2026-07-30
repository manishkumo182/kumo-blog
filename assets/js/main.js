(function () {
	'use strict';

	var toggle = document.querySelector( '.menu-toggle' );
	var nav = document.getElementById( 'primary-menu' );

	if ( toggle && nav ) {
		toggle.addEventListener( 'click', function () {
			var expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
			toggle.setAttribute( 'aria-expanded', String( ! expanded ) );
			nav.classList.toggle( 'is-open' );
		} );
	}

	var saveButton = document.querySelector( '.save-button' );
	if ( saveButton && window.localStorage ) {
		var saveKey = 'kumo_saved_' + saveButton.getAttribute( 'data-post-id' );

		if ( window.localStorage.getItem( saveKey ) ) {
			saveButton.classList.add( 'is-saved' );
			saveButton.setAttribute( 'aria-pressed', 'true' );
		}

		saveButton.addEventListener( 'click', function () {
			var saved = saveButton.classList.toggle( 'is-saved' );
			saveButton.setAttribute( 'aria-pressed', String( saved ) );
			if ( saved ) {
				window.localStorage.setItem( saveKey, '1' );
			} else {
				window.localStorage.removeItem( saveKey );
			}
		} );
	}
})();
