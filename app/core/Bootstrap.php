<?php

	namespace App\Core;
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Exception\ParseException;

	class Bootstrap extends Core
	{

		public function loadTheme()
		{
			$message_handler = new MessageHandler();
			$config_theme = $this->config['theme'];
			try {
				$theme_settings = Yaml::parseFile($config_theme['active_theme']. '/settings.yaml');
			} catch (ParseException $e){
				$message_handler->setMessage('PDO01','Critical', $e->getMessage(), $e->getTraceAsString());
				$message_handler->printMessage();
			}
		}

		public function testConection(): bool
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
			    echo $e->getMessage();
			    return false;
			}

		}

	}