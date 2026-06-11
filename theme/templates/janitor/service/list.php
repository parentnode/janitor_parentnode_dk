<?php
global $action;
global $IC;
global $model;
global $itemtype;

$items = $IC->getItems(array("itemtype" => $itemtype, "order" => "status DESC, position ASC, published_at DESC", "extend" => array("tags" => true, "mediae" => true)));
?>

<div class="scene i:scene defaultList <?= $itemtype ?>List">
	<h1>Services</h1>

	<ul class="actions">
		<?= $JML->listNew(array("label" => "New service")) ?>
	</ul>

	<div class="all_items i:defaultList taggable sortable filters"<?= $HTML->jsData(["order", "tags", "search"], ["filter-tag-contexts" => $itemtype]) ?>>
<?		if($items): ?>
		<ul class="items">
<?			foreach($items as $item): ?>
			<li class="item item_id:<?= $item["id"] ?>">
				<h3><?= strip_tags($item["name"]) ?></h3>

				<?= $JML->tagList($item["tags"], ["context" => $itemtype]) ?>

				<?= $JML->listActions($item) ?>
			 </li>
<?			endforeach; ?>
		</ul>
<?		else: ?>
		<p>No services.</p>
<?		endif; ?>
	</div>

</div>
