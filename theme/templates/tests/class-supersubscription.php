<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();


include_once("classes/shop/supersubscription.class.php");
$SuperSubscriptionClass = new SuperSubscription();

$query = new Query();
$IC = new Items();
$model_tests = $IC->typeObject("tests");

// TODO: rewrite tests to use these functions
function createTestItem($_options = false) {

	$IC = new Items();

	$itemtype = "tests";
	$name = "Test item";
	$price = false;
	$subscription_method = false;

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
	unset($_POST);


	if($item) {

		$item_id = $item["id"];

		if($price) {
			$_POST["item_price"] = $price;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$model->addPrice(array("addPrice", $item_id));
			unset($_POST);
		}

		if($subscription_method) {
			$_POST["item_subscription_method"] = 2;
			$model->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));
			unset($_POST);
		}

		return $item_id;
	}

	return false;
}

function deleteTestItem($item_id) {
	
	$IC = new Items();
	$query = new Query();

	$item = $IC->getItem(["id" => $item_id]);
	$itemtype = $item["itemtype"];
	$model = $IC->TypeObject($itemtype);

	// delete subscription
	$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN($item_id)";
	$query->sql($sql);

	// delete test items
	$model->delete(["delete",$item_id]);

	// delete order
	// $added_item_order_id = $added_item_order["id"];
	// $sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
	// $query->sql($sql);

	// clear session for callback checks
	session()->reset("test_item_subscribed_callback");
	session()->reset("test_item_ordered_callback");
	
	return true;	
	
}

function createTestUser($_options = false) {
	$query = new Query();
	include_once("classes/users/superuser.class.php");
	$UC = new SuperUser();
	include_once("classes/shop/supersubscription.class.php");
	$SuperSubscriptionClass = new SuperSubscription();

	$user_group_id = 2;
	$nickname = "test user";
	$status = 1;
	$created_at = "2019-01-01 00:00:00";
	$email = "test.parentnode@gmail.com";
	$subscribed_item_id = false;

	if($_options !== false) {
		foreach($_options as $_option => $_value) {
			switch($_option) {
				case "user_group_id"        : $user_group_id              = $_value; break;
				case "nickname"             : $nickname                   = $_value; break;
				case "status"               : $status                     = $_value; break;
				case "created_at"           : $created_at                 = $_value; break;
				case "email"                : $email                      = $_value; break;
				case "subscribed_item_id"   : $subscribed_item_id         = $_value; break;
				case "expires_at"           : $expires_at                 = $_value; break;
			}
		}
	}

	$_POST["user_group_id"] = $user_group_id;
	$_POST["nickname"] = $nickname;
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

			$added_item_cart = $SC->addToNewInternalCart($subscribed_item_id, ["user_id" => $user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $user_id, "item_id" => $subscribed_item_id]);
		}

		if($expires_at) {
			$sql = "UPDATE ".SITE_DB.".user_item_subscriptions SET expires_at = '".$expires_at."' WHERE id = ".$added_subscription["id"];
			$query->sql($sql);
		}

		return $user_id;
	}

	return false;
}

function deleteTestUser($user_id) {
	$query = new Query();

	$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE user_id = $user_id";
	if($query->sql($sql)) {
		
		$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $user_id";
		if($query->sql($sql)) {
			return true;
		}
	}


	return false;
}

?>



<? // SETUP
// create test system_subscription_methods
$sql = "INSERT INTO ".UT_SUBSCRIPTION_METHODS." (id, name, duration, starts_on) VALUES (999, 'Month', 'monthly', DEFAULT), (998, 'Week', 'weekly', DEFAULT), (997, 'Never expires', '*', DEFAULT)";
// print $sql;
$query->sql($sql);

// create test system_vatrates
$sql = "INSERT INTO ".UT_VATRATES." (id, name, vatrate, country) VALUES (999, 'No VAT', 0, 'DK'), (998, '25%', 25, 'DK')";
// print $sql;
$query->sql($sql);

// create test item
// $query->sql($sql);
$_POST["name"] = "Test item";
$item = $model_tests->save(array("save"));
$item_id = $item["item_id"];
unset($_POST);

// add subscription method (indefinite)
$_POST["item_subscription_method"] = 997;
$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));
unset($_POST);

// create test user
$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
if($query->sql($sql)) {
	$test_user_id = $query->lastInsertId();
}


?>

<div class="scene i:scene tests">
	<h1>SuperSubscription</h1>	
	<h2>Testing SuperSubscription class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>Subscriptions (without price or subscription method)</h3>
		<?

		// item without price – should succeed
		$_POST["item_id"] = $item_id;
		$_POST["user_id"] = $test_user_id;
		$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			!$subscription["expires_at"] &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>SuperSubscription::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription with updated modified_at)
		$_POST["item_id"] = $item_id;
		$_POST["user_id"] = $test_user_id;
		$subscription_duplet = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		
		// debug(["item", $item,"subscr", $subscription, "duplet", $subscription_duplet]);
		

		if(
			$subscription_duplet &&
			$subscription_duplet["item_id"] == $subscription["item_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["created_at"] == $subscription["created_at"] 
		): ?>
		<div class="testpassed"><p>SuperSubscription::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $SuperSubscriptionClass->getSubscriptions(["item_id" => $item_id])[0];
		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			!$subscription["expires_at"] &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>SuperSubscription::getSubscriptions - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::getSubscriptions - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		$deletion_success = $SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $subscription["id"]]);
		if(
			$subscription && 
			$deletion_success &&
			!$SuperSubscriptionClass->getSubscriptions(["item_id" => $item_id])
		): ?>
		<div class="testpassed"><p>SuperSubscription::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::deleteSubscription, item without price or subscription method - error</p></div>
		<? endif; ?>
	</div>



	<div class="tests">
		<h3>Subscriptions (with subscription method, monthly, without price)</h3>
		<?
		// update test item (monthly)
		$_POST["item_subscription_method"] = 999;
		$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));
		unset($_POST);


		// item without price – should succeed
		$_POST["item_id"] = $item_id;
		$_POST["user_id"] = $test_user_id;
		$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		$expires_at = date("Y-m-d 00:00:00", time() + (date("t")*24*60*60));
		// debug(["sub", $subscription, "exp", $expires_at]);
		
		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			// $subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>SuperSubscription::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		$_POST["item_id"] = $item_id;
		$_POST["user_id"] = $test_user_id;
		$subscription_duplet = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		if(
			$subscription_duplet &&
			$subscription_duplet["item_id"] == $subscription["item_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["created_at"] == $subscription["created_at"] 
		): ?>
		<div class="testpassed"><p>SuperSubscription::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $SuperSubscriptionClass->getSubscriptions(["item_id" => $item_id, "user_id" => $test_user_id]);
		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			// $subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>SuperSubscription::getSubscriptions - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::getSubscriptions - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $subscription["id"]]) &&
			!$SuperSubscriptionClass->getSubscriptions(array("item_id" => $item_id))
		): ?>
		<div class="testpassed"><p>SuperSubscription::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::deleteSubscription, item without price or subscription method - error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>Subscriptions (with subscription method, weekly, without price)</h3>
		<?
		// update test item (monthly)
		$_POST["item_subscription_method"] = 998;
		$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));
		unset($_POST);


		// item without price – should succeed
		$_POST["item_id"] = $item_id;
		$_POST["user_id"] = $test_user_id;
		$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		$expires_at = date("Y-m-d 00:00:00", time() + (7*24*60*60));

		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>SuperSubscription::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		$_POST["item_id"] = $item_id;
		$_POST["user_id"] = $test_user_id;
		$subscription_duplet = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		if(
			$subscription_duplet &&
			$subscription_duplet["item_id"] == $subscription["item_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["created_at"] == $subscription["created_at"]		): ?>
		<div class="testpassed"><p>SuperSubscription::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $SuperSubscriptionClass->getSubscriptions(["item_id" => $item_id, "user_id" => $test_user_id]);
		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>SuperSubscription::getSubscriptions - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::getSubscriptions - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $subscription["id"]]) &&
			!$SuperSubscriptionClass->getSubscriptions(array("item_id" => $item_id))
		): ?>
		<div class="testpassed"><p>SuperSubscription::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::deleteSubscription, item without price or subscription method - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>Subscriptions (with subscription method, weekly, with price)</h3>
		<?
		// update test item (add price)
		$_POST["item_price"] = 100;
		$_POST["item_price_currency"] = "DKK";
		$_POST["item_price_vatrate"] = 1;
		$_POST["item_price_type"] = 1;
		$price = $model_tests->addPrice(array("addPrice", $item_id));
		unset($_POST);
		
		$_POST["item_id"] = $item_id;
		$_POST["user_id"] = $test_user_id;
		$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		if(!$subscription): ?>
		<div class="testpassed"><p>SuperSubscription::addSubscription – price but no order_id (should not add) – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::addSubscription – price but no order_id (should not add) – error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $SuperSubscriptionClass->getSubscriptions(array("item_id" => $item_id));
		if(!$subscription): ?>
		<div class="testpassed"><p>SuperSubscription::getSubscriptions (should not exist) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::getSubscriptions (should not exist) - error</p></div>
		<? endif; ?>

	</div>

	<div class="tests">
		<h3>Subscriptions (without subscription method)</h3>
		<?
		// update test item (delete subscription method)
		$_POST["item_subscription_method"] = NULL;
		$price = $model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));
		unset($_POST);
		
		$_POST["item_id"] = $item_id;
		$_POST["user_id"] = $test_user_id;
		$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		if($subscription === false): ?>
		<div class="testpassed"><p>Subscription::addSubscription – item has no subscription method – should return false – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::addSubscription – item has no subscription method – should return false – error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $SuperSubscriptionClass->getSubscriptions(array("item_id" => $item_id));
		if($subscription === false): ?>
		<div class="testpassed"><p>Subscription::getSubscription (should not exist) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::getSubscription (should not exist) - error</p></div>
		<? endif; ?>

	</div>
	
	<? // CLEAN UP
	$sql = "DELETE FROM ".UT_ITEMS_SUBSCRIPTION_METHOD." WHERE subscription_method_id IN (997, 998, 999)";
	$query->sql($sql);
	
	$sql = "DELETE FROM ".UT_SUBSCRIPTION_METHODS." WHERE id IN (997, 998, 999)";
	// print $sql;
	$query->sql($sql);

	$sql = "DELETE FROM ".UT_ITEMS_PRICES." WHERE subscription_method_id IN (997, 998, 999)";
	$query->sql($sql);
	
	$sql = "DELETE FROM ".UT_VATRATES." WHERE id IN (998, 999)";
	// print $sql;
	$query->sql($sql);
	
	$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
	$query->sql($sql);

	$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $item_id";
	$query->sql($sql);
	
	?>

	<div class="tests">
		<h3>SuperSubscription::addSubscription</h3>	
		
		<? if(1 && "addSubscription – order item has custom price – return subscription with custom price"):
			
			(function() {

				// ARRANGE
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				$SC = new SuperShop();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $model_tests->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $model_tests->createTestUser();

				// ACT
				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "custom_price" => 50]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				
				// ASSERT
				if(
					$subscription
					&& $subscription["custom_price"] == 50
				):?>
				<div class="testpassed"><p>SuperSubscription::addSubscription – order item has custom price – return subscription with custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::addSubscription – order item has custom price – return subscription with custom price – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		endif; ?>

	</div>

	<div class="tests">
		<h3>SuperSubscription::renewSubscriptions</h3>	

		<? if(1 && "renewSubscriptions – renew all – return true") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$test_item_id = createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id_1 = createTestUser(["subscribed_item_id" => $test_item_id, "expires_at" => "2019-01-01 00:00:00"]);
				$test_user_id_2 = createTestUser(["subscribed_item_id" => $test_item_id, "expires_at" => "2019-01-01 00:00:00"]);

				// ACT
				$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions"]);
				$subscription_1 = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id_1, "item_id" => $test_item_id]); 
				$subscription_2 = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id_2, "item_id" => $test_item_id]); 
				
				// ASSERT
				if(
					$result &&
					$subscription_1 &&
					$subscription_1["expires_at"] == "2020-01-01 00:00:00" &&
					$subscription_2 &&
					$subscription_2["expires_at"] == "2020-01-01 00:00:00"

				):?>
				<div class="testpassed"><p>SuperSubscription::renewSubscriptions – renew all – return true – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::renewSubscriptions – renew all – return true – error</p></div>
				<? endif;

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestUser($test_user_id_1);
				deleteTestUser($test_user_id_2);

			})();

		} ?>

		<? 
		if(1 && "renewSubscriptions – renew subscriptions for specific user – return true"):
			
			(function() {

				// ARRANGE
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$test_item_id = createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id = createTestUser(["subscribed_item_id" => $test_item_id, "expires_at" => "2019-01-01 00:00:00"]);

				// ACT
				$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions", $test_user_id ]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]); 


				// ASSERT
				if(
					$result &&
					$subscription &&
					$subscription["expires_at"] == "2020-01-01 00:00:00"
				):?>
				<div class="testpassed"><p>SuperSubscription::renewSubscriptions, renew specific user – correct</p></div>
				<? else: 
					
				?>
				<div class="testfailed"><p>SuperSubscription::renewSubscriptions, renew specific user – error</p></div>
				<? endif;

				// CLEAN UP
				deleteTestItem($test_item_id);
				deleteTestUser($test_user_id);

			})();

		endif; 
		
		if(1 && "renewSubscriptions – renew subscription with custom price – return true, renewed subscription has custom price"):
			
			(function() {

				// ARRANGE
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $model_tests->createTestItem(["subscription_method" => 2, "price" => 100]);
				$test_user_id = $model_tests->createTestUser(["subscribed_item_id" => $test_item_id, "subscription_expires_at" => "2019-01-01 00:00:00", "subscription_custom_price" => 50]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions", $test_user_id]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]); 


				// ASSERT
				if(
					$result
					&& $subscription
					&& $subscription["expires_at"] == "2020-01-01 00:00:00"
					&& $subscription["custom_price"] == 50

				):?>
				<div class="testpassed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price – return true, renewed subscription has custom price – correct</p></div>
				<? else: 
					
				?>
				<div class="testfailed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price – return true, renewed subscription has custom price – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		endif; 

		if(1 && "renewSubscriptions – renew subscription with custom price of 0 – return true, renewed subscription has custom price of 0"):
			
			(function() {

				// ARRANGE
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $model_tests->createTestItem(["subscription_method" => 2, "price" => 100]);
				$test_user_id = $model_tests->createTestUser(["subscribed_item_id" => $test_item_id, "subscription_expires_at" => "2019-01-01 00:00:00", "subscription_custom_price" => 0]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions", $test_user_id]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]); 


				// ASSERT
				if(
					$result
					&& $subscription
					&& $subscription["expires_at"] == "2020-01-01 00:00:00"
					&& $subscription["custom_price"] === "0"

				):?>
				<div class="testpassed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price of 0 – return true, renewed subscription has custom price of 0 – correct</p></div>
				<? else: 
					
				?>
				<div class="testfailed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price of 0 – return true, renewed subscription has custom price of 0 – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		endif;

		if(1 && "renewSubscriptions – renew subscription with custom price with decimals – return true, renewed subscription has custom price with decimals"):
			
			(function() {

				// ARRANGE
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $model_tests->createTestItem(["subscription_method" => 2, "price" => 100]);
				$test_user_id = $model_tests->createTestUser(["subscribed_item_id" => $test_item_id, "subscription_expires_at" => "2019-01-01 00:00:00", "subscription_custom_price" => 50.5]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions", $test_user_id]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]); 


				// ASSERT
				if(
					$result
					&& $subscription
					&& $subscription["expires_at"] == "2020-01-01 00:00:00"
					&& $subscription["custom_price"] === "50,5"

				):?>
				<div class="testpassed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price with decimals – return true, renewed subscription has custom price with decimals – correct</p></div>
				<? else: 
					
				?>
				<div class="testfailed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price with decimals – return true, renewed subscription has custom price with decimals – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		endif;
		
		?>

		
		
	</div>

	
	<div class="tests">
		<h3>updateSubscription</h3>		
		
		<? 	
		function updateSubscription_noChanges_returnUpdatedSubscription() {
			// updateSubscription – no changes – return updated subscription
			

			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create test item and subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);

			// clear session for old callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

			// ACT 
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			
			// ASSERT 
			if(
				$updated_subscription &&
				$updated_subscription["id"] &&
				$updated_subscription["user_id"] == $test_user_id &&
				$updated_subscription["item_id"] == $test_item_1_id &&
				$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
				!session()->value("test_item_subscribed_callback")
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – no changes – return updated subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – no changes – return updated subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_1_id AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $test_item_1_id";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		}
		updateSubscription_noChanges_returnUpdatedSubscription();
		?>
		<? 	
		function updateSubscription_noParameters_returnFalse() {
			// updateSubscription – no parameters send – return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create test item and subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);

			// clear session for old callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

			// ACT 
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription"]);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – no parameters send – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – no parameters send – return false – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_1_id AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $test_item_1_id";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		}
		updateSubscription_noParameters_returnFalse();
		?>
		<? 	
		function updateSubscription_invalidSubscriptionId_returnFalse() {
			// updateSubscription – invalid subscription_id – return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create test item and subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);

			// clear session for old callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

			// ACT 
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", 9999]);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – invalid subscription_id – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – invalid subscription_id – return false – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_1_id AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $test_item_1_id";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		}
		updateSubscription_invalidSubscriptionId_returnFalse();
		?>
		<? 	
		function updateSubscription_invalidItemId_returnFalse() {
			// updateSubscription – invalid item_id – return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// order first test item and create subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);

			// ACT 
			$_POST["item_id"] = 9999;
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – invalid item_id – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – invalid item_id – return false – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_1_id AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id)";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		}
		updateSubscription_invalidItemId_returnFalse();
		?>
		<? 	
		function updateSubscription_changeItemIdWithPrice_returnUpdatedOrderlessSubscriptionCallbackSubscribed() {
			// updateSubscription – change item_id (item has a price) but not order_id – return updated, orderless subscription and callback 'subscribed'
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// order first test item and create subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);

			// create second test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_2 = $model_tests->save(["save"]);
			$test_item_2_id = $test_item_2["item_id"];
			unset($_POST);

			// add price to second test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_2_price = $model_tests->addPrice(array("addPrice", $test_item_2_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			unset($_POST);

			// ACT 
			$_POST["item_id"] = $test_item_2_id;
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – change item_id (item has a price) but not order_id – return updated, orderless subscription and callback 'subscribed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – change item_id (item has a price) but not order_id – return updated, orderless subscription and callback 'subscribed' – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN ($test_item_1_id, $test_item_2_id) AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		}
		updateSubscription_changeItemIdWithPrice_returnUpdatedOrderlessSubscriptionCallbackSubscribed();
		?>
		<? 	
		function updateSubscription_changeItemIdNoPrice_returnUpdatedOrderlessSubscriptionCallbackSubscribed() {
			// updateSubscription – change item_id (item has no price) but not order_id – return updated, orderless subscription and callback 'subscribed'
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// order first test item and create subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);

			// create second test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_2 = $model_tests->save(["save"]);
			$test_item_2_id = $test_item_2["item_id"];
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			unset($_POST);

			// ACT 
			$_POST["item_id"] = $test_item_2_id;
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription["id"] == $added_subscription["id"] &&
				$updated_subscription["user_id"] == $test_user_id &&
				$added_subscription["item_id"] == $test_item_1_id &&
				$updated_subscription["item_id"] == $test_item_2_id &&
				$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
				$updated_subscription["order_id"] == false &&
				session()->value("test_item_subscribed_callback")
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – change item_id (item has no price) but not order_id – return updated, orderless subscription and callback 'subscribed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – change item_id (item has no price) but not order_id – return updated, orderless subscription and callback 'subscribed' – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN($test_item_1_id, $test_item_2_id) AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		}
		updateSubscription_changeItemIdNoPrice_returnUpdatedOrderlessSubscriptionCallbackSubscribed();
		?>
		<? 	
		function updateSubscription_changeItemIdAddOrderId_returnUpdatedSubscriptionCallbackSubscribed() {
			// updateSubscription – change item_id and add order_id  – return updated subscription and callback 'subscribed'
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// update test item subscription method (yearly)
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create orderless, priceless subscription
			$_POST["user_id"] = $test_user_id;
			$_POST["item_id"] = $test_item_1_id;
			$added_subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);

			// create second test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_2 = $model_tests->save(["save"]);
			$test_item_2_id = $test_item_2["item_id"];
			unset($_POST);

			// add price to second test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_2_price = $model_tests->addPrice(array("addPrice", $test_item_2_id));
			unset($_POST);

			// update second test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			unset($_POST);

			// order second test item and create subscription
			$second_item_cart = $SC->addToNewInternalCart($test_item_2_id, ["user_id" => $test_user_id]);
			$second_item_cart_reference = $second_item_cart["cart_reference"];
			$second_item_cart_id = $second_item_cart["id"];
			$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_id, $second_item_cart_reference]);
			$second_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_2_id]);

			// delete second subscription
			$SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $second_subscription["id"]]);
			
			// ACT 
			$_POST["item_id"] = $test_item_2_id;
			$_POST["order_id"] = $second_item_order["id"];
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription["id"] == $added_subscription["id"] &&
				$updated_subscription["user_id"] == $test_user_id &&
				$added_subscription["item_id"] == $test_item_1_id &&
				$updated_subscription["item_id"] == $test_item_2_id &&
				$added_subscription["order_id"] == false &&
				$updated_subscription["order_id"] == $second_item_order["id"] &&
				$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
				session()->value("test_item_subscribed_callback")
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – change item_id and add order_id  – return updated subscription and callback 'subscribed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – change item_id and add order_id  – return updated subscription and callback 'subscribed' – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN($test_item_1_id, $test_item_2_id) AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
			$query->sql($sql);	

			// delete order
			$second_item_order_id = $second_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN($second_item_order_id)";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		}
		updateSubscription_changeItemIdAddOrderId_returnUpdatedSubscriptionCallbackSubscribed();
		?>
		<? 	
		function updateSubscription_changeToItemWithoutSubscriptionMethod_returnFalse() {
			// updateSubscription – change to item without subscription method – return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// order first test item and create subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);

			// create second test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_2 = $model_tests->save(["save"]);
			$test_item_2_id = $test_item_2["item_id"];
			unset($_POST);

			// add price to second test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_2_price = $model_tests->addPrice(array("addPrice", $test_item_2_id));
			unset($_POST);

			// update test item subscription method
			// $_POST["item_subscription_method"] = 2;
			// $model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			// unset($_POST);

			// ACT 
			$_POST["item_id"] = $test_item_2_id;
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – change to item without subscription method – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – change to item without subscription method – return false – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN($test_item_1_id, $test_item_2_id) AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		}
		updateSubscription_changeToItemWithoutSubscriptionMethod_returnFalse();
		?>
		<?
		function updateSubscription_addOrderId_returnUpdatedSubscription(){
			// updateSubscription – add order_id – return updated subscription
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			
			// update test item subscription method (yearly)
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create orderless, priceless subscription
			$_POST["user_id"] = $test_user_id;
			$_POST["item_id"] = $test_item_1_id;
			$added_subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// create second test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_2 = $model_tests->save(["save"]);
			$test_item_2_id = $test_item_2["item_id"];
			unset($_POST);

			// add price to second test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_2_price = $model_tests->addPrice(array("addPrice", $test_item_2_id));
			unset($_POST);

			// update second test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			unset($_POST);

			// order second test item and create subscription
			$second_item_cart = $SC->addToNewInternalCart($test_item_2_id, ["user_id" => $test_user_id]);
			$second_item_cart_reference = $second_item_cart["cart_reference"];
			$second_item_cart_id = $second_item_cart["id"];
			$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_id, $second_item_cart_reference]);
			$second_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_2_id]);

			// delete second subscription
			$SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $second_subscription["id"]]);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			
			// ACT 
			$_POST["order_id"] = $second_item_order["id"];
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription["id"] == $added_subscription["id"] &&
				$updated_subscription["user_id"] == $test_user_id &&
				$added_subscription["item_id"] == $updated_subscription["item_id"] &&
				$added_subscription["order_id"] == false &&
				$updated_subscription["order_id"] == $second_item_order["id"] &&
				$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
				!session()->value("test_item_subscribed_callback")
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – add order_id – return updated subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – add order_id – return updated subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN($test_item_1_id, $test_item_2_id) AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
			$query->sql($sql);	

			// delete order
			$second_item_order_id = $second_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN($second_item_order_id)";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		};
		updateSubscription_addOrderId_returnUpdatedSubscription();
		?>
		<?
		function updateSubscription_addOrderIdItemHasNoPrice_returnUpdatedSubscription(){
			// updateSubscription – add order_id when item has no price – return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			
			// update test item subscription method (yearly)
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create orderless, priceless subscription
			$_POST["user_id"] = $test_user_id;
			$_POST["item_id"] = $test_item_1_id;
			$added_subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);

			// create second test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_2 = $model_tests->save(["save"]);
			$test_item_2_id = $test_item_2["item_id"];
			unset($_POST);

			// add price to second test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_2_price = $model_tests->addPrice(array("addPrice", $test_item_2_id));
			unset($_POST);

			// update second test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			unset($_POST);

			// order second test item and create subscription
			$second_item_cart = $SC->addToNewInternalCart($test_item_2_id, ["user_id" => $test_user_id]);
			$second_item_cart_reference = $second_item_cart["cart_reference"];
			$second_item_cart_id = $second_item_cart["id"];
			$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_id, $second_item_cart_reference]);
			$second_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_2_id]);

			// delete second subscription
			$SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $second_subscription["id"]]);
			
			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			
			// ACT 
			$_POST["order_id"] = $second_item_order["id"];
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – add order_id when item has no price – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – add order_id when item has no price – return false – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN($test_item_1_id, $test_item_2_id) AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
			$query->sql($sql);	

			// delete order
			$second_item_order_id = $second_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN($second_item_order_id)";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		};
		updateSubscription_addOrderIdItemHasNoPrice_returnUpdatedSubscription();
		?>
		<? 	
		function updateSubscription_changeExpiryDate_returnUpdatedSubscription() {
			// updateSubscription – change expiry date, while not changing item_id – return updated subscription without callback
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// order first test item and create subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_subscription_renewed_callback");

			// ACT 
			$_POST["expires_at"] = "2001-01-01 00:00:00";
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription["id"] == $added_subscription["id"] &&
				$updated_subscription["user_id"] == $test_user_id &&
				$added_subscription["item_id"] == $test_item_1_id &&
				$updated_subscription["item_id"] == $test_item_1_id &&
				$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
				$updated_subscription["renewed_at"] == $added_subscription["renewed_at"] &&
				$updated_subscription["expires_at"] == "2001-01-01 00:00:00" &&
				!session()->value("test_item_subscribed_callback") &&
				!session()->value("test_item_subscription_renewed_callback")
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – change expiry date, while not changing item_id – return updated subscription without callback – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – change expiry date, while not changing item_id – return updated subscription without callback – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_1_id AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id)";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		}
		updateSubscription_changeExpiryDate_returnUpdatedSubscription();
		?>
		<? 	
		function updateSubscription_changeExpiryDateOfEternalSubscription_returnUpdatedSubscription() {
			// updateSubscription – change expiry date of eternal subscription – return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method (eternal subscription)
			$_POST["item_subscription_method"] = 3;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// order first test item and create subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_subscription_renewed_callback");

			// ACT 
			$_POST["expires_at"] = "2001-01-01 00:00:00";
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – change expiry date of eternal subscription – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – change expiry date of eternal subscription – return false – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_1_id AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id)";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		}
		updateSubscription_changeExpiryDateOfEternalSubscription_returnUpdatedSubscription();
		?>
		<? 	
		// This test has been disabled for now. It fails due to sql not being in 'strict mode'. 
		// See associated trello card: https://trello.com/c/50TBY01A  
		function updateSubscription_invalidExpiryDate_returnFalse() {
			// updateSubscription – invalid expiry date – return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// order first test item and create subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_subscription_renewed_callback");

			// ACT 
			$_POST["expires_at"] = 9999;
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – invalid expiry date – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – invalid expiry date – return false – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_1_id AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id)";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");
			
		}
		// updateSubscription_invalidExpiryDate_returnFalse();
		?>
		<?
		function updateSubscription_sendRenewFlagToMonthlySubscription_returnRenewedSubscriptionCallbackRenewed(){
			// updateSubscription – send 'renew' flag to monthly subscription – return updated subscription, callback 'renewed'
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method (monthly)
			$_POST["item_subscription_method"] = 1;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create test item and subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");

			// ACT 
			$_POST["subscription_renewal"] = true;
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);

			// ASSERT 
			if(
				$updated_subscription &&
				$updated_subscription["id"] &&
				$updated_subscription["user_id"] == $test_user_id &&
				$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
				$added_subscription["item_id"] == $updated_subscription["item_id"] && 
				$updated_subscription["item_id"] == $test_item_1_id &&
				!isset($added_subscription["renewed_at"]) &&
				isset($updated_subscription["renewed_at"]) &&
				session()->value("test_item_subscription_renewed_callback")
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – send 'renew' flag to monthly subscription – return updated subscription, callback 'renewed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – send 'renew' flag to monthly subscription – return updated subscription, callback 'renewed' – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_1_id AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $test_item_1_id";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");
			session()->reset("test_item_subscription_renewed_callback");
		};
		updateSubscription_sendRenewFlagToMonthlySubscription_returnRenewedSubscriptionCallbackRenewed();
		?>
		<?
		function updateSubscription_sendRenewFlagToEternalSubscription_returnFalse(){
			// updateSubscription – send 'renew' flag to eternal subscription – return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method (never expires)
			$_POST["item_subscription_method"] = 3;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create test item and subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");

			// ACT 
			$_POST["subscription_renewal"] = true;
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);

			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – send 'renew' flag to eternal subscription – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – send 'renew' flag to eternal subscription – return false – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_1_id AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $test_item_1_id";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");
			session()->reset("test_item_subscription_renewed_callback");
		};
		updateSubscription_sendRenewFlagToEternalSubscription_returnFalse();
		?>
		<?
		function updateSubscription_changeExpiryDateSendRenewFlagToMonthlySubscription_returnRenewedSubscriptionCallbackRenewed(){
			// updateSubscription – change expiry date and send 'renew' flag to monthly subscription – return updated subscription, callback 'subscribed'
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// create first test item
			$model_tests = $IC->typeObject("tests");
			$_POST["name"] = "Test item 1";
			$test_item_1 = $model_tests->save(["save"]);
			$test_item_1_id = $test_item_1["item_id"];
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$test_item_1_price = $model_tests->addPrice(array("addPrice", $test_item_1_id));
			unset($_POST);

			// update test item subscription method (monthly)
			$_POST["item_subscription_method"] = 1;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create test item and subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id, ["user_id" => $test_user_id]);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_id, $added_item_cart_reference]);
			$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");

			// ACT 
			$_POST["expires_at"] = "2001-01-01 00:00:00";
			$_POST["subscription_renewal"] = true;
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);

			// ASSERT 
			if(
				$updated_subscription &&
				$updated_subscription["id"] &&
				$updated_subscription["user_id"] == $test_user_id &&
				$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
				$added_subscription["item_id"] == $updated_subscription["item_id"] && 
				$updated_subscription["item_id"] == $test_item_1_id &&
				$updated_subscription["expires_at"] == "2001-01-01 00:00:00" &&
				!isset($added_subscription["renewed_at"]) &&
				isset($updated_subscription["renewed_at"]) &&
				session()->value("test_item_subscription_renewed_callback")
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – change expiry date and send 'renew' flag to monthly subscription – return updated subscription, callback 'subscribed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – change expiry date and send 'renew' flag to monthly subscription – return updated subscription, callback 'subscribed' – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_1_id AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $test_item_1_id";
			$query->sql($sql);	

			// delete order
			$added_item_order_id = $added_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
			$query->sql($sql);

			// delete test user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");
			session()->reset("test_item_subscription_renewed_callback");
		};
		updateSubscription_changeExpiryDateSendRenewFlagToMonthlySubscription_returnRenewedSubscriptionCallbackRenewed();
		?>
		<? 
		
		if(1 && "updateSubscription – add custom price – return subscription with custom price"):
			
			(function() {

				// ARRANGE
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				$SC = new SuperShop();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $model_tests->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $model_tests->createTestUser();

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);
				$existing_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$_POST["custom_price"] = 50;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $existing_subscription["id"]]);
				unset($_POST);

				// ASSERT
				if(
					$existing_subscription
					&& $updated_subscription
					&& $updated_subscription["custom_price"] == 50
				):?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – add custom price – return subscription with custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – add custom price – return subscription with custom price – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		endif; 

		if(1 && "updateSubscription – change custom price – return subscription with changed custom price"):
			
			(function() {

				// ARRANGE
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				$SC = new SuperShop();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $model_tests->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $model_tests->createTestUser();

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "custom_price" => 75]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);
				$existing_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$_POST["custom_price"] = 50;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $existing_subscription["id"]]);
				unset($_POST);

				// ASSERT
				if(
					$existing_subscription
					&& $existing_subscription["custom_price"] == 75
					&& $updated_subscription
					&& $updated_subscription["custom_price"] == 50
				):?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – change custom price – return subscription with changed custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – change custom price – return subscription with changed custom price – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		endif;

		if(1 && "updateSubscription – delete custom price (set to false) – return subscription without custom price"):
			
			(function() {

				// ARRANGE
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				$SC = new SuperShop();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $model_tests->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $model_tests->createTestUser();

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "custom_price" => 75]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);
				$existing_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$_POST["custom_price"] = false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $existing_subscription["id"]]);
				unset($_POST);

				// ASSERT
				if(
					$existing_subscription
					&& $existing_subscription["custom_price"] == 75
					&& $updated_subscription
					&& $updated_subscription["custom_price"] == false
				):?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – delete custom price (set to false) – return subscription without custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – delete custom price (set to false) – return subscription without custom price – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		endif;
		
		?>

		<?
		// This test isn't written yet, as it is waiting for different payment methods to be actually used by the system
		function updateSubscription_changePaymentMethod_returnUpdatedSubscription(){};
		?>
		<?
		// This test hasn't been written yet, as it is yet to be developed
		function updateSubscription_changeCustomPrice_returnUpdatedSubscription(){};
		
			// also test relevant combinations of parameters 
			// test different types of subscriptions and check that renewal dates are correct
		?>
	</div>
</div>
