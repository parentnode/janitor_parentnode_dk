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

$UpgradeClass->checkDefaultValues(UT_VATRATES, "DEFAULT, 'No VAT', 0, 'DK'", "country = 'DK'");

// clear cached values
cache()->reset("languages");
cache()->reset("countries");
cache()->reset("currencies");
cache()->reset("vatrates");
?>

<div class="scene i:scene tests defaultEdit">
	<h1>Page</h1>	
	<h2>Testing Page class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>Page::language</h3>
		<? if($this->language() == DEFAULT_LANGUAGE_ISO): ?>
		<div class="testpassed"><p>Page::language (GET DEFAULT) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::language (GET DEFAULT) - error</p></div>
		<? endif; ?>

		<? 
		$this->language("DA");
		if($this->language() == "DA"):
		?>
		<div class="testpassed"><p>Page::language (SET DA) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::language (SET DA) - error</p></div>
		<? endif; ?>

		<? 
		$this->language("DE");
		if($this->language() == "DE"):
		?>
		<div class="testpassed"><p>Page::language (SET DE) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::language (SET DE) - error</p></div>
		<? endif; ?>

		<? 
		$this->language("XX");
		if($this->language() == "EN"):
		?>
		<div class="testpassed"><p>Page::language (SET XX - should return DEFAULT_LANGUAGE_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::language (SET XX - should return DEFAULT_LANGUAGE_ISO) - error</p></div>
		<? endif; ?>

		<?
		// set back to default
		$this->language(DEFAULT_LANGUAGE_ISO);
		?>
	</div>

	<div class="tests">
		<h3>Page::languages</h3>
		<?
		$languages = $this->languages();
		if(is_array($languages) && arrayKeyValue($languages, "id", "DA") !== false && arrayKeyValue($languages, "id", "EN") !== false):
		?>
		<div class="testpassed"><p>Page::languages (GET ALL) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::languages (GET ALL) - error</p></div>
		<? endif; ?>

		<?
		$language_details = $this->languages("DA");
		if(is_array($language_details) && $language_details["id"] == "DA"):
		?>
		<div class="testpassed"><p>Page::languages (GET DA) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::languages (GET DA) - error</p></div>
		<? endif; ?>

		<?
		$language_details = $this->languages("DE");
		if(is_array($language_details) && $language_details["id"] == "DE"):
		?>
		<div class="testpassed"><p>Page::languages (GET DE) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::languages (GET DE) - error</p></div>
		<? endif; ?>

		<?
		$language_details = $this->languages("XX");
		if(is_array($language_details) && $language_details["id"] == "EN"):
		?>
		<div class="testpassed"><p>Page::languages (GET XX - should return details for DEFAULT_LANGUAGE_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::languages (GET XX - should return details for DEFAULT_LANGUAGE_ISO) - error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>Page::country</h3>
		<? if($this->country() == DEFAULT_COUNTRY_ISO): ?>
		<div class="testpassed"><p>Page::country (GET DEFAULT) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::country (GET DEFAULT) - error</p></div>
		<? endif; ?>

		<? 
		$this->country("DK");
		if($this->country() == "DK"):
		?>
		<div class="testpassed"><p>Page::country (SET DK) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::country (SET DK) - error</p></div>
		<? endif; ?>

		<? 
		$this->country("DE");
		if($this->country() == "DE"):
		?>
		<div class="testpassed"><p>Page::country (SET DE) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::country (SET DE) - error</p></div>
		<? endif; ?>

		<? 
		$this->country("XX");
		if($this->country() == "DK"):
		?>
		<div class="testpassed"><p>Page::country (SET XX - should return DEFAULT_COUNTRY_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::country (SET XX - should return DEFAULT_COUNTRY_ISO) - error</p></div>
		<? endif; ?>

		<?
		// set back to default
		$this->country(DEFAULT_COUNTRY_ISO);
		?>
	</div>

	<div class="tests">
		<h3>Page::countries</h3>
		<?
		$countries = $this->countries();
		if(is_array($countries) && arrayKeyValue($countries, "id", "DK") !== false && arrayKeyValue($countries, "id", "DE") !== false):
		?>
		<div class="testpassed"><p>Page::countries (GET ALL) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::countries (GET ALL) - error</p></div>
		<? endif; ?>

		<?
		$country_details = $this->countries("DK");
		if(is_array($country_details) && $country_details["id"] == "DK"):
		?>
		<div class="testpassed"><p>Page::countries (GET DA) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::countries (GET DA) - error</p></div>
		<? endif; ?>

		<?
		$country_details = $this->countries("DE");
		if(is_array($country_details) && $country_details["id"] == "DE"):
		?>
		<div class="testpassed"><p>Page::countries (GET DE) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::countries (GET DE) - error</p></div>
		<? endif; ?>

		<?
		$country_details = $this->countries("XX");
		if(is_array($country_details) && $country_details["id"] == "DK"):
		?>
		<div class="testpassed"><p>Page::countries (GET XX - should return details for DEFAULT_COUNTRY_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::countries (GET XX - should return details for DEFAULT_COUNTRY_ISO) - error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>Page::currency</h3>
		<? if($this->currency() == DEFAULT_CURRENCY_ISO): ?>
		<div class="testpassed"><p>Page::currency (GET DEFAULT) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currency (GET DEFAULT) - error</p></div>
		<? endif; ?>

		<? 
		$this->currency("DKK");
		if($this->currency() == "DKK"):
		?>
		<div class="testpassed"><p>Page::currency (SET DK) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currency (SET DK) - error</p></div>
		<? endif; ?>

		<? 
		$this->currency("EUR");
		if($this->currency() == "EUR"):
		?>
		<div class="testpassed"><p>Page::currency (SET EUR) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currency (SET EUR) - error</p></div>
		<? endif; ?>

		<? 
		$this->currency("XX");
		if($this->currency() == "DKK"):
		?>
		<div class="testpassed"><p>Page::currency (SET XX - should return DEFAULT_CURRENCY_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currency (SET XX - should return DEFAULT_CURRENCY_ISO) - error</p></div>
		<? endif; ?>

		<?
		// set back to default
		$this->currency(DEFAULT_CURRENCY_ISO);
		?>
	</div>

	<div class="tests">
		<h3>Page::currencies</h3>
		<?
		$currencies = $this->currencies();
		if(is_array($currencies) && arrayKeyValue($currencies, "id", "DKK") !== false && arrayKeyValue($currencies, "id", "EUR") !== false):
		?>
		<div class="testpassed"><p>Page::currencies (GET ALL) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currencies (GET ALL) - error</p></div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("DKK");
		if(is_array($currency_details) && $currency_details["id"] == "DKK"):
		?>
		<div class="testpassed"><p>Page::currencies (GET DKK) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currencies (GET DKK) - error</p></div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("EUR");
		if(is_array($currency_details) && $currency_details["id"] == "EUR"):
		?>
		<div class="testpassed"><p>Page::currencies (GET EUR) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currencies (GET EUR) - error</p></div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("XXX");
		if(is_array($currency_details) && $currency_details["id"] == "DKK"):
		?>
		<div class="testpassed"><p>Page::currencies (GET XX - should return details for DEFAULT_CURRENCY_ISO) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::currencies (GET XX - should return details for DEFAULT_CURRENCY_ISO) - error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>Page::vatrates</h3>
		<?
		$vatrates = $this->vatrates();
		if(is_array($vatrates) && arrayKeyValue($vatrates, "country", "DK") !== false):
		?>
		<div class="testpassed"><p>Page::vatrates (GET ALL) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::vatrates (GET ALL) - error</p></div>
		<? endif; ?>

		<?
		$vatrate_details = $this->vatrates(1);
		if(is_array($vatrate_details) && $vatrate_details["country"] == "DK"):
		?>
		<div class="testpassed"><p>Page::vatrates (GET id=1) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::vatrates (GET id=1) - error</p></div>
		<? endif; ?>

		<?
		$vatrate_details = $this->vatrates(9999);
		if($vatrate_details === false):
		?>
		<div class="testpassed"><p>Page::vatrates (GET id=9999) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Page::vatrates (GET id=9999) - error</p></div>
		<? endif; ?>

	</div>

</div>