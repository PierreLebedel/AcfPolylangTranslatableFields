<?php
/**
 * Plugin Name: ACF Polylang translatable fields
 * Plugin URI: 
 * Description: Adds translatable fields to ACF for non-translated contents using Polylang
 * Version: 1.0.7
 * Author: Pierre Lebedel
 * Author URI: https://www.pierrelebedel.fr
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: acfpll
 * Domain Path: /languages
 */

if( !defined('ABSPATH') ) exit;

if( !class_exists('AcfPolylangTranslatableFieldsPlugin') ){

	class AcfPolylangTranslatableFieldsPlugin {

		public function __construct(){
			add_action('plugin_loaded', array($this, 'loadTextdomain'));
			add_action('acf/include_field_types', array($this, 'includeFields'));
		}

		public static function getSettings(){
			return array(
				'version' => '1.0.7',
				'url'	  => plugin_dir_url(__FILE__),
				'path'	  => plugin_dir_path(__FILE__)
			);
		}

		public function loadTextdomain(){
			load_plugin_textdomain('acfpll', false, dirname(plugin_basename(__FILE__)).'/languages/'); 
		}
	
		public function includeFields( $version = false ) {
			if( $version!=5 ) return;
	
			include_once( ABSPATH.'wp-admin/includes/plugin.php' );
	
			if ( !is_plugin_active('polylang/polylang.php') ) {
				return;
			}
	
			if ( 
				!is_plugin_active('advanced-custom-fields/acf.php') &&
				!is_plugin_active('advanced-custom-fields-pro/acf.php')
			) {
				return;
			}
						
			// includes
			include_once('classes/AcfPolylangFieldUtils.php');
			include_once('classes/AcfPolylangFieldTrait.php');
	
			include_once('fields/AcfPolylangFieldText.php');
			include_once('fields/AcfPolylangFieldTextarea.php');
			include_once('fields/AcfPolylangFieldNumber.php');
			include_once('fields/AcfPolylangFieldEmail.php');
			include_once('fields/AcfPolylangFieldUrl.php');
	
		}

		
		
	}
	
	new AcfPolylangTranslatableFieldsPlugin();

}
