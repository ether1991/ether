jQuery(document).ready(function($){

	$('.phosphor-slider').each(function(index){
		var fixed_options 	= {
			singleItem		: true,
			navigationText	: ['<i class="fa fa-angle-double-left"></i>', '<i class="fa fa-angle-double-right"></i>']
		};

		var user_options = {
			autoPlay 		: Boolean( phosphor_slider_options.autoPlay ),
			pagination 		: Boolean( phosphor_slider_options.pagination ),
			stopOnHover 	: Boolean( phosphor_slider_options.stopOnHover ),
			navigation 		: Boolean( phosphor_slider_options.navigation ),
			transitionStyle : ( phosphor_slider_options.transitionStyle === '' ) ? false : phosphor_slider_options.transitionStyle
		};

		$(this).owlCarousel( $.extend(fixed_options, user_options) );
	});

	$( '#drop-nav' ).change(function(e){
		window.location.href = $(this).val();
	});
});