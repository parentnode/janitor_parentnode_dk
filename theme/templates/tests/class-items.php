<?

$IC = new Items();
$query = new Query();
$post_model = $IC->typeObject("post");
?>

<div class="scene i:scene tests">
	<h1>ItemsClass</h1>	
	<h2>Item querying of all sorts2</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<div class="tests getItems">
		<h3>Items->getItems</h3>

		<? 

		if(1 && "getItems by itemtype") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				$test_item_1_id = $model_tests->createTestItem();

				// Get items by tags
				$items_1 = $IC->getItems(array("itemtype" => "tests"));

				$test_item_2_id = $model_tests->createTestItem();

				$items_2 = $IC->getItems(array("itemtype" => "tests"));


				$items_1_index_1 = arrayKeyValue($items_1, "id", $test_item_1_id);
				$items_1_index_2 = arrayKeyValue($items_1, "id", $test_item_2_id);

				$items_2_index_1 = arrayKeyValue($items_2, "id", $test_item_1_id);
				$items_2_index_2 = arrayKeyValue($items_2, "id", $test_item_2_id);


				// debug([$items_1]);
				if(
					$items_1 &&
					count($items_1) === 1 &&
						
					$items_1_index_1 !== false &&
					$items_1_index_2 === false &&

					$items_2 &&
					count($items_2) === 2 &&

					$items_2_index_1 !== false &&
					$items_2_index_2 !== false

				): ?>
				<div class="testpassed"><p>Items::getItems by itemtype - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getItems by itemtype - error</p></div>
				<? endif; 


				$model_tests->cleanup(["itemtype" => "tests"]);
				message()->resetMessages();

			})();

		}

		if(1 && "getItems by rating") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

	
				$test_item_1 = $model_tests->createTestItem(["name" => "Test item 1 - I should be third"]);

				unset($_POST);
				$_POST["item_rating"] = 5;
				$model_tests->addRating(array("addRating", $test_item_1));
				$model_tests->addRating(array("addRating", $test_item_1));
				$model_tests->addRating(array("addRating", $test_item_1));
				$model_tests->addRating(array("addRating", $test_item_1));
				$model_tests->addRating(array("addRating", $test_item_1));
				unset($_POST);



				$test_item_2 = $model_tests->createTestItem(["name" => "Test item 2 - I should be fourth"]);

				unset($_POST);
				$_POST["item_rating"] = 2;
				$model_tests->addRating(array("addRating", $test_item_2));
				unset($_POST);



				$test_item_3 = $model_tests->createTestItem(["name" => "Test item 3 - I should be first"]);

				unset($_POST);
				$_POST["item_rating"] = 9;
				$model_tests->addRating(array("addRating", $test_item_3));
				$_POST["item_rating"] = 7;
				$model_tests->addRating(array("addRating", $test_item_3));
				unset($_POST);



				$test_item_4 = $model_tests->createTestItem(["name" => "Test item 4 - I should be second"]);

				unset($_POST);
				$_POST["item_rating"] = 8;
				$model_tests->addRating(array("addRating", $test_item_4));
				$_POST["item_rating"] = 11;
				$model_tests->addRating(array("addRating", $test_item_4));
				$_POST["item_rating"] = 1;
				$model_tests->addRating(array("addRating", $test_item_4));
				$_POST["item_rating"] = 6;
				$model_tests->addRating(array("addRating", $test_item_4));
				$_POST["item_rating"] = 6;
				unset($_POST);


				// Get items by rating
				$items = $IC->getItems(array("itemtype" => "tests", "order" => "rating DESC", "limit" => 4, "extend" => ["ratings" => true]));

				// debug([$items]);
				if($items && count($items) === 4 &&
					preg_match("/first/", $items[0]["name"]) &&
					preg_match("/second/", $items[1]["name"]) &&
					preg_match("/third/", $items[2]["name"]) &&
					preg_match("/fourth/", $items[3]["name"])
				): ?>
				<div class="testpassed"><p>Items::getItems ordered by ratings - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getItems ordered by ratings - error</p></div>
				<? endif; 


				$model_tests->cleanup(["itemtype" => "tests"]);
				message()->resetMessages();

			})();

		}

		if(1 && "getItems by editor") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_1_id = $model_tests->createTestItem();
				$test_user_1_id = $model_tests->createTestUser();
				
				unset($_POST);
				$_POST["item_editor"] = $test_user_1_id;
				$model_tests->addEditor(array("addEditor", $test_item_1_id));
				unset($_POST);
				
				
				$test_item_2_id = $model_tests->createTestItem();
				$test_user_2_id = $model_tests->createTestUser();

				unset($_POST);
				$_POST["item_editor"] = $test_user_2_id;
				$model_tests->addEditor(array("addEditor", $test_item_2_id));
				unset($_POST);


				// Get items by rating
				$items = $IC->getItems(array("itemtype" => "tests", "editor_id" => $test_user_1_id, "extend" => ["editors" => true]));

				// debug([$items]);
				if($items 
					&& count($items) === 1
					&& $items[0]["editors"]
					&& $items[0]["editors"][0]["user_id"] == $test_user_1_id
				): ?>
				<div class="testpassed"><p>Items::getItems by editors - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getItems by editors - error</p></div>
				<? endif; 


				$model_tests->cleanup(["itemtype" => "tests"]);
				message()->resetMessages();

			})();

		}

		if(1 && "getItems by tags") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_1_id = $model_tests->createTestItem();
				
				unset($_POST);
				$_POST["tags"] = "test:tag1";
				$model_tests->addTag(array("addTag", $test_item_1_id));
				unset($_POST);

				unset($_POST);
				$_POST["tags"] = "test:tag2";
				$model_tests->addTag(array("addTag", $test_item_1_id));
				unset($_POST);

				$test_item_2_id = $model_tests->createTestItem();

				unset($_POST);
				$_POST["tags"] = "test:tag1";
				$model_tests->addTag(array("addTag", $test_item_2_id));
				unset($_POST);


				// Get items by tags
				$items_1 = $IC->getItems(array("tags" => "test:tag1"));

				$items_2 = $IC->getItems(array("tags" => "test:tag2"));

				$items_1_index_1 = arrayKeyValue($items_1, "id", $test_item_1_id);
				$items_1_index_2 = arrayKeyValue($items_1, "id", $test_item_2_id);

				$items_2_index_1 = arrayKeyValue($items_2, "id", $test_item_1_id);
				$items_2_index_2 = arrayKeyValue($items_2, "id", $test_item_2_id);


				// debug([$items_1]);
				if(
					$items_1 &&
					count($items_1) === 2 &&
						
					$items_1_index_1 !== false &&
					$items_1_index_2 !== false &&

					$items_2 &&
					count($items_2) === 1 &&

					$items_2_index_1 !== false &&
					$items_2_index_2 === false

				): ?>
				<div class="testpassed"><p>Items::getItems by tags - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getItems by tags - error</p></div>
				<? endif; 


				$model_tests->cleanup(["itemtype" => "tests"]);
				message()->resetMessages();

			})();

		}

		?>

	</div>

	<div class="tests search">
		<h3>Items->search</h3>

		<? 

		if(1 && "search by tags") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$test_item_1_id = $model_tests->createTestItem();
				
				unset($_POST);
				$_POST["tags"] = "test:tag1";
				$model_tests->addTag(array("addTag", $test_item_1_id));
				unset($_POST);

				unset($_POST);
				$_POST["tags"] = "test:tag2";
				$model_tests->addTag(array("addTag", $test_item_1_id));
				unset($_POST);

				$test_item_2_id = $model_tests->createTestItem();

				unset($_POST);
				$_POST["tags"] = "test:tag1";
				$model_tests->addTag(array("addTag", $test_item_2_id));
				unset($_POST);


				// Get items by tags
				$items_1 = $IC->search(array("tags" => "test:tag1"));

				$items_2 = $IC->search(array("tags" => "test:tag2"));

				$items_1_index_1 = arrayKeyValue($items_1, "id", $test_item_1_id);
				$items_1_index_2 = arrayKeyValue($items_1, "id", $test_item_2_id);

				$items_2_index_1 = arrayKeyValue($items_2, "id", $test_item_1_id);
				$items_2_index_2 = arrayKeyValue($items_2, "id", $test_item_2_id);


				// debug([$items_1]);
				if(
					$items_1 &&
					count($items_1) === 2 &&
						
					$items_1_index_1 !== false &&
					$items_1_index_2 !== false &&

					$items_2 &&
					count($items_2) === 1 &&

					$items_2_index_1 !== false &&
					$items_2_index_2 === false

				): ?>
				<div class="testpassed"><p>Items::search by tags - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::search by tags - error</p></div>
				<? endif; 


				$model_tests->cleanup(["itemtype" => "tests"]);
				message()->resetMessages();

			})();

		}

		if(1 && "search by query") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$key = randomKey(4);
				$test_item_1_id = $model_tests->createTestItem(["name" => "test item 1 - $key"]);

				$test_item_2_id = $model_tests->createTestItem(["name" => "test item 2 - $key"]);


				// Get items by tags
				$items_1 = $IC->search(["query" => $key]);

				$items_1_index_1 = arrayKeyValue($items_1, "id", $test_item_1_id);
				$items_1_index_2 = arrayKeyValue($items_1, "id", $test_item_2_id);


				// debug([$items_1]);
				if(
					$items_1 &&
					count($items_1) === 2 &&
						
					$items_1_index_1 !== false &&
					$items_1_index_2 !== false

				): ?>
				<div class="testpassed"><p>Items::search by query - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::search by query - error</p></div>
				<? endif; 


				// $model_tests->cleanup(["itemtype" => "tests"]);
				message()->resetMessages();

			})();

		}

		if(1 && "search by tags and query") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				$key_1 = randomKey(4);
				$key_2 = randomKey(4);
				$test_item_1_id = $model_tests->createTestItem(["name" => "test item 1 - $key_1"]);

				
				unset($_POST);
				$_POST["tags"] = "test:tag1";
				$model_tests->addTag(array("addTag", $test_item_1_id));
				unset($_POST);

				unset($_POST);
				$_POST["tags"] = "test:tag2";
				$model_tests->addTag(array("addTag", $test_item_1_id));
				unset($_POST);

				$test_item_2_id = $model_tests->createTestItem(["name" => "test item 2 - $key_1 – $key_2"]);

				unset($_POST);
				$_POST["tags"] = "test:tag1";
				$model_tests->addTag(array("addTag", $test_item_2_id));
				unset($_POST);


				// Get items by tags
				$items_1 = $IC->search(array("tags" => "test:tag1", "query" => $key_1));

				$items_2 = $IC->search(array("tags" => "test:tag2", "query" => $key_1));

				$items_3 = $IC->search(array("tags" => "test:tag1", "query" => $key_2));


				$items_1_index_1 = arrayKeyValue($items_1, "id", $test_item_1_id);
				$items_1_index_2 = arrayKeyValue($items_1, "id", $test_item_2_id);

				$items_2_index_1 = arrayKeyValue($items_2, "id", $test_item_1_id);
				$items_2_index_2 = arrayKeyValue($items_2, "id", $test_item_2_id);

				$items_3_index_1 = arrayKeyValue($items_3, "id", $test_item_1_id);
				$items_3_index_2 = arrayKeyValue($items_3, "id", $test_item_2_id);


				// debug([$items_1]);
				if(
					$items_1 &&
					count($items_1) === 2 &&
						
					$items_1_index_1 !== false &&
					$items_1_index_2 !== false &&

					$items_2 &&
					count($items_2) === 1 &&

					$items_2_index_1 !== false &&
					$items_2_index_2 === false &&

					$items_3 &&
					count($items_3) === 1 &&

					$items_3_index_1 === false &&
					$items_3_index_2 !== false

				): ?>
				<div class="testpassed"><p>Items::search by tags and query - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::search by tags and query - error</p></div>
				<? endif; 


				$model_tests->cleanup(["itemtype" => "tests"]);
				message()->resetMessages();

			})();

		}

		?>

	</div>

	<div class="tests getNext">
		<h3>Items->getNext</h3>

		<? 

		if(1 && "getNext – invalid item_id") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				// Create 5 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 5; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(5 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}

				// Test invalid item_id
				$test_items = $IC->getNext(0, [
					"limit" => 3,
					"itemtype" => "tests",
					"order" => "sindex ASC"
				]);


				if(
					!$test_items
				): ?>
				<div class="testpassed"><p>Items::getNext – invalid item_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getNext – invalid item_id – error</p></div>
				<? endif;


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		} 

		if(1 && "getNext – valid item_id") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}

				$item = $IC->getItem(["sindex" => "item-0015-0005"]);

				// Test ASC sorting
				$test_items = $IC->getNext($item["id"], [
					"limit" => 3,
					"itemtype" => "tests",
					"order" => "sindex ASC"
				]);


				if(
					$test_items &&
					$test_items &&
					count($test_items) === 3 &&

					$test_items[0]["sindex"] === "item-0016-0004" &&
					$test_items[1]["sindex"] === "item-0017-0003" &&
					$test_items[2]["sindex"] === "item-0018-0002" &&

					// Name should not exists
					!isset($test_items[0]["name"]) &&
					!isset($test_items[1]["name"]) &&
					!isset($test_items[2]["name"]) &&

					$test_items[0]["itemtype"] === "tests" &&
					$test_items[1]["itemtype"] === "tests" &&
					$test_items[2]["itemtype"] === "tests"

				): ?>
				<div class="testpassed"><p>Items::getNext – valid item_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getNext – valid item_id – error</p></div>
				<? endif;


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		} 

		if(1 && "getNext – valid item_id – extended") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}

				$item = $IC->getItem(["sindex" => "item-0015-0005"]);

				// Test ASC sorting
				$test_items = $IC->getNext($item["id"], [
					"limit" => 3,
					"itemtype" => "tests",
					"order" => "sindex ASC",
					"extend" => true
				]);


				if(
					$test_items &&
					$test_items &&
					count($test_items) === 3 &&

					$test_items[0]["sindex"] === "item-0016-0004" &&
					$test_items[1]["sindex"] === "item-0017-0003" &&
					$test_items[2]["sindex"] === "item-0018-0002" &&
					$test_items[0]["name"] === "Item 0016 - 0004" &&
					$test_items[1]["name"] === "Item 0017 - 0003" &&
					$test_items[2]["name"] === "Item 0018 - 0002" &&

					$test_items[0]["itemtype"] === "tests" &&
					$test_items[1]["itemtype"] === "tests" &&
					$test_items[2]["itemtype"] === "tests"

				): ?>
				<div class="testpassed"><p>Items::getNext – valid item_id – extended – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getNext – valid item_id – extended – error</p></div>
				<? endif;


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		}

		?>

	</div>

	<div class="tests getPrev">
		<h3>Items->getPrev</h3>

		<? 

		if(1 && "getPrev – invalid item_id") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");

				// Create 5 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 5; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(5 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}

				// Test invalid item_id
				$test_items = $IC->getPrev(0, [
					"limit" => 3,
					"itemtype" => "tests",
					"order" => "sindex ASC"
				]);


				if(
					!$test_items
				): ?>
				<div class="testpassed"><p>Items::getPrev – invalid item_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getPrev – invalid item_id – error</p></div>
				<? endif;


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		} 

		if(1 && "getPrev – valid item_id") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}

				$item = $IC->getItem(["sindex" => "item-0015-0005"]);

				// Test ASC sorting
				$test_items = $IC->getPrev($item["id"], [
					"limit" => 3,
					"itemtype" => "tests",
					"order" => "sindex ASC"
				]);


				if(
					$test_items &&
					$test_items &&
					count($test_items) === 3 &&

					$test_items[0]["sindex"] === "item-0012-0008" &&
					$test_items[1]["sindex"] === "item-0013-0007" &&
					$test_items[2]["sindex"] === "item-0014-0006" &&
					// Name should not exists
					!isset($test_items[0]["name"]) &&
					!isset($test_items[1]["name"]) &&
					!isset($test_items[2]["name"]) &&

					$test_items[0]["itemtype"] === "tests" &&
					$test_items[1]["itemtype"] === "tests" &&
					$test_items[2]["itemtype"] === "tests"

				): ?>
				<div class="testpassed"><p>Items::getPrev – valid item_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getPrev – valid item_id – error</p></div>
				<? endif;


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		} 

		if(1 && "getPrev – valid item_id – extended") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}

				$item = $IC->getItem(["sindex" => "item-0015-0005"]);

				// Test ASC sorting
				$test_items = $IC->getPrev($item["id"], [
					"limit" => 3,
					"itemtype" => "tests",
					"order" => "sindex ASC",
					"extend" => true
				]);


				if(
					$test_items &&
					$test_items &&
					count($test_items) === 3 &&

					$test_items[0]["sindex"] === "item-0012-0008" &&
					$test_items[1]["sindex"] === "item-0013-0007" &&
					$test_items[2]["sindex"] === "item-0014-0006" &&
					$test_items[0]["name"] === "Item 0012 - 0008" &&
					$test_items[1]["name"] === "Item 0013 - 0007" &&
					$test_items[2]["name"] === "Item 0014 - 0006" &&

					$test_items[0]["itemtype"] === "tests" &&
					$test_items[1]["itemtype"] === "tests" &&
					$test_items[2]["itemtype"] === "tests"

				): ?>
				<div class="testpassed"><p>Items::getPrev – valid item_id – extended – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getPrev – valid item_id – extended – error</p></div>
				<? endif;


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		}

		?>

	</div>

	<div class="tests paginate">
		<h3>Items->paginate</h3>

		<? 

		if(1 && "paginate – no start point, order ASC and DESC") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}

				// Test ASC sorting
				$test_items_1 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex ASC"
					]
				]);

				// Test DESC sorting
				$test_items_2 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex DESC"
					]
				]);


				// debug([$test_items_1, $test_items_2]);

				if(
					$test_items_1 &&
					$test_items_1["range_items"] &&
					count($test_items_1["range_items"]) === 3 &&

					$test_items_1["range_items"][0]["sindex"] === "item-0001-0019" &&
					$test_items_1["range_items"][1]["sindex"] === "item-0002-0018" &&
					$test_items_1["range_items"][2]["sindex"] === "item-0003-0017" &&

					// Name should not exists
					!isset($test_items_1["range_items"][0]["name"]) &&
					!isset($test_items_1["range_items"][1]["name"]) &&
					!isset($test_items_1["range_items"][2]["name"]) &&

					$test_items_1["range_items"][0]["itemtype"] === "tests" &&
					$test_items_1["range_items"][1]["itemtype"] === "tests" &&
					$test_items_1["range_items"][2]["itemtype"] === "tests" &&

					$test_items_1["next"] &&
					isset($test_items_1["next"]["sindex"]) &&
					$test_items_1["next"]["sindex"] === "item-0004-0016" &&

					// Name should not exists
					!isset($test_items_1["next"]["name"]) &&
					!$test_items_1["prev"] &&

					$test_items_1["first_id"] === $test_items_1["range_items"][0]["id"] &&
					$test_items_1["last_id"] === $test_items_1["range_items"][2]["id"] &&

					$test_items_1["first_sindex"] === $test_items_1["range_items"][0]["sindex"] &&
					$test_items_1["last_sindex"] === $test_items_1["range_items"][2]["sindex"] &&

					$test_items_1["total"] === 20 &&

					isset($test_items_1["current_page"]) &&
					$test_items_1["current_page"] === 1 &&

					isset($test_items_1["page_count"]) &&
					$test_items_1["page_count"] === 7 &&



					$test_items_2 &&
					$test_items_2["range_items"] &&
					count($test_items_2["range_items"]) === 3 &&

					$test_items_2["range_items"][0]["sindex"] === "item-0020-0000" &&
					$test_items_2["range_items"][1]["sindex"] === "item-0019-0001" &&
					$test_items_2["range_items"][2]["sindex"] === "item-0018-0002" &&

					// Name should not exists
					!isset($test_items_2["range_items"][0]["name"]) &&
					!isset($test_items_2["range_items"][1]["name"]) &&
					!isset($test_items_2["range_items"][2]["name"]) &&

					$test_items_2["range_items"][0]["itemtype"] === "tests" &&
					$test_items_2["range_items"][1]["itemtype"] === "tests" &&
					$test_items_2["range_items"][2]["itemtype"] === "tests" &&

					$test_items_2["next"] &&
					isset($test_items_2["next"]["sindex"]) &&
					$test_items_2["next"]["sindex"] === "item-0017-0003" &&

					// Name should not exists
					!isset($test_items_2["next"]["name"]) &&
					!$test_items_2["prev"] &&

					$test_items_2["first_id"] === $test_items_2["range_items"][0]["id"] &&
					$test_items_2["last_id"] === $test_items_2["range_items"][2]["id"] &&

					$test_items_2["first_sindex"] === $test_items_2["range_items"][0]["sindex"] &&
					$test_items_2["last_sindex"] === $test_items_2["range_items"][2]["sindex"] &&

					$test_items_2["total"] === 20 &&

					isset($test_items_2["current_page"]) &&
					$test_items_2["current_page"] === 1 &&

					isset($test_items_2["page_count"]) &&
					$test_items_2["page_count"] === 7

				): ?>
				<div class="testpassed"><p>Items::paginate – no start point order ASC and DESC – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::paginate – no start point order ASC and DESC – error</p></div>
				<? endif;


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		} 

		if(1 && "paginate – no start point, order ASC and DESC – extended") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}

				// Test ASC sorting
				$test_items = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex ASC",
						"extend" => true
					]
				]);


				// debug([$test_items]);

				if(
					$test_items &&
					$test_items["range_items"] &&
					count($test_items["range_items"]) === 3 &&

					$test_items["range_items"][0]["name"] === "Item 0001 - 0019" &&
					$test_items["range_items"][1]["name"] === "Item 0002 - 0018" &&
					$test_items["range_items"][2]["name"] === "Item 0003 - 0017" &&

					$test_items["next"] &&
					isset($test_items["next"]["name"]) &&
					$test_items["next"]["name"] === "Item 0004 - 0016"

				): ?>
				<div class="testpassed"><p>Items::paginate – no start point order ASC and DESC – extended – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::paginate – no start point order ASC and DESC – extended – error</p></div>
				<? endif;


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		}

		if(1 && "paginate - start with sindex, order ASC and DESC") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}


				$test_items_1 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex ASC"
					],
					"sindex" => "Item-0015-0005"
				]);

				$test_items_2 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex DESC"
					],
					"sindex" => "Item-0015-0005"
				]);


				// debug([$test_items_1, $test_items_2]);

				if(
					$test_items_1 &&
					$test_items_1["range_items"] &&
					count($test_items_1["range_items"]) === 3 &&

					$test_items_1["range_items"][0]["sindex"] === "item-0015-0005" &&
					$test_items_1["range_items"][1]["sindex"] === "item-0016-0004" &&
					$test_items_1["range_items"][2]["sindex"] === "item-0017-0003" &&
					// Name should not exists
					!isset($test_items_1["range_items"][0]["name"]) &&
					!isset($test_items_1["range_items"][1]["name"]) &&
					!isset($test_items_1["range_items"][2]["name"]) &&

					$test_items_1["range_items"][0]["itemtype"] === "tests" &&
					$test_items_1["range_items"][1]["itemtype"] === "tests" &&
					$test_items_1["range_items"][2]["itemtype"] === "tests" &&


					$test_items_1["next"] &&
					isset($test_items_1["next"]["sindex"]) &&
					$test_items_1["next"]["sindex"] === "item-0018-0002" &&
					// Name should not exists
					!isset($test_items_1["next"]["name"]) &&

					$test_items_1["prev"] &&
					isset($test_items_1["prev"]["sindex"]) &&
					$test_items_1["prev"]["sindex"] === "item-0014-0006" &&
					// Name should not exists
					!isset($test_items_1["prev"]["name"]) &&


					$test_items_1["first_id"] === $test_items_1["range_items"][0]["id"] &&
					$test_items_1["last_id"] === $test_items_1["range_items"][2]["id"] &&

					$test_items_1["first_sindex"] === $test_items_1["range_items"][0]["sindex"] &&
					$test_items_1["last_sindex"] === $test_items_1["range_items"][2]["sindex"] &&

					$test_items_1["total"] === 20 &&

					isset($test_items_1["current_page"]) &&
					$test_items_1["current_page"] === 5 &&

					isset($test_items_1["page_count"]) &&
					$test_items_1["page_count"] === 7 &&



					$test_items_2 &&
					$test_items_2["range_items"] &&
					count($test_items_2["range_items"]) === 3 &&

					$test_items_2["range_items"][0]["sindex"] === "item-0015-0005" &&
					$test_items_2["range_items"][1]["sindex"] === "item-0014-0006" &&
					$test_items_2["range_items"][2]["sindex"] === "item-0013-0007" &&
					// Name should not exists
					!isset($test_items_2["range_items"][0]["name"]) &&
					!isset($test_items_2["range_items"][1]["name"]) &&
					!isset($test_items_2["range_items"][2]["name"]) &&

					$test_items_2["range_items"][0]["itemtype"] === "tests" &&
					$test_items_2["range_items"][1]["itemtype"] === "tests" &&
					$test_items_2["range_items"][2]["itemtype"] === "tests" &&

					$test_items_2["next"] &&
					isset($test_items_2["next"]["sindex"]) &&
					$test_items_2["next"]["sindex"] === "item-0012-0008" &&
					// Name should not exists
					!isset($test_items_2["next"]["name"]) &&

					$test_items_2["prev"] &&
					isset($test_items_2["prev"]["sindex"]) &&
					$test_items_2["prev"]["sindex"] === "item-0016-0004" &&
					// Name should not exists
					!isset($test_items_2["prev"]["name"]) &&

					$test_items_2["first_id"] === $test_items_2["range_items"][0]["id"] &&
					$test_items_2["last_id"] === $test_items_2["range_items"][2]["id"] &&

					$test_items_2["first_sindex"] === $test_items_2["range_items"][0]["sindex"] &&
					$test_items_2["last_sindex"] === $test_items_2["range_items"][2]["sindex"] &&

					$test_items_2["total"] === 20 &&

					isset($test_items_2["current_page"]) &&
					$test_items_2["current_page"] === 2 &&

					isset($test_items_2["page_count"]) &&
					$test_items_2["page_count"] === 7

				): ?>
				<div class="testpassed"><p>Items::paginate – start with sindex, order ASC and DESC – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::paginate – start with sindex, order ASC and DESC – error</p></div>
				<? endif;

				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		}

		if(1 && "paginate - start with sindex, order ASC and DESC - extended") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}


				$test_items_1 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex ASC",
						"extend" => true
					],
					"sindex" => "Item-0015-0005"
				]);

				$test_items_2 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex DESC",
						"extend" => true
					],
					"sindex" => "Item-0015-0005"
				]);


				// debug([$test_items_1, $test_items_2]);

				if(
					$test_items_1 &&
					$test_items_1["range_items"] &&
					count($test_items_1["range_items"]) === 3 &&

					$test_items_1["range_items"][0]["sindex"] === "item-0015-0005" &&
					$test_items_1["range_items"][1]["sindex"] === "item-0016-0004" &&
					$test_items_1["range_items"][2]["sindex"] === "item-0017-0003" &&
					$test_items_1["range_items"][0]["name"] === "Item 0015 - 0005" &&
					$test_items_1["range_items"][1]["name"] === "Item 0016 - 0004" &&
					$test_items_1["range_items"][2]["name"] === "Item 0017 - 0003" &&

					$test_items_1["range_items"][0]["itemtype"] === "tests" &&
					$test_items_1["range_items"][1]["itemtype"] === "tests" &&
					$test_items_1["range_items"][2]["itemtype"] === "tests" &&


					$test_items_1["next"] &&
					isset($test_items_1["next"]["sindex"]) &&
					$test_items_1["next"]["sindex"] === "item-0018-0002" &&
					$test_items_1["next"]["name"] === "Item 0018 - 0002" &&

					$test_items_1["prev"] &&
					isset($test_items_1["prev"]["sindex"]) &&
					$test_items_1["prev"]["sindex"] === "item-0014-0006" &&
					$test_items_1["prev"]["name"] === "Item 0014 - 0006" &&


					$test_items_1["first_id"] === $test_items_1["range_items"][0]["id"] &&
					$test_items_1["last_id"] === $test_items_1["range_items"][2]["id"] &&

					$test_items_1["first_sindex"] === $test_items_1["range_items"][0]["sindex"] &&
					$test_items_1["last_sindex"] === $test_items_1["range_items"][2]["sindex"] &&

					$test_items_1["total"] === 20 &&

					isset($test_items_1["current_page"]) &&
					$test_items_1["current_page"] === 5 &&

					isset($test_items_1["page_count"]) &&
					$test_items_1["page_count"] === 7 &&



					$test_items_2 &&
					$test_items_2["range_items"] &&
					count($test_items_2["range_items"]) === 3 &&

					$test_items_2["range_items"][0]["sindex"] === "item-0015-0005" &&
					$test_items_2["range_items"][1]["sindex"] === "item-0014-0006" &&
					$test_items_2["range_items"][2]["sindex"] === "item-0013-0007" &&
					$test_items_2["range_items"][0]["name"] === "Item 0015 - 0005" &&
					$test_items_2["range_items"][1]["name"] === "Item 0014 - 0006" &&
					$test_items_2["range_items"][2]["name"] === "Item 0013 - 0007" &&

					$test_items_2["range_items"][0]["itemtype"] === "tests" &&
					$test_items_2["range_items"][1]["itemtype"] === "tests" &&
					$test_items_2["range_items"][2]["itemtype"] === "tests" &&

					$test_items_2["next"] &&
					isset($test_items_2["next"]["sindex"]) &&
					$test_items_2["next"]["sindex"] === "item-0012-0008" &&
					$test_items_2["next"]["name"] === "Item 0012 - 0008" &&

					$test_items_2["prev"] &&
					isset($test_items_2["prev"]["sindex"]) &&
					$test_items_2["prev"]["sindex"] === "item-0016-0004" &&
					$test_items_2["prev"]["name"] === "Item 0016 - 0004" &&

					$test_items_2["first_id"] === $test_items_2["range_items"][0]["id"] &&
					$test_items_2["last_id"] === $test_items_2["range_items"][2]["id"] &&

					$test_items_2["first_sindex"] === $test_items_2["range_items"][0]["sindex"] &&
					$test_items_2["last_sindex"] === $test_items_2["range_items"][2]["sindex"] &&

					$test_items_2["total"] === 20 &&

					isset($test_items_2["current_page"]) &&
					$test_items_2["current_page"] === 2 &&

					isset($test_items_2["page_count"]) &&
					$test_items_2["page_count"] === 7

				): ?>
				<div class="testpassed"><p>Items::paginate – start with sindex, order ASC and DESC - extended – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::paginate – start with sindex, order ASC and DESC - extended – error</p></div>
				<? endif;

				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		}

		if(1 && "paginate – start with sindex, order ASC and DESC, direction prev") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}

				// Test ASC sorting
				$test_items_1 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex ASC"
					],
					"sindex" => "Item-0015-0005",
					"direction" => "prev"
				]);

				$test_items_2 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex DESC"
					],
					"sindex" => "Item-0015-0005",
					"direction" => "prev"
				]);


				// debug([$test_items_1, $test_items_2]);

				if(
					$test_items_1 &&
					$test_items_1["range_items"] &&
					count($test_items_1["range_items"]) === 3 &&

					$test_items_1["range_items"][0]["sindex"] === "item-0013-0007" &&
					$test_items_1["range_items"][1]["sindex"] === "item-0014-0006" &&
					$test_items_1["range_items"][2]["sindex"] === "item-0015-0005" &&
					// Name should not exists
					!isset($test_items_1["range_items"][0]["name"]) &&
					!isset($test_items_1["range_items"][1]["name"]) &&
					!isset($test_items_1["range_items"][2]["name"]) &&

					$test_items_1["range_items"][0]["itemtype"] === "tests" &&
					$test_items_1["range_items"][1]["itemtype"] === "tests" &&
					$test_items_1["range_items"][2]["itemtype"] === "tests" &&


					$test_items_1["next"] &&
					isset($test_items_1["next"]["sindex"]) &&
					$test_items_1["next"]["sindex"] === "item-0016-0004" &&
					// Name should not exists
					!isset($test_items_1["next"]["name"]) &&

					$test_items_1["prev"] &&
					isset($test_items_1["prev"]["sindex"]) &&
					$test_items_1["prev"]["sindex"] === "item-0012-0008" &&
					// Name should not exists
					!isset($test_items_1["prev"]["name"]) &&


					$test_items_1["first_id"] === $test_items_1["range_items"][0]["id"] &&
					$test_items_1["last_id"] === $test_items_1["range_items"][2]["id"] &&

					$test_items_1["first_sindex"] === $test_items_1["range_items"][0]["sindex"] &&
					$test_items_1["last_sindex"] === $test_items_1["range_items"][2]["sindex"] &&

					$test_items_1["total"] === 20 &&

					isset($test_items_1["current_page"]) &&
					$test_items_1["current_page"] === 5 &&

					isset($test_items_1["page_count"]) &&
					$test_items_1["page_count"] === 7 &&



					$test_items_2 &&
					$test_items_2["range_items"] &&
					count($test_items_2["range_items"]) === 3 &&

					$test_items_2["range_items"][0]["sindex"] === "item-0017-0003" &&
					$test_items_2["range_items"][1]["sindex"] === "item-0016-0004" &&
					$test_items_2["range_items"][2]["sindex"] === "item-0015-0005" &&
					// Name should not exists
					!isset($test_items_2["range_items"][0]["name"]) &&
					!isset($test_items_2["range_items"][1]["name"]) &&
					!isset($test_items_2["range_items"][2]["name"]) &&

					$test_items_2["range_items"][0]["itemtype"] === "tests" &&
					$test_items_2["range_items"][1]["itemtype"] === "tests" &&
					$test_items_2["range_items"][2]["itemtype"] === "tests" &&

					$test_items_2["next"] &&
					isset($test_items_2["next"]["sindex"]) &&
					$test_items_2["next"]["sindex"] === "item-0014-0006" &&
					// Name should not exists
					!isset($test_items_2["next"]["name"]) &&

					$test_items_2["prev"] &&
					isset($test_items_2["prev"]["sindex"]) &&
					$test_items_2["prev"]["sindex"] === "item-0018-0002" &&
					// Name should not exists
					!isset($test_items_2["prev"]["name"]) &&

					$test_items_2["first_id"] === $test_items_2["range_items"][0]["id"] &&
					$test_items_2["last_id"] === $test_items_2["range_items"][2]["id"] &&

					$test_items_2["first_sindex"] === $test_items_2["range_items"][0]["sindex"] &&
					$test_items_2["last_sindex"] === $test_items_2["range_items"][2]["sindex"] &&

					$test_items_2["total"] === 20 &&

					isset($test_items_2["current_page"]) &&
					$test_items_2["current_page"] === 2 &&

					isset($test_items_2["page_count"]) &&
					$test_items_2["page_count"] === 7
				): ?>
				<div class="testpassed"><p>Items::paginate – no start point order ASC and DESC, direction prev – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::paginate – no start point order ASC and DESC, direction prev – error</p></div>
				<? endif;


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		}

		if(1 && "paginate - start with sindex, order ASC and DESC, NOT including index item") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}


				$test_items_1 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex ASC"
					],
					"sindex" => "Item-0015-0005",
					"include" => false
				]);

				$test_items_2 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex DESC"
					],
					"sindex" => "Item-0015-0005",
					"include" => false
				]);


				// debug([$test_items_1, $test_items_2]);

				if(
					$test_items_1 &&
					$test_items_1["range_items"] &&
					count($test_items_1["range_items"]) === 3 &&

					$test_items_1["range_items"][0]["sindex"] === "item-0016-0004" &&
					$test_items_1["range_items"][1]["sindex"] === "item-0017-0003" &&
					$test_items_1["range_items"][2]["sindex"] === "item-0018-0002" &&
					// Name should not exists
					!isset($test_items_1["range_items"][0]["name"]) &&
					!isset($test_items_1["range_items"][1]["name"]) &&
					!isset($test_items_1["range_items"][2]["name"]) &&

					$test_items_1["range_items"][0]["itemtype"] === "tests" &&
					$test_items_1["range_items"][1]["itemtype"] === "tests" &&
					$test_items_1["range_items"][2]["itemtype"] === "tests" &&


					$test_items_1["next"] &&
					isset($test_items_1["next"]["sindex"]) &&
					$test_items_1["next"]["sindex"] === "item-0019-0001" &&
					// Name should not exists
					!isset($test_items_1["next"]["name"]) &&

					$test_items_1["prev"] &&
					isset($test_items_1["prev"]["sindex"]) &&
					$test_items_1["prev"]["sindex"] === "item-0015-0005" &&
					// Name should not exists
					!isset($test_items_1["prev"]["name"]) &&


					$test_items_1["first_id"] === $test_items_1["range_items"][0]["id"] &&
					$test_items_1["last_id"] === $test_items_1["range_items"][2]["id"] &&

					$test_items_1["first_sindex"] === $test_items_1["range_items"][0]["sindex"] &&
					$test_items_1["last_sindex"] === $test_items_1["range_items"][2]["sindex"] &&

					$test_items_1["total"] === 20 &&

					isset($test_items_1["current_page"]) &&
					$test_items_1["current_page"] === 6 &&

					isset($test_items_1["page_count"]) &&
					$test_items_1["page_count"] === 7 &&



					$test_items_2 &&
					$test_items_2["range_items"] &&
					count($test_items_2["range_items"]) === 3 &&

					$test_items_2["range_items"][0]["sindex"] === "item-0014-0006" &&
					$test_items_2["range_items"][1]["sindex"] === "item-0013-0007" &&
					$test_items_2["range_items"][2]["sindex"] === "item-0012-0008" &&
					// Name should not exists
					!isset($test_items_2["range_items"][0]["name"]) &&
					!isset($test_items_2["range_items"][1]["name"]) &&
					!isset($test_items_2["range_items"][2]["name"]) &&

					$test_items_2["range_items"][0]["itemtype"] === "tests" &&
					$test_items_2["range_items"][1]["itemtype"] === "tests" &&
					$test_items_2["range_items"][2]["itemtype"] === "tests" &&

					$test_items_2["next"] &&
					isset($test_items_2["next"]["sindex"]) &&
					$test_items_2["next"]["sindex"] === "item-0011-0009" &&
					// Name should not exists
					!isset($test_items_2["next"]["name"]) &&

					$test_items_2["prev"] &&
					isset($test_items_2["prev"]["sindex"]) &&
					$test_items_2["prev"]["sindex"] === "item-0015-0005" &&
					// Name should not exists
					!isset($test_items_2["prev"]["name"]) &&

					$test_items_2["first_id"] === $test_items_2["range_items"][0]["id"] &&
					$test_items_2["last_id"] === $test_items_2["range_items"][2]["id"] &&

					$test_items_2["first_sindex"] === $test_items_2["range_items"][0]["sindex"] &&
					$test_items_2["last_sindex"] === $test_items_2["range_items"][2]["sindex"] &&

					$test_items_2["total"] === 20 &&

					isset($test_items_2["current_page"]) &&
					$test_items_2["current_page"] === 3 &&

					isset($test_items_2["page_count"]) &&
					$test_items_2["page_count"] === 7

				): ?>
				<div class="testpassed"><p>Items::paginate – start with sindex, order ASC and DESC, NOT including index item – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::paginate – start with sindex, order ASC and DESC, NOT including index item – error</p></div>
				<? endif;

				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		}

		if(1 && "paginate – start with sindex, order ASC and DESC, NOT including index item, direction prev") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}

				// Test ASC sorting
				$test_items_1 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex ASC"
					],
					"sindex" => "Item-0015-0005",
					"include" => false,
					"direction" => "prev"
				]);

				$test_items_2 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex DESC"
					],
					"sindex" => "Item-0015-0005",
					"include" => false,
					"direction" => "prev"
				]);


				// debug([$test_items_1, $test_items_2]);

				if(
					$test_items_1 &&
					$test_items_1["range_items"] &&
					count($test_items_1["range_items"]) === 3 &&

					$test_items_1["range_items"][0]["sindex"] === "item-0012-0008" &&
					$test_items_1["range_items"][1]["sindex"] === "item-0013-0007" &&
					$test_items_1["range_items"][2]["sindex"] === "item-0014-0006" &&
					// Name should not exists
					!isset($test_items_1["range_items"][0]["name"]) &&
					!isset($test_items_1["range_items"][1]["name"]) &&
					!isset($test_items_1["range_items"][2]["name"]) &&

					$test_items_1["range_items"][0]["itemtype"] === "tests" &&
					$test_items_1["range_items"][1]["itemtype"] === "tests" &&
					$test_items_1["range_items"][2]["itemtype"] === "tests" &&


					$test_items_1["next"] &&
					isset($test_items_1["next"]["sindex"]) &&
					$test_items_1["next"]["sindex"] === "item-0015-0005" &&
					// Name should not exists
					!isset($test_items_1["next"]["name"]) &&

					$test_items_1["prev"] &&
					isset($test_items_1["prev"]["sindex"]) &&
					$test_items_1["prev"]["sindex"] === "item-0011-0009" &&
					// Name should not exists
					!isset($test_items_1["prev"]["name"]) &&


					$test_items_1["first_id"] === $test_items_1["range_items"][0]["id"] &&
					$test_items_1["last_id"] === $test_items_1["range_items"][2]["id"] &&

					$test_items_1["first_sindex"] === $test_items_1["range_items"][0]["sindex"] &&
					$test_items_1["last_sindex"] === $test_items_1["range_items"][2]["sindex"] &&

					$test_items_1["total"] === 20 &&

					isset($test_items_1["current_page"]) &&
					$test_items_1["current_page"] === 4 &&

					isset($test_items_1["page_count"]) &&
					$test_items_1["page_count"] === 7 &&



					$test_items_2 &&
					$test_items_2["range_items"] &&
					count($test_items_2["range_items"]) === 3 &&

					$test_items_2["range_items"][0]["sindex"] === "item-0018-0002" &&
					$test_items_2["range_items"][1]["sindex"] === "item-0017-0003" &&
					$test_items_2["range_items"][2]["sindex"] === "item-0016-0004" &&
					// Name should not exists
					!isset($test_items_2["range_items"][0]["name"]) &&
					!isset($test_items_2["range_items"][1]["name"]) &&
					!isset($test_items_2["range_items"][2]["name"]) &&

					$test_items_2["range_items"][0]["itemtype"] === "tests" &&
					$test_items_2["range_items"][1]["itemtype"] === "tests" &&
					$test_items_2["range_items"][2]["itemtype"] === "tests" &&

					$test_items_2["next"] &&
					isset($test_items_2["next"]["sindex"]) &&
					$test_items_2["next"]["sindex"] === "item-0015-0005" &&
					// Name should not exists
					!isset($test_items_2["next"]["name"]) &&

					$test_items_2["prev"] &&
					isset($test_items_2["prev"]["sindex"]) &&
					$test_items_2["prev"]["sindex"] === "item-0019-0001" &&
					// Name should not exists
					!isset($test_items_2["prev"]["name"]) &&

					$test_items_2["first_id"] === $test_items_2["range_items"][0]["id"] &&
					$test_items_2["last_id"] === $test_items_2["range_items"][2]["id"] &&

					$test_items_2["first_sindex"] === $test_items_2["range_items"][0]["sindex"] &&
					$test_items_2["last_sindex"] === $test_items_2["range_items"][2]["sindex"] &&

					$test_items_2["total"] === 20 &&

					isset($test_items_2["current_page"]) &&
					$test_items_2["current_page"] === 1 &&

					isset($test_items_2["page_count"]) &&
					$test_items_2["page_count"] === 7
				): ?>
				<div class="testpassed"><p>Items::paginate – no start point order ASC and DESC, NOT including index item, direction prev – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::paginate – no start point order ASC and DESC, NOT including index item, direction prev – error</p></div>
				<? endif;


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		}

		if(1 && "paginate - start with page 2, order ASC and DESC") {

			(function() {

				$IC = new Items();
				$model_tests = $IC->typeObject("tests");


				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

				// Create 20 items for test (creating items takes time, so limit count)
				for($i = 0; $i < 20; $i++) {
					$model_tests->createTestItem(["name" => "Item " . str_pad(20 - $i, 4, "0", STR_PAD_LEFT) . " - ".str_pad($i, 4, "0", STR_PAD_LEFT)]);
				}


				$test_items_1 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex ASC"
					],
					"page" => 2
				]);

				$test_items_2 = $IC->paginate([
					"limit" => 3,
					"pattern" => [
						"itemtype" => "tests",
						"order" => "sindex DESC"
					],
					"page" => 2
				]);


				// debug([$test_items_1, $test_items_2]);

				if(
					$test_items_1 &&
					$test_items_1["range_items"] &&
					count($test_items_1["range_items"]) === 3 &&

					$test_items_1["range_items"][0]["sindex"] === "item-0004-0016" &&
					$test_items_1["range_items"][1]["sindex"] === "item-0005-0015" &&
					$test_items_1["range_items"][2]["sindex"] === "item-0006-0014" &&
					// Name should not exists
					!isset($test_items_1["range_items"][0]["name"]) &&
					!isset($test_items_1["range_items"][1]["name"]) &&
					!isset($test_items_1["range_items"][2]["name"]) &&

					$test_items_1["range_items"][0]["itemtype"] === "tests" &&
					$test_items_1["range_items"][1]["itemtype"] === "tests" &&
					$test_items_1["range_items"][2]["itemtype"] === "tests" &&


					$test_items_1["next"] &&
					isset($test_items_1["next"]["sindex"]) &&
					$test_items_1["next"]["sindex"] === "item-0007-0013" &&
					// Name should not exists
					!isset($test_items_1["next"]["name"]) &&

					$test_items_1["prev"] &&
					isset($test_items_1["prev"]["sindex"]) &&
					$test_items_1["prev"]["sindex"] === "item-0003-0017" &&
					// Name should not exists
					!isset($test_items_1["prev"]["name"]) &&


					$test_items_1["first_id"] === $test_items_1["range_items"][0]["id"] &&
					$test_items_1["last_id"] === $test_items_1["range_items"][2]["id"] &&

					$test_items_1["first_sindex"] === $test_items_1["range_items"][0]["sindex"] &&
					$test_items_1["last_sindex"] === $test_items_1["range_items"][2]["sindex"] &&

					$test_items_1["total"] === 20 &&

					isset($test_items_1["current_page"]) &&
					$test_items_1["current_page"] === 2 &&

					isset($test_items_1["page_count"]) &&
					$test_items_1["page_count"] === 7 &&



					$test_items_2 &&
					$test_items_2["range_items"] &&
					count($test_items_2["range_items"]) === 3 &&

					$test_items_2["range_items"][0]["sindex"] === "item-0017-0003" &&
					$test_items_2["range_items"][1]["sindex"] === "item-0016-0004" &&
					$test_items_2["range_items"][2]["sindex"] === "item-0015-0005" &&
					// Name should not exists
					!isset($test_items_2["range_items"][0]["name"]) &&
					!isset($test_items_2["range_items"][1]["name"]) &&
					!isset($test_items_2["range_items"][2]["name"]) &&

					$test_items_2["range_items"][0]["itemtype"] === "tests" &&
					$test_items_2["range_items"][1]["itemtype"] === "tests" &&
					$test_items_2["range_items"][2]["itemtype"] === "tests" &&

					$test_items_2["next"] &&
					isset($test_items_2["next"]["sindex"]) &&
					$test_items_2["next"]["sindex"] === "item-0014-0006" &&
					// Name should not exists
					!isset($test_items_2["next"]["name"]) &&

					$test_items_2["prev"] &&
					isset($test_items_2["prev"]["sindex"]) &&
					$test_items_2["prev"]["sindex"] === "item-0018-0002" &&
					// Name should not exists
					!isset($test_items_2["prev"]["name"]) &&

					$test_items_2["first_id"] === $test_items_2["range_items"][0]["id"] &&
					$test_items_2["last_id"] === $test_items_2["range_items"][2]["id"] &&

					$test_items_2["first_sindex"] === $test_items_2["range_items"][0]["sindex"] &&
					$test_items_2["last_sindex"] === $test_items_2["range_items"][2]["sindex"] &&

					$test_items_2["total"] === 20 &&

					isset($test_items_2["current_page"]) &&
					$test_items_2["current_page"] === 2 &&

					isset($test_items_2["page_count"]) &&
					$test_items_2["page_count"] === 7

				): ?>
				<div class="testpassed"><p>Items::paginate – start with sindex, order ASC and DESC, NOT including index item – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::paginate – start with sindex, order ASC and DESC, NOT including index item – error</p></div>
				<? endif;

				// Delete all tests items
				$model_tests->cleanup(["itemtype" => "tests"]);

			})();

		}

		?>

	</div>

	<div class="tests getPrices">
		<h3>Items::getPrices</h3>

		<? 

		if(1 && "getPrices – pass price_id – return specific price") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$query = new Query();
				
				$model_tests = $IC->typeObject("tests");
	
				$test_item_id = $model_tests->createTestItem();
	
				// add price
				$sql = "INSERT INTO ".UT_ITEMS_PRICES." VALUES(DEFAULT, $test_item_id, 100, 'DKK', 2, 1, 1)";
				if($query->sql($sql)) {
					
					$price_id = $query->lastInsertId();
				}
	
	
				// ACT
				$price = $IC->getPrices(["price_id" => $price_id]);
				
				// ASSERT 
				if(
					$price &&
					$price["price"] == 100 &&
					$price["currency"] == "DKK" &&
					$price["quantity"] == 1 &&
					$price["vatrate"] == 25 &&
					$price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Items::getPrices – pass price_id – return specific price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getPrices – pass price_id – return specific price – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();
		}

		if(1 && "getPrices – pass item_id, item has several prices – return prices") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
	
				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"offer" => [
							"price" => 50
						]
					]
				]);

				
	
				// ACT
				$prices = $IC->getPrices(["item_id" => $test_item_id]);
				
				// ASSERT 
				if(
					$prices &&
					count($prices) == 2 &&
					$prices[0]["type"] == "offer" &&
					$prices[1]["type"] == "default" &&
					$prices[0]["price"] == "50" &&
					$prices[1]["price"] == "100"
				): ?>
				<div class="testpassed"><p>Items::getPrices – pass item_id, item has several prices – return prices – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getPrices – pass item_id, item has several prices – return prices – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id]);
	
			})();
		}

		if(1 && "getPrices – pass item_id and currency, item has several prices – return price in specified currency") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$query = new Query();
				
				$model_tests = $IC->typeObject("tests");

				$currency_id = $model_tests->createTestCurrency();
	
				$test_item_id = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100,
							"currency" => "XXX"
						],
						"offer" => [
							"price" => 50
						]
					]
				]);
	
				// ACT
				$prices = $IC->getPrices(["item_id" => $test_item_id, "currency" => "XXX"]);
				
				// ASSERT 
				if(
					$prices &&
					count($prices) == 1 &&
					$prices[0]["type"] == "default" &&
					$prices[0]["price"] == 100 &&
					$prices[0]["currency"] == "XXX"
				): ?>
				<div class="testpassed"><p>Items::getPrices – pass item_id and currency, item has several prices – return price in specified currency – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getPrices – pass item_id and currency, item has several prices – return price in specified currency – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id, "currency_id" => $currency_id]);
	
			})();
		}

		if(1 && "getPrices – pass nothing – return all prices") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$query = new Query();
				
				$model_tests = $IC->typeObject("tests");
	
				$test_item_id_1 = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"offer" => [
							"price" => 50
						]
					]
				]);

				$test_item_id_2 = $model_tests->createTestItem([
					"prices" => [
						"default" => [
							"price" => 200
						],
						"offer" => [
							"price" => 75
						]
					]
				]);

	
				// ACT
				$prices = $IC->getPrices();
				
				// ASSERT 
				if($prices)	{

					foreach($prices as $price) {
						if($price["item_id"] == $test_item_id_1 && $price["type"] == "default") {
							$test_item_1_default = $price["price"];
						}
						else if($price["item_id"] == $test_item_id_1 && $price["type"] == "offer") {
							$test_item_1_offer = $price["price"];
						}
						else if($price["item_id"] == $test_item_id_2 && $price["type"] == "default") {
							$test_item_2_default = $price["price"];
						}
						else if($price["item_id"] == $test_item_id_2 && $price["type"] == "offer") {
							$test_item_2_offer = $price["price"];
						}
					}
				}

				if(
					$prices
					&& $test_item_1_default == 100
					&& $test_item_1_offer == 50
					&& $test_item_2_default == 200
					&& $test_item_2_offer == 75
				): ?>
				<div class="testpassed"><p>Items::getPrices – pass nothing – return all prices – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Items::getPrices – pass nothing – return all prices – error</p></div>
				<? endif; 
				
				// CLEAN UP
				$model_tests->cleanUp(["item_id" => $test_item_id_1]);
				$model_tests->cleanUp(["item_id" => $test_item_id_2]);
	
			})();
		}

		?>

	</div>

</div>