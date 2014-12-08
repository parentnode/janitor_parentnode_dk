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


		$this->addToModel("string", array(
			"type" => "string",
			"label" => "String",
			"required" => true,
			"error_message" => "String must be string"
		));

		$this->addToModel("text", array(
			"type" => "text",
			"label" => "Text",
			"required" => true,
			"error_message" => "Text must be text"
		));

		$this->addToModel("html", array(
			"type" => "html",
			"label" => "HTML",
			"required" => true,
			"error_message" => "HTML must be HTML"
		));

		$this->addToModel("email", array(
			"type" => "email",
			"label" => "Email",
			"required" => true,
			"error_message" => "Email must be email"
		));

		$this->addToModel("tel", array(
			"type" => "tel",
			"label" => "Phone",
			"required" => true,
			"error_message" => "Phone must be phone"
		));

		$this->addToModel("password", array(
			"type" => "password",
			"label" => "Password",
			"required" => true,
			"error_message" => "Password must be password"
		));

		$this->addToModel("select", array(
			"type" => "select",
			"label" => "Select",
			"options" => array("" => "Select option", "1" => "First option"),
			"required" => true,
			"error_message" => "Option must be selected"
		));

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

		$this->addToModel("tag", array(
			"type" => "tag",
			"label" => "Tag",
			"required" => true,
			"error_message" => "Tag must be valid tag"
		));

		$this->addToModel("file", array(
			"type" => "files",
			"label" => "Files",
			"required" => true,
			"error_message" => "Files must be added"
		));

	}


	// VALIDATION TESTS

	function stringValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("string"))) {
			return true;
		}
		return false;
	}

	function textValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("text"))) {
			return true;
		}
		return false;
	}

	function htmlValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("html"))) {
			return true;
		}
		return false;
	}

	function selectValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("select"))) {
			return true;
		}
		return false;
	}

	function emailValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("email"))) {
			return true;
		}
		return false;
	}

	function telValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("tel"))) {
			return true;
		}
		return false;
	}

	function passwordValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("password"))) {
			return true;
		}
		return false;
	}

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

	function tagValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("tag"))) {
			return true;
		}
		return false;
	}

	function fileValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("file"))) {
			return true;
		}
		return false;
	}

}

?>