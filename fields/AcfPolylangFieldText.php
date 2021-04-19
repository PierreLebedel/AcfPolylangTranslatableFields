<?php

if( !defined('ABSPATH') ) exit;

if( !class_exists('AcfPolylangFieldText') ){
	
	class AcfPolylangFieldText extends acf_field_text {

		use AcfPolylangFieldTrait;

		function initialize(){
			// acf field init
			parent::initialize();
		
			$this->name = 'acf_polylang_text';
			$this->label = __("Text",'acfpll');

			//$this->defaults['another_default_option'] = '';
			
			// common acf_pll init
			$this->commonInitialize();
		}

		public function render_field($field){
			$field['type'] = 'text';
			$this->renderLanguageField($field);
		}





	
	}

	new AcfPolylangFieldText();
}


