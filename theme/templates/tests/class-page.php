<?
global $model;
$existing_rows = [];

// ensure correct default values are available for test
include_once("classes/system/upgrade.class.php");
$UpgradeClass = new Upgrade();

setLocalizationValues(UT_LANGUAGES, "'DA','Dansk'", "id = 'DA'");
setLocalizationValues(UT_LANGUAGES, "'EN','English'", "id = 'EN'");
setLocalizationValues(UT_LANGUAGES, "'DE','Deutch'", "id = 'DE'");

setLocalizationValues(UT_CURRENCIES, "'DKK', 'Kroner (Denmark)', 'DKK', 'after', 2, ',', '.'", "id = 'DKK'");
setLocalizationValues(UT_CURRENCIES, "'EUR', 'Euro (Denmark)', '€', 'before', 2, ',', '.'", "id = 'EUR'");

setLocalizationValues(UT_COUNTRIES, "'DK', 'Danmark', '45', '#### ####', 'DA', 'DKK'", "id = 'DK'");
setLocalizationValues(UT_COUNTRIES, "'DE', 'Deutchland', '49', '#### ####', 'DE', 'EUR'", "id = 'DE'");

setLocalizationValues(UT_VATRATES, "DEFAULT, 'No VAT', 0, 'DK'", "vatrate = '0' AND country = 'DK'");
setLocalizationValues(UT_VATRATES, "DEFAULT, '25%', 25, 'DK'", "vatrate = '25' AND country = 'DK'");


function setLocalizationValues($db_table, $values, $accept_row) {
	$query = new Query();
	global $existing_rows;

	$sql = "SELECT * FROM ".$db_table." WHERE ".$accept_row;
	if(!$query->sql($sql)) {
		$sql = "INSERT INTO ".$db_table." VALUES (".$values.")"	;
		$query->sql($sql);
	}
	else {

		if(!isset($existing_rows[$db_table])) {
			$existing_rows[$db_table] = [];
		}
		array_push($existing_rows[$db_table], $accept_row);
	}
}
	
function resetLocalizationValues($db_table) {
	
	$query = new Query();
	global $existing_rows;

	$sql = "SELECT * FROM ".$db_table;
	if($query->sql($sql)) {
		$results = $query->results();
		for($i = 0; $i < count($results); $i++) {

			if($db_table == "janitor_parentnode_dk.system_vatrates") {
				
				$row_vatrate = $results[$i]["vatrate"];
				$search_result = array_search("vatrate = '$row_vatrate' AND country = 'DK'", $existing_rows[$db_table]);
	
				// row did not exist before test
				if($search_result === false) {
				
					$sql = "DELETE FROM ".$db_table." WHERE vatrate = '".$row_vatrate."'";
					$query->sql($sql);
				}
			}
			else {
				
				$row_id = $results[$i]["id"];
				$search_result = array_search("id = '$row_id'", $existing_rows[$db_table]);
	
				// row did not exist before test
				if($search_result === false) {
				
					$sql = "DELETE FROM ".$db_table." WHERE id = '".$row_id."'";
					$query->sql($sql);
				}
			}



		}
		
	}
	
}

	




// clear cached values
cache()->reset("languages");
cache()->reset("countries");
cache()->reset("currencies");
cache()->reset("vatrates");
?>

<div class="scene i:scene tests">
	<h1>Page</h1>	
	<h2>Testing Page class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<div class="tests language">
		<h3>Page::language</h3>
		<? if($this->language() == DEFAULT_LANGUAGE_ISO): ?>
		<div class="testpassed">Page::language (GET DEFAULT) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::language (GET DEFAULT) - error</div>
		<? endif; ?>

		<? 
		$this->language("DA");
		if($this->language() == "DA"):
		?>
		<div class="testpassed">Page::language (SET DA) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::language (SET DA) - error</div>
		<? endif; ?>

		<? if(1 && "Page::language (SET DE)"): ?>
			<? 
			$this->language("DE");
			if($this->language() == "DE"):
			?>
			<div class="testpassed">Page::language (SET DE) - correct</div>
			<? else: ?>
			<div class="testfailed">Page::language (SET DE) - error</div>
			<? endif; ?>
		<? endif; ?>

		<? 
		$this->language("XX");
		if($this->language() == "EN"):
		?>
		<div class="testpassed">Page::language (SET XX - should return DEFAULT_LANGUAGE_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::language (SET XX - should return DEFAULT_LANGUAGE_ISO) - error</div>
		<? endif; ?>

		<?
		// set back to default
		$this->language(DEFAULT_LANGUAGE_ISO);
		?>
	</div>

	<div class="tests languages">
		<h3>Page::languages</h3>
		<?
		$languages = $this->languages();
		if(is_array($languages) && arrayKeyValue($languages, "id", "DA") !== false && arrayKeyValue($languages, "id", "EN") !== false):
		?>
		<div class="testpassed">Page::languages (GET ALL) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::languages (GET ALL) - error</div>
		<? endif; ?>

		<?
		$language_details = $this->languages("DA");
		if(is_array($language_details) && $language_details["id"] == "DA"):
		?>
		<div class="testpassed">Page::languages (GET DA) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::languages (GET DA) - error</div>
		<? endif; ?>

		<? if(1 && "Page::languages (GET DE)"): ?>
			<?
			$language_details = $this->languages("DE");
			if(is_array($language_details) && $language_details["id"] == "DE"):
			?>
			<div class="testpassed">Page::languages (GET DE) - correct</div>
			<? else: ?>
			<div class="testfailed">Page::languages (GET DE) - error</div>
			<? endif; ?>
		<? endif; ?>

		<?
		$language_details = $this->languages("XX");
		if(is_array($language_details) && $language_details["id"] == "EN"):
		?>
		<div class="testpassed">Page::languages (GET XX - should return details for DEFAULT_LANGUAGE_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::languages (GET XX - should return details for DEFAULT_LANGUAGE_ISO) - error</div>
		<? endif; ?>
	</div>

	<div class="tests country">
		<h3>Page::country</h3>
		<? if($this->country() == DEFAULT_COUNTRY_ISO): ?>
		<div class="testpassed">Page::country (GET DEFAULT) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::country (GET DEFAULT) - error</div>
		<? endif; ?>

		<? 
		$this->country("DK");
		if($this->country() == "DK"):
		?>
		<div class="testpassed">Page::country (SET DK) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::country (SET DK) - error</div>
		<? endif; ?>

		
		<? if(1 && "page::country (SET DE)"): ?>
			<? 
			$this->country("DE");
			if($this->country() == "DE"):
			?>
			<div class="testpassed">Page::country (SET DE) - correct</div>
			<? else: ?>
			<div class="testfailed">Page::country (SET DE) - error</div>
			<? endif; ?>
		<? endif; ?>


		<? 
		$this->country("XX");
		if($this->country() == "DK"):
		?>
		<div class="testpassed">Page::country (SET XX - should return DEFAULT_COUNTRY_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::country (SET XX - should return DEFAULT_COUNTRY_ISO) - error</div>
		<? endif; ?>

		<?
		// set back to default
		$this->country(DEFAULT_COUNTRY_ISO);
		?>
	</div>

	<div class="tests countries">
		<h3>Page::countries</h3>
		
		<?
		$countries = $this->countries();
		if(is_array($countries) && arrayKeyValue($countries, "id", "DK") !== false && arrayKeyValue($countries, "id", "DE") !== false):
		?>
		<div class="testpassed">Page::countries (GET ALL) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::countries (GET ALL) - error</div>
		<? endif; ?>

		<?
		$country_details = $this->countries("DK");
		if(is_array($country_details) && $country_details["id"] == "DK"):
		?>
		<div class="testpassed">Page::countries (GET DA) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::countries (GET DA) - error</div>
		<? endif; ?>

		<?
		$country_details = $this->countries("DE");
		if(is_array($country_details) && $country_details["id"] == "DE"):
		?>
		<div class="testpassed">Page::countries (GET DE) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::countries (GET DE) - error</div>
		<? endif; ?>

		<?
		$country_details = $this->countries("XX");
		if(is_array($country_details) && $country_details["id"] == "DK"):
		?>
		<div class="testpassed">Page::countries (GET XX - should return details for DEFAULT_COUNTRY_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::countries (GET XX - should return details for DEFAULT_COUNTRY_ISO) - error</div>
		<? endif; ?>
	</div>

	<div class="tests currency">
		<h3>Page::currency</h3>
		<? if($this->currency() == DEFAULT_CURRENCY_ISO): ?>
		<div class="testpassed">Page::currency (GET DEFAULT) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currency (GET DEFAULT) - error</div>
		<? endif; ?>

		<? 
		$this->currency("DKK");
		if($this->currency() == "DKK"):
		?>
		<div class="testpassed">Page::currency (SET DK) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currency (SET DK) - error</div>
		<? endif; ?>

		<? 
		$this->currency("EUR");
		if($this->currency() == "EUR"):
		?>
		<div class="testpassed">Page::currency (SET EUR) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currency (SET EUR) - error</div>
		<? endif; ?>

		<? 
		$this->currency("XX");
		if($this->currency() == "DKK"):
		?>
		<div class="testpassed">Page::currency (SET XX - should return DEFAULT_CURRENCY_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currency (SET XX - should return DEFAULT_CURRENCY_ISO) - error</div>
		<? endif; ?>

		<?
		// set back to default
		$this->currency(DEFAULT_CURRENCY_ISO);
		?>
	</div>

	<div class="tests currencies">
		<h3>Page::currencies</h3>
		<?
		$currencies = $this->currencies();
		if(is_array($currencies) && arrayKeyValue($currencies, "id", "DKK") !== false && arrayKeyValue($currencies, "id", "EUR") !== false):
		?>
		<div class="testpassed">Page::currencies (GET ALL) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currencies (GET ALL) - error</div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("DKK");
		if(is_array($currency_details) && $currency_details["id"] == "DKK"):
		?>
		<div class="testpassed">Page::currencies (GET DKK) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currencies (GET DKK) - error</div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("EUR");
		if(is_array($currency_details) && $currency_details["id"] == "EUR"):
		?>
		<div class="testpassed">Page::currencies (GET EUR) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currencies (GET EUR) - error</div>
		<? endif; ?>

		<?
		$currency_details = $this->currencies("XXX");
		if(is_array($currency_details) && $currency_details["id"] == "DKK"):
		?>
		<div class="testpassed">Page::currencies (GET XX - should return details for DEFAULT_CURRENCY_ISO) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::currencies (GET XX - should return details for DEFAULT_CURRENCY_ISO) - error</div>
		<? endif; ?>
	</div>

	<div class="tests vatrates">
		<h3>Page::vatrates</h3>
		<?
		$vatrates = $this->vatrates();
		if(is_array($vatrates) && arrayKeyValue($vatrates, "country", "DK") !== false):
		?>
		<div class="testpassed">Page::vatrates (GET ALL) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::vatrates (GET ALL) - error</div>
		<? endif; ?>

		<?
		$vatrate_details = $this->vatrates(1);
		if(is_array($vatrate_details) && $vatrate_details["country"] == "DK"):
		?>
		<div class="testpassed">Page::vatrates (GET id=1) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::vatrates (GET id=1) - error</div>
		<? endif; ?>

		<?
		$vatrate_details = $this->vatrates(9999);
		if($vatrate_details === false):
		?>
		<div class="testpassed">Page::vatrates (GET id=9999) - correct</div>
		<? else: ?>
		<div class="testfailed">Page::vatrates (GET id=9999) - error</div>
		<? endif; ?>

	</div>

	<?
	// CLEAN UP
	resetLocalizationValues(UT_COUNTRIES);
	resetLocalizationValues(UT_CURRENCIES);
	resetLocalizationValues(UT_VATRATES);
	resetLocalizationValues(UT_LANGUAGES);

	?>

</div>