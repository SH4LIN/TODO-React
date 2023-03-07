/**
 * Movie Library Custom Label JS
 * This file is used to add custom JS to the admin area.
 * It will change the label of the excerpt metabox to synopsis.
 */

/**
 * This function is used to add filter to the i18n.gettext hook.
 * It will change the label of the excerpt metabox to synopsis.
 */
(function () {
	'use strict';

	const { __ } = wp.i18n;

	wp.hooks.addFilter(
		'i18n.gettext',
		'movie-library',
		function (translation, text) {
			if (text === 'Excerpt') {
				return __('Synopsis', 'movie-library');
			}

			if (text === 'Write an excerpt (optional)') {
				return __('Write a synopsis', 'movie-library');
			}

			return translation;
		}
	);
})();
