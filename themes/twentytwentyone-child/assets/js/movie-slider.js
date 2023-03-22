/**
 * This file is used to provide carousel sliding functionality to the movie slider.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		const slides = document.querySelectorAll('.slide');
		const sliderDots = document.querySelectorAll('.slider-dots');
		const timeout = 5000;
		if (
			sliderDots !== null &&
			sliderDots.length > 0 &&
			slides !== null &&
			slides.length > 0
		) {
			let index = 0;
			setInterval(function () {
				slides[index].style.display = 'none';
				sliderDots[index].classList.remove('active');
				if (index >= slides.length - 1) {
					index = 0;
				} else {
					index++;
				}
				slides[index].style.display = 'unset';
				sliderDots[index].classList.add('active');
			}, timeout);

			sliderDots.forEach((span) => {
				span.addEventListener('click', function (e) {
					index = e.target.dataset.position;
					for (let i = 0; i < slides.length; i++) {
						slides[i].style.display = 'none';
						sliderDots[i].classList.remove('active');
					}
					slides[index].style.display = 'unset';
					sliderDots[index].classList.add('active');
					setTimeout(function () {}, timeout);
				});
			});
		}
	});
})();
