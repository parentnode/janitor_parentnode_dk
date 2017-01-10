<?php
	
if(class_exists("Memcached")) {

	$memc = new Memcached();
	$memc->addServer('localhost', 11211);
	
	
}
else {
	
	$memc = false;
}


$test_var = "janitor-test-".randomKey(8);
?>
<div class="scene i:scene tests defaultEdit">
	<h1>Cache</h1>	
	<h2>Testing cache (Memcached/fallback)</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<p>
		<? if($memc): ?>
		System is running Memcached.
		<? else:?>
		Memcached is not running on this system.
		<? endif; ?>
	</p>

	<div class="tests">
		<h3>Cache::value (non-existing key)</h3>
		<? if(cache()->value($test_var) == ""): ?>
		<div class="testpassed"><p>Cache::value - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Cache::value - error</p></div>
		<? endif; ?>
	</div>

	<?
		cache()->value($test_var, "test-value");
	?>
	<div class="tests">
		<h3>Cache::value (existing key)</h3>
		<? if(cache()->value($test_var) == "test-value"): ?>
		<div class="testpassed"><p>Cache::value - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Cache::value - error</p></div>
		<? endif; ?>
	</div>


	<?
		cache()->reset($test_var);
	?>
	<div class="tests">
		<h3>Cache::value (deleted key)</h3>
		<? if(cache()->value($test_var) == ""): ?>
		<div class="testpassed"><p>Cache::value - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Cache::value - error</p></div>
		<? endif; ?>
	</div>


</div>