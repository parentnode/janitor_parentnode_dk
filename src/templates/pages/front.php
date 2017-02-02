<?php

global $action;
$IC = new Items();


$page_item = $IC->getItem(array("tags" => "page:front", "extend" => array("user" => true, "tags" => true, "mediae" => true)));

?>
<div class="scene front i:front">

<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMedia($page_item); ?>
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

	<div class="usedby">
		<h2>Selected clients</h2>
		<ul>
			<li class="oeo" title="oeo.dk">oeo.dk</li>
			<li class="landskabsarkitekter" title="Danske Landskabsarkitekter">Danske Landskabsarkitekter</li>
			<li class="metro" title="Copenhagen Metro">Copenhagen Metro</li>
			<li class="urbangreen" title="Urban Green">Urban Green</li>
			<li class="distortion" title="Distortion">Distortion</li>
		</ul>
	</div>

</div>
