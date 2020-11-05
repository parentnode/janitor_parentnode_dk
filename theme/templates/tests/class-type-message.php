<?

$fs = new FileSystem();
$query = new Query();

function createTestItem($_options = false) {

	$IC = new Items();

	$itemtype = "tests";
	$name = "Test item";

	if($_options !== false) {
		foreach($_options as $_option => $_value) {
			switch($_option) {
				case "itemtype"            : $itemtype              = $_value; break;
				case "name"           : $name             = $_value; break;
			}
		}
	}
	
	// create test item
	$model = $IC->TypeObject($itemtype);
	$_POST["name"] = $name;

	if($itemtype == "message") {
		
		$_POST["html"] = '<h2>Nickname: {NICKNAME}</h2><h2>Email: {EMAIL}</h2><h2>Username: {USERNAME}</h2><h2>Firstname: {FIRSTNAME}</h2><h2>Lastname: {LASTNAME}</h2><h2>Language: {LANGUAGE}</h2><h2>Verification code: {VERIFICATION_CODE}</h2><h2>Member ID: {MEMBER_ID}</h2><h2>Order no.: {ORDER_NO}</h2><h2>Membership price: {MEMBERSHIP_PRICE}</h2><h2>Membership: {MEMBERSHIP}</h2>';	
		$_POST["layout"] = 'template-a.html';
	}

	$item = $model->save(array("save"));
	$item_id = $item["id"];
	unset($_POST);


	// // add price to membership item
	// $_POST["item_price"] = 100;
	// $_POST["item_price_currency"] = "DKK";
	// $_POST["item_price_vatrate"] = 1;
	// $_POST["item_price_type"] = 1;
	// $membership_item_price = $model_membership->addPrice(array("addPrice", $membership_item_id));
	// unset($_POST);

	// // update test item subscription method
	// $_POST["item_subscription_method"] = 2;
	// $model_membership->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
	// unset($_POST);

	if($item_id) {

		return $item_id; 
	}

	return false;
}

function deleteTestItem($item_id) {
	$IC = new Items();
	$item = $IC->getItem(["id" => $item_id]);
	$itemtype = $item["itemtype"];
	$model = $IC->TypeObject($itemtype);

	
	return $model->delete(["delete",$item_id]);	
	
}

function createTestUser($_options = false) {
	$query = new Query();
	include_once("classes/users/superuser.class.php");
	$UC = new SuperUser();

	$user_group_id = 2;
	$nickname = "test user";
	$firstname = "Tester";
	$lastname = "Testerson";
	$status = 1;
	$created_at = "2019-01-01 00:00:00";
	$email = "test.parentnode@gmail.com";
	$membership = false;

	if($_options !== false) {
		foreach($_options as $_option => $_value) {
			switch($_option) {
				case "user_group_id"        : $user_group_id              = $_value; break;
				case "nickname"             : $nickname                   = $_value; break;
				case "firstname"            : $firstname                  = $_value; break;
				case "lastname"             : $lastname                   = $_value; break;
				case "status"               : $status                     = $_value; break;
				case "created_at"           : $created_at                 = $_value; break;
				case "email"                : $email                      = $_value; break;
				case "membership"           : $membership                 = $_value; break;
			}
		}
	}

	$_POST["user_group_id"] = $user_group_id;
	$_POST["nickname"] = $nickname;
	$_POST["firstname"] = $firstname;
	$_POST["lastname"] = $lastname;
	$_POST["status"] = $status;
	$_POST["created_at"] = $created_at;

	// create test user
	$user_id = $UC->save(["save"])["item_id"];
	unset($_POST);

	if($user_id) {

		$_POST["email"] = $email;
		$UC->updateEmail(["updateEmail", $user_id]);

		return $user_id;
	}

	return false;
}

function addTestMembership($user_id) {
	$IC = new Items();
	$query = new Query();
	include_once("classes/shop/supershop.class.php");
	$SC = new Supershop;
	include_once("classes/users/supermember.class.php");
	$MC = new SuperMember;

	// create test membership item
	$model = $IC->TypeObject("membership");
	$_POST["name"] = "Membership Test item 1";
	$membership_item = $model->save(array("save"));
	$membership_item_id = $membership_item["id"];
	unset($_POST);

	// add subscription method to membership item
	$_POST["item_subscription_method"] = 1;
	$model->updateSubscriptionMethod(array("updateSubscriptionMethod", $membership_item_id));
	unset($_POST);
	
	// add price to membership item
	$_POST["item_price"] = 100;
	$_POST["item_price_currency"] = "DKK";
	$_POST["item_price_vatrate"] = 1;
	$_POST["item_price_type"] = 1;
	$membership_item_price = $model->addPrice(array("addPrice", $membership_item_id));
	unset($_POST);

	$membership_cart = $SC->addToNewInternalCart($membership_item_id, ["user_id" => $user_id]);
	$membership_cart_reference = $membership_cart["cart_reference"];
	$membership_cart_id = $membership_cart["id"];
	$membership_order = $SC->newOrderFromCart(["newOrderFromCart", $membership_cart_id, $membership_cart_reference]);
	$membership = $MC->getMembers(["user_id" => $user_id]);

	return $membership ? $membership : false;
}

function deleteTestMembership($membership) {
	
	$query = new Query();

	if($membership) {

		// delete memberships
		$sql = "DELETE FROM ".SITE_DB.".user_members WHERE id = ".$membership["id"];
		$query->sql($sql);
	
		// delete subscriptions
		$sql = "DELETE FROM ".SITE_DB.".user_item_subscriptions WHERE item_id = ".$membership["item_id"];
		$query->sql($sql);
	
		// delete membership items
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = ".$membership["item_id"];
		$query->sql($sql);
		
		// delete orders
		$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = ".$membership["order_id"];
		$query->sql($sql);
	}

}

function deleteTestUser($user_id) {
	$query = new Query();

	$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $user_id";
	if($query->sql($sql)) {
		return true;
	}

	return false;
}

function deleteTestMailingList($maillist_id) {
	$query = new Query();

	// delete maillist subscriptions
	$sql = "DELETE FROM ".SITE_DB.".user_maillists WHERE maillist_id = $maillist_id";
	if($query->sql($sql)) {
		
		// delete maillist
		$sql = "DELETE FROM ".SITE_DB.".system_maillists WHERE id = $maillist_id";
		if($query->sql($sql)) {

			return true;
		}

	}

	return false;
};



?>

<div class="scene i:scene tests">
	<h1>TypeMessage Class</h1>	
	<h2>Build and send dynamic messages</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests sendMessage">
		<h3>Itemtype::sendMessage</h3>
		<p>Note: many of these tests send out emails (currently to test.parentnode@gmail.com and test2.parentnode@gmail.com) which should be verified manually, according to the instructions in the email's subject line. </p>
		<? 

		if(1 && "send message – no parameters send – return null") {

			(function() {
				
				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");
				
				// ACT
				$recipients = $message_model->sendMessage([]);
				
				// ASSERT
				if(!isset($recipients)): ?>
				<div class="testpassed">TypeMessage::sendMessage – no parameters in $_options – return null – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – no parameters in $_options – return null – error</div>
				<? endif;
	
				//CLEAN UP

			})();

		}

		if(1 && "send message – pass only item_id – return null") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_item_id = createTestItem();
							
				// ACT
				$recipients = $message_model->sendMessage(["item_id" => $test_item_id]);

				// ASSERT
				if(!isset($recipients)): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass only item_id – return null – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass only item_id – return null – error</div>
				<? endif;

				//CLEAN UP
				deleteTestItem($test_item_id);

			})();

		}

		if(1 && "send message – pass item_id (itemtype != message) and user_id – return null") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem();
				$test_user_id = createTestUser();
				
				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"user_id" => $test_user_id
				]);
				
				// ASSERT
				if(
					!isset($recipients)
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype != message) and user_id – return null – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype != message) and user_id – return null – error</div>
				<? endif;
	
				//CLEAN UP
				deleteTestUser($test_user_id);
				deleteTestItem($test_message_item_id);

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message) and user_id – return recipient list and send Test Message 1") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem(["itemtype" => "message", "name" => "Test message 1: G'day! This should be gibberish: {TEST_VALUE}"]);
				$test_user_id = createTestUser();
				
				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"user_id" => $test_user_id
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com")
				: ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message) and user_id – return recipient list and send Test Message 1 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message) and user_id – return recipient list and send Test Message 1 – error</div>
				<? endif;
	
				//CLEAN UP
				deleteTestUser($test_user_id);
				deleteTestItem($test_message_item_id);

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message) and recipients (empty) – return null") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem(["itemtype" => "message"]);
				
				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => []
				]);
				
				// ASSERT
				if(
					!isset($recipients)
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message) and recipients (empty) – return null – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message) and recipients (empty) – return null – error</div>
				<? endif;
	
				//CLEAN UP
				deleteTestItem($test_message_item_id);

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message) and recipients – return recipient list and send Test Message 2") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem(["itemtype" => "message", "name" => "Test message 2: Bonjour recipient 1 and recipient 2! This should be gibberish: {TEST_VALUE}"]);

				
				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "test.parentnode@gmail.com,test2.parentnode@gmail.com"
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message) and recipients – return recipient list and send Test Message 2 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message) and recipients – return recipient list and send Test Message 2 – error</div>
				<? endif;
	
				// CLEAN UP
				deleteTestItem($test_message_item_id);

			})();


		}

		if(1 && "send message – pass item_id (itemtype == message), recipients, and value (same value for each recipient) – return recipient list and send Test Message 3") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem(["itemtype" => "message", "name" => "Test message 3: {TEST_VALUE}"]);

				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "test.parentnode@gmail.com,test2.parentnode@gmail.com",
					"values" => ["TEST_VALUE" => "Greetings, recipient 1 and recipient 2!"]
					
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and value (same value for each recipient) – return recipient list and send Test Message 3 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and value (same value for each recipient) – return recipient list and send Test Message 3 – error</div>
				<? endif;
	
				// CLEAN UP
				deleteTestItem($test_message_item_id);

			})();


		}

		if(1 && "send message – pass item_id (itemtype == message), recipients, and several values (same values for each recipient) – return recipient list and send Test Message 4") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem(["itemtype" => "message", "name" => "Test message 4: {TEST_VALUE} {TEST_VALUE_2}"]);

				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "test.parentnode@gmail.com,test2.parentnode@gmail.com",
					"values" => ["TEST_VALUE" => "Howdy, recipient 1 and recipient 2!", "TEST_VALUE_2" => "Here's a second custom value."]
					
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and several values (same values for each recipient) – return recipient list and send Test Message 4 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and several values (same values for each recipient) – return recipient list and send Test Message 4 – error</div>
				<? endif;
	
				// CLEAN UP
				deleteTestItem($test_message_item_id);

			})();


		}

		if(1 && "send message – pass item_id (itemtype == message), recipients, and values (different values for each recipient) – return recipient list and send Test Message 5") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem(["itemtype" => "message", "name" => "Test message 5: {TEST_VALUE}"]);

				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "test.parentnode@gmail.com,test2.parentnode@gmail.com",
					"values" => [
						"test.parentnode@gmail.com" => ["TEST_VALUE" => "Hi, recipient 1! Check that this 'Hi' was also sent to recipient 2, with a different value."],
						"test2.parentnode@gmail.com" => ["TEST_VALUE" => "Hi, recipient 2! Check that this 'Hi' was also sent to recipient 1, with a different value."]
					]
					
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and values (different values for each recipient) – return recipient list and send Test Message 5 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and values (different values for each recipient) – return recipient list and send Test Message 5 – error</div>
				<? endif;
	
				// CLEAN UP
				deleteTestItem($test_message_item_id);

			})();


		}

		if(1 && "send message – pass item_id (itemtype == message), mailing list, and values (different values for each recipient) – and send Test Message 6") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");
				include_once("classes/system/system.class.php");
				$SysC = new System();
				$UC = new  SuperUser();

				$_POST["maillist"] = "Test mailing list";
				$maillist_id = $SysC->addMaillist(["addMaillist"])["item_id"];
				unset($_POST);

				$test_message_item_id = createTestItem(["itemtype" => "message", "name" => "Test message 6: {TEST_VALUE}"]);
				$test_user_id_1 = createTestUser();
				$test_user_id_2 = createTestUser(["email" => "test2.parentnode@gmail.com"]);

				$_POST["maillist_id"] = $maillist_id;
				$UC->addMaillist(["addMaillist", $test_user_id_1]);
				$UC->addMaillist(["addMaillist", $test_user_id_2]);
				unset($_POST);

				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"maillist_id" => $maillist_id,
					"values" => [
						"test.parentnode@gmail.com" => ["TEST_VALUE" => "Hello, maillist subscriber 1! Check that this 'Hello' was also sent to recipient 2, with a different value."],
						"test2.parentnode@gmail.com" => ["TEST_VALUE" => "Hello, maillist subscriber 2! Check that this 'Hello' was also sent to recipient 1, with a different value."]
					]
					
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), mailing list, and values (different values for each recipient) – and send Test Message 6 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), mailing list, and values (different values for each recipient) – and send Test Message 6 – error</div>
				<? endif;
	
				// CLEAN UP
				deleteTestMailingList($maillist_id);
				deleteTestUser($test_user_id_1);
				deleteTestUser($test_user_id_2);
				deleteTestItem($test_message_item_id);

			})();


		}

		if(1 && "send message – pass item_id (itemtype == message), user_id (user is paying member), and custom value – return recipient list and send Test Message 7") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop;

				$test_message_item_id = createTestItem(["itemtype" => "message", "name" => "Test message 7: {TEST_VALUE}"]);
				$test_user_id = createTestUser([
					"nickname" => "This is the correct nickname",
					"firstname" => "Tester (correct)",
					"lastname" => "Testerson (correct)"
				]);
				$test_membership = addTestMembership($test_user_id);

				
				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"user_id" => $test_user_id,
					"values" => [
						"TEST_VALUE" => "Salutations! Check that all variables are correct inside this one."
					]
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com")
				: ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), user_id (user is paying member), and custom value – return recipient list and send Test Message 7 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), user_id (user is paying member), and custom value – return recipient list and send Test Message 7 – error</div>
				<? endif;
	
				//CLEAN UP
				deleteTestMembership($test_membership);
				deleteTestUser($test_user_id);
				deleteTestItem($test_message_item_id);

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message), maillist (subscribers are paying members), and custom value array, which will override default values for maillist subscriber 1, but not for subscriber 2 – return recipient list and send Test Message 8") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");
				include_once("classes/shop/supershop.class.php");
				include_once("classes/system/system.class.php");
				$SysC = new System();
				include_once("classes/users/superuser.class.php");
				$UC = new SuperUser();

				$_POST["maillist"] = "Test mailing list";
				$maillist_id = $SysC->addMaillist(["addMaillist"])["item_id"];
				unset($_POST);

				$test_message_item_id = createTestItem(["itemtype" => "message", "name" => "Test message 8: Hey! {TEST_VALUE}"]);
				$test_user_id_1 = createTestUser();
				$test_membership_1 = addTestMembership($test_user_id_1);
				$test_user_id_2 = createTestUser(["email" => "test2.parentnode@gmail.com"]);
				$test_membership_2 = addTestMembership($test_user_id_2);

				$_POST["maillist_id"] = $maillist_id;
				$UC->addMaillist(["addMaillist", $test_user_id_1]);
				$UC->addMaillist(["addMaillist", $test_user_id_2]);
				unset($_POST);

				
				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"maillist_id" => $maillist_id,
					"values" => [
						"test.parentnode@gmail.com" => [
							"TEST_VALUE" => "Check that all values have been changed in this one. But not in the other 'Hey' test for recipient 2",
							"NICKNAME" => "I have been changed.",
							"EMAIL" => "I have been changed.",
							"USERNAME" => "I have been changed.",
							"FIRSTNAME" => "I have been changed.",
							"LASTNAME" => "I have been changed.",
							"LANGUAGE" => "I have been changed.",
							"VERIFICATION_CODE" => "I have been changed.",
							"MEMBER_ID" => "I have been changed.",
							"ORDER_NO" => "I have been changed.",
							"MEMBERSHIP_PRICE" => "I have been changed",
							"MEMBERSHIP" => "I have been changed."
						]
					]
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				)
				: ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), maillist (subscribers are paying members), and custom value array, which will override default values for maillist subscriber 1, but not for subscriber 2 – return recipient list and send Test Message 8 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), maillist (subscribers are paying members), and custom value array, which will override default values for maillist subscriber 1, but not for subscriber 2 – return recipient list and send Test Message 8 – error</div>
				<? endif;
	
				//CLEAN UP
				deleteTestMailingList($maillist_id);
				deleteTestMembership($test_membership_1);
				deleteTestMembership($test_membership_2);
				deleteTestUser($test_user_id_1);
				deleteTestUser($test_user_id_2);
				deleteTestItem($test_message_item_id);

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message), maillist (subscribers are paying members), and custom value array, which will override default values for both subscribers – return recipient list and send Test Message 9") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");
				include_once("classes/shop/supershop.class.php");
				include_once("classes/system/system.class.php");
				$SysC = new System();
				include_once("classes/users/superuser.class.php");
				$UC = new SuperUser();

				$_POST["maillist"] = "Test mailing list";
				$maillist_id = $SysC->addMaillist(["addMaillist"])["item_id"];
				unset($_POST);

				$test_message_item_id = createTestItem(["itemtype" => "message", "name" => "Test message 9: Hola! {TEST_VALUE}"]);
				$test_user_id_1 = createTestUser();
				$test_membership_1 = addTestMembership($test_user_id_1);
				$test_user_id_2 = createTestUser(["email" => "test2.parentnode@gmail.com"]);
				$test_membership_2 = addTestMembership($test_user_id_2);

				$_POST["maillist_id"] = $maillist_id;
				$UC->addMaillist(["addMaillist", $test_user_id_1]);
				$UC->addMaillist(["addMaillist", $test_user_id_2]);
				unset($_POST);

				
				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"maillist_id" => $maillist_id,
					"values" => [
						"TEST_VALUE" => "Check that all values have been changed for both recipient 1 and recipient 2",
						"NICKNAME" => "I have been changed.",
						"EMAIL" => "I have been changed.",
						"USERNAME" => "I have been changed.",
						"FIRSTNAME" => "I have been changed.",
						"LASTNAME" => "I have been changed.",
						"LANGUAGE" => "I have been changed.",
						"VERIFICATION_CODE" => "I have been changed.",
						"MEMBER_ID" => "I have been changed.",
						"ORDER_NO" => "I have been changed.",
						"MEMBERSHIP_PRICE" => "I have been changed",
						"MEMBERSHIP" => "I have been changed."
					]
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				)
				: ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), maillist (subscribers are paying members), and custom value array, which will override default values for both subscribers – return recipient list and send Test Message 9 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), maillist (subscribers are paying members), and custom value array, which will override default values for both subscribers – return recipient list and send Test Message 9 – error</div>
				<? endif;
	
				//CLEAN UP
				deleteTestMailingList($maillist_id);
				deleteTestMembership($test_membership_1);
				deleteTestMembership($test_membership_2);
				deleteTestUser($test_user_id_1);
				deleteTestUser($test_user_id_2);
				deleteTestItem($test_message_item_id);

			})();

		}
		
		if(1 && "send message – pass item_id (itemtype == message), maillist (subscribers are paying members), and custom value array, which will override default values with specific values for subscriber 1 and with general values for subscriber 2 – return recipient list and send Test Message 10") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");
				include_once("classes/shop/supershop.class.php");
				include_once("classes/system/system.class.php");
				$SysC = new System();
				include_once("classes/users/superuser.class.php");
				$UC = new SuperUser();

				$_POST["maillist"] = "Test mailing list";
				$maillist_id = $SysC->addMaillist(["addMaillist"])["item_id"];
				unset($_POST);

				$test_message_item_id = createTestItem(["itemtype" => "message", "name" => "Test message 10: Ciao! {TEST_VALUE}"]);
				$test_user_id_1 = createTestUser();
				$test_membership_1 = addTestMembership($test_user_id_1);
				$test_user_id_2 = createTestUser(["email" => "test2.parentnode@gmail.com"]);
				$test_membership_2 = addTestMembership($test_user_id_2);

				$_POST["maillist_id"] = $maillist_id;
				$UC->addMaillist(["addMaillist", $test_user_id_1]);
				$UC->addMaillist(["addMaillist", $test_user_id_2]);
				unset($_POST);

				
				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"maillist_id" => $maillist_id,
					"values" => [
						"TEST_VALUE" => "Check that all values have been changed to general values",
						"NICKNAME" => "I have been changed to a general value.",
						"EMAIL" => "I have been changed to a general value.",
						"USERNAME" => "I have been changed to a general value.",
						"FIRSTNAME" => "I have been changed to a general value.",
						"LASTNAME" => "I have been changed to a general value.",
						"LANGUAGE" => "I have been changed to a general value.",
						"VERIFICATION_CODE" => "I have been changed to a general value.",
						"MEMBER_ID" => "I have been changed to a general value.",
						"ORDER_NO" => "I have been changed to a general value.",
						"MEMBERSHIP_PRICE" => "I have been changed to a general value",
						"MEMBERSHIP" => "I have been changed to a general value.",
						"test.parentnode@gmail.com" => [
							"TEST_VALUE" => "Check that all values have been changed to user specific values",
							"NICKNAME" => "I have been changed to a user specific value.",
							"EMAIL" => "I have been changed to a user specific value.",
							"USERNAME" => "I have been changed to a user specific value.",
							"FIRSTNAME" => "I have been changed to a user specific value.",
							"LASTNAME" => "I have been changed to a user specific value.",
							"LANGUAGE" => "I have been changed to a user specific value.",
							"VERIFICATION_CODE" => "I have been changed to a user specific value.",
							"MEMBER_ID" => "I have been changed to a user specific value.",
							"ORDER_NO" => "I have been changed to a user specific value.",
							"MEMBERSHIP_PRICE" => "I have been changed to a user specific value",
							"MEMBERSHIP" => "I have been changed to a user specific value."
						]
						
					]
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				)
				: ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), maillist (subscribers are paying members), and custom value array, which will override default values with specific values for subscriber 1 and with general values for subscriber 2 – return recipient list and send Test Message 10 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), maillist (subscribers are paying members), and custom value array, which will override default values with specific values for subscriber 1 and with general values for subscriber 2 – return recipient list and send Test Message 10 – error</div>
				<? endif;
	
				//CLEAN UP
				deleteTestMailingList($maillist_id);
				deleteTestMembership($test_membership_1);
				deleteTestMembership($test_membership_2);
				deleteTestUser($test_user_id_1);
				deleteTestUser($test_user_id_2);
				deleteTestItem($test_message_item_id);

			})();

		}



		


		?>
	</div>

</div>