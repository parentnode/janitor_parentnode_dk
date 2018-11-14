<?
// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();

$UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'DA','Dansk'", "id = 'DA'");
$UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'EN','English'", "id = 'EN'");
$UpgradeClass->checkDefaultValues(UT_LANGUAGES, "'DE','Deutch'", "id = 'DE'");

$UpgradeClass->checkDefaultValues(UT_CURRENCIES, "'DKK', 'Kroner (Denmark)', 'DKK', 'after', 2, ',', '.'", "id = 'DKK'");
$UpgradeClass->checkDefaultValues(UT_CURRENCIES, "'EUR', 'Euro (Denmark)', '€', 'before', 2, ',', '.'", "id = 'EUR'");

$UpgradeClass->checkDefaultValues(UT_COUNTRIES, "'DK', 'Danmark', '45', '#### ####', 'DA', 'DKK'", "id = 'DK'");
$UpgradeClass->checkDefaultValues(UT_COUNTRIES, "'DE', 'Deutchland', '49', '#### ####', 'DE', 'EUR'", "id = 'DE'");

$UpgradeClass->checkDefaultValues(UT_SUBSCRIPTION_METHODS, "DEFAULT, 'Month', 'monthly', DEFAULT", "name = 'Month'");
$UpgradeClass->checkDefaultValues(UT_VATRATES, "999, 'No VAT', 0, 'DK'", "id = 999");
$UpgradeClass->checkDefaultValues(UT_VATRATES, "998, '25%', 25, 'DK'", "id = 998");










$SC = new Shop();
?>

<div class="scene i:scene tests defaultEdit">
	<h1>Shop</h1>	
	<h2>Testing Shop classs</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>Shop::getCart()</h3>
		<?
		$cart = $SC->getCart();
		
		if($cart): ?>
		<div class="testpassed"><p>Shop::getCart - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Shop::getCart - error</p></div>
		<? endif; ?>


	</div>

</div>

<?
	// CLEAN UP
	$model->delete(array("membership/delete/".$item_with_price["item_id"]));
	$model->delete(array("membership/delete/".$item_without_price["item_id"]));
?>