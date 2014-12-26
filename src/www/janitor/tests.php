<?php
$access_item["/"] = true;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();
$itemtype = "tests";
$model = $IC->typeObject($itemtype);


$page->bodyClass("tests");
$page->pageTitle("Every good function deserves a test");


if(is_array($action) && count($action)) {

	// enable forwarding to Tests Class on all posts
	if($_SERVER["REQUEST_METHOD"] == "GET" && count($action) == 1) {

		# /tests/#sindex#
		# Tests should use Janitor interface to validate CSS and JS in output functions like HTML
		$page->page(array(
			"type" => "janitor",
			"templates" => "tests/".$action[0].".php"
		));
		exit();
	}

	// Class interface
	else if($page->validateCsrfToken() && preg_match("/[a-zA-Z]+/", $action[0])) {

		// check if custom function exists on User class
		if($model && method_exists($model, $action[0])) {

			$output = new Output();
			$output->screen($model->$action[0]($action));
			exit();
		}
	}

}



$page->page(array(
	"templates" => "tests/index.php"
));
exit();

?>
