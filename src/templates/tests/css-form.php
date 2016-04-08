<?
global $model;
global $IC;
global $itemtype;


//$model = new Tests();
$items = $IC->getItems(array("itemtype" => $itemtype));
if(!$items) {

	unset($_POST);
	$_POST["name"] = "Test item";

	$item = $model->save(array("save", "tests"));
	$item_id = $item["id"];
}
else {
	$item_id = $items[0]["id"];
}

$item = $IC->getItem(array("id" => $item_id, "extend" => array("tags" => false, "mediae" => false)));
	
?>
<script type="text/javascript">

u.o["testForm"] = new function() {
	this.init = function(form) {
		u.bug("init")
		u.f.init(form);

		form.submitted = function() {
			this.response = function(response) {
				page.notify(response);

				u.xInObject(response);

			}
			u.request(this, this.action, {"params":u.f.getParams(this, {"send_as":"formdata"}), "method":"post"});

		}
	}	
}

</script>

<div class="scene i:scene tests">
	<h1>Form CSS</h1>	
	<h2>Testing backend UI</h2>

	<ul class="actions">
		<?= $model->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<div class="tests">

		<h3>Test item (All-in-one)</h3>
		<?= $model->formStart("update/".$item["id"], array("class" => "i:testForm labelstyle:inject")) ?>
			<fieldset>
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


				<?= $model->inputHTML("v_html", array("value" => $item["v_html"])) ?>
				<?= $model->inputLocation("v_location", "v_latitude", "v_longitude", array("value_loc" => $item["v_location"], "value_lat" => $item["v_latitude"], "value_lon" => $item["v_longitude"])) ?>
			</fieldset>

			<?= $JML->editActions($item) ?>
		<?= $model->formEnd() ?>

	</div>


	<?//= $JML->editTags($item) ?>

	<?//= $JML->editMedia($item) ?>


</div>	