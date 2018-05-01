<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();


$IC = new Items();
$UC = new User();
?>

<div class="scene i:scene tests defaultEdit">
	<h1>User</h1>	
	<h2>User::getMembership</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<div class="tests">
		<h3>User::getMembership</h3>
		<? 
		$membership = $UC->getMembership();
		print "<code>";
		print_r($membership);
		print "</code>";

		if(
			$membership &&
			$membership["nickname"] &&
			$membership["email"] &&
			$membership["language"] &&
			isset($membership["firstname"]) &&
			isset($membership["lastname"]) &&
			isset($membership["mobile"]) &&
			isset($membership["addresses"]) &&
			isset($membership["membership"]) &&
			isset($membership["newsletters"])
		): ?>
		<div class="testpassed"><p>User::getUser - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>User::getUser - error</p></div>
		<? endif; ?>

	</div>
