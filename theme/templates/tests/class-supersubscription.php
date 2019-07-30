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
$sql = "INSERT INTO ".UT_SUBSCRIPTION_METHODS." (id, name, duration, starts_on) VALUES (999, 'Month', 'monthly', DEFAULT), (998, 'Week', 'weekly', DEFAULT)";
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
		$subscription = $SuperSubscriptionClass->addSubscription($item_id, ["user_id" => $test_user_id]);

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
		$subscription_duplet = $SuperSubscriptionClass->addSubscription($item_id, ["user_id" => $test_user_id]);
		
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
		if(
			$subscription && 
			$SuperSubscriptionClass->deleteSubscription($subscription["id"], ["user_id" => $test_user_id]) &&
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
		// $_POST["item_id"] = $item_id;
		$subscription = $SuperSubscriptionClass->addSubscription($item_id, ["user_id" => $test_user_id]);
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
		<div class="testpassed"><p>SuperSubscription::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		// $_POST["item_id"] = $item_id;
		$subscription_duplet = $SuperSubscriptionClass->addSubscription($item_id, ["user_id" => $test_user_id]);
		// unset($_POST);

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
			$SuperSubscriptionClass->deleteSubscription($subscription["id"], ["user_id" => $test_user_id]) &&
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
		// $_POST["item_id"] = $item_id;
		$subscription = $SuperSubscriptionClass->addSubscription($item_id, ["user_id" => $test_user_id]);
		// unset($_POST);

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
		// $_POST["item_id"] = $item_id;
		$subscription_duplet = $SuperSubscriptionClass->addSubscription($item_id, ["user_id" => $test_user_id]);
		// unset($_POST);

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
			$SuperSubscriptionClass->deleteSubscription($subscription["id"], ["user_id" => $test_user_id]) &&
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
		
		$subscription = $SuperSubscriptionClass->addSubscription($item_id);

		if(!$subscription): ?>
		<div class="testpassed"><p>SuperSubscription::addSubscription (not added) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperSubscription::addSubscription (not added) - error</p></div>
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
	$sql = "DELETE FROM ".UT_ITEMS_SUBSCRIPTION_METHOD." WHERE subscription_method_id IN (998, 999)";
	$query->sql($sql);
	
	$sql = "DELETE FROM ".UT_SUBSCRIPTION_METHODS." WHERE id IN (998, 999)";
	// print $sql;
	$query->sql($sql);

	$sql = "DELETE FROM ".UT_ITEMS_PRICES." WHERE subscription_method_id IN (998, 999)";
	$query->sql($sql);
	
	$sql = "DELETE FROM ".UT_VATRATES." WHERE id IN (998, 999)";
	// print $sql;
	$query->sql($sql);
	
	$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
	$query->sql($sql);

	$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $item_id";
	$query->sql($sql);



	?>
</div>
