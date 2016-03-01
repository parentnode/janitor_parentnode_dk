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

// get test item
$items = $IC->getItems(array("itemtype" => "tests"));
if(!$items) {

	unset($_POST);
	$_POST["name"] = "Test item";

	$test_item = $model->save(array("save", "tests"));
	$test_item_id = $item["id"];
}
else {
	$test_item_id = $items[0]["id"];
}



$UC = new Superuser();
$user = $UC->getUsers(array("email" => "security@security.dk"));



// THIS WILL EXPOSE SYSTEM IF RUN ON LIVE SITE



if(!$test_item_id) {
	print "You must have at least one &quot;Tests&quot; item to perform test<br>\n";
}

if(!$user) {
	print "You must have a user: security@security.dk on your system, with the password: s3curltA<br>\n";
}



if(!$items || !$user) {
	exit();
}

$test_item = $IC->getItem(array("id" => $test_item_id, "extend" => true));
$test_item_name = $test_item["name"];
$test_item_status = $test_item["status"];


?>


<div class="scene tests i:scene">
	<h1>Security tests</h1>	
	<h2>Testing Janitor access validation</h2>

	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<div class="tests">
		<h3>Testing prevalidation - User group 1</h3>
		<?
		session()->value("user_group_id", 1);

		$model->testPath("/janitor/admin/user/list", false);
		$model->testPath("/", true);
		$model->testPath("/janitor/admin/404", true);
		$model->testPath("/login", true);
		$model->testPath("/docs", true);
		$model->testPath("/janitor/admin/user/delete/1", false);
		$model->testPath("/janitor/admin/users/list", false);
		$model->testPath("/janitor/user/list", false);
		$model->testPath("/janitor/tests", false);
		$model->testPath("/janitor", false);
		?>
	</div>

	<div class="tests">
		<h3>Testing prevalidation - User group 3</h3>
		<?
		session()->value("user_group_id", 3);

		$model->testPath("/", true);
		$model->testPath("/janitor/tests", true);
		$model->testPath("/login", true);
		$model->testPath("/getting-started", true);
		$model->testPath("/janitor/admin/user/list", true);
		$model->testPath("/janitor/admin/user/delete/1", true);
		$model->testPath("/janitor/admin/users/list", false);
		$model->testPath("/janitor", true);
		?>
	</div>



	<?

// HTTP REQUESTS
// TEST setActions

class CurlRequest {

	private $ch;

	public function init($params) {

		$this->ch = curl_init();
		$user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:31.0) Gecko/20100101 Firefox/31.0';

		@curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		@curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
		@curl_setopt($this->ch, CURLOPT_HEADER, 1);
		@curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
		@curl_setopt($this->ch, CURLOPT_USERAGENT, $user_agent);
		@curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		@curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);

		if(isset($params['header']) && $params['header']) {
			@curl_setopt($this->ch, CURLOPT_HTTPHEADER, $params['header']);
		}

		if($params['method'] == "HEAD") {
			@curl_setopt($this->ch, CURLOPT_NOBODY, 1);
		}

		if($params['method'] == "POST") {
			@curl_setopt($this->ch, CURLOPT_POST, true);
			@curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params['post_fields']);
		}

		if(isset($params['referer'])) {
			@curl_setopt($this->ch, CURLOPT_REFERER, $params['referer']);
		}

		if(isset($params['cookie'])) {
			@curl_setopt($this->ch, CURLOPT_COOKIE, $params['cookie']);
		}

	}

	public function exec($url, $allowed) {

		@curl_setopt($this->ch, CURLOPT_URL, $url);

		$response = curl_exec($this->ch);
		$error = curl_error($this->ch);

		$result = array(
			'header' => '',
			'body' => '',
			'curl_error' => '',
			'http_code' => '',
			'last_url' => ''
		);


		if($error) {
			$result['curl_error'] = $error;
			return $result;
		}

		$header_size = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
		$result['header'] = substr($response, 0, $header_size);
		$result['body'] = substr($response, $header_size);
		$result['http_code'] = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
		$result['last_url'] = curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL);

		if(
			$result["http_code"] == 200 && 
			(
				($allowed && !preg_match("/\/login$/", $result['last_url']))

				|| 

				(!$allowed && preg_match("/\/login$/", $result['last_url']))
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
}


// get cookie from result
function getCookie($result) {

	preg_match_all("/Set\-Cookie: (.+);/", $result["header"], $cookie_match);
	$cookie = $cookie_match[1][count($cookie_match[1])-1];

	return $cookie;
}

// get CSRF from result
function getCSRF($result) {

	// look for input
	preg_match("/name\=\"csrf\-token\" value=\"(.+)\"/", $result["body"], $csrf_match);
	if(!$csrf_match) {
		// look for ajax response
		preg_match("/\"csrf\-token\":\"(.+)\"}/", $result["body"], $csrf_match);
	}

	$csrf = $csrf_match[1];

	return $csrf;
}


// test item name
function testName($expected) {
	global $IC;
	global $test_item_id;
	global $test_item_name;

	$compare_item = $IC->getItem(array("id" => $test_item_id, "extend" => true));
	if($compare_item["name"] != $test_item_name) {
		print '<div style="color: red">CRITICAL: NAME IS NOW "'.$compare_item["name"].'"</div>'."\n";
	}
}



$curl = new CurlRequest();


// TESTING HTTP GET

$params = array(
	"method" => "GET"
);
$curl->init($params);

?>

	<div class="tests">
		<h3>Testing HTTP GET requests: unrestricted pages</h3>
		<?
		$curl->exec(SITE_URL, true);
		$curl->exec(SITE_URL."/", true);
		$curl->exec(SITE_URL."/getting-started", true);
		$curl->exec(SITE_URL."/janitor/js/seg_desktop.js", true);
		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP GET requests: missing pages</h3>
		<?
		$curl->exec(SITE_URL."/janitor/user/list", false);
		$curl->exec(SITE_URL."/bad-url", false);
		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP GET requests: restricted pages</h3>
		<?
		$curl->exec(SITE_URL."/janitor", false);
		$curl->exec(SITE_URL."/janitor/tests", false);
		$curl->exec(SITE_URL."/janitor/admin/post/new", false);
		$curl->exec(SITE_URL."/janitor/admin/post", false);
		$curl->exec(SITE_URL."/janitor/admin/user/list", false);
		$curl->exec(SITE_URL."/janitor/admin/items/tags", false);
		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP GET requests: data-manipulation</h3>
		<?
		$result = $curl->exec(SITE_URL."/janitor/admin/items/status/".$test_item_id."/".($test_item_status ? "0" : "1"), false);
		$model->testStatus($test_item_status);
		$result = $curl->exec(SITE_URL."/janitor/admin/items/delete/".$test_item_id, false);
		$model->testExistence(1);
		?>
	</div>


<?

// TESTING HTTP POST
$params = array(
	"method" => "POST"
);
$curl->init($params);

?>
	<div class="tests">
		<h3>Testing HTTP POST requests: unrestricted pages</h3>
		<?
		$curl->exec(SITE_URL."/", true);
		$curl->exec(SITE_URL."/getting-started", true);
		?>
	</div>

	<div class="tests">
		<h3>Testing HTTP POST requests: restricted pages</h3>
		<?
		$curl->exec(SITE_URL."/janitor/tests", false);
		$curl->exec(SITE_URL."/janitor/tests/security", false);
		$curl->exec(SITE_URL."/janitor/admin/post/new", false);
		$curl->exec(SITE_URL."/janitor/admin/post", false);
		$curl->exec(SITE_URL."/janitor/admin/user/list", false);
		$curl->exec(SITE_URL."/janitor/admin/items/tags", false);
		?>
	</div>


	<div class="tests">
		<h3>Testing HTTP POST requests: advanced requests</h3>
		<?
		?>
	</div>
<?

//
// print "<br>\nTest advanced requests<br>\n";
// $result = $curl->exec($domain."/janitor/admin/items/status/".$item_id."/0", false);
// testStatus();
// $result = $curl->exec($domain."/janitor/admin/items/delete/".$item_id, false);
// testExistence();
//
//
// // try setting name value
// print "<br>\nPosting name<br>\n";
// $params["post_fields"] = "name=hacked";
// $curl->init($params);
// $result = $curl->exec($domain."/janitor/admin/items/update/".$item_id, false);
// testName();
//
// print "<br>\n";
//
//
//
//
// // TESTING HTTP POST (HACKiNG)
//
//
// print "<h2>Testing HTTP POST requests WITH Session and CSRF hacking</h2>\n";
//
// // parse last result (should be done on result with login form)
// // when sending cookie, csrf should be the same between requests
// $csrf = getCSRF($result);
//
//
// print "<br>\nAttempting to establish session<br>\n";
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "csrf-token=".$csrf;
// $curl->init($params);
// $result = $curl->exec($domain."/janitor/post", false);
//
//
// // test if session is established
// $csrf_compare = getCSRF($result);
// if($csrf_compare == $csrf) {
// 	print "<br>\nSession established<br>\n";
// }
//
//
// print "<br>\nTest unrestricted pages<br>\n";
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "csrf-token=".$csrf;
// $curl->init($params);
// $result = $curl->exec($domain."/", true);
//
//
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "csrf-token=".$csrf;
// $curl->init($params);
// $result = $curl->exec($domain."/animation", true);
//
//
// print "<br>\nTest restricted pages<br>\n";
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "csrf-token=".$csrf;
// $curl->init($params);
// $result = $curl->exec($domain."/janitor", false);
//
//
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "csrf-token=".$csrf;
// $curl->init($params);
// $result = $curl->exec($domain."/janitor/admin/user/list", false);
//
//
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "csrf-token=".$csrf;
// $curl->init($params);
// $result = $curl->exec($domain."/janitor/admin/items/tags", false);
//
//
// // try setting name value
// print "<br>\nTest setting name using Guest session<br>\n";
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "csrf-token=".$csrf."&name=hacked";
// $curl->init($params);
// $result = $curl->exec($domain."/janitor/admin/items/update/".$item_id, false);
// testName();
//
//
//
//
// // TESTING HTTP POST (LOGGING IN)
//
//
// print "<br>\nLOGGING IN<br>\n";
//
//
// $params = array(
// 	"method" => "POST"
// );
//
//
// // try setting name value
// $params["post_fields"] = "username=security@security.dk&password=s3curltA&ajaxlogin=true";
// $curl->init($params);
// $result = $curl->exec($domain."/?login=true", true);
//
// print_r($result);
//
// // get CSRF and Cookie after logging in
// $csrf = getCSRF($result);
//
//
// // get list page
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "csrf-token=".$csrf;
// $curl->init($params);
// $result = $curl->exec($domain."/janitor/allinone/list", true);
//
//
// // try setting name value
// print "<br>\nUpdating item name to: hacked<br>\n";
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "csrf-token=".$csrf."&name=hacked";
// $curl->init($params);
// $result = $curl->exec($domain."/janitor/admin/items/update/".$item_id, true);
// testName();
//
//
// // setting name back
// print "<br>\nRestoring name to: $item_name<br>\n";
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "csrf-token=".$csrf."&name=".$item_name;
// $curl->init($params);
// $result = $curl->exec($domain."/janitor/admin/items/update/".$item_id, true);
// testName();
//
//
// // csrf failure
// print "<br>\nTesting missing CSRF<br>\n";
// $params["header"] = array("Cookie: ".getCookie($result));
// $params["post_fields"] = "name=hacked";
// $curl->init($params);
// $result = $curl->exec($domain."/janitor/admin/items/update/".$item_id, false);


?>

</div>