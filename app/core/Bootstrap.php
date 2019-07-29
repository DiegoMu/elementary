<?php

	namespace App\Core;
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Exception\ParseException;

	class Bootstrap extends Core
	{

		public function loadelementary() {
			$layout_engine = new LayoutEngine();
			if (!$this->testConection()) {
				$layout_engine->setRegion('content', $this->message_handler->getMessage(), array('display'=>true), 'error');
			}
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
			    return true;
			} catch (\PDOException $e) {
				$this->message_handler->setMessage('PDO01','Critical Error', $e->getMessage(), $e->getTraceAsString());
				return false;
			}

		}		
	}