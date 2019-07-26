<?php
	
	namespace App\Core;
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Exception\ParseException;

	class MessageHandler extends Core
	{

		private $message;

		public function __construct(){
			$this->setConfig();
		}
		public function setMessage($translingua_id, $type, $content, $stack_trace = false): void
		{
			$date = new \DateTime();
			$message = array();
			$message['time_stamp'] 	= $date->getTimestamp();
			$message['client_ip'] 	= $_SERVER['REMOTE_ADDR'];
			$message['type'] 		= $type;

			if($this->config['debug_enable']) {
				$message['message'] 	= $content;
				$message['stack_trace'] = $stack_trace;
			} else {
				$message['message'] 	= $this->loadMessagesTemplate($translingua_id);
				$message['stack_trace'] = '';
			}

			$this->message = $message;
		}

		public function printMessage(): void
		{
			echo $this->message['time_stamp'] .'<br>';
			echo $this->message['client_ip'] .'<br>';
			echo $this->message['type'] .'<br>';
			echo $this->message['message'] .'<br>';
			echo $this->message['stack_trace'] .'<br>';
		}

		public function getMessage(): array
		{
			return $this->message;
		}

		private function loadMessagesTemplate($translingua_id){
			try
			{
				$template_message = Yaml::parseFile('localize/' . $this->config['languague'] . '/messages.yaml');
				$error_message = $template_message['error_messages'][$translingua_id];
				return $error_message;
			} catch (ParseException $e) {
				print($e->getMessage());
				print($e->getTraceAsString());
				return false;
			}
		}
	}