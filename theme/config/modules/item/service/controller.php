<?php
$controller_itemtype = "service";
$controller_favors = ["view" => "service", "list" => "List services"];

$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}


include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$itemtype = $controller_itemtype;
$action = $page->actions();


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
