<?

?>

<div class="scene i:scene tests">
	<h1>Global functions</h1>	
	<h2>General purpose functions, globally available.</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests getPost">
		<h3>getPost</h3>

		<?
		// getPost

		$ref1 = "test æøå %€&§$ \"' < >(){}[]?!*`´@/\\ test";
		$_POST["test1"] = $ref1;
		$res1 = "test æøå %€&§$ \\\"\\' < >(){}[]?!*`´@/\\\\ test";

		$ref2 = "test <script> test <> test";
		$_POST["test2"] = $ref2;
		$res2 = "test  test  test";

		$ref3 = "test <script>alert('hej');</script> test";
		$_POST["test3"] = $ref3;
		$res3 = "test alert(\\'hej\\'); test";

		$ref4 = "test <span>test</span> test";
		$_POST["test4"] = $ref4;
		$res4 = "test <span>test</span> test";

		$string1 = getPost("test1");
		$string2 = getPost("test2");
		$string3 = getPost("test3");
		$string4 = getPost("test4");

		$string0 = getPost("test0");

		// debug([$ref1, $string1, $res1, $ref2, $string2, $res2, $ref3, $string3, $res3, $ref4, $string4, $res4]);

		if($string1 === $res1 && $string2 === $res2 && $string3 === $res3 && $string4 === $res4 && !$string0): ?>
		<div class="testpassed">getPost - correct</div>
		<? else: ?>
		<div class="testfailed">getPost - error</div>
		<? endif; ?>

	</div>

	<div class="tests getPosts">
		<h3>getPosts</h3>

		<?
		// getPosts	

		$ref1 = "test æøå %€&§$ \"' < >(){}[]?!*`´@/\\ test";
		$_POST["test1"] = $ref1;
		$res1 = "test æøå %€&§$ \\\"\\' < >(){}[]?!*`´@/\\\\ test";

		$ref2 = "test <script> test <> test";
		$_POST["test2"] = $ref2;
		$res2 = "test  test  test";

		$ref3 = "test <script>alert('hej');</script> test";
		$_POST["test3"] = $ref3;
		$res3 = "test alert(\\'hej\\'); test";

		$ref4 = "test <span>test</span> test";
		$_POST["test4"] = $ref4;
		$res4 = "test <span>test</span> test";

		$strings = getPosts(["test1", "test2", "test3", "test4", "test0"]);

		// debug([$strings]);
		// debug([$ref1, $strings["test1"], $res1, $ref2, $strings["test2"], $res2, $ref3, $strings["test3"], $res3, $ref4, $strings["test4"], $res4]);
		?>			
		<? if($strings["test1"] === $res1 && $strings["test2"] === $res2 && $strings["test3"] === $res3 && $strings["test4"] === $res4 && !$strings["test0"]): ?>
		<div class="testpassed">getPosts - correct</div>
		<? else: ?>
		<div class="testfailed">getPosts - error</div>
		<? endif; ?>

	</div>

	<div class="tests getPostPassword">
		<h3>getPostPassword</h3>

<?
// getPostPassword

$ref1 = "test æøå %€&§$ \"' <>(){}[]?!*`´@/\\ test";
$_POST["test1"] = $ref1;
$res1 = "test æøå %€&§$ \"' <>(){}[]?!*`´@/\\ test";

$ref2 = "test <script></script> test";
$_POST["test2"] = $ref2;
$res2 = "test <script></script> test";

$string1 = getPostPassword("test1");
$string2 = getPostPassword("test2");

// debug([$ref1, $string1, $res1, $ref2, $string2, $res2]);
?>
		<? if($string1 === $res1 && $string2 === $res2): ?>
		<div class="testpassed">getPostPassword - correct</div>
		<? else: ?>
		<div class="testfailed">getPostPassword - error</div>
		<? endif; ?>

	</div>

	<div class="tests prepareForDB">
		<h3>prepareForDB</h3>

<?
// prepareForDB

$ref1 = "test æøå %€&§$ \"' < >(){}[]?!*`´@/\\ test";
$res1 = "test æøå %€&§$ \\\"\' < >(){}[]?!*`´@/\\\\ test";

$ref2 = "test <script> test <> test";
$res2 = "test  test  test";

$ref3 = "test <script>alert('hej');</script> test";
$res3 = "test alert(\'hej\'); test";

$ref4 = "test <span>test</span> test";
$res4 = "test <span>test</span> test";

$string1 = prepareForDB($ref1);
$string2 = prepareForDB($ref2);
$string3 = prepareForDB($ref3);
$string4 = prepareForDB($ref4);

$strings = prepareForDB(["test1" => $ref1, "test2" => $ref2]);

// debug([$strings]);
// debug([$ref1, $strings["test1"], $res1, $ref2, $strings["test2"], $res2]);
// debug([$ref1, $string1, $res1, $ref2, $string2, $res2, $ref3, $string3, $res3, $ref4, $string4, $res4]);
?>
		<? if($string1 === $res1 && $string2 === $res2 && $string3 === $res3 && $string4 === $res4 && $strings["test1"] === $res1 && $strings["test2"] === $res2): ?>
		<div class="testpassed">prepareForDB - correct</div>
		<? else: ?>
		<div class="testfailed">prepareForDB - error</div>
		<? endif; ?>

	</div>

	<div class="tests getPostPassword">
		<h3>getPostPassword</h3>


<?
// prepareForHTML

$ref1 = "test æøå %€&§$ \\\"\' < >(){}[]?!*`´@/\\\\ test";
$res1 = "test æøå %€&§$ \"' < >(){}[]?!*`´@/\\ test";

$ref2 = "test <script> test <> test";
$res2 = "test <script> test <> test";

$ref3 = "test alert(\'hej\'); test";
$res3 = "test alert('hej'); test";

$ref4 = "test <span>test</span> test";
$res4 = "test <span>test</span> test";

$string1 = prepareForHTML($ref1);
$string2 = prepareForHTML($ref2);
$string3 = prepareForHTML($ref3);
$string4 = prepareForHTML($ref4);

$strings = prepareForHTML(["test1" => $ref1, "test2" => $ref2]);
?>
		<? if($string1 === $res1 && $string2 === $res2 && $string3 === $res3 && $string4 === $res4 && $strings["test1"] === $res1 && $strings["test2"] === $res2): ?>
		<div class="testpassed">prepareForHTML - correct</div>
		<? else: ?>
		<div class="testfailed">prepareForHTML - error</div>
		<? endif; ?>

	</div>

	<div class="tests stripDisallowed">
		<h3>stripDisallowed</h3>


<?
// stripDisallowed
$ref1 = "test æøå %€&§$ \"' < >(){}[]?!*`´@/\\ test";
$res1 = "test æøå %€&§$ \"' < >(){}[]?!*`´@/\\ test";

$ref2 = "test <script> test <> test";
$res2 = "test  test  test";

$ref3 = "test <script>alert('hej');</script> test";
$res3 = "test alert('hej'); test";

$ref4 = 'test <span class="test" style="color: red;">test</span> test';
$res4 = "test <span class=\"test\">test</span> test";

$ref5 = 'test <a href="abc">test</a> test <a href="javascript:test();">test</a> test <a href="/abc">test</a> test <a href="http://abc">test</a> test <a href="https://abc">test</a> test <a href="mailto:abc">test</a> test <a href="tel:abc">test</a> test';
$res5 = 'test <a>test</a> test <a>test</a> test <a href="/abc">test</a> test <a href="http://abc">test</a> test <a href="https://abc">test</a> test <a href="mailto:abc">test</a> test <a href="tel:abc">test</a> test';

$string1 = stripDisallowed($ref1);
$string2 = stripDisallowed($ref2);
$string3 = stripDisallowed($ref3);
$string4 = stripDisallowed($ref4);
$string5 = stripDisallowed($ref5);
	
?>
		<? if($string1 === $res1 && $string2 === $res2 && $string3 === $res3 && $string4 === $res4 && $string5 === $res5): ?>
		<div class="testpassed">stripDisallowed - correct</div>
		<? else: ?>
		<div class="testfailed">stripDisallowed - error</div>
		<? endif; ?>

	</div>


	<div class="tests shorthands">
		<h3>Class shorthands</h3>

<?
$dom_class = DOM();
?>
		<? if(is_a($dom_class, "DOM")): ?>
		<div class="testpassed">DOM() - correct</div>
		<? else: ?>
		<div class="testfailed">DOM() - error</div>
		<? endif; ?>


<?
$mailer_class = mailer();
?>
		<? if(is_a($mailer_class, "MailGateway")): ?>
		<div class="testpassed">mailer() - correct</div>
		<? else: ?>
		<div class="testfailed">mailer() - error</div>
		<? endif; ?>


<?
$payment_class = payments();
?>
		<? if(is_a($payment_class, "PaymentGateway")): ?>
		<div class="testpassed">payments() - correct</div>
		<? else: ?>
		<div class="testfailed">payments() - error</div>
		<? endif; ?>


	</div>

</div>