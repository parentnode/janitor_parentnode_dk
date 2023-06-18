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
	"/js/manipulator/src/u-form-field-dropdown.js",
	"/js/manipulator/src/u-form-labelstyle-inject.js",
	"/janitor/admin/css/lib/desktop/s-form.css",
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
	<h1>Form CSS – Dropdown Field</h1>	
	<h2>Testing backend and frontend</h2>

	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests item">

		<h3>Test item (All-in-one)</h3>
		<?= $model->formStart("update/".$item["id"], array("class" => "i:testForm labelstyle:inject")) ?>
			<fieldset>

				<?= $model->input("v_select", array("type" => "dropdown", "value" => $item["v_select"])) ?>
				<?= $model->input("name", array("value" => $item["name"])) ?>

			</fieldset>

			<?= $JML->editActions($item) ?>
		<?= $model->formEnd() ?>

	</div>

	<div class="tests item">

		<h3>Test item (All-in-one)</h3>
		<?= $model->formStart("update/".$item["id"], array("class" => "i:testForm labelstyle:inject")) ?>
			<fieldset>

				<?= $model->input("v_select", array("type" => "dropdown", "value" => $item["v_select"], "required" => false)) ?>

			</fieldset>

			<?= $JML->editActions($item) ?>
		<?= $model->formEnd() ?>

	</div>

</div>	