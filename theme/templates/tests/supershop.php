<?
include_once("classes/shop/supershop.class.php");
include_once("classes/users/superuser.class.php");
$UC = new SuperUser();
$query = new Query();
$IC = new Items();
$SC = new SuperShop();
?>

<div class="scene i:scene tests">
	<h1>SuperShop</h1>	
	<h2>Testing SuperShop class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		
		<h3>SuperShop::addToCart()</h3>

		<?
		// SETUP

		$model_tests = $IC->typeObject("tests");
		// create test item
		$_POST["name"] = "Test item";
		$item = $model_tests->save(array("save"));
		// print_r($item);
		unset($_POST);
		// create test membership item
		$model_tests_membership = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership = $model_tests_membership->save(array("save"));
		// print_r($membership);
		unset($_POST);

		$cart = $SC->addCart(["addCart"]);
		// print_r($cart);
		$cart_reference = $cart["cart_reference"];

		?>
		

		<?
		// ADD ITEM WITHOUT PRICE
		
		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;
		
		$result = $SC->addToCart(["addToCart", $cart_reference]);
		unset($_POST);
		
		if(
			$result === false &&
			$cart &&
			!$cart["items"]
			): ?>
		<div class="testpassed"><p>Shop::addToCart(), adding item without price (should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::addToCart(), adding item without price (should return false) - error</p></div>
		
		<? endif; 
		
		// goto cleanup;
		?>

		<?
		// add prices to test item and membership item	
		$_POST["item_price"] = 100;
		$_POST["item_price_currency"] = "DKK";
		$_POST["item_price_vatrate"] = 1;
		$_POST["item_price_type"] = "default";
		$_POST["item_price_quantity"] = null;

		$model_tests_membership->addPrice(["addPrice", $membership["item_id"]]);
		$model_tests->addPrice(["addPrice", $item["item_id"]]);
		unset($_POST);
		?>
		
		
		<?
		// ADD TWO DIFFERENT ITEMTYPES
		$cart = $SC->emptyCart(["emptyCart", $cart_reference]);
		
		$_POST["item_id"] = $membership["item_id"];
		$_POST["quantity"] = 1;
		
		$cart = $SC->addToCart(["addToCart", $cart_reference]);
		unset($_POST);
		
		
		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;

		$cart = $SC->addToCart(["addToCart", $cart_reference]);
		unset($_POST);

		// debug(["cart with two different itemtypes", $cart]);
		
		if(
			$cart &&
			$cart["id"] &&
			$cart["cart_reference"] &&
			$cart["country"] &&
			$cart["currency"] &&
			$cart["items"] &&
			$cart["items"][1]["item_id"] == $item["item_id"] &&
			$cart["items"][0]["item_id"] == $membership["item_id"] &&
			$cart["items"][0]["quantity"] == 1 &&
			$cart["items"][1]["quantity"] == 1 &&
			$cart["items"][0]["id"] &&
			$cart["items"][1]["id"] &&
			$cart["items"][0]["cart_id"] &&
			$cart["items"][1]["cart_id"] &&
			count($cart["items"]) == 2
			): ?>
		<div class="testpassed"><p>Shop::addToCart(), adding two different itemtypes to cart - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::addToCart(), adding two different itemtypes to cart - error</p></div>
		<? endif; 
		// goto cleanup;
		?>

		<?
		// ADD ALREADY EXISTING ITEM
		
		$cart = $SC->emptyCart(["emptyCart", $cart_reference]);
		
		$_POST["item_id"] = $membership["item_id"];
		$_POST["quantity"] = 1;
		
		
		$cart = $SC->addToCart(["addToCart", $cart_reference]);
		$cart = $SC->addToCart(["addToCart", $cart_reference]);
		unset($_POST);
		
		// debug(["added already exisitng item to cart", $cart]);
		if(
			$cart &&
			$cart["items"] &&
			$cart["items"][0]["quantity"] == 2 &&
			$cart["items"][0]["item_id"] == $membership["item_id"] &&
			count($cart["items"]) == 1 &&
			$cart["id"] &&
			$cart["cart_reference"] &&
			$cart["country"] &&
			$cart["currency"]
			): ?>
		<div class="testpassed"><p>Shop::addToCart(), adding item that already exists in cart - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::addToCart(), adding item that already exists in cart - error</p></div>
		<? endif; 

		// goto cleanup;
		?>

		<? 
		// ADD ITEM TO NON-EXISTING CART
		$SC->deleteCart(["deleteCart", $cart["id"], $cart_reference]);
		$cart = false;

		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;
		
		$cart = $SC->addToCart(["addToCart"]);
		unset($_POST);


		if(
			$cart === false
			): ?>
		<div class="testpassed"><p>Shop::addToCart(), adding item to non-existing cart (should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::addToCart(), adding item to non-existing cart (should return false) - error</p></div>
		<? endif; ?>

		<?
		// // CLEAN UP
		// $model->delete(array("membership/delete/".$item_with_price["item_id"]));
		// $model->delete(array("membership/delete/".$item_without_price["item_id"]));
		
		// DELETE TEST ITEMS
		$item_id = $item["id"];
		$membership_id = $membership["id"];
		$query = new Query();
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $item_id";
		$query->sql($sql);
		// delete membership
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_id";
		$query->sql($sql);

		?>
	</div>

	<div class="tests">
		<h3>SuperShop::addToNewInternalCart</h3>

		<? 	// addToNewInternalCart
			// ARRANGE

		// create test item
		$model_tests = $IC->typeObject("tests");
		$_POST["name"] = "Test item";
		$item = $model_tests->save(array("save"));
		$item_id = $item["id"];
		
		// add price to test item
		$_POST["item_price"] = 100;
		$_POST["item_price_currency"] = "DKK";
		$_POST["item_price_vatrate"] = 1;
		$_POST["item_price_type"] = "default";
		$_POST["item_price_quantity"] = null;
		$model_tests->addPrice(["addPrice", $item_id]);
		unset($_POST);

		$user_id = session()->value("user_id");
		
		?>
		<? 	// ACT 
		$cart = $SC->addToNewInternalCart($item_id, ["user_id" => $user_id]);
		$cart_id = $cart["id"];
		?>
		<? 	// ASSERT 
		if(
			$cart &&
			$cart["items"][0]["item_id"] == $item_id &&
			$cart["user_id"] == session()->value("user_id")
			): ?>
		<div class="testpassed"><p>SuperShop::addToNewInternalCart – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::addToNewInternalCart – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP

		// delete test item
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $item_id";
		$query->sql($sql);

		// delete cart
		$sql = "DELETE FROM ".SITE_DB.".shop_carts WHERE id = $cart_id";
		$query->sql($sql);

		?>

		<? 	// addToNewInternalCart – item has no price (should return false)
			// ARRANGE

		// create test item
		$model_tests = $IC->typeObject("tests");
		$_POST["name"] = "Test item";
		$item = $model_tests->save(array("save"));
		$item_id = $item["id"];

		$user_id = session()->value("user_id");

		?>
		<? 	// ACT 
		$cart = $SC->addToNewInternalCart($item_id, ["user_id" => $user_id]);
		$cart_id = $cart["id"];	
		?>
		<? 	// ASSERT 
		if(
			$cart === false
			): ?>
		<div class="testpassed"><p>SuperShop::addToNewInternalCart – item has no price (should return false, no cart created) – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::addToNewInternalCart – item has no price (should return false, no cart created) – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP

		// delete test item
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $item_id";
		$query->sql($sql);

		?>

	</div>

	<div class="tests">
		<h3>SuperShop::newOrderFromCart()</h3>

		<?
		// SETUP

		// add test user
		$_POST["nickname"] = "test.parentnode@gmail.com";
		$_POST["user_group_id"] = 3;
		$user = $UC->save(["save"]);
		$user_id = $user["item_id"];
		unset($_POST);

		// create test item
		$model_tests = $IC->typeObject("tests");
		$_POST["name"] = "Test item";
		$item = $model_tests->save(array("save"));
		// print_r($item);
		unset($_POST);

		// create test membership item
		$model_tests_membership = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership = $model_tests_membership->save(array("save"));
		// print_r($membership);
		unset($_POST);


		// add prices to test items
		$_POST["item_price"] = 100;
		$_POST["item_price_currency"] = "DKK";
		$_POST["item_price_vatrate"] = 1;
		$_POST["item_price_type"] = "default";
		$_POST["item_price_quantity"] = null;

		$model_tests_membership->addPrice(["addPrice", $membership["item_id"]]);
		$model_tests->addPrice(["addPrice", $item["item_id"]]);
		unset($_POST);

		// add test item to cart
		$_POST["user_id"] = $user_id;
		$cart = $SC->addCart(["addCart"]);
		// print_r($cart);
		$cart_id = $cart["id"];
		$cart_reference = $cart["cart_reference"];
		unset($_POST);
		
		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;		
		$cart = $SC->addToCart(["addToCart", $cart_reference]);
		unset($_POST);
		?>

		<?
		// NEW ORDER FROM CART - ITEM WITHOUT SUBSCRIPTION METHOD
		
		session()->reset("test_item_ordered_callback");

		// print_r($cart);
		$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
		$order_id = $order["id"];
		// print_r($order);
		// debug($_SESSION);

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
			$order["id"]
			): ?>
		<div class="testpassed"><p>Shop::newOrderFromCart – item without subscription_method – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::newOrderFromCart – item without subscription_method – error</p></div>
		<? endif; ?>

		<?
		// NEW ORDER FROM CART - ITEM WITH SUBSCRIPTION METHOD
		
		session()->reset("test_item_ordered_callback");
		session()->reset("test_item_subscribed_callback");

		// add subscription method to test item
		$_POST["item_subscription_method"] = 1;
		$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item["item_id"]));
		unset($_POST);

		// add test item to cart
		$_POST["user_id"] = $user_id;
		$cart = $SC->addCart(["addCart"]);
		$cart_id = $cart["id"];
		$cart_reference = $cart["cart_reference"];
		unset($_POST);
		
		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;		
		$cart = $SC->addToCart(["addToCart", $cart_reference]);
		unset($_POST);
		
		// print_r($cart);
		$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
		$order_id = $order["id"];
		// print_r($order);
		// debug($_SESSION);

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
		<div class="testpassed"><p>Shop::newOrderFromCart – item with subscription_method – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::newOrderFromCart – item with subscription_method – error</p></div>
		<? endif; ?>


		<?
		// NEW ORDER FROM CART - EMPTY CART

		$SC->emptyCart(["emptyCart"]);
		session()->reset("test_item_ordered_callback");

		$order = $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
		if(
			$cart && 
			isset($cart["cart_reference"]) &&
			$order == false
		): ?>
		<div class="testpassed"><p>Shop::newOrderFromCart – empty cart – should return false – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::newOrderFromCart – empty cart – should return false – error</p></div>
		<? endif; ?>

		<?
		// // CLEAN UP
		// $model->delete(array("membership/delete/".$item_with_price["item_id"]));
		// $model->delete(array("membership/delete/".$item_without_price["item_id"]));
		
		// DELETE TEST ITEMS
		$item_id = $item["id"];
		$membership_id = $membership["id"];
		$query = new Query();
		
		// delete item
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $item_id";
		$query->sql($sql);
		// delete membership
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_id";
		$query->sql($sql);
		// delete order
		$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
		$query->sql($sql);
		// delete test user
		$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $user_id";
		$query->sql($sql);

		?>

	</div>

	<div class="tests">
		<h3>SuperShop::getUnpaidOrders</h3>
		<?
		// add test user
		$_POST["nickname"] = "testuser@test.com";
		$_POST["user_group_id"] = 3;
		$user = $UC->save(["save"]);
		unset($_POST);
		$user_id = $user["item_id"];
		// create test membership item
		$model = $IC->TypeObject("membership");
		$_POST["name"] = "Membership Test item";
		$membership = $model->save(array("save"));
		unset($_POST);
		$item_id = $membership["id"];

		$_POST["item_price"] = 100;
		$_POST["item_price_currency"] = "DKK";
		$_POST["item_price_vatrate"] = 1;
		$_POST["item_price_type"] = "default";
		$_POST["item_price_quantity"] = 1;
		$price = $model->addPrice(["addPrice", $item_id]);
		unset($_POST);
		 
		$_POST["user_id"] = $user_id;
		$cart = $SC->addCart(["addCart"]);
		$cart_id = $cart["id"];
		$cart_reference = $cart["cart_reference"];
		unset($_POST);
		
		$_POST["item_id"] = $item_id;
		$_POST["quantity"] = 1;
		$cart = $SC->addToCart(["addToCart", $cart_reference]);
		unset($_POST);

		$order =  $SC->newOrderFromCart(["newOrderFromCart", $cart_id, $cart_reference]);
		$order_id = $order["id"];

		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => $user_id]);
		if(
			$unpaid_orders &&
			$unpaid_orders[0]["user_id"] == $user_id &&
			$unpaid_orders[0]["order_no"] == $order["order_no"]
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct user id) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct user id) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 0]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by user id: 0, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by user id: 0, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 100000]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong user id, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong user id, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["itemtype" => "membership"]);
		if(
			$unpaid_orders &&
			$unpaid_orders[0]["user_id"] == $user_id &&
			$unpaid_orders[0]["order_no"] == $order["order_no"]
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct itemtype) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct itemtype) - error</p></div>
		<? endif; 
		$unpaid_orders = $SC->getUnpaidOrders(["itemtype" => "blabla"]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong itemtype, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong itemtype, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["itemtype" => "post"]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct itemtype but not existing as order, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct itemtype but not existing as order, should return false) - error</p></div>
		<? endif;

		$unpaid_orders = $SC->getUnpaidOrders(["item_id" => $item_id]);
		if(
			$unpaid_orders &&
			$unpaid_orders[0]["user_id"] == $user_id &&
			$unpaid_orders[0]["order_no"] == $order["order_no"]
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct item id) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct item id) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["item_id" => 0]);
		if(
			!$unpaid_orders 
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by item id: 0, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by item id: 0, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["item_id" => 1000000]);
		if(
			!$unpaid_orders 
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong item id, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong item id, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => $user_id, "itemtype" => "membership"]);
		if(
			$unpaid_orders &&
			$unpaid_orders[0]["user_id"] == $user_id &&
			$unpaid_orders[0]["order_no"] == $order["order_no"]
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct user id and itemtype) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct user id and itemtype) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => $user_id, "itemtype" => "blabla"]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by correct user id and wrong itemtype, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by correct user id and wrong itemtype, should return false) - error</p></div>
		<? endif;
		
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 10000, "itemtype" => "blabla"]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong user id and wrong itemtype, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong user id and wrong itemtype, should return false) - error</p></div>
		<? endif;
	
		$unpaid_orders = $SC->getUnpaidOrders(["user_id" => 10000, "itemtype" => "membership"]);
		if(
			!$unpaid_orders
			): ?>
		<div class="testpassed"><p>SuperShop::getUnpaidOrders (by wrong user id and correct itemtype, should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperShop::getUnpaidOrders (by wrong user id and correct itemtype, should return false) - error</p></div>
		<? endif;?>

		<?
		// // CLEAN UP
		// $model->delete(array("membership/delete/".$item_with_price["item_id"]));
		// $model->delete(array("membership/delete/".$item_without_price["item_id"]));
		
		// DELETE TEST ITEMS

			// delete user, order, item

		$item_id = $item["id"];
		$membership_id = $membership["id"];
		$query = new Query();

		// delete item
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $item_id";
		$query->sql($sql);

		// delete order
		$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
		$query->sql($sql);

		// delete membership
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $membership_id";
		$query->sql($sql);

		// delete user
		$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $user_id";
		$query->sql($sql);

		?>
		
	</div> 
	<div class="tests">
		<h3>SuperShop::addCart</h3>

		<? 	
		function addCart_internalCart_returnCartNoCartReferenceInSession() {
			// addCart – internal cart – should return cart, no cart_reference in session
				
			// ARRANGE
			$query = new Query();
			$SC = new SuperShop();

			$cart = false;

			// clear cart reference from session
			session()->reset("cart_reference");
			$session_cart_reference = session()->value("cart_reference");

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

			// delete cart
			$sql = "DELETE FROM ".SITE_DB.".shop_carts WHERE id = ".$cart["id"];
			$query->sql($sql);

			// clear cart reference from session
			session()->reset("cart_reference");

		}
		addCart_internalCart_returnCartNoCartReferenceInSession();
		?>

	</div>

</div>