<?php

	namespace App\Core;
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Exception\ParseException;


	class Install
	{
		private $config;

		static public function installDependences()
		{
			$app_root 		= realpath($_SERVER['DOCUMENT_ROOT']);
			$app_config  	= Yaml::parseFile($app_root . '/conf/settings.yaml');
			$theme_dir 	  	= $app_root . "/app/themes/". strtolower($app_config['theme']['active_theme']);
			$theme_config 	= Yaml::parseFile($theme_dir . '/settings.yaml');
			$required_libraries = self::arraySortByField($theme_config['require'], 'load_order');

			error_log('Installing dependences...' . PHP_EOL, 0);

			if (!file_exists($theme_dir . '/libraries/')) mkdir($theme_dir . '/libraries/');

			foreach ($required_libraries as $library) {

				if (!file_exists($theme_dir . '/libraries/' . $library['name'])) mkdir($theme_dir . '/libraries/' . $library['name']);
				if (!file_exists($theme_dir . '/libraries/' . $library['name'] . '/js/')) mkdir($theme_dir . '/libraries/' . $library['name'] . '/js/');
				if (!file_exists($theme_dir . '/libraries/' . $library['name'] . '/css/')) mkdir($theme_dir . '/libraries/' . $library['name'] . '/css/');

				foreach ($library['js'] as $js_libary) {

					copy($app_root . '/vendor/'. $library['vendor_dir'] . '/' . $js_libary, $theme_dir . '/libraries/' . $library['name'] . '/js/' . $js_libary);
				
				}
			
			}

		}

		static public function arraySortByField($array = array(), $field): array
		{
			$keys = array();
			$ordererArray = array();

		    foreach ($array as $key => $row){
		    	$keys[$key] = $row[$field];
		    }

    		asort($keys);

		    foreach ($keys as $key => $row){
		      $ordererArray[] = $array[$key];
		    } 
		    return $ordererArray;
		}
	}