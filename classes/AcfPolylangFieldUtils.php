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
                    'slug' => $lang->slug,
                    'is_default' => ($lang->locale==$default),
                    'is_current' => ($lang->locale==$current),
                );
            }

            return $languages;
        }

        public static function getLocaleFormSlug($slug){
            $languages = self::getActivatedLanguages();
            if( array_key_exists($slug, $languages) ){
                return $slug;
            }
            foreach($languages as $lang){
                if( strtolower($lang->slug)==strtolower($slug) ){
                    return $lang->locale;
                }
            }
            return false;
        }

        public static function encodeValues($values_array=array()){
            $values_string = '';
            if(!empty($values_array)){
                foreach($values_array as $locale=>$value){
                    if(empty($value)) continue;
                    $values_string .= '<!--:'.$locale.'-->'.$value.'<!--:-->';
                }
            }
            return $values_string;
        }

        public static function decodeValues($values_string=''){
            //$locale_regex = '([a-z]{2}_[A-Z]{2})';
            $string_regex = '/<!--:(\w{5})-->(.*)<!--:-->/U';
            preg_match_all($string_regex, $values_string, $matches);
            //dump($matches);

            if(count($matches)==3){
                $response = array();
                foreach($matches[0] as $k=>$v){
                    $response[ $matches[1][$k] ] = $matches[2][$k];
                }
                return $response;
            }

            return false;
        }

	}
}

