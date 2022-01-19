<?php
	


class MapsGateway {


	// Payment gateway settings
	public $_settings;
	private $adapter;

	/**
	*
	*/
	function __construct() {

		// no adapter selected yet
		$this->adapter = false;

		// mailer connection info
		@include("config/connect_maps.php");

	}

	function maps_connection($_settings) {

		// set type to default, googlemaps, if not defined in configs
		$_settings["type"] = (isset($_settings["type"]) ? $_settings["type"] : "googlemaps");
		$this->_settings = $_settings;

	}

	function init_adapter() {

		if(!$this->adapter) {

			if(isset($this->_settings["type"]) && preg_match("/^googlemaps$/i", $this->_settings["type"])) {

				@include_once("classes/adapters/maps/googlemaps.class.php");
				$this->adapter = new JanitorGoogleMaps($this->_settings);

			}
			// Other options
			else {


			}

		}

	}

	function getApiKey() {

		// only load adapter when needed
		$this->init_adapter();


		return $this->adapter->getApiKey();

	}
	

	function getDirections($from, $to, $_options = false) {

		// only load adapter when needed
		$this->init_adapter();


		return $this->adapter->getDirections($from, $to, $_options);

	}


	function findBestRoute($to, $from, $_options = false) {

		// only load adapter when needed
		$this->init_adapter();


		return $this->adapter->findBestRoute($to, $from, $_options);

	}

}
