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

		print_r($items);

		if("Your test condition"): ?>
		<div class="testpassed"><p>#Class::method# - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>#Class::method# - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>#Test name#</h3>
		<? if("Your test condition"): ?>
		<div class="testpassed"><p>#Class::method# - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>#Class::method# - error</p></div>
		<? endif; ?>
	</div>

</div>