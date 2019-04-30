<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();


$page->bodyClass("pages");
$page->pageTitle("Every good library deserves content");


if($action) {

	switch($action[0]) {
		case "getting-started":
		case "changelog":
		case "milestones":

			$page->page(array(
				"templates" => "pages/".$action[0].".php"
			));
			exit();

		default:

			$page->page(array(
				"body_class" => "gettingstarted",
				"templates" => "pages/view.php"
			));
			exit();

	}

}


$page->page(array(
	"templates" => "pages/getting-started.php"
));
exit();

?>
