/**
 * Movie Library Admin JS
 * This file is used to add custom JS to the admin area.
 * It will change the label of the excerpt metabox to synopsis.
 *
 * @package MovieLib
 */

jQuery(
	function ( $ ) {
		$( document ).ready(
			function ( $ ) {
				'use strict';

				const { __, _x, _n, sprintf } = wp.i18n;
				let attrs, attr, postType;
				postType = null;
				attrs    = $( 'body' ).attr( 'class' ).split( ' ' );
				for ( attr in attrs ) {
					if ( attrs.hasOwnProperty( attr ) && attrs[ attr ].indexOf( 'post-type-' ) === 0 ) {
						postType = attrs[ attr ].replace( 'post-type-', '' );
					}
				}
				if ( postType === 'rt-movie' ) {
					wp.hooks.addFilter(
						'i18n.gettext',
						'movie-library',
						function ( translation, text, domain ) {
							if ( 'Excerpt' === text ) {
								return __( 'Synopsis', 'movie-library' );
							}
							if ( 'Write an excerpt (optional)' === text ) {
								return __( 'Write a synopsis', 'movie-library' );
							}
							return translation;
						}
					);

				}

			}
		);
	}
);
