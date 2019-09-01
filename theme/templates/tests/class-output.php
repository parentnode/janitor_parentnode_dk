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


	<div class="tests output reset">
		<h3>Output object and reset error message.</h3> 
		<?
		message()->addMessage($message);
		message()->addMessage($error_message, array("type" => "error"));
		ob_start();
		$output->screen($test_object, ["type" => "error"]);
		$screen_output = ob_get_contents();
		ob_end_clean();
		$output_array = json_decode($screen_output, true);

		if(
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
		<div class="testpassed">Output::screen (object, ["type" => "error"]) - correct</div>
		<? else: ?>
		<div class="testfailed">Output::screen (object, ["type" => "error"])- error</div> 
		<? endif; ?>
	</div>
	
	<div class="tests output no_reset">
		<h3>Output object and do not reset error message.</h3>
		<?
	 	message()->addMessage($message);
	 	message()->addMessage($error_message, array("type" => "error"));
	 	ob_start();
	 	$output->screen($test_object, ["type" => "error", "reset_messages" => false]);
	 	$screen_output = ob_get_contents();
	 	ob_end_clean();
	 	$output_array = json_decode($screen_output, true);

		if(
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
		<div class="testpassed">Output::screen (object, ["type" => "error", "reset_messages" => false]) - correct</div>
		<? else: ?>
		<div class="testfailed">Output::screen (object, ["type" => "error", "reset_messages" => false]) - error</div>
		<? endif; ?>
	</div>

	<div class="tests output no_reset">
		<h3>Output object and do not reset messages.</h3>
		<?
	 	message()->resetMessages();
	 	message()->addMessage($message);
	 	message()->addMessage($error_message, array("type" => "error"));
	 	ob_start();
	 	$output->screen($test_object, ["type" => "message", "reset_messages" => false]);
	 	$screen_output = ob_get_contents();
	 	ob_end_clean();
	 	$output_array = json_decode($screen_output, true);

		if(
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
		<div class="testpassed">Output::screen (object, ["type" => "message", "reset_messages" => false]) - correct</div>
		<? else: ?>
		<div class="testfailed">Output::screen (object, ["type" => "message", "reset_messages" => false]) - error</div>
		<? endif; ?>
	</div>

	<div class="tests output reset">
		<h3>Output object and reset messages.</h3>
		<?
	 	message()->resetMessages();
	 	message()->addMessage($message);
	 	message()->addMessage($error_message, array("type" => "error"));
	 	ob_start();
	 	$output->screen($test_object, ["type" => "message"]);
	 	$screen_output = ob_get_contents();
	 	ob_end_clean();
	 	$output_array = json_decode($screen_output, true);
		
		if(
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
		<div class="testpassed">Output::screen (object, ["type" => "message"]) - correct</div>
		<? else: ?>
		<div class="testfailed">Output::screen (object, ["type" => "message"]) - error</div>
		<? endif; ?>
	</div>
	
	
</div>
