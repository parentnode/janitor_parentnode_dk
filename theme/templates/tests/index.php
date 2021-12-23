<div class="scene i:scene tests front">
	<h1>Janitor Unit tests</h1>
	<h2>All purpose testing index</h2>

	<h3>Item classes</h3>
	<ul class="tests">
		<?= $HTML->link("Itemtype", "/janitor/tests/class-itemtype", array("wrapper" => "li.itemtype")) ?>
		<?= $HTML->link("Items", "/janitor/tests/class-items", array("wrapper" => "li.items")) ?>
		<?= $HTML->link("Taglist", "/janitor/tests/class-taglist", array("wrapper" => "li.taglist")) ?>
	</ul>

	<h3>Itemtypes classes</h3>
	<ul class="tests">
		<?= $HTML->link("TypeMessage", "/janitor/tests/class-type-message", array("wrapper" => "li.type-message")) ?>
	</ul>

	<h3>Shop classes</h3>
	<ul class="tests">
		<?= $HTML->link("Shop", "/janitor/tests/class-shop", array("wrapper" => "li.shop")) ?>
		<?= $HTML->link("SuperShop", "/janitor/tests/class-supershop", array("wrapper" => "li.supershop")) ?>
	</ul>

	<h3>Subscription classes</h3>
	<ul class="tests">
		<?= $HTML->link("Subscription", "/janitor/tests/class-subscription", array("wrapper" => "li.subscription")) ?>
		<?= $HTML->link("SuperSubscription", "/janitor/tests/class-supersubscription", array("wrapper" => "li.supersubscription")) ?>
	</ul>

	<h3>System classes</h3>
	<ul class="tests">
		<?= $HTML->link("Page", "/janitor/tests/class-page", array("wrapper" => "li.page")) ?>
		<?= $HTML->link("HTML", "/janitor/tests/class-html", array("wrapper" => "li.html")) ?>
		<?= $HTML->link("Model", "/janitor/tests/class-model", array("wrapper" => "li.model")) ?>
		<?= $HTML->link("Output", "/janitor/tests/class-output", array("wrapper" => "li.output")) ?>		
		<?= $HTML->link("Cache", "/janitor/tests/class-cache", array("wrapper" => "li.cache")) ?>

	</ul>

	<h3>User classes</h3>
	<ul class="tests">
		<?= $HTML->link("User", "/janitor/tests/user/index", array("wrapper" => "li.user")) ?>
		<?= $HTML->link("SuperUser", "/janitor/tests/class-superuser", array("wrapper" => "li.superuser")) ?>
	</ul>

	<h3>Member classes</h3>
	<ul class="tests">
		<?= $HTML->link("Member", "/janitor/tests/class-member", array("wrapper" => "li.member")) ?>
		<?= $HTML->link("SuperMember", "/janitor/tests/class-supermember", array("wrapper" => "li.supermember")) ?>
	</ul>

	<h3>Helper classes</h3>
	<ul class="tests">
		<?= $HTML->link("DOM", "/janitor/tests/class-dom", array("wrapper" => "li.dom")) ?>
		<?= $HTML->link("Mail", "/janitor/tests/mail", array("wrapper" => "li.mail")) ?>
		<?= $HTML->link("FileSystem", "/janitor/tests/class-filesystem", array("wrapper" => "li.filesystem")) ?>
		<?= $HTML->link("PDF", "/janitor/tests/class-pdf", array("wrapper" => "li.pdf")) ?>
		<?= $HTML->link("Autoconversion (Image/Video/Audio)", "/janitor/tests/api-autoconversion", array("wrapper" => "li.autoconversion")) ?>
		<?= $HTML->link("QR code generator", "/janitor/tests/class-qr-codes", array("wrapper" => "li.qr_codes")) ?>
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


	<h3>CSS + JS tests</h3>
	<ul class="tests">
		<?= $HTML->link("CSS/JS Scene (General)", "/janitor/tests/css-scene", array("wrapper" => "li.css")) ?>
		<?= $HTML->link("CSS/JS Form", "/janitor/tests/css-form", array("wrapper" => "li.css_form")) ?>
		<?= $HTML->link("CSS/JS Form, HTML Field", "/janitor/tests/css-form-field-html", array("wrapper" => "li.html")) ?>
		<?= $HTML->link("CSS/JS DefaultList", "/janitor/tests/css-default-list", array("wrapper" => "li.defaultlist")) ?>
		<?= $HTML->link("CSS/JS DefaultEdit", "/janitor/tests/css-default-edit", array("wrapper" => "li.defaultedit")) ?>
		<?= $HTML->link("CSS/JS DefaultNew", "/janitor/tests/css-default-new", array("wrapper" => "li.defaultnew")) ?>
	</ul>


	<h3>PHP Info</h3>
	<ul class="tests">
		<?= $HTML->link("PHP info", "/janitor/tests/phpinfo", array("wrapper" => "li.phpinfo")) ?>
	</ul>
</div>