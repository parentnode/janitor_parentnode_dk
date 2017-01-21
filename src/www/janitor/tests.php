<?php
$access_item["/"] = true;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$action = $page->actions();
$IC = new Items();
$itemtype = "tests";
$model = $IC->typeObject($itemtype);


$page->bodyClass("tests");
$page->pageTitle("Every good function deserves a test");


if(is_array($action) && count($action)) {


	// enable forwarding to Tests Class on all posts
	if($_SERVER["REQUEST_METHOD"] == "GET" && count($action) == 1) {

		# /tests/#sindex#
		# Tests should use Janitor interface to validate CSS and JS in output functions like HTML
		$page->page(array(
			"type" => "janitor",
			"templates" => "tests/".$action[0].".php"
		));
		exit();
	}


	// Custom test responses

	// wkhtmlto - download pdf test
	else if($_SERVER["REQUEST_METHOD"] == "GET" && count($action) == 2 && $action[0] == "pdf" && $action[1] = "download") {

		$file = PRIVATE_FILE_PATH."/pdf-test.pdf";

		include_once("classes/system/pdf.class.php");
		$PC = new PDF();

		$PC->create(SITE_URL."/tests/pdf-template", $file);

		if(file_exists($file)) {

			header('Content-Description: File download');
			header('Content-Type: application/octet-stream');
			header("Content-Type: application/force-download");
			header('Content-Disposition: attachment; filename=' . "pdf-test.pdf");
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);

			// clean up
			unlink($file);

			exit();
		}

	}


	// Class interface
	else if($page->validateCsrfToken() && preg_match("/[a-zA-Z]+/", $action[0])) {

		// check if custom function exists on User class
		if($model && method_exists($model, $action[0])) {

			$output = new Output();
			$output->screen($model->{$action[0]}($action));
			exit();
		}
	}

}



$page->page(array(
	"type" => "janitor",
	"templates" => "tests/index.php"
));
exit();

?>
