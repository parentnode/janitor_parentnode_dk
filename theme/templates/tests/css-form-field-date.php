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


$this->headerIncludes(array(
	"/js/manipulator/src/u-form.js",
	"/js/manipulator/src/u-form-labelstyle-inject.js",
));

?>
<script type="text/javascript">

u.m["testForm"] = new function() {
	this.init = function(form) {

		u.f.init(form);
		form.updated = function(iN) {
			u.bug("updated", iN.name, iN.type, iN.val(), iN.value);
		}
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
	<h1>Form CSS – Date Field</h1>	
	<h2>Testing backend and frontend</h2>

	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests item">

		<h3>Test item (All-in-one)</h3>
		<?= $model->formStart("update/".$item["id"], array("class" => "i:testForm labelstyle:inject")) ?>
			<fieldset>

				<?= $model->input("v_date", array("value" => $item["v_date"])) ?>
				<?= $model->input("v_datetime", array("value" => $item["v_datetime"])) ?>

			</fieldset>

			<?= $JML->editActions($item) ?>
		<?= $model->formEnd() ?>

	</div>

	<div class="tests item">

		<h3>Test item (All-in-one)</h3>
		<?= $model->formStart("update/".$item["id"], array("class" => "i:testForm labelstyle:inject")) ?>
			<fieldset>

				<?= $model->input("v_date", array("value" => $item["v_date"], "required" => false)) ?>
				<?= $model->input("v_datetime", array("value" => $item["v_datetime"], "required" => false)) ?>

			</fieldset>

			<?= $JML->editActions($item) ?>
		<?= $model->formEnd() ?>

	</div>

</div>	