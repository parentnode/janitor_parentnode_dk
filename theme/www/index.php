<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


debug([$_SERVER]);

page()->resolveRequest();

exit();

$action = $page->actions();


$page->bodyClass("front");
$page->pageTitle("Frontend first");


$page->page(array(
	"templates" => "pages/front.php"
));
exit();

?>
