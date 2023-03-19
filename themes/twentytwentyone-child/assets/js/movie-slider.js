/**
 * This file is used to provide carousel sliding functionality to the movie slider.
 */
(function () {
	window.addEventListener('load', function () {
		const slides = document.querySelectorAll('.st-am-slider-item');
		const sliderDots = document.querySelectorAll('.st-am-slider-dots');
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
