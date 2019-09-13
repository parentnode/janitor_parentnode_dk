<?
global $model;
global $IC;

?>

<div class="scene i:scene tests">
	<h1>HTML Class</h1>	
	<h2>HTML generation</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests #method#">
		<h3>#Test name#</h3>
		<?= $HTML->formStart("update/".$item["id"], array("class" => "i:testForm labelstyle:inject")) ?>
				<?= $HTML->input("name", array("type" => "string", "value" => $item["name"])) ?>
		<?= $HTML->formEnd() ?>


		<?= $model->formStart("update/".$item["id"], array("class" => "i:testForm labelstyle:inject")) ?>
			<fieldset>
				<?= $model->input("name", array("value" => $item["name"])) ?>
			</fieldset>
		<?= $model->formEnd() ?>


		<? 

		// Your test code
		if("Your test condition"): ?>
		<div class="testpassed">#Class::method# - correct</div>
		<? else: ?>
		<div class="testfailed">#Class::method# - error</div>
		<? endif; ?>
	</div>

</div>