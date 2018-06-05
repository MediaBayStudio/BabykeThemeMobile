jQuery('.footer__button--up').click(function() {
		jQuery('#content').animate({
			scrollTop:0
		}, 800, 'easeInOutQuad');
		return false;
	});

jQuery('.footer__button--share').on('click', function() {
	jQuery('.share').addClass('share--opened');
})

jQuery('.share__close').on('click', function() {
	jQuery('.share').removeClass('share--opened');
})
