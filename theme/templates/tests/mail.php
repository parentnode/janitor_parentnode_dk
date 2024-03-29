<?
// init mailer to expose ADMIN_EMAIL
mailer();

$secondary_recipient = "test2.parentnode@gmail.com";
$tertiary_recipient = "test3.parentnode@gmail.com";
$quaternary_recipient = "test4.parentnode@gmail.com";
$custom_recipients = [ADMIN_EMAIL, $secondary_recipient];
$custom_values = [
	ADMIN_EMAIL => [
		"name" => preg_replace("/[\.@]/", "-", ADMIN_EMAIL), 
		"text" => "I'm the primary test recipient"
	], 
	$secondary_recipient => [
		"name" => "Tester 2", 
		"text" => "I'm the secondary test recipient"
	]
];


?>

<div class="scene i:scene tests defaultEdit">
	<h1>Mail</h1>	
	<h2>Testing mail sending functionality</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<p>
		Most tests will be sent to the admin specified in connect_mail.php <em>(<?= ADMIN_EMAIL ?>)</em>. Make sure your project is set up with your
		email before running too many tests.
	</p>
	<p>
		Custom recipient list is currently set to:
		<br /><br />

<? foreach($custom_recipients as $recipient): ?>
		<strong><?= $recipient ?></strong><br />
		With values:<br />
		<? foreach($custom_values[$recipient] as $key => $value): ?>
			<em><?= $key ?>=<?= $value ?></em><br />
		<? endforeach; ?>
		<br />
<? endforeach; ?>
		These values can be updated in the source code for this test (templates/tests/mail.php).
	</p>


	<h2>Test send</h2>
	<div class="tests">
	<? 

	if(1 && "simple message to admin from current user"):?>
		<h3>Mailer::send - simple message to admin from current user</h3>
		<? if(mailer()->send([
				"from_current_user" => true,
				"message" => "I'm a simple text message to the Admin, from current user",
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;
	
	if(1 && "simple message to admin with custom from_name"):?>
		<h3>Mailer::send - simple message to admin from custom from_name</h3>
		<? if(mailer()->send([
				"from_name" => "Donald Duck (custom from_name)",
				"message" => "I'm a simple text message to the Admin, from Donald Duck (a custom from_name)"
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>

	<? endif;

	if(1 && "simple message to admin with custom from_name and custom from_email"):?>
		<h3>Mailer::send - simple message to admin from custom from_name and custom from_email</h3>
		<? if(mailer()->send([
				"from_name" => "Bugs Bunny (custom from_name)",
				"from_email" => "bugsbunny@gmail.com",
				"message" => "I'm a simple text message to the Admin, from Bugs Bunny (a custom from_name) with a custom from_email."
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "simple message to admin with custom from_name and custom from_email and from_current_user"):?>
		<h3>Mailer::send - simple message to admin from custom from_name and custom from_email and from_current_user</h3>
		<? if(mailer()->send([
				"from_current_user" => true,
				"from_name" => "Mickey Mouse (custom from_name)",
				"from_email" => "mickeymouse@gmail.com",
				"message" => "I'm a simple text message to the Admin, from Mickey Mouse (a custom from_name) with a custom from_email, overriding the data from current user."
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "simple message to admin with custom from_email and from_current_user"):?>
		<h3>Mailer::send - simple message to admin with custom from_email and from_current_user</h3>
		<? if(mailer()->send([
				"from_current_user" => true,
				"from_email" => "mickeymouse@gmail.com",
				"message" => "I'm a simple text message to the Admin, from current user with a custom from_email, overriding the email from current user."
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "simple message to admin with custom from_name and from_current_user"):?>
		<h3>Mailer::send - simple message to admin with custom from_name and from_current_user</h3>
		<? if(mailer()->send([
				"from_current_user" => true,
				"from_name" => "Popeye",
				"message" => "I'm a simple text message to the Admin, from Popeye with email from current user."
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "simple message to admin with custom reply-to"):?>
		<h3>Mailer::send - simple message to admin with custom reply-to</h3>
		<? if(mailer()->send([
				"from_current_user" => true,
				"reply_to" => $secondary_recipient,
				"message" => "I'm a simple text message to the Admin; replies will go to ".$secondary_recipient."."
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "simple text message with system template to specific users (sending as CC)"):?>
		<h3>Mailer::send - simple message with system php template to specific users (sending as CC)</h3>
		<? if(mailer()->send([
			"recipients" => $custom_recipients,
			"message" => "I'm a simple text message with system template to specific users (sending as CC).<br /><br />No user specific variables, because it's the same message everyone gets.<br /><br />Global variables can be used.",
			"template" => "system"
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "custom html template to admin with system variables only - should send mails with unfilled placeholders"):?>
		<h3>Mailer::send - custom html template to admin with system variables only</h3>
		<? if(mailer()->send([
			"subject" => "I'm a custom html template, with global variables only.",
			"template" => "test_html"
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "custom html template to admin with custom variables"):?>
		<h3>Mailer::send - custom html template to admin with custom variables</h3>
		<? if(mailer()->send([
			"subject" => "I'm a custom html template, with custom variables.",
			"template" => "test_html",
			"values" => $custom_values[ADMIN_EMAIL]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "custom txt template to admin with custom variables"):?>
		<h3>Mailer::send - custom txt template to admin with custom variables</h3>
		<? if(mailer()->send([
			"subject" => "I'm a custom text template, with custom variables.",
			"template" => "test_text",
			"values" => $custom_values[ADMIN_EMAIL]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "custom txt template to admin with custom variables - disabled click tracking"):?>
		<h3>Mailer::send - custom txt template to admin with custom variables - disabled click tracking</h3>
		<? if(mailer()->send([
			"subject" => "I'm a custom text template, with click tracking disabled.",
			"template" => "test_text",
			"values" => $custom_values[ADMIN_EMAIL],
			"track_clicks" => false
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "custom txt template to admin with custom variables - disabled opened tracking"):?>
		<h3>Mailer::send - custom txt template to admin with custom variables - disabled opened tracking</h3>
		<? if(mailer()->send([
			"subject" => "I'm a custom text template, with opened tracking disabled.",
			"template" => "test_text",
			"values" => $custom_values[ADMIN_EMAIL],
			"track_opened" => false
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "custom txt template to admin with custom variables - disabled all tracking"):?>
		<h3>Mailer::send - custom txt template to admin with custom variables - disabled all tracking</h3>
		<? if(mailer()->send([
			"subject" => "I'm a custom text template, with tracking disabled.",
			"template" => "test_text",
			"values" => $custom_values[ADMIN_EMAIL],
			"tracking" => false
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "custom inline text template to admin with custom variables"):?>
		<h3>Mailer::send - custom inline text template to admin with custom variables</h3>
		<? if(mailer()->send([
			"text" => "This is a inline text mail template \"{name}\" (Custom variable) with two variable strings \"{text}\" (Custom variable)",
			"values" => $custom_values[ADMIN_EMAIL]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "custom inline text template to specific users (sending as CC)"):?>
		<h3>Mailer::send - custom inline text template to specific users (sending as CC)</h3>
		<? if(mailer()->send([
			"recipients" => $custom_recipients,
			"text" => "This is a inline text mail template \"{name}\" (Custom variable) with two variable strings \"{text}\" (Custom variable)",
			"values" => $custom_values[ADMIN_EMAIL]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif;

	if(1 && "custom inline html template to admin with custom variables"):?>
		<h3>Mailer::send - custom inline html template to admin with custom variables</h3>
		<? if(mailer()->send([
			"html" => "<h1>This is a inline text mail template \"{name}\" (Custom variable) with two variable strings \"{text}\" (Custom variable)</h1><h2>{SITE_NAME} (Global variable)</h2>",
			"values" => $custom_values[ADMIN_EMAIL]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	<? endif; ?>
	</div>

	<h2>With attachment</h2>

	<? if(1 && "simple message with attachment to admin"):?>
	<div class="tests">
		<h3>Mailer::send - simple message with attachment to admin</h3>
		<? if(mailer()->send([
			"attachments" => LOCAL_PATH."/templates/tests/mail-attachment/test.jpg",
			"message" => "I have an attachment"
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<h2>With CC/BCC</h2>

	<? if(1 && "simple message to admin and 1 CC"):?>
	<div class="tests">
		<h3>Mailer::send - simple message to admin and 1 CC</h3>
		<? if(mailer()->send([
			"message" => "I have 1 CC recipient",
			"cc_recipients" => ["test2.parentnode@gmail.com"]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "simple message to admin and 2 CC's"):?>
	<div class="tests">
		<h3>Mailer::send - simple message to admin and 2 CC's</h3>
		<? if(mailer()->send([
			"message" => "I have 2 CC recipients",
			"cc_recipients" => ["test2.parentnode@gmail.com","test3.parentnode@gmail.com"]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>
	
	<? if(1 && "simple message to admin and 2 BCC's"):?>
	<div class="tests">
		<h3>Mailer::send - simple message to admin and 2 BCC's</h3>
		<? if(mailer()->send([
			"message" => "I have 2 BCC recipients",
			"bcc_recipients" => ["test2.parentnode@gmail.com","test3.parentnode@gmail.com"]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "simple message to admin and 1 CC and 1 BCC"):?>
	<div class="tests">
		<h3>Mailer::send - simple message to admin and 2 CC's</h3>
		<? if(mailer()->send([
			"message" => "I have 1 CC and 1 BCC recipient",
			"cc_recipients" => ["test2.parentnode@gmail.com"],
			"bcc_recipients" => ["test3.parentnode@gmail.com"]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<h2>Test sendBulk</h2>

	<? if(1 && "simple message with custom variables"):?>
	<div class="tests sendBulk">
		<h3>Mailer::sendBulk - simple message with custom variables</h3>
		<? if(mailer()->sendBulk([
			"message" => "Hi {name}\n\nI am a simple text message without a template.\n\nThe secret text is:'{text}'.\n\nGood luck with the development.",
			"recipients" => $custom_recipients,
			"values" => $custom_values
		])): ?>
		<div class="testpassed">Mailer::sendBulk - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::sendBulk - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>
	
	<? if(1 && "simple message with custom variables, with 1 CC"):?>
	<div class="tests sendBulk">
		<h3>Mailer::sendBulk - simple message with custom variables, with 1 CC</h3>
		<? if(mailer()->sendBulk([
			"message" => "Hi {name}\n\nI am a simple text message without a template.\n\nThe secret text is:'{text}'.\n\nGood luck with the development.",
			"recipients" => $custom_recipients,
			"cc_recipients" => ["test3.parentnode@gmail.com"],
			"values" => $custom_values
		])): ?>
		<div class="testpassed">Mailer::sendBulk - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::sendBulk - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "simple message with custom variables, with 2 CC's"):?>
	<div class="tests sendBulk">
		<h3>Mailer::sendBulk - simple message with custom variables, with 2 CC's</h3>
		<? if(mailer()->sendBulk([
			"message" => "Hi {name}\n\nI am a simple text message without a template.\n\nThe secret text is:'{text}'.\n\nGood luck with the development.",
			"recipients" => $custom_recipients,
			"cc_recipients" => [$tertiary_recipient, $quaternary_recipient],
			"values" => $custom_values
		])): ?>
		<div class="testpassed">Mailer::sendBulk - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::sendBulk - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "simple message with custom variables, with 1 BCC"):?>
	<div class="tests sendBulk">
		<h3>Mailer::sendBulk - simple message with custom variables, with 1 BCC</h3>
		<? if(mailer()->sendBulk([
			"message" => "Hi {name}\n\nI am a simple text message without a template.\n\nThe secret text is:'{text}'.\n\nGood luck with the development.",
			"recipients" => $custom_recipients,
			"bcc_recipients" => ["test3.parentnode@gmail.com"],
			"values" => $custom_values
		])): ?>
		<div class="testpassed">Mailer::sendBulk - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::sendBulk - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "simple message with custom variables, with custom reply-to"):?>
	<div class="tests sendBulk">
		<h3>Mailer::sendBulk - simple message with custom variables, with custom reply-to</h3>
		<? if(mailer()->sendBulk([
			"message" => "Hi {name}\n\nReplies will go to $tertiary_recipient.\n\nI am a simple text message without a template.\n\nThe secret text is:'{text}'.\n\nGood luck with the development.",
			"recipients" => $custom_recipients,
			"reply_to" => $tertiary_recipient,
			"values" => $custom_values
		])): ?>
		<div class="testpassed">Mailer::sendBulk - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::sendBulk - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "custom html template with custom variables"):?>
	<div class="tests sendBulk">
		<h3>Mailer::sendBulk - custom html template with custom variables</h3>
		<? if(mailer()->sendBulk([
			"template" => "test_html",
			"recipients" => $custom_recipients,
			"values" => $custom_values
		])): ?>
		<div class="testpassed">Mailer::sendBulk - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::sendBulk - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "custom txt template with custom variables"):?>
	<div class="tests sendBulk">
		<h3>Mailer::sendBulk - custom txt template with custom variables</h3>
		<? if(mailer()->sendBulk([
			"template" => "test_text",
			"recipients" => $custom_recipients,
			"values" => $custom_values
		])): ?>
		<div class="testpassed">Mailer::sendBulk - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::sendBulk - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>


	<h2>System emails</h2>

	<? if(1 && "Signup:"):?>
	<div class="tests">
		<h3>Mailer::send - Signup:</h3>
		<? if(mailer()->send([
//			"recipients" => ["martin.nielsen@litmuspreviews.com"],
			"recipients" => $custom_recipients[0],
			"template" => "signup",
			"values" => [
				"VERIFICATION" => "abc",
				"PASSWORD" => "fake-password",
				"EMAIL" => "martin@think.dk"
			]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "Signup reminder"):?>
	<div class="tests">
		<h3>Mailer::send - Signup reminder:</h3>
		<? if(mailer()->send([
//			"recipients" => ["martin.nielsen@litmuspreviews.com"],
			"recipients" => $custom_recipients[0],
			"template" => "signup_reminder",
			"values" => [
				"VERIFICATION" => "abc",
				"NICKNAME" => "Mail recipient nickname",
				"FROM" => "Martin",
				"EMAIL" => "martin@think.dk"
			]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "Signup error"):?>
	<div class="tests">
		<h3>Mailer::send - Signup error:</h3>
		<? if(mailer()->send([
			"recipients" => $custom_recipients[0],
//			"recipients" => ["martin.nielsen@litmuspreviews.com"],
			"template" => "signup_error",
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "Reset password"):?>
	<div class="tests">
		<h3>Mailer::send - Reset password:</h3>
		<? if(mailer()->send([
			"recipients" => $custom_recipients[0],
//			"recipients" => ["martin.nielsen@litmuspreviews.com"],
			"template" => "reset_password",
			"track_clicks" => false,
			"values" => [
				"USERNAME" => "martin",
				"TOKEN" => "abc",
			]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(1 && "Payment reminder"):?>
	<div class="tests">
		<h3>Mailer::send - Payment reminder:</h3>
		<? if(mailer()->send([
			"recipients" => $custom_recipients[0],
//			"recipients" => ["martin.nielsen@litmuspreviews.com"],
			"template" => "payment_reminder",
			"track_clicks" => false,
			"values" => [
				"FROM" => "martin",
				"NICKNAME" => "Cheap bastard",
				"ORDER_NO" => "WEB123",
				"ORDER_PRICE" => "1.234,- DKK",
			]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>


</div>