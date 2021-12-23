<?php
	


class SMSGateway {


	// SMS settings
	private $_settings;
	private $adapter;

	/**
	*
	*/
	function __construct() {

		// no adapter selected yet
		$this->adapter = false;

		// mailer connection info
		@include_once("config/connect_sms.php");
			
	}

	function sms_connection($_settings) {

		
		$this->_settings = $_settings;

	}

	function init_adapter() {

		if(!$this->adapter) {

			@include_once("classes/adapters/sms/twilio.class.php");
			$this->adapter = new JanitorTwilio($this->_settings);

		}

	}

	/**
	 * SMSGateway::send
	 *
	 * @param array|false $_options
	 * 
	 * @return string|false 
	 */
	function send($_options = false) {


		$this->init_adapter();

		// Only attempt sending with valid adapter
		if($this->adapter) {

			$to = false;
			$from = $this->_settings["phone_no"];
			$body = "";

			if($_options !== false) {
				foreach($_options as $_option => $_value) {
					switch($_option) {

						case "to"                     : $to                     = $_value; break;
						case "from"                   : $from                   = $_value; break;
						case "body"                   : $body                   = $_value; break;
					}
				}
			}



			
			// only attempt sending if recipients are specified
			if($body && $to) {

				return $this->adapter->send([

					"to" => $to,
					"from" => $from,
					"body" => $body,

				]);

			}

		}

		return false;
	}

	function fetchMessage($sid) {
		
		$this->init_adapter();

		return $this->adapter->fetchMessage($sid);

	}
	
}
