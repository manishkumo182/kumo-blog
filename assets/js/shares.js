(function () {
	'use strict';

	var links = document.querySelectorAll( '.post-share a[data-share-network]' );
	var totalEl = document.querySelector( '.post-share__total-count' );

	if ( ! links.length || typeof kumoShares === 'undefined' ) {
		return;
	}

	links.forEach( function ( link ) {
		link.addEventListener( 'click', function () {
			var data = new FormData();
			data.append( 'action', 'kumo_share_post' );
			data.append( 'post_id', link.getAttribute( 'data-post-id' ) );
			data.append( 'nonce', link.getAttribute( 'data-nonce' ) );
			data.append( 'network', link.getAttribute( 'data-share-network' ) );

			fetch( kumoShares.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: data } )
				.then( function ( response ) { return response.json(); } )
				.then( function ( json ) {
					if ( json.success && totalEl ) {
						totalEl.textContent = json.data.count;
					}
				} );
		} );
	} );
})();
