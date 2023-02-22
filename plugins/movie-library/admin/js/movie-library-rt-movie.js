/**
 * This file is used to add the text-field dynamically when user selects any actor from the drop-down.
 * and remove the text-field if it is unselected.
 */
jQuery(function ($) {
	$(document).ready(function ($) {
		'use strict';

		// This will get the selected value from the drop-down.
		let rt_movie_meta_crew_actor = $('#rt_movie_meta_crew_actor');
		let rt_movie_meta_crew_actor_selected = rt_movie_meta_crew_actor.val();

		// This will find the reference of container where we will add the text-field.
		let rt_movie_meta_crew_actor_character_container = $(
			'#rt_movie_meta_crew_actor_character_container'
		);

		let old_value = rt_movie_meta_crew_actor_selected;
		let new_value = rt_movie_meta_crew_actor_selected;

		// This will add the callback function to dropdown onChanged event.
		rt_movie_meta_crew_actor.on('change', function (e) {
			new_value = $(this).val();
			let diff = $(new_value).not(old_value).get();
			let diff2 = $(old_value).not(new_value).get();

			// This will add the text-field if any new value is selected.
			if (diff.length > 0) {
				$.each(diff, function (index, value) {
					let label = $(
						'#rt_movie_meta_crew_actor option[value="' +
							value +
							'"]'
					).text();

					rt_movie_meta_crew_actor_character_container.append(
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

			old_value = new_value;
		});
	});
});
