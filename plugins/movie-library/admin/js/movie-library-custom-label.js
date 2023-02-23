/**
 * Movie Library Admin JS
 * This file is used to add custom JS to the admin area.
 * It will change the label of the excerpt metabox to synopsis.
 *
 * @package
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
