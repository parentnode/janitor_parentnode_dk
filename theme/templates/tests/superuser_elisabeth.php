<?
include_once("classes/shop/supershop.class.php");
include_once("classes/users/superuser.class.php");
$UC = new SuperUser();
$query = new Query();
$IC = new Items();
$SC = new SuperShop();
?>

<div class="scene i:scene tests defaultEdit">
	<h1>User</h1>	
	<h2>Testing SuperUser class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>
	
	
	<div class="tests">
		<h3>SuperUser::cancel</h3>
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

		$result = $UC->cancel(["cancel", $user_id]);
		// print_r($result);
		
		if (
			$result["error"] == "unpaid_orders" 
			): ?>
			<div class="testpassed"><p>SuperUser::cancel (can not cancel due to unpaid orders. Should return ["error" => "unpaid_orders"]) - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperUser::cancel (can not cancel due to unpaid orders. Should return ["error" => "unpaid_orders"]) - error</p></div>
			<? endif; 
		
	
		$result = $UC->cancel(["cancel", "hej", "bla"]);
		
		if (
			!$result
			): ?>
			<div class="testpassed"><p>SuperUser::cancel (can not cancel due to too many action parameters) - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperUser::cancel (can not cancel due to too many action parameters) - error</p></div>
			<? endif; 
			
		$result = $UC->cancel([$user_id]);
		if (
			!$result
			): ?>
			<div class="testpassed"><p>SuperUser::cancel (can not cancel due to incorrect action parameters) - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperUser::cancel (can not cancel due to incorrect action parameters) - error</p></div>
			<? endif; 
		$new_user_id = 100;
		$result = $UC->cancel(["cancel", $new_user_id]);
		print_r($result);
		if (
			!$result
			): ?>
			<div class="testpassed"><p>SuperUser::cancel (non-exisiting user_id, returns false) - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperUser::cancel (non-exisiting user_id, returns false) - error</p></div>
			<? endif;
			
		$new_user_id = 0;
		$result = $UC->cancel(["cancel", $new_user_id]);
		print_r($result);
		if (
			!$result
			): ?>
			<div class="testpassed"><p>SuperUser::cancel (user_id: 0, returns false) - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperUser::cancel (user_id: 0, returns false) - error</p></div>
			<? endif;
		
		$_POST["order_id"] = $order_id;
		$_POST["payment_method"] = 1;
		$_POST["payment_amount"] = 100;
		$payment_id = $SC->registerPayment(["registerPayment"]);
		$result = $UC->cancel(["cancel", $user_id]);
		
		if (
			$result == true
			): ?>
			<div class="testpassed"><p>SuperUser::cancel (cancels user with no exisiting orders) - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperUser::cancel (cancels user with no exisiting orders) - error</p></div>
			<? endif; 
			
		//clean up
		$sql = "DELETE FROM ".SITE_DB.".users WHERE id = '$user_id";
		$query->sql($sql);
		$model->delete(array("delete", $item_id));
		$sql = "DELETE FROM ".SITE_DB.".shop_payments WHERE order_id = $order_id";
		$query->sql($sql);
		$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
		$query->sql($sql);