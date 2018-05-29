jQuery(document).ready(function(){
    jQuery('.owl-carousel').owlCarousel({
      loop:true, //Зацикливаем слайдер
      dots:false,
      items:1,
      nav:false,
      autoplayHoverPause:true,
      autoplay:true, //Автозапуск слайдера
      smartSpeed:2000, //Время движения слайда
      animateIn: 'fadeIn',
      responsive:{ //Адаптация в зависимости от разрешения экрана
      0:{
        items:1
      },
      600:{
        items:1
      },
      1000:{
        items:1
      }
    }
    });
});
function startProgressBar() {
  jQuery(".slide-progress").css({
    width: "100%",
    transition: "width 5000ms"
  });
}
function resetProgressBar() {
  jQuery(".slide-progress").css({
    width: 0,
    transition: "width 0s"
  });
}
var owl = jQuery('.owl-carousel');
owl.on('initialized.owl.carousel', function(event) {
  $('.info').text($(".slider-section").height());
  startProgressBar();
});
owl.on('translate.owl.carousel', function(event) {
  startProgressBar();
  $('.info').text($(".slider-section").height());
});
owl.on('changed.owl.carousel', function(event) {
  resetProgressBar();
});

$('.staff-slider').owlCarousel({
    loop:true,
    items:3,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        760:{
            items:2,
            nav:true
        },
        980:{
            items:3,
            nav:true,
            loop:false
        }
    }
})
