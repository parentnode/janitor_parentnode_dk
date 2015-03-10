<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">JavaScript and CSS in Janitor</h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author">Martin Kæstel Nielsen</dd>
		</dl>

		<div class="articlebody" itemprop="articleBody">


			Do not modify the CSS or JS in the Sandbox or any of the parentnode projects, unless discussing it with the team first. You added global CSS to sandbox, which will affect ALL pages - also ones it shouldn't. There is another way to do that, which we will get back to. I removed the additions you made to s-content-desktop.css.

			Do not modify the CSS or JS in the root of the CSS or JS folder (in any project). These files are the result of a CSS and JS merging for production. Instead run the site as "url?dev=1"
			Modifications to CSS and JS must ALWAYS be done in the css/lib and js/lib.

			NEVER modify the CSS or JS in the Janitor Core. It is a complex inheritance system - it requires a high level of CSS understanding to maintain.

			We will go through how the CSS and JS setup works - very soon! Until then, just accept how things look.
		</div>
	</div>

</div>