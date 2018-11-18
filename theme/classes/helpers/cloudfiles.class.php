<?php
	


class CloudfilesGateway {


	// Payment gateway settings
	private $_settings;
	private $adapter;

	/**
	*
	*/
	function __construct() {

		// no adapter selected yet
		$this->adapter = false;

		// mailer connection info
		@include_once("config/connect_cloudfiles.php");

	}

	function cloudfiles_connection($_settings) {

		// set type to default, Stripe, if not defined in configs
		$_settings["type"] = isset($_settings["type"]) ? $_settings["type"] : "google-drive";
		$this->_settings = $_settings; 


	}

	function init_adapter() {

		if(!$this->adapter) {

			if(preg_match("/^google-drive$/i", $this->_settings["type"])) {

				@include_once("classes/adapters/cloudfiles/google_drive.class.php");
				$this->adapter = new GoogleDrive($this->_settings);

			}
			else if(preg_match("/^rackspace-files$/i", $this->_settings["type"])) {

				@include_once("classes/adapters/cloudfiles/rackspace_files.class.php");
				$this->adapter = new RackspaceFiles($this->_settings);

			}
			// Other options

		}

	}

}

$__cfcfcf = false;

function cloudfiles() {
	global $__cfcfcf;
	if(!$__cfcfcf) {
		$__cfcfcf = new CloudfilesGateway();

	}
	return $__cfcfcf;
}
