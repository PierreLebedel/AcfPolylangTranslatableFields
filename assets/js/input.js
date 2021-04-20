(function($){

	var initializedTabs = false;

	function initialize_tabs(){
		if(initializedTabs) return;

		$('.acf-polylang-translatable-tabs .wp-tab-bar a').click(function(event){
			event.preventDefault();

			// Limit effect to the container element.
			var context = $(this).closest('.wp-tab-bar').parent();
			$('.wp-tab-bar li', context).removeClass('wp-tab-active');
			$(this).closest('li').addClass('wp-tab-active');
			$('.wp-tab-panel', context).hide();
			$( $(this).attr('href'), context ).show();
		});
	
		// Make setting tabs optional.
		$('.acf-polylang-translatable-tabs .wp-tab-bar').each(function(){
			if ( $('.wp-tab-active', this).length ){
				$('.wp-tab-active', this).click();
			}else{
				$('a', this).first().click();
			}
		});

		initializedTabs = true;
	}
	
	if( typeof acf.add_action !== 'undefined' ) {
		acf.add_action('ready', initialize_tabs);
	} else {
		initialize_tabs();
	}

})(jQuery);
