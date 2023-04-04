/**
 * This function is used to play the video in the lightbox.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		const trailerBox = document.querySelector('.sm-watch-trailer-wrapper');
		const lightbox = document.getElementById('lightbox');
		const lightboxVideo = document.getElementById('lightbox-video');
		const closeBtn = document.getElementById('lightbox-close-btn');
		const videos = document.querySelectorAll('.video-item video');
		const videoPlayButton = document.querySelectorAll('.video-play-button');

		const videoPlay = function () {
			const video = document.createElement('video');
			video.setAttribute('controls', 'controls');
			video.classList.add('video-player');
			video.setAttribute('autoplay', 'autoplay');

			const src = this.getAttribute('data-src');
			video.setAttribute('src', src);

			lightboxVideo?.replaceChildren(video);
			lightbox?.classList.remove('display-none');
		};

		trailerBox?.addEventListener('click', videoPlay);
		window.document.onkeydown = function (e) {
			if (!e) {
				e = event;
			}
			if (e.keyCode === 27) {
				lightbox?.classList.add('display-none');
				lightboxVideo?.replaceChildren();
			}
		};

		closeBtn?.addEventListener('click', function () {
			lightbox?.classList.add('display-none');
			lightboxVideo?.replaceChildren();
		});

		if (videos?.length > 0) {
			videos.forEach(function (item) {
				item.addEventListener('click', videoPlay);
			});
		}

		if (videoPlayButton?.length > 0) {
			videoPlayButton.forEach(function (item) {
				item.addEventListener('click', videoPlay);
			});
		}
	});
})();
