<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();


$page->bodyClass("tests");
$page->pageTitle("Every good function deserves a test");


if(is_array($action) && count($action)) {

	if(count($action) == 1) {

		$page->header();
		$page->template("tests/".$action[0].".php");
		$page->footer();
		exit();

	}

}


$page->header();
$page->template("tests/index.php");
$page->footer();

?>
