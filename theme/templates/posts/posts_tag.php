<?php
global $action;
global $itemtype;


$IC = new Items();
$selected_tag = urldecode($action[1]);


// List extension (page > 1)
if(count($action) === 4) {
	$page = $action[3];
	$page_item = false;
}
// Default list
else {
	$page = false;
	$page_item = $IC->getItem([
		"itemtype" => "page",
		"tags" => "page:".$selected_tag, 
		"status" => 1, 
		"extend" => [
			"user" => true, 
			"mediae" => true, 
			"tags" => true
		]
	]);
}

if($page_item) {
	$this->sharingMetaData($page_item);
}
else {
	$this->sharingMetaData(["description" => "Something about $selected_tag"]);
}


$pagination_pattern = [
	"pattern" => [
		"itemtype" => $itemtype, 
		"status" => 1, 
		"extend" => [
			"tags" => true, 
			"user" => true, 
			"mediae" => true,
			"readstate" => true
		]
	],
	"tags" => $itemtype.":".addslashes($selected_tag), 
	"page" => $page,
	"limit" => 5
];

// Get posts
$items = $IC->paginate($pagination_pattern);


?>

<div class="scene posts tag i:postitems">

<? if($page_item): 
	$media = $IC->sliceMediae($page_item, "single_media"); ?>
	<div class="article i:article" itemscope itemtype="http://schema.org/Article">

		<?= HTML()->renderSnippet("snippets/media.php", [
			"item" => $page_item,
			"media" => $media,
		]) ?>


		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>


		<?= HTML()->renderSnippet("snippets/info.php", [
			"item" => $page_item,
			"url" => HTML()->path."/tag/".urlencode($selected_tag),
			"media" => $media,
			"sharing" => true
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>

	</div>

<? else: ?>

	<div class="article">
		<h1><?= $selected_tag ?></h1>
	</div>

<? endif; ?>


	<?= HTML()->renderSnippet("snippets/categories.php", [
		"itemtype" => $itemtype,
		"tags" => [["value" => $selected_tag]],
	]) ?>


	<div class="articles">

	<?	if($items): ?>

		<h2><?= $items["total"] ?> Posts</h2>


		<?= HTML()->renderSnippet("snippets/pagination.php", [
			"items" => $items,
			"direction" => "prev",
			"base_path" => HTML()->path."/tag/".urlencode($selected_tag), 
			"show_total" => false,
			"labels" => ["prev" => "Previous posts"]
		]) ?>


		<ul class="items articles articlePreviewList i:articlePreviewList">
			<? foreach($items["range_items"] as $item):
				$media = $IC->sliceMediae($item, "mediae"); ?>
			<li class="item article id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/NewsArticle"<?= HTML()->jsData(["readstate"]) ?>>

				<?= HTML()->renderSnippet("snippets/media.php", [
					"item" => $item,
					"media" => $media,
				]) ?>


				<?= HTML()->renderSnippet("snippets/tags.php", [
					"item" => $item,
					"context" => [$itemtype],
					"default" => [HTML()->path, "Posts"]
				]) ?>


				<h3 itemprop="headline"><a href="<?= HTML()->path ?>/tag/<?= urlencode($selected_tag) ?>/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h3>


				<?= HTML()->renderSnippet("snippets/info.php", [
					"item" => $item,
					"media" => $media,
					"sharing" => true
				]) ?>


				<? if($item["description"]): ?>
				<div class="description" itemprop="description">
					<p><?= nl2br($item["description"]) ?></p>
				</div>
				<? endif; ?>

			</li>
			<? endforeach; ?>
		</ul>


		<?= HTML()->renderSnippet("snippets/pagination.php", [
			"items" => $items,
			"direction" => "next",
			"base_path" => HTML()->path."/tag/".urlencode($selected_tag), 
			"show_total" => false,
			"labels" => ["next" => "Next posts"]
		]) ?>


	<? else: ?>

		<h2>Technology has limits.</h2>
		<p>We could not find any posts with the selected category.</p>

	<? endif; ?>

	</div>

</div>
