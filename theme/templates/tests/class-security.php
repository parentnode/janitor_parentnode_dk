<?
global $model;
$existing_rows = [];

// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();

	
?>

<div class="scene i:scene tests">
	<h1>Security</h1>	
	<h2>Testing security class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests logIn">
		<h3>Security::logIn</h3>
		<?

		?>
		
		<?
		// ADD VALUES
		// create test user, no password, activated, and also create reference user
		$query = new Query();
		
		// add test user
		$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'test user', 1, '2019-01-01 00:00:00')";
		if($query->sql($sql)) {
			$test_user_id = $query->lastInsertId();

			// add non-verified username (email) for test user
			$sql = "INSERT INTO ".SITE_DB.".user_usernames (user_id, username, type, verified, verification_code) VALUES($test_user_id, 'test.parentnode@gmail.com', 'email', 0, '12345678')";
			$query->sql($sql);
			$sql = "SELECT username, verification_code FROM ".SITE_DB.".user_usernames WHERE user_id = '$test_user_id'";
			// print ($sql); 

			if($query->sql($sql)) {
				$test_username = $query->result(0)["username"];
				$test_verification_code = $query->result(0)["verification_code"];
				
				// add reference user
				$sql = "INSERT INTO ".SITE_DB.".users (user_group_id, nickname, status, created_at) VALUES(2, 'reference user', 1, '2019-02-02 01:01:01')";
				if($query->sql($sql)) {
					$ref_user_id = $query->lastInsertId();
					
					// add non-verified username (email) for ref user
					$sql = "INSERT INTO ".SITE_DB.".user_usernames (user_id, username, type, verified, verification_code) VALUES($ref_user_id, 'test3.parentnode@gmail.com', 'email', 0, '87654321')";
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
		// wrong username/password, activated	

		$_POST["username"] = "i_dont_exist@parentnode.dk";
		$_POST["password"] = "i_dont_exist";
		if(!security()->logIn()): ?>
		
		<div class="testpassed">Security::logIn (wrong username/password - should return false) - correct</div>
		<? else: ?>
		<div class="testfailed">Security::logIn (wrong username/password - should return false) - error</div>
		<? endif; 
		unset($_POST);
	
		?>

		<?
		// no password, not activated, not verified

		// deactivate user
		$sql = "UPDATE ".SITE_DB.".users SET status = 0 WHERE id = $test_user_id";
		$query->sql($sql);

		$_POST["username"] = "test.parentnode@gmail.com";
		$_POST["password"] = "i_dont_exist";
		$result = security()->logIn(); 
		
		if($result["status"] == "NOT_VERIFIED" && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Security::logIn (no password, not activated, not verified - should return NOT_VERIFIED) - correct</div>
		<? else: ?>
		<div class="testfailed">Security::logIn (no password, not activated, not verified - should return NOT_VERIFIED) - error</div>
		<? endif; 
		unset($_POST);
		?>

		<?
		// no password, activated, not verified

		// activate user
		$sql = "UPDATE ".SITE_DB.".users SET status = 0 WHERE id = $test_user_id";
		$query->sql($sql);

		$_POST["username"] = "test.parentnode@gmail.com";
		$_POST["password"] = "i_dont_exist";
		$result = security()->logIn(); 
		// print_r ($result); exit;
		
		if($result["status"] == "NOT_VERIFIED" && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Security::logIn (no password, activated, not verified - should return NOT_VERIFIED) - correct</div>
		<? else: ?>
		<div class="testfailed">Security::logIn (no password, activated, not verified - should return NOT_VERIFIED) - error</div>
		<? endif; 
		unset($_POST);
		?>
	
		<?
		// no password, activated, verified

		// activate user
		$sql = "UPDATE ".SITE_DB.".users SET status = 1 WHERE id = $test_user_id";
		$query->sql($sql);
		// verify username
		$sql = "UPDATE ".SITE_DB.".user_usernames SET verified = 1 WHERE user_id = $test_user_id";
		$query->sql($sql); 		

		$_POST["username"] = "test.parentnode@gmail.com";
		$_POST["password"] = "i_dont_exist";
		$result = security()->logIn(); 
		// print_r ($result); exit;
		
		if($result["status"] == "NO_PASSWORD" && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Security::logIn (no password, activated, verified - should return NO_PASSWORD) - correct</div>
		<? else: ?>
		<div class="testfailed">Security::logIn (no password, activated, verified - should return NO_PASSWORD) - error</div>
		<? endif; 
		unset($_POST);
		?>		

		<?
		// no password, not activated, verified
		
		// deactivate user
		$sql = "UPDATE ".SITE_DB.".users SET status = 0 WHERE id = $test_user_id";
		$query->sql($sql);
		// verify username
		$sql = "UPDATE ".SITE_DB.".user_usernames SET verified = 1 WHERE user_id = $test_user_id";
		$query->sql($sql); 

		$_POST["username"] = "test.parentnode@gmail.com";
		$_POST["password"] = "i_dont_exist";
		$result = security()->logIn(); 
		
		if($result == false && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Security::logIn (no password, not activated, verified - should return false) - correct</div>
		<? else: ?>
		<div class="testfailed">Security::logIn (no password, not activated, verified - should return false) - error</div>
		<? endif; 
		unset($_POST);
	
		?>

		<?
		// correct username/password, not activated, verified
		
		// create hashed password
		$hashed_password = password_hash('test_password', PASSWORD_DEFAULT);
		$sql = "INSERT INTO ".SITE_DB.".user_passwords (user_id, password) VALUES($test_user_id, '$hashed_password')";
		$query->sql($sql);
		
		// deactivate user
		$sql = "UPDATE ".SITE_DB.".users SET status = 0 WHERE id = $test_user_id";
		$query->sql($sql);
		// verify username
		$sql = "UPDATE ".SITE_DB.".user_usernames SET verified = 1 WHERE user_id = $test_user_id";
		$query->sql($sql); 
		
		$_POST["username"] = "test.parentnode@gmail.com";
		$_POST["password"] = "test_password";
		
		$result = security()->logIn();
		if($result == false && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>
		
		<div class="testpassed">Security::logIn (correct username/password, not activated - should return false) - correct</div>
		<? else: ?>
		<div class="testfailed">Security::logIn (correct username/password, not activated - should return false) - error</div>
		<? endif; 
		unset($_POST);
		
		
		?>

		<?
		// correct username/password, activated, not verified
		
		// activate user
		$sql = "UPDATE ".SITE_DB.".users SET status = 1 WHERE id = $test_user_id";
		$query->sql($sql);

		// unverify username
		$sql = "UPDATE ".SITE_DB.".user_usernames SET verified = 0 WHERE user_id = $test_user_id";
		$query->sql($sql); 	

		$_POST["username"] = "test.parentnode@gmail.com";
		$_POST["password"] = "test_password";
		$result = security()->logIn(); 
		
		
		if($result["status"] == "NOT_VERIFIED" && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Security::logIn (correct username/password, activated, not verified - should return NOT_VERIFIED) - correct</div>
		<? else: ?>
		<div class="testfailed">Security::logIn (correct username/password, activated, not verified - should return NOT_VERIFIED) - error</div>
		<? endif; 
		unset($_POST);
		// exit;
		?>

		<?
		// correct username/password, activated, verified, ajax login

		// activate user
		$sql = "UPDATE ".SITE_DB.".users SET status = 1 WHERE id = $test_user_id";
		$query->sql($sql); 

		// verify username
		$sql = "UPDATE ".SITE_DB.".user_usernames SET verified = 1 WHERE user_id = $test_user_id";
		$query->sql($sql); 		
		
		// attempt to login with curl request that, if successful, returns new CSRF token
		include_once("classes/helpers/curl.class.php");
		$curl = new CurlRequest;
		$params = [
			"method" => "POST",
			"post_fields" => "username=test.parentnode@gmail.com&password=test_password&login_forward=/login/login_test&ajaxlogin=true",
			"cookiejar" => "-"
		];
		
		$curl->init($params);
		$url = SITE_URL."/login?login=true";
		$result = $curl->exec($url);

		preg_match("/cms_status\":\"success/", $result["body"], $ajaxlogin_match);

		// run test condition
		if($ajaxlogin_match && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Security::logIn (correct username/password, activated, verified, ajax login - should return CSRF token) - correct</div>
		<? else: ?>
		<div class="testfailed">Security::logIn (correct username/password, activated, verified, ajax login - should return CSRF token) - error</div>
		<? endif;?>

		<?
		// correct username/password, activated, verified, normal login

		// activate user
		$sql = "UPDATE ".SITE_DB.".users SET status = 1 WHERE id = $test_user_id";
		$query->sql($sql); 

		// verify username
		$sql = "UPDATE ".SITE_DB.".user_usernames SET verified = 1 WHERE user_id = $test_user_id";
		$query->sql($sql); 		
		
		// attempt to login with curl request that, if successful, forwards to login_test page  
		include_once("classes/helpers/curl.class.php");
		$curl = new CurlRequest;
		$params = [
			"method" => "POST",
			"post_fields" => "username=test.parentnode@gmail.com&password=test_password&login_forward=/login/login_test",
			"cookiejar" => "-"
		];
		
		$curl->init($params);
		$url = SITE_URL."/login?login=true";
		$result = $curl->exec($url);

		// prepare to parse login_test page in order to get the user_id
		include_once("classes/helpers/dom.class.php");
		$DC = new DOM();
		$dom_result = $DC->createDOM($result["body"]);

		$requested_user_id_node = $DC->getElement($dom_result, "span class='user_id'");
		$requested_user_id = $requested_user_id_node->textContent;


		// run test condition
		if($requested_user_id == $test_user_id && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Security::logIn (correct username/password, activated, verified) - correct</div>
		<? else: ?>
		<div class="testfailed">Security::logIn (correct username/password, activated, verified) - error</div>
		<? endif;?>

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

</div>