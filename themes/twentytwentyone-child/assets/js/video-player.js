(function () {
	window.document.onkeydown = function (e) {
		if (!e) {
			e = event;
		}
		if (e.keyCode === 27) {
			lightbox.classList.add('display-none');
			lightboxVideo.replaceChildren();
		}
	};

	const lightbox = document.getElementById('lightbox');
	const lightboxVideo = document.getElementById('lightbox-video');
	const closeBtn = document.getElementById('lightbox-close-btn');

	closeBtn.addEventListener('click', function () {
		lightbox.classList.add('display-none');
		lightboxVideo.replaceChildren();
	});

	document.querySelectorAll('.st-sp-video').forEach(function (item) {
		item.addEventListener('click', function () {
			const video = document.createElement('video');
			video.setAttribute('controls', 'controls');
			video.classList.add('video-player');
			video.setAttribute('autoplay', 'autoplay');

			const src = this.getAttribute('src');
			video.setAttribute('src', src);

			lightboxVideo.replaceChildren(video);
			lightbox.classList.remove('display-none');
		});
	});
})();
