<?
global $model;
//$model = new Tests();
$item = array("status" => 1, "id" => 1);
	
?>
<script type="text/javascript">
u.o["testValidation"] = new function() {
	this.init = function(form) {

		u.f.init(form, {"validation":false});
		form.submitted = function() {
			this.response = function(response) {
				u.xInObject(response);
			}
			u.request(this, this.action, {"params":u.f.getParams(this), "method":"post"});

		}
	}	
}

</script>

<div class="scene tests defaultEdit i:scene">
	<h1>HTML Class (Form interface)</h1>	
	<ul class="actions">
		<?= $model->link("Back", "/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	
	<h2>Date validation</h2>
	<?= $model->formStart("/tests/dateValidation", array("class" => "labelstyle:inject i:testValidation date")) ?>
		<fieldset>
			<?= $model->input("date") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>

	<h2>Datetime validation</h2>
	<?= $model->formStart("/tests/datetimeValidation", array("class" => "labelstyle:inject i:testValidation datetime")) ?>
		<fieldset>
			<?= $model->input("datetime") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>

	<h2>Integer validation</h2>
	<?= $model->formStart("/tests/integerValidation", array("class" => "labelstyle:inject i:testValidation integer")) ?>
		<fieldset>
			<?= $model->input("integer") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>

	<h2>Number validation</h2>
	<?= $model->formStart("/tests/numberValidation", array("class" => "labelstyle:inject i:testValidation number")) ?>
		<fieldset>
			<?= $model->input("number") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


</div>	