/**
 * This file is used to provide carousel sliding functionality to the movie slider.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		const slides = document.querySelectorAll('.slide');
		const sliderDots = document.querySelectorAll('.slider-dots');
		if (
			sliderDots !== null &&
			sliderDots.length > 0 &&
			slides !== null &&
			slides.length > 0
		) {
			sliderDots.forEach((span) => {
				span.addEventListener('click', function (e) {
					const index = e.target.dataset.position;
					for (let i = 0; i < slides.length; i++) {
						slides[i].style.display = 'none';
						sliderDots[i].classList.remove('active');
					}
					slides[index].style.display = 'flex';
					sliderDots[index].classList.add('active');
				});
			});
		}
	});
})();
