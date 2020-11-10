<?php

	/**
	 * Configuration settings
	 * Pro Version
	 */

	class WS_Form_Config {

		// Caches
		public static $meta_keys = array();
		public static $file_types = false;
		public static $settings_plugin = array();
		public static $frameworks = array();
		public static $parse_variables = array();
		public static $tracking = array();
		public static $ecommerce = false;
		public static $data_sources = false;
		public static $field_types = array();

		// Get full public or admin config
		public static function get_config($parameters = false, $field_types = array(), $is_admin = null) {

			// Determine if this is an admin or public API request
			if($is_admin === null) {
				$is_admin = (WS_Form_Common::get_query_var('wsf_fia', 'false') == 'true');
			}
			$form_id = WS_Form_Common::get_query_var('form_id', 0);

			// Standard response
			$config = array();

			// Different for admin or public
			if($is_admin) {

				$config['meta_keys'] = self::get_meta_keys($form_id, false);
				$config['field_types'] = self::get_field_types(false);
				$config['file_types'] = self::get_file_types(false);
				$config['settings_plugin'] = self::get_settings_plugin(false);
				$config['settings_form'] = self::get_settings_form_admin();
				$config['frameworks'] = self::get_frameworks(false);
				$config['parse_variables'] = self::get_parse_variables(false);
				$config['parse_variable_help'] = self::get_parse_variable_help($form_id, false);
				$config['calc'] = self::get_calc();
				$config['tracking'] = self::get_tracking(false);
				$config['ecommerce'] = self::get_ecommerce();
				$config['actions'] = WS_Form_Action::get_settings();
				$config['data_sources'] = WS_Form_Data_Source::get_settings();

			} else {

				$config['meta_keys'] = self::get_meta_keys($form_id, true);
				$config['field_types'] = self::get_field_types_public($field_types);
				$config['settings_plugin'] = self::get_settings_plugin();
				$config['settings_form'] = self::get_settings_form_public();
				$config['frameworks'] = self::get_frameworks();
				$config['parse_variables'] = self::get_parse_variables();
				$config['external'] = self::get_external();
				$config['analytics'] = self::get_analytics();
				$config['tracking'] = self::get_tracking();
				$config['ecommerce'] = self::get_ecommerce();

				// Debug
				if(WS_Form_Common::debug_enabled()) {

					$config['debug'] = self::get_debug();
				}
			}

			// Add generic settings (Shared between both admin and public, e.g. language)
			$config['settings_form'] = array_merge_recursive($config['settings_form'], self::get_settings_form(!$is_admin));

			return $config;
		}

		public static function get_settings_form_admin() {

			include_once 'config/class-ws-form-config-admin.php';
			$ws_form_config_admin = new WS_Form_Config_Admin();
			return $ws_form_config_admin->get_settings_form_admin();
		}

		public static function get_calc() {

			include_once 'config/class-ws-form-config-admin.php';
			$ws_form_config_admin = new WS_Form_Config_Admin();
			return $ws_form_config_admin->get_calc();
		}

		public static function get_parse_variable_help($form_id = 0, $public = true, $group = false, $group_first = false) {

			include_once 'config/class-ws-form-config-admin.php';
			$ws_form_config_admin = new WS_Form_Config_Admin();
			return $ws_form_config_admin->get_parse_variable_help($form_id, $public, $group, $group_first);
		}

		public static function get_system() {

			include_once 'config/class-ws-form-config-admin.php';
			$ws_form_config_admin = new WS_Form_Config_Admin();
			return $ws_form_config_admin->get_system();
		}

		public static function get_file_types() {

			include_once 'config/class-ws-form-config-admin.php';
			$ws_form_config_admin = new WS_Form_Config_Admin();
			return $ws_form_config_admin->get_file_types();
		}

		public static function get_settings_form_public() {

			include_once 'config/class-ws-form-config-public.php';
			$ws_form_config_public = new WS_Form_Config_Public();
			return $ws_form_config_public->get_settings_form_public();
		}

		public static function get_field_types_public($field_types_filter) {

			include_once 'config/class-ws-form-config-public.php';
			$ws_form_config_public = new WS_Form_Config_Public();
			return $ws_form_config_public->get_field_types_public($field_types_filter);
		}

		public static function get_logo_svg() {

			include_once 'config/class-ws-form-config-svg.php';
			$ws_form_config_svg = new WS_Form_Config_SVG();
			return $ws_form_config_svg->get_logo_svg();
		}

		public static function get_icon_24_svg($id = '') {

			include_once 'config/class-ws-form-config-svg.php';
			$ws_form_config_svg = new WS_Form_Config_SVG();
			return $ws_form_config_svg->get_icon_24_svg($id);
		}

		public static function get_icon_16_svg($id = '') {

			include_once 'config/class-ws-form-config-svg.php';
			$ws_form_config_svg = new WS_Form_Config_SVG();
			return $ws_form_config_svg->get_icon_16_svg($id);
		}

		public static function get_debug() {

			include_once 'config/class-ws-form-config-debug.php';
			$ws_form_config_debug = new WS_Form_Config_Debug();
			return $ws_form_config_debug->get_debug();
		}

		// Configuration - Field Types
		public static function get_field_types($public = true) {

			// Check cache
			if(isset(self::$field_types[$public])) { return self::$field_types[$public]; }

			$field_types = array(

				'basic' => array(

					'label'	=> __('Basic', 'ws-form'),
					'types' => array(

						'text' => array (

							'label'				=>	__('Text', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'			=>	'/knowledgebase/text/',
							'label_default'		=>	__('Text', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'calc_in'			=>	true,
							'calc_out'			=>	true,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'		=>	array('equals', 'equals_not', 'contains', 'contains_not', 'starts', 'starts_not', 'ends', 'ends_not', 'blank', 'blank_not', 'cc==', 'cc!=', 'cc>', 'cc<', 'cw==', 'cw!=', 'cw>', 'cw<', 'regex', 'regex_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'		=>	array('visibility', 'required', 'focus', 'value', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'		=>	'change input'
							),
							'events'			=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'		=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'			=>	'<option value="#datalist_field_value">#datalist_field_text</option>',
							'mask_row_lookups'	=>	array('datalist_field_value', 'datalist_field_text'),
							'datagrid_column_value'	=>	'datalist_field_value',

							// Fields
							'mask_field'					=>	'<input type="text" id="#id" name="#name" value="#value"#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'disabled', 'readonly', 'required', 'min_length', 'max_length', 'min_length_words', 'max_length_words', 'input_mask', 'placeholder', 'pattern', 'list', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'autocomplete_off', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=>	array(

								// Tab: Basic
								'basic'	=>	array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required', 'hidden', 'autocomplete_off', 'default_value', 'placeholder', 'help_count_char_word'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'	=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'readonly', 'min_length', 'max_length', 'min_length_words', 'max_length_words', 'input_mask', 'pattern', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Autocomplete
								'datalist'	=> array(

									'label'		=>	__('Datalist', 'ws-form'),
									'meta_keys'	=> array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'textarea' => array (

							'label'				=>	__('Text Area', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'			=>	'/knowledgebase/textarea/',
							'label_default'		=>	__('Text Area', 'ws-form'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'calc_in'			=>	true,
							'calc_out'			=>	true,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'		=>	array('equals', 'equals_not', 'contains', 'contains_not', 'starts', 'starts_not', 'ends', 'ends_not', 'blank', 'blank_not', 'cc==', 'cc!=', 'cc>', 'cc<', 'cw==', 'cw!=', 'cw>', 'cw<', 'regex', 'regex_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'		=>	array('visibility', 'required', 'focus', 'value_textarea', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'		=>	'change input'
							),
							'events'			=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Fields
							'mask_field'					=>	'<textarea id="#id" name="#name"#attributes>#value</textarea>#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'disabled', 'readonly', 'required', 'min_length', 'max_length', 'min_length_words', 'max_length_words', 'input_mask', 'placeholder', 'spellcheck', 'cols', 'rows', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'input_type_textarea', 'input_type_textarea_toolbar', 'autocomplete_off', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=>	array(

								// Tab: Basic
								'basic'	=>	array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('label_render', 'input_type_textarea', 'input_type_textarea_toolbar', 'required', 'hidden', 'autocomplete_off', 'default_value_textarea', 'placeholder', 'help_count_char_word_with_default'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'readonly', 'min_length', 'max_length', 'min_length_words', 'max_length_words', 'input_mask', 'cols', 'rows', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'number' => array (

							'label'				=>	__('Number', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'			=>	'/knowledgebase/number/',
							'label_default'		=>	__('Number', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'calc_in'			=>	true,
							'calc_out'			=>	true,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('==', '!=', '<', '>', '<=', '>=', 'blank', 'blank_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'	=>	array('visibility', 'required', 'focus', 'value_number', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change input'
							),
							'compatibility_id'	=>	'input-number',
							'events'			=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'		=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'				=>	'<option value="#datalist_field_value">#datalist_field_text</option>',
							'mask_row_lookups'		=>	array('datalist_field_value', 'datalist_field_text'),
							'datagrid_column_value'	=>	'datalist_field_value',

							// Fields
							'mask_field'									=>	'<input type="number" id="#id" name="#name" value="#value"#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'				=>	array('class', 'list', 'min', 'max', 'step', 'disabled', 'readonly', 'required', 'placeholder', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'autocomplete_off', 'hidden_bypass'),
							'mask_field_label'						=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required', 'hidden', 'autocomplete_off', 'default_value_number', 'placeholder', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'readonly', 'min', 'max', 'step', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Datalist
								'datalist'	=> array(

									'label'			=>	__('Datalist', 'ws-form'),
									'meta_keys'		=> array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'tel' => array (

							'label'				=>	__('Phone', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'			=>	'/knowledgebase/tel/',
							'label_default'		=>	__('Phone', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'calc_in'			=>	true,
							'calc_out'			=>	false,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('equals', 'equals_not', 'contains', 'contains_not', 'starts', 'starts_not', 'ends', 'ends_not', 'blank', 'blank_not', 'cc==', 'cc!=', 'cc>', 'cc<', 'regex', 'regex_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'	=>	array('visibility', 'required', 'focus', 'value_tel', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change input'
							),
							'compatibility_id'	=>	'input-email-tel-url',
							'events'			=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'		=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'				=>	'<option value="#datalist_field_value">#datalist_field_text</option>',
							'mask_row_lookups'		=>	array('datalist_field_value', 'datalist_field_text'),
							'datagrid_column_value'	=>	'datalist_field_value',

							// Fields
							'mask_field'					=>	'<input type="tel" id="#id" name="#name" value="#value"#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'disabled', 'readonly', 'min_length', 'max_length', 'pattern_tel', 'list', 'required', 'placeholder', 'aria_describedby', 'aria_labelledby', 'aria_label', 'input_mask', 'custom_attributes', 'autocomplete_off', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=>	array(

								// Tab: Basic
								'basic'	=>	array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('label_render', 'required', 'hidden', 'autocomplete_off', 'default_value_tel', 'placeholder', 'help_count_char'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'		=>	array(

									'label'		=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled','readonly', 'min_length', 'max_length', 'input_mask', 'pattern_tel', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Datalist
								'datalist'	=> array(

									'label'		=>	__('Datalist', 'ws-form'),
									'meta_keys'	=> array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'email' => array (

							'label'					=>	__('Email', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'				=>	'/knowledgebase/email/',
							'label_default'			=>	__('Email', 'ws-form'),
							'data_source'			=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'			=>	true,
							'submit_edit'			=>	true,
							'calc_in'				=>	true,
							'calc_out'				=>	false,
							'value_out'				=>	true,
							'progress'				=>	true,
							'conditional'			=>	array(

								'logics_enabled'	=>	array('equals', 'equals_not', 'contains', 'contains_not', 'starts', 'starts_not', 'ends', 'ends_not', 'blank', 'blank_not', 'cc==', 'cc!=', 'cc>', 'cc<', 'regex_email', 'regex_email_not', 'regex', 'regex_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'	=>	array('visibility', 'required', 'focus', 'value_email', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change input'
							),
							'compatibility_id'	=>	'input-email-tel-url',
							'events'				=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'			=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'		=> true,

							// Rows
							'mask_row'				=>	'<option value="#datalist_field_value">#datalist_field_text</option>',
							'mask_row_lookups'		=>	array('datalist_field_value', 'datalist_field_text'),
							'datagrid_column_value'	=>	'datalist_field_value',

							// Fields
							'mask_field'						=>	'<input type="email" id="#id" name="#name" value="#value"#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'				=>	array('class', 'multiple_email', 'min_length', 'max_length', 'pattern', 'list', 'disabled', 'readonly', 'required', 'placeholder', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'autocomplete_off', 'hidden_bypass'),
							'mask_field_label'					=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'		=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required', 'hidden', 'autocomplete_off', 'default_value_email', 'multiple_email', 'placeholder', 'help_count_char'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'		=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled','readonly', 'min_length', 'max_length', 'pattern', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Datalist
								'datalist'	=> array(

									'label'		=>	__('Datalist', 'ws-form'),
									'meta_keys'	=> array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'url' => array (

							'label'				=>	__('URL', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'			=>	'/knowledgebase/url/',
							'label_default'		=>	__('URL', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'calc_in'			=>	false,
							'calc_out'			=>	false,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('equals', 'equals_not', 'contains', 'contains_not', 'starts', 'starts_not', 'ends', 'ends_not', 'blank', 'blank_not', 'cc==', 'cc!=', 'cc>', 'cc<', 'regex_url', 'regex_url_not', 'regex', 'regex_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'	=>	array('visibility', 'required', 'focus', 'value_url', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change input'
							),
							'compatibility_id'	=>	'input-email-tel-url',
							'events'						=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'				=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'							=>	'<option value="#datalist_field_value">#datalist_field_text</option>',
							'mask_row_lookups'			=>	array('datalist_field_value', 'datalist_field_text'),
							'datagrid_column_value'	=>	'datalist_field_value',

							// Fields
							'mask_field'									=>	'<input type="url" id="#id" name="#name" value="#value"#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'				=>	array('class', 'min_length', 'max_length', 'list', 'disabled', 'readonly', 'required', 'placeholder', 'pattern', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'autocomplete_off', 'hidden_bypass'),
							'mask_field_label'						=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required', 'hidden', 'autocomplete_off', 'default_value_url', 'placeholder', 'help_count_char'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'			=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'	=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'			=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'			=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled','readonly', 'min_length', 'max_length', 'pattern', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'			=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Datalist
								'datalist'	=> array(

									'label'			=>	__('Datalist', 'ws-form'),
									'meta_keys'	=> array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						)
					)
				),

				'choice' => array(

					'label'	=> __('Choice', 'ws-form'),
					'types' => array(

						'select' => array (

							'label'				=>	__('Select', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'			=>	'/knowledgebase/select/',
							'label_default'		=>	__('Select', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_select'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'submit_array'		=>	true,
							'calc_in'			=>	false,
							'calc_out'			=>	true,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'data_grid_fields'			=>	'data_grid_select',
								'option_text'				=>	'select_field_label',
								'logics_enabled'			=>	array('selected', 'selected_not', 'selected_any', 'selected_any_not', 'rs==', 'rs!=', 'rs>', 'rs<', 'selected_value_equals', 'selected_value_equals', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input'),
								'actions_enabled'			=>	array('visibility', 'required', 'focus', 'value_row_select', 'value_row_deselect', 'value_row_select_value', 'value_row_deselect_value', 'value_row_disabled', 'value_row_not_disabled', 'value_row_class_add', 'value_row_class_remove', 'value', 'disabled', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'value_row_reset'),
								'condition_event'			=>	'change'
							),
							'events'	=>	array(

								'event'						=>	'change',
								'event_category'			=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'					=>	'<optgroup label="#group_label"#disabled>#group</optgroup>',
							'mask_group_label'				=>	'#group_label',

							// Rows
							'mask_row'						=>	'<option id="#row_id" data-id="#data_id" value="#select_field_value"#attributes>#select_field_label</option>',
							'mask_row_placeholder'			=>	'<option data-id="0" value="" data-placeholder>#value</option>',
							'mask_row_attributes'			=>	array('default', 'disabled'),
							'mask_row_lookups'				=>	array('select_field_value', 'select_field_label', 'select_field_parse_variable', 'select_cascade_field_filter'),
							'datagrid_column_value'			=>	'select_field_value',
							'mask_row_default' 				=>	' selected',

							// Fields
							'mask_field'					=>	'<select id="#id" name="#name"#attributes>#datalist</select>#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'size', 'multiple', 'required', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'dedupe_value_scope', 'select_cascade_ajax', 'hidden_bypass', 'select2', 'select2_ajax'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=> array('label_render', 'required', 'hidden', 'multiple', 'size', 'placeholder_row', 'help'),
									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Select2', 'ws-form'),
											'meta_keys'	=>	array('select2_intro', 'select2', 'select2_ajax')
										),
										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'	=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'select_min', 'select_max', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),
										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe_value_scope')
										),
										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Options
								'options'	=> array(

									'label'			=>	__('Options', 'ws-form'),
									'meta_keys'		=> array('data_grid_select', 'data_grid_rows_randomize'),
									'fieldsets' => array(

										array(
											'label'		=>	__('Column Mapping', 'ws-form'),
											'meta_keys'	=> array('select_field_label', 'select_field_value', 'select_field_parse_variable')
										),
										array(
											'label'		=>	__('Cascading', 'ws-form'),
											'meta_keys'	=> array('select_cascade', 'select_cascade_field_filter', 'select_cascade_field_id', 'select_cascade_no_match', 'select_cascade_option_text_no_rows', 'select_cascade_ajax', 'select_cascade_ajax_option_text_loading')
										)
									)
								)
							)
						),

						'checkbox' => array (

							'label'				=>	__('Checkbox', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'			=>	'/knowledgebase/checkbox/',
							'label_default'		=>	__('Checkbox', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_checkbox'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'submit_array'		=>	true,
							'calc_in'			=>	false,
							'calc_out'			=>	true,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'data_grid_fields'		=>	'data_grid_checkbox',
								'option_text'			=>	'checkbox_field_label',
								'logics_enabled'		=>	array('checked', 'checked_not', 'checked_any', 'checked_any_not', 'rc==', 'rc!=', 'rc>', 'rc<', 'checked_value_equals', 'checked_value_equals', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input'),
								'actions_enabled'		=>	array('visibility', 'class_add_wrapper', 'class_remove_wrapper', 'value_row_check', 'value_row_uncheck', 'value_row_check_value','value_row_uncheck_value', 'value_row_focus', 'value_row_required', 'value_row_not_required', 'value_row_disabled', 'value_row_not_disabled', 'value_row_visible', 'value_row_not_visible', 'value_row_class_add', 'value_row_class_remove', 'value_row_set_custom_validity', 'reset', 'clear'),
								'condition_event'		=>	'change',
								'condition_event_row'	=>	true
							),
							'events'	=>	array(

								'event'				=>	'change',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group_wrapper'		=>	'<div#attributes>#group</div>',
							'mask_group_label'			=>	'<legend>#group_label</legend>',

							// Rows
							'mask_row'					=>	'<div#attributes>#row_label</div>',
							'mask_row_attributes'		=>	array('class'),
							'mask_row_label'			=>	'<label id="#label_row_id" for="#row_id"#attributes>#row_field#checkbox_field_label#required</label>#invalid_feedback',
							'mask_row_label_attributes'	=>	array('class'),
							'mask_row_field'			=>	'<input type="checkbox" id="#row_id" name="#name" value="#checkbox_field_value"#attributes />',
							'mask_row_field_attributes'	=>	array('class', 'default', 'disabled', 'required', 'aria_labelledby', 'dedupe_value_scope', 'hidden_bypass'),
							'mask_row_lookups'			=>	array('checkbox_field_value', 'checkbox_field_label', 'checkbox_field_parse_variable', 'checkbox_cascade_field_filter'),
							'datagrid_column_value'		=>	'checkbox_field_value',
							'mask_row_default' 			=>	' checked',

							// Fields
							'mask_field'					=>	'#datalist#invalid_feedback#help',
							'mask_field_label'				=>	'<label id="#label_id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),
//							'mask_field_label_hide_group'	=>	true,

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render_off', 'hidden', 'select_all', 'select_all_label', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Layout', 'ws-form'),
											'meta_keys'	=>	array('orientation',
												'orientation_breakpoint_sizes'
											)
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'	=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('checkbox_min', 'checkbox_max', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),
										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe_value_scope')
										),
										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Checkboxes
								'checkboxes' 	=> array(

									'label'		=>	__('Checkboxes', 'ws-form'),
									'meta_keys'	=> array('data_grid_checkbox', 'data_grid_rows_randomize'),
									'fieldsets' => array(

										array(
											'label'		=>	__('Column Mapping', 'ws-form'),
											'meta_keys'	=> array('checkbox_field_label', 'checkbox_field_value', 'checkbox_field_parse_variable')
										),
										array(
											'label'		=>	__('Cascading', 'ws-form'),
											'meta_keys'	=> array('checkbox_cascade', 'checkbox_cascade_field_filter', 'checkbox_cascade_field_id', 'checkbox_cascade_no_match')
										)
									)
								)
							)
						),

						'radio' => array (

							'label'				=>	__('Radio', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'			=>	'/knowledgebase/radio/',
							'label_default'		=>	__('Radio', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_radio'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'submit_array'		=>	true,
							'calc_in'			=>	false,
							'calc_out'			=>	true,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'data_grid_fields'		=>	'data_grid_radio',
								'option_text'			=>	'radio_field_label',
								'logics_enabled'		=>	array('checked', 'checked_not', 'checked_any', 'checked_any_not', 'checked_value_equals', 'checked_value_equals', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input'),
								'actions_enabled'		=>	array('visibility', 'required', 'class_add_wrapper', 'class_remove_wrapper', 'value_row_check', 'value_row_uncheck', 'value_row_check_value','value_row_uncheck_value', 'value_row_focus', 'value_row_disabled', 'value_row_not_disabled', 'value_row_visible', 'value_row_not_visible', 'value_row_class_add', 'value_row_class_remove', 'set_custom_validity', 'reset', 'clear'),
								'condition_event'		=>	'change',
								'condition_event_row'	=>	true
							),
							'events'	=>	array(

								'event'				=>	'change',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group_wrapper'		=>	'<div#attributes>#group</div>',
							'mask_group_label'			=>	'<legend>#group_label</legend>',

							// Rows
							'mask_row'					=>	'<div#attributes>#row_label</div>',
							'mask_row_attributes'		=>	array('class'),
							'mask_row_label'			=>	'<label id="#label_row_id" for="#row_id" data-label-required-id="#label_id"#attributes>#row_field#radio_field_label</label>#invalid_feedback',
							'mask_row_label_attributes'	=>	array('class'),
							'mask_row_field'			=>	'<input type="radio" id="#row_id" name="#name" value="#radio_field_value"#attributes />',
							'mask_row_field_attributes'	=>	array('class', 'default', 'disabled', 'required_row', 'aria_labelledby', 'hidden', 'dedupe_value_scope', 'hidden_bypass'),
							'mask_row_lookups'			=>	array('radio_field_value', 'radio_field_label', 'radio_field_parse_variable', 'radio_cascade_field_filter'),
							'datagrid_column_value'		=>	'radio_field_value',
							'mask_row_default' 			=>	' checked',

							// Fields
							'mask_field'					=>	'#datalist#help',
							'mask_field_attributes'			=>	array('class', 'required_attribute_no'),
							'mask_field_label'				=>	'<label id="#label_id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),
//							'mask_field_label_hide_group'	=>	true,

							'invalid_feedback_last_row'		=> true,

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('label_render', 'required_attribute_no', 'hidden', 'help'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Layout', 'ws-form'),
											'meta_keys'	=>	array('orientation',
												'orientation_breakpoint_sizes'
											)
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'	=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),
										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe_value_scope')
										),
										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Radios
								'radios'	=> array(

									'label'		=>	__('Radios', 'ws-form'),
									'meta_keys'	=> array('data_grid_radio', 'data_grid_rows_randomize'),
									'fieldsets' => array(

										array(
											'label'		=>	__('Column Mapping', 'ws-form'),
											'meta_keys'	=> array('radio_field_label', 'radio_field_value', 'radio_field_parse_variable')
										),
										array(
											'label'		=>	__('Cascading', 'ws-form'),
											'meta_keys'	=> array('radio_cascade', 'radio_cascade_field_filter', 'radio_cascade_field_id', 'radio_cascade_no_match')
										)
									)
								)
							)
						),

						'datetime' => array (

							'label'				=>	__('Date/Time', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'			=>	'/knowledgebase/datetime/',
							'label_default'		=>	__('Date/Time', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'calc_in'			=>	true,
							'calc_out'			=>	true,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('d==', 'd!=', 'd<', 'd>', 'blank', 'blank_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'	=>	array('visibility', 'required', 'focus', 'value_datetime', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change'
							),
							'compatibility_id'	=>	'input-datetime',
							'events'			=>	array(

								'event'				=>	'change',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'		=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'			=>	'<option value="#datalist_field_value">#datalist_field_text</option>',
							'mask_row_lookups'	=>	array('datalist_field_value', 'datalist_field_text'),

							// Fields
							'mask_field'					=>	'<input id="#id" name="#name" value="#value"#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'			=>	array('input_type_datetime', 'format_date', 'format_time', 'class', 'disabled', 'required', 'readonly', 'min_date', 'max_date', 'inline', 'year_start', 'year_end', 'step', 'input_mask', 'pattern_date', 'list', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'autocomplete_off_on', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=>	array(

								// Tab: Basic
								'basic'	=>	array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'input_type_datetime', 'format_date', 'format_time', 'required', 'hidden', 'autocomplete_off_on', 'inline', 'default_value_datetime', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'		=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'readonly', 'min_date', 'max_date', 'year_start', 'year_end', 'step', 'input_mask', 'pattern_date', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Autocomplete
								'datalist'	=> array(

									'label'		=>	__('Datalist', 'ws-form'),
									'meta_keys'	=> array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'range' => array (

							'label'				=>	__('Range Slider', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'			=>	'/knowledgebase/range/',
							'label_default'		=>	__('Range Slider', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'calc_in'			=>	true,
							'calc_out'			=>	true,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('==', '!=', '<', '>', '<=', '>=', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input'),
								'actions_enabled'	=>	array('visibility', 'focus', 'value_range', 'disabled', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change input'
							),
							'compatibility_id'	=>	'input-range',
							'events'						=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),
							'trigger'			=> 'input',

							// Groups
							'mask_group'		=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'			=>	'<option value="#datalist_field_value" style="--position-tick-mark: #datalist_field_value_percentage%;" data-label="#datalist_field_text"></option>',
							'mask_row_lookups'	=>	array('datalist_field_value', 'datalist_field_text'),

							// Fields
							'mask_field'					=>	'<input type="range" id="#id" name="#name" value="#value"#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'list', 'min', 'max', 'step', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'class_fill_lower_track', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('label_render', 'hidden', 'default_value_range', 'help_range'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'		=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align', 'class_fill_lower_track')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'min', 'max', 'step', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Tick Marks
								'tickmarks'	=> array(

									'label'		=>	__('Tick Marks', 'ws-form'),
									'meta_keys'	=>	array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'color' => array (

							'label'				=>	__('Color Picker', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'			=>	'/knowledgebase/color/',
							'label_default'		=>	__('Color Picker', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'calc_in'			=>	false,
							'calc_out'			=>	false,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('c==', 'c!=', 'ch<', 'ch>', 'cs<', 'cs>', 'cl<', 'cl>', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'	=>	array('visibility', 'focus', 'value_color', 'disabled', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change'
							),
							'compatibility_id'	=>	'input-color',
							'events'			=>	array(

								'event'				=>	'change',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'		=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'			=>	'<option>#datalist_field_value</option>',
							'mask_row_lookups'	=>	array('datalist_field_value'),

							// Fields
							'mask_field'					=>	'<input type="#color_type" id="#id" name="#name" value="#value"#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'list', 'required', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'autocomplete_off', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required', 'hidden', 'autocomplete_off', 'default_value_color', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Datalist
								'datalist'	=> array(

									'label'			=>	__('Datalist', 'ws-form'),
									'meta_keys'		=>	array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_value')
										)
									)
								)
							)
						),

						'rating' => array (

							'label'				=>	__('Rating', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'			=>	'/knowledgebase/rating/',
							'label_default'		=>	__('Rating', 'ws-form'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'calc_in'			=>	true,
							'calc_out'			=>	true,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('==', '!=', '<', '>', '<=', '>=', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input'),
								'actions_enabled'	=>	array('visibility', 'value_rating', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change input'
							),
							'events'			=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),
							'trigger'			=> 'input',

							'mask_field'					=>	'<input data-rating type="number" id="#id" name="#name" value="#value"#attributes style="display:none;" />#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'required', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'rating_color_off', 'rating_color_on', 'hidden_bypass', 'readonly'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required', 'hidden', 'default_value_number', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align', 'horizontal_align', 'rating_icon', 'rating_icon_html', 'rating_size', 'rating_color_off', 'rating_color_on')
										),

										array(
											'label'			=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'			=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('readonly', 'rating_max', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),										

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'			=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						)
					)
				),

				'advanced' => array(

					'label'	=> __('Advanced', 'ws-form'),
					'types' => array(

						'file' => array (

							'label'							=>	__('File Upload', 'ws-form'),
							'pro_required'					=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'						=>	'/knowledgebase/file/',
							'label_default'					=>	__('File Upload', 'ws-form'),
							'label_position_force'			=>	'top',	// Prevent formatting issues with different label positioning. The label is the button.
							'submit_save'					=>	true,
							'submit_edit'					=>	false,
							'submit_array'					=>	true,
							'calc_in'						=>	false,
							'calc_out'						=>	false,
							'value_out'						=>	false,
							'progress'						=>	true,
							'conditional'					=>	array(

								'logics_enabled'	=>	array('f==', 'f!=', 'f<', 'f>', 'file', 'file_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input'),
								'actions_enabled'	=>	array('visibility', 'required', 'focus', 'click', 'disabled', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset_file'),
								'condition_event'	=>	'change input'
							),
							'events'						=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Fields
							'mask_field'					=>	'<input type="file" id="#id" name="#name"#attributes />#label#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'multiple_file', 'directory', 'disabled', 'accept', 'required', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'file_preview', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class', 'file_button_label'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('required', 'hidden', 'multiple_file', 'directory', 'file_button_label', 'help'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Preview', 'ws-form'),
											'meta_keys'	=> array('file_preview', 'file_preview_orientation', 'file_preview_width', 'file_preview_orientation_breakpoint_sizes')
										),

										array(
											'label'		=>	__('Image Optimization', 'ws-form'),
											'meta_keys'	=> array('file_image_max_width', 'file_image_max_height', 'file_image_crop', 'file_image_compression', 'file_image_mime')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('File Restrictions', 'ws-form'),
											'meta_keys'	=> array('accept')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'hidden' => array (

							'label'						=>	__('Hidden', 'ws-form'),
							'pro_required'				=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'					=>	'/knowledgebase/hidden/',
							'label_default'				=>	__('Hidden', 'ws-form'),
							'mask_field'				=>	'<input type="hidden" id="#id" name="#name" value="#value" data-default-value="#value" data-id-hidden="#field_id" />',
							'submit_save'				=>	true,
							'submit_edit'				=>	true,
							'submit_edit_type'			=>	'text',
							'calc_in'					=>	true,
							'calc_out'					=>	true,
							'value_out'					=>	true,
							'progress'					=>	false,
							'conditional'				=>	array(

								'logics_enabled'		=>	array('equals', 'equals_not', 'contains', 'contains_not', 'starts', 'starts_not', 'ends', 'ends_not', '<', '>', '<=', '>=', 'blank', 'blank_not', 'regex', 'regex_not', 'field_match', 'field_match_not'),
								'actions_enabled'		=>	array('value', 'reset', 'clear'),
								'condition_event'		=>	'change'
							),
							'events'						=>	array(

								'event'				=>	'change',
								'event_category'	=>	__('Field', 'ws-form')
							),
							'mask_wrappers_drop'		=>	true,

							'fieldsets'					=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('default_value'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email_on')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=> array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										)
									)
								)
							)
						),

						'recaptcha' => array (

							'label'							=>	__('reCAPTCHA', 'ws-form'),
							'pro_required'					=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'						=>	'/knowledgebase/recaptcha/',
							'label_default'					=>	__('reCAPTCHA', 'ws-form'),
							'mask_field'					=>	'<div id="#id" name="#name" style="border: none; padding: 0" required#attributes></div>#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'recaptcha_site_key', 'recaptcha_recaptcha_type', 'recaptcha_badge', 'recaptcha_type', 'recaptcha_theme', 'recaptcha_size', 'recaptcha_language', 'recaptcha_action'),
							'submit_save'					=>	false,
							'submit_edit'					=>	false,
							'calc_in'						=>	false,
							'calc_out'						=>	false,
							'value_out'						=>	false,
							'progress'						=>	false,
							'multiple'						=>	false,
							'conditional'					=>	array(

								'logics_enabled'	=>	array('recaptcha', 'recaptcha_not'),
								'actions_enabled'	=>	array('visibility', 'class_add_wrapper', 'class_remove_wrapper'),
								'condition_event'	=> 'recaptcha'
							),
							'events'						=>	array(

								'event'				=>	'mousedown touchstart',
								'event_category'	=>	__('Field', 'ws-form')
							),

							'fieldsets'						=> array(

								// Tab: Basic
								'basic'		=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('hidden', 'recaptcha_recaptcha_type', 'recaptcha_site_key', 'recaptcha_secret_key', 'recaptcha_badge', 'recaptcha_type', 'recaptcha_theme', 'recaptcha_size', 'recaptcha_action', 'help'),
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper')
										),

										array(
											'label'			=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),										

										array(
											'label'		=>	__('Localization', 'ws-form'),
											'meta_keys'	=>	array('recaptcha_language')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'signature' => array (

							'label'								=>	__('Signature', 'ws-form'),
							'pro_required'						=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'							=>	'/knowledgebase/signature/',
							'label_default'						=>	__('Signature', 'ws-form'),
							'mask_field'						=>	'<canvas id="#id" name="#name"#attributes tabIndex="0"></canvas>#invalid_feedback#help',
							'mask_field_attributes'				=>	array('class', 'signature_mime', 'signature_dot_size', 'signature_pen_color', 'signature_background_color', 'signature_height', 'signature_crop', 'required', 'disabled', 'custom_attributes', 'hidden_bypass'),
							'mask_field_label'					=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'		=>	array('class'),
							'mask_help_append'					=>	'#help_append_separator<a href="#" data-action="wsf-signature-clear">' . __('Clear', 'ws-form') . '</a>',
							'mask_help_append_separator'		=>	'<br />',
							'submit_save'						=>	true,
							'submit_edit'						=>	false,
							'calc_in'							=>	false,
							'calc_out'							=>	false,
							'value_out'							=>	false,
							'progress'							=>	true,
							'conditional'						=>	array(

								'logics_enabled'		=>	array('signature', 'signature_not', 'validate', 'validate_not'),
								'actions_enabled'		=>	array('visibility', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'required_signature', 'disabled', 'reset_signature'),
								'condition_event'		=>	'mouseup touchend'
							),
							'events'							=>	array(

								'event'				=>	'mouseup touchend',
								'event_category'	=>	__('Field', 'ws-form')
							),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required_on', 'hidden', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'			=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align', 'signature_mime', 'signature_pen_color', 'signature_background_color', 'signature_dot_size', 'signature_height', 'signature_crop',)
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'			=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'progress' => array (

							'label'				=>	__('Progress', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'			=>	'/knowledgebase/progress/',
							'label_default'		=>	__('Progress', 'ws-form'),
							'submit_save'		=>	false,
							'submit_edit'		=>	false,
							'progress'			=>	false,
							'calc_in'			=>	true,
							'calc_out'			=>	false,
							'value_out'			=>	false,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('==', '!=', '<', '>', '<=', '>=', 'field_match', 'field_match_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change'),
								'actions_enabled'	=>	array('visibility', 'value', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change'
							),
							'mask_field'					=>	'<progress data-progress-bar data-progress-bar-value id="#id" name="#name" value="#value" min="0" max="100"#attributes /></progress>#help',
							'mask_field_attributes'			=>	array('class', 'progress_source', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'hidden', 'default_value_number', 'progress_source', 'help_progress'),

									'fieldsets'	=>	array(

										array(
											'label'			=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'			=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'			=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('min', 'max', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'password' => array (

							'label'				=>	__('Password', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'			=>	'/knowledgebase/password/',
							'label_default'		=>	__('Password', 'ws-form'),
							'submit_save'		=>	false,
							'submit_edit'		=>	false,
							'calc_in'			=>	false,
							'calc_out'			=>	false,
							'value_out'			=>	false,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('equals', 'equals_not', 'contains', 'contains_not', 'starts', 'starts_not', 'ends', 'ends_not', 'blank', 'blank_not', 'cc==', 'cc!=', 'cc>', 'cc<', 'regex', 'regex_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'	=>	array('visibility', 'required', 'focus', 'value', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change input'
							),
							'events'				=>	array(

								'event'				=>	'change',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Fields
							'mask_field'					=>	'<input type="password" id="#id" name="#name" value="#value"#attributes />#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'disabled', 'autocomplete_new_password', 'required', 'readonly', 'min_length', 'max_length', 'placeholder', 'input_mask', 'pattern', 'aria_describedby', 'aria_labelledby', 'aria_label', 'password_strength_meter', 'custom_attributes'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=>	array(

								// Tab: Basic
								'basic'	=>	array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('label_render', 'required_on', 'hidden', 'autocomplete_new_password', 'default_value', 'placeholder', 'help_count_char'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Strength', 'ws-form'),
											'meta_keys'	=>	array('password_strength_meter')
										),

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'readonly', 'min_length', 'max_length', 'input_mask', 'pattern', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'search' => array (

							'label'				=>	__('Search', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'			=>	'/knowledgebase/search/',
							'label_default'		=>	__('Search', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	true,
							'calc_in'			=>	true,
							'calc_out'			=>	true,
							'value_out'			=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'		=>	array('equals', 'equals_not', 'contains', 'contains_not', 'starts', 'starts_not', 'ends', 'ends_not', 'blank', 'blank_not', 'cc==', 'cc!=', 'cc>', 'cc<', 'cw==', 'cw!=', 'cw>', 'cw<', 'regex', 'regex_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'		=>	array('visibility', 'required', 'focus', 'value', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'		=>	'change input'
							),
							'events'			=>	array(

								'event'				=>	'keyup',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'		=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'			=>	'<option value="#datalist_field_value">#datalist_field_text</option>',
							'mask_row_lookups'	=>	array('datalist_field_value', 'datalist_field_text'),
							'datagrid_column_value'	=>	'datalist_field_value',

							// Fields
							'mask_field'					=>	'<input type="search" id="#id" name="#name" value="#value"#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'disabled', 'readonly', 'required', 'min_length', 'max_length', 'min_length_words', 'max_length_words', 'input_mask', 'placeholder', 'pattern', 'list', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'autocomplete_off', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=>	array(

								// Tab: Basic
								'basic'	=>	array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required', 'hidden', 'autocomplete_off', 'default_value', 'placeholder', 'help_count_char_word'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'	=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'readonly', 'min_length', 'max_length', 'min_length_words', 'max_length_words', 'input_mask', 'pattern', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe','dedupe_message')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Autocomplete
								'datalist'	=> array(

									'label'		=>	__('Datalist', 'ws-form'),
									'meta_keys'	=> array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'legal' => array (

							'label'					=>	__('Legal', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'				=>	'/knowledgebase/legal/',
							'label_default'			=>	__('Legal', 'ws-form'),

							// Fields
							'mask_field'			=>	'<div data-wsf-legal#attributes>#value</div>',
							'mask_field_attributes'			=>	array('class', 'legal_source', 'legal_termageddon_key', 'legal_termageddon_hide_title', 'legal_style_height'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'submit_save'			=>	false,
							'submit_edit'			=>	false,
							'calc_in'				=>	false,
							'calc_out'				=>	false,
							'value_out'				=>	false,
							'progress'				=>	false,
							'conditional'			=>	array(

								'exclude_condition'	=>	true,
								'actions_enabled'	=>	array('visibility', 'class_add_wrapper', 'class_remove_wrapper')
							),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render_off', 'hidden', 'legal_source', 'legal_termageddon_intro', 'legal_termageddon_key', 'legal_termageddon_hide_title', 'legal_text_editor')
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'legal_style_height', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper')
										),

										array(
											'label'			=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),										

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)

									)
								)
							)
						)
					)
				),

				'content' => array(

					'label'	=> __('Content', 'ws-form'),
					'types' => array(

						'texteditor' => array (

							'label'					=>	__('Text Editor', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'				=>	'/knowledgebase/texteditor/',
							'label_default'			=>	__('Text Editor', 'ws-form'),
							'mask_field'			=>	'<div data-text-editor#attributes>#value</div>',
							'mask_preview'			=>	'#text_editor',
							'meta_wpautop'			=>	'text_editor',
							'meta_do_shortcode'		=>	'text_editor',
							'submit_save'			=>	false,
							'submit_edit'			=>	false,
							'static'				=>	'text_editor',
							'calc_in'				=>	true,
							'calc_out'				=>	false,
							'value_out'				=>	false,
							'progress'				=>	false,
							'conditional'			=>	array(

								'exclude_condition'	=>	true,
								'actions_enabled'	=>	array('visibility', 'text_editor', 'html', 'class_add_wrapper', 'class_remove_wrapper')
							),

							'fieldsets'				=>	array(

								// Tab: Basic
								'basic'	=>	array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('hidden', 'text_editor'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email_on')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'		=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),										
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'html' => array (

							'label'					=>	__('HTML', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'				=>	'/knowledgebase/html/',
							'label_default'			=>	__('HTML', 'ws-form'),
							'mask_field'			=>	'<div data-html#attributes>#value</div>',
							'meta_do_shortcode'		=>	'html_editor',
							'submit_save'			=>	false,
							'submit_edit'			=>	false,
							'static'				=>	'html_editor',
							'calc_in'				=>	true,
							'calc_out'				=>	false,
							'value_out'				=>	false,
							'progress'				=>	false,
							'conditional'			=>	array(

								'exclude_condition'	=>	true,
								'actions_enabled'		=>	array('visibility', 'html', 'class_add_wrapper', 'class_remove_wrapper')
							),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('hidden', 'html_editor'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email_on')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)

									)
								)
							)
						),

						'divider' => array (

							'label'					=>	__('Divider', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'				=>	'/knowledgebase/divider/',
							'label_default'			=>	__('Divider', 'ws-form'),
							'mask_field'			=>	'<hr#attributes />',
							'mask_field_email'		=>	'<hr />',
							'submit_save'			=>	false,
							'submit_edit'			=>	false,
							'calc_in'				=>	false,
							'calc_out'				=>	false,
							'value_out'				=>	false,
							'static'				=>	true,
							'progress'				=>	false,
							'conditional'			=>	array(

								'exclude_condition'	=>	true,
								'actions_enabled'	=>	array('visibility', 'class_add_wrapper', 'class_remove_wrapper')
							),
							'label_disabled'			=>	true,

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('hidden'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email_on')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'		=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align')
										),

										array(
											'label'			=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'spacer' => array (

							'label'				=>	__('Spacer', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'			=>	'/knowledgebase/spacer/',
							'label_default'		=>	__('Spacer', 'ws-form'),
							'mask_field'		=>	'',
							'submit_save'		=>	false,
							'submit_edit'		=>	false,
							'calc_in'			=>	false,
							'calc_out'			=>	false,
							'value_out'			=>	false,
							'progress'			=>	false,
							'conditional'		=>	array(

								'exclude_condition'	=>	true,
								'actions_enabled'	=>	array('visibility', 'class_add_wrapper', 'class_remove_wrapper')
							),
							'label_disabled'	=>	true,

							'fieldsets'			=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('hidden')
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'	=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'message' => array (

							'label'					=>	__('Message', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'				=>	'/knowledgebase/message/',
							'icon'					=>	'info-circle',
							'label_default'			=>	__('Message', 'ws-form'),
							'mask_field'			=>	'<div data-text-editor#attributes>#value</div>',
							'mask_field_attributes'	=>	array('class'),
							'mask_preview'			=>	'#text_editor',
							'meta_wpautop'			=>	'text_editor',
							'meta_do_shortcode'		=>	'text_editor',
							'submit_save'			=>	false,
							'submit_edit'			=>	false,
							'static'				=>	'text_editor',
							'calc_in'				=>	true,
							'calc_out'				=>	false,
							'value_out'				=>	false,
							'progress'				=>	false,
							'conditional'			=>	array(

								'exclude_condition'	=>	true,
								'actions_enabled'	=>	array('visibility', 'text_editor', 'class_add_wrapper', 'class_remove_wrapper')
							),
							'fieldsets'				=>	array(

								// Tab: Basic
								'basic'	=>	array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('hidden', 'class_field_message_type', 'text_editor'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email_on')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'		=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						)
					)
				),

				'buttons' => array(

					'label'	=> __('Buttons', 'ws-form'),
					'types' => array(

						'submit' => array (

							'label'							=>	__('Submit', 'ws-form'),
							'pro_required'					=>	!WS_Form_Common::is_edition('basic'),
							'kb_url'						=>	'/knowledgebase/submit/',
							'label_default'					=>	__('Submit', 'ws-form'),
							'label_position_force'			=>	'top',
							'mask_field'					=>	'<button type="submit" id="#id" name="#name"#attributes>#label</button>#help',
							'mask_field_attributes'			=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes'),
							'mask_field_label'				=>	'#label',
							'submit_save'					=>	false,
							'submit_edit'					=>	false,
							'calc_in'						=>	true,
							'calc_out'						=>	false,
							'value_out'						=>	false,
							'progress'						=>	false,
							'conditional'					=>	array(

								'logics_enabled'		=>	array('click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur'),
								'actions_enabled'		=>	array('visibility', 'focus', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'		=>	'click',
							),
							'events'	=>	array(

								'event'				=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('hidden', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'		=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type_primary', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),
										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'save' => array (

							'label'					=>	__('Save', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'				=>	'/knowledgebase/save/',
							'calc_in'				=>	true,
							'calc_out'				=>	false,
							'label_default'			=>	__('Save', 'ws-form'),
							'label_position_force'	=>	'top',
							'mask_field'			=>	'<button type="button" id="#id" name="#name" data-action="wsf-save"#attributes>#label</button>#help',
							'mask_field_attributes'	=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes'),
							'mask_field_label'		=>	'#label',
							'submit_save'			=>	false,
							'submit_edit'			=>	false,
							'value_out'				=>	false,
							'progress'				=>	false,
							'conditional'			=>	array(

								'logics_enabled'	=>	array('click', 'hidden', 'mouseover', 'mouseout', 'focus', 'blur'),
								'actions_enabled'	=>	array('visibility', 'focus', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'click',
							),
							'events'	=>	array(

								'event'				=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('hidden', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type_success', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'reset' => array (

							'label'							=>	__('Reset', 'ws-form'),
							'pro_required'					=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'						=>	'/knowledgebase/reset/',
							'calc_in'				=>	true,
							'calc_out'				=>	false,
							'label_default'					=>	__('Reset', 'ws-form'),
							'label_position_force'			=>	'top',
							'mask_field'					=>	'<button type="reset" id="#id" name="#name" data-action="wsf-reset"#attributes>#label</button>#help',
							'mask_field_attributes'			=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes'),
							'mask_field_label'				=>	'#label',
							'submit_save'					=>	false,
							'submit_edit'					=>	false,
							'value_out'						=>	false,
							'progress'						=>	false,
							'conditional'					=>	array(

								'logics_enabled'	=>	array('click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur'),
								'actions_enabled'	=>	array('visibility', 'focus', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'click',
							),
							'events'	=>	array(

								'event'						=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('hidden', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'			=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'				=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'clear' => array (

							'label'					=>	__('Clear', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'				=>	'/knowledgebase/clear/',
							'calc_in'				=>	true,
							'calc_out'				=>	false,
							'label_default'			=>	__('Clear', 'ws-form'),
							'label_position_force'	=>	'top',
							'mask_field'			=>	'<button type="button" id="#id" name="#name" data-action="wsf-clear"#attributes>#label</button>#help',
							'mask_field_attributes'	=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes'),
							'mask_field_label'		=>	'#label',
							'submit_save'			=>	false,
							'submit_edit'			=>	false,
							'value_out'				=>	false,
							'progress'				=>	false,
							'conditional'			=>	array(

								'logics_enabled'	=>	array('click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur'),
								'actions_enabled'	=>	array('visibility', 'focus', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'click',
							),
							'events'	=>	array(

								'event'				=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('hidden', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'			=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'tab_previous' => array (

							'label'						=>	__('Previous Tab', 'ws-form'),
							'pro_required'				=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'					=>	'/knowledgebase/tab_previous/',
							'icon'						=>	'previous',
							'calc_in'					=>	true,
							'calc_out'					=>	false,
							'label_default'				=>	__('Previous', 'ws-form'),
							'label_position_force'		=>	'top',
							'mask_field'				=>	'<button type="button" id="#id" name="#name" data-action="wsf-tab_previous"#attributes>#label</button>#help',
							'mask_field_attributes'		=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes'),
							'mask_field_label'			=>	'#label',
							'submit_save'				=>	false,
							'submit_edit'				=>	false,
							'value_out'					=>	false,
							'progress'					=>	false,
							'conditional'				=>	array(

								'logics_enabled'			=>	array('click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur'),
								'actions_enabled'			=>	array('visibility', 'focus', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'			=>	'click',
							),
							'events'	=>	array(

								'event'				=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('hidden', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'			=>	__('Scroll', 'ws-form'),
											'meta_keys'	=>	array('scroll_to_top', 'scroll_to_top_offset', 'scroll_to_top_duration')
										),

										array(
											'label'			=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'tab_next' => array (

							'label'					=>	__('Next Tab', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'				=>	'/knowledgebase/tab_next/',
							'icon'					=>	'next',
							'calc_in'				=>	true,
							'calc_out'				=>	false,
							'label_default'			=>	__('Next', 'ws-form'),
							'label_position_force'	=>	'top',
							'mask_field'			=>	'<button type="button" id="#id" name="#name" data-action="wsf-tab_next"#attributes>#label</button>#help',
							'mask_field_attributes'	=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes'),
							'mask_field_label'		=>	'#label',
							'submit_save'			=>	false,
							'submit_edit'			=>	false,
							'value_out'				=>	false,
							'progress'				=>	false,
							'conditional'			=>	array(

								'logics_enabled'	=>	array('click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur'),
								'actions_enabled'	=>	array('visibility', 'focus', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'click',
							),
							'events'	=>	array(

								'event'				=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('hidden', 'help'),

									'fieldsets'		=>	array(

										array(
											'label'			=>	__('Scroll', 'ws-form'),
											'meta_keys'	=>	array('scroll_to_top', 'scroll_to_top_offset', 'scroll_to_top_duration')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'				=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'button' => array (

							'label'						=>	__('Custom', 'ws-form'),
							'pro_required'				=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'					=>	'/knowledgebase/button/',
							'calc_in'					=>	true,
							'calc_out'					=>	false,
							'label_default'				=>	__('Button', 'ws-form'),
							'label_position_force'		=>	'top',
							'mask_field'				=>	'<button type="button" id="#id" name="#name"#attributes>#label</button>#help',
							'mask_field_attributes'		=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes'),
							'mask_field_label'			=>	'#label',
							'submit_save'				=>	false,
							'submit_edit'				=>	false,
							'value_out'					=>	false,
							'progress'					=>	false,
							'conditional'				=>	array(

								'logics_enabled'	=>	array('click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur'),
								'actions_enabled'	=>	array('visibility', 'focus', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'click',
							),
							'events'					=>	array(

								'event'				=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'				=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('hidden', 'help'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						)
					)
				),

				'section' => array(

					'label'	=> __('Repeatable Sections', 'ws-form'),
					'types' => array(

						'section_add' => array (

							'label'						=>	__('Add', 'ws-form'),
							'pro_required'				=>	!WS_Form_Common::is_edition('pro'),
							'icon'						=>	'plus',
							'kb_url'					=>	'/knowledgebase/section_add/',
							'calc_in'					=>	true,
							'calc_out'					=>	false,
							'label_default'				=>	__('Add', 'ws-form'),
							'label_position_force'		=>	'top',
							'mask_field'				=>	'<button type="button" id="#id" name="#name" data-action="wsf-section-add-button"#attributes>#label</button>#help',
							'mask_field_attributes'		=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'section_repeatable_section_id'),
							'mask_field_label'			=>	'#label',
							'submit_save'				=>	false,
							'submit_edit'				=>	false,
							'value_out'					=>	false,
							'progress'					=>	false,
							'conditional'				=>	array(

								'logics_enabled'	=>	array('click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur'),
								'actions_enabled'	=>	array('visibility', 'focus', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'click',
							),
							'events'					=>	array(

								'event'				=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'				=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('hidden', 'section_repeatable_section_id', 'help'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'section_delete' => array (

							'label'						=>	__('Remove', 'ws-form'),
							'pro_required'				=>	!WS_Form_Common::is_edition('pro'),
							'icon'						=>	'minus',
							'kb_url'					=>	'/knowledgebase/section_delete/',
							'calc_in'					=>	true,
							'calc_out'					=>	false,
							'label_default'				=>	__('Remove', 'ws-form'),
							'label_position_force'		=>	'top',
							'mask_field'				=>	'<button type="button" id="#id" name="#name" data-action="wsf-section-delete-button"#attributes>#label</button>#help',
							'mask_field_attributes'		=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'section_repeatable_section_id'),
							'mask_field_label'			=>	'#label',
							'submit_save'				=>	false,
							'submit_edit'				=>	false,
							'value_out'					=>	false,
							'progress'					=>	false,
							'conditional'				=>	array(

								'logics_enabled'	=>	array('click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur'),
								'actions_enabled'	=>	array('visibility', 'focus', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'click',
							),
							'events'					=>	array(

								'event'				=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'				=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('hidden', 'section_repeatable_section_id', 'help'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type_danger', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'section_up' => array (

							'label'						=>	__('Move Up', 'ws-form'),
							'pro_required'				=>	!WS_Form_Common::is_edition('pro'),
							'icon'						=>	'up',
							'kb_url'					=>	'/knowledgebase/section_move_up/',
							'calc_in'					=>	true,
							'calc_out'					=>	false,
							'label_default'				=>	__('Move Up', 'ws-form'),
							'label_position_force'		=>	'top',
							'mask_field'				=>	'<button type="button" id="#id" name="#name" data-action="wsf-section-move-up-button"#attributes>#label</button>#help',
							'mask_field_attributes'		=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes'),
							'mask_field_label'			=>	'#label',
							'submit_save'				=>	false,
							'submit_edit'				=>	false,
							'value_out'					=>	false,
							'progress'					=>	false,
							'conditional'				=>	array(

								'logics_enabled'	=>	array('click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur'),
								'actions_enabled'	=>	array('visibility', 'focus', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'click',
							),
							'events'					=>	array(

								'event'				=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'				=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('hidden', 'help'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),


						'section_down' => array (

							'label'						=>	__('Move Down', 'ws-form'),
							'pro_required'				=>	!WS_Form_Common::is_edition('pro'),
							'icon'						=>	'down',
							'kb_url'					=>	'/knowledgebase/section_move_down/',
							'calc_in'					=>	true,
							'calc_out'					=>	false,
							'label_default'				=>	__('Move Down', 'ws-form'),
							'label_position_force'		=>	'top',
							'mask_field'				=>	'<button type="button" id="#id" name="#name" data-action="wsf-section-move-down-button"#attributes>#label</button>#help',
							'mask_field_attributes'		=>	array('class', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes'),
							'mask_field_label'			=>	'#label',
							'submit_save'				=>	false,
							'submit_edit'				=>	false,
							'value_out'					=>	false,
							'progress'					=>	false,
							'conditional'				=>	array(

								'logics_enabled'	=>	array('click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur'),
								'actions_enabled'	=>	array('visibility', 'focus', 'blur', 'button_html', 'click', 'disabled', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'click',
							),
							'events'					=>	array(

								'event'				=>	'click',
								'event_category'	=>	__('Button', 'ws-form')
							),

							'fieldsets'				=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('hidden', 'help'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'class_field_button_type', 'class_field_full_button_remove')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('disabled', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),

						'section_icons' => array (

							'label'				=>	__('Icons', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'kb_url'			=>	'/knowledgebase/section_icons/',
							'icon'				=>	'section-icons',
							'calc_in'			=>	false,
							'calc_out'			=>	false,
							'label_default'		=>	__('Icons', 'ws-form'),
							'submit_save'		=>	false,
							'submit_edit'		=>	false,
							'value_out'			=>	false,
							'progress'			=>	false,
							'conditional'		=>	array(

								'exclude_condition'	=>	true,
								'actions_enabled'	=>	array('visibility', 'class_add_wrapper', 'class_remove_wrapper')
							),

							'mask_field'					=>	'<div data-section-icons#attributes></div>',
							'mask_field_attributes'			=>	array('class', 'section_repeatable_section_id'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('hidden', 'section_repeatable_section_id'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Icons', 'ws-form'),
											'meta_keys'	=>	array('section_icons')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('class_single_vertical_align_bottom', 'horizontal_align', 'section_icons_style', 'section_icons_size', 'section_icons_color_on', 'section_icons_color_off', 'section_icons_html_add', 'section_icons_html_delete', 'section_icons_html_move_up', 'section_icons_html_move_down', 'section_icons_html_drag', 'section_icons_html_reset', 'section_icons_html_clear')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=>	array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						),
					)
				),

				'ecommerce' => array(

					'label'	=> __('E-Commerce', 'ws-form'),
					'types' => array(

						'price' => array (

							'label'				=>	__('Price', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'icon'				=>	'text',
							'kb_url'			=>	'/knowledgebase/price/',
							'calc_in'			=>	true,
							'calc_out'			=>	true,
							'label_default'		=>	__('Price', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	false,
							'submit_edit_ecommerce'	=>	true,
							'value_out'			=>	true,
							'ecommerce_price'	=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('==', '!=', '<', '>', '<=', '>=', 'blank', 'blank_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'	=>	array('visibility', 'required', 'focus', 'blur', 'value_number', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change input'
							),
							'events'			=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'		=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'				=>	'<option value="#datalist_field_value">#datalist_field_text</option>',
							'mask_row_lookups'		=>	array('datalist_field_value', 'datalist_field_text'),
							'datagrid_column_value'	=>	'datalist_field_value',

							// Fields
							'mask_field'					=>	'<input type="text" id="#id" name="#name" value="#value" data-ecommerce-price#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'list', 'disabled', 'readonly', 'required', 'placeholder', 'aria_describedby', 'aria_labelledby', 'aria_label', 'ecommerce_price_negative', 'ecommerce_price_min', 'ecommerce_price_max', 'text_align_right', 'custom_attributes', 'ecommerce_calculation_persist', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required', 'hidden', 'text_align_right', 'default_value', 'ecommerce_price_negative', 'placeholder', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass', 'ecommerce_calculation_persist')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'readonly', 'ecommerce_price_min', 'ecommerce_price_max', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Datalist
								'datalist'	=> array(

									'label'			=>	__('Datalist', 'ws-form'),
									'meta_keys'		=> array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'price_select' => array (

							'label'				=>	__('Price Select', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'icon'				=>	'select',
							'kb_url'			=>	'/knowledgebase/price_select/',
							'calc_in'			=>	false,
							'calc_out'			=>	true,
							'label_default'		=>	__('Price Select', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_select_price'),
							'submit_save'		=>	true,
							'submit_edit'		=>	false,
							'submit_edit_ecommerce'	=>	true,
							'submit_array'		=>	true,
							'value_out'			=>	true,
							'ecommerce_price'	=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'data_grid_fields'			=>	'data_grid_select_price',
								'option_text'				=>	'select_price_field_label',
								'logics_enabled'			=>	array('selected', 'selected_not', 'selected_any', 'selected_any_not', 'rs==', 'rs!=', 'rs>', 'rs<', 'selected_value_equals', 'selected_value_equals', 'focus', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input'),
								'actions_enabled'			=>	array('visibility', 'required', 'focus', 'blur', 'value_row_select', 'value_row_deselect', 'value_row_disabled', 'value_row_not_disabled', 'value_row_class_add', 'value_row_class_remove', 'value', 'disabled', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'value_row_reset'),
								'condition_event'			=>	'change'
							),

							'events'	=>	array(

								'event'						=>	'change',
								'event_category'			=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'					=>	'<optgroup label="#group_label"#disabled>#group</optgroup>',
							'mask_group_label'				=>	'#group_label',

							// Rows
							'mask_row'						=>	'<option id="#row_id" data-id="#data_id" data-price="#row_price" value="#row_value"#attributes>#select_price_field_label</option>',
							'mask_row_value'				=>	'#select_price_field_value_html',
							'mask_row_price'				=>	'#select_price_field_price_html',
							'mask_row_placeholder'			=>	'<option data-id="0" value="" data-placeholder>#value</option>',
							'mask_row_attributes'			=>	array('default', 'disabled'),
							'mask_row_lookups'				=>	array('select_price_field_value', 'select_price_field_label', 'select_price_field_price', 'select_price_field_parse_variable', 'price_select_cascade_field_filter'),
							'datagrid_column_value'			=>	'select_price_field_value',
							'mask_row_default' 				=>	' selected',

							// Fields
							'mask_field'					=>	'<select id="#id" name="#name" data-ecommerce-price#attributes>#datalist</select>#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'size', 'multiple', 'required', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'dedupe_value_scope', 'price_select_cascade_ajax', 'ecommerce_calculation_persist', 'hidden_bypass', 'select2', 'select2_ajax'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=> array('label_render', 'required', 'hidden', 'multiple', 'size', 'placeholder_row', 'help'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Select2', 'ws-form'),
											'meta_keys'	=>	array('select2_intro', 'select2', 'select2_ajax')
										),

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass', 'ecommerce_calculation_persist')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'	=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'select_min', 'select_max', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe_value_scope')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Options
								'options'	=> array(

									'label'			=>	__('Options', 'ws-form'),
									'meta_keys'		=> array('data_grid_select_price', 'data_grid_rows_randomize'),
									'fieldsets' => array(

										array(
											'label'		=>	__('Column Mapping', 'ws-form'),
											'meta_keys'	=> array('select_price_field_label', 'select_price_field_value', 'select_price_field_price', 'select_price_field_parse_variable')
										),

										array(
											'label'		=>	__('Cascading', 'ws-form'),
											'meta_keys'	=> array('price_select_cascade', 'price_select_cascade_field_filter', 'price_select_cascade_field_id', 'price_select_cascade_option_text_no_rows', 'price_select_cascade_no_match', 'price_select_cascade_ajax', 'price_select_cascade_ajax_option_text_loading')
										)
									)
								)
							)
						),

						'price_checkbox' => array (

							'label'				=>	__('Price Checkbox', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'icon'				=>	'checkbox',
							'kb_url'			=>	'/knowledgebase/price_checkbox/',
							'calc_in'			=>	false,
							'calc_out'			=>	true,
							'label_default'		=>	__('Price Checkbox', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_checkbox_price'),
							'submit_save'		=>	true,
							'submit_edit'		=>	false,
							'submit_edit_ecommerce'	=>	true,
							'submit_array'		=>	true,
							'value_out'			=>	true,
							'ecommerce_price'	=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'data_grid_fields'		=>	'data_grid_checkbox_price',
								'option_text'			=>	'checkbox_price_field_label',
								'logics_enabled'		=>	array('checked', 'checked_not', 'checked_any', 'checked_any_not', 'rc==', 'rc!=', 'rc>', 'rc<', 'checked_value_equals', 'checked_value_equals', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input'),
								'actions_enabled'		=>	array('visibility', 'class_add_wrapper', 'class_remove_wrapper', 'value_row_check', 'value_row_uncheck', 'value_row_check_value','value_row_uncheck_value', 'value_row_focus', 'value_row_required', 'value_row_not_required', 'value_row_disabled', 'value_row_not_disabled', 'value_row_visible', 'value_row_not_visible', 'value_row_class_add', 'value_row_class_remove', 'value_row_set_custom_validity', 'reset', 'clear'),
								'condition_event'		=>	'change',
								'condition_event_row'	=>	true
							),

							'events'		=>	array(

								'event'					=>	'change',
								'event_category'		=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group_wrapper'		=>	'<div#attributes>#group</div>',
							'mask_group_label'			=>	'<legend>#group_label</legend>',

							// Rows
							'mask_row'					=>	'<div#attributes>#row_label</div>',
							'mask_row_attributes'		=>	array('class'),
							'mask_row_label'			=>	'<label id="#label_row_id" for="#row_id"#attributes>#row_field#checkbox_price_field_label#required</label>#invalid_feedback',
							'mask_row_label_attributes'	=>	array('class'),
							'mask_row_field'			=>	'<input type="checkbox" id="#row_id" name="#name" data-price="#row_price" value="#row_value" data-ecommerce-price#attributes />',
							'mask_row_value'			=>	'#checkbox_price_field_value_html',
							'mask_row_price'			=>	'#checkbox_price_field_price_html',
							'mask_row_field_attributes'	=>	array('class', 'default', 'disabled', 'required', 'aria_labelledby', 'dedupe_value_scope', 'ecommerce_calculation_persist', 'hidden_bypass'),
							'mask_row_lookups'			=>	array('checkbox_price_field_value', 'checkbox_price_field_label', 'checkbox_price_field_price', 'checkbox_price_field_parse_variable', 'price_checkbox_cascade_field_filter'),
							'datagrid_column_value'		=>	'checkbox_price_field_value',
							'mask_row_default' 			=>	' checked',

							// Fields
							'mask_field'				=>	'#datalist#invalid_feedback#help',
							'mask_field_label'				=>	'<label id="#label_id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),
//							'mask_field_label_hide_group'	=>	true,

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('label_render_off', 'hidden', 'select_all', 'select_all_label', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Layout', 'ws-form'),
											'meta_keys'	=>	array('orientation',
												'orientation_breakpoint_sizes'
											)
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass', 'ecommerce_calculation_persist')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'	=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('checkbox_min', 'checkbox_max', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe_value_scope')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Checkboxes
								'checkboxes' 	=> array(

									'label'			=>	__('Checkboxes', 'ws-form'),
									'meta_keys'		=> array('data_grid_checkbox_price', 'data_grid_rows_randomize'),
									'fieldsets' => array(

										array(
											'label'		=>	__('Column Mapping', 'ws-form'),
											'meta_keys'	=> array('checkbox_price_field_label', 'checkbox_price_field_value', 'checkbox_price_field_price', 'checkbox_price_field_parse_variable')
										),

										array(
											'label'		=>	__('Cascading', 'ws-form'),
											'meta_keys'	=> array('price_checkbox_cascade', 'price_checkbox_cascade_field_filter', 'price_checkbox_cascade_field_id', 'price_checkbox_cascade_no_match')
										)
									)
								)
							)
						),

						'price_radio' => array (

							'label'				=>	__('Price Radio', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'icon'				=>	'radio',
							'kb_url'			=>	'/knowledgebase/price_radio/',
							'calc_in'			=>	false,
							'calc_out'			=>	true,
							'label_default'		=>	__('Price Radio', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_radio_price'),
							'submit_save'		=>	true,
							'submit_edit'		=>	false,
							'submit_edit_ecommerce'	=>	true,
							'submit_array'		=>	true,
							'value_out'			=>	true,
							'ecommerce_price'	=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'data_grid_fields'			=>	'data_grid_radio_price',
								'option_text'				=>	'radio_price_field_label',
								'logics_enabled'			=>	array('checked', 'checked_not', 'checked_any', 'checked_any_not', 'checked_value_equals', 'checked_value_equals', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input'),
								'actions_enabled'			=>	array('visibility', 'required', 'class_add_wrapper', 'class_remove_wrapper', 'value_row_check', 'value_row_uncheck', 'value_row_check_value','value_row_uncheck_value', 'value_row_focus', 'value_row_disabled', 'value_row_not_disabled', 'value_row_visible', 'value_row_not_visible', 'value_row_class_add', 'value_row_class_remove', 'set_custom_validity', 'reset', 'clear'),
								'condition_event'			=>	'change',
								'condition_event_row'		=>	true
							),

							'events'	=>	array(

								'event'						=>	'change',
								'event_category'			=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'					=>	'<fieldset#disabled>#group_label#group</fieldset>',
							'mask_group_wrapper'			=>	'<div#attributes>#group</div>',
							'mask_group_label'				=>	'<legend>#group_label</legend>',

							// Rows
							'mask_row'						=>	'<div#attributes>#row_label</div>',
							'mask_row_attributes'			=>	array('class'),
							'mask_row_label'				=>	'<label id="#label_row_id" for="#row_id" data-label-required-id="#label_id"#attributes>#row_field#radio_price_field_label</label>#invalid_feedback',
							'mask_row_label_attributes'		=>	array('class'),
							'mask_row_field'				=>	'<input type="radio" id="#row_id" name="#name" data-price="#row_price" value="#row_value" data-ecommerce-price#attributes />',
							'mask_row_value'				=>	'#radio_price_field_value_html',
							'mask_row_price'				=>	'#radio_price_field_price_html',
							'mask_row_field_attributes'		=>	array('class', 'default', 'disabled', 'required_row', 'aria_labelledby', 'dedupe_value_scope', 'ecommerce_calculation_persist', 'hidden_bypass'),
							'mask_row_lookups'				=>	array('radio_price_field_value', 'radio_price_field_label', 'radio_price_field_price', 'radio_price_field_parse_variable', 'radio_price_cascade_field_filter', 'price_radio_cascade_field_filter'),
							'datagrid_column_value'			=>	'radio_price_field_value',
							'mask_row_default' 				=>	' checked',

							// Fields
							'mask_field'					=>	'#datalist#help',
							'mask_field_attributes'			=>	array('required_attribute_no'),
							'mask_field_label'				=>	'<label id="#label_id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),
//							'mask_field_label_hide_group'	=>	true,

							'invalid_feedback_last_row'		=> true,

							'fieldsets'						=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required_attribute_no', 'hidden', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Layout', 'ws-form'),
											'meta_keys'	=>	array('orientation',
												'orientation_breakpoint_sizes'
											)
										),

										array(
											'label'			=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass', 'ecommerce_calculation_persist')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'	=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'			=>	__('Classes', 'ws-form'),
											'meta_keys'		=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Duplication', 'ws-form'),
											'meta_keys'	=>	array('dedupe_value_scope')
										),

										array(
											'label'			=>	__('Validation', 'ws-form'),
											'meta_keys'		=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'			=>	__('Breakpoints', 'ws-form'),
											'meta_keys'		=> array('breakpoint_sizes'),
											'class'			=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Radios
								'radios'	=> array(

									'label'			=>	__('Radios', 'ws-form'),
									'meta_keys'		=> array('data_grid_radio_price', 'data_grid_rows_randomize'),
									'fieldsets' => array(

										array(
											'label'		=>	__('Column Mapping', 'ws-form'),
											'meta_keys'	=> array('radio_price_field_label', 'radio_price_field_value', 'radio_price_field_price', 'radio_price_field_parse_variable')
										),

										array(
											'label'		=>	__('Cascading', 'ws-form'),
											'meta_keys'	=> array('price_radio_cascade', 'price_radio_cascade_field_filter', 'price_radio_cascade_field_id', 'price_radio_cascade_no_match')
										)
									)
								)
							)
						),

						'price_range' => array (

							'label'				=>	__('Price Range', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'icon'				=>	'range',
							'kb_url'			=>	'/knowledgebase/price_range/',
							'calc_in'			=>	true,
							'calc_out'			=>	true,
							'label_default'		=>	__('Price Range', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	false,
							'submit_edit_ecommerce'	=>	true,
							'value_out'			=>	true,
							'ecommerce_price'	=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('==', '!=', '<', '>', '<=', '>=', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input'),
								'actions_enabled'	=>	array('visibility', 'focus', 'blur', 'value_range', 'disabled', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change input'
							),
							'compatibility_id'	=>	'input-range',
							'events'						=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),
							'trigger'			=> 'input',

							// Groups
							'mask_group'		=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'			=>	'<option value="#datalist_field_value" style="--position-tick-mark: #datalist_field_value_percentage%;" data-label="#datalist_field_text"></option>',
							'mask_row_lookups'	=>	array('datalist_field_value', 'datalist_field_text'),

							// Fields
							'mask_field'					=>	'<input type="range" id="#id" name="#name" value="#value" data-ecommerce-price#attributes />#datalist#invalid_feedback#help',
							'mask_field_submit'				=>	'<input type="text" id="#id" name="#name" value="#value" data-ecommerce-price#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'list', 'min', 'max', 'step', 'disabled', 'aria_describedby', 'aria_labelledby', 'aria_label', 'custom_attributes', 'class_fill_lower_track', 'ecommerce_calculation_persist', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('label_render', 'hidden', 'default_value_price_range', 'help_price_range'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass', 'ecommerce_calculation_persist')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'		=>	__('Advanced', 'ws-form'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align', 'class_fill_lower_track')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'min', 'max', 'step', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Tab: Tick Marks
								'tickmarks'	=> array(

									'label'		=>	__('Tick Marks', 'ws-form'),
									'meta_keys'	=>	array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'quantity' => array (

							'label'				=>	__('Quantity', 'ws-form'),
							'pro_required'		=>	!WS_Form_Common::is_edition('pro'),
							'icon'				=>	'quantity',
							'kb_url'			=>	'/knowledgebase/quantity/',
							'calc_in'			=>	true,
							'calc_out'			=>	true,
							'label_default'		=>	__('Quantity', 'ws-form'),
							'data_source'		=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'		=>	true,
							'submit_edit'		=>	false,
							'submit_edit_ecommerce'	=>	true,
							'value_out'			=>	true,
							'ecommerce_quantity'=>	true,
							'progress'			=>	true,
							'conditional'		=>	array(

								'logics_enabled'	=>	array('==', '!=', '<', '>', '<=', '>=', 'blank', 'blank_not', 'field_match', 'field_match_not', 'validate', 'validate_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change', 'input', 'change_input', 'keyup', 'keydown'),
								'actions_enabled'	=>	array('visibility', 'required', 'focus', 'blur', 'value_number', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field', 'reset', 'clear'),
								'condition_event'	=>	'change input'
							),
							'compatibility_id'	=>	'input-number',
							'events'			=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'					=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'				=> true,

							// Rows
							'mask_row'						=>	'<option value="#datalist_field_value">#datalist_field_text</option>',
							'mask_row_lookups'				=>	array('datalist_field_value', 'datalist_field_text'),
							'datagrid_column_value'			=>	'datalist_field_value',

							// Fields
							'mask_field'					=>	'<input type="number" id="#id" name="#name" value="#value" data-ecommerce-quantity#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'			=>	array('class', 'list', 'disabled', 'readonly', 'required', 'placeholder', 'aria_describedby', 'aria_labelledby', 'aria_label', 'ecommerce_quantity_min', 'max', 'ecommerce_field_id', 'text_align_center', 'custom_attributes', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required', 'hidden', 'text_align_center', 'ecommerce_field_id', 'ecommerce_quantity_default_value', 'placeholder', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'readonly', 'ecommerce_quantity_min', 'max', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Datalist
								'datalist'	=> array(

									'label'			=>	__('Datalist', 'ws-form'),
									'meta_keys'		=> array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'price_subtotal' => array (

							'label'						=>	__('Price Subtotal', 'ws-form'),
							'pro_required'				=>	!WS_Form_Common::is_edition('pro'),
							'icon'						=>	'calculator',
							'kb_url'					=>	'/knowledgebase/price_subtotal/',
							'calc_in'					=>	false,
							'calc_out'					=>	true,
							'label_default'				=>	__('Price Subtotal', 'ws-form'),
							'submit_save'				=>	true,
							'submit_edit'				=>	false,
							'submit_edit_ecommerce'	=>	true,
							'value_out'					=>	true,
							'ecommerce_price_subtotal'	=>	true,
							'progress'					=>	false,
							'conditional'				=>	array(

								'logics_enabled'	=>	array('==', '!=', '<', '>', '<=', '>=', 'field_match', 'field_match_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change'),
								'actions_enabled'	=>	array('visibility', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'change input'
							),
							'events'			=>	array(

								'event'				=>	'change',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Fields
							'mask_field'					=>	'<input type="text" id="#id" name="#name" data-ecommerce-price-subtotal readonly#attributes />',
							'mask_field_submit'				=>	'<input type="text" id="#id" name="#name" value="#value"data-ecommerce-price-subtotal #attributes />',
							'mask_field_attributes'			=>	array('class', 'aria_describedby', 'aria_labelledby', 'aria_label', 'ecommerce_field_id', 'text_align_right', 'custom_attributes', 'ecommerce_price_negative', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('label_render', 'hidden', 'text_align_right', 'ecommerce_field_id', 'ecommerce_price_negative'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)

									)
								)
							)
						),

						'cart_price' => array (

							'label'					=>	__('Cart Detail', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('pro'),
							'icon'					=>	'price',
							'kb_url'				=>	'/knowledgebase/cart_price/',
							'calc_in'				=>	true,
							'calc_out'				=>	true,
							'label_default'			=>	__('Cart Detail', 'ws-form'),
							'data_source'			=>	array('type' => 'data_grid', 'id' => 'data_grid_datalist'),
							'submit_save'			=>	true,
							'submit_edit'			=>	false,
							'submit_edit_ecommerce'	=>	true,
							'value_out'				=>	true,
							'ecommerce_cart_price'	=>	true,
							'progress'				=>	true,
							'conditional'			=>	array(

								'logics_enabled'	=>	array('==', '!=', '<', '>', '<=', '>=', 'blank', 'blank_not', 'field_match', 'field_match_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change'),
								'actions_enabled'	=>	array('visibility', 'required', 'focus', 'blur', 'value_number', 'disabled', 'readonly', 'set_custom_validity', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'change input'
							),
							'events'			=>	array(

								'event'				=>	'change input',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Groups
							'mask_group'		=>	"\n\n<datalist id=\"#group_id\">#group</datalist>",
							'mask_group_always'	=> true,

							// Rows
							'mask_row'				=>	'<option value="#datalist_field_value">#datalist_field_text</option>',
							'mask_row_lookups'		=>	array('datalist_field_value', 'datalist_field_text'),
							'datagrid_column_value'	=>	'datalist_field_value',

							// Fields
							'mask_field'									=>	'<input type="text" id="#id" name="#name" value="#value" data-ecommerce-cart-price#attributes />#datalist#invalid_feedback#help',
							'mask_field_attributes'				=>	array('class', 'list', 'disabled', 'readonly_on', 'required', 'placeholder', 'aria_describedby', 'aria_labelledby', 'aria_label', 'ecommerce_price_negative', 'ecommerce_price_min', 'ecommerce_price_max', 'ecommerce_cart_price_type', 'text_align_right', 'custom_attributes', 'ecommerce_calculation_persist', 'hidden_bypass'),
							'mask_field_label'						=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'		=>	__('Basic', 'ws-form'),
									'meta_keys'	=>	array('label_render', 'required', 'hidden', 'text_align_right', 'ecommerce_cart_price_type', 'default_value', 'ecommerce_price_negative', 'placeholder', 'help'),

									'fieldsets'	=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass', 'ecommerce_calculation_persist')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=> array('disabled', 'readonly_on', 'ecommerce_price_min', 'ecommerce_price_max', 'field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Validation', 'ws-form'),
											'meta_keys'	=>	array('invalid_feedback_render', 'invalid_feedback')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								),

								// Datalist
								'datalist'	=> array(

									'label'			=>	__('Datalist', 'ws-form'),
									'meta_keys'		=> array('data_grid_datalist'),
									'fieldsets' => array(

										array(
											'label' => __('Column Mapping', 'ws-form'),
											'meta_keys' => array('datalist_field_text', 'datalist_field_value')
										)
									)
								)
							)
						),

						'cart_total' => array (

							'label'					=>	__('Cart Total', 'ws-form'),
							'pro_required'			=>	!WS_Form_Common::is_edition('pro'),
							'icon'					=>	'calculator',
							'kb_url'				=>	'/knowledgebase/cart_total/',
							'calc_in'				=>	false,
							'calc_out'				=>	true,
							'label_default'			=>	__('Cart Total', 'ws-form'),
							'submit_save'			=>	true,
							'submit_edit'			=>	false,
							'submit_edit_ecommerce'	=>	true,
							'value_out'				=>	true,
							'ecommerce_cart_total'	=>	true,
							'progress'				=>	false,
							'conditional'			=>	array(

								'logics_enabled'	=>	array('==', '!=', '<', '>', '<=', '>=', 'field_match', 'field_match_not', 'click', 'mousedown', 'mouseup', 'mouseover', 'mouseout', 'touchstart', 'touchend', 'touchmove', 'touchcancel', 'focus', 'blur', 'change'),
								'actions_enabled'	=>	array('visibility', 'class_add_wrapper', 'class_remove_wrapper', 'class_add_field', 'class_remove_field'),
								'condition_event'	=>	'change input'
							),
							'events'			=>	array(

								'event'				=>	'change',
								'event_category'	=>	__('Field', 'ws-form')
							),

							// Fields
							'mask_field'					=>	'<input type="text" id="#id" name="#name" data-ecommerce-cart-total readonly#attributes />',
							'mask_field_submit'				=>	'<input type="text" id="#id" name="#name" value="#value" data-ecommerce-cart-total#attributes />',
							'mask_field_attributes'			=>	array('class', 'aria_describedby', 'aria_labelledby', 'aria_label', 'text_align_right', 'custom_attributes', 'ecommerce_price_negative', 'hidden_bypass'),
							'mask_field_label'				=>	'<label id="#label_id" for="#id"#attributes>#label</label>',
							'mask_field_label_attributes'	=>	array('class'),

							'fieldsets'	=> array(

								// Tab: Basic
								'basic'	=> array(

									'label'			=>	__('Basic', 'ws-form'),
									'meta_keys'		=>	array('label_render', 'hidden', 'text_align_right', 'ecommerce_price_negative'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Prefix / Suffix', 'ws-form'),
											'meta_keys'	=>	array('prepend', 'append')
										),

										array(
											'label'		=>	__('Accessibility', 'ws-form'),
											'meta_keys'	=>	array('aria_label')
										),

										array(
											'label'		=>	__('Exclusions', 'ws-form'),
											'meta_keys'	=>	array('exclude_email')
										),

										array(
											'label'		=>	__('Hidden Behavior', 'ws-form'),
											'meta_keys'	=>	array('hidden_bypass')
										)
									)
								),

								// Tab: Advanced
								'advanced'	=>	array(

									'label'			=>	__('Advanced', 'ws-form'),

									'fieldsets'		=>	array(

										array(
											'label'		=>	__('Style', 'ws-form'),
											'meta_keys'	=>	array('label_position', 'label_column_width', 'class_single_vertical_align')
										),

										array(
											'label'		=>	__('Classes', 'ws-form'),
											'meta_keys'	=> array('class_field_wrapper', 'class_field')
										),

										array(
											'label'		=>	__('Restrictions', 'ws-form'),
											'meta_keys'	=>	array('field_user_status', 'field_user_roles', 'field_user_capabilities')
										),

										array(
											'label'		=>	__('Custom Attributes', 'ws-form'),
											'meta_keys'	=>	array('custom_attributes')
										),

										array(
											'label'		=>	__('Breakpoints', 'ws-form'),
											'meta_keys'	=> array('breakpoint_sizes'),
											'class'		=>	array('wsf-fieldset-panel')
										)
									)
								)
							)
						)
					)
				)
			);

			// Apply filter
			$field_types = apply_filters('wsf_config_field_types', $field_types);

			// Add icons and compatibility links
			if(!$public) {

				foreach($field_types as $group_key => $group) {

					$types = $group['types'];

					foreach($types as $field_key => $field_type) {

						// Set icons (If not already an SVG)
						$field_icon = isset($field_type['icon']) ? $field_type['icon'] : $field_key;
						if(strpos($field_icon, '<svg') === false) {

							$field_types[$group_key]['types'][$field_key]['icon'] = self::get_icon_16_svg($field_icon);
						}

						// Set compatibility
						if(isset($field_type['compatibility_id'])) {

							$field_types[$group_key]['types'][$field_key]['compatibility_url'] = str_replace('#compatibility_id', $field_type['compatibility_id'], WS_FORM_COMPATIBILITY_MASK);
							unset($field_types[$group_key]['types'][$field_key]['compatibility_id']);
						}
					}
				}
			}

			// Cache
			self::$field_types[$public] = $field_types;

			return $field_types;
		}

		// Configuration - Field types (Single dimension array)
		public static function get_field_types_flat($public = true) {

			$field_types = array();
			$field_types_config = self::get_field_types($public);

			foreach($field_types_config as $group) {

				$types = $group['types'];

				foreach($types as $key => $field_type) {

					$field_types[$key] = $field_type;
				}
			}

			return $field_types;
		}

		// Configuration - Customize
		public static function get_customize() {

			$customize	=	array(

				'colors'	=>	array(

					'heading'	=>	__('Colors', 'ws-form'),
					'fields'	=>	array(

						'skin_color_default'	=> array(

							'label'			=>	__('Default', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#000000',
							'description'	=>	__('Labels and field values.', 'ws-form')
						),

						'skin_color_default_inverted'	=> array(

							'label'			=>	__('Inverted', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#FFFFFF',
							'description'	=>	__('Field backgrounds and button text.', 'ws-form')
						),

						'skin_color_default_light'	=> array(

							'label'			=>	__('Light', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#8E8E93',
							'description'	=>	__('Placeholders, help text, and disabled field values.', 'ws-form')
						),

						'skin_color_default_lighter'	=> array(

							'label'			=>	__('Lighter', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#CECED2',
							'description'	=>	__('Field borders and buttons.', 'ws-form')
						),

						'skin_color_default_lightest'	=> array(

							'label'			=>	__('Lightest', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#EFEFF4',
							'description'	=>	__('Range slider backgrounds, progress bar backgrounds, and disabled field backgrounds.', 'ws-form')
						),

						'skin_color_primary'	=> array(

							'label'			=>	__('Primary', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#205493',
							'description'	=>	__('Checkboxes, radios, range sliders, progress bars, and submit buttons.')
						),

						'skin_color_secondary'	=> array(

							'label'			=>	__('Secondary', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#5b616b',
							'description'	=>	__('Secondary elements such as a reset button.', 'ws-form')
						),

						'skin_color_success'	=> array(

							'label'			=>	__('Success', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#2e8540',
							'description'	=>	__('Completed progress bars, save buttons, and success messages.')
						),

						'skin_color_information'	=> array(

							'label'			=>	__('Information', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#02bfe7',
							'description'	=>	__('Information messages.', 'ws-form')
						),

						'skin_color_warning'	=> array(

							'label'			=>	__('Warning', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#fdb81e',
							'description'	=>	__('Warning messages.', 'ws-form')
						),

						'skin_color_danger'	=> array(

							'label'			=>	__('Danger', 'ws-form'),
							'type'			=>	'color',
							'default'		=>	'#981b1e',
							'description'	=>	__('Required field labels, invalid field borders, invalid feedback text, remove repeatable section buttons, and danger messages.')
						)
					)
				),

				'typography'	=>	array(

					'heading'		=>	__('Typography', 'ws-form'),
					'fields'		=>	array(

						'skin_font_family'	=> array(

							'label'			=>	__('Font Family', 'ws-form'),
							'type'			=>	'text',
							'default'		=>	'inherit',
							'description'	=>	__('Font family used throughout the form.', 'ws-form')
						),

						'skin_font_size'	=> array(

							'label'			=>	__('Font Size', 'ws-form'),
							'type'			=>	'number',
							'default'		=>	14,
							'description'	=>	__('Regular font size used on the form.', 'ws-form')
						),

						'skin_font_size_large'	=> array(

							'label'			=>	__('Font Size Large', 'ws-form'),
							'type'			=>	'number',
							'default'		=>	25,
							'description'	=>	__('Font size used for section labels and fieldset legends.', 'ws-form')
						),

						'skin_font_size_small'	=> array(

							'label'			=>	__('Font Size Small', 'ws-form'),
							'type'			=>	'number',
							'default'		=>	12,
							'description'	=>	__('Font size used for help text and invalid feedback text.', 'ws-form')
						),

						'skin_font_weight'	=>	array(

							'label'			=>	__('Font Weight', 'ws-form'),
							'type'			=>	'select',
							'default'		=>	'inherit',
							'choices'		=>	array(

								'inherit'	=>	__('Inherit', 'ws-form'),
								'normal'	=>	__('Normal', 'ws-form'),
								'bold'		=>	__('Bold', 'ws-form'),
								'100'		=>	__('100', 'ws-form'),
								'200'		=>	__('200', 'ws-form'),
								'300'		=>	__('300', 'ws-form'),
								'400'		=>	__('400 (Normal)', 'ws-form'),
								'500'		=>	__('500', 'ws-form'),
								'600'		=>	__('600', 'ws-form'),
								'700'		=>	__('700 (Bold)', 'ws-form'),
								'800'		=>	__('800', 'ws-form'),
								'900'		=>	__('900', 'ws-form')
							),
							'description'	=>	__('Font weight used throughout the form.', 'ws-form')
						),


						'skin_line_height'	=> array(

							'label'			=>	__('Line Height', 'ws-form'),
							'type'			=>	'number',
							'default'		=>	1.4,
							'description'	=>	__('Line height used throughout form.', 'ws-form')
						)
					)
				),

				'borders'	=>	array(

					'heading'		=>	__('Borders', 'ws-form'),
					'fields'		=>	array(

						'skin_border'	=>	array(

							'label'			=>	__('Enabled', 'ws-form'),
							'type'			=>	'checkbox',
							'default'		=>	true,
							'description'	=>	__('When checked, borders will be shown.', 'ws-form')
							),

						'skin_border_width'	=> array(

							'label'			=>	__('Width', 'ws-form'),
							'type'			=>	'number',
							'default'		=>	1,
							'description'	=>	__('Specify the width of borders used through the form. For example, borders around form fields.', 'ws-form')
						),

						'skin_border_style'	=>	array(

							'label'			=>	__('Style', 'ws-form'),
							'type'			=>	'select',
							'default'		=>	'solid',
							'choices'		=>	array(

								'dashed'	=>	__('Dashed', 'ws-form'),
								'dotted'	=>	__('Dotted', 'ws-form'),
								'double'	=>	__('Double', 'ws-form'),
								'groove'	=>	__('Groove', 'ws-form'),
								'inset'		=>	__('Inset', 'ws-form'),
								'outset'	=>	__('Outset', 'ws-form'),
								'ridge'		=>	__('Ridge', 'ws-form'),
								'solid'		=>	__('Solid', 'ws-form')
							),
							'description'	=>	__('Border style used throughout the form.', 'ws-form')
						),

						'skin_border_radius'	=> array(

							'label'			=>	__('Radius', 'ws-form'),
							'type'			=>	'number',
							'default'		=>	4,
							'description'	=>	__('Border radius used throughout the form.', 'ws-form')
						)
					)
				),

				'transitions'	=>	array(

					'heading'	=>	__('Transitions', 'ws-form'),
					'fields'	=>	array(

						'skin_transition'	=>	array(

							'label'			=>	__('Enabled', 'ws-form'),
							'type'			=>	'checkbox',
							'default'		=>	true,
							'description'	=>	__('When checked, transitions will be used on the form.', 'ws-form')
						),

						'skin_transition_speed'	=> array(

							'label'			=>	__('Speed', 'ws-form'),
							'type'			=>	'number',
							'default'		=>	200,
							'help'			=>	__('Value in milliseconds.', 'ws-form'),
							'description'	=>	__('Transition speed in milliseconds.', 'ws-form')
						),

						'skin_transition_timing_function'	=>	array(

							'label'			=>	__('Timing Function', 'ws-form'),
							'type'			=>	'select',
							'default'		=>	'ease-in-out',
							'choices'		=>	array(

								'ease'			=>	__('Ease', 'ws-form'),
								'ease-in'		=>	__('Ease In', 'ws-form'),
								'ease-in-out'	=>	__('Ease In Out', 'ws-form'),
								'ease-out'		=>	__('Ease Out', 'ws-form'),
								'linear'		=>	__('Linear', 'ws-form'),
								'step-end'		=>	__('Step End', 'ws-form'),
								'step-start'	=>	__('Step Start', 'ws-form')
							),
							'description'	=>	__('Speed curve of the transition effect.', 'ws-form')
						)
					)
				),

				'advanced'	=>	array(

					'heading'	=>	__('Advanced', 'ws-form'),
					'fields'	=>	array(

						'skin_grid_gutter'	=> array(

							'label'			=>	__('Grid Gutter', 'ws-form'),
							'type'			=>	'number',
							'default'		=>	20,
							'description'	=>	__('Sets the distance between form elements.', 'ws-form')
						)
					)
				)
			);

			// Apply filter
			$customize = apply_filters('wsf_config_customize', $customize);

			return $customize;
		}

		// Configuration - Options
		public static function get_options() {

			$options_v_1_0_0 = array(

				// Basic
				'basic'		=> array(

					'label'		=>	__('Basic', 'ws-form'),
					'groups'	=>	array(

						'preview'	=>	array(

							'heading'		=>	__('Preview', 'ws-form'),
							'fields'	=>	array(

								'helper_live_preview'	=>	array(

									'label'		=>	__('Live Preview', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Update the form preview window automatically.', 'ws-form'),
									'default'	=>	true
								),

								'preview_template'	=> array(

									'label'				=>	__('Template', 'ws-form'),
									'type'				=>	'select',
									'help'				=>	__('Page template used for previewing forms.', 'ws-form'),
									'options'			=>	array(),	// Populated below
									'default'			=>	''
								),
								'helper_debug'	=> array(

									'label'		=>	__('Debug Console', 'ws-form'),
									'type'		=>	'select',
									'help'		=>	__('Choose when to show the debug console.', 'ws-form'),
									'default'	=>	'',
									'options'	=>	array(

										'off'				=>	array('text' => __('Off', 'ws-form')),
										'administrator'		=>	array('text' => __('Administrators only', 'ws-form')),
										'on'				=>	array('text' => __('Show always'), 'ws-form')
									),
									'mode'	=>	array(

										'basic'		=>	'off',
										'advanced'	=>	'administrator'
									)
								)
							)
						),

						'layout_editor'	=>	array(

							'heading'	=>	__('Layout Editor', 'ws-form'),
							'fields'	=>	array(

								'mode'	=> array(

									'label'		=>	__('Mode', 'ws-form'),
									'type'		=>	'select',
									'help'		=>	__('Advanced mode allows variables and calculations to be used in field settings.', 'ws-form'),
									'default'	=>	'basic',
									'options'	=>	array(

										'basic'		=>	array('text' => __('Basic', 'ws-form')),
										'advanced'	=>	array('text' => __('Advanced', 'ws-form'))
									)
								),

								'helper_columns'	=>	array(

									'label'		=>	__('Column Guidelines', 'ws-form'),
									'type'		=>	'select',
									'help'		=>	__('Show column guidelines when editing forms?', 'ws-form'),
									'options'	=>	array(

										'off'		=>	array('text' => __('Off', 'ws-form')),
										'resize'	=>	array('text' => __('On resize', 'ws-form')),
										'on'		=>	array('text' => __('Always on', 'ws-form')),
									),
									'default'	=>	'resize'
								),
								'helper_breakpoint_width'	=>	array(

									'label'		=>	__('Breakpoint Widths', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Resize the width of the form to the selected breakpoint.', 'ws-form'),
									'default'	=>	true
								),
								'helper_compatibility' => array(

									'label'		=>	__('HTML Compatibility Helpers', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Show HTML compatibility helper links (Data from', 'ws-form') . ' <a href="' . WS_FORM_COMPATIBILITY_URL . '" target="_blank">' . WS_FORM_COMPATIBILITY_NAME . '</a>).',
									'default'	=>	false,
									'mode'		=>	array(

										'basic'		=>	false,
										'advanced'	=>	true
									)
								),

								'helper_field_help' => array(

									'label'		=>	__('Help Text', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Show help text in sidebar.'),
									'default'	=>	true
								),

								'helper_section_id'	=> array(

									'label'		=>	__('Section IDs', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Show IDs on sections?', 'ws-form'),
									'default'	=>	true,
									'mode'		=>	array(

										'basic'		=>	false,
										'advanced'	=>	true
									)
								),

								'helper_field_id'	=> array(

									'label'		=>	__('Field IDs', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Show IDs on fields? Useful for #field(nnn) variables.', 'ws-form'),
									'default'	=>	true
								)
							)
						),

						'admin'	=>	array(

							'heading'	=>	__('Administration', 'ws-form'),
							'fields'	=>	array(

								'disable_form_stats'			=>	array(

									'label'		=>	__('Disable Statistics', 'ws-form'),
									'type'		=>	'checkbox',
									'default'	=>	false,
									'help'		=>	__('If checked, WS Form will stop gathering statistical data about forms.', 'ws-form'),
								),

								'disable_count_submit_unread'	=>	array(

									'label'		=>	__('Disable Unread Submission Bubbles', 'ws-form'),
									'type'		=>	'checkbox',
									'default'	=>	false
								),

								'disable_toolbar_menu'			=>	array(

									'label'		=>	__('Disable Toolbar Menu', 'ws-form'),
									'type'		=>	'checkbox',
									'default'	=>	false,
									'help'		=>	__('If checked, the WS Form toolbar menu will not be shown.', 'ws-form'),
								)
							)
						)
					)
				),

				// Advanced
				'advanced'	=> array(

					'label'		=>	__('Advanced', 'ws-form'),
					'groups'	=>	array(

						'markup'	=>	array(

							'heading'		=>	__('Markup', 'ws-form'),
							'fields'	=>	array(

								'framework'	=> array(

									'label'				=>	__('Framework', 'ws-form'),
									'type'				=>	'select',
									'help'				=>	__('Framework used for rendering the front-end HTML.', 'ws-form'),
									'options'			=>	array(),	// Populated below
									'default'			=>	WS_FORM_DEFAULT_FRAMEWORK,
									'button'			=>	'wsf-framework-detect',
									'public'			=>	true,
									'data_change'		=>	'reload' 				// Reload settings on change
								),

								'framework_column_count'	=> array(

									'label'		=>	__('Column Count', 'ws-form'),
									'type'		=>	'select_number',
									'default'	=>	12,
									'minimum'	=>	1,
									'maximum'	=>	24,
									'public'	=>	true,
									'absint'	=>	true,
									'help'		=>	__('We recommend leaving this setting at 12.', 'ws-form')
								),

								'comments_html'	=>	array(

									'label'		=>	__('HTML Comments', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Should WS Form HTML include comments?', 'ws-form'),
									'default'	=>	false,
									'public'	=>	true
								),

								'comments_css'	=>	array(

									'label'		=>	__('CSS Comments', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Should WS Form CSS include comments?', 'ws-form'),
									'default'	=>	false,
									'public'	=>	true,
									'condition'	=>	array('framework' => 'ws-form')
								),

								'css_layout'	=>	array(

									'label'		=>	__('Framework CSS', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Should the WS Form framework CSS be rendered?', 'ws-form'),
									'default'	=>	true,
									'public'	=>	true,
									'condition'	=>	array('framework' => 'ws-form')
								),

								'css_skin'	=>	array(

									'label'		=>	__('Skin CSS', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	sprintf(__('Should the WS Form skin CSS be rendered? <a href="%s">Click here</a> to customize the WS Form skin.', 'ws-form'), admin_url('customize.php?return=%2Fwp-admin%2Fadmin.php%3Fpage%3Dws-form-settings%26tab%3Dappearance')),
									'default'	=>	true,
									'public'	=>	true,
									'condition'	=>	array('framework' => 'ws-form')
								),
							)
						),

						'performance'	=>	array(

							'heading'		=>	__('Performance', 'ws-form'),
							'condition'	=>	array('framework' => 'ws-form'),
							'fields'	=>	array(

								'css_minify'	=>	array(

									'label'		=>	__('Minify CSS', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Should the WS Form CSS be minified to improve page speed?', 'ws-form'),
									'default'	=>	'',
									'condition'	=>	array('framework' => 'ws-form')
								),

								'css_inline'	=>	array(

									'label'		=>	__('Inline CSS', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('Should the WS Form CSS be rendered inline to improve page speed?', 'ws-form'),
									'default'	=>	'',
									'condition'	=>	array('framework' => 'ws-form')
								),

								'css_cache_duration'	=>	array(

									'label'		=>	__('CSS Cache Duration', 'ws-form'),
									'type'		=>	'number',
									'help'		=>	__('Expires header duration in seconds for WS Form CSS.', 'ws-form'),
									'default'	=>	31536000,
									'public'	=>	true,
									'condition'	=>	array('framework' => 'ws-form')
								)
							)
						),

						'javascript'	=>	array(

							'heading'	=>	__('Javascript', 'ws-form'),
							'fields'	=>	array(

								'jquery_footer'	=>	array(

									'label'		=>	__('Enqueue in Footer', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('If checked, scripts will be enqueued in the footer.', 'ws-form'),
									'default'	=>	''
								),

								'jquery_source'	=>	array(

									'label'		=>	__('jQuery Source', 'ws-form'),
									'type'		=>	'select',
									'help'		=>	__('Where should external libraries load from? Use \'Local\' if you are using optimization plugins.', 'ws-form'),
									'default'	=>	'local',
									'public'	=>	true,
									'options'	=>	array(

										'local'		=>	array('text' => __('Local', 'ws-form')),
										'cdn'		=>	array('text' => __('CDN', 'ws-form'))
									)
								),

								'ui_datepicker'	=>	array(

									'label'		=>	__('jQuery Date/Time Picker', 'ws-form'),
									'type'		=>	'select',
									'help'		=>	__('When should date fields use a jQuery Date/Time Picker component?', 'ws-form'),
									'default'	=>	'on',
									'public'	=>	true,
									'options'	=>	array(

										'on'		=>	array('text' => __('Always', 'ws-form')),
										'native'	=>	array('text' => __('If native not available', 'ws-form')),
										'off'		=>	array('text' => __('Never', 'ws-form'))
									)
								),

								'ui_color'	=>	array(

									'label'		=>	__('jQuery Color Picker', 'ws-form'),
									'type'		=>	'select',
									'help'		=>	__('When should color fields use a jQuery Color picker component?', 'ws-form'),
									'default'	=>	'on',
									'public'	=>	true,
									'options'	=>	array(

										'native'	=>	array('text' => __('If native not available', 'ws-form')),
										'on'		=>	array('text' => __('Always', 'ws-form')),
										'off'		=>	array('text' => __('Never', 'ws-form'))
									)
								),
							)
						),
						'upload'	=>	array(

							'heading'	=>	__('File Uploads', 'ws-form'),
							'fields'	=>	array(

								'max_upload_size'	=>	array(

									'label'		=>	__('Maximum Filesize (Bytes)', 'ws-form'),
									'type'		=>	'number',
									'default'	=>	'#max_upload_size',
									'minimum'	=>	0,
									'maximum'	=>	'#max_upload_size',
									'button'	=>	'wsf-max-upload-size'
								),

								'max_uploads'	=>	array(

									'label'		=>	__('Maximum Files', 'ws-form'),
									'type'		=>	'number',
									'default'	=>	'#max_uploads',
									'minimum'	=>	0,
									'maximum'	=>	'#max_uploads',
									'button'	=>	'wsf-max-uploads'
								)
							)
						),
						'cookie'	=>	array(

							'heading'	=>	__('Cookies', 'ws-form'),
							'fields'	=>	array(

								'cookie_timeout'	=>	array(

									'label'		=>	__('Cookie Timeout (Seconds)', 'ws-form'),
									'type'		=>	'number',
									'help'		=>	__('Duration in seconds cookies are valid for.', 'ws-form'),
									'default'	=>	60 * 60 * 24 * 28,	// 28 day
									'public'	=>	true
								),

								'cookie_prefix'	=>	array(

									'label'		=>	__('Cookie Prefix', 'ws-form'),
									'type'		=>	'text',
									'help'		=>	__('We recommend leaving this value as it is.', 'ws-form'),
									'default'	=>	WS_FORM_IDENTIFIER,
									'public'	=>	true
								)
							)
						),

						'lookup'	=>	array(

							'heading'	=>	__('Tracking Lookups', 'ws-form'),
							'fields'	=>	array(

								'ip_lookup_url_mask' => array(

									'label'		=>	__('IP Lookup URL Mask', 'ws-form'),
									'type'		=>	'text',
									'default'	=>	'https://whatismyipaddress.com/ip/#value',
									'help'		=>	__('#value will be replaced with the tracking IP address.', 'ws-form')
								),

								'latlon_lookup_url_mask' => array(

									'label'		=>	__('Geolocation Lookup URL Mask', 'ws-form'),
									'type'		=>	'text',
									'default'	=>	'https://www.google.com/search?q=#value',
									'help'		=>	__('#value will be replaced with latitude,longitude.', 'ws-form')
								)
							)
						)
					)
				),

				// E-Commerce
				'ecommerce'	=> array(

					'label'		=>	__('E-Commerce', 'ws-form'),
					'groups'	=>	array(

						'price'	=>	array(

							'heading'	=>	__('Prices', 'ws-form'),
							'fields'	=>	array(

								'currency'	=> array(

									'label'		=>	__('Currency', 'ws-form'),
									'type'		=>	'select',
									'default'	=>	WS_Form_Common::get_currency_default(),
									'options'	=>	array(),
									'public'	=>	true
								),

								'currency_position'	=> array(

									'label'		=>	__('Currency Position', 'ws-form'),
									'type'		=>	'select',
									'default'	=>	'left',
									'options'	=>	array(
										'left'			=>	array('text' => __('Left', 'ws-form')),
										'right'			=>	array('text' => __('Right', 'ws-form')),
										'left_space'	=>	array('text' => __('Left with space', 'ws-form')),
										'right_space'	=>	array('text' => __('Right with space', 'ws-form'))
									),
									'public'	=>	true
								),

								'price_thousand_separator'	=> array(

									'label'		=>	__('Thousand Separator', 'ws-form'),
									'type'		=>	'text',
									'default'	=>	',',
									'public'	=>	true
								),

								'price_decimal_separator'	=> array(

									'label'		=>	__('Decimal Separator', 'ws-form'),
									'type'		=>	'text',
									'default'	=>	'.',
									'public'	=>	true
								),

								'price_decimals'	=> array(

									'label'		=>	__('Number Of Decimals', 'ws-form'),
									'type'		=>	'number',
									'default'	=>	'2',
									'public'	=>	true
								)
							)
						),

						'submission'	=>	array(

							'heading'	=>	__('Submissions', 'ws-form'),
							'fields'	=>	array(

								'submit_edit_ecommerce'	=>	array(

									'label'		=>	__('Allow Price Field Edits', 'ws-form'),
									'type'		=>	'checkbox',
									'help'		=>	__('If checked, prices can be edited in submissions. Note that changes to prices will not recalculate values in the rest of the submission.', 'ws-form'),
									'default'	=>	''
								)
							)
						)
					)
				),
				// System
				'system'	=> array(

					'label'		=>	__('System', 'ws-form'),
					'fields'	=>	array(

						'system' => array(

							'label'		=>	__('System Report', 'ws-form'),
							'type'		=>	'static'
						),

						'setup'	=> array(

							'type'		=>	'hidden',
							'default'	=>	false
						)
					)
				),
				// License
				'license'	=> array(

					'label'		=>	__('License', 'ws-form'),
					'fields'	=>	array(

						'version'	=>	array(

							'label'		=>	__('Version', 'ws-form'),
							'type'		=>	'static'						),

						'license_key'	=>	array(

							'label'		=>	__('License Key', 'ws-form'),
							'type'		=>	'text',
							'help'		=>	sprintf(__('Enter your %1$s license key here. If you have an All Access key, please enter the %1$s key instead.', 'ws-form'), WS_FORM_NAME_PRESENTABLE),
							'button'	=>	'wsf-license'
						),

						'license_status'	=>	array(

							'label'		=>	__('License Status', 'ws-form'),
							'type'		=>	'static'
						)
					)
				),
				// Data
				'data'	=> array(

					'label'		=>	__('Data', 'ws-form'),
					'groups'	=>	array(

						'form'	=>	array(

							'heading'	=>	__('Forms', 'ws-form'),
							'fields'	=>	array(

								'form_stat_reset' => array(

									'label'		=>	__('Reset Statistics', 'ws-form'),
									'type'		=>	'select',
									'save'		=>	false,
									'button'	=>	'wsf-form-stat-reset'
								)
							)
						),

						'encryption'	=>	array(

							'heading'	=>	__('Encryption', 'ws-form'),
							'fields'	=>	array(

								'encryption_enabled' => array(

									'label'		=>	__('Enable Data Encryption', 'ws-form'),
									'type'		=>	'checkbox',
									'default'	=>	false
								),

								'encryption_status' => array(

									'label'		=>	__('Encryption Status', 'ws-form'),
									'type'		=>	'static'
								)
							)
						),
						'uninstall'	=>	array(

							'heading'	=>	__('Uninstall', 'ws-form'),
							'fields'	=>	array(

								'uninstall_options' => array(

									'label'		=>	__('Delete Plugin Settings on Uninstall', 'ws-form'),
									'type'		=>	'checkbox',
									'default'	=>	false,
									'help'		=>	__('<p><strong style="color: #ff0000;">Caution:</strong> If you enable this setting and uninstall the plugin this data cannot be recovered.')
								),

								'uninstall_database' => array(

									'label'		=>	__('Delete Database Tables on Uninstall', 'ws-form'),
									'type'		=>	'checkbox',
									'default'	=>	false,
									'help'		=>	__('<p><strong style="color: #ff0000;">Caution:</strong> If you enable this setting and uninstall the plugin this data cannot be recovered.')
								)
							)
						)
					)
				)
			);
			$options = $options_v_1_0_0;

			// Frameworks
			$frameworks = self::get_frameworks(false);
			foreach($frameworks['types'] as $key => $framework) {

				$name = $framework['name'];
				$options['advanced']['groups']['markup']['fields']['framework']['options'][$key] = array('text' => $name);
			}

			// Templates
			$options['basic']['groups']['preview']['fields']['preview_template']['options'][''] = array('text' => __('Automatic', 'ws-form'));

			// Custom page templates
			$page_templates = array();
			$templates_path = get_template_directory();
			$templates = wp_get_theme()->get_page_templates();
			$templates['page.php'] = 'Page';
			$templates['singular.php'] = 'Singular';
			$templates['index.php'] = 'Index';
			$templates['front-page.php'] = 'Front Page';
			$templates['single-post.php'] = 'Single Post';
			$templates['single.php'] = 'Single';
			$templates['home.php'] = 'Home';

			foreach($templates as $template_file => $template_title) {

				// Build template path
				$template_file_full = $templates_path . '/' . $template_file;

				// Skip files that don't exist
				if(!file_exists($template_file_full)) { continue; }

				$page_templates[$template_file] = $template_title . ' (' . $template_file . ')';
			}

			asort($page_templates);

			foreach($page_templates as $template_file => $template_title) {

				$options['basic']['groups']['preview']['fields']['preview_template']['options'][$template_file] = array('text' => $template_title);
			}

			// Fallback
			$options['basic']['groups']['preview']['fields']['preview_template']['options']['fallback'] = array('text' => __('Blank Page', 'ws-form'));

			// Currencies
			$currencies = self::get_currencies();
			foreach($currencies as $code => $currency) {

				$options['ecommerce']['groups']['price']['fields']['currency']['options'][$code] = array('text' => $currency['n'] . ' (' . $currency['s'] . ')');
			}

			// Forms
			$options['data']['groups']['form']['fields']['form_stat_reset']['options'][''] = array('text' => __('Select...', 'ws-form'));

			$ws_form_form = New WS_Form_Form();
			$forms = $ws_form_form->db_read_all('', "NOT (status = 'trash')", 'label ASC', '', '', false);

			if($forms) {

				foreach($forms as $form) {

					if($form['count_stat_view'] > 0) {

						$options['data']['groups']['form']['fields']['form_stat_reset']['options'][$form['id']] = array('text' => esc_html(sprintf(__('%s (ID: %u)', 'ws-form'), $form['label'], $form['id'])));
					}
				}
			}

			// Apply filter
			$options = apply_filters('wsf_config_options', $options);

			return $options;
		}

		// Configuration - Settings (Shared with admin and public)
		public static function get_settings_form($public = true) {

			// Check if debug is enabled
			$debug = WS_Form_Common::debug_enabled();
			$settings_form = array(

				// Language
				'language'	=> array(

					// Errors
					'error_attributes'					=>	__('No attributes specified.', 'ws-form'),
					'error_attributes_obj'				=>	__('No attributes object specified.', 'ws-form'),
					'error_attributes_form_id'			=>	__('No attributes form ID specified.', 'ws-form'),
					'error_form_id'						=>	__('Form ID not specified.', 'ws-form'),
					'error_pro_required'				=>	__('WS Form PRO required.', 'ws-form'),

					// Errors - API calls
					'error_api_call_400'				=>	__('400 Bad request response from server (%s).', 'ws-form'),
					'error_api_call_401'				=>	sprintf(__('401 Unauthorized response from server. <a href="%s" target="_blank">Click here</a>.', 'ws-form'), WS_Form_Common::get_plugin_website_url('/knowledgebase/401-unauthorized/', 'api_call')),
					'error_api_call_403'				=>	sprintf(__('403 Forbidden response from server. <a href="%s" target="_blank">Click here</a>.', 'ws-form'), WS_Form_Common::get_plugin_website_url('/knowledgebase/403-forbidden/', 'api_call')),
					'error_api_call_404'				=>	__('404 Not found response from server (%s).', 'ws-form'),
					'error_api_call_500'				=>	__('500 Server error response from server (%s).', 'ws-form'),

					// Error message
					'dismiss'							=>  __('Dismiss', 'ws-form'),

					// Comments
					'comment_group_tabs'				=>	__('Tabs', 'ws-form'),
					'comment_groups'					=>	__('Tabs Content', 'ws-form'),
					'comment_group'						=>	__('Tab', 'ws-form'),
					'comment_sections'					=>	__('Sections', 'ws-form'),
					'comment_section'					=>	__('Section', 'ws-form'),
					'comment_fields'					=>	__('Fields', 'ws-form'),
					'comment_field'						=>	__('Field', 'ws-form'),

					// Word and character counts
					'character_singular'				=>	__('character', 'ws-form'),
					'character_plural'					=>	__('characters', 'ws-form'),
					'word_singular'						=>	__('word', 'ws-form'),
					'word_plural'						=>	__('words', 'ws-form'),

					// Select all
					'select_all_label'					=>	__('Select All', 'ws-form'),
					// Password strength
					'password_strength_unknown'			=> __( 'Password strength unknown', 'ws-form'),
					'password_strength_short'			=> __( 'Very weak', 'ws-form'),
					'password_strength_bad'				=> __( 'Weak', 'ws-form'),
					'password_strength_good'			=> __( 'Medium', 'ws-form'),
					'password_strength_strong'			=> __( 'Strong', 'ws-form'),
					'password_strength_mismatch'		=> __( 'Mismatch', 'ws-form' ),

					// Section icons
					'section_icon_add'					=>  __('Add', 'ws-form'),
					'section_icon_delete'				=>  __('Remove', 'ws-form'),
					'section_icon_move-up'				=>  __('Move Up', 'ws-form'),
					'section_icon_move-down'			=>  __('Move Down', 'ws-form'),
					'section_icon_drag'					=>  __('Drag', 'ws-form'),
					'section_icon_reset'				=>  __('Reset', 'ws-form'),
					'section_icon_clear'				=>  __('Clear', 'ws-form'),

					// Parse variables
					'error_parse_variable_syntax_error_brackets'			=>	__('Syntax error, missing brackets: %s'),
					'error_parse_variable_syntax_error_bracket_closing'		=>	__('Syntax error, missing closing bracket: %s'),
					'error_parse_variable_syntax_error_attribute'			=>	__('Syntax error, missing attribute: %s'),
					'error_parse_variable_syntax_error_attribute_invalid'	=>	__('Syntax error, invalid attribute: %s'),
					'error_parse_variable_syntax_error_depth'				=>	__('Syntax error, too many iterations'),
					'error_parse_variable_syntax_error_field_id'			=>	__('Syntax error, invalid field ID: %s'),
					'error_parse_variable_syntax_error_section_id'			=>	__('Syntax error, invalid section ID: %s'),
					'error_parse_variable_syntax_error_calc_loop'			=>	__('Syntax error, calculated fields cannot contain references to themselves: %s'),
					'error_parse_variable_syntax_error_calc_in'				=>	__('Syntax error, calculated fields cannot be added to this field: %s'),
					'error_parse_variable_syntax_error_calc_out'			=>	__('Syntax error, calculated fields cannot be retrieved from this field: %s'),

					// Cascading
					'cascade_option_text_loading'		=>	__('Loading...', 'ws-form'),
					'cascade_option_text_no_rows'		=>	__('Select...', 'ws-form')
				)
			);

			// Conditional
			if(!$public || $debug) {

				// Additional language strings for admin or public debug feature
				$language_extra = array(

					'error_conditional_if'				=>	__('Condition [if] not found', 'ws-form'),
					'error_conditional_then'			=>	__('Condition [then] not found', 'ws-form'),
					'error_conditional_else'			=>	__('Condition [else] not found', 'ws-form'),
					'error_conditional_settings'		=>	__('Conditional settings not found', 'ws-form'),
					'error_conditional_data_grid'		=>	__('Condition field data not found', 'ws-form'),
					'error_conditional_object'			=>	__('Condition object not found', 'ws-form'),
					'error_conditional_object_id'		=>	__('Condition object ID not found', 'ws-form'),
					'error_conditional_logic'			=>	__('Condition logic not found: %s', 'ws-form'),
					'error_conditional_logic_previous'	=>	__('Condition logic previous not found: %s', 'ws-form'),
					'error_conditional_logic_previous_group'	=>	__('Group logic previous not found', 'ws-form'),
				);

				// Add to language array
				foreach($language_extra as $key => $value) {

					$settings_form['language'][$key] = $value;
				}
			}
			// Apply filter
			$settings_form = apply_filters('wsf_config_settings_form', $settings_form);

			return $settings_form;
		}

		// Get plug-in settings
		public static function get_settings_plugin($public = true) {

			// Check cache
			if(isset(self::$settings_plugin[$public])) { return self::$settings_plugin[$public]; }

			$settings_plugin = [];

			// Plugin options
			$options = self::get_options();

			// Set up options with default values
			foreach($options as $tab => $data) {

				if(isset($data['fields'])) {

					self::get_settings_plugin_process($data['fields'], $public, $settings_plugin);
				}

				if(isset($data['groups'])) {

					$groups = $data['groups'];

					foreach($groups as $group) {

						self::get_settings_plugin_process($group['fields'], $public, $settings_plugin);
					}
				}
			}

			// Apply filter
			$settings_plugin = apply_filters('wsf_config_settings_plugin', $settings_plugin);

			// Cache
			self::$settings_plugin[$public] = $settings_plugin;

			return $settings_plugin;
		}

		// Get plug-in settings process
		public static function get_settings_plugin_process($fields, $public, &$settings_plugin) {

			foreach($fields as $field => $attributes) {

				// Skip field if public only?
				$field_skip = false;
				if($public) {

					$field_skip = !isset($attributes['public']) || !$attributes['public'];
				}
				if($field_skip) { continue; }

				// Get default value (if available)
				if(isset($attributes['default'])) { $default_value = $attributes['default']; } else { $default_value = ''; }

				// Get option value
				$settings_plugin[$field] = WS_Form_Common::option_get($field, $default_value);
			}
		}

		// Configuration - Meta Keys
		public static function get_meta_keys($form_id = 0, $public = false) {

			// Check cache
			if(isset(self::$meta_keys[$public])) { return self::$meta_keys[$public]; }

			$label_position = array(

				array('value' => 'top', 'text' => __('Top', 'ws-form')),
				array('value' => 'right', 'text' => __('Right', 'ws-form')),
				array('value' => 'bottom', 'text' => __('Bottom', 'ws-form')),
				array('value' => 'left', 'text' => __('Left', 'ws-form'))
			);

			$button_types = array(

				array('value' => '', 			'text' => __('Default', 'ws-form')),
				array('value' => 'primary', 	'text' => __('Primary', 'ws-form')),
				array('value' => 'secondary', 	'text' => __('Secondary', 'ws-form')),
				array('value' => 'success', 	'text' => __('Success', 'ws-form')),
				array('value' => 'information', 'text' => __('Information', 'ws-form')),
				array('value' => 'warning', 	'text' => __('Warning', 'ws-form')),
				array('value' => 'danger', 		'text' => __('Danger', 'ws-form'))
			);

			$message_types = array(

				array('value' => 'success', 	'text' => __('Success', 'ws-form')),
				array('value' => 'information', 'text' => __('Information', 'ws-form')),
				array('value' => 'warning', 	'text' => __('Warning', 'ws-form')),
				array('value' => 'danger', 		'text' => __('Danger', 'ws-form'))
			);

			$vertical_align = array(

				array('value' => '', 'text' => __('Top', 'ws-form')),
				array('value' => 'middle', 'text' => __('Middle', 'ws-form')),
				array('value' => 'bottom', 'text' => __('Bottom', 'ws-form'))
			);

			$meta_keys = array(

				// Forms

				// Should tabs be remembered?
				'cookie_tab_index'		=>	array(

					'label'		=>	__('Remember Last Tab Clicked', 'ws-form'),
					'type'		=>	'checkbox',
					'help'		=>	__('Should the last tab clicked be remembered?', 'ws-form'),
					'default'	=>	true
				),

				'tab_validation'		=>	array(

					'label'		=>	__('Tab Validation', 'ws-form'),
					'type'		=>	'checkbox',
					'help'		=>	__('Prevent the user from advancing to the next tab until the current tab is validated.', 'ws-form'),
					'default'	=>	false
				),

				// Add HTML to required labels
				'label_required'		=>	array(

					'label'			=>	__("Show 'Required' HTML", 'ws-form'),
					'type'			=>	'checkbox',
					'default'		=>	true,
					'help'			=>	__("Should '*' be added to labels if a field is required?", 'ws-form')
				),

				// Add HTML to required labels
				'label_mask_required'	=>	array(

					'label'			=>	__("Custom 'Required' HTML", 'ws-form'),
					'type'			=>	'text',
					'default'		=>	'',
					'help'			=>	__('Example: &apos; &lt;small&gt;Required&lt;/small&gt;&apos;.', 'ws-form'),
					'select_list'				=>	array(

						array('text' => __('&lt;small&gt;Required&lt;/small&gt;', 'ws-form'), 'value' => ' <small>Required</small>')
					),
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'label_required',
							'meta_value'	=>	'on'
						)
					)
				),

				// Hidden
				'hidden'		=>	array(

					'label'						=>	__('Hidden', 'ws-form'),
					'mask'						=>	'data-hidden',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'data_change'				=>	array('event' => 'change', 'action' => 'update')
				),

				'hidden_section'				=> array(

					'label'						=>	__('Hidden', 'ws-form'),
					'mask'						=>	'data-hidden',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'data_change'				=>	array('event' => 'change', 'action' => 'update')
				),

				// Fields
				// Recaptcha
				'recaptcha'		=> array(

					'label'						=>	__('reCAPTCHA', 'ws-form'),
					'type'						=>	'recaptcha',
					'dummy'						=>	true
				),

				// Breakpoint sizes grid
				'breakpoint_sizes'		=> array(

					'label'						=>	__('Breakpoint Sizes', 'ws-form'),
					'type'						=>	'breakpoint_sizes',
					'dummy'						=>	true,
					'condition'					=>	array(

						array(

							'logic'			=>	'!=',
							'meta_key'		=>	'recaptcha_recaptcha_type',
							'meta_value'	=>	'invisible'
						)
					)
				),

				// Spam Protection - Honeypot
				'honeypot'		=> array(

					'label'						=>	__('Enabled', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Adds a hidden field to fool spammers.', 'ws-form'),
				),

				// Spam Protection - Threshold
				'spam_threshold'	=> array(

					'label'						=>	__('Spam Threshold', 'ws-form'),
					'type'						=>	'range',
					'default'					=>	50,
					'min'						=>	0,
					'max'						=>	100,
					'help'						=>	__('If your form is configured to check for spam (e.g. Human Presence, Akismet or reCAPTCHA), each submission will be given a score between 0 (Not spam) and 100 (Blatant spam). Use this setting to determine the minimum score that will move a submission into the spam folder.', 'ws-form'),
				),

				// Duplicate Protection - Lock submit
				'submit_lock'		=> array(

					'label'						=>	__('Lock Save &amp; Submit Buttons', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'on',
					'help'						=>	__('Lock save and submit buttons when form is saved or submitted so that they cannot be double clicked.', 'ws-form')
				),

				// Duplicate Protection - Lock submit
				'submit_unlock'		=> array(

					'label'						=>	__('Unlock Save &amp; Submit Buttons', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'on',
					'help'						=>	__('Unlock save and submit buttons after form is saved or submitted.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'submit_lock',
							'meta_value'		=>	'on'
						)
					)
				),

				// Legal - Source
				'legal_source'		=> array(

					'label'						=>	__('Source', 'ws-form'),
					'type'						=>	'select',
					'mask'						=>	'data-wsf-legal-source="#value"',
					'mask_disregard_on_empty'	=>	true,
					'default'					=>	'termageddon',
					'options'					=>	array(

						array('value' => 'termageddon', 'text' => __('Termageddon', 'ws-form')),
						array('value' => '', 'text' => __('Own Copy', 'ws-form'))
					)
				),

				// Legal - Termageddon - Key
				'legal_termageddon_intro'		=> array(

					'type'						=>	'html',
					'html'						=>	sprintf('<a href="https://app.termageddon.com?fp_ref=westguard" target="_blank"><img src="%s/includes/third-party/termageddon/images/logo.gif" width="150" height="22" alt="Termageddon" title="Termageddon" /></a><div class="wsf-helper">%s</div>', WS_FORM_PLUGIN_DIR_URL, __('Termageddon is a third party service that generates policies for U.S. websites and apps and updates them whenever the laws change. WS Form has no control over and accepts no liability in respect of this service and content.', 'ws-form')),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'legal_source',
							'meta_value'		=>	'termageddon'
						)
					)
				),

				// Legal - Termageddon - Key
				'legal_termageddon_key'		=> array(

					'label'						=>	__('Key', 'ws-form'),
					'type'						=>	'text',
					'mask'						=>	'data-wsf-termageddon-key="#value"',
					'mask_disregard_on_empty'	=>	true,
					'default'					=>	'',
					'help'						=>	__('Need a key? <a href="https://app.termageddon.com?fp_ref=westguard" target="_blank">Register</a>'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'legal_source',
							'meta_value'		=>	'termageddon'
						)
					)
				),

				// Legal - Termageddon - Hide title
				'legal_termageddon_hide_title'		=> array(

					'label'						=>	__('Hide Title', 'ws-form'),
					'type'						=>	'checkbox',
					'mask'						=>	'data-wsf-termageddon-extra="no-title=true"',
					'mask_disregard_on_empty'	=>	true,
					'default'					=>	'',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'legal_source',
							'meta_value'		=>	'termageddon'
						)
					)
				),

				// Legal - Own copy
				'legal_text_editor'		=> array(

					'label'						=>	__('Legal Copy', 'ws-form'),
					'type'						=>	'text_editor',
					'default'					=>	'',
					'help'						=>	__('Enter the legal copy you would like to display.', 'ws-form'),
					'select_list'				=>	true,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'legal_source',
							'meta_value'		=>	''
						)
					),
					'key'						=>	'text_editor'
				),

				// Legal - Style - Height
				'legal_style_height'	=> array(

					'label'						=>	__('Height (pixels)', 'ws-form'),
					'type'						=>	'number',
					'mask'						=>	'style="height:#valuepx;overflow-y:scroll;"',
					'mask_disregard_on_empty'	=>	true,
					'default'					=>	'200',
					'help'						=>	__('Setting this to blank will remove the height restriction.', 'ws-form')
				),

				// Analytics - Google
				'analytics_google'		=> array(

					'label'						=>	__('Google Analytics Event Tracking', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	''
				),

				// Analytics - Google - Field events
				'analytics_google_event_field'		=> array(

					'label'						=>	__('Fire Field Events', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'on',
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'analytics_google',
							'meta_value'	=>	'on'
						)
					),
					'indent'					=>	true
				),

				// Analytics - Google - Tab events
				'analytics_google_event_tab'		=> array(

					'label'						=>	__('Fire Tab Events', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'on',
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'analytics_google',
							'meta_value'	=>	'on'
						)
					),
					'indent'					=>	true
				),

				// Tracking - Remote IP address
				'tracking_remote_ip'		=> array(

					'label'						=>	__('Remote IP Address', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Users remote IP address.', 'ws-form')
				),

				// Tracking - Geo Location
				'tracking_geo_location'		=> array(

					'label'						=>	__('Geographical Location (Browser)', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Latitude & longitude (User may be prompted to grant you permissions to this information).', 'ws-form')
				),

				// Tracking - Referrer
				'tracking_referrer'		=> array(

					'label'						=>	__('Referrer', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Referring page.', 'ws-form')
				),

				// Tracking - OS
				'tracking_os'		=> array(

					'label'						=>	__('Operating System', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Users operating system.', 'ws-form')
				),

				// Tracking - Agent
				'tracking_agent'		=> array(

					'label'						=>	__('Agent', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Users web browser type.', 'ws-form')
				),

				// Tracking - Hostname
				'tracking_host'			=> array(

					'label'						=>	__('Hostname', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Server hostname.', 'ws-form')
				),

				// Tracking - Pathname
				'tracking_pathname'	=> array(

					'label'						=>	__('Pathname', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Pathname of the URL.', 'ws-form')
				),

				// Tracking - Query String
				'tracking_query_string'	=> array(

					'label'						=>	__('Query String', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Query string of the URL.', 'ws-form')
				),

				// Tracking - UTM - Campaign source
				'tracking_utm_source'	=> array(

					'label'						=>	__('UTM Source', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Campaign source (e.g. website name).', 'ws-form')
				),

				// Tracking - UTM - Campaign medium
				'tracking_utm_medium'	=> array(

					'label'						=>	__('UTM Medium', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Campaign medium (e.g. email).', 'ws-form')
				),

				// Tracking - UTM - Campaign name
				'tracking_utm_campaign'	=> array(

					'label'						=>	__('UTM Campaign', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Campaign name.', 'ws-form')
				),

				// Tracking - UTM - Campaign term
				'tracking_utm_term'	=> array(

					'label'						=>	__('UTM Term', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Campaign term (e.g. keyword).', 'ws-form')
				),

				// Tracking - UTM - Campaign content
				'tracking_utm_content'	=> array(

					'label'						=>	__('UTM Content', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Campaign content (e.g. text link).', 'ws-form')
				),

				// Tracking - IP Lookup - City
				'tracking_ip_lookup_city'	=> array(

					'label'						=>	__('City (By IP)', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Attempt to get city from users IP address.', 'ws-form')
				),

				// Tracking - IP Lookup - Region
				'tracking_ip_lookup_region'	=> array(

					'label'						=>	__('Region (By IP)', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Attempt to get region from users IP address.', 'ws-form')
				),

				// Tracking - IP Lookup - Country
				'tracking_ip_lookup_country'	=> array(

					'label'						=>	__('Country (By IP)', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Attempt to get country from users IP address.', 'ws-form')
				),

				// Tracking - IP Lookup - Country
				'tracking_ip_lookup_latlon'	=> array(

					'label'						=>	__('Geographical Location (By IP)', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Attempt to get latitude and longitude from users IP address.', 'ws-form')
				),
				// Focus on invalid fields
				'invalid_field_focus'		=> array(

					'label'						=>	__('Focus Invalid Fields', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'on',
					'help'						=>	__('On form submit, should the first invalid field be focussed on?', 'ws-form')
				),
				// Submission limit
				'submit_limit'		=> array(

					'label'						=>	__('Limit By Submission Count', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Limit number of submissions for this form.', 'ws-form')
				),

				'submit_limit_count'		=> array(

					'label'						=>	__('Maximum Count', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	'',
					'min'						=>	1,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'submit_limit',
							'meta_value'		=>	'on'
						)
					)
				),

				'submit_limit_period'		=> array(

					'label'						=>	__('Duration', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	array(

						array('value' => '', 'text' => __('All Time', 'ws-form')),
						array('value' => 'hour', 'text' => __('Per Hour', 'ws-form')),
						array('value' => 'day', 'text' => __('Per Day', 'ws-form')),
						array('value' => 'week', 'text' => __('Per Week', 'ws-form')),
						array('value' => 'month', 'text' => __('Per Month', 'ws-form')),
						array('value' => 'year', 'text' => __('Per Year', 'ws-form'))
					),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'submit_limit',
							'meta_value'		=>	'on'
						)
					)
				),

				'submit_limit_message'			=> array(

					'label'						=>	__('Limit Reached Message', 'ws-form'),
					'type'						=>	'text_editor',
					'default'					=>	'',
					'help'						=>	__('Enter the message you would like to show if the submisson limit is reached. Leave blank to hide form.', 'ws-form'),
					'select_list'				=>	true,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'submit_limit',
							'meta_value'		=>	'on'
						)
					)
				),

				'submit_limit_message_type'		=> array(

					'label'						=>	__('Message Style', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	array(

						array('value' => '', 'text' => __('None', 'ws-form')),
						array('value' => 'success', 'text' => __('Success', 'ws-form')),
						array('value' => 'information', 'text' => __('Information', 'ws-form')),
						array('value' => 'warning', 'text' => __('Warning', 'ws-form')),
						array('value' => 'danger', 'text' => __('Danger', 'ws-form'))
					),
					'default'					=>	'information',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'submit_limit',
							'meta_value'		=>	'on'
						)
					)
				),

				// Form scheduling
				'schedule_start'			=> array(

					'label'						=>	__('Schedule Start', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Schedule a start date/time for the form.', 'ws-form')
				),

				'schedule_start_datetime'	=> array(

					'label'						=>	__('Start Date/Time', 'ws-form'),
					'type'						=>	'datetime',
					'default'					=>	'',
					'help'						=>	__('Date/time form is scheduled to start.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'schedule_start',
							'meta_value'		=>	'on'
						)
					)
				),

				'schedule_start_message'		=> array(

					'label'						=>	__('Before Message', 'ws-form'),
					'type'						=>	'text_editor',
					'default'					=>	'',
					'help'						=>	__('Message shown before the form start date/time. Leave blank to hide form.', 'ws-form'),
					'select_list'				=>	true,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'schedule_start',
							'meta_value'		=>	'on'
						)
					)
				),

				'schedule_start_message_type'	=> array(

					'label'						=>	__('Before Message Style', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	array(

						array('value' => '', 'text' => __('None', 'ws-form')),
						array('value' => 'success', 'text' => __('Success', 'ws-form')),
						array('value' => 'information', 'text' => __('Information', 'ws-form')),
						array('value' => 'warning', 'text' => __('Warning', 'ws-form')),
						array('value' => 'danger', 'text' => __('Danger', 'ws-form'))
					),
					'default'					=>	'information',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'schedule_start',
							'meta_value'		=>	'on'
						)
					)
				),

				'schedule_end'					=> array(

					'label'						=>	__('Schedule End', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Schedule an end date/time for the form.', 'ws-form')
				),

				'schedule_end_datetime'			=> array(

					'label'						=>	__('End Date/Time', 'ws-form'),
					'type'						=>	'datetime',
					'default'					=>	'',
					'help'						=>	__('Date/time form is scheduled to end.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'schedule_end',
							'meta_value'		=>	'on'
						)
					)
				),

				'schedule_end_message'	=> array(

					'label'						=>	__('After Message', 'ws-form'),
					'type'						=>	'text_editor',
					'default'					=>	'',
					'help'						=>	__('Message shown after the form end date/time. Leave blank to hide form.', 'ws-form'),
					'select_list'				=>	true,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'schedule_end',
							'meta_value'		=>	'on'
						)
					)
				),

				'schedule_end_message_type'		=> array(

					'label'						=>	__('After Message Style', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	array(

						array('value' => '', 'text' => __('None', 'ws-form')),
						array('value' => 'success', 'text' => __('Success', 'ws-form')),
						array('value' => 'information', 'text' => __('Information', 'ws-form')),
						array('value' => 'warning', 'text' => __('Warning', 'ws-form')),
						array('value' => 'danger', 'text' => __('Danger', 'ws-form'))
					),
					'default'					=>	'information',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'schedule_end',
							'meta_value'		=>	'on'
						)
					)
				),

				// User limits
				'user_limit_logged_in'	=> array(

					'label'						=>	__('User Status', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	array(

						array('value' => '', 'text' => __('Any', 'ws-form')),
						array('value' => 'on', 'text' => __('Is Logged In', 'ws-form')),
						array('value' => 'out', 'text' => __('Is Logged Out', 'ws-form')),
						array('value' => 'role_capability', 'text' => __('Has User Role or Capability', 'ws-form'))
					),
					'help'						=>	__('Only show the form under certain user conditions.', 'ws-form')
				),

				'user_limit_logged_in_message'	=> array(

					'label'						=>	__('Message', 'ws-form'),
					'type'						=>	'text_editor',
					'default'					=>	'',
					'help'						=>	__('Message shown if the user does not meet the user status condition. Leave blank to hide form.', 'ws-form'),
					'select_list'				=>	true,
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'user_limit_logged_in',
							'meta_value'		=>	''
						)
					)
				),

				'user_limit_logged_in_message_type'		=> array(

					'label'						=>	__('Type', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	array(

						array('value' => '', 'text' => __('None', 'ws-form')),
						array('value' => 'success', 'text' => __('Success', 'ws-form')),
						array('value' => 'information', 'text' => __('Information', 'ws-form')),
						array('value' => 'warning', 'text' => __('Warning', 'ws-form')),
						array('value' => 'danger', 'text' => __('Danger', 'ws-form'))
					),
					'default'					=>	'danger',
					'help'						=>	__('Style of message to use', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'user_limit_logged_in',
							'meta_value'		=>	''
						)
					)
				),
				// Submit on enter
				'submit_on_enter'	=> array(

					'label'						=>	__('Enable Form Submit On Enter', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Allow the form to be submitted if someone types Enter/Return. Not advised for e-commerce forms.', 'ws-form')
				),

				// Reload on submit
				'submit_reload'		=> array(

					'label'						=>	__('Reset Form After Submit', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'on',
					'help'						=>	__('Should the form be reset to its default state after it is submitted?', 'ws-form')
				),

				// Form action
				'form_action'		=> array(

					'label'						=>	__('Custom Form Action', 'ws-form'),
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Enter a custom action for this form. Leave blank to use WS Form (Recommended).', 'ws-form')
				),

				// Show errors on submit
				'submit_show_errors'			=> array(

					'label'						=>	__('Show Error Messages', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'on',
					'help'						=>	__('If a server side error occurs when a form is submitted, should WS Form show those as form error messages?', 'ws-form')
				),

				// Render label checkbox (On by default)
				'label_render'					=> array(

					'label'						=>	__('Show Label', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'on'
				),

				// Render label checkbox (Off by default)
				'label_render_off'				=> array(

					'label'						=>	__('Show Label', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'key'						=>	'label_render'
				),

				// Label position (Form)
				'label_position_form'			=> array(

					'label'						=>	__('Default Label Position', 'ws-form'),
					'type'						=>	'select',
					'help'						=>	__('Select the default position of field labels.', 'ws-form'),
					'options'					=>	$label_position,
					'options_framework_filter'	=>	'label_positions',
					'default'					=>	'top'
				),

				// Label position
				'label_position'		=> array(

					'label'						=>	__('Label Position', 'ws-form'),
					'type'						=>	'select',
					'help'						=>	__('Select the position of the field label.', 'ws-form'),
					'options'					=>	$label_position,
					'options_default'			=>	'label_position_form',
					'options_framework_filter'	=>	'label_positions',
					'default'					=>	'default',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'label_render',
							'meta_value'		=>	'on'
						)
					)
				),

				// Label column width
				'label_column_width_form'				=> array(

					'label'						=>	__('Default Label Width (Columns)', 'ws-form'),
					'type'						=>	'select_number',
					'default'					=>	3,
					'minimum'					=>	1,
					'maximum'					=>	'framework_column_count',
					'help'						=>	__('Column width of labels if positioned left or right.', 'ws-form')
				),

				// Label column width
				'label_column_width'				=> array(

					'label'						=>	__('Label Width (Columns)', 'ws-form'),
					'type'						=>	'select_number',
					'options_default'			=>	'label_column_width_form',
					'default'					=>	'default',
					'minimum'					=>	1,
					'maximum'					=>	'framework_column_count',
					'help'						=>	__('Column width of label.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'label_position',
							'meta_value'		=>	'left'
						),

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'label_position',
							'meta_value'		=>	'right',
							'logic_previous'	=>	'||'
						)
					)
				),

				// reCAPTCHA - Site key
				'recaptcha_site_key'	=> array(

					'label'						=>	__('Site Key', 'ws-form'),
					'mask'						=>	'data-site-key="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	sprintf(__('reCAPTCHA site key. <a href="%s" target="_blank">Learn more</a>.', 'ws-form'), WS_Form_Common::get_plugin_website_url('/knowledgebase/recaptcha/')),
					'required_setting'			=>	true,
					'data_change'				=>	array('event' => 'change', 'action' => 'update')
				),

				// reCAPTCHA - Secret key
				'recaptcha_secret_key'	=> array(

					'label'						=>	__('Secret Key', 'ws-form'),
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	sprintf(__('reCAPTCHA secret key.  <a href="%s" target="_blank">Learn more</a>.', 'ws-form'), WS_Form_Common::get_plugin_website_url('/knowledgebase/recaptcha/')),
					'required_setting'			=>	true,
					'data_change'				=>	array('event' => 'change', 'action' => 'update')
				),

				// reCAPTCHA - reCAPTCHA type
				'recaptcha_recaptcha_type'		=> array(

					'label'						=>	__('reCAPTCHA Type', 'ws-form'),
					'mask'						=>	'data-recaptcha-type="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Select the reCAPTCHA version your site key relates to.', 'ws-form'),
					'options'					=>	array(

						array('value' => 'v2_default', 'text' => __('Version 2 - Default', 'ws-form')),
						array('value' => 'v2_invisible', 'text' => __('Version 2 - Invisible', 'ws-form')),
						array('value' => 'v3_default', 'text' => __('Version 3', 'ws-form')),
					),
					'default'					=>	'v2_default'
				),

				// reCAPTCHA - Badge
				'recaptcha_badge'		=> array(

					'label'						=>	__('Badge Position', 'ws-form'),
					'mask'						=>	'data-badge="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Position of the reCAPTCHA badge (Invisible only).', 'ws-form'),
					'options'					=>	array(

						array('value' => 'bottomright', 'text' => __('Bottom Right', 'ws-form')),
						array('value' => 'bottomleft', 'text' => __('Bottom Left', 'ws-form')),
						array('value' => 'inline', 'text' => __('Inline', 'ws-form'))
					),
					'default'					=>	'bottomright',
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'recaptcha_recaptcha_type',
							'meta_value'	=>	'v2_invisible'
						)
					)
				),

				// reCAPTCHA - Type
				'recaptcha_type'		=> array(

					'label'						=>	__('Type', 'ws-form'),
					'mask'						=>	'data-type="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Image or audio?', 'ws-form'),
					'options'					=>	array(

						array('value' => 'image', 'text' => __('Image', 'ws-form')),
						array('value' => 'audio', 'text' => __('Audio', 'ws-form')),
					),
					'default'					=>	'image',
					'condition'					=>	array(

						array(

							'logic'			=>	'!=',
							'meta_key'		=>	'recaptcha_recaptcha_type',
							'meta_value'	=>	'v3_default'
						)
					)
				),

				// reCAPTCHA - Theme
				'recaptcha_theme'		=> array(

					'label'						=>	__('Theme', 'ws-form'),
					'mask'						=>	'data-theme="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Light or dark theme?', 'ws-form'),
					'options'					=>	array(

						array('value' => 'light', 'text' => __('Light', 'ws-form')),
						array('value' => 'dark', 'text' => __('Dark', 'ws-form')),
					),
					'default'					=>	'light',
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'recaptcha_recaptcha_type',
							'meta_value'	=>	'v2_default'
						)
					)
				),

				// reCAPTCHA - Size
				'recaptcha_size'		=> array(

					'label'						=>	__('Size', 'ws-form'),
					'mask'						=>	'data-size="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Normal or compact size?', 'ws-form'),
					'options'					=>	array(

						array('value' => 'normal', 'text' => __('Normal', 'ws-form')),
						array('value' => 'compact', 'text' => __('Compact', 'ws-form')),
					),
					'default'					=>	'normal',
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'recaptcha_recaptcha_type',
							'meta_value'	=>	'v2_default'
						)
					)
				),

				// reCAPTCHA - Language (Language Culture Name)
				'recaptcha_language'	=> array(

					'label'						=>	__('Language', 'ws-form'),
					'mask'						=>	'data-language="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Force the reCAPTCHA to render in a specific language?', 'ws-form'),
					'options'					=>	array(

						array('value' => '', 'text' => 'Auto Detect'),
						array('value' => 'ar', 'text' => 'Arabic'),
						array('value' => 'af', 'text' => 'Afrikaans'),
						array('value' => 'am', 'text' => 'Amharic'),
						array('value' => 'hy', 'text' => 'Armenian'),
						array('value' => 'az', 'text' => 'Azerbaijani'),
						array('value' => 'eu', 'text' => 'Basque'),
						array('value' => 'bn', 'text' => 'Bengali'),
						array('value' => 'bg', 'text' => 'Bulgarian'),
						array('value' => 'ca', 'text' => 'Catalan'),
						array('value' => 'zh-HK', 'text' => 'Chinese (Hong Kong)'),
						array('value' => 'zh-CN', 'text' => 'Chinese (Simplified)'),
						array('value' => 'zh-TW', 'text' => 'Chinese (Traditional)'),
						array('value' => 'hr', 'text' => 'Croatian'),
						array('value' => 'cs', 'text' => 'Czech'),
						array('value' => 'da', 'text' => 'Danish'),
						array('value' => 'nl', 'text' => 'Dutch'),
						array('value' => 'en-GB', 'text' => 'English (UK)'),
						array('value' => 'en', 'text' => 'English (US)'),
						array('value' => 'et', 'text' => 'Estonian'),
						array('value' => 'fil', 'text' => 'Filipino'),
						array('value' => 'fi', 'text' => 'Finnish'),
						array('value' => 'fr', 'text' => 'French'),
						array('value' => 'fr-CA', 'text' => 'French (Canadian)'),
						array('value' => 'gl', 'text' => 'Galician'),
						array('value' => 'ka', 'text' => 'Georgian'),
						array('value' => 'de', 'text' => 'German'),
						array('value' => 'de-AT', 'text' => 'German (Austria)'),
						array('value' => 'de-CH', 'text' => 'German (Switzerland)'),
						array('value' => 'el', 'text' => 'Greek'),
						array('value' => 'gu', 'text' => 'Gujarati'),
						array('value' => 'iw', 'text' => 'Hebrew'),
						array('value' => 'hi', 'text' => 'Hindi'),
						array('value' => 'hu', 'text' => 'Hungarain'),
						array('value' => 'is', 'text' => 'Icelandic'),
						array('value' => 'id', 'text' => 'Indonesian'),
						array('value' => 'it', 'text' => 'Italian'),
						array('value' => 'ja', 'text' => 'Japanese'),
						array('value' => 'kn', 'text' => 'Kannada'),
						array('value' => 'ko', 'text' => 'Korean'),
						array('value' => 'lo', 'text' => 'Laothian'),
						array('value' => 'lv', 'text' => 'Latvian'),
						array('value' => 'lt', 'text' => 'Lithuanian'),
						array('value' => 'ms', 'text' => 'Malay'),
						array('value' => 'ml', 'text' => 'Malayalam'),
						array('value' => 'mr', 'text' => 'Marathi'),
						array('value' => 'mn', 'text' => 'Mongolian'),
						array('value' => 'no', 'text' => 'Norwegian'),
						array('value' => 'fa', 'text' => 'Persian'),
						array('value' => 'pl', 'text' => 'Polish'),
						array('value' => 'pt', 'text' => 'Portuguese'),
						array('value' => 'pt-BR', 'text' => 'Portuguese (Brazil)'),
						array('value' => 'pt-PT', 'text' => 'Portuguese (Portugal)'),
						array('value' => 'ro', 'text' => 'Romanian'),
						array('value' => 'ru', 'text' => 'Russian'),
						array('value' => 'sr', 'text' => 'Serbian'),
						array('value' => 'si', 'text' => 'Sinhalese'),
						array('value' => 'sk', 'text' => 'Slovak'),
						array('value' => 'sl', 'text' => 'Slovenian'),
						array('value' => 'es', 'text' => 'Spanish'),
						array('value' => 'es-419', 'text' => 'Spanish (Latin America)'),
						array('value' => 'sw', 'text' => 'Swahili'),
						array('value' => 'sv', 'text' => 'Swedish'),
						array('value' => 'ta', 'text' => 'Tamil'),
						array('value' => 'te', 'text' => 'Telugu'),
						array('value' => 'th', 'text' => 'Thai'),
						array('value' => 'tr', 'text' => 'Turkish'),
						array('value' => 'uk', 'text' => 'Ukrainian'),
						array('value' => 'ur', 'text' => 'Urdu'),
						array('value' => 'vi', 'text' => 'Vietnamese'),
						array('value' => 'zu', 'text' => 'Zul')
					),
					'default'					=>	'',
					'condition'					=>	array(

						array(

							'logic'			=>	'!=',
							'meta_key'		=>	'recaptcha_recaptcha_type',
							'meta_value'	=>	'v3_default'
						)
					)
				),

				// reCAPTCHA - Action
				'recaptcha_action'		=> array(

					'label'						=>	__('Action', 'ws-form'),
					'mask'						=>	'data-recaptcha-action="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'help'						=>	__('Actions run on form load. Actions may only contain alphanumeric characters and slashes, and must not be user-specific.', 'ws-form'),
					'default'					=>	'ws_form/#form_id/load',
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'recaptcha_recaptcha_type',
							'meta_value'	=>	'v3_default'
						)
					)
				),

				// Signature - Dot Size
				'signature_dot_size'			=> array(

					'label'						=>	__('Pen Size', 'ws-form'),
					'mask'						=>	'data-dot-size="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'number',
					'help'						=>	__('Radius of a single dot.', 'ws-form'),
					'default'					=>	'2'
				),

				// Signature - Pen Color
				'signature_pen_color'			=> array(

					'label'						=>	__('Pen Color', 'ws-form'),
					'mask'						=>	'data-pen-color="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'color',
					'help'						=>	__('Color used to draw the lines.', 'ws-form'),
					'default'					=>	'#000000'
				),

				// Signature - Background Color
				'signature_background_color'	=> array(

					'label'						=>	__('Background Color', 'ws-form'),
					'mask'						=>	'data-background-color="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'color',
					'help'						=>	__('Color used for background (JPG only).', 'ws-form'),
					'default'					=>	'#ffffff',
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'signature_mime',
							'meta_value'	=>	'image/jpeg'
						)
					)
				),

				// Signature - Type
				'signature_mime'			=> array(

					'label'						=>	__('Type', 'ws-form'),
					'mask'						=>	'data-mime="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Output format of signature image.', 'ws-form'),
					'options'					=>	array(

						array('value' => '', 'text' => __('PNG (Transparent)', 'ws-form')),
						array('value' => 'image/jpeg', 'text' => __('JPG', 'ws-form')),
						array('value' => 'image/svg+xml', 'text' => __('SVG', 'ws-form')),
					),
					'default'					=>	''
				),

				// Signature - Height
				'signature_height'			=> array(

					'label'						=>	__('Height', 'ws-form'),
					'mask'						=>	'style="height:#value; padding: 0; width: 100%;"',
					'mask_disregard_on_empty'	=>	false,
					'type'						=>	'text',
					'help'						=>	__('Height of signature canvas.', 'ws-form'),
					'default'					=>	'76px'
				),

				// Signature - Crop
				'signature_crop'			=> array(

					'label'						=>	__('Crop', 'ws-form'),
					'mask'						=>	'data-crop',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'help'						=>	__('Should the signature be cropped prior to submitting it?', 'ws-form'),
					'default'					=>	'on'
				),

				// Input Type - Date/Time
				'input_type_datetime'		=> array(

					'label'						=>	__('Type', 'ws-form'),
					'mask'						=>	'type="#datetime_type" data-date-type="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Type of date to display.', 'ws-form'),
					'data_change'				=>	array('event' => 'change', 'action' => 'reload'),

					'options'					=>	array(

						array('value' => 'date', 'text' => __('Date', 'ws-form')),
						array('value' => 'time', 'text' => __('Time', 'ws-form')),
						array('value' => 'datetime-local', 'text' => __('Date/Time', 'ws-form')),
						array('value' => 'week', 'text' => __('Week', 'ws-form')),
						array('value' => 'month', 'text' => __('Month', 'ws-form')),
					),
					'default'					=>	'date',
					'compatibility_id'			=> 'input-datetime'
				),

				// Date format
				'format_date' => array(

					'label'						=>	__('Date Format', 'ws-form'),
					'mask'						=>	'data-date-format="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'options'					=>	array(

						array('value' => '', 'text' => __(sprintf('Default (%s)', date_i18n(get_option('date_format'))), 'ws-form'))
					),
					'default'					=>	'',
					'help'						=>	__('Format used for selected date.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'input_type_datetime',
							'meta_value'		=>	'date'
						),

						array(

							'logic_previous'	=>	'||',
							'logic'				=>	'==',
							'meta_key'			=>	'input_type_datetime',
							'meta_value'		=>	'datetime-local'
						)
					)
				),

				// Time format
				'format_time' => array(

					'label'						=>	__('Time Format', 'ws-form'),
					'mask'						=>	'data-time-format="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'options'					=>	array(

						array('value' => '', 'text' => __(sprintf('Default (%s)', date_i18n(get_option('time_format'))), 'ws-form'))
					),
					'default'					=>	'',
					'help'						=>	__('Format used for selected time.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'input_type_datetime',
							'meta_value'		=>	'time'
						),

						array(

							'logic_previous'	=>	'||',
							'logic'				=>	'==',
							'meta_key'			=>	'input_type_datetime',
							'meta_value'		=>	'datetime-local'
						)
					)
				),

				// Input Type - Text Area
				'input_type_textarea'		=> array(

					'label'						=>	__('Type', 'ws-form'),
					'mask'						=>	'data-textarea-type="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Type of text editor to display.', 'ws-form'),
					'data_change'				=>	array('event' => 'change', 'action' => 'reload'),

					'options'					=>	array(

						array('value' => '', 'text' => __('Text Area', 'ws-form'))
					),
					'default'					=> '',
					'help'						=> __('If a user has visual editor or syntax highlighting disabled, those editors will not render.', 'ws-form')
				),

				// Input Type - Text Area
				'input_type_textarea_toolbar'		=> array(

					'label'						=>	__('Visual Editor Toolbar', 'ws-form'),
					'mask'						=>	'data-textarea-toolbar="#value"',
					'type'						=>	'select',
					'help'						=>	__('Type of text editor to display.', 'ws-form'),
					'options'					=>	array(

						array('value' => 'full', 'text' => __('Full', 'ws-form')),
						array('value' => 'compact', 'text' => __('Compact', 'ws-form'))
					),
					'default'					=> '',
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'input_type_textarea',
							'meta_value'	=>	'tinymce'
						)
					),
				),

				// Progress Data Source
				'progress_source'		=> array(

					'label'						=>	__('Source', 'ws-form'),
					'mask'						=>	'data-source="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Source of progress data.', 'ws-form'),

					'options'					=>	array(

						array('value' => '', 'text' => __('No source', 'ws-form')),
						array('value' => 'form_progress', 'text' => __('Form Progress', 'ws-form')),
						array('value' => 'tab_progress', 'text' => __('Tab Progress', 'ws-form')),
						array('value' => 'post_progress', 'text' => __('Upload Progress', 'ws-form')),
					),
					'default'					=>	'form_progress'
				),
				'class_field_full_button_remove'	=> array(

					'label'						=>	__('Remove Full Width Class', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	''
				),

				'class_field_message_type'			=> array(

					'label'						=>	__('Type', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'information',
					'options'					=>	$message_types,
					'help'						=>	__('Style of message to use', 'ws-form')
				),

				'class_field_button_type'			=> array(

					'label'						=>	__('Type', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'default',
					'options'					=>	$button_types,
					'fallback'					=>	'default'
				),

				'class_field_button_type_primary'		=> array(

					'label'						=>	__('Type', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'primary',
					'options'					=>	$button_types,
					'key'						=>	'class_field_button_type',
					'fallback'					=>	'primary'
				),

				'class_field_button_type_danger'		=> array(

					'label'						=>	__('Type', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'danger',
					'options'					=>	$button_types,
					'key'						=>	'class_field_button_type',
					'fallback'					=>	'danger'
				),

				'class_field_button_type_success'		=> array(

					'label'						=>	__('Type', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'success',
					'options'					=>	$button_types,
					'key'						=>	'class_field_button_type',
					'fallback'					=>	'success'
				),

				'class_fill_lower_track'			=> array(

					'label'						=>	__('Fill Lower Track', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'mask'						=>	'data-fill-lower-track',
					'mask_disregard_on_empty'	=>	true,
					'help'						=>	__('WS Form skin only.', 'ws-form'),
				),

				'class_single_vertical_align'			=> array(

					'label'						=>	__('Vertical Alignment', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	$vertical_align
				),

				'class_single_vertical_align_bottom'	=> array(

					'label'						=>	__('Vertical Alignment', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'bottom',
					'options'					=>	$vertical_align,
					'key'						=>	'class_single_vertical_align',
					'fallback'					=>	''
				),

				// Sets default value attribute (unless saved value exists)
				'default_value'			=> array(

					'label'						=>	__('Default Value', 'ws-form'),
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Default value entered in field.', 'ws-form'),
					'select_list'				=>	true,
					'calc'						=>	true
				),

				// Sets default value attribute (unless saved value exists)
				'default_value_number'	=> array(

					'label'						=>	__('Default Value', 'ws-form'),
					'type'						=>	'number',
					'type_advanced'				=>	'text',
					'default'					=>	'',
					'help'						=>	__('Default number entered in field.', 'ws-form'),
					'key'						=>	'default_value',
					'select_list'				=>	true,
					'select_list_for_type'		=>	'text',
					'calc'						=>	true,
					'calc_for_type'				=>	'text'
				),

				// Sets default value attribute (unless saved value exists)
				'default_value_range' => array(

					'label'						=>	__('Default Value', 'ws-form'),
					'type'						=>	'range',
					'type_advanced'				=>	'text',
					'default'					=>	'',
					'help'						=>	__('Default value of range slider.', 'ws-form'),
					'key'						=>	'default_value',
					'select_list'				=>	true,
					'select_list_for_type'		=>	'text',
					'calc'						=>	true,
					'calc_for_type'				=>	'text'
				),

				// Sets default value attribute (unless saved value exists)
				'default_value_price_range' => array(

					'label'						=>	__('Default Value', 'ws-form'),
					'type'						=>	'range',
					'type_advanced'				=>	'text',
					'default'					=>	'0',
					'help'						=>	__('Default value of price range slider.', 'ws-form'),
					'key'						=>	'default_value',
					'select_list'				=>	true,
					'select_list_for_type'		=>	'text',
					'calc'						=>	true,
					'calc_for_type'				=>	'text'
				),

				// Sets default value attribute (unless saved value exists)
				'default_value_color' => array(

					'label'						=>	__('Default Color', 'ws-form'),
					'type'						=>	'color',
					'type_advanced'				=>	'text',
					'default'					=>	'#000000',
					'help'						=>	__('Default color selected in field.', 'ws-form'),
					'key'						=>	'default_value',
					'select_list'				=>	true,
					'select_list_for_type'		=>	'text'
				),

				// Sets default value attribute (unless saved value exists)
				'default_value_datetime' => array(

					'label'						=>	__('Default Value', 'ws-form'),
					'type'						=>	'datetime',
					'type_advanced'				=>	'text',
					'default'					=>	'',
					'help'						=>	__('Default date entered in field. If using the jQuery date/time picker (default) then match the chosen date/time format. If using the native browser date/time picker use yyyy-mm-dd format.', 'ws-form'),
					'key'						=>	'default_value',
					'select_list'				=>	true,
					'select_list_for_type'		=>	'text'
				),

				// Sets default value attribute (unless saved value exists)
				'default_value_email'		=> array(

					'label'						=>	__('Default Value', 'ws-form'),
					'type'						=>	'email',
					'type_advanced'				=>	'text',
					'default'					=>	'',
					'help'						=>	__('Default email entered in field.', 'ws-form'),
					'key'						=>	'default_value',
					'select_list'				=>	true,
					'select_list_for_type'		=>	'text'
				),

				// Sets default value attribute (unless saved value exists)
				'default_value_tel'		=> array(

					'label'						=>	__('Default Value', 'ws-form'),
					'type'						=>	'tel',
					'type_advanced'				=>	'text',
					'default'					=>	'',
					'help'						=>	__('Default phone number entered in field.', 'ws-form'),
					'key'						=>	'default_value',
					'select_list'				=>	true,
					'select_list_for_type'		=>	'text'
				),

				// Sets default value attribute (unless saved value exists)
				'default_value_url'		=> array(

					'label'						=>	__('Default Value', 'ws-form'),
					'type'						=>	'url',
					'type_advanced'				=>	'text',
					'default'					=>	'',
					'help'						=>	__('Default URL entered in field.', 'ws-form'),
					'key'						=>	'default_value',
					'select_list'				=>	true,
					'select_list_for_type'		=>	'text'
				),

				// Sets default value attribute (unless saved value exists)
				'default_value_textarea'		=> array(

					'label'						=>	__('Default Value', 'ws-form'),
					'type'						=>	'textarea',
					'default'					=>	'',
					'help'						=>	__('Default value entered in field', 'ws-form'),
					'key'						=>	'default_value',
					'select_list'				=>	true,
					'calc'						=>	true
				),

				// Orientation
				'orientation'			=> array(

					'label'						=>	__('Orientation', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	array(

						array('value' => '', 'text' => __('Vertical', 'ws-form')),
						array('value' => 'horizontal', 'text' => __('Horizontal', 'ws-form')),
						array('value' => 'grid', 'text' => __('Grid', 'ws-form'))
					),
					'key_legacy'				=>	'class_inline'
				),
				// Orientation
				'file_preview_orientation'			=> array(

					'label'						=>	__('Orientation', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	array(

						array('value' => '', 'text' => __('Vertical', 'ws-form')),
						array('value' => 'horizontal', 'text' => __('Horizontal', 'ws-form')),
						array('value' => 'grid', 'text' => __('Grid', 'ws-form'))
					),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'file_preview',
							'meta_value'		=>	'on'
						)
					),
					'key'						=>	'orientation'
				),

				// Orientation sizes grid
				'orientation_breakpoint_sizes'		=> array(

					'label'						=>	__('Grid Breakpoint Sizes', 'ws-form'),
					'type'						=>	'orientation_breakpoint_sizes',
					'dummy'						=>	true,
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'orientation',
							'meta_value'	=>	'grid'
						)
					)
				),

				// Orientation sizes grid
				'file_preview_orientation_breakpoint_sizes'		=> array(

					'label'						=>	__('Grid Breakpoint Sizes', 'ws-form'),
					'type'						=>	'orientation_breakpoint_sizes',
					'dummy'						=>	true,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'file_preview',
							'meta_value'		=>	'on'
						),

						array(

							'logic_previous'	=>	'&&',
							'logic'				=>	'==',
							'meta_key'			=>	'orientation',
							'meta_value'		=>	'grid'
						)
					),
					'key'						=>	'orientation_breakpoint_sizes'
				),

				// Form label mask (Allows user to define custom mask)
				'label_mask_form'		=> array(

					'label'						=>	__('Form', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Example: &apos;&lt;h2&gt;#label&lt;/h2&gt;&apos;.', 'ws-form'),
					'placeholder'				=>	'&lt;h2&gt;#label&lt;/h2&gt'
				),

				// Group label mask (Allows user to define custom mask)
				'label_mask_group'		=> array(

					'label'						=>	__('Tab', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Example: &apos;&lt;h3&gt;#label&lt;/h3&gt;&apos;.', 'ws-form'),
					'placeholder'				=>	'&lt;h3&gt;#label&lt;/h3&gt'
				),

				// Section label mask (Allows user to define custom mask)
				'label_mask_section'		=> array(

					'label'						=>	__('Section', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Example: &apos;&lt;legend&gt;#label&lt;/legend&gt;&apos;.', 'ws-form'),
					'placeholder'				=>	'&lt;legend&gt;#label&lt;/legend&gt;'
				),

				// Wrapper classes
				'class_form_wrapper'		=> array(

					'label'						=>	__('Form Wrapper', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Separate classes with spaces.', 'ws-form')
				),

				'class_group_wrapper'		=> array(

					'label'						=>	__('Tab Wrapper', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Separate classes with spaces.', 'ws-form')
				),

				'class_section_wrapper'		=> array(

					'label'						=>	__('Section Wrapper', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Separate classes with spaces.', 'ws-form')
				),

				'class_field_wrapper'		=> array(

					'label'						=>	__('Field Wrapper', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Separate classes with spaces.', 'ws-form')
				),

				// Classes
				'class_field'			=> array(

					'label'						=>	__('Field', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Separate classes with spaces.', 'ws-form')
				),

				'contact_first_name'	=> array(

					'label'						=>	__('First Name', 'ws-form'),
					'type'						=>	'text',
					'required'					=>	true
				),

				'contact_last_name'	=> array(

					'label'						=>	__('Last Name', 'ws-form'),
					'type'						=>	'text',
					'required'					=>	true
				),

				'contact_email'	=> array(

					'label'						=>	__('Email', 'ws-form'),
					'type'						=>	'email',
					'required'					=>	true
				),

				'contact_push_form'	=> array(

					'label'						=>	__('Attach form (Recommended)', 'ws-form'),
					'type'						=>	'checkbox'
				),

				'contact_push_system'	=> array(

					'label'						=>	sprintf('<a href="%s" target="_blank">%s</a> (%s).', WS_Form_Common::get_admin_url('ws-form-settings', false, 'tab=system'), __('Attach system info', 'ws-form'), __('Recommended', 'ws-form')),
					'type'						=>	'checkbox'
				),

				'contact_inquiry'	=> array(

					'label'						=>	__('Inquiry', 'ws-form'),
					'type'						=>	'textarea',
					'required'					=>	true
				),

				'contact_gdpr'	=> array(

					'label'						=>	__('I consent to having WS Form store my submitted information so they can respond to my inquiry.', 'ws-form'),
					'type'						=>	'checkbox',
					'required'					=>	true
				),

				'contact_submit'	=> array(

					'label'						=>	__('Request Support', 'ws-form'),
					'type'						=>	'button',
					'data-action'				=>	'wsf-contact-us'
				),

				'help'						=> array(

					'label'						=>	__('Help Text', 'ws-form'),
					'type'						=>	'textarea',
					'help'						=>	__('Help text to show alongside this field.', 'ws-form'),
					'select_list'				=>	true
				),

				'help_progress'				=> array(

					'label'						=>	__('Help Text', 'ws-form'),
					'type'						=>	'textarea',
					'help'						=>	__('Help text to show alongside this field. You can use #progress_percent to inject the current progress percentage.', 'ws-form'),
					'default'					=>	'#progress_percent',
					'key'						=>	'help',
					'select_list'				=>	true
				),

				'help_range'				=> array(

					'label'						=>	__('Help Text', 'ws-form'),
					'type'						=>	'textarea',
					'help'						=>	__('Help text to show alongside this field. You can use #value to inject the current range value.', 'ws-form'),
					'default'					=>	'#value',
					'key'						=>	'help',
					'select_list'				=>	true
				),

				'help_price_range'				=> array(

					'label'						=>	__('Help Text', 'ws-form'),
					'type'						=>	'textarea',
					'help'						=>	__('Help text to show alongside this field. You can use #value to inject the current range value.', 'ws-form'),
					'default'					=>	'#ecommerce_currency_symbol#value',
					'key'						=>	'help',
					'select_list'				=>	true
				),

				'help_count_char'	=> array(

					'label'						=>	__('Help Text', 'ws-form'),
					'type'						=>	'textarea',
					'help'						=>	__('Help text to show alongside this field. Use #character_count to inject the current character count.', 'ws-form'),
					'default'					=>	'',
					'key'						=>	'help',
					'select_list'				=>	true
				),

				'help_count_char_word'	=> array(

					'label'						=>	__('Help Text', 'ws-form'),
					'type'						=>	'textarea',
					'help'						=>	__('Help text to show alongside this field. Use #character_count or #word_count to inject the current character or word count.', 'ws-form'),
					'default'					=>	'',
					'key'						=>	'help',
					'select_list'				=>	true
				),

				'help_count_char_word_with_default'	=> array(

					'label'						=>	__('Help Text', 'ws-form'),
					'type'						=>	'textarea',
					'help'						=>	__('Help text to show alongside this field. Use #character_count or #word_count to inject the current character or word count.', 'ws-form'),
					'default'					=>	'#character_count #character_count_label / #word_count #word_count_label',
					'key'						=>	'help',
					'select_list'				=>	true
				),

				'html_editor'				=> array(

					'label'						=>	__('HTML', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'html_editor',
					'default'					=>	'',
					'help'						=>	__('Enter raw HTML to be output at this point on the form.', 'ws-form'),
					'select_list'				=>	true,
					'calc'						=>	true
				),

				'shortcode'					=> array(

					'label'						=>	__('Shortcode', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Enter the shortcode to insert.', 'ws-form'),
					'select_list'				=>	true
				),

				'invalid_feedback'			=> array(

					'label'						=>	__('Invalid Feedback Text', 'ws-form'),
					'type'						=>	'textarea',
					'help'						=>	__('Text to show if this field is incorrectly completed.', 'ws-form'),
					'mask_placeholder'			=>	__('Please provide a valid #label_lowercase.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'			=>	'==',
							'meta_key'		=>	'invalid_feedback_render',
							'meta_value'	=>	'on'
						)
					),
					'variables'					=> true
				),

				'invalid_feedback_render'	=> array(

					'label'						=>	__('Show Invalid Feedback', 'ws-form'),
					'type'						=>	'checkbox',
					'help'						=>	__('Show invalid feedback text?', 'ws-form'),
					'default'					=>	'on'
				),

				'text_editor'			=> array(

					'label'						=>	__('Content', 'ws-form'),
					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text_editor',
					'default'					=>	'',
					'help'						=>	__('Enter paragraphs of text.', 'ws-form'),
					'select_list'				=>	true,
					'calc'						=>	true
				),

				'required_message'		=> array(

					'label'						=>	__('Required Message', 'ws-form'),
					'type'						=>	'required_message',
					'help'						=>	__('Enter a custom message to show if this field is not completed.', 'ws-form'),
					'select_list'				=>	true
				),

				// Class for the wrapper
				'accept'		=> array(

					'label'						=>	__('File Type(s)', 'ws-form'),
					'mask'						=>	'accept="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'',
					'help'						=>	__('Specify the mime types of files that are accepted separate by commas.', 'ws-form'),
					'placeholder'				=>	__('e.g. application/pdf,image/jpeg', 'ws-form'),
					'compatibility_id'			=>	'input-file-accept',
					'select_lust'				=>	array()
				),

				// Field - HTML 5 attributes

				'cols'						=> array(

					'label'						=>	__('Columns', 'ws-form'),
					'mask'						=>	'cols="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_disregard_on_zero'	=>	true,
					'type'						=>	'number',
					'help'						=>	__('Number of columns.', 'ws-form')
				),

				'disabled'				=> array(

					'label'						=>	__('Disabled', 'ws-form'),
					'mask'						=>	'disabled',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'data_change'				=>	array('event' => 'change', 'action' => 'update'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'required',
							'meta_value'		=>	'on'
						),

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'readonly',
							'meta_value'		=>	'on',
							'logic_previous'	=>	'&&'
						)
					)
				),

				'section_repeatable'			=> array(

					'label'						=>	__('Enabled', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'data_change'				=>	array('event' => 'change', 'action' => 'update'),
					'fields_toggle'				=>	array(

						array(

							'type'				=> 'section_icons',
							'width_factor'		=> 0.25
						)
					),
					'fields_ignore'				=>	array(

						'section_add',
						'section_delete',
						'section_icons'
					)
				),

				'section_repeat_label'			=> array(

					'label'						=>	__('Repeat Label', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'label_render',
							'meta_value'		=>	'on'
						),

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_repeatable',
							'meta_value'		=>	'on'
						)
					),
				),

				'section_repeat_min'			=> array(

					'label'						=>	__('Minimum Row Count', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	'',
					'min'						=>	1,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_repeatable',
							'meta_value'		=>	'on'
						)
					)
				),

				'section_repeat_max'			=> array(

					'label'						=>	__('Maximum Row Count', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	'',
					'min'						=>	1,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_repeatable',
							'meta_value'		=>	'on'
						)
					)
				),

				'section_repeat_default'		=> array(

					'label'						=>	__('Default Row Count', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	'',
					'min'						=>	1,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_repeatable',
							'meta_value'		=>	'on'
						)
					)
				),

				// Section icons - Style
				'section_icons_style'		=> array(

					'label'						=>	__('Icon', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'circle',
					'help'						=>	__('Select the style of the icons.', 'ws-form'),
					'options'					=>	array(

						array('value' => 'circle', 'text' => __('Circle', 'ws-form')),
						array('value' => 'circle-solid', 'text' => __('Circle - Solid', 'ws-form')),
						array('value' => 'square', 'text' => __('Square', 'ws-form')),
						array('value' => 'square-solid', 'text' => __('Square - Solid', 'ws-form')),
						array('value' => 'text', 'text' => __('Text', 'ws-form')),
						array('value' => 'custom', 'text' => __('Custom HTML', 'ws-form'))
					)
				),

				// Section icons
				'section_icons'	=> array(

					'type'						=>	'repeater',
					'help'						=>	__('Select the icons to show.', 'ws-form'),
					'meta_keys'					=>	array(

						'section_icons_type',
						'section_icons_label'
					),
					'meta_keys_unique'			=>	array(
						'section_icons_type'
					),
					'default'					=>	array(

						array(

							'section_icons_type' => 'add',
							'section_icons_label' => __('Add row', 'ws-form')
						),

						array(

							'section_icons_type' => 'delete',
							'section_icons_label' => __('Remove row', 'ws-form')
						),

						array(

							'section_icons_type' => 'move-up',
							'section_icons_label' => __('Move row up', 'ws-form')
						),

						array(

							'section_icons_type' => 'move-down',
							'section_icons_label' => __('Move row down', 'ws-form')
						)
					)
				),

				// Section icons - Types
				'section_icons_type'	=> array(

					'label'						=>	__('Type', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'help'						=>	__('Select the style of the add icon.', 'ws-form'),
					'options'					=>	array(

						array('value' => 'add', 'text' => __('Add', 'ws-form')),
						array('value' => 'delete', 'text' => __('Remove', 'ws-form')),
						array('value' => 'move-up', 'text' => __('Move Up', 'ws-form')),
						array('value' => 'move-down', 'text' => __('Move Down', 'ws-form')),
						array('value' => 'drag', 'text' => __('Drag', 'ws-form')),
						array('value' => 'reset', 'text' => __('Reset', 'ws-form')),
						array('value' => 'clear', 'text' => __('Clear', 'ws-form'))
					),
					'options_blank'					=>	__('Select...', 'ws-form'),
				),

				// Section icons - Label
				'section_icons_label'	=> array(

					'label'						=>	__('ARIA Label', 'ws-form'),
					'type'						=>	'text',
					'default'					=>	''
				),

				// Section icons - Size
				'section_icons_size'	=> array(

					'label'						=>	__('Size (Pixels)', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	24,
					'min'						=>	1,
					'help'						=>	__('Size of section icons in pixels.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'custom'
						),

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'text'
						)
					)
				),

				// Section icons - Color - Off
				'section_icons_color_off'	=> array(

					'label'						=>	__('Disabled Color', 'ws-form'),
					'mask'						=>	'data-rating-color-off="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'color',
					'default'					=>	'#888888',
					'help'						=>	__('Color of section icons when disabled.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'custom'
						)
					)
				),

				// Section icons - Color - On
				'section_icons_color_on'	=> array(

					'label'						=>	__('Active Color', 'ws-form'),
					'mask'						=>	'data-rating-color-on="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'color',
					'default'					=>	'#000000',
					'help'						=>	__('Color of section icons when active.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'custom'
						)
					)
				),

				// Section icons - HTML - Add
				'section_icons_html_add'	=> array(

					'label'						=>	__('Add Icon HTML', 'ws-form'),
					'type'						=>	'html_editor',
					'default'					=>	'<span title="Add">Add</span>',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'custom'
						)
					)
				),

				// Section icons - HTML - Delete
				'section_icons_html_delete'	=> array(

					'label'						=>	__('Remove Icon HTML', 'ws-form'),
					'type'						=>	'html_editor',
					'default'					=>	'<span title="Remove">Remove</span>',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'custom'
						)
					)
				),

				// Section icons - HTML - Move Up
				'section_icons_html_move_up'	=> array(

					'label'						=>	__('Move Up Icon HTML', 'ws-form'),
					'type'						=>	'html_editor',
					'default'					=>	'<span title="Move Up">Move Up</span>',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'custom'
						)
					)
				),

				// Section icons - HTML - Move Down
				'section_icons_html_move_down'	=> array(

					'label'						=>	__('Move Down Icon HTML', 'ws-form'),
					'type'						=>	'html_editor',
					'default'					=>	'<span title="Move Down">Move Down</span>',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'custom'
						)
					)
				),

				// Section icons - HTML - Drag
				'section_icons_html_drag'	=> array(

					'label'						=>	__('Drag Icon HTML', 'ws-form'),
					'type'						=>	'html_editor',
					'default'					=>	'<span title="Drag">Drag</span>',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'custom'
						)
					)
				),

				// Section icons - HTML - Reset
				'section_icons_html_reset'	=> array(

					'label'						=>	__('Reset Icon HTML', 'ws-form'),
					'type'						=>	'html_editor',
					'default'					=>	'<span title="Reset">Reset</span>',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'custom'
						)
					)
				),

				// Section icons - HTML - Clear
				'section_icons_html_clear'	=> array(

					'label'						=>	__('Clear Icon HTML', 'ws-form'),
					'type'						=>	'html_editor',
					'default'					=>	'<span title="clear">Clear</span>',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_icons_style',
							'meta_value'		=>	'custom'
						)
					)
				),

				'section_repeatable_section_id'	=> array(

					'label'						=>	__('Repeatable Section', 'ws-form'),
					'mask'						=>	'data-repeatable-section-id="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'options'					=>	'sections',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'section_filter_attribute'	=>	'section_repeatable',
					'help'						=>	__('Select the repeatabled section this field is assigned to.', 'ws-form'),
					'required_setting'			=>	true,
					'data_change'				=>	array('event' => 'change', 'action' => 'update'),
					'default'					=>	'#section_id'
				),

				// Horizontal Align
				'horizontal_align'	=> array(

					'label'						=>	__('Horizontal Alignment', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'flex-start',
					'options'					=>	array(

						array('value' => 'flex-start', 'text' => __('Left', 'ws-form')),
						array('value' => 'center', 'text' => __('Center', 'ws-form')),
						array('value' => 'flex-end', 'text' => __('Right', 'ws-form')),
						array('value' => 'space-around', 'text' => __('Space Around', 'ws-form')),
						array('value' => 'space-between', 'text' => __('Space Between', 'ws-form')),
						array('value' => 'space-evenly', 'text' => __('Space Evenly', 'ws-form'))
					)
				),

				'section_repeatable_delimiter_section'		=> array(

					'label'						=>	__('Row Delimiter', 'ws-form'),
					'type'						=>	'text',
					'help'						=>	__('String used to delimit rows in combined field values.', 'ws-form'),
					'default'					=>	WS_FORM_SECTION_REPEATABLE_DELIMITER_SECTION,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_repeatable',
							'meta_value'		=>	'on'
						)
					),
					'placeholder'				=>	WS_FORM_SECTION_REPEATABLE_DELIMITER_SECTION
				),

				'section_repeatable_delimiter_row'			=> array(

					'label'						=>	__('Item Delimiter', 'ws-form'),
					'type'						=>	'text',
					'help'						=>	__('String used to delimit items (e.g. Checkboxes) in combined field values.', 'ws-form'),
					'default'					=>	WS_FORM_SECTION_REPEATABLE_DELIMITER_ROW,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'section_repeatable',
							'meta_value'		=>	'on'
						)
					),
					'placeholder'				=>	WS_FORM_SECTION_REPEATABLE_DELIMITER_ROW

				),
				'disabled_section'				=> array(

					'label'						=>	__('Disabled', 'ws-form'),
					'mask'						=>	'disabled',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'data_change'				=>	array('event' => 'change', 'action' => 'update'),
					'compatibility_id'			=>	'fieldset-disabled'
				),

				'text_align'	=> array(

					'label'						=>	__('Text Align', 'ws-form'),
					'mask'						=>	'style="text-align: #value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Select the alignment of text in the field.', 'ws-form'),
					'options'					=>	array(

						array('value' => '', 'text' => __('Not Set', 'ws-form')),
						array('value' => 'left', 'text' => __('Left', 'ws-form')),
						array('value' => 'right', 'text' => __('Right', 'ws-form')),
						array('value' => 'center', 'text' => __('Center', 'ws-form')),
						array('value' => 'justify', 'text' => __('Justify', 'ws-form')),
						array('value' => 'inherit', 'text' => __('Inherit', 'ws-form')),
					),
					'default'					=>	'',
					'key'						=>	'text_align'
				),

				'text_align_right'	=> array(

					'label'						=>	__('Text Align', 'ws-form'),
					'mask'						=>	'style="text-align: #value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Select the alignment of text in the field.', 'ws-form'),
					'options'					=>	array(

						array('value' => '', 'text' => __('Not Set', 'ws-form')),
						array('value' => 'left', 'text' => __('Left', 'ws-form')),
						array('value' => 'right', 'text' => __('Right', 'ws-form')),
						array('value' => 'center', 'text' => __('Center', 'ws-form')),
						array('value' => 'justify', 'text' => __('Justify', 'ws-form')),
						array('value' => 'inherit', 'text' => __('Inherit', 'ws-form')),
					),
					'default'					=>	'right',
					'key'						=>	'text_align'
				),

				'text_align_center'	=> array(

					'label'						=>	__('Text Align', 'ws-form'),
					'mask'						=>	'style="text-align: #value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Select the alignment of text in the field.', 'ws-form'),
					'options'					=>	array(

						array('value' => '', 'text' => __('Not Set', 'ws-form')),
						array('value' => 'left', 'text' => __('Left', 'ws-form')),
						array('value' => 'right', 'text' => __('Right', 'ws-form')),
						array('value' => 'center', 'text' => __('Center', 'ws-form')),
						array('value' => 'justify', 'text' => __('Justify', 'ws-form')),
						array('value' => 'inherit', 'text' => __('Inherit', 'ws-form')),
					),
					'default'					=>	'center',
					'key'						=>	'text_align'
				),

				'autocomplete_off'	=> array(

					'label'						=>	__('Auto Complete Off', 'ws-form'),
					'mask'						=>	'autocomplete="off"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	''
				),

				'autocomplete_off_on'	=> array(

					'label'						=>	__('Auto Complete Off', 'ws-form'),
					'mask'						=>	'autocomplete="off"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'on'
				),

				'autocomplete_new_password'	=> array(

					'label'						=>	__('Auto Complete Off', 'ws-form'),
					'mask'						=>	'autocomplete="new-password"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'on'
				),

				'inline'	=> array(

					'label'						=>	__('Inline', 'ws-form'),
					'mask'						=>	'data-inline',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	''
				),

				'password_strength_meter' => array(

					'label'						=>	__('Password Strength Meter', 'ws-form'),
					'type'						=>	'checkbox',
					'mask'						=>	'data-password-strength-meter',
					'mask_disregard_on_empty'	=>	true,
					'help'						=>	__('Show the WordPress password strength meter?', 'ws-form'),
					'default'					=>	'on',
				),

				'hidden_bypass'	=> array(

					'label'						=>	__('Always Include in Actions', 'ws-form'),
					'mask'						=>	'data-hidden-bypass',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked, WS Form will always include this field in actions if it is hidden.', 'ws-form')
				),

				'ecommerce_calculation_persist'	=> array(

					'label'						=>	__('Always Include in Cart Total', 'ws-form'),
					'mask'						=>	'data-ecommerce-persist',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked, WS Form will include this field in the cart total calculation if it is hidden.', 'ws-form')
				),

				'ecommerce_price_negative'	=> array(

					'label'						=>	__('Allow Negative Value', 'ws-form'),
					'mask'						=>	'data-ecommerce-negative',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	''
				),

				'ecommerce_price_min'		=> array(

					'label'						=>	__('Minimum', 'ws-form'),
					'mask'						=>	'data-ecommerce-min="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_disregard_on_zero'	=>	false,
					'type'						=>	'text',
					'help'						=>	__('Minimum value this field can have.', 'ws-form'),
					'select_list'				=>	true
				),

				'ecommerce_price_max'		=> array(

					'label'						=>	__('Maximum', 'ws-form'),
					'mask'						=>	'data-ecommerce-max="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_disregard_on_zero'	=>	false,
					'type'						=>	'text',
					'help'						=>	__('Maximum value this field can have.', 'ws-form'),
					'select_list'				=>	true
				),

				'ecommerce_quantity_min'	=> array(

					'label'						=>	__('Minimum', 'ws-form'),
					'mask'						=>	'min="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_disregard_on_zero'	=>	false,
					'default'					=>	0,
					'type'						=>	'text',
					'help'						=>	__('Minimum value this field can have.', 'ws-form')
				),

				'ecommerce_field_id'	=> array(

					'label'						=>	__('Related Price Field', 'ws-form'),
					'mask'						=>	'data-ecommerce-field-id="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_attribute'	=>	array('ecommerce_price'),
					'help'						=>	__('Price field that this field relates to.', 'ws-form'),
					'required_setting'			=>	true,
					'data_change'				=>	array('event' => 'change', 'action' => 'update')
				),

				'ecommerce_quantity_default_value' => array(

					'label'						=>	__('Default Value', 'ws-form'),
					'type'						=>	'number',
					'type_advanced'				=>	'text',
					'default'					=>	'1',
					'help'						=>	__('Default quantity value.', 'ws-form'),
					'select_list'				=>	true,
					'key'						=>	'default_value'
				),

				// Price type
				'ecommerce_cart_price_type'	=> array(

					'label'						=>	__('Type', 'ws-form'),
					'mask'						=>	'data-ecommerce-cart-price-#value',
					'type'						=>	'select',
					'help'						=>	__('Select the type of cart detail.', 'ws-form'),
					'options'					=>	'ecommerce_cart_price_type',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'required_setting'			=>	true,
					'data_change'				=>	array('event' => 'change', 'action' => 'update')
				),
				'max_length'			=> array(

					'label'						=>	__('Maximum Characters', 'ws-form'),
					'mask'						=>	'maxlength="#value"',
					'mask_disregard_on_empty'	=>	true,
					'min'						=>	0,
					'type'						=>	'number',
					'default'					=>	'',
					'help'						=>	__('Maximum length for this field in characters.', 'ws-form'),
					'compatibility_id'			=>	'maxlength'
				),

				'min_length'			=> array(

					'label'						=>	__('Minimum Characters', 'ws-form'),
					'mask'						=>	'minlength="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'number',
					'min'						=>	0,
					'default'					=>	'',
					'help'						=>	__('Minimum length for this field in characters.', 'ws-form'),
					'compatibility_id'			=>	'input-minlength'
				),

				'max_length_words'			=> array(

					'label'						=>	__('Maximum Words', 'ws-form'),
					'type'						=>	'number',
					'min'						=>	0,
					'default'					=>	'',
					'help'						=>	__('Maximum words allowed in this field.', 'ws-form')
				),

				'min_length_words'			=> array(

					'label'						=>	__('Minimum Words', 'ws-form'),
					'min'						=>	0,
					'type'						=>	'number',
					'default'					=>	'',
					'help'						=>	__('Minimum words allowed in this field.', 'ws-form')
				),

				'min'						=> array(

					'label'						=>	__('Minimum', 'ws-form'),
					'mask'						=>	'min="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_disregard_on_zero'	=>	false,
					'type'						=>	'number',
					'type_advanced'				=>	'text',
					'help'						=>	__('Minimum value this field can have.', 'ws-form'),
					'select_list'				=>	true,
					'select_list_for_type'		=>	'text'
				),

				'max'						=> array(

					'label'						=>	__('Maximum', 'ws-form'),
					'mask'						=>	'max="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_disregard_on_zero'	=>	false,
					'type'						=>	'number',
					'type_advanced'				=>	'text',
					'help'						=>	__('Maximum value this field can have.', 'ws-form'),
					'select_list'				=>	true,
					'select_list_for_type'		=>	'text'
				),

				'min_date'						=> array(

					'label'						=>	__('Minimum', 'ws-form'),
					'mask'						=>	'min="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'datetime_min_max_basic',
					'type_advanced'				=>	'datetime_min_max_advanced',
					'help'						=>	__('Minimum date/time that can be chosen.', 'ws-form'),
					'select_list'				=>	true,
					'select_list_for_type'		=>	'datetime_min_max_advanced'
//					'calc'						=>	true,
//					'calc_for_type'				=>	'datetime_min_max_advanced'
				),

				'max_date'						=> array(

					'label'						=>	__('Maximum', 'ws-form'),
					'mask'						=>	'max="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'datetime_min_max_basic',
					'type_advanced'				=>	'datetime_min_max_advanced',
					'help'						=>	__('Maximum date/time that can be chosen.', 'ws-form'),
					'select_list'				=>	true,
					'select_list_for_type'		=>	'datetime_min_max_advanced'
//					'calc'						=>	true,
//					'calc_for_type'				=>	'datetime_min_max_advanced'
				),

				'year_start'						=> array(

					'label'						=>	__('Start Year', 'ws-form'),
					'mask'						=>	'data-year-start="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'number',
					'help'						=>	__('Defaults to 1950', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'input_type_datetime',
							'meta_value'		=>	'date'
						),

						array(

							'logic_previous'	=>	'||',
							'logic'				=>	'==',
							'meta_key'			=>	'input_type_datetime',
							'meta_value'		=>	'datetime-local'
						)
					)
				),

				'year_end'						=> array(

					'label'						=>	__('End Year', 'ws-form'),
					'mask'						=>	'data-year-end="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'number',
					'help'						=>	__('Defaults to 2050', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'input_type_datetime',
							'meta_value'		=>	'date'
						),

						array(

							'logic_previous'	=>	'||',
							'logic'				=>	'==',
							'meta_key'			=>	'input_type_datetime',
							'meta_value'		=>	'datetime-local'
						)
					)
				),

				'multiple'				=> array(

					'label'						=>	__('Multiple', 'ws-form'),
					'mask'						=>	'multiple',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'help'						=>	__('If checked, multiple options can be selected at once.', 'ws-form'),
					'default'					=>	''
				),

				'multiple_email'		=> array(

					'label'						=>	__('Multiple', 'ws-form'),
					'mask'						=>	'multiple',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked, multiple email addresses can be entered.', 'ws-form'),
				),
				'select2'				=> array(

					'label'						=>	__('Enable', 'ws-form'),
					'mask'						=>	'data-wsf-select2',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	''
				),

				'select2_ajax'				=> array(

					'label'						=>	__('Use AJAX', 'ws-form'),
					'type'						=>	'checkbox',
					'help'						=>	__('If checked, Select2 will retrieve data using AJAX. This can improve performance with larger datasets.', 'ws-form'),
					'default'					=>	'',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'select2',
							'meta_value'		=>	'on'
						),

						array(

							'logic_previous'	=>	'&&',
							'logic'				=>	'!=',
							'meta_key'			=>	'select_cascade',
							'meta_value'		=>	'on'
						),

						array(

							'logic_previous'	=>	'&&',
							'logic'				=>	'!=',
							'meta_key'			=>	'price_select_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'select2_intro'				=> array(

					'type'						=>	'html',
					'html'						=>	__('Enabling <a href="https://select2.org/" target="_blank">Select2</a> adds support for searching as well as pill boxes if multiple is enabled.', 'ws-form')
				),

				'multiple_file'		=> array(

					'label'						=>	__('Multiple', 'ws-form'),
					'mask'						=>	'multiple',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked, multiple files can be selected in the file picker.', 'ws-form'),
					'compatibility_id'			=>	'input-file-multiple',
				),

				'file_button_label'	=> array(

					'label'						=>	__('Button Label', 'ws-form'),
					'mask'						=>	'data-button-label="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	'Browse'
				),

				'file_preview' => array(

					'label'						=>	__('Enable', 'ws-form'),
					'mask'						=>	'data-preview',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'help'						=>	__('If checked, WS Form will show a preview of the file(s).', 'ws-form'),
					'default'					=>	''
				),

				'file_preview_width' => array(

					'label'						=>	__('Width', 'ws-form'),
					'type'						=>	'text',
					'help'						=>	__('Set the width of each file preview.', 'ws-form'),
					'default'					=>	'150px',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'orientation',
							'meta_value'		=>	'horizontal'
						)
					)
				),

				'file_image_max_width'	=> array(

					'label'						=>	__('Max Width (Pixels)', 'ws-form'),
					'type'						=>	'number',
					'min'						=>	1,
					'help'						=>	__('Enter the maximum width in pixels the saved file should be. Leave blank for no change.', 'ws-form')
				),

				'file_image_max_height'	=> array(

					'label'						=>	__('Max Height (Pixels)', 'ws-form'),
					'type'						=>	'number',
					'min'						=>	1,
					'help'						=>	__('Enter the maximum height in pixels the saved file should be. Leave blank for no change.', 'ws-form')
				),

				'file_image_crop'	=> array(

					'label'						=>	__('Crop', 'ws-form'),
					'type'						=>	'checkbox',
					'help'						=>	__('If checked, images will be cropped to the maximum dimensions above using center positions.', 'ws-form'),
					'default'					=>	''
				),

				'file_image_compression'	=> array(

					'label'						=>	__('Quality', 'ws-form'),
					'type'						=>	'number',
					'min'						=>	1,
					'max'						=>	100,
					'help'						=>	__('Sets image compression quality on a 1-100 scale. Leave blank for no change.', 'ws-form')
				),

				'file_image_mime'	=> array(

					'label'						=>	__('File Format', 'ws-form'),
					'type'						=>	'select',
					'help'						=>	__('Select the file format image uploads should be saved as.', 'ws-form'),
					'options'					=>	array(

						array('value' => '', 'text' => __('Same as original', 'ws-form')),
						array('value' => 'image/jpeg', 'text' => __('JPG', 'ws-form')),
						array('value' => 'image/png', 'text' => __('PNG', 'ws-form')),
						array('value' => 'image/gif', 'text' => __('GIF', 'ws-form'))
					)
				),

				'directory'		=> array(

					'label'						=>	__('Directory', 'ws-form'),
					'mask'						=>	'webkitdirectory mozdirectory',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Allow entire directory with file contents (and any subdirectories) to be selected.', 'ws-form'),
					'compatibility_id'			=>	'input-file-directory',
				),
				'input_mask'			=> array(

					'label'						=>	__('Input Mask', 'ws-form'),
					'mask'						=>	'data-inputmask="\'mask\': \'#value\'"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'help'						=>	__('Input mask for the field, e.g. (999) 999-9999', 'ws-form'),
					'select_list'				=>	array(

						array('text' => __('US/Canadian Phone Number', 'ws-form'), 'value' => '(999) 999-9999'),
						array('text' => __('US/Canadian Phone Number (International)', 'ws-form'), 'value' => '+1 (999) 999-9999'),
						array('text' => __('US Zip Code', 'ws-form'), 'value' => '99999'),
						array('text' => __('US Zip Code +4', 'ws-form'), 'value' => '99999[-9999]'),
						array('text' => __('Canadian Post Code', 'ws-form'), 'value' => 'A9A-9A9'),
						array('text' => __('Short Date', 'ws-form'), 'value' => '99/99/9999'),
						array('text' => __('Social Security Number', 'ws-form'), 'value' => '999-99-9999')
					)
				),

				'field_user_status'	=> array(

					'label'						=>	__('User Status', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	array(

						array('value' => '', 'text' => __('Any', 'ws-form')),
						array('value' => 'on', 'text' => __('Is Logged In', 'ws-form')),
						array('value' => 'out', 'text' => __('Is Logged Out', 'ws-form')),
						array('value' => 'role_capability', 'text' => __('Has User Role or Capability', 'ws-form'))
					),
					'help'						=>	__('Only show the field under certain user conditions.', 'ws-form')
				),

				'form_user_roles'			=> array(

					'label'						=>	__('User Role', 'ws-form'),
					'type'						=>	'select',
					'select2'					=>	true,
					'multiple'					=>	true,
					'placeholder'				=>	__('Select...'),
					'help'						=>	__('Only show this form if logged in user has one of these roles.', 'ws-form'),
					'options'					=>	array(),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'user_limit_logged_in',
							'meta_value'		=>	'role_capability'
						)
					)
				),

				'field_user_roles'			=> array(

					'label'						=>	__('User Role', 'ws-form'),
					'type'						=>	'select',
					'select2'					=>	true,
					'multiple'					=>	true,
					'placeholder'				=>	__('Select...'),
					'help'						=>	__('Only show this field if logged in user has one of these roles.', 'ws-form'),
					'options'					=>	array(),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'field_user_status',
							'meta_value'		=>	'role_capability'
						)
					)
				),

				'form_user_capabilities'	=> array(

					'label'						=>	__('User Capability', 'ws-form'),
					'type'						=>	'select',
					'select2'					=>	true,
					'multiple'					=>	true,
					'placeholder'				=>	__('Select...'),
					'help'						=>	__('Only show this form if logged in user has one of these capabilities.', 'ws-form'),
					'options'					=>	array(),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'user_limit_logged_in',
							'meta_value'		=>	'role_capability'
						)
					)
				),

				'field_user_capabilities'	=> array(

					'label'						=>	__('User Capability', 'ws-form'),
					'type'						=>	'select',
					'select2'					=>	true,
					'multiple'					=>	true,
					'placeholder'				=>	__('Select...'),
					'help'						=>	__('Only show this field if logged in user has one of these capabilities.', 'ws-form'),
					'options'					=>	array(),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'field_user_status',
							'meta_value'		=>	'role_capability'
						)
					)
				),

				'pattern'			=> array(

					'label'						=>	__('Pattern', 'ws-form'),
					'mask'						=>	'pattern="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'help'						=>	__('Regular expression value is checked against.', 'ws-form'),
					'select_list'				=>	array(

						array('text' => __('Alpha', 'ws-form'), 'value' => '^[a-zA-Z]+$'),
						array('text' => __('Alphanumeric', 'ws-form'), 'value' => '^[a-zA-Z0-9]+$'),
						array('text' => __('Color', 'ws-form'), 'value' => '^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$'),
						array('text' => __('Country Code (2 Character)', 'ws-form'), 'value' => '[A-Za-z]{2}'),
						array('text' => __('Country Code (3 Character)', 'ws-form'), 'value' => '[A-Za-z]{3}'),
						array('text' => __('Date (mm/dd)', 'ws-form'), 'value' => '(0[1-9]|1[012]).(0[1-9]|1[0-9]|2[0-9]|3[01])'),
						array('text' => __('Date (dd/mm)', 'ws-form'), 'value' => '(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012])'),
						array('text' => __('Date (mm.dd.yyyy)', 'ws-form'), 'value' => '(0[1-9]|1[012]).(0[1-9]|1[0-9]|2[0-9]|3[01]).[0-9]{4}'),
						array('text' => __('Date (dd.mm.yyyy)', 'ws-form'), 'value' => '(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}'),
						array('text' => __('Date (yyyy-mm-dd)', 'ws-form'), 'value' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))'),
						array('text' => __('Date (mm/dd/yyyy)', 'ws-form'), 'value' => '(?:(?:0[1-9]|1[0-2])[\/\\-. ]?(?:0[1-9]|[12][0-9])|(?:(?:0[13-9]|1[0-2])[\/\\-. ]?30)|(?:(?:0[13578]|1[02])[\/\\-. ]?31))[\/\\-. ]?(?:19|20)[0-9]{2}'),
						array('text' => __('Date (dd/mm/yyyy)', 'ws-form'), 'value' => '^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$'),
						array('text' => __('Email', 'ws-form'), 'value' => '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$'),
						array('text' => __('IP (Version 4)', 'ws-form'), 'value' => '^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$'),
						array('text' => __('IP (Version 6)', 'ws-form'), 'value' => '((^|:)([0-9a-fA-F]{0,4})){1,8}$'),
						array('text' => __('ISBN', 'ws-form'), 'value' => '(?:(?=.{17}$)97[89][ -](?:[0-9]+[ -]){2}[0-9]+[ -][0-9]|97[89][0-9]{10}|(?=.{13}$)(?:[0-9]+[ -]){2}[0-9]+[ -][0-9Xx]|[0-9]{9}[0-9Xx])'),
						array('text' => __('Latitude or Longitude', 'ws-form'), 'value' => '-?\d{1,3}\.\d+'),
						array('text' => __('MD5 Hash', 'ws-form'), 'value' => '[0-9a-fA-F]{32}'),
						array('text' => __('Numeric', 'ws-form'), 'value' => '^[0-9]+$'),
						array('text' => __('Password (Numeric, lower, upper)', 'ws-form'), 'value' => '^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$'),
						array('text' => __('Password (Numeric, lower, upper, min 8)', 'ws-form'), 'value' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}'),
						array('text' => __('Phone - General', 'ws-form'), 'value' => '[0-9+()-. ]+'),
						array('text' => __('Phone - UK', 'ws-form'), 'value' => '^\s*\(?(020[7,8]{1}\)?[ ]?[1-9]{1}[0-9{2}[ ]?[0-9]{4})|(0[1-8]{1}[0-9]{3}\)?[ ]?[1-9]{1}[0-9]{2}[ ]?[0-9]{3})\s*$'),
						array('text' => __('Phone - US: 123-456-7890', 'ws-form'), 'value' => '\d{3}[\-]\d{3}[\-]\d{4}'),
						array('text' => __('Phone - US: (123)456-7890', 'ws-form'), 'value' => '\([0-9]{3}\)[0-9]{3}-[0-9]{4}'),
						array('text' => __('Phone - US: (123) 456-7890', 'ws-form'), 'value' => '\([0-9]{3}\) [0-9]{3}-[0-9]{4}'),
						array('text' => __('Phone - US: Flexible', 'ws-form'), 'value' => '(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}'),
						array('text' => __('Postal Code (UK)', 'ws-form'), 'value' => '[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}'),
						array('text' => __('Price (1.23)', 'ws-form'), 'value' => '\d+(\.\d{2})?'),
						array('text' => __('Slug', 'ws-form'), 'value' => '^[a-z0-9-]+$'),
						array('text' => __('Time (hh:mm:ss)', 'ws-form'), 'value' => '(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}'),
						array('text' => __('URL', 'ws-form'), 'value' => 'https?://.+'),
						array('text' => __('Zip Code', 'ws-form'), 'value' => '(\d{5}([\-]\d{4})?)')						
					),
					'compatibility_id'			=>	'input-pattern'
				),

				'pattern_tel'			=> array(

					'label'						=>	__('Pattern', 'ws-form'),
					'mask'						=>	'pattern="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'help'						=>	__('Regular expression value is checked against.', 'ws-form'),
					'select_list'				=>	array(

						array('text' => __('Phone - General', 'ws-form'), 'value' => '[0-9+()-. ]+'),
						array('text' => __('Phone - UK', 'ws-form'), 'value' => '^\s*\(?(020[7,8]{1}\)?[ ]?[1-9]{1}[0-9{2}[ ]?[0-9]{4})|(0[1-8]{1}[0-9]{3}\)?[ ]?[1-9]{1}[0-9]{2}[ ]?[0-9]{3})\s*$'),
						array('text' => __('Phone - US: 123-456-7890', 'ws-form'), 'value' => '\d{3}[\-]\d{3}[\-]\d{4}'),
						array('text' => __('Phone - US: (123)456-7890', 'ws-form'), 'value' => '\([0-9]{3}\)[0-9]{3}-[0-9]{4}'),
						array('text' => __('Phone - US: (123) 456-7890', 'ws-form'), 'value' => '\([0-9]{3}\) [0-9]{3}-[0-9]{4}'),
						array('text' => __('Phone - US: Flexible', 'ws-form'), 'value' => '(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}')						
					),
					'compatibility_id'			=>	'input-pattern'
				),

				'pattern_date'			=> array(

					'label'						=>	__('Pattern', 'ws-form'),
					'mask'						=>	'pattern="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'help'						=>	__('Regular expression value is checked against.', 'ws-form'),
					'select_list'				=>	array(

						array('text' => __('mm.dd.yyyy', 'ws-form'), 'value' => '(0[1-9]|1[012]).(0[1-9]|1[0-9]|2[0-9]|3[01]).[0-9]{4}'),
						array('text' => __('dd.mm.yyyy', 'ws-form'), 'value' => '(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}'),
						array('text' => __('mm/dd/yyyy', 'ws-form'), 'value' => '(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d'),
						array('text' => __('dd/mm/yyyy', 'ws-form'), 'value' => '(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d'),
						array('text' => __('yyyy-mm-dd', 'ws-form'), 'value' => '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])'),
						array('text' => __('hh:mm:ss', 'ws-form'), 'value' => '(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}'),
						array('text' => __('yyyy-mm-ddThh:mm:ssZ', 'ws-form'), 'value' => '/([0-2][0-9]{3})\-([0-1][0-9])\-([0-3][0-9])T([0-5][0-9])\:([0-5][0-9])\:([0-5][0-9])(Z|([\-\+]([0-1][0-9])\:00))/')						
					),
					'compatibility_id'			=>	'input-pattern'
				),

				'placeholder'			=> array(

					'label'						=>	__('Placeholder', 'ws-form'),
					'mask'						=>	'placeholder="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'help'						=>	__('Short hint that describes the expected value of the input field.', 'ws-form'),
					'compatibility_id'			=>	'input-placeholder',
					'select_list'				=>	true,
					'calc_type'					=>	'field_placeholder'
				),

				'placeholder_row'			=> array(

					'label'						=>	__('First Row Placeholder (Blank for none)', 'ws-form'),
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'text',
					'default'					=>	__('Select...', 'ws-form'),
					'help'						=>	__('First value in the select pulldown.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'multiple',
							'meta_value'		=>	'on'
						)
					)
				),

				'readonly'				=> array(

					'label'						=>	__('Read Only', 'ws-form'),
					'mask'						=>	'readonly',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'data_change'				=>	array('event' => 'change', 'action' => 'update'),
					'default'					=>	'',
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'required',
							'meta_value'		=>	'on'
						),

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'disabled',
							'meta_value'		=>	'on',
							'logic_previous'	=>	'&&'
						)
					),
					'compatibility_id'			=>	'readonly-attr'
				),

				'readonly_on'				=> array(

					'label'						=>	__('Read Only', 'ws-form'),
					'mask'						=>	'readonly',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'on',
					'data_change'				=>	array('event' => 'change', 'action' => 'update'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'required',
							'meta_value'		=>	'on'
						),

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'disabled',
							'meta_value'		=>	'on',
							'logic_previous'	=>	'&&'
						)
					),
					'compatibility_id'			=>	'readonly-attr',
					'key'						=>	'readonly'
				),

				'scroll_to_top'				=> array(

					'label'						=>	__('Scroll To Top', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	array(

						array('value' => '', 'text' => __('None', 'ws-form')),
						array('value' => 'instant', 'text' => __('Instant', 'ws-form')),
						array('value' => 'smooth', 'text' => __('Smooth', 'ws-form'))
					)
				),

				'scroll_to_top_offset'		=> array(

					'label'						=>	__('Offset (Pixels)', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	'0',
					'help'						=>	__('Number of pixels to offset the final scroll position by. Useful for sticky headers, e.g. if your header is 100 pixels tall, enter 100 into this setting.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'scroll_to_top',
							'meta_value'		=>	''
						)
					)
				),

				'scroll_to_top_duration'	=> array(

					'label'						=>	__('Duration (ms)', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	'400',
					'help'						=>	__('Duration of the smooth scroll in ms.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'scroll_to_top',
							'meta_value'		=>	'smooth'
						)
					)
				),

				'required'				=> array(

					'label'						=>	__('Required', 'ws-form'),
					'mask'						=>	'required data-required aria-required="true"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'compatibility_id'			=>	'form-validation',
					'data_change'				=>	array('event' => 'change', 'action' => 'update'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'disabled',
							'meta_value'		=>	'on'
						),

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'readonly',
							'meta_value'		=>	'on',
							'logic_previous'	=>	'&&'
						)
					)
				),

				'required_on'			=> array(

					'label'						=>	__('Required', 'ws-form'),
					'mask'						=>	'required data-required aria-required="true"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'on',
					'compatibility_id'			=>	'form-validation',
					'key'						=>	'required',
					'data_change'				=>	array('event' => 'change', 'action' => 'update'),
					'condition'					=>	array(

						array(

							'logic'			=>	'!=',
							'meta_key'		=>	'disabled',
							'meta_value'	=>	'on'
						),

						array(

							'logic'			=>	'!=',
							'meta_key'		=>	'readonly',
							'meta_value'	=>	'on',
							'logic_previous'	=>	'&&'
						)
					)
				),
				
				'required_attribute_no'	=> array(

					'label'						=>	__('Required', 'ws-form'),
					'mask'						=>	'',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'compatibility_id'			=>	'form-validation',
					'data_change'				=>	array('event' => 'change', 'action' => 'update'),
					'key'						=>	'required'
				),

				'required_row'				=> array(

					'mask'						=>	'required data-required aria-required="true"',
					'mask_disregard_on_empty'	=>	true
				),

				'rows'						=> array(

					'label'						=>	__('Rows', 'ws-form'),
					'mask'						=>	'rows="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_disregard_on_zero'	=>	true,
					'type'						=>	'number',
					'help'						=>	__('Number of rows.', 'ws-form')
				),

				'size'						=> array(

					'label'						=>	__('Size', 'ws-form'),
					'mask'						=>	'size="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_disregard_on_zero'	=>	true,
					'type'						=>	'number',
					'attributes'				=>	array('min' => 0),
					'help'						=>	__('The number of visible options.', 'ws-form')
				),

				'select_all'				=> array(

					'label'						=>	__('Enable Select All', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Show a \'Select All\' option above the first row.', 'ws-form')
				),

				'select_all_label'			=> array(

					'label'						=>	__('Select All Label', 'ws-form'),
					'type'						=>	'text',
					'default'					=>	'',
					'placeholder'				=>	__('Select All', 'ws-form'),
					'help'						=>	__('Enter custom label for \'Select All\' row.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'select_all',
							'meta_value'		=>	'on'
						)
					),
				),

				'spellcheck'	=> array(

					'label'						=>	__('Spell Check', 'ws-form'),
					'mask'						=>	'spellcheck="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'select',
					'help'						=>	__('Spelling and grammar checking.', 'ws-form'),
					'options'					=>	array(

						array('value' => '', 		'text' => __('Browser default', 'ws-form')),
						array('value' => 'true', 	'text' => __('Enabled', 'ws-form')),
						array('value' => 'false', 	'text' => __('Disabled', 'ws-form'))
					),
					'compatibility_id'			=>	'spellcheck-attribute'
				),

				'step'						=> array(

					'label'						=>	__('Step', 'ws-form'),
					'mask'						=>	'step="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_disregard_on_zero'	=>	false,
					'type'						=>	'number',
					'help'						=>	__('Increment/decrement by this value.', 'ws-form')
				),

				// Fields - Sidebars
				'field_select'	=> array(

					'type'					=>	'field_select'
				),

				'form_history'	=> array(

					'type'					=>	'form_history'
				),

				'knowledgebase'	=> array(

					'type'					=>	'knowledgebase'
				),

				'contact'	=> array(

					'type'					=>	'contact'
				),

				'ws_form_field'					=> array(

					'label'						=>	__('Form Field', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form')
				),

				'ws_form_field_choice'		=> array(

					'label'						=>	__('Form Field', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_type'		=>	array('select', 'checkbox', 'radio'),
					'key'						=>	'ws_form_field'
				),

				'ws_form_field_file'		=> array(

					'label'						=>	__('Form Field', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_type'		=>	array('signature', 'file'),
					'key'						=>	'ws_form_field'
				),

				'ws_form_field_save'		=> array(

					'label'						=>	__('Form Field', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_attribute'	=>	array('submit_save'),
					'key'						=>	'ws_form_field'
				),

				'ws_form_field_edit'		=> array(

					'label'						=>	__('Form Field', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_attribute'	=>	array('submit_edit'),
					'key'						=>	'ws_form_field'
				),

				'ws_form_field_ecommerce_price_cart'	=> array(

					'label'						=>	__('Form Field', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_attribute'	=>	array('ecommerce_cart_price')
				),

				// Fields - Data grids
				'conditional'	=>	array(

					'label'					=>	__('Conditions', 'ws-form'),
					'type'					=>	'data_grid',
					'type_sub'				=>	'conditional',	// Sub type
					'read_only_header'		=>	true,
					'row_disabled'			=>	true,	// Is the disabled attribute supported on rows?
					'max_columns'			=>	1,		// Maximum number of columns
					'groups_label'			=>	false,	// Is the group label feature enabled?
					'groups_label_render'	=>	false,	// Is the group label render feature enabled?
					'groups_auto_group'		=>	false,	// Is auto group feature enabled?
					'groups_disabled'		=>	false,	// Is the group disabled attribute?
					'groups_group'			=>	false,	// Is the group mask supported?
					'field_wrapper'			=>	false,
					'upload_download'		=>	false,

					'default'			=>	array(

						// Config
						'rows_per_page'		=>	10,
						'group_index'		=>	0,
						'default'			=>	array(),

						// Columns
						'columns' => array(

							array('id' => 0, 'label' => __('Condition', 'ws-form')),
							array('id' => 1, 'label' => __('Data', 'ws-form')),
						),

						// Group
						'groups' => array(

							array(

								'label' 		=> __('Conditions', 'ws-form'),
								'page'			=> 0,
								'disabled'		=> '',
								'mask_group'	=> '',

								// Rows (Only injected for a new data grid, blank for new groups)
								'rows' 		=> array(
								)
							)
						)
					)
				),

				'action'	=>	array(

					'label'					=>	__('Actions', 'ws-form'),
					'type'					=>	'data_grid',
					'type_sub'				=>	'action',	// Sub type
					'read_only_header'		=>	true,
					'row_disabled'			=>	true,	// Is the disabled attribute supported on rows?
					'max_columns'			=>	1,		// Maximum number of columns
					'groups_label'			=>	false,	// Is the group label feature enabled?
					'groups_label_render'	=>	false,	// Is the group label render feature enabled?
					'groups_auto_group'		=>	false,	// Is auto group feature enabled?
					'groups_disabled'		=>	false,	// Is the group disabled attribute?
					'groups_group'			=>	false,	// Is the group mask supported?
					'field_wrapper'			=>	false,
					'upload_download'		=>	false,

					'default'			=>	array(

						// Config
						'rows_per_page'		=>	10,
						'group_index'		=>	0,
						'default'			=>	array(),

						// Columns
						'columns' => array(

							array('id' => 0, 'label' => __('Action', 'ws-form')),
							array('id' => 1, 'label' => __('Data', 'ws-form')),
						),

						// Group
						'groups' => array(

							array(

								'label' 		=> __('Actions', 'ws-form'),
								'page'			=> 0,
								'disabled'		=> '',
								'mask_group'	=> '',

								// Rows (Only injected for a new data grid, blank for new groups)
								'rows' 		=> array(
								)
							)
						)
					)
				),

				'data_source_id' => array(

					'label'						=>	__('Data Source', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	'data_source',
					'class_wrapper'				=>	'wsf-field-wrapper-header'
				),

				'data_source_recurrence' => array(

					'label'						=>	__('Update Frequency', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'hourly',
					'options'					=>	array(),
					'help'						=>	__('This setting only applies to published forms. Previews show data in real-time.')
				),

				'data_source_get' => array(

					'label'						=>	__('Get Data', 'ws-form'),
					'type'						=>	'button'
				),

				'data_grid_datalist'	=>	array(

					'label'					=>	__('Datalist', 'ws-form'),
					'type'					=>	'data_grid',
					'row_default'			=>	false,	// Is the default attribute supported on rows?
					'row_disabled'			=>	false,	// Is the disabled attribute supported on rows?
					'row_required'			=>	false,	// Is the required attribute supported on rows?
					'row_hidden'			=>	true,	// Is the hidden supported on rows?
					'groups_label'			=>	false,	// Is the group label feature enabled?
					'groups_label_render'	=>	false,	// Is the group label render feature enabled?
					'groups_auto_group'		=>	false,	// Is auto group feature enabled?
					'groups_disabled'		=>	false,	// Is the disabled attribute supported on groups?
					'groups_group'			=>	false,	// Can user add groups?
					'mask_group'			=>	false,	// Is the group mask supported?
					'field_wrapper'			=>	false,
					'upload_download'		=>	true,
					'compatibility_id'		=>	'datalist',

					'meta_key_value'		=>	'datalist_field_value',
					'meta_key_label'		=>	'datalist_field_text',
					'data_source'			=>	true,

					'default'			=>	array(

						// Config
						'rows_per_page'		=>	10,
						'group_index'		=>	0,
						'default'			=>	array(),

						// Columns
						'columns' => array(

							array('id' => 0, 'label' => __('Value', 'ws-form')),
							array('id' => 1, 'label' => __('Label', 'ws-form'))
						),

						// Group
						'groups' => array(

							array(

								'label' 		=> __('Values', 'ws-form'),
								'page'			=> 0,
								'disabled'		=> '',
								'mask_group'	=> '',

								// Rows (Only injected for a new data grid, blank for new groups)
								'rows' 		=> array()
							)
						)
					)
				),

				'datalist_field_value'	=> array(

					'label'						=>	__('Values', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_datalist',
					'default'					=>	0,
					'html_encode'				=>	true
				),

				'datalist_field_text'		=> array(

					'label'						=>	__('Labels', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_datalist',
					'default'					=>	1
				),

				'data_grid_select'	=>	array(

					'label'					=>	__('Options', 'ws-form'),
					'type'					=>	'data_grid',
					'row_default'			=>	true,	// Is the default attribute supported on rows?
					'row_disabled'			=>	true,	// Is the disabled attribute supported on rows?
					'row_required'			=>	false,	// Is the required attribute supported on rows?
					'row_hidden'			=>	true,	// Is the hidden supported on rows?
					'groups_label'			=>	true,	// Is the group label feature enabled?
					'groups_label_label'	=>	__('Label', 'ws-form'),
					'groups_label_render'	=>	false,	// Is the group label render feature enabled?
					'groups_label_render_label'	=>	__('Show Label', 'ws-form'),
					'groups_auto_group'		=>	true,	// Is auto group feature enabled?
					'groups_disabled'		=>	true,	// Is the group disabled attribute?
					'groups_group'			=>	true,	// Is the group mask supported?
					'groups_group_label'	=>	__('Wrap In Optgroup', 'ws-form'),

					'field_wrapper'			=>	false,
					'meta_key_value'			=>	'select_field_value',
					'meta_key_label'			=>	'select_field_label',
					'meta_key_parse_variable'	=>	'select_field_parse_variable',
					'data_source'			=>	true,

					'upload_download'		=>	true,

					'default'			=>	array(

						// Config
						'rows_per_page'		=>	10,
						'group_index'		=>	0,
						'default'			=>	array(),

						// Columns
						'columns' => array(

							array('id' => 0, 'label' => __('Label', 'ws-form')),
						),

						// Group
						'groups' => array(

							array(

								'label' 		=> __('Options', 'ws-form'),
								'page'			=> 0,
								'disabled'		=> '',
								'mask_group'	=> '',

								// Rows (Only injected for a new data grid, blank for new groups)
								'rows' 		=> array(
									array(

										'id'		=> 1,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Option 1', 'ws-form'))
									),
									array(

										'id'		=> 2,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Option 2', 'ws-form'))
									),
									array(

										'id'		=> 3,
										'default'	=> '',
										'disabled'	=> '',
										'required'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Option 3', 'ws-form'))
									)
								)
							)
						)
					)
				),

				'select_field_label'			=> array(

					'label'						=>	__('Labels', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_select',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for the option labels.', 'ws-form')
				),

				'select_field_value'			=> array(

					'label'						=>	__('Values', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_select',
					'default'					=>	0,
					'html_encode'				=>	true,
					'help'						=>	__('Choose which column to use for the option values. These values should be unique.', 'ws-form')
				),

				'select_field_parse_variable'	=> array(

					'label'						=>	__('Action Variables', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_select',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for variables in actions (e.g. #field or #email_submission in email or message actions).', 'ws-form')
				),

				'select_min'	=> array(

					'label'						=>	__('Minimum Selected', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	'',
					'min'						=>	0,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'multiple',
							'meta_value'		=>	'on'
						)
					)
				),

				'select_max'	=> array(

					'label'						=>	__('Maximum Selected', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	'',
					'min'						=>	0,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'multiple',
							'meta_value'		=>	'on'
						)
					)
				),

				'select_cascade'				=> array(

					'label'						=>	__('Enable', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Filter this data grid using a value from another field.', 'ws-form')
				),

				'select_cascade_field_id'		=> array(

					'label'						=>	__('Filter Value', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_type'		=>	array('select', 'price_select', 'checkbox', 'price_checkbox', 'radio', 'price_radio', 'range', 'price_range', 'text', 'number', 'rating'),
					'help'						=>	__('Select the field to use as the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'select_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'select_cascade_field_filter'	=> array(

					'label'						=>	__('Filter Column', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_select',
					'default'					=>	0,
					'help'						=>	__('Select the column to filter with the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'select_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'select_cascade_no_match' => array(

					'label'						=>	__('Show All If No Results', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked and the filter value does not match any data in your filter column, all options will be shown.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'select_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'select_cascade_option_text_no_rows' => array(

					'label'						=>	__('No Results Placeholder', 'ws-form'),
					'type'						=>	'text',
					'default'					=>	'',
					'placeholder'				=>	__('Select...'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'select_cascade',
							'meta_value'		=>	'on'
						),

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'select_cascade_no_match',
							'meta_value'		=>	'on',
							'logic_previous'	=>	'&&'
						)
					)
				),

				'select_cascade_ajax' => array(

					'label'						=>	__('Use AJAX', 'ws-form'),
					'type'						=>	'checkbox',
					'mask'						=>	'data-cascade-ajax',
					'mask_disregard_on_empty'	=>	true,
					'default'					=>	'',
					'help'						=>	__('If checked WS Form will retrieve data using AJAX. This can improve performance with larger datasets.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'select_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'select_cascade_ajax_option_text_loading' => array(

					'label'						=>	__('Loading Placeholder', 'ws-form'),
					'type'						=>	'text',
					'default'					=>	'',
					'placeholder'				=>	__('Loading...'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'select_cascade',
							'meta_value'		=>	'on'
						),

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'select_cascade_ajax',
							'meta_value'		=>	'on',
							'logic_previous'	=>	'&&'
						)
					)
				),

				'data_grid_checkbox'	=>	array(

					'label'					=>	__('Checkboxes', 'ws-form'),
					'type'					=>	'data_grid',
					'row_default'			=>	true,	// Is the default attribute supported on rows?
					'row_disabled'			=>	true,	// Is the disabled attribute supported on rows?
					'row_required'			=>	true,	// Is the required attribute supported on rows?
					'row_hidden'			=>	true,	// Is the hidden supported on rows?
					'row_default_multiple'	=>	true,	// Can multiple defaults be selected?
					'row_required_multiple'	=>	true,	// Can multiple requires be selected?
					'groups_label'			=>	true,	// Is the group label feature enabled?
					'groups_label_label'	=>	__('Label', 'ws-form'),
					'groups_label_render'	=>	true,	// Is the group label render feature enabled?
					'groups_label_render_label'	=>	__('Show Label', 'ws-form'),
					'groups_auto_group'		=>	true,	// Is auto group feature enabled?
					'groups_disabled'		=>	true,	// Is the group disabled attribute?
					'groups_group'			=>	true,	// Is the group mask supported?
					'groups_group_label'	=>	__('Wrap In Fieldset', 'ws-form'),

					'field_wrapper'				=>	false,
					'upload_download'			=>	true,
					'meta_key_value'			=>	'checkbox_field_value',
					'meta_key_label'			=>	'checkbox_field_label',
					'meta_key_parse_variable'	=>	'checkbox_field_parse_variable',
					'data_source'				=>	true,
					'insert_image'				=>	true,

					'default'			=>	array(

						// Config
						'rows_per_page'		=>	10,
						'group_index'		=>	0,
						'default'			=>	array(),

						// Columns
						'columns' => array(

							array('id' => 0, 'label' => __('Label', 'ws-form'))
						),

						// Group
						'groups' => array(

							array(

								'label' 		=> __('Checkboxes', 'ws-form'),
								'page'			=> 0,
								'disabled'		=> '',
								'mask_group'	=> '',
								'label_render'	=> 'on',

								// Rows (Only injected for a new data grid, blank for new groups)
								'rows' 		=> array(

									array(

										'id'		=> 1,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Checkbox 1', 'ws-form'))
									),
									array(

										'id'		=> 2,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Checkbox 2', 'ws-form'))
									),
									array(

										'id'		=> 3,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Checkbox 3', 'ws-form'))
									)
								)
							)
						)
					)
				),

				'checkbox_field_label'		=> array(

					'label'						=>	__('Labels', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_checkbox',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for the checkbox labels.', 'ws-form')
				),

				'checkbox_field_value'	=> array(

					'label'						=>	__('Values', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_checkbox',
					'default'					=>	0,
					'html_encode'				=>	true,
					'help'						=>	__('Choose which column to use for the checkbox values. These values should be unique.', 'ws-form')
				),

				'checkbox_field_parse_variable'			=> array(

					'label'						=>	__('Action Variables', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_checkbox',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for variables in actions (e.g. #field or #email_submission in email or message actions).', 'ws-form')
				),

				'checkbox_min'	=> array(

					'label'						=>	__('Minimum Checked', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	'',
					'min'						=>	0
				),

				'checkbox_max'	=> array(

					'label'						=>	__('Maximum Checked', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	'',
					'min'						=>	0,
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'select_all',
							'meta_value'		=>	'on'
						)
					)
				),

				'checkbox_cascade'				=> array(

					'label'						=>	__('Enable', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Filter this data grid using a value from another field.', 'ws-form')
				),

				'checkbox_cascade_field_id'		=> array(

					'label'						=>	__('Filter Value', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_type'		=>	array('select', 'price_select', 'checkbox', 'price_checkbox', 'radio', 'price_radio', 'range', 'price_range', 'text', 'number', 'rating'),
					'help'						=>	__('Select the field to use as the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'checkbox_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'checkbox_cascade_field_filter'	=> array(

					'label'						=>	__('Filter Column', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_checkbox',
					'default'					=>	0,
					'help'						=>	__('Select the column to filter with the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'checkbox_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'checkbox_cascade_no_match' => array(

					'label'						=>	__('Show All If No Results', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked and the filter value does not match any data in your filter column, all options will be shown.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'checkbox_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'data_grid_radio'	=>	array(

					'label'					=>	__('Radios', 'ws-form'),
					'type'					=>	'data_grid',
					'row_default'			=>	true,	// Is the default attribute supported on rows?
					'row_disabled'			=>	true,	// Is the disabled attribute supported on rows?
					'row_required'			=>	false,	// Is the required attribute supported on rows?
					'row_hidden'			=>	true,	// Is the hidden supported on rows?
					'row_default_multiple'	=>	false,	// Can multiple defaults be selected?
					'row_required_multiple'	=>	false,	// Can multiple requires be selected?
					'groups_label'			=>	true,	// Is the group label feature enabled?
					'groups_label_label'	=>	__('Label', 'ws-form'),
					'groups_label_render'	=>	true,	// Is the group label render feature enabled?
					'groups_label_render_label'	=>	__('Show Label', 'ws-form'),
					'groups_auto_group'		=>	true,	// Is auto group feature enabled?
					'groups_disabled'		=>	true,	// Is the group disabled attribute?
					'groups_group'			=>	true,	// Is the group mask supported?
					'groups_group_label'	=>	__('Wrap In Fieldset', 'ws-form'),

					'field_wrapper'			=>	false,
					'upload_download'		=>	true,
					'meta_key_value'			=>	'radio_field_value',
					'meta_key_label'			=>	'radio_field_label',
					'meta_key_parse_variable'	=>	'radio_field_parse_variable',
					'data_source'			=>	true,
					'insert_image'				=>	true,

					'default'			=>	array(

						// Config
						'rows_per_page'		=>	10,
						'group_index'		=>	0,
						'default'			=>	array(),

						// Columns
						'columns' => array(

							array('id' => 0, 'label' => __('Label', 'ws-form'))
						),

						// Group
						'groups' => array(

							array(

								'label' 		=> __('Radios', 'ws-form'),
								'page'			=> 0,
								'disabled'		=> '',
								'mask_group'	=> '',
								'label_render'	=> 'on',

								// Rows (Only injected for a new data grid, blank for new groups)
								'rows' 		=> array(

									array(

										'id'		=> 1,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Radio 1', 'ws-form'))
									),
									array(

										'id'		=> 2,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Radio 2', 'ws-form'))
									),
									array(

										'id'		=> 3,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Radio 3', 'ws-form'))
									)
								)
							)
						)
					)
				),

				'radio_field_label'				=> array(

					'label'						=>	__('Labels', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_radio',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for the radio labels.', 'ws-form')

				),

				'radio_field_value'				=> array(

					'label'						=>	__('Values', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_radio',
					'default'					=>	0,
					'html_encode'				=>	true,
					'help'						=>	__('Choose which column to use for the radio values. These values should be unique.', 'ws-form')
				),

				'radio_field_parse_variable'	=> array(

					'label'						=>	__('Action Variables', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_radio',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for variables in actions (e.g. #field or #email_submission in email or message actions).', 'ws-form')
				),

				'radio_cascade'				=> array(

					'label'						=>	__('Enable', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Filter this data grid using a value from another field.', 'ws-form')
				),

				'radio_cascade_field_id'		=> array(

					'label'						=>	__('Filter Value', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_type'		=>	array('select', 'price_select', 'checkbox', 'price_checkbox', 'radio', 'price_radio', 'range', 'price_range', 'text', 'number', 'rating'),
					'help'						=>	__('Select the field to use as the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'radio_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'radio_cascade_field_filter'	=> array(

					'label'						=>	__('Filter Column', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_radio',
					'default'					=>	0,
					'help'						=>	__('Select the column to filter with the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'radio_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'radio_cascade_no_match' => array(

					'label'						=>	__('Show All If No Results', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked and the filter value does not match any data in your filter column, all radios will be shown.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'radio_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'data_grid_rows_randomize'	=> array(

					'label'						=>	__('Randomize Rows', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	''
				),
				'data_grid_select_price'	=>	array(

					'label'					=>	__('Options', 'ws-form'),
					'type'					=>	'data_grid',
					'row_default'			=>	true,	// Is the default attribute supported on rows?
					'row_disabled'			=>	true,	// Is the disabled attribute supported on rows?
					'row_required'			=>	false,	// Is the required attribute supported on rows?
					'row_hidden'			=>	true,	// Is the hidden supported on rows?
					'groups_label'			=>	true,	// Is the group label feature enabled?
					'groups_label_label'	=>	__('Label', 'ws-form'),
					'groups_label_render'	=>	false,	// Is the group label render feature enabled?
					'groups_label_render_label'	=>	__('Show Label', 'ws-form'),
					'groups_auto_group'		=>	true,	// Is auto group feature enabled?
					'groups_disabled'		=>	true,	// Is the group disabled attribute?
					'groups_group'			=>	true,	// Is the group mask supported?
					'groups_group_label'	=>	__('Wrap In Optgroup', 'ws-form'),

					'field_wrapper'			=>	false,
					'upload_download'		=>	true,
					'meta_key_price'			=>	'select_price_field_price',
					'meta_key_value'			=>	'select_price_field_value',
					'meta_key_label'			=>	'select_price_field_label',
					'meta_key_parse_variable'	=>	'select_price_field_parse_variable',
					'data_source'			=>	true,

					'default'			=>	array(

						// Config
						'rows_per_page'		=>	10,
						'group_index'		=>	0,
						'default'			=>	array(),

						// Columns
						'columns' => array(

							array('id' => 0, 'label' => __('Label', 'ws-form')),
							array('id' => 1, 'label' => __('Price', 'ws-form')),
						),

						// Group
						'groups' => array(

							array(

								'label' 		=> __('Options', 'ws-form'),
								'page'			=> 0,
								'disabled'		=> '',
								'mask_group'	=> '',

								// Rows (Only injected for a new data grid, blank for new groups)
								'rows' 		=> array(
									array(

										'id'		=> 1,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Product 1', 'ws-form'), '1')
									),
									array(

										'id'		=> 2,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Product 2', 'ws-form'), '2')
									),
									array(

										'id'		=> 3,
										'default'	=> '',
										'disabled'	=> '',
										'required'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Product 3', 'ws-form'), '3')
									)
								)
							)
						)
					)
				),

				'select_price_field_label'	=> array(

					'label'						=>	__('Label', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_select_price',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for the option labels.', 'ws-form')
				),

				'select_price_field_value'		=> array(

					'label'						=>	__('Value', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_select_price',
					'default'					=>	0,
					'html_encode'				=>	true,
					'help'						=>	__('Choose which column to use for the option values. These values should be unique.', 'ws-form')
				),

				'select_price_field_price'		=> array(

					'label'						=>	__('Price', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_select_price',
					'default'					=>	1,
					'html_encode'				=>	true,
					'price'						=>	true,
					'help'						=>	__('Choose which column to use for the price.', 'ws-form')

				),

				'select_price_field_parse_variable'	=> array(

					'label'						=>	__('Action Variables', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_select_price',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for variables in actions (e.g. #field or #email_submission in email or message actions).', 'ws-form')
				),

				'price_select_cascade'				=> array(

					'label'						=>	__('Enable', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Filter this data grid using a value from another field.', 'ws-form')
				),

				'price_select_cascade_field_id'		=> array(

					'label'						=>	__('Filter Value', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_type'		=>	array('select', 'price_select', 'checkbox', 'price_checkbox', 'radio', 'price_radio', 'range', 'price_range', 'text', 'number', 'rating'),
					'help'						=>	__('Select the field to use as the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_select_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'price_select_cascade_field_filter'	=> array(

					'label'						=>	__('Filter Column', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_select_price',
					'default'					=>	0,
					'help'						=>	__('Select the column to filter with the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_select_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'price_select_cascade_no_match' => array(

					'label'						=>	__('Show All If No Results', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked and the filter value does not match any data in your filter column, all options will be shown.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_select_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'price_select_cascade_option_text_no_rows' => array(

					'label'						=>	__('No Results Placeholder', 'ws-form'),
					'type'						=>	'text',
					'default'					=>	'',
					'placeholder'				=>	__('Select...'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_select_cascade',
							'meta_value'		=>	'on'
						),

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_select_cascade_no_match',
							'meta_value'		=>	'',
							'logic_previous'	=>	'&&'
						)
					)
				),

				'price_select_cascade_ajax' => array(

					'label'						=>	__('Use AJAX', 'ws-form'),
					'type'						=>	'checkbox',
					'mask'						=>	'data-cascade-ajax',
					'mask_disregard_on_empty'	=>	true,
					'default'					=>	'',
					'help'						=>	__('If checked WS Form will retrieve data using AJAX. This can improve performance with larger datasets.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_select_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'price_select_cascade_ajax_option_text_loading' => array(

					'label'						=>	__('Loading Placeholder', 'ws-form'),
					'type'						=>	'text',
					'default'					=>	'',
					'placeholder'				=>	__('Loading...'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_select_cascade',
							'meta_value'		=>	'on'
						),

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_select_cascade_ajax',
							'meta_value'		=>	'on',
							'logic_previous'	=>	'&&'
						)
					)
				),

				'data_grid_checkbox_price'	=>	array(

					'label'					=>	__('Checkboxes', 'ws-form'),
					'type'					=>	'data_grid',
					'row_default'			=>	true,	// Is the default attribute supported on rows?
					'row_disabled'			=>	true,	// Is the disabled attribute supported on rows?
					'row_required'			=>	true,	// Is the required attribute supported on rows?
					'row_hidden'			=>	true,	// Is the hidden supported on rows?
					'row_default_multiple'	=>	true,	// Can multiple defaults be selected?
					'row_required_multiple'	=>	true,	// Can multiple requires be selected?
					'groups_label'			=>	true,	// Is the group label feature enabled?
					'groups_label_label'	=>	__('Label', 'ws-form'),
					'groups_label_render'	=>	true,	// Is the group label render feature enabled?
					'groups_label_render_label'	=>	__('Show Label', 'ws-form'),
					'groups_auto_group'		=>	true,	// Is auto group feature enabled?
					'groups_disabled'		=>	true,	// Is the group disabled attribute?
					'groups_group'			=>	true,	// Is the group mask supported?
					'groups_group_label'	=>	__('Wrap In Fieldset', 'ws-form'),

					'field_wrapper'				=>	false,
					'upload_download'			=>	true,
					'meta_key_price'			=>	'checkbox_price_field_price',
					'meta_key_value'			=>	'checkbox_price_field_value',
					'meta_key_label'			=>	'checkbox_price_field_label',
					'meta_key_parse_variable'	=>	'checkbox_price_field_parse_variable',
					'data_source'				=>	true,
					'insert_image'				=>	true,

					'default'			=>	array(

						// Config
						'rows_per_page'		=>	10,
						'group_index'		=>	0,
						'default'			=>	array(),

						// Columns
						'columns' => array(

							array('id' => 0, 'label' => __('Label', 'ws-form')),
							array('id' => 1, 'label' => __('Price', 'ws-form')),
						),

						// Group
						'groups' => array(

							array(

								'label' 		=> __('Checkboxes', 'ws-form'),
								'page'			=> 0,
								'disabled'		=> '',
								'mask_group'	=> '',
								'label_render'	=> 'on',

								// Rows (Only injected for a new data grid, blank for new groups)
								'rows' 		=> array(
									array(

										'id'		=> 1,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Product 1', 'ws-form'), '1')
									),
									array(

										'id'		=> 2,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Product 2', 'ws-form'), '2')
									),
									array(

										'id'		=> 3,
										'default'	=> '',
										'disabled'	=> '',
										'required'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Product 3', 'ws-form'), '3')
									)
								)
							)
						)
					)
				),

				'checkbox_price_field_label'		=> array(

					'label'						=>	__('Label', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_checkbox_price',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for the checkbox labels.', 'ws-form')
				),

				'checkbox_price_field_value'	=> array(

					'label'						=>	__('Value', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_checkbox_price',
					'default'					=>	0,
					'html_encode'				=>	true,
					'help'						=>	__('Choose which column to use for the checkbox values. These values should be unique.', 'ws-form')
				),

				'checkbox_price_field_price'		=> array(

					'label'						=>	__('Price', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_checkbox_price',
					'default'					=>	1,
					'html_encode'				=>	true,
					'price'						=>	true,
					'help'						=>	__('Choose which column to use for the price.', 'ws-form')

				),

				'checkbox_price_field_parse_variable'		=> array(

					'label'						=>	__('Action Variables', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_checkbox_price',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for variables in actions (e.g. #field or #email_submission in email or message actions).', 'ws-form')
				),

				'price_checkbox_cascade'				=> array(

					'label'						=>	__('Enable', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Filter this data grid using a value from another field.', 'ws-form')
				),

				'price_checkbox_cascade_field_id'		=> array(

					'label'						=>	__('Filter Value', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_type'		=>	array('select', 'price_select', 'checkbox', 'price_checkbox', 'radio', 'price_radio', 'range', 'price_range', 'text', 'number', 'rating'),
					'help'						=>	__('Select the field to use as the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_checkbox_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'price_checkbox_cascade_field_filter'	=> array(

					'label'						=>	__('Filter Column', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_checkbox',
					'default'					=>	0,
					'help'						=>	__('Select the column to filter with the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_checkbox_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'price_checkbox_cascade_no_match' => array(

					'label'						=>	__('Show All If No Results', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked and the filter value does not match any data in your filter column, all options will be shown.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_checkbox_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'data_grid_radio_price'	=>	array(

					'label'					=>	__('Radios', 'ws-form'),
					'type'					=>	'data_grid',
					'row_default'			=>	true,	// Is the default attribute supported on rows?
					'row_disabled'			=>	true,	// Is the disabled attribute supported on rows?
					'row_required'			=>	false,	// Is the required attribute supported on rows?
					'row_hidden'			=>	true,	// Is the hidden supported on rows?
					'row_default_multiple'	=>	false,	// Can multiple defaults be selected?
					'row_required_multiple'	=>	false,	// Can multiple requires be selected?
					'groups_label'			=>	true,	// Is the group label feature enabled?
					'groups_label_label'	=>	__('Label', 'ws-form'),
					'groups_label_render'	=>	true,	// Is the group label render feature enabled?
					'groups_label_render_label'	=>	__('Show Label', 'ws-form'),
					'groups_auto_group'		=>	true,	// Is auto group feature enabled?
					'groups_disabled'		=>	true,	// Is the group disabled attribute?
					'groups_group'			=>	true,	// Is the group mask supported?
					'groups_group_label'	=>	__('Wrap In Fieldset', 'ws-form'),

					'field_wrapper'				=>	false,
					'upload_download'			=>	true,
					'meta_key_price'			=>	'radio_price_field_price',
					'meta_key_value'			=>	'radio_price_field_value',
					'meta_key_label'			=>	'radio_price_field_label',
					'meta_key_parse_variable'	=>	'radio_price_field_parse_variable',
					'data_source'				=>	true,
					'insert_image'				=>	true,

					'default'			=>	array(

						// Config
						'rows_per_page'		=>	10,
						'group_index'		=>	0,
						'default'			=>	array(),

						// Columns
						'columns' => array(

							array('id' => 0, 'label' => __('Label', 'ws-form')),
							array('id' => 1, 'label' => __('Price', 'ws-form')),
						),

						// Group
						'groups' => array(

							array(

								'label' 		=> __('Radios', 'ws-form'),
								'page'			=> 0,
								'disabled'		=> '',
								'mask_group'	=> '',
								'label_render'	=> 'on',

								// Rows (Only injected for a new data grid, blank for new groups)
								'rows' 		=> array(
									array(

										'id'		=> 1,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Product 1', 'ws-form'), '1')
									),
									array(

										'id'		=> 2,
										'default'	=> '',
										'required'	=> '',
										'disabled'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Product 2', 'ws-form'), '2')
									),
									array(

										'id'		=> 3,
										'default'	=> '',
										'disabled'	=> '',
										'required'	=> '',
										'hidden'	=> '',
										'data'		=> array(__('Product 3', 'ws-form'), '3')
									)
								)
							)
						)
					)
				),

				'radio_price_field_label'		=> array(

					'label'						=>	__('Label', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_radio_price',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for the radio labels.', 'ws-form')
				),

				'radio_price_field_value'	=> array(

					'label'						=>	__('Value', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_radio_price',
					'default'					=>	0,
					'html_encode'				=>	true,
					'help'						=>	__('Choose which column to use for the radio values. These values should be unique.', 'ws-form')
				),

				'radio_price_field_price'		=> array(

					'label'						=>	__('Price', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_radio_price',
					'default'					=>	1,
					'html_encode'				=>	true,
					'price'						=>	true,
					'help'						=>	__('Choose which column to use for the price.', 'ws-form')
				),

				'radio_price_field_parse_variable'	=> array(

					'label'						=>	__('Action Variables', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_radio_price',
					'default'					=>	0,
					'help'						=>	__('Choose which column to use for variables in actions (e.g. #field or #email_submission in email or message actions).', 'ws-form')
				),

				'price_radio_cascade'				=> array(

					'label'						=>	__('Enable', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Filter this data grid using a value from another field.', 'ws-form')
				),

				'price_radio_cascade_field_id'		=> array(

					'label'						=>	__('Filter Value', 'ws-form'),
					'type'						=>	'select',
					'default'					=>	'',
					'options'					=>	'fields',
					'options_blank'				=>	__('Select...', 'ws-form'),
					'fields_filter_type'		=>	array('select', 'price_select', 'checkbox', 'price_checkbox', 'radio', 'price_radio', 'range', 'price_range', 'text', 'number', 'rating'),
					'help'						=>	__('Select the field to use as the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_radio_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'price_radio_cascade_field_filter'	=> array(

					'label'						=>	__('Filter Column', 'ws-form'),
					'type'						=>	'data_grid_field',
					'data_grid'					=>	'data_grid_radio_price',
					'default'					=>	0,
					'help'						=>	__('Select the column to filter with the filter value.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_radio_cascade',
							'meta_value'		=>	'on'
						)
					)
				),

				'price_radio_cascade_no_match' => array(

					'label'						=>	__('Show All If No Results', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked and the filter value does not match any data in your filter column, all radios will be shown.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'price_radio_cascade',
							'meta_value'		=>	'on'
						)
					)
				),
				// Email
				'exclude_email'	=> array(

					'label'						=>	__('Exclude From Emails', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('If checked, this field will not appear in emails containing the #email_submission variable.', 'ws-form')
				),

				'exclude_email_on'	=> array(

					'label'						=>	__('Exclude From Emails', 'ws-form'),
					'type'						=>	'checkbox',
					'default'					=>	'on',
					'help'						=>	__('If checked, this field will not appear in emails containing the #email_submission variable.', 'ws-form'),
					'key'						=>	'exclude_email'
				),

				// Custom attributes
				'custom_attributes'	=> array(

					'type'						=>	'repeater',
					'help'						=>	__('Add additional attributes to this field type.', 'ws-form'),
					'meta_keys'					=>	array(

						'custom_attribute_name',
						'custom_attribute_value'
					)
				),

				// Custom attributes - Name
				'custom_attribute_name'	=> array(

					'label'							=>	__('Name', 'ws-form'),
					'type'							=>	'text'
				),

				// Custom attributes - Value
				'custom_attribute_value'	=> array(

					'label'							=>	__('Value', 'ws-form'),
					'type'							=>	'text'
				),
				// Rating - Size
				'rating_max'	=> array(

					'label'						=>	__('Maximum Rating', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	5,
					'min'						=>	1
				),

				// Rating - Icon
				'rating_icon'	=> array(

					'label'						=>	__('Icon', 'ws-form'),
					'type'						=>	'select',
					'options'					=>	array(

						array('value' => 'check', 	'text' => __('Check', 'ws-form')),
						array('value' => 'circle', 	'text' => __('Circle', 'ws-form')),
						array('value' => 'flag', 	'text' => __('Flag', 'ws-form')),
						array('value' => 'heart', 	'text' => __('Heart', 'ws-form')),
						array('value' => 'smiley', 	'text' => __('Smiley', 'ws-form')),
						array('value' => 'square', 	'text' => __('Square', 'ws-form')),
						array('value' => 'star', 	'text' => __('Star', 'ws-form')),
						array('value' => 'thumb', 	'text' => __('Thumbs Up', 'ws-form')),
						array('value' => 'custom', 	'text' => __('Custom HTML', 'ws-form'))
					),
					'default'					=>	'star'
				),

				// Rating - Icon - HTML
				'rating_icon_html'				=> array(

					'label'						=>	__('HTML', 'ws-form'),
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'html_editor',
					'default'					=>	'<span>*</span>',
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'rating_icon',
							'meta_value'		=>	'custom'
						)
					),
					'help'						=>	__('Custom rating icon HTML.', 'ws-form')
				),

				// Rating - Size
				'rating_size'	=> array(

					'label'						=>	__('Size (Pixels)', 'ws-form'),
					'type'						=>	'number',
					'default'					=>	24,
					'min'						=>	1,
					'help'						=>	__('Size of unselected rating icons in pixels.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'rating_icon',
							'meta_value'		=>	'custom'
						)
					)
				),

				// Rating - Color - Off
				'rating_color_off'	=> array(

					'label'						=>	__('Unselected Color', 'ws-form'),
					'mask'						=>	'data-rating-color-off="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'color',
					'default'					=>	'#CECED2',
					'help'						=>	__('Color of unselected rating icons.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'rating_icon',
							'meta_value'		=>	'custom'
						)
					)
				),

				// Rating - Color - On
				'rating_color_on'	=> array(

					'label'						=>	__('Selected Color', 'ws-form'),
					'mask'						=>	'data-rating-color-on="#value"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'color',
					'default'					=>	'#FFCC00',
					'help'						=>	__('Color of selected rating icons.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'!=',
							'meta_key'			=>	'rating_icon',
							'meta_value'		=>	'custom'
						)
					)
				),
				'prepend'			=> array(

					'label'						=>	__('Prefix', 'ws-form'),
					'type'						=>	'text',
					'select_list'				=>	true,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'input_type_textarea',
							'meta_value'		=>	''
						)
					)
				),

				'append'			=> array(

					'label'						=>	__('Suffix', 'ws-form'),
					'type'						=>	'text',
					'select_list'				=>	true,
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'input_type_textarea',
							'meta_value'		=>	''
						)
					)
				),

				// No duplicates (Server side)
				'dedupe'	=> array(

					'label'						=>	__('No Submission Duplicates', 'ws-form'),
					'type'						=>	'checkbox',
					'help'						=>	__('If checked, WS Form will check for duplicates in existing submissions.', 'ws-form')
				),

				// No duplications - Message
				'dedupe_message'	=> array(

					'label'						=>	__('Duplication Message', 'ws-form'),
					'placeholder'				=>	__('The value entered for #label_lowercase has already been used.', 'ws-form'),
					'type'						=>	'textarea',
					'help'						=>	__('Enter a message to be shown if a duplicate value is entered for this field. Leave blank for the default message.', 'ws-form'),
					'condition'					=>	array(

						array(

							'logic'				=>	'==',
							'meta_key'			=>	'dedupe',
							'meta_value'		=>	'on'
						)
					)
				),

				// Value deduplication by scope (Client side)
				'dedupe_value_scope'	=> array(

					'label'						=>	__('No Duplicates in Repeatable Sections', 'ws-form'),
					'mask'						=>	'data-value-scope="repeatable-section"',
					'mask_disregard_on_empty'	=>	true,
					'type'						=>	'checkbox',
					'default'					=>	'',
					'help'						=>	__('Disable values already chosen in repeatable sections.', 'ws-form')
				),

				// Hidden (Never rendered but either have default values or are special attributes)
				'breakpoint'			=> array(

					'default'					=>	25
				),

				'tab_index'				=> array(

					'default'					=>	0
				),

				'list'					=> array(

					'mask'						=>	'list="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_disregard_on_zero'	=>	false,
				),

				'aria_label'			=> array(

					'label'						=>	__('ARIA Label', 'ws-form'),
					'mask'						=>	'aria-label="#value"',
					'mask_disregard_on_empty'	=>	true,
					'mask_placeholder'			=>	'#label',
					'compatibility_id'			=>	'wai-aria',
					'select_list'				=>	true
				),

				'aria_labelledby'		=> array(

					'mask'						=>	'aria-labelledby="#value"',
					'mask_disregard_on_empty'	=>	true
				),

				'aria_describedby'		=> array(

					'mask'						=>	'aria-describedby="#value"',
					'mask_disregard_on_empty'	=>	true
				),

				'class'					=> array(

					'mask'						=>	'class="#value"',
					'mask_disregard_on_empty'	=>	true,
				),

				'default'						=> array(

					'mask'						=>	'#value',
					'mask_disregard_on_empty'	=>	true,
				)
			);

			// Text editor types
			global $wp_version;
			if(version_compare($wp_version, '4.8', '>=')) {
				$meta_keys['input_type_textarea']['options'][] = array('value' => 'tinymce', 'text' => __('Visual Editor', 'ws-form'));
			}
			if(version_compare($wp_version, '4.9', '>=')) {
				$meta_keys['input_type_textarea']['options'][] = array('value' => 'html', 'text' => __('HTML Editor', 'ws-form'));
			}

			// Add mime types to accept
			$file_types = self::get_file_types();
			$mime_select_list = array();
			foreach($file_types as $mime_type => $file_type) {

				if($mime_type == 'default') { continue; }
				$mime_select_list[] = array('text' => $mime_type, 'value' => $mime_type);
			}
			usort($mime_select_list, function($a, $b) { if ($a['text'] == $b['text']) { return 0; } return ($a['text'] < $b['text']) ? -1 : 1; });
			$meta_keys['accept']['select_list'] = $mime_select_list;

			// Date format
			$date_formats = array_unique( apply_filters( 'date_formats', array( __( 'F j, Y' ), 'Y-m-d', 'm/d/Y', 'd/m/Y' ) ) );
			foreach($date_formats as $date_format) {

				$meta_keys['format_date']['options'][] = array('value' => esc_attr($date_format), 'text' => date_i18n($date_format));	
			}

			// Time format
			$time_formats = array_unique(apply_filters( 'time_formats', array(__( 'g:i a' ), 'g:i A', 'H:i')));
			foreach($time_formats as $time_format) {

				$meta_keys['format_time']['options'][] = array('value' => esc_attr($time_format), 'text' => date_i18n($time_format));	
			}

			// User roles
			$capabilities = array();
			$roles = get_editable_roles();
			usort($roles, function($role_a, $role_b) {

				return ($role_a['name'] == $role_b['name']) ? 0 : (($role_a['name'] < $role_b['name']) ? -1 : 1);
			});
			foreach ($roles as $role => $role_config) {

				$meta_keys['form_user_roles']['options'][] = array('value' => esc_attr($role), 'text' => esc_html(translate_user_role($role_config['name'])));
				$meta_keys['field_user_roles']['options'][] = array('value' => esc_attr($role), 'text' => esc_html(translate_user_role($role_config['name'])));

				$capabilities = array_merge($capabilities, array_keys($role_config['capabilities']));
			}

			// User capabilities
			$capabilities = array_unique($capabilities);
			sort($capabilities);
			foreach ($capabilities as $capability) {

				$meta_keys['form_user_capabilities']['options'][] = array('value' => esc_attr($capability), 'text' => esc_html($capability));
				$meta_keys['field_user_capabilities']['options'][] = array('value' => esc_attr($capability), 'text' => esc_html($capability));
			}

			// Data source update frequencies

			// Add real-time
			$meta_keys['data_source_recurrence']['options'][] = array('value' => 'wsf_realtime', 'text' => __('Real-Time'));

			// Get registered schedules
			$schedules = wp_get_schedules();

			// Order by interval
			uasort($schedules, function ($schedule_1, $schedule_2) {
				if ($schedule_1['interval'] == $schedule_2['interval']) return 0;
				return $schedule_1['interval'] < $schedule_2['interval'] ? -1 : 1;
			});

			// IDs to include (also includes any schedule ID's beginning with wsf_)
			$wordpress_schedule_ids = array('hourly', 'twicedaily', 'daily', 'weekly');

			// Process schedules
			foreach($schedules as $schedule_id => $schedule_config) {

				if(
					!in_array($schedule_id, $wordpress_schedule_ids) &&
					(strpos($schedule_id, WS_FORM_DATA_SOURCE_SCHEDULE_ID_PREFIX) === false)
				) {
					continue;
				}

				$meta_keys['data_source_recurrence']['options'][] = array('value' => esc_attr($schedule_id), 'text' => esc_html($schedule_config['display']));
			}

			// Apply filter
			$meta_keys = apply_filters('wsf_config_meta_keys', $meta_keys, $form_id);

			// Public parsing (To cut down on only output needed to render form
			if($public) {

				$public_attributes_public = array('key' => 'k', 'mask' => 'm', 'mask_disregard_on_empty' => 'e', 'mask_disregard_on_zero' => 'z', 'mask_placeholder' => 'p', 'html_encode' => 'h', 'price' => 'pr', 'default' => 'd', 'calc_type' => 'c');

				foreach($meta_keys as $key => $meta_key) {

					$meta_key_keep = false;

					foreach($public_attributes_public as $attribute => $attribute_public) {

						if(isset($meta_keys[$key][$attribute])) {

							$meta_key_keep = true;
							break;
						}
					}

					// Remove this meta key from public if it doesn't contain the keys we want for public
					if(!$meta_key_keep) { unset($meta_keys[$key]); }
				}

				$meta_keys_new = array();

				foreach($meta_keys as $key => $meta_key) {

					$meta_key_source = $meta_keys[$key];
					$meta_key_new = array();

					foreach($public_attributes_public as $attribute => $attribute_public) {

						if(isset($meta_key_source[$attribute])) {

							unset($meta_key_new[$attribute]);
							$meta_key_new[$attribute_public] = $meta_key_source[$attribute];
						}
					}

					$meta_keys_new[$key] = $meta_key_new;
				}

				$meta_keys = $meta_keys_new;
			}

			// Parse compatibility meta_keys
			if(!$public) {

				foreach($meta_keys as $key => $meta_key) {

					if(isset($meta_key['compatibility_id'])) {

						$meta_keys[$key]['compatibility_url'] = str_replace('#compatibility_id', $meta_key['compatibility_id'], WS_FORM_COMPATIBILITY_MASK);
						unset($meta_keys[$key]['compatibility_id']);
					}
				}
			}

			// Cache
			self::$meta_keys[$public] = $meta_keys;

			return $meta_keys;
		}

		// Configuration - Frameworks
		public static function get_frameworks($public = true) {

			// Check cache
			if(isset(self::$frameworks[$public])) { return self::$frameworks[$public]; }

			$frameworks = array(

				'types' => array(

					'ws-form' => array('name' => __('WS Form', 'ws-form')),
					'bootstrap3' => array('name' => __('Bootstrap 3.x', 'ws-form')),
					'bootstrap4' => array('name' => __('Bootstrap 4.0', 'ws-form')),
					'bootstrap41' => array('name' => __('Bootstrap 4.1-4.5.x', 'ws-form')),
					'bootstrap5' => array('name' => __('Bootstrap 5+', 'ws-form')),
					'foundation5' => array('name' => __('Foundation 5.x', 'ws-form')),
					'foundation6' => array('name' => __('Foundation 6.0-6.3.1', 'ws-form')),
					'foundation64' => array('name' => __('Foundation 6.4+', 'ws-form'))
				),

				// Auto detection of framework based on string searching in CSS files for a website
				'auto_detect'	=> array(

					// Exclude filenames containing the following strings
					'exclude_filenames' => array(

						'ws-form',
						'jquery',
						'plugins',
						'uploads',
						'wp-includes'
					),

					// Strings to look for in CSS for each framework type
					'types'	=> array(

						'bootstrap5'	=> array(

							'Bootstrap v5',
							'.form-check',
							'.form-file',
							'.form-range'
						),

						'bootstrap41'	=> array(

							'Bootstrap v4',
							'.col-form-label',
							'.form-control-plaintext',
							'.row',
							'.custom-range'
						),

						'bootstrap4'	=> array(

							'Bootstrap v4',
							'.col-form-label',
							'.form-control-plaintext',
							'.row'
						),

						'bootstrap3'	=> array(

							'Bootstrap v3',
							'.control-label',
							'.form-control-static'
						),

						'foundation64'	=> array(

							'.cell',
							'.grid-x',
							'.grid-y' 
						),

						'foundation6'	=> array(

							'.columns',
							'.hide-for-small-only'
						),

						'foundation5'	=> array(

							'.hide-for-small',
							'.tab-title'
						)				
					)
				)
			);

			// Load current framework
			$framework = WS_Form_Common::option_get('framework', 'ws-form');

			// Get file path and class name
			switch($framework) {

				case 'bootstrap3' :

					$framework_class_suffix = 'Bootstrap_3';
					break;

				case 'bootstrap4' :

					$framework_class_suffix = 'Bootstrap_4';
					break;

				case 'bootstrap41' :

					$framework_class_suffix = 'Bootstrap_4_1';
					break;

				case 'bootstrap5' :

					$framework_class_suffix = 'Bootstrap_5';
					break;

				case 'foundation5' :

					$framework_class_suffix = 'Foundation_5';
					break;

				case 'foundation6' :

					$framework_class_suffix = 'Foundation_6';
					break;

				case 'foundation64' :

					$framework_class_suffix = 'Foundation_64';
					break;

				default :

					$framework = 'ws-form';
					$framework_class_suffix = 'WS_Form';
			}

			// Get framework include file name
			$framework_include_file_name = sprintf('framework/class-ws-form-framework-%s.php', $framework);

			// Get framework class name
			$framework_class_name = sprintf('WS_Form_Config_Framework_%s', $framework_class_suffix);

			// Admin icons
			if(!$public) {

				$frameworks['icons'] = array(

					'25'	=>	self::get_icon_24_svg('bp-25'),
					'50'	=>	self::get_icon_24_svg('bp-50'),
					'75'	=>	self::get_icon_24_svg('bp-75'),
					'100'	=>	self::get_icon_24_svg('bp-100'),
					'125'	=>	self::get_icon_24_svg('bp-125'),
					'150'	=>	self::get_icon_24_svg('bp-150')
				);

				// Include WS Form framework regardless
				include_once sprintf('framework/class-ws-form-framework-ws-form.php', $framework);
				$ws_form_config_framework_ws_form = new WS_Form_Config_Framework_WS_Form();
				$frameworks['types']['ws-form'] = $ws_form_config_framework_ws_form->get_framework_config();

				// Include current framework
				if($framework !== 'ws-form') {

					include_once $framework_include_file_name;
					$ws_form_config_framework = new $framework_class_name();
					$frameworks['types'][$framework] = $ws_form_config_framework->get_framework_config();
				}

			} else {

				// Include current framework
				include_once $framework_include_file_name;
				$ws_form_config_framework = new $framework_class_name();
				$frameworks['types'][$framework] = $ws_form_config_framework->get_framework_config();
			}

			// Apply filter
			$frameworks = apply_filters('wsf_config_frameworks', $frameworks);

			// Cache
			self::$frameworks[$public] = $frameworks;

			return $frameworks;
		}

		// Get analytics
		public static function get_analytics() {

			$analytics = array(

				'google'	=>	array(

					'label'	=>	__('Google Analytics', 'ws-form'),

					'functions'	=> array(

						'gtag'	=> array(

							'label'		=>	'gtag',
							'log_found'	=>	'log_analytics_google_loaded_gtag_js',

							// Base 64 encoded function otherwise Google's tag assistant thinks this is actual javascript
							'analytics_event_function' => base64_encode("gtag('event','#action',{'event_category': '#category', 'event_label': '#label', 'value': '#value'});")
						),

						'ga'	=> array(

							'label'		=>	'analytics',
							'log_found'	=>	'log_analytics_google_loaded_analytics_js',

							// Base 64 encoded function otherwise Google's tag assistant thinks this is actual javascript
							'analytics_event_function' => base64_encode("ga('send','event','#action','#category','#label','#value');"),
						),

						'_gaq'	=> array(

							'label'		=>	'ga',
							'log_found'	=>	'log_analytics_google_loaded_ga_js',

							// Base 64 encoded function otherwise Google's tag assistant thinks this is actual javascript
							'analytics_event_function' => base64_encode("_gaq.push(['_trackEvent', '#action', '#category', '#label', '#value']);")
						),
					)
				),

				'facebook_standard'	=>	array(

					'label'	=>	__('Facebook (Standard)', 'ws-form'),

					'functions'	=> array(

						'fbq'	=> array(

							'label'		=>	'fbevents',
							'log_found'	=>	'log_analytics_facebook_loaded_fbevents_js',

							// Base 64 encoded function
							'analytics_event_function' => base64_encode("fbq('track','#event'#params);")
						)
					)
				),

				'facebook_custom'	=>	array(

					'label'	=>	__('Facebook (Custom)', 'ws-form'),

					'functions'	=> array(

						'fbq'	=> array(

							'label'		=>	'fbevents',
							'log_found'	=>	'log_analytics_facebook_loaded_fbevents_js',

							// Base 64 encoded function
							'analytics_event_function' => base64_encode("fbq('trackCustom','#event'#params);")
						)
					)
				),

				'linkedin'	=>	array(

					'label'	=>	__('LinkedIn (Insight Tag)', 'ws-form'),

					'functions'	=> array(

						'js'	=> array(

							'label'		=>	'insight',
							'log_found'	=>	'log_analytics_linkedin_loaded_insight_js',

							// Base 64 encoded function
							'analytics_event_function' => base64_encode("if(_linkedin_partner_id){var wsf_linkedin_img = document.createElement('img');wsf_linkedin_img.setAttribute('width', 1);wsf_linkedin_img.setAttribute('height', 1);wsf_linkedin_img.setAttribute('style', 'display:none;');wsf_linkedin_img.setAttribute('src', 'https://px.ads.linkedin.com/collect/?pid=' + _linkedin_partner_id + '&conversionId=#conversion_id&fmt=gif');document.body.appendChild(wsf_linkedin_img);}")
   						)
					)
				)
			);

			// Apply filter
			$analytics = apply_filters('wsf_config_analytics', $analytics);

			return $analytics;
		}

		// Get tracking
		public static function get_tracking($public = true) {

			// Check cache
			if(isset(self::$tracking[$public])) { return self::$tracking[$public]; }

			$tracking = array(

				'tracking_remote_ip'	=>	array(

					'label'				=>	__('Remote IP Address', 'ws-form'),
					'server_source'		=>	'http_env',
					'server_http_env'	=>	array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'),
					'type'				=>	'ip',
					'description'		=>	__('Stores the website visitors remote IP address, e.g. 123.45.56.789', 'ws-form')
				),

				'tracking_geo_location'	=>	array(

					'label'				=>	__('Location (By browser)', 'ws-form'),
					'server_source'		=>	'query_var',
					'server_query_var'	=>	'wsf_geo_location',
					'client_source'		=>	'geo_location',
					'type'				=>	'latlon',
					'description'		=>	__('If a website visitors device supports geo location (GPS) this option will prompt and request permission for that data and store the latitude and longitude to a submission.', 'ws-form')
				),

				'tracking_ip_lookup_latlon'	=>	array(

					'label'				=>	__('Location (By IP)', 'ws-form'),
					'server_source'		=>	'ip_lookup',
					'server_json_var'	=>	array('geoplugin_latitude', 'geoplugin_longitude'),
					'type'				=>	'latlon',
					'description'		=>	__('This will obtain an approximate latitude and longitude of a website visitor by their IP address.', 'ws-form')
				),

				'tracking_referrer'	=>	array(

					'label'				=>	__('Referrer', 'ws-form'),
					'server_source'		=>	'query_var',
					'server_query_var'	=>	'wsf_referrer',
					'client_source'		=>	'referrer',
					'type'				=>	'url',
					'description'		=>	__('Stores the web page address a website visitor was on prior to completing the submitted form.', 'ws-form')
				),

				'tracking_os'	=>	array(

					'label'				=>	__('Operating System', 'ws-form'),
					'server_source'		=>	'query_var',
					'server_query_var'	=>	'wsf_os',
					'client_source'		=>	'os',
					'type'				=>	'text',
					'description'		=>	__('Stores the website visitors operating system.', 'ws-form')
				),

				'tracking_agent'		=>	array(

					'label'				=>	__('Agent', 'ws-form'),
					'server_source'		=>	'http_env',
					'server_http_env'	=>	array('HTTP_USER_AGENT'),
					'type'				=>	'text',
					'description'		=>	__('Stores the website visitors agent (browser type).', 'ws-form')
				),

				'tracking_host'	=>	array(

					'label'				=>	__('Hostname', 'ws-form'),
					'server_source'		=>	'http_env',
					'server_http_env'	=>	array('HTTP_HOST', 'SERVER_NAME'),
					'client_source'		=>	'pathname',
					'type'				=>	'text',
					'description'		=>	__('Stores the server hostname.', 'ws-form')

				),

				'tracking_pathname'	=>	array(

					'label'				=>	__('Pathname', 'ws-form'),
					'server_source'		=>	'query_var',
					'server_query_var'	=>	'wsf_pathname',
					'client_source'		=>	'pathname',
					'type'				=>	'text',
					'description'		=>	__('Pathname of the URL.', 'ws-form')

				),

				'tracking_query_string'	=>	array(

					'label'				=>	__('Query String', 'ws-form'),
					'server_source'		=>	'query_var',
					'server_query_var'	=>	'wsf_query_string',
					'client_source'		=>	'query_string',
					'type'				=>	'text',
					'description'		=>	__('Query string of the URL.', 'ws-form')

				),

				'tracking_ip_lookup_city'	=>	array(

					'label'				=>	__('City (By IP)', 'ws-form'),
					'server_source'		=>	'ip_lookup',
					'server_json_var'	=>	'geoplugin_city',
					'type'				=>	'text',
					'description'		=>	__('When enabled, WS Form PRO will perform an IP lookup and obtain the city located closest to their approximate location.', 'ws-form')

				),

				'tracking_ip_lookup_region'	=>	array(

					'label'				=>	__('Region (By IP)', 'ws-form'),
					'server_source'		=>	'ip_lookup',
					'server_json_var'	=>	'geoplugin_region',
					'type'				=>	'text',
					'description'		=>	__('When enabled, WS Form PRO will perform an IP lookup and obtain the region located closest to their approximate location.', 'ws-form')
				),

				'tracking_ip_lookup_country'	=>	array(

					'label'				=>	__('Country (By IP)', 'ws-form'),
					'server_source'		=>	'ip_lookup',
					'server_json_var'	=>	'geoplugin_countryName',
					'type'				=>	'text',
					'description'		=>	__('When enabled, WS Form PRO will perform an IP lookup and obtain the country located closest to their approximate location.', 'ws-form')
				),

				'tracking_utm_source'	=>	array(

					'label'				=>	__('UTM Source', 'ws-form'),
					'server_source'		=>	'query_var',
					'server_query_var'	=>	'wsf_utm_source',
					'client_source'		=>	'query_var',
					'client_query_var'	=>	'utm_source',
					'type'				=>	'text',
					'description'		=>	__('This can be used to store the UTM (Urchin Tracking Module) source parameter.', 'ws-form')
				),

				'tracking_utm_medium'	=>	array(

					'label'				=>	__('UTM Medium', 'ws-form'),
					'server_source'		=>	'query_var',
					'server_query_var'	=>	'wsf_utm_medium',
					'client_source'		=>	'query_var',
					'client_query_var'	=>	'utm_medium',
					'type'				=>	'text',
					'description'		=>	__('This can be used to store the UTM (Urchin Tracking Module) medium parameter.', 'ws-form')
				),

				'tracking_utm_campaign'	=>	array(

					'label'				=>	__('UTM Campaign', 'ws-form'),
					'server_source'		=>	'query_var',
					'server_query_var'	=>	'wsf_utm_campaign',
					'client_source'		=>	'query_var',
					'client_query_var'	=>	'utm_campaign',
					'type'				=>	'text',
					'description'		=>	__('This can be used to store the UTM (Urchin Tracking Module) campaign parameter.', 'ws-form')
				),

				'tracking_utm_term'	=>	array(

					'label'				=>	__('UTM Term', 'ws-form'),
					'server_source'		=>	'query_var',
					'server_query_var'	=>	'wsf_utm_term',
					'client_source'		=>	'query_var',
					'client_query_var'	=>	'utm_term',
					'type'				=>	'text',
					'description'		=>	__('This can be used to store the UTM (Urchin Tracking Module) term parameter.', 'ws-form')
				),

				'tracking_utm_content'	=>	array(

					'label'				=>	__('UTM Content', 'ws-form'),
					'server_source'		=>	'query_var',
					'server_query_var'	=>	'wsf_utm_content',
					'client_source'		=>	'query_var',
					'client_query_var'	=>	'utm_content',
					'type'				=>	'text',
					'description'		=>	__('This can be used to store the UTM (Urchin Tracking Module) content parameter.', 'ws-form')
				)
			);

			// Apply filter
			$tracking = apply_filters('wsf_config_tracking', $tracking);

			// Public filtering
			if($public) {

				foreach($tracking as $key => $tracking_config) {

					if(!isset($tracking_config['client_source'])) {

						unset($tracking[$key]);

					} else {

						unset($tracking[$key]['label']);
						unset($tracking[$key]['description']);
						unset($tracking[$key]['type']);
					}
				}
			}

			// Cache
			self::$tracking[$public] = $tracking;

			return $tracking;
		}

		// Parse variables
		public static function get_parse_variables($public = true) {

			// Check cache
			if(isset(self::$parse_variables[$public])) { return self::$parse_variables[$public]; }

			// Get email logo
			$email_logo = '';
			$action_email_logo = intval(WS_Form_Common::option_get('action_email_logo'));
			$action_email_logo_size = WS_Form_Common::option_get('action_email_logo_size');
			if($action_email_logo_size == '') { $action_email_logo_size = 'full'; }
			if($action_email_logo > 0) {

				$email_logo = wp_get_attachment_image($action_email_logo, $action_email_logo_size);
			}

			// Get currency symbol
			$currencies = WS_Form_Config::get_currencies();
			$currency = WS_Form_Common::option_get('currency', WS_Form_Common::get_currency_default());
			$currency_found = isset($currencies[$currency]) && isset($currencies[$currency]['s']);
			$currency_symbol = $currency_found ? $currencies[$currency]['s'] : '$';
			// Parse variables
			$parse_variables = array(

				// Blog
				'blog'	=>	array(

					'label'		=> __('Blog', 'ws-form'),

					'variables'	=> array(

						'blog_url'			=> array('label' => __('URL', 'ws-form'), 'value' => get_bloginfo('url')),
						'blog_name'			=> array('label' => __('Name', 'ws-form'), 'value' => get_bloginfo('name')),
						'blog_language'		=> array('label' => __('Language', 'ws-form'), 'value' => get_bloginfo('language')),
						'blog_charset'		=> array('label' => __('Character Set', 'ws-form'), 'value' => get_bloginfo('charset')),
						'blog_admin_email'	=> array('label' => __('Admin Email', 'ws-form')),

						'blog_time' => array('label' => __('Current Time', 'ws-form'), 'value' => date(get_option('time_format'), current_time('timestamp')), 'description' => __('Returns the blog time in the format configured in WordPress.', 'ws-form')),

						'blog_date_custom' => array(

							'label' => __('Custom Date', 'ws-form'),

							'value' => date('Y-m-d H:i:s', current_time('timestamp')),

							'attributes' => array(

								array('id' => 'format', 'required' => false, 'default' => 'm/d/Y H:i:s'),
							),

							'kb_slug' => 'date-formats',

							'description' => __('Returns the blog date and time in a specified format (PHP date format).', 'ws-form')
						),

						'blog_date' => array('label' => __('Current Date', 'ws-form'), 'value' => date(get_option('date_format'), current_time('timestamp')), 'description' => __('Returns the blog date in the format configured in WordPress.', 'ws-form')),
					)
				),

				// Client
				'client'	=>	array(

					'label'		=>__('Client', 'ws-form'),

					'variables'	=> array(

						'client_time' => array('label' => __('Current Time', 'ws-form'), 'limit' => 'in client-side', 'description' => __('Returns the users web browser local time in the format configured in WordPress.', 'ws-form')),

						'client_date_custom' => array(

							'label' => __('Custom Date', 'ws-form'),

							'attributes' => array(

								array('id' => 'format', 'required' => false, 'default' => 'm/d/Y H:i:s'),
							),

							'kb_slug' => 'date-formats',

							'limit' => 'in client-side',

							'description' => __('Returns the users web browser local date and time in a specified format (PHP date format).', 'ws-form')
						),

						'client_date' => array('label' => __('Current Date', 'ws-form'), 'limit' => 'in client-side', 'description' => __('Returns the users web browser local date in the format configured in WordPress.', 'ws-form')),
					)
 				),

				// Server
				'server'	=>	array(

					'label'		=>__('Server', 'ws-form'),

					'variables'	=> array(

						'server_time' => array('label' => __('Current Time', 'ws-form'), 'value' => date(get_option('time_format')), 'description' => __('Returns the server time in the format configured in WordPress.', 'ws-form')),

						'server_date_custom' => array(

							'label' => __('Custom Date', 'ws-form'),

							'value' => date('Y-m-d H:i:s'),

							'attributes' => array(

								array('id' => 'format', 'required' => false, 'default' => 'm/d/Y H:i:s'),
							),

							'kb_slug' => 'date-formats',

							'description' => __('Returns the server date and time in a specified format (PHP date format).', 'ws-form')
						),

						'server_date' => array('label' => __('Current Date', 'ws-form'), 'value' => date(get_option('date_format')), 'description' => __('Returns the server date in the format configured in WordPress.', 'ws-form'))
					)
 				),

				// Form
				'form' 		=> array(

					'label'		=> __('Form', 'ws-form'),

					'variables'	=> array(

						'form_obj_id'		=>	array('label' => __('DOM Selector ID', 'ws-form')),
						'form_label'		=>	array('label' => __('Label', 'ws-form')),
						'form_hash'			=>	array('label' => __('Session ID', 'ws-form')),
						'form_instance_id'	=>	array('label' => __('Instance ID', 'ws-form')),
						'form_id'			=>	array('label' => __('ID', 'ws-form')),
						'form_framework'	=>	array('label' => __('Framework', 'ws-form')),
						'form_checksum'		=>	array('label' => __('Checksum', 'ws-form')),
					)
				),

				// Submit
				'submit' 		=> array(

					'label'		=> __('Submission', 'ws-form'),

					'variables'	=> array(

						'submit_id'			=>	array('label' => __('ID', 'ws-form')),
						'submit_hash'		=>	array('label' => __('Hash', 'ws-form')),
						'submit_user_id'	=>	array('label' => __('User ID', 'ws-form')),
						'submit_admin_url'	=>	array('label' => __('Link to submission in WordPress admin', 'ws-form'))
					)
				),

				// Skin
				'skin'			=> array(

					'label'		=> __('Skin', 'ws-form'),

					'variables' => array(

						// Color
						'skin_color_default'		=>	array('label' => __('Color - Default', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_default')),
						'skin_color_default_inverted'		=>	array('label' => __('Color - Default (Inverted)', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_default_inverted')),
						'skin_color_default_light'		=>	array('label' => __('Color - Default (Light)', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_default_light')),
						'skin_color_default_lighter'		=>	array('label' => __('Color - Default (Lighter)', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_default_lighter')),
						'skin_color_default_lightest'		=>	array('label' => __('Color - Default (Lightest)', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_default_lightest')),
						'skin_color_primary'		=>	array('label' => __('Color - Primary', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_primary')),
						'skin_color_secondary'		=>	array('label' => __('Color - Secondary', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_secondary')),
						'skin_color_success'		=>	array('label' => __('Color - Success', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_success')),
						'skin_color_information'		=>	array('label' => __('Color - Information', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_information')),
						'skin_color_warning'		=>	array('label' => __('Color - Warning', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_warning')),
						'skin_color_danger'		=>	array('label' => __('Color - Danger', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_color_danger')),

						// Font
						'skin_font_family'		=>	array('label' => __('Font - Family', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_font_family')),
						'skin_font_size'		=>	array('label' => __('Font - Size', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_font_size')),
						'skin_font_size_large'		=>	array('label' => __('Font - Size (Large)', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_font_size_large')),
						'skin_font_size_small'		=>	array('label' => __('Font - Size (Small)', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_font_size_small')),
						'skin_font_weight'		=>	array('label' => __('Font - Weight', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_font_weight')),
						'skin_line_height'		=>	array('label' => __('Line Height', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_line_height')),

						// Border
						'skin_border_width'		=>	array('label' => __('Border - Width', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_border_width')),
						'skin_border_style'		=>	array('label' => __('Border - Style', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_border_style')),
						'skin_border_radius'		=>	array('label' => __('Border - Style', 'ws-form'), 'kb_slug' => 'customize-appearance', 'value' => WS_Form_Common::option_get('skin_border_radius'))
					)
				),
				// Progress
				'progress' 		=> array(

					'label'		=> __('Progress', 'ws-form'),

					'variables'	=> array(

						'progress'						=>	array('label' => __('Number (0 to 100)', 'ws-form'), 'limit' => __('in the Help setting for Progress fields', 'ws-form'), 'kb_slug' => 'progress'),
						'progress_percent'				=>	array('label' => __('Percent (0% to 100%)', 'ws-form'), 'limit' => __('in the Help setting for Progress fields', 'ws-form'), 'kb_slug' => 'progress'),
						'progress_remaining'			=>	array('label' => __('Number Remaining (100 to 0)', 'ws-form'), 'limit' => __('in the Help setting for Progress fields', 'ws-form'), 'kb_slug' => 'progress'),
						'progress_remaining_percent'	=>	array('label' => __('Percent Remaining (100% to 0%)', 'ws-form'), 'limit' => __('in the Help setting for Progress fields', 'ws-form'), 'kb_slug' => 'progress')
					)
				),

				// E-Commerce
				'ecommerce' 	=> array(

					'label'		=> __('E-Commerce', 'ws-form'),

					'variables'	=> array(

						'ecommerce_currency_symbol'		=>	array(

							'label' => __('Currency Symbol', 'ws-form'),

							'value' => $currency_symbol,

							'description' => __('Use this variable to show the current currency symbol.', 'ws-form')
						),

						'ecommerce_field_price'			=>	array(

							'label' => __('Field Value as Price', 'ws-form'),

							'attributes' => array(

								array('id' => 'id'),
							),

							'description' => __('Use this variable to insert the value of a price field on your form. For example: <code>#field(123)</code> where \'123\' is the field ID shown in the layout editor. This variable will neatly format a currency value according to your E-Commerce settings. An example output might be: 123.00', 'ws-form')
						),

						'ecommerce_price'			=>	array(

							'label' => __('Value as Price', 'ws-form'),

							'attributes' => array(

								array('id' => 'number'),
							),

							'description' => __('Convert the number input to a price that matches the configured e-commerce currency settings.', 'ws-form')
						)
					)
				),
				// Section
				'section' 	=> array(

					'label'		=> __('Section', 'ws-form'),

					'variables'	=> array(

						'section_row_count'	=>	array(

							'label' => __('Section Row Count', 'ws-form'),

							'attributes' => array(

								array('id' => 'id'),
							),

							'description' => __('This variable returns the total number of rows in a repeatable section.', 'ws-form')
						),
					)
				),

				// Time
				'seconds' 	=> array(

					'label'		=> __('Seconds', 'ws-form'),

					'variables'	=> array(

						'seconds_epoch' => array('label' => __('Seconds since Epoch', 'ws-form'), 'value' => date('U'), 'description' => __('Returns the number of seconds since the Unix Epoch (January 1 1970 00:00:00 GMT).', 'ws-form')),

						'seconds_minute' => array('label' => __('Seconds in a minute', 'ws-form'), 'value' => '60', 'description' => __('Returns the number of seconds in a minute.', 'ws-form')),

						'seconds_hour' => array('label' => __('Seconds in an hour', 'ws-form'), 'value' => '3600', 'description' => __('Returns the number of seconds in an hour.', 'ws-form')),

						'seconds_day' => array('label' => __('Seconds in a day', 'ws-form'), 'value' => '86400', 'description' => __('Returns the number of seconds in a day.', 'ws-form')),

						'seconds_week' => array('label' => __('Seconds in a week', 'ws-form'), 'value' => '604800', 'description' => __('Returns the number of seconds in a week.', 'ws-form')),

						'seconds_year' => array('label' => __('Seconds in a year', 'ws-form'), 'value' => '31536000', 'description' => __('Returns the number of seconds in a year.', 'ws-form'))
					)
				),
				// Calculated
				'calc' 	=> array(

					'label'		=> __('Calculation', 'ws-form'),

					'variables'	=> array(

						'calc'			=>	array(

							'label' => __('Calculation', 'ws-form'),

							'attributes' => array(

								array('id' => 'calculation', 'required' => false),
							),

							'description' => __('Calculated value.', 'ws-form')
						)
					),

					'priority' => 100
				),
				// Math
				'math' 	=> array(

					'label'		=> __('Math', 'ws-form'),

					'variables'	=> array(

						'abs'			=>	array(

							'label' => __('Absolute', 'ws-form'),

							'attributes' => array(

								array('id' => 'number', 'required' => false),
							),

							'description' => __('Returns the absolute value of a number.', 'ws-form')
						),

						'ceil'			=>	array(

							'label' => __('Ceiling', 'ws-form'),

							'attributes' => array(

								array('id' => 'number', 'required' => false),
							),

							'description' => __('Rounds a number up to the next largest whole number.', 'ws-form')
						),

						'cos'			=>	array(

							'label' => __('Cosine', 'ws-form'),

							'attributes' => array(

								array('id' => 'radians', 'required' => false),
							),

							'description' => __('Returns the cosine of a radian number.', 'ws-form')
						),

						'exp'			=>	array(

							'label' => __("Euler's", 'ws-form'),

							'attributes' => array(

								array('id' => 'number', 'required' => false),
							),

							'description' => __('Returns E to the power of a number.', 'ws-form')
						),

						'floor'			=>	array(

							'label' => __("Floor", 'ws-form'),

							'attributes' => array(

								array('id' => 'number', 'required' => false),
							),

							'description' => __('Returns the largest integer value that is less than or equal to a number.', 'ws-form')
						),

						'log'			=>	array(

							'label' => __('Logarithm', 'ws-form'),

							'attributes' => array(

								array('id' => 'number', 'required' => false),
							),

							'description' => __('Returns the natural logarithm of a number.', 'ws-form')
						),

						'round'			=>	array(

							'label' => __('Round', 'ws-form'),

							'attributes' => array(

								array('id' => 'number', 'required' => false),
								array('id' => 'decimals', 'required' => false)
							),

							'description' => __('Returns the rounded value of a number.', 'ws-form')
						),

						'sin'			=>	array(

							'label' => __('Sine', 'ws-form'),

							'attributes' => array(

								array('id' => 'radians', 'required' => false)
							),

							'description' => __('Returns the sine of a radian number.', 'ws-form')
						),

						'sqrt'			=>	array(

							'label' => __('Square Root', 'ws-form'),

							'attributes' => array(

								array('id' => 'number', 'required' => false)
							),

							'description' => __('Returns the square root of the number.', 'ws-form')
						),

						'tan'			=>	array(

							'label' => __('Tangent', 'ws-form'),

							'attributes' => array(

								array('id' => 'radians', 'required' => false)
							),

							'description' => __('Returns the tangent of a radian number.', 'ws-form')
						),

						'avg'			=>	array(

							'label' => __('Average', 'ws-form'),

							'attributes' => array(

								array('id' => 'number', 'recurring' => true)
							),

							'description' => __('Returns the average of all the input numbers.', 'ws-form')
						),

						'pi'			=>	array(

							'label' => __('PI', 'ws-form'),

							'value' => M_PI,

							'description' => __('Returns an approximate value of PI.', 'ws-form')
						),

						'pow'			=>	array(

							'label' => __('Base to the Exponent Power', 'ws-form'),

							'attributes' => array(

								array('id' => 'base'),
								array('id' => 'exponent')
							),

							'description' => __('Returns the base to the exponent power.', 'ws-form')
						),

						'avg'			=>	array(

							'label' => __('Average', 'ws-form'),

							'attributes' => array(

								array('id' => 'number')
							),

							'description' => __('Returns the average of all the input numbers.', 'ws-form')
						)
					),

					'ignore_prefix' => true,

					'priority' => 50
				),

				// Field
				'field' 	=> array(

					'label'		=> __('Field', 'ws-form'),

					'variables'	=> array(

						'field'			=>	array(

							'label' => __('Field Value', 'ws-form'),

							'attributes' => array(

								array('id' => 'id'),
							),

							'description' => __('Use this variable to insert the value of a field on your form. For example: <code>#field(123)</code> where \'123\' is the field ID shown in the layout editor.', 'ws-form')
						),
					)
				),

				// Data grid rows
				'data_grid_row'	=> array(

					'label'		=> __('Data Grid Rows', 'ws-form'),

					'variables'	=> array(

						'data_grid_row_value'	=>	array(

							'label' => __('Value Column', 'ws-form'),

							'description' => __('Use this variable within a data grid row to insert the text found in the value column.', 'ws-form'),

							'limit' => 'within a data grid row'
						),

						'data_grid_row_label'	=>	array(

							'label' => __('Label Column', 'ws-form'),

							'description' => __('Use this variable within a data grid row to insert the text found in the label column.', 'ws-form'),

							'limit' => 'within a data grid row'
						),

						'data_grid_row_action_variable'	=>	array(

							'label' => __('Action Variable Column', 'ws-form'),

							'description' => __('Use this variable within a data grid row to insert the text found in the action variable column.', 'ws-form'),

							'limit' => 'within a data grid row'
						),

						'data_grid_row_price'	=>	array(

							'label' => __('Price Column', 'ws-form'),

							'description' => __('Use this variable within a data grid row to insert the text found in the price column.', 'ws-form'),

							'limit' => 'within a data grid row'
						),

						'data_grid_row_price_currency'	=>	array(

							'label' => __('Price Column (With Currency)', 'ws-form'),

							'description' => __('Use this variable within a data grid row to insert the text found in the price column formatted using the currency settings.', 'ws-form'),

							'limit' => 'within a data grid row'
						),

						'data_grid_row_wocommerce_Cart'	=>	array(

							'label' => __('WooCommerce Cart Column', 'ws-form'),

							'description' => __('Use this variable within a data grid row to insert the text found in the WooCommerce cart column.', 'ws-form'),

							'limit' => 'within a data grid row'
						)
					)
				),

				// Select option text
				'select' 	=> array(

					'label'		=> __('Select', 'ws-form'),

					'variables'	=> array(

						'select_option_text'			=>	array(

							'label' => __('Select Option Text', 'ws-form'),

							'attributes' => array(

								array('id' => 'id'),
								array('id' => 'delimiter', 'required' => false, 'trim' => false)
							),

							'description' => __('Use this variable to insert the selected option text of a select field on your form. For example: <code>#select_option_text(123)</code> where \'123\' is the field ID shown in the layout editor.', 'ws-form'),

							'limit' => 'in client-side'
						)
					)
				),

				// Checkbox label
				'checkbox' 	=> array(

					'label'		=> __('Checkbox', 'ws-form'),

					'variables'	=> array(

						'checkbox_label'	=>	array(

							'label' => __('Checkbox Label', 'ws-form'),

							'attributes' => array(

								array('id' => 'id'),
								array('id' => 'delimiter', 'required' => false, 'trim' => false)
							),

							'description' => __('Use this variable to insert the label of a checkbox field on your form. For example: <code>#checkbox_label(123)</code> where \'123\' is the field ID shown in the layout editor.', 'ws-form'),

							'limit' => 'in client-side'
						)
					)
				),

				// Radio label
				'radio' 	=> array(

					'label'		=> __('Radio', 'ws-form'),

					'variables'	=> array(

						'radio_label'	=>	array(

							'label' => __('Radio Label', 'ws-form'),

							'attributes' => array(

								array('id' => 'id'),
								array('id' => 'delimiter', 'required' => false, 'trim' => false)
							),

							'description' => __('Use this variable to insert the label of a radio field on your form. For example: <code>#radio_label(123)</code> where \'123\' is the field ID shown in the layout editor.', 'ws-form'),

							'limit' => 'in client-side'
						)
					)
				),

				// Email
				'email' 	=> array(

					'label'		=> __('Email', 'ws-form'),

					'variables'	=> array(

						'email_subject'			=>	array('label' => __('Subject', 'ws-form'), 'limit' => __('in the Send Email action', 'ws-form'), 'kb_slug' => 'send-email'),
						'email_content_type'	=>	array('label' => __('Content type', 'ws-form'), 'limit' => __('in the Send Email action', 'ws-form'), 'kb_slug' => 'send-email'),
						'email_charset'			=>	array('label' => __('Character set', 'ws-form'), 'limit' => __('in the Send Email action', 'ws-form'), 'kb_slug' => 'send-email'),
						'email_submission'		=>	array(

							'label' => __('Submitted Fields', 'ws-form'),

							'attributes' => array(

								array('id' => 'tab_labels', 'required' => false, 'default' => WS_Form_Common::option_get('action_email_group_labels', 'auto'), 'valid' => array('true', 'false', 'auto')),
								array('id' => 'section_labels', 'required' => false, 'default' => WS_Form_Common::option_get('action_email_section_labels', 'auto'), 'valid' => array('true', 'false', 'auto')),
								array('id' => 'field_labels', 'required' => false, 'default' => WS_Form_Common::option_get('action_email_field_labels', 'true'), 'valid' => array('true', 'false', 'auto')),
								array('id' => 'blank_fields', 'required' => false, 'default' => (WS_Form_Common::option_get('action_email_exclude_empty') ? 'false' : 'true'), 'valid' => array('true', 'false')),
								array('id' => 'static_fields', 'required' => false, 'default' => (WS_Form_Common::option_get('action_email_static_fields') ? 'true' : 'false'), 'valid' => array('true', 'false')),
							),

							'kb_slug' => 'send-email',

							'limit' => __('in the Send Email action', 'ws-form'),

							'description' => __('This variable outputs a list of the fields captured during a submission. You can either use: <code>#email_submission</code> or provide additional parameters to toggle tab labels, section labels, blank fields and static fields (such as text or HTML areas of your form). Specify \'true\' or \'false\' for each parameter, for example: <code>#email_submission(true, true, false, true)</code>', 'ws-form')
						),
						'email_ecommerce'		=>	array(

							'label' => __('E-Commerce Values', 'ws-form'),

							'kb_slug' => 'e-commerce',

							'limit' => __('in the Send Email action', 'ws-form'),

							'description' => __('This variable outputs a list of the e-commerce transaction details such as total, transaction ID and status fields.', 'ws-form')
						),
						'email_tracking'		=>	array('label' => __('Tracking data', 'ws-form'), 'limit' => __('in the Send Email action', 'ws-form'), 'kb_slug' => 'send-email'),
						'email_logo'			=>	array('label' => __('Logo', 'ws-form'), 'value' => $email_logo, 'limit' => __('in the Send Email action', 'ws-form'), 'kb_slug' => 'send-email'),
						'email_pixel'			=>	array('label' => __('Pixel'), 'value' => '<img src="' . WS_FORM_PLUGIN_DIR_URL . 'public/images/email/p.gif" width="100%" height="5" />', 'description' => __('Outputs a transparent gif. We use this to avoid Mac Mail going into dark mode when viewing emails.', 'ws-form'))
					)
				),

				// Query
				'query' 	=> array(

					'label'		=> __('Query Variable', 'ws-form'),

					'variables'	=> array(

						'query_var'		=>	array(

							'label' => __('Variable', 'ws-form'),

							'attributes' => array(

								array('id' => 'variable')
							)
						)
					)
				),

				// Post
				'post' 	=> array(

					'label'		=> __('Post Variable', 'ws-form'),

					'variables'	=> array(

						'post_var'	=>	array(

							'label' => __('Variable', 'ws-form'),

							'attributes' => array(

								array('id' => 'variable')
							)
						)
					)
				),

				// Random Numbers
				'random_number' 	=> array(

					'label'		=> __('Random Numbers', 'ws-form'),

					'variables'	=> array(

						'random_number'	=>	array(

							'label' => __('Random Number', 'ws-form'),

							'attributes' => array(

								array('id' => 'min', 'required' => false, 'default' => 0),
								array('id' => 'max', 'required' => false, 'default' => 100)
							),

							'description' => __('Outputs an integer between the specified minimum and maximum attributes. This function does not generate cryptographically secure values, and should not be used for cryptographic purposes.', 'ws-form'),

							'single_parse' => true
						)
					)
				),

				// Random Strings
				'random_string' 	=> array(

					'label'		=> __('Random Strings', 'ws-form'),

					'variables'	=> array(

						'random_string'	=>	array(

							'label' => __('Random String', 'ws-form'),

							'attributes' => array(

								array('id' => 'length', 'required' => false, 'default' => 32),
								array('id' => 'characters', 'required' => false, 'default' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
							),

							'description' => __('Outputs a string of random characters. Use the length attribute to control how long the string is and use the characters attribute to control which characters are randomly selected. This function does not generate cryptographically secure values, and should not be used for cryptographic purposes.', 'ws-form'),

							'single_parse' => true
						)
					)
				),

				// Character
				'character'	=> array(

					'label'		=> __('Character', 'ws-form'),

					'variables' => array(

						'character_count'	=>	array(

							'label'	=> __('Count', 'ws-form'),
							'description' => __('The total character count.', 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'character_count_label'	=>	array(

							'label'	=> __('Count Label', 'ws-form'),
							'description' => __("Shows 'character' or 'characters' depending on the character count.", 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'character_remaining'	=>	array(

							'label'	=> __('Count Remaining', 'ws-form'),
							'description' => __('If you set a maximum character length for a field, this will show the total remaining character count.', 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'character_remaining_label'	=>	array(

							'label'	=> __('Count Remaining Label', 'ws-form'),
							'description' => __('If you set a maximum character length for a field, this will show the total remaining character count.', 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'character_min'	=>	array(

							'label'	=> __('Minimum', 'ws-form'),
							'description' => __('Shows the minimum character length that you set for a field.'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'character_min_label'	=>	array(

							'label'	=> __('Minimum Label', 'ws-form'),
							'description' => __("Shows 'character' or 'characters' depending on the minimum character length.", 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'character_max'	=>	array(

							'label'	=> __('Maximum', 'ws-form'),
							'description' => __('Shows the maximum character length that you set for a field.'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'character_max_label'	=>	array(

							'label'	=> __('Maximum Label', 'ws-form'),
							'description' => __("Shows 'character' or 'characters' depending on the maximum character length.", 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						)
					)
				),

				// Word
				'word'	=> array(

					'label'		=> __('Word', 'ws-form'),

					'variables' => array(

						'word_count'	=>	array(

							'label'	=> __('Count', 'ws-form'),
							'description' => __('The total word count.', 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'word_count_label'	=>	array(

							'label'	=> __('Count Label', 'ws-form'),
							'description' => __("Shows 'word' or 'words' depending on the word count.", 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'word_remaining'	=>	array(

							'label'	=> __('Count Remaining', 'ws-form'),
							'description' => __('If you set a maximum word length for a field, this will show the total remaining word count.', 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'word_remaining_label'	=>	array(

							'label'	=> __('Count Remaining Label', 'ws-form'),
							'description' => __('If you set a maximum word length for a field, this will show the total remaining word count.', 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'word_min'	=>	array(

							'label'	=> __('Minimum', 'ws-form'),
							'description' => __('Shows the minimum word length that you set for a field.', 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'word_min_label'	=>	array(

							'label'	=> __('Minimum Label', 'ws-form'),
							'description' => __("Shows 'word' or 'words' depending on the minimum word length.", 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'word_max'	=>	array(

							'label'	=> __('Maximum', 'ws-form'),
							'description' => __('Shows the maximum word length that you set for a field.', 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						),

						'word_max_label'	=>	array(

							'label'	=> __('Maximum Label', 'ws-form'),
							'description' => __("Shows 'word' or 'words' depending on the maximum word length.", 'ws-form'),
							'limit'	=> __('in the Help setting for text based Fields', 'ws-form'),
							'kb_slug' => 'word-and-character-count'
						)
					)
				)
			);

			// Post
			$post = WS_Form_Common::get_post_root();

			$parse_variables['post'] = array(

				'label'		=> __('Post', 'ws-form'),

				'variables'	=> array(

					'post_url_edit'		=>	array('label' => __('Admin URL', 'ws-form'), 'value' => !is_null($post) ? get_edit_post_link($post->ID) : ''),
					'post_url'			=>	array('label' => __('Public URL', 'ws-form'), 'value' => !is_null($post) ? get_permalink($post->ID) : ''),
					'post_type'			=>	array('label' => __('Type', 'ws-form'), 'value' => !is_null($post) ? $post->post_type : ''),
					'post_title'		=>	array('label' => __('Title', 'ws-form'), 'value' => !is_null($post) ? $post->post_title : ''),
					'post_content'		=>	array('label' => __('Content', 'ws-form'), 'value' => !is_null($post) ? $post->post_content : ''),
					'post_excerpt'		=>	array('label' => __('Excerpt', 'ws-form'), 'value' => !is_null($post) ? $post->post_excerpt : ''),
					'post_time'			=>	array('label' => __('Time', 'ws-form'), 'value' => !is_null($post) ? date(get_option('time_format'), strtotime($post->post_date)) : ''),
					'post_id'			=>	array('label' => __('ID', 'ws-form'), 'value' => !is_null($post) ? $post->ID : ''),
					'post_date'			=>	array('label' => __('Date', 'ws-form'), 'value' => !is_null($post) ? date(get_option('date_format'), strtotime($post->post_date)) : ''),

					// http://blog.stevenlevithan.com/archives/date-time-format
					'post_date_custom'	=>	array(

						'label' => __('Post Custom Date', 'ws-form'),

						'value' => !is_null($post) ? date('c', strtotime($post->post_date)) : '',

						'attributes' => array(

							array('id' => 'format', 'required' => false, 'default' => 'F j, Y, g:i a')
						),

						'kb_slug' => 'date-formats'
					),
					'post_meta'			=>	array(

						'label' => __('Meta Value', 'ws-form'),

						'attributes' => array(

							array('id' => 'key')
						),

						'description' => __('Returns the post meta value for the key specified.', 'ws-form'),

						'scope' => array('form_parse')
					)
				)
			);

			// Author
			$post_author_id = !is_null($post) ? $post->post_author : 0;
			$parse_variables['author'] = array(

				'label'		=> __('Author', 'ws-form'),

				'variables'	=> array(

					'author_id'				=>	array('label' => __('ID', 'ws-form'), 'value' => $post_author_id),
					'author_display_name'	=>	array('label' => __('Display Name', 'ws-form'), 'value' => get_the_author_meta('display_name', $post_author_id)),
					'author_first_name'		=>	array('label' => __('First Name', 'ws-form'), 'value' => get_the_author_meta('first_name', $post_author_id)),
					'author_last_name'		=>	array('label' => __('Last Name', 'ws-form'), 'value' => get_the_author_meta('last_name', $post_author_id)),
					'author_nickname'		=>	array('label' => __('Nickname', 'ws-form'), 'value' => get_the_author_meta('nickname', $post_author_id)),
					'author_email'			=>	array('label' => __('Email', 'ws-form')),
				)
			);

			// URL
			$parse_variables['url'] = array(

				'label'		=> __('URL', 'ws-form'),

				'variables'	=> array(

					'url_login'				=>	array('label' => __('Login', 'ws-form'), 'value' => wp_login_url()),
					'url_logout'			=>	array('label' => __('Logout', 'ws-form'), 'value' => wp_logout_url()),
					'url_lost_password'				=>	array('label' => __('Login', 'ws-form'), 'value' => wp_lostpassword_url()),
					'url_register'				=>	array('label' => __('Register', 'ws-form'), 'value' => wp_registration_url()),
				)
			);

			// ACF
			if(class_exists('acf')) { 

				$parse_variables['acf'] =  array(

					'label'		=> __('ACF', 'ws-form'),

					'variables'	=> array(

						'acf_repeater_field'	=>	array(

							'label' => __('Repeater Field', 'ws-form'),

							'attributes' => array(

								array('id' => 'parent_field'),
								array('id' => 'sub_field'),
							),

							'description' => __('Used to obtain an ACF repeater field. You can separate parent_fields with commas to access deep variables.', 'ws-form'),

							'scope' => array('form_parse')
						),
					)
				);
			}

			if(!$public) {

				// Tracking
				$tracking_array = self::get_tracking($public);
				$parse_variables['tracking'] = array(

					'label'		=> __('Tracking', 'ws-form'),
					'variables'	=> array()
				);

				foreach($tracking_array as $meta_key => $tracking) {

					$parse_variables['tracking']['variables'][$meta_key] = array('label' => $tracking['label'], 'description' => $tracking['description']);
				}
			}

			// Get e-commerce config
			$ecommerce_config = self::get_ecommerce();

			foreach($ecommerce_config['cart_price_types'] as $meta_key => $cart_price_type) {

				$parse_variables['ecommerce']['variables']['ecommerce_cart_' . $meta_key . '_span'] = array(

					'label' 		=> sprintf('%s (%s)', $cart_price_type['label'], __('Span', 'ws-form')),
					'value' 		=> sprintf('<span data-ecommerce-cart-price-%s>#ecommerce_cart_%1$s</span>', $meta_key),
					'description' 	=> __('Excludes currency symbol. This variable outputs a span that can be used in Text Editor or HTML fields.', 'ws-form')
				);
				$parse_variables['ecommerce']['variables']['ecommerce_cart_' . $meta_key . '_span_currency'] = array(

					'label' 		=> sprintf('%s (%s)', $cart_price_type['label'], __('Span Currency', 'ws-form')),
					'value' 		=> sprintf('<span data-ecommerce-cart-price-%1$s data-ecommerce-price-currency>#ecommerce_cart_%1$s_currency</span>', $meta_key),
					'description' 	=> __('Includes currency symbol. This variable outputs a span that can be used in Text Editor or HTML fields.', 'ws-form')
				);
				$parse_variables['ecommerce']['variables']['ecommerce_cart_' . $meta_key] = array(

					'label' 		=> $cart_price_type['label'],
					'description' 	=> __('Excludes currency symbol. Use this in conditional logic or email templates.', 'ws-form')
				);
				$parse_variables['ecommerce']['variables']['ecommerce_cart_' . $meta_key . '_currency'] = array(

					'label' 		=> sprintf('%s (%s)', $cart_price_type['label'], __('Currency', 'ws-form')),
					'description' 	=> __('Includes currency symbol. Use this in conditional logic or email templates.', 'ws-form')
				);
			}

			foreach($ecommerce_config['meta_keys'] as $meta_key => $meta_key_config) {

				$type = isset($meta_key_config['type']) ? $meta_key_config['type'] : false;

				if($type == 'price') {

					$parse_variables['ecommerce']['variables'][$meta_key . '_span'] = array(

						'label' 		=> sprintf('%s (%s)', $meta_key_config['label'], __('Span', 'ws-form')),
						'value' 		=> sprintf('<span data-%1$s>%1$s</span>', str_replace('_', '-', $meta_key)),
						'description' 	=> __('Excludes currency symbol. This variable outputs a span that can be used in Text Editor or HTML fields', 'ws-form')
					);
					$parse_variables['ecommerce']['variables'][$meta_key . '_span_currency'] = array(

						'label' 		=> sprintf('%s (%s)', $meta_key_config['label'], __('Span Currency', 'ws-form')),
						'value' 		=> sprintf('<span data-%1$s data-ecommerce-price-currency>%1$s_currency</span>', str_replace('_', '-', $meta_key)),
						'description'	=> __('Includes currency symbol. This variable outputs a span that can be used in Text Editor or HTML fields', 'ws-form')
					);
					$parse_variables['ecommerce']['variables'][$meta_key . '_currency'] = array(

						'label'			=> sprintf('%s (%s)', $meta_key_config['label'], __('Currency', 'ws-form')),
						'description' 	=> __('Includes currency symbol. Use this in conditional logic or email templates', 'ws-form')
					);
				}

				$parse_variables['ecommerce']['variables'][$meta_key] = array(

					'label' 		=> $meta_key_config['label'],
					'description' 	=> __('Excludes currency symbol. Use this in conditional logic or email templates.', 'ws-form')
				);
			}
			// User
			$user = WS_Form_Common::get_user();

			$user_id = (($user === false) ? 0 : $user->ID);

			$parse_variables['user'] = array(

				'label'		=> __('User', 'ws-form'),

				'variables'	=> array(

					'user_id' 			=>	array('label' => __('ID', 'ws-form'), 'value' => $user_id, 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_login' 		=>	array('label' => __('Login', 'ws-form'), 'value' => ($user_id > 0) ? $user->user_login : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_nicename' 	=>	array('label' => __('Nice Name', 'ws-form'), 'value' => ($user_id > 0) ? $user->user_nicename : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_email' 		=>	array('label' => __('Email', 'ws-form'), 'value' => ($user_id > 0) ? $user->user_email : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_display_name' =>	array('label' => __('Display Name', 'ws-form'), 'value' => ($user_id > 0) ? $user->display_name : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_url' 			=>	array('label' => __('URL', 'ws-form'), 'value' => ($user_id > 0) ? $user->user_url : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_registered' 	=>	array('label' => __('Registration Date', 'ws-form'), 'value' => ($user_id > 0) ? $user->user_registered : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_first_name'	=>	array('label' => __('First Name', 'ws-form'), 'value' => ($user_id > 0) ? get_user_meta($user_id, 'first_name', true) : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_last_name'	=>	array('label' => __('Last Name', 'ws-form'), 'value' => ($user_id > 0) ? get_user_meta($user_id, 'last_name', true) : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_bio'			=>	array('label' => __('Bio', 'ws-form'), 'value' => ($user_id > 0) ? get_user_meta($user_id, 'description', true) : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_nickname' 	=>	array('label' => __('Nickname', 'ws-form'), 'value' => ($user_id > 0) ? get_user_meta($user_id, 'nickname', true) : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_admin_color' 	=>	array('label' => __('Admin Color', 'ws-form'), 'value' => ($user_id > 0) ? get_user_meta($user_id, 'admin_color', true) : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_lost_password_key' => array('label' => __('Lost Password Key', 'ws-form'), 'value' => ($user_id > 0) ? $user->lost_password_key : '', 'limit' => __('if a user is currently signed in', 'ws-form')),
					'user_lost_password_url' => array(

						'label'			=> __('Lost Password URL', 'ws-form'),
						'attributes'	=> array(

							array('id' => 'path', 'required' => false, 'default' => '')
						),
						'limit' => __('if a user is currently signed in', 'ws-form')
					),
					'user_meta'			=>	array(

						'label' => __('Meta Value', 'ws-form'),

						'attributes' => array(

							array('id' => 'key')
						),

						'description' => __('Returns the user meta value for the key specified.', 'ws-form'),

						'scope' => array('form_parse')
					)
				)
			);

			// Search
			$parse_variables['search'] = array(

				'label'		=> __('Search', 'ws-form'),

				'variables'	=> array(

					'search_query' => array('label' => __('Query', 'ws-form'), 'value' => get_search_query())
				)
			);

			// Apply filter
			$parse_variables = apply_filters('wsf_config_parse_variables', $parse_variables);

			// Public - Optimize
			if($public) {

				$parameters_exclude = array('label', 'description', 'limit', 'kb_slug');

				foreach($parse_variables as $variable_group => $variable_group_config) {

					foreach($variable_group_config['variables'] as $variable => $variable_config) {

						unset($parse_variables[$variable_group]['label']);

						foreach($parameters_exclude as $parameter_exclude) {

							if(isset($parse_variables[$variable_group]['variables'][$variable][$parameter_exclude])) {

								unset($parse_variables[$variable_group]['variables'][$variable][$parameter_exclude]);
							}
						}
					}
				}
			}

			// Cache
			self::$parse_variables[$public] = $parse_variables;

			return $parse_variables;
		}

		// Javascript
		public static function get_external() {

			// CDN or local source?
			$jquery_source = WS_Form_Common::option_get('jquery_source', 'cdn');

			$external = array(

				// Signature Pad - v2.3.2
				'signature_pad_js'	=> (($jquery_source == 'local') ? 

					WS_FORM_PLUGIN_DIR_URL . 'public/js/external/signature_pad.min.js?ver=2.3.2' :
					'https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.js'
				),

				// Date Time Picker - v2.5.21
				'datetimepicker_js'	=> (($jquery_source == 'local') ? 

					WS_FORM_PLUGIN_DIR_URL . 'public/js/external/jquery.datetimepicker.min.js?ver=2.5.21' :
					'https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.21/build/jquery.datetimepicker.full.min.js'
				),

				'datetimepicker_css'	=> (($jquery_source == 'local') ? 

					WS_FORM_PLUGIN_DIR_URL . 'public/css/external/jquery.datetimepicker.min.css?ver=2.5.21' :
					'https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.21/build/jquery.datetimepicker.min.css'
				),

				// MiniColors - v2.3.2
				'minicolors_js'	=> (($jquery_source == 'local') ? 

					WS_FORM_PLUGIN_DIR_URL . 'public/js/external/jquery.minicolors.min.js?ver=2.3.2' :
					'https://cdnjs.cloudflare.com/ajax/libs/jquery-minicolors/2.3.2/jquery.minicolors.min.js'
				),

				'minicolors_css' => (($jquery_source == 'local') ? 

					WS_FORM_PLUGIN_DIR_URL . 'public/css/external/jquery.minicolors.min.css?ver=2.3.2' :
					'https://cdnjs.cloudflare.com/ajax/libs/jquery-minicolors/2.3.2/jquery.minicolors.min.css'
				),

				// Password Strength Meter (WordPress admin file)
				'zxcvbn'					=> WS_FORM_PLUGIN_INCLUDES .'js/zxcvbn.min.js',
				'password_strength_meter'	=> WS_FORM_PLUGIN_DIR_URL . 'public/js/wp/password-strength-meter.min.js',

				// Select2
				'select2_js'	=> (($jquery_source == 'local') ? 

					WS_FORM_PLUGIN_DIR_URL . 'shared/js/external/select2/select2.full.min.js' :
					'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js'
				),

				'select2_css'	=> (($jquery_source == 'local') ? 

					WS_FORM_PLUGIN_DIR_URL . 'shared/css/external/select2/select2.min.css' :
					'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css'
				),
				// Input mask bundle - v5.0.3
				'inputmask_js' => (($jquery_source == 'local') ? 

					WS_FORM_PLUGIN_DIR_URL . 'public/js/external/jquery.inputmask.min.js?ver=5.0.3' :
					'https://cdn.jsdelivr.net/gh/RobinHerbots/jquery.inputmask@5.0.3/dist/jquery.inputmask.min.js'
				)
			);

			// Apply filter
			$external = apply_filters('wsf_config_external', $external);

			return $external;
		}

		public static function get_currencies() {

			$currencies = array(

				'AFN' => array('s' => 'Af','n' => 'Afghanistan Afghani'),
				'ALL' => array('s' => 'Lek','n' => 'Albania Lek'),
				'ARS' => array('s' => '$','n' => 'Argentina Peso'),
				'AWG' => array('s' => 'ƒ','n' => 'Aruba Guilder'),
				'AUD' => array('s' => '$','n' => 'Australia Dollar'),
				'AZN' => array('s' => 'ман','n' => 'Azerbaijan New Manat'),
				'BSD' => array('s' => '$','n' => 'Bahamas Dollar'),
				'BBD' => array('s' => '$','n' => 'Barbados Dollar'),
				'BDT' => array('s' => '৳','n' => 'Bangladeshi taka'),
				'BYR' => array('s' => 'p.','n' => 'Belarus Ruble'),
				'BZD' => array('s' => 'BZ$','n' => 'Belize Dollar'),
				'BMD' => array('s' => '$','n' => 'Bermuda Dollar'),
				'BOB' => array('s' => '$b','n' => 'Bolivia Boliviano'),
				'BAM' => array('s' => 'KM','n' => 'Bosnia and Herzegovina Convertible Marka'),
				'BWP' => array('s' => 'P','n' => 'Botswana Pula'),
				'BGN' => array('s' => 'лв','n' => 'Bulgaria Lev'),
				'BRL' => array('s' => 'R$','n' => 'Brazil Real'),
				'BND' => array('s' => '$','n' => 'Brunei Darussalam Dollar'),
				'KHR' => array('s' => '៛','n' => 'Cambodia Riel'),
				'CAD' => array('s' => '$','n' => 'Canada Dollar'),
				'KYD' => array('s' => '$','n' => 'Cayman Islands Dollar'),
				'CLP' => array('s' => '$','n' => 'Chile Peso'),
				'CNY' => array('s' => '¥','n' => 'China Yuan Renminbi'),
				'COP' => array('s' => '$','n' => 'Colombia Peso'),
				'CRC' => array('s' => '₡','n' => 'Costa Rica Colon'),
				'HRK' => array('s' => 'kn','n' => 'Croatia Kuna'),
				'CUP' => array('s' => '⃌','n' => 'Cuba Peso'),
				'CZK' => array('s' => 'Kč','n' => 'Czech Republic Koruna'),
				'DKK' => array('s' => 'kr','n' => 'Denmark Krone'),
				'DOP' => array('s' => 'RD$','n' => 'Dominican Republic Peso'),
				'XCD' => array('s' => '$','n' => 'East Caribbean Dollar'),
				'EGP' => array('s' => '£','n' => 'Egypt Pound'),
				'SVC' => array('s' => '$','n' => 'El Salvador Colon'),
				'EEK' => array('s' => '','n' => 'Estonia Kroon'),
				'EUR' => array('s' => '€','n' => 'Euro Member Countries'),
				'FKP' => array('s' => '£','n' => 'Falkland Islands (Malvinas) Pound'),
				'FJD' => array('s' => '$','n' => 'Fiji Dollar'),
				'GHC' => array('s' => '','n' => 'Ghana Cedis'),
				'GIP' => array('s' => '£','n' => 'Gibraltar Pound'),
				'GTQ' => array('s' => 'Q','n' => 'Guatemala Quetzal'),
				'GGP' => array('s' => '','n' => 'Guernsey Pound'),
				'GYD' => array('s' => '$','n' => 'Guyana Dollar'),
				'HNL' => array('s' => 'L','n' => 'Honduras Lempira'),
				'HKD' => array('s' => '$','n' => 'Hong Kong Dollar'),
				'HUF' => array('s' => 'Ft','n' => 'Hungary Forint'),
				'ISK' => array('s' => 'kr','n' => 'Iceland Krona'),
				'INR' => array('s' => '₹','n' => 'India Rupee'),
				'IDR' => array('s' => 'Rp','n' => 'Indonesia Rupiah'),
				'IRR' => array('s' => '﷼','n' => 'Iran Rial'),
				'IMP' => array('s' => '','n' => 'Isle of Man Pound'),
				'ILS' => array('s' => '₪','n' => 'Israel Shekel'),
				'JMD' => array('s' => 'J$','n' => 'Jamaica Dollar'),
				'JPY' => array('s' => '¥','n' => 'Japan Yen'),
				'JEP' => array('s' => '£','n' => 'Jersey Pound'),
				'KZT' => array('s' => 'лв','n' => 'Kazakhstan Tenge'),
				'KPW' => array('s' => '₩','n' => 'Korea (North) Won'),
				'KRW' => array('s' => '₩','n' => 'Korea (South) Won'),
				'KGS' => array('s' => 'лв','n' => 'Kyrgyzstan Som'),
				'LAK' => array('s' => '₭','n' => 'Laos Kip'),
				'LVL' => array('s' => 'Ls','n' => 'Latvia Lat'),
				'LBP' => array('s' => '£','n' => 'Lebanon Pound'),
				'LRD' => array('s' => '$','n' => 'Liberia Dollar'),
				'LTL' => array('s' => 'Lt','n' => 'Lithuania Litas'),
				'MKD' => array('s' => 'ден','n' => 'Macedonia Denar'),
				'MYR' => array('s' => 'RM','n' => 'Malaysia Ringgit'),
				'MUR' => array('s' => '₨','n' => 'Mauritius Rupee'),
				'MXN' => array('s' => '$','n' => 'Mexico Peso'),
				'MNT' => array('s' => '₮','n' => 'Mongolia Tughrik'),
				'MZN' => array('s' => 'MT','n' => 'Mozambique Metical'),
				'NAD' => array('s' => '$','n' => 'Namibia Dollar'),
				'NPR' => array('s' => '₨','n' => 'Nepal Rupee'),
				'ANG' => array('s' => 'ƒ','n' => 'Netherlands Antilles Guilder'),
				'NZD' => array('s' => '$','n' => 'New Zealand Dollar'),
				'NIO' => array('s' => 'C$','n' => 'Nicaragua Cordoba'),
				'NGN' => array('s' => '₦','n' => 'Nigeria Naira'),
				'NOK' => array('s' => 'kr','n' => 'Norway Krone'),
				'OMR' => array('s' => '﷼','n' => 'Oman Rial'),
				'PKR' => array('s' => '₨','n' => 'Pakistan Rupee'),
				'PAB' => array('s' => 'B/.','n' => 'Panama Balboa'),
				'PYG' => array('s' => 'Gs','n' => 'Paraguay Guarani'),
				'PEN' => array('s' => 'S/.','n' => 'Peru Nuevo Sol'),
				'PHP' => array('s' => '₱','n' => 'Philippines Peso'),
				'PLN' => array('s' => 'zł','n' => 'Poland Zloty'),
				'QAR' => array('s' => '﷼','n' => 'Qatar Riyal'),
				'RON' => array('s' => 'lei','n' => 'Romania New Leu'),
				'RUB' => array('s' => 'руб','n' => 'Russia Ruble'),
				'SHP' => array('s' => '£','n' => 'Saint Helena Pound'),
				'SAR' => array('s' => '﷼','n' => 'Saudi Arabia Riyal'),
				'RSD' => array('s' => 'Дин.','n' => 'Serbia Dinar'),
				'SCR' => array('s' => '₨','n' => 'Seychelles Rupee'),
				'SGD' => array('s' => '$','n' => 'Singapore Dollar'),
				'SBD' => array('s' => '$','n' => 'Solomon Islands Dollar'),
				'SOS' => array('s' => 'S','n' => 'Somalia Shilling'),
				'ZAR' => array('s' => 'R','n' => 'South Africa Rand'),
				'LKR' => array('s' => '₨','n' => 'Sri Lanka Rupee'),
				'SEK' => array('s' => 'kr','n' => 'Sweden Krona'),
				'CHF' => array('s' => 'CHF','n' => 'Switzerland Franc'),
				'SRD' => array('s' => '$','n' => 'Suriname Dollar'),
				'SYP' => array('s' => '£','n' => 'Syria Pound'),
				'TWD' => array('s' => 'NT$','n' => 'Taiwan New Dollar'),
				'THB' => array('s' => '฿','n' => 'Thailand Baht'),
				'TTD' => array('s' => '$','n' => 'Trinidad and Tobago Dollar'),
				'TRY' => array('s' => '₤','n' => 'Turkey Lira'),
				'TRL' => array('s' => '','n' => 'Turkey Lira'),
				'TVD' => array('s' => '','n' => 'Tuvalu Dollar'),
				'UAH' => array('s' => '₴','n' => 'Ukraine Hryvna'),
				'GBP' => array('s' => '£','n' => 'United Kingdom Pound'),
				'USD' => array('s' => '$','n' => 'United States Dollar'),
				'UYU' => array('s' => '$U','n' => 'Uruguay Peso'),
				'UZS' => array('s' => 'лв','n' => 'Uzbekistan Som'),
				'VEF' => array('s' => 'Bs','n' => 'Venezuela Bolivar'),
				'VND' => array('s' => '₫','n' => 'Viet Nam Dong'),
				'YER' => array('s' => '﷼','n' => 'Yemen Rial'),
				'ZWD' => array('s' => '','n' => 'Zimbabwe Dollar')
			);

			// Apply filter
			$currencies = apply_filters('wsf_config_currencies', $currencies);

			return $currencies;
		}

		public static function get_ecommerce() {

			// Check cache
			if(self::$ecommerce !== false) { return self::$ecommerce; }			

			$ecommerce = array(

				'cart_price_types' => array(

					'subtotal' 			=> array('label' => __('Subtotal', 'ws-form'), 'priority' => 10, 'multiple' => false, 'render' => true),
					'shipping' 			=> array('label' => __('Shipping', 'ws-form'), 'priority' => 20),
					'discount'			=> array('label' => __('Discount', 'ws-form'), 'priority' => 30),
					'handling_fee'		=> array('label' => __('Handling Fee', 'ws-form'), 'priority' => 40),
					'shipping_discount'	=> array('label' => __('Shipping Discount', 'ws-form'), 'priority' => 50),
					'insurance'			=> array('label' => __('Insurance', 'ws-form'), 'priority' => 60),
					'gift_wrap'			=> array('label' => __('Gift Wrap', 'ws-form'), 'priority' => 70),
					'other'				=> array('label' => __('Other', 'ws-form'), 'priority' => 80),
					'tax'				=> array('label' => __('Tax', 'ws-form'), 'priority' => 100)
				),

				'status' => array(

					'new'				=> array('label' =>	__('New', 'ws-form')),
					'pending_payment'	=> array('label' =>	__('Pending Payment', 'ws-form')),
					'processing'		=> array('label' =>	__('Processing', 'ws-form')),
					'active'			=> array('label' =>	__('Active', 'ws-form')),
					'cancelled'			=> array('label' =>	__('Cancelled', 'ws-form')),
					'authorized'		=> array('label' =>	__('Authorized', 'ws-form')),
					'completed'			=> array('label' =>	__('Completed', 'ws-form')),
					'failed'			=> array('label' =>	__('Failed', 'ws-form')),
					'refunded'			=> array('label' =>	__('Refunded', 'ws-form')),
					'voided'			=> array('label' =>	__('Voided', 'ws-form'))
				),

				'meta_keys' => array(

					'ecommerce_cart_total'		=> array('label' =>	__('Total', 'ws-form'), 'type' => 'price', 'priority' => 200),
					'ecommerce_status'			=> array('label' =>	__('Status', 'ws-form'), 'lookup' => 'status', 'priority' => 5),
					'ecommerce_transaction_id'	=> array('label' =>	__('Transaction ID', 'ws-form'), 'priority' => 1010),
					'ecommerce_payment_method'	=> array('label' =>	__('Payment Method', 'ws-form'), 'priority' => 1020)
				)
			);

			// Apply filter
			$ecommerce = apply_filters('wsf_config_ecommerce', $ecommerce);

			// Cache
			self::$ecommerce = $ecommerce;

			return $ecommerce;
		}
	}