<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();

include_once("classes/shop/supershop.class.php");
include_once("classes/users/superuser.class.php");
$UC = new SuperUser();
$IC = new Items();
$SC = new SuperShop();
?>

<div class="scene i:scene tests">
	<h1>SuperUser</h1>	
	<h2>Testing SuperUser class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>
	
<?
	// SETUP
	// create test user, no password, activated, and also create reference user
	$query = new Query();
	
	// add test user
	$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
	if($query->sql($sql)) {
		$test_user_id = $query->lastInsertId();
	}

	// delete all unverified usernames
	$query->sql("DELETE FROM ".SITE_DB.".user_usernames WHERE verified = 0");

	
	// add three unverified usernames (two emails and a telephone number) for test user
	if($test_user_id) {
		$sql = "INSERT INTO ".SITE_DB.".user_usernames (user_id, username, type, verified, verification_code) VALUES($test_user_id, 'test.parentnode@gmail.com', 'email', 0, '12345678'), ($test_user_id, 'test2.parentnode@gmail.com', 'email', 0, '23456789'), ($test_user_id, '11223344', 'mobile', 0, '34567890')";
		$query->sql($sql);
		$sql = "SELECT id, username, verification_code FROM ".SITE_DB.".user_usernames WHERE user_id = '$test_user_id'";
		// print ($sql); 

		if($query->sql($sql)) {
			$test_email1 = $query->result(0)["username"];
			$test_email1_verification_code = $query->result(0)["verification_code"];
			$test_email1_username_id = $query->result(0)["id"];

			$test_email2 = $query->result(1)["username"];
			$test_email2_verification_code = $query->result(1)["verification_code"];
			$test_email2_username_id = $query->result(1)["id"];

			$test_mobile = $query->result(2)["username"];
			$test_mobile_verification_code = $query->result(2)["verification_code"];
			$test_mobile_id = $query->result(2)["id"];

		}
	}

	// add reference user
	if($test_user_id) {
		$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'reference user', 1, '2019-02-02 01:01:01')";
		if($query->sql($sql)) {
			$ref_user_id = $query->lastInsertId();
		}
	}

	if($ref_user_id) {
		// add unverified username (email) for ref user
		$sql = "INSERT INTO ".SITE_DB.".user_usernames (user_id, username, type, verified, verification_code) VALUES($ref_user_id, 'test3.parentnode@gmail.com', 'email', 0, '87654321')";
		$query->sql($sql);
		$sql = "SELECT id, username, verification_code FROM ".SITE_DB.".user_usernames WHERE user_id = '$ref_user_id'";
		if($query->sql($sql)) {
			$ref_username = $query->result(0)["username"];
			$ref_verification_code = $query->result(0)["verification_code"];
			$ref_username_id = $query->result(0)["id"];

		}
	}

?>

	<div class="tests">
		<h3>SuperUser::getUsernames</h3>

		<? 
		// pass user_id
		
		$result = $UC->getUsernames(["user_id" => $test_user_id]);
		// print_r($result);
		
		if($result && count($result) == 3):?>
		<div class="testpassed"><p>SuperUser::getUsernames, get all usernames for user_id – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperUser::getUsernames, get all usernames for user_id – error</p></div>
		<? endif; ?>

		<? 
		// pass user_id and type
		
		$result = $UC->getUsernames(["user_id" => $test_user_id, "type" => "mobile"]);
		// print_r($result);
		
		if($result && $result["username"] == 11223344):?>
		<div class="testpassed"><p>SuperUser::getUsernames, get first username of type for user_id – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperUser::getUsernames, get first username of type for user_id – error</p></div>
		<? endif; ?>

		<? 
		// pass username_id

		$result = $UC->getUsernames(["username_id" => $test_email1_username_id]);
		// print_r($result);

		if($result && $result["username"] == 'test.parentnode@gmail.com'):?>
		<div class="testpassed"><p>SuperUser::getUsernames, get specific username by username_id – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperUser::getUsernames, get specific username by username_id – error</p></div>
		<? endif; ?>


	</div>

	<div class="tests">
		<h3>SuperUser::getUnverifiedUsernames</h3>

		<? 
		// pass nothing
		
		$result = $UC->getUnverifiedUsernames();	
		
		if($result):?>
		<div class="testpassed"><p>SuperUser::getUnverifiedUsernames, get all unverified usernames – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperUser::getUnverifiedUsernames, get all unverified usernames – error</p></div>
		<? endif; ?>
		
		<? 
		// pass type
		
		$result = $UC->getUnverifiedUsernames(["type" => "email"]);
		// print_r($result);

		if($result && count($result) == 3):?>
		<div class="testpassed"><p>SuperUser::getUnverifiedUsernames, get unverified usernames of type – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperUser::getUnverifiedUsernames, get unverified usernames of type – error</p></div>
		<? endif; ?>

		<? 
		// pass user_id
		
		$result = $UC->getUnverifiedUsernames(["user_id" => $test_user_id]);
		// print_r($result);

		if($result && count($result) == 3):?>
		<div class="testpassed"><p>SuperUser::getUnverifiedUsernames, get unverified usernames for user_id – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperUser::getUnverifiedUsernames, get unverified usernames for user_id – error</p></div>
		<? endif; ?>

		<? 
		// pass user_id and type
		
		$result = $UC->getUnverifiedUsernames(["user_id" => $test_user_id, "type" => "email"]);

		if($result && count($result) == 2):?>
		<div class="testpassed"><p>SuperUser::getUnverifiedUsernames, get unverifed usernames of type for user_id – correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>SuperUser::getUnverifiedUsernames, get unverifed usernames of type for user_id – error</p></div>
		<? endif; ?>

		<? 
		// goto cleanup; 
		// goto skip_cleanup; 
		?>	


	</div>



	<div class="tests">
		<h3>SuperUser::sendVerificationLink</h3>
		
		<? 
		
		$result = $UC->sendVerificationLink(["sendVerificationLink", $test_email1_username_id]);
		// print_r($result);

		if(
			$result &&
			isset($result["verified"]) &&
			isset($result["total_reminders"]) &&
			isset($result["reminded_at"])
			):?>
		<div class="testpassed"><p>SuperUser::sendVerificationLink – correct</p></div>
		<? else: 
			
		?>
		<div class="testfailed"><p>SuperUser::sendVerificationLink – error</p></div>
		<? endif; ?>
		
	</div>


	<div class="tests">
		<h3>SuperUser::sendVerificationLinks</h3>
		
		<? 
		$usernames_ids = $test_email1_username_id.",".$test_email2_username_id;
		$_POST["selected_username_ids"] = $usernames_ids;

		$result = $UC->sendVerificationLinks(["sendVerificationLinks"]);
		// print_r($result);

		if($result && count($result) == 2):?>
		<div class="testpassed"><p>SuperUser::sendVerificationLinks – correct</p></div>
		<? else: 
			
		?>
		<div class="testfailed"><p>SuperUser::sendVerificationLinks – error</p></div>
		<? endif; ?>
		
	</div>



	<div class="tests">
		<h3>SuperUser::getVerificationStatus</h3>
		
		<? 
		
		$result = $UC->getVerificationStatus($test_email1_username_id, $test_user_id);
		// print_r($result);
		if(
			isset($result["verified"]) &&
			isset($result["total_reminders"]) &&
			isset($result["reminded_at"]) &&
			$result["verified"] === "0"
			):		
		?>
		<div class="testpassed"><p>SuperUser::getVerificationStatus – correct</p></div>
		<? else: 
			
		?>
		<div class="testfailed"><p>SuperUser::getVerificationStatus – error</p></div>
		<? endif; ?>

		
	</div>

	<div class="tests">
		<h3>SuperUser::setVerificationStatus</h3>
		
		<? 
		// update from 0 to 1
		$result = $UC->setVerificationStatus($test_email1_username_id, $test_user_id, 1);
		if(
			isset($result["verification_status"]) &&
			$result["verification_status"] == "VERIFIED"
		):?>
		<div class="testpassed"><p>SuperUser::setVerificationStatus, update from 0 to 1 – correct</p></div>
		<? else: 
			
			?>
		<div class="testfailed"><p>SuperUser::setVerificationStatus, update from 0 to 1 – error</p></div>
		<? endif; ?>
		
		<? 
		// update from 1 to 0
		$result = $UC->setVerificationStatus($test_email1_username_id, $test_user_id, 0);
		if(
			isset($result["verification_status"]) &&
			$result["verification_status"] == "NOT_VERIFIED"
		):?>
		<div class="testpassed"><p>SuperUser::setVerificationStatus, update from 1 to 0 – correct</p></div>
		<? else: 
			
			?>
		<div class="testfailed"><p>SuperUser::setVerificationStatus, update from 1 to 0 – error</p></div>
		<? endif; ?>
		
		<? 
		// update from 0 to 0
		$result = $UC->setVerificationStatus($test_email1_username_id, $test_user_id, 0);
		if(
			isset($result["verification_status"]) &&
			$result["verification_status"] == "NOT_VERIFIED"
		):?>
		<div class="testpassed"><p>SuperUser::setVerificationStatus, update from 0 to 0 (unchanged) – correct</p></div>
		<? else: 
			
			?>
		<div class="testfailed"><p>SuperUser::setVerificationStatus, update from 0 to 0 (unchanged) – error</p></div>
		<? endif; ?>
		


	</div>
	
	<div class="tests">
		<h3>SuperUser::updateEmail</h3>

		<? 
		// update existing email

		$_POST["username_id"] = $test_email1_username_id;
		$_POST["verification_status"] = 0;
		$_POST["email"] =  "test4.parentnode@gmail.com";

		$result = $UC->updateEmail(["updateEmail", $test_user_id]);
		
		$sql_test_email1 = "SELECT * FROM ".SITE_DB.".user_usernames WHERE username = 'test4.parentnode@gmail.com' AND verified = 0 AND user_id = $test_user_id AND id = $test_email1_username_id";
		// print $sql_test_email1;
		$sql_test_email2 = "SELECT * FROM ".SITE_DB.".user_usernames WHERE username = 'test2.parentnode@gmail.com' AND verified = 0 AND user_id = $test_user_id AND id = $test_email2_username_id";
		// print $sql_test_email2;
		$sql_mobile = "SELECT * FROM ".SITE_DB.".user_usernames WHERE username = 11223344 AND verified = 0 AND user_id = $test_user_id AND id = $test_mobile_id";
		// print $sql_mobile;
		$sql_ref_username = "SELECT * FROM ".SITE_DB.".user_usernames WHERE username = 'test3.parentnode@gmail.com' AND verified = 0 AND user_id = $ref_user_id AND id = $ref_username_id";
		// print $sql_mobile;

		if(
			$query->sql($sql_test_email1) && 
			$query->sql($sql_test_email2) && 
			$query->sql($sql_mobile) && 
			$query->sql($sql_ref_username) && 
			$result["email_status"] && 
			$result["verification_status"] && 
			$result["email_status"] == "UPDATED" && 
			$result["verification_status"] == 0
		):?>

		<div class="testpassed"><p>SuperUser::updateEmail, update existing email – correct</p></div>
		<? else: 
			
		?>
		<div class="testfailed"><p>SuperUser::updateEmail, update existing email – error</p></div>
		<? endif; ?>

		<?
		// unchanged email

		unset($_POST);

		$_POST["username_id"] = $test_email1_username_id;
		$_POST["verification_status"] = 0;
		$_POST["email"] =  "test4.parentnode@gmail.com";

		$result = $UC->updateEmail(["updateEmail", $test_user_id]);
// echo '<pre>'. print_r(count($result)) .'</pre>';
		if(
			$query->sql($sql_test_email1) && 
			$query->sql($sql_test_email2) && 
			$query->sql($sql_mobile) && 
			$query->sql($sql_ref_username) && 
			$result["email_status"] && 
			$result["verification_status"] && 
			$result["email_status"] == "UNCHANGED" && 
			$result["verification_status"] == 0
		):?>

		<div class="testpassed"><p>SuperUser::updateEmail, unchanged email – correct</p></div>
		<? else: 
			
		?>
		<div class="testfailed"><p>SuperUser::updateEmail, unchanged email – error</p></div>
		<? endif; ?>

		
		<? 
		// update existing email to empty (deletes username row)
			
		unset($_POST);
		
		
		$_POST["username_id"] = $test_email2_username_id;
		$_POST["verification_status"] = 0;
		$_POST["email"] = "";
		
		$result = $UC->updateEmail(["updateEmail", $test_user_id]);
				// echo '<pre>'. print_r(count($result)) .'</pre>';
		$sql = "SELECT id FROM ".SITE_DB.".user_usernames WHERE user_id = '$test_user_id' AND id = $test_email2_username_id";
		// print ($sql); 

		if(
			$result === true &&
			!$query->sql($sql)
		):?>

		<div class="testpassed"><p>SuperUser::updateEmail, update existing email to empty (deletes username row) – correct</p></div>
		<? else: 
			
		?>
		<div class="testfailed"><p>SuperUser::updateEmail, update existing email to empty (deletes username row) – error</p></div>
		<? endif; ?>
		
		<? 
		// goto cleanup; 
		// goto skip_cleanup; 
		?>	


		<? 
		// add new email

		// delete all emails for test user, empty post array and add new email
		$sql = "DELETE FROM ".SITE_DB.".user_usernames WHERE user_id = $test_user_id AND type='email'";
		
		
		// print $sql;
		if($query->sql($sql)) {
			
			unset($_POST);
			
			$_POST["verification_status"] = 0;
			$_POST["email"] = "test5.parentnode@gmail.com";

			$result = $UC->updateEmail(["updateEmail", $test_user_id]);
						// echo '<pre>'. print_r(count($result)) .'</pre>';
		}
		
		$sql_test_email5 = "SELECT * FROM ".SITE_DB.".user_usernames WHERE username = 'test5.parentnode@gmail.com' AND verified = 0 AND user_id = $test_user_id";
		// print $sql_test_email5;
		if(
			$query->sql($sql_test_email5) && 
			$query->sql($sql_mobile) && 
			$query->sql($sql_ref_username) && 
			$result["email_status"] && 
			$result["verification_status"] && 
			$result["email_status"] == "UPDATED" && 
			$result["verification_status"] == 0
		):
		
		?>

		<div class="testpassed"><p>SuperUser::updateEmail, add new email – correct</p></div>
		<? else: 
			
		?>
		<div class="testfailed"><p>SuperUser::updateEmail, add new email – error</p></div>
		<? endif; ?>
		
		<? 
		// add new email that already exists in db
			
		unset($_POST);
		
		$_POST["verification_status"] = 0;
		$_POST["email"] = "test5.parentnode@gmail.com";
		
		$result = $UC->updateEmail(["updateEmail", $test_user_id]);
		// exit;echo '<pre>'. print_r(count($result)) .'</pre>';

		
		if(			
			$result["email_status"] &&
			$result["email_status"] == "ALREADY_EXISTS"
		):?>

		<div class="testpassed"><p>SuperUser::updateEmail, add new email that already exists in db (should return error) – correct</p></div>
		<? else: 
			
		?>
		<div class="testfailed"><p>SuperUser::updateEmail, add new email that already exists in db (should return error) – error</p></div>
		<? endif; ?>
	

	</div>

<?
// CLEAN UP
// delete test user

cleanup:
$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
if($query->sql($sql)) {
	// delete ref user
	$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $ref_user_id";
	if($query->sql($sql)) {

	}	
	
}
message()->resetMessages();

skip_cleanup:
?>

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
		$_POST["item_price_type"] = 1;
		$_POST["item_price_quantity"] = 1;
		$price = $model->addPrice(["addPrice", $item_id]);
		unset($_POST);
		
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
		$order_id = $order ? $order["id"] : false;

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
		// print_r($result);
		if (
			!$result
			): ?>
			<div class="testpassed"><p>SuperUser::cancel (non-exisiting user_id, returns false) - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>SuperUser::cancel (non-exisiting user_id, returns false) - error</p></div>
			<? endif;
			
		$new_user_id = 0;
		$result = $UC->cancel(["cancel", $new_user_id]);
		// print_r($result);
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
			
		// CLEAN UP
		$model->delete(array("delete", $item_id));
		$sql = "DELETE FROM ".SITE_DB.".shop_payments WHERE order_id = $order_id";
		$query->sql($sql);
		$sql = "DELETE FROM ".SITE_DB.".shop_orders WHERE id = $order_id";
		$query->sql($sql);

		// user must be deleted last due to dependencies
		$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $user_id";
		$query->sql($sql);
		
		?>
	</div>
</div>
