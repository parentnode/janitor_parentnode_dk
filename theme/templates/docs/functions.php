<div class="scene docpage i:docpage">
	<h1>Global functions</h1>
	<p>General purpose functions, globally available.</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="getPost">
				<div class="header">
					<h3>getPost</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getPost</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|false</span> =
								getPost(
									<span class="type">String</span> <span class="var">$which</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get and sanitize the value of <span class="var">$which</span> from the $_POST array.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$which</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> index to get from $_POST array.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> Sanitized value contained in the <span class="var">$which</span> index of $_POST array. <span class="value">false</span> if index is not set.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>getPost("name")</code>
							<p>Gets the content of $_POST["name"]</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>if...else</li>
								<li>isset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>prepareForDB</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="getPosts">
				<div class="header">
					<h3>getPosts</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getPosts</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|false</span> =
								getPost(
									<span class="type">Array</span> <span class="var">$which</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get and sanitize the values passed in <span class="var">$which</span> from the $_POST array.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$which</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> array of indicies to get from $_POST array.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> array of sanitized values, using the values of <span class="var">$which</span> as indices of $_POST array. <span class="value">false</span> if index is not set.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>getPosts(["name","address"])</code>
							<p>Gets the content of $_POST["name"] and $_POST["address"]</p>
							<code>[
	"name" => "King Kong",
	"address" => "New York City"
]</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>if...else</li>
								<li>foreach</li>
								<li>isset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>prepareForDB</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="getPostPassword">
				<div class="header">
					<h3>getPostPassword</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getPostPassword</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|false</span> =
								getPostPassword(
									<span class="type">String</span> <span class="var">$which</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get the value of <span class="var">$which</span> from the $_POST array – without sanitation. Needed for passwords.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$which</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> index to get from $_POST array.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> value contained in the <span class="var">$which</span> index of $_POST array. <span class="value">false</span> if index is not set.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>getPostPassword("name")</code>
							<p>Gets the content of $_POST["name"]</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>if...else</li>
								<li>isset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>None</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="prepareForDB">
				<div class="header">
					<h3>prepareForDB</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">prepareForDB</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|Array</span> = 
								prepareForDB(
									<span class="type">String|Array</span> <span class="var">$string</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Prepare string for injection in database, by stripping invalid tags and attributes 
							and checking it with the mysqli::escape_string method. This is applied every time 
							you get posted values using <span class="type">getPost</span> or <span class="type">getVar</span>.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$string</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String|Array</span> String or Array of strings to be prepared for database injection.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String|Array</span> Sanitized string or array or strings.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>prepareForDB("Hej &lt;script&gt;alert('Hej');&lt;/script&gt;");</code>
							<p>Returns:</p>
							<code>Hej alert(\'Hej\');</code>
						</div>
						<div class="example">
							<code>prepareForDB("Hej &lt;span&gt;alert(\"Hej\”);&lt;/span&gt;");</code>
							<p>Returns:</p>
							<code>Hej &lt;span&gt;alert(\\\"Hej\\\");&lt;/span&gt;</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>if...else</li>
								<li>is_array</li>
								<li>foreach</li>
								<li>addslashes</li>
								<li>mysqli::escape_string</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>stripDisallowed</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="prepareForHTML">
				<div class="header">
					<h3>prepareForHTML</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">prepareForHTML</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|Array</span> = 
								prepareForHTML(
									<span class="type">String|Array</span> <span class="var">$string</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Prepare an already DB prepared string (or array of strings) for being used in HTML context, 
							by stripping any slashes added during data transaction.
						</p>
						<p>
							This is used if a submitted value needs to be returned to the screen, perhaps due to an error.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$string</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String|Array</span> String or array of strings.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String|Array</span> Sanitized string or array of strings.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>prepareForHTML("Hello \'you\'");</code>
							<p>Returns:</p>
							<code>Hello 'you'</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>is_array</li>
								<li>foreach</li>
								<li>stripslashes</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>none</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="stripDisallowed">
				<div class="header">
					<h3>stripDisallowed</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">stripDisallowed</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								stripDisallowed(
									<span class="type">String</span> <span class="var">$string</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Strips string of potential harmful elements. Content of removed elements, will be kept as text.</p>
						<p>
							Only the following tags are allowed:
							&lt;a&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;sup&gt;, &lt;h1&gt;, &lt;h2&gt;, &lt;h3&gt;, &lt;h4&gt;, &lt;h5&gt;, &lt;h6&gt;, &lt;p&gt;, &lt;label&gt;, &lt;br&gt;, &lt;hr&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;dd&gt;, &lt;dl&gt;, &lt;dt&gt;, &lt;span&gt;, &lt;img&gt;, &lt;div&gt;, &lt;table&gt;, &lt;tr&gt;, &lt;td&gt;, &lt;th&gt;, &lt;code&gt;
						</p>
						<p>
							Only the following attributes are allowed:
							<span class="type">href</span>, <span class="type">class</span>, <span class="type">width</span>, <span class="type">height</span>, <span class="type">alt</span>, <span class="type">charset</span>.
							The href must start with <span class="value">/</span>, <span class="value">http://</span>, <span class="value">https://</span>, <span class="value">mailto:</span>, <span class="value">tel:</span>.
							Otherwise the href property will be removed.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$string</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> String to sanitize
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> Sanitized string</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>stripDisallowed("Hej &lt;script&gt;alert('Hej');&lt;/script&gt;");</code>
							<p>Removes the <span class="type">script</span> tag and returns:</p>
							<code>Hej alert('Hej');</code>
						</div>
						<div class="example">
							<code>stripDisallowed("Hej &lt;span class=&quot;test&quot; style=&quot;color: red;&quot;&gt;Hej&lt;/span&gt;");</code>
							<p>Removed the invalid <span class="type">style</span> attribute and returns:</p>
							<code>Hej &lt;span class=&quot;test&quot;&gt;Hej&lt;/span&gt;</code>
						</div>
						<div class="example">
							<code>stripDisallowed("Hej &lt;a href=&quot;/test&quot;&gt;Hej&lt;/a&gt;");</code>
							<p>Everything valid, returns:</p>
							<code>Hej &lt;a href=&quot;/test&quot;&gt;Hej&lt;/a&gt;</code>
						</div>
						<div class="example">
							<code>stripDisallowed("Hej &lt;a href=&quot;test&quot;&gt;Hej&lt;/a&gt;");</code>
							<p>Removed the invalid relative url and returns:</p>
							<code>Hej &lt;a&gt;Hej&lt;/a&gt;</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>strip_tags</li>
								<li>trim</li>
								<li>html_entity_decode</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>DOM()</li>
								<li>DOM()->createDOM</li>
								<li>DOM()->stripAttributes</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="_functionname_">
				<div class="header">
					<h3>_functionname_</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">_functionname_</dd>
							<dt class="shorthand">Shorthand</dt>
							<dd class="shorthand">_functionshorthand_</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">_returntype_</span> = 
								_functionname_(
									<span class="type">String</span> <span class="var">format</span> 
									[, <span class="type">Mixed</span> <span class="var">timestamp</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>_description_</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">_var_</span></dt>
							<dd>
								<div class="summary">
									<span class="type">_type_</span> _summary_
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">_value_</span></dt>
										<dd>_description_</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">identifier</span></dt>
							<dd>
								<div class="summary">
									<span class="type">_type_</span> _summary_
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">_type_</span> _returnsummary_</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>_function_</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>_function_</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<h2>Class shorthands</h2>
			<p>
				The following are Class shorthand methods design to make certain classes recyclable
				and globally available
			</p>

			<div class="function" id="DOM">
				<div class="header">
					<h3>DOM</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">DOM</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">DOM</span> = 
								DOM();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Includes the DOM class and creates a new instance of the class 
							on first use and reuse this instance for all subsequent uses.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>
						<p>None</p>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">DOM</span> Returns an instance of the DOM class.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>DOM()->createDom($html);</code>
							<p>Returns a DOM object with the content of <span class="var">$html</span>.
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>include_once</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>DOM</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="mailer">
				<div class="header">
					<h3>mailer</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">mailer</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">MailGateway</span> = 
								mailer();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Includes the MailGateway class and creates a new instance of the class 
							on first use and reuse this instance for all subsequent uses.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>
						<p>None</p>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">MailGateway</span> Returns an instance of the MailGateway class.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>mailer()->send($data);</code>
							<p>Sends a mail based on <span class="var">$data</span>.
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>include_once</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>MailGateway</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
