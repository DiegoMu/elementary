<?php
	//declare(strict_types=1);
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	define('APP_ROOT', dirname(__DIR__));
	$loader = require_once dirname(__DIR__) . '/vendor/autoload.php';

	$bootstrap = new App\Core\Bootstrap();
	$bootstrap->loadelementary();
