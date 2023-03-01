/**
 * This file is used to apply front-end validation to the rt-person meta-boxes.
 */

/**
 * This IIFE will be called and according to the post type it will call the validation function.
 */
(function () {
	'use strict';

	validateRtPerson();
})();

let submit;
let isTwitterUrlValid = true;
let isFacebookUrlValid = true;
let isInstagramUrlValid = true;
let isWebsiteUrlValid = true;

window.onload = function () {
	submit = document.querySelector('.editor-post-publish-button__button');
};

/**
 * This function is used to validate the rt-person post type.
 */
function validateRtPerson() {
	const { __ } = wp.i18n;

	document
		.querySelector('.rt-person-meta-social-twitter-field')
		.addEventListener('input', function (e) {
			if (e.target.value !== '') {
				if (!isUrlValid(e.target.value)) {
					document.getElementById(
						'rt-person-meta-social-twitter-field-error'
					).textContent = __(
						'Please enter a valid url',
						'movie-library'
					);
					isTwitterUrlValid = false;
					changeRtPersonButtonState();
				} else {
					document.getElementById(
						'rt-person-meta-social-twitter-field-error'
					).textContent = '';
					isTwitterUrlValid = true;
					changeRtPersonButtonState();
				}
			} else {
				document.getElementById(
					'rt-person-meta-social-twitter-field-error'
				).textContent = '';
				isTwitterUrlValid = true;
				changeRtPersonButtonState();
			}
		});

	document
		.querySelector('.rt-person-meta-social-facebook-field')
		.addEventListener('input', function (e) {
			if (e.target.value !== '') {
				if (!isUrlValid(e.target.value)) {
					document.getElementById(
						'rt-person-meta-social-facebook-field-error'
					).textContent = __(
						'Please enter a valid url',
						'movie-library'
					);
					isFacebookUrlValid = false;
					changeRtPersonButtonState();
				} else {
					document.getElementById(
						'rt-person-meta-social-facebook-field-error'
					).textContent = '';
					isFacebookUrlValid = true;
					changeRtPersonButtonState();
				}
			} else {
				document.getElementById(
					'rt-person-meta-social-facebook-field-error'
				).textContent = '';
				isFacebookUrlValid = true;
				changeRtPersonButtonState();
			}
		});

	document
		.querySelector('.rt-person-meta-social-instagram-field')
		.addEventListener('input', function (e) {
			if (e.target.value !== '') {
				if (!isUrlValid(e.target.value)) {
					document.getElementById(
						'rt-person-meta-social-instagram-field-error'
					).textContent = __(
						'Please enter a valid url',
						'movie-library'
					);
					isInstagramUrlValid = false;
					changeRtPersonButtonState();
				} else {
					document.getElementById(
						'rt-person-meta-social-instagram-field-error'
					).textContent = '';
					isInstagramUrlValid = true;
					changeRtPersonButtonState();
				}
			} else {
				document.getElementById(
					'rt-person-meta-social-instagram-field-error'
				).textContent = '';
				isInstagramUrlValid = true;
				changeRtPersonButtonState();
			}
		});

	document
		.querySelector('.rt-person-meta-social-website-field')
		.addEventListener('input', function (e) {
			if (e.target.value !== '') {
				if (!isUrlValid(e.target.value)) {
					document.getElementById(
						'rt-person-meta-social-website-field-error'
					).textContent = __(
						'Please enter a valid url',
						'movie-library'
					);
					isWebsiteUrlValid = false;
					changeRtPersonButtonState();
				} else {
					document.getElementById(
						'rt-person-meta-social-website-field-error'
					).textContent = '';
					isWebsiteUrlValid = true;
					changeRtPersonButtonState();
				}
			} else {
				document.getElementById(
					'rt-person-meta-social-website-field-error'
				).textContent = '';
				isWebsiteUrlValid = true;
				changeRtPersonButtonState();
			}
		});
}

/**
 * This function is used to check if the url is valid or not.
 *
 * @param {string} userInput
 * @return {boolean} true if the url is valid else false.
 */
function isUrlValid(userInput) {
	try {
		new URL(userInput);
		return true;
	} catch (err) {
		return false;
	}
}

/**
 * This function is used to enable or disable the publish button on rt-movie post type.
 */
function changeRtPersonButtonState() {
	if (
		isTwitterUrlValid &&
		isFacebookUrlValid &&
		isInstagramUrlValid &&
		isWebsiteUrlValid
	) {
		submit.disabled = false;
	} else {
		submit.disabled = true;
	}
}
