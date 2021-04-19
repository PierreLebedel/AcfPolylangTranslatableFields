<?php

if( !defined('ABSPATH') ) exit;

if( !class_exists('AcfPolylangFieldTextarea') ){
	
	class AcfPolylangFieldTextarea extends acf_field_textarea {

		use AcfPolylangFieldTrait;

		function initialize(){
			// acf field init
			parent::initialize();
		
			$this->name = 'acf_polylang_textarea';
			$this->label = __("Text Area",'acfpll');

			//$this->defaults['another_default_option'] = '';
			
			// common acf_pll init
			$this->commonInitialize();
		}

		public function render_field($field){
			$field['type'] = 'text';
			$this->renderLanguageField($field);
		}





	
	}

	new AcfPolylangFieldTextarea();
}


