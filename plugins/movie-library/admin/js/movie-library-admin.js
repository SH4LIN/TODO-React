/**
 * Movie Library Media Meta JS
 * This file is used to upload images and videos to the metadata.
 *
 * @package MovieLib
 */

/**
 * This function will be called when document is ready and it will set all the required event listeners for uploading images and videos.
 *
 * @param {object} $ jQuery object.
 */
jQuery(function ($) {
	$(document).ready(function ($) {
		'use strict';

		setupMediaMetaImagesUploader($);
		setupMediaMetaVideosUploader($);
	});
});

/**
 * This function will be called when document is ready and it will set all the required event listeners for uploading images.
 *
 * @param $
 */
function setupMediaMetaImagesUploader($) {
	const { __, _x, _n, sprintf } = wp.i18n;

	let rt_media_meta_images = [];
	let rt_media_meta_selected_images_container = $(
		'.rt-media-meta-selected-images-container'
	);
	let rt_media_meta_images_frame;

	setInputValue(
		$,
		'input[name="rt-media-meta-selected-images"]',
		JSON.stringify(rt_media_meta_images)
	);

	$('.rt-media-meta-uploaded-image-remove').on('click', function (e) {
		let rt_uploaded_images = getInputValue(
			$,
			'input[name="rt-media-meta-uploaded-images"]'
		);

		e.preventDefault();

		rt_uploaded_images = rt_uploaded_images.filter(function (item) {
			return item !== $(e.currentTarget).data('id');
		});

		$(this).parent().remove();

		if (rt_uploaded_images.length === 0) {
			$('.rt-media-meta-uploaded-images-heading').remove();
		}

		setInputValue(
			$,
			'input[name="rt-media-meta-uploaded-images"]',
			JSON.stringify(rt_uploaded_images)
		);
	});

	$('.rt-media-meta-images-add').on('click', function (e) {
		e.preventDefault();

		if (rt_media_meta_images_frame) {
			rt_media_meta_images_frame.open();
			return;
		}

		rt_media_meta_images_frame = wp.media({
			title: __('Select Images', 'movie-library'),
			button: {
				text: __('Select Images', 'movie-library'),
			},
			library: {
				type: 'image',
			},
			multiple: true,
		});

		rt_media_meta_images_frame.on('select', function (e) {
			let rt_media_meta_images_attachment = rt_media_meta_images_frame
				.state()
				.get('selection')
				.toJSON();

			if (rt_media_meta_images.length === 0) {
				rt_media_meta_selected_images_container.append(
					"<h3 class='rt-media-meta-heading rt-media-meta-images-heading rt-media-meta-selected-images-heading'>" +
						__('Selected Images', 'movie-library') +
						'</h3>'
				);
			}

			$.each(rt_media_meta_images_attachment, function (index, value) {
				rt_media_meta_images.push(value.id);

				rt_media_meta_selected_images_container.append(
					'<div class="rt-media-meta rt-media-meta-image rt-media-meta-selected-image"><img src="' +
						encodeURI(value.url) +
						'" alt=""><span class="rt-media-meta-remove rt-media-meta-image-remove rt-media-meta-selected-image-remove" data-id="' +
						value.id +
						'">X</span></div>'
				);
			});

			$('.rt-media-meta-selected-image-remove').on('click', function (e) {
				e.preventDefault();

				rt_media_meta_images = rt_media_meta_images.filter(function (
					item
				) {
					return item !== $(e.currentTarget).data('id');
				});

				$(this).parent().remove();

				if (rt_media_meta_images.length === 0) {
					$('.rt-media-meta-selected-images-heading').remove();
				}

				setInputValue(
					$,
					'input[name="rt-media-meta-selected-images"]',
					JSON.stringify(rt_media_meta_images)
				);
			});

			setInputValue(
				$,
				'input[name="rt-media-meta-selected-images"]',
				JSON.stringify(rt_media_meta_images)
			);
		});

		rt_media_meta_images_frame.open();
	});
}

/**
 * This function will be called when document is ready and it will set all the required event listeners for uploading videos.
 *
 * @param $
 */
function setupMediaMetaVideosUploader($) {
	const { __, _x, _n, sprintf } = wp.i18n;

	let rt_media_meta_videos = [];
	let rt_media_meta_selected_videos_container = $(
		'.rt-media-meta-selected-videos-container'
	);
	let rt_media_meta_videos_frame;

	setInputValue(
		$,
		'input[name="rt-media-meta-selected-videos"]',
		JSON.stringify(rt_media_meta_videos)
	);
	$('.rt-media-meta-uploaded-video-remove').on('click', function (e) {
		e.preventDefault();

		let rt_uploaded_videos = getInputValue(
			$,
			'input[name="rt-media-meta-uploaded-videos"]'
		);

		rt_uploaded_videos = rt_uploaded_videos.filter(function (item) {
			return item !== $(e.currentTarget).data('id');
		});

		$(this).parent().remove();

		if (rt_uploaded_videos.length === 0) {
			$('.rt-media-meta-uploaded-videos-heading').remove();
		}

		setInputValue(
			$,
			'input[name="rt-media-meta-uploaded-videos"]',
			JSON.stringify(rt_uploaded_videos)
		);
	});

	$('.rt-media-meta-videos-add').on('click', function (e) {
		e.preventDefault();

		if (rt_media_meta_videos_frame) {
			rt_media_meta_videos_frame.open();
			return;
		}

		rt_media_meta_videos_frame = wp.media({
			title: __('Select Videos', 'movie-library'),
			button: {
				text: __('Select Videos', 'movie-library'),
			},
			library: {
				type: 'video',
			},
			multiple: true,
		});

		rt_media_meta_videos_frame.on('select', function (e) {
			e.preventDefault();

			let rt_media_meta_videos_attachment = rt_media_meta_videos_frame
				.state()
				.get('selection')
				.toJSON();

			if (rt_media_meta_videos.length === 0) {
				rt_media_meta_selected_videos_container.append(
					"<h3 class='rt-media-meta-heading rt-media-meta-videos-heading rt-media-meta-selected-videos-heading'>" +
						__('Selected Videos', 'movie-library') +
						'</h3>'
				);
			}

			$.each(rt_media_meta_videos_attachment, function (index, value) {
				rt_media_meta_videos.push(value.id);
				rt_media_meta_selected_videos_container.append(
					'<div class="rt-media-meta rt-media-meta-video rt-media-meta-selected-video"><video controls><source src="' +
						encodeURI(value.url) +
						'"></video><span class="rt-media-meta-remove rt-media-meta-video-remove rt-media-meta-selected-video-remove" data-id="' +
						value.id +
						'">X</span></div>'
				);
			});

			$('.rt-media-meta-selected-video-remove').on('click', function (e) {
				e.preventDefault();

				rt_media_meta_videos = rt_media_meta_videos.filter(function (
					item
				) {
					return item !== $(e.currentTarget).data('id');
				});

				$(this).parent().remove();

				if (rt_media_meta_videos.length === 0) {
					$('.rt-media-meta-selected-videos-heading').remove();
				}

				setInputValue(
					$,
					'input[name="rt-media-meta-selected-videos"]',
					JSON.stringify(rt_media_meta_videos)
				);
			});

			setInputValue(
				$,
				'input[name="rt-media-meta-selected-videos"]',
				JSON.stringify(rt_media_meta_videos)
			);
		});

		rt_media_meta_videos_frame.open();
	});
}

/**
 * This function will return the value of the input field.
 *
 * @param $
 * @param selector
 * @returns {any}
 */
function getInputValue($, selector) {
	return JSON.parse($(selector).val());
}

/**
 * This function will set the value of the input field.
 *
 * @param $
 * @param selector
 * @param value
 */
function setInputValue($, selector, value) {
	$(selector).val(value);
}
