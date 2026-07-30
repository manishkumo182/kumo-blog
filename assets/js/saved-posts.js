(function () {
	'use strict';

	var list = document.getElementById( 'saved-posts-list' );
	var emptyMsg = document.getElementById( 'saved-posts-empty' );
	if ( ! list || ! emptyMsg || ! window.localStorage || typeof kumoSaved === 'undefined' ) {
		return;
	}

	var ids = [];
	for ( var i = 0; i < window.localStorage.length; i++ ) {
		var key = window.localStorage.key( i );
		if ( key.indexOf( 'kumo_saved_' ) === 0 ) {
			ids.push( key.replace( 'kumo_saved_', '' ) );
		}
	}

	if ( ! ids.length ) {
		return;
	}

	emptyMsg.style.display = 'none';

	fetch( kumoSaved.restUrl + 'wp/v2/posts?include=' + ids.join( ',' ) + '&_embed=1&per_page=' + ids.length )
		.then( function ( response ) { return response.json(); } )
		.then( function ( posts ) {
			if ( ! Array.isArray( posts ) || ! posts.length ) {
				emptyMsg.style.display = '';
				return;
			}

			posts.forEach( function ( post ) {
				var media = post._embedded && post._embedded[ 'wp:featuredmedia' ] && post._embedded[ 'wp:featuredmedia' ][ 0 ];
				var imgUrl = media && media.source_url ? media.source_url : '';
				var date = new Date( post.date ).toLocaleDateString( undefined, { year: 'numeric', month: 'short', day: 'numeric' } );

				var article = document.createElement( 'article' );
				article.className = 'post-card';
				article.innerHTML =
					'<a href="' + post.link + '" class="post-card__media">' +
						( imgUrl ? '<img src="' + imgUrl + '" alt="" loading="lazy" />' : '' ) +
					'</a>' +
					'<span class="post-card__meta"><span class="author__date">' + date + '</span></span>' +
					'<h3 class="post-card__title"><a href="' + post.link + '">' + post.title.rendered + '</a></h3>' +
					'<button type="button" class="post-card__readmore js-unsave" data-post-id="' + post.id + '">Remove from saved</button>';

				list.appendChild( article );
			} );

			list.addEventListener( 'click', function ( e ) {
				if ( ! e.target.classList.contains( 'js-unsave' ) ) {
					return;
				}
				var postId = e.target.getAttribute( 'data-post-id' );
				window.localStorage.removeItem( 'kumo_saved_' + postId );
				e.target.closest( '.post-card' ).remove();
				if ( ! list.children.length ) {
					emptyMsg.style.display = '';
				}
			} );
		} )
		.catch( function () {
			emptyMsg.style.display = '';
		} );
})();
