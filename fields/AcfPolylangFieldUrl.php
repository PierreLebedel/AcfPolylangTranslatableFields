<?php

if( !defined('ABSPATH') ) exit;

if( !class_exists('AcfPolylangFieldUrl') ){
	
	class AcfPolylangFieldUrl extends acf_field_url {

		use AcfPolylangFieldTrait;

		function initialize(){
			// acf field init
			parent::initialize();
		
			$this->name = 'acf_polylang_url';
			$this->label = __("URL",'acfpll');

			//$this->defaults['another_default_option'] = '';
			
			// common acf_pll init
			$this->commonInitialize();
		}

		public function render_field($field){
			$field['type'] = 'url';
			$this->renderLanguageField($field);
		}
	
	}

	new AcfPolylangFieldUrl();
}


