<?php
global $module_group_id;
global $module_id;

$module = module()->getModule($module_group_id, $module_id);
?>
<div class="scene module i:module pageitem i:pageitem">
	<h1>Itemtype page</h1>
	<h2>Configuration</h2>

	<?= HTML()->renderSnippet("snippets/modules/actions-back.php") ?>

	<h3>Module description</h3>
	<?= HTML()->renderSnippet("snippets/modules/panel-info.php", [
		"module" => $module,
	]) ?>

	<h3>Default page viewer</h3>
	<?= $module_class->formStart("modules/updateSettings/instantmessage/telegram", array("class" => "labelstyle:inject")) ?>
		<fieldset>
			<?= $module_class->input("telegram_token", array("value" => $telegram_token)) ?>
			<?= $module_class->input("telegram_chat_id", array("value" => $telegram_chat_id)) ?>
		</fieldset>

		<ul class="actions">
			<?= $module_class->submit("Save", array("wrapper" => "li.save", "class" => "primary")) ?>
			<?= $module_class->link("Cancel", "modules", array("class" => "button key:esc", "wrapper" => "li.cancel")) ?>
		</ul>

	<?= $module_class->formEnd() ?>

	<?= HTML()->formStart("updateSettings") ?>
		<fieldset>
			<?= HTML()->input("default_view_path", [
				"label" => "Default page viewer path",
				"value" => $module["settings"]["default_view_path"] ?? "",
			]) ?>
		</fieldset>
	<?= HTML()->formEnd() ?>

	<?= HTML()->renderSnippet("snippets/modules/panel-version.php", [
		"module" => $module,
	]) ?>
	<?= HTML()->renderSnippet("snippets/modules/panel-upgrade.php", [
		"module" => $module,
	]) ?>
	<?= $HTML->renderSnippet("snippets/modules/panel-uninstall.php",  [
		"module" => $module,
	]) ?>

</div>