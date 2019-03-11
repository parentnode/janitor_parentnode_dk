<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$model = new User();


$page->bodyClass("signup");
$page->pageTitle("Signup");


// Account creation and verification flow
if($action) {

	// /signup/save
	if($action[0] == "save" && $page->validateCsrfToken()) {

		// create new user
		$user = $model->newUser(array("newUser"));

		// successful creation
		if(isset($user["user_id"])) {
			// redirect to leave POST state
			header("Location: verify");
			exit();
		}

		// user exists
		else if(isset($user["status"]) && $user["status"] == "USER_EXISTS") {
			message()->addMessage("Sorry, the computer says you either have a bad memory or a bad conscience!", array("type" => "error"));
		}
		// something went wrong
		else {
			message()->addMessage("Sorry, computer says no!", array("type" => "error"));
		}

	}


	// signup/verify
	else if($action[0] == "verify") {

		$page->page([
			"templates" => "signup/verify.php"
		]);
		exit();

	}
	// signup/skip
	else if($action[0] == "skip") {

		$page->page([
			"templates" => "signup/verify_skip.php"
		]);
		exit();

	}


	// signup/confirm
	else if($action[0] == "confirm") {

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
				header("Location: /signup/confirm/receipt");
				exit();
			}

			// code is not valid
			else {
				message()->addMessage("Incorrect verification code, try again!", array("type" => "error"));
				header("Location: verify");
				exit();
			}
		}


		// /signup/confirm/email|mobile/#email|mobile#/#verification_code#
		else if(count($action) == 3) {
			// session()->value("signup_type", $action[1]);
			// session()->value("signup_username", $action[2]);

			$username = $action[1];
			$verification_code = $action[2];

			// Confirm user returns either true, false or an object
			$result = $model->confirmUsername($username, $verification_code);

			// user has already been verified
			if($result && isset($result["status"]) && $result["status"] == "USER_VERIFIED") {
				message()->addMessage("You're already verified! Try logging in.", array("type" => "error"));
				header("Location: /login");
				exit();
			}

			// code is valid
			else if($result) {
				header("Location: /signup/confirm/receipt");
				exit();
			}

			// code is not valid
			else {
				// redirect to leave POST state
				header("Location: /signup/confirm/error");
				exit();
			}
		}


		else if($action[1] == "receipt") {

			$page->page(array(
				"templates" => "signup/confirmed.php"
			));
			exit();
		}
		
		else if($action[1] == "error") {
	
			$page->page(array(
				"templates" => "signup/confirmation_failed.php"
			));
			exit();
		}
	}

	// /signup/receipt
	else if($action[0] == "receipt") {

		$page->page(array(
			"templates" => "signup/receipt.php"
		));
		exit();
	}

}



// TODO: Find out what to do and where to put unsubscribe
if($action) {

	// post username, maillist_id and verification_token
	if($action[0] == "unsubscribe" && $page->validateCsrfToken()) {

		// successful creation
		if($model->unsubscribeUserFromMaillist(["unsubscribe", "unsubscribeUserFromMaillist"])) {

			// redirect to leave POST state
			header("Location: /signup/unsubscribed");
			exit();

		}

		$page->page(array(
			"templates" => "signup/unsubscribe.php"
		));
		exit();

	}
	// /signup/unsubscribe/#maillist_id#/#username#/#verification_code#
	else if($action[0] == "unsubscribe") {

		$page->page(array(
			"templates" => "signup/unsubscribe.php"
		));
		exit();

	}
	// /signup/unsubscribed
	else if($action[0] == "unsubscribed") {

		$page->page(array(
			"templates" => "signup/unsubscribed.php"
		));
		exit();

	}

}



// plain signup directly
// /signup
$page->page(array(
	"templates" => "signup/signup.php"
));

?>

