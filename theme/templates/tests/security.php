<?php

if(defined("SITE_INSTALL") && SITE_INSTALL) {
	print "Process will loop, if you run this test in SITE_INSTALL mode.<br>\n";
	exit();
}


// test if path is accessible
function testPath($path, $allowed) {

	$result = security()->validatePath($path);
	if(($result && $allowed) || (!$result && !$allowed)) {
		print '<div class="testpassed">'.$path."</div>\n";
	}
	else {
		print '<div class="testfailed">'.$path."</div>\n";
	}

}

function curlTest($url, $options, $allowed) {

	$result = curl()->request($url, $options);
	// debug([$result]);

	if(
		$result["http_code"] == 200 && 
		(
			// ($allowed && !preg_match("/\/login$/", $result['last_url']))
			//
			// ||

			(!$allowed && preg_match("/\/login$/", $result['last_url']) && $url !== $result['last_url'])

			||

			($allowed && preg_replace("/\/$/", "", $result['last_url']) == preg_replace("/\/$/", "", $url))
		)
	
		|| 
	
		($result["http_code"] == 404 && !$allowed)
	) {
		print '<div class="testpassed"><p>'.$url.": ".$result['http_code']." (".$result['last_url'].")</p></div>\n";
	}
	else {
		print '<div class="testfailed"><p>'.$url.": ".$result['http_code']." (".$result['last_url'].")</p></div>\n";
	}

	return $result;

}

?>


<div class="scene i:scene tests">
	<h1>Security tests</h1>	
	<h2>Testing Janitor access validation</h2>

	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<div class="tests">
		<h3>Testing prevalidation - User group 1</h3>
		<?

		if(1 && "Testing prevalidation - User group 1") {

			(function() {

				// ARRANGE 

				$current_user_group = session()->value("user_group_id");
				security()->resetRuntimeValues();
				session()->value("user_group_id", 1);


				// ACT

				testPath("/janitor/admin/user/list", false);
				testPath("/", true);
				testPath("/janitor/admin/404", true);
				testPath("/login", true);
				testPath("/docs", true);
				testPath("/janitor/admin/user/delete/1", false);
				testPath("/janitor/admin/users/list", false);
				testPath("/janitor/user/list", false);
				testPath("/janitor/tests", false);
				testPath("/janitor", false);


				// CLEANUP

				security()->resetRuntimeValues();
				session()->value("user_group_id", $current_user_group);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing prevalidation - User group 3</h3>
		<?

		if(1 && "Testing prevalidation - User group 3") {

			(function() {

				// ARRANGE 

				$current_user_group = session()->value("user_group_id");
				security()->resetRuntimeValues();
				session()->value("user_group_id", 3);


				// ACT

				testPath("/", true);
				testPath("/janitor/tests", true);
				testPath("/login", true);
				testPath("/getting-started", true);
				testPath("/janitor/admin/user/list", true);
				testPath("/janitor/admin/user/delete/1", true);
				testPath("/janitor/admin/users/list", false);
				testPath("/janitor", true);


				// CLEANUP

				security()->resetRuntimeValues();
				session()->value("user_group_id", $current_user_group);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP GET requests: unrestricted pages</h3>
		<?

		if(1 && "Testing HTTP GET requests: unrestricted pages") {

			(function() {

				// ARRANGE 


				// ACT

				curlTest(SITE_URL, ["method" => "GET"], true);
				curlTest(SITE_URL."/", ["method" => "GET"], true);
				curlTest(SITE_URL."/getting-started", ["method" => "GET"], true);
				curlTest(SITE_URL."/janitor/js/seg_desktop.js", ["method" => "GET"], true);

				// CLEANUP

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP GET requests: missing pages</h3>
		<?

		if(1 && "Testing HTTP GET requests: missing pages") {

			(function() {

				// ARRANGE 


				// ACT

				curlTest(SITE_URL."/janitor/user/list", ["method" => "GET"], false);
				curlTest(SITE_URL."/bad-url", ["method" => "GET"], false);

				// CLEANUP

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP GET requests: restricted pages</h3>
		<?

		if(1 && "Testing HTTP GET requests: restricted pages") {

			(function() {

				// ARRANGE 


				// ACT

				curlTest(SITE_URL."/janitor", ["method" => "GET"], false);
				curlTest(SITE_URL."/janitor/tests", ["method" => "GET"], false);
				curlTest(SITE_URL."/janitor/admin/post/new", ["method" => "GET"], false);
				curlTest(SITE_URL."/janitor/admin/post", ["method" => "GET"], false);
				curlTest(SITE_URL."/janitor/admin/user/list", ["method" => "GET"], false);
				curlTest(SITE_URL."/janitor/admin/items/tags", ["method" => "GET"], false);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP GET requests: data-manipulation</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$name = "Test item – ".randomKey(4);
				$test_item_id = $test_model->createTestItem([
					"name" => $name,
					"status" => 1
				]);

				$item_1 = $IC->getItem(["id" => $test_item_id, "extend" => true]);


				// ACT

				$result = curlTest(SITE_URL."/janitor/tests/status/".$test_item_id."/0", ["method" => "GET"], false);

				$result = curlTest(SITE_URL."/janitor/tests/delete/".$test_item_id, ["method" => "GET"], false);

				$item_2 = $IC->getItem(["id" => $test_item_id, "extend" => true]);


				// ASSERT 

				if(
					$item_1 &&
					$item_1["name"] === $name &&
					$item_1["status"] == 1 &&
					$item_2 &&
					$item_1 === $item_2
				): ?>
				<div class="testpassed"><p>GET data-manipulation – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>GET data-manipulation – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		?>
	</div>


	<div class="tests">
		<h3>Testing HTTP GET requests WITH Session, CSRF and Cookie</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				// ACT

				$result_1 = curlTest(SITE_URL."/login", [
					"method" => "GET"
				], true);

				// when sending cookie, csrf should be the same between requests
				$csrf_1 = $test_model->getCSRF($result_1);
				$cookie_1 = $test_model->getCookie($result_1);


				$result_2 = curlTest(SITE_URL."/login", [
					"method" => "GET",
					"header" => array("Cookie: ".$cookie_1), 
				], true);


				// test if session is established
				$csrf_2 = $test_model->getCSRF($result_2);
				$cookie_2 = $test_model->getCookie($result_2);


				// ASSERT 

				if(
					$csrf_1 &&
					$csrf_2 &&
					$csrf_1 == $csrf_2 &&
					$cookie_1 &&
					$cookie_2 &&
					$cookie_1 === $cookie_2
				): ?>
				<div class="testpassed"><p>Session established</p></div>
				<? else: ?>
				<div class="testfailed"><p>Session failed</p></div>
				<? endif; 

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP POST requests: unrestricted pages</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 


				// ACT

				curlTest(SITE_URL."/", ["method" => "POST"], true);
				curlTest(SITE_URL."/getting-started", ["method" => "POST"], true);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP POST requests: restricted pages</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				// ACT

				curlTest(SITE_URL."/janitor/tests", ["method" => "POST"], false);
				curlTest(SITE_URL."/janitor/tests/security", ["method" => "POST"], false);
				curlTest(SITE_URL."/janitor/admin/post/new", ["method" => "POST"], false);
				curlTest(SITE_URL."/janitor/admin/post", ["method" => "POST"], false);
				curlTest(SITE_URL."/janitor/admin/user/list", ["method" => "POST"], false);
				curlTest(SITE_URL."/janitor/admin/items/tags", ["method" => "POST"], false);

			})();

		}

		?>
	</div>


	<div class="tests">
		<h3>Testing HTTP POST requests: advanced requests</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$name = "Test item – ".randomKey(4);
				$test_item_id = $test_model->createTestItem([
					"name" => $name,
					"status" => 1
				]);

				$item_1 = $IC->getItem(["id" => $test_item_id, "extend" => true]);


				// ACT

				curlTest(SITE_URL."/janitor/admin/items/status/".$test_item_id."/0", ["method" => "POST"], false);

				curlTest(SITE_URL."/janitor/admin/items/delete/".$test_item_id, ["method" => "POST"], false);

				$result = curlTest(SITE_URL."/janitor/admin/items/update/".$test_item_id, [
					"method" => "POST",
					"post_fields" => "name=hacked"
				], false);

				$item_2 = $IC->getItem(["id" => $test_item_id, "extend" => true]);


				// ASSERT 

				if(
					$item_1 &&
					$item_1["name"] === $name &&
					$item_1["status"] == 1 &&
					$item_2 &&
					$item_1 === $item_2
				): ?>
				<div class="testpassed"><p>POST data-manipulation – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>POST data-manipulation – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		?>
	</div>


	<div class="tests">
		<h3>Testing HTTP POST requests WITH Session, CSRF and Cookie</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				// ACT

				// parse last result (should be done on result with login form)
				$result_1 = curlTest(SITE_URL."/login", [
					"method" => "post"
				], true);

				// when sending cookie, csrf should be the same between requests
				$csrf_1 = $test_model->getCSRF($result_1);
				$cookie_1 = $test_model->getCookie($result_1);


				$result_2 = curlTest(SITE_URL."/login", [
					"method" => "POST",
					"header" => array("Cookie: ".$cookie_1), 
				], true);
				$cookie_2 = $test_model->getCookie($result_2);


				// test if session is established
				$csrf_2 = $test_model->getCSRF($result_2);


				// ASSERT 

				if(
					$csrf_1 &&
					$csrf_2 &&
					$csrf_1 == $csrf_2 &&
					$cookie_1 &&
					$cookie_2 &&
					$cookie_1 === $cookie_2
				): ?>
				<div class="testpassed"><p>Session established</p></div>
				<? else: ?>
				<div class="testfailed"><p>Session failed</p></div>
				<? endif; 

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP POST requests WITH Session, CSRF and Cookie (unrestricted pages)</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				// ACT

				// parse last result (should be done on result with login form)
				$result_1 = curlTest(SITE_URL."/login", [
					"method" => "post"
				], true);
				$csrf_1 = $test_model->getCSRF($result_1);
				$cookie_1 = $test_model->getCookie($result_1);

				// Using cookie
				$result_2 = curlTest(SITE_URL."/", [
					"method" => "POST",
					"header" => array("Cookie: ".$cookie_1), 
				], true);
				$cookie_2 = $test_model->getCookie($result_2);

				// Using cookie
				$result_3 = curlTest(SITE_URL."/getting-started", [
					"method" => "POST", 
					"header" => array("Cookie: ".$cookie_1), 
				], true);
				$cookie_3 = $test_model->getCookie($result_3);

				// Using cookie
				$result_4 = curlTest(SITE_URL."/login", [
					"method" => "POST", 
					"header" => array("Cookie: ".$cookie_1), 
				], true);
				$csrf_4 = $test_model->getCSRF($result_4);
				$cookie_4 = $test_model->getCookie($result_4);

				// NOT using cookie
				$result_5 = curlTest(SITE_URL."/login", [
					"method" => "POST", 
				], true);
				$csrf_5 = $test_model->getCSRF($result_5);
				$cookie_5 = $test_model->getCookie($result_5);


				// ASSERT 

				if(
					$csrf_1 &&
					$csrf_4 &&
					$csrf_1 === $csrf_4 &&
					$csrf_4 !== $csrf_5 &&

					$cookie_1 &&
					$cookie_2 &&
					$cookie_3 &&
					$cookie_1 === $cookie_2 &&
					$cookie_2 === $cookie_3 &&
					$cookie_4 !== $cookie_5
				): ?>
				<div class="testpassed"><p>Session established</p></div>
				<? else: ?>
				<div class="testfailed"><p>Session failed</p></div>
				<? endif; 

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP POST requests WITH Session, CSRF and Cookie (restricted pages)</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				// parse last result (should be done on result with login form)
				$result_1 = curlTest(SITE_URL."/login", [
					"method" => "POST"
				], true);
				$csrf_1 = $test_model->getCSRF($result_1);
				$cookie_1 = $test_model->getCookie($result_1);


				// Should reset csrf
				$result_2 = curlTest(SITE_URL."/janitor", [
					"method" => "POST", 
					"header" => array("Cookie: ".$cookie_1), 
				], false);
				$csrf_2 = $test_model->getCSRF($result_2);
				$cookie_2 = $test_model->getCookie($result_2);


				$result_3 = curlTest(SITE_URL."/login", [
					"method" => "POST",
					"header" => array("Cookie: ".$cookie_1), 
				], true);
				$csrf_3 = $test_model->getCSRF($result_3);
				$cookie_3 = $test_model->getCookie($result_3);


				// ASSERT 

				if(
					$csrf_1 &&
					$csrf_2 &&
					$csrf_1 !== $csrf_2 &&
					$csrf_2 === $csrf_3 &&

					$cookie_1 &&
					$cookie_2 &&
					$cookie_3 &&
					$cookie_1 === $cookie_2 &&
					$cookie_2 === $cookie_3
				): ?>
				<div class="testpassed"><p>Session established and renewed</p></div>
				<? else: ?>
				<div class="testfailed"><p>Session failed</p></div>
				<? endif; 

			})();

		}

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				// parse last result (should be done on result with login form)
				$result_1 = curlTest(SITE_URL."/login", [
					"method" => "POST"
				], true);
				$csrf_1 = $test_model->getCSRF($result_1);
				$cookie_1 = $test_model->getCookie($result_1);


				// Should reset csrf
				$result_2 = curlTest(SITE_URL."/janitor/admin/user/list", [
					"method" => "POST", 
					"header" => array("Cookie: ".$cookie_1), 
				], false);
				$csrf_2 = $test_model->getCSRF($result_2);
				$cookie_2 = $test_model->getCookie($result_2);


				// ASSERT 

				if(
					$csrf_1 &&
					$csrf_2 &&
					$csrf_1 !== $csrf_2 &&

					$cookie_1 &&
					$cookie_2 &&
					$cookie_1 === $cookie_2
				): ?>
				<div class="testpassed"><p>Session established and renewed</p></div>
				<? else: ?>
				<div class="testfailed"><p>Session failed</p></div>
				<? endif; 

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Test setting "Test item" name using Guest session</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				// parse last result (should be done on result with login form)
				$result_1 = curlTest(SITE_URL."/login", [
					"method" => "POST"
				], true);
				$csrf_1 = $test_model->getCSRF($result_1);
				$cookie_1 = $test_model->getCookie($result_1);

				$name = "Test item – ".randomKey(4);
				$test_item_id = $test_model->createTestItem([
					"name" => $name,
					"status" => 1
				]);

				$item_1 = $IC->getItem(["id" => $test_item_id, "extend" => true]);


				$result_2 = curlTest(SITE_URL."/janitor/tests/update/".$test_item_id, [
					"method" => "POST", 
					"header" => array("Cookie: ".$cookie_1), 
					"post_fields" => "csrf-token=".$csrf_1."&name=hacked"
				], false);
				$cookie_2 = $test_model->getCookie($result_2);

				$item_2 = $IC->getItem(["id" => $test_item_id, "extend" => true]);


				// ASSERT 

				if(
					$item_1 &&
					$item_1["name"] === $name &&
					$item_1["status"] == 1 &&
					$item_2 &&
					$item_1 === $item_2 &&

					$csrf_1 &&

					$cookie_1 &&
					$cookie_2 &&
					$cookie_1 === $cookie_2
				): ?>
				<div class="testpassed"><p>POST data-manipulation as guest – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>POST data-manipulation as guest – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp(["item_id" => $test_item_id]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Test Logging in</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");

			// $params = array(
			// 	"method" => "POST"
			// );
			//
			// // login data
			// $params["post_fields"] = "username=security-test@parentnode.dk&password=s3curltA&ajaxlogin=true";
			// curlInit($params);
				$test_key = randomKey(4);
				$test_username = "security-test-".$test_key."@parentnode.dk";
				$test_password = "s3curltA";

				$test_user_id = $test_model->createTestUser([
					"nickname" => "User item, Security test – ".$test_key,
					"email" => $test_username,
					"verified_email" => 1,
					"password" => $test_password,
					"status" => 1,
					"user_group_id" => 3
				]);


				$result = curlTest(SITE_URL."/?login=true", [
					"method" => "POST", 
					"post_fields" => "username=$test_username&password=$test_password&ajaxlogin=true"
				], true);

				// get CSRF and Cookie after logging in
				$csrf = $test_model->getCSRF($result);
				$cookie = $test_model->getCookie($result);


				$result = curlTest(SITE_URL."/janitor/admin/post/list", [
					"method" => "GET", 
					"header" => array("Cookie: ".$cookie), 
				], true);

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Updating "Test item" name to: hacked as valid user</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");


				$test_key = randomKey(4);
				$test_item_id = $test_model->createTestItem([
					"name" => "Test item – ".$test_key,
					"status" => 1
				]);

				$test_username = "security-test-".$test_key."@parentnode.dk";
				$test_password = "s3curltA";

				$test_user_id = $test_model->createTestUser([
					"nickname" => "User item, Security test – ".$test_key,
					"email" => $test_username,
					"verified_email" => 1,
					"password" => $test_password,
					"status" => 1,
					"user_group_id" => 3
				]);

				$item_1 = $IC->getItem(["id" => $test_item_id, "extend" => true]);


				$result_login = curlTest(SITE_URL."/?login=true", [
					"method" => "POST", 
					"post_fields" => "username=$test_username&password=$test_password&ajaxlogin=true"
				], true);
				$csrf_1 = $test_model->getCSRF($result_login);
				$cookie_1 = $test_model->getCookie($result_login);


				$result_2 = curlTest(SITE_URL."/janitor/tests/update/".$test_item_id, [
					"method" => "POST", 
					"header" => array("Cookie: ".$cookie_1), 
					"inputs" => "csrf-token=".$csrf_1."&name=hacked"
				], true);
				$cookie_2 = $test_model->getCookie($result_2);

				$item_2 = $IC->getItem(["id" => $test_item_id, "extend" => true]);


				// ASSERT 

				if(
					$item_1 &&
					$item_1["name"] === "Test item – ".$test_key &&
					$item_1["status"] == 1 &&
					$item_2 &&
					$item_2["name"] === "hacked" &&

					$csrf_1 &&

					$cookie_1 &&
					$cookie_2 &&
					$cookie_1 === $cookie_2
				): ?>
				<div class="testpassed"><p>POST data-manipulation as valid user – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>POST data-manipulation as valid user – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id,
					"user_id" => $test_user_id
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

	<div class="tests">
		<h3>Updating "Test item" name to: hacked as valid user, CSRF failure</h3>
		<?

		if(1 && "Testing") {

			(function() {

				// ARRANGE 

				$IC = new Items();

				$test_model = $IC->typeObject("tests");

				$test_key = randomKey(4);

				$test_username = "security-test-".$test_key."@parentnode.dk";
				$test_password = "s3curltA";


				$item_name = "Test item – ".$test_key;
				$test_item_id = $test_model->createTestItem([
					"name" => $item_name,
					"status" => 1
				]);

				$user_name = "User item – ".$test_key;
				$test_user_id = $test_model->createTestUser([
					"name" => $user_name,
					"email" => $test_username,
					"verified_email" => 1,
					"password" => $test_password,
					"status" => 1,
					"user_group_id" => 3
				]);

				$item_1 = $IC->getItem(["id" => $test_item_id, "extend" => true]);


				$result_login = curlTest(SITE_URL."/?login=true", [
					"method" => "POST", 
					"post_fields" => "username=$test_username&password=$test_password&ajaxlogin=true"
				], true);
				$csrf_1 = $test_model->getCSRF($result_login);
				$cookie_1 = $test_model->getCookie($result_login);


				$result_2 = curlTest(SITE_URL."/janitor/tests/update/".$test_item_id, [
					"method" => "POST", 
					"header" => array("Cookie: ".$cookie_1), 
					"post_fields" => "name=hacked"
				], false);
				$cookie_2 = $test_model->getCookie($result_2);

				$item_2 = $IC->getItem(["id" => $test_item_id, "extend" => true]);


				// ASSERT 

				if(
					$item_1 &&
					$item_1["name"] === $item_name &&
					$item_1["status"] == 1 &&
					$item_2 === $item_1 &&

					$csrf_1 &&

					$cookie_1 &&
					$cookie_2 &&
					$cookie_1 === $cookie_2
				): ?>
				<div class="testpassed"><p>POST data-manipulation as valid user, CSRF failure – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>POST data-manipulation as valid user, CSRF failure – error</p></div>
				<? endif; 


				// CLEAN UP

				$test_model->cleanUp([
					"item_id" => $test_item_id,
					"user_id" => $test_user_id
				]);
				message()->resetMessages();

			})();

		}

		?>
	</div>

</div>