<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();


include_once("classes/shop/supersubscription.class.php");
$SuperSubscriptionClass = new SuperSubscription();

$query = new Query();
$IC = new Items();
$model_tests = $IC->typeObject("tests");

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
		$_POST["item_price_vatrate"] = 999;
		$_POST["item_price_type"] = "default";
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

	<div class="tests">
		<h3>SuperSubscription::renewSubscriptions</h3>	
		
		<? //TODO: move to SuperSubscription class and finish 
		// renew all 

		$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions"]);
		// print_r($result);

		if(
			$result
			):?>
		<div class="testpassed"><p>SuperSubscription::renewSubscriptions, renew all – correct</p></div>
		<? else: 
			
		?>
		<div class="testfailed"><p>SuperSubscription::renewSubscriptions, renew all – error</p></div>
		<? endif; ?>

		<? // renew single
		
		$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions", $test_user_id ]);
		// print_r($result);

		if(
			$result
			):?>
		<div class="testpassed"><p>SuperSubscription::renewSubscriptions, renew specific user – correct</p></div>
		<? else: 
			
		?>
		<div class="testfailed"><p>SuperSubscription::renewSubscriptions, renew specific user – error</p></div>
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
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
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
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $test_user_id, $added_subscription["id"]]);
			
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
		function updateSubscription_changeItemId_returnUpdatedSubscriptionCallbackSubscribed() {
			// updateSubscription – change item_id – return updated subscription and callback 'subscribed'
			
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
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
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
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$test_item_2_price = $model_tests->addPrice(array("addPrice", $test_item_2_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			unset($_POST);

			// ACT 
			$_POST["item_id"] = $test_item_2_id;
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $test_user_id, $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription["id"] == $added_subscription["id"] &&
				$updated_subscription["user_id"] == $test_user_id &&
				$added_subscription["item_id"] == $test_item_1_id &&
				$updated_subscription["item_id"] == $test_item_2_id &&
				$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
				session()->value("test_item_subscribed_callback")
				): ?>
			<div class="testpassed"><p>SuperSubscription::updateSubscription – change item_id – return updated subscription and callback 'subscribed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperSubscription::updateSubscription – change item_id – return updated subscription and callback 'subscribed' – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $test_item_2_id AND user_id = $test_user_id";
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
		updateSubscription_changeItemId_returnUpdatedSubscriptionCallbackSubscribed();
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
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
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
			$_POST["expires_at"] = "2222-01-01 00:00:00";
			$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $test_user_id, $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				// $updated_subscription["id"] == $added_subscription["id"] &&
				// $updated_subscription["user_id"] == $test_user_id &&
				// $added_subscription["item_id"] == $test_item_1_id &&
				// $updated_subscription["item_id"] == $test_item_1_id &&
				// $updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
				// $updated_subscription["renewed_at"] == $added_subscription["renewed_at"] &&
				// $updated_subscription["expires_at"] == "2222-01-01 00:00:00" &&
				!session()->value("test_item_subscribed_callback") &&
				!session()->value("test_item_subscribtion_renewed_callback")
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
	</div>
</div>
