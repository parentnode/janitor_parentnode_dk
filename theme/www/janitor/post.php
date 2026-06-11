<?php
$controller_itemtype = "post";
$controller_favors = false;

$access_item["/"] = true;
$access_item["/owner"] = true;
$access_item["/updateOwner"] = "/owner";

$access_item["/comments"] = true;
$access_item["/deleteComment"] = "/comments";
$access_item["/updateComment"] = "/comments";

$access_item["/sindex"] = true;
$access_item["/updateSindex"] = "/sindex";
$access_item["/checkSindex"] = "/sindex";

$access_item["/cannonical"] = true;
$access_item["/setCannonicalUrl"] = "/cannonical";


$access_item["/tags"] = true;
$access_item["/addTag"] = "/tags";
$access_item["/updateTag"] = "/tags";
$access_item["/deleteTag"] = "/tags";

$access_item["/developer"] = true;

if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$itemtype = $controller_itemtype;
$action = $page->actions();
$IC = new Items();
$model = $IC->typeObject($itemtype);


$page->bodyClass($itemtype);
$page->pageTitle("Posts");


if(is_array($action) && count($action)) {

	// LIST/EDIT/NEW ITEM
	if(preg_match("/^(list|edit|new)$/", $action[0])) {

		$page->page(array(
			"type" => "janitor",
			"templates" => "janitor/".$itemtype."/".$action[0].".php"
		));
		exit();
	}

	// Handle possible API request
	else {
		security()->API_request($model, $action);
	}

}

$page->page(array(
	"templates" => "pages/404.php"
));
