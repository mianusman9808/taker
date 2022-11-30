jQuery(document).ready(function ($) {
	// HERO en Home
	// Define una función para setear #hero

	function fullscreen() {
		jQuery('#fullscreen').css({
			width: jQuery(window).width(),
			height: jQuery(window).height()
		});
	}
	fullscreen();
	// corre ala función cuando la vnetana se modifica
	jQuery(window).resize(function () {
		fullscreen();
	});

	// Menu Scroll
	jQuery(window).scroll(function () {
		if ($(this).scrollTop() > 200) {
			$('#nav-scroll').fadeIn(200);
		} else {
			$('#nav-scroll').fadeOut(200);
		}
	});

	// To top
	$('a.top').on('click', function(e){
		$("html, body").animate({scrollTop: $("#nav-scroll").offset().top}, 500);
	});

	 $('a[href^="#"]').on('click',function (e) {
		e.preventDefault();

		var target = this.hash;
		$target = $(target);

		$('html, body').stop().animate({
			'scrollTop':  parseInt($target.offset().top,10)
		}, 900, 'swing', function () {
			window.location.hash = target;
		});
	});
});





