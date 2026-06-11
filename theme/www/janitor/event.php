<?php
$access_item["/"] = true;
$access_item["/admin"] = true;
$access_item["/admin-list"] = "/admin";
$access_item["/admin-new"] = "/admin";
$access_item["/admin-edit"] = "/admin";
$access_item["/saveAdmin"] = "/admin";
$access_item["/updateAdmin"] = "/admin";
$access_item["/host"] = true;
$access_item["/host-list"] = "/host";
$access_item["/host-edit"] = "/host";
$access_item["/updateHost"] = "/host";
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();
$itemtype = "event";
$model = $IC->typeObject($itemtype);


$page->bodyClass($itemtype);
$page->pageTitle("Events");


if(is_array($action) && count($action)) {

	// LIST/EDIT/NEW ITEM
	if(preg_match("/^(admin-list|admin-new|admin-edit|host-list|host-edit)$/", $action[0])) {

		$page->page(array(
			"type" => "janitor",
			"templates" => "janitor/".$itemtype."/".$action[0].".php"
		));
		exit();
	}

	// Class interface
	else if(security()->validateCsrfToken() && preg_match("/[a-zA-Z]+/", $action[0])) {

		// check if custom function exists on User class
		if($model && method_exists($model, $action[0])) {

			$output = new Output();
			$output->screen($model->{$action[0]}($action));
			exit();
		}
	}

}

$page->page(array(
	"templates" => "pages/404.php"
));

?>
