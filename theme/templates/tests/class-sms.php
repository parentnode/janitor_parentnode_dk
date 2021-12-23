<?

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
				
				// ACT
				$message = sms()->send(["to" => "+4560626083", "body" => "Hejsa!-".rand()]);
				
				
				// ASSERT
				
				if($message) {

					sleep(5);
					$message = sms()->fetchMessage($message->sid);
				}

				if(
					$message
					&& $message->status == "delivered"
				): ?>
				<div class="testpassed"><p>SMSGateway::send – send single sms and wait 5 seconds – return status 'delivered' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SMSGateway::send – send single sms and wait 5 seconds – return status 'delivered' – error</p></div>
				<? endif; 
				
				// CLEAN UP
	
			})();
		}
		?>
	</div>

</div>

<?

?>