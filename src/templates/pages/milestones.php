<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("Where we are heading ...");
?>
<div class="scene milestones i:scene">

	<h1>Milestones</h1>
	<p>
		The core functionality of Janitor is solid and already implemented across
		a multitude of websites. The further development of Janitor is focused on syntax
		alignment, performance optimization, extending the advanced feature set and minor
		bug-fixing.
	</p>
	<p>
		Below you'll find the current roadmap for reaching version 1.
	</p>


	<h2>Version 0.8</h2>

	<h3>General</h3>
	<ul class="todo">
		<li>Only show TODOs and Questions on user dashboard if user has correct permissions - DONE</li>
		<li>Add target option to Navigation nodes - DONE</li>
		<li>Add way of specifying controller path for page Itemtype (per node) - DONE</li>
		<li>Implement fallback option for navigation nodes (if not accessible to user, hide or show fallback) - DONE</li>

		<li>Add full documentation for Page, Items, Itemtypes, Model and Queryi</li>

		<li>Add fully accessible demo site on janitor-demo.parentnode.dk</li>
		<li>Add "Fork me on Github" to this website</li>
		<li>Add "used by" footer to this website</li>
		<li>Add architecture documentation</li>
		<li>Add folder layout documentation</li>
		<li>Finish "Create Janitor project. Quickly." tutorial</li>
		<li>Finish "Install server software on windows" tutorial</li>
		<li>Finish "Upgrading to ..." tutorials</li>
	</ul>

	<h3>Backend interface</h3>
	<ul class="todo">
		<li>Update tag method in list view to match edit view</li>
		<li>Add tag based filtering in backend lists</li>
	</ul>


	<h2>Version 0.9</h2>

	<h3>General</h3>
	<ul class="todo">
		<li>Go through all old TODOs in source code</li>
		<li>Extend user dashboard</li>
		<li>Add languages admin interface</li>
		<li>Add countries admin interface</li>
		<li>Add documentation on how to build js+css using mergers</li>
		<li>Add full documentation for HTML, FileSystem, Session, Message, Video, Audio, Image and Users</li>
		<li>Add IP-based request limit on autoconversion (or similar) + disk space check</li>
		<li>Finalize "Install server software on windows" tutorial</li>
		<li>Finish "Set up an existing Janitor project" tutorial.</li>
		<li>If it seems logical, allow using all itemtypes as navigation nodes</li>
	</ul>

	<h3>Backend interface</h3>
	<ul class="todo">
		<li>Mobile touch support</li>
		<li>Collapsable navigation on Desktop</li>
		<li>Replace all graphics with SVGs</li>
		<li>Improve nested Drag'n'Drop structure for rearranging Navigation nodes (also update link-span when changing structure)</li>
	</ul>

	<h3>Queries</h3>
	<ul class="todo">
		<li>Optimize complex queries in Items::getItems for better performance (if possible)</li>
	</ul>

	<h3>Security / Accounts</h3>
	<ul class="todo">
		<li>Add timelock on repeated failed login attempts</li>
		<li>Add "forgot password"</li>
		<li>Add token login</li>
		<li>Refine content tab of user profile</li>
	</ul>

	<h3>Shop</h3>
	<ul class="todo">
		<li>Rewrite current temporary shop modules for public release</li>
		<li>Add currencies admin interface</li>
	</ul>


	<h2>Version 1.0</h2>

	<h3>General</h3>
	<ul class="todo">
		<li>Add general "getting started" examples</li>
		<li>Add full documentation for Shop</li>
	</ul>

	<h3>Shop</h3>
	<ul class="todo">
		<li>Final shop implementation</li>
	</ul>



	<h2>For consideration</h2>
	<p>
		Most of Janitor has been created on a need-to basis. Whenever something is needed in a project,
		we build the first version for that project. If it turns out to be a reoccuring need, it might end up
		as an official function.
	</p>
	<p>
		The following ideas have shown up along the way and are listed here to preserved initial thoughts for 
		further refinement.
	</p>

	<ul class="todo">
		<li>Complete WKHTML integration</li>
	</ul>

</div>
