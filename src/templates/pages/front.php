<div class="scene front i:front">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">the Janitor</h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author">Martin Kæstel Nielsen</dd>
		</dl>

		<div class="articlebody" itemprop="articleBody">
			<h1>the Janitor</h1>
			<p>Brief introduction</p>


			<h2>Getting started</h2>
			<p><a href="/getting-started">Getting started</a> - install, setup, concept</p>

			<h2>Documentation</h2>
			<p><a href="/docs">Documentation</a></p>
		</div>
	</div>

</div>
