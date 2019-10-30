<?
// init mailer to expose ADMIN_EMAIL
mailer();

$secondary_recipient = "test.parentnode@gmail.com";
$custom_recipients = [ADMIN_EMAIL, $secondary_recipient];
$custom_values = [
	ADMIN_EMAIL => [
		"name" => preg_replace("/[\.@]/", "-", ADMIN_EMAIL), 
		"text" => "I'm the primary test recipient"
	], 
	$secondary_recipient => [
		"name" => "parentnode test gmail", 
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

	<? if(0 && "simple message to admin from current user"):?>
	<div class="tests">;
		<h3>Mailer::send - simple message to admin from current user</h3>
		<? if(mailer()->send([
				"from_current_user" => true,
				"message" => "I'm a simple text message to the Admin, from current user"
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(0 && "simple text message with system template to specific users (sending as CC)"):?>
	<div class="tests">
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
	</div>
	<? endif; ?>

	<? if(0 && "custom html template to admin with system variables only"):?>
	<div class="tests">
		<h3>Mailer::send - custom html template to admin with system variables only</h3>
		<? if(mailer()->send([
			"subject" => "I'm a custom html template, with global variables only.",
			"template" => "test_html"
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(0 && "custom html template to admin with custom variables"):?>
	<div class="tests">
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
	</div>
	<? endif; ?>

	<? if(0 && "custom txt template to admin with custom variables"):?>
	<div class="tests">
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
	</div>
	<? endif; ?>

	<? if(0 && "custom txt template to admin with custom variables - disabled click tracking"):?>
	<div class="tests">
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
	</div>
	<? endif; ?>

	<? if(0 && "custom txt template to admin with custom variables - disabled opened tracking"):?>
	<div class="tests">
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
	</div>
	<? endif; ?>

	<? if(0 && "custom txt template to admin with custom variables - disabled all tracking"):?>
	<div class="tests">
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
	</div>
	<? endif; ?>

	<? if(0 && "custom inline text template to admin with custom variables"):?>
	<div class="tests">
		<h3>Mailer::send - custom inline text template to admin with custom variables</h3>
		<? if(mailer()->send([
			"text" => "This is a inline text mail template \"{name}\" (Custom variable) with two variable strings \"{text}\" (Custom variable)",
			"values" => $custom_values[ADMIN_EMAIL]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>

	<? if(0 && "custom inline text template to specific users (sending as CC)"):?>
	<div class="tests">
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
	</div>
	<? endif; ?>

	<? if(0 && "custom inline html template to admin with custom variables"):?>
	<div class="tests">
		<h3>Mailer::send - custom inline html template to admin with custom variables</h3>
		<? if(mailer()->send([
			"html" => "<h1>This is a inline text mail template \"{name}\" (Custom variable) with two variable strings \"{text}\" (Custom variable)</h1><h2>{SITE_NAME} (Global variable)</h2>",
			"values" => $custom_values[ADMIN_EMAIL]
		])): ?>
		<div class="testpassed">Mailer::send - message sent - correct</div>
		<? else: ?>
		<div class="testfailed">Mailer::send - message sent - error</div>
		<? endif; ?>
	</div>
	<? endif; ?>


	<h2>With attachment</h2>

	<? if(0 && "simple message with attachment to admin"):?>
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


	<h2>Test sendBulk</h2>

	<? if(0 && "simple message with custom variables"):?>
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

	<? if(0 && "custom html template with custom variables"):?>
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

	<? if(0 && "custom txt template with custom variables"):?>
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

	<? if(0 && "Signup:"):?>
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

	<? if(0 && "Signup reminder"):?>
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

	<? if(0 && "Signup error"):?>
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

	<? if(0 && "Reset password"):?>
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

	<? if(0 && "Payment reminder"):?>
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