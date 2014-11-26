<?php
/**
* @package janitor.itemtypes
* This file contains itemtype functionality
*/

class TypeTests extends Itemtype {

	/**
	* Init, set varnames, validation rules
	*/
	function __construct() {

		// construct ItemType before adding to model
		parent::__construct(get_class());


		// itemtype database
		$this->db = SITE_DB.".item_tests";


		$this->addToModel("datetime", array(
			"type" => "datetime",
			"label" => "Datetime (yyyy-mm-dd hh:mm)",
			"required" => true,
			"error_message" => "Datetime must be of format (yyyy-mm-dd hh:mm)"
		));

		$this->addToModel("date", array(
			"type" => "date",
			"label" => "Date (yyyy-mm-dd)",
			"required" => true,
			"error_message" => "Date must be of format (yyyy-mm-dd)"
		));

		$this->addToModel("integer", array(
			"type" => "integer",
			"label" => "Integer",
			"required" => true,
			"error_message" => "Must be Integer"
		));

		$this->addToModel("number", array(
			"type" => "number",
			"label" => "Number",
			"required" => true,
			"error_message" => "Must be Number"
		));

	}


	// VALIDATION TESTS

	function dateValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("date"))) {
			return true;
		}
		return false;
	}

	function datetimeValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("datetime"))) {
			return true;
		}
		return false;
	}

	function integerValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("integer"))) {
			return true;
		}
		return false;
	}

	function numberValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("number"))) {
			return true;
		}
		return false;
	}


}

?>