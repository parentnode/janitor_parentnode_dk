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





$IC = new Items();
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


$SC = new Shop();
?>

<div class="scene i:scene tests defaultEdit">
	<h1>Shop</h1>	
	<h2>Testing Shop classs</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>Shop::getCart()</h3>
		<?
		$cart = $SC->getCart();
		
		if($cart): ?>
		<div class="testpassed"><p>Shop::getCart - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::getCart - error</p></div>
		<? endif; ?>


		<? if("Your test condition"): ?>
		<div class="testpassed"><p>#Class::method# - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>#Class::method# - error</p></div>
		<? endif; ?>
	
		<? if("Your test condition"): ?>
		<div class="testpassed"><p>#Class::method# - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>#Class::method# - error</p></div>
		<? endif; ?>
	</div>
	
	<div class="tests">
		
		<h3>Shop::addToCart()</h3>
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
		<? endif; ?>
	
		<? if("Your test condition"): ?>
		<div class="testpassed"><p>#Class::method# - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>#Class::method# - error</p></div>
		<? endif; ?>
	
		<? if("Your test condition"): ?>
		<div class="testpassed"><p>#Class::method# - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>#Class::method# - error</p></div>
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
	
</div>

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