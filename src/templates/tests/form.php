<?
global $model;
//$model = new Tests();
$item = array("status" => 1, "id" => 1);
	
?>
<script type="text/javascript">
</script>

<div class="scene tests defaultEdit i:scene">
	<h1>HTML Class - For testing Janitor backend interface</h1>	

	
	<h2>Date validation</h2>
	<?= $model->formStart("/tests/testDateValidation", array("class" => "labelstyle:inject i:testValidation date")) ?>
		<fieldset>
			<?= $model->input("date") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>

	<h2>Datetime validation</h2>
	<?= $model->formStart("/tests/testDatetimeValidation", array("class" => "labelstyle:inject i:testValidation datetime")) ?>
		<fieldset>
			<?= $model->input("datetime") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>

	<h2>Integer validation</h2>
	<?= $model->formStart("/tests/testIntegerValidation", array("class" => "labelstyle:inject i:testValidation integer")) ?>
		<fieldset>
			<?= $model->input("integer") ?>
		</fieldset>

		<ul class="actions">
			<?= $model->submit("Update", array("wrapper" => "li.save")) ?>
		</ul>
	<?= $model->formEnd() ?>


	<div class="item i:_defaultEdit">
		<h2>All-in-one content</h2>
		<?= $model->formStart("/", array("class" => "labelstyle:inject")) ?>
			<fieldset>
				<?= $model->input("string", array("type" => "string", "label" => "String", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>
				<?= $model->input("integer", array("type" => "integer", "label" => "integer", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>
				<?= $model->input("number", array("type" => "number", "label" => "number", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>

				<?= $model->input("email", array("type" => "email", "label" => "email", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>
				<?= $model->input("tel", array("type" => "tel", "label" => "tel", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>
				<?= $model->input("password", array("type" => "password", "label" => "password", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>

				<?= $model->input("datetime", array("type" => "datetime", "label" => "Datetime", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>
				<?= $model->input("date", array("type" => "date", "label" => "Date", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>

				<?= $model->input("description", array("type" => "text", "class" => "autoexpand short", "label" => "Text", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>

				<?= $model->input("html", array("type" => "html", "label" => "HTML", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>

				<?= $model->input("checkbox1", array("type" => "checkbox", "label" => "Checkbox", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>
				<?= $model->input("checkbox2", array("type" => "checkbox", "label" => "Checkbox", "value" => 1, "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>

				<?= $model->input("radiobuttons", array("type" => "radiobuttons", "label" => "Radiobuttons", "value" => "value2", "options" => array("value1" => "text1", "value2" => "text2"), "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>

				<?= $model->input("select", array("type" => "select", "value" => "value2", "options" => array("value1" => "text1", "value2" => "text2"), "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>

				<?= $model->inputLocation("location", "latitude", "longitude", array("label_loc" => "Location", "label_lat" => "latitude", "label_lon" => "Longitude", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>
			</fieldset>

			<ul class="actions">
				<?= $model->link("Back", "/", array("class" => "button key:esc", "wrapper" => "li.cancel")) ?>
				<?= $model->submit("Update", array("class" => "primary key:s", "wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>



		<?= $model->formStart("/tests/testDateValidation", array("class" => "labelstyle:inject")) ?>
			<fieldset>
				<?= $model->input("datetime", array("type" => "datetime", "label" => "Datetime", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>
				<?= $model->input("date", array("type" => "date", "label" => "Date", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>
			</fieldset>

			<ul class="actions">
				<?= $model->link("Back", "/", array("class" => "button key:esc", "wrapper" => "li.cancel")) ?>
				<?= $model->submit("Update", array("class" => "primary key:s", "wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>
	</div>


	<div class="media i:_addMedia sortable item_id:1"
		data-save-order="/" 
		data-delete-media="/"
		data-update-media-name="/"
		>
		<h2>Media</h2>
		<?= $model->formStart("/", array("class" => "upload labelstyle:inject")) ?>
			<fieldset>
				<?= $model->input("mediae", array("type" => "files", "label" => "files", "required" => true, "error_message" => "error message", "hint_message" => "hint_message")) ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Add image", array("class" => "primary", "wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>

		<ul class="mediae">
			<li class="media image variant:missing_image media_id:1">
				<img src="/images/0/missing_image/x150.png" />
				<p>Image name 1</p>
			</li>
			<li class="media image variant:missing_image media_id:1">
				<img src="/images/0/missing_image/x150.png" />
				<p>Image name 2</p>
			</li>
			<li class="media image variant:missing_image media_id:1">
				<img src="/images/0/missing_image/x150.png" />
				<p>Image name 3</p>
			</li>
		</ul>

	</div>


	<div class="tags i:_defaultTags item_id:1"
		data-get-tags="/" 
		data-delete-tag="/"
		>
		<h2>Tags</h2>
		<?= $model->formStart("/", array("class" => "labelstyle:inject")) ?>
			<fieldset>
				<?= $model->input("tags", array("type" => "tags")) ?>
			</fieldset>

			<ul class="actions">
				<?= $model->submit("Add new tag", array("class" => "primary", "wrapper" => "li.save")) ?>
			</ul>
		<?= $model->formEnd() ?>

		<ul class="tags">
			<li class="tag">
				<span class="context">context</span>:<span class="value">value 1</span>
			</li>
			<li class="tag">
				<span class="context">context</span>:<span class="value">value 2</span>
			</li>
			<li class="tag">
				<span class="context">context</span>:<span class="value">value 3</span>
			</li>
		</ul>
	</div>

</div>	