<?
$model = new Model();
?>

<div class="scene i:scene tests">
	<h1>Model</h1>	
	<h2>Core Janitor Model class</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">


<?
// Add to elements to model to perform test
$model->addToModel("password", ["type" => "password"]);
$model->addToModel("name", ["type" => "string"]);


$_POST["user_id"] = 1;
$_POST["name"] = "Test name";
$_POST["password"] = "æøå<span>#€%&!/()";
$_POST["html"] = "<p>æøå<script>#€%&!/()</script></p>";
$_FILES["mediae"] = ["tmp_name" => "Test file name"];

$model->getPostedEntities();
	
?>
		<? if(
			$model->getProperty("user_id", "value") == 1 &&
			$model->getProperty("name", "value") == "Test name" &&
			$model->getProperty("password", "value") == "æøå<span>#€%&!/()" &&
			$model->getProperty("html", "value") == "<p>æøå#€%&!/()</p>" &&
			$model->getProperty("mediae", "value") == "Test file name"
		): ?>
		<div class="testpassed"><p>Model::getPostedEntities - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>Model::getPostedEntities - error</p></div>
		<? endif; ?>
	</div>

</div>