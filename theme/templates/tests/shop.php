<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();

$UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'DA','Dansk'", "id = 'DA'");
$UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'EN','English'", "id = 'EN'");
$UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'DE','Deutch'", "id = 'DE'");

$UpgradeClass->checkDefaultValues(UT_CURRENCIES, "'DKK', 'Kroner (Denmark)', 'DKK', 'after', 2, ',', '.'", "id = 'DKK'");
$UpgradeClass->checkDefaultValues(UT_CURRENCIES, "'EUR', 'Euro (Denmark)', '€', 'before', 2, ',', '.'", "id = 'EUR'");

$UpgradeClass->checkDefaultValues(UT_COUNTRIES, "'DK', 'Danmark', '45', '#### ####', 'DA', 'DKK'", "id = 'DK'");
$UpgradeClass->checkDefaultValues(UT_COUNTRIES, "'DE', 'Deutchland', '49', '#### ####', 'DE', 'EUR'", "id = 'DE'");

$UpgradeClass->checkDefaultValues(UT_SUBSCRIPTION_METHODS, "DEFAULT, 'Month', 'monthly', DEFAULT", "name = 'Month'");
$UpgradeClass->checkDefaultValues(UT_VATRATES, "999, 'No VAT', 0, 'DK'", "id = 999");
$UpgradeClass->checkDefaultValues(UT_VATRATES, "998, '25%', 25, 'DK'", "id = 998");





$query = new Query();
$IC = new Items();

include_once("classes/shop/supershop.class.php");
$SC = new Shop();
$SSC = new SuperShop();
?>

<div class="scene i:scene tests defaultEdit">
	<h1>Shop</h1>	
	<h2>Testing Shop class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>Shop::addCart</h3>


		<? 	// addCart
			// ARRANGE
			$cart = false;

		?>
		<? 	// ACT 
		?>
		<? 	// ASSERT 
		if(
			$cart 
			): ?>
		<div class="testpassed"><p>Shop::addCart – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::addCart – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP

		?>

		<? 	// addCart – internal cart
			// ARRANGE
			$cart = false;

		?>
		<? 	// ACT 
		?>
		<? 	// ASSERT 
		if(
			$cart 
			): ?>
		<div class="testpassed"><p>Shop::addCart – internal cart – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::addCart – internal cart – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP

		?>

		<? 	// addCart – overwrite default values
			// ARRANGE
			$cart = false;

		?>
		<? 	// ACT 
		?>
		<? 	// ASSERT 
		if(
			$cart 
			): ?>
		<div class="testpassed"><p>Shop::addCart – overwrite default values – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::addCart – overwrite default values – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP

		?>

	</div>

	<div class="tests">
		<h3>Shop::addToNewInternalCart</h3>

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
		
		?>
		<? 	// ACT 
		$cart = $SC->addToNewInternalCart($item_id);
		$cart_id = $cart["id"];
		?>
		<? 	// ASSERT 
		if(
			$cart &&
			$cart["items"][0]["item_id"] == $item_id &&
			$cart["user_id"] == session()->value("user_id")
			): ?>
		<div class="testpassed"><p>Shop::addToNewInternalCart – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::addToNewInternalCart – error</p></div>
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

		?>
		<? 	// ACT 
		$cart = $SC->addToNewInternalCart($item_id);
		$cart_id = $cart["id"];	
		?>
		<? 	// ASSERT 
		if(
			$cart === false
			): ?>
		<div class="testpassed"><p>Shop::addToNewInternalCart – item has no price (should return false, no cart created) – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::addToNewInternalCart – item has no price (should return false, no cart created) – error</p></div>
		<? endif; ?>
		<? 	// CLEAN UP

		// delete test item
		$sql = "DELETE FROM ".SITE_DB.".items WHERE id = $item_id";
		$query->sql($sql);

		?>

	</div>


	<div class="tests">
		<h3>Shop::getCart()</h3>
		
		<? // SETUP

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
		?>
		
		<? 
		$cart = $SC->getCart();
		// debug([$cart]);
		?>
		
		
		<? if(
			$cart && 
			$cart["user_id"] == session()->value("user_id"))
		: ?>
		<div class="testpassed"><p>Shop::getCart - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::getCart - error</p></div>
		<? endif; ?>

	</div>
	

	<div class="tests">
		
		<h3>Shop::addToCart()</h3>
		<?
		// ADD ITEM WITHOUT PRICE
		$cart_id = $cart["id"];
		$cart = $SC->emptyCart("emptyCart");
		
		$item_id = $item["item_id"];
		$_POST["item_id"] = $item_id;
		$_POST["quantity"] = 1;
		
		$result = $SC->addToCart(["addToCart"]);
		unset($_POST);

		$cart = $SC->getCart();
		// debug([$cart]);

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
		$cart = $SC->emptyCart("emptyCart");
		
		$_POST["item_id"] = $membership["item_id"];
		$_POST["quantity"] = 1;
		
			
		$cart = $SC->addToCart(array("addToCart"));
		unset($_POST);
		
		
		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;

		$cart = $SC->addToCart(array("addToCart"));
		unset($_POST);
		
		if(
			$cart &&
			$cart["id"] &&
			$cart["user_id"] &&
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
		<div class="testfailed"><p>Shop::addToCart() - error</p></div>
		<? endif; 
		// goto cleanup;
		?>

		<?
		// ADD ALREADY EXISTING ITEM
		$cart = $SC->emptyCart("emptyCart");
		
		
		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;
		
		$cart = $SC->addToCart(["addToCart"]);
		$cart = $SC->addToCart(["addToCart"]);
		unset($_POST);
		
		if(
			$cart &&
			$cart["items"] &&
			$cart["items"][0]["quantity"] == 2 &&
			$cart["items"][0]["item_id"] == $item["item_id"] &&
			count($cart["items"]) == 1 &&
			$cart["id"] &&
			$cart["user_id"] &&
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
		$SSC->deleteCart(["deleteCart", $cart["id"], $cart["cart_reference"]]);
		$cart = false;

		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;
		
		$cart = $SC->addToCart(["addToCart"]);
		unset($_POST);


		if(
			$cart &&
			$cart["items"] &&
			$cart["items"][0]["quantity"] == 1 &&
			$cart["items"][0]["item_id"] == $item["item_id"] &&
			count($cart["items"]) == 1 &&
			$cart["id"] &&
			$cart["user_id"] &&
			$cart["cart_reference"] &&
			$cart["country"] &&
			$cart["currency"]	
			): ?>
		<div class="testpassed"><p>Shop::addToCart(), adding item to non-existing cart - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::addToCart(), adding item to non-existing cart - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>Shop::newOrderFromCart()</h3>
		<?
		// NEW ORDER FROM CART - REGULAR

		session()->reset("test_item_ordered_callback");

		// print_r($cart);
		$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
		$order_id = $order["id"];
		// print_r($order);


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
		<div class="testpassed"><p>Shop::newOrderFromCart - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::newOrderFromCart - error</p></div>
		<? endif; ?>


		<?
		// NEW ORDER FROM CART - EMPTY CART

		$SC->emptyCart(["emptyCart"]);
		session()->reset("test_item_ordered_callback");

		$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["cart_reference"]]);
		if(
			$cart &&
			isset($cart["cart_reference"]) && 
			$order == false
		): ?>
		<div class="testpassed"><p>Shop::newOrderFromCart, empty cart (should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::newOrderFromCart, empty cart (should return false) - error</p></div>
		<? endif; ?>

	</div>
	
	<div class="tests">
		<h3>Shop::deleteItemtypeFromCart()</h3>
		<?
		$cart = $SC->emptyCart("emptyCart");
		
		$_POST["item_id"] = $membership["item_id"];
		$_POST["quantity"] = 1;
		$cart = $SC->addToCart(array("addToCart"));
		unset($_POST);
		
		
		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;
		$cart = $SC->addToCart(array("addToCart"));
		unset($_POST);
		
		$itemtype = "membership";
		$cart = $SC->deleteItemtypeFromCart($itemtype);
	
		if(
			$membership["itemtype"] &&
			$membership["itemtype"] == "membership" &&
			$item["itemtype"] &&
			$item["itemtype"] == "tests" && 
			$itemtype &&
			$itemtype == "membership" &&
			$cart &&
			$cart["items"][0]["item_id"] != $membership["item_id"] &&
			$cart["items"][0]["item_id"] == $item["item_id"] &&
			count($cart["items"]) == 1
			): ?>
		<div class="testpassed"><p>Shop::deleteItemtypeFromCart, deleting existing itemtype from cart  - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::deleteItemtypeFromCart, deleting existing itemtype from cart - error</p></div>
		<? endif; ?>

		<?
		$cart = $SC->emptyCart("emptyCart");
		
		$_POST["item_id"] = $membership["item_id"];
		$_POST["quantity"] = 1;
		$cart = $SC->addToCart(array("addToCart"));
		unset($_POST);
		
		
		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;
		$cart = $SC->addToCart(array("addToCart"));
		unset($_POST);
		
		
		$itemtype = "blabla";
		$cart = $SC->deleteItemtypeFromCart($itemtype);
		
		if(
			$membership["itemtype"] &&
			$membership["itemtype"] == "membership" &&
			$item["itemtype"] &&
			$item["itemtype"] == "tests" && 
			$itemtype &&
			$itemtype == "blabla" &&
			$cart &&
			$cart["items"][0]["item_id"] == $membership["item_id"] &&
			$cart["items"][1]["item_id"] == $item["item_id"] &&
			count($cart["items"]) == 2
			): ?>
		<div class="testpassed"><p>Shop::deleteItemtypeFromCart, deleting non-existing itemtype from cart - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::deleteItemtypeFromCart, deleting non-existing itemtype from cart - error</p></div>
		<? endif; ?>
		
		
		<?
		$cart = $SC->emptyCart("emptyCart");
		
		$_POST["item_id"] = $membership["item_id"];
		$_POST["quantity"] = 1;
		$cart = $SC->addToCart(array("addToCart"));
		unset($_POST);
		
		
		$_POST["item_id"] = $item["item_id"];
		$_POST["quantity"] = 1;
		$cart = $SC->addToCart(array("addToCart"));
		unset($_POST);
		
		
		$itemtype = "post";
		$cart = $SC->deleteItemtypeFromCart($itemtype);
		
		if(
			$membership["itemtype"] &&
			$membership["itemtype"] == "membership" &&
			$item["itemtype"] &&
			$item["itemtype"] == "tests" && 
			$itemtype &&
			$itemtype == "post" &&
			$cart &&
			$cart["items"][0]["item_id"] == $membership["item_id"] &&
			$cart["items"][1]["item_id"] == $item["item_id"] &&
			count($cart["items"]) == 2
			): ?>
		<div class="testpassed"><p>Shop::deleteItemtypeFromCart, deleting existing itemtype from cart that is not in the cart - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::deleteItemtypeFromCart, deleting existing itemtype from cart that is not in the cart - error</p></div>
		<? endif; ?>
		
	</div>
	<?
		cleanup:
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

		skip_cleanup:
	?>
	
</div>
