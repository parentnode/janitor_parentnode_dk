	<div class="scene i:scene tests">
	<h1>QR codes</h1>	
	<h2>QR code generator</h2>
	<ul class="actions">
		<?= $HTML->link("Back", "/janitor/tests", array("class" => "button", "wrapper" => "li.back")) ?>
	</ul>

	<div class="tests #method#">
		<h3>QrCodesGateway::create</h3>
		<? 
		if(1 && "create – pass content as string – return QR code as binary string") {

			(function() {
					
				// ARRANGE
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_string.png";

				// ACT
				$output_file = qr_codes()->create("test");
				
				// ASSERT 
				if(
					$output_file == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as string – return QR code as binary string – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as string – return QR code as binary string – error</p></div>
				<? endif; 
				
				// CLEAN UP
	
			})();
		}
		if(1 && "create – pass content as number – return QR code as binary string") {

			(function() {
					
				// ARRANGE
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_number.png";

				// ACT
				$output_file = qr_codes()->create(100);
				
				// ASSERT 
				if(
					$output_file == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as number – return QR code as binary string – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as number – return QR code as binary string – error</p></div>
				<? endif; 
				
				// CLEAN UP
	
			})();
		}
		if(1 && "create – pass content as array – return QR code as binary string") {

			(function() {
					
				// ARRANGE
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_array.png";

				// ACT
				$output_file = qr_codes()->create(["a" => 1, "b" => 2]);
				
				// ASSERT 
				if(
					$output_file == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as array – return QR code as binary string – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as array – return QR code as binary string – error</p></div>
				<? endif; 
				
				// CLEAN UP
	
			})();
		}
		if(1 && "create – pass content as string; pass custom format (svg) – return QR code as binary string") {

			(function() {
					
				// ARRANGE
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_string.svg";

				// ACT
				$output_file = qr_codes()->create("test", ["format" => "svg"]);
				
				// ASSERT 
				if(
					$output_file == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as string; pass custom format (svg) – return QR code as binary string – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as string; pass custom format (svg) – return QR code as binary string – error</p></div>
				<? endif; 
				
				// CLEAN UP
	
			})();
		}
		if(1 && "create – pass content as string; pass filename – save QR code png; return QR code path") {

			(function() {
					
				// ARRANGE
				$filename = LOCAL_PATH."/templates/tests/qr_codes/qr-test.png";
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_string.png";

				// ACT
				$output_file = qr_codes()->create("test", ["output_file" => $filename]);
				
				// ASSERT 
				if(
					$output_file == $filename
					&& file_get_contents($output_file) == file_get_contents($reference) 
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
				$output_file = qr_codes()->create(100, ["output_file" => $filename]);
				
				// ASSERT 
				if(
					$output_file == $filename
					&& file_get_contents($output_file) == file_get_contents($reference) 
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
				$output_file = qr_codes()->create(["a" => 1, "b" => 2], ["output_file" => $filename]);
				
				// ASSERT 
				if(
					$output_file == $filename
					&& file_get_contents($output_file) == file_get_contents($reference) 
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
				$output_file = qr_codes()->create("test", ["output_file" => $filename, "size" => 500]);
				
				// ASSERT 
				if(
					$output_file == $filename
					&& file_get_contents($output_file) == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as string; pass filename; pass custom size – save QR code png with custom size; return QR code path – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as string; pass filename; pass custom size – save QR code png with custom size; return QR code path – error</p></div>
				<? endif; 
				
				// CLEAN UP
				unlink($filename);
	
			})();
		}
		if(1 && "create – pass content as string; pass filename; pass margin false – save QR code png with no margin; return QR code path") {

			(function() {
					
				// ARRANGE
				$filename = LOCAL_PATH."/templates/tests/qr_codes/qr-test.png";
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_string_no_margin.png";

				// ACT
				$output_file = qr_codes()->create("test", ["output_file" => $filename, "margin" => false]);
				
				// ASSERT 
				if(
					$output_file == $filename
					&& file_get_contents($output_file) == file_get_contents($reference) 
				): ?>
				<div class="testpassed"><p>QrCodesGateway::create – pass content as string; pass filename; pass margin false – save QR code png with no margin; return QR code path – correct</p></div>
				<? else: ?>
				<div class="testfailed"><p>QrCodesGateway::create – pass content as string; pass filename; pass margin false – save QR code png with no margin; return QR code path – error</p></div>
				<? endif; 
				
				// CLEAN UP
				unlink($filename);
	
			})();
		}
		// temporarily disabled
		if(0 && "create – pass content as string; pass filename; pass custom colors – save QR code png with custom colors; return QR code path") {

			(function() {
					
				// ARRANGE
				$filename = LOCAL_PATH."/templates/tests/qr_codes/qr-test.png";
				$reference = LOCAL_PATH."/templates/tests/qr_codes/references/qr-test_string_custom_colors.png";

				// ACT
				$output_file = qr_codes()->create("test", [
					"output_file" => $filename, 
					"foreground_color" => ["r" => 255, "g" => 0, "b" => 0, "a" => 0],
					"background_color" => ["r" => 0, "g" => 255, "b" => 0, "a" => 0]
				]);
				
				// ASSERT 
				if(
					$output_file == $filename
					&& file_get_contents($output_file) == file_get_contents($reference) 
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
				$output_file = qr_codes()->create("test", ["output_file" => $filename, "format" => "svg"]);
				
				// ASSERT 
				if(
					$output_file == $filename
					&& file_get_contents($output_file) == file_get_contents($reference) 
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
