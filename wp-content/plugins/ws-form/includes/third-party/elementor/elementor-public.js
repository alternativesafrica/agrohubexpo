(function($) {

	'use strict';

	$( window ).on( 'elementor/frontend/init', function() {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/ws-form.default', function($scope, $) {

			// Render each form
			$('.wsf-form').each(function() {

				// Reset events and HTML
				$(this).off().html('');

				// Get attributes
				var id = $(this).attr('id');
				var form_id = $(this).attr('data-id');
				var instance_id = $(this).attr('data-instance-id');

				// Render form
				var ws_form = new $.WS_Form();
				window.wsf_form_instances[instance_id] = ws_form;

				ws_form.render({

					'obj' : 		'#' + id,
					'form_id':		form_id
				});
			});
		});
	});

})(jQuery);
