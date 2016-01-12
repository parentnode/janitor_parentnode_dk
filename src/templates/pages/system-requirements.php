<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("What you need ...");
?>
<div class="scene system i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">System Requirements</h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="modified_at">Date modified</dt>
			<dd class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author">Martin Kæstel Nielsen</dd>
			<dt class="publisher">Publisher</dt>
			<dd class="publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<ul class="publisher_info">
					<li class="name" itemprop="name">parentnode.dk</li>
					<li class="logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
						<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
						<span class="image_width" itemprop="width" content="720"></span>
						<span class="image_height" itemprop="height" content="405"></span>
					</li>
				</ul>
			</dd>
			<dt class="image_info">Image</dt>
			<dd class="image_info" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
				<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
				<span class="image_width" itemprop="width" content="720"></span>
				<span class="image_height" itemprop="height" content="405"></span>
			</dd>
		</dl>

		<div class="articlebody" itemprop="articleBody">
			<ul>
				<li>Apache 2.2+ (with virtualhosts and multiviews)</li>
				<li>PHP 5.3+ (with mysqlnd and short_open_tag = On)</li>
				<li>MySql 5+</li>
				<li>FFMpeg 2.1+</li>
				<li>Git 1.8+</li>
			</ul>

			<h3>Apache</h3>
			<p>
				Janitor needs MultiViews enabled.
			</p>
			<p>
				Janitor uses Apache, the most popular web server on the internet since 1996 - we don't care about 
				other webservers, though Janitor might be made to work there as well, as long as it provides MultiViews
				and environment variables available in $_SERVER.
			</p>

			<h3>PHP</h3>
			<p>
				PHP needs to be compiled with the dom, mysqlnd, mbstring, session and SimpleXML extensions which are all
				normally part of a default installation. 
			</p>
			<p>
				PHP needs to be compiled with the imagick extension to use the image conversion API.
			</p>
			<p>
				PHP needs to be allowed to use the &lt;? syntax - set short_open_tag = On in php.ini.
			</p>

			<h3>FFMpeg</h3>
			<p>
				FFMpeg is required to perform audio and video conversions. This needs to be installed as a
				regular command-line tool - NOT as a PHP extension.
			</p>

			<h3>Git</h3>
			<p>
				Janitor uses Git submodules for including itself in your project.
			</p>
		</div>
	</div>

</div>