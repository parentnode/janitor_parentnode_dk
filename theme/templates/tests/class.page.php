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

<div class="scene i:scene tests defaultEdit">
	<h1>Page</h1>	
	<h2>Testing Page class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
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
			$sql = "INSERT INTO ".SITE_DB.".user_usernames (user_id, username, type, verified, verification_code) VALUES($test_user_id, 'login@test.com', 'email', 0, '12345678')";
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
		// wrong username/password, activated	

		$_POST["username"] = "i_dont_exist@test.com";
		$_POST["password"] = "i_dont_exist";
		if(!$this->logIn()): ?>
		
		<div class="testpassed"><p>Page::logIn (wrong username/password - should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::logIn (wrong username/password - should return false) - error</p></div>
		<? endif; 
		unset($_POST);
	
		?>

		<?
		// no password, not activated, not verified

		// deactivate user
		$sql = "UPDATE ".SITE_DB.".users SET status = 0 WHERE id = $test_user_id";
		$query->sql($sql);

		$_POST["username"] = "login@test.com";
		$_POST["password"] = "i_dont_exist";
		$result = $this->logIn(); 
		
		if($result["status"] == "NOT_VERIFIED" && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed"><p>Page::logIn (no password, not activated, not verified - should return NOT_VERIFIED) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::logIn (no password, not activated, not verified - should return NOT_VERIFIED) - error</p></div>
		<? endif; 
		unset($_POST);
		?>

		<?
		// no password, activated, not verified

		// activate user
		$sql = "UPDATE ".SITE_DB.".users SET status = 0 WHERE id = $test_user_id";
		$query->sql($sql);

		$_POST["username"] = "login@test.com";
		$_POST["password"] = "i_dont_exist";
		$result = $this->logIn(); 
		// print_r ($result); exit;
		
		if($result["status"] == "NOT_VERIFIED" && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed"><p>Page::logIn (no password, activated, not verified - should return NOT_VERIFIED) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::logIn (no password, activated, not verified - should return NOT_VERIFIED) - error</p></div>
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

		$_POST["username"] = "login@test.com";
		$_POST["password"] = "i_dont_exist";
		$result = $this->logIn(); 
		// print_r ($result); exit;
		
		if($result["status"] == "NO_PASSWORD" && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed"><p>Page::logIn (no password, activated, verified - should return NO_PASSWORD) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::logIn (no password, activated, verified - should return NO_PASSWORD) - error</p></div>
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

		$_POST["username"] = "login@test.com";
		$_POST["password"] = "i_dont_exist";
		$result = $this->logIn(); 
		
		if($result == false && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed"><p>Page::logIn (no password, not activated, verified - should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::logIn (no password, not activated, verified - should return false) - error</p></div>
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
		
		$_POST["username"] = "login@test.com";
		$_POST["password"] = "test_password";
		
		$result = $this->logIn();
		if($result == false && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"): ?>
		
		<div class="testpassed"><p>Page::logIn (correct username/password, not activated - should return false) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::logIn (correct username/password, not activated - should return false) - error</p></div>
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

		$_POST["username"] = "login@test.com";
		$_POST["password"] = "test_password";
		$result = $this->logIn(); 
		
		
		if($result["status"] == "NOT_VERIFIED" && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed"><p>Page::logIn (correct username/password, activated, not verified - should return NOT_VERIFIED) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::logIn (correct username/password, activated, not verified - should return NOT_VERIFIED) - error</p></div>
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
			"post_fields" => "username=login@test.com&password=test_password&login_forward=/login/login_test&ajaxlogin=true",
			"cookiejar" => "-"
		];
		
		$curl->init($params);
		$url = SITE_URL."/login?login=true";
		$result = $curl->exec($url);

		preg_match("/cms_status\":\"success/", $result["body"], $ajaxlogin_match);

		// run test condition
		if($ajaxlogin_match && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed"><p>Page::logIn (correct username/password, activated, verified, ajax login - should return CSRF token) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::logIn (correct username/password, activated, verified, ajax login - should return CSRF token) - error</p></div>
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
			"post_fields" => "username=login@test.com&password=test_password&login_forward=/login/login_test",
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
		if($requested_user_id == $test_user_id && $ref_username == "ref@test.com" && $ref_verification_code == "87654321"): ?>

		<div class="testpassed"><p>Page::logIn (correct username/password, activated, verified) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::logIn (correct username/password, activated, verified) - error</p></div>
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

	<div class="tests">
		<h3>Page::language</h3>
		<? if($this->language() == DEFAULT_LANGUAGE_ISO): ?>
		<div class="testpassed"><p>Page::language (GET DEFAULT) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::language (GET DEFAULT) - error</p></div>
		<? endif; ?>

		<? 
		$this->language("DA");
		if($this->language() == "DA"):
		?>
		<div class="testpassed"><p>Page::language (SET DA) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::language (SET DA) - error</p></div>
		<? endif; ?>

		<? 
		$this->language("DE");
		if($this->language() == "DE"):
		?>
		<div class="testpassed"><p>Page::language (SET DE) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::language (SET DE) - error</p></div>
		<? endif; ?>

		<? 
		$this->language("XX");
		if($this->language() == "EN"):
		?>
		<div class="testpassed"><p>Page::language (SET XX - should return DEFAULT_LANGUAGE_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::language (SET XX - should return DEFAULT_LANGUAGE_ISO) - error</p></div>
		<? endif; ?>

		<?
		// set back to default
		$this->language(DEFAULT_LANGUAGE_ISO);
		?>
	</div>

	<div class="tests">
		<h3>Page::languages</h3>
		<?
		$languages = $this->languages();
		if(is_array($languages) && arrayKeyValue($languages, "id", "DA") !== false && arrayKeyValue($languages, "id", "EN") !== false):
		?>
		<div class="testpassed"><p>Page::languages (GET ALL) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::languages (GET ALL) - error</p></div>
		<? endif; ?>

		<?
		$language_details = $this->languages("DA");
		if(is_array($language_details) && $language_details["id"] == "DA"):
		?>
		<div class="testpassed"><p>Page::languages (GET DA) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::languages (GET DA) - error</p></div>
		<? endif; ?>

		<?
		$language_details = $this->languages("DE");
		if(is_array($language_details) && $language_details["id"] == "DE"):
		?>
		<div class="testpassed"><p>Page::languages (GET DE) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::languages (GET DE) - error</p></div>
		<? endif; ?>

		<?
		$language_details = $this->languages("XX");
		if(is_array($language_details) && $language_details["id"] == "EN"):
		?>
		<div class="testpassed"><p>Page::languages (GET XX - should return details for DEFAULT_LANGUAGE_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::languages (GET XX - should return details for DEFAULT_LANGUAGE_ISO) - error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>Page::country</h3>
		<? if($this->country() == DEFAULT_COUNTRY_ISO): ?>
		<div class="testpassed"><p>Page::country (GET DEFAULT) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::country (GET DEFAULT) - error</p></div>
		<? endif; ?>

		<? 
		$this->country("DK");
		if($this->country() == "DK"):
		?>
		<div class="testpassed"><p>Page::country (SET DK) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::country (SET DK) - error</p></div>
		<? endif; ?>

		<? 
		$this->country("DE");
		if($this->country() == "DE"):
		?>
		<div class="testpassed"><p>Page::country (SET DE) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::country (SET DE) - error</p></div>
		<? endif; ?>

		<? 
		$this->country("XX");
		if($this->country() == "DK"):
		?>
		<div class="testpassed"><p>Page::country (SET XX - should return DEFAULT_COUNTRY_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::country (SET XX - should return DEFAULT_COUNTRY_ISO) - error</p></div>
		<? endif; ?>

		<?
		// set back to default
		$this->country(DEFAULT_COUNTRY_ISO);
		?>
	</div>

	<div class="tests">
		<h3>Page::countries</h3>
		<?
		$countries = $this->countries();
		if(is_array($countries) && arrayKeyValue($countries, "id", "DK") !== false && arrayKeyValue($countries, "id", "DE") !== false):
		?>
		<div class="testpassed"><p>Page::countries (GET ALL) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::countries (GET ALL) - error</p></div>
		<? endif; ?>

		<?
		$country_details = $this->countries("DK");
		if(is_array($country_details) && $country_details["id"] == "DK"):
		?>
		<div class="testpassed"><p>Page::countries (GET DA) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::countries (GET DA) - error</p></div>
		<? endif; ?>

		<?
		$country_details = $this->countries("DE");
		if(is_array($country_details) && $country_details["id"] == "DE"):
		?>
		<div class="testpassed"><p>Page::countries (GET DE) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::countries (GET DE) - error</p></div>
		<? endif; ?>

		<?
		$country_details = $this->countries("XX");
		if(is_array($country_details) && $country_details["id"] == "DK"):
		?>
		<div class="testpassed"><p>Page::countries (GET XX - should return details for DEFAULT_COUNTRY_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::countries (GET XX - should return details for DEFAULT_COUNTRY_ISO) - error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>Page::currency</h3>
		<? if($this->currency() == DEFAULT_CURRENCY_ISO): ?>
		<div class="testpassed"><p>Page::currency (GET DEFAULT) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currency (GET DEFAULT) - error</p></div>
		<? endif; ?>

		<? 
		$this->currency("DKK");
		if($this->currency() == "DKK"):
		?>
		<div class="testpassed"><p>Page::currency (SET DK) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currency (SET DK) - error</p></div>
		<? endif; ?>

		<? 
		$this->currency("EUR");
		if($this->currency() == "EUR"):
		?>
		<div class="testpassed"><p>Page::currency (SET EUR) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currency (SET EUR) - error</p></div>
		<? endif; ?>

		<? 
		$this->currency("XX");
		if($this->currency() == "DKK"):
		?>
		<div class="testpassed"><p>Page::currency (SET XX - should return DEFAULT_CURRENCY_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currency (SET XX - should return DEFAULT_CURRENCY_ISO) - error</p></div>
		<? endif; ?>

		<?
		// set back to default
		$this->currency(DEFAULT_CURRENCY_ISO);
		?>
	</div>

	<div class="tests">
		<h3>Page::currencies</h3>
		<?
		$currencies = $this->currencies();
		if(is_array($currencies) && arrayKeyValue($currencies, "id", "DKK") !== false && arrayKeyValue($currencies, "id", "EUR") !== false):
		?>
		<div class="testpassed"><p>Page::currencies (GET ALL) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currencies (GET ALL) - error</p></div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("DKK");
		if(is_array($currency_details) && $currency_details["id"] == "DKK"):
		?>
		<div class="testpassed"><p>Page::currencies (GET DKK) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currencies (GET DKK) - error</p></div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("EUR");
		if(is_array($currency_details) && $currency_details["id"] == "EUR"):
		?>
		<div class="testpassed"><p>Page::currencies (GET EUR) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currencies (GET EUR) - error</p></div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("XXX");
		if(is_array($currency_details) && $currency_details["id"] == "DKK"):
		?>
		<div class="testpassed"><p>Page::currencies (GET XX - should return details for DEFAULT_CURRENCY_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currencies (GET XX - should return details for DEFAULT_CURRENCY_ISO) - error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>Page::vatrates</h3>
		<?
		$vatrates = $this->vatrates();
		if(is_array($vatrates) && arrayKeyValue($vatrates, "country", "DK") !== false):
		?>
		<div class="testpassed"><p>Page::vatrates (GET ALL) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::vatrates (GET ALL) - error</p></div>
		<? endif; ?>

		<?
		$vatrate_details = $this->vatrates(1);
		if(is_array($vatrate_details) && $vatrate_details["country"] == "DK"):
		?>
		<div class="testpassed"><p>Page::vatrates (GET id=1) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::vatrates (GET id=1) - error</p></div>
		<? endif; ?>

		<?
		$vatrate_details = $this->vatrates(9999);
		if($vatrate_details === false):
		?>
		<div class="testpassed"><p>Page::vatrates (GET id=9999) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::vatrates (GET id=9999) - error</p></div>
		<? endif; ?>

	</div>


</div>