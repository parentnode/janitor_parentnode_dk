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
			
			$since = false;
			$until = false;

			if($_options !== false) {
				foreach($_options as $_option => $_value) {
					switch($_option) {

						case "since"                     : $since                     = $_value; break;
						case "until"                     : $until                     = $_value; break;
					}
				}
			}

			// Some kind of id
			$default_query = "user_agent=" . $this->_settings["user-agent"];

			// Choose parentNode workspace
			$default_query .= "&workspace_id=" . $this->_settings["workspace-id"];

			// only not tagged elements (rule is only using "afregnet" tag)
			$default_query .= "&tag_ids=0";

			$query = $default_query;

			return $this->adapter->getReports($query);
		}
	}


	
}
