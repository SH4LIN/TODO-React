(function () {
	document.querySelectorAll('.st-am-slider-dots').forEach((span) => {
		span.addEventListener('click', function (e) {
			const index = e.target.dataset.position;
			const slides = document.querySelectorAll('.st-am-slider-item');
			const dots = document.querySelectorAll('.st-am-slider-dots');
			for (let i = 0; i < slides.length; i++) {
				slides[i].style.display = 'none';
				dots[i].classList.remove('active');
			}
			slides[index].style.display = 'flex';
			dots[index].classList.add('active');
		});
	});
})();
