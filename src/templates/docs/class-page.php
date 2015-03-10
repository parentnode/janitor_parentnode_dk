<div class="scene docpage i:docpage">
	<h1>Page</h1>
	<p>
		The Page class is the core controller and template toolset. This class is automatically instatiated and 
		available in $page, after the init file has been included in your controller. It provides all the base
		functionality needed to process a request and output relevant templates.
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

						<div class="example"><code>$this->bodyClass("front");</code>
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

						<div class="example"><code>$this->contentClass("front");</code>
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
								Page::languages();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all available languages in nested Array structure</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<p>No parameters</p>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> nested Array of available languages</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						
						<div class="example">
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
								Page::countries();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all available countries in nested Array structure</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<p>No parameters</p>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> nested Array of available countries</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						
						<div class="example">
						<code>$page->countries();</code>
						<p>Could returns (depending on available countries):</p>
						<code>Array(
	[0] => array(
		["id"] => "DK",
		["name"] => "Danmark"
	),
	[1] => array(
		["id"] => "US",
		["name"] => "USA"
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
							</ul>
						</div>

					</div>

				</div>
			</div>

			<!-- CURRENT IMPLEMENTATION IS FLAWED -->
			<!--div class="function" id="Page::currency">
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
							<h5>Janitor</h5>
							<ul>
								<li>_function_</li>
							</ul>
						</div>

					</div>

				</div>
			</div-->

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
							<dd class="syntax"><span class="type">String</span> = 
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

validatePath
validPath

logOff
throwOff




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
