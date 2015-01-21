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


		$this->addToModel("name", array(
			"type" => "string",
			"label" => "String",
			"required" => true,
			"error_message" => "String must be string"
		));

		$this->addToModel("v_text", array(
			"type" => "text",
			"label" => "Text",
			"required" => true,
			"error_message" => "Text must be text"
		));

		$this->addToModel("v_email", array(
			"type" => "email",
			"label" => "Email",
			"required" => true,
			"error_message" => "Email must be email"
		));

		$this->addToModel("v_tel", array(
			"type" => "tel",
			"label" => "Phone",
			"required" => true,
			"error_message" => "Phone must be phone"
		));

		$this->addToModel("v_password", array(
			"type" => "password",
			"label" => "Password",
			"required" => true,
			"error_message" => "Password must be password"
		));

		$this->addToModel("v_select", array(
			"type" => "select",
			"label" => "Select",
			"options" => array("" => "Select option", "1" => "First option"),
			"required" => true,
			"error_message" => "Option must be selected"
		));

		$this->addToModel("v_datetime", array(
			"type" => "datetime",
			"label" => "Datetime (yyyy-mm-dd hh:mm)",
			"required" => true,
			"error_message" => "Datetime must be of format (yyyy-mm-dd hh:mm)"
		));

		$this->addToModel("v_date", array(
			"type" => "date",
			"label" => "Date (yyyy-mm-dd)",
			"required" => true,
			"error_message" => "Date must be of format (yyyy-mm-dd)"
		));

		$this->addToModel("v_integer", array(
			"type" => "integer",
			"label" => "Integer",
			"required" => true,
			"error_message" => "Must be Integer"
		));

		$this->addToModel("v_number", array(
			"type" => "number",
			"label" => "Number",
			"required" => true,
			"error_message" => "Must be Number"
		));

		$this->addToModel("v_checkbox", array(
			"type" => "checkbox",
			"label" => "Checkbox",
			"required" => true,
			"error_message" => "Must be checked"
		));

		$this->addToModel("v_radiobuttons", array(
			"type" => "radiobuttons",
			"label" => "Radiobuttons",
			"options" => array("value1" => "text1", "value2" => "text2"),
			"required" => true,
			"error_message" => "One must be selected"
		));


		$this->addToModel("v_html", array(
			"type" => "html",
			"label" => "HTML",
			"allowed_tags" => "p,h1,h2,h3,h4,h5,h6,code,ul,ol,download,png,jpg,vimeo,youtube", //",mp4",
			"required" => true,
			"error_message" => "HTML must be HTML"
		));

		$this->addToModel("v_location", array(
			"type" => "location",
			"label" => "Location",
			//"required" => true,
			"error_message" => "Must be location"
		));
		$this->addToModel("v_latitude", array(
			"type" => "number",
			"label" => "Latitude"
		));
		$this->addToModel("v_longitude", array(
			"type" => "number",
			"label" => "Longitude"
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
		if($this->validateList(array("name"))) {
			return true;
		}
		return false;
	}

	function textValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_text"))) {
			return true;
		}
		return false;
	}

	function htmlValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_html"))) {
			return true;
		}
		return false;
	}

	function selectValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_select"))) {
			return true;
		}
		return false;
	}

	function emailValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_email"))) {
			return true;
		}
		return false;
	}

	function telValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_tel"))) {
			return true;
		}
		return false;
	}

	function passwordValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_password"))) {
			return true;
		}
		return false;
	}

	function dateValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_date"))) {
			return true;
		}
		return false;
	}

	function datetimeValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_datetime"))) {
			return true;
		}
		return false;
	}

	function integerValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_integer"))) {
			return true;
		}
		return false;
	}

	function numberValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_number"))) {
			return true;
		}
		return false;
	}

	function checkboxValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_checkbox"))) {
			return true;
		}
		return false;
	}

	function radiobuttonsValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_radiobuttons"))) {
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


	function testAll() {}
}

?>