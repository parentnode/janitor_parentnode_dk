<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("Architecture of Janitor");
?>
<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">Architecture of Janitor</h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author">Martin Kæstel Nielsen</dd>
		</dl>

		<div class="articlebody" itemprop="articleBody">

			<p>Part of milestone for v0.8 - Check the
				<a href="/pages/milestones">Milestones</a> for more information.
			</p>

		</div>
	</div>

</div>
