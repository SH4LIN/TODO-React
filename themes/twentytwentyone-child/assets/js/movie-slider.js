(function () {

  document.querySelectorAll('.st-am-slider-dots')
    .forEach((span) => {

      span.addEventListener('click', function (e) {


        let index = e.target.dataset.position;
        console.log(index);
        let slides = document.querySelectorAll('.st-am-slider-item');
        let dots = document.querySelectorAll('.st-am-slider-dots');
          for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
            dots[i].classList.remove('active');
          }
          slides[index].style.display = 'flex';
          dots[index].classList.add('active');


      });
    });



})();