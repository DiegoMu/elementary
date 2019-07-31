<?php

	namespace App\Core;
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Exception\ParseException;

	class Bootstrap extends Core
	{

		public function loadElementary() {
			$layout_engine = new LayoutEngine();
			var_dump(Router::setRoutes());
			if ($this->config['use_database']) {
				if (!$this->testConection()) {
					$layout_engine->setRegion('content', MessageHandler::getMessage(), array('display'=>true), 'error');
				}
			}
			
			$layout_engine->setRegion('header', "<p class='display-1'>Elementary</p>", array('display'=>true), false);
			$layout_engine->loadTheme();
		}
		
		public function testConection() : bool
		{
			$dbconfig = $this->getConfig()['data_base'];
			$dsn  = $dbconfig['type'] . ':dbname=' . $dbconfig['name']. ';host=' . $dbconfig['host'];
			$usr  = $dbconfig['user'];
			$pass = $dbconfig['password'];

			try {
			    $conection = new \PDO($dsn, $usr, $pass);
			    $conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    $conection = null;
			    return true;
			} catch (\PDOException $exception) {
				MessageHandler::setMessage('PDO01', $exception->getMessage(), $exception);
				return false;
			}

		}		
	}