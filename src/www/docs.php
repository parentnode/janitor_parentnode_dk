<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();


$page->bodyClass("docs");
$page->pageTitle("Every good library deserves documentation");


if(is_array($action) && count($action)) {

	if(count($action) == 1) {

		$page->header();
		$page->template("docs/".$action[0].".php");
		$page->footer();
		exit();

	}

}


$page->header();
$page->template("docs/index.php");
$page->footer();

?>
