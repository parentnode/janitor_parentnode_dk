<?php

$redis = false;
$memc = false;

if(class_exists("Redis")) {


	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
}

if(class_exists("Memcached")) {

	$memc = new Memcached();
	$memc->addServer('localhost', 11211);
}

// TODO: Test remaining interface
// TODO: Test storing more advanced objects with special chars

$test_var = "janitor-test-".randomKey(8);
?>
<div class="scene i:scene tests">
	<h1>Cache</h1>	
	<h2>Testing cache (Memcached/fallback)</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<p>
		<? if($redis): ?>
		System is running Redis.<br />
		<? else:?>
		Redis is not running on this system.<br />
		<? endif; ?>

		<? if($memc): ?>
		System is running Memcached.<br />
		<? else:?>
		Memcached is not running on this system.<br />
		<? endif; ?>
	</p>

	<h3>Using <strong><?= cache()->cache_type ?></strong> for test</h3>


	<div class="tests value">
		<h3>Cache::value</h3>
		<? 

		if(1 && "non-existing key") {

			if(cache()->value($test_var) === NULL): ?>
			<div class="testpassed">Cache::value (non-existing key) - correct</div>
			<? else: ?>
			<div class="testfailed">Cache::value (non-existing key) - error</div>
			<? endif;

		}


		if(1 && "existing key") {

			cache()->value($test_var, "test-value");
		
			if(cache()->value($test_var) === "test-value"): ?>
			<div class="testpassed">Cache::value (existing key) - correct</div>
			<? else: ?>
			<div class="testfailed">Cache::value (existing key) - error</div>
			<? endif;

		}


		if(1 && "deleted key") {

			cache()->reset($test_var);
		
			if(cache()->value($test_var) === NULL): ?>
			<div class="testpassed">Cache::value (deleted key) - correct</div>
			<? else: ?>
			<div class="testfailed">Cache::value (deleted key) - error</div>
			<? endif;

		}

		?>
	</div>

</div>