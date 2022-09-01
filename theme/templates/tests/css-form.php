<?
global $model;
global $IC;
global $itemtype;


//$model = new Tests();
$items = $IC->getItems(["itemtype" => $itemtype, "order" => "id ASC"]);
if(!$items) {

	unset($_POST);
	$_POST["name"] = "Test item";

	$item = $model->save(array("save", "tests"));
	$item_id = $item["id"];
}
else {
	$item_id = $items[0]["id"];
}

$item = $IC->getItem(array("id" => $item_id, "extend" => array("tags" => true, "mediae" => true, "comments" => true)));

$v_file_value = $IC->filterMediae($item, "v_file");
$v_files_value = $IC->filterMediae($item, "v_files");

$this->headerIncludes(array(
	"/js/manipulator/src/u-form.js",
	"/js/manipulator/src/u-form-builder.js",
	"/js/manipulator/src/u-form-labelstyle-inject.js",
	"/js/manipulator/src/u-form-field-location.js",

	"/js/manipulator/src/u-form-field-html.js",
	"/js/manipulator/src/u-sortable.js",
));

?>
<script type="text/javascript">

u.m["testForm"] = new function() {
	this.init = function(form) {

		u.f.init(form);

		form.submitted = function() {
			this.response = function(response) {
				page.notify(response);

				u.f.updateFilelistStatus(this, response);
			}
			u.request(this, this.action, {"data":this.getData({"format":"formdata"}), "method":"post"});
		}

	}
}


</script>

<div class="scene i:scene defaultEdit tests">
	<h1>Form CSS</h1>	
	<h2>Testing backend UI</h2>

	<?= $JML->editGlobalActions($item) ?>

	<div class="tests item">

		<h3>Test item (All-in-one)</h3>
		<?= $model->formStart("update/".$item["id"], array("class" => "i:testForm labelstyle:inject")) ?>
			<fieldset>
				<?= $model->input("name", array("value" => $item["name"])) ?>

				<?= $model->input("v_integer", array("value" => $item["v_integer"])) ?>
				<?= $model->input("v_number", array("value" => $item["v_number"])) ?>
				<?= $model->input("v_range", array("value" => $item["v_range"])) ?>

				<?= $model->input("v_email", array("value" => $item["v_email"])) ?>
				<?= $model->input("v_tel", array("value" => $item["v_tel"])) ?>
				<?= $model->input("v_password", array("value" => $item["v_password"])) ?>

				<?= $model->input("v_datetime", array("value" => $item["v_datetime"])) ?>
				<?= $model->input("v_date", array("value" => $item["v_date"])) ?>

				<?= $model->input("v_select", array("value" => $item["v_select"])) ?>

				<?= $model->input("v_text", array("value" => $item["v_text"])) ?>

				<?= $model->input("v_checkbox", array("value" => $item["v_checkbox"])) ?>
				<?= $model->input("v_radiobuttons", array("value" => $item["v_radiobuttons"])) ?>

				<?= $model->input("v_file", array("value" => $v_file_value)) ?>
				<?= $model->input("v_files", array("value" => $v_files_value)) ?>


				<?= $model->input("user_id", array("type" => "string", "value" => $item["user_id"])) ?>
				<?= $model->input("item_id", array("type" => "string", "value" => $item["item_id"])) ?>


				<?= $model->input("v_html", array("value" => $item["v_html"])) ?>

				<?= $model->input("v_html", array("value" => $item["v_html"])) ?>

				<?= $model->inputLocation("v_location", "v_latitude", "v_longitude", array("value_loc" => $item["v_location"], "value_lat" => $item["v_latitude"], "value_lon" => $item["v_longitude"])) ?>

				<?//= $model->inputTags("tags", array("type" => "string", "value" => $item["tags"])) ?>
			</fieldset>

			<?= $JML->editActions($item) ?>

			<ul class="actions">
				<?= $model->submit("Button (submit)", array("class" => "primary", "wrapper" => "li.input")); ?>
				<?= $model->submit("Button (button)", array("type" => "button", "wrapper" => "li.input")); ?>
				<?= $model->link("Button (a)", "/janitor/tests", array("class" => "button", "wrapper" => "li.abutton")) ?>
			</ul>
		<?= $model->formEnd() ?>

	</div>


	<?= $JML->editTags($item) ?>

	<?= $JML->editMediae($item, ["label" => "Mediae"]) ?>

	<?= $JML->editMediae($item, ["label" => "v_files", "variant" => "v_files"]) ?>

	<?= $JML->editSingleMedia($item, ["label" => "Single Media"]) ?>

	<?= $JML->editSingleMedia($item, ["label" => "v_file", "variant" => "v_file"]) ?>

	<?= $JML->editOwner($item) ?>

	<?= $JML->editComments($item) ?>

</div>	