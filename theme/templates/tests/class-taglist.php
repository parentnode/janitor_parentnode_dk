<?
global $backup;

function backupTags() {
//A method to backup the existing database
	global $backup;
	include_once("classes/items/taglist.class.php");
	$query = new Query();

	$sql = "SELECT * FROM ".SITE_DB.".tags";
	$backup["all_tags"] = false;
	if($query->sql($sql)) {
		$backup["all_tags"] = $query->results();

		$sql = "SELECT * FROM ".SITE_DB.".taglist_tags";
		$backup["all_taglist_tags"] = false;
		if($query->sql($sql)) {
			$backup["all_taglist_tags"] = $query->results();
		}

		$sql = "SELECT * FROM ".SITE_DB.".taggings";
		$backup["all_taggings"] = false;
		if($query->sql($sql)) {
			$backup["all_taggings"] = $query->results();
		}

		$sql = "DELETE FROM ".SITE_DB.".tags";
		$query->sql($sql);
		$sql = "DELETE FROM ".SITE_DB.".taglist_tags";
		$query->sql($sql);
		$sql = "DELETE FROM ".SITE_DB.".taggings";
		$query->sql($sql);
	}

	$sql = "SELECT * FROM ".SITE_DB.".taglists";
	$backup["all_taglists"] = false;
	if($query->sql($sql)) {
		$backup["all_taglists"] = $query->results();
	}
	$sql = "DELETE FROM ".SITE_DB.".taglists";
	$query->sql($sql);

}

function restoreTags() {
// A method to restore the database existed before the testing 
	global $backup;
	include_once("classes/items/taglist.class.php");
	$query = new Query();

	// Clean up the noise created during testing
	$sql = "DELETE FROM ".SITE_DB.".tags";
	$query->sql($sql);
	$sql = "DELETE FROM ".SITE_DB.".taglist_tags";
	$query->sql($sql);
	$sql = "DELETE FROM ".SITE_DB.".taggings";
	$query->sql($sql);
	$sql = "DELETE FROM ".SITE_DB.".taglists";
	$query->sql($sql); // Clean up done

	if($backup["all_taglists"]) {
		foreach($backup["all_taglists"] as $taglist) {
			$sql = "INSERT INTO ".SITE_DB.".taglists SET id = ".$taglist["id"].", name = '".$taglist["name"]."', handle = '".$taglist["handle"]."'";
			$query->sql($sql);
		}
	}

	if($backup["all_tags"]) {
		foreach($backup["all_tags"] as $tag) {
			$sql = "INSERT INTO ".SITE_DB.".tags SET id = ".$tag["id"].", context = '".$tag["context"]."', value = '".$tag["value"]."', description = '".$tag["description"]."'";
			$query->sql($sql);
		}
		if($backup["all_taglist_tags"]) {
			foreach($backup["all_taglist_tags"] as $tag) {
				$sql = "INSERT INTO ".SITE_DB.".taglist_tags SET id = ".$tag["id"].", taglist_id = ".$tag["taglist_id"].", tag_id = ".$tag["tag_id"].", position = ".$tag["position"];
				$query->sql($sql);
			}
		}
		if($backup["all_taggings"]) {
			foreach($backup["all_taggings"] as $tag) {
				$sql = "INSERT INTO ".SITE_DB.".taggings SET id = ".$tag["id"].", item_id = ".$tag["item_id"].", tag_id = ".$tag["tag_id"];
				$query->sql($sql);
			}
		}
	}

}

?>

<div class="scene i:scene tests">
	<h1>Taglist</h1>	
	<h2>Testing Taglist functionality</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests getAllTags">
		<h3>Taglist::getAllTags</h3>
		<? 

		if(1 && "getAllTags – Returns false for no tag in the entire system") {

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");

				backupTags();
				$TC = new Taglist();
				$no_tags = $TC->getAllTags();

				// ASSERT 
				if(
					$no_tags === false 
				): ?>
				<div class="testpassed"><p>Taglist::getAllTags – Returns false for no tag in the entire system – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::getAllTags – Returns false for no tag in the entire system – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();
		}

		if(1 && "getAllTags – Returns all the tags from the entire system") {

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$test_item_id = $model_tests->createTestItem();

				backupTags();
				$TC = new Taglist();

				$_POST["tags"] = "test:tag1";
				$model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);

				$_POST["tags"] = "test:tag2";
				$model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);

				// ACT

				$tags = $TC->getAllTags();

				// ASSERT 
				if(
					$tags
                    && count($tags) == 2
                    && $tags[0]["context"] == "test"
                    && $tags[0]["value"] == "tag1"
                    && $tags[1]["context"] == "test"
                    && $tags[1]["value"] == "tag2" 
				): ?>
				<div class="testpassed"><p>Taglist::getAllTags – Returns all the tags from the entire system – correct</p></div>	
			<? else: ?>
				<div class="testfailed"><p>Taglist::getAllTags – Returns all the tags from the entire system – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();
				$model_tests->cleanUp(["item_id" => $test_item_id]);

			})();
		}

		?>
	</div>

	<div class="tests getTaglists">
		<h3>Taglist::getTaglists</h3>
		<? 

		if(1 && "getTaglists – Get all taglists") { 

			(function() {

				include_once("classes/items/taglist.class.php");
				$query = new Query();
				$TC = new Taglist();
				global $model;

				// ARRANGE
				backupTags();

				$test_taglist_1_id = $model->createTestTaglist("Test taglist 1");
				$test_taglist_2_id = $model->createTestTaglist("Test taglist 2");

				// ACT
				$taglists = $TC->getTaglists();

				// ASSERT 
				if(
					$taglists
					&& count($taglists) == 2
					&& arrayKeyValue($taglists, "name", "Test taglist 1") !== false
					&& arrayKeyValue($taglists, "name", "Test taglist 2") !== false
				): ?>
				<div class="testpassed"><p>Taglist::getTaglists – Get all taglists – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::getTaglists – Get all taglists – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		if(1 && "getTaglists – No taglists – Return false") { 

			(function() {

				include_once("classes/items/taglist.class.php");
				$query = new Query();

				backupTags();
				$TC = new Taglist();


				// ACT
				$taglists = $TC->getTaglists();

				// ASSERT 
				if(
					$taglists === false
				): ?>
				<div class="testpassed"><p>Taglist::getTaglists – No taglists – Return false­ – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::getTaglists – No taglists – Return false­ – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		?>
	</div>

	<div class="tests getTaglist">
		<h3>Taglist::getTaglist</h3>
		<? 

		if(1 && "getTaglist – Send non-existing id and handle – Return false") { 

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");
				$query = new Query();

				backupTags();
				$TC = new Taglist();
				$taglist1 = $TC->getTaglist(array("handle"=>"test1"));
				$taglist2 = $TC->getTaglist(array("id"=>100));

				// ASSERT 
				if(
					$taglist1 === false
					&& $taglist2 === false
				): ?>
				<div class="testpassed"><p>Taglist::getTaglist – Send non-existing id and handle – Return false – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::getTaglist – Send non-existing id and handle – Return false – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();
				//$model_tests->cleanUp(["item_id" => $test_item_id]);
			})();
		}

		if(1 && "getTaglist – Send id or handle – Returns the corresponding taglist") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");
				$query = new Query();
				
				backupTags();
				$TC = new Taglist();

				$sql = "INSERT INTO ".SITE_DB.".taglists SET name = 'Test1', handle = 'test1'";
				$query->sql($sql);
				$sql = "INSERT INTO ".SITE_DB.".taglists SET name = 'Test2', handle = 'test2'";
				$query->sql($sql);
				$taglist_id = $query->lastInsertId();
				
				// ACT
				$taglist1 = $TC->getTaglist(array("handle"=>"test1"));
				//print_r(count($taglist1));
				$taglist2 = $TC->getTaglist(["taglist_id"=>$taglist_id]);
				//print_r($taglist2);

				// ASSERT 
				if(
					$taglist1
					&& $taglist2
                    && $taglist1["name"] == "Test1"
                    && $taglist1["handle"] == "test1"
                    && $taglist2["name"] == "Test2"
                    && $taglist2["handle"] == "test2"
				): ?>
				<div class="testpassed"><p>Taglist::getTaglist – Send id or handle – Returns the corresponding taglist – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::getTaglist – Send id or handle – Returns the corresponding taglist – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		?>
	</div>

	<div class="tests addTaglistTag">
		<h3>Taglist::addTaglistTag</h3>
		<? 

		if(1 && "addTaglistTag – Non-existing taglist – Return false") { 

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");
				global $model;

				backupTags();
				$TC = new Taglist();
				$test_tag_1_id = $model->createTestTag("test", "1");

				// ACT
				$result = $TC->addTaglistTag(["addTaglistTag", 200, $test_tag_1_id]);

				// ASSERT 
				if(
					$result === false
					&& $test_tag_1_id
				): ?>
				<div class="testpassed"><p>Taglist::addTaglistTag – Non-existing taglist – Return false – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::addTaglistTag – Non-existing taglist – Return false – error</p></div>
				<? endif; 

				// CLEAN UP

				restoreTags();

			})();
		}

		if(1 && "addTaglistTag – Non-existing tag – Return false") { 

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");
				$query = new Query();

				backupTags();
				$TC = new Taglist();
				global $model;
				$test_taglist_1_id = $model->createTestTaglist("Test taglist 1");
				
				// ACT
				$result = $TC->addTaglistTag(["addTaglistTag", $test_taglist_1_id, 100]);

				// ASSERT 
				if(
					$test_taglist_1_id
					&& $result === false
				): ?>
				<div class="testpassed"><p>Taglist::addTaglistTag – Non-existing tag – Return false – correct</p></div>	
				<? else: ?>
				<div class="testfailed"><p>Taglist::addTaglistTag – Non-existing tag – Return false – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		if(1 && "addTaglistTag – Send ids for existing tag and taglist – Return true ") { 

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$test_item_id = $model_tests->createTestItem();
				$query = new Query();

				backupTags();
				$TC = new Taglist();

				$_POST["tags"] = "test:tag1";
				$tag1 = $model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);
				//$sql = "SELECT id FROM ".SITE_DB.".tags"

				$_POST["tags"] = "test:tag2";
				$tag2 = $model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);

				$test_taglist_1_id = $model_tests->createTestTaglist("Test taglist 1");

				// ACT
				$TC->addTaglistTag(["addTaglistTag", $test_taglist_1_id, $tag1["tag_id"]]);
				$TC->addTaglistTag(["addTaglistTag", $test_taglist_1_id, $tag2["tag_id"]]);

				// ASSERT 
				$sql = "SELECT * FROM ".SITE_DB.".taglist_tags";
				$taglist_tags = false;
				if($query->sql($sql)) {
					$taglist_tags = $query->results();
				}

				$sql = "SELECT tags.context, tags.value FROM ".SITE_DB.".tags, ".SITE_DB.".taglist_tags WHERE tags.id = taglist_tags.tag_id AND taglist_tags.taglist_id = $test_taglist_1_id";
				$tags = false;
				if($query->sql($sql)) {
					$tags = $query->results();
				}

				if(
					$taglist_tags
					&& count($taglist_tags) == 2
					&& $tags[0]["context"] == "test"
					&& $tags[0]["value"] == "tag1"
					&& $tags[1]["context"] == "test"
					&& $tags[1]["value"] == "tag2"
				): ?>
				<div class="testpassed"><p>Taglist::addTaglistTag – Send ids for existing tag and taglist – Return true – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::addTaglistTag – Send ids for existing tag and taglist – Return true – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();
				$model_tests->cleanUp(["item_id" => $test_item_id]);

			})();

		}

		?>
	</div>

	<div class="tests removeTaglistTag">
		<h3>Taglist::removeTaglistTag</h3>
		<? 

		if(1 && "removeTaglistTag – Non-existing taglist – Return false") { 

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");

				backupTags(); // backed up and deleted to perform the test in an empty database
				$TC = new Taglist();
				
				global $model;
				$test_tag_1_id = $model->createTestTag("test", "1");

				// ACT
				$result = $TC->removeTaglistTag(["removeTaglistTag", 200, $test_tag_1_id]);

				// ASSERT 
				if(
					$test_tag_1_id &&
					$result === false
				): ?>
				<div class="testpassed"><p>Taglist::removeTaglistTag – Non-existing taglist – Return false – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::removeTaglistTag – Non-existing taglist – Return false – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		if(1 && "removeTaglistTag – Non-existing tag – Return false") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				global $model;
				include_once("classes/items/taglist.class.php");
				$TC = new Taglist();

				$test_taglist_1_id = $model->createTestTaglist("Test taglist 1");

				// ACT
				$result = $TC->removeTaglistTag(["removeTaglistTag", $test_taglist_1_id, 100]);

				// ASSERT 
				if(
					$test_taglist_1_id
					&& $result === false
				): ?>
				<div class="testpassed"><p>Taglist::removeTaglistTag – Non-existing tag – Return false – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::removeTaglistTag – Non-existing tag – Return false – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		if(1 && "removeTaglistTag – Send ids for existing taglist and tag – Return true") { 

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				include_once("classes/items/taglist.class.php");
				global $model;
				$TC = new Taglist();
				
				$test_taglist_1_id = $model->createTestTaglist("Test taglist 1");
				
				$test_tag_1_id = $model->createTestTag("test", "1");
				$test_tag_2_id = $model->createTestTag("test", "2");

				$add_result_1 = $TC->addTaglistTag(["addTaglistTag", $test_taglist_1_id, $test_tag_1_id]);
				$add_result_2 = $TC->addTaglistTag(["addTaglistTag", $test_taglist_1_id, $test_tag_2_id]);

				$remove_result_1 = false;
				$remove_result_2 = false;
				
				// ACT
				if($add_result_1 && $add_result_2) {
					$remove_result_1 = $TC->removeTaglistTag(["removeTaglistTag", $test_taglist_1_id, $test_tag_1_id]);
				}

				// ASSERT 
				if(
					$remove_result_1 === true
					&& $remove_result_2 === false
				): ?>
				<div class="testpassed"><p>Taglist::removeTaglistTag – Send ids for existing taglist and tag – Return true – correct</p></div>	
				<? else: ?>
				<div class="testfailed"><p>Taglist::removeTaglistTag – Send ids for existing taglist and tag – Return true – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		?>
	</div>

	<div class="tests updateTaglist">
		<h3>Taglist::updateTaglist</h3>
		<? 

		if(1 && "updateTaglist – Non-existing taglist – Return false") { 

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				include_once("classes/items/taglist.class.php");
				$TC = new Taglist();

				// ACT
				$result = $TC->updateTaglist(["updateTaglist", 200]);

				// ASSERT 
				if(
					$result === false
				): ?>
				<div class="testpassed"><p>Taglist::updateTaglist – Non-existing taglist – Return false – correct</p></div>	
				<? else: ?>
				<div class="testfailed"><p>Taglist::updateTaglist – Non-existing taglist – Return false – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		if(1 && "updateTaglist – Update existing taglist – Return true") { 

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				global $model;
				include_once("classes/items/taglist.class.php");
				$TC = new Taglist();

				$test_taglist_1_id = $model->createTestTaglist("Test taglist 1");
				$test_taglist_1 = $TC->getTaglist(["taglist_id" => $test_taglist_1_id]);
				
				// ACT
				$_POST["name"] = "test_name";
				$_POST["handle"] = "test_handle";
				$TC->updateTaglist(["updateTaglist", $test_taglist_1_id]);
				unset($_POST);
				
				// ASSERT 
				$test_taglist_1_updated = $TC->getTaglist(["taglist_id" => $test_taglist_1_id]);
				if(
					$test_taglist_1
					&& $test_taglist_1_updated
					&& $test_taglist_1 != $test_taglist_1_updated
					&& $test_taglist_1_updated["name"] == "test_name"
					&& $test_taglist_1_updated["handle"] == "test_handle"
				): ?>
				<div class="testpassed"><p>Taglist::updateTaglist – Update existing taglist – Return true – correct</p></div>	
				<? else: ?>
				<div class="testfailed"><p>Taglist::updateTaglist – Update existing taglist – Return true – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		?>
	</div>

	<div class="tests saveTaglist">
		<h3>Taglist::saveTaglist</h3>
		<? 

		if(1 && "saveTaglist – Return taglist_id as an array") { 

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				include_once("classes/items/taglist.class.php");
				$TC = new Taglist();

				// ACT
				$_POST["name"] = "testName";
				$taglist_id = $TC->saveTaglist(["saveTaglist"]);
				unset($_POST);
					

				// ASSERT 
				$taglist = $TC->getTaglist(["taglist_id" => $taglist_id ? $taglist_id["id"] : false]);
				if(
					$taglist
					&& $taglist["name"] == "testName"
				): ?>
				<div class="testpassed"><p>Taglist::saveTaglist – Return taglist_id as an array – correct</p></div>	
				<? else: ?>
				<div class="testfailed"><p>Taglist::saveTaglist – Return taglist_id as an array – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		?>
	</div>

	<div class="tests deleteTaglist">
		<h3>Taglist::deleteTaglist</h3>
		<? 

		if(1 && "deleteTaglist – Non-existing taglist – Return false") { 

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				include_once("classes/items/taglist.class.php");
				$TC = new Taglist();

				$result = $TC->deleteTaglist(["deleteTaglist", 400]);

				// ASSERT 
				if(
					$result === false
				): ?>
				<div class="testpassed"><p>Taglist::deleteTaglist – Non-existing taglist – Return false – correct</p></div>	
				<? else: ?>
				<div class="testfailed"><p>Taglist::deleteTaglist – Non-existing taglist – Return false – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		if(1 && "deleteTaglist – Send existing taglist id – Return true") { 

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				include_once("classes/items/taglist.class.php");
				$TC = new Taglist();
				global $model;

				$test_taglist_1_id = $model->createTestTaglist("Test taglist deletion");

				// ACT
				$deletion_result = $TC->deleteTaglist(["deleteTaglist", $test_taglist_1_id]);

				// ASSERT 
				if(
					$test_taglist_1_id
					&& $deletion_result
				): ?>
				<div class="testpassed"><p>Taglist::deleteTaglist – Send existing taglist id – Return true – correct</p></div>	
				<? else: ?>
				<div class="testfailed"><p>Taglist::deleteTaglist – Send existing taglist id – Return true – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		?>
	</div>

	<div class="tests duplicateTaglist">
		<h3>Taglist::duplicateTaglist</h3>
		<? 

		if(1 && "duplicateTaglist – Non-existing taglist – Return false") { 

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				include_once("classes/items/taglist.class.php");
				$TC = new Taglist();

				// ACT
				$duplication_result = $TC->duplicateTaglist(["duplicateTaglist", 200]);

				// ASSERT 
				if(
					$duplication_result === false
				): ?>
				<div class="testpassed"><p>Taglist::duplicateTaglist – Non-existing taglist – Return false – correct</p></div>	
				<? else: ?>
				<div class="testfailed"><p>Taglist::duplicateTaglist – Non-existing taglist – Return false – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		if(1 && "duplicateTaglist – Duplicate existing taglist – Return the duplicated taglist") { 

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				global $model;
				include_once("classes/items/taglist.class.php");
				$TC = new Taglist();

				$test_tag_1_id = $model->createTestTag("test", "1");
				$test_tag_2_id = $model->createTestTag("test", "2");

				$test_taglist_1_id = $model->createTestTaglist("Test taglist 1");

				$add_result_1 = $TC->addTaglistTag(["addTaglistTag", $test_taglist_1_id, $test_tag_1_id]);
				$add_result_2 = $TC->addTaglistTag(["addTaglistTag", $test_taglist_1_id, $test_tag_2_id]);

				$taglist = $TC->getTaglist(["taglist_id" => $test_taglist_1_id]);
				
				// ACT
				$duplicated_taglist = $TC->duplicateTaglist(["duplicateTaglist", $test_taglist_1_id]);
				
				// ASSERT 
				if(
					$add_result_1 && $add_result_2
					&& $taglist
					&& $duplicated_taglist
					&& $taglist != $duplicated_taglist
					&& $taglist["tags"] == $duplicated_taglist["tags"]
				): ?>
				<div class="testpassed"><p>Taglist::duplicateTaglist – Duplicate existing taglist – Return the duplicated taglist – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>Taglist::duplicateTaglist – Duplicate existing taglist – Return the duplicated taglist – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();

			})();

		}

		?>
	</div>

	<div class="tests updateOrder">
		<h3>Taglist::updateOrder</h3>
		<? 

		if(1 && "updateOrder – Non-existing taglist – Return false") { 

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				include_once("classes/items/taglist.class.php");
				$TC = new Taglist();

				// ACT
				$result = $TC->updateOrder(["updateOrder", 200]);

				// ASSERT 
				if(
					$result === false
				): ?>
				<div class="testpassed"><p>Taglist::updateOrder – Non-existing taglist – Return false – correct</p></div>	
				<? else: ?>
				<div class="testfailed"><p>Taglist::updateOrder – Non-existing taglist – Return false – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();
				message()->resetMessages();

			})();

		}

		if(1 && "updateOrder – Update order of existing taglist – Return true") { 

			(function() {

				// ARRANGE
				backupTags(); // backed up and deleted to perform the test in an empty database

				global $model;
				include_once("classes/items/taglist.class.php");
				$TC = new Taglist();

				$test_tag_1_id = $model->createTestTag("test", "1");
				$test_tag_2_id = $model->createTestTag("test", "2");
				$test_tag_3_id = $model->createTestTag("test", "3");

				$test_taglist_1_id = $model->createTestTaglist("Test taglist 1");

				$add_result_1 = $TC->addTaglistTag(["addTaglistTag", $test_taglist_1_id, $test_tag_1_id]);
				$add_result_2 = $TC->addTaglistTag(["addTaglistTag", $test_taglist_1_id, $test_tag_2_id]);
				$add_result_3 = $TC->addTaglistTag(["addTaglistTag", $test_taglist_1_id, $test_tag_3_id]);

				// ACT
				$_POST["order"] = $test_tag_3_id.", ".$test_tag_2_id.", ".$test_tag_1_id;
				$update_result = $TC->updateOrder(["updateOrder", $test_taglist_1_id]);
				unset($_POST);

				// ASSERT 
				$test_taglist_1 = $TC->getTaglist(["taglist_id" => $test_taglist_1_id]);
				
				if(
					$update_result
					&& $test_taglist_1
					&& count($test_taglist_1["tags"]) == 3
					&& $test_taglist_1["tags"][arrayKeyValue($test_taglist_1["tags"], "value", "1")]["position"] == 3
					&& $test_taglist_1["tags"][arrayKeyValue($test_taglist_1["tags"], "value", "2")]["position"] == 2
					&& $test_taglist_1["tags"][arrayKeyValue($test_taglist_1["tags"], "value", "3")]["position"] == 1

				): ?>
				<div class="testpassed"><p>Taglist::updateOrder – Update order of existing taglist – Return true – correct</p></div>	
				<? else: ?>
				<div class="testfailed"><p>Taglist::updateOrder – Update order of existing taglist – Return true – error</p></div>
				<? endif; 

				// CLEAN UP
				restoreTags();
				message()->resetMessages();

			})();

		}

		?>
	</div>

</div>

