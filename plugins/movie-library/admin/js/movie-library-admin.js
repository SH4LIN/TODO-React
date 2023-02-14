( function ( $ ) {
	'use strict';

	let attrs, attr, postType;
	postType = null;

	$(function()
		{
			attrs = $( 'body' ).attr( 'class' ).split( ' ' );
			for ( attr in attrs ) {
				if ( attrs.hasOwnProperty( attr ) && attrs[ attr ].indexOf( 'post-type-' ) === 0 ) {
					postType = attrs[ attr ].replace( 'post-type-', '' );
				}
			}
			if(postType === 'rt-movie') {
				wp.i18n.setLocaleData(
					{
						'Excerpt': [ 'Synopsis' ],
						'Write an excerpt (optional)': [ 'Write a synopsis' ],
					}
				);
			}


		}
	);
} )( jQuery );
