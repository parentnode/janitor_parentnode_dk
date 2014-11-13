<div class="scene front i:front">
	<h1>Janitor server software on Windows</h1>
	<p>
		This guides you through a complete setup, using the preferred
		Janitor development environment layout on a Windows machine.
	</p>
	<p>Thuyet - please add explanation here - you can delete the mac stuff, just left it here for your reference</p>

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
