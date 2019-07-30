<?php
 	namespace App\Core;
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Exception\ParseException;

	class Router extends Core
	{
		static public function getRequest()
		{
			$request['request_metod'] = $_SERVER['REQUEST_METHOD'];
			$request['request_uri'] = $_SERVER['REQUEST_URI'];	
		}

		static public function setRoutes(): array
		{
			$routes = array();
			$modules_path = APP_ROOT . '/app/modules/';
			$modules_dir = scandir($modules_path);
			foreach ($modules_dir as $module) {
				if($module != '.' && $module != '..') {
					try
					{
						$module_config = Yaml::parseFile(APP_ROOT . '/app/modules/' .$module . '/settings.php');
						$routes[] = $module_config['routers'];
						
					} catch (ParseException $e) {
						self::$message_handler->setMessage('PDO01','Critical Error', $e->getMessage(), $e->getTraceAsString());
						return false;
					}
				}
			}
			return $routes;
		}
	}