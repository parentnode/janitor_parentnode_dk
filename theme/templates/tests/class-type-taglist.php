<?
global $backup;

function backup() {
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
		$backup["all_item_tags"] = false;
		if($query->sql($sql)) {
			$backup["all_item_tags"] = $query->results();
		}

		$sql = "DELETE FROM ".SITE_DB.".tags";
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

function restore() {
// A method to restore the database existed before the testing 
	global $backup;
	include_once("classes/items/taglist.class.php");
	$query = new Query();

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
		if($backup["all_item_tags"]) {
			foreach($backup["all_item_tags"] as $tag) {
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
		if(1 && "getAllTags – Returns all the tags") {
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$test_item_id = $model_tests->createTestItem();
				$query = new Query();

				backup();
				$TC = new Taglist();
				$no_tags = $TC->getAllTags();

				$_POST["tags"] = "test:tag1";
				$model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);

				$_POST["tags"] = "test:tag2";
				$model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);

				// $test_user_id = $model_tests->createTestUser();

				// ACT

				$tags = $TC->getAllTags();

				// ASSERT 
				if(
					$no_tags === false
					&& $tags
                    && count($tags) == 2
                    && $tags[0]["context"] == "test"
                    && $tags[0]["value"] == "tag1"
                    && $tags[1]["context"] == "test"
                    && $tags[1]["value"] == "tag2" 
				): ?>
				<div class="testpassed"><p>Taglist::getAllTags – Returns all the tags – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::getAllTags – Returns all the tags – error</p></div>
				<? endif; 

				// CLEAN UP

				$sql = "DELETE FROM ".SITE_DB.".tags";
				$query->sql($sql);
				//$model_tests->cleanUp(["item_id" => $test_item_id]);
				restore();
			})();
		}
		?>
	</div>

	<div class="tests getTaglists">
		<h3>Taglist::getTaglists</h3>
		<? 
		if(1 && "getTaglists – Returns all the taglists") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				include_once("classes/items/taglist.class.php");
				$query = new Query();
				
				backup();
				$TC = new Taglist();
				$no_taglists = $TC->getTaglists();

				$sql = "INSERT INTO ".SITE_DB.".taglists SET name = 'Test1', handle = 'test1'";
				$query->sql($sql);
				$sql = "INSERT INTO ".SITE_DB.".taglists SET name = 'Test1', handle = 'test2'";
				$query->sql($sql);

				// ACT
				$taglists = $TC->getTaglists();

				// ASSERT 
				if(
					$no_taglists === false
					&& $taglists
					&& count($taglists) == 2
					&& $taglists[0]["name"] == "Test1"
					&& $taglists[0]["handle"] == "test1"
					&& $taglists[1]["name"] == "Test1"
					&& $taglists[1]["handle"] == "test2" 
				): ?>
				<div class="testpassed"><p>Taglist::getTaglists – Returns all the taglists – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::getTaglists – Returns all the taglists – error</p></div>
				<? endif; 

				// CLEAN UP

				$sql = "DELETE FROM ".SITE_DB.".taglists";
				$query->sql($sql);
				//$model_tests->cleanUp(["item_id" => $test_item_id]);
				restore();
			})();
		}
		?>
	</div>

	<div class="tests getTaglist">
		<h3>Taglist::getTaglist</h3>
		<? 
		if(1 && "getTaglist – One taglist's id or handle is sent in the parameter – Returns the corresponding taglist") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");
				$query = new Query();
				
				backup();
				$TC = new Taglist();
				$no_taglist1 = $TC->getTaglist(array("handle"=>"test1"));
				$no_taglist2 = $TC->getTaglist(array("handle"=>"test1"));

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
					$no_taglist1 === false
					&& $no_taglist2 === false
					&& $taglist1
					&& $taglist2
                    && $taglist1["name"] == "Test1"
                    && $taglist1["handle"] == "test1"
                    && $taglist2["name"] == "Test2"
                    && $taglist2["handle"] == "test2"
				): ?>
				<div class="testpassed"><p>Taglist::getTaglist – One taglist's id or handle is sent in the parameter – Returns the corresponding taglist – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::getTaglist – One taglist's id or handle is sent in the parameter – Returns the corresponding taglist – error</p></div>
				<? endif; 

				// CLEAN UP

				$sql = "DELETE FROM ".SITE_DB.".taglists";
				$query->sql($sql);
				//$model_tests->cleanUp(["item_id" => $test_item_id]);
				restore();
			})();
		}
		?>
	</div>

	<div class="tests addTaglistTag">
		<h3>Taglist::addTaglistTag</h3>
		<? 
		if(1 && "addTaglistTag – An array of parameters is sent – Returns true when the corresponding tag is added to the corresponding taglist") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE
				include_once("classes/items/taglist.class.php");
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$test_item_id = $model_tests->createTestItem();
				$query = new Query();

				backup();
				$TC = new Taglist();
				$no_taglist_tag = $TC->addTaglistTag(["addTaglistTag", 200, 100]);

				$_POST["tags"] = "test:tag1";
				$tag1 = $model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);
				//$sql = "SELECT id FROM ".SITE_DB.".tags"

				$_POST["tags"] = "test:tag2";
				$tag2 = $model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);

				$sql = "INSERT INTO ".SITE_DB.".taglists SET name = 'Test1', handle = 'test1'";
				if($query->sql($sql)) {
					$taglist_id = $query->lastInsertId();
				}

				// ACT
				$TC->addTaglistTag(["addTaglistTag", $taglist_id, $tag1["tag_id"]]);
				$TC->addTaglistTag(["addTaglistTag", $taglist_id, $tag2["tag_id"]]);

				$sql = "SELECT * FROM ".SITE_DB.".taglist_tags";
				$taglist_tags = false;
				if($query->sql($sql)) {
					$taglist_tags = $query->results();
				}

				$sql = "SELECT tags.context, tags.value FROM ".SITE_DB.".tags, ".SITE_DB.".taglist_tags WHERE tags.id = taglist_tags.tag_id AND taglist_tags.taglist_id = $taglist_id";
				$tags = false;
				if($query->sql($sql)) {
					$tags = $query->results();
				}

				// ASSERT 
				if(
					$no_taglist_tag === false
					&& $taglist_tags
					&& count($taglist_tags) == 2
					&& $tags[0]["context"] == "test"
					&& $tags[0]["value"] == "tag1"
					&& $tags[1]["context"] == "test"
					&& $tags[1]["value"] == "tag2"
				): ?>
				<div class="testpassed"><p>Taglist::addTaglistTag – An array of parameters is sent – Returns true when the corresponding tag is added to the corresponding taglist – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::addTaglistTag – An array of parameters is sent – Returns true when the corresponding tag is added to the corresponding taglist – error</p></div>
				<? endif; 

				// CLEAN UP

				$sql = "DELETE FROM ".SITE_DB.".taglists";
				$query->sql($sql);

				$sql = "DELETE FROM ".SITE_DB.".tags";
				$query->sql($sql);
				//$model_tests->cleanUp(["item_id" => $test_item_id]);
				restore();
			})();
		}
		?>
	</div>

	<div class="tests removeTaglistTag">
		<h3>Taglist::removeTaglistTag</h3>
		<? 
		if(1 && "removeTaglistTag – An array of parameters is sent – Returns true when the corresponding tag is removed from the corresponding taglist") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE

				include_once("classes/items/taglist.class.php");
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$test_item_id = $model_tests->createTestItem();
				$query = new Query();

				backup(); // backed up and deleted to perform the test in an empty database
				$TC = new Taglist();
				$no_taglist_tag = $TC->removeTaglistTag(["removeTaglistTag", 200, 100]);

				$_POST["tags"] = "test:tag1";
				$tag1 = $model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);

                $_POST["tags"] = "test:tag2";
				$tag2 = $model_tests->addTag(["addTag", $test_item_id]);
                unset($_POST);

				$sql = "INSERT INTO ".SITE_DB.".taglists SET name = 'Test1', handle = 'test1'";
				$tags = false;
				$taglist_tags = false;
				if($query->sql($sql) && $tag1 && $tag2) {
					$taglist_id = $query->lastInsertId();
					$sql = "INSERT INTO ".SITE_DB.".taglist_tags (taglist_id, tag_id) VALUES ($taglist_id, $tag1[tag_id]), ($taglist_id, $tag2[tag_id])";
					if($query->sql($sql)) {
						$sql = "SELECT * FROM ".SITE_DB.".taglist_tags";
						if($query->sql($sql)) {
							$taglist_tags = $query->results();
							if($taglist_tags) {
								$sql = "SELECT tags.id, tags.context, tags.value FROM ".SITE_DB.".tags, ".SITE_DB.".taglist_tags WHERE tags.id = taglist_tags.tag_id AND taglist_tags.taglist_id = $taglist_id";
								if($query->sql($sql)) {
									$tags = $query->results(); // These are tags added to the taglist
								}
							}
						}
					}
				}

				// ACT
				if($tags) {
					$TC->removeTaglistTag(["removeTaglistTag", $taglist_id, $tags[0]["id"]]);
					$TC->removeTaglistTag(["removeTaglistTag", $taglist_id, $tags[1]["id"]]);

					$sql = "SELECT * FROM ".SITE_DB.".taglist_tags WHERE taglist_id = $taglist_id";
					$remove_taglist_tags = false;
					if(!$query->sql($sql)) {
						$remove_taglist_tags = true;
					} 
				}

				// ASSERT 
				if(
					!$no_taglist_tag
					&& $remove_taglist_tags
					&& count($taglist_tags) == 2
					&& $tags[0]["context"] == "test"
					&& $tags[0]["value"] == "tag1"
					&& $tags[1]["context"] == "test"
					&& $tags[1]["value"] == "tag2"
					&& $remove_taglist_tags
				): ?>
				<div class="testpassed"><p>Taglist::removeTaglistTag – An array of parameters is sent – Returns true when the corresponding tag is removed from the corresponding taglist – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::removeTaglistTag – An array of parameters is sent – Returns true when the corresponding tag is removed from the corresponding taglist – error</p></div>
				<? endif; 

				// CLEAN UP

				$sql = "DELETE FROM ".SITE_DB.".taglists";
				$query->sql($sql);

				$sql = "DELETE FROM ".SITE_DB.".tags";
				$query->sql($sql);
				//$model_tests->cleanUp(["item_id" => $test_item_id]);

				restore();
			})();
		}
		?>
	</div>

	<div class="tests updateTaglist">
		<h3>Taglist::updateTaglist</h3>
		<? 
		if(1 && "updateTaglist – An array of parameters is sent – Returns true when the corresponding taglist is updated with the input values") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE

				include_once("classes/items/taglist.class.php");
				$query = new Query();
				$TC = new Taglist();
				backup(); // backed up and deleted to perform the test in an empty database
				$no_taglist = $TC->updateTaglist(["updateTaglist", 200]);

				$sql = "INSERT INTO ".SITE_DB.".taglists SET name = 'Test1', handle = 'test1'";
				if($query->sql($sql)) {
					$taglist_id = $query->lastInsertId();
					$sql = "SELECT * FROM ".SITE_DB.".taglists";
					if($query->sql($sql)) {
						$test_taglist = $query->results();
					}
				}

				// ACT
				if($test_taglist) {
					$_POST["name"] = "testName";
					//unset($_POST);
	
					$_POST["handle"] = "testhandle";
					//unset($_POST);

					$TC->updateTaglist(["updateTaglist", $taglist_id]);
					unset($_POST);

					$sql = "SELECT * FROM ".SITE_DB.".taglists WHERE id = $taglist_id";
					if($query->sql($sql)) {
						$updated_taglist = $query->results();
					} 
				}

				// ASSERT 
				if(
					!$no_taglist
					&& $test_taglist
					&& count($test_taglist) == 1
					&& $test_taglist[0]["name"] == "Test1"
					&& $test_taglist[0]["handle"] == "test1"
					&& $updated_taglist
					&& count($updated_taglist) == 1
					&& $updated_taglist[0]["name"] == "testName"
					&& $updated_taglist[0]["handle"] == "testhandle"
				): ?>
				<div class="testpassed"><p>Taglist::updateTaglist – An array of parameters is sent – Returns true when the corresponding taglist is updated with the input values – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::updateTaglist – An array of parameters is sent – Returns true when the corresponding taglist is updated with the input values – error</p></div>
				<? endif; 

				// CLEAN UP

				$sql = "DELETE FROM ".SITE_DB.".taglists";
				$query->sql($sql);
				//$model_tests->cleanUp(["item_id" => $test_item_id]);

				restore();
			})();
		}
		?>
	</div>

	<div class="tests saveTaglist">
		<h3>Taglist::saveTaglist</h3>
		<? 
		if(1 && "saveTaglist – An array of a single element is sent in the parameter – Returns taglist's id as an array when the corresponding taglist is saved") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE

				include_once("classes/items/taglist.class.php");
				$query = new Query();
				$TC = new Taglist();
				backup(); // backed up and deleted to perform the test in an empty database
				$no_taglist = $TC->saveTaglist(["updateTaglist"]);

				// ACT

					$_POST["name"] = "testName";
					//unset($_POST);

					$taglist_id = $TC->saveTaglist(["saveTaglist"]);
					unset($_POST);

					$sql = "SELECT * FROM ".SITE_DB.".taglists WHERE id = ".$taglist_id["id"];
					if($query->sql($sql)) {
						$taglist = $query->results();
					} 

				// ASSERT 
				if(
					!$no_taglist
					&& $taglist
					&& count($taglist) == 1
					&& $taglist[0]["name"] == "testName"
				): ?>
				<div class="testpassed"><p>Taglist::saveTaglist – An array of a single element is sent in the parameter – Returns taglist's id as an array when the corresponding taglist is saved – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::saveTaglist – An array of a single element is sent in the parameter – Returns taglist's id as an array when the corresponding taglist is saved – error</p></div>
				<? endif; 

				// CLEAN UP

				$sql = "DELETE FROM ".SITE_DB.".taglists";
				$query->sql($sql);
				//$model_tests->cleanUp(["item_id" => $test_item_id]);

				restore();
			})();
		}
		?>
	</div>

	<div class="tests deleteTaglist">
		<h3>Taglist::deleteTaglist</h3>
		<? 
		if(1 && "deleteTaglist – An array of a parameters is sent – Returns true when the corresponding taglist is deleted") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE

				include_once("classes/items/taglist.class.php");
				$query = new Query();
				$TC = new Taglist();
				backup(); // backed up and deleted to perform the test in an empty database
				$no_taglist = $TC->deleteTaglist(["updateTaglist", 400]);

				$sql = "INSERT INTO ".SITE_DB.".taglists SET name = 'testDelete', handle = 'testdelete'";
				$query->sql($sql);
				$sql = "SELECT * FROM ".SITE_DB.".taglists";
				if($query->sql($sql)) {
					$taglist = $query->results();
				}

				// ACT

					$TC->deleteTaglist(["deleteTaglist", $taglist[0]["id"]]);

					$sql = "SELECT * FROM ".SITE_DB.".taglists WHERE id = ".$taglist[0]["id"];
					$taglist_deleted = false;
					if(!$query->sql($sql)) {
						$taglist_deleted = true;
					} 

				// ASSERT 
				if(
					!$no_taglist
					&& $taglist
					&& count($taglist) == 1
					&& $taglist[0]["name"] == "testDelete"
					&& $taglist[0]["handle"] == "testdelete"
					&& $taglist_deleted
				): ?>
				<div class="testpassed"><p>Taglist::deleteTaglist – An array of a parameters is sent – Returns true when the corresponding taglist is deleted – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::deleteTaglist – An array of a parameters is sent – Returns true when the corresponding taglist is deleted – error</p></div>
				<? endif; 

				// CLEAN UP

				$sql = "DELETE FROM ".SITE_DB.".taglists";
				$query->sql($sql);
				//$model_tests->cleanUp(["item_id" => $test_item_id]);

				restore();
			})();
		}
		?>
	</div>

	<div class="tests duplicateTaglist">
		<h3>Taglist::duplicateTaglist</h3>
		<? 
		if(1 && "duplicateTaglist – An array of parameters is sent – Returns the duplicated taglist when the duplication is made on the corresponding taglist") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE

				include_once("classes/items/taglist.class.php");
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$test_item_id = $model_tests->createTestItem();
				$query = new Query();

				backup(); // backed up and deleted to perform the test in an empty database
				$TC = new Taglist();
				$no_taglist = $TC->duplicateTaglist(["removeTaglistTag", 200]);

				$_POST["tags"] = "test:tag1";
				$tag1 = $model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);

                $_POST["tags"] = "test:tag2";
				$tag2 = $model_tests->addTag(["addTag", $test_item_id]);
                unset($_POST);

				$sql = "INSERT INTO ".SITE_DB.".taglists SET name = 'Test1', handle = 'test1'";
				$tags = false;
				//$taglist = false;
				$taglist_tags = false;
				if($query->sql($sql) && $tag1 && $tag2) {
					$taglist_id = $query->lastInsertId();

					$sql = "SELECT * FROM ".SITE_DB.".taglists WHERE id = $taglist_id";
					if($query->sql($sql)) {
						$taglist = $query->result(0);
					}

					$sql = "INSERT INTO ".SITE_DB.".taglist_tags (taglist_id, tag_id) VALUES ($taglist_id, $tag1[tag_id]), ($taglist_id, $tag2[tag_id])";
					if($query->sql($sql)) {
						$sql = "SELECT * FROM ".SITE_DB.".taglist_tags";
						if($query->sql($sql)) {
							$taglist_tags = $query->results();
							if($taglist_tags) {
								$sql = "SELECT tags.id, tags.context, tags.value, taglist_tags.position FROM ".SITE_DB.".tags, ".SITE_DB.".taglist_tags WHERE tags.id = taglist_tags.tag_id AND taglist_tags.taglist_id = $taglist_id ORDER BY taglist_tags.position ASC";
								if($query->sql($sql)) {
									$tags = $query->results(); // These are tags added to the taglist
								}
							}
						}
					}
				}

				// ACT
				if($tags) {
					$TC = new Taglist();
					$duplicated_taglist = $TC->duplicateTaglist(["duplicateTaglist", $taglist_id]);
				}

				// ASSERT 
				if(
					!$no_taglist
					&& count($taglist_tags) == 2
					&& $tags[0]["context"] == "test"
					&& $tags[0]["value"] == "tag1"
					&& $tags[0]["position"] == $duplicated_taglist["tags"][0]["position"]
					&& $tags[1]["context"] == "test"
					&& $tags[1]["value"] == "tag2"
					&& $tags[1]["position"] == $duplicated_taglist["tags"][1]["position"]
					&& $taglist["name"] != $duplicated_taglist["name"]
					&& $taglist["handle"] != $duplicated_taglist["handle"]

				): ?>
				<div class="testpassed"><p>Taglist::duplicateTaglist – An array of parameters is sent – Returns the duplicated taglist when the duplication is made on the corresponding taglist – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::duplicateTaglist – An array of parameters is sent – Returns the duplicated taglist when the duplication is made on the corresponding taglist – error</p></div>
				<? endif; 

				// CLEAN UP

				$sql = "DELETE FROM ".SITE_DB.".taglists";
				$query->sql($sql);

				$sql = "DELETE FROM ".SITE_DB.".tags";
				$query->sql($sql);
				//$model_tests->cleanUp(["item_id" => $test_item_id]);

				restore();
			})();
		}
		?>
	</div>

	<div class="tests updateOrder">
		<h3>Taglist::updateOrder</h3>
		<? 
		if(1 && "updateOrder – An array of parameters is sent – Returns true when the order of the tags of the corresponding taglist is updated") { 
				// #method# – #test conditions# – #expected result#

			(function() {

				// ARRANGE

				include_once("classes/items/taglist.class.php");
				$IC = new Items();
				$model_tests = $IC->typeObject("tests");
				$test_item_id = $model_tests->createTestItem();
				$query = new Query();

				backup(); // backed up and deleted to perform the test in an empty database
				$TC = new Taglist();
				$no_order = $TC->updateOrder(["updateOrder", 200]);

				$_POST["tags"] = "test:tag1";
				$tag1 = $model_tests->addTag(["addTag", $test_item_id]);
				//print_r($tag1);
				unset($_POST);

				$_POST["tags"] = "test:tag2";
				$tag2 = $model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);

				$_POST["tags"] = "test:tag3";
				$tag3 = $model_tests->addTag(["addTag", $test_item_id]);
				unset($_POST);

				$sql = "INSERT INTO ".SITE_DB.".taglists SET name = 'Test1', handle = 'test1'";
				$tags = false;
				$taglist_tags = false;
				if($query->sql($sql) && $tag1 && $tag2 && $tag3) {
					$taglist_id = $query->lastInsertId();

					$sql = "SELECT * FROM ".SITE_DB.".taglists WHERE id = $taglist_id";
					if($query->sql($sql)) {
						$taglist = $query->result(0);
					}

					$sql = "INSERT INTO ".SITE_DB.".taglist_tags (taglist_id, tag_id) VALUES ($taglist_id, $tag1[tag_id]), ($taglist_id, $tag2[tag_id]), ($taglist_id, $tag3[tag_id])";
					if($query->sql($sql)) {
						$sql = "SELECT * FROM ".SITE_DB.".taglist_tags";
						if($query->sql($sql)) {
							$taglist_tags = $query->results();
							if($taglist_tags) {
								$sql = "SELECT tags.id, tags.context, tags.value, taglist_tags.position FROM ".SITE_DB.".tags, ".SITE_DB.".taglist_tags WHERE tags.id = taglist_tags.tag_id AND taglist_tags.taglist_id = $taglist_id";
								if($query->sql($sql)) {
									$tags = $query->results(); // These are tags added to the taglist
									//print_r($tags);
								}
							}
						}
					}
				}

				// ACT
				if($tags) {
					$_POST["order"] = $tag3["tag_id"].", ".$tag2["tag_id"].", ".$tag1["tag_id"];
					$updated = $TC->updateOrder(["updateOrder", $taglist_id]);

					$sql = "SELECT tag_id, position FROM ".SITE_DB.".taglist_tags";
					if($query->sql($sql)) {
						$updated_order_tags = $query->results(); // These are tags added to the taglist
						//print_r($updated_order_tags);
					}
				}

				// ASSERT 
				if(
					!$no_order
					&& $updated
					&& count($taglist_tags) == 3
					&& $tags[0]["context"] == "test"
					&& $tags[0]["value"] == "tag1"
					&& $tags[1]["context"] == "test"
					&& $tags[1]["value"] == "tag2"
					&& $tags[2]["context"] == "test"
					&& $tags[2]["value"] == "tag3"
					&& $updated_order_tags[0]["position"] = 3
					&& $updated_order_tags[1]["position"] = 2
					&& $updated_order_tags[2]["position"] = 1

				): ?>
				<div class="testpassed"><p>Taglist::updateOrder – An array of parameters is sent – Returns true when the order of the tags of the corresponding taglist is updated – correct</p></div>	
				<!-- #Class#::#method# – #test conditions# – #expected result# -->
				<? else: ?>
				<div class="testfailed"><p>Taglist::updateOrder – An array of parameters is sent – Returns true when the order of the tags of the corresponding taglist is updated – error</p></div>
				<? endif; 

				// CLEAN UP

				$sql = "DELETE FROM ".SITE_DB.".taglists";
				$query->sql($sql);

				$sql = "DELETE FROM ".SITE_DB.".tags";
				$query->sql($sql);
				//$model_tests->cleanUp(["item_id" => $test_item_id]);

				restore();
			})();
		}
		?>
	</div>

</div>

