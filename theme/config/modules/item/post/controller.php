<?php
$controller_itemtype = "post";
$controller_favors = ["view" => "post", "list" => "List posts"];

$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}


include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$itemtype = $controller_itemtype;
$action = $page->actions();


if(is_array($action) && count($action)) {

	# View specific post
	# /posts/#sindex#
	if(count($action) === 1) {

		$page->page([
			"templates" => "posts/post.php"
		]);
		exit();

	}

	# Tags
	else if(count($action) >= 1 && $action[0] === "tag") {

		# View specific post (tag listed)
		# /posts/tag/#tag#/#sindex#
		if(count($action) === 3) {

			$page->page([
				"templates" => "posts/post_tag.php"
			]);
			exit();
		}

		# List by tag
		# /posts/tag/#tag#
		# /posts/tag/#tag#/page/#sindex#
		else if((count($action) === 2) || (count($action) === 4 && $action[2] === "page")) {

			$page->page([
				"templates" => "posts/posts_tag.php"
			]);
			exit();

		}

	}

}


$page->page(array(
	"templates" => "posts/posts.php"
));
exit();


?>
 