<?

$fs = new FileSystem();
$query = new Query();

function createTestItem($_options = false) {

	$IC = new Items();

	$itemtype = "tests";
	$item_name = "Test item";

	if($_options !== false) {
		foreach($_options as $_option => $_value) {
			switch($_option) {
				case "itemtype"            : $itemtype              = $_value; break;
				case "item_name"           : $item_name             = $_value; break;
			}
		}
	}
	
	// create test item
	$model = $IC->TypeObject($itemtype);
	$_POST["name"] = $item_name;

	if($itemtype == "message") {
		
		$_POST["description"] = '{TEST_VALUE}';
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
	// $_POST["item_price_type"] = "default";
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
	$status = 1;
	$created_at = "2019-01-01 00:00:00";
	$email = "test.parentnode@gmail.com";

	if($_options !== false) {
		foreach($_options as $_option => $_value) {
			switch($_option) {
				case "user_group_id"        : $user_group_id              = $_value; break;
				case "nickname"             : $nickname                   = $_value; break;
				case "status"               : $status                     = $_value; break;
				case "created_at"           : $created_at                 = $_value; break;
				case "email"                : $email                      = $_value; break;
			}
		}
	}

	$_POST["user_group_id"] = $user_group_id;
	$_POST["nickname"] = $nickname;
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

		if(1 && "send message – pass item_id (itemtype == message) and user_id – return recipient list") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem(["itemtype" => "message", "item_name" => "Test message"]);
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
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message) and user_id – return recipient list – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message) and user_id – return recipient list – error</div>
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

				$test_message_item_id = createTestItem(["itemtype" => "message", "item_name" => "Test message"]);
				
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

		if(1 && "send message – pass item_id (itemtype == message) and recipients – return recipient list") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem(["itemtype" => "message", "item_name" => "Test message"]);

				
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
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message) and recipients – return recipient list – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message) and recipients – return recipient list – error</div>
				<? endif;
	
				// CLEAN UP
				deleteTestItem($test_message_item_id);

			})();


		}

		if(1 && "send message – pass item_id (itemtype == message), recipients, and values (same value for each recipient) – return recipient list") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem(["itemtype" => "message", "item_name" => "Test message"]);

				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "test.parentnode@gmail.com,test2.parentnode@gmail.com",
					"values" => ["TEST_VALUE" => "Same value for test and test2"]
					
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and values (same value for each recipient) – return recipient list – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and values (same value for each recipient) – return recipient list – error</div>
				<? endif;
	
				// CLEAN UP
				deleteTestItem($test_message_item_id);

			})();


		}

		if(1 && "send message – pass item_id (itemtype == message), recipients, and values (different values for each recipient) – return recipient list") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");

				$test_message_item_id = createTestItem(["itemtype" => "message", "item_name" => "Test message"]);

				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "test.parentnode@gmail.com,test2.parentnode@gmail.com",
					"values" => [
						"test.parentnode@gmail.com" => ["TEST_VALUE" => "Test value"],
						"test2.parentnode@gmail.com" => ["TEST_VALUE" => "Test2 value"]
					]
					
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and values (different values for each recipient) – return recipient list – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and values (different values for each recipient) – return recipient list – error</div>
				<? endif;
	
				// CLEAN UP
				deleteTestItem($test_message_item_id);

			})();


		}

		if(1 && "send message – pass item_id (itemtype == message), mailing list, and values (different values for each recipient) – return recipient list") {

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

				$test_message_item_id = createTestItem(["itemtype" => "message", "item_name" => "Test message"]);
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
						"test.parentnode@gmail.com" => ["TEST_VALUE" => "Test value (maillist)"],
						"test2.parentnode@gmail.com" => ["TEST_VALUE" => "Test2 value (maillist)"]
					]
					
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == "test.parentnode@gmail.com" &&
					$recipients[1] == "test2.parentnode@gmail.com"
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), mailing list, and values (different values for each recipient) – return recipient list – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), mailing list, and values (different values for each recipient) – return recipient list – error</div>
				<? endif;
	
				// CLEAN UP
				deleteTestMailingList($maillist_id);
				deleteTestUser($test_user_id_1);
				deleteTestUser($test_user_id_2);
				deleteTestItem($test_message_item_id);

			})();


		}



		


		?>
	</div>

</div>