<?

$query = new Query();
if(!$query->sql("SELECT * FROM ".UT_SUBSCRIPTION_METHODS." WHERE duration = 'weekly'")) {
	$query->sql("INSERT INTO ".UT_SUBSCRIPTION_METHODS." SET name = 'Week', duration = 'weekly'");
	cache()->reset("subscription_methods");
}

?>

<div class="scene i:scene tests">
	<h1>Subscription</h1>	
	<h2>Testing Subscription class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests addSubscription">
		<h3>addSubscription</h3>
		<?

		if(1 && "addSubscription, never expires") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SuC = new Subscription();

				$current_user_id = session()->value("user_id");


				$sms = $this->subscriptionMethods();
				$subscription_method = $sms[arrayKeyValue($sms, "duration", "*")];

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem([
					"subscription_method" => $subscription_method["id"]
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $user_id);


				// item without price – should succeed
				$_POST["item_id"] = $item_id;
				$subscription = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);

				if(
					$subscription &&
					$subscription["item_id"] == $item_id &&
					!$subscription["expires_at"] &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>Subscription::addSubscription, never expires - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::addSubscription, never expires - error</p></div>
				<? endif;


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id,
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "addSubscription, adding already existing item, never expires") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SuC = new Subscription();

				$current_user_id = session()->value("user_id");


				$sms = $this->subscriptionMethods();
				$subscription_method = $sms[arrayKeyValue($sms, "duration", "*")];

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem([
					"subscription_method" => $subscription_method["id"]
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $user_id);

				$_POST["item_id"] = $item_id;
				$subscription = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);

				// adding already existing item – should succeed (but return existing subscription with updated modified_at)
				$_POST["item_id"] = $item_id;
				$subscription_duplet = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);

				// debug(["subscr", $subscription, "duplet", $subscription_duplet]);

				if(
					$subscription_duplet &&
					$subscription_duplet["id"] === $subscription["id"] &&
					$subscription_duplet["item_id"] == $subscription["item_id"] &&
					$subscription_duplet["user_id"] == $subscription["user_id"] &&
					$subscription_duplet["user_id"] == $subscription["user_id"] &&
					$subscription_duplet["created_at"] == $subscription["created_at"] &&
					$subscription_duplet["modified_at"] &&
					!$subscription["modified_at"]
				): ?>
				<div class="testpassed"><p>Subscription::addSubscription, adding already existing item, never expires - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::addSubscription, adding already existing item, never expires - error</p></div>
				<? endif;


				// CLEAN UP

				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "addSubscription, monthly") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SuC = new Subscription();

				$current_user_id = session()->value("user_id");


				$sms = $this->subscriptionMethods();
				$subscription_method = $sms[arrayKeyValue($sms, "duration", "monthly")];

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem([
					"subscription_method" => $subscription_method["id"]
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $user_id);


				// item without price – should succeed
				$_POST["item_id"] = $item_id;
				$subscription = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);


				if (
					$subscription &&
					$subscription["item_id"] == $item_id &&
					// Loose test of expiry (to work with shifting month lengths) 
					strtotime($subscription["expires_at"]) - time() > 27*24*60*60 &&
					strtotime($subscription["expires_at"]) - time() < 32*24*60*60 &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>Subscription::addSubscription, monthly - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::addSubscription, monthly - error</p></div>
				<? endif;


				// CLEAN UP

				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "addSubscription, weekly") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SuC = new Subscription();

				$current_user_id = session()->value("user_id");


				$sms = $this->subscriptionMethods();
				$subscription_method = $sms[arrayKeyValue($sms, "duration", "weekly")];

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem([
					"subscription_method" => $subscription_method["id"]
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $user_id);


				// item without price – should succeed
				$_POST["item_id"] = $item_id;
				$subscription = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);

				$expires_at = date("Y-m-d 00:00:00", time() + (7*24*60*60));


				if(
					$subscription &&
					$subscription["item_id"] == $item_id &&
					$subscription["expires_at"] == $expires_at &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>Subscription::addSubscription, weekly - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::addSubscription, weekly - error</p></div>
				<? endif;


				// CLEAN UP

				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "addSubscription – price but no order_id (should not add)") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SuC = new Subscription();

				$current_user_id = session()->value("user_id");


				$sms = $this->subscriptionMethods();
				$subscription_method = $sms[arrayKeyValue($sms, "duration", "weekly")];

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem([
					"price" => 100,
					"subscription_method" => $subscription_method["id"]
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $user_id);


				$_POST["item_id"] = $item_id;
				$subscription = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);


				if(
					$user_id &&
					$item_id &&
					$subscription === false
				): ?>
				<div class="testpassed"><p>Subscription::addSubscription – price but no order_id (should not add) – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::addSubscription – price but no order_id (should not add) – error</p></div>
				<? endif;


				// CLEAN UP

				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "addSubscription – item has no subscription method – should return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SuC = new Subscription();

				$current_user_id = session()->value("user_id");


				$sms = $this->subscriptionMethods();
				$subscription_method = $sms[arrayKeyValue($sms, "duration", "weekly")];

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem([
					"price" => 100,
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $user_id);

				// update test item (delete subscription method)
				// $_POST["item_subscription_method"] = NULL;
				// $price = $model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));
		
				$_POST["item_id"] = $item_id;
				$subscription = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);


				if(
					$user_id &&
					$item_id &&
					$subscription === false
				): ?>
				<div class="testpassed"><p>Subscription::addSubscription – item has no subscription method – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::addSubscription – item has no subscription method – should return false – error</p></div>
				<? endif;


				// CLEAN UP

				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "addSubscription – via order, item has custom price – return subscription with custom price") {

			(function() {

				// ARRANGE

				$SC = new Shop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SuC = new Subscription();

				$current_user_id = session()->value("user_id");

				$test_item_id = $test_model->createTestItem([
					"subscription_method" => 1, 
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $user_id);


				$cart = $SC->addToNewInternalCart($test_item_id, [
					"user_id" => $user_id, 
					"custom_price" => 50
				]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
				$subscription = $SuC->getSubscriptions(["item_id" => $test_item_id]);


				// ASSERT

				if(
					$subscription
					&& $subscription["custom_price"] == 50
				):?>
				<div class="testpassed"><p>Subscription::addSubscription – via order, item has custom price – return subscription with custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::addSubscription – via order, item has custom price – return subscription with custom price – error</p></div>
				<? endif;


				// CLEAN UP

				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "addSubscription – membership via order, item has custom price – return subscription with custom price") {

			(function() {

				// ARRANGE

				$SC = new Shop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SuC = new Subscription();
				$MC = new Member();

				$current_user_id = session()->value("user_id");

				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"subscription_method" => 1, 
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $user_id);


				$cart = $SC->addToNewInternalCart($test_item_id, [
					"user_id" => $user_id, 
					"custom_price" => 50
				]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
				$subscription = $SuC->getSubscriptions(["item_id" => $test_item_id]);
				$membership = $MC->getMembership();


				// ASSERT

				if(
					$subscription &&
					$subscription["custom_price"] == 50 &&
					$membership &&
					$membership["subscription_id"] == $subscription["id"] &&
					$membership["item_id"] == $test_item_id
				):?>
				<div class="testpassed"><p>Subscription::addSubscription – via order, item has custom price – return subscription with custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::addSubscription – via order, item has custom price – return subscription with custom price – error</p></div>
				<? endif;


				// CLEAN UP

				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests getSubscription">
		<h3>getSubscription</h3>
		<?

		if(1 && "getSubscription by item_id") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SuC = new Subscription();

				$current_user_id = session()->value("user_id");


				$sms = $this->subscriptionMethods();
				$subscription_method = $sms[arrayKeyValue($sms, "duration", "*")];

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem([
					"subscription_method" => $subscription_method["id"]
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $user_id);

				$_POST["item_id"] = $item_id;
				$subscription = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);

				// get the created subscription
				$subscription = $SuC->getSubscriptions(array("item_id" => $item_id));
				if(
					$subscription &&
					$subscription["user_id"] == $user_id &&
					$subscription["item_id"] == $item_id &&
					!$subscription["expires_at"] &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>Subscription::getSubscription by item_id - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::getSubscription by item_id - error</p></div>
				<? endif;


				// CLEAN UP

				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getSubscription (should not exist)") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SuC = new Subscription();


				// get the created subscription
				$subscription = $SuC->getSubscriptions(array("item_id" => 100000000000));
				if($subscription === false): ?>
				<div class="testpassed"><p>Subscription::getSubscription (should not exist) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::getSubscription (should not exist) - error</p></div>
				<? endif;


				// CLEAN UP

				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests deleteSubscription">
		<h3>deleteSubscription</h3>
		<?

		if(1 && "deleteSubscription") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SuC = new Subscription();

				$current_user_id = session()->value("user_id");


				$sms = $this->subscriptionMethods();
				$subscription_method = $sms[arrayKeyValue($sms, "duration", "*")];

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem([
					"subscription_method" => $subscription_method["id"]
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $user_id);

				$_POST["item_id"] = $item_id;
				$subscription = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);

				$SuC->deleteSubscription(["deleteSubscription", $subscription["id"]]);

				$post_subscription = $SuC->getSubscriptions(array("item_id" => $item_id));


				// delete the created subscription
				if(
					$subscription &&
					!$post_subscription
				): ?>
				<div class="testpassed"><p>Subscription::deleteSubscription - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::deleteSubscription - error</p></div>
				<? endif;


				// CLEAN UP

				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests updateSubscription">
		<h3>updateSubscription</h3>
		<?

		if(1 && "updateSubscription – no changes – return updated subscription") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
			
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

				// delete order
				$added_item_order_id = $added_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
				$query->sql($sql);

				// delete test item
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $test_item_1_id";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();

			})();

		}

		if(1 && "updateSubscription – no parameters send – return false") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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

				// delete order
				$added_item_order_id = $added_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
				$query->sql($sql);

				// delete test item
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $test_item_1_id";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – invalid subscription_id – return false") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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

				// delete order
				$added_item_order_id = $added_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
				$query->sql($sql);

				// delete test item
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $test_item_1_id";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – invalid item_id – return false") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
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

				// delete order
				$added_item_order_id = $added_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – change item_id (item has a price) but not order_id – return updated, orderless subscription and callback 'subscribed'") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
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

				// delete order
				$added_item_order_id = $added_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – change item_id (item has no price) but not order_id – return updated, orderless subscription and callback 'subscribed'") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);
			
				// ASSERT 
				if(
					$updated_subscription &&
					$added_subscription &&
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

				// delete order
				$added_item_order_id = $added_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – change item_id and add order_id  – return updated subscription and callback 'subscribed'") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$second_subscription_id = $second_subscription ? $second_subscription["id"] : false;
				$SubscriptionClass->deleteSubscription(["deleteSubscription", $second_subscription_id]);
			
				// ACT 
				$_POST["item_id"] = $test_item_2_id;
				$_POST["order_id"] = $second_item_order["id"];
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);
			
				// ASSERT 
				if(
					$updated_subscription &&
					$added_subscription &&
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

				// delete order
				$second_item_order_id = $second_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN($second_item_order_id)";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – change to item without subscription method – return false") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
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

				// delete order
				$added_item_order_id = $added_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – add order_id – return updated subscription") {

			(function() {

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
				$second_item_cart = $SC->addToNewInternalCart($test_item_2_id);
				$second_item_cart_reference = $second_item_cart["cart_reference"];
				$second_item_cart_id = $second_item_cart["id"];
				$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_reference]);
				$second_subscription = $SubscriptionClass->getSubscriptions(["item_id" => $test_item_2_id]);

				// delete second subscription
				$second_subscription_id = $second_subscription ? $second_subscription["id"] : false;
				$SubscriptionClass->deleteSubscription(["deleteSubscription", $second_subscription_id]);

				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
			
				// ACT 
				$_POST["order_id"] = $second_item_order["id"];
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);
			
				// ASSERT 
				if(
					$updated_subscription &&
					$added_subscription &&
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

				// delete order
				$second_item_order_id = $second_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN($second_item_order_id)";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – add order_id when item has no price – return false") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$second_subscription_id = $second_subscription ? $second_subscription["id"] : false;
				$SubscriptionClass->deleteSubscription(["deleteSubscription", $second_subscription_id]);
			
				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
			
				// ACT 
				$_POST["order_id"] = $second_item_order["id"];
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
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

				// delete order
				$second_item_order_id = $second_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN($second_item_order_id)";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – add order_id when another order_id already exists – return false") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$second_subscription_id = $second_subscription ? $second_subscription["id"] : false;
				$SubscriptionClass->deleteSubscription(["deleteSubscription", $second_subscription_id]);
			
				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
			
				// ACT 
				$_POST["order_id"] = $second_item_order["id"];
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
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

				// delete orders
				$added_item_order_id = $added_item_order["id"];
				$second_item_order_id = $second_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN($added_item_order_id, $second_item_order_id)";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id, $test_item_2_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – change expiry date, while not changing item_id – return updated subscription without callback") {

			(function() {

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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);
			
				// ASSERT 
				if(
					$updated_subscription &&
					$added_subscription &&
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

				// delete order
				$added_item_order_id = $added_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – change expiry date of eternal subscription – return false") {

			(function() {
			
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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
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

				// delete order
				$added_item_order_id = $added_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateSubscription – add custom price – return subscription with custom price") {
			
			(function() {

				// ARRANGE
				$SubscriptionClass = new Subscription();
				$SC = new Shop();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $model_tests->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $model_tests->createTestUser();

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
				$existing_subscription = $SubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$_POST["custom_price"] = 50;
				$existing_subscription_id = $existing_subscription ? $existing_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $existing_subscription_id]);
				unset($_POST);

				// ASSERT
				if(
					$existing_subscription
					&& $updated_subscription
					&& $updated_subscription["custom_price"] == 50
				):?>
				<div class="testpassed"><p>Subscription::updateSubscription – add custom price – return subscription with custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::updateSubscription – add custom price – return subscription with custom price – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp([
					"user_id" => $test_user_id, 
					"order_id" => $order["id"],
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		} 

		if(1 && "updateSubscription – change custom price – return subscription with changed custom price") {
			
			(function() {

				// ARRANGE
				$SubscriptionClass = new Subscription();
				$SC = new Shop();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $model_tests->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $model_tests->createTestUser();

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "custom_price" => 75]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
				$existing_subscription = $SubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$_POST["custom_price"] = 50;
				$existing_subscription_id = $existing_subscription ? $existing_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $existing_subscription_id]);
				unset($_POST);

				// ASSERT
				if(
					$existing_subscription
					&& $existing_subscription["custom_price"] == 75
					&& $updated_subscription
					&& $updated_subscription["custom_price"] == 50
				):?>
				<div class="testpassed"><p>Subscription::updateSubscription – change custom price – return subscription with changed custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::updateSubscription – change custom price – return subscription with changed custom price – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp([
					"user_id" => $test_user_id, 
					"order_id" => $order["id"],
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "updateSubscription – delete custom price (set to false) – return subscription without custom price") {

			(function() {

				// ARRANGE
				$SubscriptionClass = new Subscription();
				$SC = new Shop();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $model_tests->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $model_tests->createTestUser();

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "custom_price" => 75]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
				$existing_subscription = $SubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$_POST["custom_price"] = false;
				$existing_subscription_id = $existing_subscription ? $existing_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $existing_subscription_id]);
				unset($_POST);

				// ASSERT
				if(
					$existing_subscription
					&& $existing_subscription["custom_price"] == 75
					&& $updated_subscription
					&& $updated_subscription["custom_price"] == false
				):?>
				<div class="testpassed"><p>Subscription::updateSubscription – delete custom price (set to false) – return subscription without custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::updateSubscription – delete custom price (set to false) – return subscription without custom price – error</p></div>
				<? endif;

				// CLEAN UP
				$model_tests->cleanUp([
					"user_id" => $test_user_id,
					"order_id" => $order["id"],
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		}


		// This test has been disabled for now. It fails due to sql not being in 'strict mode'. 
		// See associated trello card: https://trello.com/c/50TBY01A  
		if(1 && "updateSubscription – invalid expiry date – return false") {

			(function() {
			
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
				$_POST["item_price_vatrate"] = 1;
				$_POST["item_price_type"] = 1;
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
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
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


				// delete order
				$added_item_order_id = $added_item_order["id"];
				$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_item_order_id";
				$query->sql($sql);

				// delete test items
				$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($test_item_1_id)";
				$query->sql($sql);	


				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");
			
				message()->resetMessages();

			})();

		}

		// This test isn't written yet, as it is waiting for different payment methods to be actually used by the system
		if(1 && "updateSubscription – change PaymentMethod, return Updated Subscription") {

			(function() {

				message()->resetMessages();

			})();

		}

		// This test hasn't been written yet, as it is yet to be developed
		if(1 && "updateSubscription – change Custom Price, return Updated Subscription") {

			(function() {

				message()->resetMessages();

			})();

		}

		// also test relevant combinations of parameters 
		// test different types of subscriptions and check that renewal dates are correct

		?>
	</div>

	<div class="tests calculateSubscriptionExpiry">
		<h3>calculateSubscriptionExpiry</h3>
		<?

		if(1 && "calculateSubscriptionExpiry – annual subscription, no parameters sent – return current time + 1 year") {

			(function() {

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

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – annual subscription, specify start time – return start time + 1 year") {

			(function() {

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

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – annual subscription, specify start time as Feb 29th in a leap year – return Feb 28th next year") {

			(function() {

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

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – biannually subscription, no parameters sent – return current time + 6 months") {

			(function() {

				// ARRANGE
				include_once("classes/shop/subscription.class.php");
				$SubscriptionClass = new Subscription();

				$current_time = date("Y-m-d 00:00:00");

				// ACT 
				$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("biannually");

				// ASSERT 
				$current_timestamp = strtotime($current_time);
				$calculated_timestamp = strtotime($calculated_time);
				$time_diff = $calculated_timestamp - $current_timestamp;
				// summer / wintertime offset
				$offset = 3600;

				// compensate for Dayligt Saving Time (shifts in March/October in the EU)
				if(
					$current_time &&
					$calculated_time &&
					(
						$time_diff == (181*86400) || $time_diff == (182*86400) || $time_diff == (183*86400) || $time_diff == (184*86400) ||
						$time_diff == (181*86400+$offset) || $time_diff == (182*86400+$offset) || $time_diff == (183*86400+$offset) || $time_diff == (184*86400+$offset) ||
						$time_diff == (181*86400-$offset) || $time_diff == (182*86400-$offset) || $time_diff == (183*86400-$offset) || $time_diff == (184*86400-$offset)
					)		//|| $time_diff == (31*86400) || $time_diff == (31*86400+3600)
				): ?>
				<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – biannually subscription, no parameters sent – return current time + 6 months – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – biannually subscription, no parameters sent – return current time + 6 months – error</p></div>
				<? endif; 

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – biannually subscription, specify start time – return start time + 6 months") {

			(function() {

				// ARRANGE
				include_once("classes/shop/subscription.class.php");
				$SubscriptionClass = new Subscription();

			
				// ACT 
				$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("biannually", "2018-01-01 00:00:00");
			
				// ASSERT 
				if(
					$calculated_time == "2018-07-01 00:00:00"
					): ?>
				<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – biannually subscription, specify start time – return start time + 6 months – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – biannually subscription, specify start time – return start time + 6 months – error</p></div>
				<? endif; 

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – biannually subscription, specify start time as last day in a short month – return last day in longer month") {

			(function() {

				// ARRANGE
				include_once("classes/shop/subscription.class.php");
				$SubscriptionClass = new Subscription();

			
				// ACT 
				$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("biannually", "2018-02-28 00:00:00");
			
				// ASSERT 
				if(
					$calculated_time == "2018-08-31 00:00:00"
					): ?>
				<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – biannually subscription, specify start time as last day in a short month – return last day in longer month – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – biannually subscription, specify start time as last day in a short month – return last day in longer month – error</p></div>
				<? endif; 

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – biannually subscription, specify start time as last day in longer month – return last day in short month") {

			(function() {

				// ARRANGE
				include_once("classes/shop/subscription.class.php");
				$SubscriptionClass = new Subscription();

			
				// ACT 
				$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("biannually", "2018-03-31 00:00:00");
			
				// ASSERT 
				if(
					$calculated_time == "2018-09-30 00:00:00"
					): ?>
				<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – biannually subscription, specify start time as last day in longer month – return last day in short month – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – biannually subscription, specify start time as last day in longer month – return last day in short month – error</p></div>
				<? endif; 

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – quarterly subscription, no parameters sent – return current time + 3 months") {

			(function() {

				// ARRANGE
				include_once("classes/shop/subscription.class.php");
				$SubscriptionClass = new Subscription();


				// ACT 
				$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("quarterly");

				// ASSERT 
				$compare_timestamp = strtotime("+ 3 months");
				$compare_date = date("Y-m-d 00:00:00", $compare_timestamp);


				if(
					$compare_date &&
					$calculated_time &&
					$compare_date === $calculated_time
				): ?>
				<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – quarterly subscription, no parameters sent – return current time + 3 months – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – quarterly subscription, no parameters sent – return current time + 3 months – error</p></div>
				<? endif; 

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – quarterly subscription, specify start time – return start time + 3 months") {

			(function() {

				// ARRANGE
				include_once("classes/shop/subscription.class.php");
				$SubscriptionClass = new Subscription();

			
				// ACT 
				$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("quarterly", "2018-01-01 00:00:00");
			
				// ASSERT 
				if(
					$calculated_time == "2018-04-01 00:00:00"
					): ?>
				<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – quarterly subscription, specify start time – return start time + 3 months – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – quarterly subscription, specify start time – return start time + 3 months – error</p></div>
				<? endif; 

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – quarterly subscription, specify start time as last day in a short month – return last day in longer month") {

			(function() {

				// ARRANGE
				include_once("classes/shop/subscription.class.php");
				$SubscriptionClass = new Subscription();

			
				// ACT 
				$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("quarterly", "2018-02-28 00:00:00");
			
				// ASSERT 
				if(
					$calculated_time == "2018-05-31 00:00:00"
					): ?>
				<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – quarterly subscription, specify start time as last day in a short month – return last day in longer month – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – quarterly subscription, specify start time as last day in a short month – return last day in longer month – error</p></div>
				<? endif; 

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – quarterly subscription, specify start time as last day in longer month – return last day in short month") {

			(function() {

				// ARRANGE
				include_once("classes/shop/subscription.class.php");
				$SubscriptionClass = new Subscription();

			
				// ACT 
				$calculated_time = $SubscriptionClass->calculateSubscriptionExpiry("quarterly", "2018-03-31 00:00:00");
			
				// ASSERT 
				if(
					$calculated_time == "2018-06-30 00:00:00"
					): ?>
				<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – quarterly subscription, specify start time as last day in longer month – return last day in short month – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – quarterly subscription, specify start time as last day in longer month – return last day in short month – error</p></div>
				<? endif; 

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – monthly subscription, no parameters sent – return current time + 1 month") {

			(function() {

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

				// compensate for Dayligt Saving Time (shifts in March/October in the EU)
				if(date("M") == "Mar") {
					$time_diff += 3600;
				}
				if(date("M") == "Oct") {
					$time_diff -= 3600;
				}

				if(
					$current_time &&
					$calculated_time &&
					($time_diff == (28*86400) || $time_diff == (29*86400) || $time_diff == (30*86400) || $time_diff == (31*86400) || $time_diff == (31*86400+3600))
					): ?>
				<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – monthly subscription, no parameters sent – return current time + 1 month – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – monthly subscription, no parameters sent – return current time + 1 month – error</p></div>
				<? endif; 

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – monthly subscription, specify start time – return start time + 1 month") {

			(function() {

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

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – monthly subscription, specify start time as last day in a short month – return last day in longer month") {

			(function() {

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

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – monthly subscription, specify start time as last day in longer month – return last day in short month") {

			(function() {

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

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – weekly subscription, no parameters sent – return current time + 1 week") {

			(function() {

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

				// compensate for Daylight Saving Time (shift in last week of March and October)
				$current_week = date("W");
				$last_week_in_march = date("W", mktime(0, 0, 0, 4, 1))-1;
				$last_week_in_october = date("W", mktime(0, 0, 0, 11, 1))-1;
				if($current_week == $last_week_in_march ) {
					$time_diff += 3600;
				}
				if($current_week == $last_week_in_october) {
					$time_diff -= 3600;
				}

				if(
					$current_time &&
					$calculated_time &&
					$time_diff == (7*24*60*60)
					): ?>
				<div class="testpassed"><p>Subscription::calculateSubscriptionExpiry – weekly subscription, no parameters sent – return current time + 1 week – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::calculateSubscriptionExpiry – weekly subscription, no parameters sent – return current time + 1 week – error</p></div>
				<? endif; 

				message()->resetMessages();
	
			})();

		}

		if(1 && "calculateSubscriptionExpiry – weekly subscription, specify start time – return start time + 1 week") {

			(function() {
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

				message()->resetMessages();
	
			})();

		}

		?>
	</div>

</div>
