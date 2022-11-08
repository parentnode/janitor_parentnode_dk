<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();

include_once("classes/shop/supershop.class.php");
include_once("classes/users/superuser.class.php");



function countExistingUsers() {

	$query = new Query();
	$user_count = 0;

	$sql = "SELECT count(id) AS count FROM ".SITE_DB.".users WHERE id != 1";
	// debug([$sql]);
	if($query->sql($sql)) {
		$user_count = $query->result(0, "count");
	}
	return $user_count;
	
}

function createUserGroup($user_group) {

	$query = new Query();

	$sql = "INSERT INTO ".SITE_DB.".user_groups SET user_group = '$user_group'";
	// debug([$sql]);
	if($query->sql($sql)) {
		return $query->lastInsertId();
	}
	return false;
}
function deleteUserGroup($id) {

	$query = new Query();

	// delete user
	$sql = "DELETE FROM ".SITE_DB.".user_groups WHERE id = $id";
	if($query->sql($sql)) {
		return true;
	}

	return false;

}

function createUser($_options = false) {

	$user_group_id = 2;
	$nickname = "test_user_".randomKey(4);
	$status = 1;
	$created_at = false;

	$usernames = false;

	if($_options !== false) {
		foreach($_options as $_option => $_value) {
			switch($_option) {

				case "user_group_id"       : $user_group_id      = $_value; break;
				case "nickname"            : $nickname           = $_value; break;
				case "status"              : $status             = $_value; break;
				case "created_at"          : $created_at         = $_value; break;

				case "usernames"           : $usernames          = $_value; break;


			}
		}
	}

	$query = new Query();
	$test_user_id = false;


	$sql = "INSERT INTO ".SITE_DB.".users SET user_group_id = $user_group_id, nickname = '$nickname', status = $status".($created_at ? ", created_at = '$created_at'" : "");
	// debug([$sql]);
	if($query->sql($sql)) {
		$test_user_id = $query->lastInsertId();


		if($usernames) {
		
			foreach($usernames as $username) {

				$sql = "INSERT INTO ".SITE_DB.".user_usernames SET user_id = $test_user_id, username = '".$username["username"]."', type = '".$username["type"]."', verified = ".(isset($username["verified"]) ? $username["verified"] : 0).", verification_code = '".randomKey(8)."'";
				// debug(["sql", $sql, $username]);
				$query->sql($sql);
			}
		
		}

	}

	
	return $test_user_id;


	
}
function deleteUser($id) {

	$query = new Query();

	// delete user
	$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $id";
	// debug([$sql]);
	if($query->sql($sql)) {
		return true;
	}

	return false;

}


function createTestItem($_options = false) {

	$IC = new Items();

	$itemtype = "tests";
	$name = "Test item";

	$user_id = false;

	if($_options !== false) {
		foreach($_options as $_option => $_value) {
			switch($_option) {
				case "itemtype"            : $itemtype              = $_value; break;
				case "name"           : $name             = $_value; break;
				case "price"               : $price                 = $_value; break;
				case "subscription_method" : $subscription_method   = $_value; break;

				case "user_id" : $user_id   = $_value; break;
			}
		}
	}
	
	// create test item
	$model = $IC->TypeObject($itemtype);
	$_POST["name"] = $name;

	$item = $model->save(array("save"));
	$item_id = $item["id"];
	unset($_POST);

	if($item_id) {

		if(isset($price) && $price) {
			// add price to membership item
			$_POST["item_price"] = $price;
			$_POST["item_price_currency"] = "DKK";
			$_POST["item_price_vatrate"] = 2;
			$_POST["item_price_type"] = 1;
			$item_price = $model->addPrice(array("addPrice", $item_id));
			unset($_POST);

		}

		// Set owner
		if($user_id) {
			$_POST["item_ownership"] = $user_id;
			$model->updateOwner(["updateOwner", $item_id]);
			unset($_POST);
		}

		if(isset($subscription_method) && preg_match("/[1-3]/", $subscription_method)) {
			// add subscription method to second membership item
			$_POST["item_subscription_method"] = $subscription_method;
			$model->updateSubscriptionMethod(array("updateSubscriptionMethod", $item_id));
			unset($_POST);
		}

		return $item_id; 
	}

	return false;
}
function deleteTestItem($item_id) {

	$IC = new Items();
	$item = $IC->getItem(["id" => $item_id]);
	$itemtype = $item["itemtype"];
	$model = $IC->TypeObject($itemtype);

	
	return $model->delete(["delete",$item_id]);	

}

function createTestOrder($user_id, $item_id) {

	$SC = new SuperShop();

	$_POST["user_id"] = $user_id;
	$cart = $SC->addCart(["addCart"]);
	unset($_POST);

	$_POST["item_id"] = $item_id;
	$_POST["quantity"] = 1;
	$cart = $SC->addToCart(["addToCart", $cart["cart_reference"]]);
	unset($_POST);

	$order = $SC->newOrderFromCart(["newOrderFromCart", $cart["id"], $cart["cart_reference"]]);

	return $order["id"];

}
function deleteTestOrder($order_id) {

	$query = new Query();

	// delete order
	$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
	// debug([$sql]);
	if($query->sql($sql)) {
		return true;
	}

	return false;
	
}

function payTestOrder($order_id) {

	$SC = new SuperShop();
	$order_price = $SC->getTotalOrderPrice($order_id);

	global $page;
	$payment_methods = $page->paymentMethods();

	$_POST["order_id"] = $order_id;
	$_POST["payment_method_id"] = $payment_methods[0]["id"];
	$_POST["payment_amount"] = $order_price["price"];

	return $SC->registerPayment(["registerPayment"]);
	
}
function deleteTestPayment($payment_id) {

	$query = new Query();

	// delete payment
	$sql = "DELETE FROM ".SITE_DB.".shop_payments WHERE id = $payment_id";
	// debug([$sql]);
	if($query->sql($sql)) {
		return true;
	}

	return false;
	
}

?>

<div class="scene i:scene tests">
	<h1>SuperUser</h1>	
	<h2>Testing SuperUser class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<div class="tests">
		<h3>SuperUser::getUsers</h3>
		<?
		if(1 && "getUsers") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();

				// Count existing users
				$user_count = countExistingUsers();

				$test_user_group_id = createUserGroup("test-group");

				$test_user_id_1 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
				]);

				$test_user_id_2 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 2",
				]);

				$test_user_id_3 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 3",
					"status" => 0
				]);

				$users = $UC->getUsers();
				// debug([count($users), $users]);

				$test_user_1_index = arrayKeyValue($users, "id", $test_user_id_1);
				$test_user_2_index = arrayKeyValue($users, "id", $test_user_id_2);
				$test_user_3_index = arrayKeyValue($users, "id", $test_user_id_3);


				if(
					count($users) === ($user_count+3) &&

					$test_user_1_index !== false &&
					$users[$test_user_1_index]["nickname"] === "test user 1" &&
					$users[$test_user_1_index]["user_group_id"] == $test_user_group_id &&
					$users[$test_user_1_index]["status"] == 1 &&

					$test_user_2_index !== false &&
					$users[$test_user_2_index]["nickname"] === "test user 2" &&
					$users[$test_user_2_index]["user_group_id"] == $test_user_group_id &&
					$users[$test_user_2_index]["status"] == 1 &&

					$test_user_3_index !== false &&
					$users[$test_user_3_index]["nickname"] === "test user 3" &&
					$users[$test_user_3_index]["user_group_id"] == $test_user_group_id &&
					$users[$test_user_3_index]["status"] == 0

				): ?>
				<div class="testpassed"><p>SuperUser::getUsers – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUsers – error</p></div>
				<? endif; 


				// CLEAN UP
				deleteUser($test_user_id_1);
				deleteUser($test_user_id_2);
				deleteUser($test_user_id_3);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "getUsers – ordered") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();

				// Count existing users
				$user_count = countExistingUsers();

				$test_user_group_id = createUserGroup("test-group");

				$test_user_id_1 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "c test user 1",
				]);

				$test_user_id_2 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "b test user 2",
					"created_at" => date("Y-m-d H:i:s", strtotime("- 50 years")),
				]);

				$test_user_id_3 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "a test user 3",
					"status" => 0
				]);


				// By User group id
				$users_by_date = $UC->getUsers();

				$test_user_1_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_1);
				$test_user_2_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_2);
				$test_user_3_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_3);

				// debug([count($users_by_date), $users_by_date]);

				$users_by_name = $UC->getUsers(["order" => "nickname ASC"]);

				$test_user_1_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_1);
				$test_user_2_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_2);
				$test_user_3_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_3);

				// debug([count($users_by_name), $users_by_name]);



				if(
					count($users_by_date) === $user_count+3 &&

					$test_user_1_by_date_index < $test_user_2_by_date_index &&
					$test_user_1_by_date_index < $test_user_3_by_date_index &&
					$test_user_2_by_date_index > $test_user_3_by_date_index &&

					$test_user_1_by_name_index > $test_user_2_by_name_index &&
					$test_user_1_by_name_index > $test_user_3_by_name_index &&
					$test_user_2_by_name_index > $test_user_3_by_name_index

				): ?>
				<div class="testpassed"><p>SuperUser::getUsers ordered – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUsers ordered – error</p></div>
				<? endif; 


				// CLEAN UP
				deleteUser($test_user_id_1);
				deleteUser($test_user_id_2);
				deleteUser($test_user_id_3);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "getUsers by user_id") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();

				$test_user_group_id = createUserGroup("test-group");

				$test_user_id_1 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
				]);

				$test_user_id_2 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 2",
				]);

				$test_user_id_3 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 3",
					"status" => 0
				]);

				// By User id
				$user_1 = $UC->getUsers(["user_id" => $test_user_id_1]);
				$user_2 = $UC->getUsers(["user_id" => $test_user_id_2]);
				$user_3 = $UC->getUsers(["user_id" => $test_user_id_3]);
				// debug([$user_1, $user_2, $user_3]);


				if(

					$user_1 &&
					$user_1["nickname"] === "test user 1" &&
					$user_1["user_group_id"] == $test_user_group_id &&
					$user_1["status"] == 1 &&

					$user_2 &&
					$user_2["nickname"] === "test user 2" &&
					$user_2["user_group_id"] == $test_user_group_id &&
					$user_2["status"] == 1 &&

					$user_3 &&
					$user_3["nickname"] === "test user 3" &&
					$user_3["user_group_id"] == $test_user_group_id &&
					$user_3["status"] == 0

				): ?>
				<div class="testpassed"><p>SuperUser::getUsers by user_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUsers by user_id – error</p></div>
				<? endif; 


				// CLEAN UP
				deleteUser($test_user_id_1);
				deleteUser($test_user_id_2);
				deleteUser($test_user_id_3);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "getUsers by user_group_id") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();

				$test_user_group_id = createUserGroup("test-group");

				$test_user_id_1 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
				]);

				$test_user_id_2 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 2",
				]);

				$test_user_id_3 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 3",
					"status" => 0
				]);

				// By User group id
				$users = $UC->getUsers(["user_group_id" => $test_user_group_id]);
				// debug([count($users), $users]);

				$test_user_1_index = arrayKeyValue($users, "id", $test_user_id_1);
				$test_user_2_index = arrayKeyValue($users, "id", $test_user_id_2);
				$test_user_3_index = arrayKeyValue($users, "id", $test_user_id_3);


				if(
					count($users) === 3 &&

					$test_user_1_index !== false &&
					$users[$test_user_1_index]["nickname"] === "test user 1" &&
					$users[$test_user_1_index]["user_group_id"] == $test_user_group_id &&
					$users[$test_user_1_index]["status"] == 1 &&

					$test_user_2_index !== false &&
					$users[$test_user_2_index]["nickname"] === "test user 2" &&
					$users[$test_user_2_index]["user_group_id"] == $test_user_group_id &&
					$users[$test_user_2_index]["status"] == 1 &&

					$test_user_3_index !== false &&
					$users[$test_user_3_index]["nickname"] === "test user 3" &&
					$users[$test_user_3_index]["user_group_id"] == $test_user_group_id &&
					$users[$test_user_3_index]["status"] == 0

				): ?>
				<div class="testpassed"><p>SuperUser::getUsers by user_group_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUsers by user_group_id – error</p></div>
				<? endif; 


				// CLEAN UP
				deleteUser($test_user_id_1);
				deleteUser($test_user_id_2);
				deleteUser($test_user_id_3);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "getUsers by user_group_id – ordered") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();

				$test_user_group_id = createUserGroup("test-group");

				$test_user_id_1 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "c test user 1",
				]);

				$test_user_id_2 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "b test user 2",
					"created_at" => date("Y-m-d H:i:s", strtotime("- 50 years")),
				]);

				$test_user_id_3 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "a test user 3",
					"status" => 0
				]);


				// By User group id
				$users_by_date = $UC->getUsers(["user_group_id" => $test_user_group_id]);

				$test_user_1_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_1);
				$test_user_2_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_2);
				$test_user_3_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_3);

				// debug([count($users_by_date), $users_by_date]);

				$users_by_name = $UC->getUsers(["user_group_id" => $test_user_group_id, "order" => "nickname ASC"]);

				$test_user_1_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_1);
				$test_user_2_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_2);
				$test_user_3_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_3);

				// debug([count($users_by_name), $users_by_name]);



				if(
					count($users_by_date) === 3 &&

					$test_user_1_by_date_index === 0 &&
					$test_user_2_by_date_index === 2 &&
					$test_user_3_by_date_index === 1 &&

					$test_user_1_by_name_index === 2 &&
					$test_user_2_by_name_index === 1 &&
					$test_user_3_by_name_index === 0

				): ?>
				<div class="testpassed"><p>SuperUser::getUsers by user_group_id ordered – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUsers by user_group_id ordered – error</p></div>
				<? endif; 


				// CLEAN UP
				deleteUser($test_user_id_1);
				deleteUser($test_user_id_2);
				deleteUser($test_user_id_3);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		?>
	</div>

	<div class="tests">
		<h3>SuperUser::search</h3>
		<?

		if(1 && "search without query") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();

				// Count existing users
				$user_count = countExistingUsers();

				$test_user_group_id = createUserGroup("test-group");

				$test_user_id_1 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
				]);

				$test_user_id_2 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 2",
				]);

				$test_user_id_3 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 3",
					"status" => 0
				]);

				$users = $UC->search();
				// debug([count($users), $users]);

				$test_user_1_index = arrayKeyValue($users, "id", $test_user_id_1);
				$test_user_2_index = arrayKeyValue($users, "id", $test_user_id_2);
				$test_user_3_index = arrayKeyValue($users, "id", $test_user_id_3);


				if(
					count($users) === ($user_count+3) &&

					$test_user_1_index !== false &&
					$users[$test_user_1_index]["nickname"] === "test user 1" &&
					$users[$test_user_1_index]["user_group_id"] == $test_user_group_id &&
					$users[$test_user_1_index]["status"] == 1 &&

					$test_user_2_index !== false &&
					$users[$test_user_2_index]["nickname"] === "test user 2" &&
					$users[$test_user_2_index]["user_group_id"] == $test_user_group_id &&
					$users[$test_user_2_index]["status"] == 1 &&

					$test_user_3_index !== false &&
					$users[$test_user_3_index]["nickname"] === "test user 3" &&
					$users[$test_user_3_index]["user_group_id"] == $test_user_group_id &&
					$users[$test_user_3_index]["status"] == 0

				): ?>
				<div class="testpassed"><p>SuperUser::search (without query) – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::search (without query) – error</p></div>
				<? endif; 


				// CLEAN UP
				deleteUser($test_user_id_1);
				deleteUser($test_user_id_2);
				deleteUser($test_user_id_3);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "search – ordered") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();

				// Count existing users
				$user_count = countExistingUsers();

				$test_user_group_id = createUserGroup("test-group");

				$test_user_id_1 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "c test user 1",
				]);

				$test_user_id_2 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "b test user 2",
					"created_at" => date("Y-m-d H:i:s", strtotime("- 50 years")),
				]);

				$test_user_id_3 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "a test user 3",
					"status" => 0
				]);


				// By User group id
				$users_by_date = $UC->search();

				$test_user_1_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_1);
				$test_user_2_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_2);
				$test_user_3_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_3);

				// debug([count($users_by_date), $users_by_date]);

				$users_by_name = $UC->search(["pattern" => ["order" => "nickname ASC"]]);

				$test_user_1_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_1);
				$test_user_2_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_2);
				$test_user_3_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_3);

				// debug([count($users_by_name), $users_by_name]);



				if(
					count($users_by_date) === $user_count+3 &&

					$test_user_1_by_date_index < $test_user_2_by_date_index &&
					$test_user_1_by_date_index < $test_user_3_by_date_index &&
					$test_user_2_by_date_index > $test_user_3_by_date_index &&

					$test_user_1_by_name_index > $test_user_2_by_name_index &&
					$test_user_1_by_name_index > $test_user_3_by_name_index &&
					$test_user_2_by_name_index > $test_user_3_by_name_index

				): ?>
				<div class="testpassed"><p>SuperUser::search ordered – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::search ordered – error</p></div>
				<? endif; 


				// CLEAN UP
				deleteUser($test_user_id_1);
				deleteUser($test_user_id_2);
				deleteUser($test_user_id_3);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "search – ordered with query") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();

				// Count existing users
				$user_count = countExistingUsers();

				$test_user_group_id = createUserGroup("test-group");
				$test_key = randomKey(4);

				$test_user_id_1 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "c test user 1 - ".$test_key,
				]);

				$test_user_id_2 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "b test user 2 - ".$test_key,
					"created_at" => date("Y-m-d H:i:s", strtotime("- 50 years")),
				]);

				$test_user_id_3 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "a test user 3 - ".$test_key,
					"status" => 0
				]);


				// By User group id
				$users_by_date = $UC->search(["query" => $test_key]);

				$test_user_1_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_1);
				$test_user_2_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_2);
				$test_user_3_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_3);

				// debug([count($users_by_date), $users_by_date]);

				$users_by_name = $UC->search(["query" => $test_key, "pattern" => ["order" => "nickname ASC"]]);

				$test_user_1_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_1);
				$test_user_2_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_2);
				$test_user_3_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_3);

				// debug([count($users_by_name), $users_by_name]);


				if(

					$test_user_1_by_date_index < $test_user_2_by_date_index &&
					$test_user_1_by_date_index < $test_user_3_by_date_index &&
					$test_user_2_by_date_index > $test_user_3_by_date_index &&

					$test_user_1_by_name_index > $test_user_2_by_name_index &&
					$test_user_1_by_name_index > $test_user_3_by_name_index &&
					$test_user_2_by_name_index > $test_user_3_by_name_index

				): ?>
				<div class="testpassed"><p>SuperUser::search ordered with query – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::search ordered with query – error</p></div>
				<? endif; 


				// CLEAN UP
				deleteUser($test_user_id_1);
				deleteUser($test_user_id_2);
				deleteUser($test_user_id_3);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "search – ordered with query and user_group_id") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();

				// Count existing users
				$user_count = countExistingUsers();

				$test_user_group_id_1 = createUserGroup("test-group-1");
				$test_user_group_id_2 = createUserGroup("test-group-2");

				$test_key = randomKey(4);

				$test_user_id_1 = createUser([
					"user_group_id" => $test_user_group_id_1,
					"nickname" => "c test user 1 - ".$test_key,
				]);

				$test_user_id_2 = createUser([
					"user_group_id" => $test_user_group_id_1,
					"nickname" => "b test user 2 - ".$test_key,
					"created_at" => date("Y-m-d H:i:s", strtotime("- 50 years")),
				]);

				$test_user_id_3 = createUser([
					"user_group_id" => $test_user_group_id_2,
					"nickname" => "a test user 3 - ".$test_key,
					"status" => 0
				]);


				// By query and User group id
				$users_by_date = $UC->search(["query" => $test_key, "pattern" => ["user_group_id" => $test_user_group_id_1]]);

				$test_user_1_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_1);
				$test_user_2_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_2);
				$test_user_3_by_date_index = arrayKeyValue($users_by_date, "id", $test_user_id_3);

				// debug([count($users_by_date), $users_by_date]);

				$users_by_name = $UC->search(["query" => $test_key, "pattern" => ["user_group_id" => $test_user_group_id_1, "order" => "nickname ASC"]]);

				$test_user_1_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_1);
				$test_user_2_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_2);
				$test_user_3_by_name_index = arrayKeyValue($users_by_name, "id", $test_user_id_3);

				// debug([count($users_by_name), $users_by_name]);


				if(
					count($users_by_date) == 2 && 
					$test_user_1_by_date_index < $test_user_2_by_date_index &&
					!$test_user_3_by_name_index &&

					count($users_by_name) == 2 && 
					$test_user_1_by_name_index > $test_user_2_by_name_index &&
					!$test_user_3_by_name_index

				): ?>
				<div class="testpassed"><p>SuperUser::search ordered with query and user_group_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::search ordered with query and user_group_id – error</p></div>
				<? endif; 


				// CLEAN UP
				deleteUser($test_user_id_1);
				deleteUser($test_user_id_2);
				deleteUser($test_user_id_3);

				deleteUserGroup($test_user_group_id_1);
				deleteUserGroup($test_user_group_id_2);

				message()->resetMessages();

			})();
		}

		?>
	</div>

	<div class="tests">
		<h3>SuperUser::getUsernames</h3>

		<? 

		if(1 && "getUsernames for user_id") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$result = $UC->getUsernames(["user_id" => $test_user_id]);
				// debug([$result]);
	
				$test_username_1 = arrayKeyValue($result, "username", "test.parentnode@gmail.com");
				$test_username_2 = arrayKeyValue($result, "username", "test2.parentnode@gmail.com");
				$test_username_3 = arrayKeyValue($result, "username", "11223344");
	
				if(
					$result && 
					count($result) == 3 &&
					
					$test_username_1 !== false &&
					$result[$test_username_1]["type"] === "email" &&
					$result[$test_username_1]["verified"] == 0 &&

					$test_username_2 !== false &&
					$result[$test_username_2]["type"] === "email" &&
					$result[$test_username_2]["verified"] == 1 &&

					$test_username_3 !== false &&
					$result[$test_username_3]["type"] === "mobile" &&
					$result[$test_username_3]["verified"] == 0

				):?>
				<div class="testpassed"><p>SuperUser::getUsernames, get all usernames for user_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUsernames, get all usernames for user_id – error</p></div>
				<? endif;


				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "getUsername type for user_id") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$result_1 = $UC->getUsernames(["user_id" => $test_user_id, "type" => "mobile"]);

				$result_2 = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);
				// debug([$result]);
		
				if(
					$result_1 && 
					
					$result_1["username"] === "11223344" &&
					$result_1["verified"] == 0 &&

					$result_2 && 
				
					$result_2["username"] === "test2.parentnode@gmail.com" &&
					$result_2["verified"] == 1

				):?>
				<div class="testpassed"><p>SuperUser::getUsernames, get username of type for user_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUsernames, get username of type for user_id – error</p></div>
				<? endif;


				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "getUsername by username_id") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$result = $UC->getUsernames(["user_id" => $test_user_id]);
				// debug([$result]);
	
				$test_username_1 = arrayKeyValue($result, "username", "test2.parentnode@gmail.com");
				$username_id_1 = $result[$test_username_1]["id"];

				$result_1 = $UC->getUsernames(["username_id" => $username_id_1]);

				$test_username_2 = arrayKeyValue($result, "username", "11223344");
				$username_id_2 = $result[$test_username_2]["id"];

				$result_2 = $UC->getUsernames(["username_id" => $username_id_2]);
		
				if(
					$result_1 && 
					
					$result_1["username"] === "test2.parentnode@gmail.com" &&
					$result_1["verified"] == 1 &&

					$result_2 && 
				
					$result_2["username"] === "11223344" &&
					$result_2["verified"] == 0

				):?>
				<div class="testpassed"><p>SuperUser::getUsernames, get specific username by username_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUsernames, get specific username by username_id – error</p></div>
				<? endif;


				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		?>
	</div>

	<div class="tests">
		<h3>SuperUser::getUnverifiedUsernames</h3>

		<? 

		if(1 && "getUnverifiedUsernames") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$result = $UC->getUnverifiedUsernames();
				// debug([$result]);
	
				$test_username_1 = arrayKeyValue($result, "username", "test.parentnode@gmail.com");
				$test_username_2 = arrayKeyValue($result, "username", "test2.parentnode@gmail.com");
				$test_username_3 = arrayKeyValue($result, "username", "11223344");
	
				if(
					$result && 
					count($result) >= 2 &&

					$test_username_1 !== false &&
					$result[$test_username_1]["username"] === "test.parentnode@gmail.com" &&
					$result[$test_username_1]["type"] === "email" &&

					$test_username_2 === false &&

					$test_username_3 !== false &&
					$result[$test_username_3]["username"] === "11223344" &&
					$result[$test_username_3]["type"] === "mobile"

				):?>
				<div class="testpassed"><p>SuperUser::getUnverifiedUsernames, get all unverified usernames – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUnverifiedUsernames, get all unverified usernames – error</p></div>
				<? endif;


				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "getUnverifiedUsernames by type") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$result = $UC->getUnverifiedUsernames(["type" => "email"]);
				// debug([$result]);
	
				$test_username_1 = arrayKeyValue($result, "username", "test.parentnode@gmail.com");
				$test_username_2 = arrayKeyValue($result, "username", "test2.parentnode@gmail.com");
				$test_username_3 = arrayKeyValue($result, "username", "11223344");
	
				if(
					$result && 
					count($result) >= 1 &&

					$test_username_1 !== false &&
					$result[$test_username_1]["username"] === "test.parentnode@gmail.com" &&
					$result[$test_username_1]["type"] === "email" &&

					$test_username_2 === false &&

					$test_username_3 === false

				):?>
				<div class="testpassed"><p>SuperUser::getUnverifiedUsernames all by type – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUnverifiedUsernames all by type – error</p></div>
				<? endif;


				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "getUnverifiedUsernames by user_id") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$result = $UC->getUnverifiedUsernames(["user_id" => $test_user_id]);
				// debug([$result]);
	
				$test_username_1 = arrayKeyValue($result, "username", "test.parentnode@gmail.com");
				$test_username_2 = arrayKeyValue($result, "username", "test2.parentnode@gmail.com");
				$test_username_3 = arrayKeyValue($result, "username", "11223344");
	
				if(
					$result && 
					count($result) == 2 &&

					$test_username_1 !== false &&
					$result[$test_username_1]["username"] === "test.parentnode@gmail.com" &&
					$result[$test_username_1]["type"] === "email" &&

					$test_username_2 === false &&

					$test_username_3 !== false &&
					$result[$test_username_3]["username"] === "11223344" &&
					$result[$test_username_3]["type"] === "mobile"

				):?>
				<div class="testpassed"><p>SuperUser::getUnverifiedUsernames by user_id – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUnverifiedUsernames by user_id – error</p></div>
				<? endif;


				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "getUnverifiedUsernames by type") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$result = $UC->getUnverifiedUsernames(["user_id" => $test_user_id, "type" => "email"]);
				// debug([$result]);
	
				$test_username_1 = arrayKeyValue($result, "username", "test.parentnode@gmail.com");
				$test_username_2 = arrayKeyValue($result, "username", "test2.parentnode@gmail.com");
				$test_username_3 = arrayKeyValue($result, "username", "11223344");
	
				if(
					$result && 
					count($result) == 1 &&

					$test_username_1 !== false &&
					$result[$test_username_1]["username"] === "test.parentnode@gmail.com" &&
					$result[$test_username_1]["type"] === "email" &&

					$test_username_2 === false &&

					$test_username_3 === false

				):?>
				<div class="testpassed"><p>SuperUser::getUnverifiedUsernames all by type – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getUnverifiedUsernames all by type – error</p></div>
				<? endif;


				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		?>

	</div>

	<div class="tests">
		<h3>SuperUser::sendVerificationLink</h3>

		<?

		if(1 && "sendVerificationLink") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
					]
				]);

				$usernames = $UC->getUsernames(["user_id" => $test_user_id]);
				// debug([$result]);

				$test_username_1 = arrayKeyValue($usernames, "username", "test.parentnode@gmail.com");
				$username_id_1 = $usernames[$test_username_1]["id"];

				$result = $UC->sendVerificationLink(["sendVerificationLink", $username_id_1]);

				if(
					$result && 

					isset($result["verified"]) &&
					$result["verified"] == 0 &&

					isset($result["total_reminders"]) &&
					$result["total_reminders"] == 1 &&

					isset($result["reminded_at"]) &&
					date("Y-m-d", strtotime($result["reminded_at"])) === date("Y-m-d")

				):?>
				<div class="testpassed"><p>SuperUser::sendVerificationLink – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::sendVerificationLink – error</p></div>
				<? endif;


				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		?>

	</div>

	<div class="tests">
		<h3>SuperUser::getVerificationStatus</h3>

		<? 

		if(1 && "getVerificationStatus") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$usernames = $UC->getUsernames(["user_id" => $test_user_id]);
				// debug([$usernames]);
	
				$test_username_1 = arrayKeyValue($usernames, "username", "test2.parentnode@gmail.com");
				$username_id_1 = $usernames[$test_username_1]["id"];

				$test_username_2 = arrayKeyValue($usernames, "username", "11223344");
				$username_id_2 = $usernames[$test_username_2]["id"];


				$result_1 = $UC->getVerificationStatus($username_id_1, $test_user_id);
				$result_2 = $UC->getVerificationStatus($username_id_2, $test_user_id);



				if(
					$result_1 && 

					$result_1["verified"] == 1 &&
					isset($result_1["total_reminders"]) &&
					$result_1["total_reminders"] == 0 &&

					$result_2 && 
				
					$result_2["verified"] == 0 &&
					isset($result_2["total_reminders"]) &&
					$result_2["total_reminders"] == 0

				):?>
				<div class="testpassed"><p>SuperUser::getVerificationStatus – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::getVerificationStatus – error</p></div>
				<? endif;


				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		?>

	</div>

	<div class="tests">
		<h3>SuperUser::setVerificationStatus</h3>

		<? 

		if(1 && "setVerificationStatus - from 0 to 1") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0]
					]
				]);

				$username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);
				// debug([$username]);
	

				// update from 0 to 1
				$result = $UC->setVerificationStatus($username["id"], $test_user_id, 1);

				if(
					isset($result["verification_status"]) &&
					$result["verification_status"] == "VERIFIED"
				): ?>
				<div class="testpassed"><p>SuperUser::setVerificationStatus, update from 0 to 1 – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::setVerificationStatus, update from 0 to 1 – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "setVerificationStatus - from 0 to 0") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0]
					]
				]);

				$username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);
				// debug([$username]);
	

				// update from 0 to 1
				$result = $UC->setVerificationStatus($username["id"], $test_user_id, 0);

				if(
					isset($result["verification_status"]) &&
					$result["verification_status"] == "NOT_VERIFIED"
				): ?>
				<div class="testpassed"><p>SuperUser::setVerificationStatus, update from 0 to 0 – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::setVerificationStatus, update from 0 to 0 – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "setVerificationStatus - from 1 to 1") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 1]
					]
				]);

				$username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);
				// debug([$username]);
	

				// update from 0 to 1
				$result = $UC->setVerificationStatus($username["id"], $test_user_id, 1);

				if(
					isset($result["verification_status"]) &&
					$result["verification_status"] == "VERIFIED"
				): ?>
				<div class="testpassed"><p>SuperUser::setVerificationStatus, update from 1 to 1 – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::setVerificationStatus, update from 1 to 1 – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "setVerificationStatus - from 1 to 0") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 1]
					]
				]);

				$username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);
				// debug([$username]);
	

				// update from 0 to 1
				$result = $UC->setVerificationStatus($username["id"], $test_user_id, 0);

				if(
					isset($result["verification_status"]) &&
					$result["verification_status"] == "NOT_VERIFIED"
				): ?>
				<div class="testpassed"><p>SuperUser::setVerificationStatus, update from 1 to 0 – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::setVerificationStatus, update from 1 to 0 – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		?>
	</div>

	<div class="tests">
		<h3>SuperUser::updateEmail</h3>

		<? 

		if(1 && "updateEmail – no existing usernames") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
				]);


				$_POST["email"] = "test4.parentnode@gmail.com";
				$result = $UC->updateEmail(["updateEmail", $test_user_id]);

				$usernames = $UC->getUsernames(["user_id" => $test_user_id]);
				// debug(["result", $result, "usernames" => $usernames]);

				if(

					count($usernames) === 1 &&
					$usernames[0]["username"] === "test4.parentnode@gmail.com" &&

					isset($result["email_status"]) &&
					$result["email_status"] == "UPDATED" &&

					isset($result["verification_status"]) &&
					$result["verification_status"] == "NOT_VERIFIED"

				): ?>
				<div class="testpassed"><p>SuperUser::updateEmail, no existing usernames – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::updateEmail, no existing usernames – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "updateEmail – usernames exist") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);


				$_POST["email"] = "test4.parentnode@gmail.com";
				$result = $UC->updateEmail(["updateEmail", $test_user_id]);

				$usernames = $UC->getUsernames(["user_id" => $test_user_id]);


				if(
					count($usernames) === 4 &&

					isset($result["email_status"]) &&
					$result["email_status"] == "UPDATED" &&

					isset($result["verification_status"]) &&
					$result["verification_status"] == "NOT_VERIFIED"
				): ?>
				<div class="testpassed"><p>SuperUser::updateEmail, usernames exist – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::updateEmail, usernames exist – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "updateEmail – using username_id + no verification_status") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 1],
					]
				]);

				$username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);
				
				
				$_POST["username_id"] = $username["id"];
				// $_POST["verification_status"] = 0;
				$_POST["email"] = "test4.parentnode@gmail.com";
				$result = $UC->updateEmail(["updateEmail", $test_user_id]);

				$usernames = $UC->getUsernames(["user_id" => $test_user_id]);

				$result_email_username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);


				if(

					count($usernames) === 1 &&

					$result_email_username["id"] === $username["id"] &&
					$result_email_username["username"] === "test4.parentnode@gmail.com" &&
					$result_email_username["verified"] == 0 &&

					isset($result["email_status"]) &&
					$result["email_status"] == "UPDATED" &&

					isset($result["verification_status"]) &&
					$result["verification_status"] == "NOT_VERIFIED"
				): ?>
				<div class="testpassed"><p>SuperUser::updateEmail, using username_id + no verification_status – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::updateEmail, using username_id + no verification_status – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "updateEmail – using username_id + verification_status") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 1],
					]
				]);

				$username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);
				
				
				$_POST["username_id"] = $username["id"];
				$_POST["verification_status"] = 1;
				$_POST["email"] = "test4.parentnode@gmail.com";
				$result = $UC->updateEmail(["updateEmail", $test_user_id]);

				$usernames = $UC->getUsernames(["user_id" => $test_user_id]);

				$result_email_username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);


				if(

					count($usernames) === 1 &&
					$result_email_username["id"] === $username["id"] &&
					$result_email_username["username"] === "test4.parentnode@gmail.com" &&
					$result_email_username["verified"] == 1 &&

					isset($result["email_status"]) &&
					$result["email_status"] == "UPDATED" &&

					isset($result["verification_status"]) &&
					$result["verification_status"] == "VERIFIED"
				): ?>
				<div class="testpassed"><p>SuperUser::updateEmail, using username_id + verification_status – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::updateEmail, using username_id + verification_status – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "updateEmail – using username_id + unchanged email") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 1],
					]
				]);

				$username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);
				
				
				$_POST["username_id"] = $username["id"];
				$_POST["email"] = "test.parentnode@gmail.com";
				$result = $UC->updateEmail(["updateEmail", $test_user_id]);

				$usernames = $UC->getUsernames(["user_id" => $test_user_id]);

				$result_email_username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);


				if(

					count($usernames) === 1 &&

					$result_email_username["id"] === $username["id"] &&
					$result_email_username["username"] === "test.parentnode@gmail.com" &&
					$result_email_username["verified"] == 1 &&

					isset($result["email_status"]) &&
					$result["email_status"] == "UNCHANGED" &&

					isset($result["verification_status"]) &&
					$result["verification_status"] == "VERIFIED"
				): ?>
				<div class="testpassed"><p>SuperUser::updateEmail, using username_id + unchanged email – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::updateEmail, using username_id + unchanged email – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "updateEmail – using username_id + empty email (delete email)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 1],
					]
				]);

				$username = $UC->getUsernames(["user_id" => $test_user_id, "type" => "email"]);

				$_POST["username_id"] = $username["id"];
				$_POST["email"] = "";
				$result = $UC->updateEmail(["updateEmail", $test_user_id]);

				$usernames = $UC->getUsernames(["user_id" => $test_user_id]);

				if(

					$username && 
					$result &&
					!$usernames

				): ?>
				<div class="testpassed"><p>SuperUser::updateEmail, using username_id + empty email (delete email) – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::updateEmail, using username_id + empty email (delete email) – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		if(1 && "updateEmail – using username_id + empty email (delete email)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id_1 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 1],
					]
				]);

				$test_user_id_2 = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 2",
				]);


				$_POST["email"] = "test.parentnode@gmail.com";
				$result = $UC->updateEmail(["updateEmail", $test_user_id_2]);


				$usernames_1 = $UC->getUsernames(["user_id" => $test_user_id_1]);
				$usernames_2 = $UC->getUsernames(["user_id" => $test_user_id_2]);

				if(

					count($usernames_1) === 1 &&
					$usernames_1[0]["username"] === "test.parentnode@gmail.com" && 

					!$usernames_2 &&

					$result &&
					$result["email_status"] == "ALREADY_EXISTS"

				): ?>
				<div class="testpassed"><p>SuperUser::updateEmail, using username_id + existing email – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::updateEmail, using username_id + existing email – error</p></div>
				<? endif;

				// CLEAN UP
				deleteUser($test_user_id_1);
				deleteUser($test_user_id_2);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();
		}

		?>
	</div>

	<div class="tests">
		<h3>SuperUser::userCanBeDeleted</h3>
		<?

		if(1 && "delete (unused user)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1 for delete",
				]);


				$result = $UC->userCanBeDeleted($test_user_id);
		
				if (

					$result

				): ?>
				<div class="testpassed"><p>SuperUser::userCanBeDeleted (unused user) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::userCanBeDeleted (unused user) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);
				
				message()->resetMessages();

			})();

		}

		if(1 && "userCanBeDeleted (guest user)") {

			(function() {

				$UC = new SuperUser();


				$result = $UC->userCanBeDeleted(1);
				// debug([$result]);
		
				if (

					!$result

				): ?>
				<div class="testpassed"><p>SuperUser::userCanBeDeleted (guest user) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::userCanBeDeleted (guest user) - error</p></div>
				<? endif; 

				message()->resetMessages();

			})();

		}

		if(1 && "userCanBeDeleted (non-existing user)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$result_1 = $UC->userCanBeDeleted("abc");
				$result_2 = $UC->userCanBeDeleted("");
				$result_3 = $UC->userCanBeDeleted(1000000000);
				// debug([$result_1, $result_2, $result_3, $result_4]);

				if (

					!$result_1 &&
					!$result_2 &&
					!$result_3

				): ?>
				<div class="testpassed"><p>SuperUser::userCanBeDeleted (non-existing user) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::userCanBeDeleted (non-existing user) - error</p></div>
				<? endif; 

				message()->resetMessages();

			})();

		}

		if(1 && "userCanBeDeleted (user with item)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$test_item_id = createTestItem(["price" => 400, "user_id" => $test_user_id]);


				$result = $UC->userCanBeDeleted($test_user_id);
				// debug([$result]);
		
				if (
					!$result 
				): ?>
				<div class="testpassed"><p>SuperUser::userCanBeDeleted (user with item) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::userCanBeDeleted (user with item) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);

				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();
			})();

		}

		if(1 && "userCanBeDeleted (user with order)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$test_item_id = createTestItem(["price" => 400]);


				$test_order_id = createTestOrder($test_user_id, $test_item_id);


				$result = $UC->userCanBeDeleted($test_user_id);
				// debug([$result, message()->getMessages()]);

				if (
					!$result
				): ?>
				<div class="testpassed"><p>SuperUser::userCanBeDeleted (user with order) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::userCanBeDeleted (user with order) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestOrder($test_order_id);

				deleteTestItem($test_item_id);

				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);
				
				message()->resetMessages();
			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>SuperUser::delete</h3>
		<?

		if(1 && "delete (unused user)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1 for delete",
				]);


				$result = $UC->delete(["delete", $test_user_id]);

				$sql_user = "SELECT * FROM ".SITE_DB.".users WHERE id = $test_user_id"; 
				$sql_usernames = "SELECT * FROM ".SITE_DB.".usernames WHERE user_id = $test_user_id"; 
				$sql_passwords = "SELECT * FROM ".SITE_DB.".passwords WHERE user_id = $test_user_id"; 
				$sql_items = "SELECT * FROM ".SITE_DB.".items WHERE user_id = $test_user_id"; 
				$sql_comments = "SELECT * FROM ".SITE_DB.".item_comments WHERE user_id = $test_user_id"; 
				$sql_carts = "SELECT * FROM ".SITE_DB.".shop_carts WHERE user_id = $test_user_id"; 
				$sql_orders = "SELECT * FROM ".SITE_DB.".shop_orders WHERE user_id = $test_user_id"; 

				// debug([$result]);
		
				if (

					$result &&
					!$query->sql($sql_user) &&
					!$query->sql($sql_usernames) &&
					!$query->sql($sql_passwords) &&
					!$query->sql($sql_items) &&
					!$query->sql($sql_comments) &&
					!$query->sql($sql_carts) &&
					!$query->sql($sql_orders)

				): ?>
				<div class="testpassed"><p>SuperUser::delete (unused user) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::delete (unused user) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteUserGroup($test_user_group_id);
				
				message()->resetMessages();

			})();

		}

		if(1 && "delete (guest user)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$result = $UC->delete(["delete", 1]);
				// debug([$result]);
		
				if (

					!$result

				): ?>
				<div class="testpassed"><p>SuperUser::delete (guest user) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::delete (guest user) - error</p></div>
				<? endif; 

				message()->resetMessages();

			})();

		}

		if(1 && "delete (non-existing user)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$result_1 = $UC->delete(["delete", "abc"]);
				$result_2 = $UC->delete(["delete", ""]);
				$result_3 = $UC->delete(["delete"]);
				$result_4 = $UC->delete(["delete", "1000000000"]);
				// debug([$result_1, $result_2, $result_3, $result_4]);

				if (

					!$result_1 &&
					!$result_2 &&
					!$result_3 &&
					!$result_4

				): ?>
				<div class="testpassed"><p>SuperUser::delete (non-existing user) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::delete (non-existing user) - error</p></div>
				<? endif; 

				message()->resetMessages();

			})();

		}

		if(1 && "delete (user with usernames)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$result = $UC->delete(["delete", $test_user_id]);

				$sql_user = "SELECT * FROM ".SITE_DB.".users WHERE id = $test_user_id"; 
				$sql_usernames = "SELECT * FROM ".SITE_DB.".usernames WHERE user_id = $test_user_id"; 
				$sql_passwords = "SELECT * FROM ".SITE_DB.".passwords WHERE user_id = $test_user_id"; 
				$sql_items = "SELECT * FROM ".SITE_DB.".items WHERE user_id = $test_user_id"; 
				$sql_comments = "SELECT * FROM ".SITE_DB.".item_comments WHERE user_id = $test_user_id"; 
				$sql_carts = "SELECT * FROM ".SITE_DB.".shop_carts WHERE user_id = $test_user_id"; 
				$sql_orders = "SELECT * FROM ".SITE_DB.".shop_orders WHERE user_id = $test_user_id"; 

				// debug([$result]);
	
				if (

					$result &&
					!$query->sql($sql_user) &&
					!$query->sql($sql_usernames) &&
					!$query->sql($sql_passwords) &&
					!$query->sql($sql_items) &&
					!$query->sql($sql_comments) &&
					!$query->sql($sql_carts) &&
					!$query->sql($sql_orders)

				): ?>
				<div class="testpassed"><p>SuperUser::delete (user with usernames) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::delete (user with usernames) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteUserGroup($test_user_group_id);
				
				message()->resetMessages();

			})();

		}

		if(1 && "delete (user with item)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$test_item_id = createTestItem(["price" => 400, "user_id" => $test_user_id]);


				$result = $UC->delete(["delete", $test_user_id]);
				// debug([$result]);
		
				if (
					!$result 
				): ?>
				<div class="testpassed"><p>SuperUser::delete (user with item) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::delete (user with item) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);

				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();
			})();

		}

		if(1 && "delete (user with cart)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$test_item_id = createTestItem(["price" => 400]);

				$SC = new SuperShop();

		
				$_POST["user_id"] = $test_user_id;
				$cart = $SC->addCart(["addCart"]);
				unset($_POST);

				$_POST["item_id"] = $test_item_id;
				$_POST["quantity"] = 1;
				$cart = $SC->addToCart(["addToCart", $cart["cart_reference"]]);
				unset($_POST);


				$result = $UC->delete(["delete", $test_user_id]);
				// debug([$result]);

				$sql_user = "SELECT * FROM ".SITE_DB.".users WHERE id = $test_user_id"; 
				$sql_usernames = "SELECT * FROM ".SITE_DB.".usernames WHERE user_id = $test_user_id"; 
				$sql_passwords = "SELECT * FROM ".SITE_DB.".passwords WHERE user_id = $test_user_id"; 
				$sql_items = "SELECT * FROM ".SITE_DB.".items WHERE user_id = $test_user_id"; 
				$sql_comments = "SELECT * FROM ".SITE_DB.".item_comments WHERE user_id = $test_user_id"; 
				$sql_carts = "SELECT * FROM ".SITE_DB.".shop_carts WHERE user_id = $test_user_id"; 
				$sql_orders = "SELECT * FROM ".SITE_DB.".shop_orders WHERE user_id = $test_user_id"; 

				// debug([$result]);
	
				if (

					$result &&
					!$query->sql($sql_user) &&
					!$query->sql($sql_usernames) &&
					!$query->sql($sql_passwords) &&
					!$query->sql($sql_items) &&
					!$query->sql($sql_comments) &&
					!$query->sql($sql_carts) &&
					!$query->sql($sql_orders)

				): ?>
				<div class="testpassed"><p>SuperUser::delete (user with cart) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::delete (user with cart) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteUserGroup($test_user_group_id);

				deleteTestItem($test_item_id);

				message()->resetMessages();

			})();

		}

		if(1 && "delete (user with order)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$test_item_id = createTestItem(["price" => 400]);


				$test_order_id = createTestOrder($test_user_id, $test_item_id);


				$result = $UC->delete(["delete", $test_user_id]);
				// debug([$result, message()->getMessages()]);

				if (
					!$result
				): ?>
				<div class="testpassed"><p>SuperUser::delete (user with order) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::delete (user with order) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestOrder($test_order_id);

				deleteTestItem($test_item_id);

				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);
				
				message()->resetMessages();
			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>SuperUser::cancel</h3>
		<?

		if(1 && "cancel (user with usernames)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);


				$result = $UC->cancel(["cancel", $test_user_id]);
				// debug([$result]);


				$sql_user = "SELECT * FROM ".SITE_DB.".users WHERE id = $test_user_id"; 
				$query->sql($sql_user);
				$user = $query->result(0);
				// debug([$user]);

				$sql_usernames = "SELECT * FROM ".SITE_DB.".usernames WHERE user_id = $test_user_id"; 
				$sql_passwords = "SELECT * FROM ".SITE_DB.".passwords WHERE user_id = $test_user_id"; 
				$sql_items = "SELECT * FROM ".SITE_DB.".items WHERE user_id = $test_user_id"; 
				$sql_comments = "SELECT * FROM ".SITE_DB.".item_comments WHERE user_id = $test_user_id"; 
				$sql_carts = "SELECT * FROM ".SITE_DB.".shop_carts WHERE user_id = $test_user_id"; 
				$sql_orders = "SELECT * FROM ".SITE_DB.".shop_orders WHERE user_id = $test_user_id"; 

				if (
					$result &&

					$user["nickname"] === "Anonymous" &&
					$user["status"] == -1 &&
					!$user["firstname"] &&
					!$user["lastname"] &&
					!$user["user_group_id"] &&

					!$query->sql($sql_usernames) &&
					!$query->sql($sql_passwords) &&
					!$query->sql($sql_items) &&
					!$query->sql($sql_comments) &&
					!$query->sql($sql_carts) &&
					!$query->sql($sql_orders)

				): ?>
				<div class="testpassed"><p>SuperUser::cancel (user with usernames) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::cancel (user with usernames) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);
				
				message()->resetMessages();

			})();

		}

		if(1 && "cancel (guest user)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$result = $UC->cancel(["cancel", 1]);
				// debug([$result]);
		
				if (

					!$result

				): ?>
				<div class="testpassed"><p>SuperUser::cancel (guest user) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::cancel (guest user) - error</p></div>
				<? endif; 

				message()->resetMessages();

			})();

		}

		if(1 && "cancel (non-existing user)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$result_1 = $UC->cancel(["cancel", "abc"]);
				$result_2 = $UC->cancel(["cancel", ""]);
				$result_3 = $UC->cancel(["cancel"]);
				$result_4 = $UC->cancel(["cancel", "1000000000"]);
				// debug([$result_1, $result_2, $result_3, $result_4]);

				if (

					!$result_1 &&
					!$result_2 &&
					!$result_3 &&
					!$result_4

				): ?>
				<div class="testpassed"><p>SuperUser::cancel (non-existing user) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::cancel (non-existing user) - error</p></div>
				<? endif; 

				message()->resetMessages();

			})();

		}

		if(1 && "cancel (user with item)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
					"usernames" => [
						["username" => "test.parentnode@gmail.com", "type" => "email", "verified" => 0],
						["username" => "test2.parentnode@gmail.com", "type" => "email", "verified" => 1],
						["username" => "11223344", "type" => "mobile", "verified" => 0],
					]
				]);

				$test_item_id = createTestItem(["price" => 400, "user_id" => $test_user_id]);


				$result = $UC->cancel(["cancel", $test_user_id]);
				// debug([$result]);

				$sql_user = "SELECT * FROM ".SITE_DB.".users WHERE id = $test_user_id"; 
				$query->sql($sql_user);
				$user = $query->result(0);
				// debug([$user]);

				$sql_usernames = "SELECT * FROM ".SITE_DB.".usernames WHERE user_id = $test_user_id"; 
				$sql_passwords = "SELECT * FROM ".SITE_DB.".passwords WHERE user_id = $test_user_id"; 
				$sql_items = "SELECT * FROM ".SITE_DB.".items WHERE user_id = $test_user_id"; 
				$sql_comments = "SELECT * FROM ".SITE_DB.".item_comments WHERE user_id = $test_user_id"; 
				$sql_carts = "SELECT * FROM ".SITE_DB.".shop_carts WHERE user_id = $test_user_id"; 
				$sql_orders = "SELECT * FROM ".SITE_DB.".shop_orders WHERE user_id = $test_user_id"; 

		
				if (

					$result &&

					$user["nickname"] === "Anonymous" &&
					$user["status"] == -1 &&
					!$user["firstname"] &&
					!$user["lastname"] &&
					!$user["user_group_id"] &&

					$query->sql($sql_items) &&

					!$query->sql($sql_usernames) &&
					!$query->sql($sql_passwords) &&
					!$query->sql($sql_comments) &&
					!$query->sql($sql_carts) &&
					!$query->sql($sql_orders)

				): ?>
				<div class="testpassed"><p>SuperUser::cancel (user with item) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::cancel (user with item) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestItem($test_item_id);

				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);

				message()->resetMessages();

			})();

		}

		if(1 && "cancel (user with paid order)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
				]);

				$test_item_id = createTestItem(["price" => 400]);

				$test_order_id = createTestOrder($test_user_id, $test_item_id);

				$test_payment_id = payTestOrder($test_order_id);

				$result = $UC->cancel(["cancel", $test_user_id]);
				// debug([$result, message()->getMessages()]);


				$sql_user = "SELECT * FROM ".SITE_DB.".users WHERE id = $test_user_id"; 
				$query->sql($sql_user);
				$user = $query->result(0);
				// debug([$user]);

				$sql_usernames = "SELECT * FROM ".SITE_DB.".usernames WHERE user_id = $test_user_id"; 
				$sql_passwords = "SELECT * FROM ".SITE_DB.".passwords WHERE user_id = $test_user_id"; 
				$sql_items = "SELECT * FROM ".SITE_DB.".items WHERE user_id = $test_user_id"; 
				$sql_comments = "SELECT * FROM ".SITE_DB.".item_comments WHERE user_id = $test_user_id"; 
				$sql_carts = "SELECT * FROM ".SITE_DB.".shop_carts WHERE user_id = $test_user_id"; 
				$sql_orders = "SELECT * FROM ".SITE_DB.".shop_orders WHERE user_id = $test_user_id"; 

		
				if (

					$result &&

					$user["nickname"] === "Anonymous" &&
					$user["status"] == -1 &&
					!$user["firstname"] &&
					!$user["lastname"] &&
					!$user["user_group_id"] &&

					$query->sql($sql_orders) &&

					!$query->sql($sql_items) &&
					!$query->sql($sql_usernames) &&
					!$query->sql($sql_passwords) &&
					!$query->sql($sql_comments) &&
					!$query->sql($sql_carts)

				): ?>
				<div class="testpassed"><p>SuperUser::cancel (user with paid order) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::cancel (user with paid order) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestPayment($test_payment_id);

				deleteTestOrder($test_order_id);

				deleteTestItem($test_item_id);

				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);
				
				message()->resetMessages();
			})();

		}

		if(1 && "cancel (user with unpaid order)") {

			(function() {

				$UC = new SuperUser();
				$query = new Query();


				$test_user_group_id = createUserGroup("test-group");

				$test_user_id = createUser([
					"user_group_id" => $test_user_group_id,
					"nickname" => "test user 1",
				]);

				$test_item_id = createTestItem(["price" => 400]);

				$test_order_id = createTestOrder($test_user_id, $test_item_id);


				$result = $UC->cancel(["cancel", $test_user_id]);
				// debug([$result]);


				$sql_user = "SELECT * FROM ".SITE_DB.".users WHERE id = $test_user_id"; 
				$query->sql($sql_user);
				$user = $query->result(0);
				// debug([$user]);

				$sql_usernames = "SELECT * FROM ".SITE_DB.".usernames WHERE user_id = $test_user_id"; 
				$sql_passwords = "SELECT * FROM ".SITE_DB.".passwords WHERE user_id = $test_user_id"; 
				$sql_items = "SELECT * FROM ".SITE_DB.".items WHERE user_id = $test_user_id"; 
				$sql_comments = "SELECT * FROM ".SITE_DB.".item_comments WHERE user_id = $test_user_id"; 
				$sql_carts = "SELECT * FROM ".SITE_DB.".shop_carts WHERE user_id = $test_user_id"; 
				$sql_orders = "SELECT * FROM ".SITE_DB.".shop_orders WHERE user_id = $test_user_id"; 

		
				if (

					$result &&
					$result["error"] === "unpaid_orders" &&

					$user["nickname"] !== "Anonymous" &&
					$user["status"] == 1 &&
					$user["user_group_id"] &&

					$query->sql($sql_orders)

				): ?>
				<div class="testpassed"><p>SuperUser::cancel (user with unpaid order) - correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>SuperUser::cancel (user with unpaid order) - error</p></div>
				<? endif; 

				// CLEAN UP
				deleteTestOrder($test_order_id);

				deleteTestItem($test_item_id);

				deleteUser($test_user_id);

				deleteUserGroup($test_user_group_id);
				
				message()->resetMessages();
			})();

		}

		?>
	</div>
</div>
