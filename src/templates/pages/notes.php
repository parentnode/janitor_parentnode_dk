apache - local development apache configuration (requires /srv/sites alias pointing to your sites folder)

src - specific project files
	
	class - itemtype classes and system overwrite classes
	config - project base configuration
	library - media folder (Janitor uploads content here)
	templates - templates (views)
	www - controllers, img, js and css (web root)

submodules - project submodules (git submodules)

	janitor - the janitor submodule
	js-merger - merging tool for JavaScript
	css-merger - merging tool for CSS
	



Ignored files (.gitignore)

	.DS_Store
	src/library/*
	src/config/connect_*.php


Ignore file mode changes

	git config core.filemode false



Janitor inheritance

	when including a file or template the Janitor setup 
	will first look in your src folder. If file is not 
	found it will then look in the Janitor submodule.
	
	Because of this you can overwrite any Janitor file
	(expect a very few core files)



INSTALL SETUP

macports

	sudo port install php53 +apache2 +mysql56-server +pear php53-apache2handler
	sudo port install php53-mysql
	sudo port install php53-http
	sudo port install php53-iconv
	sudo port install php53-openssl
	sudo port install php53-mbstring
	sudo port install php53-curl
	sudo port install php53-zip
	sudo port install php53-imagick

-

	sudo port install ffmpeg +nonfree


	sudo port load apache2


	sudo chown -R mysql:mysql /opt/local/var/db/mysql56
	sudo chown -R mysql:mysql /opt/local/var/run/mysql56
	sudo chown -R mysql:mysql /opt/local/etc/mysql56
	sudo chown -R mysql:mysql /opt/local/share/mysql56

	sudo port install mysql56-server
	sudo -u _mysql /opt/local/lib/mysql56/bin/mysql_install_db
	sudo port load mysql56-server


Copy conf files

	/opt/local/apache2/conf/httpd.conf
	/opt/local/apache2/conf/extra/httpd-vhosts.conf
	/opt/local/etc/php53/php.ini



Restart

	sudo /opt/local/lib/mysql56/bin/mysqladmin -u root password 'root'



Add to .profile or .bash_profile

	alias apache="sudo /opt/local/apache2/bin/apachectl"
	alias mysql="sudo /opt/local/share/mysql56/mysql.server"

	