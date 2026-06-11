<?php
global $action;
global $itemtype;


$IC = new Items();

// List extension (page > 1)
if(count($action) === 2) {
	$page = $action[1];
	$page_item = false;
}
// Default list
else {
	$page = false;
	$page_item = $IC->getItem([
		"itemtype" => "page",
		"tags" => "page:Posts", 
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
	"page" => $page,
	"limit" => 5
];

// Get posts
$items = $IC->paginate($pagination_pattern);

?>

<div class="scene posts i:postitems">

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
			"url" => HTML()->path,
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
		<h1>Posts</h1>
	</div>

<? endif; ?>


	<?= HTML()->renderSnippet("snippets/categories.php", [
		"itemtype" => $itemtype,
	]) ?>


	<div class="articles">

<? if($items): ?>

		<h2>All posts</h2>


		<?= HTML()->renderSnippet("snippets/pagination.php", [
			"items" => $items,
			"direction" => "prev",
			"show_total" => false,
			"labels" => ["prev" => "Previous posts"]
		]) ?>


		<ul class="articles articlePreviewList i:articlePreviewList">
<?			foreach($items["range_items"] as $item):
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


				<h3 itemprop="headline"><a href="<?= HTML()->path ?>/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h3>


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
			"show_total" => false,
			"labels" => ["next" => "Next posts"]
		]) ?>


<? else: ?>

		<p>No posts</p>

<? endif; ?>

	</div>

</div>
