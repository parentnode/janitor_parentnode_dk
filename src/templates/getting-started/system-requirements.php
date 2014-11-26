<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">System Requirements</h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author">Martin Kæstel Nielsen</dd>
		</dl>

		<div class="articlebody" itemprop="articleBody">
			<ul>
				<li>Apache 2.2+ (with virtualhosts and multiviews)</li>
				<li>PHP 5.3+ (with mysqlnd and short_open_tag = On)</li>
				<li>MySql 5+</li>
				<li>ImageMagick</li>
				<li>FFMpeg 2.1+</li>
				<li>GIT</li>
			</ul>


			<p>
				Janitor uses Apache, the most popular web server on the internet since 1996 - we don't care about 
				other webservers, though Janitor might be made to work there as well.
			</p>

			<p>
				More details to come.
			</p>
		</div>
	</div>

</div>