<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();


include_once("classes/shop/subscription.class.php");
$SubscriptionClass = new Subscription();

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
$_POST["name"] = "Test item";
$item = $model_tests->save(array("save"));
$item_id = $item["item_id"];
unset($_POST);

// add subscription method (indefinite)
$_POST["item_subscription_method"] = 997;
$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));

?>

<div class="scene i:scene tests">
	<h1>Subscription</h1>	
	<h2>Testing Subscription class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>Subscriptions (without price, with subscription method, no expiry)</h3>
		<?

		// item without price – should succeed
		$_POST["item_id"] = $item_id;
		$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			!$subscription["expires_at"] &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>Subscription::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription with updated modified_at)
		$_POST["item_id"] = $item_id;
		$subscription_duplet = $SubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);
		
		// debug(["item", $item,"subscr", $subscription, "duplet", $subscription_duplet]);
		

		if(
			$subscription_duplet &&
			$subscription_duplet["item_id"] == $subscription["item_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["created_at"] == $subscription["created_at"] 
		): ?>
		<div class="testpassed"><p>Subscription::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $SubscriptionClass->getSubscriptions(array("item_id" => $item_id));
		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			!$subscription["expires_at"] &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>Subscription::getSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::getSubscription - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$SubscriptionClass->deleteSubscription(["deleteSubscription", $subscription["id"]]) &&
			!$SubscriptionClass->getSubscriptions(array("item_id" => $item_id))
		): ?>
		<div class="testpassed"><p>Subscription::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::deleteSubscription, item without price or subscription method - error</p></div>
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
		$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
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
		<div class="testpassed"><p>Subscription::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		$_POST["item_id"] = $item_id;
		$subscription_duplet = $SubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		if(
			$subscription_duplet &&
			$subscription_duplet["item_id"] == $subscription["item_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["created_at"] == $subscription["created_at"] 
		): ?>
		<div class="testpassed"><p>Subscription::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $SubscriptionClass->getSubscriptions(array("item_id" => $item_id));
		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>Subscription::getSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::getSubscription - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$SubscriptionClass->deleteSubscription(["deleteSubscription", $subscription["id"]]) &&
			!$SubscriptionClass->getSubscriptions(array("item_id" => $item_id))
		): ?>
		<div class="testpassed"><p>Subscription::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::deleteSubscription, item without price or subscription method - error</p></div>
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
		$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		$expires_at = date("Y-m-d 00:00:00", time() + (7*24*60*60));

		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>Subscription::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		$_POST["item_id"] = $item_id;
		$subscription_duplet = $SubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		if(
			$subscription_duplet &&
			$subscription_duplet["item_id"] == $subscription["item_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["user_id"] == $subscription["user_id"] &&
			$subscription_duplet["created_at"] == $subscription["created_at"]		): ?>
		<div class="testpassed"><p>Subscription::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $SubscriptionClass->getSubscriptions(array("item_id" => $item_id));
		if(
			$subscription &&
			$subscription["item_id"] == $item_id &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>Subscription::getSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::getSubscription - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$SubscriptionClass->deleteSubscription(["deleteSubscription", $subscription["id"]]) &&
			!$SubscriptionClass->getSubscriptions(array("item_id" => $item_id))
		): ?>
		<div class="testpassed"><p>Subscription::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::deleteSubscription, item without price or subscription method - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>Subscriptions (with subscription method, weekly, with price, no order_id)</h3>
		<?
		// update test item (add price)
		$_POST["item_price"] = 100;
		$_POST["item_price_currency"] = "DKK";
		$_POST["item_price_vatrate"] = 999;
		$_POST["item_price_type"] = "default";
		$price = $model_tests->addPrice(array("addPrice", $item_id));
		
		$_POST["item_id"] = $item_id;
		$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		if($subscription === false): ?>
		<div class="testpassed"><p>Subscription::addSubscription – price but no order_id (should not add) – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::addSubscription – price but no order_id (should not add) – error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $SubscriptionClass->getSubscriptions(array("item_id" => $item_id));
		if($subscription === false): ?>
		<div class="testpassed"><p>Subscription::getSubscription (should not exist) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::getSubscription (should not exist) - error</p></div>
		<? endif; ?>

	</div>

	<div class="tests">
		<h3>Subscriptions (without subscription method)</h3>
		<?
		// update test item (delete subscription method)
		$_POST["item_subscription_method"] = NULL;
		$price = $model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));
		
		$_POST["item_id"] = $item_id;
		$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
		unset($_POST);

		if($subscription === false): ?>
		<div class="testpassed"><p>Subscription::addSubscription – item has no subscription method – should return false – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Subscription::addSubscription – item has no subscription method – should return false – error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $SubscriptionClass->getSubscriptions(array("item_id" => $item_id));
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

	$sql = "DELETE FROM ".UT_ITEMS_PRICES." WHERE subscription_method_id IN (998, 999)";
	$query->sql($sql);
	
	$sql = "DELETE FROM ".UT_VATRATES." WHERE id IN (998, 999)";
	// print $sql;
	$query->sql($sql);

	$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $item_id";
 	$query->sql($sql);


	<div class="tests">
		<h3>updateSubscription</h3>		
		
		<? 	
		function updateSubscription_noChanges_returnUpdatedSubscription() {
			// updateSubscription – no changes – return updated subscription
			
			// ARRANGE
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$test_user_id = session()->value("user_id");
			
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
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);

			// clear session for old callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

			// ACT 
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			
			// ASSERT 
			if(
				$updated_subscription &&
				$updated_subscription["id"] &&
				$updated_subscription["user_id"] == $test_user_id &&
				$updated_subscription["item_id"] == $test_item_1_id &&
				$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
				!session()->value("test_item_subscribed_callback")
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – no changes – return updated subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – no changes – return updated subscription – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");

			
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
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);

			// clear session for old callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

			// ACT 
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription"]);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – no parameters send – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – no parameters send – return false – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");
			
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
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);

			// clear session for old callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

			// ACT 
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", 9999]);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – invalid subscription_id – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – invalid subscription_id – return false – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");
			
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
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);

			// ACT 
			$_POST["item_id"] = 9999;
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – invalid item_id – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – invalid item_id – return false – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");
			
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
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);

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
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – change item_id (item has a price) but not order_id – return updated, orderless subscription and callback 'subscribed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – change item_id (item has a price) but not order_id – return updated, orderless subscription and callback 'subscribed' – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");
	
			
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
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);

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
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
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
			<div class="testpassed"><p>Subscription::updateSubscription – change item_id (item has no price) but not order_id – return updated, orderless subscription and callback 'subscribed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – change item_id (item has no price) but not order_id – return updated, orderless subscription and callback 'subscribed' – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");
		
			
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
			$added_subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
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
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$test_item_2_price = $model_tests->addPrice(array("addPrice", $test_item_2_id));
			unset($_POST);

			// update second test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			unset($_POST);

			// order second test item and create subscription
			$second_item_cart = $SC->addToNewInternalCart($test_item_2_id);
			$second_item_cart_reference = $second_item_cart["cart_reference"];
			$second_item_cart_id = $second_item_cart["id"];
			$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_reference]);
			$second_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_2_id]);

			// delete second subscription
			$SubscriptionClass->deleteSubscription(["deleteSubscription", $second_subscription["id"]]);
			
			// ACT 
			$_POST["item_id"] = $test_item_2_id;
			$_POST["order_id"] = $second_item_order["id"];
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
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
			<div class="testpassed"><p>Subscription::updateSubscription – change item_id and add order_id  – return updated subscription and callback 'subscribed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – change item_id and add order_id  – return updated subscription and callback 'subscribed' – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");

			
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
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);

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
			// $_POST["item_subscription_method"] = 2;
			// $model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			// unset($_POST);

			// ACT 
			$_POST["item_id"] = $test_item_2_id;
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – change to item without subscription method – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – change to item without subscription method – return false – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");

			
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
			$added_subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);

			// add price to first test item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
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
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$test_item_2_price = $model_tests->addPrice(array("addPrice", $test_item_2_id));
			unset($_POST);

			// update second test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			unset($_POST);

			// order second test item and create subscription
			$second_item_cart = $SC->addToNewInternalCart($test_item_2_id);
			$second_item_cart_reference = $second_item_cart["cart_reference"];
			$second_item_cart_id = $second_item_cart["id"];
			$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_reference]);
			$second_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_2_id]);

			// delete second subscription
			$SubscriptionClass->deleteSubscription(["deleteSubscription", $second_subscription["id"]]);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			
			// ACT 
			$_POST["order_id"] = $second_item_order["id"];
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
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
			<div class="testpassed"><p>Subscription::updateSubscription – add order_id – return updated subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – add order_id – return updated subscription – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");
			
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
			$added_subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
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
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$test_item_2_price = $model_tests->addPrice(array("addPrice", $test_item_2_id));
			unset($_POST);

			// update second test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			unset($_POST);

			// order second test item and create subscription
			$second_item_cart = $SC->addToNewInternalCart($test_item_2_id);
			$second_item_cart_reference = $second_item_cart["cart_reference"];
			$second_item_cart_id = $second_item_cart["id"];
			$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_reference]);
			$second_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_2_id]);

			// delete second subscription
			$SubscriptionClass->deleteSubscription(["deleteSubscription", $second_subscription["id"]]);
			
			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			
			// ACT 
			$_POST["order_id"] = $second_item_order["id"];
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – add order_id when item has no price – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – add order_id when item has no price – return false – error</p></div>
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

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		};
		updateSubscription_addOrderIdItemHasNoPrice_returnUpdatedSubscription();
		?>
		<?
		function updateSubscription_addOrderIdAnotherOrderIdAlreadyExists_returnUpdatedSubscription(){
			// updateSubscription – add order_id when another order_id already exists – return false
			
			// ARRANGE
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");
			
			
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

			// update test item subscription method (yearly)
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// order first test item and create subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);

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

			// update second test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_2_id));
			unset($_POST);

			// order second test item and create subscription
			$second_item_cart = $SC->addToNewInternalCart($test_item_2_id);
			$second_item_cart_reference = $second_item_cart["cart_reference"];
			$second_item_cart_id = $second_item_cart["id"];
			$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_reference]);
			$second_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_2_id]);

			// delete second subscription
			$SubscriptionClass->deleteSubscription(["deleteSubscription", $second_subscription["id"]]);
			
			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			
			// ACT 
			$_POST["order_id"] = $second_item_order["id"];
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – add order_id when another order_id already exists – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – add order_id when another order_id already exists – return false – error</p></div>
			<? endif; 
			
			// CLEAN UP

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN($test_item_1_id, $test_item_2_id) AND user_id = $test_user_id";
			$query->sql($sql);

			// delete test items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
			$query->sql($sql);	

			// delete orders
			$added_item_order_id = $added_item_order["id"];
			$second_item_order_id = $second_item_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN($added_item_order_id, $second_item_order_id)";
			$query->sql($sql);

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");

		};
		updateSubscription_addOrderIdAnotherOrderIdAlreadyExists_returnUpdatedSubscription();
		?>
		<? 	
		function updateSubscription_changeExpiryDate_returnUpdatedSubscription() {
			// updateSubscription – change expiry date, while not changing item_id – return updated subscription without callback
			
			// ARRANGE
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");
			
			
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
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_subscription_renewed_callback");

			// ACT 
			$_POST["expires_at"] = "2001-01-01 00:00:00";
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
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
			<div class="testpassed"><p>Subscription::updateSubscription – change expiry date, while not changing item_id – return updated subscription without callback – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – change expiry date, while not changing item_id – return updated subscription without callback – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");
			
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

			// update test item subscription method (eternal subscription)
			$_POST["item_subscription_method"] = 3;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// order first test item and create subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_subscription_renewed_callback");

			// ACT 
			$_POST["expires_at"] = "2001-01-01 00:00:00";
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – change expiry date of eternal subscription – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – change expiry date of eternal subscription – return false – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");
			
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
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_subscription_renewed_callback");

			// ACT 
			$_POST["expires_at"] = 9999;
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);
			
			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – invalid expiry date – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – invalid expiry date – return false – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");

			
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

			// update test item subscription method (monthly)
			$_POST["item_subscription_method"] = 1;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create test item and subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");

			// ACT 
			$_POST["subscription_renewal"] = true;
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
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
			<div class="testpassed"><p>Subscription::updateSubscription – send 'renew' flag to monthly subscription – return updated subscription, callback 'renewed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – send 'renew' flag to monthly subscription – return updated subscription, callback 'renewed' – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");

			
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

			// update test item subscription method (never expires)
			$_POST["item_subscription_method"] = 3;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create test item and subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");

			// ACT 
			$_POST["subscription_renewal"] = true;
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
			unset($_POST);

			// ASSERT 
			if(
				$updated_subscription === false
				): ?>
			<div class="testpassed"><p>Subscription::updateSubscription – send 'renew' flag to eternal subscription – return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – send 'renew' flag to eternal subscription – return false – error</p></div>
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
			include_once("classes/users/member.class.php");
			include_once("classes/shop/subscription.class.php");
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();

			$test_user_id = session()->value("user_id");

			
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

			// update test item subscription method (monthly)
			$_POST["item_subscription_method"] = 1;
			$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $test_item_1_id));
			unset($_POST);

			// create test item and subscription
			$added_item_cart = $SC->addToNewInternalCart($test_item_1_id);
			$added_item_cart_reference = $added_item_cart["cart_reference"];
			$added_item_cart_id = $added_item_cart["id"];
			$added_item_order = $SC->newOrderFromCart(["newOrderFromCart", $added_item_cart_reference]);
			$added_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_1_id]);
			session()->reset("test_item_subscribed_callback");

			// ACT 
			$_POST["expires_at"] = "2001-01-01 00:00:00";
			$_POST["subscription_renewal"] = true;
			$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription["id"]]);
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
			<div class="testpassed"><p>Subscription::updateSubscription – change expiry date and send 'renew' flag to monthly subscription – return updated subscription, callback 'subscribed' – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::updateSubscription – change expiry date and send 'renew' flag to monthly subscription – return updated subscription, callback 'subscribed' – error</p></div>
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

			// clear session for callback checks
			session()->reset("test_item_subscribed_callback");
			session()->reset("test_item_ordered_callback");
			session()->reset("test_item_subscription_renewed_callback");
		};
		updateSubscription_changeExpiryDateSendRenewFlagToMonthlySubscription_returnRenewedSubscriptionCallbackRenewed();
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

	<div class="tests">
		<h3>calculateSubscriptionExpiry</h3>
		<? 	
		function calculateSubscriptionExpiry_annuallyFromCurrentTime() {
			// calculateSubscriptionExpiry – annual subscription, no parameters sent – return current time + 1 year

			// ARRANGE
			include_once("classes/shop/subscription.class.php");
			$SubscriptionClass = new Subscription();

			$current_time = date("Y-m-d 00:00:00");
			
			// ACT 
			$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("annually");
			
			// ASSERT 
			$current_timestamp = strtotime($current_time);
			$calculated_timestamp = strtotime($calculated_time);
			$time_diff = $calculated_timestamp - $current_timestamp;
			if(
				$current_time &&
				$calculated_time &&
				($time_diff == 31622400 || $time_diff == 31536000)
				): ?>
			<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – annual subscription, no parameters sent – return current time + 1 year – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – annual subscription, no parameters sent – return current time + 1 year – error</p></div>
			<? endif; 

		}
		calculateSubscriptionExpiry_annuallyFromCurrentTime();
		?>
		<? 	
		function calculateSubscriptionExpiry_annuallyFromSpecifiedTime() {
			// calculateSubscriptionExpiry – annual subscription, specify start time – return start time + 1 year

			// ARRANGE
			include_once("classes/shop/subscription.class.php");
			$SubscriptionClass = new Subscription();

			
			// ACT 
			$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("annually", "2018-01-01 00:00:00");
			
			// ASSERT 
			if(
				$calculated_time == "2019-01-01 00:00:00"
				): ?>
			<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – annual subscription, specify start time – return start time + 1 year – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – annual subscription, specify start time – return start time + 1 year – error</p></div>
			<? endif; 

		}
		calculateSubscriptionExpiry_annuallyFromSpecifiedTime();
		?>
		<? 	
		function calculateSubscriptionExpiry_annuallyFromFeb29th() {
			// calculateSubscriptionExpiry – annual subscription, specify start time as Feb 29th in a leap year – return Feb 28th next year

			// ARRANGE
			include_once("classes/shop/subscription.class.php");
			$SubscriptionClass = new Subscription();

			
			// ACT 
			$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("annually", "2016-02-29 00:00:00");
			
			// ASSERT 
			if(
				$calculated_time == "2017-02-28 00:00:00"
				): ?>
			<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – annual subscription, specify start time as Feb 29th in a leap year – return Feb 28th next year – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – annual subscription, specify start time as Feb 29th in a leap year – return Feb 28th next year – error</p></div>
			<? endif; 

		}
		calculateSubscriptionExpiry_annuallyFromFeb29th();
		?>
		<? 	
		function calculateSubscriptionExpiry_monthlyFromCurrentTime() {
			// calculateSubscriptionExpiry – monthly subscription, no parameters sent – return current time + 1 month

			// ARRANGE
			include_once("classes/shop/subscription.class.php");
			$SubscriptionClass = new Subscription();

			$current_time = date("Y-m-d 00:00:00");
			
			// ACT 
			$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("monthly");
			
			// ASSERT 
			$current_timestamp = strtotime($current_time);
			$calculated_timestamp = strtotime($calculated_time);
			$time_diff = $calculated_timestamp - $current_timestamp;
			if(
				$current_time &&
				$calculated_time &&
				($time_diff == (28*86400) || $time_diff == (29*86400) || $time_diff == (30*86400) || $time_diff == (31*86400) || $time_diff == (31*86400+3600))
				): ?>
			<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – monthly subscription, no parameters sent – return current time + 1 month – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – monthly subscription, no parameters sent – return current time + 1 month – error</p></div>
			<? endif; 

		}
		calculateSubscriptionExpiry_monthlyFromCurrentTime();
		?>
		<? 	
		function calculateSubscriptionExpiry_monthlyFromSpecifiedTime() {
			// calculateSubscriptionExpiry – monthly subscription, specify start time – return start time + 1 month

			// ARRANGE
			include_once("classes/shop/subscription.class.php");
			$SubscriptionClass = new Subscription();

			
			// ACT 
			$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("monthly", "2018-01-01 00:00:00");
			
			// ASSERT 
			if(
				$calculated_time == "2018-02-01 00:00:00"
				): ?>
			<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – monthly subscription, specify start time – return start time + 1 month – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – monthly subscription, specify start time – return start time + 1 month – error</p></div>
			<? endif; 

		}
		calculateSubscriptionExpiry_monthlyFromSpecifiedTime();
		?>
		<? 	
		function calculateSubscriptionExpiry_monthlyFromShorterMonth() {
			// calculateSubscriptionExpiry – monthly subscription, specify start time as last day in a short month – return last day in longer month

			// ARRANGE
			include_once("classes/shop/subscription.class.php");
			$SubscriptionClass = new Subscription();

			
			// ACT 
			$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("monthly", "2018-02-28 00:00:00");
			
			// ASSERT 
			if(
				$calculated_time == "2018-03-31 00:00:00"
				): ?>
			<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – monthly subscription, specify start time as last day in a short month – return last day in longer month – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – monthly subscription, specify start time as last day in a short month – return last day in longer month – error</p></div>
			<? endif; 

		}
		calculateSubscriptionExpiry_monthlyFromShorterMonth();
		?>
		<? 	
		function calculateSubscriptionExpiry_monthlyFromLongerMonth() {
			// calculateSubscriptionExpiry – monthly subscription, specify start time as last day in longer month – return last day in short month

			// ARRANGE
			include_once("classes/shop/subscription.class.php");
			$SubscriptionClass = new Subscription();

			
			// ACT 
			$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("monthly", "2018-03-31 00:00:00");
			
			// ASSERT 
			if(
				$calculated_time == "2018-04-30 00:00:00"
				): ?>
			<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – monthly subscription, specify start time as last day in longer month – return last day in short month – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – monthly subscription, specify start time as last day in longer month – return last day in short month – error</p></div>
			<? endif; 

		}
		calculateSubscriptionExpiry_monthlyFromLongerMonth();
		?>
		<? 	
		function calculateSubscriptionExpiry_weeklyFromCurrentTime() {
			// calculateSubscriptionExpiry – weekly subscription, no parameters sent – return current time + 1 week

			// ARRANGE
			include_once("classes/shop/subscription.class.php");
			$SubscriptionClass = new Subscription();

			$current_time = date("Y-m-d 00:00:00");
			
			// ACT 
			$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("weekly");
			
			// ASSERT 
			$current_timestamp = strtotime($current_time);
			$calculated_timestamp = strtotime($calculated_time);
			$time_diff = $calculated_timestamp - $current_timestamp;
			if(
				$current_time &&
				$calculated_time &&
				$time_diff == (7*24*60*60)
				): ?>
			<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – weekly subscription, no parameters sent – return current time + 1 week – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – weekly subscription, no parameters sent – return current time + 1 week – error</p></div>
			<? endif; 

		}
		calculateSubscriptionExpiry_weeklyFromCurrentTime();
		?>
		<? 	
		function calculateSubscriptionExpiry_weeklyFromSpecifiedTime() {
			// calculateSubscriptionExpiry – weekly subscription, specify start time – return start time + 1 week

			// ARRANGE
			include_once("classes/shop/subscription.class.php");
			$SubscriptionClass = new Subscription();

			
			// ACT 
			$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("weekly", "2018-01-01 00:00:00");
			
			// ASSERT 
			if(
				$calculated_time == "2018-01-08 00:00:00"
				): ?>
			<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – weekly subscription, specify start time – return start time + 1 week – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – weekly subscription, specify start time – return start time + 1 week – error</p></div>
			<? endif; 

		}
		calculateSubscriptionExpiry_weeklyFromSpecifiedTime();
		?>
		
</div>
