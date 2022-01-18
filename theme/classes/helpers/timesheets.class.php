<?php
	


class TimesheetsGateway {


	// Settings
	private $_settings;
	private $adapter;

	/**
	*
	*/
	function __construct() {

		// no adapter selected yet
		$this->adapter = false;

		// timesheets API connection info
		@include_once("config/connect_timesheets.php");
			
	}

	function timesheets_connection($_settings) {

		
		$this->_settings = $_settings;

	}

	function init_adapter() {

		if(!$this->adapter) {

			if($this->_settings["type"] == "toggl") {

				@include_once("classes/adapters/timesheets/toggl.class.php");
				$this->adapter = new JanitorToggl($this->_settings);
			}

		}

	}

	function getReports($_options = false) {

		$this->init_adapter();

		if($this->adapter) {

			return $this->adapter->getReports($_options);
		}
	}


	
}
