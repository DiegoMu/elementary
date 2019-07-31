<?php
	
	namespace App\Core;
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Exception\ParseException;

	class MessageHandler
	{

		private static $message;
		private static $config;

		public function __construct(){
			self::setConfig();
		}
		static public function setMessage($translingua_id, $message, $exception = false): void
		{
			$date = new \DateTime();
			$new_message = array();
			$new_message['time_stamp'] 	= $date->getTimestamp();
			$new_message['client_ip'] 	= $_SERVER['REMOTE_ADDR'];

			if(self::$config['debug_enable']) {
				$new_message['type']		= '';
				$new_message['message'] 	= $message;
				$new_message['stack_trace'] = explode('#', $exception->getTraceAsString());
			} else {
				$new_message['type'] 	= self::loadMessageFromTemplate($translingua_id)['type'];
				$new_message['message'] = self::loadMessageFromTemplate($translingua_id)['text'];
				$new_message['stack_trace'] = false;
			}

			self::$message = $new_message;
		}

		public function printMessage(): void
		{
			echo $this->message['type'] .'<br>';
			echo $this->message['message'] .'<br>';
			foreach ($this->message['stack_trace'] as $stack_message) {
				echo '#' . $stack_message .'<br>';
			}
			
		}

		public function getMessage()
		{
			return self::$message;
		}

		private function loadMessageFromTemplate($translingua_id){
			try
			{
				$template_message = Yaml::parseFile(__DIR__ . '/localize/' . self::$config['languague'] . '/messages.yaml');
				$error_message = $template_message['error_messages'][$translingua_id];
				return $error_message;
			} catch (ParseException $e) {
				print($e->getMessage());
				print($e->getTraceAsString());
				return false;
			}
		}

		static public function setConfig(): void
		{
			try
			{
				self::$config = Yaml::parseFile(APP_ROOT . '/conf/settings.yaml');
				
			} catch (ParseException $e) {
				print($e->getMessage());
				print($e->getTraceAsString());
			}	
			
		}
	}