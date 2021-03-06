<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("Howto ...");
?>
<style>
	*{
		color: #666;
	}
	h1,h2,h3{
		color: #ff7c00;
	}
	.scene ul, .scene li{
		list-style: square !important;
		list-style-position: outside !important;
	}
	.scene ul{
		margin-left: 20px;
	}
	.scene li{
		display: list-item !important;
		margin-bottom: 10px;
		line-height: 1.5;
	}
	p{
		line-height: 1.5;
	}
	xmp{
		margin: 0;
	}
</style>

<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">Janitor server software on Windows</h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="modified_at">Date modified</dt>
			<dd class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author">Thuyet Le</dd>
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
			<p>
				This guides you through a complete setup, using the preferred Janitor development environment layout on a Windows machine.
			</p>
			<p>
				If you already have a setup, you can skip or modify steps to accommodate your existing setup.
			</p>



			<h3>1. Install Apache, PHP and MySQL</h3>
			<p>You can have Apache web server, PHP and MySQL installed separately. But the easiest way to get the job done is installing <strong><a href="http://www.wampserver.com/" target="_blank">WAMP Server</a></strong></p>

			<p>
				<strong>WampServer</strong> is a Windows web development environment. Double click on the downloaded file and just follow the instructions. Everything is automatic. The WampServer package is delivered whith the latest releases of Apache, MySQL and PHP.
			</p>



			<h3>2. Prepare directory structure</h3>
			<ul>
				<li>Create <strong>"Sites"</strong> folder anywhere on your hard drive - this is the folder that hosts your web projects.</li>
				<li>Create <strong>"apache"</strong> folder in the <strong>"Sites"</strong> folder above (<em>"Sites/apache"</em>).<br>
					This folder contains a global config file (<em>"apache.conf"</em>) for any Janitor-related projects hosted in <strong>"Sites"</strong> folder.<br>
					In this file we can use many "Include" directives to point to many project-specific config files ("httpd-vhosts.conf" - included in each project).
				</li>
				<li>Create <strong>"parentnode"</strong> folder in the <strong>"Sites"</strong> folder above (<em>"Sites/parentnode"</em>).<br>
					This folder contains core modules from parentnode.dk, so...
				</li>
				<li>Clone 2 core modules of parentnode.dk (Janitor, Manipulator) from github into <em>"Sites/parentnode"</em> folder.</li>
				<li>Clone our sample project (<em>sandbox</em>) from github into your local folder (recursive clone) (ex: <em>Sites/sandbox</em>).</li>
			</ul>



			<h3>3. Create symbolic link</h3>
			<p>To make the setup much easier for daily use, we are creating a symbolic links (aka "hard shortcut" - more detail about symbolic link can be found <a href="http://www.howtogeek.com/howto/16226/complete-guide-to-symbolic-links-symlinks-on-windows-or-linux/">here</a>). This is especially useful if more people are working together on your projects.</p>
			<p>Now we're creating a symbolic link <strong><em>"\srv\sites"</em></strong> - this is a "hard shortcut" points to our <strong>"Sites"</strong> folder created above.</p>
			<ul>
				<li>Go to the root of your hard drive (the drive that contains the "Sites" folder)</li>
				<li>Create a folder called <strong><em>"srv"</em></strong></li>
				<li>Use this command line to make a symbolic link points to "Sites" folder:</li>
			</ul>
			<code>mklink /J "\srv\sites" "\real\path\to\Sites"</code>



			<h3>4. Edit Apache config file (<em>httpd.conf</em>)</h3>
			<p>Change no.1: Use <em>Options MultiViews</em> as below</p>
			<code>
<xmp>
<Directory />
	Options FollowSymLinks MultiViews
	AllowOverride all
	Order deny,allow
	Allow from all
</Directory>
</xmp>
	</code>

			<p>Change no.2: Include global config file</p>
			<code>Include "/srv/sites/apache/apache.conf"</code>



			<h3>5. Edit PHP config file (<em>php.ini</em>)</h3>
			<p>Change <em>short_open_tag</em> value to <em>On</em></p>
			<code>short_open_tag = On </code>

			<p>The NameVirtualHost directive is a required directive if we want to configure name-based virtual hosts</p>
			<code>NameVirtualHost *:80</code>



			<h3>6. Add to windows host file (<em>etc/host</em>)</h3>
			<p><strong><em>Notes:</em></strong> <em>sandbox.local</em> is the value of the directive <em>ServerName</em> in the project-specific config file (<em>httpd-vhosts.conf</em>)</p>
			<code>127.0.0.1  sandbox.local</code>



			<h3>7. Installing Imagick</h3>
			<p>Download and install this file: <a href="http://ftp.sunet.se/pub/multimedia/graphics/ImageMagick/binaries/ImageMagick-6.7.7-5-Q16-windows-dll.exe" target="_blank">http://ftp.sunet.se/pub/multimedia/graphics/ImageMagick/binaries/ImageMagick-6.7.7-5-Q16-windows-dll.exe</a></p>

			
			
			
			<h3>8. Installing Imagick extension for PHP</h3>
			<ul>
				<li>Download this file: <a href="http://www.peewit.fr/imagick/releases/php_imagick-3.2.0RC1-5.5-ts-vc11-x86.zip" target="_blank">http://www.peewit.fr/imagick/releases/php_imagick-3.2.0RC1-5.5-ts-vc11-x86.zip</a></li>
				<li>Extract the file <strong>"php_imagick.dll"</strong> to php <strong>"ext"</strong> folder (ex: wamp\bin\php\php5.5.12\ext)</li>
				<li>Edit <strong>php.ini</strong> file and add new extension:<br/>
					<strong>extension=php_imagick.dll</strong>
				</li>
				<li>Restart WAMPP Server</li>
			</ul>

			
			
			<h3>9. Installing FFMpeg</h3>
			<ul>
				<li>Download "FFmpeg git-48efe9e Win32 Static" from this site: <a href="http://zeranoe1.rssing.com/chan-5973786/all_p23.html" target="_blank">http://zeranoe1.rssing.com/chan-5973786/all_p23.html</a></li>
				<li>Extract it into the folder <strong>"/srv"</strong> and rename it to <strong>"ffmpeg"</strong>. So we have <strong>"/srv/ffmpeg"</strong></li>
				<li>To check the FFMpeg version: Go to the directory <strong>"/srv/ffmpeg/bin"</strong> and excute this command: <strong>"ffmpeg -version"</strong></li>
			</ul>

			
			<h3>Sample file: <em>"/srv/sites/apache/apache.conf"</em></h3>
			<p></p>
			<code>
<xmp>
<VirtualHost *:80>
	DocumentRoot "/srv/sites"
	ServerName local
</VirtualHost>

Include "/srv/sites/sandbox/apache/httpd-vhosts.conf"
Include "/srv/sites/sandbox2/apache/httpd-vhosts.conf"
</xmp>
	</code>



			<h3>Sample file: <em>"/srv/sites/sandbox/apache/httpd-vhosts.conf"</em></h3>
			<p></p>
			<code>
<xmp>
<VirtualHost *:80>
	DocumentRoot "/srv/sites/sandbox/src/www"
	ServerName sandbox.local
	ServerAlias sandbox.proxy

	# live manipulator repo for dev
	Alias "/js/manipulator/src" "/srv/sites/parentnode/manipulator/src"

	<Directory "/srv/sites/sandbox/src/www">
		ErrorDocument 404 /404.php
	</Directory>

	Alias "/setup" "/srv/sites/parentnode/janitor/src/setup"
	<Directory "/srv/sites/parentnode/janitor/src/setup">
		Options MultiViews
		AcceptPathInfo On
	</Directory>

	# set custom log for individual log files
	CustomLog "logs/sandbox_access_log" combined

	# include path for php
	SetEnv "LOCAL_PATH" "/srv/sites/sandbox/src"
	SetEnv "FRAMEWORK_PATH" "/srv/sites/parentnode/janitor/src"

	# reference to backend interface
	Alias "/janitor/admin" "/srv/sites/parentnode/janitor/src/www"

	# setup janitor autoconversion
	Alias "/autoconversion" "/srv/sites/sandbox/submodules/janitor/src/autoconversion"
	Alias "/images" "/srv/sites/sandbox/src/library/public"
	Alias "/videos" "/srv/sites/sandbox/src/library/public"
	Alias "/audios" "/srv/sites/sandbox/src/library/public"
	<Directory "/srv/sites/sandbox/src/library/public">
		ErrorDocument 404 /autoconversion/index.php
	</Directory>

	# setup local css+js mergers
	Alias "/js/lib/build" "/srv/sites/sandbox/submodules/js-merger"
	Alias "/css/lib/build" "/srv/sites/sandbox/submodules/css-merger"
	Alias "/janitor/js/lib/build" "/srv/sites/sandbox/submodules/js-merger"
	Alias "/janitor/css/lib/build" "/srv/sites/sandbox/submodules/css-merger"
</VirtualHost>
</xmp>
</code>

		</div>
	</div>

</div>
