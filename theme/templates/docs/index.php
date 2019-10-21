<?php
global $action;
$IC = new Items();


$page_item = $IC->getItem(array("tags" => "page:documentation", "extend" => array("user" => true, "tags" => true, "mediae" => true)));
?>
<div class="scene docsindex i:docsindex">

<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMediae($page_item); ?>
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


		<?= $HTML->articleInfo($page_item, "/docs", [
			"media" => $media, 
			"sharing" => true
		]) ?>


		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>


	</div>
<? endif; ?>


	<div class="search"></div>

	<div class="files" id="library_files">

		<h2>Index</h2>
		
		<h3>Item classes</h3>
		<ul class="library item">
			<li>
				<h3><a href="/docs/class-itemtype">Itemtype</a></h3>
				<p>Creating and manipulating itemtypes</p>
			</li>
			<li>
				<h3><a href="/docs/class-items">Items</a></h3>
				<p>Querying items and item data</p>
			</li>
		</ul>

		<h3>Shop classes</h3>
		<ul class="library shop">
			<li>
				<h3><a href="/docs/class-shop">Shop</a></h3>
				<p>Creating, querying and manipulating orders and cart items data.</p>
			</li>
			<li>
				<h3><a href="/docs/class-supershop">SuperShop</a></h3>
				<p>Creating, querying and manipulating orders and cart items data.</p>
			</li>
		</ul>

		<h3>Subscription classes</h3>
		<ul class="library subscription">
			<li>
				<h3><a href="/docs/class-subscription">Subscription</a></h3>
				<p>Creating, querying and manipulating subscriptions.</p>
			</li>
			<li>
				<h3><a href="/docs/class-supersubscription">SuperSubscription</a></h3>
				<p>Creating, querying and manipulating subscriptions.</p>
			</li>
		</ul>

		<h3>System classes</h3>
		<ul class="library system">
			<li>
				<h3><a href="/docs/class-page">Page</a></h3>
				<p>Core request and response structure</p>
			</li>
			<li>
				<h3><a href="/docs/class-html">HTML</a></h3>
				<p>HTML class</p>
			</li>
			<li>
				<h3><a href="/docs/class-html-janitor">Janitor HTML (JML)</a></h3>
				<p>Janitor style HTML class</p>
			</li>
			<li>
				<h3><a href="/docs/class-model">Model</a></h3>
				<p>Core janitor model class</p>
			</li>
			<li>
				<h3><a href="/docs/class-output">Output</a></h3>
				<p>Output helper class</p>
			</li>
			<li>
				<h3><a href="/docs/class-session">Session</a></h3>
				<p>Session helper class</p>
			</li>
			<li>
				<h3><a href="/docs/class-message">Message</a></h3>
				<p>Message helper class</p>
			</li>
		</ul>

		<h3>User classes</h3>
		<ul class="library user">
			
			<li>
				<h3><a href="/docs/class-user">Users</a></h3>
				<p>Plain user creation and manipulation</p>
			</li>
			<li>
				<h3><a href="/docs/class-superuser">Superusers</a></h3>
				<p>Getting, creating and manipulating users</p>
			</li>
		</ul>
		
		<h3>Member classes</h3>
		<ul class="library member">
			
			<li>
				<h3><a href="/docs/class-member">Members</a></h3>
				<p>Plain member creation and manipulation</p>
			</li>
			<li>
				<h3><a href="/docs/class-supermember">Supermembers</a></h3>
				<p>Getting, creating and manipulating members</p>
			</li>
		</ul>

		<h3>Helper classes</h3>
		<ul class="library helper">
			
			<!--li>
				<h3><a href="/docs/class-image">Image</a></h3>
				<p>Image class</p>
			</li>
			<li>
				<h3><a href="/docs/class-video">Video</a></h3>
				<p>Video class</p>
			</li>
			<li>
				<h3><a href="/docs/class-audio">Audio</a></h3>
				<p>Audio class</p>
			</li-->
			<li>
				<h3><a href="/docs/class-dom">DOM</a></h3>
				<p>DOM for Janitor</p>
			</li>
			<li>
				<h3><a href="/docs/class-zipper">Zipper</a></h3>
				<p>Zip helper class</p>
			</li>
		</ul>

		<h3>API</h3>
		<ul class="library api">
			<!--li>
				<h3><a href="/docs/api-autoconversion">Media auto-conversion (API)</a></h3>
				<p>Media scaling and format conversion (Image, Video, Audio)</p>
			</li-->
		</ul>

		<h3>Standalone functions</h3>
		<ul class="library functions">
			<li>
				<h3><a href="/docs/functions">Global functions</a></h3>
				<p>General purpose functions, globally available</p>
			</li>
		</ul>

	</div>

</div>
