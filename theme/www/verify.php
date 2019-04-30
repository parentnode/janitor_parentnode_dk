<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$model = new User();


$page->bodyClass("verify");
$page->pageTitle("Verify");


// Verification flow
if($action) {

	// verify/confirm
	if($action[0] == "confirm") {

		if (count($action) == 1 && $page->validateCsrfToken()) {
			
			$username = session()->value("signup_email");
			$verification_code = getPost("verification_code");
			
			// Verify and enable user
			$result = $model->confirmUsername($username, $verification_code);

			// user has already been verified
			if($result && isset($result["status"]) && $result["status"] == "USER_VERIFIED") {
				message()->addMessage("You're already verified! Try logging in.", array("type" => "error"));
				header("Location: /login");
				exit();
			}

			// code is valid
			else if($result) {
				header("Location: /verify/confirm/receipt");
				exit();
			}

			// code is not valid
			else {
				message()->addMessage("Incorrect verification code, try again!", array("type" => "error"));
				header("Location: /signup/verify");
				exit();
			}
		}


		// /verify/confirm/email|mobile/#email|mobile#/#verification_code#
		else if(count($action) == 3) {
			// session()->value("signup_type", $action[1]);
			// session()->value("signup_username", $action[2]);
			
			$username = $action[1];
			$verification_code = $action[2];
			session()->value("signup_email", $username);

			// Confirm username returns either true, false or an object
			$result = $model->confirmUsername($username, $verification_code);

			// user has already been verified
			if($result && isset($result["status"]) && $result["status"] == "USER_VERIFIED") {
				message()->addMessage("You're already verified! Try logging in.", array("type" => "error"));
				header("Location: /login");
				exit();
			}

			// code is valid
			else if($result) {
				header("Location: /verify/confirm/receipt");
				exit();
			}

			// code is not valid
			else {
				// redirect to leave POST state
				header("Location: /verify/confirm/error");
				exit();
			}
		}


		else if($action[1] == "receipt") {

			$page->page(array(
				"templates" => "verify/confirmed.php"
			));
			exit();
		}
		
		else if($action[1] == "error") {
	
			$page->page(array(
				"templates" => "verify/confirmation_failed.php"
			));
			exit();
		}
	}

}

// fallback
// /login
$page->page(array(
	"templates" => "pages/login.php"
));

?>
