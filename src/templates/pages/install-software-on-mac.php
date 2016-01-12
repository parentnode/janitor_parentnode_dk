<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("Howto ...");
?>
<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">Janitor server software on Mac</h1>

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
			<p>This is work in progress and part of milestone for v0.8 - Check the
				<a href="/pages/milestones">Milestones</a> for more information.
			</p>


			<p>
				This guides you through a complete setup, using the preferred
				Janitor development environment layout.
			</p>
			<p>
				If you already have a setup, you can skip or modify steps to 
				accommodate your existing setup.
			</p>

			<h2>Install on OSX, using Macports</h2>

			<h3>Get Macports</h3>
			<p>Intall Macports from <a href="http://macports.org">macports.org</a>.</p>

			<h3>Install software</h3>
			<p>Open new Terminal and paste these lines.</p>

			<code>sudo port install php53 +apache2 +mysql56-server +pear php53-apache2handler
sudo port install php53-mysql
sudo port install php53-http
sudo port install php53-iconv
sudo port install php53-openssl
sudo port install php53-mbstring
sudo port install php53-curl
sudo port install php53-zip
sudo port install php53-imagick
sudo port install ffmpeg +nonfree

sudo port load apache2

sudo port install mysql56-server

sudo chown -R mysql:mysql /opt/local/var/db/mysql56
sudo chown -R mysql:mysql /opt/local/var/run/mysql56
sudo chown -R mysql:mysql /opt/local/etc/mysql56
sudo chown -R mysql:mysql /opt/local/share/mysql56

sudo -u _mysql /opt/local/lib/mysql56/bin/mysql_install_db
sudo port load mysql56-server</code>

			<h3>Create shortcuts</h3>
			<p>
				To make this setup more easy for daily use we are creating some shortcuts.
				This is especially useful if more people are working together on your projects.
			</p>

			<p>Create "Sites" folder in your home folder - /Users/-your-username-/Sites.</p>

			<p>Create "apache" folder in your Sites folder - /Users/-your-username-/Sites/apache.</p>

			<p>
				create alias /srv/sites
				<br>
				copy conf files
			</p>	
		</div>
	</div>

</div>
