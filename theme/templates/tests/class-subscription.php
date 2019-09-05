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
		$subscription = $SubscriptionClass->addSubscription($item_id);

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
		$subscription_duplet = $SubscriptionClass->addSubscription($item_id);
		
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
			$SubscriptionClass->deleteSubscription($subscription["id"]) &&
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
		// $_POST["item_id"] = $item_id;
		$subscription = $SubscriptionClass->addSubscription($item_id);
		// unset($_POST);

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
		// $_POST["item_id"] = $item_id;
		$subscription_duplet = $SubscriptionClass->addSubscription($item_id);
		// unset($_POST);

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
			$SubscriptionClass->deleteSubscription($subscription["id"]) &&
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
		// $_POST["item_id"] = $item_id;
		$subscription = $SubscriptionClass->addSubscription($item_id);
		// unset($_POST);

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
		// $_POST["item_id"] = $item_id;
		$subscription_duplet = $SubscriptionClass->addSubscription($item_id);
		// unset($_POST);

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
			$SubscriptionClass->deleteSubscription($subscription["id"]) &&
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
		
		$subscription = $SubscriptionClass->addSubscription($item_id);

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
		
		$subscription = $SubscriptionClass->addSubscription($item_id);

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


	?>
</div>
