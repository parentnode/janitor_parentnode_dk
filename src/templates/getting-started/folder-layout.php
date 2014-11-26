<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">The folder layout of Janitor</h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author">Martin Kæstel Nielsen</dd>
		</dl>

		<div class="articlebody" itemprop="articleBody">
			<ul>
				<li><h3>apache - local development apache configuration</h3></li>
				<li>
					<h3>src - specific project files</h3>
					<ul>
						<li>class - itemtype classes and system overwrite classes</li>
						<li>config - project base configuration</li>
						<li>library - media folder (Janitor uploads content here)</li>
						<li>templates - templates (views)</li>
						<li>www - controllers, img, js and css (web root)</li>
					</ul>
				</li>
				<li>
					<h3>submodules - project submodules (git submodules)</h3>
					<ul>
						<li>janitor - the janitor submodule</li>
						<li>js-merger - merging tool for JavaScript</li>
						<li>css-merger - merging tool for CSS</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>

</div>