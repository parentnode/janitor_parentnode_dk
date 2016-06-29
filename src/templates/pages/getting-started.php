<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("Getting started with Janitor");
?>
<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="headline">Getting started with Janitor</h1>

		<ul class="info">
			<li class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></li>
			<li class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"></li>
			<li class="author" itemprop="author">Martin Kæstel Nielsen</li>
			<li class="main_entity share" itemprop="mainEntityOfPage" content="<?= SITE_URL."/getting-starting" ?>"></li>
			<li class="publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<ul class="publisher_info">
					<li class="name" itemprop="name">parentnode.dk</li>
					<li class="logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
						<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
						<span class="image_width" itemprop="width" content="720"></span>
						<span class="image_height" itemprop="height" content="405"></span>
					</li>
				</ul>
			</li>
			<li class="image_info" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
				<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
				<span class="image_width" itemprop="width" content="720"></span>
				<span class="image_height" itemprop="height" content="405"></span>
			</li>
		</ul>

		<div class="articlebody" itemprop="articleBody">
			<p>
				In essense Janitor is the result of stubbornly wanting to create a backend toolkit, which always prioritizes
				frontend over backend.
			</p>
			<p>
				The following articles will give you a thorough introduction to all the facets of Janitor.
			</p>

			<h2>Topics</h2>
			<ul>
				<li><a href="/pages/system-requirements">System Requirements</a></li>

				<li><a href="/pages/architecture">Architecture</a></li>
				<li><a href="/pages/folder-layout">Folder layout</a></li>

				<li><a href="/pages/create-a-new-project">Create a new Janitor project</a></li>
				<li><a href="/pages/install-software-on-mac">How to install the server software on Mac OS X</a></li>
				<!--li><a href="/pages/install-software-on-windows">How to install the server software on Windows</a></li-->
				<!--li><a href="/pages/set-up-an-existing-project">Set up an existing Janitor project</a></li-->

				<li><a href="/pages/milestones">Milestones / Roadmap</a></li>
				<li><a href="/pages/changelog">Changelog</a></li>

				<!--li><a href="/pages/javascript-and-css">JavaScript and CSS</a></li-->

			</ul>
		</div>
	</div>

</div>
