<div class="scene i:scene tests">
	<h1>SuperShop</h1>	
	<h2>Testing SuperShop class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests addToNewInternalCart">
		<h3>SuperShop::addToNewInternalCart</h3>
		<? 

		if(1 && "addToNewInternalCart – add test item – return cart with test item") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$test_user_id = $test_model->createTestUser();


				// ACT

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$cart &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["user_id"] == $test_user_id
				): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item – return cart with test item – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item – return cart with test item – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2)") {

			(function() {
					
				// ARRANGE
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$test_user_id = $test_model->createTestUser();

				// ACT

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "quantity" => 2]);


				// ASSERT 

				if(
					$cart &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["items"][0]["quantity"] == 2 &&
					$cart["user_id"] == $test_user_id
				): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2) – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item (quantity = 2) – return cart with test item (quantity = 2) – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item without price – return false") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();

				$test_item_id = $test_model->createTestItem();
				$test_user_id = $test_model->createTestUser();


				// ACT

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id]);


				// ASSERT 

				if(
					$cart == false &&
					$test_item_id &&
					$test_user_id
				): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item without price – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item without price – return false – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		if(1 && "addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item") {

			(function() {

				// ARRANGE

				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$test_user_id = $test_model->createTestUser();

				// ACT

				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id, "custom_name" => "Test item with custom name", "custom_price" => 50]);


				// ASSERT 

				if(
					$cart &&
					$cart["items"][0]["item_id"] == $test_item_id &&
					$cart["user_id"] == $test_user_id &&
					$cart["items"][0]["custom_price"] == 50 &&
					$cart["items"][0]["custom_name"] == "Test item with custom name"
				): ?>
				<div class="testpassed"><p>Shop::addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Shop::addToNewInternalCart – add test item with custom_name and custom_price – return cart with test item – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id, 
					"user_id" => $test_user_id
				]);
				message()->resetMessages();
	
			})();

		}

		?>
	</div>

	<div class="tests newOrderFromCart">
		<h3>SuperShop::newOrderFromCart()</h3>
		<?

		if(1 && "newOrderFromCart – empty cart – return false") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$user_id = $test_model->createTestUser();

				// add cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				$cart_id = $cart ? $cart["id"] : false;


				// ACT

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);


				// ASSERT

				if(
					$cart && 
					isset($cart_reference) &&
					$order == false
				): ?>
				<div class="testpassed"><p>SuperShop::newOrderFromCart – empty cart – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – empty cart – return false – error</p></div>
				<? endif;


				// CLEAN UP

				$test_model->cleanUp(["user_id" => $user_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – item without subscription method – return order, 'ordered'-callback, no 'subscribed'-callback") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				// print_r($cart);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ACT
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);


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
				<div class="testpassed"><p>SuperShop::newOrderFromCart – item without subscription_method – return order, 'ordered'-callback, no 'subscribed'-callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – item without subscription_method – return order, 'ordered'-callback, no 'subscribed'-callback – error</p></div>
				<? endif; 


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – pass cart and order_comment – return order with comment") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				// ACT
				$_POST["order_comment"] = "Testing order comment";
				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
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
				<div class="testpassed"><p>SuperShop::newOrderFromCart – pass cart and order_comment – return order with comment – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – pass cart and order_comment – return order with comment – error</p></div>
				<? endif; 


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem(["price" => 100, "subscription_method" => 1]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;

				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ACT

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);


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
				<div class="testpassed"><p>SuperShop::newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – item with subscription method – return order, 'ordered'-callback, 'subscribed'-callback – error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – item with subscription method, subscription already exists – return order, 'ordered'-callback, 'subscribed'-callback") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem([
					"price" => 100, 
					"subscription_method" => 1
				]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;

				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);


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
				<div class="testpassed"><p>SuperShop::newOrderFromCart – item with subscription method, subscription already exists – return order, 'ordered'-callback, 'subscribed'-callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – item with subscription method, subscription already exists – return order, 'ordered'-callback, 'subscribed'-callback – error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – cart_item with custom price – return order with custom price") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem(["price" => 100]);

				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ACT

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);


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
				<div class="testpassed"><p>SuperShop::newOrderFromCart – cart_item with custom price – return order with custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – cart_item with custom price – return order with custom price – error</p></div>
				<? endif; 


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid") {

			(function() {

				// ARRANGE
				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem(["price" => 100]);


				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 0;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ACT

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);


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
				<div class="testpassed"><p>SuperShop::newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – cart_item with custom price of 0 – return order with total_price of 0, status = 1, payment_status = paid – error</p></div>
				<? endif; 


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – cart_item with custom price with decimals – return order with custom price with decimals") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem(["price" => 100]);


				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50.5;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ACT

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);


				// ASSERT

				if(
					$order &&
					$order["items"] &&
					$order["items"][0]["total_price"] == 50.5 &&
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
				<div class="testpassed"><p>SuperShop::newOrderFromCart – cart_item with custom price with decimals – return order with custom price with decimals – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – cart_item with custom price with decimals – return order with custom price with decimals – error</p></div>
				<? endif; 


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – cart_item with custom name – return order with custom name") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem(["price" => 100]);


				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_name"] = "Testing custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ACT

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);


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
				<div class="testpassed"><p>SuperShop::newOrderFromCart – cart_item with custom name – return order with custom name – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – cart_item with custom name – return order with custom name – error</p></div>
				<? endif; 


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();
		}

		if(1 && "newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem(["price" => 100]);


				// add test item to cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$_POST["custom_name"] = "Testing custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ACT

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);


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
				<div class="testpassed"><p>SuperShop::newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – cart_item with custom name and custom price – return order with custom name and custom price – error</p></div>
				<? endif; 


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name– return order with correct prices and quantities ") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$user_id = $test_model->createTestUser();
				$item_id = $test_model->createTestItem(["price" => 100]);


				// add cart
				$_POST["user_id"] = $user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_id = $cart ? $cart["id"] : false;
				$cart_reference = $cart ? $cart["cart_reference"] : false;
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 2;		
				$_POST["custom_price"] = 50;
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);
				
				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_price"] = 50;
				$_POST["custom_name"] = "Testing custom name and custom price";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);

				$_POST["item_id"] = $item_id;
				$_POST["quantity"] = 1;		
				$_POST["custom_name"] = "Testing only custom name";
				$cart = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ACT

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);


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
				<div class="testpassed"><p>SuperShop::newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name – return order with correct prices and quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::newOrderFromCart – add item (1x standard price, 2x custom_price, 1x custom_price/custom_name, 1 custom_name – return order with correct prices and quantities – error</p></div>
				<? endif; 


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests getUnpaidOrders">
		<h3>SuperShop::getUnpaidOrders</h3>
		<?

		if(1 && "getUnpaidOrders (by correct user id)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["user_id" => $user_id]);
				if(
					$user_id &&
					$order &&
					$unpaid_orders &&
					$unpaid_orders[0]["user_id"] == $user_id &&
					$unpaid_orders[0]["order_no"] == $order["order_no"]
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct user id) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct user id) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by user id: 0, should return false)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 0]);
				if(
					$user_id &&
					$order &&
					!$unpaid_orders
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by user id: 0, should return false) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by user id: 0, should return false) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by wrong user id, should return false)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 100000]);
				if(
					$user_id &&
					$order &&
					!$unpaid_orders
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong user id, should return false) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong user id, should return false) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by correct itemtype)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["itemtype" => "membership"]);
				if(
					$user_id &&
					$order &&
					$unpaid_orders &&
					$unpaid_orders[0]["user_id"] == $user_id &&
					$unpaid_orders[0]["order_no"] == $order["order_no"]
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct itemtype) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct itemtype) - error</p></div>
				<? endif; 


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by wrong itemtype, should return false)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["itemtype" => "blabla"]);
				if (
					$user_id &&
					$order &&
					!$unpaid_orders
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong itemtype, should return false) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong itemtype, should return false) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by correct itemtype but not existing as order, should return false)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id_1 = $test_model->createTestItem([
					"itemtype" => "post",
					"price" => 100
				]);
				$item_id_2 = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id_2,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["itemtype" => "post"]);
				if (
					$user_id &&
					$order &&
					$item_id_1 &&
					$item_id_2 &&
					!$unpaid_orders
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct itemtype but not existing as order, should return false) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct itemtype but not existing as order, should return false) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_ids" => [$item_id_1, $item_id_2]
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by correct item id)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["item_id" => $item_id]);
				if(
					$user_id &&
					$order &&
					$item_id &&
					$unpaid_orders &&
					$unpaid_orders[0]["user_id"] == $user_id &&
					$unpaid_orders[0]["order_no"] == $order["order_no"]
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct item id) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct item id) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by item id: 0, should return false)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["item_id" => 0]);
				if (
					$user_id &&
					$order &&
					$item_id &&
					!$unpaid_orders 
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by item id: 0, should return false) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by item id: 0, should return false) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by wrong item id, should return false)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["item_id" => 1000000]);
				if(
					$user_id &&
					$order &&
					$item_id &&
					!$unpaid_orders 
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong item id, should return false) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong item id, should return false) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by correct user id and itemtype)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["user_id" => $user_id, "itemtype" => "membership"]);
				if (
					$user_id &&
					$order &&
					$item_id &&
					$unpaid_orders &&
					$unpaid_orders[0]["user_id"] == $user_id &&
					$unpaid_orders[0]["order_no"] == $order["order_no"]
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct user id and itemtype) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct user id and itemtype) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by correct user id and wrong itemtype, should return false)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["user_id" => $user_id, "itemtype" => "blabla"]);
				if (
					$user_id &&
					$order &&
					$item_id &&
					!$unpaid_orders
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct user id and wrong itemtype, should return false) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct user id and wrong itemtype, should return false) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by wrong user id and wrong itemtype, should return false)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 10000, "itemtype" => "blabla"]);
				if(
					$user_id &&
					$order &&
					$item_id &&
					!$unpaid_orders
				): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong user id and wrong itemtype, should return false) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong user id and wrong itemtype, should return false) - error</p></div>
				<? endif;


				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "getUnpaidOrders (by wrong user id and correct itemtype, should return false)") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$item_id = $test_model->createTestItem([
					"itemtype" => "membership",
					"price" => 100
				]);

				$user_id = $test_model->createTestUser();

				$order = $test_model->createTestOrder([
					"item_id" => $item_id,
					"user_id" => $user_id
				]);


				// ACT

				$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 10000, "itemtype" => "membership"]);
				if(
					$user_id &&
					$order &&
					$item_id &&
					!$unpaid_orders
					): ?>
				<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong user id and correct itemtype, should return false) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong user id and correct itemtype, should return false) - error</p></div>
				<? endif;
				

				// CLEAN UP

				session()->reset("test_item_ordered_callback");
				session()->reset("test_item_subscribed_callback");

				$test_model->cleanUp([
					"user_id" => $user_id, 
					"item_id" => $item_id
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests addCart">
		<h3>SuperShop::addCart</h3>
		<?

		if(1 && "addCart – internal cart – should return cart, no cart_reference in session") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				// clear cart reference from session
				session()->reset("cart_reference");


				// ACT

				$cart = $SC->addCart(["addCart"]);

			
				// ASSERT 

				$session_cart_reference = session()->value("cart_reference");
				if(
					$cart &&
					$cart["id"] &&
					!$session_cart_reference
				): ?>
				<div class="testpassed"><p>SuperShop::addCart – internal cart – should return cart, no cart_reference in session – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addCart – internal cart – should return cart, no cart_reference in session – error</p></div>
				<? endif; 
			

				// CLEAN UP

				$test_model->cleanUp([
					"cart_id" => $cart["id"], 
				]);
				// clear cart reference from session
				session()->reset("cart_reference");
				message()->resetMessages();


			})();

		}

		?>
	</div>

	<div class="tests cancelOrder">
		<h3>SuperShop::cancelOrder</h3>
		<?

		if(1 && "cancel order – ordered item with order_cancelled callback – return true, order status 3, make order_cancelled callback") {

			(function() {

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["price" => 400]);
				$test_user_id = $test_model->createTestUser();


				$cart = $SC->addToNewInternalCart($test_item_id, ["user_id" => $test_user_id]);

				$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);
				$order_id = $order ? $order["id"] : false;


				// ACT

				$result = $SC->cancelOrder(["cancelOrder", $order_id, $test_user_id]);
				$order = $SC->getOrders(["order_id" => $order_id]);


				// ASSERT 

				if(
					$cart &&
					$order &&
					$result &&
					session()->value("test_item_order_cancelled_callback") &&
					$order["status"] == 3
				): ?>
				<div class="testpassed"><p>SuperShop::cancelOrder – ordered item with order_cancelled callback – return true, order status 3, make order_cancelled callback – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::cancelOrder – ordered item with order_cancelled callback – return true, order status 3, make order_cancelled callback – error</p></div>
				<? endif; 


				// CLEAN UP

				session()->reset("test_item_order_cancelled");

				$test_model->cleanUp([
					"user_id" => $test_user_id, 
					"item_id" => $test_item_id
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests addToCart">
		<h3>SuperShop::addToCart()</h3>
		<?

		if(1 && "addToCart – add item without price – return false") {

			(function(){

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");
				
				$test_item_id = $test_model->createTestItem();


				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;


				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$result = $SC->addToCart(["addToCart", $cart_reference]);
				unset($_POST);


				// ASSERT

				if(
					$result === false &&
					$cart &&
					$cart_reference &&
					!$cart["items"]
				): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add item without price – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add item without price – return false – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id,
					"cart_id" => $cart["id"]
				]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add two different itemtypes to cart – return cart") {

			(function(){

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$membership_item_id = $test_model->createTestItem([
					"itemtype" => "membership", 
					"price" => 100
				]);

				$test_user_id = $test_model->createTestUser();


				$_POST["user_id"] =	$test_user_id; 
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;


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
				<div class="testpassed"><p>SuperShop::addToCart() – add two different itemtypes to cart – return cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add two different itemtypes to cart – return cart – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["item_id" => $membership_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["cart_id" => $cart["id"]]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add item that already exists in cart – return cart with updated quantity") {

			(function(){

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$test_user_id = $test_model->createTestUser();


				$_POST["user_id"] =	$test_user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;


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
				<div class="testpassed"><p>SuperShop::addToCart() – add item that already exists in cart – return cart with updated quantity – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add item that already exists in cart – return cart with updated quantity – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["cart_id" => $cart["id"]]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add item to non-existing cart – return false") {

			(function(){

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["price" => 100]);


				// ACT

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart"]);
				unset($_POST);


				if(
					$test_item_id &&
					$cart === false
				): ?>
				<div class="testpassed"><p>SuperShop::addToCart() – add item to non-existing cart – return false – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add item to non-existing cart – return false – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		if(1 && "addToCart – add item with custom_name and custom_price – return cart") {

			(function(){

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$test_user_id = $test_model->createTestUser();


				$_POST["user_id"] =	$test_user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;


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
				<div class="testpassed"><p>SuperShop::addToCart() – add item with custom_name and custom_price – return cart – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add item with custom_name and custom_price – return cart – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["cart_id" => $cart["id"]]);

			})();

		}

		if(1 && "addToCart – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items ") {

			(function(){

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$test_user_id = $test_model->createTestUser();


				$_POST["user_id"] =	$test_user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;


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
				<div class="testpassed"><p>SuperShop::addToCart() – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items  – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add item with standard price to cart that already contains an item of the same type but with a custom price – return cart with separated items  – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["cart_id" => $cart["id"]]);

			})();

		}

		if(1 && "addToCart – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities ") {

			(function(){

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$test_user_id = $test_model->createTestUser();


				$_POST["user_id"] =	$test_user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;


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
				<div class="testpassed"><p>SuperShop::addToCart() – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add the same item five times (2x standard price, 1x custom price A, 2x custom price B), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["cart_id" => $cart["id"]]);

			})();

		}

		if(1 && "addToCart – add the same item twice, one standard, and one with custom name – return cart with separated items") {

			(function(){

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$test_user_id = $test_model->createTestUser();


				$_POST["user_id"] =	$test_user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;


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
				<div class="testpassed"><p>SuperShop::addToCart() – add the same item twice, one standard, and one with custom name – return cart with separated items – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add the same item twice, one standard, and one with custom name – return cart with separated items – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["cart_id" => $cart["id"]]);

			})();

		}

		if(1 && "addToCart – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities ") {

			(function(){

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$test_user_id = $test_model->createTestUser();


				$_POST["user_id"] =	$test_user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;


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
				<div class="testpassed"><p>SuperShop::addToCart() – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – add the same item five times (2x standard, 1x custom name AAA, 2x custom name BBB), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["cart_id" => $cart["id"]]);

			})();

		}

		if(1 && "addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities") {

			(function(){

				// ARRANGE

				include_once("classes/shop/supershop.class.php");
				$SC = new SuperShop();
				$IC = new Items();
				$test_model = $IC->typeObject("tests");

				$test_item_id = $test_model->createTestItem(["price" => 100]);
				$test_user_id = $test_model->createTestUser();


				$_POST["user_id"] =	$test_user_id;
				$cart = $SC->addCart(["addCart"]);
				$cart_reference = $cart ? $cart["cart_reference"] : false;


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
				<div class="testpassed"><p>SuperShop::addToCart() – addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperShop::addToCart() – addToCart – add the same item 8 times (2x standard, 1x custom name AAA, 2x custom name BBB, 2x custom price 50, 1x custom price 75, 2x custom name AAA/custom price 50, 1x custom name BBB/custom price 50, 1x custom name AAA/custom price 75), in mixed order – return cart with separated items, with correct quantities – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				$test_model->cleanUp(["user_id" => $test_user_id]);
				$test_model->cleanUp(["cart_id" => $cart["id"]]);

			})();

		}

		?>
	</div>

</div>