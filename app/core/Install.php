<?php

	namespace App\Core;
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Exception\ParseException;


	class Install
	{
		private static $app_root;
		private static $config;

		static public function installDependences()
		{	
			
			self::setConfig();
			self::installLibraies();	

		}

		static function setConfig() : void
		{
			self::$app_root = realpath($_SERVER['DOCUMENT_ROOT']);
			self::$config  	= Yaml::parseFile(self::$app_root . '/conf/settings.yaml');
		}

		static function installLibraies()
		{
			$theme_dir 	  	= self::$app_root . "/app/themes/". strtolower(self::$config['theme']['active_theme']);
			$theme_config 	= Yaml::parseFile($theme_dir . '/settings.yaml');
			$required_libraries = $theme_config['require'];
			
			error_log('Installing dependences...', 0);

			

			foreach ($required_libraries as $library) {

				if(!$library['public']) $libaries_path = $theme_dir . '/libraries/';

				if($library['public']) $libaries_path = self::$app_root . '/public/resources/';

				if (!file_exists($libaries_path)) mkdir($libaries_path);

				error_log($library['name'] . '...', 0);
				
				if ($library['copy_all']) {
					error_log('Unsuported feature...' . PHP_EOL, 0);

				} else {

					$library_path = $libaries_path . $library['name'];
					$library_js_path = $library_path . '/js/';
					$library_css_path = $library_path . '/css/';

					if (!file_exists($library_path)) mkdir($library_path);
					
					if (isset($library['js'])) {
						if (!file_exists($library_js_path)) mkdir($library_js_path);
						foreach ($library['js'] as $js_libary) {
							$file_name = explode('/', $js_libary);
							copy(self::$app_root . '/vendor/'. $library['vendor_dir'] . '/' . $js_libary, $library_js_path. end($file_name));
						
						}
					}

					if (isset($library['css'])) {
						if (!file_exists($library_css_path)) mkdir($library_css_path);
						foreach ($library['css'] as $css_libary) {
							$file_name = explode('/', $css_libary);
							copy(self::$app_root . '/vendor/'. $library['vendor_dir'] . '/' . $css_libary, $library_css_path. end($file_name));
						
						}
					}
				}
			
			}

			error_log('Done' . PHP_EOL, 0);
		}
	}