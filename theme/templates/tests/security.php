<?php

if(defined("SITE_INSTALL") && SITE_INSTALL) {
	print "Process will loop, if you run this test in SITE_INSTALL mode.<br>\n";
	exit();
}

global $IC;
global $model;


// expose all test item value globally (to use in test class without passing as parameter)
global $test_item;
global $test_item_name;
global $test_item_id;
global $test_item_status;


include_once("classes/users/superuser.class.php");
$UC = new Superuser();

include("classes/helpers/curl.class.php");
global $CH;

// Initialize curl request
function curlInit($params) {

	global $CH;

	$CH = new CurlRequest();
	$CH->init($params);

}
// Test a request
function curlTest($url, $allowed) {

	global $CH;

	$result = $CH->exec($url);

	if(
		$result["http_code"] == 200 && 
		(
			// ($allowed && !preg_match("/\/login$/", $result['last_url']))
			//
			// ||

			(!$allowed && preg_match("/\/login$/", $result['last_url']))
			
			||
			
			($allowed && $result['last_url'] ==  $url)
		)
	
		|| 
	
		($result["http_code"] == 404 && !$allowed)
	) {
		print '<div class="testpassed">'.$url.": ".$result['http_code']." (".$result['last_url'].")</div>\n";
	}
	else {
		print '<div class="testfailed">'.$url.": ".$result['http_code']." (".$result['last_url'].")</div>\n";
	}

	return $result;

}


// test item name
function testName($expected) {
	global $test_item_id;
	global $test_item_name;

	$IC = new Items();

	$compare_item = $IC->getItem(array("id" => $test_item_id, "extend" => true));
	if($compare_item["name"] == $expected) {
		print '<div class="testpassed">Name ok</div>'."\n";
	}
	else {
		print '<div class="testfailed">Name error</div>'."\n";
	}
}
// test if path is accessible
function testPath($path, $allowed) {
	global $page;
	$result = $page->validatePath($path);
	if(($result && $allowed) || (!$result && !$allowed)) {
		print '<div class="testpassed">'.$path."</div>\n";
	}
	else {
		print '<div class="testfailed">'.$path."</div>\n";
	}
}
// test item status
function testStatus($expected) {
	global $test_item_id;
	$IC = new Items();

	$compare_item = $IC->getItem(array("id" => $test_item_id, "extend" => true));
	if($compare_item["status"] == $expected) {
		print '<div class="testpassed">Status ok</div>'."\n";
	}
	else {
		print '<div class="testfailed">Status error</div>'."\n";
	}
}
// test if item exists
function testExistence($expected) {
	global $test_item_id;
	$IC = new Items();

	$compare_item = $IC->getItem(array("id" => $test_item_id, "extend" => true));
	if(($compare_item && $expected) || (!$compare_item && !$expected)) {
		print '<div class="testpassed">Existence ok</div>'."\n";
	}
	else {
		print '<div class="testfailed">Existence error</div>'."\n";
	}
}


// get test item

$test_item_id = $model->createTestItem();


$user = $UC->getUsers(array("email" => "security-test@parentnode.dk"));



// THIS WILL EXPOSE SYSTEM IF RUN ON LIVE SITE



if(!$test_item_id) {
	print "You must have at least one &quot;Tests&quot; item to perform test<br>\n";
}

if(!$user) {
	print 'You must have a user: security-test@parentnode.dk on your system, with the password: s3curltA – <a href="/janitor/admin/user/list">create it here</a>.';
}



if(!$test_item_id || !$user) {
	exit();
}

$test_item = $IC->getItem(array("id" => $test_item_id, "extend" => true));
$test_item_name = $test_item["name"];
$test_item_status = $test_item["status"];


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
		session()->value("user_group_id", 1);

		if(1 && "Testing prevalidation - User group 1") {

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
		}

		?>
	</div>

	<div class="tests">
		<h3>Testing prevalidation - User group 3</h3>
		<?
		session()->value("user_group_id", 3);

		if(1 && "Testing prevalidation - User group 3") {

			testPath("/", true);
			testPath("/janitor/tests", true);
			testPath("/login", true);
			testPath("/getting-started", true);
			testPath("/janitor/admin/user/list", true);
			testPath("/janitor/admin/user/delete/1", true);
			testPath("/janitor/admin/users/list", false);
			testPath("/janitor", true);
		}

		?>
	</div>



<?
// TESTING HTTP GET

$params = array(
	"method" => "GET"
);
curlInit($params);

?>

	<div class="tests">
		<h3>Testing HTTP GET requests: unrestricted pages</h3>
		<?

		if(1 && "Testing HTTP GET requests: unrestricted pages") {

			curlTest(SITE_URL, true);
			curlTest(SITE_URL."/", true);
			curlTest(SITE_URL."/getting-started", true);
			curlTest(SITE_URL."/janitor/js/seg_desktop.js", true);

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP GET requests: missing pages</h3>
		<?

		if(1 && "Testing HTTP GET requests: missing pages") {

			curlTest(SITE_URL."/janitor/user/list", false);
			curlTest(SITE_URL."/bad-url", false);

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP GET requests: restricted pages</h3>
		<?

		if(1 && "Testing HTTP GET requests: restricted pages") {

			curlTest(SITE_URL."/janitor", false);
			curlTest(SITE_URL."/janitor/tests", false);
			curlTest(SITE_URL."/janitor/admin/post/new", false);
			curlTest(SITE_URL."/janitor/admin/post", false);
			curlTest(SITE_URL."/janitor/admin/user/list", false);
			curlTest(SITE_URL."/janitor/admin/items/tags", false);

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP GET requests: data-manipulation</h3>
		<?

		if(1 && "Testing") {

			$result = curlTest(SITE_URL."/janitor/admin/items/status/".$test_item_id."/".($test_item_status ? "0" : "1"), false);
			testStatus($test_item_status);
			$result = curlTest(SITE_URL."/janitor/admin/items/delete/".$test_item_id, false);
			testExistence(1);

		}

		?>
	</div>


<?

// TESTING HTTP POST
$params = array(
	"method" => "POST"
);
curlInit($params);

?>
	<div class="tests">
		<h3>Testing HTTP POST requests: unrestricted pages</h3>
		<?

		if(1 && "Testing") {

			curlTest(SITE_URL."/", true);
			curlTest(SITE_URL."/getting-started", true);

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP POST requests: restricted pages</h3>
		<?

		if(1 && "Testing") {

			curlTest(SITE_URL."/janitor/tests", false);
			curlTest(SITE_URL."/janitor/tests/security", false);
			curlTest(SITE_URL."/janitor/admin/post/new", false);
			curlTest(SITE_URL."/janitor/admin/post", false);
			curlTest(SITE_URL."/janitor/admin/user/list", false);
			curlTest(SITE_URL."/janitor/admin/items/tags", false);

		}

		?>
	</div>


	<div class="tests">
		<h3>Testing HTTP POST requests: advanced requests</h3>
		<?
		if(1 && "Testing") {

			curlTest(SITE_URL."/janitor/admin/items/status/".$test_item_id."/0", false);
			testStatus($test_item_status);
			curlTest(SITE_URL."/janitor/admin/items/delete/".$test_item_id, false);
			testExistence(1);


			$params["post_fields"] = "name=hacked";
			curlInit($params);

			$result = curlTest(SITE_URL."/janitor/admin/items/update/".$test_item_id, false);
			testName($test_item_name);
			
			
		}

		?>
	</div>


	<div class="tests">
		<h3>Testing HTTP POST requests WITH Session and CSRF hacking</h3>
		<?

		if(1 && "Testing") {

			curlInit($params);
			// parse last result (should be done on result with login form)
			$result = curlTest(SITE_URL."/login", true);

			// when sending cookie, csrf should be the same between requests
			$csrf = $model->getCSRF($result);
			$cookie = $model->getCookie($result);

			// attemptiong to establish session connection
			$params["header"] = array("Cookie: ".$cookie);
			$params["post_fields"] = "csrf-token=".$csrf;

			curlInit($params);
			$result = curlTest(SITE_URL."/login", false);

	//		print_r($result);

			// test if session is established
			$csrf_compare = $model->getCSRF($result);

			print "csrf:".$csrf.", " .$csrf_compare."<br>";

			if($csrf_compare == $csrf) {
				print '<div class="testpassed">Session established</div>'."\n";
			}
			else {
				print '<div class="testfailed">Session failed</div>'."\n";
			}

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP POST requests WITH Session and CSRF hacking (unrestricted pages)</h3>
		<?

		if(1 && "Testing") {

			// parse last result (should be done on result with login form)
			$result = curlTest(SITE_URL."/login", true);
			$csrf = $model->getCSRF($result);

			$params["header"] = array("Cookie: ".$model->getCookie($result));
			$params["post_fields"] = "csrf-token=".$csrf;
			curlInit($params);
			$result = curlTest(SITE_URL."/", true);

		}

		if(1 && "Testing") {

			// parse last result (should be done on result with login form)
			$result = curlTest(SITE_URL."/login", true);
			$csrf = $model->getCSRF($result);

			$params["header"] = array("Cookie: ".$model->getCookie($result));
			$params["post_fields"] = "csrf-token=".$csrf;
			curlInit($params);
			$result = curlTest(SITE_URL."/getting-started", true);

		}

		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP POST requests WITH Session and CSRF hacking (restricted pages)</h3>
		<?

		if(1 && "Testing") {

			// parse last result (should be done on result with login form)
			$result = curlTest(SITE_URL."/login", true);
			$csrf = $model->getCSRF($result);

			$params["header"] = array("Cookie: ".$model->getCookie($result));
			$params["post_fields"] = "csrf-token=".$csrf;
			curlInit($params);
			$result = curlTest(SITE_URL."/janitor", false);

		}

		if(1 && "Testing") {

			// parse last result (should be done on result with login form)
			$result = curlTest(SITE_URL."/login", true);
			$csrf = $model->getCSRF($result);

			$params["header"] = array("Cookie: ".$model->getCookie($result));
			$params["post_fields"] = "csrf-token=".$csrf;
			curlInit($params);
			$result = curlTest(SITE_URL."/janitor/admin/user/list", false);

		}

		if(1 && "Testing") {

			// parse last result (should be done on result with login form)
			$result = curlTest(SITE_URL."/login", true);
			$csrf = $model->getCSRF($result);

			$params["header"] = array("Cookie: ".$model->getCookie($result));
			$params["post_fields"] = "csrf-token=".$csrf;
			curlInit($params);
			$result = curlTest(SITE_URL."/janitor/admin/items/tags", false);

		}
		?>
	</div>

	<div class="tests">
		<h3>Test setting "Test item" name using Guest session</h3>
		<?

		if(1 && "Testing") {

			// parse last result (should be done on result with login form)
			$result = curlTest(SITE_URL."/login", true);
			$csrf = $model->getCSRF($result);

			$params["header"] = array("Cookie: ".$model->getCookie($result));
			$params["post_fields"] = "csrf-token=".$csrf."&name=hacked";
			curlInit($params);
			$result = curlTest(SITE_URL."/janitor/admin/items/update/".$test_item_id, false);
			testName($test_item_name);

		}

		?>
	</div>

	<div class="tests">
		<h3>Test Logging in</h3>
		<?

		if(1 && "Testing") {

			$params = array(
				"method" => "POST"
			);

			// login data
			$params["post_fields"] = "username=security-test@parentnode.dk&password=s3curltA&ajaxlogin=true";
			curlInit($params);
			$result = curlTest(SITE_URL."/?login=true", true);

			// get CSRF and Cookie after logging in
			$csrf = $model->getCSRF($result);

			// get list page
			$params["header"] = array("Cookie: ".$model->getCookie($result));
			// $params["post_fields"] = "csrf-token=".$csrf;
			curlInit($params);
			$result = curlTest(SITE_URL."/janitor/admin/post/list", true);

		}

		?>
	</div>

	<div class="tests">
		<h3>Updating "Test item" name to: hacked</h3>
		<?

		if(1 && "Testing") {

			$params = array(
				"method" => "POST"
			);

			// login data
			$params["post_fields"] = "username=security-test@parentnode.dk&password=s3curltA&ajaxlogin=true";
			curlInit($params);
			$result = curlTest(SITE_URL."/?login=true", true);

			// get CSRF and Cookie after logging in
			$csrf = $model->getCSRF($result);
			$cookie = $model->getCookie($result);

			$params["header"] = array("Cookie: ".$cookie);
			$params["post_fields"] = "csrf-token=".$csrf."&name=hacked";
			curlInit($params);
			$result = curlTest(SITE_URL."/janitor/tests/update/".$test_item_id, true);
			// debug([$result]);
			testName("hacked");

			?>

		<h3>Restoring "Test item" name to: <?= $test_item_name ?></h3>

			<?

			$params["header"] = array("Cookie: ".$cookie);
			$params["post_fields"] = "csrf-token=".$csrf."&name=".$test_item_name;
			curlInit($params);
			$result = curlTest(SITE_URL."/janitor/tests/update/".$test_item_id, true);
			// debug([$result]);
			testName($test_item_name);

			?>

		<h3>CSRF failure</h3>
			
		<?

			$params["header"] = array("Cookie: ".$cookie);
			$params["post_fields"] = "name=hacked";
			curlInit($params);
			$result = curlTest(SITE_URL."/janitor/tests/update/".$test_item_id, false);

		}

		?>
	</div>

</div>