<?php

	namespace App\Core

	class Model extends Core {
		static private $elementaryPDO;

		static public function __construct()
		{
			self:setElementaryConection();
		}

		static private setElementaryConection(): void
		{
			$dbconfig = $this->getConfig()['data_base'];
			$dsn  = $dbconfig['type'] . ':dbname=' . $dbconfig['name']. ';host=' . $dbconfig['host'];
			$usr  = $dbconfig['user'];
			$pass = $dbconfig['password'];
			try {
			    $conection = new \PDO($dsn, $usr, $pass);
			    $conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    self::$elementaryPDO = $conection;
			    $conection = null;
			} catch (\PDOException $exception) {
				MessageHandler::setMessage('PDO01', $exception->getMessage(), $exception);
			}	
		}

		static public function search($field = false, $value = false) :array
		{
			$field = self::$elementaryPDO->cuote($field);
			$value = self::$elementaryPDO->cuote($value);
			$query_string = "SELECT * FROM " . strtolower(get_class(self)) . " WHERE $field = '$value'";
			return = self::$elementaryPDO->query($query_string);
		}

	} 