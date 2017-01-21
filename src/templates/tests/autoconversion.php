<?
global $IC;
global $model;


include_once("classes/system/video.class.php");
include_once("classes/system/audio.class.php");
include_once("classes/system/image.class.php");

global $videoClass;
global $audioClass;
global $imageClass;

$videoClass = new Video();
$audioClass = new Audio();
$imageClass = new Image();


$fs = new FileSystem();
$fs->copy(LOCAL_PATH."/templates/tests/autoconversion-media", PRIVATE_FILE_PATH."/autoconversion-test");


class CurlRequest {

	private $ch;

	public function init($params) {

		$this->ch = curl_init();
		$user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:31.0) Gecko/20100101 Firefox/31.0';

		@curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		@curl_setopt($this->ch, CURLOPT_VERBOSE, 1);
		@curl_setopt($this->ch, CURLOPT_HEADER, 1);
		@curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
		@curl_setopt($this->ch, CURLOPT_USERAGENT, $user_agent);
		@curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		@curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);

		if(isset($params['header']) && $params['header']) {
			@curl_setopt($this->ch, CURLOPT_HTTPHEADER, $params['header']);
		}

		if($params['method'] == "HEAD") {
			@curl_setopt($this->ch, CURLOPT_NOBODY, 1);
		}

		if($params['method'] == "POST") {
			@curl_setopt($this->ch, CURLOPT_POST, true);
			@curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params['post_fields']);
		}

		if(isset($params['referer'])) {
			@curl_setopt($this->ch, CURLOPT_REFERER, $params['referer']);
		}

		if(isset($params['cookie'])) {
			@curl_setopt($this->ch, CURLOPT_COOKIE, $params['cookie']);
		}

	}

	public function exec($url) {

		@curl_setopt($this->ch, CURLOPT_URL, $url);

		$response = curl_exec($this->ch);
		$error = curl_error($this->ch);

		$result = array(
			'header' => '',
			'body' => '',
			'curl_error' => '',
			'http_code' => '',
			'last_url' => ''
		);

		if($error) {
			$result['curl_error'] = $error;
			return $result;
		}

		$header_size = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
		$result['header'] = substr($response, 0, $header_size);
		$result['body'] = substr($response, $header_size);
		$result['http_code'] = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
		$result['last_url'] = curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL);

		if($result["http_code"] == 200 && $result['last_url'] == $url) {
			return true;
		}
		else {
			return false;
		}

	}
}



// test image conversion result
function autoconvertImage($url, $filesize, $width, $height, $format) {
	global $curl;
	global $imageClass;

	if($curl->exec(SITE_URL."/images/autoconversion-test/".$url) && file_exists(PUBLIC_FILE_PATH."/autoconversion-test/".$url)) {

		$info = $imageClass->info(PUBLIC_FILE_PATH."/autoconversion-test/".$url);
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
function autoconvertVideo($url, $filesize, $width, $height, $codec) {
	global $curl;
	global $videoClass;

	if($curl->exec(SITE_URL."/videos/autoconversion-test/".$url) && file_exists(PUBLIC_FILE_PATH."/autoconversion-test/".$url)) {

		$info = $videoClass->info(PUBLIC_FILE_PATH."/autoconversion-test/".$url);
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


// test video conversion result
function autoconvertAudio($url, $filesize, $bitrate, $codec) {
	global $curl;
	global $audioClass;

	if($curl->exec(SITE_URL."/audios/autoconversion-test/".$url) && file_exists(PUBLIC_FILE_PATH."/autoconversion-test/".$url)) {

		$info = $audioClass->info(PUBLIC_FILE_PATH."/autoconversion-test/".$url);
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
<div class="scene i:scene tests defaultEdit">
	<h1>Autoconversion</h1>	

	<h2>Media conversion test using the Autoconversion API</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests">
		<h3>Image: png input</h3>

		<? if(autoconvertImage("png/300x300.png", array(120000, 130000), 300, 300, "png")): ?>
			<div class="testpassed"><p>png -> png (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/png/300x300.png") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>png -> png (different proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertImage("png/256x144.png", array(55000, 65000), 256, 144, "png")): ?>
			<div class="testpassed"><p>png -> png (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/png/256x144.png") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>png -> png (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertImage("png/256x144.jpg", array(15000, 25000), 256, 144, "jpg")): ?>
			<div class="testpassed"><p>png -> jpg (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/png/256x144.jpg") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>png -> jpg (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertImage("png/256x144.gif", array(25000, 35000), 256, 144, "gif")): ?>
			<div class="testpassed"><p>png -> gif (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/png/256x144.gif") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>png -> gif (same proportion) - API error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>Image: jpg input</h3>

		<? if(autoconvertImage("jpg/300x300.jpg", array(30000, 40000), 300, 300, "jpg")): ?>
			<div class="testpassed"><p>jpg -> jpg (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/jpg/300x300.jpg") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>jpg -> jpg (different proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertImage("jpg/256x144.jpg", array(15000, 25000), 256, 144, "jpg")): ?>
			<div class="testpassed"><p>jpg -> png (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/jpg/256x144.jpg") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>jpg -> png (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertImage("jpg/256x144.png", array(55000, 65000), 256, 144, "png")): ?>
			<div class="testpassed"><p>jpg -> png (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/jpg/256x144.png") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>jpg -> png (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertImage("jpg/256x144.gif", array(25000, 35000), 256, 144, "gif")): ?>
			<div class="testpassed"><p>jpg -> gif (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/jpg/256x144.gif") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>jpg -> gif (same proportion) - API error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>Image: gif input</h3>

		<? if(autoconvertImage("gif/300x300.gif", array(65000, 75000), 300, 300, "gif")): ?>
			<div class="testpassed"><p>gif -> gif (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/gif/300x300.gif") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>gif -> gif (different proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertImage("gif/256x144.gif", array(30000, 35000), 256, 144, "gif")): ?>
			<div class="testpassed"><p>gif -> png (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/gif/256x144.gif") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>gif -> png (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertImage("gif/256x144.png", array(60000, 70000), 256, 144, "png")): ?>
			<div class="testpassed"><p>gif -> png (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/gif/256x144.png") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>gif -> png (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertImage("gif/256x144.jpg", array(15000, 25000), 256, 144, "jpg")): ?>
			<div class="testpassed"><p>gif -> jpg (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/gif/256x144.jpg") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>gif -> jpg (same proportion) - API error</p></div>
		<? endif; ?>
	</div>


	<div class="tests">
		<h3>Video: mp4 input</h3>

		<? if(autoconvertVideo("mp4/256x144.mp4", array(100000, 120000), 256, 144, "h264")): ?>
			<div class="testpassed"><p>mp4 -> mp4 (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/256x144.mp4") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>mp4 -> mp4 (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("mp4/300x300.mp4", array(170000, 190000), 300, 300, "h264")): ?>
			<div class="testpassed"><p>mp4 -> mp4 (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/300x300.mp4") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>mp4 -> mp4 (different proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("mp4/256x144.ogv", array(130000, 150000), 256, 144, "theora")): ?>
			<div class="testpassed"><p>mp4 -> ogv (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/256x144.ogv") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>mp4 -> ogv (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("mp4/256x144.mov", array(220000, 240000), 256, 144, "m2v1")): ?>
			<div class="testpassed"><p>mp4 -> mov (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/256x144.mov") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>mp4 -> mov (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("mp4/256x144.webm", array(150000, 170000), 256, 144, "vp8")): ?>
			<div class="testpassed"><p>mp4 -> webm (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/256x144.webm") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>mp4 -> webm (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("mp4/256x144.3gp", array(340000, 360000), 352, 288, "s263")): ?>
			<div class="testpassed"><p>mp4 -> 3gp (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp4/256x144.3gp") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>mp4 -> 3gp (same proportion) - API error</p></div>
		<? endif; ?>

	</div>


	<div class="tests">
		<h3>Video: mov input</h3>

		<? if(autoconvertVideo("mov/256x144.mov", array(220000, 240000), 256, 144, "m2v1")): ?>
			<div class="testpassed"><p>webm -> mov (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/256x144.mov") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> mov (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("mov/300x300.mov", array(405000, 425000), 300, 300, "m2v1")): ?>
			<div class="testpassed"><p>webm -> mov (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/300x300.mov") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> mov (different proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("mov/256x144.ogv", array(135000, 155000), 256, 144, "theora")): ?>
			<div class="testpassed"><p>webm -> ogv (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/256x144.ogv") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> ogv (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("mov/256x144.webm", array(160000, 180000), 256, 144, "vp8")): ?>
			<div class="testpassed"><p>webm -> webm (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/256x144.webm") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> webm (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("mov/256x144.mp4", array(110000, 130000), 256, 144, "h264")): ?>
			<div class="testpassed"><p>webm -> mp4 (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/256x144.mp4") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> mp4 (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("mov/256x144.3gp", array(345000, 365000), 352, 288, "s263")): ?>
			<div class="testpassed"><p>webm -> 3gp (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mov/256x144.3gp") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> 3gp (same proportion) - API error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>Video: webm input</h3>

		<? if(autoconvertVideo("webm/256x144.webm", array(145000, 165000), 256, 144, "vp8")): ?>
			<div class="testpassed"><p>webm -> webm (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/256x144.webm") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> webm (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("webm/300x300.webm", array(265000, 285000), 300, 300, "vp8")): ?>
			<div class="testpassed"><p>webm -> webm (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/300x300.webm") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> webm (different proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("webm/256x144.ogv", array(130000, 150000), 256, 144, "theora")): ?>
			<div class="testpassed"><p>webm -> ogv (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/256x144.ogv") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> ogv (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("webm/256x144.mov", array(220000, 240000), 256, 144, "m2v1")): ?>
			<div class="testpassed"><p>webm -> mov (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/256x144.mov") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> mov (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("webm/256x144.mp4", array(95000, 115000), 256, 144, "h264")): ?>
			<div class="testpassed"><p>webm -> mp4 (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/256x144.mp4") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> mp4 (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("webm/256x144.3gp", array(350000, 370000), 352, 288, "s263")): ?>
			<div class="testpassed"><p>webm -> 3gp (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/webm/256x144.3gp") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>webm -> 3gp (same proportion) - API error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>Video: ogv input</h3>

		<? if(autoconvertVideo("ogv/256x144.ogv", array(130000, 150000), 256, 144, "theora")): ?>
			<div class="testpassed"><p>ogv -> ogv (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/256x144.ogv") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>ogv -> ogv (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("ogv/300x300.ogv", array(280000, 300000), 300, 300, "theora")): ?>
			<div class="testpassed"><p>ogv -> ogv (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/300x300.ogv") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>ogv -> ogv (different proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("ogv/256x144.webm", array(150000, 170000), 256, 144, "vp8")): ?>
			<div class="testpassed"><p>ogv -> webm (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/256x144.webm") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>ogv -> webm (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("ogv/256x144.mov", array(230000, 250000), 256, 144, "m2v1")): ?>
			<div class="testpassed"><p>ogv -> mov (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/256x144.mov") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>ogv -> mov (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("ogv/256x144.mp4", array(100000, 120000), 256, 144, "h264")): ?>
			<div class="testpassed"><p>ogv -> mp4 (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/256x144.mp4") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>ogv -> mp4 (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("ogv/256x144.3gp", array(360000, 380000), 352, 288, "s263")): ?>
			<div class="testpassed"><p>ogv -> 3gp (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogv/256x144.3gp") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>ogv -> 3gp (same proportion) - API error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>Video: 3gp input</h3>
		
		<? if(autoconvertVideo("3gp/256x144.3gp", array(340000, 360000), 352, 288, "s263")): ?>
			<div class="testpassed"><p>3gp -> 3gp (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/256x144.3gp") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>3gp -> 3gp (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("3gp/100x100.3gp", array(65000, 75000), 128, 96, "s263")): ?>
			<div class="testpassed"><p>3gp -> 3gp (different proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/100x100.3gp") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>3gp -> 3gp (different proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("3gp/256x144.webm", array(155000, 175000), 256, 144, "vp8")): ?>
			<div class="testpassed"><p>3gp -> webm (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/256x144.webm") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>3gp -> webm (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("3gp/256x144.mov", array(215000, 235000), 256, 144, "m2v1")): ?>
			<div class="testpassed"><p>3gp -> mov (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/256x144.mov") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>3gp -> mov (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("3gp/256x144.mp4", array(100000, 120000), 256, 144, "h264")): ?>
			<div class="testpassed"><p>3gp -> mp4 (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/256x144.mp4") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>3gp -> mp4 (same proportion) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertVideo("3gp/256x144.ogv", array(130000, 150000), 256, 144, "theora")): ?>
			<div class="testpassed"><p>3gp -> ogv (same proportion) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/3gp/256x144.ogv") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>3gp -> ogv (same proportion) - API error</p></div>
		<? endif; ?>
	</div>



	<div class="tests">
		<h3>Audio: mp3 input</h3>

		<? if(autoconvertAudio("mp3/128.mp3", array(35000, 45000), 128, "mp3")): ?>
			<div class="testpassed"><p>mp3 -> mp3 (same bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp3/128.mp3") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>mp3 -> mp3 (same bitrate) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertAudio("mp3/64.mp3", array(15000, 25000), 64, "mp3")): ?>
			<div class="testpassed"><p>mp3 -> mp3 (different bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp3/64.mp3") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>mp3 -> mp3 (different bitrate) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertAudio("mp3/128.ogg", array(30000, 35000), 128, "vorbis")): ?>
			<div class="testpassed"><p>mp3 -> ogg (same bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/mp3/128.ogg") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>mp3 -> ogg (same bitrate) - API error</p></div>
		<? endif; ?>

	</div>

	<div class="tests">
		<h3>Audio: wav input</h3>

		<? if(autoconvertAudio("wav/128.mp3", array(35000, 45000), 128, "mp3")): ?>
			<div class="testpassed"><p>wav -> mp3 - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/wav/128.mp3") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>wav -> mp3 - API error</p></div>
		<? endif; ?>

		<? if(autoconvertAudio("wav/64.mp3", array(15000, 25000), 64, "mp3")): ?>
			<div class="testpassed"><p>wav -> mp3 - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/wav/64.mp3") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>wav -> mp3 - API error</p></div>
		<? endif; ?>

		<? if(autoconvertAudio("wav/128.ogg", array(30000, 35000), 128, "vorbis")): ?>
			<div class="testpassed"><p>wav -> ogg - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/wav/128.ogg") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>wav -> ogg - API error</p></div>
		<? endif; ?>
	</div>

	<div class="tests">
		<h3>Audio: ogg input</h3>

		<? if(autoconvertAudio("ogg/128.mp3", array(35000, 45000), 128, "mp3")): ?>
			<div class="testpassed"><p>ogg -> mp3 (same bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogg/128.mp3") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>ogg -> mp3 (same bitrate) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertAudio("ogg/64.ogg", array(15000, 25000), 64, "vorbis")): ?>
			<div class="testpassed"><p>ogg -> ogg (different bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogg/64.ogg") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>ogg -> ogg (different bitrate) - API error</p></div>
		<? endif; ?>

		<? if(autoconvertAudio("ogg/128.ogg", array(30000, 35000), 128, "vorbis")): ?>
			<div class="testpassed"><p>ogg -> ogg (same bitrate) - correct (<?= $fs->filesize(PUBLIC_FILE_PATH."/autoconversion-test/ogg/128.ogg") ?>)</p></div>
		<? else: ?>
			<div class="testfailed"><p>ogg -> ogg (same bitrate) - API error</p></div>
		<? endif; ?>
	</div>


	<?
	// cleanup
//	$fs->removeDirRecursively(PRIVATE_FILE_PATH."/autoconversion-test");
//	$fs->removeDirRecursively(PUBLIC_FILE_PATH."/autoconversion-test");
	?>
	
</div>