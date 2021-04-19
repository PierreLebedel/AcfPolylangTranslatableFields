<?php

if( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists('AcfPolylangFieldUtils') ){
	class AcfPolylangFieldUtils {

        /**
         * Extract value from a (maybe null) values array
         */
        public static function getFieldValue($locale, $values_array){
			if( is_array($values_array) ){
				if(array_key_exists($locale, $values_array)){
					return $values_array[ $locale ];
				}
			}
			return '';
		}

        /**
         * Get Polylang current locale (empty on admin and can be empty on front)
         */
        public static function getCurrentLocale(){
            $current = pll_current_language('locale');
            return $current;
        }

        /**
         * Get Polylang default locale
         */
        public static function getDefaultLocale(){
            $default = pll_default_language('locale');
            return $default;
        }

        /**
         * List Polylang configurated languages for the field loop
         */
        public static function getActivatedLanguages(){
            $languages = array();
            $default = self::getDefaultLocale();
            $current = self::getCurrentLocale();

            $plllangs = pll_languages_list(array('fields' => array())); 
            /**
             * @var PLL_Language[] $plllangs
             */
            foreach($plllangs as $lang){
                $languages[ $lang->locale ] = (object)array(
                    'locale' => $lang->locale,
                    'flag' => $lang->flag,
                    'name' => $lang->name,
                    'is_default' => ($lang->locale==$default),
                    'is_current' => ($lang->locale==$current),
                );
            }

            return $languages;
        }

	}
}

