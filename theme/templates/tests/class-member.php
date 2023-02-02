<div class="scene i:scene tests">
	<h1>Member</h1>	
	<h2>Testing Member class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests addNewMembership">
		<h3>addNewMembership</h3>
		<?

		if(1 && "addNewMembership – with correct action – should return order object") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$_POST["item_id"] = $test_item_id;
				$added_membership_order = $MC->addNewMembership(["addNewMembership"]);
				$added_membership_order_id = $added_membership_order ? $added_membership_order["id"] : false;
				unset($_POST);


				// ASSERT 

				if(
					$added_membership_order &&
					$added_membership_order["items"][0]["item_id"] == $test_item_id &&
					$added_membership_order["items"][0]["total_price"] == 100
				): ?>
				<div class="testpassed"><p>Member::addNewMembership – with correct $action – should return order object – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::addNewMembership – with correct $action – should return order object – error</p></div>
				<? endif;


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addNewMembership – invalid user_id in action – should return false") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$_POST["item_id"] = $test_item_id;
				$added_membership_order = $MC->addNewMembership(["addNewMembership", "invalid_id"]);
				unset($_POST);


				// ASSERT 

				if(
					$test_user_id &&
					$test_item_id &&
					$added_membership_order === false
				): ?>
				<div class="testpassed"><p>Member::addNewMembership – invalid user_id in $action – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::addNewMembership – invalid user_id in $action – should return false – error</p></div>
				<? endif;


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addNewMembership – valid but non-existing user_id in action – should return false") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$_POST["item_id"] = $test_item_id;
				$added_membership_order = $MC->addNewMembership(["addNewMembership", 9999]);
				unset($_POST);


				// ASSERT 

				if(
					$test_user_id &&
					$test_item_id &&
					$added_membership_order === false
				): ?>
				<div class="testpassed"><p>Member::addNewMembership – valid but non-existing user_id in $action – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::addNewMembership – valid but non-existing user_id in $action – should return false – error</p></div>
				<? endif;


				// CLEAN UP
	
				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests addMembership">
		<h3>addMembership</h3>
		<?

		if(1 && "addMembership – non-existing subscription") {

			(function() {

				// ARRANGE
				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);
	
				$added_membership = $MC->addMembership($test_item_id, 999999999);


				// ASSERT 

				if(
					$added_membership === false
				): ?>
				<div class="testpassed"><p>Member::addMembership – non-existing subscription – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::addMembership – non-existing subscription – should return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addMembership – membership already exists – should return false") {

			(function() {

				$MC = new Member();
				$SuC = new Subscription();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"subscription_method" => 2
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// Adding subscription to membership will automatically add membership via type.membership->subscribed

				$_POST["item_id"] = $test_item_id;
				$subscription = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);

				$add_membership = $MC->addMembership($test_item_id, $subscription["id"]);
	

				// ASSERT 
				if(
					$subscription &&
					!$add_membership
				): ?>
				<div class="testpassed"><p>Member::addMembership – membership already exists – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::addMembership – membership already exists – should return false – error</p></div>
				<? endif;


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addMembership – subscription without price") {

			(function() {

				$MC = new Member();
				$SuC = new Subscription();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"subscription_method" => 2
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// Adding subscription to membership will automatically add membership via type.membership->subscribed
				$_POST["item_id"] = $test_item_id;
				$subscription = $SuC->addSubscription(["addSubscription"]);
				unset($_POST);

				$membership = $MC->getMembership();
				// debug([$membership]);

				// ASSERT 
				if(
					$membership &&
					$membership["id"] &&
					$membership["user_id"] == $test_user_id &&
					$membership["item_id"] == $test_item_id &&
					$membership["order"] === false &&
					$membership["item"]["prices"] === false
				): ?>
				<div class="testpassed"><p>Member::addMembership – subscription without price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::addMembership – subscription without price – error</p></div>
				<? endif;


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>


	<div class="tests getMembership">
		<h3>getMembership</h3>
		<?

		if(1 && "getMembership") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);
				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$fetched_membership = $MC->getMembership();


				// ASSERT 

				if(
					$fetched_membership &&
					$fetched_membership["id"] &&
					$fetched_membership["user_id"] == $test_user_id &&
					$fetched_membership["item_id"] == $test_item_id &&
					$fetched_membership["item"]["prices"][0]["price"] == 100
				): ?>
				<div class="testpassed"><p>Member::getMembership – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::getMembership – error</p></div>
				<? endif;


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "getMembership – no membership exists") {

			(function() {

				// ARRANGE

				$MC = new Member();


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

				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests cancelMembership">
		<h3>cancelMembership</h3>
		<? 

		if(1 && "cancelMembership") {

			(function() {

				// ARRANGE
				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);
				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$membership = $MC->getMembership();

				$cancellation_success = $MC->cancelMembership(["cancelMembership", $membership["id"]]);


				// ASSERT 

				if(
					$cancellation_success === true
				): ?>
				<div class="testpassed"><p>Member::cancelMembership – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::cancelMembership – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id,
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "cancelMembership – invalid membership – should return false") {

			(function() {

				// ARRANGE

				$MC = new Member();


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

				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests switchMembership">
		<h3>switchMembership</h3>
		<?

		if(1 && "switchMembership (inactive membership) – from no subscription to subscription") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id_1 = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"name" => "Membership 2",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 200
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$membership = $MC->getMembership();

				$cancellation_success = $MC->cancelMembership(["cancelMembership", $membership["id"]]);
				$cancelled_membership = $MC->getMembership();

				$_POST["item_id"] = $test_item_id_2;
				$order = $MC->switchMembership(["switchMembership"]);
				unset($_POST);

				$switched_membership = $MC->getMembership();
				// debug([$membership, $cancelled_membership, $switched_membership]);


				// ASSERT

				if(
					$membership &&
					$membership["id"] === $switched_membership["id"] &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 100 &&

					$cancellation_success === true &&
					$cancelled_membership &&
					!$cancelled_membership["subscription_id"] &&
					!$cancelled_membership["item"] &&

					$order && 
					$switched_membership &&
					$switched_membership["item_id"] == $test_item_id_2 &&
					$switched_membership["subscription_id"] != $membership["subscription_id"] &&
					$switched_membership["order_id"] == $order["id"] &&
					$switched_membership["item"]["prices"][0]["price"] == 200
				): ?>
				<div class="testpassed"><p>Member::switchMembership – from no subscription (inactive membership) to subscription – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::switchMembership – from no subscription (inactive membership) to subscription – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "switchMembership – from one subscription to another subscription") {

			(function() {

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id_1 = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"name" => "Membership 2",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 200
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$membership = $MC->getMembership();

				$_POST["item_id"] = $test_item_id_2;
				$order = $MC->switchMembership(["switchMembership"]);
				unset($_POST);

				$switched_membership = $MC->getMembership();
				// debug([$membership, $switched_membership]);


				// ASSERT 

				if(
					$membership &&
					$membership["id"] === $switched_membership["id"] &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 100 &&

					$order && 
					$switched_membership &&
					$switched_membership["item_id"] == $test_item_id_2 &&
					$switched_membership["subscription_id"] != $membership["subscription_id"] &&
					$switched_membership["order_id"] == $order["id"] &&
					$switched_membership["item"]["prices"][0]["price"] == 200
				): ?>
				<div class="testpassed"><p>Member::switchMembership – from one subscription to another subscription – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::switchMembership – from one subscription to another subscription – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "switchMembership – from subscription with custom price to another subscription") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();
				$SuC = new Subscription();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id_1 = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"name" => "Membership 2",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 200
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1,
					"subscription_custom_price" => 50,
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$membership = $MC->getMembership();
				$membership_subscription = $SuC->getSubscriptions(["subscription_id" => $membership["subscription_id"]]);


				$_POST["item_id"] = $test_item_id_2;
				$order = $MC->switchMembership(["switchMembership"]);
				unset($_POST);
				$switched_membership = $MC->getMembership();

				$switched_membership_subscription = $SuC->getSubscriptions(["subscription_id" => $switched_membership["subscription_id"]]);

				// debug([$membership, $membership_subscription, $switched_membership, $switched_membership_subscription]);


				// ASSERT 

				if(
					$membership &&
					$membership["id"] == $switched_membership["id"] &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["order"]["items"][0]["total_price"] == 50 &&
					$membership_subscription["custom_price"] == 50 &&

					$order &&
					$switched_membership &&
					$order == $switched_membership["order"] &&
					$switched_membership["item_id"] == $test_item_id_2 &&
					$switched_membership["subscription_id"] != $membership["subscription_id"] &&
					$switched_membership["order_id"] == $order["id"] &&
					$switched_membership["item"]["prices"][0]["price"] == 200 &&
					$switched_membership["order"]["items"][0]["total_price"] == 200 &&
					!$switched_membership_subscription["custom_price"]
				): ?>
				<div class="testpassed"><p>Member::switchMembership – from subscription with custom price to another subscription – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::switchMembership – from subscription with custom price to another subscription – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "switchMembership – no membership exists") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$MC = new Member();
				$IC = new Items();
				$SuC = new Subscription();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id_1 = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"name" => "Membership 2",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 200
				]);

				$test_user_id = $test_model->createTestUser();


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$_POST["item_id"] = $test_item_id_2;
				$order = $MC->switchMembership(["switchMembership"]);
				unset($_POST);

				$membership = $MC->getMembership();


				// ASSERT 

				if(
					$order === false &&
					!$membership
				): ?>
				<div class="testpassed"><p>Member::switchMembership – no membership exists – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::switchMembership – no membership exists – should return false – error</p></div>
				<? endif; 


				// CLEAN UP 

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests updateMembership">
		<h3>updateMembership</h3>
		<?

		if(1 && "updateMembership – no changes") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);
				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id,
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$membership = $MC->getMembership();

				$updated_membership = $MC->updateMembership();


				// ASSERT 

				if(
					$membership &&
					$membership["item_id"] == $test_item_id &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["order"]["items"][0]["total_price"] == 100 &&

					$updated_membership &&
					$updated_membership["id"] == $membership["id"] &&
					$updated_membership["item_id"] == $test_item_id &&
					$updated_membership["item"]["prices"][0]["price"] == 100 &&
					$updated_membership["order"]["items"][0]["total_price"] == 100 &&
					$updated_membership["user_id"] == $test_user_id &&
					$updated_membership["modified_at"] != $membership["modified_at"]
				): ?>
				<div class="testpassed"><p>Member::updateMembership – no changes – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::updateMembership – no changes – error</p></div>
				<? endif; 


				// CLEAN UP


				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "updateMembership – add subscription_id") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();
				$SuC = new Subscription();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id_1 = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"name" => "Membership 2",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 200
				]);
				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1,
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$membership = $MC->getMembership();
				$membership_subscription = $SuC->getSubscriptions(["subscription_id" => $membership["subscription_id"]]);

				$cancellation_success = $MC->cancelMembership(["cancelMembership", $membership["id"]]);
				$cancelled_membership = $MC->getMembership();

				// Will invoke updateMembership as a result of ordered and subscribed callbacks
				$test_order = $test_model->createTestOrder([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id_2,
				]);
				$new_membership = $MC->getMembership();
				$new_membership_subscription = $SuC->getSubscriptions(["subscription_id" => $new_membership["subscription_id"]]);


				// ASSERT 

				if(
					$membership &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["order"]["items"][0]["total_price"] == 100 &&
					$membership_subscription["item_id"] == $test_item_id_1 &&
					$membership_subscription["order_id"] == $membership["order_id"] &&
					!$membership_subscription["custom_price"] &&

					$cancellation_success === true &&
					$cancelled_membership &&
					!$cancelled_membership["subscription_id"] &&
					!$cancelled_membership["item"] &&

					$new_membership &&
					$new_membership["id"] == $membership["id"] &&
					$new_membership["item_id"] == $test_item_id_2 &&
					$new_membership["item"]["prices"][0]["price"] == 200 &&
					$new_membership["order"]["items"][0]["total_price"] == 200 &&
					$new_membership["user_id"] == $test_user_id &&
					$new_membership["modified_at"] != $membership["modified_at"] &&
					$new_membership_subscription["item_id"] == $test_item_id_2 &&
					$new_membership_subscription["order_id"] == $new_membership["order_id"] &&
					!$new_membership_subscription["custom_price"]
				): ?>
				<div class="testpassed"><p>Member::updateMembership – add subscription_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::updateMembership – add subscription_id – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "updateMembership – no membership exists") {

			(function() {

				// ARRANGE
				$MC = new Member();
				$IC = new Items();
				$SuC = new Subscription();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id = $test_model->createTestItem([
					"name" => "Test item",
					"subscription_method" => 2,
					"price" => 200
				]);
				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id,
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$subscription = $SuC->getSubscriptions(["item_id" => $test_item_id]);

				$updated_membership = $MC->updateMembership(["subscription_id" => $subscription["id"]]);


				// ASSERT 

				if(
					$subscription &&
					$updated_membership === false
				): ?>
				<div class="testpassed"><p>Member::updateMembership – no membership exists – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::updateMembership – no membership exists – should return false – error</p></div>
				<? endif;


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id,
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests upgradeMembership">
		<h3>upgradeMembership</h3>
		<?

		if(1 && "upgradeMembership – to more expensive subscription") {
			session()->value("user_id", 2);

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id_1 = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"name" => "Membership 2",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 150
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$membership = $MC->getMembership();


				$_POST["item_id"] = $test_item_id_2;
				$upgrade_success = $MC->upgradeMembership(["upgradeMembership"]);
				unset($_POST);
				$upgraded_membership = $MC->getMembership();

				// debug([$membership, $upgraded_membership]);


				// ASSERT 

				if(
					$membership &&
					$membership["id"] === $upgraded_membership["id"] &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["subscription_id"] &&
					$membership["order"]["items"][0]["total_price"] == 100 &&

					$upgrade_success &&
					$upgraded_membership &&
					$upgraded_membership["item_id"] == $test_item_id_2 &&
					$upgraded_membership["subscription_id"] == $membership["subscription_id"] &&
					$upgraded_membership["item"]["prices"][0]["price"] == 150 &&
					$upgraded_membership["order"]["items"][0]["total_price"] == 50
				): ?>
				<div class="testpassed"><p>Member::upgradeMembership – to more expensive subscription – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::upgradeMembership – to more expensive subscription – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "upgradeMembership – to cheaper subscription – should return false") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id_1 = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 200
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"name" => "Membership 2",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$membership = $MC->getMembership();

				$_POST["item_id"] = $test_item_id_2;
				$upgrade_success = $MC->upgradeMembership(["upgradeMembership"]);
				unset($_POST);

				$not_upgraded_membership = $MC->getMembership();


				// ASSERT 

				if(
					$membership &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 200 &&
					$membership["subscription_id"] &&

					$upgrade_success === false &&

					$not_upgraded_membership === $membership 
				): ?>
				<div class="testpassed"><p>Member::upgradeMembership – to cheaper subscription – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::upgradeMembership – to cheaper subscription – should return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "upgradeMembership – existing membership is inactive/has no subscription – should return false") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id_1 = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"name" => "Membership 2",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 200
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$membership = $MC->getMembership();

				$cancellation_success = $MC->cancelMembership(["cancelMembership", $membership["id"]]);
				$cancelled_membership = $MC->getMembership();


				$_POST["item_id"] = $test_item_id_2;
				$upgrade_success = $MC->upgradeMembership(["upgradeMembership"]);
				unset($_POST);

				$not_upgraded_membership = $MC->getMembership();


				// ASSERT 

				if(
					$membership &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["subscription_id"] &&
					$membership["item"]["prices"][0]["price"] == 100 &&

					$cancellation_success === true &&
					$cancelled_membership &&
					!$cancelled_membership["subscription_id"] &&
					!$cancelled_membership["item"] &&

					$upgrade_success === false &&

					$not_upgraded_membership === $cancelled_membership
				): ?>
				<div class="testpassed"><p>Member::upgradeMembership – existing membership is inactive/has no subscription – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::upgradeMembership – existing membership is inactive/has no subscription – should return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "upgradeMembership – existing membership has no expiry – should return true, new expiry date based on current date") {

			(function() {

				// ARRANGE

				$MC = new Member();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");
				$current_user_id = session()->value("user_id");


				$test_item_id_1 = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 3,
					"price" => 100
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"name" => "Membership 2",
					"itemtype" => "membership",
					"subscription_method" => 1,
					"price" => 200
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$membership = $MC->getMembership();


				$_POST["item_id"] = $test_item_id_2;
				$upgrade_success = $MC->upgradeMembership(["upgradeMembership"]);
				unset($_POST);

				$upgraded_membership = $MC->getMembership();
				$today_next_month = date("Y-m-d 00:00:00", strtotime("+1 month", time()));


				// ASSERT 

				if(
					$membership &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["subscription_id"] &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["expires_at"] === NULL &&

					$upgraded_membership &&
					$upgraded_membership["item_id"] == $test_item_id_2 &&
					$upgraded_membership["subscription_id"] == $membership["subscription_id"] &&
					$upgraded_membership["expires_at"] == $today_next_month &&
					$upgraded_membership["item"]["prices"][0]["price"] == 200
				): ?>
				<div class="testpassed"><p>Member::upgradeMembership – existing membership has no expiry date – should return true, new expiry date based on current date – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Member::upgradeMembership – existing membership has no expiry date – should return true, new expiry date based on current date – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

</div>
