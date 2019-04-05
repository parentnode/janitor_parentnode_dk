<?

$IC = new Items();
?>

<div class="scene i:scene tests">
	<h1>ItemsClass</h1>	
	<h2>Item querying of all sorts</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>#Test name#</h3>
		<? if("Your test condition"): ?>
		<div class="testpassed"><p>#Class::method# - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>#Class::method# - error</p></div>
		<? endif; ?>
	</div>

</div>