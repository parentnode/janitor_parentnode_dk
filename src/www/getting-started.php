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

		# /getting-started/#sindex#
		$page->page(array(
			"templates" => "getting-started/".$action[0].".php"
		));
		exit();
	}

}

$page->page(array(
	"templates" => "getting-started/index.php"
));
exit();

?>
