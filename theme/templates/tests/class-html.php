<?
global $model;
global $IC;

?>

<div class="scene i:scene tests">
	<h1>HTML Class</h1>	
	<h2>HTML generation</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<p>
		The formStart test relies on NOT having access to "dummy-no-access-test-do-not-grant-access". If this access is
		granted, the test will fail.
	</p>

	<div class="tests attribute">
		<h3>HTML::attribute</h3>
		<?

		if(1 && "attribute (no values)") {

			$attribute_string = $HTML->attribute("class");

			if(!$attribute_string): ?>
			<div class="testpassed">HTML::attribute (no values) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::attribute (no values) - error</div>
			<? endif;

		}

		if(1 && "attribute (false and empty values)") {

			$attribute_string = $HTML->attribute("class", false, "");

			if(!$attribute_string): ?>
			<div class="testpassed">HTML::attribute (false and empty values) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::attribute (false and empty values) - error</div>
			<? endif;

		}

		if(1 && "attribute (one value)") {

			$attribute_string = $HTML->attribute("class", "test");

			if($attribute_string === ' class="test"'): ?>
			<div class="testpassed">HTML::attribute (one value) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::attribute (one value) - error</div>
			<? endif;

		}

		if(1 && "attribute (multiple values)") {

			$attribute_string = $HTML->attribute("class", "test", "someclass", "id:123");

			if($attribute_string === ' class="test someclass id:123"'): ?>
			<div class="testpassed">HTML::attribute (multiple values) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::attribute (multiple values) - error</div>
			<? endif;

		}

		if(1 && "attribute (mixed values)") {

			$attribute_string = $HTML->attribute("class", "test", false, "someclass", "", NULL, "id:123");

			if($attribute_string === ' class="test someclass id:123"'): ?>
			<div class="testpassed">HTML::attribute (mixed values) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::attribute (mixed values) - error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests toOptions">
		<h3>HTML::toOptions</h3>
		<?

		if(1 && "toOptions (empty array)") {

			$options_array = $HTML->toOptions([], "id", "value");

			if(!$options_array): ?>
			<div class="testpassed">HTML::toOptions (no values) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::toOptions (no values) - error</div>
			<? endif;

		}

		if(1 && "toOptions (dataset)") {

			$options_array = $HTML->toOptions([
				0 => ["id" => 0, "name" => "name 0", "value" => "Name value 0"],
				1 => ["id" => 1, "name" => "name 1", "value" => "Name value 1"],
			], "id", "value");

			if($options_array && count($options_array) == 2 &&
				$options_array[0] == "Name value 0" &&
				$options_array[1] == "Name value 1"
			): ?>
			<div class="testpassed">HTML::toOptions (dataset) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::toOptions (dataset) - error</div>
			<? endif;

		}

		if(1 && "toOptions (dataset + add option)") {

			$options_array = $HTML->toOptions([
				0 => ["id" => 0, "name" => "name 0", "value" => "Name value 0"],
				1 => ["id" => 1, "name" => "name 1", "value" => "Name value 1"],
			], "id", "value", ["add" => ["" => "Select"]]);

			if($options_array && count($options_array) == 3 &&
				$options_array[""] == "Select" &&
				$options_array[0] == "Name value 0" &&
				$options_array[1] == "Name value 1"
			): ?>
			<div class="testpassed">HTML::toOptions (dataset + add option) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::toOptions (dataset + add option) - error</div>
			<? endif;

		}

		if(1 && "toOptions (empty array + add option)") {

			$options_array = $HTML->toOptions([], "id", "value", ["add" => ["" => "Select"]]);

			if($options_array && count($options_array) == 1 &&
				$options_array[""] == "Select"
			): ?>
			<div class="testpassed">HTML::toOptions (empty array + add option) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::toOptions (empty array + add option) - error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests formStart">
		<h3>HTML::formStart</h3>
		<?

		if(1 && "formStart (allowed path)") {

			$form_html = $HTML->formStart("/");

			if(preg_match("/\<form action=\"\/\" method=\"post\" enctype=\"application\/x-www-form-urlencoded\"\>\n\<input type=\"hidden\" name=\"csrf-token\" value=\"[a-z0-9\-]+\" \/\>/", $form_html)): ?>
			<div class="testpassed">HTML::formStart (no values) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::formStart (no values) - error</div>
			<? endif;

		}

		if(1 && "formStart (disallowed path)") {

			$form_html = $HTML->formStart("/janitor/tests/dummy-no-access-test-do-not-grant-access");

			if(!$form_html): ?>
			<div class="testpassed">HTML::formStart (disallowed path) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::formStart (disallowed path) - error</div>
			<? endif;

		}

		if(1 && "formStart (allowed path, GET)") {

			$form_html = $HTML->formStart("/", ["method" => "get"]);

			if(preg_match("/\<form action=\"\/\" method=\"get\" enctype=\"application\/x-www-form-urlencoded\"\>\n\<input type=\"hidden\" name=\"csrf-token\" value=\"[a-z0-9\-]+\" \/\>/", $form_html)): ?>
			<div class="testpassed">HTML::formStart (allowed path, GET) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::formStart (allowed path, GET) - error</div>
			<? endif;

		}

		if(1 && "formStart (allowed path, GET, class, id)") {

			$form_html = $HTML->formStart("/", ["method" => "get", "class" => "classname", "id" => "elementid"]);

			if(preg_match("/\<form action=\"\/\" method=\"get\" class=\"classname\"\ id=\"elementid\" enctype=\"application\/x-www-form-urlencoded\">\n\<input type=\"hidden\" name=\"csrf-token\" value=\"[a-z0-9\-]+\" \/\>/", $form_html)): ?>
			<div class="testpassed">HTML::formStart (allowed path, GET, class, id) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::formStart (allowed path, GET, class, id) - error</div>
			<? endif;

		}

		if(1 && "formStart (allowed path, GET, class, id, enctype)") {

			$form_html = $HTML->formStart("/", ["method" => "get", "class" => "classname", "id" => "elementid", "enctype" => "multipart/form-data"]);

			if(preg_match("/\<form action=\"\/\" method=\"get\" class=\"classname\"\ id=\"elementid\" enctype=\"multipart\/form-data\">\n\<input type=\"hidden\" name=\"csrf-token\" value=\"[a-z0-9\-]+\" \/\>/", $form_html)): ?>
			<div class="testpassed">HTML::formStart (allowed path, GET, class, id, enctype) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::formStart (allowed path, GET, class, id, enctype) - error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests formEnd">
		<h3>HTML::formEnd</h3>
		<?

		if(1 && "formEnd (form was started)") {

			$form_start_html = $HTML->formStart("/");
			$form_end_html = $HTML->formEnd();

			if($form_end_html == "</form>\n"): ?>
			<div class="testpassed">HTML::formEnd (form was started) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::formEnd (form was started) - error</div>
			<? endif;

		}

		if(1 && "formEnd (form was started with disallowed path)") {

			$form_start_html = $HTML->formStart("/janitor/tests/dummy-no-access-test-do-not-grant-access");
			$form_end_html = $HTML->formEnd();

			if(!$form_end_html): ?>
			<div class="testpassed">HTML::formEnd (form was started with disallowed path) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::formEnd (form was started with disallowed path) - error</div>
			<? endif;

		}

		if(1 && "formEnd (form was NOT started)") {

			$form_end_html = $HTML->formEnd();

			if(!$form_end_html): ?>
			<div class="testpassed">HTML::formEnd (form was NOT started) - correct</div>
			<? else: ?>
			<div class="testfailed">HTML::formEnd (form was NOT started) - error</div>
			<? endif;

		}

		?>
	</div>

</div>