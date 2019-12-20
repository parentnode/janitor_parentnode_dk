<?php
global $action;
global $IC;
global $model;
global $itemtype;

$sindex = false;
$page = false;

if(count($action) == 3 && $action[1] == "page") {
	$page = $action[2];
}
else if(count($action) == 2) {
	$sindex = $action[1];
}

$limit = 2;

$items = $IC->paginate([
	"limit" => $limit, 
	"pattern" => array(
		"itemtype" => $itemtype, 
		"order" => "status DESC, position ASC", 
		"extend" => [
			"tags" => true, 
			"mediae" => true
		]
	),
	"sindex" => $sindex,
	"page" => $page
]);

?>

<div class="scene i:scene defaultList <?= $itemtype ?>List">
	<h1>Tests</h1>

	<ul class="actions">
		<?= $JML->listNew(array("label" => "New test")) ?>
	</ul>

	<div class="all_items i:defaultList taggable filters sortable images width:100"<?= $HTML->jsData(["order", "tags", "search"]) ?>>
<?		if($items && $items["range_items"]): ?>
		<ul class="items">
<?			foreach($items["range_items"] as $item):?>
			<li class="item item_id:<?= $item["id"] ?><?= $HTML->jsMedia($item, "mediae") ?>">
				<h3><?= strip_tags($item["name"]) ?></h3>

				<?= $JML->tagList($item["tags"]) ?>

				<?= $JML->listActions($item) ?>
			 </li>
<?			endforeach; ?>
		</ul>


		<?= $HTML->pagination($items, ["base_url" => "/janitor/tests/list"]) ?>


<?		else: ?>
		<p>No test items.</p>
<?		endif; ?>
	</div>

</div>
