<div class="scene docpage i:docpage">
	<h1>CurlRequest</h1>
	<p>Making cURL request easy.</p>
	<p>
		The cURL helper class comes with a handy <em>curl</em> function shorthand, that loads and instantiates 
		the helper class automatically and allows you to make cURL request as one-liner commands.
	</p>
	<p>
		The cURL implementation in PHP has some little known behavioural problems. Sending inputs with the request 
		as an array will automatically change the header content-type to <em>multipart/form-data</em>. While the header
		can be forced to a different value using the header array, then the actual sending of values will use the <em>multipart/form-data</em>
		syntax – and that won't work. To get a <em>application/x-www-form-urlencoded</em> header and syntax, the input MUST be sent as a URL-encoded 
		string rather than as an array.
	</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="CurlRequest::request">
				<div class="header">
					<h3>request</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="shorthand">CurlRequest::request()</dd>
							<dt class="shorthand">Shorthand</dt>
							<dd class="name">curl()->request()</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								curl()->request(
									<span class="type">String</span> <span class="var">$url</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Make a cURL request using the PHP cURL implementation. cURL can be used to make complex serverside requests, including POST.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$url</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> The URL to make the request to
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional array of cURL options
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">header</span></dt>
										<dd>The header(s) of the request as an array with fully formed header values.</dd>
										<dt><span class="value">method</span></dt>
										<dd>Method of the request – GET (default), POST, PUT, DELETE, OPTIONS, CONNECT (lowercase values allowed)</dd>
										<dt><span class="value">useragent</span></dt>
										<dd>User-agent to use for the request</dd>
										<dt><span class="value">referer</span></dt>
										<dd>Referer of the request</dd>
										<dt><span class="value">cookie</span></dt>
										<dd>Cookie to send along with the request</dd>
										<dt><span class="value">cookiejar</span></dt>
										<dd>Cookie jar to send along with the request</dd>
										<dt><span class="value">inputs</span></dt>
										<dd>String or array of key/values to send along with the request. <br /><strong>NOTE:</strong> Sending values as array will automatically change header content-type to <em>multipart/form-data</em>. Header can be overwritten via header option, but multipart/form-data syntax will still be used for sending values.</dd>
										<dt><span class="value">debug</span></dt>
										<dd>Enable debug information – request info will be written into theme/library/debug file and response info will be added to response array</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> Array containing response values in an Array with these keys:</p>

						<h5>header</h5>
						<p>Contains the header information of the response.</p>

						<h5>body</h5>
						<p>Contains the response body. This is typically what you are looking for. Equivalent to what you will see in the browser if the request was made directly.</p>

						<h5>curl_error</h5>
						<p>Contains any curl error if such occured.</p>

						<h5>http_code</h5>
						<p>The http response code of the response – like 200 for success, 404 for not found etc.</p>

						<h5>last_url</h5>
						<p>Contains the last accessed url. In some cases the request might be redirected by the receiving server, and the responding url might differ from the requested url. Ie. if your request is redirected to a login page.</p>

						<h5>cookies</h5>
						<p>Contains an array of cookies returned with the reponse.</p>

						<h5>information</h5>
						<p>Optional index only used when <em>debug</em> option is set. Will contain additional information about response for debugging purposes.</p>
						
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>Plain request</h5>
							<code>$response = curl()->request("https://janitor.parentnode.dk");</code>
							<p>Makes a request to https://janitor.parentnode.dk and returns the response values as an Array.</p>
						</div>

						<div class="example">
							<h5>Request with custom headers</h5>
							<code>$response = curl()->request("https://janitor.parentnode.dk", [
	"headers" => [
		"Content-Type: application/x-www-form-urlencoded", 
		"Authorization: Basic XXX"
	]
]);</code>
							<p>Makes a request to https://janitor.parentnode.dk, adding two header values to the request, and returns the response values as an Array.</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>curl_init</li>
								<li>curl_setopt</li>
								<li>curl_exec</li>
								<li>curl_error</li>
								<li>curl_getinfo</li>

								<li>is_string</li>
								<li>strtoupper</li>
								<li>strlen</li>
								<li>substr</li>
								<li>fopen</li>
								<li>fclose</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>None</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
