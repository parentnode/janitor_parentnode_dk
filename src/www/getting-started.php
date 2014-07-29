<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();


$page->bodyClass("docs");
$page->pageTitle("Everyone deserves a good start");


if(is_array($action) && count($action)) {

	if(count($action) == 1) {

		$page->header();
		$page->template("getting-started/".$action[0].".php");
		$page->footer();
		exit();

	}

}


$page->header();
$page->template("getting-started/index.php");
$page->footer();

?>
