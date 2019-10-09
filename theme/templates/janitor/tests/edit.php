<?php
global $action;
global $IC;
global $model;
global $itemtype;

$item_id = $action[1];
$item = $IC->getItem(array("id" => $item_id, "extend" => array("tags" => true, "mediae" => true, "comments" => true)));

?>
<div class="scene i:scene defaultEdit <?= $itemtype ?>Edit">
	<h1>Edit test</h1>
	<h2 class="name"><?= strip_tags($item["name"]) ?></h2>

	<?= $JML->editGlobalActions($item) ?>

	<?= $JML->editSindex($item) ?>

	<div class="item i:defaultEdit">
		<h2>Post content</h2>
		<?= $model->formStart("update/".$item["id"], array("class" => "labelstyle:inject")) ?>

			<fieldset>
				<?= $model->input("published_at", array("value" => $item["published_at"])) ?>

				<?= $model->input("name", array("value" => $item["name"])) ?>
				<?= $model->input("v_integer", array("value" => $item["v_integer"])) ?>
				<?= $model->input("v_number", array("value" => $item["v_number"])) ?>

				<?= $model->input("v_email", array("value" => $item["v_email"])) ?>
				<?= $model->input("v_tel", array("value" => $item["v_tel"])) ?>
				<?= $model->input("v_password", array("value" => $item["v_password"])) ?>

				<?= $model->input("v_datetime", array("value" => $item["v_datetime"])) ?>
				<?= $model->input("v_date", array("value" => $item["v_date"])) ?>

				<?= $model->input("v_select", array("value" => $item["v_select"])) ?>

				<?= $model->input("v_text", array("value" => $item["v_text"])) ?>

				<?= $model->input("v_checkbox", array("value" => $item["v_checkbox"])) ?>
				<?= $model->input("v_radiobuttons", array("value" => $item["v_radiobuttons"])) ?>

				<?= $model->input("user_id", array("type" => "string", "value" => $item["user_id"])) ?>
				<?= $model->input("item_id", array("type" => "string", "value" => $item["item_id"])) ?>


				<?= $model->input("v_html", array("value" => $item["v_html"])) ?>

				<?= $model->inputLocation("v_location", "v_latitude", "v_longitude", array("value_loc" => $item["v_location"], "value_lat" => $item["v_latitude"], "value_lon" => $item["v_longitude"])) ?>
			</fieldset>

			<?= $JML->editActions($item) ?>

		<?= $model->formEnd() ?>
	</div>

	<?= $JML->editOwner($item) ?>

	<?= $JML->editTags($item) ?>

	<?= $JML->editMediae($item, ["label" => "Mediae"]) ?>

	<?= $JML->editMediae($item, ["label" => "v_files", "variant" => "v_files"]) ?>

	<?= $JML->editSingleMedia($item, ["label" => "Single Media"]) ?>

	<?= $JML->editSingleMedia($item, ["label" => "v_file", "variant" => "v_file"]) ?>

	<?= $JML->editComments($item) ?>

</div>
