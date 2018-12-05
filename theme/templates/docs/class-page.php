<div class="scene docpage i:docpage">
	<h1>Page</h1>
	<p>
		The Page class is the core controller and template toolset. This class is automatically instatiated and 
		available in $page, after the init file has been included in your controller. It provides all the base
		functionality needed to process a request and output your page and templates.
	</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="Page::sharingMetaData">
				<div class="header">
					<h3>Page::sharingMetaData</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">sharingMetaData</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								Page::sharingMetaData(
									[<span class="type">Item</span> <span class="var">$item</span>]
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get sharing meta data as string (in OG format), for injection in header.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$item</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Item</span> Optional item to get data from. Default is
									the default settings in the config file, using the touch_icon.png as image.
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional options for Metadata
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">title</span></dt>
										<dd>Custom title</dd>
										<dt><span class="value">description</span></dt>
										<dd>Custom description</dd>
										<dt><span class="value">image</span></dt>
										<dd>Custom image</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String</span> The OG Meta tags with title, description, url and image.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						<p>No example</p>
					</div>
					
					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::pageTitle</li>
								<li>Page::pageDescription</li>
								<li>Page::pageImage</li>
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
							<dd class="name">pageTitle</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|void</span> = 
								Page::pageTitle(
									[<span class="type">String</span> <span class="var">$value</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Getter/setter of page title. 
						</p>
						<p>
							Can be used to set page title from inside your templates.
							It is typically used to inject the title in your header template. If no title has been 
							set manually, it will use the SITE_NAME constant defined in you config file.
						</p>
					</div>
	

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">String</span></dt>
							<dd>
								<div class="summary">
									<span class="type">$value</span> Set the page title. If parameter is omitted,
									the defined page title will be returned.
								</div>
							</dd>
						</dl>

					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String|void</span> if no $value is passed, it returns the current page title.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Nothing</li>
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
									[<span class="type">String</span> <span class="var">$value</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Getter/setter of page description.
						</p>
						<p>
							Can be used to set page description from inside your templates.
							It is typically used to inject the description in your header template. If no description has been 
							set manually, it will use the DEFAULT_PAGE_DESCRIPTION constant defined in you config file. If
							DEFAULT_PAGE_DESCRIPTION is not defined, is will return the value from Page::pageTitle.
						</p>
					</div>
						
					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">String</span></dt>
							<dd>
								<div class="summary">
									<span class="type">$value</span> Set the page description. If parameter is omitted,
									the defined page description will be returned.
								</div>
							</dd>
						</dl>
					</div>


					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String|void</span> if no $value is passed, it returns the page description.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::pageTitle</li>
							</ul>
						</div>
					</div>

				</div>
			</div>

			<div class="function" id="Page::pageImage">
				<div class="header">
					<h3>Page::pageImage</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">pageImage</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String|void</span> = 
								Page::pageImage(
									[<span class="type">String</span> <span class="var">$value</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Getter/setter of page image. 
						</p>
						<p>
							Can be used to set page image from inside your templates.
							It is typically used to inject the image as part of your sharing meta data in your header 
							template. If no image has been 
							set manually, it will use the DEFAULT_PAGE_IMAGE constant defined in you config file. If
							DEFAULT_PAGE_IMAGE is not defined, is will use /favicon.png.
						</p>
					</div>
						
					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">String</span></dt>
							<dd>
								<div class="summary">
									<span class="type">$value</span> Set the page image. If parameter is omitted,
									the defined page image will be returned.
								</div>
							</dd>
						</dl>
					</div>


					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String|void</span> if no $value is passed, it returns the page image.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Nothing</li>
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
									[<span class="type">String</span> <span class="var">$value</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Getter/setter of body class. 
						</p>
						<p>
							Can be used to set body class from inside your templates.
							It is used to print the body class in your header 
							template.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">String</span></dt>
							<dd>
								<div class="summary">
									<span class="type">$value</span> Set the body class. If parameter is omitted,
									the defined body class will be returned.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String|void</span> if no $value is passed, it returns the body class.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$this->bodyClass("front");</code>
							<p>Sets the current body class to <span class="value">front</span>.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Nothing</li>
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
									[<span class="type">String</span> <span class="var">$value</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Getter/setter of div#content class. 
						</p>
						<p>
							Can be used to set div#content class from inside your templates.
							It is used to print the div#content class in your header 
							template.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">String</span></dt>
							<dd>
								<div class="summary">
									<span class="type">$value</span> Set the div#content class. If parameter is omitted,
									the defined div#content class will be returned.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String|void</span> if no $value is passed, it returns the div#content class.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$this->contentClass("front");</code>
							<p>Set the div#content class to <span class="value">front</span>.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Nothing</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::headerIncludes">
				<div class="header">
					<h3>Page::headerIncludes</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">headerIncludes</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String </span> = 
								Page::headerIncludes(
									[<span class="type">Array</span> <span class="var">$files</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Getter/setter of header includes. 
						</p>
						<p>
							Can be used to add JavaScript and CSS header includes from inside your templates.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">Array</span></dt>
							<dd>
								<div class="summary">
									<span class="type">$files</span> Add files to the header includes list. If parameter is omitted,
									the added files will be returned as a string of include statements.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String|void</span> if no $files are passed, it returns the includes string.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$this->headerIncludes(array("/js/include_me.js", "/css/include_me.css"));</code>
							<p>Add <span class="value">/js/include_me.js</span> and <span class="value">/css/include_me.css</span> to the document head.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Nothing</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

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
							<dd class="syntax"><span class="type">Sting|rendered PHP</span> = 
								Page::template(
									<span class="type">String</span> <span class="var">$template</span>,
									[<span class="type">Array</span> <span class="var">$_options</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							This is the secondary method for including templates. Use Page::page for automatic
							buffering, and header + footer inclusion.
						</p>
						<p>
							Include a template in your controller.
							Optional setting for buffered output, to enable setting title, body and content class
							later.
						</p>
						<p>
							The path to the template should match a template in either 
							project/src/templates or submodules/janitor/src/templates.
						</p>
						<p>
							If template is found in neither location the error template will be returned instead.
						</p>
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
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional options for Template inclusion
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">buffer</span></dt>
										<dd>Boolean value for buffering - default false</dd>
										<dt><span class="value">error</span></dt>
										<dd>Custom error template - default /templates/404.php</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p>
							<span class="type">String|rendered PHP</span> If buffer is <span class="value">false</span>, the template will be included
							and rendered using a PHP include(). If buffer is <span class="value">true</span>, the include will be buffered for printing
							later.
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>
					
					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Nothing</li>
							</ul>
						</div>
					</div>

				</div>
			</div>

			<div class="function" id="Page::page">
				<div class="header">
					<h3>Page::page</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">page</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								Page::page(
									<span class="type">Array</span> <span class="var">$_options</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							This is the primary method for including templates.
						</p>
						<p>
							Includes a header, template(s) and a footer in your controller.
							
						</p>
						<p>
							The path to the template should match a template in either 
							project/src/templates or submodules/janitor/src/templates.
						</p>
						<p>
							If template is found in neither location the error template will be returned instead.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional options for Template inclusion
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">type</span></dt>
										<dd>Type of header and footer - default www</dd>
										<dt><span class="value">templates</span></dt>
										<dd>Templates to include</dd>
										<dt><span class="value">body_class</span></dt>
										<dd>Custom error body class</dd>
										<dt><span class="value">page_title</span></dt>
										<dd>Custom page title</dd>
										<dt><span class="value">page_descriptiton</span></dt>
										<dd>Custom page description</dd>
										<dt><span class="value">content_class</span></dt>
										<dd>Custom content class</dd>
										<dt><span class="value">error</span></dt>
										<dd>Custom error template - default /templates/404.php</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p>
							<span class="type">Void</span> The header, template(s) and footer will be included
							and rendered using a PHP include().
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>
					
					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::header</li>
								<li>Page::footer</li>
								<li>Page::template</li>
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
									[<span class="type">Array</span> <span class="var">$_options</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Includes a header template. Defaults to templates/www.header.php, but you can specify
							a backend or development (or any custom) header if you want. 
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Array of options
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">buffer</span></dt>
										<dd>Boolean value for buffering - default false</dd>
										<dt><span class="value">type</span></dt>
										<dd>The type of header - default www</dd>
										<dt><span class="value">body_class</span></dt>
										<dd>Custom error body class</dd>
										<dt><span class="value">page_title</span></dt>
										<dd>Custom page title</dd>
										<dt><span class="value">page_descriptiton</span></dt>
										<dd>Custom page description</dd>
										<dt><span class="value">content_class</span></dt>
										<dd>Custom content class</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p>
							<span class="type">String|rendered PHP</span> If buffer is <span class="value">false</span>, the header will be included
							and rendered using a PHP include(). If buffer is <span class="value">true</span>, the include will be buffered for printing
							later.
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::bodyClass</li>
								<li>Page::pageTitle</li>
								<li>Page::pageDescription</li>
								<li>Page::contentClass</li>
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
									[<span class="type">Array</span> <span class="var">$_options</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Includes a footer template. Defaults to templates/www.footer.php, but you can specify
							a backend or development (or any custom) footer if you want. 
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Array of options
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">buffer</span></dt>
										<dd>Boolean value for buffering - default false</dd>
										<dt><span class="value">type</span></dt>
										<dd>The type of header - default www</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p>
							<span class="type">String|rendered PHP</span> If buffer is <span class="value">false</span>, the footer will be included
							and rendered using a PHP include(). If buffer is <span class="value">true</span>, the include will be buffered for printing
							later.
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Nothing</li>
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
									[<span class="type">String</span> <span class="var">$value</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get/set current language. Default should be defined in DEFAULT_LANGUAGE_ISO in config.php</p>
						<p>If you attempt to set invalid language, DEFAULT_LANGUAGE_ISO will be used instead of specified value.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> ISO language to use for session.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String | void</span> The language ISO code of the session</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$page->language();</code>
							<p>Returns current session language, fx: <span class="value">DA</span></p>
						</div>

						<div class="example">
							<code>$page->language("DA");</code>
							<p>Sets current session language to <span class="value">DA</span></p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session</li>
								<li>Query</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::languages">
				<div class="header">
					<h3>Page::languages</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">languages</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Page::languages(
									[<span class="type">String</span> <span class="var">$id</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all available languages in nested Array structure from cache or DB</p>
						<p>Optionally get language details by passing valid language iso value as parameter.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Optional ISO language to get details of.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> nested Array of available languages or specified language details</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						
						<div class="example">
							<h5>Get all languages</h5>
							<code>$page->languages();</code>
							<p>Could returns (depending on available languages):</p>
							<code>Array(
	[0] => array(
		["id"] => "en",
		["name"] => "English"
	),
	[1] => array(
		["id"] => "da",
		["name"] => "Dansk"
	)
)</code>
						</div>

						<div class="example">
							<h5>Get details for specific language</h5>
							<code>$page->languages("DA");</code>
							<p>Returns:</p>
							<code>Array(
	["id"] => "da",
	["name"] => "Dansk"
)</code>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session</li>
								<li>Query</li>
								<li>Cache</li>
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
									[<span class="type">String</span> <span class="var">$value</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get/set current country. Default should be defined in DEFAULT_COUNTRY_ISO in config.php</p>
						<p>If you attempt to set invalid country, DEFAULT_COUNTRY_ISO will be used instead of specified value.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> ISO country to use for session.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String | void</span> The country ISO code of the session</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$page->country();</code>
							<p>Returns current session country, fx: <span class="value">DK</span></p>
						</div>

						<div class="example">
							<code>$page->country("DK");</code>
							<p>Sets current session country to <span class="value">DK</span></p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session</li>
								<li>Query</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::countries">
				<div class="header">
					<h3>Page::countries</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">countries</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Page::countries(
									[<span class="type">String</span> <span class="var">$id</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all available countries in nested Array structure from cache or DB</p>
						<p>Optionally get country details by passing valid country iso value as parameter.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Optional ISO country to get details of.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> nested Array of available countries or specified country details</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						
						<div class="example">
							<h5>Get all countries</h5>
							<code>$page->countries();</code>
							<p>Could returns (depending on available countries):</p>
							<code>Array(
	[0] => array(
		["id"] => "DK",
		["name"] => "Danmark",
		["phone_countrycode"] => 45,
		["phone_format"] => "#### ####",
		["language"] => "DA",
		["currency"] => "DKK"
	),
	[1] => array(
		["id"] => "US",
		["name"] => "USA"
		["phone_countrycode"] => 1,
		["phone_format"] => "### ### ####",
		["language"] => "EN",
		["currency"] => "USD"
	)
)</code>
						</div>

						<div class="example">
							<h5>Get details for specific country</h5>
							<code>$page->countries("DK");</code>
							<p>Returns:</p>
							<code>Array(
	["id"] => "DK",
	["name"] => "Danmark",
	["phone_countrycode"] => 45,
	["phone_format"] => "#### ####",
	["language"] => "DA",
	["currency"] => "DKK"
)</code>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session</li>
								<li>Query</li>
								<li>Cache</li>
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
								Page::currency(
									[<span class="type">String</span> <span class="var">$value</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get/set current currency. Default should be defined in DEFAULT_CURRENCY_ISO in config.php</p>
						<p>If you attempt to set invalid currency, DEFAULT_CURRENCY_ISO will be used instead of specified value.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> ISO currency to use for session.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String | void</span> The currency ISO code of the session</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$page->currency();</code>
							<p>Returns current session currency, fx: <span class="value">DKK</span></p>
						</div>

						<div class="example">
							<code>$page->currency("DKK");</code>
							<p>Sets current session currency to <span class="value">DKK</span></p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session</li>
								<li>Query</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::currencies">
				<div class="header">
					<h3>Page::currencies</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">currencies</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Page::currencies(
									[<span class="type">String</span> <span class="var">$id</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all available currencies in nested Array structure from cache or DB</p>
						<p>Optionally get currency details by passing valid currency iso value as parameter.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Optional ISO currency to get details of.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> nested Array of available currencies or specified currency details</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						
						<div class="example">
							<h5>Get all currencies</h5>
							<code>$page->currencies();</code>
							<p>Could returns (depending on available currencies):</p>
							<code>Array(
	[0] => array(
		["id"] => "DKK",
		["name"] => "Kroner (Denmark)",
		["abbreviation"] => "DKK",
		["abbreviation_position"] => "after",
		["decimals"] => "2",
		["decimal_separator"] => ",",
		["grouping_separator"] => "."
	),
	[1] => array(
		["id"] => "USD",
		["name"] => "US Dollar"
		["abbreviation"] => "$",
		["abbreviation_position"] => "before",
		["decimals"] => "2",
		["decimal_separator"] => ".",
		["grouping_separator"] => ","
	)
)</code>
						</div>

						<div class="example">
							<h5>Get details for specific currency</h5>
							<code>$page->currencies("DKK");</code>
							<p>Returns:</p>
							<code>Array(
	["id"] => "DKK",
	["name"] => "Kroner (Denmark)",
	["abbreviation"] => "DKK",
	["abbreviation_position"] => "after",
	["decimals"] => "2",
	["decimal_separator"] => ",",
	["grouping_separator"] => "."
)</code>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session</li>
								<li>Query</li>
								<li>Cache</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::vatrates">
				<div class="header">
					<h3>Page::vatrates</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">vatrates</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Page::vatrates(
									[<span class="type">Integer</span> <span class="var">$id</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all available vatrates in nested Array structure from cache or DB</p>
						<p>Optionally get vatrate details by passing valid vatrate id as parameter.</p>
						<p>Vatrates are used to specify VAT for Item prices.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> Optional vatrate id to get details of.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> nested Array of available vatrates or specified vatrate details</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						
						<div class="example">
							<h5>Get all vatrates</h5>
							<code>$page->vatrates();</code>
							<p>Could returns (depending on available vatrates):</p>
							<code>Array(
	[0] => array(
		["id"] => 1,
		["name"] => "No VAT",
		["vatrate"] => 0,
		["country"] => "DK"
	),
	[1] => array(
		["id"] => 2,
		["name"] => "25%",
		["vatrate"] => 0.25,
		["country"] => "DK"
	)
)</code>
						</div>

						<div class="example">
							<h5>Get details for specific vatrate</h5>
							<code>$page->vatrates(1);</code>
							<p>Returns:</p>
							<code>Array(
	["id"] => 1,
	["name"] => "No VAT",
	["vatrate"] => 0,
	["country"] => "DK"
)</code>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session</li>
								<li>Query</li>
								<li>Cache</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::subscriptionMethods">
				<div class="header">
					<h3>Page::subscriptionMethods</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">subscriptionMethods</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Page::subscriptionMethods(
									[<span class="type">Integer</span> <span class="var">$id</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all available subscription methods in nested Array structure from cache or DB</p>
						<p>Optionally get subscription method details by passing valid subscription method id as parameter.</p>
						<p>Subscription methods are used to specify subscription renewal setting for item subscriptions.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> Optional subscription method id to get details of.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> nested Array of available subscription methods or specified subscription method details</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						
						<div class="example">
							<h5>Get all subscription methods</h5>
							<code>$page->subscriptionMethods();</code>
							<p>Could returns (depending on available subscription methods):</p>
							<code>Array(
	[0] => array(
		["id"] => 1,
		["name"] => "Monthly",
		["duration"] => "month",
		["starts_on"] => NULL
	),
	[1] => array(
		["id"] => 1,
		["name"] => "Weekly",
		["duration"] => "week",
		["starts_on"] => NULL
	)
)</code>
						</div>

						<div class="example">
							<h5>Get details for specific subscription method</h5>
							<code>$page->subscriptionMethods(1);</code>
							<p>Returns:</p>
							<code>Array(
	["id"] => 1,
	["name"] => "Monthly",
	["duration"] => "month",
	["starts_on"] => NULL
)</code>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session</li>
								<li>Query</li>
								<li>Cache</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::paymentMethods">
				<div class="header">
					<h3>Page::paymentMethods</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">paymentMethods</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Page::paymentMethods(
									[<span class="type">Integer</span> <span class="var">$id</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all available payment methods in nested Array structure from cache or DB</p>
						<p>Optionally get payment method details by passing valid payment method id as parameter.</p>
						<p>Subscription methods are used to specify payment method for subscriptions.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> Optional payment method id to get details of.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> nested Array of available payment methods or specified payment method details</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						
						<div class="example">
							<h5>Get all payment methods</h5>
							<code>$page->paymentMethods();</code>
							<p>Could returns (depending on available payment methods):</p>
							<code>Array(
	[0] => array(
		["id"] => 1,
		["name"] => "Bank account"
	),
	[1] => array(
		["id"] => 1,
		["name"] => "Paypal"
	)
)</code>
						</div>

					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session</li>
								<li>Query</li>
								<li>Cache</li>
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
							<dd class="syntax"><span class="type">String|void</span> = 
								Page::segment(
									[<span class="type">String</span> <span class="var">$value</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Get or set segment for current session (desktop, dekstop_ie, dekstop_light, mobile_light, mobile, mobile_touch, tablet, tv). 
							Calls http://detector-v3.dearapi.com for device detection.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Set session segment to $value
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String|void</span> It the $value parameter is omitted, the segment string is returned (desktop, dekstop_ie, dekstop_light, mobile_light, mobile, mobile_touch, tablet, tv)</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Session</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::navigation">
				<div class="header">
					<h3>Page::navigation</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">navigation</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|Boolean</span> = 
								Page::navigation(
									<span class="type">String</span> <span class="var">$handle</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Get the nested navigation for <span class="var">handle</span> from cache or DB (if not currently cached)
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$handle</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Navigation handle
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array|Boolean</span> The navigation structure in nested array or <span class="value">false</span>.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Cache</li>
								<li>Query</li>
								<li>Items</li>
								<li>superNormalize</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::validatePath">
				<div class="header">
					<h3>Page::validatePath</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">validatePath</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Page::validatePath(
									<span class="type">String</span> <span class="var">$path</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Checks if the current user has permission to access the specified path
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$path</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> The path to validate
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Boolean</span> True if current user has access to path, false if not</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::checkPermissions</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::validPath">
				<div class="header">
					<h3>Page::validPath</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">validPath</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								Page::validPath(
									<span class="type">String</span> <span class="var">$path</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Checks if the current user has permission to access the specified path and 
							returns path when user has permission. This is simply a quick way to use validatePath and have the
							path returned directly.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$path</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> The path to validate
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">String</span> The path is returned if current user has access to path, empty string if not</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::validatePath</li>
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
							<dd class="name">actions</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Page::actions();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get Array containing current url fragments, excluding controller path.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<p>No parameters</p>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> containing current url fragments, excluding controller path</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Nothing</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::logOff">
				<div class="header">
					<h3>Page::logOff</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">logOff</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								Page::logOff();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Log off the current user, reset session and return user to frontpage.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<p>No parameters</p>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Void</span></p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::addLog</li>
								<li>Session</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Page::throwOff">
				<div class="header">
					<h3>Page::throwOff</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">throwOff</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								Page::throwOff();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Throw user off the system, send email to ADMIN_EMAIL, reset session and return user to login page.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<p>No parameters</p>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Void</span></p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::addLog</li>
								<li>Page::mail</li>
								<li>Session</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<!--div class="function" id="Page::mail">
				<div class="header">
					<h3>Page::mail</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">mail</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Page::mail(
									<span class="type">Array</span> <span class="var">$_options</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Send mail, using specified mailer account</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Mail options
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">subject</span></dt>
										<dd>Subject of mail</dd>
										<dt><span class="value">message</span></dt>
										<dd>Mail message body</dd>
										<dt><span class="value">recipients</span></dt>
										<dd>Recipients, comma or semicolon separated</dd>
										<dt><span class="value">template</span></dt>
										<dd>Mail template to use for parsing message data</dd>
										<dt><span class="value">object</span></dt>
										<dd>Data Array to make available for template</dd>
										<dt><span class="value">attachments</span></dt>
										<dd>File attachments (single as string or multiple as strings in array)</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Boolean</span> true on success, false on error</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$page->mail(array(
	"subject" => "Hello world",
	"message" => "What do you want to say!",
	"recipients" => info@parentnode.dk
));</code>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Nothing</li>
							</ul>
						</div>

					</div>

				</div>
			</div-->

			<div class="function" id="Page::addLog">
				<div class="header">
					<h3>Page::addLog</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">addLog</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								Page::addLog(
									<span class="type">String</span> <span class="var">$message</span> 
									[, <span class="type">String</span> <span class="var">$collection</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Add message to Janitor log. Logging message, timestamp, user_id and IP-address in optional <span class="value">$collection</span>. Defaults to the <span class="value">framework</span> collection</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$message</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> message to log
								</div>
							</dd>
							<dt><span class="var">$collection</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Optional collection to add log to. Defaults to <span class="value">framework</span>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Void</span></p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$page->addLog("I think this is interesting");</code>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>FileSystem::makeDirRecursively</li>
								<li>Session</li>
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
							<dd class="name">collectNotification</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">_returntype_</span> = 
								Page::collectNotification(
									<span class="type">String</span> <span class="var">$message</span> 
									[, <span class="type">String</span> <span class="var">$collection</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Save message to collection to be emailed to ADMIN_EMAIL when collection limit is reached.
							Limit is defined in SITE_COLLECT_NOTIFICATIONS in config.php.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$message</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> message to log
								</div>
							</dd>
							<dt><span class="var">$collection</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Optional collection to add log to. Defaults to <span class="value">framework</span>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Void</span></p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<p>No example</p>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>FileSystem::makeDirRecursively</li>
								<li>Session</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
