<?php

if (!defined('ABSPATH')) exit;

if (!class_exists('AcfPolylangFieldUrl')) {

	class AcfPolylangFieldUrl extends acf_field_url
	{

		use AcfPolylangFieldTrait;

		function initialize()
		{
			// acf field init
			parent::initialize();

			$this->name = 'acf_polylang_url';
			$this->label = __("URL", 'acfpll');

			//$this->defaults['another_default_option'] = '';

			// common acf_pll init
			$this->commonInitialize();
		}

		public function render_field($field)
		{
			$field['type'] = 'url';
			$this->renderLanguageField($field);
		}

		public function format_value($values, $post_id, $field, $escape_html = false)
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

			$method = new \ReflectionMethod('acf_field_url', 'format_value');

			if ($method->getNumberOfParameters() == 4) {
				return parent::format_value($value, $post_id, $field, $escape_html);
			}

			return parent::format_value($value, $post_id, $field);
		}
	}

	new AcfPolylangFieldUrl();
}
