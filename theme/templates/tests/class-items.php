<?

$IC = new Items();
$query = new Query();
$post_model = $IC->typeObject("post");
?>

<div class="scene i:scene tests">
	<h1>ItemsClass</h1>	
	<h2>Item querying of all sorts</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<?
	function addTestPrices() {


	}
	?>

	<div class="tests ratings">
		<h3>Items ratings</h3>
		<? 


		// Delete your post items from janitor_parentnode_dk db to repeat test from scratch


		$items = $IC->getItems(array("itemtype" => "post", "order" => "rating DESC", "limit" => 4, "extend" => ["ratings" => true]));
		if(!$items) {

			unset($_POST);
			$_POST["name"] = "Test item 1 - I should be first";
			$item = $post_model->save(array("save", "post"));
			$item_id = $item["id"];

			unset($_POST);
			$_POST["item_rating"] = 5;
			$post_model->addRating(array("addRating", $item_id));
			$post_model->addRating(array("addRating", $item_id));
			$post_model->addRating(array("addRating", $item_id));
			$post_model->addRating(array("addRating", $item_id));
			$post_model->addRating(array("addRating", $item_id));

			
			unset($_POST);
			$_POST["name"] = "Test item 2 -  I should be fourth";
			$item = $post_model->save(array("save", "post"));
			$item_id = $item["id"];

			unset($_POST);
			$_POST["item_rating"] = 2;
			$post_model->addRating(array("addRating", $item_id));


			unset($_POST);
			$_POST["name"] = "Test item 3 - I should be third";
			$item = $post_model->save(array("save", "post"));
			$item_id = $item["id"];

			unset($_POST);
			$_POST["item_rating"] = 9;
			$post_model->addRating(array("addRating", $item_id));
			$_POST["item_rating"] = 7;
			$post_model->addRating(array("addRating", $item_id));


			unset($_POST);
			$_POST["name"] = "Test item 4 - I should be second";
			$item = $post_model->save(array("save", "post"));
			$item_id = $item["id"];

			unset($_POST);
			$_POST["item_rating"] = 8;
			$post_model->addRating(array("addRating", $item_id));
			$_POST["item_rating"] = 11;
			$post_model->addRating(array("addRating", $item_id));
			$_POST["item_rating"] = 1;
			$post_model->addRating(array("addRating", $item_id));
			$_POST["item_rating"] = 6;
			$post_model->addRating(array("addRating", $item_id));
			$_POST["item_rating"] = 6;

			$items = $IC->getItems(["itemtype" => "post", "order" => "rating DESC", "limit" => 4, "extend" => ["ratings" => true]]);
			
			// debug([$items, message()->getMessages()]);
			message()->resetMessages();
		}
		
		if("Your test condition"): ?>
		<div class="testpassed"><p>#Class::method# - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>#Class::method# - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests pagination">
		<h3>Items pagination</h3>
		<?
		$query = new Query();
		$sql = "DELETE FROM ".SITE_DB.".items WHERE itemtype = 'tests'";
		$query->sql($sql);
		
		$model_tests = $IC->typeObject("tests");
		unset($_POST);
		
		$_POST["name"] = "Test item AAA";
		$item = $model_tests->save(array("save", "tests"));
		$item_id_A = $item["item_id"];
		unset($_POST);
		
		$_POST["name"] = "Test item BBB";
		$item = $model_tests->save(array("save", "tests"));
		$item_id_B = $item["item_id"];
		unset($_POST);
		
		$_POST["name"] = "Test item CCC";
		$item = $model_tests->save(array("save", "tests"));
		$item_id_C = $item["item_id"];
		unset($_POST);
		?>
		
		<? if(1 && "no start point"): ?>

			<?
			$items = $IC->paginate(array(
				"limit" => 2, 
				"pattern" => array(
					"itemtype" => "tests",
					"order" => "sindex ASC")
			));
			?>
			
			<? if(
				$items &&
				$items["range_items"] &&
				count($items["range_items"]) == 2 &&
				$items["range_items"][0]["id"] == $item_id_A &&
				$items["range_items"][1]["id"] == $item_id_B &&
				$items["range_items"][0]["itemtype"] == "tests" &&
				$items["next"] && 
				count($items["next"]) == 1 &&
				$items["next"][0]["id"] == $item_id_C &&
				$items["first_id"] &&
				$items["last_id"] &&
				$items["first_sindex"] &&
				$items["last_sindex"] &&
				$items["total"] == 3
				
				): ?>
			<div class="testpassed"><p>Items::paginate – no start point – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Items::paginate – no start point – error</p></div>
			<? endif;?>
		<? endif; ?>

		<? if(1 && "start from item with specified sindex"): ?>
			<?
			$sindex = "test-item-aaa";
			
			$items = $IC->paginate(array(
				"limit" => 2, 
				"pattern" => array(
					"itemtype" => "tests",
					"order" => "sindex ASC"),
				"sindex" => $sindex
			));
		
			?>
			
			<? if(
				$items &&
				$items["range_items"] &&
				count($items["range_items"]) == 2 &&
				$items["range_items"][0]["id"] == $item_id_A &&
				$items["range_items"][1]["id"] == $item_id_B &&
				$items["range_items"][0]["itemtype"] == "tests" &&
				$items["next"] && 
				count($items["next"]) == 1 &&
				$items["next"][0]["id"] == $item_id_C &&
				$items["first_id"] &&
				$items["last_id"] &&
				$items["first_sindex"] &&
				$items["last_sindex"] &&
				$items["total"] == 3
				
				): ?>
			<div class="testpassed"><p>Items::paginate – start from item with specified sindex – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Items::paginate – start from item with specified sindex – error</p></div>
			<? endif;?>
		<? endif; ?>

		<? if(1 && "direction = 'next': start from item subsequent to item with specified sindex"): ?>
			<?
			
			$items = $IC->paginate(array(
				"limit" => 2, 
				"pattern" => array(
					"itemtype" => "tests",
					"order" => "sindex ASC"),
				"sindex" => $sindex,
				"direction" => "next"
			));
			?>
			
			<? if(
				$items &&
				$items["range_items"] &&
				count($items["range_items"]) == 2 &&
				$items["range_items"][0]["id"] == $item_id_B &&
				$items["range_items"][1]["id"] == $item_id_C &&
				$items["range_items"][0]["itemtype"] == "tests" &&
				$items["prev"] && 
				count($items["prev"]) == 1 &&
				$items["prev"][0]["id"] == $item_id_A &&
				$items["first_id"] &&
				$items["last_id"] &&
				$items["first_sindex"] &&
				$items["last_sindex"] &&
				$items["total"] == 3
				
				): ?>
			<div class="testpassed"><p>Items::paginate – direction = 'next' – start from item subsequent to item with specified sindex – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Items::paginate – direction = 'next' – start from item subsequent to item with specified sindex – error</p></div>
			<? endif;?>
		<? endif; ?>

		<? if(1 && "direction = 'prev': show items before item with specified sindex"): ?>
			<?
			$sindex = "test-item-bbb";
			$items = $IC->paginate(array(
				"limit" => 2, 
				"pattern" => array(
					"itemtype" => "tests",
					"order" => "sindex ASC"),
				"sindex" => $sindex,
				"direction" => "prev"
			));

			?>
			
			<? if(
				$items &&
				$items["range_items"] &&
				count($items["range_items"]) == 1 &&
				$items["range_items"][0]["id"] == $item_id_A &&
				$items["range_items"][0]["itemtype"] == "tests" &&
				$items["next"] && 
				count($items["next"]) == 2 &&
				$items["next"][0]["id"] == $item_id_B &&
				$items["next"][1]["id"] == $item_id_C &&
				$items["first_id"] &&
				$items["last_id"] &&
				$items["first_sindex"] &&
				$items["last_sindex"] &&
				$items["total"] == 3
				
				): ?>
			<div class="testpassed"><p>Items::paginate – direction = 'prev' – show items before item with specified sindex – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Items::paginate – direction = 'prev' – show items before item with specified sindex – error</p></div>
			<? endif;?>
		
		<? endif; ?>

		<? if(1 && "sort items by descending ratings, show items before item with specified sindex"): ?>
			<?
			$sindex = "test-item-3-i-should-be-third";
			
			$items = $IC->paginate(array(
				"limit" => 2, 
				"pattern" => array(
					"itemtype" => "post",
					"order" => "rating DESC", 
					"extend" => array(
						"ratings" => true
					)),
				"sindex" => $sindex,
				"direction" => "prev"
			));
			if(
				$items &&
				$items["range_items"] &&
				count($items["range_items"]) == 2 &&
				$items["range_items"][0]["total_rating"] == 26 &&
				$items["range_items"][0]["sindex"] == "test-item-4-i-should-be-second" &&
				$items["range_items"][0]["ratings"] &&
				$items["range_items"][1]["total_rating"] == 25 &&
				$items["range_items"][1]["sindex"] == "test-item-1-i-should-be-first" &&
				$items["range_items"][0]["itemtype"] == "post" &&
				$items["next"] && 
				count($items["next"]) == 2 &&
				$items["next"][0]["sindex"] == "test-item-3-i-should-be-third" &&
				$items["next"][0]["total_rating"] == 16 &&
				$items["next"][1]["sindex"] == "test-item-2-i-should-be-fourth" &&
				$items["next"][1]["total_rating"] = 2 &&
				$items["first_id"] &&
				$items["last_id"] &&
				$items["first_sindex"] == "test-item-4-i-should-be-second" &&
				$items["last_sindex"] ==  "test-item-1-i-should-be-first" &&
				$items["total"] == 4
				
			): ?>
			<div class="testpassed"><p>Items::paginate - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Items::paginate - error</p></div>
			<? endif;?>
		<? endif; ?>

		<? if(1 && "sort items by descending ratings, start from item subsequent to item with specified sindex"): ?>
			<?
			$items = $IC->paginate(array(
				"limit" => 2, 
				"pattern" => array(
					"itemtype" => "post",
					"order" => "rating DESC", 
					"extend" => array(
						"ratings" => true
					)),
				"sindex" => "test-item-3-i-should-be-third",
				"direction" => "next"
			));
			if(
				$items &&
				$items["range_items"] &&
				count($items["range_items"]) == 1 &&
				$items["range_items"][0]["total_rating"] == 2 &&
				$items["range_items"][0]["sindex"] == "test-item-2-i-should-be-fourth" &&
				$items["range_items"][0]["ratings"] &&
				$items["range_items"][0]["itemtype"] == "post" &&
				$items["prev"] && 
				count($items["prev"]) == 2 &&
				$items["prev"][0]["sindex"] == "test-item-1-i-should-be-first" &&
				$items["prev"][0]["total_rating"] == 25 &&
				$items["prev"][1]["sindex"] == "test-item-3-i-should-be-third" &&
				$items["prev"][1]["total_rating"] == 16 &&
				$items["first_id"] &&
				$items["last_id"] &&
				$items["first_sindex"] == "test-item-2-i-should-be-fourth" &&
				$items["last_sindex"] ==  "test-item-2-i-should-be-fourth" &&
				$items["total"] == 4
				
			): ?>
			<div class="testpassed"><p>Items::paginate – sort items by descending ratings, start from item subsequent to item with specified sindex – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Items::paginate – sort items by descending ratings, start from item subsequent to item with specified sindex – error</p></div>
			<? endif;?>
		<? endif; ?>

		<? if(1 && "itemtype doesn't exist – return empty array"): ?>
			<?	
			$items = $IC->paginate(array(
				"limit" => 2, 
				"pattern" => array(
					"itemtype" => "membership",
					"order" => "rating DESC", 
					"extend" => array(
						"ratings" => true
					))
			));
			if(
				$items &&
				$items["range_items"] == [] &&
				empty($items["range_items"]) &&
				$items["total"] == 0
			): ?>
			<div class="testpassed"><p>Items::paginate – itemtype doesn't exist – return empty array – correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>Items::paginate – itemtype doesn't exist – return empty array – error</p></div>
			<? endif; ?>
		<? endif; ?>

		<? // CLEAN UP

		// delete posts item
		$sql = "DELETE FROM ".SITE_DB.".items WHERE sindex IN('test-item-1-i-should-be-first', 'test-item-2-i-should-be-fourth', 'test-item-3-i-should-be-third', 'test-item-4-i-should-be-second', 'test-item-aaa', 'test-item-bbb', 'test-item-ccc')";
		$query->sql($sql);	
	
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
				$query = new Query();
				
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
					$prices[0]["name"] == "offer" &&
					$prices[1]["name"] == "default" &&
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
					$prices[0]["name"] == "default" &&
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