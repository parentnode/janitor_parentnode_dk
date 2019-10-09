<div class="scene docpage i:docpage">
	<h1>Janitor HTML Class (JML)</h1>
	<p>
		Janitor Markup is custom markup snippets optimised for the Janitor backend theme. The Janitor HTML class is 
		available in all templates as <span class="var">$JML</span>.
	</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="JanitorHTML::jsMedia">
				<div class="header">
					<h3>JanitorHTML::jsMedia</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">JanitorHTML::jsMedia</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">_returntype_</span> = 
								JanitorHTML::jsMedia(
									<span class="type">String</span> <span class="var">format</span> 
									[, <span class="type">Mixed</span> <span class="var">timestamp</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Provide media info as classVars string. It will get first media element from item, or
							first of <span class="var">variant</span> from item, if variant is specified.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$item</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Item data array, with <span class="var">mediae</span> index populated
								</div>
							</dd>
							<dt><span class="var">$variant</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Optional variant to match when finding media
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> classVars string with media info, empty string en error</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$JML->jsMedia($item, "mediae");</code>
							<p>Might return something like:</p>
							<code> format:jpg variant:mediae-xyzdefgh</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<p>None</p>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Items::getFirstMedia</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="JanitorHTML::jsData">
				<div class="header">
					<h3>JanitorHTML::jsData</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">JanitorHTML::jsData</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								JanitorHTML::jsData(
									<span class="type">Array</span> <span class="var">$_options</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Create data attributes with backend endpoints for JavaScript interfaces.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Array of endpoint areas to include
								</div>
								<div class="details">
									<h5>Available endpoint areas</h5>
									<dl class="options">
										<dt><span class="value">order</span></dt>
										<dd>Endpoint for updating item order</dd>
										<dt><span class="value">tags</span></dt>
										<dd>Endpoint for getting, adding and removing tags</dd>
										<dt><span class="value">media</span></dt>
										<dd>Endpoint for deleting media and updating media name and order</dd>
										<dt><span class="value">comments</span></dt>
										<dd>Endpoint for updating or deleting comments</dd>
										<dt><span class="value">prices</span></dt>
										<dd>Endpoint for deleting prices</dd>
										<dt><span class="value">qna</span></dt>
										<dd>Endpoint for updating or deleting QnA's</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> String of data attributes with all the endpoint related to specifed areas – or all areas if none are defined. Will always add a csrf-token data attribute.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						<p>No examples</p>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>array_search</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session::value</li>
								<li>Page::validPath</li>
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

		</div>
	</div>

</div>
