<?php

	class WS_Form_Config_Public extends WS_Form_Config {

		// Configuration - Settings - Public
		public static function get_settings_form_public() {

			$settings_form_public = array();

			// Additional language strings for the public
			$language_extra = array(

				'error_min_length'						=>	__('Minimum character count: %s', 'ws-form'),
				'error_max_length'						=>	__('Maximum character count: %s', 'ws-form'),
				'error_min_length_words'				=>	__('Minimum word count: %s', 'ws-form'),
				'error_max_length_words'				=>	__('Maximum word count: %s', 'ws-form'),
				'error_data_grid_source_type'			=>	__('Data grid source type not specified', 'ws-form'),
				'error_data_grid_source_id'				=>	__('Data grid source ID not specified', 'ws-form'),
				'error_data_source_data'				=>	__('Data source data not found', 'ws-form'),
				'error_data_source_columns'				=>	__('Data source columns not found', 'ws-form'),
				'error_data_source_groups'				=>	__('Data source groups not found', 'ws-form'),
				'error_data_source_group_label'			=>	__('Data source group label not found', 'ws-form'),
				'error_data_group_rows'					=>	__('Data source group rows not found', 'ws-form'),
				'error_data_group_label'				=>	__('Data source group label not found', 'ws-form'),
				'error_mask_help'						=>	__('No help mask defined: %s', 'ws-form'),
				'error_mask_invalid_feedback'			=>	__('No invalid feedback mask defined', 'ws-form'),
				'error_api_call_hash'					=>	__('Hash not returned in API call', 'ws-form'),
				'error_api_call_hash_invalid'			=>	__('Invalid hash returned in API call', 'ws-form'),
				'error_api_call_framework_invalid'		=>	__('Framework config not found', 'ws-form'),
				'error_recaptcha_v2_hidden'				=>	__('reCAPTCHA V2 hidden error', 'ws-form'),
				'error_timeout_recaptcha'				=>	__('Timeout waiting for reCAPTCHA to load', 'ws-form'),
				'error_timeout_signature'				=>	__('Timeout waiting for signature component to load', 'ws-form'),
				'error_timeout_analytics_google'		=>	__('Timeout waiting for Google Analytics to load', 'ws-form'),
				'error_timeout_datetimepicker'			=>	__('Timeout waiting for datetimepicker component to load', 'ws-form'),
				'error_timeout_minicolors'				=>	__('Timeout waiting for minicolors component to load', 'ws-form'),
				'error_timeout_inputmask'				=>	__('Timeout waiting for inputmask component to load', 'ws-form'),
				'error_datetime_default_value'			=>	__('Default date/time value invalid (%s)', 'ws-form'),
				'error_framework_tabs_activate_js'		=>	__('Framework tab activate JS not defined', 'ws-form'),
				'error_form_draft'						=>	__('Form is in draft', 'ws-form'),
				'error_form_future'						=>	__('Form is scheduled', 'ws-form'),
				'error_form_trash'						=>	__('Form is trashed', 'ws-form'),
				'error_calc'							=>	__('Calculation error: %s'),
				'error_framework_plugin'				=>	__('Framework plugin not found: %s', 'ws-form'),
				'error_tracking_geo_location'			=>	__('Tracking - Geo location error: %s', 'ws-form'),
				'error_action'							=>	__('Actions - %s', 'ws-form'),
				'error_payment'							=>	__('Payments - %s', 'ws-form'),
				'error_termageddon'						=>	__('Error retrieving Termageddon content', 'ws-form'),
				'error_termageddon_404'					=>	__('Invalid Termageddon key', 'ws-form'),
				'error_js'								=>	__('Syntax error in JavaScript: %s', 'ws-form'),
				'error_section_button_no_section'		=>	__('No section assigned to this button', 'ws-form'),
				'error_section_icon_no_section'			=>	__('No section assigned to these icons', 'ws-form'),
				'error_section_icon_not_in_own_section'	=>	__('Icon %s must be in its own assigned section', 'ws-form'),
				'error_not_supported_video'				=>	__("Sorry, your browser doesn't support embedded videos.", 'ws-form'),
				'error_not_supported_audio'				=>	__("Sorry, your browser doesn't support embedded audio.", 'ws-form')
			);

			// Add to language array
			$settings_form_public['language'] = array();
			foreach($language_extra as $key => $value) {

				$settings_form_public['language'][$key] = $value;
			}

			// Check if debug is enabled
			$debug = WS_Form_Common::debug_enabled();

			// Debug
			if($debug) {

				// Additional language strings for the public debug feature
				$language_extra = array(

					'debug_form'						=>	__('Form', 'ws-form'),
					'debug_form_rendered'				=>	__('Form rendered', 'ws-form'),

					'debug_minimize'					=>	__('Minimize', 'ws-form'),
					'debug_restore'						=>	__('Restore', 'ws-form'),

					'debug_tools'						=>	__('Tools', 'ws-form'),
					'debug_css'							=>	__('Design', 'ws-form'),
					'debug_log'							=>	__('Log', 'ws-form'),
					'debug_error'						=>	__('Errors', 'ws-form'),

					'debug_tools_populate'				=>	__('Populate', 'ws-form'),
					'debug_tools_identify'				=>	__('Identify', 'ws-form'),
					'debug_tools_edit'					=>	__('Edit', 'ws-form'),
					'debug_tools_submissions'			=>	__('Submissions', 'ws-form'),
					'debug_tools_submit'				=>	__('Submit', 'ws-form'),
					'debug_tools_save'					=>	__('Save', 'ws-form'),
					'debug_tools_populate_submit'		=>	__('Populate & Submit', 'ws-form'),
					'debug_tools_reload'				=>	__('Reload', 'ws-form'),
					'debug_tools_form_clear'			=>	__('Clear', 'ws-form'),
					'debug_tools_form_reset'			=>	__('Reset', 'ws-form'),
					'debug_tools_clear_hash'			=>	__('Clear Session ID', 'ws-form'),
					'debug_tools_clear_log'				=>	__('Clear Log', 'ws-form'),
					'debug_tools_clear_error'			=>	__('Clear Errors', 'ws-form'),

					'debug_info_label'					=>	__('Form Name', 'ws-form'),
					'debug_info_id'						=>	__('Form ID', 'ws-form'),
					'debug_info_instance'				=>	__('Instance', 'ws-form'),
					'debug_info_hash'					=>	__('Session ID', 'ws-form'),
					'debug_info_checksum'				=>	__('Checksum', 'ws-form'),
					'debug_info_duration'				=>	__('Rendering Time', 'ws-form'),
					'debug_info_framework'				=>	__('Framework', 'ws-form'),
					'debug_info_submit_count'			=>	__('Submit Count', 'ws-form'),
					'debug_info_submit_duration_user'	=>	__('Submit Duration (User)', 'ws-form'),
					'debug_info_submit_duration_client'	=>	__('Submit Duration (Client)', 'ws-form'),
					'debug_info_submit_duration_server'	=>	__('Submit Duration (Server)', 'ws-form'),

					'debug_hash_empty'					=>	__('New Form', 'ws-form'),
					'debug_tools_publish_pending'		=>	__('Publish Pending', 'ws-form'),

					'debug_action_type'					=>	__('Type', 'ws-form'),
					'debug_action_row'					=>	__('Row', 'ws-form'),
					'debug_action_form'					=>	__('Form', 'ws-form'),
					'debug_action_group'				=>	__('Tab', 'ws-form'),
					'debug_action_section'				=>	__('Section', 'ws-form'),
					'debug_action_action'				=>	__('Action', 'ws-form'),
					'debug_action_reset'				=>	__('Reset', 'ws-form'),
					'debug_action_focussed'				=>	__('Focussed', 'ws-form'),
					'debug_action_clicked'				=>	__('Clicked', 'ws-form'),
					'debug_action_added'				=>	__('Added', 'ws-form'),
					'debug_action_removed'				=>	__('Removed', 'ws-form'),
					'debug_action_selected'				=>	__('Selected', 'ws-form'),
					'debug_action_deselected'			=>	__('Deselected', 'ws-form'),
					'debug_action_selected_value'		=>	__('Selected row by value', 'ws-form'),
					'debug_action_deselected_value'		=>	__('Deselected row by value', 'ws-form'),
					'debug_action_checked'				=>	__('Checked', 'ws-form'),
					'debug_action_unchecked'			=>	__('Unchecked', 'ws-form'),
					'debug_action_checked_value'		=>	__('Checked by value', 'ws-form'),
					'debug_action_unchecked_value'		=>	__('Unchecked by value', 'ws-form'),
					'debug_action_required'				=>	__('Required', 'ws-form'),
					'debug_action_not_required'			=>	__('Not required', 'ws-form'),
					'debug_action_disabled'				=>	__('Disabled', 'ws-form'),
					'debug_action_enabled'				=>	__('Enabled', 'ws-form'),
					'debug_action_hide'					=>	__('Hide', 'ws-form'),
					'debug_action_show'					=>	__('Show', 'ws-form'),
					'debug_action_read_only'			=>	__('Read only', 'ws-form'),
					'debug_action_not_read_only'		=>	__('Not read only', 'ws-form'),

					'debug_submit_loaded'				=>	__('Retrieved submit data', 'ws-form'),

					'debug_action_get'					=>	__('Retrieved %s action data', 'ws-form'),

					'debug_tracking_geo_location_permission_denied'		=>	__('User denied the request for geo location', 'ws-form'),
					'debug_tracking_geo_location_position_unavailable'	=>	__('Geo location information was unavailable', 'ws-form'),
					'debug_tracking_geo_location_timeout'				=>	__('The request to get user geo location timed out', 'ws-form'),
					'debug_tracking_geo_location_default'				=>	__('An unknown error occurred whilst retrieving geo location', 'ws-form'),

					// Log
					'log_hash_set'								=>	__('Session ID received: %s', 'ws-form'),
					'log_hash_clear'							=>	__('Session ID cleared', 'ws-form'),
					'log_conditional_fired_then'				=>	__("Conditional matched, running 'THEN': %s", 'ws-form'),
					'log_conditional_fired_else'				=>	__("Conditional matched, running 'ELSE': %s", 'ws-form'),
					'log_conditional_action_then'				=>	__("THEN run: %s", 'ws-form'),
					'log_conditional_action_else'				=>	__("ELSE run: %s", 'ws-form'),
					'log_conditional_event'						=>	__("Added event handler for %s", 'ws-form'),
					'log_analytics_google_loaded_analytics_js'	=>	__('Google Analytics successfully loaded (analytics.js)', 'ws-form'),
					'log_analytics_google_loaded_gtag_js'		=>	__('Google Analytics successfully loaded (gtag.js)', 'ws-form'),
					'log_analytics_google_loaded_ga_js'			=>	__('Google Analytics successfully loaded (ga.js)', 'ws-form'),
					'log_analytics_facebook_loaded_fbevents_js'	=>	__('Facebook Analytics successfully loaded (fbevents.js)', 'ws-form'),
					'log_analytics_event_field'					=>	__('Analytics field events initialized: %s', 'ws-form'),
					'log_analytics_event_field_fired'			=>	__('Analytics field event ran: %s', 'ws-form'),
					'log_analytics_event_field_failed'			=>	__('Analytics field event failed: %s (Function does not exist)', 'ws-form'),
					'log_analytics_event_tab'					=>	__('Analytics tab events initialized: %s', 'ws-form'),
					'log_analytics_event_tab_fired'				=>	__('Analytics tab event ran: %s', 'ws-form'),
					'log_recaptcha_v3_action_fired'				=>	__('reCAPTCHA V3 action ran: %s', 'ws-form'),
					'log_javascript'							=>	__('Javascript ran', 'ws-form'),
					'log_honeypot'								=>	__('Spam protection - Honeypot initialized', 'ws-form'),
					'log_tracking_geo_location'					=>	__('Tracking - Geo location: %s', 'ws-form'),
					'log_submit_lock'							=>	__('Duplication protection - Button(s) locked', 'ws-form'),
					'log_submit_unlock'							=>	__('Duplication protection - Button(s) unlocked', 'ws-form'),
					'log_form_submit'							=>	__('Form submitted', 'ws-form'),
					'log_form_save'								=>	__('Form saved', 'ws-form'),
					'log_group_index'							=>	__('Set tab index to: %s', 'ws-form'),
					'log_action'								=>	__('Actions - %s', 'ws-form'),
					'log_trigger'								=>	__("jQuery: $(document).trigger('%s', form, form_id, instance_id, form_obj, form_canvas_obj) ran"),
					'log_ecommerce_status'						=>	__('Ecommerce - Status set to: %s', 'ws-form'),
					'log_ecommerce_transaction_id'				=>	__('Ecommerce - Transaction ID set to: %s', 'ws-form'),
					'log_ecommerce_payment_method'				=>	__('Ecommerce - Payment method set to: %s', 'ws-form'),
					'log_ecommerce_payment_amount'				=>	__('Ecommerce - Payment amount set to: %s', 'ws-form'),
					'log_payment'								=>	__('Payments - %s', 'ws-form'),
					'log_calc_registered'						=>	__('Calculation registered: %s', 'ws-form'),
					'log_calc_registered_triggered'				=>	__('Triggered by: %s', 'ws-form'),
					'log_calc_fired'							=>	__('Calculation fired: %s', 'ws-form'),
					'log_calc_fired_triggered'					=>	__('Triggered by: %s', 'ws-form'),
					'log_calc_init'								=>	__('Initial calculation', 'ws-form'),

					// Submissions
					'submit_duration_hours'				=>	__('Hours', 'ws-form'),
					'submit_duration_minutes'			=>	__('Minutes', 'ws-form'),
					'submit_duration_seconds'			=>	__('Seconds', 'ws-form'),
				);

				// Add to language array
				$settings_form_public['language'] = array();
				foreach($language_extra as $key => $value) {

					$settings_form_public['language'][$key] = $value;
				}
			}

			// Conditional
			require_once 'class-ws-form-config-conditional.php';
			$ws_form_config_conditional = new WS_Form_Config_Conditional();
			$settings_form_public['conditional'] = $ws_form_config_conditional->get_settings_conditional();

			// Group, section, field
			if(!$debug) {

				foreach($settings_form_public['conditional']['objects'] as $object_key => $object) {

					// Remove object text
					unset($settings_form_public['conditional']['objects'][$object_key]['text']);

					$public_attributes_strip = array(

						'logic'		=>	array('text', 'values', 'type', 'case_sensitive', 'min', 'max', 'unit'),
						'action'	=>	array('text', 'values', 'auto_else', 'auto_else_copy', 'value_row_ids', 'type')
					);

					// Logic, Action to filter
					foreach($public_attributes_strip as $key => $attributes) {

						// Individual logics and actions
						foreach($object[$key] as $key_inner => $attributes_inner) {

							// Attributes of logic or action
							foreach($attributes as $attribute) {
								
								if(isset($settings_form_public['conditional']['objects'][$object_key][$key][$key_inner][$attribute])) {
									unset($settings_form_public['conditional']['objects'][$object_key][$key][$key_inner][$attribute]);
								}
							}

							if(count($settings_form_public['conditional']['objects'][$object_key][$key][$key_inner]) == 0) {

								unset($settings_form_public['conditional']['objects'][$object_key][$key][$key_inner]);
							}
						}
					}
				}
			}

			// Apply filter
			$settings_form_public = apply_filters('wsf_config_settings_form_public', $settings_form_public);

			return $settings_form_public;
		}

		// Configuration - Get field types public
		public static function get_field_types_public($field_types_filter) {

			$field_types = self::get_field_types_flat(true);

			// Filter by fields found in forms
			if(count($field_types_filter) > 0) {

				$field_types_old = $field_types;
				$field_types = array();

				foreach($field_types_filter as $field_type) {

					if(isset($field_types_old[$field_type])) { $field_types[$field_type] = $field_types_old[$field_type]; }
				}
	
			} else {

				return $field_types;	
			}

			// Strip attributes
			$public_attributes_strip = array('label' => false, 'label_default' => false, 'submit_edit' => false, 'conditional' => array('logics_enabled', 'actions_enabled'), 'compatibility_id' => false, 'kb_url' => false, 'fieldsets' => false, 'pro_required' => false);

			foreach($field_types as $key => $field) {

				foreach($public_attributes_strip as $attribute_strip => $attributes_strip_sub) {

					if(isset($field_types[$key][$attribute_strip])) {

						if(is_array($attributes_strip_sub)) {

							foreach($attributes_strip_sub as $attribute_strip_sub) {

								if(isset($field_types[$key][$attribute_strip][$attribute_strip_sub])) {

									unset($field_types[$key][$attribute_strip][$attribute_strip_sub]);
								}
							}

						} else {

							unset($field_types[$key][$attribute_strip]);
						}
					}
				}
			}

			return $field_types;
		}
	}