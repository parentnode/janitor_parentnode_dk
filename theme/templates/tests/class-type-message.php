<?


// Set custom test emails – DO NOT USE THE EMAIL OF YOUR JANITOR ACCOUNT, OR TEST CANNOT BE COMPLETED

global $mail_1;
// $mail_1 = "test.parentnode@gmail.com";
$mail_1 = "martin@parentnode.dk";

global $mail_2;
// $mail_2 = "test2.parentnode@gmail.com";
$mail_2 = "martin@kaestel.dk";


?>

<div class="scene i:scene tests">
	<h1>TypeMessage Class</h1>	
	<h2>Build and send dynamic messages</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests sendMessage">
		<h3>Itemtype::sendMessage</h3>
		<p>Note: many of these tests send out emails (currently to <?= $mail_1 ?> and <?= $mail_2 ?>) which should be verified manually, according to the instructions in the email's subject line. </p>
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

	
				// CLEAN UP

				message()->resetMessages();

			})();

		}

		if(1 && "send message – pass only item_id – return null") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem();


				// ACT

				$recipients = $message_model->sendMessage(["item_id" => $test_item_id]);


				// ASSERT

				if(!isset($recipients)): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass only item_id – return null – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass only item_id – return null – error</div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – pass item_id (itemtype != message) and user_id – return null") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem();
				$test_user_id = $test_model->createTestUser();


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_item_id,
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


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message) and recipients (empty) – return null") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message"
				]);


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


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message) and user_id – return recipient list and send Test Message 1") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				global $mail_1;

				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 1: {TEST_VALUE}",
					"html" => "<h2>Send to user_id</h2><h3>Test value: {TEST_VALUE}</h3><p>Test value in header and body should <strong>not</strong> be replaced</p>",
				]);
				$test_user_id = $test_model->createTestUser([
					"email" => $mail_1
				]);


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"user_id" => $test_user_id
				]);
				// debug([$test_message_item_id, $recipients]);


				// ASSERT

				if(
					is_array($recipients) &&
					$recipients[0] == $mail_1)
				: ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message) and user_id – return recipient list and send Test Message 1 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message) and user_id – return recipient list and send Test Message 1 – error</div>
				<? endif;


				//CLEAN UP

				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message) and recipients – return recipient list and send Test Message 2") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				global $mail_1;
				global $mail_2;


				// name has a 100 char limit
				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 2: {TEST_VALUE}",
					"html" => "<h3>Send to recipients array with $mail_1 and $mail_2!</h3><h3>Test value: {TEST_VALUE}</h3><p>Test value in header and body should <strong>not</strong> be replaced</p>",
				]);


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "$mail_1,$mail_2"
				]);
				// debug([$test_message_item_id, $recipients, message()->getMessages()]);


				// ASSERT

				if(
					is_array($recipients) &&
					$recipients[0] == $mail_1 &&
					$recipients[1] == $mail_2
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message) and recipients – return recipient list and send Test Message 2 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message) and recipients – return recipient list and send Test Message 2 – error</div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message), recipients, and value (same value for each recipient) – return recipient list and send Test Message 3") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				global $mail_1;
				global $mail_2;

				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 3: {TEST_VALUE}",
					"html" => "<h2>Send to recipients array, using on value</h2><h3>Test value: {TEST_VALUE}</h3><p>Test value in header and body should be replaced with: Greetings</p>",
				]);


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "$mail_1,$mail_2",
					"values" => [
						"TEST_VALUE" => "Greetings"
					]
				]);


				// ASSERT

				if(
					is_array($recipients) &&
					$recipients[0] == $mail_1 &&
					$recipients[1] == $mail_2
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and value (same value for each recipient) – return recipient list and send Test Message 3 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and value (same value for each recipient) – return recipient list and send Test Message 3 – error</div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message), recipients, and several values (same values for each recipient) – return recipient list and send Test Message 4") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				global $mail_1;
				global $mail_2;

				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 4",
					"html" => "<h2>Send to recipients array with two values</h2><h3>Test value: {TEST_VALUE}</h3><h3>Test value: {TEST_VALUE_2}</h3><p>Test value in body should be replaced with for both recipients: Howdy and G'day</p>",
				]);


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "$mail_1,$mail_2",
					"values" => [
						"TEST_VALUE" => "Howdy", 
						"TEST_VALUE_2" => "G'day"
					]
				]);


				// ASSERT

				if(
					is_array($recipients) &&
					$recipients[0] == $mail_1 &&
					$recipients[1] == $mail_2
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and several values (same values for each recipient) – return recipient list and send Test Message 4 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and several values (same values for each recipient) – return recipient list and send Test Message 4 – error</div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				message()->resetMessages();

			})();


		}

		if(1 && "send message – pass item_id (itemtype == message), recipients, and values (different values for each recipient) – return recipient list and send Test Message 5") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				global $mail_1;
				global $mail_2;

				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 5",
					"html" => "<h2>Send to recipients array with value array</h2><h3>Test value: {TEST_VALUE}</h3><p>Test value in body should be replaced with different texts for each recipient.</p>",
				]);

				// ACT
				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "$mail_1,$mail_2",
					"values" => [
						$mail_1 => ["TEST_VALUE" => "Hi, $mail_1! Check that this 'Hi' was also sent to $mail_2, with a different value."],
						$mail_2 => ["TEST_VALUE" => "Hi, $mail_2! Check that this 'Hi' was also sent to $mail_1, with a different value."]
					]
				]);
				
				// ASSERT
				if(
					is_array($recipients) &&
					$recipients[0] == $mail_1 &&
					$recipients[1] == $mail_2
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and values (different values for each recipient) – return recipient list and send Test Message 5 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and values (different values for each recipient) – return recipient list and send Test Message 5 – error</div>
				<? endif;
	
				// CLEAN UP
				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message), mailing list, and values (different values for each recipient) – and send Test Message 6") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				include_once("classes/users/superuser.class.php");
				$UC = new SuperUser();


				global $mail_1;
				global $mail_2;


				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 6",
					"html" => "<h2>Send to maillist with two subscribers</h2><h3>Test value: {TEST_VALUE}</h3><p>Test value in body and preview should be replaced with different texts for each recipient.</p>",
					"mail_preview" => "Hej {PREVIEW}",
				]);
				$test_user_id_1 = $test_model->createTestUser([
					"email" => $mail_1
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"email" => $mail_2
				]);


				$maillist_id = $test_model->createTestMaillist("Test mailing list");

				$_POST["maillist_id"] = $maillist_id;
				$UC->addMaillist(["addMaillist", $test_user_id_1]);
				$UC->addMaillist(["addMaillist", $test_user_id_2]);
				unset($_POST);


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"maillist_id" => $maillist_id,
					"values" => [
						$mail_1 => ["TEST_VALUE" => "Hello, maillist subscriber 1! Check that this 'Hello' was also sent to recipient 2, with a different value.", "PREVIEW" => "test 1"],
						$mail_2 => ["TEST_VALUE" => "Hello, maillist subscriber 2! Check that this 'Hello' was also sent to recipient 1, with a different value.", "PREVIEW" => "test 2"]
					]
				]);
				// debug([$recipients, message()->getMessages()]);


				// ASSERT

				if(
					is_array($recipients) &&
					$recipients[0] == $mail_1 &&
					$recipients[1] == $mail_2
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), mailing list, and values (different values for each recipient) – and send Test Message 6 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), mailing list, and values (different values for each recipient) – and send Test Message 6 – error</div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["maillist_id" => $maillist_id]);
				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – buy membership send Test Message 7") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");


				global $mail_1;


				// ACT

				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 7",
					"html" => "<h2>Send to paying member – values should be filled out</h2><h3>Nickname: {NICKNAME}</h3><h3>Email: {EMAIL}</h3><h3>Username: {USERNAME}</h3><h3>Firstname: {FIRSTNAME}</h3><h3>Lastname: {LASTNAME}</h3><h3>Language: {LANGUAGE}</h3><h3>Verification code: {VERIFICATION_CODE}</h3><h3>Member ID: {MEMBER_ID}</h3><h3>Order no.: {ORDER_NO}</h3><h3>Membership price: {MEMBERSHIP_PRICE}</h3><h3>Membership: {MEMBERSHIP}</h3>"
				]);

				$test_membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership", 
					"name" => "Membership Test item 1",
					"subscribed_message_id" => $test_message_item_id,
					"subscription_method" => 1,
					"price" => 100,
				]);

				$test_user_id = $test_model->createTestUser([
					"nickname" => "This is the correct nickname",
					"firstname" => "Tester",
					"lastname" => "Testerson",
					"email" => $mail_1,
					"subscribed_item_id" => $test_membership_item_id
				]);


				// ASSERT

				if(
					$test_user_id &&
					$test_membership_item_id
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – buy membership send Test Message 7 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – buy membership send Test Message 7 – error</div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id]);
				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – buy membership, custom price send Test Message 8") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				global $mail_1;


				// ACT

				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 8",
					"html" => "<h2>Send to paying member – values should be filled out</h2><h3>Nickname: {NICKNAME}</h3><h3>Email: {EMAIL}</h3><h3>Username: {USERNAME}</h3><h3>Firstname: {FIRSTNAME}</h3><h3>Lastname: {LASTNAME}</h3><h3>Language: {LANGUAGE}</h3><h3>Verification code: {VERIFICATION_CODE}</h3><h3>Member ID: {MEMBER_ID}</h3><h3>Order no.: {ORDER_NO}</h3><h3>Membership price: {MEMBERSHIP_PRICE}</h3><h3>Membership: {MEMBERSHIP}</h3>"
				]);

				$test_membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership", 
					"name" => "Membership Test item 1",
					"subscribed_message_id" => $test_message_item_id,
					"subscription_method" => 1,
					"price" => 100,
				]);

				$test_user_id = $test_model->createTestUser([
					"nickname" => "This is the correct nickname",
					"firstname" => "Tester",
					"lastname" => "Testerson",
					"email" => $mail_1,
				]);

				$test_order_id = $test_model->createTestOrder([
					"user_id" => $test_user_id,
					"item_id" => $test_membership_item_id,
					"custom_price" => 50
				]);


				// ASSERT

				if(
					$test_user_id &&
					$test_membership_item_id &&
					$test_order_id
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – buy membership send Test Message 8 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – buy membership send Test Message 8 – error</div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id]);
				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – existing member, buy new membership send Test Message 9") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				global $mail_1;


				// ACT

				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 9",
					"html" => "<h2>Send to paying member – values should be filled out</h2><h3>Nickname: {NICKNAME}</h3><h3>Email: {EMAIL}</h3><h3>Username: {USERNAME}</h3><h3>Firstname: {FIRSTNAME}</h3><h3>Lastname: {LASTNAME}</h3><h3>Language: {LANGUAGE}</h3><h3>Verification code: {VERIFICATION_CODE}</h3><h3>Member ID: {MEMBER_ID}</h3><h3>Order no.: {ORDER_NO}</h3><h3>Membership price: {MEMBERSHIP_PRICE}</h3><h3>Membership: {MEMBERSHIP}</h3>"
				]);

				$test_membership_item_id_1 = $test_model->createTestItem([
					"itemtype" => "membership", 
					"name" => "Membership Test item 1",
					"subscribed_message_id" => $test_message_item_id,
					"subscription_method" => 1,
					"price" => 100,
				]);
				$test_membership_item_id_2 = $test_model->createTestItem([
					"itemtype" => "membership", 
					"name" => "Membership Test item 2",
					"subscribed_message_id" => $test_message_item_id,
					"subscription_method" => 1,
					"price" => 200,
				]);

				$test_user_id = $test_model->createTestUser([
					"nickname" => "This is the correct nickname",
					"firstname" => "Tester",
					"lastname" => "Testerson",
					"email" => $mail_1,
					"subscribed_item_id" => $test_membership_item_id_1
				]);

				$test_order_id = $test_model->createTestOrder([
					"user_id" => $test_user_id,
					"item_id" => $test_membership_item_id_2
				]);


				// ASSERT

				if(
					$test_user_id &&
					$test_membership_item_id_1 &&
					$test_membership_item_id_2 &&
					$test_order_id
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – existing member, buy new membership send Test Message 9 twice with different memberships – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – existing member, buy new membership send Test Message 9 twice with different memberships – error</div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id_2]);
				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – maillist for members and custom value array, which will override default values for maillist subscriber 1, but not for subscriber 2 – send Test Message 10-1 and 10-2") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				include_once("classes/users/superuser.class.php");
				$UC = new SuperUser();


				global $mail_1;
				global $mail_2;


				$test_message_item_id_1 = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 10-1",
					"html" => "<h2>Subscribed to membership mail – values should be filled out</h2><h3>Nickname: {NICKNAME}</h3><h3>Email: {EMAIL}</h3><h3>Username: {USERNAME}</h3><h3>Firstname: {FIRSTNAME}</h3><h3>Lastname: {LASTNAME}</h3><h3>Language: {LANGUAGE}</h3><h3>Verification code: {VERIFICATION_CODE}</h3><h3>Member ID: {MEMBER_ID}</h3><h3>Order no.: {ORDER_NO}</h3><h3>Membership price: {MEMBERSHIP_PRICE}</h3><h3>Membership: {MEMBERSHIP}</h3>"
				]);

				$test_message_item_id_2 = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 10-2",
					"html" => "<h2>Send to maillist – values should be filled out</h2><h3>Nickname: {NICKNAME}</h3><h3>Email: {EMAIL}</h3><h3>Username: {USERNAME}</h3><h3>Firstname: {FIRSTNAME}</h3><h3>Lastname: {LASTNAME}</h3><h3>Language: {LANGUAGE}</h3><h3>Verification code: {VERIFICATION_CODE}</h3><h3>Member ID: {MEMBER_ID}</h3><h3>Order no.: {ORDER_NO}</h3><h3>Membership price: {MEMBERSHIP_PRICE}</h3><h3>Membership: {MEMBERSHIP}</h3>"
				]);

				$test_membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership", 
					"name" => "Membership Test item 1",
					"subscribed_message_id" => $test_message_item_id_1,
					"subscription_method" => 1,
					"price" => 100,
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"nickname" => "This is the correct nickname 1",
					"firstname" => "Tester",
					"lastname" => "Testerson",
					"email" => $mail_1,
					"subscribed_item_id" => $test_membership_item_id
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"nickname" => "This is the correct nickname 2",
					"firstname" => "Tester",
					"lastname" => "Testerson",
					"email" => $mail_2,
					"subscribed_item_id" => $test_membership_item_id
				]);


				$maillist_id = $test_model->createTestMaillist("Test mailing list 10");

				$_POST["maillist_id"] = $maillist_id;
				$UC->addMaillist(["addMaillist", $test_user_id_1]);
				$UC->addMaillist(["addMaillist", $test_user_id_2]);
				unset($_POST);


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id_2,
					"maillist_id" => $maillist_id,
					"values" => [
						$mail_1 => [
							"TEST_VALUE" => "Check that all values have been changed in this one. But not in message for recipient 2",
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
					$recipients[0] == $mail_1 &&
					$recipients[1] == $mail_2
				)
				: ?>
				<div class="testpassed">TypeMessage::sendMessage – maillist for members and custom value array, which will override default values for maillist subscriber 1, but not for subscriber 2 – send Test Message 10-1 and 10-2 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – maillist for members and custom value array, which will override default values for maillist subscriber 1, but not for subscriber 2 – send Test Message 10-1 and 10-2 – error</div>
				<? endif;


				//CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id]);
				$test_model->cleanUp(["item_id" => $test_message_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_message_item_id_2]);
				$test_model->cleanUp(["maillist_id" => $maillist_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – maillist for members and custom value array, which will override default values for both subscribers – send Test Message 11-1 and 11-2") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				include_once("classes/users/superuser.class.php");
				$UC = new SuperUser();

				global $mail_1;
				global $mail_2;


				$test_message_item_id_1 = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 11-1",
					"html" => "<h2>Subscribed to membership mail – values should be filled out</h2><h3>Nickname: {NICKNAME}</h3><h3>Email: {EMAIL}</h3><h3>Username: {USERNAME}</h3><h3>Firstname: {FIRSTNAME}</h3><h3>Lastname: {LASTNAME}</h3><h3>Language: {LANGUAGE}</h3><h3>Verification code: {VERIFICATION_CODE}</h3><h3>Member ID: {MEMBER_ID}</h3><h3>Order no.: {ORDER_NO}</h3><h3>Membership price: {MEMBERSHIP_PRICE}</h3><h3>Membership: {MEMBERSHIP}</h3>"
				]);

				$test_message_item_id_2 = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 11-2",
					"html" => "<h2>Send to maillist – values should be filled out with override values</h2><h3>Nickname: {NICKNAME}</h3><h3>Email: {EMAIL}</h3><h3>Username: {USERNAME}</h3><h3>Firstname: {FIRSTNAME}</h3><h3>Lastname: {LASTNAME}</h3><h3>Language: {LANGUAGE}</h3><h3>Verification code: {VERIFICATION_CODE}</h3><h3>Member ID: {MEMBER_ID}</h3><h3>Order no.: {ORDER_NO}</h3><h3>Membership price: {MEMBERSHIP_PRICE}</h3><h3>Membership: {MEMBERSHIP}</h3>"
				]);

				$test_membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership", 
					"name" => "Membership Test item 1",
					"subscribed_message_id" => $test_message_item_id_1,
					"subscription_method" => 1,
					"price" => 100,
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"nickname" => "This is the correct nickname 1",
					"firstname" => "Tester",
					"lastname" => "Testerson",
					"email" => $mail_1,
					"subscribed_item_id" => $test_membership_item_id
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"nickname" => "This is the correct nickname 2",
					"firstname" => "Tester",
					"lastname" => "Testerson",
					"email" => $mail_2,
					"subscribed_item_id" => $test_membership_item_id
				]);


				$maillist_id = $test_model->createTestMaillist("Test mailing list 11");

				$_POST["maillist_id"] = $maillist_id;
				$UC->addMaillist(["addMaillist", $test_user_id_1]);
				$UC->addMaillist(["addMaillist", $test_user_id_2]);
				unset($_POST);


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id_2,
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
					$recipients[0] == $mail_1 &&
					$recipients[1] == $mail_2
				)
				: ?>
				<div class="testpassed">TypeMessage::sendMessage – maillist for members and custom value array, which will override default values for both subscribers – send Test Message 11-1 and 11-2 – correct</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – maillist for members and custom value array, which will override default values for both subscribers – send Test Message 11-1 and 11-2 – error</div>
				<? endif;


				//CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id]);
				$test_model->cleanUp(["item_id" => $test_message_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_message_item_id_2]);
				$test_model->cleanUp(["maillist_id" => $maillist_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – maillist for members and custom value array, which will override default values for maillist subscriber 1, and specific values for subscriber 2 – send Test Message 12-1 and 12-2") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				include_once("classes/users/superuser.class.php");
				$UC = new SuperUser();


				global $mail_1;
				global $mail_2;


				$test_message_item_id_1 = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 12-1",
					"html" => "<h2>Subscribed to membership mail – values should be filled out</h2><h3>Nickname: {NICKNAME}</h3><h3>Email: {EMAIL}</h3><h3>Username: {USERNAME}</h3><h3>Firstname: {FIRSTNAME}</h3><h3>Lastname: {LASTNAME}</h3><h3>Language: {LANGUAGE}</h3><h3>Verification code: {VERIFICATION_CODE}</h3><h3>Member ID: {MEMBER_ID}</h3><h3>Order no.: {ORDER_NO}</h3><h3>Membership price: {MEMBERSHIP_PRICE}</h3><h3>Membership: {MEMBERSHIP}</h3>"
				]);

				$test_message_item_id_2 = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 12-2",
					"html" => "<h2>Send to maillist – values should be filled out with override values</h2><h3>Nickname: {NICKNAME}</h3><h3>Email: {EMAIL}</h3><h3>Username: {USERNAME}</h3><h3>Firstname: {FIRSTNAME}</h3><h3>Lastname: {LASTNAME}</h3><h3>Language: {LANGUAGE}</h3><h3>Verification code: {VERIFICATION_CODE}</h3><h3>Member ID: {MEMBER_ID}</h3><h3>Order no.: {ORDER_NO}</h3><h3>Membership price: {MEMBERSHIP_PRICE}</h3><h3>Membership: {MEMBERSHIP}</h3>"
				]);

				$test_membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership", 
					"name" => "Membership Test item 1",
					"subscribed_message_id" => $test_message_item_id_1,
					"subscription_method" => 1,
					"price" => 100,
				]);

				$test_user_id_1 = $test_model->createTestUser([
					"nickname" => "This is the correct nickname 1",
					"firstname" => "Tester",
					"lastname" => "Testerson",
					"email" => $mail_1,
					"subscribed_item_id" => $test_membership_item_id
				]);
				$test_user_id_2 = $test_model->createTestUser([
					"nickname" => "This is the correct nickname 2",
					"firstname" => "Tester",
					"lastname" => "Testerson",
					"email" => $mail_2,
					"subscribed_item_id" => $test_membership_item_id
				]);


				$maillist_id = $test_model->createTestMaillist("Test mailing list 12");

				$_POST["maillist_id"] = $maillist_id;
				$UC->addMaillist(["addMaillist", $test_user_id_1]);
				$UC->addMaillist(["addMaillist", $test_user_id_2]);
				unset($_POST);


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id_2,
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
						$mail_1 => [
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
					$recipients[0] == $mail_1 &&
					$recipients[1] == $mail_2
				)
				: ?>
				<div class="testpassed">TypeMessage::sendMessage – maillist for members and custom value array, which will override default values for maillist subscriber 1, and specific values for subscriber 2 – send Test Message 12-1 and 12-2 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – maillist for members and custom value array, which will override default values for maillist subscriber 1, and specific values for subscriber 2 – send Test Message 12-1 and 12-2 – error</div>
				<? endif;


				//CLEAN UP

				$test_model->cleanUp(["user_id" => $test_user_id_1]);
				$test_model->cleanUp(["user_id" => $test_user_id_2]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id]);
				$test_model->cleanUp(["item_id" => $test_message_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_message_item_id_2]);
				$test_model->cleanUp(["maillist_id" => $maillist_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message with image and list content), recipient – return recipient list and send Test Message 13") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				global $mail_1;

				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 13: {TEST_VALUE}",
					"html" => "<h2>Send to recipients array, using on value</h2><h3>Test value: {TEST_VALUE}</h3><p>Test value in header and body should be replaced with: Greetings</p><ul><li>item 1</li><li>item 2</li></ul><div class=\"media item_id:0 variant:missing name:missing-image format:png \"><p>test image</p></div>",
				]);


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "$mail_1",
					"values" => [
						"TEST_VALUE" => "Greeting with image and list"
					]
				]);


				// ASSERT

				if(
					is_array($recipients) &&
					$recipients[0] == $mail_1
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and value (same value for each recipient) – return recipient list and send Test Message 3 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message), recipients, and value (same value for each recipient) – return recipient list and send Test Message 3 – error</div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "send message – pass item_id (itemtype == message with special chars), recipient and value with special chars – return recipient list and send Test Message 14") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$message_model = $IC->typeObject("message");
				$test_model = $IC->typeObject("tests");

				global $mail_1;

				$test_message_item_id = $test_model->createTestItem([
					"itemtype" => "message", 
					"name" => "Test message 14: {TEST_VALUE}",
					"html" => "<h2>Send to recipients array, using one value with special chars like æøå and entities &aelig;&oslash;&aring;</h2><h3>Test value: {TEST_VALUE}</h3><p>Test value in header and body should be replaced with: Greetings</p><ul><li>item 1</li><li>item 2</li></ul>",
				]);


				// ACT

				$recipients = $message_model->sendMessage([
					"item_id" => $test_message_item_id,
					"recipients" => "$mail_1",
					"values" => [
						"TEST_VALUE" => "Greeting with special chars & and æøå and &aring;"
					]
				]);


				// ASSERT

				if(
					is_array($recipients) &&
					$recipients[0] == $mail_1
				): ?>
				<div class="testpassed">TypeMessage::sendMessage – pass item_id (itemtype == message with special chars), recipient and value with special chars (same value for each recipient) – return recipient list and send Test Message 3 – correct – VERIFY MAIL</div>
				<? else: ?>
				<div class="testfailed">TypeMessage::sendMessage – pass item_id (itemtype == message with special chars), recipient and value with special chars (same value for each recipient) – return recipient list and send Test Message 3 – error</div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_message_item_id]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

</div>