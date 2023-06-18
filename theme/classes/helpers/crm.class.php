<?php
	


class CRMGateway {


	// CRM settings
	private $_settings;
	private $adapter;


	/**
	*
	*/
	function __construct() {

		// no adapter selected yet
		$this->adapter = false;

		// mailer connection info
		@include_once("config/connect_crm.php");
			
	}

	function sms_connection($_settings) {

		
		$this->_settings = $_settings;

	}

	function init_adapter() {

		if(!$this->adapter) {

			@include_once("classes/adapters/crm/highlevel.class.php");
			$this->adapter = new JanitorHighLevel($this->_settings);

		}

	}


	function getContact($_options = false) {

		$this->init_adapter();

		return $this->adapter->getContact($sid);

	}

	function createContact($_options = false) {

		$this->init_adapter();

		return $this->adapter->createContact($sid);

	}

	function updateContact($_options = false) {

		$this->init_adapter();

		return $this->adapter->updateContact($sid);

	}

}
