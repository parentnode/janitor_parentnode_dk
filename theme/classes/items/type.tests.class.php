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
			"hint_message" => "Type string",
			"error_message" => "String must be string"
		));

		$this->addToModel("v_text", array(
			"type" => "text",
			"label" => "Text",
			"required" => true,
			"hint_message" => "Type text",
			"error_message" => "Text must be text"
		));

		$this->addToModel("v_email", array(
			"type" => "email",
			"label" => "Email",
			"required" => true,
			"hint_message" => "Type email",
			"error_message" => "Email must be email"
		));

		$this->addToModel("v_tel", array(
			"type" => "tel",
			"label" => "Phone",
			"required" => true,
			"hint_message" => "Type tel",
			"error_message" => "Phone must be phone"
		));

		$this->addToModel("v_password", array(
			"type" => "password",
			"label" => "Password",
			"required" => true,
			"hint_message" => "Type password",
			"error_message" => "Password must be password"
		));

		$this->addToModel("v_select", array(
			"type" => "select",
			"label" => "Select",
			"options" => array("" => "Select option", "1" => "First option"),
			"required" => true,
			"hint_message" => "Type select",
			"error_message" => "Option must be selected"
		));

		$this->addToModel("v_datetime", array(
			"type" => "datetime",
			"label" => "Datetime (yyyy-mm-dd hh:mm)",
			"required" => true,
			"hint_message" => "Type datetime",
			"error_message" => "Datetime must be of format (yyyy-mm-dd hh:mm)"
		));

		$this->addToModel("v_date", array(
			"type" => "date",
			"label" => "Date (yyyy-mm-dd)",
			"required" => true,
			"hint_message" => "Type date",
			"error_message" => "Date must be of format (yyyy-mm-dd)"
		));

		$this->addToModel("v_integer", array(
			"type" => "integer",
			"label" => "Integer",
			"required" => true,
			"hint_message" => "Type integer",
			"error_message" => "Must be Integer"
		));

		$this->addToModel("v_number", array(
			"type" => "number",
			"label" => "Number",
			"required" => true,
			"hint_message" => "Type number",
			"error_message" => "Must be Number"
		));

		$this->addToModel("v_checkbox", array(
			"type" => "checkbox",
			"label" => "Checkbox",
			"required" => true,
			"hint_message" => "Type checkbox",
			"error_message" => "Must be checked"
		));

		$this->addToModel("v_radiobuttons", array(
			"type" => "radiobuttons",
			"label" => "Radiobuttons",
			"options" => array("value1" => "text1", "value2" => "text2"),
			"required" => true,
			"hint_message" => "Type radiobuttons",
			"error_message" => "One must be selected"
		));


		$this->addToModel("v_html", array(
			"type" => "html",
			"label" => "HTML",
			"allowed_tags" => "p,h1,h2,h3,h4,h5,h6,code,ul,ol,download,png,jpg,vimeo,youtube", //",mp4",
			"required" => true,
			"hint_message" => "Type html",
			"error_message" => "HTML must be HTML"
		));

		$this->addToModel("v_location", array(
			"type" => "location",
			"label" => "Location",
			//"required" => true,
			"hint_message" => "Type location",
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
			"hint_message" => "Type tag",
			"error_message" => "Tag must be valid tag"
		));

		$this->addToModel("file", array(
			"type" => "files",
			"label" => "Files",
			"required" => true,
			"hint_message" => "Type files",
			"error_message" => "Files must be added"
		));

	}


	// CUSTOM SUBSCRIBE/UNSUBSCRIBE


	function subscribed($user_id, $item_id) {
		
	}

	// Do I really want this to work for all users
	function unsubscribed($user_id, $item_id) {
		global $page;
		$IC = new Items();
		
		mailer()->send([
			"message" => "test unsubscribed"
		]);
	}

	function subscriptionRenewed() {}



	// VALIDATION TESTS

	function stringValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("name"))) {
			message()->addMessage("String ok");
			return true;
		}
		return false;
	}

	function textValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_text"))) {
			message()->addMessage("Text ok");
			return true;
		}
		return false;
	}

	function htmlValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_html"))) {
			message()->addMessage("HTML ok");
			return true;
		}
		return false;
	}

	function selectValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_select"))) {
			message()->addMessage("Select ok");
			return true;
		}
		return false;
	}

	function emailValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_email"))) {
			message()->addMessage("Email ok");
			return true;
		}
		return false;
	}

	function telValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_tel"))) {
			message()->addMessage("Tel ok");
			return true;
		}
		return false;
	}

	function passwordValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_password"))) {
			message()->addMessage("Password ok");
			return true;
		}
		return false;
	}

	function dateValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_date"))) {
			message()->addMessage("Date ok");
			return true;
		}
		return false;
	}

	function datetimeValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_datetime"))) {
			message()->addMessage("Datetime ok");
			return true;
		}
		return false;
	}

	function integerValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_integer"))) {
			message()->addMessage("Integer ok");
			return true;
		}
		return false;
	}

	function numberValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_number"))) {
			message()->addMessage("Number ok");
			return true;
		}
		return false;
	}

	function checkboxValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_checkbox"))) {
			message()->addMessage("Checkbox ok");
			return true;
		}
		return false;
	}

	function radiobuttonsValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_radiobuttons"))) {
			message()->addMessage("Radiobuttons ok");
			return true;
		}
		return false;
	}

	function tagValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("tag"))) {
			message()->addMessage("Tag ok");
			return true;
		}
		return false;
	}

	function fileValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("file"))) {
			message()->addMessage("File ok");
			return true;
		}
		return false;
	}


	function testAll() {}



	// ADDITIONAL TEST FUNCTIONS
	function testPath($path, $allowed) {
		global $page;
		$result = $page->validatePath($path);
		if(($result && $allowed) || (!$result && !$allowed)) {
			print '<div class="testpassed">'.$path."</div>\n";
		}
		else {
			print '<div class="testfailed">'.$path."</div>\n";
		}
	}


	// test item status
	function testStatus($expected) {
		global $test_item_id;
		$IC = new Items();

		$compare_item = $IC->getItem(array("id" => $test_item_id, "extend" => true));
		if($compare_item["status"] == $expected) {
			print '<div class="testpassed">Status ok</div>'."\n";
		}
		else {
			print '<div class="testfailed">Status error</div>'."\n";
		}
	}

	// test item name
	function testExistence($expected) {
		global $test_item_id;
		$IC = new Items();

		$compare_item = $IC->getItem(array("id" => $test_item_id, "extend" => true));
		if(($compare_item && $expected) || (!$compare_item && !$expected)) {
			print '<div class="testpassed">Existence ok</div>'."\n";
		}
		else {
			print '<div class="testfailed">Existence error</div>'."\n";
		}
	}

	// test item name
	function testName($expected) {
		global $test_item_id;
		global $test_item_name;
		$IC = new Items();

		$compare_item = $IC->getItem(array("id" => $test_item_id, "extend" => true));
		if($compare_item["name"] == $expected) {
			print '<div class="testpassed">Name ok</div>'."\n";
		}
		else {
			print '<div class="testfailed">Name error</div>'."\n";
		}
	}

	// get cookie from result
	function getCookie($result) {

		preg_match_all("/Set\-Cookie: (.+);/", $result["header"], $cookie_match);
		$cookie = $cookie_match[1][count($cookie_match[1])-1];

		return $cookie;
	}

	// get CSRF from result
	function getCSRF($result) {

		// look for input
		preg_match("/name\=\"csrf\-token\" value=\"(.+)\"/", $result["body"], $csrf_match);
		if(!$csrf_match) {
			// look for ajax response
			preg_match("/\"csrf\-token\":\"(.+)\"}/", $result["body"], $csrf_match);
		}

		$csrf = $csrf_match[1];

		return $csrf;
	}
}

?>