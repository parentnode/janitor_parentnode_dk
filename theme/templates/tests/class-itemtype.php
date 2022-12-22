<?



function manualCleanUp($item_id) {
	$fs = new FileSystem();
	$query = new Query();

	$query->sql("DELETE FROM ".UT_ITEMS." WHERE id = $item_id");

	$fs->removeDirRecursively(PUBLIC_FILE_PATH."/$item_id");
	$fs->removeDirRecursively(PRIVATE_FILE_PATH."/$item_id");


	message()->resetMessages();
	unset($_POST);
	unset($_GET);
	unset($_FILES);

}


?>

<div class="scene i:scene tests">
	<h1>Itemtype Class</h1>	
	<h2>Item manipulation</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests save">
		<h3>Itemtype->save</h3>
		<? 

		// Save test items

		if(1 && "save (no values)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				// Clear Datasets
				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				// Get current set of test items for reference
				$starting_tests_items = $IC->getItems(["itemtype" => "tests"]);


				// NO VALUES
				unset($_POST);
				$test_save_no_values = $tests_model->save(array("save"));

				// Get reference items
				$reference_tests_items = $IC->getItems(["itemtype" => "tests"]);

				// debug([(!$test_save_no_values), count($starting_tests_items), count($reference_tests_items), ($starting_tests_items === $reference_tests_items) ? "" : $starting_tests_items]);
				// Test
				if(!$test_save_no_values && $starting_tests_items === $reference_tests_items): ?>
				<div class="testpassed">Itemtype->save (no values) - correct</div>
				<? else: ?>
				<div class="testfailed">Itemtype->save (no values) - error</div>
				<? endif;

			})();

		}

		if(1 && "save (values sent as GET – fails)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				// Clear Datasets
				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				// Get current set of test items for reference
				$starting_tests_items = $IC->getItems(["itemtype" => "tests"]);



				// VALUES SENT AS GET
				$_GET["name"] = "Test GET item";
				$test_save_get_values = $tests_model->save(array("save"));

				// Get reference items
				$reference_tests_items = $IC->getItems(["itemtype" => "tests"]);

				// Test
				if(!$test_save_get_values && $starting_tests_items === $reference_tests_items): ?>
				<div class="testpassed">Itemtype->save (values sent as GET – fails) - correct</div>
				<? else: ?>
				<div class="testfailed">Itemtype->save (values sent as GET – fails) - error</div>
				<? endif;

			})();

		}

		if(1 && "save (name only)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				// Clear Datasets
				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				// Get current set of test items for reference
				$starting_tests_items = $IC->getItems(["itemtype" => "tests"]);



				// SIMPLEST ITEM (name only)
				$_POST["name"] = "Test simple item";
				$test_save_simple = $tests_model->save(array("save"));

				// Get reference items
				$reference_tests_items = $IC->getItems(["itemtype" => "tests"]);
				$reference_item = $IC->getItem(["id" => $test_save_simple["id"], "extend" => ["all" => true]]);

				// Test
				if($test_save_simple &&
					$reference_item["name"] === $test_save_simple["name"] &&
					$reference_item["name"] === $_POST["name"] &&

					$reference_item["status"] == 0 &&
					strpos($reference_item["sindex"], superNormalize($reference_item["name"])) === 0 &&
					$reference_item["user_id"] == session()->value("user_id") &&

					strtotime($reference_item["created_at"]) <= time() &&
					strtotime($reference_item["created_at"]) > time()-1000 &&

					!$reference_item["v_text"] &&
					!$reference_item["v_password"] &&
					!$reference_item["v_datetime"] &&
					!$reference_item["v_html"] &&
					!$reference_item["v_location"] &&

					!$reference_item["mediae"] &&
					!$reference_item["comments"] &&
					!$reference_item["ratings"] &&
					!$reference_item["prices"] &&
					!$reference_item["subscription_method"] &&

					count($starting_tests_items)+1 === count($reference_tests_items)
				): ?>
				<div class="testpassed">Itemtype->save (name only) - correct</div>
				<? else: ?>
				<div class="testfailed">Itemtype->save (name only) - error</div>
				<? endif;

				// Clear Datasets
				manualCleanUp($test_save_simple["id"]);

			})();

		}

		if(1 && "standard input types only)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				// Get current set of test items for reference
				$starting_tests_items = $IC->getItems(["itemtype" => "tests"]);


				// PLAIN ITEM (all standard input types, - excluding files and tags)
				$_POST["name"] = "Test plain item (æøå)";

				$_POST["v_text"] = "v_text 2";
				$_POST["v_email"] = "v_email_2@domain.com";
				$_POST["v_tel"] = "2222-2222";
				$_POST["v_password"] = "v_password 2";
				$_POST["v_select"] = "v_select 2";
				$_POST["v_datetime"] = "2022-02-22 22:22:22";
				$_POST["v_date"] = "2022-02-22";
				$_POST["v_integer"] = "2";
				$_POST["v_number"] = "2.2";

				$_POST["v_checkbox"] = "v_checkbox 2";
				$_POST["v_radiobuttons"] = "v_radiobuttons 2";

				$_POST["v_html"] = "v_html 2";

				$_POST["v_location"] = "v_location 2";
				$_POST["v_latitude"] = "2.1";
				$_POST["v_longitude"] = "2.2";

				$test_save_plain = $tests_model->save(array("save"));

				// Get reference items
				$reference_tests_items = $IC->getItems(["itemtype" => "tests"]);
				$reference_item = $IC->getItem(["id" => $test_save_plain["id"], "extend" => ["all" => true]]);

				// Test
				if($test_save_plain &&
					$reference_item["name"] === $test_save_plain["name"] &&
					$reference_item["name"] === $_POST["name"] &&

					$reference_item["status"] == 0 &&
					strpos($reference_item["sindex"], superNormalize($reference_item["name"])) === 0 &&
					$reference_item["user_id"] == session()->value("user_id") &&

					strtotime($reference_item["created_at"]) <= time() &&
					strtotime($reference_item["created_at"]) > time()-1000 &&

					$reference_item["v_text"] === $test_save_plain["v_text"] &&
					$reference_item["v_text"] === $_POST["v_text"] &&

					$reference_item["v_email"] === $_POST["v_email"] &&
					$reference_item["v_tel"] === $_POST["v_tel"] &&
					$reference_item["v_password"] === $_POST["v_password"] &&
					$reference_item["v_select"] === $_POST["v_select"] &&
					$reference_item["v_datetime"] === $_POST["v_datetime"] &&
					$reference_item["v_date"] === $_POST["v_date"] &&
					$reference_item["v_integer"] === $_POST["v_integer"] &&
					$reference_item["v_number"] === $_POST["v_number"] &&
					$reference_item["v_checkbox"] === $_POST["v_checkbox"] &&
					$reference_item["v_radiobuttons"] === $_POST["v_radiobuttons"] &&
					$reference_item["v_html"] === $_POST["v_html"] &&
					$reference_item["v_location"] === $_POST["v_location"] &&
					$reference_item["v_latitude"] === $_POST["v_latitude"] &&
					$reference_item["v_longitude"] === $_POST["v_longitude"] &&

					!$reference_item["mediae"] &&
					!$reference_item["comments"] &&
					!$reference_item["ratings"] &&
					!$reference_item["prices"] &&
					!$reference_item["subscription_method"] &&

					count($starting_tests_items)+1 === count($reference_tests_items)
				): ?>
				<div class="testpassed">Itemtype->save (standard input types only) - correct</div>
				<? else: ?>
				<div class="testfailed">Itemtype->save (standard input types only) - error</div>
				<? endif;



				// Clear Datasets
				manualCleanUp($test_save_plain["id"]);

			})();

		}

		if(1 && "save (simple with status)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);

				// Get current set of test items for reference
				$starting_tests_items = $IC->getItems(["itemtype" => "tests"]);


				// SIMPLE ITEM WITH STATUS AND PUBLISHED AT
				$_POST["name"] = "Test simple item (æøå)";
				$_POST["status"] = 1;
				// Experiment with syntax (Should accept dash as time separator)
				$_POST["published_at"] = "2022-02-22 22-22-22";

				$test_save_simple_status = $tests_model->save(array("save"));

				// Get reference items
				$reference_tests_items = $IC->getItems(["itemtype" => "tests"]);
				$reference_item = $IC->getItem(["id" => $test_save_simple_status["id"], "extend" => ["all" => true]]);

				// debug([message()->getMessages(), "test", $test_save_simple_status, $reference_item]);

				// Test
				if($test_save_simple_status &&
					$reference_item["name"] === $test_save_simple_status["name"] &&
					$reference_item["name"] === $_POST["name"] &&

					$reference_item["status"] == 1 &&
					strpos($reference_item["sindex"], superNormalize($reference_item["name"])) === 0 &&
					$reference_item["user_id"] == session()->value("user_id") &&

					strtotime($reference_item["created_at"]) <= time() &&
					strtotime($reference_item["created_at"]) > time()-1000 &&

					!$reference_item["mediae"] &&
					!$reference_item["comments"] &&
					!$reference_item["ratings"] &&
					!$reference_item["prices"] &&
					!$reference_item["subscription_method"] &&

					count($starting_tests_items)+1 === count($reference_tests_items)
				): ?>
				<div class="testpassed">Itemtype->save (simple with status) - correct</div>
				<? else: ?>
				<div class="testfailed">Itemtype->save (simple with status) - error</div>
				<? endif;

				// Clear Datasets
				manualCleanUp($test_save_simple_status["id"]);

			})();

		}

		if(1 && "save (with file)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);

				// Get current set of test items for reference
				$starting_tests_items = $IC->getItems(["itemtype" => "tests"]);



				// COMPLEX (WITH FILE)

				// Copy test file
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_POST["name"] = "Test complex item, file";
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test-file.png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$test_save_file = $tests_model->save(array("save"));

				// Get reference items
				$reference_tests_items = $IC->getItems(["itemtype" => "tests"]);
				$reference_item = $IC->getItem(["id" => $test_save_file["id"], "extend" => ["all" => true]]);

				// debug([message()->getMessages(), "test", $test_save_file, $reference_item]);

				// Test
				if($test_save_file &&
					$reference_item["name"] === $test_save_file["name"] &&
					$reference_item["name"] === $_POST["name"] &&

					strpos($reference_item["sindex"], superNormalize($reference_item["name"])) === 0 &&
					$reference_item["user_id"] == session()->value("user_id") &&

					strtotime($reference_item["created_at"]) <= time() &&
					strtotime($reference_item["created_at"]) > time()-1000 &&

					$reference_item["mediae"] && 
					$reference_item["mediae"]["v_file"] &&
					$reference_item["mediae"]["v_file"]["name"] === $_FILES["v_file"]["name"][0] &&
					$reference_item["mediae"]["v_file"]["format"] === "png" &&

					!file_exists("templates/tests/file_upload/test-running.png") &&

					!$reference_item["comments"] &&
					!$reference_item["ratings"] &&
					!$reference_item["prices"] &&
					!$reference_item["subscription_method"] &&

					count($starting_tests_items)+1 === count($reference_tests_items)
				): ?>
				<div class="testpassed">Itemtype->save (with file) - correct</div>
				<? else: ?>
				<div class="testfailed">Itemtype->save (with file) - error</div>
				<? endif;

				// Clear Datasets
				manualCleanUp($test_save_file["id"]);

			})();

		}

		if(1 && "save (with files)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// Get current set of test items for reference
				$starting_tests_items = $IC->getItems(["itemtype" => "tests"]);



				// COMPLEX (WITH FILES)

				// Ensure fitting min limit
				$tests_model->setProperty("v_files", "min", 2);

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
				$_POST["name"] = "Test complex item, multiple files";
				$_FILES["v_files"] = [
					"type" => ["image/png", "image/jpeg"],
					"name" => ["Test file png", "Test file jpg"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg"],
					"error" => ["", ""]
				];

				$test_save_files = $tests_model->save(array("save"));

				// Get reference items
				$reference_tests_items = $IC->getItems(["itemtype" => "tests"]);
				$reference_item = $IC->getItem(["id" => $test_save_files["id"], "extend" => ["all" => true]]);

				list($variant1, $variant2) = array_keys($reference_item["mediae"]);

				// debug([message()->getMessages(), "test", $test_save_files, $reference_item, $variant1, $variant2]);

				// Test
				if($test_save_files &&
					$reference_item["name"] === $test_save_files["name"] &&
					$reference_item["name"] === $_POST["name"] &&

					strpos($reference_item["sindex"], superNormalize($reference_item["name"])) === 0 &&
					$reference_item["user_id"] == session()->value("user_id") &&

					strtotime($reference_item["created_at"]) <= time() &&
					strtotime($reference_item["created_at"]) > time()-1000 &&

					$reference_item["mediae"] &&
					count($reference_item["mediae"]) === 2 &&

					$reference_item["mediae"][$variant1]["name"] === $_FILES["v_files"]["name"][1] &&
					$reference_item["mediae"][$variant1]["format"] === "jpg" &&
					$reference_item["mediae"][$variant2]["name"] === $_FILES["v_files"]["name"][0] &&
					$reference_item["mediae"][$variant2]["format"] === "png" &&

					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists("templates/tests/file_upload/test-running.jpg") &&

					!$reference_item["comments"] &&
					!$reference_item["ratings"] &&
					!$reference_item["prices"] &&
					!$reference_item["subscription_method"] &&

					count($starting_tests_items)+1 === count($reference_tests_items)
				): ?>
				<div class="testpassed">Itemtype->save (with files) - correct</div>
				<? else: ?>
				<div class="testfailed">Itemtype->save (with files) - error</div>
				<? endif;

				// Clear Datasets
				manualCleanUp($test_save_files["id"]);

			})();

		}


		?>
	</div>

	<div class="tests update">
		<h3>Itemtype->update</h3>
		<?

		if(1 && "update (standard inputs)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);


				// SIMPLEST ITEM (name only)
				$_POST["name"] = "Test simple item";
				$test_save_simple = $tests_model->save(array("save"));
				$item_id = $test_save_simple["id"];

				// Get reference items
				$reference_item = $IC->getItem(["id" => $item_id, "extend" => ["all" => true]]);

				// We apear to have a valid item
				if(
					$test_save_simple && 
					$reference_item && 
					$test_save_simple === $reference_item &&

					strpos($reference_item["sindex"], superNormalize($reference_item["name"])) === 0

				) {

					message()->resetMessages();
					unset($_POST);


					// Prepare for update
					$_POST["name"] = "Updated simple item";

					// Play tricks with date format
					$_POST["published_at"] = "2022-02-22 22:22:22";

					$_POST["v_text"] = "v_text 2";
					$_POST["v_email"] = "v_email_2@domain.com";
					$_POST["v_tel"] = "2222-2222";
					$_POST["v_password"] = "v_password 2";
					$_POST["v_select"] = "v_select 2";
					$_POST["v_datetime"] = "2019-10-11 12:30:00";
					$_POST["v_date"] = "2019-10-11";
					$_POST["v_integer"] = "2";
					$_POST["v_number"] = "2.2";

					$_POST["v_checkbox"] = "v_checkbox 2";
					$_POST["v_radiobuttons"] = "v_radiobuttons 2";

					$_POST["v_html"] = "<p>v_html 2</p>";

					$_POST["v_location"] = "v_location 2";
					$_POST["v_latitude"] = "2.1";
					$_POST["v_longitude"] = "2.2";

					// SHOULD BE IGNORED
					$_POST["user_id"] = 1;
					$_POST["status"] = 1;

					$_POST["htmleditor_media"] = "v_html 2";
					$_POST["htmleditor_file"] = "v_location 2";

					$test_update_simple = $tests_model->update(array("update", $item_id));

					// Get reference items
					$reference_item_updated = $IC->getItem(["id" => $item_id, "extend" => ["all" => true]]);

					// Test
					if($test_update_simple &&
						$reference_item["name"] !== $reference_item_updated["name"] &&
						$reference_item["v_text"] !== $reference_item_updated["v_text"] &&
						$reference_item["v_email"] !== $reference_item_updated["v_email"] &&

						$reference_item_updated["name"] === $_POST["name"] &&

						// sindex not automatically updated – should still be the original value
						strpos($reference_item["sindex"], superNormalize($reference_item["name"])) === 0 &&

						$reference_item_updated["created_at"] === $reference_item["created_at"] &&

						$reference_item_updated["v_text"] === $_POST["v_text"] &&
						$reference_item_updated["v_email"] === $_POST["v_email"] &&
						$reference_item_updated["v_tel"] === $_POST["v_tel"] &&
						$reference_item_updated["v_password"] === $_POST["v_password"] &&
						$reference_item_updated["v_select"] === $_POST["v_select"] &&
						$reference_item_updated["v_datetime"] === $_POST["v_datetime"] &&
						$reference_item_updated["v_date"] === $_POST["v_date"] &&
						$reference_item_updated["v_integer"] === $_POST["v_integer"] &&
						$reference_item_updated["v_number"] === $_POST["v_number"] &&
						$reference_item_updated["v_checkbox"] === $_POST["v_checkbox"] &&
						$reference_item_updated["v_radiobuttons"] === $_POST["v_radiobuttons"] &&
						$reference_item_updated["v_html"] === $_POST["v_html"] &&
						$reference_item_updated["v_location"] === $_POST["v_location"] &&
						$reference_item_updated["v_latitude"] === $_POST["v_latitude"] &&
						$reference_item_updated["v_longitude"] === $_POST["v_longitude"] &&

						!$reference_item["mediae"] &&
						!$reference_item["comments"] &&
						!$reference_item["ratings"] &&
						!$reference_item["prices"] &&
						!$reference_item["subscription_method"] &&

						// Should be unchanged
						$reference_item_updated["status"] == 0 &&
						$reference_item["user_id"] == session()->value("user_id")
					): ?>
					<div class="testpassed">Itemtype->update (standard inputs) - correct</div>
					<? else: ?>
					<div class="testfailed">Itemtype->update (standard inputs) - error</div>
					<? endif;


					// Clear Datasets
					manualCleanUp($item_id);

				}

				else { ?>
					<div class="testfailed">Itemtype->update (failed on save) - error</div>
				<? }

			})();

		}

		if(1 && "update (file)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// SIMPLEST ITEM (name only)
				$_POST["name"] = "Test simple item";
				$test_save_simple = $tests_model->save(array("save"));
				$item_id = $test_save_simple["id"];

				// Get reference items
				$reference_item = $IC->getItem(["id" => $item_id, "extend" => ["all" => true]]);

				// We apear to have a valid item
				if($test_save_simple && $reference_item && $test_save_simple === $reference_item) {


					message()->resetMessages();
					unset($_POST);

					// Test File
					copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
					$_POST["name"] = "Test update, file";
					$_FILES["v_file"] = [
						"type" => ["image/png"],
						"name" => ["Test file png"],
						"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
						"error" => [""]
					];

					$test_update_file = $tests_model->update(array("update", $item_id));

					// Get reference items
					$reference_item_updated = $IC->getItem(["id" => $item_id, "extend" => ["all" => true]]);

					// Test
					if($reference_item_updated["mediae"] &&
						count($reference_item_updated["mediae"]) === 1 &&

						$reference_item_updated["mediae"]["v_file"]["name"] === $_FILES["v_file"]["name"][0] &&
						$reference_item_updated["mediae"]["v_file"]["format"] === "png" &&

						!file_exists("templates/tests/file_upload/test-running.png")
					): ?>
					<div class="testpassed">Itemtype->update (file) - correct</div>
					<? else: ?>
					<div class="testfailed">Itemtype->update (file) - error</div>
					<? endif;


					// Clear Datasets
					manualCleanUp($item_id);

				}
				else { ?>
					<div class="testfailed">Itemtype->update (failed on save) - error</div>
				<? }

			})();

		}

		if(1 && "update (file, overwrite)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// SIMPLEST ITEM (name only)
				$_POST["name"] = "Test simple item";
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test file png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$test_save_simple = $tests_model->save(array("save"));
				$item_id = $test_save_simple["id"];

				// Get reference items
				$reference_item = $IC->getItem(["id" => $item_id, "extend" => ["all" => true]]);

				// We apear to have a valid item
				if($test_save_simple && $reference_item && $test_save_simple === $reference_item) {


					message()->resetMessages();
					unset($_POST);


					// Overwrite File
					copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
					$_POST["name"] = "Test update, file";
					$_FILES["v_file"] = [
						"type" => ["image/jpeg"],
						"name" => ["Test file jpg"],
						"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.jpg"],
						"error" => [""]
					];

					$test_update_file = $tests_model->update(array("update", $item_id));

					// Get reference items
					$reference_item_updated = $IC->getItem(["id" => $item_id, "extend" => ["all" => true]]);

					// Test
					if($test_update_file &&
						$reference_item_updated["mediae"] &&
						count($reference_item_updated["mediae"]) === 1 &&

						$reference_item_updated["mediae"]["v_file"]["name"] === $_FILES["v_file"]["name"][0] &&
						$reference_item_updated["mediae"]["v_file"]["format"] === "jpg" &&

						!file_exists("templates/tests/file_upload/test-running.jpg")
					): ?>
					<div class="testpassed">Itemtype->update (file, overwrite) - correct</div>
					<? else: ?>
					<div class="testfailed">Itemtype->update (file, overwrite) - error</div>
					<? endif;


					// Clear Datasets
					manualCleanUp($item_id);

				}
				else { ?>
					<div class="testfailed">Itemtype->update (failed on save) - error</div>
				<? }

			})();

		}

		if(1 && "update (files)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");


				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// SIMPLEST ITEM (name only)
				$_POST["name"] = "Test simple item";
				$test_save_simple = $tests_model->save(array("save"));
				$item_id = $test_save_simple["id"];

				// Get reference items
				$reference_item = $IC->getItem(["id" => $item_id, "extend" => ["all" => true]]);

				// We apear to have a valid item
				if($test_save_simple && $reference_item && $test_save_simple === $reference_item) {


					message()->resetMessages();
					unset($_POST);

					// Test files (v_files has min of 3 files)
					// Copy test files
					copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running-1.png");
					copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-2.jpg");
					copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-3.jpg");
					$_POST["name"] = "Test complex item, multiple files";
					$_FILES["v_files"] = [
						"type" => ["image/png", "image/jpeg", "image/jpeg"],
						"name" => ["Test file png 1", "Test file jpg 1", "Test file jpg 2"],
						"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running-1.png", LOCAL_PATH."/templates/tests/file_upload/test-running-2.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-3.jpg"],
						"error" => ["", "", ""]
					];
	
					$test_update_files = $tests_model->update(array("update", $item_id));

					// Get reference items
					$reference_item_updated = $IC->getItem(["id" => $item_id, "extend" => ["all" => true]]);

					list($variant3, $variant2, $variant1) = array_keys($reference_item_updated["mediae"]);
					// debug([$variant1, $variant2, $variant3]);

					// Test
					if($test_update_files &&
						$reference_item_updated["mediae"] &&
						count($reference_item_updated["mediae"]) === 3 &&

						$reference_item_updated["mediae"][$variant1]["name"] === $_FILES["v_files"]["name"][0] &&
						$reference_item_updated["mediae"][$variant1]["format"] === "png" &&
						$reference_item_updated["mediae"][$variant2]["name"] === $_FILES["v_files"]["name"][1] &&
						$reference_item_updated["mediae"][$variant2]["format"] === "jpg" &&
						$reference_item_updated["mediae"][$variant3]["name"] === $_FILES["v_files"]["name"][2] &&
						$reference_item_updated["mediae"][$variant3]["format"] === "jpg" &&

						!file_exists("templates/tests/file_upload/test-running-1.png") &&
						!file_exists("templates/tests/file_upload/test-running-2.jpg") &&
						!file_exists("templates/tests/file_upload/test-running-3.jpg")

					): ?>
					<div class="testpassed">Itemtype->update (files) - correct</div>
					<? else: ?>
					<div class="testfailed">Itemtype->update (files) - error</div>
					<? endif;


					// Clear Datasets
					manualCleanUp($item_id);

				}
				else { ?>
					<div class="testfailed">Itemtype->update (failed on save) - error</div>
				<? }

			})();

		}

		if(1 && "update (files, add)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");


				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// Test files (v_files has min of 3 files)
				// SIMPLEST ITEM (name only)
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running-1.png");
				copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-2.jpg");
				copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-3.jpg");
				$_POST["name"] = "Test complex item, multiple files";
				$_FILES["v_files"] = [
					"type" => ["image/png", "image/jpeg", "image/jpeg"],
					"name" => ["Test file png 1", "Test file jpg 1", "Test file jpg 2"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running-1.png", LOCAL_PATH."/templates/tests/file_upload/test-running-2.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-3.jpg"],
					"error" => ["", "", ""]
				];

				$test_save_simple = $tests_model->save(array("save"));
				$item_id = $test_save_simple["id"];

				// Get reference items
				$reference_item = $IC->getItem(["id" => $item_id, "extend" => ["all" => true]]);

				// We apear to have a valid item
				if($test_save_simple && $reference_item && $test_save_simple === $reference_item) {


					message()->resetMessages();
					unset($_POST);
					unset($_FILES);

					// Test files (v_files has min of 3 files)
					// Copy test files
					copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running-1.png");
					copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-2.jpg");
					copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-3.jpg");
					$_POST["name"] = "Test complex item, multiple files";
					$_FILES["v_files"] = [
						"type" => ["image/png", "image/jpeg", "image/jpeg"],
						"name" => ["Test 2 file png 1", "Test 2 file jpg 1", "Test 2 file jpg 2"],
						"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running-1.png", LOCAL_PATH."/templates/tests/file_upload/test-running-2.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-3.jpg"],
						"error" => ["", "", ""]
					];

	
					$test_update_files = $tests_model->update(array("update", $item_id));

					// Get reference items
					$reference_item_updated = $IC->getItem(["id" => $item_id, "extend" => ["all" => true]]);

					list($variant3, $variant2, $variant1) = array_keys($reference_item_updated["mediae"]);
					// debug([$reference_item, $reference_item_updated, message()->getMessages()]);

					// Test
					if($test_update_files &&
						$reference_item_updated["mediae"] &&
						count($reference_item_updated["mediae"]) === 6 &&

						$reference_item_updated["mediae"][$variant1]["name"] === $_FILES["v_files"]["name"][0] &&
						$reference_item_updated["mediae"][$variant1]["format"] === "png" &&
						$reference_item_updated["mediae"][$variant2]["name"] === $_FILES["v_files"]["name"][1] &&
						$reference_item_updated["mediae"][$variant2]["format"] === "jpg" &&
						$reference_item_updated["mediae"][$variant3]["name"] === $_FILES["v_files"]["name"][2] &&
						$reference_item_updated["mediae"][$variant3]["format"] === "jpg" &&

						!file_exists("templates/tests/file_upload/test-running.png") &&
						!file_exists("templates/tests/file_upload/test-running.jpg")

					): ?>
					<div class="testpassed">Itemtype->update (files, add) - correct</div>
					<? else: ?>
					<div class="testfailed">Itemtype->update (files, add) - error</div>
					<? endif;


					// Clear Datasets
					manualCleanUp($item_id);

				}
				else { ?>
					<div class="testfailed">Itemtype->update (failed on save) - error</div>
				<? }

			})();

		}

		?>
	</div>

	<div class="tests delete">
		<h3>Itemtype->delete</h3>
		<?

		if(1 && "delete (simple)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);


				// DELETE SIMPLE
				$_POST["name"] = "Test simple item";
				$test_delete_simple = $tests_model->save(array("save"));

				// Get reference items
				if($test_delete_simple) {

					$deleted = $tests_model->delete(array("delete", $test_delete_simple["id"]));
					$reference_item = $IC->getItem(["id" => $test_delete_simple["id"], "extend" => ["all" => true]]);

					// Test
					if($deleted &&
						!$reference_item &&

						!file_exists(PRIVATE_FILE_PATH."/".$test_delete_simple["id"]) &&
						!file_exists(PUBLIC_FILE_PATH."/".$test_delete_simple["id"])
					): ?>
					<div class="testpassed">Itemtype->delete (simple) - correct</div>
					<? else: ?>
					<div class="testfailed">Itemtype->delete (simple) - error</div>
					<? endif;

				}
				else { ?>
					<div class="testfailed">Itemtype->delete (failed on save) - error</div>
				<? } 

			})();

		}

		if(1 && "delete (files)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);


				// Test files (v_files has min of 3 files)
				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running-1.png");
				copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-2.jpg");
				copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-3.jpg");
				$_POST["name"] = "Test complex item, multiple files";
				$_FILES["v_files"] = [
					"type" => ["image/png", "image/jpeg", "image/jpeg"],
					"name" => ["Test file png 1", "Test file jpg 1", "Test file jpg 2"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running-1.png", LOCAL_PATH."/templates/tests/file_upload/test-running-2.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running-3.jpg"],
					"error" => ["", "", ""]
				];

				$test_delete_files = $tests_model->save(array("save"));

				// Get reference items
				$reference_item = $IC->getItem(["id" => $test_delete_files["id"], "extend" => ["all" => true]]);

				// debug([$test_delete_files, $reference_item, message()->getMessages()]);

				// Test
				if($test_delete_files &&
					$reference_item["mediae"] &&
					count($reference_item["mediae"]) === 3
				) {

					$deleted = $tests_model->delete(array("delete", $test_delete_files["id"]));
					$reference_item = $IC->getItem(["id" => $test_delete_files["id"], "extend" => ["all" => true]]);

					// Test
					if($deleted &&
						!$reference_item &&

						!file_exists(PRIVATE_FILE_PATH."/".$test_delete_files["id"]) &&
						!file_exists(PUBLIC_FILE_PATH."/".$test_delete_files["id"])
					): ?>
					<div class="testpassed">Itemtype->delete (files) - correct</div>
					<? else: ?>
					<div class="testfailed">Itemtype->delete (files) - error</div>
					<? endif;

				}
				else { ?>
					<div class="testfailed">Itemtype->delete (files, failed on save) - error</div>
				<? }

			})();

		}

		?>
	</div>

	<div class="tests upload">
		<h3>Itemtype->upload</h3>
		<?

		if(1 && "upload (single png)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();


				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);


				// TEST SINGLE FILE UPLOAD


				// Set allowed formats for initial test
				$tests_model->setProperty("v_file", "allowed_formats", "png,jpg");


				// Create test item
				$_POST["name"] = "Test upload, 1";
				$test_upload = $tests_model->save(array("save"));
				$item_id = $test_upload["id"];


				// TEST ALLOWED FILE (PNG)

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test-file.png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					count($uploads) === 1 &&
					$uploads[0]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads[0]["format"] === "png" &&
					$uploads[0]["width"] === 512 &&
					$uploads[0]["height"] === 288 &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.png") &&
					$uploads[0]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/png") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (single png) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (single png) - error</div>
				<? endif;


				// Clear Datasets
				manualCleanUp($item_id);

			})();

		}

		if(1 && "upload (overwrite, single jpg)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);


				// TEST SINGLE FILE OVERWRITE
				// Set allowed formats for initial test
				$tests_model->setProperty("v_file", "allowed_formats", "png,jpg");


				// Create test item
				$_POST["name"] = "Test upload, 1";
				$test_upload = $tests_model->save(array("save"));
				$item_id = $test_upload["id"];


				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test-file.png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];


				// Overwrite previously uploaded file

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
				$_FILES["v_file"] = [
					"type" => ["image/jpg"],
					"name" => ["Test-file.jpg"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.jpg"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					count($uploads) === 1 &&
					$uploads[0]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads[0]["format"] === "jpg" &&
					$uploads[0]["width"] === 512 &&
					$uploads[0]["height"] === 288 &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.jpg") &&
					$uploads[0]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.jpg") &&
					!file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/jpg") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (overwrite, single jpg) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (overwrite, single jpg) - error</div>
				<? endif;

				// Clear Datasets
				manualCleanUp($item_id);

			})();

		}

		if(1 && "upload (disallowed, single txt)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);


				// Set allowed formats for initial test
				$tests_model->setProperty("v_file", "allowed_formats", "png,jpg");


				// Create test item
				$_POST["name"] = "Test upload, 1";
				copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
				$_FILES["v_file"] = [
					"type" => ["image/jpg"],
					"name" => ["Test-file.jpg"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.jpg"],
					"error" => [""]
				];

				$test_upload = $tests_model->save(array("save"));
				$item_id = $test_upload["id"];

				// TEST DISALLOWED FILE TYPE (TXT)

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.txt", LOCAL_PATH."/templates/tests/file_upload/test-running.txt");
				$_FILES["v_file"] = [
					"type" => ["text/plain"],
					"name" => ["Test-file.txt"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.txt"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if(!$uploads &&

					!file_exists("templates/tests/file_upload/test-running.txt") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					// Original upload still exists
					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/jpg") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (disallowed, single txt) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (disallowed, single txt) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (multiple on single file input)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);


				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "png,jpg");

				// TEST FILE COUNT (MULTIPLE UPLOAD ON SINGLE FILE INPUT)

				// Create test item
				$_POST["name"] = "Test upload, multiple on single file input";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
				$_FILES["v_file"] = [
					"type" => ["image/png", "image/jpeg"],
					"name" => ["Test file png", "Test file jpg"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg"],
					"error" => ["", ""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file", "auto_add_variant" => true]);

				// Test
				if(!$uploads &&
					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&
					!file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"])
				): ?>
					<div class="testpassed">Itemtype->upload (multiple on single file input) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (multiple on single file input) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed, single mp4)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);



				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "*");


				// TESTING FILE TYPES (MP4)

				// Create test item
				$_POST["name"] = "Test upload, mp4";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.mp4", LOCAL_PATH."/templates/tests/file_upload/test-running.mp4");
				$_FILES["v_file"] = [
					"type" => ["video/mp4"],
					"name" => ["Test-file.mp4"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.mp4"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					$uploads[0]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads[0]["format"] === "mp4" &&
					$uploads[0]["width"] === 512 &&
					$uploads[0]["height"] === 288 &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.mp4") &&
					$uploads[0]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.mp4") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/mp4") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed, single mp4) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed, single mp4) - error</div>
				<? endif;


				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed, single mov)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);


				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "*");


				// TESTING FILE TYPES (MOV)

				// Create test item
				$_POST["name"] = "Test upload, mov";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.mov", LOCAL_PATH."/templates/tests/file_upload/test-running.mov");
				$_FILES["v_file"] = [
					"type" => ["video/quicktime"],
					"name" => ["Test-file.mov"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.mov"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					$uploads[0]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads[0]["format"] === "mov" &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.mov") &&
					$uploads[0]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.mov") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/mov") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed, single mov) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed, single mov) - error</div>
				<? endif;


				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed, single mp3)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "*");

				// TESTING FILE TYPES (MP3)

				// Create test item
				$_POST["name"] = "Test upload, mp3";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.mp3", LOCAL_PATH."/templates/tests/file_upload/test-running.mp3");
				$_FILES["v_file"] = [
					"type" => ["audio/mpeg"],
					"name" => ["Test-file.mp3"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.mp3"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					$uploads[0]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads[0]["format"] === "mp3" &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.mp3") &&
					$uploads[0]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.mp3") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/mp3") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed, single mp3) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed, single mp3) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed, single pdf)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "*");

				// TESTING FILE TYPES (PDF)

				// Create test item
				$_POST["name"] = "Test upload, pdf";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.pdf", LOCAL_PATH."/templates/tests/file_upload/test-running.pdf");
				$_FILES["v_file"] = [
					"type" => ["application/pdf"],
					"name" => ["Test-file.pdf"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.pdf"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					$uploads[0]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads[0]["format"] === "pdf" &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.pdf") &&
					$uploads[0]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.pdf") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/pdf") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed, single pdf) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed, single pdf) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed, single zip)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "*");

				// TESTING FILE TYPES (ZIP)

				// Create test item
				$_POST["name"] = "Test upload, zip";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.zip", LOCAL_PATH."/templates/tests/file_upload/test-running.zip");
				$_FILES["v_file"] = [
					"type" => ["application/zip"],
					"name" => ["Test-file.zip"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.zip"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					$uploads[0]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads[0]["format"] === "zip" &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.zip") &&
					$uploads[0]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.zip") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/zip") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed, single zip) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed, single zip) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed, single txt)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "*");

				// TESTING "AUTO-ZIP" FILE TYPES (TXT)

				// Create test item
				$_POST["name"] = "Test upload, txt";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.txt", LOCAL_PATH."/templates/tests/file_upload/test-running.txt");
				$_FILES["v_file"] = [
					"type" => ["text/plain"],
					"name" => ["Test-file.txt"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.txt"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					$uploads[0]["name"] === ($_FILES["v_file"]["name"][0].".zip") &&
					$uploads[0]["format"] === "zip" &&
					$uploads[0]["variant"] === "v_file" &&

					// Zipped size should be larger (due to ZIP overhead on small files)
					$uploads[0]["filesize"] > filesize(LOCAL_PATH."/templates/tests/file_upload/test.txt") &&

					!file_exists("templates/tests/file_upload/test-running.txt") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/zip") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed, single txt) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed, single txt) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed, single ogg)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "*");

				// TESTING "AUTO-ZIP" FILE TYPES (OGG)

				// Create test item
				$_POST["name"] = "Test upload, ogg";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.ogg", LOCAL_PATH."/templates/tests/file_upload/test-running.ogg");
				$_FILES["v_file"] = [
					"type" => ["audio/ogg"],
					"name" => ["Test-file.ogg"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.ogg"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					$uploads[0]["name"] === ($_FILES["v_file"]["name"][0].".zip") &&
					$uploads[0]["format"] === "zip" &&
					$uploads[0]["variant"] === "v_file" &&

					// Zipped size should be smaller
					$uploads[0]["filesize"] < filesize(LOCAL_PATH."/templates/tests/file_upload/test.ogg") &&

					!file_exists("templates/tests/file_upload/test-running.ogg") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/zip") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed, single ogg) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed, single ogg) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed, single docx)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "*");

				// TESTING "AUTO-ZIP" FILE TYPES (DOCX)

				// Create test item
				$_POST["name"] = "Test upload, docx";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.docx", LOCAL_PATH."/templates/tests/file_upload/test-running.docx");
				$_FILES["v_file"] = [
					"type" => ["application/vnd.openxmlformats-officedocument.wordprocessingml.document"],
					"name" => ["Test-file.docx"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.docx"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					$uploads[0]["name"] === ($_FILES["v_file"]["name"][0].".zip") &&
					$uploads[0]["format"] === "zip" &&
					$uploads[0]["variant"] === "v_file" &&

					// Zipped size should be smaller
					$uploads[0]["filesize"] < filesize(LOCAL_PATH."/templates/tests/file_upload/test.docx") &&

					!file_exists("templates/tests/file_upload/test-running.docx") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/zip") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed, single docx) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed, single docx) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed, single odt)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "*");

				// TESTING "AUTO-ZIP" FILE TYPES (ODT)

				// Create test item
				$_POST["name"] = "Test upload, odt";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.odt", LOCAL_PATH."/templates/tests/file_upload/test-running.odt");
				$_FILES["v_file"] = [
					"type" => ["application/vnd.openxmlformats-officedocument.wordprocessingml.document"],
					"name" => ["Test-file.odt"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.odt"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					$uploads[0]["name"] === ($_FILES["v_file"]["name"][0].".zip") &&
					$uploads[0]["format"] === "zip" &&
					$uploads[0]["variant"] === "v_file" &&

					// Zipped size should be smaller
					$uploads[0]["filesize"] < filesize(LOCAL_PATH."/templates/tests/file_upload/test.odt") &&

					!file_exists("templates/tests/file_upload/test-running.odt") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/zip") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed, single odt) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed, single odt) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed, single graffle)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// allow all formats for additional tests
				$tests_model->setProperty("v_file", "allowed_formats", "*");

				// TESTING "AUTO-ZIP" FILE TYPES (GRAFFLE)

				// Create test item
				$_POST["name"] = "Test upload, graffle";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.graffle", LOCAL_PATH."/templates/tests/file_upload/test-running.graffle");
				$_FILES["v_file"] = [
					"type" => ["application/octet-stream"],
					"name" => ["Test-file.graffle"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.graffle"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					$uploads[0]["name"] === ($_FILES["v_file"]["name"][0].".zip") &&
					$uploads[0]["format"] === "zip" &&
					$uploads[0]["variant"] === "v_file" &&

					// Zipped file size is uncertain
					// $uploads[0]["filesize"] < filesize(LOCAL_PATH."/templates/tests/file_upload/test.graffle") &&

					!file_exists("templates/tests/file_upload/test-running.graffle") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/zip") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed, single graffle) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed, single graffle) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (png + jpg)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// allow all formats for additional tests
				$tests_model->setProperty("v_files", "allowed_formats", "jpg,png");
				$tests_model->setProperty("v_files", "min", 2);

				// TESTING MULTIPLE FILES (PNG + JPG)

				// Create test item
				$_POST["name"] = "Test upload, multiple files";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
				$_FILES["v_files"] = [
					"type" => ["image/png", "image/jpeg"],
					"name" => ["Test file png", "Test file jpg"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg"],
					"error" => ["", ""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_files", "auto_add_variant" => true]);


				// Test
				if($uploads &&
					count($uploads) === 2 &&
					$uploads[0]["name"] === $_FILES["v_files"]["name"][0] &&
					$uploads[0]["format"] === "png" &&
					$uploads[0]["width"] === 512 &&
					$uploads[0]["height"] === 288 &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.png") &&
					$uploads[0]["variant"] &&

					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/".$uploads[0]["variant"]."/png") &&

					$uploads[1]["name"] === $_FILES["v_files"]["name"][1] &&
					$uploads[1]["format"] === "jpg" &&
					$uploads[1]["width"] === 512 &&
					$uploads[1]["height"] === 288 &&
					$uploads[1]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.jpg") &&
					preg_match("/v_files\-/", $uploads[1]["variant"]) &&

					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/".$uploads[1]["variant"]."/jpg") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 2
				): ?>
					<div class="testpassed">Itemtype->upload (png + jpg) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (png + jpg) - error</div>
				<? endif;


				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (disallowed size png)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// TESTING ALLOWED SIZES
				// TEST WRONG SIZE (PNG)

				$tests_model->setProperty("v_file", "allowed_sizes", "100x100");

				// Create test item
				$_POST["name"] = "Test upload, disallowed sizes";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test-file.png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if(!$uploads &&
					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&
					!file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"]) &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 0
				): ?>
					<div class="testpassed">Itemtype->upload (disallowed size png) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (disallowed size png) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed size png)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// TEST ALLOWED SIZE (PNG)

				$tests_model->setProperty("v_file", "allowed_sizes", "512x288");

				// Create test item
				$_POST["name"] = "Test upload, allowed sizes";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test-file.png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					count($uploads) === 1 &&
					$uploads[0]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads[0]["format"] === "png" &&
					$uploads[0]["width"] === 512 &&
					$uploads[0]["height"] === 288 &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.png") &&
					$uploads[0]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/png") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed size png) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed size png) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (disallowed proportion png)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// Allow all sizes again
				$tests_model->setProperty("v_file", "allowed_sizes", "");


				// TESTING ALLOWED PROPORTIONS
				// TEST WRONG PROPORTION (PNG)

				$tests_model->setProperty("v_file", "allowed_proportions", round(4/3, 4));

				// Create test item
				$_POST["name"] = "Test upload, disallowed proportions";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test-file.png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if(!$uploads &&
					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&
					!file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"]) &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 0
				): ?>
					<div class="testpassed">Itemtype->upload (disallowed proportion png) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (disallowed proportion png) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed proportion png)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// TEST ALLOWED PROPORTION (PNG)

				$tests_model->setProperty("v_file", "allowed_proportions", round(16/9, 4));

				// Create test item
				$_POST["name"] = "Test upload, allowed proportions";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test-file.png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					count($uploads) === 1 &&
					$uploads[0]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads[0]["format"] === "png" &&
					$uploads[0]["width"] === 512 &&
					$uploads[0]["height"] === 288 &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.png") &&
					$uploads[0]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/png") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed proportion png) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed proportion png) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (disallowed min-width png)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// TEST PROPORTIONS WITH MIN- AND MAX- WIDTH AND HEIGHT
				// TEST DISALLOWED WIDTH WITH PROPORTIONS

				$tests_model->setProperty("v_file", "allowed_proportions", round(16/9, 4));
				$tests_model->setProperty("v_file", "min_width", 700);

				// Create test item
				$_POST["name"] = "Test upload, allowed proportions with min-width";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test-file.png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if(!$uploads &&
					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&
					!file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"])
				): ?>
					<div class="testpassed">Itemtype->upload (disallowed min-width png) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (disallowed min-width png) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (disallowed min-height png)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);


				// TEST DISALLOWED HEIGHT WITH PROPORTIONS

				$tests_model->setProperty("v_file", "allowed_proportions", round(16/9, 4));
				$tests_model->setProperty("v_file", "min_width", "");
				$tests_model->setProperty("v_file", "min_height", 700);

				// Create test item
				$_POST["name"] = "Test upload, allowed proportions with min-height";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test-file.png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if(!$uploads &&
					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&
					!file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"])
				): ?>
					<div class="testpassed">Itemtype->upload (disallowed min-height png) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (disallowed min-height png) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "upload (allowed min-width and min-height png)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// TEST ALLOWED WIDTH AND HEIGHT

				$tests_model->setProperty("v_file", "allowed_proportions", round(16/9, 4));
				$tests_model->setProperty("v_file", "min_width", 512);
				$tests_model->setProperty("v_file", "min_height", 288);

				// Create test item
				$_POST["name"] = "Test upload, allowed proportions with min-width";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test-file.png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$uploads = $tests_model->upload($test_upload["id"], ["input_name" => "v_file"]);

				// Test
				if($uploads &&
					count($uploads) === 1 &&
					$uploads[0]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads[0]["format"] === "png" &&
					$uploads[0]["width"] === 512 &&
					$uploads[0]["height"] === 288 &&
					$uploads[0]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.png") &&
					$uploads[0]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/v_file/png") &&

					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->upload (allowed min-width and min-height png) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->upload (allowed min-width and min-height png) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		?>
	</div>

	<div class="tests addMedia">
		<h3>Itemtype->addMedia</h3>
		<?

		if(1 && "addMedia (png + jpg)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);


				// TESTING MULTIPLE VALID FILES (PNG + JPG)

				$tests_model->setProperty("v_files", "allowed_formats", "png,jpg");
				$tests_model->setProperty("v_files", "min", 2);

				// Create test item
				$_POST["name"] = "Test addMedia, multiple files";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				copy(LOCAL_PATH."/templates/tests/file_upload/test.jpg", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg");
				$_FILES["v_files"] = [
					"type" => ["image/png", "image/jpeg"],
					"name" => ["Test file png", "Test file jpg"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png", LOCAL_PATH."/templates/tests/file_upload/test-running.jpg"],
					"error" => ["", ""]
				];

				$uploads = $tests_model->addMedia(["addMedia", $test_upload["id"], "v_files"]);

				// Get reference items
				$reference_item = $IC->getItem(["id" => $test_upload["id"], "extend" => ["all" => true]]);

				list($variant1, $variant2) = array_keys($uploads["mediae"]);

				// Test
				if($uploads && isset($uploads["mediae"]) &&
					count($uploads["mediae"]) === 2 &&

					$uploads["mediae"][$variant1]["name"] === $_FILES["v_files"]["name"][0] &&
					$uploads["mediae"][$variant1]["format"] === "png" &&
					$uploads["mediae"][$variant1]["width"] === 512 &&
					$uploads["mediae"][$variant1]["height"] === 288 &&
					$uploads["mediae"][$variant1]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.png") &&
					preg_match("/v_files\-/", $uploads["mediae"][$variant1]["variant"]) &&

					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/".$uploads["mediae"][$variant1]["variant"]."/png") &&

					$uploads["mediae"][$variant2]["name"] === $_FILES["v_files"]["name"][1] &&
					$uploads["mediae"][$variant2]["format"] === "jpg" &&
					$uploads["mediae"][$variant2]["width"] === 512 &&
					$uploads["mediae"][$variant2]["height"] === 288 &&
					$uploads["mediae"][$variant2]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.jpg") &&
					preg_match("/v_files\-/", $uploads["mediae"][$variant2]["variant"]) &&

					!file_exists("templates/tests/file_upload/test-running.jpg") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/".$uploads["mediae"][$variant2]["variant"]."/jpg") &&


					$reference_item["mediae"][$variant1]["name"] === $_FILES["v_files"]["name"][0] &&
					$reference_item["mediae"][$variant1]["format"] === "png" &&
					$reference_item["mediae"][$variant1]["width"] == 512 &&
					$reference_item["mediae"][$variant1]["height"] == 288 &&


					$reference_item["mediae"][$variant2]["name"] === $_FILES["v_files"]["name"][1] &&
					$reference_item["mediae"][$variant2]["format"] === "jpg" &&
					$reference_item["mediae"][$variant2]["width"] == 512 &&
					$reference_item["mediae"][$variant2]["height"] == 288 &&


					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 2
				): ?>
					<div class="testpassed">Itemtype->addMedia (png + jpg) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->addMedia (png + jpg) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "addMedia (png + disallowed txt)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				$tests_model->setProperty("v_files", "min", 1);

				// TESTING MULTIPLE FILES – ONE DISALLOWED (PNG + TXT)

				$tests_model->setProperty("v_files", "allowed_formats", "png");

				// Create test item
				$_POST["name"] = "Test addMedia, multiple files, disallowed txt";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				copy(LOCAL_PATH."/templates/tests/file_upload/test.txt", LOCAL_PATH."/templates/tests/file_upload/test-running.txt");
				$_FILES["v_files"] = [
					"type" => ["image/png", "text/plain"],
					"name" => ["Test file png", "Test file txt"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png", LOCAL_PATH."/templates/tests/file_upload/test-running.txt"],
					"error" => ["", ""]
				];

				$uploads["mediae"] = $tests_model->addMedia(["addMedia", $test_upload["id"], "v_files"]);

				// Get reference items
				$reference_item = $IC->getItem(["id" => $test_upload["id"], "extend" => ["all" => true]]);

				// Test
				if(!$uploads["mediae"] &&
					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists("templates/tests/file_upload/test-running.txt") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&
					!file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"]) &&

					!$reference_item["mediae"]
				): ?>
					<div class="testpassed">Itemtype->addMedia (png + disallowed txt) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->addMedia (png + disallowed txt) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		?>
	</div>

	<div class="tests addSingleMedia">
		<h3>Itemtype->addSingleMedia</h3>
		<?

		if(1 && "addSingleMedia (png)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");
				$fs = new FileSystem();

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// TESTING VALID FILE (PNG)

				$tests_model->setProperty("v_file", "allowed_formats", "png");

				// Create test item
				$_POST["name"] = "Test addSingleMedia, png";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.png", LOCAL_PATH."/templates/tests/file_upload/test-running.png");
				$_FILES["v_file"] = [
					"type" => ["image/png"],
					"name" => ["Test file png"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.png"],
					"error" => [""]
				];

				$uploads = $tests_model->addSingleMedia(["addSingleMedia", $test_upload["id"], "v_file"]);

				// Get reference items
				$reference_item = $IC->getItem(["id" => $test_upload["id"], "extend" => ["all" => true]]);

				// Test
				if($uploads && isset($uploads["mediae"]) &&
					count($uploads["mediae"]) === 1 &&

					$uploads["mediae"]["v_file"]["name"] === $_FILES["v_file"]["name"][0] &&
					$uploads["mediae"]["v_file"]["format"] === "png" &&
					$uploads["mediae"]["v_file"]["width"] === 512 &&
					$uploads["mediae"]["v_file"]["height"] === 288 &&
					$uploads["mediae"]["v_file"]["filesize"] === filesize(LOCAL_PATH."/templates/tests/file_upload/test.png") &&
					$uploads["mediae"]["v_file"]["variant"] === "v_file" &&

					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&

					file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"] . "/".$uploads["mediae"]["v_file"]["variant"]."/png") &&


					$reference_item["mediae"]["v_file"]["name"] === $_FILES["v_file"]["name"][0] &&
					$reference_item["mediae"]["v_file"]["format"] === "png" &&
					$reference_item["mediae"]["v_file"]["width"] == 512 &&
					$reference_item["mediae"]["v_file"]["height"] == 288 &&


					count($fs->files(PRIVATE_FILE_PATH . "/" . $test_upload["id"])) === 1
				): ?>
					<div class="testpassed">Itemtype->addSingleMedia (png) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->addSingleMedia (png) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		if(1 && "addSingleMedia (disallowed txt)") {

			(function() {

				$IC = new Items();
				$tests_model = $IC->typeObject("tests");

				message()->resetMessages();
				unset($_POST);
				unset($_GET);
				unset($_FILES);

				// TESTING MULTIPLE FILES – ONE DISALLOWED (PNG + TXT)

				$tests_model->setProperty("v_file", "allowed_formats", "png");

				// Create test item
				$_POST["name"] = "Test addSingleMedia, disallowed txt";
				$test_upload = $tests_model->save(array("save"));

				// Copy test files
				copy(LOCAL_PATH."/templates/tests/file_upload/test.txt", LOCAL_PATH."/templates/tests/file_upload/test-running.txt");
				$_FILES["v_files"] = [
					"type" => ["text/plain"],
					"name" => ["Test file txt"],
					"tmp_name" => [LOCAL_PATH."/templates/tests/file_upload/test-running.txt"],
					"error" => [""]
				];

				$uploads = $tests_model->addSingleMedia(["addMedia", $test_upload["id"], "v_file"]);

				// Get reference items
				$reference_item = $IC->getItem(["id" => $test_upload["id"], "extend" => ["all" => true]]);

				// Test
				if(!$uploads &&
					!file_exists("templates/tests/file_upload/test-running.png") &&
					!file_exists("templates/tests/file_upload/test-running.txt") &&
					!file_exists(PUBLIC_FILE_PATH . "/" . $test_upload["id"]) &&
					!file_exists(PRIVATE_FILE_PATH . "/" . $test_upload["id"]) &&

					!$reference_item["mediae"]
				): ?>
					<div class="testpassed">Itemtype->addSingleMedia (disallowed txt) - correct</div>
				<? else: ?>
					<div class="testfailed">Itemtype->addSingleMedia (disallowed txt) - error</div>
				<? endif;

				// Clear datasets
				manualCleanUp($test_upload["id"]);

			})();

		}

		?>
	</div>

	<? /*

	<div class="tests deleteMedia">
		<h3>Itemtype->deleteMedia</h3>
		<?

		message()->resetMessages();
		unset($_POST);
		unset($_GET);
		unset($_FILES);

		?>
	</div>

	<div class="tests updateMediaName">
		<h3>Itemtype->updateMediaName</h3>
		<?

		message()->resetMessages();
		unset($_POST);
		unset($_GET);
		unset($_FILES);

		?>
	</div>

	<div class="tests updateMediaOrder">
		<h3>Itemtype->updateMediaOrder</h3>
		<?

		message()->resetMessages();
		unset($_POST);
		unset($_GET);
		unset($_FILES);

		?>
	</div>

	<div class="tests addHTMLMedia">
		<h3>Itemtype->addHTMLMedia</h3>
		<?

		message()->resetMessages();
		unset($_POST);
		unset($_GET);
		unset($_FILES);

		?>
	</div>

	<div class="tests deleteHTMLMedia">
		<h3>Itemtype->deleteHTMLMedia</h3>
		<?

		message()->resetMessages();
		unset($_POST);
		unset($_GET);
		unset($_FILES);

		?>
	</div>

	<div class="tests addHTMLFile">
		<h3>Itemtype->addHTMLFile</h3>
		<?

		message()->resetMessages();
		unset($_POST);
		unset($_GET);
		unset($_FILES);

		?>
	</div>

	<div class="tests deleteHTMLFile">
		<h3>Itemtype->deleteHTMLFile</h3>
		<?

		message()->resetMessages();
		unset($_POST);
		unset($_GET);
		unset($_FILES);

		?>
	</div>

	<div class="tests addRating">
		<h3>Itemtype->addRating</h3>
		<?

		message()->resetMessages();
		unset($_POST);
		unset($_GET);
		unset($_FILES);



		$_POST["name"] = "Test item 1 - I should be first";
		$item_1 = $tests_model->save(array("save"));

		unset($_POST);
		$_POST["item_rating"] = 5;
		$tests_model->addRating(array("addRating", $item_1["id"]));
		$_POST["item_rating"] = 7;
		$tests_model->addRating(array("addRating", $item_1["id"]));
		$_POST["item_rating"] = 4;
		$tests_model->addRating(array("addRating", $item_1["id"]));
		$_POST["item_rating"] = 2;
		$tests_model->addRating(array("addRating", $item_1["id"]));
		$_POST["item_rating"] = 9;
		$tests_model->addRating(array("addRating", $item_1["id"]));

		// Get reference item
		$reference_item_1 = $IC->getItem(["id" => $item_1["id"], "extend" => ["ratings" => true]]);

		// Test
		if($reference_item_1 &&
			$reference_item_1["ratings"] &&
			$reference_item_1["ratings"]["lowest"] === 2 &&
			$reference_item_1["ratings"]["highest"] === 9 &&
			$reference_item_1["ratings"]["average"] === 5.4
		): ?>
		<div class="testpassed">Itemtype->addRating - correct</div>
		<? else: ?>
		<div class="testfailed">Itemtype-> - error</div>
		<? endif;



		// Clear Datasets
		manualCleanUp($item_1["id"]);

		message()->resetMessages();
		unset($_POST);
		unset($_GET);
		unset($_FILES);
		?>

	</div>
	*/ ?>


</div>