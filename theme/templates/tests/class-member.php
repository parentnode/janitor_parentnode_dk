<div class="scene i:scene tests">
	<h1>Member</h1>	
	<h2>Testing Member class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>addNewMembership</h3>

		<? function addNewMembership_correctAction_returnOrder() {
			// addNewMembership – with correct $action – should return order object
			
			// ARRANGE
			$MC = new Member();
			$SubscriptionClass = new Subscription();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// ACT 
			$_POST["item_id"] = $membership_item_id;
			$added_membership_order = $MC->addNewMembership(["addNewMembership"]);
			$added_membership_order_id = $added_membership_order["id"];
			unset($_POST);
			
			
			// ASSERT 
			if(
				$added_membership_order &&
				$added_membership_order["items"][0]["item_id"] == $membership_item_id
	
				): ?>
			<div class="testpassed"><p>SuperMember::addNewMembership – with correct $action – should return order object – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addNewMembership – with correct $action – should return order object – error</p></div>
			<? endif;

			// CLEAN UP
			// delete memberships
			$added_membership = $MC->getMembership();
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id IN ($added_membership_id)";
			$query->sql($sql);

			// delete subscriptions
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN ($membership_item_id)";
			$query->sql($sql);
	
			// delete membership items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($membership_item_id)";
			$query->sql($sql);
			
			// delete orders
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN ($added_membership_order_id)";
			$query->sql($sql);

			
			
		}
		addNewMembership_correctAction_returnOrder();
		?>
		<? function addNewMembership_noUserIdSent_returnFalse() {
			// addNewMembership – no user_id in $action – should return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// ACT 
			$_POST["item_id"] = $membership_item_id;
			$added_membership_order = $MC->addNewMembership(["addNewMembership"]);
			unset($_POST);
			
			
			// ASSERT 
			if(
				$added_membership_order === false
				): ?>
			<div class="testpassed"><p>SuperMember::addNewMembership – no user_id in $action – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addNewMembership – no user_id in $action – should return false – error</p></div>
			<? endif;

			// CLEAN UP
	
			// delete membership items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($membership_item_id)";
			$query->sql($sql);
			
		}
		// addNewMembership_noUserIdSent_returnFalse();
		?>
		<? function addNewMembership_invalidUserIdSent_returnFalse() {
			// addNewMembership – invalid user_id in $action – should return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// ACT 
			$_POST["item_id"] = $membership_item_id;
			$added_membership_order = $MC->addNewMembership(["addNewMembership", "invalid_id"]);
			unset($_POST);
			
			
			// ASSERT 
			if(
				$added_membership_order === false
				): ?>
			<div class="testpassed"><p>SuperMember::addNewMembership – invalid user_id in $action – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addNewMembership – invalid user_id in $action – should return false – error</p></div>
			<? endif;

			// CLEAN UP
	
			// delete membership items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($membership_item_id)";
			$query->sql($sql);
			
		}
		// addNewMembership_invalidUserIdSent_returnFalse();
		?>
		<? function addNewMembership_validButNonexistingUserId_returnFalse() {
			// addNewMembership – valid but non-existing user_id in $action – should return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// ACT 
			$_POST["item_id"] = $membership_item_id;
			$added_membership_order = $MC->addNewMembership(["addNewMembership", 9999]);
			unset($_POST);
			
			
			// ASSERT 
			if(
				$added_membership_order === false
				): ?>
			<div class="testpassed"><p>SuperMember::addNewMembership – valid but non-existing user_id in $action – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addNewMembership – valid but non-existing user_id in $action – should return false – error</p></div>
			<? endif;

			// CLEAN UP
	
			// delete membership items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($membership_item_id)";
			$query->sql($sql);
		}
		// addNewMembership_validButNonexistingUserId_returnFalse();
		?>
		
	</div>

	<div class="tests">
		<h3>addMembership</h3>		
		<? function addMembership_nonexistingSubscription_returnFalse() {

			// addMembership – non-existing subscription
	
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
			$added_membership = $MC->addMembership($membership_item["id"], 999);
			
			// ASSERT 
			if(
				$added_membership === false
				): ?>
			<div class="testpassed"><p>Member::addMembership – non-existing subscription – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::addMembership – non-existing subscription – should return false – error</p></div>
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
		addMembership_nonexistingSubscription_returnFalse(); 
		?>
		<? function addMembership_withSubscriptionNoPrice_returnMembershipWithSubscriptionId() {

			// addMembership – with subscription and no price
	
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

			// update test item subscription method
			$_POST["item_subscription_method"] = 1;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			$_POST["item_id"] = $membership_item_id;
			$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);
			$subscription_id = $subscription["id"];
	
			// ACT 
			$added_membership = $MC->addMembership($membership_item["id"], $subscription_id);
			
			// ASSERT 
			if(
				$added_membership &&
				$added_membership["id"] &&
				$added_membership["user_id"] == session()->value("user_id")
				): ?>
			<div class="testpassed"><p>Member::addMembership – with subscription and no price – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::addMembership – with subscription and no price – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		addMembership_withSubscriptionNoPrice_returnMembershipWithSubscriptionId(); 
		?>			
		<? 	
		function addMembership_withSubscriptionWithPrice_returnMembershipWithSubscriptionId() {
			
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
			
			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 999;
			$_POST["item_price_type"] = "default";
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
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
				
				// add user_id to order
				$user_id = session()->value("user_id");
				$sql = "UPDATE ".SITE_DB.".shop_orders SET user_id = '$user_id' WHERE id = '$order_id'";
				$query->sql($sql);
			}

			// create order item for test order
			$sql = "INSERT INTO ".SITE_DB.".shop_order_items (order_id, item_id, name, quantity, unit_price, unit_vat, total_price, total_vat) VALUES ($order_id, $membership_item_id, 'test order item', 1, 100, 0, 100, 0)";
			$query->sql($sql);
		
			$_POST["item_id"] = $membership_item_id;
			$_POST["order_id"] = $order_id;
			$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);
			$subscription_id = $subscription["id"];
	
			// ACT 
			$added_membership = $MC->addMembership($membership_item["id"], $subscription_id);
			
			// ASSERT 
			if(
				$added_membership &&
				$added_membership["id"] &&
				$added_membership["user_id"] == session()->value("user_id") &&
				$added_membership["subscription_id"] == $subscription_id &&
				$added_membership["item_id"] == $membership_item["id"] &&
				$added_membership["order_id"] == $order_id
	
				): ?>
			<div class="testpassed"><p>Member::addMembership – with subscription and price – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::addMembership – with subscription and price – error</p></div>
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
		addMembership_withSubscriptionWithPrice_returnMembershipWithSubscriptionId(); 
		?>
		<? 
		function addMembership_membershipAlreadyExists_returnFalse() {
			// addMembership – membership already exists – should return false
			
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

			// update test item subscription method
			$_POST["item_subscription_method"] = 3;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			$_POST["item_id"] = $membership_item_id;
			$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);
			$subscription_id = $subscription["id"];
	
			$added_membership = $MC->addMembership($membership_item["id"], $subscription_id);
	
			
			// ACT 
			$repeated_membership = $MC->addMembership($membership_item["id"], $subscription_id);
			
			// ASSERT 
			if(
				!$repeated_membership
				): ?>
			<div class="testpassed"><p>Member::addMembership – membership already exists – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::addMembership – membership already exists – should return false – error</p></div>
			<? endif;
				
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}	
		addMembership_membershipAlreadyExists_returnFalse(); 
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
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 3;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			$_POST["item_id"] = $membership_item_id;
			$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);
			$subscription_id = $subscription["id"];

			$added_membership = $MC->addMembership($membership_item_id, $subscription_id);
			
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

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
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
			<div class="testpassed"><p>Member::getMembership – no membership exists – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::getMembership – no membership exists – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 
		}
		getMembership_noMembershipExists_returnFalse();
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

			// update test item subscription method
			$_POST["item_subscription_method"] = 3;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			$_POST["item_id"] = $membership_item_id;
			$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);
			$subscription_id = $subscription["id"];
	
			$added_membership = $MC->addMembership($membership_item["id"], $subscription_id);
			$added_membership_id = $added_membership["id"];
	
			$cancellation_success = false;
	
			// ACT 
			
			$cancellation_success = $MC->cancelMembership(["cancelMembership", $added_membership_id]);
			
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

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		cancelMembership_membershipExists_membershipIsCancelled();
		?>
		<? 	
		function cancelMembership_membershipInvalid_returnFalse() {
			// cancelMembership – invalid membership – should return false
				
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// ACT 
				$cancellation_success = $MC->cancelMembership(["cancelMembership", 9999]);

			
			
			// ASSERT 
			if(
				$cancellation_success === false
				): ?>
			<div class="testpassed"><p>Member::cancelMembership – invalid membership – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::cancelMembership – invalid membership – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP


		}
		cancelMembership_membershipInvalid_returnFalse();
		?>
	</div>


	<div class="tests">
		<h3>switchMembership</h3>
		<? 	
		function switchMembership_fromNoSubscriptionToSubscription_returnOrderAddSubscriptionUpdateMembership() {
			
			// switchMembership (inactive membership) – from no subscription to subscription
			
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
			
			// cancel membership 1 
			$MC->cancelMembership(["cancelMembership", $added_membership_id]);
			$added_membership = $MC->getMembership();

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
			
			
			// ACT 
			$_POST["item_id"] = $membership_item_2_id;
			$order = $MC->switchMembership(["switchMembership"]);
			$switched_membership = $MC->getMembership();
			unset($_POST);
			
			// ASSERT 
			if(
				$order && 
				$switched_membership &&
				$switched_membership["id"] == $added_membership_id &&
				$switched_membership != $added_membership &&
				!$added_membership["subscription_id"] &&
				$switched_membership["subscription_id"] &&
				$order["items"][0]["item_id"] == $membership_item_2_id &&
				$switched_membership["order_id"] == $order["id"]
				): ?>
			<div class="testpassed"><p>Member::switchMembership – from no subscription (inactive membership) to subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::switchMembership – from no subscription (inactive membership) to subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership["id"];
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
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
		switchMembership_fromNoSubscriptionToSubscription_returnOrderAddSubscriptionUpdateMembership();
		?>
		<? 	
		function switchMembership_fromSubscriptionToSubscription_returnOrderUpdateSubscriptionUpdateMembership() {
			
			// switchMembership – from one subscription to another subscription
			
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

			$_POST["item_id"] = $membership_item_1_id;
			$added_membership_order = $MC->addNewMembership(["addNewMembership"]);
			$added_membership = $MC->getMembership();
			$added_membership_id = $added_membership["id"];
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
			
			
			// ACT 
			$_POST["item_id"] = $membership_item_2_id;
			$order = $MC->switchMembership(["switchMembership"]);
			$switched_membership = $MC->getMembership();
			unset($_POST);
			
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
			$added_membership_order_id = $added_membership_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = '$added_membership_order_id'";
			$query->sql($sql);
			
			// delete membership item 2 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id AND order_id = ".$order["id"];
			$query->sql($sql);
			
			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);
			
			// delete order
			$order_id = $order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = '$order_id'";
			$query->sql($sql);
		}
		switchMembership_fromSubscriptionToSubscription_returnOrderUpdateSubscriptionUpdateMembership();
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
			$_POST["item_id"] = $membership_item_id;
			$order = $MC->switchMembership(["switchMembership"]);
			unset($_POST);
			
			// ASSERT 
			if(
				$order === false
				): ?>
			<div class="testpassed"><p>Member::switchMembership – no membership exists – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::switchMembership – no membership exists – should return false – error</p></div>
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

			// update test item subscription method
			$_POST["item_subscription_method"] = 3;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			$_POST["item_id"] = $membership_item_id;
			$subscription = $SubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);
			$subscription_id = $subscription["id"];
	
			$added_membership = $MC->addMembership($membership_item["id"], $subscription_id);
			
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

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);	
		}
		updateMembership_noChanges_returnUpdatedMembership();
		?>
		<? 	
		function updateMembership_addSubscriptionId_returnUpdatedMembership() {
			// updateMembership – add subscription_id
			
			// ARRANGE
			$MC = new Member();
			$query = new Query();
			$IC = new Items();
			$SC = new Shop();
			$SubscriptionClass = new Subscription();
			
			// create first test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
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
	
			// update first membership item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);
	
			// create membership and subscription
			$added_membership_cart_reference = $SC->addToNewInternalCart($membership_item_1_id)["cart_reference"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_reference]);
			$added_membership = $MC->getMembership();
			$added_membership_id = $added_membership["id"];
			
			// cancel membership 1 (remove subscription_id)
			$MC->cancelMembership(["cancelMembership",$added_membership_id]);
			$added_membership = $MC->getMembership();

			// create second test membership item
			$model_membership = $IC->TypeObject("membership");
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
	
			// update second membership item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_2_id));
			unset($_POST);
	
			// create test order for second membership item
			$order_no = $SC->getNewOrderNumber();
			$sql = "SELECT id FROM ".SITE_DB.".shop_orders WHERE order_no = '$order_no'";
			if($query->sql($sql)) {
				$order_2_id = $query->result(0, "id");

				// add user_id to order
				$user_id = session()->value("user_id");
				$sql = "UPDATE ".SITE_DB.".shop_orders SET user_id = '$user_id' WHERE id = '$order_2_id'";
				$query->sql($sql);
			}

			// create order item for test order for second membership item
			$sql = "INSERT INTO ".SITE_DB.".shop_order_items (order_id, item_id, name, quantity, unit_price, unit_vat, total_price, total_vat) VALUES ($order_2_id, $membership_item_2_id, 'test order item', 1, 100, 0, 100, 0)";
			$query->sql($sql);
	
			$_POST["item_id"] = $membership_item_2_id;
			$_POST["order_id"] = $order_2_id;
			$subscription_2 = $SubscriptionClass->addSubscription(["addSubscription"]);
			unset($_POST);
			$subscription_2_id = $subscription_2["id"];
	
			
			// ACT 
			$updated_membership = $MC->updateMembership(["subscription_id" => $subscription_2_id]);
			
			// ASSERT 
			if(
				$updated_membership &&
				$updated_membership["user_id"] == session()->value("user_id") &&
				$updated_membership["id"] == $added_membership["id"] &&
				!isset($added_membership["subscription_id"]) &&
				$updated_membership["subscription_id"] == $subscription_2_id
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
	
			// delete first membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);	
	
			// delete order 1
			$added_membership_order_id = $added_membership_order["id"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_membership_order_id";
			$query->sql($sql);
	
			// delete subscription for second membership
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id AND order_id = $order_2_id";
			$query->sql($sql);
	
			// delete second membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);	
	
			// delete order 2
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_2_id";
			$query->sql($sql);

		}
		updateMembership_addSubscriptionId_returnUpdatedMembership();
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
			<div class="testpassed"><p>Member::updateMembership – no membership exists – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::updateMembership – no membership exists – should return false – error</p></div>
			<? endif;
			
			// CLEAN UP
		}
		updateMembership_noMembershipExists_returnFalse();
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
			$_POST["item_id"] = $membership_item_2_id;
			$upgrade_success = $MC->upgradeMembership(["upgradeMembership"]);
			unset($_POST);
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
			
			// upgradeMembership – to cheaper subscription – should return false
			
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
			$_POST["item_id"] = $membership_item_2_id;
			$upgrade_success = $MC->upgradeMembership(["upgradeMembership"]);
			unset($_POST);
			
			// ASSERT 
			if(
				$existing_membership_id &&
				$upgrade_success === false
				): ?>
			<div class="testpassed"><p>Member::upgradeMembership – to cheaper subscription – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::upgradeMembership – to cheaper subscription – should return false – error</p></div>
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
			
			// upgradeMembership – existing membership is inactive/has no subscription – should return false
			
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

			// cancel membership 1 (remove subscription_id)
			$MC->cancelMembership(["cancelMembership", $existing_membership_id]);
			$existing_membership = $MC->getMembership();
	
			// ACT 
			$_POST["item_id"] = $membership_item_2_id;
			$upgrade_success = $MC->upgradeMembership(["upgradeMembership"]);
			unset($_POST);
			
			// ASSERT 
			if(
				$existing_membership &&
				$existing_membership["order"] === false &&
				$upgrade_success === false
				): ?>
			<div class="testpassed"><p>Member::upgradeMembership – existing membership is inactive/has no subscription – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Member::upgradeMembership – existing membership is inactive/has no subscription – should return false – error</p></div>
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
	</div>


</div>
