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
			u.request(this, this.action, {"params":u.f.getParams(this, {"send_as":"formdata"}), "method":"post"});

		}
	}	
}

</script>

<div class="scene tests defaultEdit i:scene">
	<h1>HTML Class (Form interface)</h1>	
	<ul class="actions">
		<?= $model->link("Back", "/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<h2>String validation</h2>
	<?= $model->formStart("/tests/stringValidation", array("class" => "labelstyle:inject i:testValidation string")) ?>
		<fieldset>
			<?= $model->input("string") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Text validation</h2>
	<?= $model->formStart("/tests/textValidation", array("class" => "labelstyle:inject i:testValidation text")) ?>
		<fieldset>
			<?= $model->input("text") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>HTML validation</h2>
	<?= $model->formStart("/tests/htmlValidation", array("class" => "labelstyle:inject i:testValidation html")) ?>
		<fieldset>
			<?= $model->inputHTML("html") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Select validation</h2>
	<?= $model->formStart("/tests/selectValidation", array("class" => "labelstyle:inject i:testValidation select")) ?>
		<fieldset>
			<?= $model->input("select") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Email validation</h2>
	<?= $model->formStart("/tests/emailValidation", array("class" => "labelstyle:inject i:testValidation email")) ?>
		<fieldset>
			<?= $model->input("email") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Phone validation</h2>
	<?= $model->formStart("/tests/telValidation", array("class" => "labelstyle:inject i:testValidation tel")) ?>
		<fieldset>
			<?= $model->input("tel") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Password validation</h2>
	<?= $model->formStart("/tests/passwordValidation", array("class" => "labelstyle:inject i:testValidation password")) ?>
		<fieldset>
			<?= $model->input("password") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


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


	<h2>Tag validation</h2>
	<?= $model->formStart("/tests/tagValidation", array("class" => "labelstyle:inject i:testValidation tag")) ?>
		<fieldset>
			<?= $model->inputTags("tag") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Files validation</h2>
	<?= $model->formStart("/tests/fileValidation", array("class" => "labelstyle:inject i:testValidation file")) ?>
		<fieldset>
			<?= $model->input("file") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


</div>	