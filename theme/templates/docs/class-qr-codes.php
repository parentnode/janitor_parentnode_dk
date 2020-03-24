<div class="scene docpage i:docpage">
	<h1>QR codes</h1>
	<p>Generate QR codes</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="QrCodesGateway::create">
				<div class="header">
					<h3>QrCodesGateway::create</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">QrCodesGateway::create</dd>
							<dt class="shorthand">Shorthand</dt>
							<dd class="shorthand">qr_codes()->create()</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|false</span> = 
								QrCodesGateway::create(
									<span class="type">String</span> <span class="var">$content</span> 
									[, <span class="type">Array|false</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Generate QR code and output as file or string.</p>
						<p>Default setting: output png as binary string, 300x300px, margin 0px, black on white background, </p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$content</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Mixed</span> Array is converted to json-encoded string. Everything else is directly converted to string.
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array|False</span>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">size (Integer)</span></dt>
										<dd>size in px</dd>
										<dt><span class="value">margin (Integer)</span></dt>
										<dd>margin size in px</dd>
										<dt><span class="value">foreground_color (Array)</span></dt>
										<dd>rgba array, e.g. ["r" => 255, "g" => 255, "b" => 255, "a" => 0]</dd>
										<dt><span class="value">background_color (Array)</span></dt>
										<dd>rgba array</dd>
										<dt><span class="value">output_file (String)</span></dt>
										<dd>will save the QR code as the specified filename</dd>
										<dt><span class="value">format (String)</span></dt>
										<dd>png (default) or svg</dd>
									</dl>
								</div>
							</dd>
							
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String|False</span> qr code as binary string or path of saved qr code. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>Generate QR code with the text "test":</p>
							<code>qr_codes->("test");</code>
							<p>Generate QR code with the text '{"a":1,"b":2}':</p>
							<code>qr_codes->(["a" => 1, "b" => 2]);</code>
							<p>Generate QR code with the text "test", size is 500x500px:</p>
							<code>qr_codes->("test", ["size" => 500]);</code>
							<p>Generate QR code with the text "test", saved as specified path:</p>
							<code>qr_codes->("test", ["output_file" => "/srv/sites/parentnode/qr.png"]);</code>
							<p>Generate QR code with the text "test", saved as specified path as svg:</p>
							<code>qr_codes->("test", ["output_file" => "/srv/sites/parentnode/qr.svg", "format" => "svg"]);</code>

						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>QrCodesGateway::init_adapter</li>
								<li>JanitorEndroidQrCodeGenerator::create</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
