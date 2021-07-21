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

		// Published at
		$this->addToModel("published_at", array(
			"type" => "datetime",
			"label" => "Publish date (yyyy-mm-dd hh:mm)",
			"hint_message" => "Publishing date of the item. Leave empty for current time.",
			"error_message" => "Datetime must be of format yyyy-mm-dd hh:mm",
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
			"min" => 1,
			"max" => 100,
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
			"min" => "2019-10-11 12:30",
			"max" => "2019-10-11 12:34",
			"hint_message" => "Type datetime between 2019-10-11 12:30 and 2019-10-11 12:34",
			"error_message" => "Datetime must be of format (yyyy-mm-dd hh:mm) and at or after 2019-10-11 12:30 and at or before 2019-10-11 12:34"
		));

		$this->addToModel("v_date", array(
			"type" => "date",
			"label" => "Date (yyyy-mm-dd)",
			"min" => "2019-10-11",
			"max" => "2019-10-12",
			"required" => true,
			"hint_message" => "Type date between 2019-10-11 and 2019-10-12",
			"error_message" => "Date must be of format (yyyy-mm-dd) and on or after 2019-10-11 and on or before 2019-10-12"
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

		$this->addToModel("v_range", array(
			"type" => "range",
			"label" => "Range",
			"required" => true,
			"min" => 10,
			"max" => 100,
			"step" => 5,
			"hint_message" => "Type range",
			"error_message" => "Must be within range"
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


		$this->addToModel("v_file", array(
			"type" => "files",
			"label" => "File",
			"required" => true,
			"hint_message" => "Type * file",
			"error_message" => "File must be added"
		));

		$this->addToModel("single_media", array(
			"type" => "files",
			"label" => "Add media here",
			"allowed_sizes" => "960x540",
			"max" => 1,
			"allowed_formats" => "png,jpg",
			"hint_message" => "Add single image by dragging it here. PNG or JPG allowed in 960x540",
			"error_message" => "Media does not fit requirements."
		));

		$this->addToModel("v_files", array(
			"type" => "files",
			"label" => "Files",
			"required" => true,
			"min" => 3,
			"max" => 20,
			"hint_message" => "Type * files",
			"error_message" => "Between 3 and 20 files must be added"
		));

		$this->addToModel("mediae", array(
			"type" => "files",
			"label" => "Add media here",
			"max" => 20,
			"allowed_formats" => "png,jpg,mp4",
			"hint_message" => "Add images or videos here. Use png, jpg or mp4.",
			"error_message" => "Media does not fit requirements."
		));


		$this->addToModel("v_html", array(
			"type" => "html",
			"label" => "HTML",
			"allowed_tags" => "p,h1,h2,h3,h4,h5,h6,code,ul,ol,download,png,jpg,vimeo,youtube,mp4",
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
			"label" => "Latitude",
			"hint_message" => "Type latitude",
			"error_message" => "Must be latitude"
		));
		$this->addToModel("v_longitude", array(
			"type" => "number",
			"label" => "Longitude",
			"hint_message" => "Type longitude",
			"error_message" => "Must be longitude"
		));


		$this->addToModel("tag", array(
			"type" => "tag",
			"label" => "Tag",
			"required" => true,
			"hint_message" => "Type tag",
			"error_message" => "Tag must be valid tag"
		));


	}


	// CUSTOM SUBSCRIBE/UNSUBSCRIBE

	// TypeTests::ordered should be identical to ItemType::ordered 
	function ordered($order_item, $order){
		session()->value("test_item_ordered_callback", true);

		include_once("classes/shop/supersubscription.class.php");
		$SuperSubscriptionClass = new SuperSubscription();
		$IC = new Items();

		$item = $IC->getItem(["id" => $order_item["item_id"], "extend" => ["subscription_method" => true]]);
		$item_id = $order_item["item_id"];

		if(isset($order_item["custom_price"]) && $order_item["custom_price"] !== false) {
			$custom_price = $order_item["custom_price"];
		}

		// item can be subscribed to
		if(SITE_SUBSCRIPTIONS && isset($item["subscription_method"]) && $item["subscription_method"]) {
			
			$order_id = $order["id"];
			$user_id = $order["user_id"];
			
			$subscription = $SuperSubscriptionClass->getSubscriptions(array("user_id" => $user_id, "item_id" => $item_id));

			// user already subscribes to item
			if($subscription) {

				// update existing subscription
				// makes callback to 'subscribed' if item_id changes
				$_POST["order_id"] = $order["id"];
				$_POST["item_id"] = $item_id;
				if(isset($custom_price) && ($custom_price || $custom_price === "0")) {
					$_POST["custom_price"] = $custom_price;
				}
				else {
					$_POST["custom_price"] = null;
				}
				
				$subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $subscription["id"]]);
				unset($_POST);

			}
			
			else {
				// add new subscription
				// makes callback to 'subscribed'
				$_POST["item_id"] = $item_id;
				$_POST["user_id"] = $user_id;
				$_POST["order_id"] = $order_id;
				if(isset($custom_price) && ($custom_price || $custom_price === "0")) {
					$_POST["custom_price"] = $custom_price;
				}
				else {
					$_POST["custom_price"] = null;
				}
				
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

			}
		}
	}

	function subscribed($subscription) {
		session()->value("test_item_subscribed_callback", true);
	}
	
	function subscription_renewed($subscription) {
		session()->value("test_item_subscription_renewed_callback", true);
	}

	function order_cancelled($order_item, $order) {
		session()->value("test_item_order_cancelled_callback", true);
	}

	// Do I really want this to work for all users
	function unsubscribed($subscription) {
		global $page;
		$IC = new Items();
		
		mailer()->send([
			"message" => "test unsubscribed"
		]);
	}



	// VALIDATION TESTS

	function stringValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("name"))) {
			message()->addMessage("String ok (".htmlentities($this->getProperty("name", "value")).")");
			return true;
		}
		return false;
	}

	function textValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_text"))) {
			message()->addMessage("Text ok (".htmlentities($this->getProperty("v_text", "value")).")");
			return true;
		}
		return false;
	}

	function htmlValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_html"))) {
			message()->addMessage("HTML ok (".htmlentities($this->getProperty("v_html", "value")).")");
			return true;
		}
		return false;
	}

	function selectValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_select"))) {
			message()->addMessage("Select ok (".htmlentities($this->getProperty("v_select", "value")).")");
			return true;
		}
		return false;
	}

	function emailValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_email"))) {
			message()->addMessage("Email ok (".htmlentities($this->getProperty("v_email", "value")).")");
			return true;
		}
		return false;
	}

	function telValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_tel"))) {
			message()->addMessage("Tel ok (".htmlentities($this->getProperty("v_tel", "value")).")");
			return true;
		}
		return false;
	}

	function passwordValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_password"))) {
			message()->addMessage("Password ok (".htmlentities($this->getProperty("v_password", "value")).")");
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

	function rangeValidation() {

		$this->getPostedEntities();
		if($this->validateList(array("v_range"))) {
			message()->addMessage("Range ok");
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

	// get cookie from result
	function getCookie($result) {

		preg_match_all("/Set\-Cookie: (.+);/", $result["header"], $cookie_match);
		if($cookie_match && count($cookie_match) >= 2 && isset($cookie_match[1][count($cookie_match[1])-1])) {
			$cookie = $cookie_match[1][count($cookie_match[1])-1];
		}
		else {
			$cookie = "";
		}
		// debug([$cookie_match, $result["header"]]);

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


	// cleanup function
	function cleanUp($_options) {
		$query = new Query();
		include_once("classes/shop/supershop.class.php");
	
		$SC = new SuperShop();
		$IC = new Items();
	
		$user_id = false;
		$item_id = false;
		$currency_id = false;
		$itemtype = false;
		
		foreach($_options as $_option => $_value) {
			switch($_option) {
				case "itemtype"           : $itemtype             = $_value; break;

				case "item_id"            : $item_id              = $_value; break;
				case "user_id"            : $user_id              = $_value; break;
				case "currency_id"        : $currency_id          = $_value; break;

			}
		}


		// Delete by itemtype
		if($itemtype) {

			$items = $IC->getItems(["itemtype" => $itemtype]);
			$model_item = $IC->typeObject($itemtype);
			foreach($items as $item) {

				// delete subscriptions
				$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = ".$item["id"];
				$query->sql($sql);

				$model_item->delete(["delete", $item["id"]]);

				// flush price_types cache
				include_once("classes/system/system.class.php");
				$SysC = new System();
				$_POST["cache-key"] = "price_types";
				$SysC->flushFromCache(["flushFromCache"]);
				unset($_POST);

			}

		}


		// Delete by user_id
		if($user_id) {
	
			// delete member
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE user_id = $user_id";
			$query->sql($sql);
			
			// delete subscriptions
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE user_id = $user_id";
			$query->sql($sql);
	
			// delete carts
			$sql = "DELETE FROM ".SITE_DB.".shop_carts WHERE user_id = $user_id";
			$query->sql($sql);
	
			// delete orders and cancelled orders
			$orders = $SC->getOrders(["user_id" => $user_id]);
			if($orders) {
	
				foreach($orders as $order) {
	
					// delete cancelled orders
					$sql = "DELETE FROM ".SITE_DB.".shop_cancelled_orders WHERE order_id = ".$order["id"];
					$query->sql($sql);
					
				}
				
				// delete orders
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE user_id = $user_id";
				$query->sql($sql);
	
			}
	
			if($user_id != session()->value("user_id")) {

				// delete user
				$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $user_id";
				$query->sql($sql);
			}
		}

		// Delete by item_id
		if($item_id) {
	
			$item = $IC->getItem(["id" => $item_id]);
			$model_item = $IC->TypeObject($item["itemtype"]);
			
	
			// delete subscriptions
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $item_id";
			$query->sql($sql);
	
			$model_item->delete(["delete",$item_id]);

			// flush price_types cache
			include_once("classes/system/system.class.php");
			$SysC = new System();
			$_POST["cache-key"] = "price_types";
			$SysC->flushFromCache(["flushFromCache"]);
			unset($_POST);
		}

		// Delete by currency id
		if($currency_id) {

			$sql = "DELETE FROM ".UT_CURRENCIES." WHERE id = '$currency_id'";
			$query->sql($sql);
		}



		// Cleanup check

		// check that item was deleted
		$remaining_itemtype_items = false;
		if($itemtype) {
			$sql = "SELECT * FROM ".UT_ITEMS." WHERE itemtype = '$itemtype'";
			$remaining_itemtype_items = $query->sql($sql); 
		}
		


		// check that item was deleted
		$remaining_items = false;
		if($item_id) {
			$sql = "SELECT * FROM ".SITE_DB.".items WHERE id = $item_id";
			$remaining_items = $query->sql($sql); 
		}


		// Check that users and orders was deleted
		$remaining_orders = false;
		$remaining_users = false;
		if($user_id) {

			$sql = "SELECT * FROM ".SITE_DB.".shop_orders WHERE user_id = $user_id";
			$remaining_orders = $query->sql($sql); 

			if($user_id != session()->value("user_id")) {
				$sql = "SELECT * FROM ".SITE_DB.".users WHERE id = $user_id";
				$remaining_users = $query->sql($sql);
			}

		}

		// Check that currency was deleted
		$remaining_currencies = false;
		if($currency_id) {

			$sql = "SELECT * FROM ".UT_CURRENCIES." WHERE id = '$currency_id'";
			$remaining_currencies = $query->sql($sql);

		}


		if(
			!$remaining_itemtype_items && 
			!$remaining_items && 
			!$remaining_orders && 
			!$remaining_users && 
			!$remaining_currencies
		) {
	
			return true;
		}

		print "Incomplete cleanup";
		return false;
	
	}

	function createTestItem($_options = false) {

		$IC = new Items();
		$query = new Query();
	
		$itemtype = "tests";
		$name = "Test item";
		$status = 1;
	
		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {
					case "itemtype"            : $itemtype              = $_value; break;
					case "name"           : $name             = $_value; break;

					case "price"               : $price                 = $_value; break;
					case "prices"              : $prices                = $_value; break;

					case "subscription_method" : $subscription_method   = $_value; break;
					case "status" 			   : $status                = $_value; break;
				}
			}
		}
		
		// create test item
		$model = $IC->TypeObject($itemtype);
		$_POST["name"] = $name;
	
		$item = $model->save(array("save"));
		$item_id = $item["id"];
		unset($_POST);
	
	
	
		if($item_id) {
	
			if(isset($price) && $price !== false) {
				// add price 
				$_POST["item_price"] = $price;
				$_POST["item_price_currency"] = "DKK";
				$_POST["item_price_vatrate"] = 2;
				$_POST["item_price_type"] = 1;
				$item_price = $model->addPrice(array("addPrice", $item_id));
				unset($_POST);
	
			}

			if(isset($prices) && $prices && is_array($prices)) {
				foreach($prices as $price_type => $_options) {

					$price = 100;
					$currency = "DKK";
					$vatrate = 2;
					$quantity = false;

					// get price_type_id from price_type name
					$sql = "SELECT id FROM ".UT_PRICE_TYPES." WHERE name = '$price_type'";
					if ($query->sql($sql)) {
						
						$price_type_id = $query->result(0, "id");
					} 

					foreach($_options as $_option => $_value) {

						switch($_option) {
		
							case "price"               : $price                 = $_value;   break;
							case "currency"            : $currency              = $_value;   break;
							case "vatrate"             : $vatrate               = $_value;   break;
							case "quantity"            : $quantity              = $_value;   break;
						}					

					}


					$_POST["item_price"] = $price;
					$_POST["item_price_currency"] = $currency;
					$_POST["item_price_vatrate"] = $vatrate;
					$_POST["item_price_type"] = $price_type_id;
					$_POST["item_price_quantity"] = $quantity;
					$item_price = $model->addPrice(array("addPrice", $item_id));
					unset($_POST);
				}

			}
	
			if(isset($subscription_method) && preg_match("/[1-3]/", $subscription_method)) {
				// add subscription method
				$_POST["item_subscription_method"] = $subscription_method;
				$model->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));
				unset($_POST);
			}


			if($model->status(["status", $item_id, $status])) {

				return $item_id; 

			}
	
		}
	
		return false;
	}
	
	function createTestUser($_options = false) {
		$query = new Query();
		include_once("classes/users/superuser.class.php");
		$UC = new SuperUser();
	
		$user_group_id = 2;
		$nickname = "test user";
		$firstname = "Tester";
		$lastname = "Testerson";
		$status = 1;
		$created_at = "2019-01-01 00:00:00";
		$email = "test.parentnode@gmail.com";
		$membership = false;
		$subscribed_item_id = false;
		$subscription_expires_at = false;
		$subscription_custom_price = false;
	
		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {
					case "user_group_id"                  : $user_group_id                         = $_value; break;
					case "nickname"                       : $nickname                              = $_value; break;
					case "firstname"                      : $firstname                             = $_value; break;
					case "lastname"                       : $lastname                              = $_value; break;
					case "status"                         : $status                                = $_value; break;
					case "created_at"                     : $created_at                            = $_value; break;
					case "email"                          : $email                                 = $_value; break;
					case "membership"                     : $membership                            = $_value; break;
					case "subscribed_item_id"             : $subscribed_item_id                    = $_value; break;
					case "subscription_expires_at"        : $subscription_expires_at               = $_value; break;
					case "subscription_custom_price"      : $subscription_custom_price             = $_value; break;
				}
			}
		}
	
		$_POST["user_group_id"] = $user_group_id;
		$_POST["nickname"] = $nickname;
		$_POST["firstname"] = $firstname;
		$_POST["lastname"] = $lastname;
		$_POST["status"] = $status;
		$_POST["created_at"] = $created_at;
	
		// create test user
		$user_id = $UC->save(["save"])["item_id"];
		unset($_POST);
	
		if($user_id) {
	
			$_POST["email"] = $email;
			$UC->updateEmail(["updateEmail", $user_id]);

			if($subscribed_item_id)	{
				$SC = new SuperShop();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$added_item_cart = $SC->addToNewInternalCart($subscribed_item_id, ["user_id" => $user_id, "custom_price" => $subscription_custom_price]);
				$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart["id"], $added_item_cart["cart_reference"]]);
				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $user_id, "item_id" => $subscribed_item_id]);
			}
	
			if($subscription_expires_at) {
				$sql = "UPDATE ".SITE_DB.".user_item_subscriptions SET expires_at = '".$subscription_expires_at."' WHERE id = ".$added_subscription["id"];
				$query->sql($sql);
			}
	
			return $user_id;
		}
	
		return false;
	}

	function createTestCurrency() {
		$query = new Query();

		$abbreviation = "XXX";
		$id = $abbreviation;
		$name = "Test currency";
		$abbreviation_position = "after";
		$decimals = 2;
		$decimal_separator = ",";
		$grouing_separator = ".";


		$sql = "INSERT INTO ".UT_CURRENCIES." (id, name, abbreviation, abbreviation_position, decimals, decimal_separator, grouping_separator) VALUES ('$id', '$name', '$abbreviation', '$abbreviation_position', $decimals, '$decimal_separator', '$grouing_separator')";
		if ($query->sql($sql)) {
			 return $id;
		}

		return false;
	} 
	
}

?>