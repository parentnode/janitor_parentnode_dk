<?

$IC = new Items();
$post_model = $IC->typeObject("post");
?>

<div class="scene i:scene tests">
	<h1>ItemsClass</h1>	
	<h2>Item querying of all sorts</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
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
			$_POST["name"] = "Test item 2 -  I should be forth";
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
			
			debug([$items, message()->getMessages()]);
			message()->resetMessages();
		}
		
		if("Your test condition"): ?>
		<div class="testpassed"><p>#Class::method# - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>#Class::method# - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
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
		<div class="testpassed"><p>Items::paginate - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Items::paginate - error</p></div>
		<? endif;
		
		$sindex = "test-item-aaa";
		
		$items = $IC->paginate(array(
			"limit" => 2, 
			"pattern" => array(
				"itemtype" => "tests",
				"order" => "sindex ASC"),
			"sindex" => $sindex
		));
		print_r($items);
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
		<div class="testpassed"><p>Items::paginate - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Items::paginate - error</p></div>
		<? endif;
		
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
		<div class="testpassed"><p>Items::paginate - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Items::paginate - error</p></div>
		<? endif;
		
		$sindex = "test-item-bbb";
		$items = $IC->paginate(array(
			"limit" => 2, 
			"pattern" => array(
				"itemtype" => "tests",
				"order" => "sindex ASC"),
			"sindex" => $sindex,
			"direction" => "prev"
		));
		print_r($items);
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
		<div class="testpassed"><p>Items::paginate - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Items::paginate - error</p></div>
		<? endif;
		
		
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
			$items["next"][1]["sindex"] == "test-item-2-i-should-be-forth" &&
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
		<? endif;
		
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
			$items["range_items"][0]["sindex"] == "test-item-2-i-should-be-forth" &&
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
			$items["first_sindex"] == "test-item-2-i-should-be-forth" &&
			$items["last_sindex"] ==  "test-item-2-i-should-be-forth" &&
			$items["total"] == 4
			
		): ?>
		<div class="testpassed"><p>Items::paginate - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Items::paginate - error</p></div>
		<? endif;
		
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
		<div class="testpassed"><p>Items::paginate - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Items::paginate - error</p></div>
		<? endif; ?>
	</div>

	

</div>