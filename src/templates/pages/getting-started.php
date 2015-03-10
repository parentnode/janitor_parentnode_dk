<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("Getting started with Janitor");
?>
<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">Getting started with Janitor</h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author">Martin Kæstel Nielsen</dd>
		</dl>

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
