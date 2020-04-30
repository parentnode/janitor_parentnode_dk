<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();

$UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'DA','Dansk'", "id = 'DA'");
$UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'EN','English'", "id = 'EN'");
$UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'DE','Deutch'", "id = 'DE'");

$UpgradeClass->checkDefaultValues(UT_CURRENCIES, "'DKK', 'Kroner (Denmark)', 'DKK', 'after', 2, ',', '.'", "id = 'DKK'");
$UpgradeClass->checkDefaultValues(UT_CURRENCIES, "'EUR', 'Euro (Denmark)', '€', 'before', 2, ',', '.'", "id = 'EUR'");

$UpgradeClass->checkDefaultValues(UT_COUNTRIES, "'DK', 'Danmark', '45', '#### ####', 'DA', 'DKK'", "id = 'DK'");
$UpgradeClass->checkDefaultValues(UT_COUNTRIES, "'DE', 'Deutchland', '49', '#### ####', 'DE', 'EUR'", "id = 'DE'");

$UpgradeClass->checkDefaultValues(UT_SUBSCRIPTION_METHODS, "DEFAULT, 'Month', 'monthly', DEFAULT", "name = 'Month'");
$UpgradeClass->checkDefaultValues(UT_VATRATES, "999, 'No VAT', 0, 'DK'", "id = 999");
$UpgradeClass->checkDefaultValues(UT_VATRATES, "998, '25%', 25, 'DK'", "id = 998");





$query = new Query();
$IC = new Items();

include_once("classes/shop/supershop.class.php");
$SC = new Shop();
$SSC = new SuperShop();

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

function deleteTestCart($cart_reference) {
	$query = new Query();

	$sql = "DELETE FROM ".SITE_DB.".shop_carts WHERE cart_reference = '$cart_reference'";
//			print $sql;

	if($query->sql($sql)) {
		return true;
	}
	
	return false;
}
?>

<div class="scene i:scene tests defaultEdit">
	<h1>Shop</h1>	
	<h2>Testing Shop class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests getPrice">
		<h3>Shop::getPrice</h3>
		<?
		if(1 && "getPrice – item with default price – return default price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				// ACT
				
				$price = $SC->getPrice($test_item_id);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == 100
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price – return default price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();
		} 

		if(1 && "getPrice – item with default price of 0 – return default price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $model_tests->createTestItem(["price" => 0]);

				// ACT
				
				$price = $SC->getPrice($test_item_id);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == "0"
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price of 0 – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price of 0 – return default price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();
		} 

		if(1 && "getPrice – item with default price and cheaper offer price – return offer price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"offer" => [
							"price" => 50
						]
					]
				]);

				// ACT
				
				$price = $SC->getPrice($test_item_id);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == 50
					&& $price["type"] == "offer"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and cheaper offer price – return offer price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and cheaper offer price – return offer price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();
		}
		
		if(1 && "getPrice – item with default price and more expensive offer price – return default price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"offer" => [
							"price" => 150
						]
					]
				]);

				// ACT
				
				$price = $SC->getPrice($test_item_id);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == 100
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and more expensive offer price – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and more expensive offer price – return default price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();
		} 

		if(1 && "getPrice – item with default price and bulk price with minimum quantity 3, get price for 3 items – return bulk price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"bulk" => [
							"price" => 80,
							"quantity" => 3
						]
					]
				]);

				// ACT
				
				$price = $SC->getPrice($test_item_id, ["quantity" => 3]);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == 80
					&& $price["type"] == "bulk"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and bulk price with minimum quantity 3, get price for 3 items – return bulk price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and bulk price with minimum quantity 3, get price for 3 items – return bulk price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();
		} 

		if(1 && "getPrice – item with default price and bulk price with minimum quantity 3, get price for 2 items – return default price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"bulk" => [
							"price" => 80,
							"quantity" => 3
						]
					]
				]);

				// ACT
				
				$price = $SC->getPrice($test_item_id, ["quantity" => 2]);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == 100
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and bulk price with minimum quantity 3, get price for 2 items – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and bulk price with minimum quantity 3, get price for 2 items – return default price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();
		}

		if(1 && "getPrice – item with default price and cheaper membership price, user has matching membership – return membership price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();
				$SubscriptionClass = new Subscription();
				$MC = new Member();
				$user_id = session()->value("user_id");
				

				$membership_item_id = $model_tests->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2
				]);

				$_POST["item_id"] = $membership_item_id;
				$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				$membership = $MC->addMembership($membership_item_id, $subscription["id"]);

				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"test-membership" => [
							"price" => 75
						]
					]
				]);
				

				// ACT
				
				$price = $SC->getPrice($test_item_id);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == 75
					&& $price["type"] == "test-membership"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and cheaper membership price, user has matching membership – return membership price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and cheaper membership price, user has matching membership – return membership price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$model_tests->cleanUp(["item_id" => $membership_item_id, "user_id" => $user_id]);
	
			})();
		}

		if(1 && "getPrice – item with default price and more expensive membership price, user has matching membership – return membership price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();
				$SubscriptionClass = new Subscription();
				$MC = new Member();
				$user_id = session()->value("user_id");
				

				$membership_item_id = $model_tests->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2
				]);

				$_POST["item_id"] = $membership_item_id;
				$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				$membership = $MC->addMembership($membership_item_id, $subscription["id"]);

				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 75
						],
						"test-membership" => [
							"price" => 100
						]
					]
				]);
				

				// ACT
				
				$price = $SC->getPrice($test_item_id);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == 75
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and more expensive membership price, user has matching membership – return membership price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and more expensive membership price, user has matching membership – return membership price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$model_tests->cleanUp(["item_id" => $membership_item_id, "user_id" => $user_id]);
	
			})();
		}

		if(1 && "getPrice – item with default price and cheaper membership price, user has different membership – return default price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();
				$SubscriptionClass = new Subscription();
				$MC = new Member();
				$user_id = session()->value("user_id");
				

				$membership_item_id = $model_tests->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2
				]);

				$membership_item_id_2 = $model_tests->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership-2",
					"subscription_method" => 2
				]);

				$_POST["item_id"] = $membership_item_id_2;
				$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				$membership = $MC->addMembership($membership_item_id_2, $subscription["id"]);

				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"test-membership" => [
							"price" => 75
						]
					]
				]);
				

				// ACT
				
				$price = $SC->getPrice($test_item_id);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == 100
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and cheaper membership price, user has different membership – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and cheaper membership price, user has different membership – return default price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$model_tests->cleanUp(["item_id" => $membership_item_id]);
				$model_tests->cleanUp(["item_id" => $membership_item_id_2, "user_id" => $user_id]);
	
			})();
		}

		if(1 && "getPrice – item with default price and membership price, user has no membership – return default price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();
				$user_id = session()->value("user_id");
				

				$membership_item_id = $model_tests->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2
				]);


				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"test-membership" => [
							"price" => 75
						]
					]
				]);
				

				// ACT
				
				$price = $SC->getPrice($test_item_id);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == 100
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and membership price, user has no membership – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and membership price, user has no membership – return default price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$model_tests->cleanUp(["item_id" => $membership_item_id, "user_id" => $user_id]);
	
			})();
		}

		if(1 && "getPrice – item with default price and cheaper membership price and even cheaper offer price, user has matching membership – return offer price") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();
				$SubscriptionClass = new Subscription();
				$MC = new Member();
				$user_id = session()->value("user_id");
				

				$membership_item_id = $model_tests->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2
				]);

				$_POST["item_id"] = $membership_item_id;
				$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				$membership = $MC->addMembership($membership_item_id, $subscription["id"]);

				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"test-membership" => [
							"price" => 75
						],
						"offer" => [
							"price" => 50
						]
					]
				]);
				

				// ACT
				
				$price = $SC->getPrice($test_item_id);
				
				// ASSERT 
				if(
					$price
					&& $price["price"] == 50
					&& $price["type"] == "offer"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and cheaper membership price and even cheaper offer price, user has matching membership – return offer price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and cheaper membership price and even cheaper offer price, user has matching membership – return offer price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$model_tests->cleanUp(["item_id" => $membership_item_id, "user_id" => $user_id]);
	
			})();
		}

		if(1 && "getPrice – item with only membership price, user has no membership – return false") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();
				$SubscriptionClass = new Subscription();
				$MC = new Member();
				$user_id = session()->value("user_id");
				

				$membership_item_id = $model_tests->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2
				]);


				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"test-membership" => [
							"price" => 75
						]
					]
				]);
				

				// ACT
				
				$price = $SC->getPrice($test_item_id);
				
				// ASSERT 
				if(
					$price === false
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with only membership price, user has no membership – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with only membership price, user has no membership – return false – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$model_tests->cleanUp(["item_id" => $membership_item_id, "user_id" => $user_id]);
	
			})();
		}

		?>
	</div>

	<div class="tests addToCart">
		
		<h3>Shop::addToCart()</h3>

		<?

		if(1 && "addToCart – add item without price – return false") {

			(function(){

				// ARRANGE
				$SC = new Shop();
				$IC = new Items();

				$test_item_id = createTestItem();

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

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
				<div class="testpassed"><p>Shop::addToCart() – add item without price – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add item without price – return false – error</p></div>
				
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestCart($cart_reference);

			})();
		}

		if(1 && "addToCart – add two different itemtypes to cart – return cart") {

			(function(){

				// ARRANGE
				$SC = new Shop();
				$IC = new Items();
				$model_tests = $IC->TypeObject("tests");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);
				$membership_item_id = $model_tests->createTestItem(["itemtype" => "membership", "price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

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
				<div class="testpassed"><p>Shop::addToCart() – add two different itemtypes to cart – return cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add two different itemtypes to cart – return cart – error</p></div>
				
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestItem($membership_item_id);
				deleteTestCart($cart_reference);

			})();
		}

		if(1 && "addToCart – add item that already exists in cart – return cart with updated quantity") {

			(function(){

				// ARRANGE
				$SC = new Shop();
				$IC = new Items();
				$model_tests = $IC->TypeObject("tests");


				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

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
				<div class="testpassed"><p>Shop::addToCart() – add item that already exists in cart – return cart with updated quantity – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add item that already exists in cart – return cart with updated quantity – error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestCart($cart_reference);

			})();
		}

		if(1 && "addToCart – add item with custom_name and custom_price – return cart") {

			(function(){

				// ARRANGE
				$SC = new Shop();
				$IC = new Items();
				$model_tests = $IC->TypeObject("tests");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

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
				<div class="testpassed"><p>Shop::addToCart() – add item with custom_name and custom_price – return cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add item with custom_name and custom_price – return cart – error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestCart($cart_reference);

			})();
		}

		if(0 && "addToCart – add item with custom_price of 0 – return cart with cart item with custom price of 0") {

			(function(){

				// ARRANGE
				$SC = new Shop();
				$IC = new Items();
				$model_tests = $IC->TypeObject("tests");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 0;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ASSERT
				if(
					$cart
					&& $cart["items"][0]["item_id"] == $test_item_id
					&& $cart["items"][0]["custom_price"] === "0"
				): ?>
				<div class="testpassed"><p>Shop::addToCart() – add item with custom_price of 0 – return cart with cart item with custom price of 0 – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add item with custom_price of 0 – return cart with cart item with custom price of 0 – error</p></div>
				<? endif; 

				
				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestCart($cart_reference);

			})();
		}

		if(1 && "addToCart – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items ") {

			(function(){

				// ARRANGE
				$SC = new Shop();
				$IC = new Items();
				$model_tests = $IC->TypeObject("tests");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

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
				<div class="testpassed"><p>Shop::addToCart() – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items  – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items  – error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestCart($cart_reference);

			})();
		}

		if(1 && "addToCart – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities ") {

			(function(){

				// ARRANGE
				$SC = new Shop();
				$IC = new Items();
				$model_tests = $IC->TypeObject("tests");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

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
				<div class="testpassed"><p>Shop::addToCart() – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestCart($cart_reference);

			})();
		}

		if(1 && "addToCart – add the same item twice, one standard, and one with custom name – return cart with separated items") {

			(function(){

				// ARRANGE
				$SC = new Shop();
				$IC = new Items();
				$model_tests = $IC->TypeObject("tests");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

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
				<div class="testpassed"><p>Shop::addToCart() – add the same item twice, one standard, and one with custom name – return cart with separated items – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add the same item twice, one standard, and one with custom name – return cart with separated items – error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestCart($cart_reference);

			})();
		}

		if(1 && "addToCart – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities ") {

			(function(){

				// ARRANGE
				$SC = new Shop();
				$IC = new Items();
				$model_tests = $IC->TypeObject("tests");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

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
				<div class="testpassed"><p>Shop::addToCart() – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestCart($cart_reference);

			})();
		}

		if(1 && "addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities") {

			(function(){

				// ARRANGE
				$SC = new Shop();
				$IC = new Items();
				$model_tests = $IC->TypeObject("tests");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

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
				<div class="testpassed"><p>Shop::addToCart() – addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestCart($cart_reference);

			})();
		}

		?>

	</div>

	<div class="tests addCart">
		<h3>Shop::addCart</h3>

		<? 	
		function addCart_normalCart_returnCartAddCartReferenceToSession() {
			// addCart – normal cart – should return cart and add cart_reference to session
				
			// ARRANGE
			$query = new Query();
			$SC = new Shop();

			$cart = false;

			// ACT 
			$cart = $SC->addCart(["addCart"]);
			
			
			// ASSERT 
			if(
				$cart &&
				$cart["id"] &&
				session()->value("cart_reference") == $cart["cart_reference"]
				): ?>
			<div class="testpassed"><p>Shop::addCart – normal cart – should return cart and add cart_reference to session – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Shop::addCart – normal cart – should return cart and add cart_reference to session – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete cart
			$sql = "DELETE FROM ".SITE_DB.".shop_carts WHERE id = ".$cart["id"];
			$query->sql($sql);

			// clear cart reference from session
			session()->reset("cart_reference");


		}
		addCart_normalCart_returnCartAddCartReferenceToSession();
		?>
		<? 	
		function addCart_internalCart_returnCartNoCartReferenceInSession() {
			// addCart – internal cart – should return cart, no cart_reference in session
				
			// ARRANGE
			$query = new Query();
			$SC = new Shop();

			$cart = false;

			// clear cart reference from session
			session()->reset("cart_reference");
			$session_cart_reference = session()->value("cart_reference");


			// ACT
			$_POST["is_internal"] = true;
			$cart = $SC->addCart(["addCart"]);
			unset($_POST);
			
			
			// ASSERT 
			$session_cart_reference = session()->value("cart_reference");
			if(
				$cart &&
				$cart["id"] &&
				!$session_cart_reference
				): ?>
			<div class="testpassed"><p>Shop::addCart – internal cart – should return cart, no cart_reference in session – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Shop::addCart – internal cart – should return cart, no cart_reference in session – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete cart
			$sql = "DELETE FROM ".SITE_DB.".shop_carts WHERE id = ".$cart["id"];
			$query->sql($sql);

			// clear cart reference from session
			session()->reset("cart_reference");

		}
		addCart_internalCart_returnCartNoCartReferenceInSession();
		?>

	</div>


	<div class="tests addToNewInternalCart">
		<h3>Shop::addToNewInternalCart</h3>

		<? 
		if(1 && "addToNewInternalCart – add test item – return cart with test item") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				// ACT
				$cart = $SC->addToNewInternalCart($test_item_id);
				
				
				// ASSERT 
				if(
					$cart &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["user_id"] == session()->value("user_id")
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item – return cart with test item – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item – return cart with test item – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id, "user_id" => $cart["user_id"]]);
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2)") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				// ACT
				$cart = $SC->addToNewInternalCart($test_item_id, ["quantity" => 2]);
				
				
				// ASSERT 
				if(
					$cart
					&& $cart["items"][0]["item_id"] == $test_item_id
					&& $cart["items"][0]["quantity"] == 2
					&& $cart["user_id"] == session()->value("user_id")
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2) – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2) – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id, "user_id" => $cart["user_id"]]);
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item without price – return false") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $model_tests->createTestItem();

				// ACT
				$cart = $SC->addToNewInternalCart($test_item_id);
				
				
				// ASSERT 
				if(
					$cart == false
					&& $test_item_id
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item without price – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item without price – return false – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				// ACT
				$cart = $SC->addToNewInternalCart($test_item_id, ["custom_name" => "Test item with custom name", "custom_price" => 50]);
				
				
				// ASSERT 
				if(
					$cart
					&& $cart["items"][0]["item_id"] == $test_item_id
					&& $cart["user_id"] == session()->value("user_id")
					&& $cart["items"][0]["custom_price"] == 50
					&& $cart["items"][0]["custom_name"] == "Test item with custom name"
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id, "user_id" => $cart["user_id"]]);
	
			})();

		}

		?>

	</div>

	<div class="tests getCart">
		<h3>Shop::getCart()</h3>
		
		<? 
		if(1 && "getCart – cart with 1 item – return cart") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$SC = new Shop();
				$model_tests = $IC->typeObject("tests");

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

				$test_item_id = $model_tests->createTestItem();

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$cart = $SC->getCart();
				
				// ASSERT 
				if(
					$cart 
					&& $cart["user_id"] == session()->value("user_id")
					&& $cart_reference == $cart["cart_reference"]
				): ?>
				<div class="testpassed"><p>Shop::getCart – cart with 1 item – return cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getCart – cart with 1 item – return cart – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();
		}
		?>

	</div>

	<div class="tests newOrderFromCart">
		<h3>Shop::newOrderFromCart()</h3>

		<?
		
		if(1 && "newOrderFromCart – empty cart – return false") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();

				// add cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart_reference]);

				// ASSERT
				if(
					$cart && 
					isset($cart_reference) &&
					$order == false
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – empty cart – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – empty cart – return false – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id]);
				
				
			})();
		}

		if(1 && "newOrderFromCart – item without subscription method – return order, 'ordered'-callback, no 'subscribed'-callback") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();
				$item_id = $model_tests->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				// print_r($cart);
				$cart_id = $cart["id"];
				$cart_reference = $cart["cart_reference"];
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				$order_id = $order["id"];
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
				<div class="testpassed"><p>Shop::newOrderFromCart – item without subscription_method – return order, 'ordered'-callback, no 'subscribed'-callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – item without subscription_method – return order, 'ordered'-callback, no 'subscribed'-callback – error</p></div>
				<? endif; 

				// CLEAN UP

				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – pass cart and order_comment method – return order with comment") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();
				$item_id = $model_tests->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				// print_r($cart);
				$cart_id = $cart["id"];
				$cart_reference = $cart["cart_reference"];
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$_POST["order_comment"] = "Testing order comment";
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				unset($_POST);
				$order_id = $order["id"];
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
				<div class="testpassed"><p>Shop::newOrderFromCart – pass cart and order_comment – return order with comment – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – pass cart and order_comment – return order with comment – error</p></div>
				<? endif; 

				// CLEAN UP

				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();
				$item_id = $model_tests->createTestItem(["price" => 100, "subscription_method" => 1]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				// print_r($cart);
				$cart_id = $cart["id"];
				$cart_reference = $cart["cart_reference"];
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				$order_id = $order["id"];

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
				<div class="testpassed"><p>Shop::newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);
				
				
			})();
		}

		if(1 && "newOrderFromCart – cart_item with custom price – return order with custom price") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();
				$item_id = $model_tests->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart["id"];
				$cart_reference = $cart["cart_reference"];
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				$order_id = $order["id"];
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
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom price – return order with custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom price – return order with custom price – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();
				$item_id = $model_tests->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart["id"];
				$cart_reference = $cart["cart_reference"];
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 0;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				$order_id = $order["id"];
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
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – cart_item with custom price with comma-seperated decimal – return order with custom price with period-seperated decimal") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();
				$item_id = $model_tests->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart["id"];
				$cart_reference = $cart["cart_reference"];
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = "50,5";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				$order_id = $order["id"];
				// print_r($order);
				// debug($_SESSION);

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] === "50.5" &&
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
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom price with comma-seperated decimal – return order with custom price with period-seperated decimal – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom price with comma-seperated decimal – return order with custom price with period-seperated decimal – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – cart_item with custom price with period-seperated decimal – return order with custom price with comma-seperated decimal") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();
				$item_id = $model_tests->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart["id"];
				$cart_reference = $cart["cart_reference"];
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = "50.5";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				$order_id = $order["id"];
				// print_r($order);
				// debug($_SESSION);

				// ASSERT
				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] === "50.5" &&
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
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom price with period-seperated decimal – return order with custom price with comma-seperated decimal – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom price with period-seperated decimal – return order with custom price with comma-seperated decimal – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}


		if(1 && "newOrderFromCart – cart_item with custom name – return order with custom name") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();
				$item_id = $model_tests->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart["id"];
				$cart_reference = $cart["cart_reference"];
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_name"] = "Testing custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				$order_id = $order["id"];

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
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom name – return order with custom name – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom name – return order with custom name – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();
				$item_id = $model_tests->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart["id"];
				$cart_reference = $cart["cart_reference"];
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$_POST["custom_name"] = "Testing custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				$order_id = $order["id"];

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
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

				
				
			})();
		}

		if(1 && "newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name– return order with correct prices and quantities ") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new Shop();
				$IC = new Items();

				$model_tests = $IC->typeObject("tests");

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$user_id = $model_tests->createTestUser();
				$item_id = $model_tests->createTestItem(["price" => 100]);

				// add cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart["id"];
				$cart_reference = $cart["cart_reference"];
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
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				$order_id = $order["id"];

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
				<div class="testpassed"><p>Shop::newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name – return order with correct prices and quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name – return order with correct prices and quantities – error</p></div>
				<? endif; 

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $user_id, "item_id" => $item_id]);

			})();
		}


		
		
		?>

	</div>
	
	<div class="tests deleteItemtypeFromCart">
		<h3>Shop::deleteItemtypeFromCart()</h3>
		<? 
		if(1 && "deleteItemtypeFromCart – delete existing itemtype – return cart without deleted itemtype") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$cart = $SC->emptyCart("emptyCart");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);
				$membership_item_id = $model_tests->createTestItem(["itemtype" => "membership", "price" => 100]);

				$_POST["item_id"] = $membership_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(array("addToCart"));
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(array("addToCart"));
				unset($_POST);

				$old_cart = $cart;
				
				$itemtype = "membership";
				
				// ACT
				$cart = $SC->deleteItemtypeFromCart($itemtype);
				
				
				// ASSERT 
				if(
					$cart
					&& $old_cart
					&& count($cart["items"]) == 1
					&& count($old_cart["items"]) == 2
					&& $cart["items"][0]["item_id"] == $test_item_id 
					&& $old_cart["items"][0]["item_id"] == $membership_item_id 
					&& $old_cart["items"][1]["item_id"] == $test_item_id 
				): ?>
				<div class="testpassed"><p>Shop::deleteItemtypeFromCart – delete existing itemtype – return cart without deleted itemtype – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::deleteItemtypeFromCart – delete existing itemtype – return cart without deleted itemtype – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$model_tests->cleanUp(["item_id" => $membership_item_id]);
				
			})();
		}
		if(1 && "deleteItemtypeFromCart – delete non-existing itemtype – return unchanged cart") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$cart = $SC->emptyCart("emptyCart");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);
				$membership_item_id = $model_tests->createTestItem(["itemtype" => "membership", "price" => 100]);

				$_POST["item_id"] = $membership_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(array("addToCart"));
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(array("addToCart"));
				unset($_POST);

				$old_cart = $cart;
				
				$itemtype = "blabla";
				
				// ACT
				$cart = $SC->deleteItemtypeFromCart($itemtype);
				
				
				// ASSERT 
				if(
					$cart
					&& $old_cart
					&& count($cart["items"]) == 2
					&& count($old_cart["items"]) == 2
					&& $cart["items"][0]["item_id"] == $membership_item_id 
					&& $cart["items"][1]["item_id"] == $test_item_id 
					&& $old_cart["items"][0]["item_id"] == $membership_item_id 
					&& $old_cart["items"][1]["item_id"] == $test_item_id 
				): ?>
				<div class="testpassed"><p>Shop::deleteItemtypeFromCart – delete non-existing itemtype – return unchanged cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::deleteItemtypeFromCart – delete non-existing itemtype – return unchanged cart – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				$model_tests->cleanUp(["item_id" => $membership_item_id]);
				
			})();
		}
		if(1 && "deleteItemtypeFromCart – delete existing itemtype that is not in cart – return unchanged cart") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$SC = new Shop();

				$cart = $SC->emptyCart("emptyCart");

				$test_item_id = $model_tests->createTestItem(["price" => 100]);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(array("addToCart"));
				unset($_POST);

				$old_cart = $cart;
				
				$itemtype = "membership";
				
				// ACT
				$cart = $SC->deleteItemtypeFromCart($itemtype);
				
				
				// ASSERT 
				if(
					$cart
					&& $old_cart
					&& count($cart["items"]) == 1
					&& count($old_cart["items"]) == 1
					&& $cart["items"][0]["item_id"] == $test_item_id 
					&& $old_cart["items"][0]["item_id"] == $test_item_id 
				): ?>
				<div class="testpassed"><p>Shop::deleteItemtypeFromCart – delete existing itemtype that is not in cart – return unchanged cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::deleteItemtypeFromCart – delete existing itemtype that is not in cart – return unchanged cart – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
				
			})();
		}
		?>
		
	</div>
	
</div>
