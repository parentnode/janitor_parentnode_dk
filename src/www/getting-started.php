<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();


$page->bodyClass("gettingstarted");
$page->pageTitle("Everyone deserves a good start");


$page->page(array(
	"templates" => "pages/getting-started.php"
));
exit();

?>
