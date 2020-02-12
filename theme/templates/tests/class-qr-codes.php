<div class="scene i:scene tests">
	<h1>QR codes</h1>	
	<h2>QR code generator</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests #method#">
		<h3>QrCodesGateway::create</h3>
		<? 
		if(1 && "create – pass content as string; pass filename – save QR code png; return QR code path") {

			(function() {
					
				// ARRANGE
				$filename = LOCAL_PATH."/templates/tests/qr_codes/qr-test.png";
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_string.png";

				// ACT
				$qr_code_path = qr_codes()->create("test", $filename);
				
				// ASSERT 
				if(
					$qr_code_path == $filename
					&& file_get_contents($qr_code_path) == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as string; pass filename – save QR code png; return QR code path – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as string; pass filename – save QR code png; return QR code path – error</p></div>
				<? endif; 
				
				// CLEAN UP
				unlink($filename);
	
			})();
		}
		if(1 && "create – pass content as number; pass filename – save QR code png; return QR code path") {

			(function() {
					
				// ARRANGE
				$filename = LOCAL_PATH."/templates/tests/qr_codes/qr-test.png";
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_number.png";

				// ACT
				$qr_code_path = qr_codes()->create(100, $filename);
				
				// ASSERT 
				if(
					$qr_code_path == $filename
					&& file_get_contents($qr_code_path) == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as number; pass filename – save QR code png; return QR code path – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as number; pass filename – save QR code png; return QR code path – error</p></div>
				<? endif; 
				
				// CLEAN UP
				unlink($filename);
	
			})();
		}
		if(1 && "create – pass content as array; pass filename – save QR code png; return QR code path") {

			(function() {
					
				// ARRANGE
				$filename = LOCAL_PATH."/templates/tests/qr_codes/qr-test.png";
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_array.png";

				// ACT
				$qr_code_path = qr_codes()->create(["a" => 1, "b" => 2], $filename);
				
				// ASSERT 
				if(
					$qr_code_path == $filename
					&& file_get_contents($qr_code_path) == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as array; pass filename – save QR code png; return QR code path – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as array; pass filename – save QR code png; return QR code path – error</p></div>
				<? endif; 
				
				// CLEAN UP
				unlink($filename);
	
			})();
		}
		if(1 && "create – pass content as string; pass filename; pass custom size – save QR code png with custom size; return QR code path") {

			(function() {
					
				// ARRANGE
				$filename = LOCAL_PATH."/templates/tests/qr_codes/qr-test.png";
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_string_custom_size.png";

				// ACT
				$qr_code_path = qr_codes()->create("test", $filename, ["size" => 500]);
				
				// ASSERT 
				if(
					$qr_code_path == $filename
					&& file_get_contents($qr_code_path) == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as string; pass filename; pass custom size – save QR code png with custom size; return QR code path – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as string; pass filename; pass custom size – save QR code png with custom size; return QR code path – error</p></div>
				<? endif; 
				
				// CLEAN UP
				unlink($filename);
	
			})();
		}
		if(1 && "create – pass content as string; pass filename; pass custom margin size – save QR code png with custom margin size; return QR code path") {

			(function() {
					
				// ARRANGE
				$filename = LOCAL_PATH."/templates/tests/qr_codes/qr-test.png";
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_string_custom_margin.png";

				// ACT
				$qr_code_path = qr_codes()->create("test", $filename, ["margin" => 50]);
				
				// ASSERT 
				if(
					$qr_code_path == $filename
					&& file_get_contents($qr_code_path) == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as string; pass filename; pass custom margin size – save QR code png with custom margin size; return QR code path – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as string; pass filename; pass custom margin size – save QR code png with custom margin size; return QR code path – error</p></div>
				<? endif; 
				
				// CLEAN UP
				unlink($filename);
	
			})();
		}
		if(1 && "create – pass content as string; pass filename; pass custom colors – save QR code png with custom colors; return QR code path") {

			(function() {
					
				// ARRANGE
				$filename = LOCAL_PATH."/templates/tests/qr_codes/qr-test.png";
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_string_custom_colors.png";

				// ACT
				$qr_code_path = qr_codes()->create("test", $filename, [
					"foreground_color" => ["r" => 255, "g" => 0, "b" => 0, "a" => 0],
					"background_color" => ["r" => 0, "g" => 255, "b" => 0, "a" => 0]
				]);
				
				// ASSERT 
				if(
					$qr_code_path == $filename
					&& file_get_contents($qr_code_path) == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as string; pass filename; pass custom colors – save QR code png with custom colors; return QR code path – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as string; pass filename; pass custom colors – save QR code png with custom colors; return QR code path – error</p></div>
				<? endif; 
				
				// CLEAN UP
				unlink($filename);
	
			})();
		}
		if(1 && "create – pass content as string; pass filename; pass custom format (svg) – save QR code svg; return QR code path") {

			(function() {
					
				// ARRANGE
				$filename = LOCAL_PATH."/templates/tests/qr_codes/qr-test.svg";
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_string.svg";

				// ACT
				$qr_code_path = qr_codes()->create("test", $filename, ["format" => "svg"]);
				
				// ASSERT 
				if(
					$qr_code_path == $filename
					&& file_get_contents($qr_code_path) == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as string; pass filename; pass custom format (svg) – save QR code svg; return QR code path – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as string; pass filename; pass custom format (svg) – save QR code svg; return QR code path – error</p></div>
				<? endif; 
				
				// CLEAN UP
				unlink($filename);
	
			})();
		}


		?>
	</div>

</div>
