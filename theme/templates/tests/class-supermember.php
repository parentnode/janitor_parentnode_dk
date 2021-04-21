<div class="scene i:scene tests">
	<h1>SuperMember</h1>	
	<h2>Testing SuperMember class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>
	<div class="tests">
		<h3>addNewMembership</h3>

		<? function addNewMembership_correctAction_returnOrder() {
			// addNewMembership – with correct $action – should return order object
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			include_once("classes/shop/supershop.class.php");
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// ACT 
			$_POST["item_id"] = $membership_item_id;
			$added_membership_order = $MC->addNewMembership(["addNewMembership", $test_user_id]);
			$added_membership_order_id = $added_membership_order ? $added_membership_order["id"] : false;
			unset($_POST);
			
			
			// ASSERT 
			if(
				$added_membership_order &&
				$added_membership_order["user_id"] == $test_user_id &&
				$added_membership_order["items"][0]["item_id"] == $membership_item_id
	
				): ?>
			<div class="testpassed"><p>SuperMember::addNewMembership – with correct $action – should return order object – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addNewMembership – with correct $action – should return order object – error</p></div>
			<? endif;

			// CLEAN UP
			// delete memberships
			$added_membership = $MC->getMembers(["user_id" => $test_user_id]);
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
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
			
			// delete users
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id IN ($test_user_id)";
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
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
		addNewMembership_noUserIdSent_returnFalse();
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
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
		addNewMembership_invalidUserIdSent_returnFalse();
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
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
		addNewMembership_validButNonexistingUserId_returnFalse();
		?>
		
	</div>
	<div class="tests">
		<h3>addMembership</h3>	

		<? function addMembership_nonexistingSubscription_returnFalse() {

			// addMembership – non-existing subscription
	
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			include_once("classes/shop/supershop.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();

			$user_id = session()->value("user_id");


			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);
	
			// ACT 
			$added_membership = $MC->addMembership($membership_item["id"], 999, ["user_id" => $user_id]);
			
			// ASSERT 
			if(
				$added_membership === false
				): ?>
			<div class="testpassed"><p>SuperMember::addMembership – non-existing subscription – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addMembership – non-existing subscription – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		addMembership_nonexistingSubscription_returnFalse(); 
		?>
		<? 
		function addMembership_noUserIdSent_returnFalse() {
			// addMembership – no user_id sent
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
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
			$_POST["user_id"] = $user_id;
			$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
			$subscription_id = $subscription ? $subscription["id"] : false;
			unset($_POST);

			// ACT 
			$added_membership = $MC->addMembership($membership_item["id"], $subscription_id);
			
			// ASSERT 
			if(
				$added_membership === false
				): ?>
			<div class="testpassed"><p>SuperMember::addMembership – no user_id sent – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addMembership – no user_id sent – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		addMembership_noUserIdSent_returnFalse();
		?>
		<? 
		function addMembership_invalidUserIdSent_returnFalse() {
			// addMembership – invalid user_id sent
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
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
			$_POST["user_id"] = $user_id;
			$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
			$subscription_id = $subscription ? $subscription["id"] : false;
			unset($_POST);

			// ACT 
			$added_membership = $MC->addMembership($membership_item["id"], $subscription_id, ["user_id" => 9999]);
			
			// ASSERT 
			if(
				$added_membership === false
				): ?>
			<div class="testpassed"><p>SuperMember::addMembership – invalid user_id sent – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addMembership – invalid user_id sent – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		addMembership_invalidUserIdSent_returnFalse();
		?>
		<? function addMembership_withSubscriptionNoPrice_returnMembership() {

			// addMembership – with subscription and no price
	
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			include_once("classes/shop/supershop.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();

			$user_id = session()->value("user_id");

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
			$_POST["user_id"] = $user_id;
			$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
			$subscription_id = $subscription ? $subscription["id"] : false;
			unset($_POST);

			// ACT 
			$added_membership = $MC->addMembership($membership_item["id"], $subscription_id, ["user_id" => $user_id]);
			
			// ASSERT 
			if(
				$added_membership &&
				$added_membership["subscription_id"] == $subscription_id &&
				$subscription["item"]["prices"] === false
				): ?>
			<div class="testpassed"><p>SuperMember::addMembership – with subscription and no price – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addMembership – with subscription and no price – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		addMembership_withSubscriptionNoPrice_returnMembership(); 
		?>		
		<? 	
		function addMembership_withSubscriptionWithPrice_returnMembership() {
			
			// addMembership – with subscription and price
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			include_once("classes/shop/supershop.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			$user_id = session()->value("user_id");

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);
	
			// create test order
			$order_no = $SC->getNewOrderNumber();
			$sql = "SELECT * FROM ".SITE_DB.".shop_orders WHERE order_no = '$order_no'";
			if($query->sql($sql)) {
				$order = $query->result(0);
				$order_id = $order ? $order["id"] : false;

				// add user_id to order
				$sql = "UPDATE ".SITE_DB.".shop_orders SET user_id = '$user_id' WHERE id = '$order_id'";
				$query->sql($sql);
			}

			// create order item for test order
			$sql = "INSERT INTO ".SITE_DB.".shop_order_items (order_id, item_id, name, quantity, unit_price, unit_vat, total_price, total_vat) VALUES ($order_id, $membership_item_id, 'test order item', 1, 100, 0, 100, 0)";
			$query->sql($sql);


	
			$_POST["item_id"] = $membership_item_id;
			$_POST["user_id"] = $user_id;
			$_POST["order_id"] = $order_id;
			$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
			$subscription_id = $subscription ? $subscription["id"] : false;
			unset($_POST);
	
			// ACT 
			$added_membership = $MC->addMembership($membership_item["id"], $subscription_id, ["user_id" => $user_id]);
			
			// ASSERT 
			if(
				$added_membership &&
				$added_membership["id"] &&
				$added_membership["user_id"] == $user_id &&
				$added_membership["subscription_id"] == $subscription_id &&
				$added_membership["item_id"] == $membership_item["id"] &&
				$added_membership["order_id"] == $order_id
	
				): ?>
			<div class="testpassed"><p>SuperMember::addMembership – with subscription and price – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addMembership – with subscription and price – error</p></div>
			<? endif;
			
			// CLEAN UP
			$membership_item_id = $membership_item["id"];
			
			// delete membership
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
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
		addMembership_withSubscriptionWithPrice_returnMembership(); 
		?>
		<? 
		function addMembership_membershipAlreadyExists_returnFalse() {
			// addMembership – membership already exists – should return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();

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
			$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
			$subscription_id = $subscription ? $subscription["id"] : false;
			unset($_POST);
			$added_membership = $MC->addMembership($membership_item["id"], $subscription_id);
	
			
			// ACT 
			$repeated_membership = $MC->addMembership($membership_item["id"], $subscription_id);
			
			// ASSERT 
			if(
				!$repeated_membership
				): ?>
			<div class="testpassed"><p>SuperMember::addMembership – membership already exists – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::addMembership – membership already exists – should return false – error</p></div>
			<? endif;
				
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}	
		addMembership_membershipAlreadyExists_returnFalse(); 
		?>
	</div>

	<div class="tests">
		<h3>getMembers</h3>		
		<? 
		function getMembers_byMemberIdMembershipExists_returnMembership() {

			// getMembers by member_id, membership exists
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			include_once("classes/shop/supershop.class.php");
			$SC = new SuperShop();
			
			$user_id = session()->value("user_id");

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// create test order
			$order_no = $SC->getNewOrderNumber();
			$sql = "SELECT * FROM ".SITE_DB.".shop_orders WHERE order_no = '$order_no'";
			if($query->sql($sql)) {
				$order = $query->result(0);
				$order_id = $order ? $order["id"] : false;

				// add user_id to order
				$sql = "UPDATE ".SITE_DB.".shop_orders SET user_id = '$user_id' WHERE id = '$order_id'";
				$query->sql($sql);
			}

			// create order item for test order
			$sql = "INSERT INTO ".SITE_DB.".shop_order_items (order_id, item_id, name, quantity, unit_price, unit_vat, total_price, total_vat) VALUES ($order_id, $membership_item_id, 'test order item', 1, 100, 0, 100, 0)";
			$query->sql($sql);

			$_POST["item_id"] = $membership_item_id;
			$_POST["user_id"] = $user_id;
			$_POST["order_id"] = $order_id;
			$subscription = $SuperSubscriptionClass->addSubscription(["addSubscription"]);
			$subscription_id = $subscription ? $subscription["id"] : false;
			unset($_POST);
	
			$added_membership = $MC->addMembership($membership_item_id, $subscription_id, ["user_id" => $user_id]);
			
			// ACT 
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			$fetched_membership = $MC->getMembers(["member_id" => $added_membership_id]);
			
			// ASSERT 
			if(
				$fetched_membership &&
				$fetched_membership["id"] &&
				$fetched_membership["user_id"] == session()->value("user_id") &&
				$fetched_membership["id"] == $added_membership["id"]
				): ?>
			<div class="testpassed"><p>SuperMember::getMembers – by member_id, membership exists – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMembers – by member_id, membership exists – error</p></div>
			<? endif;
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
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
		getMembers_byMemberIdMembershipExists_returnMembership(); 
		?>	
		<? 
		function getMembers_byMemberIdNoMembershipExists_returnFalse() {
			// getMembers – by wrong member id, no such membership exists
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// ACT 
			$fetched_membership = $MC->getMembers(["member_id" => 9999]);
			
			// ASSERT 
			if(
				$fetched_membership === false
				): ?>
			<div class="testpassed"><p>SuperMember::getMembers – by wrong member id, no such membership exists – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMembers – by wrong member id, no such membership exists – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 
		}
		getMembers_byMemberIdNoMembershipExists_returnFalse();
		?>	
		<? 
		function getMembers_byUserIdMembershipExists_returnMembership() {

			// getMembers by user_id, membership exists
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			$user_id = session()->value("user_id");

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// create membership and subscription
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_id, ["user_id" => $user_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership_order_id = $added_membership_order ? $added_membership_order["id"] : false;
	
			// ACT 
			$fetched_membership = $MC->getMembers(["user_id" => $user_id]);
			
			// ASSERT 
			if(
				$fetched_membership &&
				$fetched_membership["id"] &&
				$fetched_membership["user_id"] == session()->value("user_id")
				): ?>
			<div class="testpassed"><p>SuperMember::getMembers – by user_id, membership exists – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMembers – by user_id, membership exists – error</p></div>
			<? endif;
			
			// CLEAN UP
			// delete membership
			$fetched_membership_id = $fetched_membership ? $fetched_membership["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $fetched_membership_id";
			$query->sql($sql);

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
			
			// delete order
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_membership_order_id";
			$query->sql($sql);
		
		}	
		getMembers_byUserIdMembershipExists_returnMembership(); 
		?>	
		<? 
		function getMembers_byUserIdNoMembershipExists_returnFalse() {
			// getMembers – by wrong user_id, no such membership exists
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// ACT 
			$fetched_membership = $MC->getMembers(["user_id" => 9999]);
			
			// ASSERT 
			if(
				$fetched_membership === false
				): ?>
			<div class="testpassed"><p>SuperMember::getMembers – by wrong user_id, no such membership exists – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMembers – by wrong user_id, no such membership exists – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 
		}
		getMembers_byUserIdNoMembershipExists_returnFalse();
		?>	
		<? 
		function getMembers_byItemIdMembershipExists_returnMembership() {

			// getMembers by item_id, membership exists
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();

			$user_id = session()->value("user_id");

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// create membership and subscription
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_id, ["user_id" => $user_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership_order_id = $added_membership_order ? $added_membership_order["id"] : false;
	
			// ACT 
			$fetched_membership = $MC->getMembers(["item_id" => $membership_item_id]);
			
			// ASSERT 
			if(
				$fetched_membership &&
				$fetched_membership[0]["id"] &&
				$fetched_membership[0]["user_id"] == session()->value("user_id")
				): ?>
			<div class="testpassed"><p>SuperMember::getMembers – by item_id, membership exists – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMembers – by item_id, membership exists – error</p></div>
			<? endif;
			
			// CLEAN UP
			// delete membership
			$fetched_membership_id = $fetched_membership ? $fetched_membership[0]["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $fetched_membership_id";
			$query->sql($sql);
	
			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
			
			// delete order
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_membership_order_id";
			$query->sql($sql);		
		
		}	
		getMembers_byItemIdMembershipExists_returnMembership(); 
		?>	
		<? 
		function getMembers_byItemIdNoMembershipExists_returnFalse() {
			// getMembers – by wrong item_id, no such membership exists
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			
			// ACT 
			$fetched_membership = $MC->getMembers(["item_id" => 9999]);
			
			// ASSERT 
			if(
				$fetched_membership === false
				): ?>
			<div class="testpassed"><p>SuperMember::getMembers – by wrong item_id, no such membership exists – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMembers – by wrong item_id, no such membership exists – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 
		}
		getMembers_byItemIdNoMembershipExists_returnFalse();
		?>
		<? 
		function getMembers_noParameters_returnAllMemberships() {

			// getMembers by item_id, membership exists
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$model_tests = $IC->typeObject("tests");

			$test_user_1_id = $model_tests->createTestUser();
			$test_user_2_id = $model_tests->createTestUser();

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// create membership and subscription for test_user_1
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_id, ["user_id" => $test_user_1_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership_order_id = $added_membership_order ? $added_membership_order["id"] : false;

			// create membership and subscription for test_user_2
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_id, ["user_id" => $test_user_2_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership_order_id = $added_membership_order ? $added_membership_order["id"] : false;

			$test_user_2_membership = $MC->getMembers(["user_id" => $test_user_2_id]);

			// cancel membership for test_user_2
			$MC->cancelMembership(["cancelMembership", $test_user_2_id, $test_user_2_membership["id"]]);
	
			// ACT 
			$fetched_memberships = $MC->getMembers();
			
			// ASSERT 
			if(
				$fetched_memberships &&
				count($fetched_memberships) == 2 &&
				$fetched_memberships[0]["user_id"] == $test_user_1_id && 
				$fetched_memberships[1]["user_id"] == $test_user_2_id 
				): ?>
			<div class="testpassed"><p>SuperMember::getMembers – no parameters send – return all members – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMembers – no parameters send – return all members – error</p></div>
			<? endif;
			
			// CLEAN UP

			$model_tests->cleanup(["user_id" => $test_user_1_id]);
			$model_tests->cleanup(["user_id" => $test_user_2_id]);
		
		}	
		getMembers_noParameters_returnAllMemberships(); 
		?>
		<? 
		function getMembers_onlyActiveMembers_returnAllActiveMemberships() {

			getMembers by item_id, membership exists
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$model_tests = $IC->typeObject("tests");

			$test_user_1_id = $model_tests->createTestUser();
			$test_user_2_id = $model_tests->createTestUser();

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// create membership and subscription for test_user_1
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_id, ["user_id" => $test_user_1_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership_order_id = $added_membership_order ? $added_membership_order["id"] : false;

			// create membership and subscription for test_user_2
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_id, ["user_id" => $test_user_2_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership_order_id = $added_membership_order ? $added_membership_order["id"] : false;

			$test_user_2_membership = $MC->getMembers(["user_id" => $test_user_2_id]);

			// cancel membership for test_user_2
			$MC->cancelMembership(["cancelMembership", $test_user_2_id, $test_user_2_membership["id"]]);
	
			// ACT 
			$fetched_memberships = $MC->getMembers(["only_active_members" => true]);
			
			// ASSERT 
			if(
				$fetched_memberships &&
				count($fetched_memberships) == 1 &&
				$fetched_memberships[0]["user_id"] == $test_user_1_id
				): ?>
			<div class="testpassed"><p>SuperMember::getMembers – send parameter 'only_active_members' – return all active members – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMembers – send parameter 'only_active_members' – return all active members – error</p></div>
			<? endif;
			
			// CLEAN UP

			$model_tests->cleanup(["user_id" => $test_user_1_id]);
			$model_tests->cleanup(["user_id" => $test_user_2_id]);
		
		}	
		getMembers_onlyActiveMembers_returnAllActiveMemberships(); 
		?>	
	</div>

	<div class="tests">
		<h3>getMemberCount</h3>		
		<? 
		function getMemberCount_noParameters_countAllMembersReturnString() {

			// getMemberCount no parameters, memberships exist – count all memberships, return member count as string
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$UC = new SuperUser();
			
			// create first membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);

			// add price to first membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);
	
			// update subscription method for first membership item
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);

			// create second membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);

			// add price to second membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
	
			// update subscription method for second membership item
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_2_id));
			unset($_POST);

			// create 3 test users
			for($i = 0; $i < 3; $i++) {
				$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user $i', 1, '2019-01-01 00:00:00')";
				if($query->sql($sql)) {
					$test_user_ids[$i] = $query->lastInsertId();
				}
			}

			// create two memberships based on first membership item  
			$membership_1_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $test_user_ids[0]]);
			$membership_1_cart_reference = $membership_1_cart["cart_reference"];
			$membership_1_cart_id = $membership_1_cart["id"];
			$membership_1_order = $SC->newOrderFromCart(["newOrderFromCart", $membership_1_cart_id, $membership_1_cart_reference]);
			$membership_1_order_id = $membership_1_order["id"];
			$membership_1 = $MC->getMembers(["user_id" => $test_user_ids[0]]);
			$membership_1_id = $membership_1 ? $membership_1["id"] : false;

			$membership_2_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $test_user_ids[1]]);
			$membership_2_cart_reference = $membership_2_cart["cart_reference"];
			$membership_2_cart_id = $membership_2_cart["id"];
			$membership_2_order = $SC->newOrderFromCart(["newOrderFromCart", $membership_2_cart_id, $membership_2_cart_reference]);
			$membership_2_order_id = $membership_2_order["id"];
			$membership_2 = $MC->getMembers(["user_id" => $test_user_ids[1]]);
			$membership_2_id = $membership_2 ? $membership_2["id"] : false;

			// create one membership based on second membership item  
			$membership_3_cart = $SC->addToNewInternalCart($membership_item_2_id, ["user_id" => $test_user_ids[2]]);
			$membership_3_cart_reference = $membership_3_cart["cart_reference"];
			$membership_3_cart_id = $membership_3_cart["id"];
			$membership_3_order = $SC->newOrderFromCart(["newOrderFromCart", $membership_3_cart_id, $membership_3_cart_reference]);
			$membership_3_order_id = $membership_3_order["id"];
			$membership_3 = $MC->getMembers(["user_id" => $test_user_ids[2]]);
			$membership_3_id = $membership_3 ? $membership_3["id"] : false;

			
			
			// ACT 
			$member_count = $MC->getMemberCount();
			
			// ASSERT 
			if(
				$member_count &&
				$member_count === "3"
				): ?>
			<div class="testpassed"><p>SuperMember::getMemberCount – no parameters, memberships exist – count all memberships, return member count as string – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMemberCount – no parameters, memberships exist – count all memberships, return member count as string – error</p></div>
			<? endif;
			
			// CLEAN UP
			// delete memberships
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id IN ($membership_1_id, $membership_2_id, $membership_3_id)";
			$query->sql($sql);

			// delete subscriptions
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN ($membership_item_1_id, $membership_item_2_id)";
			$query->sql($sql);
	
			// delete membership items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($membership_item_1_id, $membership_item_2_id)";
			$query->sql($sql);
			
			// delete orders
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN ($membership_1_order_id, $membership_2_order_id, $membership_3_order_id)";
			$query->sql($sql);

			// delete users
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id IN (".$test_user_ids[0].", ".$test_user_ids[1].", ".$test_user_ids[2].")";
			$query->sql($sql);
		
		}	
		getMemberCount_noParameters_countAllMembersReturnString(); 
		?>
		<? 
		function getMemberCount_noParametersNoMemberships_returnZero() {

			// getMemberCount no parameters, no memberships exist – return "0"
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();

			
			// ACT 
			$member_count = $MC->getMemberCount();
			
			// ASSERT 
			if(
				$member_count === "0"
				): ?>
			<div class="testpassed"><p>SuperMember::getMemberCount – no parameters, no memberships exist – return "0" – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMemberCount – no parameters, no memberships exist – return "0" – error</p></div>
			<? endif;
			
			// CLEAN UP
		
		}	
		getMemberCount_noParametersNoMemberships_returnZero(); 
		?>
		<?
		function getMemberCount_byItemId_countMembersWithMembertypeReturnString() {
			// getMemberCount no parameters, memberships exist – count all memberships, return member count as string
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$UC = new SuperUser();
			
			// create first membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);

			// add price to first membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);
	
			// update subscription method for first membership item
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);

			// create second membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);

			// add price to second membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
	
			// update subscription method for second membership item
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_2_id));
			unset($_POST);

			// create 3 test users
			for($i = 0; $i < 3; $i++) {
				$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user $i', 1, '2019-01-01 00:00:00')";
				if($query->sql($sql)) {
					$test_user_ids[$i] = $query->lastInsertId();
				}
			}

			// create two memberships based on first membership item  
			$membership_1_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $test_user_ids[0]]);
			$membership_1_cart_reference = $membership_1_cart["cart_reference"];
			$membership_1_cart_id = $membership_1_cart["id"];
			$membership_1_order = $SC->newOrderFromCart(["newOrderFromCart", $membership_1_cart_id, $membership_1_cart_reference]);
			$membership_1_order_id = $membership_1_order["id"];
			$membership_1 = $MC->getMembers(["user_id" => $test_user_ids[0]]);
			$membership_1_id = $membership_1 ? $membership_1["id"] : false;

			$membership_2_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $test_user_ids[1]]);
			$membership_2_cart_reference = $membership_2_cart["cart_reference"];
			$membership_2_cart_id = $membership_2_cart["id"];
			$membership_2_order = $SC->newOrderFromCart(["newOrderFromCart", $membership_2_cart_id, $membership_2_cart_reference]);
			$membership_2_order_id = $membership_2_order["id"];
			$membership_2 = $MC->getMembers(["user_id" => $test_user_ids[1]]);
			$membership_2_id = $membership_2 ? $membership_2["id"] : false;

			// create one membership based on second membership item  
			$membership_3_cart = $SC->addToNewInternalCart($membership_item_2_id, ["user_id" => $test_user_ids[2]]);
			$membership_3_cart_reference = $membership_3_cart["cart_reference"];
			$membership_3_cart_id = $membership_3_cart["id"];
			$membership_3_order = $SC->newOrderFromCart(["newOrderFromCart", $membership_3_cart_id, $membership_3_cart_reference]);
			$membership_3_order_id = $membership_3_order["id"];
			$membership_3 = $MC->getMembers(["user_id" => $test_user_ids[2]]);
			$membership_3_id = $membership_3 ? $membership_3["id"] : false;

			
			
			// ACT 
			$member_count = $MC->getMemberCount(["item_id" => $membership_item_1_id]);
			
			// ASSERT 
			if(
				$member_count &&
				$member_count === "2"
				): ?>
			<div class="testpassed"><p>SuperMember::getMemberCount – no parameters, memberships exist – count all memberships, return member count as string – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMemberCount – no parameters, memberships exist – count all memberships, return member count as string – error</p></div>
			<? endif;
			
			// CLEAN UP
			// delete memberships
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id IN ($membership_1_id, $membership_2_id, $membership_3_id)";
			$query->sql($sql);

			// delete subscriptions
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN ($membership_item_1_id, $membership_item_2_id)";
			$query->sql($sql);
	
			// delete membership items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($membership_item_1_id, $membership_item_2_id)";
			$query->sql($sql);
			
			// delete orders
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN ($membership_1_order_id, $membership_2_order_id, $membership_3_order_id)";
			$query->sql($sql);

			// delete users
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id IN (".$test_user_ids[0].", ".$test_user_ids[1].", ".$test_user_ids[2].")";
			$query->sql($sql);
		}
		getMemberCount_byItemId_countMembersWithMembertypeReturnString();
		?>
		<?
		function getMemberCount_byItemIdNoMemberships_returnZero() {
			// getMemberCount by item_id, no memberships exists – should return "0"
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$UC = new SuperUser();
			
			// create first membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);

			// add price to first membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);
	
			// update subscription method for first membership item
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);

			
			
			// ACT 
			$member_count = $MC->getMemberCount(["item_id" => $membership_item_1_id]);
			
			// ASSERT 
			if(
				$member_count === "0"
				): ?>
			<div class="testpassed"><p>SuperMember::getMemberCount – by item_id, no memberships exists – should return "0" – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMemberCount – by item_id, no memberships exists – should return "0" – error</p></div>
			<? endif;
			
			// CLEAN UP
			// delete membership items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($membership_item_1_id)";
			$query->sql($sql);
			
		}
		getMemberCount_byItemIdNoMemberships_returnZero();
		?>
		<?
		function getMemberCount_byInvalidItemId_returnZero() {
			// getMemberCount by invalid item_id, memberships exist – return "0"
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$UC = new SuperUser();
			
			// create first membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);

			// add price to first membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);
	
			// update subscription method for first membership item
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);

			// create second membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);

			// add price to second membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
	
			// update subscription method for second membership item
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_2_id));
			unset($_POST);

			// create 3 test users
			for($i = 0; $i < 3; $i++) {
				$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user $i', 1, '2019-01-01 00:00:00')";
				if($query->sql($sql)) {
					$test_user_ids[$i] = $query->lastInsertId();
				}
			}

			// create two memberships based on first membership item  
			$membership_1_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $test_user_ids[0]]);
			$membership_1_cart_reference = $membership_1_cart["cart_reference"];
			$membership_1_cart_id = $membership_1_cart["id"];
			$membership_1_order = $SC->newOrderFromCart(["newOrderFromCart", $membership_1_cart_id, $membership_1_cart_reference]);
			$membership_1_order_id = $membership_1_order["id"];
			$membership_1 = $MC->getMembers(["user_id" => $test_user_ids[0]]);
			$membership_1_id = $membership_1 ? $membership_1["id"] : false;

			$membership_2_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $test_user_ids[1]]);
			$membership_2_cart_reference = $membership_2_cart["cart_reference"];
			$membership_2_cart_id = $membership_2_cart["id"];
			$membership_2_order = $SC->newOrderFromCart(["newOrderFromCart", $membership_2_cart_id, $membership_2_cart_reference]);
			$membership_2_order_id = $membership_2_order["id"];
			$membership_2 = $MC->getMembers(["user_id" => $test_user_ids[1]]);
			$membership_2_id = $membership_2 ? $membership_2["id"] : false;

			// create one membership based on second membership item  
			$membership_3_cart = $SC->addToNewInternalCart($membership_item_2_id, ["user_id" => $test_user_ids[2]]);
			$membership_3_cart_reference = $membership_3_cart["cart_reference"];
			$membership_3_cart_id = $membership_3_cart["id"];
			$membership_3_order = $SC->newOrderFromCart(["newOrderFromCart", $membership_3_cart_id, $membership_3_cart_reference]);
			$membership_3_order_id = $membership_3_order["id"];
			$membership_3 = $MC->getMembers(["user_id" => $test_user_ids[2]]);
			$membership_3_id = $membership_3 ? $membership_3["id"] : false;

			
			
			// ACT 
			$member_count = $MC->getMemberCount(["item_id" => 9999]);
			
			// ASSERT 
			if(
				$member_count === "0"
				): ?>
			<div class="testpassed"><p>SuperMember::getMemberCount – by invalid item_id, memberships exist – return "0" – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::getMemberCount – by invalid item_id, memberships exist – return "0" – error</p></div>
			<? endif;
			
			// CLEAN UP
			// delete memberships
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id IN ($membership_1_id, $membership_2_id, $membership_3_id)";
			$query->sql($sql);

			// delete subscriptions
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id IN ($membership_item_1_id, $membership_item_2_id)";
			$query->sql($sql);
	
			// delete membership items
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id IN ($membership_item_1_id, $membership_item_2_id)";
			$query->sql($sql);
			
			// delete orders
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id IN ($membership_1_order_id, $membership_2_order_id, $membership_3_order_id)";
			$query->sql($sql);

			// delete users
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id IN (".$test_user_ids[0].", ".$test_user_ids[1].", ".$test_user_ids[2].")";
			$query->sql($sql);
		}
		getMemberCount_byInvalidItemId_returnZero();
		?>
			
	</div>

	<div class="tests">
		<h3>cancelMembership</h3>
		<? 	
		function cancelMembership_membershipExists_membershipIsCancelled() {

			cancelMembership
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			include_once("classes/shop/supersubscription.class.php");
			// include_once("classes/shop/supershop.class.php");
			$MC = new SuperMember();
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();

			$user_id = session()->value("user_id");

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 3;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// create membership and subscription
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_id, ["user_id" => $user_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership = $MC->getMembers(["user_id" => $user_id]);
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
	
			$cancellation_success = false;
	
			// ACT 
			
			$cancellation_success = $MC->cancelMembership(["cancelMembership", $user_id, $added_membership_id]);
			
			// ASSERT 
			if(
				$cancellation_success === true
				): ?>
			<div class="testpassed"><p>SuperMember::cancelMembership – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::cancelMembership – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);

			// delete membership order
			$added_membership_order_no = $added_membership_order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$added_membership_order_no'";
			$query->sql($sql);
		}
		// cancelMembership_membershipExists_membershipIsCancelled();
		?>
		<? 	
		function cancelMembership_membershipInvalid_returnFalse() {
			// cancelMembership – invalid membership – should return false
				
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();

			// create test user
			$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
			if($query->sql($sql)) {
				$test_user_id = $query->lastInsertId();
			}
			
			// ACT 
				$cancellation_success = $MC->cancelMembership(["cancelMembership", $test_user_id, 9999]);
			
			
			// ASSERT 
			if(
				$cancellation_success === false
				): ?>
			<div class="testpassed"><p>SuperMember::cancelMembership – invalid membership – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::cancelMembership – invalid membership – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete users
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id IN ($test_user_id)";
			$query->sql($sql);

		}
		cancelMembership_membershipInvalid_returnFalse();
		?>
	</div>

	<div class="tests">
		<h3>updateMembership</h3>		
		<? 	
		function updateMembership_noChanges_returnUpdatedMembership() {

			// updateMembership – no changes
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");

			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);

			// update test item subscription method
			$_POST["item_subscription_method"] = 3;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);

			// create membership and subscription
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_id, ["user_id" => $user_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership = $MC->getMembers(["user_id" => $user_id]);
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			
			// ACT 
			$updated_membership = $MC->updateMembership(["user_id" => $user_id]);
			
			// ASSERT 
			if(
				$updated_membership &&
				$updated_membership["id"] &&
				$updated_membership["user_id"] == session()->value("user_id") &&
				$updated_membership["id"] == $added_membership["id"] &&
				$updated_membership["modified_at"] != $added_membership["modified_at"]
				): ?>
			<div class="testpassed"><p>SuperMember::updateMembership – no changes – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::updateMembership – no changes – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);

			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);

			// delete membership order
			$added_membership_order_no = $added_membership_order["order_no"];
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$added_membership_order_no'";
			$query->sql($sql);	
		}
		updateMembership_noChanges_returnUpdatedMembership();
		?>
		<? 	
		function updateMembership_addSubscriptionId_returnUpdatedMembership() {
			// updateMembership – add subscription_id
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// add price to membership item
			$_POST["item_price"] = 100;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
			unset($_POST);
	
			// update test item subscription method
			$_POST["item_subscription_method"] = 2;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
			unset($_POST);
	
			// create membership and subscription
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_id, ["user_id" => $user_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership = $MC->getMembers(["user_id" => $user_id]);
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
	
			$subscription_id = $added_membership ? $added_membership["subscription_id"] : false;
	
			// ACT 
			$updated_membership = $MC->updateMembership(["subscription_id" => $subscription_id, "user_id" => $user_id]);
			
			// ASSERT 
			if(
				$updated_membership &&
				$updated_membership["id"] &&
				$updated_membership["user_id"] == session()->value("user_id") &&
				$updated_membership["id"] == $added_membership["id"] &&
				$updated_membership["subscription_id"] == $subscription_id &&
				$updated_membership["modified_at"] != $added_membership["modified_at"]
				): ?>
			<div class="testpassed"><p>SuperMember::updateMembership – add subscription_id – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::updateMembership – add subscription_id – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_id AND user_id = $user_id";
			$query->sql($sql);
	
			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);	
	
			// delete order
			$added_membership_order_id = $added_membership_order ? $added_membership_order["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $added_membership_order_id";
			$query->sql($sql);

		}
		updateMembership_addSubscriptionId_returnUpdatedMembership();
		?>
		<? 	
		function updateMembership_noMembershipExists_returnFalse() {

			// updateMembership – no membership exists
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
			// ACT 
			$updated_membership = $MC->updateMembership(["user_id" => $user_id]);
			$updated_membership_id = $updated_membership ? $updated_membership["id"] : false;
			
			
			// ASSERT 
			if(
				$updated_membership === false
				): ?>
			<div class="testpassed"><p>SuperMember::updateMembership – no membership exists – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::updateMembership – no membership exists – should return false – error</p></div>
			<? endif;
			
			// CLEAN UP
		}
		updateMembership_noMembershipExists_returnFalse();
		?>
		<? 
		function updateMembership_noUserIdSent_returnFalse() {
			// updateMembership – no user_id sent
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// ACT 
			$updated_membership = $MC->updateMembership();
			
			// ASSERT 
			if(
				$updated_membership === false
				): ?>
			<div class="testpassed"><p>SuperMember::updateMembership – no user_id sent – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::updateMembership – no user_id sent – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 

			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		updateMembership_noUserIdSent_returnFalse();
		?>
		<? 
		function updateMembership_invalidUserIdSent_returnFalse() {
			// updateMembership – invalid user_id sent
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// ACT 
			$updated_membership = $MC->updateMembership(["user_id" => 9999]);
			
			// ASSERT 
			if(
				$updated_membership === false
				): ?>
			<div class="testpassed"><p>SuperMember::updateMembership – invalid user_id sent – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::updateMembership – invalid user_id sent – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 

			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		updateMembership_invalidUserIdSent_returnFalse();
		?>
	</div>


	<div class="tests">
		<h3>switchMembership</h3>
		<? 	
		function switchMembership_fromNoSubscriptionToSubscription_returnOrderAddSubscriptionUpdateMembership() {
			
			// switchMembership – from no subscription to subscription
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();

			$user_id = session()->value("user_id");
			
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create membership and subscription
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $user_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership = $MC->getMembers(["user_id" => $user_id]);
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			
			// cancel membership 1 (removes subscription_id)
			$MC->cancelMembership(["cancelMembership", $user_id, $added_membership_id]);
			$added_membership = $MC->getMembers();
			
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
	
			// ACT 
			$_POST["item_id"] = $membership_item_2_id;
			$switched_membership_order = $MC->switchMembership(["switchMembership", $user_id]);
			unset($_POST);
			$switched_membership = $MC->getMembers(["user_id" => $user_id]);
			
			// ASSERT 
			if(
				$switched_membership_order && 
				$switched_membership &&
				$switched_membership["id"] == $added_membership_id &&
				$switched_membership != $added_membership &&
				$switched_membership["subscription_id"] &&
				$switched_membership_order["items"][0]["item_id"] == $membership_item_2_id &&
				$switched_membership["order_id"] == $switched_membership_order["id"]
				): ?>
			<div class="testpassed"><p>SuperMember::switchMembership – from no subscription to subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::switchMembership – from no subscription to subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = $added_membership_id";
			$query->sql($sql);
	
			// delete membership 1 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_1_id AND user_id = $user_id";
			$query->sql($sql);

			// delete membership item 1
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_1_id";
			$query->sql($sql);

			// delete membership 1 order
			$added_membership_order_id = $added_membership_order ? $added_membership_order["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = '$added_membership_order_id'";
			$query->sql($sql);
			
			// delete membership item 2 subscription
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id AND user_id = $user_id";
			$query->sql($sql);

			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);
	
			// delete membership 2 order
			$switched_membership_order_id = $switched_membership_order ? $switched_membership_order["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = '$switched_membership_order_id'";
			$query->sql($sql);
		}
		switchMembership_fromNoSubscriptionToSubscription_returnOrderAddSubscriptionUpdateMembership();
		?>
		<? 	
		function switchMembership_fromSubscriptionToSubscription_returnOrderUpdateSubscriptionUpdateMembership() {
			
			// switchMembership – from one subscription to another subscription
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create membership and subscription
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $user_id]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership = $MC->getMembers(["user_id" => $user_id]);
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			$added_membership_subscription_id = $added_membership ? $added_membership["subscription_id"] : false;
			$added_membership_subscription = $SuperSubscriptionClass->getSubscriptions(["subscription_id" => $added_membership_subscription_id]);

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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
			

	
			// ACT 
			$_POST["item_id"] = $membership_item_2_id;
			$switched_membership_order = $MC->switchMembership(["switchMembership", $user_id]);
			unset($_POST);
			$switched_membership = $MC->getMembers(["user_id" => $user_id]);
			
			$switched_membership_subscription_id = $switched_membership ? $switched_membership["subscription_id"] : false;
			$switched_membership_subscription = $SuperSubscriptionClass->getSubscriptions(["subscription_id" => $switched_membership_subscription_id]);

			// ASSERT 
			if(
				$switched_membership_order && 
				$switched_membership &&
				$switched_membership["id"] == $added_membership_id &&
				$added_membership["subscription_id"] &&
				$switched_membership["subscription_id"] &&
				$switched_membership != $added_membership &&
				$switched_membership_order["items"][0]["item_id"] == $membership_item_2_id &&
				$switched_membership_subscription["expires_at"] != $added_membership_subscription["expires_at"] &&
				$switched_membership["order_id"] == $switched_membership_order["id"]
				): ?>
			<div class="testpassed"><p>SuperMember::switchMembership – from one subscription to another subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::switchMembership – from one subscription to another subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
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
			$switched_membership_order_id = $switched_membership_order ? $switched_membership_order["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id AND order_id = ".$switched_membership_order_id;
			$query->sql($sql);
			
			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);
			
			// delete order
			$switched_membership_order_id = $switched_membership_order ? $switched_membership_order["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = '$switched_membership_order_id'";
			$query->sql($sql);
		}
		switchMembership_fromSubscriptionToSubscription_returnOrderUpdateSubscriptionUpdateMembership();
		?>
		<? 	
		function switchMembership_fromSubscriptionWithCustomPriceToSubscription_returnOrderUpdateSubscriptionUpdateMembership() {
			
			// switchMembership – from subscription with custom price to another subscription
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create membership and subscription
			$added_membership_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $user_id, "custom_price" => 50]);
			$added_membership_cart_reference = $added_membership_cart["cart_reference"];
			$added_membership_cart_id = $added_membership_cart["id"];
			$added_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $added_membership_cart_id, $added_membership_cart_reference]);
			$added_membership = $MC->getMembers(["user_id" => $user_id]);
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
			$added_membership_subscription_id = $added_membership ? $added_membership["subscription_id"] : false;
			$added_membership_subscription = $SuperSubscriptionClass->getSubscriptions(["subscription_id" => $added_membership_subscription_id]);

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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
			

	
			// ACT 
			$_POST["item_id"] = $membership_item_2_id;
			$switched_membership_order = $MC->switchMembership(["switchMembership", $user_id]);
			unset($_POST);
			$switched_membership = $MC->getMembers(["user_id" => $user_id]);
			
			$switched_membership_subscription_id = $switched_membership ? $switched_membership["subscription_id"] : false;
			$switched_membership_subscription = $SuperSubscriptionClass->getSubscriptions(["subscription_id" => $switched_membership_subscription_id]);

			// ASSERT 
			if(
				$switched_membership_order && 
				$switched_membership &&
				$switched_membership["id"] == $added_membership_id &&
				$added_membership["subscription_id"] &&
				$switched_membership["subscription_id"] &&
				$switched_membership != $added_membership &&
				$switched_membership != $added_membership &&
				$added_membership["order"]["items"][0]["total_price"] == 50 &&
				$switched_membership["order"]["items"][0]["total_price"] == 100 &&
				$switched_membership_order["items"][0]["item_id"] == $membership_item_2_id &&
				$switched_membership_subscription["expires_at"] != $added_membership_subscription["expires_at"] &&
				$added_membership_subscription["custom_price"] == 50 &&
				empty($switched_membership_subscription["custom_price"]) &&
				$switched_membership["order_id"] == $switched_membership_order["id"]
				): ?>
			<div class="testpassed"><p>SuperMember::switchMembership – from subscription with custom price to another subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::switchMembership – from subscription with custom price to another subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$added_membership_id = $added_membership ? $added_membership["id"] : false;
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
			$switched_membership_order_id = $switched_membership_order ? $switched_membership_order["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = $membership_item_2_id AND order_id = ".$switched_membership_order_id;
			$query->sql($sql);
			
			// delete membership item 2
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_2_id";
			$query->sql($sql);
			
			// delete order
			$switched_membership_order_id = $switched_membership_order ? $switched_membership_order["id"] : false;
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = '$switched_membership_order_id'";
			$query->sql($sql);
		}
		switchMembership_fromSubscriptionWithCustomPriceToSubscription_returnOrderUpdateSubscriptionUpdateMembership();
		?>
		<? 
		function switchMembership_noMembershipExists_returnFalse() {
			// switchMembership – no membership exists
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// ACT 
			$_POST["item_id"] = $membership_item_id;
			$switched_membership_order = $MC->switchMembership(["switchMembership", $user_id]);
			unset($_POST);
			
			// ASSERT 
			if(
				$switched_membership_order === false
				): ?>
			<div class="testpassed"><p>SuperMember::switchMembership – no membership exists – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::switchMembership – no membership exists – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 

			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		switchMembership_noMembershipExists_returnFalse();
		?>
		<? 
		function switchMembership_noUserIdSent_returnFalse() {
			// switchMembership – no user_id sent
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// ACT 
			$_POST["item_id"] = $membership_item_id;
			$switched_membership_order = $MC->switchMembership(["switchMembership"]);
			unset($_POST);
			$switched_membership = $MC->getMembers(["user_id" => $user_id]);
			
			// ASSERT 
			if(
				$switched_membership === false
				): ?>
			<div class="testpassed"><p>SuperMember::switchMembership – no user_id sent – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::switchMembership – no user_id sent – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 

			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		switchMembership_noUserIdSent_returnFalse();
		?>
		<? 
		function switchMembership_invalidUserIdSent_returnFalse() {
			// switchMembership – invalid user_id sent
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// ACT 
			$_POST["item_id"] = $membership_item_id;
			$switched_membership_order = $MC->switchMembership(["switchMembership", 9999]);
			unset($_POST);
			
			// ASSERT 
			if(
				$switched_membership_order === false
				): ?>
			<div class="testpassed"><p>SuperMember::switchMembership – invalid user_id sent – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::switchMembership – invalid user_id sent – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 

			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		switchMembership_invalidUserIdSent_returnFalse();
		?>
	</div>


	<div class="tests">
		<h3>upgradeMembership</h3>
		<? 	
		function upgradeMembership_toMoreExpensiveSubscription_returnTrueUpgradeMembership() {
			
			// upgradeMembership – to more expensive subscription
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);

			// create membership and subscription
			$existing_membership_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $user_id]);
			$existing_membership_cart_reference = $existing_membership_cart["cart_reference"];
			$existing_membership_cart_id = $existing_membership_cart["id"];
			$existing_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $existing_membership_cart_id, $existing_membership_cart_reference]);
			$existing_membership = $MC->getMembers(["user_id" => $user_id]);
			$existing_membership_id = $existing_membership ? $existing_membership["id"] : false;
	
			// ACT 
			$_POST["item_id"] = $membership_item_2_id;
			$upgrade_success = $MC->upgradeMembership(["upgradeMembership", $user_id]);
			unset($_POST);
			$upgraded_membership = $MC->getMembers(["user_id" => $user_id]);
			
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
			<div class="testpassed"><p>SuperMember::upgradeMembership – to more expensive subscription – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::upgradeMembership – to more expensive subscription – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$existing_membership_id = $existing_membership ? $existing_membership["id"] : false;
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
			$upgraded_membership_order_no = $upgraded_membership ? $upgraded_membership["order"]["order_no"] : false;
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$upgraded_membership_order_no'";
			$query->sql($sql);
		}
		upgradeMembership_toMoreExpensiveSubscription_returnTrueUpgradeMembership();
		?>
		<? 	
		function upgradeMembership_toCheaperSubscription_returnFalse() {
			
			// upgradeMembership – to cheaper (or equally priced) subscription – should return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create membership and subscription
			// TypeMembership::ordered will call SuperMember::addMembership 
			$existing_membership_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $user_id]);
			$existing_membership_cart_reference = $existing_membership_cart["cart_reference"];
			$existing_membership_cart_id = $existing_membership_cart["id"];
			$existing_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $existing_membership_cart_id, $existing_membership_cart_reference]);
			$existing_membership = $MC->getMembers(["user_id" => $user_id]);
			$existing_membership_id = $existing_membership ? $existing_membership["id"] : false;
			

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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);
	
			// ACT 
			$_POST["item_id"] = $membership_item_2_id;
			$upgrade_success = $MC->upgradeMembership(["upgradeMembership", $user_id]);
			unset($_POST);
			
			// ASSERT 
			if(
				$existing_membership_id &&
				$upgrade_success === false
				): ?>
			<div class="testpassed"><p>SuperMember::upgradeMembership – to cheaper (or equally priced) subscription – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::upgradeMembership – to cheaper (or equally priced) subscription – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$existing_membership_id = $existing_membership ? $existing_membership["id"] : false;
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
			
			// upgradeMembership – existing membership has no subscription (is inactive) – should return false
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
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
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);

			// create membership and subscription
			// TypeMembership::ordered will call SuperMember::addMembership 
			$existing_membership_cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $user_id]);
			$existing_membership_cart_reference = $existing_membership_cart["cart_reference"];
			$existing_membership_cart_id = $existing_membership_cart["id"];
			$existing_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $existing_membership_cart_id, $existing_membership_cart_reference]);
			$existing_membership = $MC->getMembers(["user_id" => $user_id]);
			$existing_membership_id = $existing_membership ? $existing_membership["id"] : false;

			// cancel membership (removes subscription_id)
			$MC->cancelMembership(["cancelMembership", $user_id, $existing_membership_id]);
			$existing_membership = $MC->getMembers(["user_id" => $user_id]);
	
			// ACT 
			$_POST["item_id"] = $membership_item_2_id;
			$upgrade_success = $MC->upgradeMembership(["upgradeMembership", $user_id]);
			unset($_POST);
			
			// ASSERT 
			if(
				$existing_membership &&
				$existing_membership["order"] === false &&
				$upgrade_success === false
				): ?>
			<div class="testpassed"><p>SuperMember::upgradeMembership – existing membership has no subscription (is inactive) – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::upgradeMembership – existing membership has no subscription (is inactive) – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$existing_membership_id = $existing_membership ? $existing_membership["id"] : false;
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
		function upgradeMembership_noUserIdSent_returnFalse() {
			// upgradeMembership – no user_id sent
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// ACT 
			$upgrade_success = $MC->upgradeMembership(["upgradeMembership"]);
			unset($_POST);
			
			// ASSERT 
			if(
				$upgrade_success === false
				): ?>
			<div class="testpassed"><p>SuperMember::upgradeMembership – no user_id sent – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::upgradeMembership – no user_id sent – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 

			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		upgradeMembership_noUserIdSent_returnFalse();
		?>
		<? 
		function upgradeMembership_invalidUserIdSent_returnFalse() {
			// upgradeMembership – invalid user_id sent
			
			// ARRANGE
			include_once("classes/users/supermember.class.php");
			$MC = new SuperMember();
			include_once("classes/shop/supersubscription.class.php");
			$SuperSubscriptionClass = new SuperSubscription();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();
			$user_id = session()->value("user_id");
			
			// create test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item";
			$membership_item = $model_membership->save(array("save"));
			$membership_item_id = $membership_item["id"];
			unset($_POST);

			// ACT 
			$upgrade_success = $MC->upgradeMembership(["upgradeMembership", 9999]);
			unset($_POST);
			
			// ASSERT 
			if(
				$upgrade_success === false
				): ?>
			<div class="testpassed"><p>SuperMember::upgradeMembership – invalid user_id sent – should return false – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::upgradeMembership – invalid user_id sent – should return false – error</p></div>
			<? endif; 
			
			// CLEAN UP 

			// delete membership item
			$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_item_id";
			$query->sql($sql);
		}
		upgradeMembership_invalidUserIdSent_returnFalse();
		?>
		<? 	
		function upgradeMembership_existingMembershipHasNoExpiry_returnTrue() {
			
			// upgradeMembership – existing membership has no expiry – should return true, new expiry date based on current date
			
			// ARRANGE
			$MC = new SuperMember();
			$query = new Query();
			$IC = new Items();
			$SC = new SuperShop();

			$model_tests = $IC->typeObject("tests");
			$user_id = $model_tests->createTestUser();
			
			// create first test membership item
			$model_membership = $IC->TypeObject("membership");
			$_POST["name"] = "Membership Test item 1";
			$membership_item_1 = $model_membership->save(array("save"));
			$membership_item_1_id = $membership_item_1["id"];
			unset($_POST);

			// add subscription method to first membership item (never expires)
			$_POST["item_subscription_method"] = 3;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_1_id));
			unset($_POST);
			
			// add price to first membership item
			$_POST["item_price"] = 0;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_1_price = $model_membership->addPrice(array("addPrice", $membership_item_1_id));
			unset($_POST);

			// create second test membership item
			$_POST["name"] = "Membership Test item 2";
			$membership_item_2 = $model_membership->save(array("save"));
			$membership_item_2_id = $membership_item_2["id"];
			unset($_POST);

			// add subscription method to second membership item (monthly)
			$_POST["item_subscription_method"] = 1;
			$model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_2_id));
			unset($_POST);
			
			// add price to second membership item
			$_POST["item_price"] = 300;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 1;
			$_POST["item_price_type"] = 1;
			$membership_item_2_price = $model_membership->addPrice(array("addPrice", $membership_item_2_id));
			unset($_POST);

			// create cart and order for first membership item 
			// TypeMembership::ordered will call Member::addMembership 
			$cart = $SC->addToNewInternalCart($membership_item_1_id, ["user_id" => $user_id]);
			$existing_membership_order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);
			$existing_membership = $MC->getMembers(["user_id" => $user_id]);
			$existing_membership_id = $existing_membership ? $existing_membership["id"] : false;
	
			// ACT 
			$_POST["item_id"] = $membership_item_2_id;
			$upgrade_success = $MC->upgradeMembership(["upgradeMembership", $user_id]);
			unset($_POST);

			$upgraded_membership = $MC->getMembers(["user_id" => $user_id]);
			$today_next_month = date("Y-m-d", strtotime("+1 month", time()));

			// ASSERT 
			if(
				$existing_membership
				&& $upgraded_membership
				&& $existing_membership["subscription_id"] == $upgraded_membership["subscription_id"]
				&& $existing_membership["expires_at"] === NULL
				&& $upgraded_membership["expires_at"] == $today_next_month." 00:00:00"
				): ?>
			<div class="testpassed"><p>SuperMember::upgradeMembership – existing membership has no expiry date – should return true, new expiry date based on current date – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperMember::upgradeMembership – existing membership has no expiry date – should return true, new expiry date based on current date – error</p></div>
			<? endif; 
			
			// CLEAN UP
			// delete membership
			$existing_membership_id = $existing_membership ? $existing_membership["id"] : false;
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
			$upgraded_membership_order_no = $upgraded_membership ? $upgraded_membership["order"]["order_no"] : false;
			$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE order_no = '$upgraded_membership_order_no'";
			$query->sql($sql);

			$model_tests->cleanUp(["user_id" => $user_id]);
		}
		upgradeMembership_existingMembershipHasNoExpiry_returnTrue();
		?>
	</div>


</div>
