<?
include_once("classes/shop/supershop.class.php");
include_once("classes/users/superuser.class.php");
$UC = new SuperUser();
$query = new Query();
$IC = new Items();
$SC = new SuperShop();




function createTestItem($_options = false) {

	$IC = new Items();

	$itemtype = "tests";
	$name = "Test item";

	if($_options !== false) {
		foreach($_options as $_option => $_value) {
			switch($_option) {
				case "itemtype"            : $itemtype              = $_value; break;
				case "name"           : $name             = $_value; break;
				case "price"               : $price                 = $_value; break;
				case "subscription_method" : $subscription_method   = $_value; break;
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

		if(isset($price) && $price) {
			// add price to membership item
			$_POST["item_price"] = $price;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 2;
			$_POST["item_price_type"] = 1;
			$item_price = $model->addPrice(array("addPrice", $item_id));
			unset($_POST);

		}

		if(isset($subscription_method) && preg_match("/[1-3]/", $subscription_method)) {
			// add subscription method to second membership item
			$_POST["item_subscription_method"] = $subscription_method;
			$model->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));
			unset($_POST);
		}

		return $item_id; 
	}

	return false;
}

function deleteTestItem($item_id) {
	$IC = new Items();
	$item = $IC->getItem(["id" => $item_id]);
	$itemtype = $item["itemtype"];
	$model = $IC->TypeObject($itemtype);

	
	return $model->delete(["delete",$item_id]);	
	
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

	if($_options !== false) {
		foreach($_options as $_option => $_value) {
			switch($_option) {
				case "user_group_id"        : $user_group_id              = $_value; break;
				case "nickname"             : $nickname                   = $_value; break;
				case "firstname"            : $firstname                  = $_value; break;
				case "lastname"             : $lastname                   = $_value; break;
				case "status"               : $status                     = $_value; break;
				case "created_at"           : $created_at                 = $_value; break;
				case "email"                : $email                      = $_value; break;
				case "membership"           : $membership                 = $_value; break;
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

		return $user_id;
	}

	return false;
}

function deleteTestUser($user_id) {
	$query = new Query();

	$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $user_id";
	if($query->sql($sql)) {
		return true;
	}

	return false;
}

function deleteTestOrder($order_id) {
	$query = new Query();

	$sql = "DELETE FROM ".SITE_DB.".shop_cancelled_orders WHERE order_id = $order_id";
	if($query->sql($sql)) {
		
		$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
		if($query->sql($sql)) {
			return true;
		}
	}	

	return false;
}


?>


<div class="scene i:scene tests">
	<h1>SuperShop</h1>	
	<h2>Testing SuperShop class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests addToNewInternalCart">
		<h3>SuperShop::addToNewInternalCart</h3>

		<? 
		if(1 && "addToNewInternalCart – add test item – return cart with test item") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new SuperShop();

				$test_item_id = $model_tests->createTestItem(["price" => 100]);
				$test_user_id = $model_tests->createTestUser();
				

				// ACT
				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id]);
				
				
				// ASSERT 
				if(
					$cart &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["user_id"] == $test_user_id
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item – return cart with test item – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item – return cart with test item – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id, "user_id" => $test_user_id]);
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2)") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new SuperShop();

				$test_item_id = $model_tests->createTestItem(["price" => 100]);
				$test_user_id = $model_tests->createTestUser();

				// ACT
				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "quantity" => 2]);
				
				
				// ASSERT 
				if(
					$cart
					&& $cart["items"][0]["item_id"] == $test_item_id
					&& $cart["items"][0]["quantity"] == 2
					&& $cart["user_id"] == $test_user_id
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2) – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2) – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id, "user_id" => $test_user_id]);
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item without price – return false") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new SuperShop();

				$test_item_id = $model_tests->createTestItem();
				$test_user_id = $model_tests->createTestUser();

				// ACT
				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id]);
				
				
				// ASSERT 
				if(
					$cart == false
					&& $test_item_id
					&& $test_user_id
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item without price – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item without price – return false – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id, "user_id" => $test_user_id]);
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new SuperShop();

				$test_item_id = $model_tests->createTestItem(["price" => 100]);
				$test_user_id = $model_tests->createTestUser();

				// ACT
				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "custom_name" => "Test item with custom name", "custom_price" => 50]);
				
				
				// ASSERT 
				if(
					$cart
					&& $cart["items"][0]["item_id"] == $test_item_id
					&& $cart["user_id"] == $test_user_id
					&& $cart["items"][0]["custom_price"] == 50
					&& $cart["items"][0]["custom_name"] == "Test item with custom name"
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id, "user_id" => $test_user_id]);
	
			})();

		}
		?>

	</div>

	<div class="tests newOrderFromCart">
		<h3>SuperShop::newOrderFromCart()</h3>

		<?
		
		if(1 && "newOrderFromCart – empty cart – return false") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = createTestUser();

				// add cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);

				// ASSERT
				if(
					$cart && 
					isset($cart_reference) &&
					$order == false
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – empty cart – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – empty cart – return false – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id]);
				
				
			})();
		}

		if(1 && "newOrderFromCart – item without subscription method – return order, 'ordered'-callback, no 'subscribed'-callback") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = createTestUser();
				$item_id = createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				// print_r($cart);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
				// print_r($order);
				// debug($_SESSION);

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – item without subscription_method – return order, 'ordered'-callback, no 'subscribed'-callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – item without subscription_method – return order, 'ordered'-callback, no 'subscribed'-callback – error</p></div>
				<? endif; 

				// CLEAN UP

				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – pass cart and order_comment – return order with comment") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = createTestUser();
				$item_id = createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				// print_r($cart);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$_POST["order_comment"] = "Testing order comment";
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
				unset($_POST);
				// print_r($order);
				// debug($_SESSION);

				// ASSERT
				if(
					$order &&
					$order["comment"] == "Testing order comment" &&
					$order["items"] &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – pass cart and order_comment – return order with comment – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – pass cart and order_comment – return order with comment – error</p></div>
				<? endif; 

				// CLEAN UP

				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = createTestUser();
				$item_id = createTestItem(["price" => 100, "subscription_method" => 1]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				// print_r($cart);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);
				
				
			})();
		}

		if(0 && "newOrderFromCart – item with subscription method, subscription already exists – return order, 'ordered'-callback, 'subscribed'-callback") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser([""]);
				$item_id = createTestItem(["price" => 100, "subscription_method" => 1]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				// print_r($cart);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
				

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – item with subscription method, subscription already exists – return order, 'ordered'-callback, 'subscribed'-callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – item with subscription method, subscription already exists – return order, 'ordered'-callback, 'subscribed'-callback – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);
				
				
			})();
		}

		if(1 && "newOrderFromCart – cart_item with custom price – return order with custom price") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = createTestUser();
				$item_id = createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
				// print_r($order);
				// debug($_SESSION);

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] == 50 &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – cart_item with custom price – return order with custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – cart_item with custom price – return order with custom price – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}
		
		if(1 && "newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = createTestUser();
				$item_id = createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 0;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
				// print_r($order);
				// debug($_SESSION);

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] === "0" &&
					$order["status"] == 1 &&
					$order["payment_status"] == 2 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – cart_item with custom price with decimals – return order with custom price with decimals") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = createTestUser();
				$item_id = createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50.5;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
				
				// print_r($order);
				// debug($_SESSION);

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] == 50.5 &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – cart_item with custom price with decimals – return order with custom price with decimals – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – cart_item with custom price with decimals – return order with custom price with decimals – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – cart_item with custom name – return order with custom name") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = createTestUser();
				$item_id = createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_name"] = "Testing custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
				

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["name"] == "Testing custom name" &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – cart_item with custom name – return order with custom name – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – cart_item with custom name – return order with custom name – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = createTestUser();
				$item_id = createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$_POST["custom_name"] = "Testing custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
				

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] == 50 &&
					$order["items"][0]["name"] == "Testing custom name" &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name– return order with correct prices and quantities ") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = createTestUser();
				$item_id = createTestItem(["price" => 100]);

				// add cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 2;		
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$_POST["custom_name"] = "Testing custom name and custom price";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_name"] = "Testing only custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
				

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					count($order["items"]) == 4 &&
					$order["items"][0]["quantity"] == 1 &&
					$order["items"][0]["total_price"] == 100 &&
					$order["items"][0]["name"] == "Test item" &&
					$order["items"][1]["quantity"] == 2 &&
					$order["items"][1]["total_price"] == 100 &&
					$order["items"][1]["name"] == "Test item" &&
					$order["items"][2]["quantity"] == 1 &&
					$order["items"][2]["total_price"] == 50 &&
					$order["items"][2]["name"] == "Testing custom name and custom price" &&
					$order["items"][3]["quantity"] == 1 &&
					$order["items"][3]["total_price"] == 100 &&
					$order["items"][3]["name"] == "Testing only custom name" &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"]
					): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name – return order with correct prices and quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name – return order with correct prices and quantities – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

			})();
		}
		
		?>

	</div>

	<div class="tests getUnpaidOrders">
		<h3>SuperShop::getUnpaidOrders</h3>
		<?
		// add test user
		$_POST["nickname"] = "testuser@test.com";
		$_POST["user_group_id"] = 3;
		$user = $UC->save(["save"]);
		unset($_POST);
		$user_id = $user["item_id"];
		// create test membership item
		$model = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership = $model->save(array("save"));
		unset($_POST);
		$item_id = $membership["id"];

		$_POST["item_price"] = 100;
		$_POST["item_price_currency"] = "DKK";
		$_POST["item_price_vatrate"] = 1;
		$_POST["item_price_type"] = 1;
		$_POST["item_price_quantity"] = 1;
		$price = $model->addPrice(["addPrice", $item_id]);
		unset($_POST);
		 
		$_POST["user_id"] = $user_id;
		$cart = $SC->addCart(["addCart"]);
		$cart_id = $cart ? $cart["id"] : false;
		$cart_reference = $cart ? $cart["cart_reference"] : false;
		unset($_POST);
		
		$_POST["item_id"] = $item_id;
		$_POST["quantity"] = 1;
		$cart = $SC->addToCart(["addToCart", $cart_reference]);
		unset($_POST);

		$order =  $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
		$order_id = $order ? $order["id"]: false;

		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => $user_id]);
		if(
			$unpaid_orders &&
			$unpaid_orders[0]["user_id"] == $user_id &&
			$unpaid_orders[0]["order_no"] == $order["order_no"]
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct user id) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct user id) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 0]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by user id: 0, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by user id: 0, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 100000]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong user id, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong user id, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["itemtype" => "membership"]);
		if(
			$unpaid_orders &&
			$unpaid_orders[0]["user_id"] == $user_id &&
			$unpaid_orders[0]["order_no"] == $order["order_no"]
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct itemtype) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct itemtype) - error</p></div>
		<? endif; 
		$unpaid_orders = $SC->getUnpaidOrders(["itemtype" => "blabla"]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong itemtype, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong itemtype, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["itemtype" => "post"]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct itemtype but not existing as order, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct itemtype but not existing as order, should return false) - error</p></div>
		<? endif;

		$unpaid_orders = $SC->getUnpaidOrders(["item_id" => $item_id]);
		if(
			$unpaid_orders &&
			$unpaid_orders[0]["user_id"] == $user_id &&
			$unpaid_orders[0]["order_no"] == $order["order_no"]
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct item id) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct item id) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["item_id" => 0]);
		if(
			!$unpaid_orders 
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by item id: 0, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by item id: 0, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["item_id" => 1000000]);
		if(
			!$unpaid_orders 
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong item id, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong item id, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => $user_id, "itemtype" => "membership"]);
		if(
			$unpaid_orders &&
			$unpaid_orders[0]["user_id"] == $user_id &&
			$unpaid_orders[0]["order_no"] == $order["order_no"]
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct user id and itemtype) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct user id and itemtype) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => $user_id, "itemtype" => "blabla"]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct user id and wrong itemtype, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct user id and wrong itemtype, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 10000, "itemtype" => "blabla"]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong user id and wrong itemtype, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong user id and wrong itemtype, should return false) - error</p></div>
		<? endif;
	
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 10000, "itemtype" => "membership"]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong user id and correct itemtype, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong user id and correct itemtype, should return false) - error</p></div>
		<? endif;?>

		<?
		// // CLEAN UP
		// $model->delete(array("membership/delete/".$item_with_price["item_id"]));
		// $model->delete(array("membership/delete/".$item_without_price["item_id"]));
		
		// DELETE TEST ITEMS

			// delete user, order, item

		// $item_id = $item["id"];
		$membership_id = $membership["id"];
		$query = new Query();



		

		// delete item
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $item_id";
		$query->sql($sql);

		// delete order
		$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
		$query->sql($sql);

		// delete membership
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_id";
		$query->sql($sql);

		// delete user
		$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $user_id";
		$query->sql($sql);

		?>
		
	</div> 
	
	<div class="tests addCart">
		<h3>SuperShop::addCart</h3>

		<? 	
		function addCart_internalCart_returnCartNoCartReferenceInSession() {
			// addCart – internal cart – should return cart, no cart_reference in session
				
			// ARRANGE
			$query = new Query();
			$SC = new SuperShop();

			$cart = false;

			// clear cart reference from session
			session()->reset("cart_reference");
			$session_cart_reference = session()->value("cart_reference");

			// ACT
			$cart = $SC->addCart(["addCart"]);
			$cart_id = $cart ? $cart["id"] : false;
			
			// ASSERT 
			$session_cart_reference = session()->value("cart_reference");
			if(
				$cart &&
				$cart["id"] &&
				!$session_cart_reference
				): ?>
			<div class="testpassed"><p>SuperShop::addCart – internal cart – should return cart, no cart_reference in session – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperShop::addCart – internal cart – should return cart, no cart_reference in session – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete cart
			$sql = "DELETE FROM ".SITE_DB.".shop_carts WHERE id = ".$cart_id;
			$query->sql($sql);

			// clear cart reference from session
			session()->reset("cart_reference");

		}
		addCart_internalCart_returnCartNoCartReferenceInSession();
		?>

	</div>

	<div class="tests cancelOrder">
		<h3>SuperShop::cancelOrder</h3>

		<? 	

		if(1 && "cancel order – ordered item with order_cancelled callback – return true, order status 3, make order_cancelled callback")
		(function() {
				
			// ARRANGE
			$SC = new SuperShop();
			$IC = new Items();

			$model_tests = $IC->typeObject("tests");

			$test_item_id = createTestItem(["price" => 400]);
			$test_user_id = createTestUser();

			$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id]);
			if ($cart) {

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);
				$order_id = $order ? $order["id"] : false;
				// ACT
				$result = $SC->cancelOrder(["cancelOrder", $order_id, $test_user_id]);
				$order = $SC->getOrders(["order_id" => $order_id]);
			}
			else {
				$result = false;
			}

			
			
			
			// ASSERT 
			if(
				$result &&
				session()->value("test_item_order_cancelled_callback") &&
				$order["status"] == 3
				): ?>
			<div class="testpassed"><p>SuperShop::cancelOrder – ordered item with order_cancelled callback – return true, order status 3, make order_cancelled callback – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperShop::cancelOrder – ordered item with order_cancelled callback – return true, order status 3, make order_cancelled callback – error</p></div>
			<? endif; 
			
			// CLEAN UP
			$model_tests->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);


			// clear session
			session()->reset("test_item_order_cancelled");
		})();
		?>

	</div>

	<div class="tests addToCart">
		
		<h3>SuperShop::addToCart()</h3>

		<?

		if(1 && "addToCart – add item without price – return false") {

			(function(){

				// ARRANGE
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");
				
				$test_item_id = createTestItem();

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;

				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$result = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ASSERT
				if(
					$result === false &&
					$cart &&
					!$cart["items"]
					): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add item without price – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add item without price – return false – error</p></div>
				
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);

				$SC->deleteCart(["deleteCart", $cart_id, $cart_reference]);

			})();
		}

		if(1 && "addToCart – add two different itemtypes to cart – return cart") {

			(function(){

				// ARRANGE
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				$test_item_id = createTestItem(["price" => 100]);
				$membership_item_id = createTestItem(["itemtype" => "membership", "price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;

				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $membership_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ASSERT
				if(
					$cart &&
					$cart["id"] &&
					$cart["cart_reference"] &&
					$cart["country"] &&
					$cart["currency"] &&
					$cart["items"] &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][1]["item_id"] == $membership_item_id &&
					$cart["items"][0]["quantity"] == 1 &&
					$cart["items"][1]["quantity"] == 1 &&
					$cart["items"][0]["id"] &&
					$cart["items"][1]["id"] &&
					$cart["items"][0]["cart_id"] &&
					$cart["items"][1]["cart_id"] &&
					count($cart["items"]) == 2
					): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add two different itemtypes to cart – return cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add two different itemtypes to cart – return cart – error</p></div>
				
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$model_tests->cleanUp(["item_id" => $membership_item_id]);
				$SC->deleteCart(["deleteCart", $cart_id, $cart_reference]);

			})();
		}

		if(1 && "addToCart – add item that already exists in cart – return cart with updated quantity") {

			(function(){

				// ARRANGE
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				$test_item_id = createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;

				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ASSERT
				if(
					$cart &&
					$cart["items"] &&
					$cart["items"][0]["quantity"] == 2 &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					count($cart["items"]) == 1 &&
					$cart["id"] &&
					$cart["cart_reference"] &&
					$cart["country"] &&
					$cart["currency"]
					): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add item that already exists in cart – return cart with updated quantity – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add item that already exists in cart – return cart with updated quantity – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$SC->deleteCart(["deleteCart", $cart_id, $cart_reference]);

			})();
		}

		if(1 && "addToCart – add item to non-existing cart – return false") {

			(function(){

				// ARRANGE
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				$test_item_id = createTestItem(["price" => 100]);

				$cart = false;

				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				
				$cart = $SC->addToCart(["addToCart"]);
				unset($_POST);

				if(
					$cart === false
				): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add item to non-existing cart – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add item to non-existing cart – return false – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);

			})();
		}

		if(1 && "addToCart – add item with custom_name and custom_price – return cart") {

			(function(){

				// ARRANGE
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				$test_item_id = createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;

				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ASSERT
				if(
					$cart &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][0]["custom_name"] == "Test item with special price" &&
					$cart["items"][0]["custom_price"] == 50
					): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add item with custom_name and custom_price – return cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add item with custom_name and custom_price – return cart – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$SC->deleteCart(["deleteCart", $cart_id, $cart_reference]);

			})();
		}

		if(1 && "addToCart – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items ") {

			(function(){

				// ARRANGE
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				$test_item_id = createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;

				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ASSERT
				if(
					$cart &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][1]["item_id"] == $test_item_id &&
					$cart["items"][0]["custom_price"] == 50 &&
					count($cart["items"]) == 2
					): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items  – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items  – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$SC->deleteCart(["deleteCart", $cart_id, $cart_reference]);

			})();
		}

		if(1 && "addToCart – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities ") {

			(function(){

				// ARRANGE
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				$test_item_id = createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;

				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 75;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
	
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 75;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ASSERT
				if(
					$cart &&
					count($cart["items"]) == 3 &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][1]["item_id"] == $test_item_id &&
					$cart["items"][2]["item_id"] == $test_item_id &&
					$cart["items"][0]["custom_price"] == 50 &&
					!isset($cart["items"][1]["custom_price"]) &&
					$cart["items"][2]["custom_price"] == 75 &&
					$cart["items"][0]["quantity"] == 1 &&
					$cart["items"][1]["quantity"] == 2 &&
					$cart["items"][2]["quantity"] == 2 
					): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$SC->deleteCart(["deleteCart", $cart_id, $cart_reference]);

			})();
		}

		if(1 && "addToCart – add the same item twice, one standard, and one with custom name – return cart with separated items") {

			(function(){

				// ARRANGE
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				$test_item_id = createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;

				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				// ASSERT
				if(
					$cart &&
					count($cart["items"]) == 2 &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][1]["item_id"] == $test_item_id &&
					!isset($cart["items"][0]["custom_name"]) &&
					$cart["items"][1]["custom_name"] == "AAA"
					): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add the same item twice, one standard, and one with custom name – return cart with separated items – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add the same item twice, one standard, and one with custom name – return cart with separated items – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$SC->deleteCart(["deleteCart", $cart_id, $cart_reference]);

			})();
		}

		if(1 && "addToCart – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities ") {

			(function(){

				// ARRANGE
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				$test_item_id = createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;

				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "BBB";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
	
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "BBB";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ASSERT
				if(
					$cart &&
					count($cart["items"]) == 3 &&
					$cart["items"][0]["custom_name"] == "AAA" &&
					!isset($cart["items"][1]["custom_name"]) &&
					$cart["items"][2]["custom_name"] == "BBB" &&
					$cart["items"][0]["quantity"] == 1 &&
					$cart["items"][1]["quantity"] == 2 &&
					$cart["items"][2]["quantity"] == 2 &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][1]["item_id"] == $test_item_id &&
					$cart["items"][2]["item_id"] == $test_item_id
					
					): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$SC->deleteCart(["deleteCart", $cart_id, $cart_reference]);

			})();
		}

		if(1 && "addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities") {

			(function(){

				// ARRANGE
				$SC = new SuperShop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				$test_item_id = createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;

				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "BBB";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_price"] = 75;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "BBB";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$_POST["custom_price"] = 75;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "BBB";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ASSERT
				if(
					$cart &&
					count($cart["items"]) == 8 &&
					!isset($cart["items"][0]["custom_name"]) &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][0]["quantity"] == 2 &&
					$cart["items"][1]["item_id"] == $test_item_id &&
					$cart["items"][1]["custom_name"] == "AAA" &&
					$cart["items"][1]["quantity"] == 1 &&
					$cart["items"][2]["item_id"] == $test_item_id &&
					$cart["items"][2]["custom_name"] == "BBB" &&
					$cart["items"][2]["quantity"] == 2 &&
					$cart["items"][3]["item_id"] == $test_item_id &&
					$cart["items"][3]["custom_price"] == 50 &&
					$cart["items"][3]["quantity"] == 2 &&
					$cart["items"][4]["item_id"] == $test_item_id &&
					$cart["items"][4]["custom_price"] == 75 &&
					$cart["items"][4]["quantity"] == 1 &&
					$cart["items"][5]["item_id"] == $test_item_id &&
					$cart["items"][5]["custom_price"] == 50 &&
					$cart["items"][5]["custom_name"] == "AAA" &&
					$cart["items"][5]["quantity"] == 2 &&
					$cart["items"][6]["item_id"] == $test_item_id &&
					$cart["items"][6]["custom_price"] == 50 &&
					$cart["items"][6]["custom_name"] == "BBB" &&
					$cart["items"][6]["quantity"] == 1 &&
					$cart["items"][7]["item_id"] == $test_item_id &&
					$cart["items"][7]["custom_name"] == "AAA" &&
					$cart["items"][7]["custom_price"] == 75 &&
					$cart["items"][7]["quantity"] == 1
					
					): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$SC->deleteCart(["deleteCart", $cart_id, $cart_reference]);

			})();
		}


		?>

		

		

	</div>

</div>