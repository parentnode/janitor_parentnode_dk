<?php
global $action;
global $IC;
global $model;
global $itemtype;

$sindex = isset($action[1]) ? $action[1] : false;
$limit = 100;

$items = $IC->paginate(array(
	"limit" => $limit, 
	"pattern" => array(
		"itemtype" => $itemtype, 
		"order" => "status DESC, position ASC", 
		"extend" => array(
			"tags" => true, 
			"mediae" => true
		)
	),
	"sindex" => $sindex
));

?>

<div class="scene i:scene defaultList <?= $itemtype ?>List">
	<h1>Tests</h1>

	<ul class="actions">
		<?= $JML->listNew(array("label" => "New test")) ?>
	</ul>

	<div class="all_items i:defaultList taggable filters sortable images width:100"<?= $JML->jsData(["order", "tags", "search"]) ?>>
<?		if($items && $items["range_items"]): ?>
		<ul class="items">
<?			foreach($items["range_items"] as $item):?>
			<li class="item item_id:<?= $item["id"] ?><?= $JML->jsMedia($item, "mediae") ?>">
				<h3><?= strip_tags($item["name"]) ?></h3>

				<?= $JML->tagList($item["tags"]) ?>

				<?= $JML->listActions($item) ?>
			 </li>
<?			endforeach; ?>
		</ul>
		
		<? if($items["next"] || $items["prev"]): ?>
		<div class="pagination">
			<ul>
				<? if($items["prev"]): ?>
				<li class="previous"><a href="/janitor/tests/list/<?= $items["prev"][0]["sindex"] ?>">Previous</a></li>
				<? else: ?>
				<li class="previous"><a class="disabled">Previous</a></li>
				<? endif; ?>
				<li><?= ceil($items["total"] / $limit) ?> pages</li>
				<? if($items["next"]): ?>
					<li class="next"><a href="/janitor/tests/list/<?= $items["next"][0]["sindex"] ?>">Next</a></li>
				<? else: ?>	
				<li class="next"><a class="disabled">Next</a></li>
				<? endif; ?>
			</ul>
		</div>
		<? endif; ?>
		
<?		else: ?>
		<p>No test items.</p>
<?		endif; ?>
	</div>

</div>
