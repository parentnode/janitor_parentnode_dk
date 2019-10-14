<?
// Processing images, videos and audios might take more then default execution time
set_time_limit(0);

// global $IC;
// global $model;


include_once("classes/helpers/video.class.php");
include_once("classes/helpers/audio.class.php");
include_once("classes/helpers/image.class.php");

include_once("classes/helpers/curl.class.php");

global $videoClass;
global $audioClass;
global $imageClass;

$videoClass = new Video();
$audioClass = new Audio();
$imageClass = new Image();


$fs = new FileSystem();
$fs->copy(LOCAL_PATH."/templates/tests/autoconversion-media", PRIVATE_FILE_PATH."/autoconversion-test");

// Auto conversion test dows not work on windows.
// - Apache crashes when trying to make Imagick object from image just created (possibly the file is locked)
// - This is only a problem in this test scenario – not a practical matter
$os = preg_match("/Darwin/i", PHP_OS) ? "mac" : (preg_match("/win/i", PHP_OS) ? "win" : "unix");


// test image conversion result
function autoconvertImage($asset_variant, $filesize, $width, $height, $format) {
	global $curl;
	global $imageClass;

	$request_url = SITE_URL."/images/autoconversion-test/".$asset_variant;
	$result = $curl->exec($request_url);
	// debug([$result]);

	if($result["http_code"] == 200 && $result['last_url'] == $request_url && file_exists(PUBLIC_FILE_PATH."/autoconversion-test/".$asset_variant)) {

		$info = $imageClass->info(PUBLIC_FILE_PATH."/autoconversion-test/".$asset_variant);
		// debug([$info, $filesize]);
		if(
			$info &&
			$info["filesize"] > $filesize[0] && $info["filesize"] < $filesize[1] &&
			$info["width"] == $width &&
			$info["height"] == $height &&
			preg_match("/".$format."/", $info["format"])
		) {
			return true;
		}

	}
	return false;
}


// test video conversion result
function autoconvertVideo($asset_variant, $filesize, $width, $height, $codec) {
	global $curl;
	global $videoClass;

	$request_url = SITE_URL."/videos/autoconversion-test/".$asset_variant;
	$result = $curl->exec($request_url);
	// debug([$result]);

	if($result["http_code"] == 200 && $result['last_url'] == $request_url && file_exists(PUBLIC_FILE_PATH."/autoconversion-test/".$asset_variant)) {

		$info = $videoClass->info(PUBLIC_FILE_PATH."/autoconversion-test/".$asset_variant);
		// debug([$info, $filesize]);
		if(
			$info &&
			$info["filesize"] > $filesize[0] && $info["filesize"] < $filesize[1] &&
			$info["width"] == $width &&
			$info["height"] == $height &&

			// exact duration may differ sligthly between formats due to codec framerate/keyframe handling
			$info["hours"] == 0 &&
			$info["minutes"] == 0 &&
			$info["seconds"] == 3 &&
			$info["fractions"] < 100 &&
			preg_match("/".$codec."/", $info["codec"])
		) {
			return true;
		}

	}
	return false;
}


// test audio conversion result
function autoconvertAudio($asset_variant, $filesize, $bitrate, $codec) {
	global $curl;
	global $audioClass;

	$request_url = SITE_URL."/audios/autoconversion-test/".$asset_variant;
	$result = $curl->exec($request_url);
	// debug([$result]);

	if($result["http_code"] == 200 && $result['last_url'] == $request_url && file_exists(PUBLIC_FILE_PATH."/autoconversion-test/".$asset_variant)) {

		$info = $audioClass->info(PUBLIC_FILE_PATH."/autoconversion-test/".$asset_variant);
		// debug([$info, $filesize]);
		if(
			$info &&
			$info["filesize"] > $filesize[0] && $info["filesize"] < $filesize[1] &&
			($info["bitrate"] == $bitrate || $info["codec"] == "pcm_s32le") &&

			// exact duration may differ sligthly between formats due to codec framerate/keyframe handling
			$info["hours"] == 0 &&
			$info["minutes"] == 0 &&
			$info["seconds"] == 2 &&
			$info["fractions"] < 600 &&
			$info["fractions"] > 400 &&
			preg_match("/".$codec."/", $info["codec"])
		) {
			return true;
		}

	}
	return false;
}


global $curl;
$curl = new CurlRequest();
$params = array(
	"method" => "GET"
);
$curl->init($params);

?>
<div class="scene i:scene tests">
	<h1>Autoconversion</h1>	

<? if($os != "win"): ?>

	<h2>Media conversion test using the Autoconversion API</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<p>
		Note that output file sizes may differ between platforms, Imagick/FFmpeg versions – occasionally even
		from two different test runs on same machine, depending on overall load. Therefore all tests allow a filesize
		range. It tests fails, consider checking if output size have changed – perhaps due to Imagick/FFmpeg update.
	</p>
	<p>
		Error can also occur in test if offline, and autoconvertion-notifications needs to be sent.
	</p>

	<div class="tests png">
		<h3>Image: png input</h3>
		<?

		if(1 && "png -> png/300x300.png") {

			if(autoconvertImage("png/300x300.png", array(120000, 130000), 300, 300, "png")): ?>
				<div class="testpassed">png -> png (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/png/300x300.png") ?>)</div>
			<? else: ?>
				<div class="testfailed">png -> png (different proportion) - API error</div>
			<? endif;

		}

		if(1 && "png -> png/256x144.png") {

			if(autoconvertImage("png/256x144.png", array(55000, 65000), 256, 144, "png")): ?>
				<div class="testpassed">png -> png (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/png/256x144.png") ?>)</div>
			<? else: ?>
				<div class="testfailed">png -> png (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "png -> png/256x144.jpg") {

			if(autoconvertImage("png/256x144.jpg", array(15000, 25000), 256, 144, "jpg")): ?>
				<div class="testpassed">png -> jpg (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/png/256x144.jpg") ?>)</div>
			<? else: ?>
				<div class="testfailed">png -> jpg (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "png -> png/256x144.gif") {

			if(autoconvertImage("png/256x144.gif", array(25000, 35000), 256, 144, "gif")): ?>
				<div class="testpassed">png -> gif (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/png/256x144.gif") ?>)</div>
			<? else: ?>
				<div class="testfailed">png -> gif (same proportion) - API error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests jpg">
		<h3>Image: jpg input</h3>
		<? 

		if(1 && "jpg -> jpg/300x300.jpg") {
		
			if(autoconvertImage("jpg/300x300.jpg", array(30000, 40000), 300, 300, "jpg")): ?>
				<div class="testpassed">jpg -> jpg (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/jpg/300x300.jpg") ?>)</div>
			<? else: ?>
				<div class="testfailed">jpg -> jpg (different proportion) - API error</div>
			<? endif;

		}

		if(1 && "jpg -> jpg/256x144.jpg") {

			if(autoconvertImage("jpg/256x144.jpg", array(15000, 25000), 256, 144, "jpg")): ?>
				<div class="testpassed">jpg -> png (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/jpg/256x144.jpg") ?>)</div>
			<? else: ?>
				<div class="testfailed">jpg -> png (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "jpg -> jpg/256x144.png") {

			if(autoconvertImage("jpg/256x144.png", array(55000, 65000), 256, 144, "png")): ?>
				<div class="testpassed">jpg -> png (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/jpg/256x144.png") ?>)</div>
			<? else: ?>
				<div class="testfailed">jpg -> png (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "jpg -> jpg/256x144.gif") {

			if(autoconvertImage("jpg/256x144.gif", array(25000, 35000), 256, 144, "gif")): ?>
				<div class="testpassed">jpg -> gif (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/jpg/256x144.gif") ?>)</div>
			<? else: ?>
				<div class="testfailed">jpg -> gif (same proportion) - API error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests gif">
		<h3>Image: gif input</h3>
		<? 

		if(1 && "gif -> gif/300x300.gif") {

			if(autoconvertImage("gif/300x300.gif", array(65000, 75000), 300, 300, "gif")): ?>
				<div class="testpassed">gif -> gif (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/gif/300x300.gif") ?>)</div>
			<? else: ?>
				<div class="testfailed">gif -> gif (different proportion) - API error</div>
			<? endif;

		}

		if(1 && "gif -> gif/256x144.gif") {

			if(autoconvertImage("gif/256x144.gif", array(30000, 35000), 256, 144, "gif")): ?>
				<div class="testpassed">gif -> png (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/gif/256x144.gif") ?>)</div>
			<? else: ?>
				<div class="testfailed">gif -> png (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "gif -> gif/256x144.png") {

			if(autoconvertImage("gif/256x144.png", array(60000, 70000), 256, 144, "png")): ?>
				<div class="testpassed">gif -> png (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/gif/256x144.png") ?>)</div>
			<? else: ?>
				<div class="testfailed">gif -> png (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "gif -> gif/256x144.jpg") {

			if(autoconvertImage("gif/256x144.jpg", array(15000, 25000), 256, 144, "jpg")): ?>
				<div class="testpassed">gif -> jpg (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/gif/256x144.jpg") ?>)</div>
			<? else: ?>
				<div class="testfailed">gif -> jpg (same proportion) - API error</div>
			<? endif;

		}

		?>
	</div>

<? else: ?>
	Image auto conversion <strong>test</strong> does not work on Windows. (Causes Apache to crash on current windows parentNode stack)
<? endif; ?>


	<div class="tests mp4">
		<h3>Video: mp4 input</h3>
		<? 

		if(1 && "mp4 -> mp4/256x144.mp4") {

			if(autoconvertVideo("mp4/256x144.mp4", array(100000, 120000), 256, 144, "h264")): ?>
				<div class="testpassed">mp4 -> mp4 (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/256x144.mp4") ?>)</div>
			<? else: ?>
				<div class="testfailed">mp4 -> mp4 (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "mp4 -> mp4/300x300.mp4") {

			if(autoconvertVideo("mp4/300x300.mp4", array(170000, 190000), 300, 300, "h264")): ?>
				<div class="testpassed">mp4 -> mp4 (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/300x300.mp4") ?>)</div>
			<? else: ?>
				<div class="testfailed">mp4 -> mp4 (different proportion) - API error</div>
			<? endif;

		}

		if(1 && "mp4 -> mp4/256x144.ogv") {

			if(autoconvertVideo("mp4/256x144.ogv", array(130000, 150000), 256, 144, "theora")): ?>
				<div class="testpassed">mp4 -> ogv (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/256x144.ogv") ?>)</div>
			<? else: ?>
				<div class="testfailed">mp4 -> ogv (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "mp4 -> mp4/256x144.mov") {

			if(autoconvertVideo("mp4/256x144.mov", array(220000, 240000), 256, 144, "m2v1")): ?>
				<div class="testpassed">mp4 -> mov (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/256x144.mov") ?>)</div>
			<? else: ?>
				<div class="testfailed">mp4 -> mov (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "mp4 -> mp4/256x144.webm") {

			if(autoconvertVideo("mp4/256x144.webm", array(150000, 170000), 256, 144, "vp8")): ?>
				<div class="testpassed">mp4 -> webm (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/256x144.webm") ?>)</div>
			<? else: ?>
				<div class="testfailed">mp4 -> webm (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "mp4 -> mp4/256x144.3gp") {

			if(autoconvertVideo("mp4/256x144.3gp", array(340000, 360000), 352, 288, "s263")): ?>
				<div class="testpassed">mp4 -> 3gp (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/256x144.3gp") ?>)</div>
			<? else: ?>
				<div class="testfailed">mp4 -> 3gp (same proportion) - API error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests mov">
		<h3>Video: mov input</h3>
		<? 

		if(1 && "mov -> mov/256x144.mov") {

			if(autoconvertVideo("mov/256x144.mov", array(220000, 240000), 256, 144, "m2v1")): ?>
				<div class="testpassed">mov -> mov (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/256x144.mov") ?>)</div>
			<? else: ?>
				<div class="testfailed">mov -> mov (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "mov -> mov/300x300.mov") {

			if(autoconvertVideo("mov/300x300.mov", array(405000, 425000), 300, 300, "m2v1")): ?>
				<div class="testpassed">mov -> mov (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/300x300.mov") ?>)</div>
			<? else: ?>
				<div class="testfailed">mov -> mov (different proportion) - API error</div>
			<? endif;

		}

		if(1 && "mov -> mov/256x144.ogv") {

			if(autoconvertVideo("mov/256x144.ogv", array(135000, 155000), 256, 144, "theora")): ?>
				<div class="testpassed">mov -> ogv (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/256x144.ogv") ?>)</div>
			<? else: ?>
				<div class="testfailed">mov -> ogv (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "mov -> mov/256x144.webm") {

			if(autoconvertVideo("mov/256x144.webm", array(160000, 185000), 256, 144, "vp8")): ?>
				<div class="testpassed">mov -> webm (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/256x144.webm") ?>)</div>
			<? else: ?>
				<div class="testfailed">mov -> webm (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "mov -> mov/256x144.mp4") {

			if(autoconvertVideo("mov/256x144.mp4", array(110000, 130000), 256, 144, "h264")): ?>
				<div class="testpassed">mov -> mp4 (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/256x144.mp4") ?>)</div>
			<? else: ?>
				<div class="testfailed">mov -> mp4 (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "mov -> mov/256x144.3gp") {

			if(autoconvertVideo("mov/256x144.3gp", array(345000, 365000), 352, 288, "s263")): ?>
				<div class="testpassed">mov -> 3gp (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/256x144.3gp") ?>)</div>
			<? else: ?>
				<div class="testfailed">mov -> 3gp (same proportion) - API error</div>
			<? endif;

		}
		
		?>
	</div>

	<div class="tests webm">
		<h3>Video: webm input</h3>
		<? 
		
		if(1 && "webm -> webm/256x144.webm") {

			if(autoconvertVideo("webm/256x144.webm", array(145000, 165000), 256, 144, "vp8")): ?>
				<div class="testpassed">webm -> webm (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/256x144.webm") ?>)</div>
			<? else: ?>
				<div class="testfailed">webm -> webm (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "webm -> webm/300x300.webm") {

			if(autoconvertVideo("webm/300x300.webm", array(275000, 300000), 300, 300, "vp8")): ?>
				<div class="testpassed">webm -> webm (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/300x300.webm") ?>)</div>
			<? else: ?>
				<div class="testfailed">webm -> webm (different proportion) - API error</div>
			<? endif;

		}

		if(1 && "webm -> webm/256x144.ogv") {

			if(autoconvertVideo("webm/256x144.ogv", array(130000, 150000), 256, 144, "theora")): ?>
				<div class="testpassed">webm -> ogv (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/256x144.ogv") ?>)</div>
			<? else: ?>
				<div class="testfailed">webm -> ogv (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "webm -> webm/256x144.mov") {

			if(autoconvertVideo("webm/256x144.mov", array(220000, 240000), 256, 144, "m2v1")): ?>
				<div class="testpassed">webm -> mov (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/256x144.mov") ?>)</div>
			<? else: ?>
				<div class="testfailed">webm -> mov (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "webm -> webm/256x144.mp4") {

			if(autoconvertVideo("webm/256x144.mp4", array(95000, 115000), 256, 144, "h264")): ?>
				<div class="testpassed">webm -> mp4 (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/256x144.mp4") ?>)</div>
			<? else: ?>
				<div class="testfailed">webm -> mp4 (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "webm -> webm/256x144.3gp") {

			if(autoconvertVideo("webm/256x144.3gp", array(350000, 370000), 352, 288, "s263")): ?>
				<div class="testpassed">webm -> 3gp (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/256x144.3gp") ?>)</div>
			<? else: ?>
				<div class="testfailed">webm -> 3gp (same proportion) - API error</div>
			<? endif; 

		}

		?>
	</div>

	<div class="tests ogv">
		<h3>Video: ogv input</h3>
		<? 

		if(1 && "ogv -> ogv/256x144.ogv") {

			if(autoconvertVideo("ogv/256x144.ogv", array(130000, 150000), 256, 144, "theora")): ?>
				<div class="testpassed">ogv -> ogv (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/256x144.ogv") ?>)</div>
			<? else: ?>
				<div class="testfailed">ogv -> ogv (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "ogv -> ogv/300x300.ogv") {

			if(autoconvertVideo("ogv/300x300.ogv", array(280000, 300000), 300, 300, "theora")): ?>
				<div class="testpassed">ogv -> ogv (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/300x300.ogv") ?>)</div>
			<? else: ?>
				<div class="testfailed">ogv -> ogv (different proportion) - API error</div>
			<? endif;

		}

		if(1 && "ogv -> ogv/256x144.webm") {

			if(autoconvertVideo("ogv/256x144.webm", array(150000, 170000), 256, 144, "vp8")): ?>
				<div class="testpassed">ogv -> webm (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/256x144.webm") ?>)</div>
			<? else: ?>
				<div class="testfailed">ogv -> webm (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "ogv -> ogv/256x144.mov") {

			if(autoconvertVideo("ogv/256x144.mov", array(230000, 250000), 256, 144, "m2v1")): ?>
				<div class="testpassed">ogv -> mov (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/256x144.mov") ?>)</div>
			<? else: ?>
				<div class="testfailed">ogv -> mov (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "ogv -> ogv/256x144.mp4") {

			if(autoconvertVideo("ogv/256x144.mp4", array(100000, 120000), 256, 144, "h264")): ?>
				<div class="testpassed">ogv -> mp4 (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/256x144.mp4") ?>)</div>
			<? else: ?>
				<div class="testfailed">ogv -> mp4 (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "ogv -> ogv/256x144.3gp") {

			if(autoconvertVideo("ogv/256x144.3gp", array(360000, 380000), 352, 288, "s263")): ?>
				<div class="testpassed">ogv -> 3gp (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/256x144.3gp") ?>)</div>
			<? else: ?>
				<div class="testfailed">ogv -> 3gp (same proportion) - API error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests 3gp">
		<h3>Video: 3gp input</h3>
		<? 

		if(1 && "3gp -> 3gp/256x144.3gp") {

			if(autoconvertVideo("3gp/256x144.3gp", array(340000, 370000), 352, 288, "s263")): ?>
				<div class="testpassed">3gp -> 3gp (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/256x144.3gp") ?>)</div>
			<? else: ?>
				<div class="testfailed">3gp -> 3gp (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "3gp -> 3gp/100x100.3gp") {

			if(autoconvertVideo("3gp/100x100.3gp", array(65000, 75000), 128, 96, "s263")): ?>
				<div class="testpassed">3gp -> 3gp (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/100x100.3gp") ?>)</div>
			<? else: ?>
				<div class="testfailed">3gp -> 3gp (different proportion) - API error</div>
			<? endif;

		}

		if(1 && "3gp -> 3gp/256x144.webm") {

			if(autoconvertVideo("3gp/256x144.webm", array(155000, 175000), 256, 144, "vp8")): ?>
				<div class="testpassed">3gp -> webm (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/256x144.webm") ?>)</div>
			<? else: ?>
				<div class="testfailed">3gp -> webm (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "3gp -> 3gp/256x144.mov") {

			if(autoconvertVideo("3gp/256x144.mov", array(215000, 235000), 256, 144, "m2v1")): ?>
				<div class="testpassed">3gp -> mov (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/256x144.mov") ?>)</div>
			<? else: ?>
				<div class="testfailed">3gp -> mov (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "3gp -> 3gp/256x144.mp4") {

			if(autoconvertVideo("3gp/256x144.mp4", array(90000, 120000), 256, 144, "h264")): ?>
				<div class="testpassed">3gp -> mp4 (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/256x144.mp4") ?>)</div>
			<? else: ?>
				<div class="testfailed">3gp -> mp4 (same proportion) - API error</div>
			<? endif;

		}

		if(1 && "3gp -> 3gp/256x144.ogv") {

			if(autoconvertVideo("3gp/256x144.ogv", array(130000, 150000), 256, 144, "theora")): ?>
				<div class="testpassed">3gp -> ogv (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/256x144.ogv") ?>)</div>
			<? else: ?>
				<div class="testfailed">3gp -> ogv (same proportion) - API error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests mp3">
		<h3>Audio: mp3 input</h3>
		<? 

		if(1 && "mp3 -> mp3/128.mp3") {

			if(autoconvertAudio("mp3/128.mp3", array(35000, 45000), 128, "mp3")): ?>
				<div class="testpassed">mp3 -> mp3 (same bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp3/128.mp3") ?>)</div>
			<? else: ?>
				<div class="testfailed">mp3 -> mp3 (same bitrate) - API error</div>
			<? endif;

		}

		if(1 && "mp3 -> mp3/64.mp3") {

			if(autoconvertAudio("mp3/64.mp3", array(15000, 25000), 64, "mp3")): ?>
				<div class="testpassed">mp3 -> mp3 (different bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp3/64.mp3") ?>)</div>
			<? else: ?>
				<div class="testfailed">mp3 -> mp3 (different bitrate) - API error</div>
			<? endif;

		}

		if(1 && "mp3 -> mp3/128.ogg") {

			if(autoconvertAudio("mp3/128.ogg", array(30000, 35000), 128, "vorbis")): ?>
				<div class="testpassed">mp3 -> ogg (same bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp3/128.ogg") ?>)</div>
			<? else: ?>
				<div class="testfailed">mp3 -> ogg (same bitrate) - API error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests wav">
		<h3>Audio: wav input</h3>
		<? 

		if(1 && "wav -> wav/128.mp3") {

			if(autoconvertAudio("wav/128.mp3", array(35000, 45000), 128, "mp3")): ?>
				<div class="testpassed">wav -> mp3 - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/wav/128.mp3") ?>)</div>
			<? else: ?>
				<div class="testfailed">wav -> mp3 - API error</div>
			<? endif;

		}

		if(1 && "wav -> wav/64.mp3") {

			if(autoconvertAudio("wav/64.mp3", array(15000, 25000), 64, "mp3")): ?>
				<div class="testpassed">wav -> mp3 - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/wav/64.mp3") ?>)</div>
			<? else: ?>
				<div class="testfailed">wav -> mp3 - API error</div>
			<? endif;

		}

		if(1 && "wav -> wav/128.ogg") {

			if(autoconvertAudio("wav/128.ogg", array(30000, 35000), 128, "vorbis")): ?>
				<div class="testpassed">wav -> ogg - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/wav/128.ogg") ?>)</div>
			<? else: ?>
				<div class="testfailed">wav -> ogg - API error</div>
			<? endif;

		}

		?>
	</div>

	<div class="tests ogg">
		<h3>Audio: ogg input</h3>
		<? 
		
		if(1 && "ogg -> ogg/128.mp3") {

			if(autoconvertAudio("ogg/128.mp3", array(35000, 45000), 128, "mp3")): ?>
				<div class="testpassed">ogg -> mp3 (same bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogg/128.mp3") ?>)</div>
			<? else: ?>
				<div class="testfailed">ogg -> mp3 (same bitrate) - API error</div>
			<? endif;

		}

		if(1 && "ogg -> ogg/64.ogg") {

			if(autoconvertAudio("ogg/64.ogg", array(15000, 25000), 64, "vorbis")): ?>
				<div class="testpassed">ogg -> ogg (different bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogg/64.ogg") ?>)</div>
			<? else: ?>
				<div class="testfailed">ogg -> ogg (different bitrate) - API error</div>
			<? endif;

		}

		if(1 && "ogg -> ogg/128.ogg") {

			if(autoconvertAudio("ogg/128.ogg", array(30000, 35000), 128, "vorbis")): ?>
				<div class="testpassed">ogg -> ogg (same bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogg/128.ogg") ?>)</div>
			<? else: ?>
				<div class="testfailed">ogg -> ogg (same bitrate) - API error</div>
			<? endif; 

		}

		?>
	</div>


	<?
	// cleanup
	$fs->removeDirRecursively(PRIVATE_FILE_PATH."/autoconversion-test");
	$fs->removeDirRecursively(PUBLIC_FILE_PATH."/autoconversion-test");
	?>


</div>