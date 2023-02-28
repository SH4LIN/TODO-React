/**
 * Movie Library RT Movie JS
 * This file is used to add the text-field dynamically when user selects any actor from the drop-down.
 * and remove the text-field if it is unselected.
 */

/**
 * This function will be used to add the Text-field dynamically when user selects any actor from the drop-down.
 * and remove the text-field if it is unselected.
 */
(function () {
	'use strict';

	// This will get the selected value from the drop-down.
	const rtMovieMetaCrewActor = document.querySelector(
		'#rt_movie_meta_crew_actor'
	);
	const rtMovieMetaCrewActorSelectedObject =
		rtMovieMetaCrewActor.selectedOptions;

	const rtMovieMetaCrewActorSelected = [];
	[...rtMovieMetaCrewActorSelectedObject].forEach((option) => {
		rtMovieMetaCrewActorSelected.push(option.value);
	});

	// This will find the reference of container where we will add the text-field.
	const rtMovieMetaCrewActorCharacterContainer = document.querySelector(
		'#rt_movie_meta_crew_actor_character_container'
	);

	let oldValue = rtMovieMetaCrewActorSelected;
	let newValue = rtMovieMetaCrewActorSelected;

	// This will add the callback function to dropdown onChanged event.
	rtMovieMetaCrewActor.addEventListener('change', function () {
		const newValueObjects = this.selectedOptions;
		newValue = [];
		[...newValueObjects].forEach((option) => {
			newValue.push(option.value);
		});

		const diff = newValue.filter((x) => !oldValue.includes(x));
		const diff2 = oldValue.filter((x) => !newValue.includes(x));

		// This will add the text-field if any new value is selected.
		if (diff.length > 0) {
			diff.forEach(function (value) {
				const label = document.querySelector(
					'#rt_movie_meta_crew_actor option[value="' + value + '"]'
				).text;

				const divContainer = document.createElement('div');
				const labelElement = document.createElement('label');
				const inputElement = document.createElement('input');
				const hiddenInputElement = document.createElement('input');

				labelElement.setAttribute(
					'for',
					'rt_movie_meta_crew_actor_character_' + value
				);
				labelElement.innerHTML = label + '(Character Name)';

				inputElement.setAttribute(
					'class',
					'rt-movie-meta-crew-actor-character-field'
				);
				inputElement.setAttribute('type', 'text');
				inputElement.setAttribute('name', value);
				inputElement.setAttribute('id', value);
				inputElement.setAttribute('value', '');

				hiddenInputElement.setAttribute('class', 'hidden-field');
				hiddenInputElement.setAttribute('type', 'text');
				hiddenInputElement.setAttribute('name', value + '-name');
				hiddenInputElement.setAttribute('id', value);
				hiddenInputElement.setAttribute('value', label);

				divContainer.appendChild(labelElement);
				divContainer.appendChild(inputElement);
				divContainer.appendChild(hiddenInputElement);

				rtMovieMetaCrewActorCharacterContainer.appendChild(
					divContainer
				);
			});
		}

		// This will add the text-field if any new value is deselected.
		if (diff2.length > 0) {
			diff2.forEach(function (value) {
				const idQuery = value;
				document.getElementById(idQuery).parentElement.remove();
			});
		}

		oldValue = newValue;
	});
})();
