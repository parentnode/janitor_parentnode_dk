<div class="scene front i:front">
	<h1>Set up Janitor project from scratch</h1>
	<p>
		A Janitor project should live in a GIT repository. Git is a distributed Version Control System and 
		its purpose is to track the development of source code over time. If you don’t know 
		much about Git, check out 
		<a href="http://en.wikipedia.org/wiki/Git_%28software%29" target="_blank">GIT on Wikipedia</a> 
		or on <a href="http://github.com" target="_blank">GITHub</a> where you can host opensource 
		projects for free. We like opensource.
	</p>


	<h2>1. Create new GIT repository</h2>
	<p>
		The first step is to decide where you would like your project to live. Either you create a “remote repository” 
		that resides on a remote server, shared among multiple team members or a local repository that resides 
		on your local machine, if you are the only one who needs access.
	</p>


	<h3>Remote GIT repository</h3>
	<h4>Create your new repository at your GIT provider</h4>
	<p>
		Here's and article on how to do that on <a href="https://help.github.com/articles/create-a-repo">github</a>.
		There are plenty of other options out there as well, just 
		<a href="https://www.google.com?q=git%20hosting" target="_blonk">ask google</a>.
	</p>

	<p>or</p>

	<h3>Local GIT repository</h3>
	<p>
		The combined history of your source code lives in a .git folder. This is not where you work, only where GIT works.
		Decide the path (#GIT_REPOS_PATH#) to where you would like the local GIT repository to be hosted. This could 
		be in your Dropbox or some other location which is backed up automatically. Backup is nice.
	</p>
	<h4>Create your new repository locally</h4>
	<p>Run this command in Terminal, replacing #GIT_REPOS_PATH# with the path you decided on.</p>
	<code>git init --bare #GIT_REPOS_PATH#.git</code>



	<h2>2. Clone working copy</h2>
	<p>
		Then we clone the GIT repository to where we are going to work on it. We call it our woking copy.
	</p>
	<code>git clone #GIT_REPOS_PATH#.git #WORKING_COPY_PATH#</code>



	<h3>Set file permissions</h3>
	<p>For the setup script to access to your Working copy we need to adjust the file permissions first.</p>
	<code>sudo chmod -R 777 #WORKING_COPY_PATH#</code>


	<h2>3. Clone submodules</h2>
	<p>
		Submodules is a clever thing that comes with GIT. Submodules allow you to keep a GIT repository 
		as a subdirectory of another GIT repository. This lets you clone another repository into your 
		project and keep your commits separate. This is how we integrate Janitor in projects.
	</p>
	<p>In terminal navigate to your #WORKING_COPY_PATH# and copy/past the following lines:</p>

	<code>git submodule add https://github.com/parentnode/js-merger.git submodules/js-merger
git commit -m 'added js-merger submodule'\n
git push


git submodule add https://github.com/parentnode/css-merger.git submodules/css-merger
git commit -m 'added css-merger submodule'
git push


git submodule add https://github.com/parentnode/janitor.git submodules/janitor
git commit -m 'added janitor submodule'
git push</code>


	<h2>4. Add Apache configuration</h2>
	<p>
		Next we need to configure our web server. Janitor uses Apache, the most popular web server on the 
		internet since 1996. In your Working copy, create a new folder called “apache”. Copy and personalise 
		the code below into a new file called “httpd-vhosts.conf” and save it into #WORKING_COPY_PATH#/apache.
	</p>

	<code>&lt;VirtualHost *:80&gt;
DocumentRoot &quot;#WORKING_COPY_PATH#/submodules/janitor/src&quot;
ServerName #DOMAIN_NAME#

Alias "/setup" #WORKING_COPY_PATH#/submodules/janitor/src/setup"
Alias "/janitor/admin" #WORKING_COPY_PATH#/submodules/janitor/src/www"
&lt;/VirtualHost&gt;</code>

	<p>Finally you need to configure your main Apache file by adding the line below:</p>
	<code>Include "#WORKING_COPY_PATH#/apache/httpd-vhosts.conf"</code>

	<!--p>
		Due to the flexibility of apache towards your workflow, the apache "conf/httpd.conf" file might 
		be at a different place - but most likely it’s located here “/opt/local/apache2/conf/httpd.conf" 
		or here "/opt/local/apache2/conf/extra/httpd-vhosts.conf".
	</p-->


	<h2>5. Update hosts file</h2>
	<p>
		If you are setting up your Janitor project locally, you probably was to add a the #DOMAIN_NAME# to
		your hosts file. The exact location of the hosts file depends on your operating system, but
		it is typically located in /etc/hosts on Unix/Linux and in \Windows\System32\drivers\etc\hosts
		on Windows.
	</p>
	<p>Add the follwing code to your hosts file, replacing #DOMAIN_NAME# with your new project domain name.</p>
	<div class="example">
		<code>127.0.0.1	#DOMAIN_NAME#
fe80::1%lo0	#DOMAIN_NAME#</code>
	</div>


	<h2>6. Restart Apache</h2>
	<p>To confirm the changes made above we need to restart apache.</p>
	<code>apache restart</code>

	<h2>7. Run setup script</h2>
	<p>
		Almost done! We’ve laid the foundation by creating a new GIT repository and by adding the necessary 
		server files. Now we’re ready to actually set up Janitor. In your browser you should now be able to 
		access the domain and follow the instructions.
	</p>
	<code>http://#DOMAIN_NAME#/setup</code>


</div>
