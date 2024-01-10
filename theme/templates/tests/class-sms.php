<?
global $test_mobile;
$test_mobile = "+4520742819";
?>

<div class="scene i:scene tests">
	<h1>SMS</h1>	
	<h2>SMS Gateway</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests #method#">
		<h3>SMSGateway::send</h3>
		<? 
		if(1 && "send – send single sms and wait 5 seconds – return status 'delivered'") {

			(function() {

				// ARRANGE

				global $test_mobile;


				// ACT

				// On trial account message will have trail account info added to it
				$sms_text = "Hejsa! ".rand();

				$message = sms()->send(["to" => $test_mobile, "body" => $sms_text]);


				// ASSERT

				if($message) {
					sleep(5);
					$fetched_message = sms()->fetchMessage($message->sid);
				}

				// debug([$message->status, $fetched_message->status, $fetched_message->body, $sms_text, strpos($fetched_message->body, $sms_text), strpos($fetched_message->body, $sms_text) !== false]);

				if(
					$message &&
					($message->status == "delivered" || $message->status == "queued" || $message->status == "accepted") &&
					$fetched_message &&
					$fetched_message->status == "delivered" &&
					strpos($fetched_message->body, $sms_text) !== false
				): ?>
				<div class="testpassed"><p>SMSGateway::send – send single sms and wait 5 seconds – return status 'delivered' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SMSGateway::send – send single sms and wait 5 seconds – return status 'delivered' – error</p></div>
				<? endif; 


				// CLEAN UP
	
			})();
		}

		if(1 && "send – send single sms with URL-like string and wait 5 seconds – return status 'delivered'") {

			(function() {

				// ARRANGE

				global $test_mobile;


				// ACT

				$sms_text = "4.tv https://parentnode.dk - ".rand();

				$message = sms()->send(["to" => $test_mobile, "body" => $sms_text]);


				// ASSERT

				if($message) {
					sleep(5);
					$fetched_message = sms()->fetchMessage($message->sid);
				}

				// debug([$message->status, $fetched_message->status, $fetched_message->body, $sms_text, strpos($fetched_message->body, $sms_text)]);

				if(
					$message && 
					($message->status == "delivered" || $message->status == "queued" || $message->status == "accepted") &&
					$fetched_message &&
					$fetched_message->status == "delivered" &&
					strpos($fetched_message->body, $sms_text) !== false
				): ?>
				<div class="testpassed"><p>SMSGateway::send – send single sms with URL-like string and wait 5 seconds – return status 'delivered' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SMSGateway::send – send single sms with URL-like string and wait 5 seconds – return status 'delivered' – error</p></div>
				<? endif; 


				// CLEAN UP
	
			})();
		}

		?>
	</div>

</div>

<?

?>