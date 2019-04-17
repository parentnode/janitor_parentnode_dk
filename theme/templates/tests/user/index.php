<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();
global $model;
global $action;
$page = new Page();
// $UpgradeClass->checkDefaultValues(UT_LANGUAGES);
// // $UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'DA','Dansk'", "id = 'DA'");
// // $UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'EN','English'", "id = 'EN'");
//
// $UpgradeClass->checkDefaultValues(UT_CURRENCIES);
// // $UpgradeClass->checkDefaultValues(UT_CURRENCIES, "'DKK', 'Kroner (Denmark)', 'DKK', 'after', 2, ',', '.'", "id = 'DKK'");
// // $UpgradeClass->checkDefaultValues(UT_CURRENCIES, "'EUR', 'Euro (Denmark)', '€', 'before', 2, ',', '.'", "id = 'EUR'");
//
// $UpgradeClass->checkDefaultValues(UT_COUNTRIES, "'DK', 'Danmark', '45', '#### ####', 'DA', 'DKK'", "id = 'DK'");
// $UpgradeClass->checkDefaultValues(UT_COUNTRIES, "'DE', 'Deutchland', '49', '#### ####', 'DE', 'EUR'", "id = 'DE'");
//
// $UpgradeClass->checkDefaultValues(UT_SUBSCRIPTION_METHODS, "999, 'Month', 'monthly', DEFAULT", "id = 999");
// $UpgradeClass->checkDefaultValues(UT_SUBSCRIPTION_METHODS, "998, 'Week', 'weekly', DEFAULT", "id = 998");
//
// $UpgradeClass->checkDefaultValues(UT_VATRATES, "999, 'No VAT', 0, 'DK'", "id = 999");
// $UpgradeClass->checkDefaultValues(UT_VATRATES, "998, '25%', 25, 'DK'", "id = 998");


$IC = new Items();
$model_tests = $IC->typeObject("tests");



// create test item
$_POST["name"] = "Test item";
$item = $model_tests->save(array("save"));
unset($_POST);


$UC = new User();
?>

<div class="scene i:scene tests defaultEdit">
	<h1>User</h1>	
	<h2>Testing User class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<div class="tests">
		<h3>User::getUser</h3>
		<? 
		$user = $UC->getUser();
		if(
			$user &&
			$user["nickname"] &&
			$user["email"] &&
			$user["language"] &&
			isset($user["firstname"]) &&
			isset($user["lastname"]) &&
			isset($user["mobile"]) &&
			isset($user["addresses"]) &&
			isset($user["membership"]) &&
			isset($user["newsletters"])
		): ?>
		<div class="testpassed"><p>User::getUser - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getUser - error</p></div>
		<? endif; ?>

	</div>


	<div class="tests">
		<h3>Subscriptions (without price or subscription method)</h3>
		<?

		// item without price – should succeed
		$_POST["item_id"] = $item["item_id"];
		$subscription = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			!$subscription["expires_at"] &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		$_POST["item_id"] = $item["item_id"];
		$subscription_duplet = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		if(
			$subscription_duplet == $subscription
		): ?>
		<div class="testpassed"><p>User::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $UC->getSubscriptions(array("item_id" => $item["item_id"]));
		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			!$subscription["expires_at"] &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::getSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getSubscription - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$UC->deleteSubscription(array("deleteSubscription", $subscription["id"])) &&
			!$UC->getSubscriptions(array("item_id" => $item["item_id"]))
		): ?>
		<div class="testpassed"><p>User::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::deleteSubscription, item without price or subscription method - error</p></div>
		<? endif; ?>
	</div>



	<div class="tests">
		<h3>Subscriptions (with subscription method, monthly, without price)</h3>
		<?
		// update test item (monthly)
		$_POST["item_subscription_method"] = 999;
		$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item["item_id"]));
		unset($_POST);


		// item without price – should succeed
		$_POST["item_id"] = $item["item_id"];
		$subscription = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		$expires_at = date("Y-m-d 00:00:00", time() + (date("t")*24*60*60));
		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		$_POST["item_id"] = $item["item_id"];
		$subscription_duplet = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		if(
			$subscription_duplet == $subscription
		): ?>
		<div class="testpassed"><p>User::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $UC->getSubscriptions(array("item_id" => $item["item_id"]));
		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::getSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getSubscription - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$UC->deleteSubscription(array("deleteSubscription", $subscription["id"])) &&
			!$UC->getSubscriptions(array("item_id" => $item["item_id"]))
		): ?>
		<div class="testpassed"><p>User::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::deleteSubscription, item without price or subscription method - error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>Subscriptions (with subscription method, weekly, without price)</h3>
		<?
		// update test item (monthly)
		$_POST["item_subscription_method"] = 998;
		$model_tests->updateSubscriptionMethod(array("updateSubscriptionMethod", $item["item_id"]));
		unset($_POST);


		// item without price – should succeed
		$_POST["item_id"] = $item["item_id"];
		$subscription = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		$expires_at = date("Y-m-d 00:00:00", time() + (7*24*60*60));
		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::addSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription - error</p></div>
		<? endif; ?>


		<?
		// adding existing item – should succeed (but return existing subscription)
		$_POST["item_id"] = $item["item_id"];
		$subscription_duplet = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		if(
			$subscription_duplet == $subscription
		): ?>
		<div class="testpassed"><p>User::addSubscription, adding exising item - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription, adding exising item - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $UC->getSubscriptions(array("item_id" => $item["item_id"]));
		if(
			$subscription &&
			$subscription["item_id"] == $item["item_id"] &&
			$subscription["expires_at"] == $expires_at &&
			!$subscription["payment_method"] &&
			!$subscription["order_id"]
		): ?>
		<div class="testpassed"><p>User::getSubscription - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getSubscription - error</p></div>
		<? endif; ?>


		<?
		// delete the created subscription
		if(
			$subscription && 
			$UC->deleteSubscription(array("deleteSubscription", $subscription["id"])) &&
			!$UC->getSubscriptions(array("item_id" => $item["item_id"]))
		): ?>
		<div class="testpassed"><p>User::deleteSubscription, item without price or subscription method - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::deleteSubscription, item without price or subscription method - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>Subscriptions (with subscription method, weekly, with price)</h3>
		<?
		// update test item (add price)
		$_POST["item_price"] = 100;
		$_POST["item_price_currency"] = "DKK";
		$_POST["item_price_vatrate"] = 999;
		$_POST["item_price_type"] = "default";
		$model_tests->addPrice(array("addPrice", $item["item_id"]));


		// item without price – should succeed
		$_POST["item_id"] = $item["item_id"];
		$subscription = $UC->addSubscription(array("addSubscription"));
		unset($_POST);

		if(!$subscription): ?>
		<div class="testpassed"><p>User::addSubscription (not added) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::addSubscription (not added) - error</p></div>
		<? endif; ?>


		<?
		// get the created subscription
		$subscription = $UC->getSubscriptions(array("item_id" => $item["item_id"]));
		if(!$subscription): ?>
		<div class="testpassed"><p>User::getSubscription (should not exist) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getSubscription (should not exist) - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>User::confirmUsername</h3>

		<?
		// ADD VALUES
		$query = new Query();

		// add test user
		$sql = "INSERT INTO ".SITE_DB.".users (created_at) VALUES('2019-01-01 00:00:00')";
		if($query->sql($sql)) {
			$test_user_id = $query->lastInsertId();

			$sql = "INSERT INTO ".SITE_DB.".user_usernames (user_id, username, type, verified, verification_code) VALUES($test_user_id, 'test@test.com', 'email', 0, '12345678')";
			$query->sql($sql);
			$sql = "SELECT username, verification_code FROM ".SITE_DB.".user_usernames WHERE user_id = '$test_user_id'";
			// print ($sql); 

			if($query->sql($sql)) {
				$test_username = $query->result(0)["username"];
				$test_verification_code = $query->result(0)["verification_code"];
				
				// add reference user
				$sql = "INSERT INTO ".SITE_DB.".users (created_at) VALUES('2019-02-02 01:01:01')";
				if($query->sql($sql)) {
					$ref_user_id = $query->lastInsertId();
					
					$sql = "INSERT INTO ".SITE_DB.".user_usernames (user_id, username, type, verified, verification_code) VALUES($ref_user_id, 'ref@test.com', 'email', 0, '87654321')";
					$query->sql($sql);
					$sql = "SELECT username, verification_code FROM ".SITE_DB.".user_usernames WHERE user_id = '$ref_user_id'";
					if($query->sql($sql)) {
						$ref_username = $query->result(0)["username"];
						$ref_verification_code = $query->result(0)["verification_code"];
					}
				}
			}
		}

		?>
		
		<?
		// unverified user with wrong code
		$test_result_wrong_code = $UC->confirmUsername($test_username, "00000000");
		
		if(
			$test_result_wrong_code == false && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"
		): ?>
		<div class="testpassed"><p>User::confirmUsername, wrong verification code - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::confirmUsername, wrong verification code - error</p></div>
		<? endif; 
		?>		
		
		<?
		// unverified user with correct code

		$test_result_correct_code = $UC->confirmUsername($test_username, $test_verification_code);
		
		if($test_result_correct_code && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"): ?>
		<div class="testpassed"><p>User::confirmUsername, correct verification code - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::confirmUsername, correct verification code - error</p></div>
		<? endif; 
		?>

		<?
		// already verified user 
		
		$test_result_already_verified = $UC->confirmUsername($test_username, $test_verification_code);
		
		if(
			$test_result_already_verified == ["status"=>"USER_VERIFIED"] && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"
		): ?>
		<div class="testpassed"><p>User::confirmUsername, already verified user - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::confirmUsername, already verified user - error</p></div>
		<? endif; 
		?>

		<?
		// CLEAN UP
		// delete test user
		$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $test_user_id";
		if($query->sql($sql)) {
			// delete ref user
			$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $ref_user_id";
			if($query->sql($sql)) {

			}	
			
		}
		// should there be an error message if something goes wrong here?

		?>

	</div>
	
	<div class="tests">
		<h3>User::setPassword</h3>
		<?
		
		// add test user
		// 
		include_once("classes/users/superuser.class.php");
		$SU = new SuperUser();
		$test_user_name = "testuser@test.com";
		$test_user_password = "test_password";
		
		$_POST["nickname"] = "testuser@test.com";
		$_POST["user_group_id"] = 3;
		$user = $SU->save(["save"]);
		unset($_POST);
	
		$user_id = $user["item_id"];
		$_POST["email"] = "testuser@test.com";
		$SU->updateEmail(["updateEmail", $user["item_id"]]);
		unset($_POST);
		
		$verification = $SU->getVerificationCode("email", $test_user_name);
		$UC->confirmUsername($test_user_name, $verification);
		// print_r($verification);
		unset($_POST);
		

		$_POST["password"] = "test_password";
		$SU->setPassword(["setPassword", $user_id]);
		unset($_POST);
		
		
		include_once("classes/helpers/curl.class.php");
		$curl = new CurlRequest;
		$params = [
			"method" => "POST",
			"post_fields" => "username=testuser@test.com&password=test_password&ajaxlogin=true",
			"cookiejar" => "-"
		];
		$curl->init($params);
		$url = SITE_URL."/login?login=true";
		$login_result = $curl->exec($url);
		$body = $login_result["body"];
		$result = json_decode($body, true);
		if 	(
			$result["cms_object"] &&
			$result["cms_object"]["csrf-token"] &&
			$result["cms_status"] &&
			$result["cms_status"] == "success"
			): ?>
			<div class="testpassed"><p>User::setPassword (Set password, user does not have password already) - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>User::setPassword (Set password, user does not have password already) - error</p></div>
			<? endif; 
		// // get CSRF and Cookie after logging in
		$csrf = $model->getCSRF($login_result);
		$cookie = $model->getCookie($login_result);
		
		
		$params = [
			"header" => array("Cookie: ".$cookie),
			"method" => "POST",
			"post_fields" => "old_password=wrong_password&new_password=new_test_password&csrf-token=".$csrf
		];
		$curl->init($params);
		$result = $curl->exec(SITE_URL."/janitor/admin/profile/setPassword");
		$body = $result["body"]; 
		$result = json_decode($body, true);
		if (
		
			$result["cms_object"] &&
			$result["cms_object"]["error"] &&
			$result["cms_object"]["error"] == "wrong_password" &&
			$result["cms_status"] == "error"
			): ?>
			<div class="testpassed"><p>User::setPassword (incorrect old password, password not set) - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>User::setPassword (incorrect old password, password not set) - error</p></div>
			<? endif; 
		
			$params = [
				"header" => array("Cookie: ".$cookie),
				"method" => "POST",
				"post_fields" => "old_password=test_password&new_password=new_test_password&csrf-token=".$csrf
			];
			$curl->init($params);
			$result = $curl->exec(SITE_URL."/janitor/admin/profile/setPassword");
			$body = $result["body"]; 
			$result = json_decode($body, true);
		if 	(
			$result["cms_object"] == true &&
			$result["cms_status"] == "success"
			): ?>
			<div class="testpassed"><p>User::setPassword (Set password, correct old password) - correct</p></div>
			<? else: ?>
			<div class="testfailed"><p>User::setPassword (Set password, correct old password) - error</p></div>
			<? endif; 
		
		
		?>
	</div>

</div>
<?


	// CLEAN UP
	$model_tests->delete(array("delete", $item["item_id"]));
	$sql = "DELETE FROM ".SITE_DB.".user_members WHERE user_id = $user_id";
	$query->sql($sql);
	$sql = "DELETE FROM ".SITE_DB.".users WHERE id = $user_id";
	$query->sql($sql);
	
	// $model->delete(array("delete", $membership_without_price["item_id"]));
?>