<?

?>

<div class="scene i:scene tests">
	<h1>#What#</h1>	
	<h2>#what does it do#</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests #method#">
		<h3>#Test name#</h3>
		<? 

		// Your test code
		if("Your test condition"): ?>
		<div class="testpassed">#Class::method# - correct</div>
		<? else: ?>
		<div class="testfailed">#Class::method# - error</div>
		<? endif; ?>
	</div>

</div>