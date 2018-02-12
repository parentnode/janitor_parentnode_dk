<div class="scene i:scene tests front">

	<h1>Janitor Unit tests</h1>

	<ul class="tests">
		<?= $HTML->link("Page", "/janitor/tests/page", array("wrapper" => "li.page")) ?>

		<?= $HTML->link("Autoconversion (Image/Video/Audio)", "/janitor/tests/autoconversion", array("wrapper" => "li.autoconversion")) ?>
		<?= $HTML->link("FileSystem", "/janitor/tests/filesystem", array("wrapper" => "li.filesystem")) ?>
		<?= $HTML->link("Cache", "/janitor/tests/cache", array("wrapper" => "li.cache")) ?>
		<?= $HTML->link("PDF", "/janitor/tests/pdf", array("wrapper" => "li.pdf")) ?>

		<?= $HTML->link("User", "/janitor/tests/user", array("wrapper" => "li.user")) ?>
		<?= $HTML->link("Shop", "/janitor/tests/shop", array("wrapper" => "li.shop")) ?>

		<?= $HTML->link("Form interface", "/janitor/tests/form", array("wrapper" => "li.form")) ?>
		<?= $HTML->link("Form validation", "/janitor/tests/form-validation", array("wrapper" => "li.formvalidation")) ?>

		<?= $HTML->link("Mail", "/janitor/tests/mail", array("wrapper" => "li.mail")) ?>



		<?= $HTML->link("Security", "/janitor/tests/security", array("wrapper" => "li.security")) ?>


		<?= $HTML->link("CSS Scene (General)", "/janitor/tests/css-scene", array("wrapper" => "li.css")) ?>
		<?= $HTML->link("CSS Form", "/janitor/tests/css-form", array("wrapper" => "li.css")) ?>

		<?= $HTML->link("CSS DefaultList", "/janitor/tests/css-default-list", array("wrapper" => "li.css")) ?>


		<?= $HTML->link("CSS DefaultEdit", "/janitor/tests/css-default-edit", array("wrapper" => "li.css")) ?>
		<?= $HTML->link("CSS DefaultNew", "/janitor/tests/css-default-new", array("wrapper" => "li.css")) ?>


		<?= $HTML->link("PHP info", "/janitor/tests/phpinfo", array("wrapper" => "li.phpinfo")) ?>
	</ul>
</div>