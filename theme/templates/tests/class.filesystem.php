<?
$fs = new FileSystem();
$fs->copy(LOCAL_PATH."/templates/tests/filesystem-test-structure", PUBLIC_FILE_PATH."/filesystem-test");

// delete empty.txt files - they are required to maintain folder structure in GIT repos, but not part of the test
unlink(PUBLIC_FILE_PATH."/filesystem-test/level2/level23/level231/empty.txt");
unlink(PUBLIC_FILE_PATH."/filesystem-test/level2/level23/level232/empty.txt");

function checkFiles($files, $expected) {
	
	foreach($files as $file) {
		$index = array_search(str_replace(PUBLIC_FILE_PATH, "", $file), $expected);
		if($index !== false) {
			array_splice($expected, $index, 1);
		}
	}

	if(count($expected) == 0) {
		return true;
	}

	return false;
	
}

?>

<div class="scene i:scene tests defaultEdit">
	<h1>FileSystem</h1>	
	<h2>Testing filesystem read/write methods</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>FileSystem::makeDirRecursively</h3>
		<? if(file_exists(PUBLIC_FILE_PATH."/filesystem-test/level1/level11")): ?>
		<div class="testpassed"><p>FileSystem::makeDirRecursively - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>FileSystem::makeDirRecursively - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>FileSystem::copy</h3>
		<? if(file_exists(PUBLIC_FILE_PATH."/filesystem-test/level1/test.txt")): ?>
		<div class="testpassed"><p>FileSystem::copy - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>FileSystem::copy - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>FileSystem::valid</h3>
	<?

	// print "1:" . $fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt")."\n";
	// print "2:" . !$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/level11/.systemfile")."," . file_exists(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/level11/.systemfile") . "," . LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/level11/.systemfile" . "\n";
	// print "3:" . $fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/level11/.systemfile", array("include_tempfiles" => true))."\n";
	// print "4:" . $fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("allow_extensions" => "txt"))."\n";
	// print "5:" . !$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("allow_extensions" => "pdf"))."\n";
	// print "6:" . !$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("deny_extensions" => "txt"))."\n";
	// print "7:" . $fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("deny_extensions" => "pdf"))."\n";
	// print "8:" . !$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("deny_folders" => "level1"))."\n";
	// print "9:" . $fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("allow_folders" => "level1"))."\n";
	
		if(
			$fs->valid(PUBLIC_FILE_PATH."/filesystem-test/level1/test.txt") &&
			!$fs->valid(PUBLIC_FILE_PATH."/filesystem-test/level1/level11/.systemfile") &&
			$fs->valid(PUBLIC_FILE_PATH."/filesystem-test/level1/level11/.systemfile", array("include_tempfiles" => true)) &&
			$fs->valid(PUBLIC_FILE_PATH."/filesystem-test/level1/test.txt", array("allow_extensions" => "txt")) &&
			!$fs->valid(PUBLIC_FILE_PATH."/filesystem-test/level1/test.txt", array("allow_extensions" => "pdf")) &&
			!$fs->valid(PUBLIC_FILE_PATH."/filesystem-test/level1/test.txt", array("deny_extensions" => "txt")) &&
			$fs->valid(PUBLIC_FILE_PATH."/filesystem-test/level1/test.txt", array("deny_extensions" => "pdf")) &&
			!$fs->valid(PUBLIC_FILE_PATH."/filesystem-test/level1/test.txt", array("deny_folders" => "level1")) &&
			$fs->valid(PUBLIC_FILE_PATH."/filesystem-test/level1/test.txt", array("allow_folders" => "level1"))
		):
		?>
		<div class="testpassed"><p>FileSystem::valid - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>FileSystem::valid - error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>FileSystem::files</h3>
		<?
		$files = $fs->files(PUBLIC_FILE_PATH."/filesystem-test");
		if(count($files) == 4 && checkFiles($files, array(
			"/filesystem-test/level1/test.txt",
			"/filesystem-test/level2/level21/test.jpg",
			"/filesystem-test/level2/level22/level221/I'm a fake.pdf",
			"/filesystem-test/level2/level22/test.txt"
		))):
		?>
		<div class="testpassed"><p>FileSystem::files (ignore tempfiles) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>FileSystem::files (ignore tempfiles) - error</p></div>
		<? endif; ?>

		<?

		$files = $fs->files(PUBLIC_FILE_PATH."/filesystem-test", array("include_tempfiles" => true));
		if(count($files) == 6 && checkFiles($files, array(
			"/filesystem-test/level1/level11/.systemfile",
			"/filesystem-test/level1/level12/_tempfile.txt",
			"/filesystem-test/level1/test.txt",
			"/filesystem-test/level2/level21/test.jpg",
			"/filesystem-test/level2/level22/level221/I'm a fake.pdf",
			"/filesystem-test/level2/level22/test.txt"
		))):
		
		?>
		<div class="testpassed"><p>FileSystem::files (include tempfiles) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>FileSystem::files (include tempfiles) - error</p></div>
		<? endif; ?>

		<?
		$files = $fs->files(PUBLIC_FILE_PATH."/filesystem-test", array("allow_extensions" => "txt,jpg", "deny_folders" => "level21"));
		if(count($files) == 2 && checkFiles($files, array(
			"/filesystem-test/level1/test.txt",
			"/filesystem-test/level2/level22/test.txt"
		))):
		?>
		<div class="testpassed"><p>FileSystem::files (allow/deny) - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>FileSystem::files (allow/deny) - error</p></div>
		<? endif; ?>
	</div>



	<div class="tests">
		<h3>FileSystem::removeEmptyDirRecursively</h3>
		<?
		$passed = false;

		$fs->removeEmptyDirRecursively(PUBLIC_FILE_PATH."/filesystem-test", array("allow_folders" => "level1"));
		$files = $fs->files(PUBLIC_FILE_PATH."/filesystem-test", array("include_tempfiles" => true));

		if(count($files) == 6 &&
			file_exists(PUBLIC_FILE_PATH."/filesystem-test/level2/level23/level231")
		):


			$fs->removeEmptyDirRecursively(PUBLIC_FILE_PATH."/filesystem-test", array("allow_folders" => "level2", "delete_tempfiles" => true));
			$files = $fs->files(PUBLIC_FILE_PATH."/filesystem-test", array("include_tempfiles" => true));

			if(count($files) == 6 &&
				!file_exists(PUBLIC_FILE_PATH."/filesystem-test/level2/level23/level231") &&
				!file_exists(PUBLIC_FILE_PATH."/filesystem-test/level2/level23/level232")
			):


				$fs->removeEmptyDirRecursively(PUBLIC_FILE_PATH."/filesystem-test", array("allow_folders" => "level1", "delete_tempfiles" => true));
				$files = $fs->files(PUBLIC_FILE_PATH."/filesystem-test", array("include_tempfiles" => true));

				if(count($files) == 4 &&
					!file_exists(PUBLIC_FILE_PATH."/filesystem-test/level1/level11") &&
					!file_exists(PUBLIC_FILE_PATH."/filesystem-test/level1/level12")
				):

					$passed = true;

				endif;

			endif;


			// $files = $fs->files(PUBLIC_FILE_PATH."/filesystem-test");
			// print_r($files);


		endif;

		?>

		<? if($passed): ?>
		<div class="testpassed"><p>FileSystem::removeEmptyDirRecursively - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>FileSystem::removeEmptyDirRecursively - error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>FileSystem::filesize</h3>
		<? if($fs->filesize(PUBLIC_FILE_PATH."/filesystem-test/level2/level21/test.jpg") == "12.23K" && $fs->filesize(PUBLIC_FILE_PATH."/filesystem-test/level1/test.txt") == "16.00B"): ?>
		<div class="testpassed"><p>FileSystem::makeDirRecursively - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>FileSystem::makeDirRecursively - error</p></div>
		<? endif; ?>

	</div>

	<?
	// cleanup
	$fs->removeDirRecursively(PUBLIC_FILE_PATH."/filesystem-test");
	?>

	<div class="tests">
		<h3>FileSystem::removeDirRecursively</h3>
		<? if(!file_exists(PUBLIC_FILE_PATH."/filesystem-test")): ?>
		<div class="testpassed"><p>FileSystem::removeDirRecursively - correct</p></div>
		<? else: ?>
		<div class="testfailed"><p>FileSystem::removeDirRecursively - error</p></div>
		<? endif; ?>

	</div>

</div>