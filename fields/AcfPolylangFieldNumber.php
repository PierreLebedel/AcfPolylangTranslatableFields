<?php

if( !defined('ABSPATH') ) exit;

if( !class_exists('AcfPolylangFieldNumber') ){
	
	class AcfPolylangFieldNumber extends acf_field_number {

		use AcfPolylangFieldTrait;

		function initialize(){
			// acf field init
			parent::initialize();
		
			$this->name = 'acf_polylang_number';
			$this->label = __("Number",'acfpll');

			//$this->defaults['another_default_option'] = '';
			
			// common acf_pll init
			$this->commonInitialize();
		}

		public function render_field($field){
			$field['type'] = 'number';
			$this->renderLanguageField($field);
		}
	
	}

	new AcfPolylangFieldNumber();
}


