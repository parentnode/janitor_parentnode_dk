<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();


$MC = new Member();
$query = new Query();
$IC = new Items();
$SC = new Shop();

$SubscriptionClass = new Subscription();
$model_tests = $IC->typeObject("tests");

?>

<div class="scene i:scene tests">
	<h1>Member</h1>	
	<h2>Testing Member class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>addMembership</h3>
		
		<? 	// addMembership – no subscription
			// ARRANGE

		// create test membership item
		$model_membership = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership_item = $model_membership->save(array("save"));
		$membership_item_id = $membership_item["id"];
		unset($_POST);

		?>
		<? 	// ACT 
		$added_membership = $MC->addMembership($membership_item["id"]);
		?>
		<? 	// ASSERT 
		if(
			$added_membership &&
			$added_membership["id"] &&
			$added_membership["user_id"] == session()->value("user_id")
			): ?>
		<div class="testpassed"><p>Member::addMembership – no subscription – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Member::addMembership – no subscription – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP

		// delete membership
		$added_membership_id = $added_membership["id"];
		$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
		$query->sql($sql);

		// delete membership item
		$sql = "DELETE FROM ".SITE_DB.".item_membership WHERE item_id = $membership_item_id";
		$query->sql($sql);

		
		?>

		<? 	// addMembership – with subscription
			// ARRANGE
			
		// create test membership item
		$model_membership = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership_item = $model_membership->save(array("save"));
		$membership_item_id = $membership_item["id"];
		unset($_POST);

		// update test item subscription method
		$_POST["item_subscription_method"] = 2;
		$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
		unset($_POST);

		// create test order
		$order_no = $SC->getNewOrderNumber();
		$sql = "SELECT id FROM ".SITE_DB.".shop_orders WHERE order_no = '$order_no'";
		if($query->sql($sql)) {
			$order_id = $query->result(0, "id");
		}

		$subscription = $SubscriptionClass->addSubscription($membership_item_id, ["order_id" => $order_id]);
		$subscription_id = $subscription["id"];

		?>
		<? 	// ACT 
		$added_membership = $MC->addMembership($membership_item["id"], ["subscription_id" => $subscription_id]);
		?>
		<? 	// ASSERT 
		if(
			$added_membership &&
			$added_membership["id"] &&
			$added_membership["user_id"] == session()->value("user_id") &&
			$added_membership["subscription_id"] == $subscription_id &&
			$added_membership["item_id"] == $membership_item["id"] &&
			$added_membership["order_id"] == $order_id

			): ?>
		<div class="testpassed"><p>Member::addMembership – with subscription – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Member::addMembership – with subscription – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP
		$membership_item_id = $membership_item["id"];
		
		// delete membership
		$added_membership_id = $added_membership["id"];
		$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
		$query->sql($sql);

		// delete subscription
		$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id AND order_id = $order_id";
		$query->sql($sql);
		
		// delete membership item
		$sql = "DELETE FROM ".SITE_DB.".item_membership WHERE item_id = $membership_item_id";
		$query->sql($sql);

		// delete membership item subscription method
		$sql = "DELETE FROM ".SITE_DB.".items_subscription_method WHERE item_id = $membership_item_id";
		$query->sql($sql);		

		// delete order
		$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
		$query->sql($sql);

		?>

		<? 	// addMembership – membership already exists (should return false)
			// ARRANGE

		// create test membership item
		$model_membership = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership_item = $model_membership->save(array("save"));
		$membership_item_id = $membership_item["id"];
		unset($_POST);

		$added_membership = $MC->addMembership($membership_item["id"]);

		?>
		<? 	// ACT 
		$repeated_membership = $MC->addMembership($membership_item["id"]);
		?>
		<? 	// ASSERT 
		if(
			!$repeated_membership
			): ?>
		<div class="testpassed"><p>Member::addMembership – membership already exists (should return false) – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Member::addMembership – membership already exists (should return false) – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP

		// delete membership
		$added_membership_id = $added_membership["id"];
		$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
		$query->sql($sql);

		// delete membership item
		$sql = "DELETE FROM ".SITE_DB.".item_membership WHERE item_id = $membership_item_id";
		$query->sql($sql);
		?>

	</div>

	<div class="tests">
		<h3>getMembership</h3>
		
		<? 	// getMembership
			// ARRANGE
		// create test membership item
		$model_membership = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership_item = $model_membership->save(array("save"));
		$membership_item_id = $membership_item["id"];
		unset($_POST);

		$added_membership = $MC->addMembership($membership_item_id);
		?>
		<? 	// ACT 
		$fetched_membership = $MC->getMembership();
		?>
		<? 	// ASSERT 
		if(
			$fetched_membership &&
			$fetched_membership["id"] &&
			$fetched_membership["user_id"] == session()->value("user_id") &&
			$fetched_membership["id"] == $added_membership["id"]
			): ?>
		<div class="testpassed"><p>Member::getMembership – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Member::getMembership – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP
		// delete membership
		$added_membership_id = $added_membership["id"];
		$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
		$query->sql($sql);

		// delete membership item
		$sql = "DELETE FROM ".SITE_DB.".item_membership WHERE item_id = $membership_item_id";
		$query->sql($sql);		
		?>


		<? 	// getMembership – no membership exists
			// ARRANGE
		?>
		<? 	// ACT 
		$fetched_membership = $MC->getMembership();
		?>
		<? 	// ASSERT 
		if(
			!$fetched_membership
			): ?>
		<div class="testpassed"><p>Member::getMembership – no membership exists (should return false) – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Member::getMembership – no membership exists (should return false) – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP
		?>

	</div>

	<div class="tests">
		<h3>updateMembership</h3>
		
		<? 	// updateMembership – no changes
			// ARRANGE
		
		// create test membership item
		$model_membership = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership_item = $model_membership->save(array("save"));
		$membership_item_id = $membership_item["id"];
		unset($_POST);

		$added_membership = $MC->addMembership($membership_item["id"]);
		?>
		<? 	// ACT 
		$updated_membership = $MC->updateMembership();
		?>
		<? 	// ASSERT 
		if(
			$updated_membership &&
			$updated_membership["id"] &&
			$updated_membership["user_id"] == session()->value("user_id") &&
			$updated_membership["id"] == $added_membership["id"] &&
			$updated_membership["modified_at"] != $added_membership["modified_at"]
			): ?>
		<div class="testpassed"><p>Member::updateMembership – no changes – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Member::updateMembership – no changes – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP
		// delete membership
		$added_membership_id = $added_membership["id"];
		$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
		$query->sql($sql);

		// delete membership item
		$sql = "DELETE FROM ".SITE_DB.".item_membership WHERE item_id = $membership_item_id";
		$query->sql($sql);	
		?>


		<? 	// updateMembership – change subscription_id
			// ARRANGE
		// create test membership item
		$model_membership = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership_item = $model_membership->save(array("save"));
		$membership_item_id = $membership_item["id"];
		unset($_POST);

		// update test item subscription method
		$_POST["item_subscription_method"] = 2;
		$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
		unset($_POST);

		// create test order
		$order_no = $SC->getNewOrderNumber();
		$sql = "SELECT id FROM ".SITE_DB.".shop_orders WHERE order_no = '$order_no'";
		if($query->sql($sql)) {
			$order_id = $query->result(0, "id");
		}

		$subscription = $SubscriptionClass->addSubscription($membership_item_id, ["order_id" => $order_id]);
		$subscription_id = $subscription["id"];

		$added_membership = $MC->addMembership($membership_item["id"]);
		?>

		<? 	// ACT 
		$updated_membership = $MC->updateMembership(["subscription_id" => $subscription_id]);
		?>
		<? 	// ASSERT 
		if(
			$updated_membership &&
			$updated_membership["id"] &&
			$updated_membership["user_id"] == session()->value("user_id") &&
			$updated_membership["id"] == $added_membership["id"] &&
			$updated_membership["subscription_id"] == $subscription_id &&
			$updated_membership["modified_at"] != $added_membership["modified_at"]
			): ?>
		<div class="testpassed"><p>Member::updateMembership – add subscription_id – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Member::updateMembership – add subscription_id – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP
		// delete membership
		$added_membership_id = $added_membership["id"];
		$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
		$query->sql($sql);

		// delete subscription
		$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id AND order_id = $order_id";
		$query->sql($sql);

		// delete membership item
		$sql = "DELETE FROM ".SITE_DB.".item_membership WHERE item_id = $membership_item_id";
		$query->sql($sql);	

		// delete membership item subscription method
		$sql = "DELETE FROM ".SITE_DB.".items_subscription_method WHERE item_id = $membership_item_id";
		$query->sql($sql);

		// delete order
		$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
		$query->sql($sql);
		?>


		<? 	// updateMembership – no membership exists
			// ARRANGE
		?>
		<? 	// ACT 
		$updated_membership = $MC->updateMembership();
		$updated_membership_id = $updated_membership["id"];
		?>
		<? 	// ASSERT 
		if(
			!$updated_membership
			): ?>
		<div class="testpassed"><p>Member::updateMembership – no membership exists (should return false) – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Member::updateMembership – no membership exists (should return false) – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP
		?>

	</div>
	<div class="tests">
		<h3>cancelMembership</h3>


		<? 	// cancelMembership
			// ARRANGE

		// create test membership item
		$model_membership = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership_item = $model_membership->save(array("save"));
		$membership_item_id = $membership_item["id"];
		unset($_POST);

		$added_membership = $MC->addMembership($membership_item["id"]);
		$added_membership_id = $added_membership["id"];

		$cancellation_success = false;

		?>
		<? 	// ACT 
			$cancellation_success = $MC->cancelMembership($added_membership_id);
		?>
		<? 	// ASSERT 
		if(
			$cancellation_success === true
			): ?>
		<div class="testpassed"><p>Member::cancelMembership – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Member::cancelMembership – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP
		// delete membership
		$added_membership_id = $added_membership["id"];
		$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
		$query->sql($sql);

		// delete membership item
		$sql = "DELETE FROM ".SITE_DB.".item_membership WHERE item_id = $membership_item_id";
		$query->sql($sql);
		?>

		<? 	// cancelMembership – invalid membership (should return false)
			// ARRANGE

		?>
		<? 	// ACT 
			$cancellation_success = $MC->cancelMembership(9999);
		?>
		<? 	// ASSERT 
		if(
			$cancellation_success === false
			): ?>
		<div class="testpassed"><p>Member::cancelMembership – invalid membership (should return false) – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Member::cancelMembership – invalid membership (should return false) – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP
		// delete membership
		$added_membership_id = $added_membership["id"];
		$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
		$query->sql($sql);

		// delete membership item
		$sql = "DELETE FROM ".SITE_DB.".item_membership WHERE item_id = $membership_item_id";
		$query->sql($sql);
		?>

	</div>

	
</div>
