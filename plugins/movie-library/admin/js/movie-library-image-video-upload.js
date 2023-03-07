/**
 * Movie Library Admin JS
 * This file is used to upload images and videos to the metadata.
 */

/**
 * This function will be called when document is ready and it will set all the required event listeners for uploading images and videos.
 *
 * @param {Object} $ jQuery object.
 */

'use strict';

setupMediaMetaImagesUploader();
setupMediaMetaVideosUploader();

/**
 * This function will be called when document is ready and it will set all the required event listeners for uploading images.
 */
function setupMediaMetaImagesUploader() {
	const { __ } = wp.i18n;

	let rtMediaMetaImages = [];
	const rtMediaMetaSelectedImagesContainer = document.querySelector(
		'.rt-media-meta-selected-images-container'
	);
	let rtMediaMetaImagesFrame;

	setInputValue(
		'input[name="rt-media-meta-selected-images"]',
		JSON.stringify(rtMediaMetaImages)
	);

	if (
		document.querySelector('.rt-media-meta-uploaded-image-remove') !== null
	) {
		document
			.querySelectorAll('.rt-media-meta-uploaded-image-remove')
			.forEach((span) => {
				span.addEventListener('click', function (e) {
					let rtUploadedImages = getInputValue(
						'input[name="rt-media-meta-uploaded-images"]'
					);

					e.preventDefault();

					rtUploadedImages = rtUploadedImages.filter(function (item) {
						return item !== +e.target.dataset.id;
					});

					e.target.parentElement.remove();

					if (rtUploadedImages.length === 0) {
						document
							.querySelector(
								'.rt-media-meta-uploaded-images-heading'
							)
							.remove();
					}

					setInputValue(
						'input[name="rt-media-meta-uploaded-images"]',
						JSON.stringify(rtUploadedImages)
					);
				});
			});
	}

	document
		.querySelector('.rt-media-meta-images-add')
		.addEventListener('click', function () {
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
					const heading = document.createElement('h3');
					heading.classList.add(
						'rt-media-meta-heading',
						'rt-media-meta-images-heading',
						'rt-media-meta-selected-images-heading'
					);
					heading.innerText = __('Selected Images', 'movie-library');
					document
						.querySelector('.rt-media-meta-images')
						.appendChild(heading);
				}

				rtMediaMetaImagesAttachment.forEach(function (value) {
					rtMediaMetaImages.push(value.id);

					const imageContainer = document.createElement('div');
					imageContainer.classList.add(
						'rt-media-meta',
						'rt-media-meta-image',
						'rt-media-meta-selected-image'
					);

					const image = document.createElement('img');
					image.src = encodeURI(value.sizes.thumbnail.url);
					image.alt = '';
					imageContainer.appendChild(image);

					const closeButton = document.createElement('span');
					closeButton.classList.add(
						'rt-media-meta-remove',
						'rt-media-meta-image-remove',
						'rt-media-meta-selected-image-remove'
					);
					closeButton.dataset.id = value.id;
					closeButton.innerText = 'X';
					imageContainer.appendChild(closeButton);

					rtMediaMetaSelectedImagesContainer.appendChild(
						imageContainer
					);
				});

				document
					.querySelectorAll('.rt-media-meta-selected-image-remove')
					.forEach((span) => {
						span.addEventListener('click', function (evt) {
							rtMediaMetaImages = rtMediaMetaImages.filter(
								function (item) {
									return item !== +evt.target.dataset.id;
								}
							);

							evt.target.parentElement.remove();

							if (rtMediaMetaImages.length === 0) {
								document
									.querySelector(
										'.rt-media-meta-selected-images-heading'
									)
									.remove();
							}

							setInputValue(
								'input[name="rt-media-meta-selected-images"]',
								JSON.stringify(rtMediaMetaImages)
							);
						});
					});

				setInputValue(
					'input[name="rt-media-meta-selected-images"]',
					JSON.stringify(rtMediaMetaImages)
				);
			});

			rtMediaMetaImagesFrame.open();
		});
}

/**
 * This function will be called when document is ready and it will set all the required event listeners for uploading videos.
 */
function setupMediaMetaVideosUploader() {
	const { __ } = wp.i18n;

	let rtMediaMetaVideos = [];
	const rtMediaMetaSelectedVideosContainer = document.querySelector(
		'.rt-media-meta-selected-videos-container'
	);
	let rtMediaMetaVideosFrame;

	setInputValue(
		'input[name="rt-media-meta-selected-videos"]',
		JSON.stringify(rtMediaMetaVideos)
	);

	if (
		document.querySelector('.rt-media-meta-uploaded-video-remove') !== null
	) {
		document
			.querySelectorAll('.rt-media-meta-uploaded-video-remove')
			.forEach((span) => {
				span.addEventListener('click', function (e) {
					e.preventDefault();

					let rtUploadedVideos = getInputValue(
						'input[name="rt-media-meta-uploaded-videos"]'
					);

					rtUploadedVideos = rtUploadedVideos.filter(function (item) {
						return item !== +e.target.dataset.id;
					});

					e.target.parentElement.remove();

					if (rtUploadedVideos.length === 0) {
						document
							.querySelector(
								'.rt-media-meta-uploaded-videos-heading'
							)
							.remove();
					}

					setInputValue(
						'input[name="rt-media-meta-uploaded-videos"]',
						JSON.stringify(rtUploadedVideos)
					);
				});
			});
	}

	document
		.querySelector('.rt-media-meta-videos-add')
		.addEventListener('click', function (e) {
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
					const heading = document.createElement('h3');
					heading.classList.add(
						'rt-media-meta-heading',
						'rt-media-meta-videos-heading',
						'rt-media-meta-selected-videos-heading'
					);
					heading.innerText = __('Selected Videos', 'movie-library');
					rtMediaMetaSelectedVideosContainer.appendChild(heading);
				}

				rtMediaMetaVideosAttachment.forEach(function (value) {
					rtMediaMetaVideos.push(value.id);
					const videoContainer = document.createElement('div');
					videoContainer.classList.add(
						'rt-media-meta',
						'rt-media-meta-video',
						'rt-media-meta-selected-video'
					);

					const video = document.createElement('video');
					video.controls = true;

					const videoSource = document.createElement('source');
					videoSource.src = encodeURI(value.url);
					video.appendChild(videoSource);
					videoContainer.appendChild(video);

					const closeButton = document.createElement('span');
					closeButton.classList.add(
						'rt-media-meta-remove',
						'rt-media-meta-video-remove',
						'rt-media-meta-selected-video-remove'
					);
					closeButton.dataset.id = value.id;
					closeButton.innerText = 'X';
					videoContainer.appendChild(closeButton);

					rtMediaMetaSelectedVideosContainer.appendChild(
						videoContainer
					);
				});

				document
					.querySelectorAll('.rt-media-meta-selected-video-remove')
					.forEach((span) => {
						span.addEventListener('click', function (evt) {
							evt.preventDefault();

							rtMediaMetaVideos = rtMediaMetaVideos.filter(
								function (item) {
									return item !== +evt.target.dataset.id;
								}
							);

							evt.target.parentElement.remove();

							if (rtMediaMetaVideos.length === 0) {
								document
									.querySelector(
										'.rt-media-meta-selected-videos-heading'
									)
									.remove();
							}

							setInputValue(
								'input[name="rt-media-meta-selected-videos"]',
								JSON.stringify(rtMediaMetaVideos)
							);
						});
					});

				setInputValue(
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
 * @param {string} selector
 */
function getInputValue(selector) {
	return JSON.parse(document.querySelector(selector).value);
}

/**
 * This function will set the value of the input field.
 *
 * @param {string} selector
 * @param {string} value
 */
function setInputValue(selector, value) {
	document.querySelector(selector).value = value;
}
