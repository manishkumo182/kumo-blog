(function () {
	'use strict';

	var button = document.querySelector( '.like-button' );
	if ( ! button || typeof kumoLikes === 'undefined' ) {
		return;
	}

	var postId   = button.getAttribute( 'data-post-id' );
	var storeKey = 'kumo_liked_' + postId;
	var countEl  = button.querySelector( '.like-button__count' );

	if ( window.localStorage && window.localStorage.getItem( storeKey ) ) {
		button.classList.add( 'is-liked' );
		button.disabled = true;
	}

	button.addEventListener( 'click', function () {
		if ( button.disabled ) {
			return;
		}
		button.disabled = true;

		var data = new FormData();
		data.append( 'action', 'kumo_like_post' );
		data.append( 'post_id', postId );
		data.append( 'nonce', button.getAttribute( 'data-nonce' ) );

		fetch( kumoLikes.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: data } )
			.then( function ( response ) { return response.json(); } )
			.then( function ( json ) {
				if ( json.success ) {
					countEl.textContent = json.data.count;
					button.classList.add( 'is-liked' );
					if ( window.localStorage ) {
						window.localStorage.setItem( storeKey, '1' );
					}
				} else {
					button.disabled = false;
				}
			} )
			.catch( function () {
				button.disabled = false;
			} );
	} );
})();
