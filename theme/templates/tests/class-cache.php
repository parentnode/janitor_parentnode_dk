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
		System is running Redis.
		<? else:?>
		Redis is not running on this system.
		<? endif; ?>
	</p>

	<p>
		<? if($memc): ?>
		System is running Memcached.
		<? else:?>
		Memcached is not running on this system.
		<? endif; ?>
	</p>

	<div class="tests value empty">
		<h3>Cache::value (non-existing key)</h3>
		<? if(cache()->value($test_var) == ""): ?>
		<div class="testpassed">Cache::value - correct</div>
		<? else: ?>
		<div class="testfailed">Cache::value - error</div>
		<? endif; ?>
	</div>

	<div class="tests value existing">
		<h3>Cache::value (existing key)</h3>
		<?
		cache()->value($test_var, "test-value");
		
		if(cache()->value($test_var) == "test-value"): ?>
		<div class="testpassed">Cache::value - correct</div>
		<? else: ?>
		<div class="testfailed">Cache::value - error</div>
		<? endif; ?>
	</div>

	<div class="tests deleted">
		<h3>Cache::value (deleted key)</h3>
		<?
		cache()->reset($test_var);
		
		if(cache()->value($test_var) == ""): ?>
		<div class="testpassed">Cache::value - correct</div>
		<? else: ?>
		<div class="testfailed">Cache::value - error</div>
		<? endif; ?>
	</div>

</div>