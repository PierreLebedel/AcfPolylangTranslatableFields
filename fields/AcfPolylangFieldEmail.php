<?php

if( !defined('ABSPATH') ) exit;

if( !class_exists('AcfPolylangFieldEmail') ){
	
	class AcfPolylangFieldEmail extends acf_field_email {

		use AcfPolylangFieldTrait;

		function initialize(){
			// acf field init
			parent::initialize();
		
			$this->name = 'acf_polylang_email';
			$this->label = __("Email",'acfpll');

			//$this->defaults['another_default_option'] = '';
			
			// common acf_pll init
			$this->commonInitialize();
		}

		public function render_field($field){
			$field['type'] = 'email';
			$this->renderLanguageField($field);
		}
	
	}

	new AcfPolylangFieldEmail();
}


