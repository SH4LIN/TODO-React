/**
 * Movie Library Admin JS
 * This file is used to upload images and videos to the metadata.
 */

/**
 * This function will be called when document is ready and it will set all the required event listeners for uploading images and videos.
 *
 * @param {Object} $ jQuery object.
 */
jQuery(function ($) {
	$(document).ready(function () {
		'use strict';

		setupMediaMetaImagesUploader($);
		setupMediaMetaVideosUploader($);
	});
});

/**
 * This function will be called when document is ready and it will set all the required event listeners for uploading images.
 *
 * @param {Object} $
 */
function setupMediaMetaImagesUploader($) {
	const { __ } = wp.i18n;

	let rtMediaMetaImages = [];
	const rtMediaMetaSelectedImagesContainer = $(
		'.rt-media-meta-selected-images-container'
	);
	let rtMediaMetaImagesFrame;

	setInputValue(
		$,
		'input[name="rt-media-meta-selected-images"]',
		JSON.stringify(rtMediaMetaImages)
	);

	$('.rt-media-meta-uploaded-image-remove').on('click', function (e) {
		let rtUploadedImages = getInputValue(
			$,
			'input[name="rt-media-meta-uploaded-images"]'
		);

		e.preventDefault();

		rtUploadedImages = rtUploadedImages.filter(function (item) {
			return item !== $(e.currentTarget).data('id');
		});

		$(this).parent().remove();

		if (rtUploadedImages.length === 0) {
			$('.rt-media-meta-uploaded-images-heading').remove();
		}

		setInputValue(
			$,
			'input[name="rt-media-meta-uploaded-images"]',
			JSON.stringify(rtUploadedImages)
		);
	});

	$('.rt-media-meta-images-add').on('click', function (e) {
		if (rtMediaMetaImagesFrame) {
			rtMediaMetaImagesFrame.open();
			return;
		}

		rtMediaMetaImagesFrame = wp.media({
			title: __('Select Images', 'movie-library'),
			button: {
				text: __('Select Images', 'movie-library'),
			},
			library: {
				type: 'image',
			},
			multiple: true,
		});

		rtMediaMetaImagesFrame.on('select', function () {
			const rtMediaMetaImagesAttachment = rtMediaMetaImagesFrame
				.state()
				.get('selection')
				.toJSON();

			if (rtMediaMetaImages.length === 0) {
				rtMediaMetaSelectedImagesContainer.append(
					"<h3 class='rt-media-meta-heading rt-media-meta-images-heading rt-media-meta-selected-images-heading'>" +
						__('Selected Images', 'movie-library') +
						'</h3>'
				);
			}

			$.each(rtMediaMetaImagesAttachment, function (index, value) {
				rtMediaMetaImages.push(value.id);

				rtMediaMetaSelectedImagesContainer.append(
					'<div class="rt-media-meta rt-media-meta-image rt-media-meta-selected-image"><img src="' +
						encodeURI(value.url) +
						'" alt=""><span class="rt-media-meta-remove rt-media-meta-image-remove rt-media-meta-selected-image-remove" data-id="' +
						value.id +
						'">X</span></div>'
				);
			});

			$('.rt-media-meta-selected-image-remove').on('click', function () {
				rtMediaMetaImages = rtMediaMetaImages.filter(function (item) {
					return item !== $(e.currentTarget).data('id');
				});

				$(this).parent().remove();

				if (rtMediaMetaImages.length === 0) {
					$('.rt-media-meta-selected-images-heading').remove();
				}

				setInputValue(
					$,
					'input[name="rt-media-meta-selected-images"]',
					JSON.stringify(rtMediaMetaImages)
				);
			});

			setInputValue(
				$,
				'input[name="rt-media-meta-selected-images"]',
				JSON.stringify(rtMediaMetaImages)
			);
		});

		rtMediaMetaImagesFrame.open();
	});
}

/**
 * This function will be called when document is ready and it will set all the required event listeners for uploading videos.
 *
 * @param {Object} $
 */
function setupMediaMetaVideosUploader($) {
	const { __ } = wp.i18n;

	let rtMediaMetaVideos = [];
	const rtMediaMetaSelectedVideosContainer = $(
		'.rt-media-meta-selected-videos-container'
	);
	let rtMediaMetaVideosFrame;

	setInputValue(
		$,
		'input[name="rt-media-meta-selected-videos"]',
		JSON.stringify(rtMediaMetaVideos)
	);
	$('.rt-media-meta-uploaded-video-remove').on('click', function (e) {
		e.preventDefault();

		let rtUploadedVideos = getInputValue(
			$,
			'input[name="rt-media-meta-uploaded-videos"]'
		);

		rtUploadedVideos = rtUploadedVideos.filter(function (item) {
			return item !== $(e.currentTarget).data('id');
		});

		$(this).parent().remove();

		if (rtUploadedVideos.length === 0) {
			$('.rt-media-meta-uploaded-videos-heading').remove();
		}

		setInputValue(
			$,
			'input[name="rt-media-meta-uploaded-videos"]',
			JSON.stringify(rtUploadedVideos)
		);
	});

	$('.rt-media-meta-videos-add').on('click', function (e) {
		e.preventDefault();

		if (rtMediaMetaVideosFrame) {
			rtMediaMetaVideosFrame.open();
			return;
		}

		rtMediaMetaVideosFrame = wp.media({
			title: __('Select Videos', 'movie-library'),
			button: {
				text: __('Select Videos', 'movie-library'),
			},
			library: {
				type: 'video',
			},
			multiple: true,
		});

		rtMediaMetaVideosFrame.on('select', function () {
			const rtMediaMetaVideosAttachment = rtMediaMetaVideosFrame
				.state()
				.get('selection')
				.toJSON();

			if (rtMediaMetaVideos.length === 0) {
				rtMediaMetaSelectedVideosContainer.append(
					"<h3 class='rt-media-meta-heading rt-media-meta-videos-heading rt-media-meta-selected-videos-heading'>" +
						__('Selected Videos', 'movie-library') +
						'</h3>'
				);
			}

			$.each(rtMediaMetaVideosAttachment, function (index, value) {
				rtMediaMetaVideos.push(value.id);
				rtMediaMetaSelectedVideosContainer.append(
					'<div class="rt-media-meta rt-media-meta-video rt-media-meta-selected-video"><video controls><source src="' +
						encodeURI(value.url) +
						'"></video><span class="rt-media-meta-remove rt-media-meta-video-remove rt-media-meta-selected-video-remove" data-id="' +
						value.id +
						'">X</span></div>'
				);
			});

			$('.rt-media-meta-selected-video-remove').on(
				'click',
				function (evt) {
					evt.preventDefault();

					rtMediaMetaVideos = rtMediaMetaVideos.filter(function (
						item
					) {
						return item !== $(evt.currentTarget).data('id');
					});

					$(this).parent().remove();

					if (rtMediaMetaVideos.length === 0) {
						$('.rt-media-meta-selected-videos-heading').remove();
					}

					setInputValue(
						$,
						'input[name="rt-media-meta-selected-videos"]',
						JSON.stringify(rtMediaMetaVideos)
					);
				}
			);

			setInputValue(
				$,
				'input[name="rt-media-meta-selected-videos"]',
				JSON.stringify(rtMediaMetaVideos)
			);
		});

		rtMediaMetaVideosFrame.open();
	});
}

/**
 * This function will return the value of the input field.
 *
 * @param {Object} $
 * @param {string} selector
 */
function getInputValue($, selector) {
	return JSON.parse($(selector).val());
}

/**
 * This function will set the value of the input field.
 *
 * @param {Object} $
 * @param {string} selector
 * @param {string} value
 */
function setInputValue($, selector, value) {
	$(selector).val(value);
}
