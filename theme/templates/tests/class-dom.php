<?
$ref_dom_string1 = '<div class="test" style="color: red;"><script>alert(\'hallo\')</script></div>';
$res_dom_string1_a = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body><div class="test" style="color: red;"><script>alert(\'hallo\')</script></div></body></html>';
$res_dom_string1_b = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html><head><meta></head><body><div class="test"><script>alert(\'hallo\')</script></div></body></html>';

$ref_dom_string2 = '<a class="test" href="/test">test æøå</a>';
$res_dom_string2 = 'test æøå';

$ref_dom_string3 = '<html><body class="bodytest"><a class="test" href="/test">test æøå</a> <a class="test" href="/test">test æøå</a></body></html>';


$ref_dom_string4 = '<body class="bodytest"><a class="test" href="test">test æøå</a></body>';

$ref_dom_string5 = '<a class="test" href="https://test">test æøå</a></body>';

?>

<div class="scene i:scene tests">
	<h1>DOM</h1>	
	<h2>Janitor DOM implementation</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests createDom">
		<h3>DOM::createDom</h3>


<?
// createDom
$dom1 = DOM()->createDom($ref_dom_string1);
// debug([$dom1->body, $res_dom_string1, $dom1->saveHTML()]);

$dom2 = DOM()->createDom($ref_dom_string2);
// debug([$dom2->body, $res_dom_string2, $dom2->saveHTML(), $dom2->body->firstChild->attributes, $dom2->body->firstChild->getAttribute("href")->name]);

$dom3 = DOM()->createDom($ref_dom_string3);
// debug([$dom3->body, $res_dom_string3, $dom3->saveHTML(), $dom3->body->childNodes->length]);

$dom4 = DOM()->createDom($ref_dom_string4);
// debug([$dom4->body, $res_dom_string4, $dom4->saveHTML()]);
	
?>
		<? if(
			$dom1->body && trim($dom1->saveHTML()) == $res_dom_string1_a 
			
			&&
			
			$dom2->body->childNodes->length == 1 && $dom2->body->firstChild->nodeName == "a" &&
			$dom2->body->textContent === $res_dom_string2 && 
			$dom2->body->firstChild->getAttribute("class") == "test" &&
			$dom2->body->firstChild->getAttribute("href") == "/test"
				
			&&

			$dom3->body->childNodes->length == 3 && $dom3->body->getAttribute("class") == "bodytest" &&
			$dom3->body->firstChild->nodeName == "a"
				
			&&

			$dom4->body->childNodes->length == 1 && $dom3->body->getAttribute("class") == "bodytest" &&
			$dom4->body->firstChild->nodeName == "a"
		
		
		): ?>
		<div class="testpassed">DOM()->createDom - correct</div>
		<? else: ?>
		<div class="testfailed">DOM()->createDom - error</div>
		<? endif; ?>

	</div>

	<div class="tests stripAttributes">
		<h3>DOM::stripAttributes</h3>


<?
// stripAttributes
$dom1 = DOM()->createDom($ref_dom_string1);
DOM()->stripAttributes($dom1);
// debug([$dom1->body, $res_dom_string1_b, $dom1->saveHTML()]);

$dom4 = DOM()->createDom($ref_dom_string4);
DOM()->stripAttributes($dom4);
// debug([$dom4->body, $res_dom_string4, $dom4->saveHTML()]);

?>
		<? if(
			$dom1->body && trim($dom1->saveHTML()) == $res_dom_string1_b &&
			$dom1->body->firstChild->nodeName == "div"

			&&

			$dom4->body && $dom4->body->firstChild->hasAttribute("class") && !$dom4->body->firstChild->hasAttribute("href")
		
		): ?>
		<div class="testpassed">DOM()->stripAttributes - correct</div>
		<? else: ?>
		<div class="testfailed">DOM()->stripAttributes - error</div>
		<? endif; ?>

	</div>

</div>