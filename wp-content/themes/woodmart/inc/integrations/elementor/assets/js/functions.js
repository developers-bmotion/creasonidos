jQuery(window).on('elementor:init', function() {
	window.elementor.on( 'panel:init', function() {
		setTimeout(function() {
			jQuery(document).on('click mousedown', '.elementor-nerd-box-link, .elementor-button-go-pro, #elementor-notice-bar__message > a, #elementor-notice-bar__action > a, .elementor-go-pro, .dialog-buttons-action.elementor-button-success', function (e) {
				e.preventDefault();
				e.stopPropagation();
				window.open('https://elementor.com/pro/?ref=13393', '_blank');
			});
		}, 2000);
	});
});
