<?php

	class WS_Form_Wizard extends WS_Form_Core {

		public $id = false;
		public $label = '';
		public $pro_required = false;
		public $svg = '';
		public $form = '';

		public $action_id = false;

		private $config;
		private $config_file;

		public function __construct() {

			global $wpdb;

			$this->config_files = array(WS_FORM_PLUGIN_DIR_PATH . 'includes/wizard/config.json');
		}

		// Read wizard
		public function read() {

			self::db_check_id();

			$config_full = self::read_config();

			foreach($config_full as $wizard_category) {

				$file_path = $wizard_category->file_path;

				foreach($wizard_category->wizards as $wizard) {

					if($wizard->id === $this->id) {

						// Set class variables
						$this->id = $wizard->id;
						$this->label = $wizard->label;

						// Read file JSON
						$file_json = $wizard->file_json;
						$file = $file_path . $file_json;
						if(!file_exists($file)) { self::db_throw_error(sprintf(__('Unable to read wizard JSON file: %s', 'ws-form'), $file)); }
						$form = file_get_contents($file);
						$this->form = json_decode($form);

						return $this;
					}
				}
			}

			self::db_throw_error(__('Wizard not found', 'ws-form'));
		}

		// Read config
		public function read_config($config_files = false) {

			// Run filter (to allow appending of additional config files)
			$this->config_files = ($config_files === false) ? apply_filters('wsf_wizard_config_files', $this->config_files) : $config_files;

			$config = array();

			$popular_wizards = array();

			foreach($this->config_files as $config_file) {

				// Read config file
				$config_file_string = file_get_contents($config_file);
				if($config_file_string === false) { self::db_throw_error(sprintf(__('Unable to read wizard config file: %s', $config_file), 'ws-form')); }

				// JSON decode
				$config_object = json_decode($config_file_string);
				if(is_null($config_object)) { self::db_throw_error(sprintf(__('Unable to JSON decode wizard config file: %s', $config_file), 'ws-form')); }

				foreach($config_object->wizard_categories as $wizard_category_key => $wizard_category) {

					$file_path = $config_object->wizard_categories[$wizard_category_key]->file_path;
					$file_path = sprintf('%s/%s', dirname($config_file), $file_path);
					$config_object->wizard_categories[$wizard_category_key]->file_path = $file_path;

					$wizard_category_file_path = $wizard_category->file_path;

					// Sort wizards
					usort($wizard_category->wizards, function($a, $b) {

						return ($a->label === $b->label) ? 0 : ($a->label > $b->label);
					});

					foreach($wizard_category->wizards as $wizard_key => $wizard) {

						// Build SVG
						$file_svg = isset($wizard->file_svg) ? $wizard->file_svg : '';
						$wizard_svg = '';
						if(!empty($file_svg)) {

							$file = $file_path . $file_svg;
							if(!file_exists($file)) { self::db_throw_error(sprintf(__('Unable to read wizard SVG file: %s', 'ws-form'), $file)); }
							$wizard_svg = file_get_contents($file);
						}
						$config_object->wizard_categories[$wizard_category_key]->wizards[$wizard_key]->svg = $wizard_svg;

						// Pro required
						$config_object->wizard_categories[$wizard_category_key]->wizards[$wizard_key]->pro_required = !WS_Form_Common::is_edition((isset($wizard->pro_required) ? $wizard->pro_required : false) ? 'pro' : 'basic');

						// Preview URL
						$preview_url = isset($wizard->preview_url) ? $wizard->preview_url : false;
						if($preview_url === true) {

							$preview_url = WS_Form_Common::get_plugin_website_url(sprintf('/template/%s/', sanitize_title($wizard->label)), 'add_form');
						}
						$config_object->wizard_categories[$wizard_category_key]->wizards[$wizard_key]->preview_url = $preview_url;

						// Popular?
						$popular = isset($wizard->popular) ? $wizard->popular : false;
						if($popular) {

							// Prefix wizard file path with category file path
							$wizard->file_json = $wizard_category_file_path . $wizard->file_json;

							$popular_wizards[] = $wizard;
						}
					}
				}

				$config = array_merge($config, $config_object->wizard_categories);
			}

			// Build popular category
			if(count($popular_wizards) > 0) {

				// Sort wizards
				usort($popular_wizards, function($a, $b) {

					return ($a->label === $b->label) ? 0 : ($a->label > $b->label);
				});

				// Insert at beginning of config
				array_unshift($config, (object) array(

					'id'			=>	'popular',
					'label' 		=> 	'Popular',
					'label_singular'=>	'Popular',
					'file_path'		=>	'',
					'wizards'		=>	$popular_wizards
				));
			}

			return $config;
		}

		// Build SVG from form
		public function get_svg() {

			self::db_check_id();
			self::read();

			$ws_form_form = new WS_Form_Form();
			$svg = $ws_form_form->get_svg_from_form_object($this->form, false);
			$svg = str_replace('#label', $this->label, $svg);

			return $svg;
		}

		// Get wizards for each action installed
		public function db_get_actions() {

			$return_array = array();

			if(!isset(WS_Form_Action::$actions)) { parent::db_throw_error(__('No actions installed', 'ws-form')); }

			// Capabilities required of each action
			$capabilities_required = array('get_lists', 'get_list', 'get_list_fields');

			// Get actions that have above capabilities
			$actions = WS_Form_Action::get_actions_with_capabilities($capabilities_required);

			// Run through each action
			foreach($actions as $action) {

				// Add to return array
				$return_array[] = (object) array(

					'id'					=>	$action->id,
					'label'					=>	$action->label,
					'reload'				=>	isset($action->add_new_reload) ? $action->add_new_reload : true,
					'list_sub_modal_label'	=>	isset($action->list_sub_modal_label) ? $action->list_sub_modal_label : false
				);
			}

			return $return_array;
		}

		// Get wizards for each action installed
		public function db_get_action_wizards() {

			$return_array = array();

			if(!isset(WS_Form_Action::$actions)) { parent::db_throw_error(__('No actions installed', 'ws-form')); }

			// Check action ID
			self::db_check_action_id();

			// Capabilities required of each action
			$capabilities_required = array('get_lists', 'get_list', 'get_list_fields');

			// Get actions that have above capabilities
			$actions = WS_Form_Action::get_actions_with_capabilities($capabilities_required);

			if(!isset($actions[$this->action_id])) { parent::db_throw_error(__('Action not compatible with this function', 'ws-form')); }

			$action = $actions[$this->action_id];

			// Labels
			$field_label = isset($action->field_label) ? $action->field_label : false;
			$record_label = isset($action->record_label) ? $action->record_label : false;

			// Get lists
			$lists = $action->get_lists();

			foreach($lists as $list) {

				// Add to return array
				$return_array[] = array(

					'id'			=>	$list['id'],
					'label'			=>	$list['label'],
					'field_count'	=>	$list['field_count'],
					'record_count'	=>	$list['record_count'],
					'list_sub'		=>	isset($list['list_sub']) ? $list['list_sub'] : false,
					'svg'			=>	WS_Form_Action::get_svg($this->action_id, $list['id'], $list['label'], $list['field_count'], $list['record_count'], $field_label, $record_label)
				);
			}

			return $return_array;
		}

		// Render wizard category
		public function wizard_category_render($wizard_category, $button_class = 'wsf-button wsf-button-primary wsf-button-full') {

			// SVG defaults
			$svg_width = 140;
			$svg_height = 180;

			// Colors
			$color_default = WS_Form_Common::option_get('skin_color_default');
			$color_default_inverted = WS_Form_Common::option_get('skin_color_default_inverted');
			$color_default_lighter = WS_Form_Common::option_get('skin_color_default_lighter');
?>
<!-- Blank -->
<li>
<div class="wsf-template" data-id="blank">
	<svg class="wsf-responsive" viewBox="0 0 <?php echo esc_attr($svg_width); ?> <?php echo esc_attr($svg_height); ?>"><rect height="100%" width="100%" fill="#fff"/><text fill="<?php echo esc_attr($color_default) ?>'" class="wsf-wizard-title"><tspan x="<?php echo is_rtl() ? esc_attr($svg_width - 5) : 5; ?>" y="16"><?php esc_html_e('Blank', 'ws-form'); ?></tspan></text></svg>
	<div class="wsf-template-actions">
		<button class="wsf-button wsf-button-primary wsf-button-full" data-action="wsf-add-blank" data-id="blank"><?php esc_html_e('Use Template', 'ws-form'); ?></button>
	</div>
</div>
</li>
<!-- /Blank -->
<?php
			if(isset($wizard_category->wizards)) {

				// Loop through wizards
				foreach ($wizard_category->wizards as $wizard)  {

?><li<?php if($wizard->pro_required) { ?> class="wsf-pro-required"<?php } ?>>
<div class="wsf-template" title="<?php echo esc_html($wizard->label); ?>">
<?php
					// Parse SVG
					$svg = $wizard->svg;

					if(empty($svg)) {

						$this->id = $wizard->id;
						$svg = $this->get_svg();
					}
					$svg = str_replace('#label', htmlentities($wizard->label), $svg);
					echo $svg;	 // phpcs:ignore
?>
<div class="wsf-template-actions">
<?php
					if($wizard->pro_required) {
?>
	<a class="wsf-button wsf-button-primary wsf-button-full" href="<?php echo esc_attr(WS_Form_Common::get_plugin_website_url('', 'add_form')); ?>" target="_blank"><?php esc_html_e('Upgrade to PRO', 'ws-form'); ?></a>
<?php
					} else {
?>
	<button class="wsf-button wsf-button-primary wsf-button-full" data-action="wsf-add-wizard" data-id="<?php echo esc_attr($wizard->id); ?>"><?php esc_html_e('Use Template', 'ws-form'); ?></button>
<?php
					}

					if($wizard->preview_url !== false) {
?>
	<a class="wsf-preview" href="<?php echo esc_attr($wizard->preview_url); ?>" target="_blank"><?php WS_Form_Common::render_icon_16_svg('visible'); ?> <?php esc_html_e('Preview Template', 'ws-form'); ?></a>
<?php
					}
?>
	</div>
</div>
</li>
<?php
				}
			}
		}

		// Check id
		public function db_check_id() {

			if(empty($this->id)) { parent::db_throw_error(__('Invalid ID', 'ws-form')); }
			return true;
		}

		// Check action_id
		public function db_check_action_id() {

			if($this->action_id === false) { parent::db_throw_error(__('Invalid action ID', 'ws-form')); }
			return true;
		}
	}