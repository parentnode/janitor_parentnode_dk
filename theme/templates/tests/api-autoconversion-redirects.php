<?

?>

<div class="scene i:scene tests">
	<h1>Autoconversion - redirects</h1>
	<h2>Automatic redirects to new variant names</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>Redirect</h3>
		<p>
			This test is very manual – it requires a known item_id that has a known mediae variant.
			This mediae variant must then have an "artifical" previous variant added to the 
			project <em>config/mediae_variant_redirects.php</em> array, to test if it will redirect
			to the current variant, when accessed using the artificial variant.
		</p>
		<p>
			We do that by simply adding an image with the artificial variant URL in this page.
			The picture should load, despite it's incorrect URL, and when looking in the network pane of
			your developer tools, you should see that the HTTP Response code is 301 (permenantly moved) to
			inform search engines, crawlers and others that the new url is permanent,
		</p>
		<p class="note">THIS TEST WILL FAIL IF YOUR LOCAL SETUP DOESN'T HAVE THE EXPECTED ITEM (CURRENTLY ITEM_ID 2377, VARIANT mediae-ki6l3gkp).</p>

		<h3>Should load, with redirect (301) - AND (307) if public image did not exist</h3>
		<img src="/images/2377/abcdefgh/100x.png" />

		<h3>Should redirect (307) to missing image - AND additional (307) if public missing image did not exist</h3>
		<img src="/images/2377/abcdefg/100x.png" />

		<h3>Should load, without redirect – or (307) if public image did not exist</h3>
		<img src="/images/2377/mediae-ki6l3gkp/100x.png" />

	</div>

</div>