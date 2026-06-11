<?php
global $action;
global $IC;
global $model;
global $itemtype;

$item_id = $action[1];
$item = $IC->getItem(array("id" => $item_id, "extend" => array("tags" => true, "mediae" => true)));
?>
<div class="scene i:scene defaultEdit <?= $itemtype ?>Edit">
	<h1>Edit Post</h1>
	<h2><?= strip_tags($item["name"]) ?></h2>

	<?= $JML->editGlobalActions($item) ?>

	<?= $JML->previewUrl($item) ?>

	<?= $JML->editSingleMedia($item, array("label" => "Main post image")) ?>


	<div class="item i:defaultEdit">
		<h2>Post text</h2>
		<?= $model->formStart("update/".$item_id, array("class" => "labelstyle:inject")) ?>

			<fieldset>
				<?= $model->input("published_at", array("value" => date("Y-m-d H:i", strtotime($item["published_at"])))) ?>

				<?= $model->input("name", array("value" => $item["name"])) ?>
				<?= $model->input("description", array("class" => "autoexpand short", "value" => $item["description"])) ?>
				<?= $model->input("html", array("value" => $item["html"])) ?>
			</fieldset>

			<?= $JML->editActions($item) ?>

		<?= $model->formEnd() ?>
	</div>


	<?= $JML->editTags($item, ["context" => $itemtype]) ?>

	<?= $JML->editCannonicalUrl($item) ?>

	<?= $JML->editSindex($item) ?>

	<?= $JML->editOwner($item) ?>

	<?= $JML->editDeveloperSettings($item) ?>

</div>
