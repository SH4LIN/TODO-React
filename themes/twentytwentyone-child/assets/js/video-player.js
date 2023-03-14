(function () {

  window.document.onkeydown = function(e) {
    if (!e) {
      e = event;
    }
    if (e.keyCode == 27) {
      lightbox_close();
    }
  }

  const lightbox = document.getElementById('lightbox');
  const lightboxVideo = document.getElementById('lightbox-video');
  const videoBtn = document.getElementsByClassName('video-btn');
  const closeBtn = document.getElementById('lightbox-close-btn');

  closeBtn.addEventListener('click', function() {
    lightbox.classList.add('display-none');
    lightboxVideo.replaceChildren();
  });

console.log(videoBtn);
  document.querySelectorAll('.st-sp-video').forEach(function (item) {
    item.addEventListener('click', function (e) {
      const video = document.createElement('video');
      video.setAttribute('controls', 'controls');
      video.classList.add('video-player');
      video.setAttribute('autoplay', 'autoplay');

      const src = this.getAttribute('src');
      console.log(this);
      video.setAttribute('src', src);

      lightboxVideo.replaceChildren(video);
      lightbox.classList.remove('display-none');
    });
  });

})();