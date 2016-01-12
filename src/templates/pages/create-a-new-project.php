<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("Howto ...");
?>
<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">Create a new Janitor project from scratch</h1>

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
			<p>
				This is <strong>not</strong> a guide for 
				<a href="/pages/set-up-an-existing-project">setting up an existing Janitor project</a>.
			</p>

			<ul class="toc i:toc"></ul>

			<h2>Introduction</h2>
			<p>
				This guide is a detailed tour through the entire process of creating up a full Janitor project.
				That includes creating a Git Repository, how to Clone your project and include Janitor, as well as js-merger 
				and css-merger, the two tools used for merging 
				<a href="http://detector.parentnode.dk" target="_blank">Segment</a>-based JavaScript and CSS. 
				Then setup of Apache configuration and hosts file. You can find the 
				<a href="/pages/create-a-new-project-quickly">short version here</a>.
			</p>

			<p>
				You might want to read the 
				<a href="/pages/system-requirements">System Requirements for Janitor</a> 
				before you continue.
			</p>

			<p>
				A Janitor project lives in a Git Repository. Git is a Distributed Version Control System and 
				its primary purpose is to track the development of source code over time. If you don’t know 
				much about Git, check out 
				<a href="http://en.wikipedia.org/wiki/Git_%28software%29" target="_blank">Git on Wikipedia</a> 
				or <a href="http://github.com" target="_blank">GitHub</a> where you can host opensource 
				projects for free. We like opensource.
			</p>
			<p>
				If you are new to Git you should read the following carefully - Though Git is beautifully simple, 
				there are some tricky bits in understanding the difference between a Git Repository and a Working Directory.
			</p>
			<p>Enough said, let's get started.</p>


			<h2>1. Create new Git Repository</h2>
			<p>
				First step is to decide where your project repository should live. Either you create a 
				<strong>Remote Repository (A)</strong> which is hosted on a server somewhere out there (preferred for teams and sharing), 
				or a <strong>Local Repository (B)</strong> located on your local machine (fine, if you are the only one who needs access).
			</p>

			<p>
				Make up your mind, and move on.
			</p>


			<h3>A: Remote Git Repository</h3>
			<p>
				Good choice. This is easy.
			</p>
			<h4>Create your new Repository at your Git Hosting provider.</h4>
			<p>
				Here's and article on how to do that on <a href="https://help.github.com/articles/create-a-repo">GitHub</a>.
				There are plenty of other options out there as well, just 
				<a href="https://www.google.com?q=git%20hosting" target="_blonk">ask Google</a>.
			</p>

			<p><strong>or</strong></p>

			<h3>B: Local Git Repository</h3>
			<p>
				Ok, we have experienced the need to explain a bit more in this case :)
			</p>
			<p>
				The combined history of your source code lives in a .git folder. This is <strong>not</strong> where you work, 
				only where Git works. The Repository could be placed in your Dropbox or some other location with automatic 
				backup. Backup is nice. Version control is pointless if you loose your Repository and your Working Directory
				at the same time.
			</p>
			<p>
				Decide the location of your new <strong>Git Repository</strong>, 
				and we'll refer to that as the _REPOSITORY_PATH_. 
			</p>

			<h4>Create your new repository locally</h4>
			<p>
				Run this command in Terminal/CMD, replacing _REPOSITORY_PATH_ with the path you decided on.
			</p>
			<code>git init --bare _REPOSITORY_PATH_.git</code>
			<p>
				In case you are in doubt, it could look something like this:
			</p>
			<code>git init --bare /Users/mkn/Dropbox/my_first_repos.git</code>

			<p>Congratulations! You made it through the first step.</p>


			<h2>2. Clone to Woking Directory</h2>
			<p>
				The second step is to clone a working copy from the Git Repository, to where you are going to work on it. 
				This location is called the <strong>Woking Directory</strong>.
			</p>
			<p>
				If you have chosen to host your repository on GitHub you might want to use the GitHub App to clone your new repository - or you may do it manually as described below.
			</p>

			<h3>Manual cloning</h3>
			<p>
				Decide the location of your Woking Directory, and we'll refer to that as the _WOKING_DIRECTORY_PATH_. 
			</p>
			<p>
				In Terminal/CMD:
			</p>
			<code>git clone _REPOSITORY_PATH_.git _WOKING_DIRECTORY_PATH_</code>
			<p>
				In case you are in doubt, it could look something like this:
			</p>
			<code>git clone /Users/mkn/Dropbox/my_first_repos.git /Users/mkn/Sites/my_first_working_directory</code>
			<p>
				Or:
			</p>
			<code>git clone https://github.com/parentnode/my_first_repos.git /Users/mkn/Sites/my_first_working_directory</code>


			<h2>3. Clone Git Submodules</h2>
			<p>
				Submodules is a clever thing that comes with Git. Submodules allow you to include external 
				Git Repositories, Like Janitor, in your own Git Repository. You get the benefit of simultaneous
				inclusion and separation and an easy way to update the external Git Repositories later.
				This is how we integrate Janitor in projects.
			</p>
			<p>In terminal:</p>
			<code>cd _WOKING_DIRECTORY_PATH_</code>

			<p>Like:</p>
			<code>cd /Users/mkn/Sites/my_first_working_directory</code>

			<p>And copy/paste the following lines:</p>

			<code>git submodule add https://github.com/parentnode/janitor.git submodules/janitor
git commit -m 'added janitor submodule'
git push

git submodule add https://github.com/parentnode/js-merger.git submodules/js-merger
git commit -m 'added js-merger submodule'
git push

git submodule add https://github.com/parentnode/css-merger.git submodules/css-merger
git commit -m 'added css-merger submodule'
git push
</code>

			<p>
				In your _WOKING_DIRECTORY_PATH_, you'll now see a new folder named <em>submodules</em>. 
				You have cloned everything you need to run Janitor - Now it is time to tell Apache about it.
			</p>


			<h2>4. Add configuration for Apache</h2>
			<p>
				Next we need to include a configuration file for Apache, to allow you to access your Janitor project
				in your browser.
			</p>
			<p>
				In your _WOKING_DIRECTORY_PATH_, create a new folder named <strong>apache</strong> and in it, a new file
				named <strong>httpd-vhosts.conf</strong>.
			</p>
			<p>
				At this point you'll need to decide which domain you want to use to access this Janitor project.
				On a local system, we recommend something like <strong>fjp.local</strong>, for your first Janitor project.
			</p>
			<p>
				Copy the code below, replace _WOKING_DIRECTORY_PATH_ with your decided path and _DOMAIN_NAME_ with
				your chosen domain, and paste it into the file:
			</p>

			<code>&lt;VirtualHost *:80&gt;
	DocumentRoot "_WOKING_DIRECTORY_PATH_/submodules/janitor/src"
	ServerName _DOMAIN_NAME_

	Alias "/setup" "_WOKING_DIRECTORY_PATH_/submodules/janitor/src/setup"
	Alias "/janitor/admin" "_WOKING_DIRECTORY_PATH_/submodules/janitor/src/www"
&lt;/VirtualHost&gt;</code>

			<p>It should look something like this:</p>
			<code>&lt;VirtualHost *:80&gt;
	DocumentRoot "/Users/mkn/Sites/my_first_working_directory/submodules/janitor/src"
	ServerName fjp.local

	Alias "/setup" "/Users/mkn/Sites/my_first_working_directory/submodules/janitor/src/setup"
	Alias "/janitor/admin" "/Users/mkn/Sites/my_first_working_directory/submodules/janitor/src/www"
&lt;/VirtualHost&gt;</code>

			<p>
				Then you need to tell Apache to include your new configuration file. For that you'll need
				to know where your main Apache configuration is located. Due to the flexibility and
				multitude of supported systems, it is kind of hard to guess where it might be located on
				your computer - but the file you are looking for is likely called something like
				<strong>httpd-vhosts.conf</strong>, and could be located in 
				<strong>/etc/apache2/extra/</strong> or <strong>/opt/local/apache2/conf/extra/</strong>.
				If you can't find it, 
				<a href="https://www.google.com?q=where%20is%20the%20apache%20configuration%20located%20on" target="_blonk">ask Google</a>
				where to find it on your system.
			</p>
		
			<p>Add the line below to the end of your main Apache configuration:</p>
			<code>Include "_WOKING_DIRECTORY_PATH_/apache/httpd-vhosts.conf"</code>

			<p>Yeah, that would turn into a variation of:</p>
			<code>Include "/Users/mkn/Sites/my_first_working_directory/apache/httpd-vhosts.conf"</code>

			<p>
				Then it is time to restart Apache to apply the new configuration.
			</p>
			<p>
				In Terminal/CMD you should be able to run:
			</p>
			<code>service apache2 restart</code>
			<p>or</p>
			<code>apachectl restart</code>

			<p>
				Again this depends on your system. If you can't make it work, 
				<a href="https://www.google.com?q=restart%20apache%20on" target="_blonk">ask Google</a>
				how to restart Apache on your system.
			</p>

			<p>Pew, you made it this far. It is almost over.</p>


			<h2>5. Update hosts file</h2>
			<p>
				If you are setting up your Janitor project locally, you want to add a the _DOMAIN_NAME_ to
				your hosts file, to make your system redirect this domain to your local webserver. 
		
				The location of the hosts file depends on your operating system, but
				it is here <strong>/etc/hosts</strong> on Mac/Linux and here <strong>C:\Windows\System32\drivers\etc\hosts</strong>
				on Windows.
			</p>
			<p>Add the follwing lines to your hosts file, replacing _DOMAIN_NAME_ with your new project domain name.</p>

			<code>127.0.0.1	_DOMAIN_NAME_
fe80::1%lo0	_DOMAIN_NAME_</code>
			<p>Very similar or even identical to:</p>
			<code>127.0.0.1	fjp.local
fe80::1%lo0	fjp.local</code>

			<p>
				Holy macaroni, you are done with the hard part. It is time to access your project
				in your browser and start the setup process.
			</p>
			<code>http://_DOMAIN_NAME_/setup</code>

			<p>Or maybe even:</p>
			<code>http://fjp.local/setup</code>

			<p>Enjoy!</p>
		</div>
	</div>

</div>
