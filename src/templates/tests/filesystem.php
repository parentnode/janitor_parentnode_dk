<?
$fs = new FileSystem();
$fs->copy(LOCAL_PATH."/templates/tests/filesystem-test-structure", PUBLIC_FILE_PATH."/filesystem-test");

?>

<div class="scene tests defaultEdit i:scene">
	<h1>FileSystem</h1>	
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>


	<h2>FileSystem::valid</h2>
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
		$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt") &&
		!$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/level11/.systemfile") &&
		$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/level11/.systemfile", array("include_tempfiles" => true)) &&
		$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("allow_extensions" => "txt")) &&
		!$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("allow_extensions" => "pdf")) &&
		!$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("deny_extensions" => "txt")) &&
		$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("deny_extensions" => "pdf")) &&
		!$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("deny_folders" => "level1")) &&
		$fs->valid(LOCAL_PATH."/templates/tests/filesystem-test-structure/level1/test.txt", array("allow_folders" => "level1"))
	):
	?>
		<div class="correct"><p>FileSystem::valid - correct</p></div>
	<? else: ?>
		<div class="error"><p>FileSystem::valid - error</p></div>
	<? endif; ?>




	<h2>FileSystem::files</h2>
	<?
	$files = $fs->files(PUBLIC_FILE_PATH."/filesystem-test");
	if(count($files) == 4 &&
		str_replace(PUBLIC_FILE_PATH, "", $files[0]) == "/filesystem-test/level1/test.txt" &&
		str_replace(PUBLIC_FILE_PATH, "", $files[1]) == "/filesystem-test/level2/level21/test.jpg" &&
		str_replace(PUBLIC_FILE_PATH, "", $files[2]) == "/filesystem-test/level2/level22/level221/I'm a fake.pdf" &&
		str_replace(PUBLIC_FILE_PATH, "", $files[3]) == "/filesystem-test/level2/level22/test.txt"
	):
		
	?>
		<div class="correct"><p>FileSystem::files (ignore tempfiles) - correct</p></div>
	<? else: ?>
		<div class="error"><p>FileSystem::files (ignore tempfiles) - error</p></div>
	<? endif; ?>


	<?
	$files = $fs->files(PUBLIC_FILE_PATH."/filesystem-test", array("include_tempfiles" => true));
	if(count($files) == 6 &&
		str_replace(PUBLIC_FILE_PATH, "", $files[0]) == "/filesystem-test/level1/level11/.systemfile" &&
		str_replace(PUBLIC_FILE_PATH, "", $files[1]) == "/filesystem-test/level1/level12/_tempfile.txt" &&
		str_replace(PUBLIC_FILE_PATH, "", $files[2]) == "/filesystem-test/level1/test.txt" &&
		str_replace(PUBLIC_FILE_PATH, "", $files[3]) == "/filesystem-test/level2/level21/test.jpg" &&
		str_replace(PUBLIC_FILE_PATH, "", $files[4]) == "/filesystem-test/level2/level22/level221/I'm a fake.pdf" &&
		str_replace(PUBLIC_FILE_PATH, "", $files[5]) == "/filesystem-test/level2/level22/test.txt"
	):
		
	?>
		<div class="correct"><p>FileSystem::files (include tempfiles) - correct</p></div>
	<? else: ?>
		<div class="error"><p>FileSystem::files (include tempfiles) - error</p></div>
	<? endif; ?>

	<?
	$files = $fs->files(PUBLIC_FILE_PATH."/filesystem-test", array("allow_extensions" => "txt,jpg", "deny_folders" => "level21"));
	if(count($files) == 2 &&
		str_replace(PUBLIC_FILE_PATH, "", $files[0]) == "/filesystem-test/level1/test.txt" &&
		str_replace(PUBLIC_FILE_PATH, "", $files[1]) == "/filesystem-test/level2/level22/test.txt"
	):
		
	?>
		<div class="correct"><p>FileSystem::files (allow/deny) - correct</p></div>
	<? else: ?>
		<div class="error"><p>FileSystem::files (allow/deny) - error</p></div>
	<? endif; ?>




	<h2>FileSystem::removeEmptyDirRecursively</h2>
	<?
		// $fs->removeEmptyDirRecursively(PUBLIC_FILE_PATH."/filesystem-test", array("allow_folders" => "level2"));
		//
		// print "\n#\n";
		//
		// $fs->removeEmptyDirRecursively(PUBLIC_FILE_PATH."/filesystem-test", array("allow_folders" => "level1"));
		//
		// print "\n#\n";
		//
		// $fs->removeEmptyDirRecursively(PUBLIC_FILE_PATH."/filesystem-test", array("allow_folders" => "level1", "delete_tempfiles" => true));
		//
		// print "\n#\n";
		//
		// $fs->removeEmptyDirRecursively(PUBLIC_FILE_PATH."/filesystem-test", array("allow_folders" => "level2", "delete_tempfiles" => true));
		//
		// print "\n#\n";
		//
		// $fs->removeEmptyDirRecursively(PUBLIC_FILE_PATH."/filesystem-test", array("deny_folders" => "level2", "delete_tempfiles" => true));
		//
		// print "\n#\n";
		//
		// $fs->removeEmptyDirRecursively(PUBLIC_FILE_PATH."/filesystem-test", array("deny_folders" => "level1", "delete_tempfiles" => true));


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
			<div class="correct"><p>FileSystem::removeEmptyDirRecursively - correct</p></div>
		<? else: ?>
			<div class="error"><p>FileSystem::removeEmptyDirRecursively - error</p></div>
		<? endif; ?>



</div>