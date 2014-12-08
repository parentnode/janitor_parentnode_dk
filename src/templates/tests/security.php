<?php
// $access_item["/"] = true;
// if(isset($read_access) && $read_access) {
// 	return;
// }
//
// include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


if(defined("SITE_INSTALL") && SITE_INSTALL) {
	print "Process will loop, if you run this test in SITE_INSTALL mode.<br>\n";
	exit();
}


// get test item
$IC = new Items();
$items = $IC->getItems(array("itemtype" => "post", "status" => 1, "limit" => 1));

$UC = new Superuser();
$user = $UC->getUsers(array("email" => "security@security.dk"));



// THIS WILL EXPOSE SYSTEM IF RUN ON LIVE SITE



if(!$items) {
	print "You must have at least one Post item to perform test<br>\n";
}

if(!$user) {
	print "You must have a user: security@security.dk on your system, with the password: s3curltA<br>\n";
}



if(!$items || !$user) {
	exit();
}


$item = $IC->getItem(array("id" => $items[0]["id"], "extend" => true));
$item_id = $item["id"];
$item_name = $item["name"];



// Perform security tests by making a series of http requests and see if they are handled correctly
$domain = (isset($_SERVER["HTTPS"]) ? "https" : "http") . "://" . $_SERVER["SERVER_NAME"];



// PREVALIDATION 
// TEST validatePath


function testPath($path, $allowed) {
	global $page;
	$result = $page->validatePath($path);
	if(($result && $allowed) || (!$result && !$allowed)) {
		print '<div style="color: #00dd00">'.$path."</div>\n";
	}
	else {
		print '<div style="color: red">'.$path."</div>\n";
	}
}


print "<h2>Testing prevalidation</h2>\n";


print "User group 1<br>\n";
session()->value("user_group_id", 1);
print testPath("/janitor/admin/user/list", false);
print testPath("/", true);
print testPath("/janitor/admin/404", true);
print testPath("/login", true);
print testPath("/docs", true);
print testPath("/janitor/admin/user/delete/1", false);
print testPath("/janitor/admin/users/list", false);
print testPath("/janitor/user/list", false);
print testPath("/janitor/allinone/list", false);
print testPath("/janitor", false);

print "<br>\n<br>\n";

print "User group 3<br>\n";
session()->value("user_group_id", 3);
print testPath("/", true);
print testPath("/janitor/tests", true);
print testPath("/login", true);
print testPath("/animation", true);
print testPath("/janitor/admin/user/list", true);
print testPath("/janitor/admin/user/delete/1", true);
print testPath("/janitor/admin/users/list", false);
print testPath("/janitor", true);

print "<br>\n<br>\n";


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
			print '<div style="color: #00dd00">'.$url.": ".$result['http_code']." (".$result['last_url'].")</div>\n";
		}
		else {
			print '<div style="color: red">'.$url.": ".$result['http_code']." (".$result['last_url'].")</div>\n";
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

// test item status
function testStatus() {
	global $IC;
	global $item_id;

	$test_item = $IC->getItem(array("id" => $item_id, "extend" => true));
	if($test_item["status"] != 1) {
		print '<div style="color: red">CRITICAL: ITEM DISBALED</div>'."\n";
	}
}

// test item name
function testExistence() {
	global $IC;
	global $item_id;

	$test_item = $IC->getItem(array("id" => $item_id, "extend" => true));
	if(!$test_item) {
		print '<div style="color: red">CRITICAL: ITEM DELETED</div>'."\n";
	}
}

// test item name
function testName() {
	global $IC;
	global $item_id;
	global $item_name;

	$test_item = $IC->getItem(array("id" => $item_id, "extend" => true));
	if($test_item["name"] != $item_name) {
		print '<div style="color: red">CRITICAL: NAME IS NOW "'.$test_item["name"].'"</div>'."\n";
	}
}


$curl = new CurlRequest();




// TESTING HTTP GET


print "<h2>Testing HTTP GET requests</h2>\n";

$params = array(
	"method" => "GET"
);
$curl->init($params);


print "<br>\nTest unrestricted pages<br>\n";
$result = $curl->exec($domain, true);
$result = $curl->exec($domain."/", true);
$result = $curl->exec($domain."/animation", true);
$result = $curl->exec($domain."/janitor/js", true);
$result = $curl->exec($domain."/janitor/js/seg_desktop.js", true);


print "<br>\nTest missing pages<br>\n";
$result = $curl->exec($domain."/janitor/user/list", false);
$result = $curl->exec($domain."/bad-url", false);


print "<br>\nTest restricted pages<br>\n";
$result = $curl->exec($domain."/tests", false);
$result = $curl->exec($domain."/tests/security", false);
$result = $curl->exec($domain."/janitor", false);
$result = $curl->exec($domain."/janitor/allinone/list", false);
$result = $curl->exec($domain."/janitor/post/new", false);
$result = $curl->exec($domain."/janitor/post", false);
$result = $curl->exec($domain."/janitor/admin/user/list", false);
$result = $curl->exec($domain."/janitor/admin/items/tags", false);


print "<br>\nTest data-manipulation<br>\n";
$result = $curl->exec($domain."/janitor/admin/items/status/".$item_id."/0", false);
testStatus();
$result = $curl->exec($domain."/janitor/admin/items/delete/".$item_id, false);
testExistence();

print "<br>\n";




// TESTING HTTP POST


print "<h2>Testing HTTP POST requests</h2>\n";


$params = array(
	"method" => "POST"
);
$curl->init($params);


print "<br>\nTest unrestricted pages<br>\n";
$result = $curl->exec($domain."/", true);
$result = $curl->exec($domain."/animation", true);


print "<br>\nTest restricted pages<br>\n";
$result = $curl->exec($domain."/tests/security", false);
$result = $curl->exec($domain."/janitor/allinone/list", false);
$result = $curl->exec($domain."/janitor/post/new", false);
$result = $curl->exec($domain."/janitor/post", false);
$result = $curl->exec($domain."/janitor/admin/user/list", false);
$result = $curl->exec($domain."/janitor/admin/items/tags", false);


print "<br>\nTest advanced requests<br>\n";
$result = $curl->exec($domain."/janitor/admin/items/status/".$item_id."/0", false);
testStatus();
$result = $curl->exec($domain."/janitor/admin/items/delete/".$item_id, false);
testExistence();


// try setting name value
print "<br>\nPosting name<br>\n";
$params["post_fields"] = "name=hacked";
$curl->init($params);
$result = $curl->exec($domain."/janitor/admin/items/update/".$item_id, false);
testName();

print "<br>\n";




// TESTING HTTP POST (HACKiNG)


print "<h2>Testing HTTP POST requests WITH Session and CSRF hacking</h2>\n";

// parse last result (should be done on result with login form)
// when sending cookie, csrf should be the same between requests
$csrf = getCSRF($result);


print "<br>\nAttempting to establish session<br>\n";
$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "csrf-token=".$csrf;
$curl->init($params);
$result = $curl->exec($domain."/janitor/post", false);


// test if session is established
$csrf_compare = getCSRF($result);
if($csrf_compare == $csrf) {
	print "<br>\nSession established<br>\n";
}


print "<br>\nTest unrestricted pages<br>\n";
$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "csrf-token=".$csrf;
$curl->init($params);
$result = $curl->exec($domain."/", true);


$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "csrf-token=".$csrf;
$curl->init($params);
$result = $curl->exec($domain."/animation", true);


print "<br>\nTest restricted pages<br>\n";
$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "csrf-token=".$csrf;
$curl->init($params);
$result = $curl->exec($domain."/janitor", false);


$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "csrf-token=".$csrf;
$curl->init($params);
$result = $curl->exec($domain."/janitor/admin/user/list", false);


$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "csrf-token=".$csrf;
$curl->init($params);
$result = $curl->exec($domain."/janitor/admin/items/tags", false);


// try setting name value
print "<br>\nTest setting name using Guest session<br>\n";
$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "csrf-token=".$csrf."&name=hacked";
$curl->init($params);
$result = $curl->exec($domain."/janitor/admin/items/update/".$item_id, false);
testName();




// TESTING HTTP POST (LOGGING IN)


print "<br>\nLOGGING IN<br>\n";


$params = array(
	"method" => "POST"
);


// try setting name value
$params["post_fields"] = "username=security@security.dk&password=s3curltA&ajaxlogin=true";
$curl->init($params);
$result = $curl->exec($domain."/?login=true", true);

print_r($result);

// get CSRF and Cookie after logging in
$csrf = getCSRF($result);


// get list page
$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "csrf-token=".$csrf;
$curl->init($params);
$result = $curl->exec($domain."/janitor/allinone/list", true);


// try setting name value
print "<br>\nUpdating item name to: hacked<br>\n";
$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "csrf-token=".$csrf."&name=hacked";
$curl->init($params);
$result = $curl->exec($domain."/janitor/admin/items/update/".$item_id, true);
testName();


// setting name back
print "<br>\nRestoring name to: $item_name<br>\n";
$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "csrf-token=".$csrf."&name=".$item_name;
$curl->init($params);
$result = $curl->exec($domain."/janitor/admin/items/update/".$item_id, true);
testName();


// csrf failure
print "<br>\nTesting missing CSRF<br>\n";
$params["header"] = array("Cookie: ".getCookie($result));
$params["post_fields"] = "name=hacked";
$curl->init($params);
$result = $curl->exec($domain."/janitor/admin/items/update/".$item_id, false);


?>