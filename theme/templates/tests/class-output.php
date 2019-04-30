<?
$output = new Output();
$test_object = array("id" => 22);
$error_message = "This is a test message of type error.";
$message = "This is a test message.";
?>

<div class="scene i:scene tests">
	<h1>Output</h1>	
	<h2>Test Output class.</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

<? 
	message()->addMessage($message);
	message()->addMessage($error_message, array("type" => "error"));
	ob_start();
	$output->screen($test_object, ["type" => "error"]);
	$screen_output = ob_get_contents();
	ob_end_clean();
	$output_array = json_decode($screen_output, true);
?>
	<div class="tests">
		<h3>Output object and reset error message.</h3> 
		<? if(
			$output_array &&
			isset($output_array["cms_object"]) &&
			isset($output_array["cms_object"]["id"]) &&
			$output_array["cms_object"]["id"] == 22 &&
			!message()->hasMessages() &&
			isset($output_array["cms_status"]) &&
			$output_array["cms_status"] == "error" &&
			isset($output_array["cms_message"]) &&
			$output_array["cms_message"][0] == $error_message &&
			count($output_array["cms_message"]) == 1 &&
			count($output_array) == 3
			): ?>
		<div class="testpassed"><p>Output::screen (object, ["type" => "error"]) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Output::screen (object, ["type" => "error"])- error</p></div> 
		<? endif; ?>
	</div>
	
<?
	message()->addMessage($message);
	message()->addMessage($error_message, array("type" => "error"));
	ob_start();
	$output->screen($test_object, ["type" => "error", "reset_messages" => false]);
	$screen_output = ob_get_contents();
	ob_end_clean();
	$output_array = json_decode($screen_output, true);
?>
	<div class="tests">
		<h3>Output object and do not reset error message.</h3>
		 <? if(
			$output_array &&
 			isset($output_array["cms_object"]) &&
 			isset($output_array["cms_object"]["id"]) &&
			$output_array["cms_object"]["id"] == 22 &&
			message()->hasMessages() &&
			isset($output_array["cms_status"]) &&
			$output_array["cms_status"] == "error" &&
			isset($output_array["cms_message"]) &&
			count($output_array) == 3 &&
			$output_array["cms_message"][0] == $error_message &&
			count(message()->getMessages()) == 2
			
		): ?>
		<div class="testpassed"><p>Output::screen (object, ["type" => "error", "reset_messages" => false]) - correct</p></div>
	<? else: ?>
		<div class="testfailed"><p>Output::screen (object, ["type" => "error", "reset_messages" => false]) - error</p></div>
	<? endif; ?>
	</div>
<?	
	message()->resetMessages();
	message()->addMessage($message);
	message()->addMessage($error_message, array("type" => "error"));
	ob_start();
	$output->screen($test_object, ["type" => "message", "reset_messages" => false]);
	$screen_output = ob_get_contents();
	ob_end_clean();
	$output_array = json_decode($screen_output, true);
?>
	<div class="tests">
		<h3>Output object and do not reset messages.</h3>
		 <? if(
			$output_array &&
			isset($output_array["cms_object"]) &&
			isset($output_array["cms_object"]["id"]) &&
			$output_array["cms_object"]["id"] == 22 &&
			message()->hasMessages() &&
			isset($output_array["cms_status"]) &&
			$output_array["cms_status"] == "success" &&
			isset($output_array["cms_message"]) &&
			isset($output_array["cms_message"]["message"]) &&
			isset($output_array["cms_message"]["message"][0]) &&
			$output_array["cms_message"]["message"][0] == $message &&
			isset($output_array["cms_message"]["error"]) &&
			isset($output_array["cms_message"]["error"][0]) &&
			$output_array["cms_message"]["error"][0] == $error_message &&
			isset($output_array["return_to"]) &&
			count($output_array) == 4 &&
			count(message()->getMessages()) == 2
			
		): ?>
		<div class="testpassed"><p>Output::screen (object, ["type" => "message", "reset_messages" => false]) - correct</p></div>
	<? else: ?>
		<div class="testfailed"><p>Output::screen (object, ["type" => "message", "reset_messages" => false]) - error</p></div>
	<? endif; ?>
	</div>

<?	
	message()->resetMessages();
	message()->addMessage($message);
	message()->addMessage($error_message, array("type" => "error"));
	ob_start();
	$output->screen($test_object, ["type" => "message"]);
	$screen_output = ob_get_contents();
	ob_end_clean();
	$output_array = json_decode($screen_output, true);

?>
	<div class="tests">
		<h3>Output object and reset messages.</h3>
		 <? if(
			$output_array &&
			isset($output_array["cms_object"]) &&
			isset($output_array["cms_object"]["id"]) &&
			$output_array["cms_object"]["id"] == 22 &&
			!message()->hasMessages() &&
			isset($output_array["cms_status"]) &&
			$output_array["cms_status"] == "success" &&
			isset($output_array["cms_message"]) &&
			isset($output_array["cms_message"]["message"]) &&
			isset($output_array["cms_message"]["message"][0]) &&
			$output_array["cms_message"]["message"][0] == $message &&
			isset($output_array["cms_message"]["error"]) &&
			isset($output_array["cms_message"]["error"][0]) &&
			$output_array["cms_message"]["error"][0] == $error_message &&
			isset($output_array["return_to"]) &&
			count($output_array) == 4 
			
		): ?>
		<div class="testpassed"><p>Output::screen (object, ["type" => "message"]) - correct</p></div>
	<? else: ?>
		<div class="testfailed"><p>Output::screen (object, ["type" => "message"]) - error</p></div>
	<? endif; ?>
	</div>
	
	
</div>
