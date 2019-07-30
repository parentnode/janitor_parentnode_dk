<div class="scene i:scene tests front">
	<h1>Janitor Unit tests</h1>
	<h2>All purpose testing index</h2>
	
	<h3>Classes</h3>
	<ul class="tests">
		<?= $HTML->link("Page", "/janitor/tests/class-page", array("wrapper" => "li.page")) ?>
		<?= $HTML->link("Items", "/janitor/tests/class-items", array("wrapper" => "li.items")) ?>

		<?= $HTML->link("Model", "/janitor/tests/class-model", array("wrapper" => "li.model")) ?>

		<?= $HTML->link("Autoconversion (Image/Video/Audio)", "/janitor/tests/autoconversion", array("wrapper" => "li.autoconversion")) ?>
		<?= $HTML->link("FileSystem", "/janitor/tests/class-filesystem", array("wrapper" => "li.filesystem")) ?>
		<?= $HTML->link("Cache", "/janitor/tests/class-cache", array("wrapper" => "li.cache")) ?>
		<?= $HTML->link("DOM", "/janitor/tests/class-dom", array("wrapper" => "li.dom")) ?>
		<?= $HTML->link("PDF", "/janitor/tests/class-pdf", array("wrapper" => "li.pdf")) ?>
		<?= $HTML->link("Output", "/janitor/tests/class-output", array("wrapper" => "li.output")) ?>		
		<?= $HTML->link("Mail", "/janitor/tests/mail", array("wrapper" => "li.mail")) ?>
		<?= $HTML->link("User", "/janitor/tests/user/index", array("wrapper" => "li.user")) ?>
		<?= $HTML->link("Member", "/janitor/tests/class-member", array("wrapper" => "li.member")) ?>
		<?= $HTML->link("Shop", "/janitor/tests/shop", array("wrapper" => "li.shop")) ?>
		<?= $HTML->link("Subscription", "/janitor/tests/class-subscription", array("wrapper" => "li.subscription")) ?>
		<?= $HTML->link("SuperUser", "/janitor/tests/class-superuser", array("wrapper" => "li.superuser")) ?>
		<?= $HTML->link("SuperShop", "/janitor/tests/supershop", array("wrapper" => "li.supershop")) ?>
		<?= $HTML->link("SuperSubscription", "/janitor/tests/class-supersubscription", array("wrapper" => "li.supersubscription")) ?>

	</ul>


	<h3>Form and model</h3>
	<ul class="tests">
		<?= $HTML->link("Form interface", "/janitor/tests/form", array("wrapper" => "li.form")) ?>
		<?= $HTML->link("Form validation", "/janitor/tests/form-validation", array("wrapper" => "li.formvalidation")) ?>
	</ul>

	<h3>Global functions</h3>
	<ul class="tests">
		<?= $HTML->link("Functions", "/janitor/tests/functions", array("wrapper" => "li.functions")) ?>
	</ul>


	<h3>Security test</h3>
	<ul class="tests">
		<?= $HTML->link("Security", "/janitor/tests/security", array("wrapper" => "li.security")) ?>
	</ul>


	<h3>CSS tests</h3>
	<ul class="tests">
		<?= $HTML->link("CSS Scene (General)", "/janitor/tests/css-scene", array("wrapper" => "li.css")) ?>
		<?= $HTML->link("CSS Form", "/janitor/tests/css-form", array("wrapper" => "li.css")) ?>
		<?= $HTML->link("CSS DefaultList", "/janitor/tests/css-default-list", array("wrapper" => "li.css")) ?>
		<?= $HTML->link("CSS DefaultEdit", "/janitor/tests/css-default-edit", array("wrapper" => "li.css")) ?>
		<?= $HTML->link("CSS DefaultNew", "/janitor/tests/css-default-new", array("wrapper" => "li.css")) ?>
	</ul>


	<h3>PHP Info</h3>
	<ul class="tests">
		<?= $HTML->link("PHP info", "/janitor/tests/phpinfo", array("wrapper" => "li.phpinfo")) ?>
	</ul>
</div>