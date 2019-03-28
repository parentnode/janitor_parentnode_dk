<div class="scene docpage i:docpage">
	<h1>Output</h1>
	<p>The Output system class outputs response objects. It currently outputs objects as json, but it is preprared to output different data formats.</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="_functionname_">
				<div class="header">
					<h3>Output::screen</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">screen</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								Output::screen(
									<span class="type">Array|mixed</span> <span class="var">$object</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>
					<div class="description">
						<h4>Description</h4>
						<p> The function outputs data objects as json objects.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$object</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array|mixed</span> The data to be printed.
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">format</span></dt>
										<dd>Is pr default json.</dd>
										<dt><span class="value">type</span></dt>
										<dd>If type is 'error' cms_staus will be set to error. Any posted values will not be returned.</dd>
										<dt><span class="value">reset_messages</span></dt>
										<dd>Reset_messages is per default true. Set to false in order to keep messages.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Void</span> prints out json object.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>Example 1</h5>
							<code>$object = ["user" => "elisabeth", "age" => 27, "gender" => "woman"]
message()->addMessage("Hello, this is Elisabeth");
$output = new Output();
$output->screen($object);</code>
							<p>Outputs data object as json and resets messages in the message class. Output:</p>
							<code>{
	"cms_object":
		{
			"user":"elisabeth",
			"age":27,
			"gender":"woman"
		},
	"cms_status":"success",
	"cms_message":
		{
			"message":[
				"Hello, this is Elisabeth"
			]
		},
	"return_to":false
}</code>
						</div>
						<div class="example">
							<h5>Example 2</h5>
							<code>$object = ["user" => "elisabeth", "age" => 27, "gender" => "woman"]
message()->addMessage("Hello, this is Elisabeth", array("type" => "error"));
$output = new Output();
$output->screen($object, ["type" => "error", "reset_messages" => false]);</code>
							<p>Outputs data object as json with cms_status error. Does not reset messages in the message class. Output:</p>
							<code>{
	"cms_object":
		{
			"user":"elisabeth",
			"age":27,
			"gender":"woman"
		},
		"cms_status":"error",
		"cms_message":[
			"Hello, this is Elisabeth"
		]
}</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Uses</h4>
						
						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>json_encode</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>message()->getMessages</li>
								<li>message()->resetMessages()</li>
								<li>getPost()</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
