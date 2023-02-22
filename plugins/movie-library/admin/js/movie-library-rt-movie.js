jQuery(function ($) {
	$(document).ready(function ($) {
		'use strict';

		let rt_movie_meta_crew_actor = $('#rt_movie_meta_crew_actor');
		let rt_movie_meta_crew_actor_selected = rt_movie_meta_crew_actor.val();

		console.log(rt_movie_meta_crew_actor_selected);
		let rt_movie_meta_crew_actor_character_container = $(
			'#rt_movie_meta_crew_actor_character_container'
		);
		let old_value = rt_movie_meta_crew_actor_selected;
		let new_value = rt_movie_meta_crew_actor_selected;
		rt_movie_meta_crew_actor.on('change', function (e) {
			new_value = $(this).val();
			let diff = $(new_value).not(old_value).get();
			let diff2 = $(old_value).not(new_value).get();
			console.log(diff.length);
			if (diff.length > 0) {
				$.each(diff, function (index, value) {
					console.log('add');
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

			if (diff2.length > 0) {
				console.log('remove');
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
