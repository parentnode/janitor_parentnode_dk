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
				page.notify(response);
				u.xInObject(response);
			}
			u.request(this, this.action, {"params":u.f.getParams(this, {"send_as":"formdata"}), "method":"post"});

		}
	}	
}

</script>

<div class="scene tests defaultEdit i:scene">
	<h1>HTML Class (Form interface)</h1>
	<h2>Type validation test</h2>

	<ul class="actions">
		<?= $model->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<div class="tests">
		<h3>String validation</h3>
		<?= $model->formStart("stringValidation", array("class" => "labelstyle:inject i:testValidation string")) ?>
			<fieldset>
				<?= $model->input("name") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Text validation</h3>
		<?= $model->formStart("textValidation", array("class" => "labelstyle:inject i:testValidation text")) ?>
			<fieldset>
				<?= $model->input("v_text") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>HTML validation</h3>
		<?= $model->formStart("htmlValidation", array("class" => "labelstyle:inject i:testValidation html")) ?>
			<fieldset>
				<?= $model->inputHTML("v_html") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Select validation</h3>
		<?= $model->formStart("selectValidation", array("class" => "labelstyle:inject i:testValidation select")) ?>
			<fieldset>
				<?= $model->input("v_select") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Email validation</h3>
		<?= $model->formStart("emailValidation", array("class" => "labelstyle:inject i:testValidation email")) ?>
			<fieldset>
				<?= $model->input("v_email") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Phone validation</h3>
		<?= $model->formStart("telValidation", array("class" => "labelstyle:inject i:testValidation tel")) ?>
			<fieldset>
				<?= $model->input("v_tel") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Password validation</h3>
		<?= $model->formStart("passwordValidation", array("class" => "labelstyle:inject i:testValidation password")) ?>
			<fieldset>
				<?= $model->input("v_password") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Date validation</h3>
		<?= $model->formStart("dateValidation", array("class" => "labelstyle:inject i:testValidation date")) ?>
			<fieldset>
				<?= $model->input("v_date") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Datetime validation</h3>
		<?= $model->formStart("datetimeValidation", array("class" => "labelstyle:inject i:testValidation datetime")) ?>
			<fieldset>
				<?= $model->input("v_datetime") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Integer validation</h3>
		<?= $model->formStart("integerValidation", array("class" => "labelstyle:inject i:testValidation integer")) ?>
			<fieldset>
				<?= $model->input("v_integer") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Number validation</h3>
		<?= $model->formStart("numberValidation", array("class" => "labelstyle:inject i:testValidation number")) ?>
			<fieldset>
				<?= $model->input("v_number") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Number validation</h3>
		<?= $model->formStart("numberValidation", array("class" => "labelstyle:inject i:testValidation number")) ?>
			<fieldset>
				<?= $model->input("v_number") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Checkbox validation</h3>
		<?= $model->formStart("checkboxValidation", array("class" => "labelstyle:inject i:testValidation number")) ?>
			<fieldset>
				<?= $model->input("v_checkbox") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Tag validation</h3>
		<?= $model->formStart("tagValidation", array("class" => "labelstyle:inject i:testValidation tag")) ?>
			<fieldset>
				<?= $model->inputTags("tag") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

	<div class="tests">
		<h3>Files validation</h3>
		<?= $model->formStart("fileValidation", array("class" => "labelstyle:inject i:testValidation file")) ?>
			<fieldset>
				<?= $model->input("v_file") ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>

</div>	