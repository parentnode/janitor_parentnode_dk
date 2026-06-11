<?php
global $action;
global $itemtype;


$IC = new Items();
$sindex = $action[0];


$pagination_pattern = [
	"pattern" => [
		"itemtype" => $itemtype, 
		"status" => 1, 
		"extend" => [
			"tags" => true, 
			"user" => true, 
			"mediae" => true,
			"readstate" => true,
		]
	],
	"sindex" => $sindex,
	"limit" => 1
];


// Get posts
$pagination_items = $IC->paginate($pagination_pattern);


if($pagination_items && $pagination_items["range_items"]) {

	$item = $pagination_items["range_items"][0];
	$this->sharingMetaData($item);

	// set related pattern
	$related_pattern = [
		"itemtype" => $item["itemtype"], 
		"tags" => $item["tags"], 
		"exclude" => $item["id"]
	];
	$related_title = "Related posts";

}
else {

	// itemtype pattern for missing item
	$related_pattern = ["itemtype" => $itemtype];
	$related_title = "Other posts";

}

// add base pattern properties
$related_pattern["limit"] = 5;
$related_pattern["extend"] = [
	"tags" => true, 
	"readstate" => true, 
	"user" => true, 
	"mediae" => true
];

// get related items
$related_items = $IC->getRelatedItems($related_pattern);


?>

<div class="scene post i:postitem">

<? if($item):
	$media = $IC->sliceMediae($item, "mediae"); ?>

	<div class="article i:article id:<?= $item["item_id"] ?><?= $item["classname"] ? " ".$item["classname"] : "" ?>" itemscope itemtype="http://schema.org/NewsArticle"<?= HTML()->jsData(["readstate"]) ?>>

		<?= HTML()->renderSnippet("snippets/media.php", [
			"item" => $item,
			"media" => $media,
		]) ?>


		<?= HTML()->renderSnippet("snippets/tags.php", [
			"item" => $item,
			"context" => [$itemtype],
			"default" => [HTML()->path, "Posts"]
		]) ?>


		<h1 itemprop="headline"><?= $item["name"] ?></h1>


		<?= HTML()->renderSnippet("snippets/info.php", [
			"item" => $item,
			"media" => $media,
			"sharing" => true
		]) ?>


		<div class="articlebody" itemprop="articleBody">
			<?= $item["html"] ?>
		</div>

	</div>


	<?= HTML()->renderSnippet("snippets/categories.php", [
		"item" => $item,
		"itemtype" => $itemtype,
	]) ?>


	<?= HTML()->renderSnippet("snippets/pagination.php", [
		"items" => $pagination_items,
		"type" => "sindex",
		"show_total" => false,
		"labels" => ["prev" => "{name}", "next" => "{name}"]
	]) ?>


<? else: ?>

	<div class="article">
		<h1>Technology has limits</h1>
		<p>We could not find the specified post.</p>
	</div>

<? endif; ?>


<?= HTML()->renderSnippet("snippets/related.php", [
	"items" => $related_items,
]) ?>


</div>
