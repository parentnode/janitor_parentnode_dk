<?php
global $module_group_id;
global $module_id;

$module = module()->getModule($module_group_id, $module_id);
$controllers = module()->getItemControllers($module_id);

?>
<div class="scene module i:module postitem i:postitem">
	<h1>Itemtype post</h1>
	<h2>Configuration</h2>

	<?= HTML()->renderSnippet("snippets/modules/actions-back.php") ?>

	<h3>Module description</h3>
	<?= HTML()->renderSnippet("snippets/modules/panel-info.php", [
		"module" => $module,
	]) ?>
	<?= HTML()->renderSnippet("snippets/modules/panel-version.php", [
		"module" => $module,
	]) ?>


	<div class="controllers">
		<h2>Controllers</h2>

		<p>
			Controllers are used to access post items and create meaningful urls on your website.
		</p>
		<p>
			Your post items can be accessed via any of your post item controllers by adding the post item sindex to the 
			controller path, like this: .
		</p>
		<code><?= SITE_URL ?>/posts/post-item-sindex</code>

		<h3>Existing post item controllers</h3>
		<ul class="controllers" 
			data-csrf-token="<?= session()->value("csrf") ?>"
			data-delete-action="<?= security()->validPath(HTML()->path."/modules/deleteController/item/post") ?>"
			data-confirm-value="Are you sure?"
			data-button-name="delete"
			data-button-value="Delete"
		>
			<? foreach($controllers as $controller): ?>
			<li>
				<h4><?= $controller ?></h4>
			</li>
			<? endforeach;	?>
		</ul>

		<?= HTML()->formStart("modules/addController/item/post", array("class" => "new labelstyle:inject")) ?>
			<fieldset>
				<h3>Add new controller</h3>
				<p>
					You can add new controllers to make up the url structure you prefer. Use meaningful names, without special 
					characters or spaces since these does not work well acroos different platforms. Use - to separate words.
				</p>
				<?= HTML()->input("controller_path", [
					"type" => "string",
					"label" => "New controller",
					"required" => true,
					"pattern" => "^\/[a-z\/]+$",
					"hint_message" => "State the path/name of the new controller relative to your domain root. Must be lowercase, only a-z and /.",
					"error_message" => "Controller path is invalid. It must start with / and contain only a-z and /.",
				]) ?>
			</fieldset>

			<ul class="actions">
				<?= HTML()->submit("Add controller", array("wrapper" => "li.save", "class" => "primary")) ?>
			</ul>
		<?= HTML()->formEnd() ?>

	</div>

	<?= HTML()->renderSnippet("snippets/modules/panel-upgrade.php", [
		"module" => $module,
	]) ?>
	<?= $HTML->renderSnippet("snippets/modules/panel-uninstall.php",  [
		"module" => $module,
	]) ?>

</div>