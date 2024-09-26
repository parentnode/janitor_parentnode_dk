<?php

@include_once("classes/adapters/instantmessages/telegram.class.php");
$module_class = new JanitorTelegram(false);

$connect_values = $module_class->getConnectValues("instantmessages");

$telegram_token = isset($connect_values["telegram_token"]) ? $connect_values["telegram_token"] : "";
$telegram_chat_id = isset($connect_values["telegram_chat_id"]) ? $connect_values["telegram_chat_id"] : "";

$module_type = isset($connect_values["type"]) ? $connect_values["type"] : "";

?>
<div class="scene module i:module telegram i:telegram">

	<h1>Telegram configuration</h1>
	<h2>Instant messages</h2>

	<? if($module_type !== "telegram"): ?>
	<p class="warning">The system is currently configured for another Instant messaging module.</p>
	<? endif; ?>

	<p>Enter your Telegram token and chat_id to enable sending messages to Telegram.</p>

	<?= $module_class->formStart("modules/updateSettings/instantmessages/telegram", array("class" => "labelstyle:inject")) ?>
		<fieldset>
			<?= $module_class->input("telegram_token", array("value" => $telegram_token)) ?>
			<?= $module_class->input("telegram_chat_id", array("value" => $telegram_chat_id)) ?>
		</fieldset>

		<ul class="actions">
			<?= $module_class->submit("Save", array("wrapper" => "li.save", "class" => "primary")) ?>
		</ul>

	<?= $module_class->formEnd() ?>

</div>