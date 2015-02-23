<?php
$this->bodyClass("changelog");
$this->pageTitle("It's just improvements");
?>
<div class="scene changelog i:scene">

	<h1>Changelog</h1>

	<h2>Version 8.0</h2>
	<p>
		Summary
	</p>
	<p>
		The most important updates are:
	</p>

	<ul class="changes">
		<li>
			Non-privleged user creation (members), via plain signup or newsletter signup.
			Includes activation email and confirmation process.

			NOTE: controllers are not included in Janitor yet!<br />
			(they are frontend controllers and are currently located in 
			kaestel_dk/src/www/newsletter.php and
			kaestel_dk/src/www/signup.php)
		</li>
		<li>
			User profile module.
		</li>
	</ul>

</div>
