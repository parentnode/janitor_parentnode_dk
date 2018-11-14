<div class="scene i:scene tests defaultEdit">
	<h1>PDF</h1>	
	<h2>Testing PDF generation</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<p>The PDF class is using the WKHTMLTO module to create a PDF of the <a href="/tests/pdf-template" target="_blank">pdf-template</a>.</p>


	<ul class="actions">
		<?= $HTML->link("Generate and View PDF", "/janitor/tests/pdf/download", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

</div>