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

		public function arraySortByField($array = array(), $field): array
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