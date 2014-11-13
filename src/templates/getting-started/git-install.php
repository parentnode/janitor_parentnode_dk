<div class="scene front i:front">
	<h1>Janitor project install</h1>

	<p>
		Janitor should live in a GIT repository. Git is a distributed Version Control System and 
		its purpose is to track the development of source code through time. If you don’t know 
		much about Git, check out 
		<a href="http://en.wikipedia.org/wiki/Git_%28software%29" target="_blank">GIT on Wikipedia</a> 
		or on <a href="http://github.com" target="_blank">GITHub</a> where you can host opensource 
		projects for free. We like opensource.
	</p>


	<h2>1. Create new GIT repository</h2>

	<p>
		The first step is to decide where you would like your project to live. Either you create a “remote repository” 
		that resides on a remote server that is shared among multiple team members or a local repository that resides 
		on your local machine if you are the only one who needs access.
	</p>

	<h3>Remote GIT repository</h3>
	<h4>1. Create your new repository at your GIT provider.</h4>
	<p>
		Here's and article on how to do that on <a href="https://help.github.com/articles/create-a-repo">github</a>.
	</p>

	<h4>2. Clone your new repository to your local machine.</h4>


	<p>or</p>


	<h3>Local GIT repository</h3>
	
	<h4>1. Create local GIT repository</h4>
	<p>
		The combined history of your source code lives in a .git folder. This is not where you work, only where GIT works.
		Decide the path (#PATH_FOR_GIT_REPOS#) to where you would like the local GIT repository to be hosted. This could 
		be in your Dropbox or some other location which is backed up automatically. Backup is nice.
	</p>
	<p>The run this command in Terminal, replacing #PATH_FOR_GIT_REPOS# with the path you decided on.</p>
	<code>git init --bare #PATH_FOR_GIT_REPOS#.git</code>

	<h4>2. Clone working copy</h4>
	<p>
		Then we clone the GIT repository to where we are going to work on it. We call it our woking copy. 
		(In my case the working copy need to be in the sites folder). #PATH_FOR_WORKING_COPY#
		- your project folder so to speak
	</p>
	<code>git clone #PATH_FOR_GIT_REPOS#.git #PATH_FOR_WORKING_COPY#</code>


	<h2>2. Clone submodules</h2>
	<p>
		Submodules is a clever thing that comes with GIT. Submodules allow you to keep a GIT repository 
		as a subdirectory of another GIT repository. This lets you clone another repository into your 
		project and keep your commits separate.
	</p>
	<p>In terminal navigate to your #PATH_FOR_WORKING_COPY# and copy/past the following lines:</p>

	<code>git submodule add https://github.com/parentnode/js-merger.git submodules/js-merger
git commit -m 'added js-merger submodule'\n
git push


git submodule add https://github.com/parentnode/css-merger.git submodules/css-merger
git commit -m 'added css-merger submodule'
git push


git submodule add https://github.com/parentnode/janitor.git submodules/janitor
git commit -m 'added janitor submodule'
git push</code>


	<h2>3. Add Apache configuration</h2>
	<p>
		Next we need to configure our web server. Janitor uses Apache, the most popular web server on the 
		internet since 1996. In your “working copy” create a new folder called “apache”. Copy and personalise 
		the code below into a new file called “httpd-vhosts.conf” and save it into your newly created apache folder.
	</p>
# local test configuration
<VirtualHost *:80>
	DocumentRoot "/srv/sites/parentnode/janitor_test/submodules/janitor/src"
	ServerName janitor_test.local

	Alias "/setup" "/srv/sites/parentnode/janitor_test/submodules/janitor/src/setup"
	Alias "/janitor/admin" "/srv/sites/parentnode/janitor_test/submodules/janitor/src/www"
</VirtualHost>

	<code>&lt;VirtualHost *:80&gt;
DocumentRoot &quot;#ABSOLUTE_PATH_TO_YOUR_PROJECT_FOLDER#/submodules/janitor/src&quot;
ServerName #STATE_YOUR_DOMAIN_NAME_HERE#

Alias "/setup" "#ABSOLUTE_PATH_TO_YOUR_PROJECT_FOLDER#/submodules/janitor/src/setup"
Alias "/janitor/admin" "#ABSOLUTE_PATH_TO_YOUR_PROJECT_FOLDER#/submodules/janitor/src/www"
&lt;/VirtualHost&gt;</code>


	<p>In addition we need to configure our main apache file by adding the line below:</p>
	<code>Include "#PATH_TO_WORKING_COPY#/apache/httpd-vhosts.conf"</code>


	<p>
		Due to the flexibility of apache towards your workflow, the apache "conf/httpd.conf" file might 
		be at a different place - but most likely it’s located here “/opt/local/apache2/conf/httpd.conf" 
		or here "/opt/local/apache2/conf/extra/httpd-vhosts.conf".
	</p>


	<p><a href="https://www.google.com/search?q=etc%2Fhosts#q=Apache+configuration+httpd.conf">Google some more info</a></p>
	<p></p>


	<h2>4. Update hosts file</h2>
	<p>In a next step we need to update our host file. The exact location of the Hosts file depends on your operating system. (fx. /etc/hosts on Unix/Linux)</p>
	<div class="example">
		<code>127.0.0.1	projectName.local
fe80::1%lo0	projectName.local</code>
	</div>
	<p><a href="https://www.google.com/search?q=etc%2Fhosts&oq=etc%2Fhosts">Google some more info</a></p>


	<h2>5. Set file permissions</h2>
	<p>To be able to have access to your “working copy” folder we need to adjust the file permissions first.</p>
	<code>sudo chmod -R 777 #ABSOLUTE_PATH_TO_YOUR_PROJECT_FOLDER#</code>

	<h2>6. Restart Apache</h2>
	<p>To confirm the changes made above we need to restart apache.</p>
	<code>apache restart</code>

	<h2>7. Run setup script</h2>
	<p>Almost done! We’ve laid the foundation by creating a new GIT repository and by adding the necessary server files. Now we’re ready to actually setup Janitor. In your browser copy & personalise the link below and follow the instructions.</p>

	<code>http://projectName.localhost/setup</code>


</div>
