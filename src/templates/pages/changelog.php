<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("It's just improvements");
?>
<div class="scene changelog i:scene">

	<h1>Changelog</h1>

	<h2>Version 0.7.6</h2>
	<p>
		The most important updates are:
	</p>

	<ul class="changes">
		<li>Added token login</li>
		<li>Reworked FileSystem functionality for improved edge-case handling</li>
		<li>Added Zipper.class for easier creation of zip-files</li>
		
		<li>Added headerIncludes function to add header CSS and JS includes from content templates</li>
		<li>Navigation nodes now allow for specifying controller path for page Itemtype (per node)</li>
		<li>Updated to Detector-v3</li>
		<li>
			Non-privleged user creation (members), via plain signup or newsletter signup.
			Includes activation email and confirmation process.<br /><br />

			NOTE: controllers are not included in Janitor, but will be exemplified in the Janitor demo shortly.<br />
		</li>
		<li>
			User profile module.
		</li>
		<li>
			Simple automated version control on all main item data updates. This is considered a
			data protection enhancement - Revisions are still only availble
			via DB access. Revision interface could be included in v0.9.
		</li>
		<li>
			Global item comments added. Now any item can have comments added.
		</li>
		<li>
			Added IC::getRelatedItems which finds best matching items based on tags and itemtype.
		</li>
		<li>
			Added Readstates - the ability to store "read"-state for users on any item.
		</li>
		<li>
			Updated TODOs with assigned_to value. Also added JML-listUserTodos for creating dashboard on frontpage.
		</li>
		<li>
			Added Questions and Answers global item. Also added JML-listOpenQuestions for creating dashboard on frontpage.
		</li>
	</ul>



	<h2>Version 0.7.5</h2>
	<p>
		Version 0.7.5 finalized a long awaited major core class update and a full webbased setup module.
	</p>
	<p>
		The most important updates were:
	</p>

	<ul class="changes">
		<li>Setup interface for existing projects</li>
		<li>Setup interface for new projects</li>
		<li>Reorganized core class naming and inclusion model</li>
		<li>Updated folder structure</li>
		<li>Simplified backend template HTML with general Janitor HTML support class</li>
	</ul>


	<h2>Version 0.7</h2>
	<p>
		Version 0.7 added Windows support to Janitor and an all rewritten security model.
	</p>
	<p>
		The most important updates were:
	</p>

	<ul class="changes">
		<li>Added Windows support</li>
		<li>Updated security model with csrf token</li>
		<li>Updated Apache conf layout</li>
		<li>Introduced default guest user for all visitors</li>
		<li>Simplified controller layout</li>
	</ul>

</div>
