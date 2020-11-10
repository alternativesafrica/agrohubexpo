<?php

	//	Framework config: Foundation 6.4

	class WS_Form_Config_Framework_Foundation_64 {

		// Configuration - Frameworks
		public static function get_framework_config() {

			return array(

				'name'						=>	__('Foundation 6.4+', 'ws-form'),

				'default'					=>	false,

				'css_file'					=>	'foundation64.css',

				'label_positions'			=>	array('default', 'top', 'left', 'right', 'bottom'),

				'init_js'					=>	"if(typeof $(document).foundation === 'function') {

					// Abide
					if(typeof(Foundation.Abide) === 'function') {

						if($('[data-abide]').length) { Foundation.reInit($('[data-abide]')); }

					} else {

						if(typeof $('#form_canvas_selector')[0].ws_form_log_error === 'function') {
							$('#form_canvas_selector')[0].ws_form_log_error('error_framework_plugin', 'Abide', 'framework');
						}
					}

					// Tabs
					if(typeof(Foundation.Tabs) === 'function') {

						if($('[data-tabs]').length) { var wsf_foundation_tabs = new Foundation.Tabs($('[data-tabs]')); }

					} else {

						if(typeof($('#form_canvas_selector')[0].ws_form_log_error) === 'function') {

							$('#form_canvas_selector')[0].ws_form_log_error('error_framework_plugin', 'Tabs', 'framework');
						}
					}
				}",

				'minicolors_args'			=>	array(

					'theme' => 'foundation'
				),

				'columns'					=>	array(

					'column_count' 			=> 	12,
					'column_class'				=>	'#id-#size',
					'column_css_selector'		=>	'.#id-#size',
					'offset_class'				=>	'#id-offset-#offset',
					'offset_css_selector'		=>	'.#id-offset-#offset'
				),

				'breakpoints'				=>	array(

					// Up to 639px
					25	=>	array(
						'id'					=>	'small',
						'name'					=>	__('Small', 'ws-form'),
						'column_class'			=>	'#id-#size',
						'column_css_selector'	=>	'.#id-#size',
						'admin_max_width'		=>	639,
						'column_size_default'	=>	'column_count'	// Set to column count if XS framework breakpoint size is not set in object meta
					),
					// Up to 1023px
					75	=>	array(
						'id'				=>	'medium',
						'name'				=>	__('Medium', 'ws-form'),
						'admin_max_width'	=>	1023,
						'min_width'			=>	640
					),

					// 1024+
					125	=>	array(
						'id'				=>	'large',
						'name'				=>	__('Large', 'ws-form'),
						'min_width'			=>	1024
					)
				),

				'form' => array(

					'admin' => array('mask_single' => '#form'),
					'public' => array(

						'mask_single' 	=> '#label#form',
						'mask_label'	=> '<h2>#label</h2>',
						'attributes' 	=> array('data-abide' => '')
					),
				),

				'tabs' => array(

					'public' => array(

						'mask_wrapper'				=>	'<ul class="tabs" data-tabs id="#id">#tabs</ul>',
						'mask_single'				=>	'<li class="tabs-title#active"><a href="#href">#label</a></li>',
						'active'					=>	' is-active',
						'activate_js'				=>	"$('#form .tabs .tabs-title:eq(#index) a').click();",
						'event_js'					=>	'change.zf.tabs',
						'event_type_js'				=>	'wrapper',
						'event_selector_wrapper_js'	=>	'ul[data-tabs]',
						'event_selector_active_js'	=>	'li.is-active',
						'class_parent_disabled'		=>	'wsf-tab-disabled'
					),
				),

				'message' => array(

					'public'	=>	array(

						'mask_wrapper'		=>	'<div class="callout #mask_wrapper_class">#message</div>',

						'types'	=>	array(

							'success'		=>	array('mask_wrapper_class' => 'success'),
							'information'	=>	array('mask_wrapper_class' => 'primary'),
							'warning'		=>	array('mask_wrapper_class' => 'warning'),
							'danger'		=>	array('mask_wrapper_class' => 'alert')
						)
					)
				),

				'groups' => array(

					'public' => array(

						'mask_wrapper'	=>	'<div class="tabs-content" data-tabs-content="#id">#groups</div>',
						'mask_single' 	=> '<div class="#class" id="#id" data-id="#data_id" data-group-index="#data_group_index">#label#group</div>',
						'mask_label' 	=> '<h3>#label</h3>',
						'class'			=> 'tabs-panel',
						'class_active'	=> 'is-active',
					)
				),

				'sections' => array(

					'public' => array(

						'mask_wrapper'	=> '<div class="grid-x grid-margin-x" id="#id" data-id="#data_id">#sections</div>',
						'mask_single' 	=> '<fieldset#attributes class="#class" id="#id" data-id="#data_id">#section</fieldset>',

						'class_single'	=> array('cell')
					)
				),

				'fields' => array(

					'public' => array(

						// Honeypot attributes
						'honeypot_attributes' => array('data-abide-ignore'),

						// Label position - Left
						'left' => array(

							'mask'							=>	'<div class="grid-x grid-padding-x">#field</div>',
							'mask_field_label_wrapper'		=>	'<div class="small-#column_width_label cell">#label</div>',
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_wrapper'			=>	'<div class="small-#column_width_field cell">#field</div>',
							'class_field_label'				=>	array('text-right', 'middle'),
						),

						// Label position - Right
						'right' => array(

							'mask'							=>	'<div class="grid-x grid-padding-x">#field</div>',
							'mask_field_label_wrapper'		=>	'<div class="small-#column_width_label cell">#label</div>',
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_wrapper'			=>	'<div class="small-#column_width_field cell">#field</div>',
							'class_field_label'				=>	array('middle'),
						),

						// Masks
						'mask_wrapper' 			=> '#label<div class="grid-x grid-margin-x" id="#id" data-id="#data_id">#fields</div>',
						'mask_wrapper_label'	=> '<legend>#label</legend>',
						'mask_single' 			=> '<div class="#class" id="#id" data-id="#data_id" data-type="#type"#attributes>#field</div>',
						'mask_field_label'		=> '<label id="#label_id" for="#id"#attributes>#label#field</label>',

						// Input group
						'mask_field_input_group'			=>	'<div class="input-group">#field</div>#invalid_feedback#help',
						'mask_field_input_group_prepend'	=>	'<span class="input-group-label">#prepend</span>',
						'mask_field_input_group_append'		=>	'<span class="input-group-label">#append</span>',
						'class_field_input_group'			=>	'input-group-field',

						// Required
						'mask_required_label'	=> ' <small>Required</small>',

						// Help
						'mask_help'			=>	'<p id="#help_id" class="#help_class">#help#help_append</p>',

						// Invalid feedback
						'mask_invalid_feedback'		=>	'<span id="#invalid_feedback_id" data-form-error-for="#id" class="#invalid_feedback_class">#invalid_feedback</span>',

						// Classes - Default
						'class_single'				=> array('cell'),
						'class_field'				=> array(),
						'class_field_label'			=> array(),
						'class_help'				=> array('help-text'),
						'class_invalid_feedback'	=> array('form-error'),
						'class_inline' 				=> array('form-inline'),
						'class_form_validated'		=> array('was-validated'),
						'class_orientation_wrapper'		=> array('grid-x', 'grid-margin-x'),
						'class_orientation_row'			=> array('cell'),
						'class_single_vertical_align'	=> array(

							'middle'	=>	'align-self-middle',
							'bottom'	=>	'align-self-bottom'
						),
						'class_field_button_type'	=> array(

							'primary'		=>	'primary',
							'secondary'		=>	'secondary',
							'success'		=>	'success',
							'warning'		=>	'warning',
							'danger'		=>	'alert'
						),
						'class_field_message_type'	=> array(

							'success'		=>	'success',
							'information'	=>	'primary',
							'warning'		=>	'warning',
							'danger'		=>	'alert'
						),

						// Attributes
						'attribute_field_match'		=> array('data-equalto' => '#field_match_id'),

						// Classes - Custom by field type
						'field_types'		=> array(

							'checkbox' 	=> array(

								'class_inline' 			=> array(),
								'mask_field'			=> '<div#attributes>#datalist</div>#invalid_feedback#help',
								'mask_group'			=> '<fieldset#disabled>#group_label#group</fieldset>',
								'mask_row_label'		=> '#row_field<label id="#label_row_id" for="#row_id"#attributes>#checkbox_field_label</label>#invalid_feedback',
								'mask_single' 			=> '<fieldset class="#class" id="#id" data-id="#data_id" data-type="#type"#attributes>#field</fieldset>',
								'mask_field_label'		=> '<legend id="#label_id" for="#id"#attributes>#label</legend>#field',
							),

							'radio' 	=> array(

								'class_inline' 			=> array(),
								'mask_field'			=> '<div#attributes>#datalist</div>#help',
								'mask_group'			=> '<fieldset#disabled>#group_label#group</fieldset>',
								'mask_row_label'		=> '#row_field<label id="#label_row_id" for="#row_id" data-label-required-id="#label_id"#attributes>#radio_field_label</label>#invalid_feedback',
								'mask_single' 			=> '<fieldset class="#class" id="#id" data-id="#data_id" data-type="#type"#attributes>#field</fieldset>',
								'mask_field_label'		=> '<legend id="#label_id" for="#id"#attributes>#label</legend>#field',
							),

							'spacer'	=> array(

								'mask_field_label'		=>	'',
							),

							'texteditor'	=> array(

								'mask_field_label'		=>	'',
							),
							'section_icons'	=> array(

								'mask_field_label'		=>	'',
							),

							'price_checkbox' 	=> array(

								'class_inline' 			=> array(),
								'mask_field'			=> '<div#attributes>#datalist</div>#help',
								'mask_group'			=> '<fieldset#disabled>#group_label#group</fieldset>',
								'mask_row_label'		=> '#row_field<label id="#label_row_id" for="#row_id"#attributes>#checkbox_price_field_label</label>#invalid_feedback',
								'mask_single' 			=> '<fieldset class="#class" id="#id" data-id="#data_id" data-type="#type"#attributes>#field</fieldset>',
								'mask_field_label'		=> '<legend id="#label_id" for="#id"#attributes>#label</legend>#field',
							),

							'price_radio' 	=> array(

								'class_inline' 			=> array(),
								'mask_field'			=> '<div#attributes>#datalist</div>#help',
								'mask_group'			=> '<fieldset#disabled>#group_label#group</fieldset>',
								'mask_row_label'		=> '#row_field<label id="#label_row_id" for="#row_id" data-label-required-id="#label_id"#attributes>#radio_price_field_label</label>#invalid_feedback',
								'mask_single' 			=> '<fieldset class="#class" id="#id" data-id="#data_id" data-type="#type"#attributes>#field</fieldset>',
								'mask_field_label'		=> '<legend id="#label_id" for="#id"#attributes>#label</legend>#field',
							),

							'file' 	=> array(

								'mask_field_label'		=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
								'class_field'			=> array('show-for-sr'),
								'class_field_label'		=> array('button', 'expanded')
							),

							'signature' => array(

								'mask_field_label'					=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
								'class_field'						=> array('callout'),
								'class_invalid_label'				=> array('is-invalid-label'),
								'class_invalid_field'				=> array('is-invalid-input'),
								'class_invalid_invalid_feedback'	=> array('is-visible')
							),

							'recaptcha' => array(

								'mask_field_label'					=> '',
								'class_invalid_invalid_feedback'	=> array('is-visible')
							),

							'submit' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=> array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'default'
							),

							'clear' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=> array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'secondary'
							),

							'reset' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=> array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'secondary'
							),

							'tab_previous' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=> array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'secondary'
							),

							'tab_next' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=> array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'secondary'
							),

							'section_add' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=>	array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'secondary'
							),

							'section_delete' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=>	array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'danger'
							),

							'section_up' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=>	array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'secondary'
							),

							'section_down' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=>	array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'secondary'
							),

							'save' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=> array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'secondary'
							),

							'button' 	=> array(

								'mask_field_label'					=> '#label',
								'class_field'						=> array('button'),
								'class_field_full_button'			=> array('expanded'),
								'class_field_button_type_fallback'	=> 'secondary'
							),

							'message' 	=> array(
								'mask_field_label'	=>	'',
								'class_field'		=> array('callout')
							),

							'hidden' => array(

								'mask_field_label'	=>	''
							),

							'html' => array(

								'mask_field_label'	=>	''
							),

							'progress'	=> array(

								'class_field'					=> array('progress'),
								'class_complete'				=> array('success'),
								'mask_field'					=>	'<div data-progress-bar role="progressbar" tabindex="0" aria-valuenow="#value" aria-valuemin="0" aria-valuemax="100" id="#id"#attributes><div data-progress-bar-value data=value="0" class="progress-meter"></div></div>',
								'mask_field_attributes'			=>	array('class', 'progress_source', 'aria_describedby', 'aria_labelledby', 'aria_label'),
							)
						)
					)
				)
			);
		}
	}