<?php

if (! defined('ABSPATH')) exit;

if (!trait_exists('AcfPolylangFieldTrait')) {

	trait AcfPolylangFieldTrait
	{

		public function commonInitialize()
		{
			$this->label .= ' (AcfPll)';
			$this->category = 'Polylang Translatable';

			if (!$this->defaults) $this->defaults = array();
			$this->defaults = array_merge(array(
				'empty_value_behavior' => "empty",
			), $this->defaults);
		}

		function render_field_settings($field)
		{
			parent::render_field_settings($field);
			$this->commonRenderFieldSettings($field);
		}

		public function commonRenderFieldSettings($field)
		{
			acf_render_field_setting($field, array(
				'label' => __('Empty value behavior', 'acfpll'),
				'instructions' => __('Use the default language field value if empty?', 'acfpll'),
				'type' => 'radio',
				'name' => 'empty_value_behavior',
				'choices' => array(
					'empty' => __("Empty value", 'acfpll'),
					'default_lang' => __("Default language value", 'acfpll')
				),
				'layout' => 'horizontal'
			));
		}

		public function render_field($field)
		{
			$this->renderLanguageField($field);
		}

		public function renderLanguageField($field)
		{
			$langs = AcfPolylangFieldUtils::getActivatedLanguages();
			//echo '<pre>'.print_r($langs,true).'</pre>';

?><div class="acf-polylang-translatable-tabs">

				<ul class="wp-tab-bar">
					<?php foreach ($langs as $lang): ?>
						<li class="<?php echo ($lang->is_default) ? 'wp-tab-active' : ''; ?>">
							<a href="#<?php echo $field['key'] . $lang->locale; ?>">
								<?php echo $lang->flag; ?>
								<span><?php echo $lang->name; ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul><?php

						foreach ($langs as $lang): ?>

					<div class="wp-tab-panel" id="<?php echo $field['key'] . $lang->locale; ?>"
						<?php echo ($lang->is_default) ? '' : 'style="display: none;"'; ?>>

						<?php $this->renderLanguageLoopField($field, $lang->locale); ?>

					</div>

				<?php endforeach; ?>

			</div><?php
				}

				public function renderLanguageLoopField($field, $locale)
				{
					$field['name'] = $field['name'] . '[' . $locale . ']';
					$field['value'] = AcfPolylangFieldUtils::getFieldValue($locale, $field['value']);

					return parent::render_field($field);
				}

				public function load_value($values_string, $post_id, $field)
				{
					$values_array = AcfPolylangFieldUtils::decodeValues($values_string, true);
					return $values_array;
				}

				public function update_value($inputs, $post_id, $field)
				{

					$previous_values = get_field($field['name'], $post_id, false);
					if (!is_array($previous_values)) $previous_values = array();

					if (is_array($inputs)) {
						$valid_inputs = array();
						if (!empty($inputs)) {
							foreach ($inputs as $k => $v) {
								$locale = AcfPolylangFieldUtils::getLocaleFormSlug($k);
								$valid_inputs[$locale] = $v;
							}
						}
						$values = array_merge($previous_values, $valid_inputs);
					} else {
						// if string/int value, we store on current user locale
						$current = AcfPolylangFieldUtils::getCurrentLocale();
						if (!$current) {
							$current = AcfPolylangFieldUtils::getDefaultLocale();
						}

						$values = array_merge($previous_values, array(
							$current => $inputs,
						));
					}

					$encoded = AcfPolylangFieldUtils::encodeValues($values);
					return $encoded;
				}

				public function format_value($values, $post_id, $field)
				{
					if (empty($values)) {
						return '';
					}

					$currentlocale = AcfPolylangFieldUtils::getCurrentLocale();
					$value = '';

					if ($currentlocale) {
						$value = AcfPolylangFieldUtils::getFieldValue($currentlocale, $values);
					}

					if (empty($value) && $field['empty_value_behavior'] === 'default_lang') {
						$defaultlocale = AcfPolylangFieldUtils::getDefaultLocale();
						$value = AcfPolylangFieldUtils::getFieldValue($defaultlocale, $values);
					}

					if (is_callable('parent::format_value')) {
						return parent::format_value($value, $post_id, $field);
					}

					return $value;
				}

				public function validate_value($valid, $values, $field, $input)
				{
					$commonValid = $this->commonValidateField($valid, $values, $field, $input);
					if (!$commonValid) return false;

					return $valid;
				}

				public function commonValidateField($valid, $values, $field, $input)
				{
					if ($field['required']) {
						if ($field['empty_value_behavior'] === 'default_lang') {
							/**
							 * If we use default lang value, only the default lang value is required
							 */
							$defaultlocale = AcfPolylangFieldUtils::getDefaultLocale();
							if (!isset($values[$defaultlocale]) || empty($values[$defaultlocale])) {
								$valid = false;
							}
						} else {
							/**
							 * empty_value_behavior = empty
							 * If we dont use default lang value, all the languages are required
							 */
							foreach ($values as $locale => $value) {
								if ($field['required'] && empty($value)) {
									$valid = false;
								}
							}
						}
					}

					return $valid;
				}

				public function input_admin_enqueue_scripts()
				{
					$settings = AcfPolylangTranslatableFieldsPlugin::getSettings();

					$url     = $settings['url'];
					$version = $settings['version'];

					// register & include JS
					wp_register_script('acfpll', "{$url}assets/js/input.js", array('acf-input'), $version);
					wp_enqueue_script('acfpll');

					// register & include CSS
					wp_register_style('acfpll', "{$url}assets/css/input.css", array('acf-input'), $version);
					wp_enqueue_style('acfpll');
				}
			}
		}
