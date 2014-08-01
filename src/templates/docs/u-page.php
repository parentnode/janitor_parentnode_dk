<div class="scene docpage i:docpage">
	<h1>Page</h1>
	<p>
		What does the page class handle
	</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="Page::template">
				<div class="header">
					<h3>Page::template</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">template</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">void</span> = 
								Page::template(
									<span class="type">String</span> <span class="var">$template</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Include a template - like the header...better explained)</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$template</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> the path to the wanted template
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">void</span></p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>???</code>
						</div>
					</div>
					
					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::getTitle">
				<div class="header">
					<h3>Page::pageTitle</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getTitle</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|void</span> = 
								Page::pageTitle(
									<span class="type">String</span> <span class="var">$value</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>You can set the title manually via Page::header in your controller. If you don't, I will look for, prioritized:<br>
						- An Item title<br>
						- Tags - and create a list of them<br>
						- A Navigation item title<br>
						- The fallback SITE_NAME<br>
						</p>
					</div>
	

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">String</span></dt>
							<dd>
								<div class="summary">
									<span class="type">$value</span> Set your own page title
								</div>
							</dd>
						</dl>

					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String|void</span> if no $_options it returns the page title.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$this->pageTitle();</code>
							<p>Print the page title.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::pageDescription">
				<div class="header">
					<h3>Page::pageDescription</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">pageDescription</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|void</span> = 
								Page::pageDescription(
									<span class="type">String</span> <span class="var">$value</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get or set the page description</p>
					</div>
						
					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">String</span></dt>
							<dd>
								<div class="summary">
									<span class="type">$value</span> Set your own page description
								</div>
							</dd>
						</dl>
					</div>


					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String|void</span> if no $_options it returns the page description.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$this->pageDesciption();</code>
							<p>Print the page desciption.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::bodyClass">
				<div class="header">
					<h3>Page::bodyClass</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">bodyClass</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String </span> = 
								Page::bodyClass(
									<span class="type">String</span> <span class="var">$value</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get or set the body class</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">String</span></dt>
							<dd>
								<div class="summary">
									<span class="type">$value</span> Set your body class
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String</span> The body class</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$this->bodyClass();</code>
							<p>Print the body class.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::contentClass">
				<div class="header">
					<h3>Page::contentClass</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">contentClass</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String </span> = 
								Page::contentClass(
									<span class="type">String</span> <span class="var">$value</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Set or get content class</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">String</span></dt>
							<dd>
								<div class="summary">
									<span class="type">$value</span> Set your content class
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String</span> The content class</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$this->contentClass();</code>
							<p>Print the content class.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::header">
				<div class="header">
					<h3>Page::header</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">header</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">void </span> = 
								Page::header(
									<span class="type">Array</span> <span class="var">$_options</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Prints the www.header.php</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Array of options
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">type</span></dt>
										<dd>default www</dd>
										<dt><span class="value">body_class</span></dt>
										<dd>Set the body class</dd>
										<dt><span class="value">page_title</span></dt>
										<dd>Set the page title</dd>
										<dt><span class="value">page_descriptiton</span></dt>
										<dd>Set the page description</dd>
										<dt><span class="value">content_class</span></dt>
										<dd>Set the content class</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">void</span></p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$page->header();</code>
							<p>Print the header</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::footer">
				<div class="header">
					<h3>Page::footer</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">footer</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">void</span> = 
								Page::footer(
									<span class="type">Array</span> <span class="var">$_options</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Prints the www.footer.php</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Array of options
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">type</span></dt>
										<dd>default www</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">void</span></p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$page->footer();</code>
							<p>Print the footer</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::language">
				<div class="header">
					<h3>Page::language</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">language</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|false</span> = 
								Page::language(
									<span class="type">String</span> <span class="var">$value</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get/set current language. Default "DA"</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Set ISO language.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String | void</span> The language string</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$this->language()</code>
							<p>Prints the languge</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::country">
				<div class="header">
					<h3>Page::country</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">country</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|false</span> = 
								Page::country(
									<span class="type">String</span> <span class="var">$value</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Set country code in ISO format. Default DK</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Set ISO country.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String | void</span> The country string</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$this->country()</code>
							<p>Prints the country code</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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
			<div class="function" id="Page::currency">
				<div class="header">
					<h3>Page::currency</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">currency</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|void</span> = 
								currency(
									<span class="type">String</span> <span class="var">$value</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get/set currency in ISO format. Default "DKK".</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Set currency in ISO format. 
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String | void</span> The country string</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$this->currency()</code>
							<p>Prints the sessions currency.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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
			<div class="function" id="Page::segment">
				<div class="header">
					<h3>Page::segment</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">segment</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">_returntype_</span> = 
								Page::segment(
									<span class="type">String</span> <span class="var">format</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get/set segment current session (desktop, dekstop_ie, dekstop_light, mobile_light, mobile, mobile_touch, tablet, tv). Calls http://devices.dearapi.com for device detection.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Set the segment?
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String | void</span> The segment string</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$this->segment()</code>
							<p>Prints the sessions segment.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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
			<div class="function" id="Page::actions">
				<div class="header">
					<h3>Page::actions</h3>
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
						<h4>Returns</h4>
						<p><span class="type">_type_</span> _returnsummary_</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::mail">
				<div class="header">
					<h3>Page::mail</h3>
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
						<h4>Returns</h4>
						<p><span class="type">_type_</span> _returnsummary_</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::addLog">
				<div class="header">
					<h3>Page::addLog</h3>
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
						<h4>Returns</h4>
						<p><span class="type">_type_</span> _returnsummary_</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Page::collectNotification">
				<div class="header">
					<h3>Page::collectNotification</h3>
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
						<h4>Returns</h4>
						<p><span class="type">_type_</span> _returnsummary_</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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
