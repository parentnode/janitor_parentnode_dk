<div class="scene front i:front">
	<h1>Janitor project install</h1>
	<p>
		A Janitor project should live in a GIT repository. If you don't know about GIT yet, check out 
		<a href="http://en.wikipedia.org/wiki/Git_%28software%29" target="_blank">GIT on Wikipedia</a> and 
		<a href="http://github.com" target="_blank">GITHub</a>.
	</p>


	<h2>1. Create new GIT repository</h2>
	<p>
		You can either create a remote GIT repository at your favorite GIT hosting provider or create a local 
		repository for your project.
	</p>

	<h3>Remote GIT repository</h3>
	<h4>1. Create your new repository at your GIT provider.</h4>
	<p>Here's and article on how to do that on <a href="https://help.github.com/articles/create-a-repo">github</a>.</p>

	<h4>2. Clone your new repository to your local machine.</h4>


	<p>or</p>


	<h3>Local GIT repository</h3>
	
	<h4>1. Create local GIT repository</h4>
	<p>#PATH_FOR_GIT_REPOS# is the path to your repository. This is not the same as the project directory. If you don't know where to put your repository, you could always just add it to the desktop or your dropbox.</p>
	<code>git init --bare #PATH_FOR_GIT_REPOS#.git</code>

	<h4>2. Clone working copy</h4>
	<p>#PATH_FOR_WORKING_COPY# is the path to the project. We will now clone the repository we just created into the project folder.</p>

	<code>git clone #PATH_FOR_GIT_REPOS#.git #PATH_FOR_WORKING_COPY#</code>


	<h2>2. Clone submodules</h2>
	<p>
		Submodules is a clever thing that comes with git. A submodule in a git repository is like a sub-directory 
		which is a separate git repository in its own. So, by cloning submodules into our new Git repository is 
		half the job to het Janitor running.
	</p>
	<p>
		Open terminal. Navigate to the local project folder and run the following lines:
	</p>

	<code>git submodule add https://github.com/parentnode/js-merger.git submodules/js-merger
git commit -m 'added js-merger submodule'
git push


git submodule add https://github.com/parentnode/css-merger.git submodules/css-merger
git commit -m 'added css-merger submodule'
git push


git submodule add https://github.com/parentnode/janitor.git submodules/janitor
git commit -m 'added janitor submodule'
git push</code>


	<h2>3. Add Apache configuration</h2>
	<p>Add "apache" folder to your project and copy content below to new file httpd-vhosts.conf</p>
	<code>
&lt;VirtualHost *:80&gt;
	DocumentRoot &quot;#ABSOLUTE_PATH_TO_YOUR_PROJECT_FOLDER#/submodules/janitor/src/www&quot;
	ServerName #STATE_YOUR_DOMAIN_NAME_HERE#
&lt;/VirtualHost&gt;
</code>

	<p>Add this file to your Apache configuration by adding something like this:</p>
	<code>Include "#PATH_TO_WORKING_COPY#/apache/httpd-vhosts.conf"</code>


	<p>Your Apache configuration file is most likely to be here <br>
	"/opt/local/apache2/conf/httpd.conf"<br>
	or here<br>
	"/opt/local/apache2/conf/extra/httpd-vhosts.conf".</p>


	<p><a href="https://www.google.com/search?q=etc%2Fhosts#q=Apache+configuration+httpd.conf">Google some more info</a></p>
	<p></p>


	<h2>4. Update hosts file</h2>
	<p>Your Hosts file is probably located here "/etc/hosts". Open it in an editor and add:</p>
	<div class="example">
		<code>
127.0.0.1	projectName.local
fe80::1%lo0	projectName.local
		</code>
	</div>
	<p><a href="https://www.google.com/search?q=etc%2Fhosts&oq=etc%2Fhosts">Google some more info</a></p>


	<h2>5. Set file permissions</h2>
	<p>Copy into your terminal</p>
	<code>
sudo chmod -R 777 #ABSOLUTE_PATH_TO_YOUR_PROJECT_FOLDER#
</code>

	<h2>6. Restart Apache</h2>
	<p>Open terminal and enter "apache restart". </p>
	

	<h2>7. Run setup script</h2>
	<p>Open your browser and go to projectName.localhost/setup. Follow the instructions.</br>
	Add DB
	Password
	</p>

	
	<p class="todo">Create tutorial for creating GIT repos and cloning submodules</p>

	

</div>
