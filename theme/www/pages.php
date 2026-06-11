<?php
$controller_itemtype = "page";
$controller_favors = ["view" => "page"];

$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}


include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$itemtype = $controller_itemtype;
$action = $page->actions();


// /pages/#sindex#
if(count($action) == 1) {

	$page->page(array(
		"templates" => "pages/view.php"
	));
	exit();

}

$page->page(array(
	"templates" => "pages/404.php"
));
exit();
