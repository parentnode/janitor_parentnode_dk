<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");

$action = $page->actions();


$page->bodyClass("terms");
$page->pageTitle("Terms");


$page->header();
$page->template("pages/terms.php");
$page->footer();
exit();

?>