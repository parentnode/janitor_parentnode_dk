<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();


$page->bodyClass("pages");
$page->pageTitle("Every good library deserves content");


if(is_array($action) && count($action)) {

	if(count($action) == 1) {

		if(file_exists(LOCAL_PATH."/templates/pages/".$action[0].".php")) {
			$page->page(array(
				"templates" => "pages/".$action[0].".php"
			));
		}
		else {
			$page->page(array(
				"templates" => "pages/view.php"
			));
		}
		exit();
	}

}


$page->page(array(
	"templates" => "pages/getting-started.php"
));
exit();

?>
