<div class="scene i:scene tests defaultEdit">
	<h1>Shop</h1>	
	<h2>Testing Shop class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests getPrice">
		<h3>Shop::getPrice</h3>
		<?

		if(1 && "getPrice – item with default price – return default price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);


				// ACT

				$price = $SC->getPrice($test_item_id);


				// ASSERT 

				if(
					$price
					&& $price["price"] == 100
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price – return default price – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "getPrice – item with default price of 0 – return default price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $test_model->createTestItem(["price" => 0]);


				// ACT

				$price = $SC->getPrice($test_item_id);


				// ASSERT 

				if(
					$price
					&& $price["price"] == "0"
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price of 0 – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price of 0 – return default price – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "getPrice – item with default price and cheaper offer price – return offer price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
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

				$price = $SC->getPrice($test_item_id);


				// ASSERT 

				if(
					$price
					&& $price["price"] == 50
					&& $price["type"] == "offer"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and cheaper offer price – return offer price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and cheaper offer price – return offer price – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "getPrice – item with default price and more expensive offer price – return default price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"offer" => [
							"price" => 150
						]
					]
				]);


				// ACT

				$price = $SC->getPrice($test_item_id);


				// ASSERT 

				if(
					$price
					&& $price["price"] == 100
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and more expensive offer price – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and more expensive offer price – return default price – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "getPrice – item with default price and bulk price with minimum quantity 3, get price for 3 items – return bulk price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"bulk" => [
							"price" => 80,
							"quantity" => 3
						]
					]
				]);


				// ACT

				$price = $SC->getPrice($test_item_id, ["quantity" => 3]);


				// ASSERT 

				if(
					$price
					&& $price["price"] == 80
					&& $price["type"] == "bulk"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and bulk price with minimum quantity 3, get price for 3 items – return bulk price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and bulk price with minimum quantity 3, get price for 3 items – return bulk price – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "getPrice – item with default price and bulk price with minimum quantity 3, get price for 2 items – return default price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"bulk" => [
							"price" => 80,
							"quantity" => 3
						]
					]
				]);


				// ACT

				$price = $SC->getPrice($test_item_id, ["quantity" => 2]);


				// ASSERT 

				if(
					$price
					&& $price["price"] == 100
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and bulk price with minimum quantity 3, get price for 2 items – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and bulk price with minimum quantity 3, get price for 2 items – return default price – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "getPrice – item with default price and cheaper membership price, user has matching membership – return membership price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2,
					"price" => 200
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_membership_item_id
				]);

				$test_item_id = $test_model->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"test-membership" => [
							"price" => 75
						]
					]
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$price = $SC->getPrice($test_item_id);
				// debug([$price]);


				// ASSERT

				if(
					$price
					&& $price["price"] == 75
					&& $price["type"] == "test-membership"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and cheaper membership price, user has matching membership – return membership price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and cheaper membership price, user has matching membership – return membership price – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "getPrice – item with default price and more expensive membership price, user has matching membership – return lowest price") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2,
					"price" => 200
				]);
				// debug(["m1", $test_membership_item_id, message()->getMessages()]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_membership_item_id
				]);


				$test_item_id = $test_model->createTestItem([
					"prices" => [
						"default" => [
							"price" => 75
						],
						"test-membership" => [
							"price" => 100
						]
					]
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$price = $SC->getPrice($test_item_id);
				// debug([$price]);


				// ASSERT 

				if(
					$price
					&& $price["price"] == 75
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and more expensive membership price, user has matching membership – return lowest price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and more expensive membership price, user has matching membership – return lowest price – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "getPrice – item with default price and cheaper membership price, user has different membership – return default price") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_membership_item_id_1 = $test_model->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2,
					"price" => 150
				]);

				$test_membership_item_id_2 = $test_model->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership-2",
					"subscription_method" => 2,
					"price" => 200
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_membership_item_id_2
				]);


				$test_item_id = $test_model->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"test-membership" => [
							"price" => 75
						]
					]
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$price = $SC->getPrice($test_item_id);


				// ASSERT 

				if(
					$price
					&& $price["price"] == 100
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and cheaper membership price, user has different membership – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and cheaper membership price, user has different membership – return default price – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id_1]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id_2]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "getPrice – item with default price and membership price, user has no membership – return default price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2,
					"price" => 200
				]);


				$test_item_id = $test_model->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"test-membership" => [
							"price" => 75
						]
					]
				]);

				$test_user_id = $test_model->createTestUser();


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$price = $SC->getPrice($test_item_id);


				// ASSERT 

				if(
					$price
					&& $price["price"] == 100
					&& $price["type"] == "default"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and membership price, user has no membership – return default price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and membership price, user has no membership – return default price – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "getPrice – item with default price and cheaper membership price and even cheaper offer price, user has matching membership – return offer price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2,
					"price" => 200
				]);


				$test_item_id = $test_model->createTestItem([
					"prices" => [
						"default" => [
							"price" => 100
						],
						"test-membership" => [
							"price" => 75
						],
						"offer" => [
							"price" => 50
						]
					]
				]);

				$test_user_id = $test_model->createTestUser([
					"subscribed_item_id" => $test_membership_item_id
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$price = $SC->getPrice($test_item_id);


				// ASSERT 

				if(
					$price
					&& $price["price"] == 50
					&& $price["type"] == "offer"
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with default price and cheaper membership price and even cheaper offer price, user has matching membership – return offer price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with default price and cheaper membership price and even cheaper offer price, user has matching membership – return offer price – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "getPrice – item with only membership price, user has no membership – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"name" => "test-membership",
					"subscription_method" => 2,
					"price" => 200
				]);

				$test_item_id = $test_model->createTestItem([
					"prices" => [
						"test-membership" => [
							"price" => 75
						]
					]
				]);

				$test_user_id = $test_model->createTestUser();

				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$price = $SC->getPrice($test_item_id);


				// ASSERT 

				if(
					$price === false
				): ?>
				<div class="testpassed"><p>Shop::getPrice – item with only membership price, user has no membership – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getPrice – item with only membership price, user has no membership – return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_membership_item_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests addCart">
		<h3>Shop::addCart</h3>
		<?

		if(1 && "addCart – normal cart – should return cart and add cart_reference to session") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();


				// ACT 

				$cart = $SC->addCart(["addCart"]);
				$test_cart_id = $cart["id"];


				// ASSERT 

				if(
					$cart &&
					$cart["id"] &&
					session()->value("cart_reference") == $cart["cart_reference"]
					): ?>
				<div class="testpassed"><p>Shop::addCart – normal cart – should return cart and add cart_reference to session – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addCart – normal cart – should return cart and add cart_reference to session – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addCart – internal cart – should return cart, no cart_reference in session") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();


				// ACT

				$_POST["is_internal"] = true;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$test_cart_id = $cart["id"];

				$session_cart_reference = session()->value("cart_reference");


				// ASSERT 

				if(
					$cart &&
					$cart["id"] &&
					!$session_cart_reference
					): ?>
				<div class="testpassed"><p>Shop::addCart – internal cart – should return cart, no cart_reference in session – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addCart – internal cart – should return cart, no cart_reference in session – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests addToCart">
		<h3>Shop::addToCart()</h3>
		<?

		if(1 && "addToCart – add item without price – return false") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem();


				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$result = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$result === false &&
					$cart &&
					!$cart["items"]
					): ?>
				<div class="testpassed"><p>Shop::addToCart() – add item without price – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add item without price – return false – error</p></div>
				
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add two different itemtypes to cart – return cart") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->TypeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);
				$membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership", 
					"price" => 100
				]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $membership_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$cart &&
					$cart["id"] &&
					$cart["cart_reference"] &&
					$cart["country"] &&
					$cart["currency"] &&
					$cart["items"] &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][1]["item_id"] == $membership_item_id &&
					$cart["items"][0]["quantity"] == 1 &&
					$cart["items"][1]["quantity"] == 1 &&
					$cart["items"][0]["id"] &&
					$cart["items"][1]["id"] &&
					$cart["items"][0]["cart_id"] &&
					$cart["items"][1]["cart_id"] &&
					count($cart["items"]) == 2
					): ?>
				<div class="testpassed"><p>Shop::addToCart() – add two different itemtypes to cart – return cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add two different itemtypes to cart – return cart – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["item_id" => $membership_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add item that already exists in cart – return cart with updated quantity") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->TypeObject("tests");

				$SC = new Shop();


				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$cart &&
					$cart["items"] &&
					$cart["items"][0]["quantity"] == 2 &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					count($cart["items"]) == 1 &&
					$cart["id"] &&
					$cart["cart_reference"] &&
					$cart["country"] &&
					$cart["currency"]
					): ?>
				<div class="testpassed"><p>Shop::addToCart() – add item that already exists in cart – return cart with updated quantity – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add item that already exists in cart – return cart with updated quantity – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add item with custom_name and custom_price – return cart") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->TypeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$cart &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][0]["custom_name"] == "Test item with special price" &&
					$cart["items"][0]["custom_price"] == 50
					): ?>
				<div class="testpassed"><p>Shop::addToCart() – add item with custom_name and custom_price – return cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add item with custom_name and custom_price – return cart – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add item with custom_price of 0 – return cart with cart item with custom price of 0") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->TypeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 0;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$cart
					&& $cart["items"][0]["item_id"] == $test_item_id
					&& $cart["items"][0]["custom_price"] === "0"
				): ?>
				<div class="testpassed"><p>Shop::addToCart() – add item with custom_price of 0 – return cart with cart item with custom price of 0 – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add item with custom_price of 0 – return cart with cart item with custom price of 0 – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items ") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->TypeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$cart &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][1]["item_id"] == $test_item_id &&
					$cart["items"][0]["custom_price"] == 50 &&
					count($cart["items"]) == 2
					): ?>
				<div class="testpassed"><p>Shop::addToCart() – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items  – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items  – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities ") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->TypeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 75;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
	
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "Test item with special price";
				$_POST["custom_price"] = 75;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$cart &&
					count($cart["items"]) == 3 &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][1]["item_id"] == $test_item_id &&
					$cart["items"][2]["item_id"] == $test_item_id &&
					$cart["items"][0]["custom_price"] == 50 &&
					!isset($cart["items"][1]["custom_price"]) &&
					$cart["items"][2]["custom_price"] == 75 &&
					$cart["items"][0]["quantity"] == 1 &&
					$cart["items"][1]["quantity"] == 2 &&
					$cart["items"][2]["quantity"] == 2 
					): ?>
				<div class="testpassed"><p>Shop::addToCart() – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add the same item twice, one standard, and one with custom name – return cart with separated items") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->TypeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$cart &&
					count($cart["items"]) == 2 &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][1]["item_id"] == $test_item_id &&
					!isset($cart["items"][0]["custom_name"]) &&
					$cart["items"][1]["custom_name"] == "AAA"
					): ?>
				<div class="testpassed"><p>Shop::addToCart() – add the same item twice, one standard, and one with custom name – return cart with separated items – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add the same item twice, one standard, and one with custom name – return cart with separated items – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities ") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->TypeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "BBB";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
	
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "BBB";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$cart &&
					count($cart["items"]) == 3 &&
					$cart["items"][0]["custom_name"] == "AAA" &&
					!isset($cart["items"][1]["custom_name"]) &&
					$cart["items"][2]["custom_name"] == "BBB" &&
					$cart["items"][0]["quantity"] == 1 &&
					$cart["items"][1]["quantity"] == 2 &&
					$cart["items"][2]["quantity"] == 2 &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][1]["item_id"] == $test_item_id &&
					$cart["items"][2]["item_id"] == $test_item_id
					
					): ?>
				<div class="testpassed"><p>Shop::addToCart() – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities") {

			(function(){

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->TypeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ACT
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "BBB";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_price"] = 75;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "BBB";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$_POST["custom_price"] = 75;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "AAA";
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_name"] = "BBB";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$cart &&
					count($cart["items"]) == 8 &&
					!isset($cart["items"][0]["custom_name"]) &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][0]["quantity"] == 2 &&
					$cart["items"][1]["item_id"] == $test_item_id &&
					$cart["items"][1]["custom_name"] == "AAA" &&
					$cart["items"][1]["quantity"] == 1 &&
					$cart["items"][2]["item_id"] == $test_item_id &&
					$cart["items"][2]["custom_name"] == "BBB" &&
					$cart["items"][2]["quantity"] == 2 &&
					$cart["items"][3]["item_id"] == $test_item_id &&
					$cart["items"][3]["custom_price"] == 50 &&
					$cart["items"][3]["quantity"] == 2 &&
					$cart["items"][4]["item_id"] == $test_item_id &&
					$cart["items"][4]["custom_price"] == 75 &&
					$cart["items"][4]["quantity"] == 1 &&
					$cart["items"][5]["item_id"] == $test_item_id &&
					$cart["items"][5]["custom_price"] == 50 &&
					$cart["items"][5]["custom_name"] == "AAA" &&
					$cart["items"][5]["quantity"] == 2 &&
					$cart["items"][6]["item_id"] == $test_item_id &&
					$cart["items"][6]["custom_price"] == 50 &&
					$cart["items"][6]["custom_name"] == "BBB" &&
					$cart["items"][6]["quantity"] == 1 &&
					$cart["items"][7]["item_id"] == $test_item_id &&
					$cart["items"][7]["custom_name"] == "AAA" &&
					$cart["items"][7]["custom_price"] == 75 &&
					$cart["items"][7]["quantity"] == 1
				): ?>
				<div class="testpassed"><p>Shop::addToCart() – addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToCart() – addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests addToNewInternalCart">
		<h3>Shop::addToNewInternalCart</h3>
		<?

		if(1 && "addToNewInternalCart – add test item – return cart with test item") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);


				// ACT

				$cart = $SC->addToNewInternalCart($test_item_id);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ASSERT 

				if(
					$cart &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["user_id"] == session()->value("user_id")
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item – return cart with test item – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item – return cart with test item – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2)") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				$cart = $SC->addToNewInternalCart($test_item_id, ["quantity" => 2]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ASSERT 

				if(
					$cart
					&& $cart["items"][0]["item_id"] == $test_item_id
					&& $cart["items"][0]["quantity"] == 2
					&& $cart["user_id"] == session()->value("user_id")
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2) – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2) – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item without price – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem();


				// ACT

				$cart = $SC->addToNewInternalCart($test_item_id);


				// ASSERT 

				if(
					$cart == false
					&& $test_item_id
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item without price – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item without price – return false – error</p></div>
				<? endif; 


				// CLEAN UP
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();

				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				$cart = $SC->addToNewInternalCart($test_item_id, ["custom_name" => "Test item with custom name", "custom_price" => 50]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				// ASSERT 

				if(
					$cart
					&& $cart["items"][0]["item_id"] == $test_item_id
					&& $cart["user_id"] == session()->value("user_id")
					&& $cart["items"][0]["custom_price"] == 50
					&& $cart["items"][0]["custom_name"] == "Test item with custom name"
					): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["cart_id" => $test_cart_id]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests getCart">
		<h3>Shop::getCart()</h3>
		<? 

		if(1 && "getCart – cart with 1 item – return cart") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();

				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$test_item_id = $test_model->createTestItem();

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ACT

				$cart = $SC->getCart();


				// ASSERT 

				if(
					$cart 
					&& $cart["user_id"] == session()->value("user_id")
					&& $cart_reference == $cart["cart_reference"]
				): ?>
				<div class="testpassed"><p>Shop::getCart – cart with 1 item – return cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::getCart – cart with 1 item – return cart – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id,
					"cart_id" => $cart["id"]
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests newOrderFromCart">
		<h3>Shop::newOrderFromCart()</h3>
		<?

		if(1 && "newOrderFromCart – empty cart – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart_reference]);


				// ASSERT

				if(
					$test_user_id &&
					$cart && 
					isset($cart_reference) &&
					$order == false
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – empty cart – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – empty cart – return false – error</p></div>
				<? endif;


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – item without subscription method – return order, 'ordered'-callback, no 'subscribed'-callback") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add test item to cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];


				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);


				// ASSERT

				if(
					$order &&
					$order["items"] &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – item without subscription_method – return order, 'ordered'-callback, no 'subscribed'-callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – item without subscription_method – return order, 'ordered'-callback, no 'subscribed'-callback – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – pass cart and order_comment method – return order with comment") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add test item to cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				$_POST["order_comment"] = "Testing order comment";
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$order &&
					$order["comment"] == "Testing order comment" &&
					$order["items"] &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – pass cart and order_comment – return order with comment – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – pass cart and order_comment – return order with comment – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 1]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add test item to cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);


				// ASSERT

				if(
					$order &&
					$order["items"] &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback – error</p></div>
				<? endif;


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – cart_item with custom price – return order with custom price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add test item to cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);


				// ASSERT

				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] == 50 &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom price – return order with custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom price – return order with custom price – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add test item to cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 0;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);


				// ASSERT

				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] === "0" &&
					$order["status"] == 1 &&
					$order["payment_status"] == 2 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – cart_item with custom price with comma-seperated decimal – return order with custom price with period-seperated decimal") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add test item to cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = "50,5";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);


				// ASSERT

				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] === "50.5" &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom price with comma-seperated decimal – return order with custom price with period-seperated decimal – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom price with comma-seperated decimal – return order with custom price with period-seperated decimal – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – cart_item with custom price with period-seperated decimal – return order with custom price with comma-seperated decimal") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add test item to cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = "50.5";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);


				// ASSERT

				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] === "50.5" &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom price with period-seperated decimal – return order with custom price with comma-seperated decimal – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom price with period-seperated decimal – return order with custom price with comma-seperated decimal – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – cart_item with custom name – return order with custom name") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add test item to cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_name"] = "Testing custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);


				// ASSERT

				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["name"] == "Testing custom name" &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom name – return order with custom name – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom name – return order with custom name – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add test item to cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$_POST["custom_name"] = "Testing custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);


				// ASSERT

				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] == 50 &&
					$order["items"][0]["name"] == "Testing custom name" &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"] &&
					session()->value("test_item_ordered_callback") &&
					!session()->value("test_item_subscribed_callback") &&
					$order["id"]
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name– return order with correct prices and quantities ") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				// add cart
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_reference = $cart["cart_reference"];
				$test_cart_id = $cart["id"];

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 2;		
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$_POST["custom_name"] = "Testing custom name and custom price";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_name"] = "Testing only custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_reference]);


				// ASSERT

				if(
					$order &&
					$order["items"] &&
					count($order["items"]) == 4 &&
					$order["items"][0]["quantity"] == 1 &&
					$order["items"][0]["total_price"] == 100 &&
					$order["items"][0]["name"] == "Test item" &&
					$order["items"][1]["quantity"] == 2 &&
					$order["items"][1]["total_price"] == 100 &&
					$order["items"][1]["name"] == "Test item" &&
					$order["items"][2]["quantity"] == 1 &&
					$order["items"][2]["total_price"] == 50 &&
					$order["items"][2]["name"] == "Testing custom name and custom price" &&
					$order["items"][3]["quantity"] == 1 &&
					$order["items"][3]["total_price"] == 100 &&
					$order["items"][3]["name"] == "Testing only custom name" &&
					$order["status"] == 0 &&
					$order["payment_status"] == 0 &&
					$order["shipping_status"] == 0 &&
					$order["user_id"] &&
					$order["currency"] &&
					$order["country"]
					): ?>
				<div class="testpassed"><p>Shop::newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name – return order with correct prices and quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name – return order with correct prices and quantities – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();
		}

		?>
	</div>

	<div class="tests deleteItemtypeFromCart">
		<h3>Shop::deleteItemtypeFromCart()</h3>
		<? 

		if(1 && "deleteItemtypeFromCart – delete existing itemtype – return cart without deleted itemtype") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);
				$membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership", 
					"price" => 100
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->emptyCart("emptyCart");


				$_POST["item_id"] = $membership_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(array("addToCart"));
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(array("addToCart"));
				unset($_POST);

				$old_cart = $cart;

				$itemtype = "membership";

				$cart = $SC->deleteItemtypeFromCart($itemtype);


				// ASSERT 

				if(
					$cart
					&& $old_cart
					&& count($cart["items"]) == 1
					&& count($old_cart["items"]) == 2
					&& $cart["items"][0]["item_id"] == $test_item_id 
					&& $old_cart["items"][0]["item_id"] == $membership_item_id 
					&& $old_cart["items"][1]["item_id"] == $test_item_id 
				): ?>
				<div class="testpassed"><p>Shop::deleteItemtypeFromCart – delete existing itemtype – return cart without deleted itemtype – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::deleteItemtypeFromCart – delete existing itemtype – return cart without deleted itemtype – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["item_id" => $membership_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "deleteItemtypeFromCart – delete non-existing itemtype – return unchanged cart") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();

				$test_item_id = $test_model->createTestItem([
					"price" => 100
				]);
				$membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership", 
					"price" => 100
				]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->emptyCart("emptyCart");


				$_POST["item_id"] = $membership_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(array("addToCart"));
				unset($_POST);
				
				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(array("addToCart"));
				unset($_POST);

				$old_cart = $cart;

				$itemtype = "blabla";

				$cart = $SC->deleteItemtypeFromCart($itemtype);


				// ASSERT 

				if(
					$cart
					&& $old_cart
					&& count($cart["items"]) == 2
					&& count($old_cart["items"]) == 2
					&& $cart["items"][0]["item_id"] == $membership_item_id 
					&& $cart["items"][1]["item_id"] == $test_item_id 
					&& $old_cart["items"][0]["item_id"] == $membership_item_id 
					&& $old_cart["items"][1]["item_id"] == $test_item_id 
				): ?>
				<div class="testpassed"><p>Shop::deleteItemtypeFromCart – delete non-existing itemtype – return unchanged cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::deleteItemtypeFromCart – delete non-existing itemtype – return unchanged cart – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["item_id" => $membership_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "deleteItemtypeFromCart – delete existing itemtype that is not in cart – return unchanged cart") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();

				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->emptyCart("emptyCart");

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(array("addToCart"));
				unset($_POST);

				$old_cart = $cart;

				$itemtype = "membership";


				$cart = $SC->deleteItemtypeFromCart($itemtype);


				// ASSERT 

				if(
					$cart
					&& $old_cart
					&& count($cart["items"]) == 1
					&& count($old_cart["items"]) == 1
					&& $cart["items"][0]["item_id"] == $test_item_id 
					&& $old_cart["items"][0]["item_id"] == $test_item_id 
				): ?>
				<div class="testpassed"><p>Shop::deleteItemtypeFromCart – delete existing itemtype that is not in cart – return unchanged cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::deleteItemtypeFromCart – delete existing itemtype that is not in cart – return unchanged cart – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests selectPaymentMethodForCart">
		<h3>Shop::selectPaymentMethodForCart</h3>
		<? 

		if(1 && "selectPaymentMethodForCart – Stripe as payment method – Return 'PROCEED_TO_GATEWAY'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();

				$payment_methods = $this->paymentMethods();
				$payment_method = $payment_methods[arrayKeyValue($payment_methods, "gateway", "stripe")];


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addCart(["addCart"]);

				$_POST["cart_id"] = $cart["id"];
				$_POST["payment_method_id"] = $payment_method["id"];
				$result = $SC->selectPaymentMethodForCart(["selectPaymentMethodForCart"]);


				// ASSERT 

				if(
					$payment_methods &&
					$payment_method["gateway"] === "stripe" &&
					$result &&
					$result["status"] == "PROCEED_TO_GATEWAY"
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForCart – Stripe as payment method – Return 'PROCEED_TO_GATEWAY' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForCart – Stripe as payment method – Return 'PROCEED_TO_GATEWAY' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp(["user_id" => $test_user_id]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "selectPaymentMethodForCart – Non-public payment method – Return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();

				$payment_method_id = $test_model->createTestPaymentMethod([
					"state" => null
				]);

				$payment_method = $this->paymentMethods($payment_method_id);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addCart(["addCart"]);

				$_POST["cart_id"] = $cart["id"];
				$_POST["payment_method_id"] = $payment_method_id;
				$result = $SC->selectPaymentMethodForCart(["selectPaymentMethodForCart"]);
				unset($_POST);


				// ASSERT 

				if(
					$payment_method &&
					!$payment_method["state"] &&
					!$result
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForCart – Non-public payment method – Return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForCart – Non-public payment method – Return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"payment_method_id" => $payment_method_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "selectPaymentMethodForCart – Non-existing payment method – Return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addCart(["addCart"]);


				$_POST["cart_id"] = $cart["id"];
				$_POST["payment_method_id"] = 10000;
				$result = $SC->selectPaymentMethodForCart(["selectPaymentMethodForCart"]);


				// ASSERT 

				if(
					$result === false
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForCart – Non-existing payment method – Return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForCart – Non-existing payment method – Return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectPaymentMethodForCart – Non-credit card payment method – Return 'PROCEED_TO_RECEIPT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();

				$payment_method_id = $test_model->createTestPaymentMethod();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart"]);
				unset($_POST);

				$_POST["cart_id"] = $cart["id"];
				$_POST["payment_method_id"] = $payment_method_id;
				$result = $SC->selectPaymentMethodForCart(["selectPaymentMethodForCart"]);
				unset($_POST);


				// ASSERT 

				if(
					$result &&
					$result["status"] === "PROCEED_TO_RECEIPT"
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForCart – Non-credit card payment method – Return 'PROCEED_TO_RECEIPT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForCart – Non-credit card payment method – Return 'PROCEED_TO_RECEIPT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"payment_method_id" => $payment_method_id,
					"item_id" => $test_item_id,
					"user_id" => $test_user_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectPaymentMethodForCart – Empty cart – Return 'ORDER_FAILED'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart = $SC->addCart(["addCart"]);

				$payment_method_id = $test_model->createTestPaymentMethod();

				// ACT
				$_POST["cart_id"] = $cart["id"];
				$_POST["payment_method_id"] = $payment_method_id;
				$result = $SC->selectPaymentMethodForCart(["selectPaymentMethodForCart"]);
				unset($_POST);


				// ASSERT 

				if(
					$result
					&& $result["status"] == "ORDER_FAILED"
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForCart – Empty cart – Return 'ORDER_FAILED' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForCart – Empty cart – Return 'ORDER_FAILED' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"payment_method_id" => $payment_method_id,
					"user_id" => $test_user_id
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests selectUserPaymentMethodForCa1t">
		<h3>Shop::selectUserPaymentMethodForCart</h3>
		<? 

		if(1 && "selectUserPaymentMethodForCart – With payment method gateway – Return 'PROCEED_TO_INTENT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$UC = new User();

				$test_user_id = $test_model->createTestUser();

				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart = $SC->addToNewInternalCart($test_item_id);

				$payment_methods = $this->paymentMethods();
				$stripe_payment_method = $payment_methods[arrayKeyValue($payment_methods, "gateway", "stripe")];
				$stripe_payment_method_id = $stripe_payment_method ? $stripe_payment_method["id"] : false;

				$gateway_payment_method = payments()->processCardForCart($cart, "4242424242424242", "12", "34", "567");
				$gateway_payment_method_id = ($gateway_payment_method && isset($gateway_payment_method["card"]))? $gateway_payment_method["card"]["id"] : false;

				$user_payment_method_id = $UC->addPaymentMethod(["payment_method_id" => $stripe_payment_method_id]);


				// ACT
				$_POST["cart_id"] = $cart ? $cart["id"] : false;
				$_POST["payment_method_id"] = $stripe_payment_method_id;
				$_POST["user_payment_method_id"] = $user_payment_method_id;
				$_POST["gateway_payment_method_id"] = $gateway_payment_method_id;
				$result = $SC->selectUserPaymentMethodForCart(["selectUserPaymentMethodForCart"]);
				unset($_POST);


				// ASSERT 

				if(
					$stripe_payment_method_id &&
					$gateway_payment_method_id &&
					$user_payment_method_id &&
					$result &&
					$result["payment_gateway"] == "stripe" &&
					$result["status"] == "PROCEED_TO_INTENT" &&
					$result["gateway_payment_method_id"] == $gateway_payment_method_id &&
					$result["cart"] == $cart
				): ?>
				<div class="testpassed"><p>Shop::selectUserPaymentMethodForCart – With payment method gateway – Return 'PROCEED_TO_INTENT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectUserPaymentMethodForCart – With payment method gateway – Return 'PROCEED_TO_INTENT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectUserPaymentMethodForCart – No payment method gateway – Return 'PROCEED_TO_RECEIPT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$UC = new User();

				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart = $SC->addToNewInternalCart($test_item_id);

				$test_payment_method_id = $test_model->createTestPaymentMethod();
				$UC->addPaymentMethod(["payment_method_id" => $test_payment_method_id]);
				$user_payment_method = $UC->getPaymentMethods(["payment_method_id" => $test_payment_method_id]);


				$_POST["cart_id"] = $cart ? $cart["id"] : false;
				$_POST["payment_method_id"] = $test_payment_method_id;
				$_POST["user_payment_method_id"] = $user_payment_method ? $user_payment_method["id"] : false;
				$result = $SC->selectUserPaymentMethodForCart(["selectUserPaymentMethodForCart"]);
				unset($_POST);


				// ASSERT 

				if(
					$user_payment_method &&
					$result &&
					$result["order_no"] &&
					$result["status"] == "PROCEED_TO_RECEIPT"
				): ?>
				<div class="testpassed"><p>Shop::selectUserPaymentMethodForCart – No payment method gateway – Return 'PROCEED_TO_RECEIPT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectUserPaymentMethodForCart – No payment method gateway – Return 'PROCEED_TO_RECEIPT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"payment_method_id" => $test_payment_method_id,
					"item_id" => $test_item_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "selectUserPaymentMethodForCart – Emptied cart – Return 'ORDER_FAILED'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$UC = new User();

				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart = $SC->addToNewInternalCart($test_item_id);
				$cart_item = $SC->getCartItem($cart["cart_reference"], $test_item_id);
				$cart = $SC->deleteFromCart(["deleteFromCart", $cart["cart_reference"], $cart_item["id"]]);

				$test_payment_method_id = $test_model->createTestPaymentMethod();
				$UC->addPaymentMethod(["payment_method_id" => $test_payment_method_id]);
				$user_payment_method = $UC->getPaymentMethods(["payment_method_id" => $test_payment_method_id]);

				$_POST["cart_id"] = $cart["id"];
				$_POST["payment_method_id"] = $test_payment_method_id;
				$_POST["user_payment_method_id"] = $user_payment_method ? $user_payment_method["id"] : false;
				$result = $SC->selectUserPaymentMethodForCart(["selectUserPaymentMethodForCart"]);
				unset($_POST);


				// ASSERT

				if(
					$cart &&
					$test_payment_method_id &&
					$user_payment_method &&
					$result &&
					$result["status"] == "ORDER_FAILED"
				): ?>
				<div class="testpassed"><p>Shop::selectUserPaymentMethodForCart – Emptied cart – Return 'ORDER_FAILED' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectUserPaymentMethodForCart – Emptied cart – Return 'ORDER_FAILED' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"payment_method_id" => $test_payment_method_id,
					"item_id" => $test_item_id
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>
	
	<div class="tests selectPaymentMethodForOrder">
		<h3>Shop::selectPaymentMethodForOrder</h3>
		<? 

		if(1 && "selectPaymentMethodForOrder – Stripe as payment method – Return 'PROCEED_TO_GATEWAY'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addToNewInternalCart($test_item_id);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);

				$payment_methods = $this->paymentMethods();
				$stripe_payment_method = $payment_methods[arrayKeyValue($payment_methods, "gateway", "stripe")];

				$_POST["order_id"] = $order["id"];
				$_POST["payment_method_id"] = $stripe_payment_method["id"];
				$result = $SC->selectPaymentMethodForOrder(["selectPaymentMethodForOrder"]);


				// ASSERT 

				if(
					$cart &&
					$order &&
					$result &&
					$stripe_payment_method &&
					$result["status"] == "PROCEED_TO_GATEWAY" &&
					$result["order_no"] == $order["order_no"] &&
					$result["payment_gateway"] == "stripe"
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForOrder – Stripe as payment method – Return 'PROCEED_TO_GATEWAY' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForOrder – Stripe as payment method – Return 'PROCEED_TO_GATEWAY' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectPaymentMethodForOrder – Non-public payment method – Return false") {

			(function() {

				// ARRANGE
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);

				$payment_method_id = $test_model->createTestPaymentMethod([
					"state" => null
				]);

				$payment_method = $this->paymentMethods($payment_method_id);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addToNewInternalCart($test_item_id);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);


				$_POST["order_id"] = $order["id"];
				$_POST["payment_method_id"] = $payment_method["id"];
				$result = $SC->selectPaymentMethodForOrder(["selectPaymentMethodForOrder"]);


				// ASSERT 

				if(
					$cart &&
					$order &&
					$payment_method &&
					$result === false
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForOrder – Non-public payment method – Return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForOrder – Non-public payment method – Return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id,
					"payment_method_id" => $payment_method_id,
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectPaymentMethodForOrder – Non-existing payment method – Return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addToNewInternalCart($test_item_id);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);				

				$_POST["order_id"] = $order["id"];
				$_POST["payment_method_id"] = 10000;
				$result = $SC->selectPaymentMethodForOrder(["selectPaymentMethodForOrder"]);


				// ASSERT 

				if(
					$cart &&
					$order &&
					$result === false
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForOrder – Non-existing payment method – Return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForOrder – Non-existing payment method – Return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id, 
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectPaymentMethodForOrder – Non-credit card payment method – Return 'PROCEED_TO_RECEIPT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$test_user_id = $test_model->createTestUser();

				$payment_method_id = $test_model->createTestPaymentMethod();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addToNewInternalCart($test_item_id);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);	

				$_POST["order_id"] = $order["id"];
				$_POST["payment_method_id"] = $payment_method_id;
				$result = $SC->selectPaymentMethodForOrder(["selectPaymentMethodForOrder"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart &&
					$order &&
					$result &&
					$result["status"] === "PROCEED_TO_RECEIPT"
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForOrder – Non-credit card payment method – Return 'PROCEED_TO_RECEIPT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForOrder – Non-credit card payment method – Return 'PROCEED_TO_RECEIPT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"payment_method_id" => $payment_method_id,
					"item_id" => $test_item_id,
					"user_id" => $test_user_id, 
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests selectUserPaymentMethodForOrder">
		<h3>Shop::selectUserPaymentMethodForOrder</h3>
		<?

		if(1 && "selectUserPaymentMethodForOrder – With payment method gateway – Return 'PROCEED_TO_INTENT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$UC = new User();

				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart = $SC->addToNewInternalCart($test_item_id);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);	

				$payment_methods = $this->paymentMethods();
				$stripe_payment_method = $payment_methods[arrayKeyValue($payment_methods, "gateway", "stripe")];
				$stripe_payment_method_id = $stripe_payment_method ? $stripe_payment_method["id"] : false;

				$gateway_payment_method = payments()->processCardForCart($cart, "4242424242424242", "12", "34", "567");
				$gateway_payment_method_id = ($gateway_payment_method && $gateway_payment_method["card"])? $gateway_payment_method["card"]["id"] : false;

				$user_payment_method_id = $UC->addPaymentMethod(["payment_method_id" => $stripe_payment_method_id]);

				$_POST["order_id"] = $order ? $order["id"] : false;
				$_POST["payment_method_id"] = $stripe_payment_method_id;
				$_POST["user_payment_method_id"] = $user_payment_method_id;
				$_POST["gateway_payment_method_id"] = $gateway_payment_method_id;
				$result = $SC->selectUserPaymentMethodForOrder(["selectUserPaymentMethodForOrder"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart &&
					$order &&
					$stripe_payment_method_id &&
					$gateway_payment_method_id &&
					$user_payment_method_id &&
					$result &&
					$result["payment_gateway"] == "stripe" &&
					$result["status"] == "PROCEED_TO_INTENT" &&
					$result["gateway_payment_method_id"] == $gateway_payment_method_id &&
					$result["order"] == $order
				): ?>
				<div class="testpassed"><p>Shop::selectUserPaymentMethodForOrder – With payment method gateway – Return 'PROCEED_TO_INTENT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectUserPaymentMethodForOrder – With payment method gateway – Return 'PROCEED_TO_INTENT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_id" => $test_item_id,
					"user_id" => $test_user_id, 
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectUserPaymentMethodForOrder – No payment method gateway – Return 'PROCEED_TO_RECEIPT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$UC = new User();

				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addToNewInternalCart($test_item_id);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);	

				$test_payment_method_id = $test_model->createTestPaymentMethod();
				$UC->addPaymentMethod(["payment_method_id" => $test_payment_method_id]);
				$user_payment_method = $UC->getPaymentMethods(["payment_method_id" => $test_payment_method_id]);

				$_POST["order_id"] = $order ? $order["id"] : false;
				$_POST["payment_method_id"] = $test_payment_method_id;
				$_POST["user_payment_method_id"] = $user_payment_method ? $user_payment_method["id"] : false;
				$result = $SC->selectUserPaymentMethodForOrder(["selectUserPaymentMethodForOrder"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart &&
					$order &&
					$test_payment_method_id &&
					$user_payment_method &&
					$result &&
					$result["order_no"] &&
					$result["status"] == "PROCEED_TO_RECEIPT"
				): ?>
				<div class="testpassed"><p>Shop::selectUserPaymentMethodForOrder – No payment method gateway – Return 'PROCEED_TO_RECEIPT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectUserPaymentMethodForOrder – No payment method gateway – Return 'PROCEED_TO_RECEIPT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"payment_method_id" => $test_payment_method_id, 
					"item_id" => $test_item_id,
					"user_id" => $test_user_id,
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests selectPaymentMethodForOrders">
		<h3>Shop::selectPaymentMethodForOrders</h3>
		<? 

		if(1 && "selectPaymentMethodForOrders – Stripe as payment method – Return 'PROCEED_TO_GATEWAY'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();

				$test_item_id_1 = $test_model->createTestItem(["price" => 100]);
				$test_item_id_2 = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart_1 = $SC->addToNewInternalCart($test_item_id_1);
				$order_1 = $SC->newOrderFromCart(["newOrderFromCart", $cart_1["cart_reference"]]);

				$cart_2 = $SC->addToNewInternalCart($test_item_id_2);
				$order_2 = $SC->newOrderFromCart(["newOrderFromCart", $cart_2["cart_reference"]]);

				$order_ids = $order_1["id"].",".$order_1["id"];
				
				$payment_methods = $this->paymentMethods();
				$stripe_payment_method = $payment_methods[arrayKeyValue($payment_methods, "gateway", "stripe")];

				$_POST["order_ids"] = $order_ids;
				$_POST["payment_method_id"] = $stripe_payment_method["id"];
				$result = $SC->selectPaymentMethodForOrders(["selectPaymentMethodForOrders"]);


				// ASSERT 

				if(
					$cart_1 &&
					$cart_2 &&
					$order_1 &&
					$order_2 &&
					$stripe_payment_method &&
					$result &&
					$result["status"] == "PROCEED_TO_GATEWAY" &&
					$result["order_ids"] == $order_ids &&
					$result["payment_gateway"] == "stripe"
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForOrders – Stripe as payment method – Return 'PROCEED_TO_GATEWAY' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForOrders – Stripe as payment method – Return 'PROCEED_TO_GATEWAY' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2],
					"user_id" => $test_user_id,
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectPaymentMethodForOrders – Non-public payment method – Return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$test_user_id = $test_model->createTestUser();

				$test_item_id_1 = $test_model->createTestItem(["price" => 100]);
				$test_item_id_2 = $test_model->createTestItem(["price" => 100]);

				$payment_method_id = $test_model->createTestPaymentMethod([
					"state" => null
				]);

				$payment_method = $this->paymentMethods($payment_method_id);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart_1 = $SC->addToNewInternalCart($test_item_id_1);
				$order_1 = $SC->newOrderFromCart(["newOrderFromCart", $cart_1["cart_reference"]]);

				$cart_2 = $SC->addToNewInternalCart($test_item_id_2);
				$order_2 = $SC->newOrderFromCart(["newOrderFromCart", $cart_2["cart_reference"]]);

				$order_ids = $order_1["id"].",".$order_1["id"];

				$_POST["order_ids"] = $order_ids;
				$_POST["payment_method_id"] = $payment_method_id;
				$result = $SC->selectPaymentMethodForOrders(["selectPaymentMethodForOrders"]);


				// ASSERT 

				if(
					$cart_1 &&
					$cart_2 &&
					$order_1 &&
					$order_2 &&
					$payment_method &&
					!$payment_method["state"] &&
					$result === false
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForOrders – Non-public payment method – Return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForOrders – Non-public payment method – Return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2],
					"user_id" => $test_user_id,
					"payment_method_id" => $payment_method_id,
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectPaymentMethodForOrders – Non-existing payment method – Return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();

				$test_item_id_1 = $test_model->createTestItem(["price" => 100]);
				$test_item_id_2 = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart_1 = $SC->addToNewInternalCart($test_item_id_1);
				$order_1 = $SC->newOrderFromCart(["newOrderFromCart", $cart_1["cart_reference"]]);

				$cart_2 = $SC->addToNewInternalCart($test_item_id_2);
				$order_2 = $SC->newOrderFromCart(["newOrderFromCart", $cart_2["cart_reference"]]);

				$order_ids = $order_1["id"].",".$order_1["id"];		

				$_POST["order_ids"] = $order_ids;
				$_POST["payment_method_id"] = 10000;
				$result = $SC->selectPaymentMethodForOrders(["selectPaymentMethodForOrders"]);


				// ASSERT 

				if(
					$cart_1 &&
					$cart_2 &&
					$order_1 &&
					$order_2 &&
					$result === false
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForOrders – Non-existing payment method – Return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForOrders – Non-existing payment method – Return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2],
					"user_id" => $test_user_id,
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectPaymentMethodForOrders – Non-credit card payment method – Return 'PROCEED_TO_RECEIPT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$payment_method_id = $test_model->createTestPaymentMethod();

				$test_item_id_1 = $test_model->createTestItem(["price" => 100]);
				$test_item_id_2 = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart_1 = $SC->addToNewInternalCart($test_item_id_1);
				$order_1 = $SC->newOrderFromCart(["newOrderFromCart", $cart_1["cart_reference"]]);

				$cart_2 = $SC->addToNewInternalCart($test_item_id_2);
				$order_2 = $SC->newOrderFromCart(["newOrderFromCart", $cart_2["cart_reference"]]);

				$order_ids = $order_1["id"].",".$order_1["id"];		

				$_POST["order_ids"] = $order_ids;
				$_POST["payment_method_id"] = $payment_method_id;
				$result = $SC->selectPaymentMethodForOrders(["selectPaymentMethodForOrders"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart_1 &&
					$cart_2 &&
					$order_1 &&
					$order_2 &&
					$payment_method_id &&
					$result &&
					$result["status"] === "PROCEED_TO_RECEIPT"
				): ?>
				<div class="testpassed"><p>Shop::selectPaymentMethodForOrders – Non-credit card payment method – Return 'PROCEED_TO_RECEIPT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectPaymentMethodForOrders – Non-credit card payment method – Return 'PROCEED_TO_RECEIPT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"payment_method_id" => $payment_method_id, 
					"item_ids" => [$test_item_id_1, $test_item_id_2], 
					"user_id" => $test_user_id,
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests selectUserPaymentMethodForOrders">
		<h3>Shop::selectUserPaymentMethodForOrders</h3>
		<? 

		if(1 && "selectUserPaymentMethodForOrders – With payment method gateway – Return 'PROCEED_TO_INTENT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$UC = new User();

				$test_user_id = $test_model->createTestUser();

				$test_item_id_1 = $test_model->createTestItem(["price" => 100]);
				$test_item_id_2 = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart_1 = $SC->addToNewInternalCart($test_item_id_1);
				$order_1 = $SC->newOrderFromCart(["newOrderFromCart", $cart_1["cart_reference"]]);

				$cart_2 = $SC->addToNewInternalCart($test_item_id_2);
				$order_2 = $SC->newOrderFromCart(["newOrderFromCart", $cart_2["cart_reference"]]);

				$orders = [$order_1, $order_2];
				$order_ids = $order_1["id"].",".$order_2["id"];		

				$payment_methods = $this->paymentMethods();
				$stripe_payment_method = $payment_methods[arrayKeyValue($payment_methods, "gateway", "stripe")];
				$stripe_payment_method_id = $stripe_payment_method ? $stripe_payment_method["id"] : false;

				$gateway_payment_method = payments()->processCardForOrders($orders, "4242424242424242", "12", "34", "567");
				$gateway_payment_method_id = ($gateway_payment_method && $gateway_payment_method["card"])? $gateway_payment_method["card"]["id"] : false;

				$user_payment_method_id = $UC->addPaymentMethod(["payment_method_id" => $stripe_payment_method_id]);


				$_POST["order_ids"] = $order_ids;
				$_POST["payment_method_id"] = $stripe_payment_method_id;
				$_POST["user_payment_method_id"] = $user_payment_method_id;
				$_POST["gateway_payment_method_id"] = $gateway_payment_method_id;
				$result = $SC->selectUserPaymentMethodForOrders(["selectUserPaymentMethodForOrders"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart_1 &&
					$cart_2 &&
					$order_1 &&
					$order_2 &&
					$stripe_payment_method_id &&
					$gateway_payment_method_id &&
					$user_payment_method_id &&
					$result &&
					$result["payment_gateway"] == "stripe" &&
					$result["status"] == "PROCEED_TO_INTENT" &&
					$result["gateway_payment_method_id"] == $gateway_payment_method_id &&
					$result["orders"] == $orders 
				): ?>
				<div class="testpassed"><p>Shop::selectUserPaymentMethodForOrders – With payment method gateway – Return 'PROCEED_TO_INTENT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectUserPaymentMethodForOrders – With payment method gateway – Return 'PROCEED_TO_INTENT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"item_ids" => [$test_item_id_1, $test_item_id_2],
					"user_id" => $test_user_id,
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectUserPaymentMethodForOrders – No payment method gateway – Return 'PROCEED_TO_RECEIPT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$UC = new User();

				$test_user_id = $test_model->createTestUser();

				$test_item_id_1 = $test_model->createTestItem(["price" => 100]);
				$test_item_id_2 = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart_1 = $SC->addToNewInternalCart($test_item_id_1);
				$order_1 = $SC->newOrderFromCart(["newOrderFromCart", $cart_1["cart_reference"]]);

				$cart_2 = $SC->addToNewInternalCart($test_item_id_2);
				$order_2 = $SC->newOrderFromCart(["newOrderFromCart", $cart_2["cart_reference"]]);

				$orders = [$order_1, $order_2];
				$order_ids = $order_1["id"].",".$order_2["id"];	
				$order_nos = $order_1["order_no"].",".$order_2["order_no"];	

				$test_payment_method_id = $test_model->createTestPaymentMethod();
				$UC->addPaymentMethod(["payment_method_id" => $test_payment_method_id]);
				$user_payment_method = $UC->getPaymentMethods(["payment_method_id" => $test_payment_method_id]);

				$_POST["order_ids"] = $order_ids;
				$_POST["payment_method_id"] = $test_payment_method_id;
				$_POST["user_payment_method_id"] = $user_payment_method ? $user_payment_method["id"] : false;
				$result = $SC->selectUserPaymentMethodForOrders(["selectUserPaymentMethodForOrders"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart_1 &&
					$cart_2 &&
					$order_1 &&
					$order_2 &&
					$test_payment_method_id &&
					$user_payment_method &&
					$result &&
					$result["order_nos"] == $order_nos &&
					$result["status"] == "PROCEED_TO_RECEIPT"
				): ?>
				<div class="testpassed"><p>Shop::selectUserPaymentMethodForOrders – No payment method gateway – Return 'PROCEED_TO_RECEIPT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectUserPaymentMethodForOrders – No payment method gateway – Return 'PROCEED_TO_RECEIPT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"payment_method_id" => $test_payment_method_id,
					"item_ids" => [$test_item_id_1, $test_item_id_2],
					"user_id" => $test_user_id,
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests selectUserPaymentMethodForCart">
		<h3>Shop::selectUserPaymentMethodForCart</h3>
		<? 

		if(1 && "selectUserPaymentMethodForCart – With payment method gateway – Return 'PROCEED_TO_INTENT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$UC = new User();

				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart = $SC->addToNewInternalCart($test_item_id);

				$payment_methods = $this->paymentMethods();
				$stripe_payment_method = $payment_methods[arrayKeyValue($payment_methods, "gateway", "stripe")];
				$stripe_payment_method_id = $stripe_payment_method ? $stripe_payment_method["id"] : false;

				$gateway_payment_method = payments()->processCardForCart($cart, "4242424242424242", "12", "34", "567");
				$gateway_payment_method_id = ($gateway_payment_method && $gateway_payment_method["card"])? $gateway_payment_method["card"]["id"] : false;

				$user_payment_method_id = $UC->addPaymentMethod(["payment_method_id" => $stripe_payment_method_id]);


				// ACT
				$_POST["cart_id"] = $cart ? $cart["id"] : false;
				$_POST["payment_method_id"] = $stripe_payment_method_id;
				$_POST["user_payment_method_id"] = $user_payment_method_id;
				$_POST["gateway_payment_method_id"] = $gateway_payment_method_id;
				$result = $SC->selectUserPaymentMethodForCart(["selectUserPaymentMethodForCart"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart &&
					$stripe_payment_method_id &&
					$gateway_payment_method_id &&
					$user_payment_method_id &&
					$result &&
					$result["payment_gateway"] == "stripe" &&
					$result["status"] == "PROCEED_TO_INTENT" &&
					$result["gateway_payment_method_id"] == $gateway_payment_method_id &&
					$result["cart"] == $cart
				): ?>
				<div class="testpassed"><p>Shop::selectUserPaymentMethodForCart – With payment method gateway – Return 'PROCEED_TO_INTENT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectUserPaymentMethodForCart – With payment method gateway – Return 'PROCEED_TO_INTENT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectUserPaymentMethodForCart – No payment method gateway – Return 'PROCEED_TO_RECEIPT'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$UC = new User();

				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart = $SC->addToNewInternalCart($test_item_id);

				$test_payment_method_id = $test_model->createTestPaymentMethod();
				$UC->addPaymentMethod(["payment_method_id" => $test_payment_method_id]);
				$user_payment_method = $UC->getPaymentMethods(["payment_method_id" => $test_payment_method_id]);

				// ACT
				$_POST["cart_id"] = $cart ? $cart["id"] : false;
				$_POST["payment_method_id"] = $test_payment_method_id;
				$_POST["user_payment_method_id"] = $user_payment_method ? $user_payment_method["id"] : false;
				$result = $SC->selectUserPaymentMethodForCart(["selectUserPaymentMethodForCart"]);
				unset($_POST);
				
				
				// ASSERT 
				if(
					$cart &&
					$test_payment_method_id &&
					$user_payment_method &&
					$result &&
					$result["order_no"] &&
					$result["status"] == "PROCEED_TO_RECEIPT"
				): ?>
				<div class="testpassed"><p>Shop::selectUserPaymentMethodForCart – No payment method gateway – Return 'PROCEED_TO_RECEIPT' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectUserPaymentMethodForCart – No payment method gateway – Return 'PROCEED_TO_RECEIPT' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"payment_method_id" => $test_payment_method_id, 
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id,
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "selectUserPaymentMethodForCart – Empty cart – Return 'ORDER_FAILED'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$UC = new User();

				$test_user_id = $test_model->createTestUser();

				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart = $SC->addToNewInternalCart($test_item_id);
				$cart_item = $SC->getCartItem($cart["cart_reference"], $test_item_id);
				$cart = $SC->deleteFromCart(["deleteFromCart", $cart["cart_reference"], $cart_item["id"]]);

				$test_payment_method_id = $test_model->createTestPaymentMethod();
				$UC->addPaymentMethod(["payment_method_id" => $test_payment_method_id]);
				$user_payment_method = $UC->getPaymentMethods(["payment_method_id" => $test_payment_method_id]);

				// ACT
				$_POST["cart_id"] = $cart["id"];
				$_POST["payment_method_id"] = $test_payment_method_id;
				$_POST["user_payment_method_id"] = $user_payment_method ? $user_payment_method["id"] : false;
				$result = $SC->selectUserPaymentMethodForCart(["selectUserPaymentMethodForCart"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart &&
					$test_payment_method_id &&
					$user_payment_method &&
					$result &&
					$result["status"] == "ORDER_FAILED"
				): ?>
				<div class="testpassed"><p>Shop::selectUserPaymentMethodForCart – Empty cart – Return 'ORDER_FAILED' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::selectUserPaymentMethodForCart – Empty cart – Return 'ORDER_FAILED' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"payment_method_id" => $test_payment_method_id, 
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id,
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests processCardForCart">
		<h3>Shop::processCardForCart</h3>
		<? 

		if(1 && "processCardForCart – Valid card, valid cart – Return status 'success' and card object") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addToNewInternalCart($test_item_id);

				$_POST["card_number"] = 4242424242424242;
				$_POST["card_exp_month"] = "12";
				$_POST["card_exp_year"] = "30";
				$_POST["card_cvc"] = "123";
				$result = $SC->processCardForCart(["processCardForCart", "stripe", "cart", $cart["cart_reference"], "process"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart &&
					$result &&
					$result["status"] == "success" &&
					$result["type"] == "card" &&
					$result["card"]
					): ?>
				<div class="testpassed"><p>Shop::processCardForCart – Valid card, valid cart – Return status 'success' and card object – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::processCardForCart – Valid card, valid cart – Return status 'success' and card object – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "processCardForCart – Valid card, non-existing cart – Return false") {

			(function() {

				// ARRANGE

				$SC = new Shop();

				// ACT
				$_POST["card_number"] = 4242424242424242;
				$_POST["card_exp_month"] = "12";
				$_POST["card_exp_year"] = "30";
				$_POST["card_cvc"] = "123";
				$result = $SC->processCardForCart(["processCardForCart", "stripe", "cart", "invalid_cart_reference", "process"]);
				unset($_POST);


				// ASSERT 

				if(
					$result === false
				): ?>
				<div class="testpassed"><p>Shop::processCardForCart – Valid card, non-existing cart – Return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::processCardForCart – Valid card, non-existing cart – Return false – error</p></div>
				<? endif; 

				// CLEAN UP

				message()->resetMessages();

			})();

		}

		if(1 && "processCardForCart – Expired card, valid cart – Return status 'CARD_ERROR' and error code 'expired_card'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart = $SC->addToNewInternalCart($test_item_id);

				$_POST["card_number"] = 4000000000000069;
				$_POST["card_exp_month"] = "12";
				$_POST["card_exp_year"] = "30";
				$_POST["card_cvc"] = "123";
				$result = $SC->processCardForCart(["processCardForCart", "stripe", "cart", $cart["cart_reference"], "process"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart &&
					$result &&
					$result["status"] == "CARD_ERROR" &&
					$result["code"] == "expired_card"
				): ?>
				<div class="testpassed"><p>Shop::processCardForCart – Expired card, valid cart – Return status 'CARD_ERROR' and error code 'expired_card' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::processCardForCart – Expired card, valid cart – Return status 'CARD_ERROR' and error code 'expired_card' – error</p></div>
				<? endif; 

				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests processCardForOrder">
		<h3>Shop::processCardForOrder</h3>
		<?

		if(1 && "processCardForOrder – Valid card, valid order – Return status 'success' and order object") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart = $SC->addToNewInternalCart($test_item_id);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);

				$_POST["card_number"] = 4242424242424242;
				$_POST["card_exp_month"] = "12";
				$_POST["card_exp_year"] = "30";
				$_POST["card_cvc"] = "123";
				$result = $SC->processCardForOrder(["processCardForOrder", "stripe", "order", $order["order_no"], "process"]);
				unset($_POST);


				// ASSERT 

				if(
					$result &&
					$result["status"] == "success" &&
					$result["type"] == "card" &&
					$result["card"] &&
					$result["order"]
				): ?>
				<div class="testpassed"><p>Shop::processCardForOrder – Valid card, valid order – Return status 'success' and order object – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::processCardForOrder – Valid card, valid order – Return status 'success' and order object – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id,
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "processCardForOrder – Invalid card, valid order – Return status 'CARD_ERROR' and and decline code 'generic_decline'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addToNewInternalCart($test_item_id);
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);


				$_POST["card_number"] = 4000000000000002;
				$_POST["card_exp_month"] = "12";
				$_POST["card_exp_year"] = "30";
				$_POST["card_cvc"] = "123";
				$result = $SC->processCardForOrder(["processCardForOrder", "stripe", "order", $order["order_no"], "process"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart &&
					$order &&
					$result &&
					$result["status"] == "CARD_ERROR" &&
					$result["decline_code"] == "generic_decline"
				): ?>
				<div class="testpassed"><p>Shop::processCardForOrder – Invalid card, valid order – Return status 'CARD_ERROR' and and decline code 'generic_decline' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::processCardForOrder – Invalid card, valid order – Return status 'CARD_ERROR' and and decline code 'generic_decline' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id,
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "processCardForOrder – Valid card, invalid order – Return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart = $SC->addToNewInternalCart($test_item_id);


				$_POST["card_number"] = 4242424242424242;
				$_POST["card_exp_month"] = "12";
				$_POST["card_exp_year"] = "30";
				$_POST["card_cvc"] = "123";
				$result = $SC->processCardForOrder(["processCardForOrder", "stripe", "order", "THIS IS INVALID", "process"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart &&
					$result === false
				): ?>
				<div class="testpassed"><p>Shop::processCardForOrder – Valid card, invalid order – Return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::processCardForOrder – Valid card, invalid order – Return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id,
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests processCardForOrders">
		<h3>Shop::processCardForOrders</h3>
		<? 

		if(1 && "processCardForOrders – Valid card, valid orders – Return status 'success' and order objects") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);


				$cart_1 = $SC->addToNewInternalCart($test_item_id);
				$cart_2 = $SC->addToNewInternalCart($test_item_id);
				$order_1 = $SC->newOrderFromCart(["newOrderFromCart", $cart_1["cart_reference"]]);
				$order_2 = $SC->newOrderFromCart(["newOrderFromCart", $cart_2["cart_reference"]]);

				$order_ids = implode(",", [$order_1["id"], $order_2["id"]]);


				$_POST["card_number"] = 4242424242424242;
				$_POST["card_exp_month"] = "12";
				$_POST["card_exp_year"] = "30";
				$_POST["card_cvc"] = "123";
				$result = $SC->processCardForOrders(["processCardForOrders", "stripe", "order", $order_ids, "process"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart_1 &&
					$cart_2 &&
					$order_1 &&
					$order_2 &&
					$result &&
					$result["status"] == "success" &&
					$result["type"] == "card" &&
					$result["card"] &&
					$result["orders"] &&
					count($result["orders"]) == 2
				): ?>
				<div class="testpassed"><p>Shop::processCardForOrders – Valid card, valid orders – Return status 'success' and order objects – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::processCardForOrders – Valid card, valid orders – Return status 'success' and order objects – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id,
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "processCardForOrders – Invalid card, valid orders – Return status 'CARD_ERROR' and and decline code 'generic_decline'") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");


				$test_user_id = $test_model->createTestUser();
				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$cart_1 = $SC->addToNewInternalCart($test_item_id);
				$cart_2 = $SC->addToNewInternalCart($test_item_id);
				$order_1 = $SC->newOrderFromCart(["newOrderFromCart", $cart_1["cart_reference"]]);
				$order_2 = $SC->newOrderFromCart(["newOrderFromCart", $cart_2["cart_reference"]]);

				$order_ids = implode(",", [$order_1["id"], $order_2["id"]]);


				$_POST["card_number"] = 4000000000000002;
				$_POST["card_exp_month"] = "12";
				$_POST["card_exp_year"] = "30";
				$_POST["card_cvc"] = "123";
				$result = $SC->processCardForOrders(["processCardForOrders", "stripe", "order", $order_ids, "process"]);
				unset($_POST);


				// ASSERT 

				if(
					$cart_1 &&
					$cart_2 &&
					$order_1 &&
					$order_2 &&
					$result &&
					$result["status"] == "CARD_ERROR" &&
					$result["decline_code"] == "generic_decline"
				): ?>
				<div class="testpassed"><p>Shop::processCardForOrders – Invalid card, valid orders – Return status 'CARD_ERROR' and and decline code 'generic_decline' – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::processCardForOrders – Invalid card, valid orders – Return status 'CARD_ERROR' and and decline code 'generic_decline' – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
					"item_id" => $test_item_id,
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "processCardForOrders – Valid card, invalid orders – Return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$SC = new Shop();
				$current_user_id = session()->value("user_id");

				$test_user_id = $test_model->createTestUser();


				// ACT

				// Set users id in current session to mimic interaction on behalf of test user
				session()->value("user_id", $test_user_id);

				$_POST["card_number"] = 4000000000000002;
				$_POST["card_exp_month"] = "12";
				$_POST["card_exp_year"] = "30";
				$_POST["card_cvc"] = "123";
				$result = $SC->processCardForOrders(["processCardForOrders", "stripe", "order", "INVALID,INVALID", "process"]);
				unset($_POST);


				// ASSERT 

				if(
					$result === false
				): ?>
				<div class="testpassed"><p>Shop::processCardForOrders – Valid card, invalid orders – Return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::processCardForOrders – Valid card, invalid orders – Return false – error</p></div>
				<? endif; 


				// CLEAN UP

				// Restore user session
				session()->value("user_id", $current_user_id);

				$test_model->cleanUp([
					"user_id" => $test_user_id,
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>
</div>
