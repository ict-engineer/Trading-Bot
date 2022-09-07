$(document).ready(function(){

	/* billboard slider */

	$('.billboard .slider').owlCarousel({
		'autoPlay' : true,
		'singleItem' : true,
	});


	/* mainmenu */

	$('.menu-trigger').click(function(){
		$('.menu-wrapper').slideToggle(500);
		$(this).find('.dyna').toggleClass('fa-bars').toggleClass('fa-times');
		return false;
	});
	$('.user-links-toggler').click(function(){
		$('.user-links.mobile').slideToggle();
		return false;
	});

	$(document).click(function(e){
		if( $(e.target).is('.menu-wrapper , .menu-wrapper *') ){
			// do nothing
		} else {
			$('.menu-wrapper').slideUp(500);
			$('.dyna').attr('class' , 'dyna fa fa-bars');
		}
	});
	$(document).on('click' , '.close-menu' , function(){
		$('.menu-wrapper').slideUp(500);
	});

	/* cart box toggle */
	$('.cart-link > a').click(function(){
		$('.cart-box').fadeToggle(300);
		return false;
	});

});
