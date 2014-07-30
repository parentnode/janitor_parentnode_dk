<div class="scene front i:front">
	<h1>GIT based project Install</h1>
	

	<h3>1. Create Git repository</h3>
	<p>The easiest way to install Janitor is through Git. The first thing you need to do is to create a new Git repository. Here's and article on how to do that on <a href="https://help.github.com/articles/create-a-repo">github</a></p>
	
	<h3>2. Clone to local machine</h3>
	<p>Clone your newly created Git repository to your local machine. One of the easiest ways is to use the <a href="https://mac.github.com/">Github app</a></p>

	<h3>3. Clone submodules</h3>
	<p>Submodules is a clever thing that comes with git. A submodule in a git repository is like a sub-directory which is a separate git repository in its own. So, by cloning submodules into our new Git repository is half the job to het Janitor running.</p>
	<p>Open terminal. Navigate to the local project folder and run the following lines:</p>

	<div class="example">
		<code>git submodule add https://github.com/parentnode/js-merger.git submodules/js-merger
git commit -m 'added js-merger submodule'
git push


git submodule add https://github.com/parentnode/css-merger.git submodules/css-merger
git commit -m 'added css-merger submodule'
git push


git submodule add https://github.com/parentnode/janitor.git submodules/janitor
git commit -m 'added janitor submodule'
git push
		</code>
	</div>
					


	<h3>4. Update Apache configuration</h3>
	<p>Your Apache configuration file is most likely to be here <br>
	"/opt/local/apache2/conf/httpd.conf"<br>
	or here<br>
	"/opt/local/apache2/conf/extra/httpd-vhosts.conf"</p>
	<p><a href="https://www.google.com/search?q=etc%2Fhosts#q=Apache+configuration+httpd.conf">Google some more info</a></p>
	<p></p>


	<h3>5. Update hosts file</h3>
	<p>Your Hosts file is probably located here "/etc/hosts". Open it in an editor and add:</p>
	<div class="example">
		<code>
127.0.0.1	projectName.local
fe80::1%lo0	projectName.local
		</code>
	</div>
	<p><a href="https://www.google.com/search?q=etc%2Fhosts&oq=etc%2Fhosts">Google some more info</a></p>

	<h3>6. Restart Apache</h3>
	<p>Open terminal and enter "apache restart". </p>
	

	<h3>7. Run setup script</h3>
	<p>Open your browser and go to projectName.localhost. Follow the instructions.</br>
	Add DB
	Password
	</p>

	
	<p class="todo">Create tutorial for creating GIT repos and cloning submodules</p>

	

</div>
