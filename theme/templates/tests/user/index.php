<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();

// $UpgradeClass->checkDefaultValues(UT_LANGUAGES);
// // $UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'DA','Dansk'", "id = 'DA'");
// // $UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'EN','English'", "id = 'EN'");
//
// $UpgradeClass->checkDefaultValues(UT_CURRENCIES);
// // $UpgradeClass->checkDefaultValues(UT_CURRENCIES, "'DKK', 'Kroner (Denmark)', 'DKK', 'after', 2, ',', '.'", "id = 'DKK'");
// // $UpgradeClass->checkDefaultValues(UT_CURRENCIES, "'EUR', 'Euro (Denmark)', '€', 'before', 2, ',', '.'", "id = 'EUR'");
//
// $UpgradeClass->checkDefaultValues(UT_COUNTRIES, "'DK', 'Danmark', '45', '#### ####', 'DA', 'DKK'", "id = 'DK'");
// $UpgradeClass->checkDefaultValues(UT_COUNTRIES, "'DE', 'Deutchland', '49', '#### ####', 'DE', 'EUR'", "id = 'DE'");
//
// $UpgradeClass->checkDefaultValues(UT_SUBSCRIPTION_METHODS, "999, 'Month', 'monthly', DEFAULT", "id = 999");
// $UpgradeClass->checkDefaultValues(UT_SUBSCRIPTION_METHODS, "998, 'Week', 'weekly', DEFAULT", "id = 998");
//
// $UpgradeClass->checkDefaultValues(UT_VATRATES, "999, 'No VAT', 0, 'DK'", "id = 999");
// $UpgradeClass->checkDefaultValues(UT_VATRATES, "998, '25%', 25, 'DK'", "id = 998");


$IC = new Items();
$model_tests = $IC->typeObject("tests");



// create test item
$_POST["name"] = "Test item";
$item = $model_tests->save(array("save"));
unset($_POST);


$UC = new User();
?>

<div class="scene i:scene tests defaultEdit">
	<h1>User</h1>	
	<h2>Testing User class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<div class="tests">
		<h3>User::getUser</h3>
		<? 
		$user = $UC->getUser();
		if(
			$user &&
			$user["nickname"] &&
			$user["email"] &&
			$user["language"] &&
			isset($user["firstname"]) &&
			isset($user["lastname"]) &&
			isset($user["mobile"]) &&
			isset($user["addresses"]) &&
			isset($user["membership"]) &&
			isset($user["newsletters"])
		): ?>
		<div class="testpassed"><p>User::getUser - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getUser - error</p></div>
		<? endif; ?>

	</div>


	<div class="tests">
		<h3>Subscriptions (without price or subscription method)</h3>
		<?

		// item without price – should succeed
		$_POST["item_id"] = $item["item_id"];
		$subscription = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			!$subscription["expires_at"] &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		$_POST["item_id"] = $item["item_id"];
		$subscription_duplet = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		if(
			$subscription_duplet == $subscription
		): ?>
		<div class="testpassed"><p>User::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $UC->getSubscriptions(array("item_id" => $item["item_id"]));
		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			!$subscription["expires_at"] &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::getSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getSubscription - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$UC->deleteSubscription(array("deleteSubscription", $subscription["id"])) &&
			!$UC->getSubscriptions(array("item_id" => $item["item_id"]))
		): ?>
		<div class="testpassed"><p>User::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::deleteSubscription, item without price or subscription method - error</p></div>
		<? endif; ?>
	</div>



	<div class="tests">
		<h3>Subscriptions (with subscription method, monthly, without price)</h3>
		<?
		// update test item (monthly)
		$_POST["item_subscription_method"] = 999;
		$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item["item_id"]));
		unset($_POST);


		// item without price – should succeed
		$_POST["item_id"] = $item["item_id"];
		$subscription = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		$expires_at = date("Y-m-d 00:00:00", time() + (date("t")*24*60*60));
		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		$_POST["item_id"] = $item["item_id"];
		$subscription_duplet = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		if(
			$subscription_duplet == $subscription
		): ?>
		<div class="testpassed"><p>User::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $UC->getSubscriptions(array("item_id" => $item["item_id"]));
		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::getSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getSubscription - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$UC->deleteSubscription(array("deleteSubscription", $subscription["id"])) &&
			!$UC->getSubscriptions(array("item_id" => $item["item_id"]))
		): ?>
		<div class="testpassed"><p>User::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::deleteSubscription, item without price or subscription method - error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>Subscriptions (with subscription method, weekly, without price)</h3>
		<?
		// update test item (monthly)
		$_POST["item_subscription_method"] = 998;
		$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item["item_id"]));
		unset($_POST);


		// item without price – should succeed
		$_POST["item_id"] = $item["item_id"];
		$subscription = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		$expires_at = date("Y-m-d 00:00:00", time() + (7*24*60*60));
		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		$_POST["item_id"] = $item["item_id"];
		$subscription_duplet = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		if(
			$subscription_duplet == $subscription
		): ?>
		<div class="testpassed"><p>User::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $UC->getSubscriptions(array("item_id" => $item["item_id"]));
		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::getSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getSubscription - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$UC->deleteSubscription(array("deleteSubscription", $subscription["id"])) &&
			!$UC->getSubscriptions(array("item_id" => $item["item_id"]))
		): ?>
		<div class="testpassed"><p>User::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::deleteSubscription, item without price or subscription method - error</p></div>
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
		$model_tests->addPrice(array("addPrice", $item["item_id"]));


		// item without price – should succeed
		$_POST["item_id"] = $item["item_id"];
		$subscription = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		if(!$subscription): ?>
		<div class="testpassed"><p>User::addSubscription (not added) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription (not added) - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $UC->getSubscriptions(array("item_id" => $item["item_id"]));
		if(!$subscription): ?>
		<div class="testpassed"><p>User::getSubscription (should not exist) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getSubscription (should not exist) - error</p></div>
		<? endif; ?>
	</div>

</div>
<?


	// CLEAN UP
	$model_tests->delete(array("delete", $item["item_id"]));
//	$model->delete(array("delete", $membership_without_price["item_id"]));
?>