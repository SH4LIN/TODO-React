/**
 * This function is used to play the video in the lightbox.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		const trailerBox = document.querySelector(
			'.st-sm-watch-trailer-container'
		);

		const lightbox = document.getElementById('lightbox');
		const lightboxVideo = document.getElementById('lightbox-video');
		const closeBtn = document.getElementById('lightbox-close-btn');
		const videos = document.querySelectorAll('.video');
		if (videos !== null && videos.length > 0) {
			if (
				closeBtn !== null &&
				lightbox !== null &&
				lightboxVideo !== null
			) {
				if (trailerBox !== null) {
					trailerBox.addEventListener('click', function () {
						const video = document.createElement('video');
						video.setAttribute('controls', 'controls');
						video.classList.add('video-player');
						video.setAttribute('autoplay', 'autoplay');

						const src = this.getAttribute('data-src');
						console.log(src);
						video.setAttribute('src', src);

						lightboxVideo.replaceChildren(video);
						lightbox.classList.remove('display-none');
					});
				}

				window.document.onkeydown = function (e) {
					if (!e) {
						e = event;
					}
					if (e.keyCode === 27) {
						lightbox.classList.add('display-none');
						lightboxVideo.replaceChildren();
					}
				};
				closeBtn.addEventListener('click', function () {
					lightbox.classList.add('display-none');
					lightboxVideo.replaceChildren();
				});

				videos.forEach(function (item) {
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
			}
		}
	});
})();
