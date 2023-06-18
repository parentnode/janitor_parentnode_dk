<?
$query = new Query();

// SETUP
// create test system_subscription_methods
$sql = "INSERT INTO ".UT_SUBSCRIPTION_METHODS." (id, name, duration, starts_on) VALUES (999, 'Month', 'monthly', DEFAULT), (998, 'Week', 'weekly', DEFAULT), (997, 'Never expires', '*', DEFAULT)";
// print $sql;
$query->sql($sql);

// create test system_vatrates
$sql = "INSERT INTO ".UT_VATRATES." (id, name, vatrate, country) VALUES (999, 'No VAT', 0, 'DK'), (998, '25%', 25, 'DK')";
// print $sql;
$query->sql($sql);


?>

<div class="scene i:scene tests">
	<h1>SuperSubscription</h1>	
	<h2>Testing SuperSubscription class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>Subscriptions (without price, subscription method *)</h3>
		<?

		if(1 && "SuperSubscription::addSubscription, without price, subscription method *") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 997]);
				$test_user_id = $test_model->createTestUser();


				// item without price – should succeed
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				// debug([$test_item_id, $test_user_id, $subscription]);


				// ASSERT

				if(
					$subscription &&
					$subscription["item_id"] == $test_item_id &&
					$subscription["user_id"] == $test_user_id &&
					!$subscription["expires_at"] &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>SuperSubscription::addSubscription, without price, subscription method * - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::addSubscription, without price, subscription method * - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "SuperSubscription::addSubscription, without price, subscription method *, adding existing item") {

			(function() {


				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 997]);
				$test_user_id = $test_model->createTestUser();


				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// adding existing item – should succeed (but return existing subscription with updated modified_at)
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription_duplet = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// debug(["item", $item,"subscr", $subscription, "duplet", $subscription_duplet]);
		

				// ASSERT

				if(
					$subscription_duplet &&
					$subscription_duplet["item_id"] == $subscription["item_id"] &&
					$subscription_duplet["user_id"] == $subscription["user_id"] &&
					$subscription_duplet["user_id"] == $subscription["user_id"] &&
					$subscription_duplet["created_at"] == $subscription["created_at"] 
				): ?>
				<div class="testpassed"><p>SuperSubscription::addSubscription, adding existing item - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::addSubscription, adding existing item - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "getSubscriptions by item_id, without price, subscription method *") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 997]);
				$test_user_id = $test_model->createTestUser();


				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// get the created subscription
				$subscriptions = $SuperSubscriptionClass->getSubscriptions(["item_id" => $test_item_id]);
				$subscription = $subscriptions ? $subscriptions[0] : false;

				// debug([$subscription]);


				// ASSERT

				if(
					$subscription &&
					$subscription["user_id"] == $test_user_id &&
					$subscription["item_id"] == $test_item_id &&
					!$subscription["expires_at"] &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>SuperSubscription::getSubscriptions by item_id, without price, subscription method * - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::getSubscriptions by item_id, without price, subscription method * - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "getSubscriptions by user_id, without price, subscription method *") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 997]);
				$test_user_id = $test_model->createTestUser();


				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// get the created subscription
				$subscriptions = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id]);
				$subscription = $subscriptions ? $subscriptions[0] : false;

				// debug([$subscription]);


				// ASSERT

				if(
					$subscription &&
					$subscription["user_id"] == $test_user_id &&
					$subscription["item_id"] == $test_item_id &&
					!$subscription["expires_at"] &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>SuperSubscription::getSubscriptions by user_id, without price, subscription method * - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::getSubscriptions by user_id, without price, subscription method * - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "deleteSubscription, item without price, subscription method *") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 997]);
				$test_user_id = $test_model->createTestUser();


				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// delete the created subscription
				$subscription_id = $subscription ? $subscription["id"] : false;
				$deletion_success = $SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $subscription_id]);


				// ASSERT

				if(
					$subscription && 
					$deletion_success &&
					!$SuperSubscriptionClass->getSubscriptions(["item_id" => $test_item_id]) &&
					!$SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id])
				): ?>
				<div class="testpassed"><p>SuperSubscription::deleteSubscription, item without price, subscription method * - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::deleteSubscription, item without price, subscription method * - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Subscriptions (with subscription method, monthly, without price)</h3>
		<?

		if(1 && "with subscription method, monthly, without price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 999]);
				$test_user_id = $test_model->createTestUser();


				// item without price – should succeed
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				$expires_at = $SuperSubscriptionClass->calculateSubscriptionExpiry("monthly");


				// ASSERT
		
				if(
					$subscription &&
					$subscription["item_id"] == $test_item_id &&
					$subscription["expires_at"] === $expires_at &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>SuperSubscription::addSubscription, with subscription method, monthly, without price - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::addSubscription, with subscription method, monthly, without price - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "with subscription method, monthly, without price, adding existing item") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 999]);
				$test_user_id = $test_model->createTestUser();


				// item without price – should succeed
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				// adding existing item – should succeed (but return existing subscription)
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription_duplet = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				$expires_at = $SuperSubscriptionClass->calculateSubscriptionExpiry("monthly");


				// ASSERT

				if(
					$subscription_duplet &&
					$subscription_duplet["item_id"] == $subscription["item_id"] &&
					$subscription_duplet["user_id"] == $subscription["user_id"] &&
					$subscription_duplet["user_id"] == $subscription["user_id"] &&
					$subscription_duplet["created_at"] == $subscription["created_at"] &&
					$subscription_duplet["expires_at"] === $expires_at
						
				): ?>
				<div class="testpassed"><p>SuperSubscription::addSubscription, with subscription method, monthly, without price, adding existing item - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::addSubscription, with subscription method, monthly, without price, adding existing item - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "getSubscriptions, by user_id and item_id") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 999]);
				$test_user_id = $test_model->createTestUser();


				// item without price – should succeed
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// get the created subscription
				$subscription = $SuperSubscriptionClass->getSubscriptions(["item_id" => $test_item_id, "user_id" => $test_user_id]);

				$expires_at = $SuperSubscriptionClass->calculateSubscriptionExpiry("monthly");


				// ASSERT

				if(
					$subscription &&
					$subscription["item_id"] == $test_item_id &&
					$subscription["expires_at"] === $expires_at &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>SuperSubscription::getSubscriptions, by user_id and item_id - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::getSubscriptions, by user_id and item_id - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "getSubscriptions, by user_id and item_id") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 999]);
				$test_user_id = $test_model->createTestUser();


				// item without price – should succeed
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// ASSERT

				// delete the created subscription
				if(
					$subscription && 
					$SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $subscription["id"]]) &&
					!$SuperSubscriptionClass->getSubscriptions(array("item_id" => $test_item_id))
				): ?>
				<div class="testpassed"><p>SuperSubscription::deleteSubscription, item without price or subscription method - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::deleteSubscription, item without price or subscription method - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Subscriptions (with subscription method, weekly, without price)</h3>
		<?

		if(1 && "with subscription method, weekly, without price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 998]);
				$test_user_id = $test_model->createTestUser();


				// item without price – should succeed
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				$expires_at = $SuperSubscriptionClass->calculateSubscriptionExpiry("weekly");


				// ASSERT
		
				if(
					$subscription &&
					$subscription["item_id"] == $test_item_id &&
					$subscription["expires_at"] === $expires_at &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>SuperSubscription::addSubscription, with subscription method, weekly, without price - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::addSubscription, with subscription method, weekly, without price - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "with subscription method, weekly, without price, adding existing item") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 998]);
				$test_user_id = $test_model->createTestUser();


				// item without price – should succeed
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				// adding existing item – should succeed (but return existing subscription)
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription_duplet = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);

				$expires_at = $SuperSubscriptionClass->calculateSubscriptionExpiry("weekly");


				// ASSERT

				if(
					$subscription_duplet &&
					$subscription_duplet["item_id"] == $subscription["item_id"] &&
					$subscription_duplet["user_id"] == $subscription["user_id"] &&
					$subscription_duplet["user_id"] == $subscription["user_id"] &&
					$subscription_duplet["created_at"] == $subscription["created_at"] &&
					$subscription_duplet["expires_at"] === $expires_at
						
				): ?>
				<div class="testpassed"><p>SuperSubscription::addSubscription, with subscription method, weekly, without price, adding existing item - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::addSubscription, with subscription method, weekly, without price, adding existing item - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "getSubscriptions, by user_id and item_id") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 998]);
				$test_user_id = $test_model->createTestUser();


				// item without price – should succeed
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// get the created subscription
				$subscription = $SuperSubscriptionClass->getSubscriptions(["item_id" => $test_item_id, "user_id" => $test_user_id]);

				$expires_at = $SuperSubscriptionClass->calculateSubscriptionExpiry("weekly");


				// ASSERT

				if(
					$subscription &&
					$subscription["item_id"] == $test_item_id &&
					$subscription["expires_at"] === $expires_at &&
					!$subscription["order_id"]
				): ?>
				<div class="testpassed"><p>SuperSubscription::getSubscriptions, by user_id and item_id - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::getSubscriptions, by user_id and item_id - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "getSubscriptions, by user_id and item_id") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 998]);
				$test_user_id = $test_model->createTestUser();


				// item without price – should succeed
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// ASSERT

				// delete the created subscription
				if(
					$subscription && 
					$SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $subscription["id"]]) &&
					!$SuperSubscriptionClass->getSubscriptions(array("item_id" => $test_item_id))
				): ?>
				<div class="testpassed"><p>SuperSubscription::deleteSubscription, item without price or subscription method - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::deleteSubscription, item without price or subscription method - error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		?>
	</div>


	<div class="tests">
		<h3>Subscriptions (with subscription method, weekly, with price but no order)</h3>
		<?

		if(1 && "text") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 998, "price" => 100]);
				$test_user_id = $test_model->createTestUser();

		
				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// ASSERT

				if(!$subscription): ?>
				<div class="testpassed"><p>SuperSubscription::addSubscription – price but no order_id (should not add) – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::addSubscription – price but no order_id (should not add) – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Subscriptions (without subscription method)</h3>
		<?

		if(1 && "without subscription method") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem();
				$test_user_id = $test_model->createTestUser();


				$_POST["item_id"] = $test_item_id;
				$_POST["user_id"] = $test_user_id;
				$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
				unset($_POST);


				// ASSERT

				if($subscription === false): ?>
				<div class="testpassed"><p>Subscription::addSubscription – item has no subscription method – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Subscription::addSubscription – item has no subscription method – should return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>SuperSubscription::addSubscription</h3>	
		<?

		if(1 && "addSubscription – order item has custom price – return subscription with custom price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();

				$test_item_id = $test_model->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $test_model->createTestUser();


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

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>SuperSubscription::renewSubscriptions</h3>	
		<?

		if(1 && "renewSubscriptions – renew all – return true") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id_1 = $test_model->createTestUser(["subscribed_item_id" => $test_item_id, "subscription_expires_at" => "2019-01-01 00:00:00"]);
				$test_user_id_2 = $test_model->createTestUser(["subscribed_item_id" => $test_item_id, "subscription_expires_at" => "2019-01-01 00:00:00"]);


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

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		if(1 && "renewSubscriptions – renew subscriptions for specific user – return true") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id, "subscription_expires_at" => "2019-01-01 00:00:00"]);


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
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::renewSubscriptions, renew specific user – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		} 

		if(1 && "renewSubscriptions – renew subscription with custom price – return true, renewed subscription has custom price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 2, "price" => 100]);
				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id, "subscription_expires_at" => "2019-01-01 00:00:00", "subscription_custom_price" => 50]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				// ACT

				$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions", $test_user_id]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]); 


				// ASSERT

				if(
					$result &&
					$subscription &&
					$subscription["expires_at"] == "2020-01-01 00:00:00" &&
					$subscription["custom_price"] == 50
				):?>
				<div class="testpassed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price – return true, renewed subscription has custom price – correct</p></div>
				<? else: 
					
				?>
				<div class="testfailed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price – return true, renewed subscription has custom price – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		}

		if(1 && "renewSubscriptions – renew subscription with custom price of 0 – return true, renewed subscription has custom price of 0") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 2, "price" => 100]);
				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id, "subscription_expires_at" => "2019-01-01 00:00:00", "subscription_custom_price" => 0]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions", $test_user_id]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]); 


				// ASSERT
				if(
					$result &&
					$subscription &&
					$subscription["expires_at"] == "2020-01-01 00:00:00" &&
					$subscription["custom_price"] === "0"
				):?>
				<div class="testpassed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price of 0 – return true, renewed subscription has custom price of 0 – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price of 0 – return true, renewed subscription has custom price of 0 – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);

			})();

		}

		if(1 && "renewSubscriptions – renew subscription with custom price with comma-seperated decimal – return true, renewed subscription has custom price with period-seperated decimal") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 2, "price" => 100]);
				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id, "subscription_expires_at" => "2019-01-01 00:00:00", "subscription_custom_price" => "50,5"]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				// ACT

				$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions", $test_user_id]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]); 


				// ASSERT

				if(
					$result &&
					$subscription &&
					$subscription["expires_at"] == "2020-01-01 00:00:00" &&
					$subscription["custom_price"] === "50.5"
				):?>
				<div class="testpassed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price with comma-seperated decimal – return true, renewed subscription has custom price with period-seperated decimal – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price with comma-seperated decimal – return true, renewed subscription has custom price with period-seperated decimal – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		}

		if(1 && "renewSubscriptions – renew subscription with custom price with period-seperated decimal – return true, renewed subscription has custom price with period-seperated decimal") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$test_item_id = $test_model->createTestItem(["subscription_method" => 2, "price" => 100]);
				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id, "subscription_expires_at" => "2019-01-01 00:00:00", "subscription_custom_price" => "50.5"]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// ACT
				$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions", $test_user_id]);
				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]); 


				// ASSERT
				if(
					$result &&
					$subscription &&
					$subscription["expires_at"] == "2020-01-01 00:00:00" &&
					$subscription["custom_price"] === "50.5"
				):?>
				<div class="testpassed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price with period-seperated decimal – return true, renewed subscription has custom price with period-seperated decimal – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::renewSubscriptions – renew subscription with custom price with period-seperated decimal – return true, renewed subscription has custom price with period-seperated decimal – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>updateSubscription</h3>		
		<?

		if(1 && "updateSubscription – no changes – return updated subscription") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				// ARRANGE
				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id]);

				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// clear session for old callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");


				// ACT 

				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);


				// ASSERT 

				if(
					$updated_subscription &&
					$updated_subscription["id"] &&
					$updated_subscription["user_id"] == $test_user_id &&
					$updated_subscription["item_id"] == $test_item_id &&
					$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
					!session()->value("test_item_subscribed_callback")
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – no changes – return updated subscription – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – no changes – return updated subscription – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – no parameters send – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				// clear session for old callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");


				// ACT 

				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription"]);


				// ASSERT 

				if(
					$added_subscription &&
					$updated_subscription === false
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – no parameters send – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – no parameters send – return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – invalid subscription_id – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				// clear session for old callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");


				// ACT 

				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", 9999]);


				// ASSERT 

				if(
					$added_subscription &&
					$updated_subscription === false
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – invalid subscription_id – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – invalid subscription_id – return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – invalid item_id – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				// ACT 

				$_POST["item_id"] = 9999;
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
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

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – change item_id (item has a price) but not order_id – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id_1 = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_item_id_2 = $test_model->createTestItem(["price" => 50, "subscription_method" => 2]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id_1]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id_1]);


				// ACT 

				$_POST["item_id"] = $test_item_id_2;
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);


				// ASSERT 

				if(
					$updated_subscription === false
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – change item_id (item has a price) but not order_id – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – change item_id (item has a price) but not order_id – return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_item_id_2]);

			})();

		}

		if(1 && "updateSubscription – change item_id (item has no price) but not order_id – return updated, orderless subscription and callback 'subscribed'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id_1 = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_item_id_2 = $test_model->createTestItem(["subscription_method" => 2]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id_1]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id_1]);


				// clear session for old callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");


				// ACT 

				$_POST["item_id"] = $test_item_id_2;
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);


				// ASSERT 

				if(
					$updated_subscription &&
					$added_subscription &&
					$updated_subscription["id"] == $added_subscription["id"] &&
					$updated_subscription["user_id"] == $test_user_id &&
					$added_subscription["item_id"] == $test_item_id_1 &&
					$updated_subscription["item_id"] == $test_item_id_2 &&
					$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
					$updated_subscription["order_id"] == false &&
					session()->value("test_item_subscribed_callback")
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – change item_id (item has no price) but not order_id – return updated, orderless subscription and callback 'subscribed' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – change item_id (item has no price) but not order_id – return updated, orderless subscription and callback 'subscribed' – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_item_id_2]);

			})();

		}

		if(1 && "updateSubscription – change item_id and add order_id  – return updated subscription and callback 'subscribed'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id_1 = $test_model->createTestItem(["subscription_method" => 2]);

				$test_item_id_2 = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id_1]);



				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id_1]);


				// order second test item and create subscription
				$second_item_cart = $SC->addToNewInternalCart($test_item_id_2, ["user_id" => $test_user_id]);
				$second_item_cart_reference = $second_item_cart["cart_reference"];
				$second_item_cart_id = $second_item_cart["id"];
				$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_id, $second_item_cart_reference]);
				$second_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id_2]);


				// delete second subscription
				$second_subscription_id = $second_subscription ? $second_subscription["id"] : false;
				$SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $second_subscription_id]);


				// clear session for old callback checks
				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_ordered_callback");


				// ACT 

				$_POST["item_id"] = $test_item_id_2;
				$_POST["order_id"] = $second_item_order["id"];
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);
			
				// ASSERT 
				if(
					$updated_subscription &&
					$added_subscription &&
					$updated_subscription["id"] == $added_subscription["id"] &&
					$updated_subscription["user_id"] == $test_user_id &&
					$added_subscription["item_id"] == $test_item_id_1 &&
					$updated_subscription["item_id"] == $test_item_id_2 &&
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

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_item_id_2]);

			})();

		} 

		if(1 && "updateSubscription – change to item without subscription method – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id_1 = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_item_id_2 = $test_model->createTestItem(["price" => 50]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id_1]);

				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id_1]);


				// ACT 

				$_POST["item_id"] = $test_item_id_2;
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);


				// ASSERT 

				if(
					$added_subscription &&
					$updated_subscription === false
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – change to item without subscription method – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – change to item without subscription method – return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_item_id_2]);

			})();

		}

		if(1 && "updateSubscription – add mew order_id – return updated subscription") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id_1 = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_item_id_2 = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);


				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id_1]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id_1]);

				// order second test item and create subscription
				$second_item_cart = $SC->addToNewInternalCart($test_item_id_2, ["user_id" => $test_user_id]);
				$second_item_cart_reference = $second_item_cart["cart_reference"];
				$second_item_cart_id = $second_item_cart["id"];
				$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_id, $second_item_cart_reference]);
				$second_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id_2]);

				// delete second subscription
				$second_subscription_id = $second_subscription ? $second_subscription["id"] : false;
				$SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $second_subscription_id]);

				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");


				// ACT 

				$_POST["order_id"] = $second_item_order["id"];
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);


				// ASSERT 

				if(
					$updated_subscription &&
					$added_subscription &&
					$updated_subscription["id"] == $added_subscription["id"] &&
					$updated_subscription["user_id"] == $test_user_id &&
					$added_subscription["item_id"] == $updated_subscription["item_id"] &&
					$updated_subscription["order_id"] == $second_item_order["id"] &&
					$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
					!session()->value("test_item_subscribed_callback")
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – add new order_id – return updated subscription – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – add new order_id – return updated subscription – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_item_id_2]);

			})();

		}

		if(1 && "updateSubscription – add order_id when item has no price – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id_1 = $test_model->createTestItem(["subscription_method" => 2]);

				$test_item_id_2 = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);


				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id_1]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id_1]);


				// order second test item and create subscription
				$second_item_cart = $SC->addToNewInternalCart($test_item_id_2, ["user_id" => $test_user_id]);
				$second_item_cart_reference = $second_item_cart["cart_reference"];
				$second_item_cart_id = $second_item_cart["id"];
				$second_item_order = $SC->newOrderFromCart(["newOrderFromCart", $second_item_cart_id, $second_item_cart_reference]);
				$second_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id_2]);

				// delete second subscription
				$second_subscription_id = $second_subscription ? $second_subscription["id"] : false;
				$SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $test_user_id, $second_subscription_id]);
			
				// clear session for callback checks
				session()->reset("test_item_subscribed_callback");


				// ACT 

				$_POST["order_id"] = $second_item_order["id"];
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);
		
				// ASSERT 
				if(
					$added_subscription &&
					$updated_subscription === false
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – add order_id when item has no price – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – add order_id when item has no price – return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_item_id_2]);

			})();

		} 

		if(1 && "updateSubscription – change expiry date, while not changing item_id – return updated subscription without callback") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_subscription_renewed_callback");


				// ACT 

				$_POST["expires_at"] = "2001-01-01 00:00:00";
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);


				// ASSERT 

				if(
					$updated_subscription &&
					$added_subscription &&
					$updated_subscription["id"] == $added_subscription["id"] &&
					$updated_subscription["user_id"] == $test_user_id &&
					$added_subscription["item_id"] == $test_item_id &&
					$updated_subscription["item_id"] == $test_item_id &&
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

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		} 

		if(1 && "updateSubscription – change expiry date of eternal subscription – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 3]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_subscription_renewed_callback");


				// ACT 

				$_POST["expires_at"] = "2001-01-01 00:00:00";
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);


				// ASSERT 

				if(
					$added_subscription &&
					$updated_subscription === false
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – change expiry date of eternal subscription – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – change expiry date of eternal subscription – return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – invalid expiry date – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 2]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				session()->reset("test_item_subscribed_callback");
				session()->reset("test_item_subscription_renewed_callback");


				// ACT 

				$_POST["expires_at"] = 9999;
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);


				// ASSERT 

				if(
					$added_subscription &&
					$updated_subscription === false
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – invalid expiry date – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – invalid expiry date – return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – send 'renew' flag to monthly subscription – return updated subscription, callback 'renewed'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 1]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				session()->reset("test_item_subscription_renewed_callback");
				session()->reset("test_item_subscribed_callback");


				// ACT 

				$_POST["subscription_renewal"] = true;
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);


				// ASSERT 

				if(
					$updated_subscription &&
					$updated_subscription["id"] &&
					$updated_subscription["user_id"] == $test_user_id &&
					$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
					$added_subscription["item_id"] == $updated_subscription["item_id"] && 
					$updated_subscription["item_id"] == $test_item_id &&
					!isset($added_subscription["renewed_at"]) &&
					isset($updated_subscription["renewed_at"]) &&
					session()->value("test_item_subscription_renewed_callback")
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – send 'renew' flag to monthly subscription – return updated subscription, callback 'renewed' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – send 'renew' flag to monthly subscription – return updated subscription, callback 'renewed' – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – send 'renew' flag to eternal subscription – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 3]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				// ACT 

				$_POST["subscription_renewal"] = true;
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);


				// ASSERT 

				if(
					$added_subscription &&
					$updated_subscription === false
				): ?>
				<div class="testpassed"><p>SuperSubscription::updateSubscription – send 'renew' flag to eternal subscription – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperSubscription::updateSubscription – send 'renew' flag to eternal subscription – return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – change expiry date and send 'renew' flag to monthly subscription – return updated subscription, callback 'subscribed'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 1]);

				$test_user_id = $test_model->createTestUser(["subscribed_item_id" => $test_item_id]);


				$added_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);

				session()->reset("test_item_subscription_renewed_callback");


				// ACT 

				$_POST["expires_at"] = "2001-01-01 00:00:00";
				$_POST["subscription_renewal"] = true;
				$added_subscription_id = $added_subscription ? $added_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $added_subscription_id]);
				unset($_POST);


				// ASSERT 

				if(
					$updated_subscription &&
					$updated_subscription["id"] &&
					$updated_subscription["user_id"] == $test_user_id &&
					$updated_subscription["modified_at"] != $added_subscription["modified_at"] &&
					$added_subscription["item_id"] == $updated_subscription["item_id"] && 
					$updated_subscription["item_id"] == $test_item_id &&
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

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – add custom price – return subscription with custom price") {
			
			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $test_model->createTestUser();

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);
				$existing_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				// ACT

				$_POST["custom_price"] = 50;
				$existing_subscription_id = $existing_subscription ? $existing_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $existing_subscription_id]);
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

				$test_model->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – change custom price – return subscription with changed custom price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $test_model->createTestUser();

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "custom_price" => 75]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);
				$existing_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				// ACT

				$_POST["custom_price"] = 50;
				$existing_subscription_id = $existing_subscription ? $existing_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $existing_subscription_id]);
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

				$test_model->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		}

		if(1 && "updateSubscription – delete custom price (set to false) – return subscription without custom price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();


				$test_item_id = $test_model->createTestItem(["subscription_method" => 1, "price" => 100]);
				$test_user_id = $test_model->createTestUser();

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "custom_price" => 75]);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);
				$existing_subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id, "item_id" => $test_item_id]);


				// ACT

				$_POST["custom_price"] = false;
				$existing_subscription_id = $existing_subscription ? $existing_subscription["id"] : false;
				$updated_subscription = $SuperSubscriptionClass->updateSubscription(["updateSubscription", $existing_subscription_id]);
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

				$test_model->cleanUp(["user_id" => $test_user_id, "item_id" => $test_item_id]);

			})();

		}

		/*

		// This test isn't written yet, as it is waiting for different payment methods to be actually used by the system
		function updateSubscription_changePaymentMethod_returnUpdatedSubscription(){};
		?>
		<?
		// This test hasn't been written yet, as it is yet to be developed
		function updateSubscription_changeCustomPrice_returnUpdatedSubscription(){};
		
		// also test relevant combinations of parameters 
		// test different types of subscriptions and check that renewal dates are correct

		*/
		?>
	</div>
</div>


<?

// CLEAN UP
$sql = "DELETE FROM ".UT_ITEMS_SUBSCRIPTION_METHOD." WHERE subscription_method_id IN (997, 998, 999)";
$query->sql($sql);

$sql = "DELETE FROM ".UT_SUBSCRIPTION_METHODS." WHERE id IN (997, 998, 999)";
// print $sql;
$query->sql($sql);

?>