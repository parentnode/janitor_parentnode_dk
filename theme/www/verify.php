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

		if (count($action) == 1 && security()->validateCsrfToken()) {
			
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
				header("Location: /verify/receipt");
				exit();
			}

			// code is not valid
			else {
				message()->addMessage("Incorrect verification code, try again!", array("type" => "error"));
				header("Location: /verify");
				exit();
			}
		}


		// verify/confirm/#email|mobile#/#verification_code#
		else if(count($action) == 3) {
			
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
				header("Location: /verify/receipt");
				exit();
			}

			// code is not valid
			else {
				// redirect to leave POST state
				header("Location: /verify/error");
				exit();
			}
		}

	}

	// verify/receipt
	else if($action[0] == "receipt") {

		$page->page(array(
			"templates" => "verify/confirmed.php"
		));
		exit();
	}
	// verify/error
	else if($action[0] == "error") {

		$page->page(array(
			"templates" => "verify/confirmation_failed.php"
		));
		exit();
	}
	// verify/skip
	else if($action[0] == "skip") {

		$page->page([
			"templates" => "verify/verify_skip.php"
		]);
		exit();
	}

}

// fallback
// /verify
$page->page(array(
	"templates" => "verify/verify.php"
));

?>

