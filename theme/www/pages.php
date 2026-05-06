<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();
$itemtype = "service";


$page->bodyClass("services");
$page->pageTitle("Services");


// news list for tags
// /services/#sindex#
if(count($action) == 1) {

	$page->page(array(
		"templates" => "services/view.php"
	));
	exit();

}

$page->page(array(
	"templates" => "services/index.php"
));
exit();

?>
