<?php

	class WS_Form_Public {

		// The ID of this plugin.
		private $plugin_name;

		// The version of this plugin.
		private $version;

		// Customizer
		private $customizer;

		// CSS inline
		private $css_inline;

		// Form index (Incremented for each rendered with a short code)
		public $form_instance = 1;

		// Error index
		public $error_index = 0;

		// Debug
		public $debug = false;

		// JSON
		public $wsf_form_json = array();

		// Footer JS
		public $footer_js = '';

		// Registered

		// Enqueuing
		public $enqueue_css_layout = false;
		public $enqueue_css_skin = false;
		public $enqueue_css_debug = false;
		public $enqueue_js_form_common = false;
		public $enqueue_js_form_public = false;
		public $enqueue_js_form_debug = false;
		public $enqueue_js_wp_editor = false;
		public $enqueue_js_wp_html_editor = false;
		public $enqueue_js_input_mask = false;
		public $enqueue_js_sortable = false;
		public $enqueue_js_signature = false;
		public $enqueue_js_datetime_picker = false;
		public $enqueue_js_color_picker = false;
		public $enqueue_js_password_strength = false;
		public $enqueue_js_select2 = false;

		// Enqueued
		public $enqueued_all = false;
		public $enqueued_visual_builder = false;
		public $enqueued_core = false;

		public $enqueued_css_layout = false;
		public $enqueued_css_skin = false;
		public $enqueued_css_debug = false;

		public $enqueued_js_form_common = false;
		public $enqueued_js_form_public = false;
		public $enqueued_js_form_debug = false;
		public $enqueued_js_wp_editor = false;
		public $enqueued_js_wp_html_editor = false;
		public $enqueued_js_input_mask = false;
		public $enqueued_js_sortable = false;
		public $enqueued_js_signature = false;
		public $enqueued_js_datetime_picker = false;
		public $enqueued_js_color_picker = false;
		public $enqueued_js_password_strength = false;
		public $enqueued_js_select2 = false;

		// Config filtering
		public $field_types = array();

		// Initialize the class and set its properties.
		public function __construct() {

			$this->plugin_name = WS_FORM_NAME;
			$this->version = WS_FORM_VERSION;
			$this->customizer = (WS_Form_Common::get_query_var('customize_theme') !== '');
			$this->css_inline = (WS_Form_Common::option_get('css_inline'));

			add_action('wsf_enqueue_all', array($this, 'enqueue_all'), 10, 0);
			add_action('wsf_enqueue_visual_builder', array($this, 'enqueue_visual_builder'), 10, 0);
			add_action('wsf_enqueue_core', array($this, 'enqueue_core'), 10, 0);
		}

		public function enqueue_core() {

			if(!$this->enqueued_core) {

				// Set filters to true
				add_filter('wsf_enqueue_css_layout', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_css_skin', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_form_common', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_form_public', function($enqueue) { return true; }, 99999, 1);

				// Process enqueues
				self::enqueue();

				$this->enqueued_core = true;
			}
		}

		public function enqueue_visual_builder() {

			if(!$this->enqueued_visual_builder) {

				// Set filters to true
				add_filter('wsf_enqueue_css_layout', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_css_skin', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_form_common', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_form_public', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_input_mask', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_sortable', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_signature', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_datetime_picker', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_color_picker', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_password_strength', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_select2', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_form_debug', function($enqueue) { return false; }, 99999, 1);

				// Process enqueues
				self::enqueue();

				$this->enqueued_visual_builder = true;
			}
		}

		public function enqueue_all() {

			if(!$this->enqueued_all) {

				// Set filters to true
				add_filter('wsf_enqueue_css_layout', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_css_skin', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_form_common', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_form_public', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_wp_editor', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_wp_html_editor', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_input_mask', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_sortable', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_signature', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_datetime_picker', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_color_picker', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_password_strength', function($enqueue) { return true; }, 99999, 1);
				add_filter('wsf_enqueue_js_select2', function($enqueue) { return true; }, 99999, 1);

				// Process enqueues
				self::enqueue();

				$this->enqueued_all = true;
			}
		}

		public function init() {

			// Preview engine
			$plugin_preview = new WS_Form_Preview();
		}

		public function wp() {

			// Get post
			global $post;
			$GLOBALS['ws_form_post_root'] = isset($post) ? $post : null;
		}

		// Shortcode: ws_form
		public function shortcode_ws_form($atts) {

			// Form ID
			$form_id = isset($atts['id']) ? intval($atts['id']) : false;

			// Element
			$element = isset($atts['element']) ? $atts['element'] : 'form';

			// Element ID
			$element_id = isset($atts['element_id']) ? $atts['element_id'] : false;

			// Published?
			$published = isset($atts['published']) ? ($atts['published'] == 'true') : true;

			// Preview?
			$preview = isset($atts['preview']) ? ($atts['preview'] == 'true') : false;

			// Form HTML?
			$form_html = isset($atts['form_html']) ? ($atts['form_html'] == 'true') : true;

			// Visual builder?
			$visual_builder = isset($atts['visual_builder']) ? ($atts['visual_builder'] == 'true') : false;

			// Query string overrides
			if(WS_Form_Common::get_query_var('wsf_published') === 'false') { $published = false; }

			// Check for preview mode
			if($preview) {

				// Reset form instance (This is required to ensure wp_head calls resulting in do_shortcode('ws-form') don't stack up on each other)
				if(isset($this->wsf_form_json[$form_id])) { unset($this->wsf_form_json[$form_id]); }
				$this->form_instance = 1;
			}

			// Wizard ID
			$form_object = false;
			$wizard_id = isset($atts['wizard_id']) ? $atts['wizard_id'] : false;
			if($wizard_id !== false) {
				
				$ws_form_wizard = new WS_Form_Wizard();
				$ws_form_wizard->id = $wizard_id;
				
				try {
					
					$ws_form_wizard->read();
					$form_object = $ws_form_wizard->form;

					// Change meta data
					$form_object->meta->class_form_wrapper = 'wsf-demo';
					$form_object->meta->label_render = '';
					$form_object->meta->form_action = '#';

					$published = false;

				} catch (Exception $e) {}
			}

			// Visual builder
			if($visual_builder) {

				$published = false;
			}

			if(
				(($form_id > 0) && ($form_object === false)) ||
				(($form_id === false) && ($form_object !== false))
			) {

				if($form_id > 0) {

					// Embed form data (Avoids an API call)
					$ws_form_form = New WS_Form_Form();
					$ws_form_form->id = $form_id;

					try {

						if($published) {

							$form_object = $ws_form_form->db_read_published(true);

						} else {

							$form_object = $ws_form_form->db_read(true, true, false, true);
						}

					} catch(Exception $e) { return $e->getMessage(); }
				}

				if($form_object !== false) {

					// Filter
					$form_object = apply_filters('wsf_pre_render_' . $form_id, $form_object, $preview);
					$form_object = apply_filters('wsf_pre_render', $form_object, $preview);

					// Pre-process form data
					self::form_pre_process($form_object);
				}

				// Get form HTML
				$return_value = ($form_html ? self::form_html($this->form_instance++, $form_object, $element, $published, $preview, $element_id, $visual_builder) : '');

				return $return_value;

			} else {

				// Error
				return __('Invalid form ID', 'ws-form');
			}
		}

		// Head scripts
		public function wp_head() {

			WS_Form_Common::toolbar_css();
		}

		// Footer scripts
		public function wp_footer() {

			if(count($this->wsf_form_json) == 0) { return; };

			if(count($this->field_types) > 0) { $this->field_types = array_unique($this->field_types); }

			echo "\n<script type=\"text/javascript\" id=\"wsf-wp-footer\">\n/* <![CDATA[ */\n";

			// Embed config data (Avoids an API call)
			$json_config = wp_json_encode(WS_Form_Config::get_config(false, $this->field_types));
			echo sprintf("var wsf_form_json_config = %s;\n", $json_config);	// phpcs:ignore
			$json_config = null;

			// Init form data
			echo ("var wsf_form_json = [];\n");
			echo ("var wsf_form_json_populate = [];\n");

			// Footer JS
			echo $this->footer_js;	// phpcs:ignore
			$this->footer_js = null;

			echo "/* ]]> */\n</script>\n\n";

			// Enqueue debug
//			self::wp_scripts_debug();
		}

		// Footer scripts - Pre-Process
		public function form_pre_process(&$form_object) {

			// If REST request, abandon this
			if(WS_Form_Common::is_rest_request()) { return; }

			// Enqueue WS Form
			$this->enqueue_js_form_common = true;
			$this->enqueue_js_form_public = true;
			$this->enqueue_css_layout = true;
			$this->enqueue_css_skin = true;

			// Enqueue WS Form Debug console
			$this->debug = WS_Form_Common::debug_enabled();
			if($this->debug) {
				$this->enqueue_js_form_debug = true;
				$this->enqueue_css_debug = true;
			}

			// Field types
			$field_types = WS_Form_Config::get_field_types_flat();

 			// Get form fields
			$fields = WS_Form_Common::get_fields_from_form($form_object);

			// Get user roles
			$current_user = wp_get_current_user();
			$user_roles = $current_user->roles;

			// Process fields
			foreach($fields as $field) {

				if(!isset($field->type)) { continue; }

				// Get field type
				$field_type = $field->type;

				// Add field type to array (This is used later on to filter the field configs rendered on the page)
				$this->field_types[] = $field_type;

				// Check to see if an input_mask is set
				if(!$this->enqueue_js_input_mask) {

					$input_mask = WS_Form_Common::get_object_meta_value($field, 'input_mask', '');
					if($input_mask !== '') { $this->enqueue_js_input_mask = true; }

				}

				// Field user status
				$field_user_status = WS_Form_Common::get_object_meta_value($field, 'field_user_status', '');
				$field_user_roles = WS_Form_Common::get_object_meta_value($field, 'field_user_roles', false);
				$field_user_capabilities = WS_Form_Common::get_object_meta_value($field, 'field_user_capabilities', false);

				if($field_user_status) {

					$field_show = false;

					switch($field_user_status) {

						// Must be logged in
						case 'on' :

							if($current_user->ID > 0) { $field_show = true; }
							break;

						// Must be logged out
						case 'out' :

							if($current_user->ID == 0) { $field_show = true; }
							break;

						// Must have user role or capability
						case 'role_capability' :

							if(is_array($field_user_roles) && (count($field_user_roles) > 0)) {

								$user_role_ok = false;

								if(is_user_logged_in()) {

									foreach($field_user_roles as $field_user_role) {

										if(in_array($field_user_role, $user_roles)) {

											$user_role_ok = true;
										}
									}
								}

							} else {

								$user_role_ok = true;
							}

							if(is_array($field_user_capabilities) && (count($field_user_capabilities) > 0)) {

								$user_capability_ok = false;

								if(is_user_logged_in()) {

									foreach($field_user_capabilities as $field_user_capability) {

										if(WS_Form_Common::can_user($field_user_capability)) {

											$user_capability_ok = true;
										}
									}
								}

							} else {

								$user_capability_ok = true;
							}

							if($user_role_ok && $user_capability_ok) { $field_show = true; }

							break;
					}

					if(!$field_show) {

						unset($form_object->groups[$field->group_key]->sections[$field->section_key]->fields[$field->field_key]);
					}
				}

				// Check by field type
				switch($field_type) {

					// Check to see if a textarea field is using wp_editor or wp_html_editor
					case 'textarea' :

						$input_type_textarea = WS_Form_Common::get_object_meta_value($field, 'input_type_textarea', '');
						if($input_type_textarea == 'tinymce') { $this->enqueue_js_wp_editor = true; }
						if($input_type_textarea == 'html') { $this->enqueue_js_wp_html_editor = true; }
						break;

				}

				$field = null;
			}

			// Run enqueues
			self::enqueue();
		}

		// Enqueue
		public function enqueue() {

			// Enqueue in footer?
			$jquery_footer = (WS_Form_Common::option_get('jquery_footer', '') == 'on');

			// External scripts
			$external = WS_Form_Config::get_external();

			// JS - Input Mask
			if(!$this->enqueued_js_input_mask && apply_filters('wsf_enqueue_js_input_mask', $this->enqueue_js_input_mask)) {

				// External - Input Mask Bundle
				wp_enqueue_script($this->plugin_name . '-external-inputmask', $external['inputmask_js'], array('jquery'), null, $jquery_footer);
				$this->enqueued_js_input_mask = true;
			}
			// If a textarea exists in a form that requires wp_editor or wp_code_editor, enqueue the scripts
			global $wp_version;

			// WP Editor
			if(
				!$this->enqueued_js_wp_editor && 
				apply_filters('wsf_enqueue_js_wp_editor', $this->enqueue_js_wp_editor) &&
				version_compare($wp_version, '4.8', '>=') &&
				user_can_richedit()
			) {

				wp_enqueue_editor();

				$this->enqueued_js_wp_editor = true;
			}

			// WP HTML Editor
			if(
				!$this->enqueued_js_wp_html_editor && 
				apply_filters('wsf_enqueue_js_wp_html_editor', $this->enqueue_js_wp_html_editor) &&
				version_compare($wp_version, '4.9', '>=') &&
				(!is_user_logged_in() || (wp_get_current_user()->syntax_highlighting))
			) {

				wp_enqueue_code_editor(array('type' => 'text/html'));

				$this->enqueued_js_wp_html_editor = true;
			}

			// JS - Common
			if(!$this->enqueued_js_form_common && apply_filters('wsf_enqueue_js_form_common', $this->enqueue_js_form_common)) {

				// Enqueued scripts settings
				$ws_form_settings = self::localization_object($this->debug);

				// WS Form script - Common
				wp_register_script($this->plugin_name . '-form-common', plugin_dir_url(__DIR__) . 'shared/js/ws-form.js', array('jquery'), $this->version, $jquery_footer);
				wp_localize_script($this->plugin_name . '-form-common', 'ws_form_settings', $ws_form_settings);
				wp_enqueue_script($this->plugin_name . '-form-common');

				$this->enqueued_js_form_common = true;
			}

			// JS - Public
			if(!$this->enqueued_js_form_public && apply_filters('wsf_enqueue_js_form_public', $this->enqueue_js_form_public)) {

				// Form class - Public
				wp_enqueue_script($this->plugin_name . '-form-public', plugin_dir_url(__DIR__) . 'public/js/ws-form-public.js', array($this->plugin_name . '-form-common'), $this->version, $jquery_footer);

				$this->enqueued_js_form_public = true;
			}

			// CSS - Layout
			if(!$this->enqueued_css_layout && apply_filters('wsf_enqueue_css_layout', $this->enqueue_css_layout)) {

				if(WS_Form_Common::option_get('css_layout', true) && (WS_Form_Common::option_get('framework', 'ws-form') == 'ws-form')) {

					if($this->customizer || ($this->css_inline && !is_admin())) {

						add_action('wp_footer', function() {

							// Output public CSS
							$ws_form_css = new WS_Form_CSS();
							$css = $ws_form_css->get_public();
							echo $ws_form_css->inline($css);	// phpcs:ignore

						}, 100);

					} else {

						wp_enqueue_style($this->plugin_name . '-css-layout', WS_Form_Common::get_api_path('helper/ws_form_css'), array(), $this->version, 'all');
					}
				}
	
				$this->enqueued_css_layout = true;
			}

			// CSS - Skin
			if(!$this->enqueued_css_skin && apply_filters('wsf_enqueue_css_skin', $this->enqueue_css_skin)) {

				if(WS_Form_Common::option_get('css_skin', true) && (WS_Form_Common::option_get('framework', 'ws-form') == 'ws-form')) {

					if($this->customizer || ($this->css_inline && !is_admin())) {

						add_action('wp_footer', function() {

							// Output public CSS
							$ws_form_css = new WS_Form_CSS();

							$css_skin = $ws_form_css->get_skin();
							echo $ws_form_css->inline($css_skin);	// phpcs:ignore

							if(is_rtl()) {

								$css_skin_rtl = $ws_form_css->get_skin_rtl();
								echo $ws_form_css->inline($css_skin_rtl);	// phpcs:ignore
							}

						}, 100);

					} else {

						wp_enqueue_style($this->plugin_name . '-css-skin', WS_Form_Common::get_api_path('helper/ws_form_css_skin'), array(), $this->version, 'all');

						if(is_rtl()) {

							wp_enqueue_style($this->plugin_name . '-css-skin-rtl', WS_Form_Common::get_api_path('helper/ws_form_css_skin_rtl'), array(), $this->version, 'all');
						}
					}
				}

				$this->enqueued_css_skin = true;
			}
		}

		// Enqueue - Debug
		public function wp_scripts_debug() {

			global $wp_scripts, $wp_styles;

			echo '<table><thead><tr><th>Handle</th><th>URL</th><th>Dependencies</th></thead><tbody>';

			foreach($wp_scripts->registered as $registered) {

				echo sprintf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", esc_html($registered->handle), esc_html($registered->src), esc_html(implode(', ', $registered->deps)));
			}

			echo '</tbody></table>';
		}

		// Form - Divi - AJAX - Form
		public function ws_form_divi_form() {

			$atts = array('id' => WS_Form_Common::get_query_var('form_id'), 'visual_builder' => true);

			$this->form_instance = WS_Form_Common::get_query_var('instance_id');

			echo self::shortcode_ws_form($atts);	// phpcs:ignore

			wp_die();
		}

		// Form - HTML
		public function form_html($form_instance, $form_object, $element = 'form', $published = true, $preview = false, $element_id = false, $visual_builder = false) {

			if($form_object === false) { return __('Unpublished form', 'ws-form'); }
			if(!is_object($form_object)) { return __('Invalid form data', 'ws-form'); }
			if(!isset($form_object->id)) { return __('Invalid form data', 'ws-form'); }

			// Get form ID
			$form_id = $form_object->id;

			// Get element ID
			if($element_id === false) { $element_id = 'ws-form-' . $form_instance; }

			// Do not render if draft or trash
			switch($form_object->status) {

				case 'draft' :
				case 'trash' :

					if($published) { return ''; };
			}

			// Init framework config
			$framework_id = WS_Form_Common::option_get('framework', WS_FORM_DEFAULT_FRAMEWORK);
			$frameworks = WS_Form_Config::get_frameworks();
			$framework = $frameworks['types'][$framework_id];

			// Check for form attributes
			$form_attributes = '';

			if(isset($framework['form']['public']['attributes'])) {

				$form_attribute_array = $framework['form']['public']['attributes'];

				foreach($form_attribute_array as $key => $value) {

					$form_attributes .= ' ' . $key . (($value != '') ? '="' . $value . '"' : '');
				}
			}

			// Preview attribute
			if(!$published) { $form_attributes .= ' data-preview'; }

			// Visual builder attribute
			if($visual_builder) { $form_attributes .= ' data-visual-builder'; }

			// CSS - Framework
			if((isset($framework['css_file'])) && ($framework['css_file'] != '')) {

				$css_file_path = plugin_dir_url(__FILE__) . 'css/framework/' . $framework['css_file'];
				wp_enqueue_style($this->plugin_name . '-css-framework', $css_file_path, array(), $this->version, 'all');
			}

			// Form action
			$form_action = WS_Form_Common::get_api_path() . 'submit';

			// Check for custom form action
			$form_action_custom = trim(WS_Form_Common::get_object_meta_value($form_object, 'form_action', ''));
			if($form_action_custom != '') { $form_action = $form_action_custom; }

			// Filter - Form action
			$form_action = apply_filters('wsf_shortcode_form_action', $form_action);

			// Form method
			$form_method = 'POST';
			$form_method = apply_filters('wsf_shortcode_form_method', $form_method);

			// Form wrapper
			switch($element) {

				case 'form' :

					$return_value = sprintf('<form action="%s" class="wsf-form wsf-form-canvas" id="%s" data-id="%u" data-instance-id="%u" method="%s"%s></form>', esc_attr($form_action), esc_attr($element_id), esc_attr($form_id), esc_attr($form_instance), esc_attr($form_method), $form_attributes);
					break;

				default :

					$return_value = sprintf('<%1$s class="wsf-form wsf-form-canvas" id="%2$s" data-id="%3$u" data-instance-id="%4$u"%5$s></%1$s>', $element, esc_attr($element_id), esc_attr($form_id), esc_attr($form_instance), $form_attributes);
					break;
			}

			// Shortcode filter
			$return_value = apply_filters('wsf_shortcode', $return_value);

			// Build JSON
			$form_json = wp_json_encode($form_object);

			// Form data (Only render once per form ID)
			if(!isset($this->wsf_form_json[$form_id])) {

				// Form JSON
				$this->footer_js .= sprintf("window.wsf_form_json[%u] = %s;", $form_id, $form_json) . "\n";

				// Form JSON populate
				$populate_array = self::get_populate_array($form_json);
				$populate_array = apply_filters('wsf_populate', $populate_array);
				if(($populate_array !== false) && count($populate_array) > 0) {

					$this->footer_js .= sprintf("window.wsf_form_json_populate[%u] = %s;", $form_id, wp_json_encode($populate_array)) . "\n";
				}

				$this->wsf_form_json[$form_id] = true;
			}

			return $return_value;
		}
		public function localization_object($debug = false) {

			global $post, $wp_version;

			// Stats
			$ws_form_form_stat = New WS_Form_Form_Stat();

			// Localization array
			$return_array = array(

				// Nonce - WordPress
				'x_wp_nonce'			=> wp_create_nonce('wp_rest'),
				'wsf_nonce_field_name'	=> WS_FORM_POST_NONCE_FIELD_NAME,
				'wsf_nonce'				=> wp_create_nonce(WS_FORM_POST_NONCE_ACTION_NAME),

				// URL
				'url'					=>	WS_Form_Common::get_api_path(),

				// Admin framework (Fallover)
				'framework_admin'		=> 'ws-form',

				// Should framework CSS be rendered? (WS Form framework only)
				'css_framework'			=> WS_Form_Common::option_get('css_framework', true),

				// Is design enabled?
				'design'				=> (WS_Form_Common::option_get('css_skin', true)) && (WS_Form_Common::option_get('framework', 'ws-form') == 'ws-form'),

				// Max upload size
				'max_upload_size'		=> intval(WS_Form_Common::option_get('max_upload_size', 0)),

				// Field prefix
				'field_prefix'			=> WS_FORM_FIELD_PREFIX,

				// Date / time format
				'date_format'			=> get_option('date_format'),
				'time_format'			=> get_option('time_format'),
				'gmt_offset'			=> get_option('gmt_offset'),

				// Locale
				'locale'				=> get_locale(),

				// Stats
				'stat'					=> $ws_form_form_stat->form_stat_check(),

				// Skin - Grid gutter
				'skin_grid_gutter'		=> WS_Form_Common::option_get('skin_grid_gutter', true),

				// RTL
				'rtl'					=> is_rtl()
			);
			// WP Editor
			if(
				apply_filters('wsf_enqueue_js_wp_editor', $this->enqueue_js_wp_editor) &&
				version_compare($wp_version, '4.8', '>=') &&
				user_can_richedit()
			) {

				// TinyMCE toolbars - Compact
				$return_array['tinymce_toolbar1_compact'] = apply_filters('wsf_tinymce_toolbar1_compact', 'bold italic underline strikethrough | bullist numlist | alignleft aligncenter alignright alignjustify | link unlink | undo redo | fullscreen');
				$return_array['tinymce_toolbar2_compact'] = apply_filters('wsf_tinymce_toolbar2_compact', '');
				$return_array['tinymce_toolbar3_compact'] = apply_filters('wsf_tinymce_toolbar3_compact', '');
				$return_array['tinymce_toolbar4_compact'] = apply_filters('wsf_tinymce_toolbar4_compact', '');

				// TinyMCE plugins - Compact
				$return_array['tinymce_plugins_compact'] = apply_filters('wsf_tinymce_plugins_full', 'lists media tabfocus fullscreen wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview');
	
				// TinyMCE toolbars - Full
				$return_array['tinymce_toolbar1_full'] = apply_filters('wsf_tinymce_toolbar1_full', 'formatselect bold italic underline strikethrough | bullist numlist | alignleft aligncenter alignright alignjustify | link unlink | wp_adv');
				$return_array['tinymce_toolbar2_full'] = apply_filters('wsf_tinymce_toolbar1_full', 'forecolor | pastetext | hr | removeformat charmap | outdent indent blockquote | wp_more | undo redo | fullscreen');
				$return_array['tinymce_toolbar3_full'] = apply_filters('wsf_tinymce_toolbar1_full', '');
				$return_array['tinymce_toolbar4_full'] = apply_filters('wsf_tinymce_toolbar1_full', '');

				// TinyMCE plugins - Full
				$return_array['tinymce_plugins_full'] = apply_filters('wsf_tinymce_plugins_full', 'charmap colorpicker hr lists media paste tabfocus textcolor fullscreen wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview');
			}

			// Pass through post ID
			if(isset($post) && ($post->ID > 0)) {

				$return_array['post_id'] = $post->ID;
			}

			return $return_array;
		}

		// Populate from action
		public function get_populate_array($form_json) {

			// Get populate data
			$form_object = json_decode($form_json);

			// Check form populate is enabled
			$form_populate_enabled = WS_Form_Common::get_object_meta_value($form_object, 'form_populate_enabled', '');
			if(!$form_populate_enabled) { return false; }

			// Read form populate data - Action ID
			$form_populate_action_id = WS_Form_Common::get_object_meta_value($form_object, 'form_populate_action_id', '');
			if($form_populate_action_id == '') { return false; }
			if(!isset(WS_Form_Action::$actions[$form_populate_action_id])) { return false; }

			// Get action
			$action = WS_Form_Action::$actions[$form_populate_action_id];

			// Check get method exists
			if(!method_exists($action, 'get')) { return false; }

			// Read form populate data - List ID
			$action_get_require_list_id = isset($action->get_require_list_id) ? $action->get_require_list_id : true;
			if($action_get_require_list_id) {

				$form_populate_list_id = WS_Form_Common::get_object_meta_value($form_object, 'form_populate_list_id', '');
				if($form_populate_list_id == '') { return false; }
			}

			// Read form populate data - Field mapping
			$form_populate_field_mapping = WS_Form_Common::get_object_meta_value($form_object, 'form_populate_field_mapping', array());

			if(method_exists($action, 'get_tags')) {

				// Read form populate data - Tag mapping
				$form_populate_tag_mapping = WS_Form_Common::get_object_meta_value($form_object, 'form_populate_tag_mapping', array());
			}

			// Get user data
			$current_user = wp_get_current_user();

			// Set list ID
			if($action_get_require_list_id) {

				$action->list_id = $form_populate_list_id;
			}

			// Try to get action data
			try {

				$get_array = $action->get($form_object, $current_user);

			} catch(Exception $e) { return false; }

			if(
				($get_array === false) ||
				!is_array($get_array)

			) { return false; }

			$data = array();

			// Process field mapping data
			$field_mapping_lookup = array();
			if(is_array($form_populate_field_mapping)) {

				foreach($form_populate_field_mapping as $field_mapping) {

					$action_field = $field_mapping->form_populate_list_fields;
					$ws_form_field = $field_mapping->ws_form_field;

					if(!isset($field_mapping_lookup[$action_field])) {

						$field_mapping_lookup[$action_field] = $ws_form_field;
					}
				}
			}

			// Map fields
			if(
				isset($get_array['fields']) &&
				is_array($get_array['fields'])
			) {

				foreach($get_array['fields'] as $id => $value) {

					if($id === '') { continue; }

					if(is_numeric($id)) {

						$data[WS_FORM_FIELD_PREFIX . $id] = $value;

					} else {

						if(isset($field_mapping_lookup[$id])) {

							$data[WS_FORM_FIELD_PREFIX . $field_mapping_lookup[$id]] = $value;
						}
					}
				}
			}

			// Map fields (Repeatable)
			if(
				isset($get_array['fields_repeatable']) &&
				is_array($get_array['fields_repeatable'])
			) {

				foreach($get_array['fields_repeatable'] as $id => $values) {

					if($id === '') { continue; }

					if(!is_array($values)) { continue; }

					foreach($values as $repeatable_index => $value) {

						if(is_numeric($id)) {

							$data[WS_FORM_FIELD_PREFIX . $id . '_' . ($repeatable_index + 1)] = $value;

						} else {

							if(isset($field_mapping_lookup[$id])) {

								$data[WS_FORM_FIELD_PREFIX . $field_mapping_lookup[$id] . '_' . ($repeatable_index + 1)] = $value;
							}
						}
					}
				}
			}

			// Tag mapping
			if(
				method_exists($action, 'get_tags') &&
				is_array($form_populate_tag_mapping) &&
				isset($get_array['tags']) &&
				is_array($get_array['tags'])
			) {

				$tag_mapping_array = array();
				foreach($get_array['tags'] as $id => $value) {

					if($value) {

						$tag_mapping_array[] = $id;
					}
				}

				foreach($form_populate_tag_mapping as $tag_mapping) {

					$ws_form_field = $tag_mapping->ws_form_field;

					$data[WS_FORM_FIELD_PREFIX . $ws_form_field] = $tag_mapping_array;
				}
			}

			// Section repeatable
			if(
				isset($get_array['section_repeatable']) &&
				is_array($get_array['section_repeatable'])
			) {

				$section_repeatable = $get_array['section_repeatable'];
			}

			return array('action_label' => $action->label, 'data' => $data, 'section_repeatable' => $section_repeatable);
		}

		public function nonce_user_logged_out($uid = 0, $action = false) {

			return ($action === WS_FORM_POST_NONCE_ACTION_NAME) ? 0 : $uid;
		}

	}
