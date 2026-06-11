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


$pagination_items = $IC->paginate($pagination_pattern);


if($pagination_items && $pagination_items["range_items"]) {

	$item = $pagination_items["range_items"][0];

	$this->pageTitle($item["name"]);
	$this->bodyClass($item["classname"] ? $item["classname"] : "services");
	$this->sharingMetaData($item);

	// set related pattern
	$related_pattern = [
		"itemtype" => $item["itemtype"], 
		"tags" => $item["tags"], 
		"exclude" => $item["id"]
	];

	$related_title = "Related services";

}
else {
	// itemtype pattern for missing item
	$related_pattern = ["itemtype" => $itemtype];
	$related_title = "Other services";

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

<div class="scene service i:serviceitem">

<? if($item):
	$media = $IC->sliceMediae($item, "single_media"); ?>

	<div class="article i:article id:<?= $item["item_id"] ?> service" itemscope itemtype="http://schema.org/Article"<?= HTML()->jsData(["readstate"]) ?>>

		<?= HTML()->renderSnippet("snippets/media.php", [
			"item" => $item,
			"media" => $media,
		]) ?>


		<?= HTML()->renderSnippet("snippets/tags.php", [
			"item" => $item,
			"context" => [$itemtype],
			"default" => [HTML()->path, "Services"]
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


	<?= HTML()->renderSnippet("snippets/pagination.php", [
		"items" => $pagination_items,
		"type" => "sindex",
		"show_total" => false,
		"labels" => ["prev" => "{name}", "next" => "{name}"]
	]) ?>


<? else: ?>

	<h1>Technology has limits</h1>
	<p>We could not find the specified service.</p>

<? endif; ?>


<?= HTML()->renderSnippet("snippets/related.php", [
	"items" => $related_items,
]) ?>


<? if($related_items): ?>
	<div class="related">
		<h2><?= $related_title ?> <a href="/services">(see all)</a></h2>

		<ul class="items services">
<?		foreach($related_items as $item): 
			$media = $IC->sliceMediae($item, "single_media"); ?>
			<li class="item service item_id:<?= $item["item_id"] ?>" itemscope itemtype="http://schema.org/NewsArticle"
				data-readstate="<?= $item["readstate"] ?>"
				>

				<h3 itemprop="headline"><a href="/services/<?= $item["sindex"] ?>"><?= strip_tags($item["name"]) ?></a></h3>


				<?= HTML()->renderSnippet("snippets/info.php", [
					"item" => $item,
					"media" => $media,
				]) ?>

				<?/*= $HTML->articleInfo($item, "/services/".$item["sindex"], [
					"media" => $media
				])*/ ?>


				<? if($item["description"]): ?>
				<div class="description" itemprop="description">
					<p><?= nl2br($item["description"]) ?></p>
				</div>
				<? endif; ?>

			</li>
	<?	endforeach; ?>
		</ul>
	</div>
<? endif; ?>


</div>
