<?php
global $action;
global $itemtype;


$IC = new Items();

$page_item = $IC->getItem([
	"itemtype" => "page",
	"tags" => "page:Services", 
	"status" => 1, 
	"extend" => [
		"user" => true, 
		"mediae" => true, 
		"tags" => true
	]
]);


if($page_item) {
	$this->sharingMetaData($page_item);
}

$items = $IC->getItems([
	"itemtype" => $itemtype, 
	"status" => 1, 
	"order" => "$itemtype.position ASC", 
	"extend" => [
		"tags" => true, 
		"readstate" => true, 
		"mediae" => true, 
		"user" => true
	]
]);

?>

<div class="scene services i:serviceitems">

<? if($page_item): 
	$media = $IC->sliceMediae($page_item, "single_media"); ?>
	<div class="article i:article id:<?= $page_item["item_id"] ?> service" itemscope itemtype="http://schema.org/Article">

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

<? else:?>

	<div class="article">
		<h1>Services</h1>
	</div>

<? endif; ?>


	<div class="all_services">

<?		if($items): ?>
		<ul class="items services articles articlePreviewList i:articlePreviewList">
<?			foreach($items as $item):
				$media = $IC->sliceMediae($item, "single_media"); ?>
			<li class="item article service id:<?= $item["item_id"] ?><?= $item["classname"] ? " ".$item["classname"] : "" ?>" itemscope itemtype="http://schema.org/Article">

				<?= HTML()->renderSnippet("snippets/media.php", [
					"item" => $item,
					"media" => $media,
				]) ?>


				<?= HTML()->renderSnippet("snippets/tags.php", [
					"item" => $item,
					"context" => [$itemtype]
				]) ?>


				<h2 itemprop="headline"><a href="<?= HTML()->path ?>/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h2>


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
<?			endforeach; ?>
		</ul>

<?		else: ?>

		<p>No services</p>

<?		endif; ?>

	</div>

</div>
