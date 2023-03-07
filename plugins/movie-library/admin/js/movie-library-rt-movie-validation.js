/**
 * This file is used to apply front-end validation to the rt-movie meta-boxes.
 */

/**
 * This IIFE will be called and according to the post type it will call the validation function.
 */
(function () {
	'use strict';

	validateRtMovie();
})();

let submit;
let isRatingValid = true;
let isRuntimeValid = true;

window.onload = function () {
	submit = document.querySelector('.editor-post-publish-button__button');
};

/**
 * This function is used to validate the rt-movie post type.
 */
function validateRtMovie() {
	const { __ } = wp.i18n;

	document
		.getElementById('rt-movie-meta-basic-rating')
		.addEventListener('input', function (e) {
			if (e.target.value !== '') {
				if (
					e.target.value > 10 ||
					e.target.value < 0 ||
					isNaN(+e.target.value)
				) {
					document.getElementById(
						'rt-movie-meta-basic-rating-field-error'
					).textContent = __(
						'Value should be between 0 and 10',
						'movie-library'
					);
					isRatingValid = false;
					changeRtMovieButtonState();
				} else {
					document.getElementById(
						'rt-movie-meta-basic-rating-field-error'
					).textContent = '';
					isRatingValid = true;
					changeRtMovieButtonState();
				}
			} else {
				document.getElementById(
					'rt-movie-meta-basic-rating-field-error'
				).textContent = '';
				isRatingValid = true;
				changeRtMovieButtonState();
			}
		});

	document
		.getElementById('rt-movie-meta-basic-runtime')
		.addEventListener('input', function (e) {
			if (e.target.value !== '') {
				if (
					e.target.value > 1000 ||
					e.target.value < 1 ||
					isNaN(+e.target.value)
				) {
					document.getElementById(
						'rt-movie-meta-basic-runtime-field-error'
					).textContent = __(
						'Value should be between 1 and 1000',
						'movie-library'
					);
					isRuntimeValid = false;
					changeRtMovieButtonState();
				} else {
					document.getElementById(
						'rt-movie-meta-basic-runtime-field-error'
					).textContent = '';
					isRuntimeValid = true;
					changeRtMovieButtonState();
				}
			} else {
				document.getElementById(
					'rt-movie-meta-basic-runtime-field-error'
				).textContent = '';
				isRuntimeValid = true;
				changeRtMovieButtonState();
			}
		});
}

/**
 * This function is used to enable or disable the publish button on rt-movie post type.
 */
function changeRtMovieButtonState() {
	if (isRatingValid && isRuntimeValid) {
		submit.disabled = false;
	} else {
		submit.disabled = true;
	}
}
