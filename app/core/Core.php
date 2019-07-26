<?php

	namespace App\Core;

	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Exception\ParseException;

	class Core
	{
		public $config;

		public function __construct()
		{
			$this->setConfig();
		}

		public function setConfig(): void
		{
			try
			{
				$this->config = Yaml::parseFile(APP_ROOT . '/conf/settings.yaml');
				
			} catch (ParseException $e) {
				print($e->getMessage());
				print($e->getTraceAsString());
			}	
			
		}

		public function getConfig(): array
		{
			return $this->config;
		}
	}