<?
global $model;

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

$UpgradeClass->checkDefaultValues(UT_VATRATES, "DEFAULT, 'No VAT', 0, 'DK'", "country = 'DK'");

// clear cached values
cache()->reset("languages");
cache()->reset("countries");
cache()->reset("currencies");
cache()->reset("vatrates");
?>

<div class="scene i:scene tests">
	<h1>Page</h1>	
	<h2>Testing Page class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests logIn">
		<h3>Page::logIn</h3>
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
		if(!$this->logIn()): ?>
		
		<div class="testpassed">Page::logIn (wrong username/password - should return false) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::logIn (wrong username/password - should return false) - error</div>
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
		$result = $this->logIn(); 
		
		if($result["status"] == "NOT_VERIFIED" && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Page::logIn (no password, not activated, not verified - should return NOT_VERIFIED) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::logIn (no password, not activated, not verified - should return NOT_VERIFIED) - error</div>
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
		$result = $this->logIn(); 
		// print_r ($result); exit;
		
		if($result["status"] == "NOT_VERIFIED" && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Page::logIn (no password, activated, not verified - should return NOT_VERIFIED) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::logIn (no password, activated, not verified - should return NOT_VERIFIED) - error</div>
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
		$result = $this->logIn(); 
		// print_r ($result); exit;
		
		if($result["status"] == "NO_PASSWORD" && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Page::logIn (no password, activated, verified - should return NO_PASSWORD) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::logIn (no password, activated, verified - should return NO_PASSWORD) - error</div>
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
		$result = $this->logIn(); 
		
		if($result == false && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Page::logIn (no password, not activated, verified - should return false) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::logIn (no password, not activated, verified - should return false) - error</div>
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
		
		$result = $this->logIn();
		if($result == false && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>
		
		<div class="testpassed">Page::logIn (correct username/password, not activated - should return false) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::logIn (correct username/password, not activated - should return false) - error</div>
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
		$result = $this->logIn(); 
		
		
		if($result["status"] == "NOT_VERIFIED" && $ref_username == "test3.parentnode@gmail.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed">Page::logIn (correct username/password, activated, not verified - should return NOT_VERIFIED) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::logIn (correct username/password, activated, not verified - should return NOT_VERIFIED) - error</div>
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

		<div class="testpassed">Page::logIn (correct username/password, activated, verified, ajax login - should return CSRF token) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::logIn (correct username/password, activated, verified, ajax login - should return CSRF token) - error</div>
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

		<div class="testpassed">Page::logIn (correct username/password, activated, verified) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::logIn (correct username/password, activated, verified) - error</div>
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

	<div class="tests language">
		<h3>Page::language</h3>
		<? if($this->language() == DEFAULT_LANGUAGE_ISO): ?>
		<div class="testpassed">Page::language (GET DEFAULT) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::language (GET DEFAULT) - error</div>
		<? endif; ?>

		<? 
		$this->language("DA");
		if($this->language() == "DA"):
		?>
		<div class="testpassed">Page::language (SET DA) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::language (SET DA) - error</div>
		<? endif; ?>

		<? 
		$this->language("DE");
		if($this->language() == "DE"):
		?>
		<div class="testpassed">Page::language (SET DE) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::language (SET DE) - error</div>
		<? endif; ?>

		<? 
		$this->language("XX");
		if($this->language() == "EN"):
		?>
		<div class="testpassed">Page::language (SET XX - should return DEFAULT_LANGUAGE_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::language (SET XX - should return DEFAULT_LANGUAGE_ISO) - error</div>
		<? endif; ?>

		<?
		// set back to default
		$this->language(DEFAULT_LANGUAGE_ISO);
		?>
	</div>

	<div class="tests languages">
		<h3>Page::languages</h3>
		<?
		$languages = $this->languages();
		if(is_array($languages) && arrayKeyValue($languages, "id", "DA") !== false && arrayKeyValue($languages, "id", "EN") !== false):
		?>
		<div class="testpassed">Page::languages (GET ALL) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::languages (GET ALL) - error</div>
		<? endif; ?>

		<?
		$language_details = $this->languages("DA");
		if(is_array($language_details) && $language_details["id"] == "DA"):
		?>
		<div class="testpassed">Page::languages (GET DA) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::languages (GET DA) - error</div>
		<? endif; ?>

		<?
		$language_details = $this->languages("DE");
		if(is_array($language_details) && $language_details["id"] == "DE"):
		?>
		<div class="testpassed">Page::languages (GET DE) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::languages (GET DE) - error</div>
		<? endif; ?>

		<?
		$language_details = $this->languages("XX");
		if(is_array($language_details) && $language_details["id"] == "EN"):
		?>
		<div class="testpassed">Page::languages (GET XX - should return details for DEFAULT_LANGUAGE_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::languages (GET XX - should return details for DEFAULT_LANGUAGE_ISO) - error</div>
		<? endif; ?>
	</div>

	<div class="tests country">
		<h3>Page::country</h3>
		<? if($this->country() == DEFAULT_COUNTRY_ISO): ?>
		<div class="testpassed">Page::country (GET DEFAULT) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::country (GET DEFAULT) - error</div>
		<? endif; ?>

		<? 
		$this->country("DK");
		if($this->country() == "DK"):
		?>
		<div class="testpassed">Page::country (SET DK) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::country (SET DK) - error</div>
		<? endif; ?>

		<? 
		$this->country("DE");
		if($this->country() == "DE"):
		?>
		<div class="testpassed">Page::country (SET DE) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::country (SET DE) - error</div>
		<? endif; ?>

		<? 
		$this->country("XX");
		if($this->country() == "DK"):
		?>
		<div class="testpassed">Page::country (SET XX - should return DEFAULT_COUNTRY_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::country (SET XX - should return DEFAULT_COUNTRY_ISO) - error</div>
		<? endif; ?>

		<?
		// set back to default
		$this->country(DEFAULT_COUNTRY_ISO);
		?>
	</div>

	<div class="tests countries">
		<h3>Page::countries</h3>
		<?
		$countries = $this->countries();
		if(is_array($countries) && arrayKeyValue($countries, "id", "DK") !== false && arrayKeyValue($countries, "id", "DE") !== false):
		?>
		<div class="testpassed">Page::countries (GET ALL) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::countries (GET ALL) - error</div>
		<? endif; ?>

		<?
		$country_details = $this->countries("DK");
		if(is_array($country_details) && $country_details["id"] == "DK"):
		?>
		<div class="testpassed">Page::countries (GET DA) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::countries (GET DA) - error</div>
		<? endif; ?>

		<?
		$country_details = $this->countries("DE");
		if(is_array($country_details) && $country_details["id"] == "DE"):
		?>
		<div class="testpassed">Page::countries (GET DE) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::countries (GET DE) - error</div>
		<? endif; ?>

		<?
		$country_details = $this->countries("XX");
		if(is_array($country_details) && $country_details["id"] == "DK"):
		?>
		<div class="testpassed">Page::countries (GET XX - should return details for DEFAULT_COUNTRY_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::countries (GET XX - should return details for DEFAULT_COUNTRY_ISO) - error</div>
		<? endif; ?>
	</div>

	<div class="tests currency">
		<h3>Page::currency</h3>
		<? if($this->currency() == DEFAULT_CURRENCY_ISO): ?>
		<div class="testpassed">Page::currency (GET DEFAULT) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currency (GET DEFAULT) - error</div>
		<? endif; ?>

		<? 
		$this->currency("DKK");
		if($this->currency() == "DKK"):
		?>
		<div class="testpassed">Page::currency (SET DK) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currency (SET DK) - error</div>
		<? endif; ?>

		<? 
		$this->currency("EUR");
		if($this->currency() == "EUR"):
		?>
		<div class="testpassed">Page::currency (SET EUR) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currency (SET EUR) - error</div>
		<? endif; ?>

		<? 
		$this->currency("XX");
		if($this->currency() == "DKK"):
		?>
		<div class="testpassed">Page::currency (SET XX - should return DEFAULT_CURRENCY_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currency (SET XX - should return DEFAULT_CURRENCY_ISO) - error</div>
		<? endif; ?>

		<?
		// set back to default
		$this->currency(DEFAULT_CURRENCY_ISO);
		?>
	</div>

	<div class="tests currencies">
		<h3>Page::currencies</h3>
		<?
		$currencies = $this->currencies();
		if(is_array($currencies) && arrayKeyValue($currencies, "id", "DKK") !== false && arrayKeyValue($currencies, "id", "EUR") !== false):
		?>
		<div class="testpassed">Page::currencies (GET ALL) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currencies (GET ALL) - error</div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("DKK");
		if(is_array($currency_details) && $currency_details["id"] == "DKK"):
		?>
		<div class="testpassed">Page::currencies (GET DKK) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currencies (GET DKK) - error</div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("EUR");
		if(is_array($currency_details) && $currency_details["id"] == "EUR"):
		?>
		<div class="testpassed">Page::currencies (GET EUR) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currencies (GET EUR) - error</div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("XXX");
		if(is_array($currency_details) && $currency_details["id"] == "DKK"):
		?>
		<div class="testpassed">Page::currencies (GET XX - should return details for DEFAULT_CURRENCY_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currencies (GET XX - should return details for DEFAULT_CURRENCY_ISO) - error</div>
		<? endif; ?>
	</div>

	<div class="tests vatrates">
		<h3>Page::vatrates</h3>
		<?
		$vatrates = $this->vatrates();
		if(is_array($vatrates) && arrayKeyValue($vatrates, "country", "DK") !== false):
		?>
		<div class="testpassed">Page::vatrates (GET ALL) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::vatrates (GET ALL) - error</div>
		<? endif; ?>

		<?
		$vatrate_details = $this->vatrates(1);
		if(is_array($vatrate_details) && $vatrate_details["country"] == "DK"):
		?>
		<div class="testpassed">Page::vatrates (GET id=1) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::vatrates (GET id=1) - error</div>
		<? endif; ?>

		<?
		$vatrate_details = $this->vatrates(9999);
		if($vatrate_details === false):
		?>
		<div class="testpassed">Page::vatrates (GET id=9999) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::vatrates (GET id=9999) - error</div>
		<? endif; ?>

	</div>

</div>