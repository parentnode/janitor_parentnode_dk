<?
// ensure correct default values are available for test
// include_once("classes/system/upgrade.class.php");
// $UpgradeClass = new Upgrade();


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
		<? function addMembership_noSubscription_returnMembership() {

			// addMembership – no subscription
	
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);
	
			// ACT 
			$added_membership = $MC->addMembership($membership_item["id"]);
			
			// ASSERT 
			if(
				$added_membership &&
				$added_membership["id"] &&
				$added_membership["user_id"] == session()->value("user_id")
				): ?>
			<div class="testpassed"><p>Member::addMembership – no subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::addMembership – no subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		addMembership_noSubscription_returnMembership(); 
		?>		
		<? 	
		function addMembership_withSubscription_returnMembershipWithSubscriptionId() {
			
			// addMembership – with subscription
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();

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
	
			// ACT 
			$added_membership = $MC->addMembership($membership_item["id"], ["subscription_id" => $subscription_id]);
			
			// ASSERT 
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
			<? endif;
			
			// CLEAN UP
			$membership_item_id = $membership_item["id"];
			
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id AND order_id = $order_id";
			$query->sql($sql);
			
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
	
			// delete order
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
			$query->sql($sql);
	
		}
		addMembership_withSubscription_returnMembershipWithSubscriptionId(); 
		?>
		<? 
		function addMembership_membershipExists_returnFalse() {
			// addMembership – membership already exists (should return false)
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SubscriptionClass = new Subscription();

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);
	
			$added_membership = $MC->addMembership($membership_item["id"]);
	
			
			// ACT 
			$repeated_membership = $MC->addMembership($membership_item["id"]);
			
			// ASSERT 
			if(
				!$repeated_membership
				): ?>
			<div class="testpassed"><p>Member::addMembership – membership already exists (should return false) – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::addMembership – membership already exists (should return false) – error</p></div>
			<? endif;
				
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}	
		addMembership_membershipExists_returnFalse(); 
		?>
	</div>


	<div class="tests">
		<h3>getMembership</h3>		
		<? 
		function getMembership_membershipExists_returnMembership() {

			// getMembership
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);
	
			$added_membership = $MC->addMembership($membership_item_id);
			
			// ACT 
			$fetched_membership = $MC->getMembership();
			
			// ASSERT 
			if(
				$fetched_membership &&
				$fetched_membership["id"] &&
				$fetched_membership["user_id"] == session()->value("user_id") &&
				$fetched_membership["id"] == $added_membership["id"]
				): ?>
			<div class="testpassed"><p>Member::getMembership – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::getMembership – error</p></div>
			<? endif;
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);		
		
		}	
		getMembership_membershipExists_returnMembership(); 
		?>	
		<? 
		function getMembership_noMembershipExists_returnFalse() {
			// getMembership – no membership exists
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// ACT 
			$fetched_membership = $MC->getMembership();
			
			// ASSERT 
			if(
				$fetched_membership === false
				): ?>
			<div class="testpassed"><p>Member::getMembership – no membership exists (should return false) – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::getMembership – no membership exists (should return false) – error</p></div>
			<? endif; 
			
			// CLEAN UP 
		}
		getMembership_noMembershipExists_returnFalse();
		?>				
	</div>


	<div class="tests">
		<h3>updateMembership</h3>		
		<? 	
		function updateMembership_noChanges_returnUpdatedMembership() {

			// updateMembership – no changes
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);
	
			$added_membership = $MC->addMembership($membership_item["id"]);
			
			// ACT 
			$updated_membership = $MC->updateMembership();
			
			// ASSERT 
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
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);	
		}
		updateMembership_noChanges_returnUpdatedMembership();
		?>
		<? 	
		function updateMembership_changeSubscriptionId_returnUpdatedMembership() {
			// updateMembership – change subscription_id
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
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
			
			// ACT 
			$updated_membership = $MC->updateMembership(["subscription_id" => $subscription_id]);
			
			// ASSERT 
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
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id AND order_id = $order_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);	
	
			// delete order
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
			$query->sql($sql);

		}
		updateMembership_changeSubscriptionId_returnUpdatedMembership();
		?>
		<? 	
		function updateMembership_toNoSubscriptionId_returnUpdatedMembershipSubscriptionIdNull() {
			// updateMembership – change subscription_id
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);
	
			// add subscription method to first membership item
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);

			// add price to first membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);		
			
			// create membership and subscription
			$added_membership_cart_reference = $SC->addToNewInternalCart($membership_item_1_id)["cart_reference"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_reference]);
			
			$added_membership = $MC->getMembership();
			$added_membership_id = $added_membership["id"];
			$added_membership_subscription_id = $added_membership["subscription_id"];
			
			// create another test membership item
			$_POST["name"] = "Membership Test item 2";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);

			// ACT 
			$updated_membership = $MC->updateMembership();
			
			// ASSERT 
			if(
				$updated_membership &&
				$updated_membership["id"] &&
				$updated_membership["user_id"] == session()->value("user_id") &&
				$updated_membership["id"] == $added_membership["id"] &&
				$added_membership_subscription_id &&
				!$updated_membership["subscription_id"] == $added_membership_subscription_id &&
				$updated_membership["modified_at"] != $added_membership["modified_at"]
				): ?>
			<div class="testpassed"><p>Member::updateMembership – update to no subscription method – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::updateMembership – update to no subscription method – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
			
			// delete membership item 1 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_1_id";
			$query->sql($sql);			
			
			// delete membership 1 order
			$added_membership_order_no = $added_membership_order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$added_membership_order_no'";
			$query->sql($sql);

			// delete membership item 1
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);
	
			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);


			

		}
		updateMembership_toNoSubscriptionId_returnUpdatedMembershipSubscriptionIdNull();
		?>
		<? 	
		function updateMembership_noMembershipExists_returnFalse() {

			// updateMembership – no membership exists
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// ACT 
			$updated_membership = $MC->updateMembership();
			$updated_membership_id = $updated_membership["id"];
			
			
			// ASSERT 
			if(
				$updated_membership === false
				): ?>
			<div class="testpassed"><p>Member::updateMembership – no membership exists (should return false) – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::updateMembership – no membership exists (should return false) – error</p></div>
			<? endif;
			
			// CLEAN UP
		}
		updateMembership_noMembershipExists_returnFalse();
		?>
	</div>


	<div class="tests">
		<h3>cancelMembership</h3>
		<? 	
		function cancelMembership_membershipExists_membershipIsCancelled() {

			// cancelMembership
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);
	
			$added_membership = $MC->addMembership($membership_item["id"]);
			$added_membership_id = $added_membership["id"];
	
			$cancellation_success = false;
	
			// ACT 
			
			$cancellation_success = $MC->cancelMembership($added_membership_id);
			
			// ASSERT 
			if(
				$cancellation_success === true
				): ?>
			<div class="testpassed"><p>Member::cancelMembership – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::cancelMembership – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		cancelMembership_membershipExists_membershipIsCancelled();
		?>
		<? 	
		function cancelMembership_membershipInvalid_returnFalse() {
			// cancelMembership – invalid membership (should return false)
				
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// ACT 
				$cancellation_success = $MC->cancelMembership(9999);
			
			
			// ASSERT 
			if(
				$cancellation_success === false
				): ?>
			<div class="testpassed"><p>Member::cancelMembership – invalid membership (should return false) – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::cancelMembership – invalid membership (should return false) – error</p></div>
			<? endif; 
			
			// CLEAN UP


		}
		cancelMembership_membershipInvalid_returnFalse();
		?>
	</div>


	<div class="tests">
		<h3>switchMembership</h3>
		<? 	
		function switchMembership_fromNoSubscriptionToNoSubscription_returnOrderUpdateMembership() {
			
			// switchMembership – from no subscription to no subscription
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item 1";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);
			
			// create another test membership item
			$_POST["name"] = "Membership Test item 2";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);
			
			// add price to second membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
			
			$added_membership = $MC->addMembership($membership_item_1_id);
			$added_membership_id = $added_membership["id"];
	
			// ACT 
			$order = $MC->switchMembership($membership_item_2_id);
			$switched_membership = $MC->getMembership();
			
			// ASSERT 
			if(
				$order && 
				$switched_membership &&
				$switched_membership["id"] == $added_membership_id &&
				$switched_membership != $added_membership
				): ?>
			<div class="testpassed"><p>Member::switchMembership – from no subscription to no subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::switchMembership – from no subscription to no subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete membership item 1
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);
	
			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);
	
			// delete order
			$order_no = $order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$order_no'";
			$query->sql($sql);
		}
		switchMembership_fromNoSubscriptionToNoSubscription_returnOrderUpdateMembership();
		?>
		<? 	
		function switchMembership_fromNoSubscriptionToSubscription_returnOrderAddSubscriptionUpdateMembership() {
			
			// switchMembership – from no subscription to subscription
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item 1";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);
			
			// create another test membership item
			$_POST["name"] = "Membership Test item 2";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);
	
			// add subscription method to second membership item
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_2_id));
			unset($_POST);
			
			// add price to second membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
			
			$added_membership = $MC->addMembership($membership_item_1_id);
			$added_membership_id = $added_membership["id"];
	
			// ACT 
			$order = $MC->switchMembership($membership_item_2_id);
			$switched_membership = $MC->getMembership();
			
			// ASSERT 
			if(
				$order && 
				$switched_membership &&
				$switched_membership["id"] == $added_membership_id &&
				$switched_membership != $added_membership &&
				$switched_membership["subscription_id"] &&
				$order["items"][0]["item_id"] == $membership_item_2_id &&
				$switched_membership["order_id"] == $order["id"]
				): ?>
			<div class="testpassed"><p>Member::switchMembership – from no subscription to subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::switchMembership – from no subscription to subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete membership item 1
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);
			
			// delete membership item 2 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id AND order_id = ".$order["id"];
			$query->sql($sql);

			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);
	
			// delete order
			$order_no = $order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$order_no'";
			$query->sql($sql);
		}
		switchMembership_fromNoSubscriptionToSubscription_returnOrderAddSubscriptionUpdateMembership();
		?>
		<? 	
		function switchMembership_fromSubscriptionToSubscription_returnOrderUpdateSubscriptionUpdateMembership() {
			
			// switchMembership – from no subscription to subscription
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item 1";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);

			// add subscription method to first membership item
			$_POST["item_subscription_method"] = 1;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);

			// add price to first membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create membership and subscription
			$added_membership_cart_reference = $SC->addToNewInternalCart($membership_item_1_id)["cart_reference"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_reference]);
			
			// create another test membership item
			$_POST["name"] = "Membership Test item 2";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);
	
			// add subscription method to second membership item
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_2_id));
			unset($_POST);
			
			// add price to second membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
			
			$added_membership = $MC->getMembership($membership_item_1_id);
			$added_membership_id = $added_membership["id"];
	
			// ACT 
			$order = $MC->switchMembership($membership_item_2_id);
			$switched_membership = $MC->getMembership();
			
			// ASSERT 
			if(
				$order && 
				$switched_membership &&
				$switched_membership["id"] == $added_membership_id &&
				$added_membership["subscription_id"] &&
				$switched_membership["subscription_id"] &&
				$switched_membership != $added_membership &&
				$order["items"][0]["item_id"] == $membership_item_2_id &&
				$switched_membership["order_id"] == $order["id"]
				): ?>
			<div class="testpassed"><p>Member::switchMembership – from one subscription to another subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::switchMembership – from one subscription to another subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
			
			// delete membership item 1 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_1_id";
			$query->sql($sql);
			
			// delete membership item 1
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);

			// delete membership 1 order
			$added_membership_order_no = $added_membership_order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$added_membership_order_no'";
			$query->sql($sql);
			
			// delete membership item 2 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id AND order_id = ".$order["id"];
			$query->sql($sql);
			
			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);
			
			// delete order
			$order_no = $order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$order_no'";
			$query->sql($sql);
		}
		switchMembership_fromSubscriptionToSubscription_returnOrderUpdateSubscriptionUpdateMembership();
		?>
		<? 	
		function switchMembership_fromSubscriptionToNoSubscription_returnOrderRemoveSubscriptionUpdateMembership() {
			
			// switchMembership – from subscription to no subscription
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item 1";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);

			// add subscription method to first membership item
			$_POST["item_subscription_method"] = 1;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);

			// add price to first membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create membership and subscription
			$added_membership_cart_reference = $SC->addToNewInternalCart($membership_item_1_id)["cart_reference"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_reference]);
			
			$added_membership = $MC->getMembership();
			$added_membership_id = $added_membership["id"];
			$added_membership_subscription_id = $added_membership["subscription_id"];
			
			// create another test membership item
			$_POST["name"] = "Membership Test item 2";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);

			// add price to second membership item
			$_POST["item_price"] = 0;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
	
			// ACT 
			$switched_membership_order = $MC->switchMembership($membership_item_2_id);
			$switched_membership = $MC->getMembership();
			
			// ASSERT 
			if(
				$switched_membership_order && 
				$switched_membership &&
				$switched_membership["id"] == $added_membership_id &&
				$added_membership_subscription_id &&
				!$SubscriptionClass->getSubscriptions(["subscription_id" => $added_membership_subscription_id]) &&
				!$switched_membership["subscription_id"] &&
				$switched_membership_order["items"][0]["item_id"] == $membership_item_2_id &&
				$switched_membership["order_id"] === false
				): ?>
			<div class="testpassed"><p>Member::switchMembership – from subscription to no subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::switchMembership – from subscription to no subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
			
			// delete membership item 1 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_1_id";
			$query->sql($sql);
			
			// delete membership item 1
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);

			// delete membership 1 order
			$added_membership_order_no = $added_membership_order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$added_membership_order_no'";
			$query->sql($sql);
			
			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);
			
			// delete membership 2 order
			$switched_membership_order_no = $switched_membership_order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$switched_membership_order_no'";
			$query->sql($sql);
		}
		switchMembership_fromSubscriptionToNoSubscription_returnOrderRemoveSubscriptionUpdateMembership();
		?>
		<? 
		function switchMembership_noMembershipExists_returnFalse() {
			// switchMembership – no membership exists
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// ACT 
			$switched_membership = $MC->switchMembership($membership_item_id);
			
			// ASSERT 
			if(
				$switched_membership === false
				): ?>
			<div class="testpassed"><p>Member::switchMembership – no membership exists (should return false) – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::switchMembership – no membership exists (should return false) – error</p></div>
			<? endif; 
			
			// CLEAN UP 

			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		switchMembership_noMembershipExists_returnFalse();
		?>
	</div>


	<div class="tests">
		<h3>upgradeMembership</h3>
		<? 	
		function upgradeMembership_toMoreExpensiveSubscription_returnTrueUpgradeMembership() {
			
			// upgradeMembership – to more expensive subscription
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create first test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item 1";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);

			// add subscription method to first membership item
			$_POST["item_subscription_method"] = 1;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);
			
			// add price to first membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create second test membership item
			$_POST["name"] = "Membership Test item 2";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);

			// add subscription method to second membership item
			$_POST["item_subscription_method"] = 1;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_2_id));
			unset($_POST);
			
			// add price to second membership item
			$_POST["item_price"] = 300;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);

			// create cart and order for first membership item 
			// TypeMembership::ordered will call Member::addMembership 
			$cart = $SC->addToNewInternalCart($membership_item_1_id);
			$existing_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
			
			$existing_membership = $MC->getMembership();
			$existing_membership_id = $existing_membership["id"];
	
			// ACT 
			$upgrade_success = $MC->upgradeMembership($membership_item_2_id);
			$upgraded_membership = $MC->getMembership();
			
			// ASSERT 
			if(
				$upgrade_success && 
				$upgraded_membership &&
				$upgraded_membership["id"] == $existing_membership_id &&
				$upgraded_membership != $existing_membership &&
				$existing_membership["subscription_id"] &&
				$upgraded_membership["subscription_id"] &&
				$upgraded_membership["order"]["items"][0]["item_id"] == $membership_item_2_id
				): ?>
			<div class="testpassed"><p>Member::upgradeMembership – to more expensive subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::upgradeMembership – to more expensive subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$existing_membership_id = $existing_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $existing_membership_id";
			$query->sql($sql);

			// delete membership item 1 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_1_id";
			$query->sql($sql);
	
			// delete membership item 1
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);

			// delete membership 1 order
			$existing_membership_order_no = $existing_membership_order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$existing_membership_order_no'";
			$query->sql($sql);
	
			// delete membership item 2 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id";
			$query->sql($sql);

			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);
	

			// delete membership 2 order
			$upgraded_membership_order_no = $upgraded_membership["order"]["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$upgraded_membership_order_no'";
			$query->sql($sql);
		}
		upgradeMembership_toMoreExpensiveSubscription_returnTrueUpgradeMembership();
		?>
		<? 	
		function upgradeMembership_toCheaperSubscription_returnFalse() {
			
			// upgradeMembership – to cheaper subscription (should return false)
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create first test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item 1";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);

			// add subscription method to first membership item
			$_POST["item_subscription_method"] = 1;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);
			
			// add price to first membership item
			$_POST["item_price"] = 300;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create second test membership item
			$_POST["name"] = "Membership Test item 2";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);

			// add subscription method to second membership item
			$_POST["item_subscription_method"] = 1;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_2_id));
			unset($_POST);
			
			// add price to second membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);

			// create cart and order for first membership item 
			// TypeMembership::ordered will call Member::addMembership 
			$cart = $SC->addToNewInternalCart($membership_item_1_id);
			$existing_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
			
			$existing_membership = $MC->getMembership();
			$existing_membership_id = $existing_membership["id"];
	
			// ACT 
			$upgrade_success = $MC->upgradeMembership($membership_item_2_id);
			
			// ASSERT 
			if(
				$existing_membership_id &&
				$upgrade_success === false
				): ?>
			<div class="testpassed"><p>Member::upgradeMembership – to cheaper subscription (should return false) – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::upgradeMembership – to cheaper subscription (should return false) – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$existing_membership_id = $existing_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $existing_membership_id";
			$query->sql($sql);

			// delete membership item 1 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_1_id";
			$query->sql($sql);
	
			// delete membership item 1
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);

			// delete membership 1 order
			$existing_membership_order_no = $existing_membership_order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$existing_membership_order_no'";
			$query->sql($sql);
	
			// delete membership item 2 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id";
			$query->sql($sql);

			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);
	
		}
		upgradeMembership_toCheaperSubscription_returnFalse();
		?>
		<? 	
		function upgradeMembership_existingMembershipHasNoSubscription_returnFalse() {
			
			// upgradeMembership – existing membership has no subscription (should return false)
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create first test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item 1";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);
			
			// add price to first membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create second test membership item
			$_POST["name"] = "Membership Test item 2";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);

			// add subscription method to second membership item
			$_POST["item_subscription_method"] = 1;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_2_id));
			unset($_POST);
			
			// add price to second membership item
			$_POST["item_price"] = 300;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);

			// create cart and order for first membership item 
			// TypeMembership::ordered will call Member::addMembership 
			$cart = $SC->addToNewInternalCart($membership_item_1_id);
			$existing_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
			
			$existing_membership = $MC->getMembership();
			$existing_membership_id = $existing_membership["id"];
	
			// ACT 
			$upgrade_success = $MC->upgradeMembership($membership_item_2_id);
			
			// ASSERT 
			if(
				$existing_membership &&
				$existing_membership["order"] === false &&
				$upgrade_success === false
				): ?>
			<div class="testpassed"><p>Member::upgradeMembership – existing membership has no subscription (should return false) – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::upgradeMembership – existing membership has no subscription (should return false) – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$existing_membership_id = $existing_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $existing_membership_id";
			$query->sql($sql);

			// delete membership item 1 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_1_id";
			$query->sql($sql);
	
			// delete membership item 1
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);

			// delete membership 1 order
			$existing_membership_order_no = $existing_membership_order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$existing_membership_order_no'";
			$query->sql($sql);
	
			// delete membership item 2 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id";
			$query->sql($sql);

			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);

		}
		upgradeMembership_existingMembershipHasNoSubscription_returnFalse();
		?>
		<? 	
		function upgradeMembership_newMembershipHasNoSubscription_returnTrueUpgradeMembershipInheritSubscriptionDeleteExpiry() {
			
			// upgradeMembership – new membership has no subscription (upgraded membership should inherit subscription and delete expiry_at)
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create first test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item 1";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);

			// add subscription method to first membership item
			$_POST["item_subscription_method"] = 1;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);
			
			// add price to first membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create second test membership item
			$_POST["name"] = "Membership Test item 2";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);

			// add price to second membership item
			$_POST["item_price"] = 300;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);

			// create cart and order for first membership item 
			// TypeMembership::ordered will call Member::addMembership 
			$cart = $SC->addToNewInternalCart($membership_item_1_id);
			$existing_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
			
			$existing_membership = $MC->getMembership();
			$existing_membership_id = $existing_membership["id"];
	
			// ACT 
			$upgrade_success = $MC->upgradeMembership($membership_item_2_id);
			$upgraded_membership = $MC->getMembership();
			
			// ASSERT 
			if(
				$existing_membership &&
				$upgrade_success === true &&
				$upgraded_membership["id"] == $existing_membership_id &&
				$upgraded_membership["subscription_id"] == $existing_membership["subscription_id"] &&
				$upgraded_membership["expires_at"] === NULL 
				): ?>
			<div class="testpassed"><p>Member::upgradeMembership – new membership has no subscription (upgraded membership should inherit subscription and delete expiry_at) – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::upgradeMembership – new membership has no subscription (upgraded membership should inherit subscription and delete expiry_at) – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$existing_membership_id = $existing_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $existing_membership_id";
			$query->sql($sql);

			// delete membership item 1 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_1_id";
			$query->sql($sql);
	
			// delete membership item 1
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);

			// delete membership 1 order
			$existing_membership_order_no = $existing_membership_order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$existing_membership_order_no'";
			$query->sql($sql);
	
			// delete membership item 2 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id";
			$query->sql($sql);

			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);

		}
		upgradeMembership_newMembershipHasNoSubscription_returnTrueUpgradeMembershipInheritSubscriptionDeleteExpiry();
		?>
	</div>


</div>
