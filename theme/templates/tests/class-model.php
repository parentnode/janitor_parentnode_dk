<?
?>

<div class="scene i:scene tests">
	<h1>Model</h1>	
	<h2>Core Janitor Model class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests addToModel">
		<h3>Model::addToModel</h3>
		<?
		$model = new Model();
		$random_name = "fun".randomKey(8);


		$model->addToModel($random_name, [
			"label" => "My first label",
			"type" => "string",
			"value" => "nothing",
			"options" => ["text" => "value"],
			"pattern" => "/abc/",
			"error_message" => "My first error",
			"hint_message" => "My first hint",

			"i_dont_exist" => "hello error"
		]);


		if(
			$model->data_entities[$random_name]["label"] == "My first label" &&
			$model->data_entities[$random_name]["type"] == "string" &&
			$model->data_entities[$random_name]["value"] == "nothing" &&
			$model->data_entities[$random_name]["options"] == ["text" => "value"] &&
			$model->data_entities[$random_name]["pattern"] == "/abc/" &&
			$model->data_entities[$random_name]["error_message"] == "My first error" &&
			$model->data_entities[$random_name]["hint_message"] == "My first hint" &&

			!isset($model->data_entities[$random_name]["i_dont_exist"])
		
		): ?>
		<div class="testpassed">Model::addToModel - correct</div>
		<? else: ?>
		<div class="testfailed">Model::addToModel - error</div>
		<? endif; ?>

	</div>

	<div class="tests getModel">
		<h3>Model::getModel</h3>
		<?

		message()->resetMessages();

		$model = new Model();

		// Get model containing only predefined entities
		$entities = $model->getModel();

		if(
			isset($entities["user_id"]) &&
			$entities["user_id"]["type"] == "user_id" &&
			isset($entities["user_id"]["label"]) &&

			isset($entities["html"]) &&
			$entities["html"]["type"] == "html" &&
			isset($entities["html"]["allowed_tags"]) &&
			
			isset($entities["published_at"]) &&
			$entities["published_at"]["type"] == "datetime" &&

			!isset($entities["name"])
		): ?>
		<div class="testpassed">Model::getModel - correct</div>
		<? else: ?>
		<div class="testfailed">Model::getModel - error</div>
		<? endif; ?>

	</div>

	<div class="tests setProperty">
		<h3>Model::setProperty</h3>
		<?

		message()->resetMessages();

		$model = new Model();
		$model->setProperty("user_id", "type", "string");
		$model->setProperty("user_id", "label", "What");

		$entities = $model->getModel();

		if(
			isset($entities["user_id"]) &&
			$entities["user_id"]["type"] == "string" &&
			$entities["user_id"]["label"] == "What"
		): ?>
		<div class="testpassed">Model::setProperty - correct</div>
		<? else: ?>
		<div class="testfailed">Model::setProperty - error</div>
		<? endif; ?>

	</div>

	<div class="tests getProperty">
		<h3>Model::getProperty</h3>
		<?

		message()->resetMessages();

		$model = new Model();

		$model->setProperty("user_id", "type", "string");
		$model->setProperty("user_id", "label", "What");

		if(
			$model->getProperty("user_id", "type") == "string" &&
			$model->getProperty("user_id", "label") == "What" &&

			$model->getProperty("html", "type") == "html" &&
			!$model->getProperty("html", "value") &&

			$model->getProperty("item_id", "type") == "item_id" &&
			!$model->getProperty("item_id", "value") &&
			$model->getProperty("item_id", "hint_message")
		): ?>
		<div class="testpassed">Model::getProperty - correct</div>
		<? else: ?>
		<div class="testfailed">Model::getProperty - error</div>
		<? endif; ?>

	</div>

	<div class="tests getPostedEntities">
		<h3>Model::getPostedEntities</h3>
		<?

		message()->resetMessages();

		$model = new Model();

		// Add to elements to model to perform test
		$model->addToModel("password", ["type" => "password"]);
		$model->addToModel("name", ["type" => "string"]);
		$model->addToModel("email", ["type" => "email"]);


		$_POST["user_id"] = 1;
		$_POST["name"] = "Test name";
		$_POST["email"] = "message+email@domain.tld";
		$_POST["password"] = "æøå<span>#€%&!/()";
		$_POST["html"] = "<p>æøå<script>#€%&!/()</script></p>";
		$_FILES["mediae"] = ["tmp_name" => "Test file name"];

		$model->getPostedEntities();

	
		if(
			$model->getProperty("user_id", "value") == 1 &&
			$model->getProperty("name", "value") == "Test name" &&
			$model->getProperty("email", "value") == "message+email@domain.tld" &&
			$model->getProperty("password", "value") == "æøå<span>#€%&!/()" &&
			$model->getProperty("html", "value") == "<p>æøå#€%&!/()</p>" &&
			$model->getProperty("mediae", "value") == "Test file name" &&

			!$model->getProperty("item_id", "value") &&
			!$model->getProperty("i_dont_exist", "value")
		): ?>
		<div class="testpassed">Model::getPostedEntities - correct</div>
		<? else: ?>
		<div class="testfailed">Model::getPostedEntities - error</div>
		<? endif; ?>
	</div>

	<div class="tests validate">
		<h3>Model::validate</h3>
		<?

		// STRING, HIDDEN, TEXT, SELECT

		if(1 && "string, empty, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			if(
				!$messages &&

				$validation_result &&

				!$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, empty, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, empty, not required) - error</div>
			<? endif;

		}


		if(1 && "string, zero, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);
			$model->setProperty("name", "value", 0);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") === 0 &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, zero, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, zero, not required) - error</div>
			<? endif;

		}


		if(1 && "string, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages &&

				$validation_result &&

				$model->getProperty("name", "value") == "I'm a string" &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, string, not required) - error</div>
			<? endif;

		}


		if(1 && "string, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, empty, required) - error</div>
			<? endif;

		}


		if(1 && "string, string, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "I'm a string");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") == "I'm a string" &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, string, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, string, required) - error</div>
			<? endif;

		}


		if(1 && "string, empty with min-length, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "min", 20);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				!$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, empty with min-length, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, empty with min-length, not required) - error</div>
			<? endif;

		}


		if(1 && "string, too short, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "I'm a string");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "min", 20);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, too short, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, too short, required) - error</div>
			<? endif;

		}


		if(1 && "string, too long, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "I'm a string");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "max", 10);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, too long, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, too long, required) - error</div>
			<? endif;

		}


		if(1 && "string, not matching pattern, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "def");
			$model->setProperty("name", "pattern", "[abc]+");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, not matching pattern, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, not matching pattern, not required) - error</div>
			<? endif;

		}


		if(1 && "string, matching pattern, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "abcabc");
			$model->setProperty("name", "pattern", "[abc]+");
			$model->setProperty("name", "required", true);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, matching pattern, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, matching pattern, required) - error</div>
			<? endif;

		}


		if(1 && "string, compare_to fail, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "123321");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "compare_to", "name_compare");

			$model->addToModel("name_compare", ["type" => "string"]);

			$model->setProperty("name_compare", "value", "123");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, compare_to fail, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, compare_to fail, required) - error</div>
			<? endif;

		}


		if(1 && "string, compare_to, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "123321");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "compare_to", "name_compare");

			$model->addToModel("name_compare", ["type" => "string"]);

			$model->setProperty("name_compare", "value", "123321");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (string, compare_to, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (string, compare_to, required) - error</div>
			<? endif;

		}



		// HTML

		if(1 && "html, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "html"]);

			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (html, empty, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (html, empty, not required) - error</div>
			<? endif;

		}


		if(1 && "html, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "html"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") == "I'm a string" &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (html, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (html, string, not required) - error</div>
			<? endif;

		}


		if(1 && "html, string, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "html"]);

			$model->setProperty("name", "value", "I'm a string");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") == "I'm a string" &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (html, string, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (html, string, required) - error</div>
			<? endif;

		}


		if(1 && "html, html, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "html"]);

			$model->setProperty("name", "value", "<p>html</p>");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") == "<p>html</p>" &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (html, html, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (html, html, required) - error</div>
			<? endif;

		}


		if(1 && "html, too short, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "html"]);

			$model->setProperty("name", "value", "<p>not enough</p>");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "min", 20);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (html, too short, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (html, too short, required) - error</div>
			<? endif;

		}


		if(1 && "html, long enough, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "html"]);

			$model->setProperty("name", "value", "<p>long enough to pass validation</p>");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "min", 20);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (html, long enough, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (html, long enough, required) - error</div>
			<? endif;

		}



		// FILES

		if(1 && "files, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, empty, required) - error</div>
			<? endif;

		}


		if(1 && "files, string, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", "I'm a string");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") == "I'm a string" &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, string, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, string, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed file, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png");
			$model->setProperty("name", "required", true);

			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$_FILES["name"] = [
				"type" => ["image/png"],
				"name" => ["Test-file.png"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
				"error" => [""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed file, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed file, required) - error</div>
			<? endif;

		}


		if(1 && "files, disallowed file, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "jpg");
			$model->setProperty("name", "required", true);

			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$_FILES["name"] = [
				"type" => ["image/png"],
				"name" => ["Test-file.png"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
				"error" => [""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, disallowed file, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, disallowed file, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed file, disallowed size, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png");
			$model->setProperty("name", "allowed_sizes", "1000x1000");
			$model->setProperty("name", "required", true);

			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$_FILES["name"] = [
				"type" => ["image/png"],
				"name" => ["Test-file.png"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
				"error" => [""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed file, disallowed size, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed file, disallowed size, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed file, allowed size, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png");
			$model->setProperty("name", "allowed_sizes", "1000x1000,512x288");
			$model->setProperty("name", "required", true);

			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$_FILES["name"] = [
				"type" => ["image/png"],
				"name" => ["Test-file.png"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
				"error" => [""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed file, allowed size, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed file, allowed size, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed file, disallowed proportion, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png");
			$model->setProperty("name", "allowed_proportions", (4/3));
			$model->setProperty("name", "required", true);

			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$_FILES["name"] = [
				"type" => ["image/png"],
				"name" => ["Test-file.png"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
				"error" => [""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed file, disallowed proportion, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed file, disallowed proportion, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed file, allowed proportion, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png");
			$model->setProperty("name", "allowed_proportions", round(16/9, 4));
			$model->setProperty("name", "required", true);

			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$_FILES["name"] = [
				"type" => ["image/png"],
				"name" => ["Test-file.png"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
				"error" => [""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed file, allowed proportion, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed file, allowed proportion, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed file, < min-width, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png");
			$model->setProperty("name", "min_width", 960);
			$model->setProperty("name", "required", true);

			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$_FILES["name"] = [
				"type" => ["image/png"],
				"name" => ["Test-file.png"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
				"error" => [""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed file, &lt; min-width, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed file, &lt; min-width, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed file, > min-width, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png");
			$model->setProperty("name", "min_width", 500);
			$model->setProperty("name", "required", true);

			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$_FILES["name"] = [
				"type" => ["image/png"],
				"name" => ["Test-file.png"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
				"error" => [""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed file, &gt; min-width, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed file, &gt; min-width, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed file, < min-height, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png");
			$model->setProperty("name", "min_height", 500);
			$model->setProperty("name", "required", true);

			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$_FILES["name"] = [
				"type" => ["image/png"],
				"name" => ["Test-file.png"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
				"error" => [""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed file, &lt; min-height, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed file, &lt; min-height, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed file, > min-height, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png");
			$model->setProperty("name", "min_height", 200);
			$model->setProperty("name", "required", true);

			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$_FILES["name"] = [
				"type" => ["image/png"],
				"name" => ["Test-file.png"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
				"error" => [""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed file, &gt; min-height, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed file, &gt; min-height, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed files, default max (1), required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png,jpg");
			$model->setProperty("name", "required", true);


			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
			$_FILES["name"] = [
				"type" => ["image/png", "image/jpeg"],
				"name" => ["Test file png", "Test file jpg"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg"],
				"error" => ["", ""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");	
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed files, default max, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed files, default max, required) - error</div>
			<? endif;

		}


		if(1 && "files, allowed files, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "png,jpg");
			$model->setProperty("name", "max", 20);
			$model->setProperty("name", "required", true);


			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
			$_FILES["name"] = [
				"type" => ["image/png", "image/jpeg"],
				"name" => ["Test file png", "Test file jpg"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg"],
				"error" => ["", ""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");	
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, allowed files, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, allowed files, required) - error</div>
			<? endif;

		}


		if(1 && "files, 1 allowed file, 1 disallowed file, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "files"]);

			$model->setProperty("name", "value", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			$model->setProperty("name", "allowed_formats", "jpg");
			$model->setProperty("name", "max", 20);
			$model->setProperty("name", "required", true);


			// Copy test files
			copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
			$_FILES["name"] = [
				"type" => ["image/png", "image/jpeg"],
				"name" => ["Test file png", "Test file jpg"],
				"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg"],
				"error" => ["", ""]
			];

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.png");
			unlink(LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (files, 1 allowed file, 1 disallowed file, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (files, 1 allowed file, 1 disallowed file, required) - error</div>
			<? endif;

		}



		// NUMBER

		if(1 && "number, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "number"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (number, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (number, string, not required) - error</div>
			<? endif;

		}


		if(1 && "number, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "number"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (number, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (number, empty, required) - error</div>
			<? endif;

		}


		if(1 && "number, number, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", "123.456");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") == "123.456" &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (number, number, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (number, number, required) - error</div>
			<? endif;

		}


		if(1 && "number, empty with min-value, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "number"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "min", 5.2);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
		
			if(
				!$messages && 

				$validation_result &&

				!$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (number, empty with min-value, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (number, empty with min-value, not required) - error</div>
			<? endif;

		}


		if(1 && "number, too low, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "number"]);

			$model->setProperty("name", "value", 20.199);
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "min", 20.2);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (number, too low, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (number, too low, required) - error</div>
			<? endif;

		}


		if(1 && "number, too high, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "number"]);

			$model->setProperty("name", "value", 10.120001);
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "max", 10.12);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (number, too high, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (number, too high, required) - error</div>
			<? endif;

		}


		if(1 && "number, not matching pattern, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "number"]);

			$model->setProperty("name", "value", "456.123");
			$model->setProperty("name", "pattern", "[1\.23]+");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (number, not matching pattern, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (number, not matching pattern, not required) - error</div>
			<? endif;

		}


		if(1 && "number, matching pattern, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "number"]);

			$model->setProperty("name", "value", "123.321");
			$model->setProperty("name", "pattern", "[123\.]+");
			$model->setProperty("name", "required", true);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (number, matching pattern, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (number, matching pattern, required) - error</div>
			<? endif;

		}



		// INTEGER

		if(1 && "integer, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "integer"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (integer, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (integer, string, not required) - error</div>
			<? endif;

		}


		if(1 && "integer, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "integer"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (integer, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (integer, empty, required) - error</div>
			<? endif;

		}


		if(1 && "integer, number, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "integer"]);

			$model->setProperty("name", "value", "123.456");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") == "123.456" &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (integer, number, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (integer, number, required) - error</div>
			<? endif;

		}


		if(1 && "integer, integer, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "integer"]);

			$model->setProperty("name", "value", "123");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") == "123" &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (integer, integer, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (integer, integer, required) - error</div>
			<? endif;

		}


		if(1 && "integer, empty with min-value, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "integer"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "min", 5);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
		
			if(
				!$messages && 

				$validation_result &&

				!$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (integer, empty with min-value, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (integer, empty with min-value, not required) - error</div>
			<? endif;

		}


		if(1 && "integer, too low, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "integer"]);

			$model->setProperty("name", "value", 19);
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "min", 20);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (integer, too low, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (integer, too low, required) - error</div>
			<? endif;

		}


		if(1 && "integer, too high, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "integer"]);

			$model->setProperty("name", "value", 12);
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "max", 10);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (integer, too high, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (integer, too high, required) - error</div>
			<? endif;

		}


		if(1 && "integer, not matching pattern, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "integer"]);

			$model->setProperty("name", "value", "456");
			$model->setProperty("name", "pattern", "[123]+");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (integer, not matching pattern, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (integer, not matching pattern, not required) - error</div>
			<? endif;

		}


		if(1 && "integer, matching pattern, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "integer"]);

			$model->setProperty("name", "value", "123321");
			$model->setProperty("name", "pattern", "[123]+");
			$model->setProperty("name", "required", true);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (integer, matching pattern, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (integer, matching pattern, required) - error</div>
			<? endif;

		}



		// EMAIL

		if(1 && "email, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "email"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (email, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (email, string, not required) - error</div>
			<? endif;

		}


		if(1 && "email, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "email"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (email, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (email, empty, required) - error</div>
			<? endif;

		}


		if(1 && "email, email, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "email"]);

			$model->setProperty("name", "value", "message+email@subdomain.domain.tld");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") == "message+email@subdomain.domain.tld" &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (email, email, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (email, email, required) - error</div>
			<? endif;

		}

		
		if(1 && "email, not matching custom pattern, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "email"]);

			$model->setProperty("name", "value", "456");
			$model->setProperty("name", "pattern", "[123]+");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (email, not matching pattern, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (email, not matching pattern, not required) - error</div>
			<? endif;

		}


		if(1 && "email, matching custom pattern, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "email"]);

			$model->setProperty("name", "value", "123321");
			$model->setProperty("name", "pattern", "[123]+");
			$model->setProperty("name", "required", true);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (email, matching pattern, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (email, matching pattern, required) - error</div>
			<? endif;

		}


		if(1 && "email, compare_to fail, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "email"]);

			$model->setProperty("name", "value", "message+email@subdomain.domain.tld");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "compare_to", "name_compare");

			$model->addToModel("name_compare", ["type" => "email"]);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (email, compare_to fail, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (email, compare_to fail, required) - error</div>
			<? endif;

		}


		if(1 && "email, compare_to, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "email"]);

			$model->setProperty("name", "value", "message+email@subdomain.domain.tld");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "compare_to", "name_compare");

			$model->addToModel("name_compare", ["type" => "email"]);

			$model->setProperty("name_compare", "value", "message+email@subdomain.domain.tld");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (email, compare_to, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (email, compare_to, required) - error</div>
			<? endif;

		}



		// TEL

		if(1 && "tel, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "tel"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (tel, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (tel, string, not required) - error</div>
			<? endif;

		}


		if(1 && "tel, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "tel"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (tel, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (tel, empty, required) - error</div>
			<? endif;

		}


		if(1 && "tel, tel, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "tel"]);

			$model->setProperty("name", "value", "12345");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") == "12345" &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (tel, tel, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (tel, tel, required) - error</div>
			<? endif;

		}

		
		if(1 && "tel, not matching custom pattern, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "tel"]);

			$model->setProperty("name", "value", "456");
			$model->setProperty("name", "pattern", "[123]+");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (tel, not matching pattern, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (tel, not matching pattern, not required) - error</div>
			<? endif;

		}


		if(1 && "tel, matching custom pattern, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "tel"]);

			$model->setProperty("name", "value", "123321");
			$model->setProperty("name", "pattern", "[123]+");
			$model->setProperty("name", "required", true);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (tel, matching pattern, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (tel, matching pattern, required) - error</div>
			<? endif;

		}


		if(1 && "tel, compare_to fail, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "tel"]);

			$model->setProperty("name", "value", "12345");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "compare_to", "name_compare");

			$model->addToModel("name_compare", ["type" => "tel"]);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (tel, compare_to fail, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (tel, compare_to fail, required) - error</div>
			<? endif;

		}


		if(1 && "tel, compare_to, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "tel"]);

			$model->setProperty("name", "value", "12345");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "compare_to", "name_compare");

			$model->addToModel("name_compare", ["type" => "tel"]);

			$model->setProperty("name_compare", "value", "12345");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (tel, compare_to, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (tel, compare_to, required) - error</div>
			<? endif;

		}



		// PASSWORD

		if(1 && "password, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "password"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (password, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (password, string, not required) - error</div>
			<? endif;

		}


		if(1 && "password, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "password"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (password, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (password, empty, required) - error</div>
			<? endif;

		}


		if(1 && "password, password, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "password"]);

			$model->setProperty("name", "value", "12345");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") == "12345" &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (password, password, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (password, password, required) - error</div>
			<? endif;

		}

		
		if(1 && "password, not matching custom pattern, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "password"]);

			$model->setProperty("name", "value", "456");
			$model->setProperty("name", "pattern", "[123]+");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (password, not matching pattern, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (password, not matching pattern, not required) - error</div>
			<? endif;

		}


		if(1 && "password, matching custom pattern, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "password"]);

			$model->setProperty("name", "value", "123321");
			$model->setProperty("name", "pattern", "[123]+");
			$model->setProperty("name", "required", true);


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (password, matching pattern, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (password, matching pattern, required) - error</div>
			<? endif;

		}


		if(1 && "password, compare_to fail, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "password"]);

			$model->setProperty("name", "value", "123321");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "compare_to", "name_compare");

			$model->addToModel("name_compare", ["type" => "password"]);

			$model->setProperty("name_compare", "value", "123");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (password, compare_to fail, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (password, compare_to fail, required) - error</div>
			<? endif;

		}


		if(1 && "password, compare_to, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "password"]);

			$model->setProperty("name", "value", "123321");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "compare_to", "name_compare");

			$model->addToModel("name_compare", ["type" => "password"]);

			$model->setProperty("name_compare", "value", "123321");


			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (password, compare_to, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (password, compare_to, required) - error</div>
			<? endif;

		}



		// DATE

		if(1 && "date, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "date"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (date, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (date, string, not required) - error</div>
			<? endif;

		}


		if(1 && "date, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "date"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (date, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (date, empty, required) - error</div>
			<? endif;

		}


		if(1 && "date, date, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "date"]);

			$model->setProperty("name", "value", "2019-07-01");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") == "2019-07-01" &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (date, date, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (date, date, required) - error</div>
			<? endif;

		}


		if(1 && "date, date before min, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "date"]);

			$model->setProperty("name", "value", "2019-07-01");
			$model->setProperty("name", "min", "2020-01-01");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (date, date before min, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (date, date before min, required) - error</div>
			<? endif;

		}


		if(1 && "date, date after min, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "date"]);

			$model->setProperty("name", "value", "2019-07-01");
			$model->setProperty("name", "min", "2000-01-01");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") == "2019-07-01" &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (date, date after min, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (date, date after min, required) - error</div>
			<? endif;

		}


		if(1 && "date, date after max, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "date"]);

			$model->setProperty("name", "value", "2019-07-01");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "max", "2000-01-01");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (date, date after max, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (date, date after max, required) - error</div>
			<? endif;

		}


		if(1 && "date, date before max, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "date"]);

			$model->setProperty("name", "value", "2019-07-01");
			$model->setProperty("name", "max", "2020-01-01");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (date, date before max, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (date, date before max, required) - error</div>
			<? endif;

		}


		if(1 && "date, date between min and max, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "date"]);

			$model->setProperty("name", "value", "2019-07-01");
			$model->setProperty("name", "max", "2000-01-01");
			$model->setProperty("name", "max", "2020-01-01");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (date, date between min and max, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (date, date between min and max, required) - error</div>
			<? endif;

		}



		// DATETIME

		if(1 && "datetime, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "datetime"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (datetime, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (datetime, string, not required) - error</div>
			<? endif;

		}


		if(1 && "datetime, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "datetime"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (datetime, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (datetime, empty, required) - error</div>
			<? endif;

		}


		if(1 && "datetime, datetime, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "datetime"]);

			$model->setProperty("name", "value", "2019-07-01 18:20");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (datetime, datetime, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (datetime, datetime, required) - error</div>
			<? endif;

		}


		if(1 && "datetime, datetime before min, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "datetime"]);

			$model->setProperty("name", "value", "2019-07-01 12:12:12");
			$model->setProperty("name", "min", "2020-01-01 12:12:12");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (datetime, datetime before min, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (datetime, datetime before min, required) - error</div>
			<? endif;

		}


		if(1 && "datetime, datetime after min, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "datetime"]);

			$model->setProperty("name", "value", "2019-07-01 12:12");
			$model->setProperty("name", "min", "2000-01-01");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (datetime, datetime after min, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (datetime, datetime after min, required) - error</div>
			<? endif;

		}


		if(1 && "datetime, datetime after max, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "datetime"]);

			$model->setProperty("name", "value", "2019-07-01 12:12");
			$model->setProperty("name", "required", true);
			$model->setProperty("name", "max", "2000-01-01");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (datetime, datetime after max, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (datetime, datetime after max, required) - error</div>
			<? endif;

		}


		if(1 && "datetime, datetime before max, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "datetime"]);

			$model->setProperty("name", "value", "2019-07-01 12:12");
			$model->setProperty("name", "max", "2020-01-01");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (datetime, datetime before max, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (datetime, datetime before max, required) - error</div>
			<? endif;

		}


		if(1 && "datetime, datetime between min and max, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "datetime"]);

			$model->setProperty("name", "value", "2019-07-01 12:12");
			$model->setProperty("name", "max", "2000-01-01");
			$model->setProperty("name", "max", "2020-01-01");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (datetime, datetime between min and max, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (datetime, datetime between min and max, required) - error</div>
			<? endif;

		}



		// CHECKBOX

		if(1 && "checkbox, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "checkbox"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (checkbox, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (checkbox, string, not required) - error</div>
			<? endif;

		}


		if(1 && "checkbox, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "checkbox"]);

			$model->setProperty("name", "value", "0");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (checkbox, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (checkbox, empty, required) - error</div>
			<? endif;

		}


		if(1 && "checkbox, checkbox, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "checkbox"]);

			$model->setProperty("name", "value", "1");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (checkbox, checkbox, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (checkbox, checkbox, required) - error</div>
			<? endif;

		}



		// RADIOBUTTONS

		if(1 && "radiobuttons, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "radiobuttons"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (radiobuttons, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (radiobuttons, string, not required) - error</div>
			<? endif;

		}


		if(1 && "radiobuttons, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "radiobuttons"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "required", true);

			$model->addToModel("name_2", ["type" => "radiobuttons"]);

			// "0" not accepted as valid answer (flowover from checkbox where "0" means not checked)
			$model->setProperty("name_2", "value", "0");
			$model->setProperty("name_2", "required", true);

			$validation_result = $model->validate("name");
			$validation_result = $model->validate("name_2");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 2 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error") &&
				$model->getProperty("name_2", "error")
			): ?>
			<div class="testpassed">Model::validate (radiobuttons, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (radiobuttons, empty, required) - error</div>
			<? endif;

		}


		if(1 && "radiobuttons, radiobuttons, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "radiobuttons"]);

			$model->setProperty("name", "value", "1");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (radiobuttons, radiobuttons, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (radiobuttons, radiobuttons, required) - error</div>
			<? endif;

		}



		// TAG

		if(1 && "tag, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "tag"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (tag, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (tag, string, not required) - error</div>
			<? endif;

		}


		if(1 && "tag, empty, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "tag"]);

			$model->setProperty("name", "value", "");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				!$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (tag, empty, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (tag, empty, required) - error</div>
			<? endif;

		}


		if(1 && "tag, tag, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "tag"]);

			$model->setProperty("name", "value", "1");
			$model->setProperty("name", "required", true);


			$model->addToModel("name_2", ["type" => "tag"]);

			$model->setProperty("name_2", "value", "post:Tag me, I'm yours ");
			$model->setProperty("name_2", "required", true);

			$validation_result = $model->validate("name");
			$validation_result = $model->validate("name_2");
			$messages = message()->getMessages();	

			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (tag, tag, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (tag, tag, required) - error</div>
			<? endif;

		}



		// USER_ID

		if(1 && "user_id, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "user_id"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (user_id, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (user_id, string, not required) - error</div>
			<? endif;

		}


		if(1 && "user_id, user_id, required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "user_id"]);

			$model->setProperty("name", "value", "1");
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (user_id, user_id, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (user_id, user_id, required) - error</div>
			<? endif;

		}



		// ITEM_ID

		if(1 && "item_id, string, not required") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "item_id"]);

			$model->setProperty("name", "value", "I'm a string");

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (item_id, string, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (item_id, string, not required) - error</div>
			<? endif;

		}


		if(1 && "item_id, item_id, required") {

			message()->resetMessages();

			$IC = new Items();
			$items = $IC->getItems(["limit" => 1]);

			$model = new Model();
			$model->addToModel("name", ["type" => "item_id"]);

			$model->setProperty("name", "value", $items[0]["id"]);
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (item_id, item_id, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (item_id, item_id, required) - error</div>
			<? endif;

		}



		// UNIQUE

		if(1 && "unique, unique") {

			message()->resetMessages();

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", randomKey(16));
			$model->setProperty("name", "unique", $IC->typeObject($items[0]["itemtype"])->db);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (unique, unique, not required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (unique, unique, not required) - error</div>
			<? endif;

		}


		if(1 && "unique, existing, required") {

			message()->resetMessages();

			$IC = new Items();
			$items = $IC->getItems(["limit" => 1, "extend" => true]);

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", $items[0]["name"]);
			$model->setProperty("name", "unique", $IC->typeObject($items[0]["itemtype"])->db);
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name");
			$messages = message()->getMessages();
	
			if(
				$messages && 
				isset($messages["error"]) && 
				count($messages["error"]) === 1 &&

				!$validation_result &&

				$model->getProperty("name", "value") &&
				$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (unique, existing, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (unique, existing, required) - error</div>
			<? endif;

		}


		if(1 && "unique, existing, item_id, required") {

			message()->resetMessages();

			$IC = new Items();
			$items = $IC->getItems(["limit" => 1, "extend" => true]);

			$model = new Model();
			$model->addToModel("name", ["type" => "string"]);

			$model->setProperty("name", "value", $items[0]["name"]);
			$model->setProperty("name", "unique", $IC->typeObject($items[0]["itemtype"])->db);
			$model->setProperty("name", "required", true);

			$validation_result = $model->validate("name", $items[0]["id"]);
			$messages = message()->getMessages();
	
			if(
				!$messages && 

				$validation_result &&

				$model->getProperty("name", "value") &&
				!$model->getProperty("name", "error")
			): ?>
			<div class="testpassed">Model::validate (unique, existing, item_id, required) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validate (unique, existing, item_id, required) - error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests validateAll">
		<h3>Model::validateAll</h3>
		<?


		if(1 && "validateAll, one failing") {

			message()->resetMessages();

			$model = new Model();

			$model->addToModel("name1", ["type" => "string", "required" => true]);
			$model->addToModel("name2", ["type" => "string", "required" => true]);
			$model->addToModel("name3", ["type" => "string", "required" => true]);

			$model->setProperty("name1", "value", randomKey(16));
			$model->setProperty("name2", "value", randomKey(16));

			$validation_result = $model->validateAll();
			$messages = message()->getMessages();

			if(
				$messages && 
				isset($messages["error"]) && 

				!$validation_result &&

				$model->getProperty("name1", "value") &&
				$model->getProperty("name2", "value") &&
				!$model->getProperty("name3", "value") &&
				!$model->getProperty("name1", "error") &&
				$model->getProperty("name3", "error")
			): ?>
			<div class="testpassed">Model::validateAll - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validateAll - error</div>
			<? endif;

		}	


		if(1 && "validateAll, positive cannot be tested meaningfully (yet) – some defaults are required (still)") {}


		?>
	</div>

	<div class="tests validateList">
		<h3>Model::validateList</h3>
		<?


		if(1 && "validateList, one failing") {

			message()->resetMessages();

			$model = new Model();

			$model->addToModel("name1", ["type" => "string", "required" => true]);
			$model->addToModel("name2", ["type" => "string", "required" => true]);
			$model->addToModel("name3", ["type" => "string", "required" => true]);

			$model->setProperty("name1", "value", randomKey(16));
			$model->setProperty("name2", "value", randomKey(16));

			$validation_result = $model->validateList(["name1", "name2", "name3"]);
			$messages = message()->getMessages();

			if(
				$messages && 
				isset($messages["error"]) && 

				!$validation_result &&

				$model->getProperty("name1", "value") &&
				$model->getProperty("name2", "value") &&
				!$model->getProperty("name3", "value") &&
				!$model->getProperty("name1", "error") &&
				$model->getProperty("name3", "error")
			): ?>
			<div class="testpassed">Model::validateList (one failing) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validateList (one failing) - error</div>
			<? endif;

		}


		if(1 && "validateList, all valid") {

			message()->resetMessages();

			$model = new Model();

			$model->addToModel("name1", ["type" => "string", "required" => true]);
			$model->addToModel("name2", ["type" => "string", "required" => true]);
			$model->addToModel("name3", ["type" => "string", "required" => true]);

			$model->setProperty("name1", "value", randomKey(16));
			$model->setProperty("name2", "value", randomKey(16));
			$model->setProperty("name3", "value", randomKey(16));

			$validation_result = $model->validateList(["name1", "name2", "name3"]);
			$messages = message()->getMessages();

			if(
				!$messages &&

				$validation_result &&

				$model->getProperty("name1", "value") &&
				$model->getProperty("name2", "value") &&
				$model->getProperty("name3", "value") &&
				!$model->getProperty("name1", "error") &&
				!$model->getProperty("name2", "error") &&
				!$model->getProperty("name3", "error")
			): ?>
			<div class="testpassed">Model::validateList (all valid) - correct</div>
			<? else: ?>
			<div class="testfailed">Model::validateList (all valid) - error</div>
			<? endif;

		}


		?>
	</div>


</div>