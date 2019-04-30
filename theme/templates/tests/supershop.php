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
		$order = $SC->addOrder(["addOrder"]);
		unset($_POST);
		$order_id = $order["id"];
		$_POST["item_id"] = $item_id;
		$_POST["quantity"] = 1;
		$order = $SC->addToOrder(["addToOrder", $order_id]);
		unset($_POST);
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
	</div> 

</div>