<div class="scene i:scene tests">
	<h1>SuperMember</h1>	
	<h2>Testing SuperMember class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>
	<div class="tests addNewMembership">
		<h3>addNewMembership</h3>
		<?

		if(1 && "addNewMembership – with correct action – should return order object") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);


				// ACT

				$_POST["item_id"] = $test_item_id;
				$added_membership_order = $MC->addNewMembership(["addNewMembership", $test_user_id]);
				unset($_POST);

				$membership = $MC->getMembers(["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$added_membership_order &&
					$added_membership_order["user_id"] == $test_user_id &&
					$added_membership_order["items"][0]["item_id"] == $test_item_id &&

					$membership &&
					$membership["user_id"] == $test_user_id &&
					$membership["item_id"] == $test_item_id
				): ?>
				<div class="testpassed"><p>SuperMember::addNewMembership – with correct $action – should return order object – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::addNewMembership – with correct $action – should return order object – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addNewMembership – no user_id in action – should return false") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);


				// ACT

				$_POST["item_id"] = $test_item_id;
				$added_membership_order = $MC->addNewMembership(["addNewMembership"]);
				unset($_POST);

				$membership = $MC->getMembers(["user_id" => $test_item_id]);


				// ASSERT 

				if(
					!$membership &&
					$added_membership_order === false
				): ?>
				<div class="testpassed"><p>SuperMember::addNewMembership – no user_id in $action – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::addNewMembership – no user_id in $action – should return false – error</p></div>
				<? endif;


				// CLEAN UP

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
				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);


				// ACT

				$_POST["item_id"] = $test_item_id;
				$added_membership_order = $MC->addNewMembership(["addNewMembership", "invalid_id"]);
				unset($_POST);

				$membership = $MC->getMembers(["user_id" => $test_item_id]);


				// ASSERT 

				if(
					!$membership &&
					$added_membership_order === false
				): ?>
				<div class="testpassed"><p>SuperMember::addNewMembership – invalid user_id in $action – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::addNewMembership – invalid user_id in $action – should return false – error</p></div>
				<? endif;


				// CLEAN UP

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

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);


				// ACT 

				$_POST["item_id"] = $test_item_id;
				$added_membership_order = $MC->addNewMembership(["addNewMembership", 9999]);
				unset($_POST);

				$membership = $MC->getMembers(["user_id" => $test_item_id]);


				// ASSERT 

				if(
					!$membership &&
					$added_membership_order === false
				): ?>
				<div class="testpassed"><p>SuperMember::addNewMembership – valid but non-existing user_id in $action – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::addNewMembership – valid but non-existing user_id in $action – should return false – error</p></div>
				<? endif;


				// CLEAN UP
	
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

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);
	

				// ACT 

				$added_membership = $MC->addMembership($test_item_id, 999, ["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$added_membership === false
				): ?>
				<div class="testpassed"><p>SuperMember::addMembership – non-existing subscription – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::addMembership – non-existing subscription – should return false – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id,
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addMembership – no user_id sent") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);
				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);

				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id]);


				// ACT 

				$added_membership = $MC->addMembership($test_item_id_2, $subscription[0]["id"]);


				// ASSERT 

				if(
					$added_membership === false
				): ?>
				<div class="testpassed"><p>SuperMember::addMembership – no user_id sent – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::addMembership – no user_id sent – should return false – error</p></div>
				<? endif; 


				// CLEAN UP 

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addMembership – invalid user_id sent") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100,
					"subscription_method" => 2
				]);
				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);

				$subscription = $SuperSubscriptionClass->getSubscriptions(["user_id" => $test_user_id]);


				// ACT 

				$added_membership = $MC->addMembership($test_item_id_2, $subscription[0]["id"], ["user_id" => 9999]);


				// ASSERT

				if(
					$added_membership === false
				): ?>
				<div class="testpassed"><p>SuperMember::addMembership – invalid user_id sent – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::addMembership – invalid user_id sent – should return false – error</p></div>
				<? endif; 


				// CLEAN UP 

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addMembership – with subscription and no price") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"subscription_method" => 2
				]);


				// ACT 

				// addMembership will be called via addSubscription callbacks to ordered and subscribed
				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id
				]);

				$membership = $MC->getMembers(["user_id" => $test_user_id]);
				// debug([$membership]);

				// ASSERT 

				if(
					$membership &&
					$membership["subscription_id"] &&
					$membership["item"]["prices"] === false
				): ?>
				<div class="testpassed"><p>SuperMember::addMembership – with subscription and no price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::addMembership – with subscription and no price – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id,
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addMembership – with subscription and price") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);


				// ACT 

				// addMembership will be called via addSubscription callbacks to ordered and subscribed
				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id
				]);

				$membership = $MC->getMembers(["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$membership &&
					$membership["id"] &&
					$membership["user_id"] == $test_user_id &&
					$membership["item_id"] == $test_item_id &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["order"]["items"][0]["total_price"] == 100
				): ?>
				<div class="testpassed"><p>SuperMember::addMembership – with subscription and price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::addMembership – with subscription and price – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addMembership – membership already exists – should return false") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);


				// ACT 

				// addMembership will be called via addSubscription callbacks to ordered and subscribed
				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);

				$membership = $MC->getMembers(["user_id" => $test_user_id]);

				$repeated_add = $MC->addMembership($test_item_id_2, $membership["subscription_id"]);
				$repeated_membership = $MC->getMembers(["user_id" => $test_user_id]);

				// debug([$membership]);


				// ASSERT 

				if(
					!$repeated_add &&
					$membership === $repeated_membership
				): ?>
				<div class="testpassed"><p>SuperMember::addMembership – membership already exists – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::addMembership – membership already exists – should return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests getMembers">
		<h3>getMembers</h3>
		<?

		if(1 && "getMembers by member_id, membership exists") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				$query = new Query();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_3 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_2
				]);
				$test_user_id_4 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_2
				]);

				// do not use getMembers for finding member_id as getMember by member_id is being tested here
				$sql = "SELECT id FROM ".$MC->db_members." WHERE user_id = $test_user_id_1";
				if($query->sql($sql)) {
					$member_id_1 = $query->result(0, "id");
				}

				$sql = "SELECT id FROM ".$MC->db_members." WHERE user_id = $test_user_id_3";
				if($query->sql($sql)) {
					$member_id_3 = $query->result(0, "id");
				}


				// ACT 

				$membership_1 = $MC->getMembers(["member_id" => $member_id_1]);
				$membership_3 = $MC->getMembers(["member_id" => $member_id_3]);


				// ASSERT 

				if(
					$test_item_id_1 &&
					$test_item_id_2 &&
					$test_user_id_1 &&
					$test_user_id_2 &&
					$test_user_id_3 &&
					$test_user_id_4 &&
					$member_id_1 &&
					$member_id_3 &&

					$membership_1 &&
					$membership_1["id"] == $member_id_1 &&
					$membership_1["item_id"] == $test_item_id_1 &&
					$membership_1["user_id"] == $test_user_id_1 &&
					$membership_1["item"]["prices"][0]["price"] == 100 &&
					$membership_1["order"]["items"][0]["total_price"] == 100 &&

					$membership_3 &&
					$membership_3["id"] == $member_id_3 &&
					$membership_3["item_id"] == $test_item_id_2 &&
					$membership_3["user_id"] == $test_user_id_3 &&
					$membership_3["item"]["prices"][0]["price"] == 150 &&
					$membership_3["order"]["items"][0]["total_price"] == 150
				): ?>
				<div class="testpassed"><p>SuperMember::getMembers – by member_id, membership exists – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::getMembers – by member_id, membership exists – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["user_id" => $test_user_id_3]);
				$test_model->cleanUp(["user_id" => $test_user_id_4]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "getMembers – by wrong member id, no such membership exists") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id
				]);


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

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "getMembers by user_id, membership exists") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$query = new Query();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_3 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_2
				]);
				$test_user_id_4 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_2
				]);


				// ACT 

				$membership_1 = $MC->getMembers(["user_id" => $test_user_id_1]);
				$membership_3 = $MC->getMembers(["user_id" => $test_user_id_3]);


				// ASSERT 

				if(
					$test_item_id_1 &&
					$test_item_id_2 &&
					$test_user_id_1 &&
					$test_user_id_2 &&
					$test_user_id_3 &&
					$test_user_id_4 &&

					$membership_1 &&
					$membership_1["item_id"] == $test_item_id_1 &&
					$membership_1["user_id"] == $test_user_id_1 &&
					$membership_1["item"]["prices"][0]["price"] == 100 &&
					$membership_1["order"]["items"][0]["total_price"] == 100 &&

					$membership_3 &&
					$membership_3["item_id"] == $test_item_id_2 &&
					$membership_3["user_id"] == $test_user_id_3 &&
					$membership_3["item"]["prices"][0]["price"] == 150 &&
					$membership_3["order"]["items"][0]["total_price"] == 150 &&

					$membership_1["id"] != $membership_3["id"]
				): ?>
				<div class="testpassed"><p>SuperMember::getMembers – by user_id, membership exists – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::getMembers – by user_id, membership exists – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["user_id" => $test_user_id_3]);
				$test_model->cleanUp(["user_id" => $test_user_id_4]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "getMembers – by wrong user_id, no such membership exists") {

			(function() {

				// ARRANGE
				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser();


				// ACT 

				$membership_1 = $MC->getMembers(["user_id" => $test_user_id_1]);
				$membership_2 = $MC->getMembers(["user_id" => 999999999]);

				// debug([$membership_1, $membership_2]);

				// ASSERT 

				if(
					$test_item_id_1 &&
					$test_item_id_2 &&
					$test_user_id_1 &&

					!$membership_1 &&
					!$membership_2
				): ?>
				<div class="testpassed"><p>SuperMember::getMembers – by wrong user_id, no such membership exists – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::getMembers – by wrong user_id, no such membership exists – should return false – error</p></div>
				<? endif; 


				// CLEAN UP 

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "getMembers by item_id, membership exists") {

			(function() {

				// ARRANGE
				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_3 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_2
				]);
				$test_user_id_4 = $test_model->createTestUser([
					"subscription_custom_price" => 50,
					"subscribed_item_id" => $test_item_id_2
				]);


				// ACT 

				$membership_1 = $MC->getMembers(["item_id" => $test_item_id_1]);
				$membership_2 = $MC->getMembers(["item_id" => $test_item_id_2]);

				// debug([$membership_1, $membership_2]);

				// ASSERT 

				if(
					$test_item_id_1 &&
					$test_item_id_2 &&
					$test_user_id_1 &&
					$test_user_id_2 &&
					$test_user_id_3 &&
					$test_user_id_4 &&

					count($membership_1) == 2 &&
					$membership_1[0]["item_id"] == $test_item_id_1 &&
					$membership_1[0]["user_id"] == $test_user_id_1 &&
					$membership_1[0]["item"]["prices"][0]["price"] == 100 &&
					$membership_1[0]["order"]["items"][0]["total_price"] == 100 &&
					$membership_1[1]["item_id"] == $test_item_id_1 &&
					$membership_1[1]["user_id"] == $test_user_id_2 &&
					$membership_1[1]["item"]["prices"][0]["price"] == 100 &&
					$membership_1[1]["order"]["items"][0]["total_price"] == 100 &&

					count($membership_2) == 2 &&
					$membership_2[0]["item_id"] == $test_item_id_2 &&
					$membership_2[0]["user_id"] == $test_user_id_3 &&
					$membership_2[0]["item"]["prices"][0]["price"] == 150 &&
					$membership_2[0]["order"]["items"][0]["total_price"] == 150 &&
					$membership_2[1]["item_id"] == $test_item_id_2 &&
					$membership_2[1]["user_id"] == $test_user_id_4 &&
					$membership_2[1]["item"]["prices"][0]["price"] == 150 &&
					$membership_2[1]["order"]["items"][0]["total_price"] == 50
				): ?>
				<div class="testpassed"><p>SuperMember::getMembers – by item_id, membership exists – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::getMembers – by item_id, membership exists – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["user_id" => $test_user_id_3]);
				$test_model->cleanUp(["user_id" => $test_user_id_4]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "getMembers – by wrong item_id, no such membership exists") {

			(function() {

				// ARRANGE
				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser();


				// ACT 

				$membership_1 = $MC->getMembers(["item_id" => $test_item_id_1]);
				$membership_2 = $MC->getMembers(["item_id" => 999999999]);

				// debug([$membership_1, $membership_2]);

				// ASSERT 

				if(
					$test_item_id_1 &&
					$test_item_id_2 &&
					$test_user_id_1 &&

					!$membership_1 &&
					!$membership_2
				): ?>
				<div class="testpassed"><p>SuperMember::getMembers – by wrong item_id, no such membership exists – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::getMembers – by wrong item_id, no such membership exists – should return false – error</p></div>
				<? endif; 


				// CLEAN UP 

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getMembers, no parameters sent – return all members") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_3 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_2
				]);
				$test_user_id_4 = $test_model->createTestUser([
					"subscription_custom_price" => 50,
					"subscribed_item_id" => $test_item_id_2
				]);


				// ACT 

				$memberships = $MC->getMembers();

				// debug([$memberships]);


				// ASSERT 

				if(
					$test_item_id_1 &&
					$test_item_id_2 &&
					$test_user_id_1 &&
					$test_user_id_2 &&
					$test_user_id_3 &&
					$test_user_id_4 &&

					count($memberships) == 4 &&
					$memberships[0]["item_id"] == $test_item_id_1 &&
					$memberships[0]["user_id"] == $test_user_id_1 &&
					$memberships[0]["item"]["prices"][0]["price"] == 100 &&
					$memberships[0]["order"]["items"][0]["total_price"] == 100 &&
					$memberships[1]["item_id"] == $test_item_id_1 &&
					$memberships[1]["user_id"] == $test_user_id_2 &&
					$memberships[1]["item"]["prices"][0]["price"] == 100 &&
					$memberships[1]["order"]["items"][0]["total_price"] == 100 &&
					$memberships[2]["item_id"] == $test_item_id_2 &&
					$memberships[2]["user_id"] == $test_user_id_3 &&
					$memberships[2]["item"]["prices"][0]["price"] == 150 &&
					$memberships[2]["order"]["items"][0]["total_price"] == 150 &&
					$memberships[3]["item_id"] == $test_item_id_2 &&
					$memberships[3]["user_id"] == $test_user_id_4 &&
					$memberships[3]["item"]["prices"][0]["price"] == 150 &&
					$memberships[3]["order"]["items"][0]["total_price"] == 50
				): ?>
				<div class="testpassed"><p>SuperMember::getMembers – no parameters sent – return all members – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::getMembers – no parameters sent – return all members – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["user_id" => $test_user_id_3]);
				$test_model->cleanUp(["user_id" => $test_user_id_4]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getMembers – send parameter 'only_active_members' – return all active members ") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"nickname" => "Tester 1",
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"nickname" => "Tester 2",
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_3 = $test_model->createTestUser([
					"nickname" => "Tester 3",
					"subscribed_item_id" => $test_item_id_2
				]);
				$test_user_id_4 = $test_model->createTestUser([
					"nickname" => "Tester 4",
					"subscription_custom_price" => 50,
					"subscribed_item_id" => $test_item_id_2
				]);


				$membership_2 = $MC->getMembers(["user_id" => $test_user_id_2]);

				// cancel membership for test_user_2
				$cancellation = $MC->cancelMembership(["cancelMembership", $test_user_id_2, $membership_2["id"]]);

	
				// ACT 

				$memberships = $MC->getMembers(["only_active_members" => true]);
				// debug([$cancellation, $memberships]);


				// ASSERT 

				if(
					$test_item_id_1 &&
					$test_item_id_2 &&
					$test_user_id_1 &&
					$test_user_id_2 &&
					$test_user_id_3 &&
					$test_user_id_4 &&

					$cancellation === true &&

					count($memberships) == 3 &&
					$memberships[0]["item_id"] == $test_item_id_1 &&
					$memberships[0]["user_id"] == $test_user_id_1 &&
					$memberships[0]["item"]["prices"][0]["price"] == 100 &&
					$memberships[0]["order"]["items"][0]["total_price"] == 100 &&
					$memberships[1]["item_id"] == $test_item_id_2 &&
					$memberships[1]["user_id"] == $test_user_id_3 &&
					$memberships[1]["item"]["prices"][0]["price"] == 150 &&
					$memberships[1]["order"]["items"][0]["total_price"] == 150 &&
					$memberships[2]["item_id"] == $test_item_id_2 &&
					$memberships[2]["user_id"] == $test_user_id_4 &&
					$memberships[2]["item"]["prices"][0]["price"] == 150 &&
					$memberships[2]["order"]["items"][0]["total_price"] == 50
				): ?>
				<div class="testpassed"><p>SuperMember::getMembers – send parameter 'only_active_members' – return all active members – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::getMembers – send parameter 'only_active_members' – return all active members – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["user_id" => $test_user_id_3]);
				$test_model->cleanUp(["user_id" => $test_user_id_4]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests getMemberCount">
		<h3>getMemberCount</h3>
		<?

		if(1 && "getMemberCount no parameters, memberships exist – count all memberships, return member count as string") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_3 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_2
				]);
				$test_user_id_4 = $test_model->createTestUser([
					"subscription_custom_price" => 50,
					"subscribed_item_id" => $test_item_id_2
				]);


				// ACT 

				$member_count = $MC->getMemberCount();


				// ASSERT 

				if(
					$test_item_id_1 &&
					$test_item_id_2 &&
					$test_user_id_1 &&
					$test_user_id_2 &&
					$test_user_id_3 &&
					$test_user_id_4 &&
					$member_count &&
					$member_count === "4"
				): ?>
				<div class="testpassed"><p>SuperMember::getMemberCount – no parameters, memberships exist – count all memberships, return member count as string – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::getMemberCount – no parameters, memberships exist – count all memberships, return member count as string – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["user_id" => $test_user_id_3]);
				$test_model->cleanUp(["user_id" => $test_user_id_4]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getMemberCount no parameters, no memberships exist – return 0") {

			(function() {

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

				message()->resetMessages();

			})();

		}

		if(1 && "getMemberCount by item_id, memberships exist – count all memberships, return member count as string") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_3 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_2
				]);
				$test_user_id_4 = $test_model->createTestUser([
					"subscription_custom_price" => 50,
					"subscribed_item_id" => $test_item_id_2
				]);


				// ACT 

				$member_count = $MC->getMemberCount(["item_id" => $test_item_id_2]);


				// ASSERT 

				if(
					$member_count &&
					$member_count === "2"
				): ?>
				<div class="testpassed"><p>SuperMember::getMemberCount – by item_id, memberships exist – count all memberships, return member count as string – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::getMemberCount – by item_id, memberships exist – count all memberships, return member count as string – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["user_id" => $test_user_id_3]);
				$test_model->cleanUp(["user_id" => $test_user_id_4]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getMemberCount by item_id, no memberships exists – should return 0") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();


				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);


				// ACT 

				$member_count = $MC->getMemberCount(["item_id" => $test_item_id]);


				// ASSERT 

				if(
					$member_count === "0"
				): ?>
				<div class="testpassed"><p>SuperMember::getMemberCount – by item_id, no memberships exists – should return "0" – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::getMemberCount – by item_id, no memberships exists – should return "0" – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "getMemberCount by invalid item_id, memberships exist – return 0") {

			(function() {

				// ARRANGE
				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_3 = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_2
				]);
				$test_user_id_4 = $test_model->createTestUser([
					"subscription_custom_price" => 50,
					"subscribed_item_id" => $test_item_id_2
				]);


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

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["user_id" => $test_user_id_3]);
				$test_model->cleanUp(["user_id" => $test_user_id_4]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
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
				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);
				$test_item_id_2 = $test_model->createTestItem([
					"price" => 150,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"nickname" => "Tester 1",
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"nickname" => "Tester 2",
					"subscribed_item_id" => $test_item_id_1
				]);
				$test_user_id_3 = $test_model->createTestUser([
					"nickname" => "Tester 3",
					"subscribed_item_id" => $test_item_id_2
				]);
				$test_user_id_4 = $test_model->createTestUser([
					"nickname" => "Tester 4",
					"subscription_custom_price" => 50,
					"subscribed_item_id" => $test_item_id_2
				]);

	
				// ACT 

				// Get membership to cancel member
				$membership_2 = $MC->getMembers(["user_id" => $test_user_id_2]);

				// cancel membership for test_user_2
				$cancellation = $MC->cancelMembership(["cancelMembership", $test_user_id_2, $membership_2["id"]]);

				$memberships = $MC->getMembers();
				// debug([$cancellation, $memberships]);


				// ASSERT 

				if(
					$test_item_id_1 &&
					$test_item_id_2 &&
					$test_user_id_1 &&
					$test_user_id_2 &&
					$test_user_id_3 &&
					$test_user_id_4 &&

					$cancellation === true &&

					count($memberships) == 4 &&
					$memberships[0]["item_id"] == $test_item_id_1 &&
					$memberships[0]["user_id"] == $test_user_id_1 &&
					$memberships[0]["item"]["prices"][0]["price"] == 100 &&
					$memberships[0]["order"]["items"][0]["total_price"] == 100 &&

					$memberships[1]["item_id"] == $test_item_id_2 &&
					$memberships[1]["user_id"] == $test_user_id_3 &&
					$memberships[1]["item"]["prices"][0]["price"] == 150 &&
					$memberships[1]["order"]["items"][0]["total_price"] == 150 &&

					$memberships[2]["item_id"] == $test_item_id_2 &&
					$memberships[2]["user_id"] == $test_user_id_4 &&
					$memberships[2]["item"]["prices"][0]["price"] == 150 &&
					$memberships[2]["order"]["items"][0]["total_price"] == 50 &&

					!$memberships[3]["item_id"] &&
					$memberships[3]["user_id"] == $test_user_id_2 &&
					!$memberships[3]["item"] &&
					!$memberships[3]["order"]

				): ?>
				<div class="testpassed"><p>SuperMember::cancelMembership – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::cancelMembership – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["user_id" => $test_user_id_3]);
				$test_model->cleanUp(["user_id" => $test_user_id_4]);
				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "cancelMembership – invalid membership – should return false") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_user_id = $test_model->createTestUser([
					"nickname" => "Tester 1",
				]);


				// ACT 

				$cancellation = $MC->cancelMembership(["cancelMembership", $test_user_id, 999999]);


				// ASSERT 
				if(
					$cancellation === false
				): ?>
				<div class="testpassed"><p>SuperMember::cancelMembership – invalid membership – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::cancelMembership – invalid membership – should return false – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id
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
				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id = $test_model->createTestUser([
					"nickname" => "Tester 1",
					"subscribed_item_id" => $test_item_id
				]);

	
				// ACT 

				// Get membership
				$membership = $MC->getMembers(["user_id" => $test_user_id]);

				$update = $MC->updateMembership(["user_id" => $test_user_id]);

				$membership_post = $MC->getMembers(["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$test_user_id &&
					$membership &&

					$update &&
					$update["id"] &&
					$update["user_id"] == $test_user_id &&
					$update["id"] == $membership["id"] &&
					$update["modified_at"] != $membership["modified_at"] &&

					$membership_post === $update
				): ?>
				<div class="testpassed"><p>SuperMember::updateMembership – no changes – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::updateMembership – no changes – error</p></div>
				<? endif; 


				// CLEAN UP

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

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"price" => 100,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_item_id_2 = $test_model->createTestItem([
					"price" => 200,
					"itemtype" => "membership",
					"subscription_method" => 2
				]);

				$test_user_id = $test_model->createTestUser([
					"nickname" => "Tester 1",
					"subscribed_item_id" => $test_item_id_1
				]);

	
				// ACT 

				// Get membership
				$membership = $MC->getMembers(["user_id" => $test_user_id]);
				$membership_subscription = $SuperSubscriptionClass->getSubscriptions(["subscription_id" => $membership["subscription_id"]]);

				$cancellation = $MC->cancelMembership(["cancelMembership", $test_user_id, $membership["id"]]);
				$cancelled_membership = $MC->getMembers(["user_id" => $test_user_id]);

				
				// Will invoke updateMembership as a result of ordered and subscribed callbacks
				$test_order = $test_model->createTestOrder([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id_2,
				]);

				// $update = $MC->updateMembership(["user_id" => $test_user_id]);

				$new_membership = $MC->getMembers(["user_id" => $test_user_id]);
				$new_membership_subscription = $SuperSubscriptionClass->getSubscriptions(["subscription_id" => $new_membership["subscription_id"]]);


				// ASSERT 

				if(
					$membership &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["order"]["items"][0]["total_price"] == 100 &&
					$membership_subscription["item_id"] == $test_item_id_1 &&
					$membership_subscription["order_id"] == $membership["order_id"] &&
					!$membership_subscription["custom_price"] &&

					$cancellation === true &&
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
				<div class="testpassed"><p>SuperMember::updateMembership – add subscription_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::updateMembership – add subscription_id – error</p></div>
				<? endif; 


				// CLEAN UP

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

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_user_id = $test_model->createTestUser([
					"nickname" => "Tester 1"
				]);


				// ACT 

				$updated_membership = $MC->updateMembership(["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$test_user_id &&
					$updated_membership === false
				): ?>
				<div class="testpassed"><p>SuperMember::updateMembership – no membership exists – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::updateMembership – no membership exists – should return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "updateMembership – no user_id sent") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();


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

				message()->resetMessages();
	
			})();

		}

		if(1 && "updateMembership – invalid user_id sent") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();


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

				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests switchMembership">
		<h3>switchMembership</h3>
		<?

		if(1 && "switchMembership – from no subscription to subscription") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


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
					"nickname" => "tester 1",
					"subscribed_item_id" => $test_item_id_1
				]);


				// ACT

				$membership = $MC->getMembers(["user_id" => $test_user_id]);

				$cancellation_success = $MC->cancelMembership(["cancelMembership", $test_user_id, $membership["id"]]);
				$cancelled_membership = $MC->getMembers(["user_id" => $test_user_id]);

				$_POST["item_id"] = $test_item_id_2;
				$order = $MC->switchMembership(["switchMembership", $test_user_id]);
				unset($_POST);

				$switched_membership = $MC->getMembers(["user_id" => $test_user_id]);


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
				<div class="testpassed"><p>SuperMember::switchMembership – from no subscription to subscription – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::switchMembership – from no subscription to subscription – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "switchMembership – from one subscription to another subscription") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


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
					"nickname" => "tester 1",
					"subscribed_item_id" => $test_item_id_1
				]);


				// ACT

				$membership = $MC->getMembers(["user_id" => $test_user_id]);

				$_POST["item_id"] = $test_item_id_2;
				$order = $MC->switchMembership(["switchMembership", $test_user_id]);
				unset($_POST);

				$switched_membership = $MC->getMembers(["user_id" => $test_user_id]);


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
				<div class="testpassed"><p>SuperMember::switchMembership – from one subscription to another subscription – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::switchMembership – from one subscription to another subscription – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "switchMembership – from subscription with custom price to another subscription") {

			(function() {

				// ARRANGE
				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();
				include_once("classes/shop/supersubscription.class.php");
				$SuperSubscriptionClass = new SuperSubscription();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


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
					"nickname" => "tester 1",
					"subscribed_item_id" => $test_item_id_1,
					"subscription_custom_price" => 50
				]);


				// ACT

				$membership = $MC->getMembers(["user_id" => $test_user_id]);
				$membership_subscription = $SuperSubscriptionClass->getSubscriptions(["subscription_id" => $membership["subscription_id"]]);

				$_POST["item_id"] = $test_item_id_2;
				$order = $MC->switchMembership(["switchMembership", $test_user_id]);
				unset($_POST);

				$switched_membership = $MC->getMembers(["user_id" => $test_user_id]);
				$switched_membership_subscription = $SuperSubscriptionClass->getSubscriptions(["subscription_id" => $switched_membership["subscription_id"]]);


				// ASSERT 

				if(
					$membership &&
					$membership["id"] === $switched_membership["id"] &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["order"]["items"][0]["total_price"] == 50 &&
					$membership_subscription["custom_price"] == 50 &&

					$order && 
					$switched_membership &&
					$switched_membership["item_id"] == $test_item_id_2 &&
					$switched_membership["subscription_id"] != $membership["subscription_id"] &&
					$switched_membership["order_id"] == $order["id"] &&
					$switched_membership["item"]["prices"][0]["price"] == 200 &&
					$switched_membership["order"]["items"][0]["total_price"] == 200 &&
					!$switched_membership_subscription["custom_price"]
				): ?>
				<div class="testpassed"><p>SuperMember::switchMembership – from subscription with custom price to another subscription – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::switchMembership – from subscription with custom price to another subscription – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "switchMembership – no membership exists") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);

				$test_user_id = $test_model->createTestUser([
					"nickname" => "tester 1",
				]);


				// ACT 

				$_POST["item_id"] = $test_item_id;
				$switched_membership_order = $MC->switchMembership(["switchMembership", $test_user_id]);
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

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "switchMembership – no user_id sent") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);

				$test_user_id = $test_model->createTestUser([
					"nickname" => "tester 1",
				]);


				// ACT 

				$_POST["item_id"] = $test_item_id;
				$switched_membership_order = $MC->switchMembership(["switchMembership"]);
				unset($_POST);
				$switched_membership = $MC->getMembers(["user_id" => $test_item_id]);


				// ASSERT 

				if(
					!$switched_membership_order &&
					$switched_membership === false
				): ?>
				<div class="testpassed"><p>SuperMember::switchMembership – no user_id sent – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::switchMembership – no user_id sent – should return false – error</p></div>
				<? endif; 


				// CLEAN UP 

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "switchMembership – invalid user_id sent") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 100
				]);

				$test_user_id = $test_model->createTestUser([
					"nickname" => "tester 1",
				]);


				// ACT 

				$_POST["item_id"] = $test_item_id;
				$switched_membership_order = $MC->switchMembership(["switchMembership", 99999]);
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

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


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

				$membership = $MC->getMembers(["user_id" => $test_user_id]);


				$_POST["item_id"] = $test_item_id_2;
				$upgrade_success = $MC->upgradeMembership(["upgradeMembership", $test_user_id]);
				unset($_POST);
				$upgraded_membership = $MC->getMembers(["user_id" => $test_user_id]);

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
				<div class="testpassed"><p>SuperMember::upgradeMembership – to more expensive subscription – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::upgradeMembership – to more expensive subscription – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "upgradeMembership – to cheaper (or equally priced) subscription – should return false") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_item_id_1 = $test_model->createTestItem([
					"name" => "Membership 1",
					"itemtype" => "membership",
					"subscription_method" => 2,
					"price" => 150
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

				$membership = $MC->getMembers(["user_id" => $test_user_id]);

				$_POST["item_id"] = $test_item_id_2;
				$upgrade_success = $MC->upgradeMembership(["upgradeMembership", $test_user_id]);
				unset($_POST);
				$upgraded_membership = $MC->getMembers(["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$membership &&
					$membership["id"] === $upgraded_membership["id"] &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 150 &&
					$membership["subscription_id"] &&
					$membership["order"]["items"][0]["total_price"] == 150 &&

					$upgrade_success === false &&

					$membership === $upgraded_membership
				): ?>
				<div class="testpassed"><p>SuperMember::upgradeMembership – to cheaper (or equally priced) subscription – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::upgradeMembership – to cheaper (or equally priced) subscription – should return false – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "upgradeMembership – existing membership has no subscription (is inactive) – should return false") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


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

				$membership = $MC->getMembers(["user_id" => $test_user_id]);

				// cancel membership
				$cancellation = $MC->cancelMembership(["cancelMembership", $test_user_id, $membership["id"]]);


				$_POST["item_id"] = $test_item_id_2;
				$upgrade_success = $MC->upgradeMembership(["upgradeMembership", $test_user_id]);
				unset($_POST);
				$upgraded_membership = $MC->getMembers(["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$membership &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["subscription_id"] &&
					$membership["order"]["items"][0]["total_price"] == 100 &&

					$upgrade_success === false &&

					$upgraded_membership["order"] === false &&
					$upgraded_membership["item_id"] === false
				): ?>
				<div class="testpassed"><p>SuperMember::upgradeMembership – existing membership has no subscription (is inactive) – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::upgradeMembership – existing membership has no subscription (is inactive) – should return false – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "upgradeMembership – no user_id sent") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


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

				$membership = $MC->getMembers(["user_id" => $test_user_id]);

				$_POST["item_id"] = $test_item_id_2;
				$upgrade_success = $MC->upgradeMembership(["upgradeMembership"]);
				unset($_POST);
				$upgraded_membership = $MC->getMembers(["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$membership &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["subscription_id"] &&
					$membership["order"]["items"][0]["total_price"] == 100 &&

					$upgrade_success === false &&

					$membership === $upgraded_membership
				): ?>
				<div class="testpassed"><p>SuperMember::upgradeMembership – no user_id sent – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::upgradeMembership – no user_id sent – should return false – error</p></div>
				<? endif; 


				// CLEAN UP 

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "upgradeMembership – invalid user_id sent") {

			(function() {

				// ARRANGE

				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


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

				$membership = $MC->getMembers(["user_id" => $test_user_id]);

				$_POST["item_id"] = $test_item_id_2;
				$upgrade_success = $MC->upgradeMembership(["upgradeMembership", 99999]);
				unset($_POST);
				$upgraded_membership = $MC->getMembers(["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$membership &&
					$membership["item_id"] == $test_item_id_1 &&
					$membership["item"]["prices"][0]["price"] == 100 &&
					$membership["subscription_id"] &&
					$membership["order"]["items"][0]["total_price"] == 100 &&

					$upgrade_success === false &&

					$membership === $upgraded_membership
				): ?>
				<div class="testpassed"><p>SuperMember::upgradeMembership – invalid user_id sent – should return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::upgradeMembership – invalid user_id sent – should return false – error</p></div>
				<? endif; 


				// CLEAN UP 

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "upgradeMembership – existing membership has no expiry – should return true, new expiry date based on current date") {

			(function() {

				// ARRANGE
				include_once("classes/users/supermember.class.php");
				$MC = new SuperMember();

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


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
					"price" => 150
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_item_id_1
				]);


				// ACT

				$membership = $MC->getMembers(["user_id" => $test_user_id]);

				$_POST["item_id"] = $test_item_id_2;
				$upgrade_success = $MC->upgradeMembership(["upgradeMembership", $test_user_id]);
				unset($_POST);
				$upgraded_membership = $MC->getMembers(["user_id" => $test_user_id]);
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
					$upgraded_membership["item"]["prices"][0]["price"] == 150
				): ?>
				<div class="testpassed"><p>SuperMember::upgradeMembership – existing membership has no expiry date – should return true, new expiry date based on current date – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperMember::upgradeMembership – existing membership has no expiry date – should return true, new expiry date based on current date – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2]
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

</div>
