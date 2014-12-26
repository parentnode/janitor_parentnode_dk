<?
global $model;
//$model = new Tests();
$item = array("status" => 1, "id" => 1);
	
?>
<script type="text/javascript">
u.o["testValidation"] = new function() {
	this.init = function(form) {
		u.bug("init")
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
		<?= $model->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<h2>String validation</h2>
	<?= $model->formStart("stringValidation", array("class" => "labelstyle:inject i:testValidation string")) ?>
		<fieldset>
			<?= $model->input("name") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Text validation</h2>
	<?= $model->formStart("textValidation", array("class" => "labelstyle:inject i:testValidation text")) ?>
		<fieldset>
			<?= $model->input("v_text") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>HTML validation</h2>
	<?= $model->formStart("htmlValidation", array("class" => "labelstyle:inject i:testValidation html")) ?>
		<fieldset>
			<?= $model->inputHTML("v_html") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Select validation</h2>
	<?= $model->formStart("selectValidation", array("class" => "labelstyle:inject i:testValidation select")) ?>
		<fieldset>
			<?= $model->input("v_select") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Email validation</h2>
	<?= $model->formStart("emailValidation", array("class" => "labelstyle:inject i:testValidation email")) ?>
		<fieldset>
			<?= $model->input("v_email") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Phone validation</h2>
	<?= $model->formStart("telValidation", array("class" => "labelstyle:inject i:testValidation tel")) ?>
		<fieldset>
			<?= $model->input("v_tel") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Password validation</h2>
	<?= $model->formStart("passwordValidation", array("class" => "labelstyle:inject i:testValidation password")) ?>
		<fieldset>
			<?= $model->input("v_password") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Date validation</h2>
	<?= $model->formStart("dateValidation", array("class" => "labelstyle:inject i:testValidation date")) ?>
		<fieldset>
			<?= $model->input("v_date") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Datetime validation</h2>
	<?= $model->formStart("datetimeValidation", array("class" => "labelstyle:inject i:testValidation datetime")) ?>
		<fieldset>
			<?= $model->input("v_datetime") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Integer validation</h2>
	<?= $model->formStart("integerValidation", array("class" => "labelstyle:inject i:testValidation integer")) ?>
		<fieldset>
			<?= $model->input("v_integer") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Number validation</h2>
	<?= $model->formStart("numberValidation", array("class" => "labelstyle:inject i:testValidation number")) ?>
		<fieldset>
			<?= $model->input("v_number") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Number validation</h2>
	<?= $model->formStart("numberValidation", array("class" => "labelstyle:inject i:testValidation number")) ?>
		<fieldset>
			<?= $model->input("v_number") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Checkbox validation</h2>
	<?= $model->formStart("checkboxValidation", array("class" => "labelstyle:inject i:testValidation number")) ?>
		<fieldset>
			<?= $model->input("v_checkbox") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Tag validation</h2>
	<?= $model->formStart("tagValidation", array("class" => "labelstyle:inject i:testValidation tag")) ?>
		<fieldset>
			<?= $model->inputTags("tag") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<h2>Files validation</h2>
	<?= $model->formStart("fileValidation", array("class" => "labelstyle:inject i:testValidation file")) ?>
		<fieldset>
			<?= $model->input("v_file") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


</div>	