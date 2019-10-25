<?php

global $action;
$IC = new Items();


$this->bodyClass("gettingstarted");
$this->pageTitle("Getting started with Janitor");


$page_item = $IC->getItem(array("tags" => "page:getting-started", "status" => 1, "extend" => array("user" => true, "tags" => true, "mediae" => true)));

?>
<div class="scene gettingstarted i:scene">

<? if($page_item): 
	$media = $IC->sliceMediae($page_item, "single_media"); ?>
	<div class="article i:article" itemscope itemtype="http://schema.org/Article">

		<? if($media): ?>
		<div class="image item_id:<?= $page_item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; ?>


		<?= $HTML->articleTags($page_item, [
			"context" => false
		]) ?>


		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>

		<? if($page_item["subheader"]): ?>
		<h2 itemprop="alternativeHeadline"><?= $page_item["subheader"] ?></h2>
		<? endif; ?>


		<?= $HTML->articleInfo($page_item, "/getting-started", [
			"media" => $media, 
			"sharing" => true
		]) ?>


		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>


	</div>
<? endif; ?>

</div>
