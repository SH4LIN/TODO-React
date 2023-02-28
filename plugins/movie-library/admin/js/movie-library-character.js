/**
 * Movie Library RT Movie JS
 * This file is used to add the text-field dynamically when user selects any actor from the drop-down.
 * and remove the text-field if it is unselected.
 */

/**
 * This function will be used to add the Text-field dynamically when user selects any actor from the drop-down.
 * and remove the text-field if it is unselected.
 */
(function ($) {
	$(document).ready(function () {
		'use strict';

		// This will get the selected value from the drop-down.
		const rtMovieMetaCrewActor = $('#rt_movie_meta_crew_actor');
		const rtMovieMetaCrewActorSelected = rtMovieMetaCrewActor.val();

		// This will find the reference of container where we will add the text-field.
		const rtMovieMetaCrewActorCharacterContainer = $(
			'#rt_movie_meta_crew_actor_character_container'
		);

		let oldValue = rtMovieMetaCrewActorSelected;
		let newValue = rtMovieMetaCrewActorSelected;

		// This will add the callback function to dropdown onChanged event.
		rtMovieMetaCrewActor.on('change', function () {
			newValue = $(this).val();
			const diff = $(newValue).not(oldValue).get();
			const diff2 = $(oldValue).not(newValue).get();

			// This will add the text-field if any new value is selected.
			if (diff.length > 0) {
				$.each(diff, function (index, value) {
					const label = $(
						'#rt_movie_meta_crew_actor option[value="' +
							value +
							'"]'
					).text();

					rtMovieMetaCrewActorCharacterContainer.append(
						'<div>' +
							'<label for="rt_movie_meta_crew_actor_character_' +
							value +
							'">' +
							label +
							'(Character Name)' +
							'</label>' +
							'<input class="rt-movie-meta-crew-actor-character-field" type="text" name="' +
							value +
							'" id="' +
							value +
							'" value=""/>' +
							'<input class="hidden-field" type="text" name="' +
							value +
							'-name" id="' +
							value +
							'" value="' +
							label +
							'"/>' +
							'</div>'
					);
				});
			}

			// This will add the text-field if any new value is deselected.
			if (diff2.length > 0) {
				$.each(diff2, function (index, value) {
					$(`#rt_movie_meta_crew_actor_character_container #${value}`)
						.parent()
						.remove();
					$(
						`#rt_movie_meta_crew_actor_character_container #${value}-name`
					)
						.parent()
						.remove();
				});
			}

			oldValue = newValue;
		});
	});
})(jQuery);
