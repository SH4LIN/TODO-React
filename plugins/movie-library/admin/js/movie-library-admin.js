/**
 * Movie Library Media Meta JS
 * This file is used to upload images and videos to the metadata.
 *
 * @package MovieLib
 */

jQuery(
	function ( $ ) {
		$( document ).ready(
			function ( $ ) {
				'use strict';

				const { __, _x, _n, sprintf } = wp.i18n;
				setupMediaMetaImagesUploader( $ );
				setupMediaMetaVideosUploader( $ );

			}
		);
	}
);


function setupMediaMetaImagesUploader( $ ) {
	let rt_media_meta_images = [];
	let rt_media_meta_selected_images_container = $( '.rt-media-meta-selected-images-container' );
	let rt_media_meta_images_frame;

	$( 'input[name="rt-media-meta-selected-images"]' ).val( JSON.stringify( rt_media_meta_images ) );
	$( '.rt-media-meta-uploaded-image-remove' ).on(
		'click',
		function ( e ) {
			let rt_uploaded_images = JSON.parse( $( 'input[name="rt-media-meta-uploaded-images"]' ).val() );
			e.preventDefault();
			rt_uploaded_images = rt_uploaded_images.filter(
				function ( item ) {
					return item !== $( e.currentTarget ).data( 'id' );
				}
			);
			$( this ).parent().remove();
			if ( rt_uploaded_images.length === 0 ) {
				$( '.rt-media-meta-uploaded-images-heading' ).remove();
			}
			$( 'input[name="rt-media-meta-uploaded-images"]' ).val( JSON.stringify( rt_uploaded_images ) );
		}
	);

	$( '.rt-media-meta-images-add' ).on(
		'click',
		function ( e ) {
			e.preventDefault();
			if ( rt_media_meta_images_frame ) {
				rt_media_meta_images_frame.open();
				return;
			}

			rt_media_meta_images_frame = wp.media(
				{
					title: 'Select Images',
					button: {
						text: 'Select Images'
					},
					library: {
						type: 'image'
					},
					multiple: true
				}
			);

			rt_media_meta_images_frame.on(
				'select',
				function ( e ) {
					let rt_media_meta_images_attachment = rt_media_meta_images_frame.state().get( 'selection' ).toJSON();
					console.log( rt_media_meta_images.length );
					if ( rt_media_meta_images.length === 0 ) {
						console.log( rt_media_meta_images.length );
						rt_media_meta_selected_images_container.append( "<h3 class='rt-media-meta-heading rt-media-meta-images-heading rt-media-meta-selected-images-heading'>Selected Images</h3>" );
					}

					$.each(
						rt_media_meta_images_attachment,
						function ( index, value ) {
							rt_media_meta_images.push( value.id );
							rt_media_meta_selected_images_container.append(
								'<div class="rt-media-meta rt-media-meta-image rt-media-meta-selected-image"><img src="' + encodeURI( value.url ) + '" alt=""><span class="rt-media-meta-remove rt-media-meta-image-remove rt-media-meta-selected-image-remove" data-id="' + value.id + '">X</span></div>'
							);

						}
					);

					$( '.rt-media-meta-selected-image-remove' ).on(
						'click',
						function ( e ) {
							e.preventDefault();
							rt_media_meta_images = rt_media_meta_images.filter(
								function ( item ) {
									return item !== $( e.currentTarget ).data( 'id' );
								}
							);
							$( this ).parent().remove();
							if ( rt_media_meta_images.length === 0 ) {
								$( '.rt-media-meta-selected-images-heading' ).remove();
							}
							$( 'input[name="rt-media-meta-selected-images"]' ).val( JSON.stringify( rt_media_meta_images ) );
						}
					);

					$( 'input[name="rt-media-meta-selected-images"]' ).val( JSON.stringify( rt_media_meta_images ) );
				}
			);
			rt_media_meta_images_frame.open();
		}
	);
}

function setupMediaMetaVideosUploader( $ ) {
	let rt_media_meta_videos = [];
	let rt_media_meta_selected_videos_container = $( '.rt-media-meta-selected-videos-container' );
	let rt_media_meta_videos_frame;

	$( 'input[name="rt-media-meta-selected-videos"]' ).val( JSON.stringify( rt_media_meta_videos ) );
	$( '.rt-media-meta-uploaded-video-remove' ).on(
		'click',
		function ( e ) {
			console.log( 'hello' );
			let rt_uploaded_videos = JSON.parse( $( 'input[name="rt-media-meta-uploaded-videos"]' ).val() );
			e.preventDefault();
			rt_uploaded_videos = rt_uploaded_videos.filter(
				function ( item ) {
					return item !== $( e.currentTarget ).data( 'id' );
				}
			);
			$( this ).parent().remove();
			if ( rt_uploaded_videos.length === 0 ) {
				$( '.rt-media-meta-uploaded-videos-heading' ).remove();
			}
			$( 'input[name="rt-media-meta-uploaded-videos"]' ).val( JSON.stringify( rt_uploaded_videos ) );
		}
	);

	$( '.rt-media-meta-videos-add' ).on(
		'click',
		function ( e ) {
			e.preventDefault();
			if ( rt_media_meta_videos_frame ) {
				rt_media_meta_videos_frame.open();
				return;
			}

			rt_media_meta_videos_frame = wp.media(
				{
					title: 'Select Videos',
					button: {
						text: 'Select Videos'
					},
					library: {
						type: 'video'
					},
					multiple: true
				}
			);

			rt_media_meta_videos_frame.on(
				'select',
				function ( e ) {
					let rt_media_meta_videos_attachment = rt_media_meta_videos_frame.state().get( 'selection' ).toJSON();
					console.log( rt_media_meta_videos_attachment );
					if ( rt_media_meta_videos.length === 0 ) {
						rt_media_meta_selected_videos_container.append( "<h3 class='rt-media-meta-heading rt-media-meta-videos-heading rt-media-meta-selected-videos-heading'>Selected Videos</h3>" );
					}

					$.each(
						rt_media_meta_videos_attachment,
						function ( index, value ) {
							rt_media_meta_videos.push( value.id );
							rt_media_meta_selected_videos_container.append(
								'<div class="rt-media-meta rt-media-meta-video rt-media-meta-selected-video"><video controls><source src="' + encodeURI( value.url ) + '"></video><span class="rt-media-meta-remove rt-media-meta-video-remove rt-media-meta-selected-video-remove" data-id="' + value.id + '">X</span></div>'
							);

						}
					);

					$( '.rt-media-meta-selected-video-remove' ).on(
						'click',
						function ( e ) {
							e.preventDefault();
							rt_media_meta_videos = rt_media_meta_videos.filter(
								function ( item ) {
									return item !== $( e.currentTarget ).data( 'id' );
								}
							);
							$( this ).parent().remove();
							if ( rt_media_meta_videos.length === 0 ) {
								$( '.rt-media-meta-selected-videos-heading' ).remove();
							}
							$( 'input[name="rt-media-meta-selected-videos"]' ).val( JSON.stringify( rt_media_meta_videos ) );
						}
					);

					$( 'input[name="rt-media-meta-selected-videos"]' ).val( JSON.stringify( rt_media_meta_videos ) );
				}
			);
			rt_media_meta_videos_frame.open();
		}
	);
}
