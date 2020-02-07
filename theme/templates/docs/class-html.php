<div class="scene docpage i:docpage">
	<h1>HTML Class</h1>
	<h2>HTML output for Model based input templates</h2>
	<p>
		The HTML Class is providing some essential HTML output methods, primarily for creating HTML Form elements.
		It allows you more access control over your forms and generates Templator compliant HTML.
	</p>
	<p>
		The HTML Class is extended by the Model Class, and thus also indirectly by your Item type classes. That means all the HTML methods
		are also available through any Item type Class, such as fx. the TypePost Class, but also in any other Class that extends the Model
		Class. When invoking an HTML method through a Type Class or similar, the methods can utilize the defined Model entities, allowing you
		too easily create HTML inputs for any entity in your Model.
	</p>
	<p>
		The HTML Class is also conveniently auto-instantiated as a global <em>$HTML</em> variable in Janitor, and the $HTML instance is directly available in all
		templates, which are loaded using the template methods of the Page Class (Page::page, Page::header, Page::footer and Page::template). 
		When invoking HTML methods directly through the $HTML instance, there is <strong>no</strong> link to the model – only by invoking
		these methods through a Type Class or similar, will they be able to use Model entities as data source.
	</p>
	<p>
		As with most other system classes in Janitor, the HTML Class is actually split into a HTML Class and a HTML Core Class.
		It is in fact the HTML Core Class that provides the methods below – the HTML Class is only intended as a placeholder
		for your additions or customisations.
	</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="HTML::attribute">
				<div class="header">
					<h3>HTML::attribute</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::attribute</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">_returntype_</span> = 
								HTML::attribute(
									<span class="type">String</span> <span class="var">$attribute_name</span> 
									[, <span class="type">Mixed</span> <span class="var">$attribute_value</span> ]*N
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Creates an HTML attribute of type <span class="var">$attribute_name</span>, with values
							passed as individual successive parameters. You can pass as many 
							<span class="var">$attribute_value</span>'s as you desire.
						</p>
						<p>
							Attribute values that resolve to false or empty strings will be ignore.
						</p>
						<p>
							If all passed attribute values resolve negatively (to false or empty string), the method will return an empty string,
							as an attribute without values, doesn't make any sense.
						</p>
						<p>
							This method can conveniently be used to add a number of yet undetermined className values
							to a <em>class</em> attribute.
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$attribute_name</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Attribute to create if valid values are passed
								</div>
							</dd>
							<dt><span class="var">$attribute_value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Mixed</span> Repeating parameter, containing values for the attribute.
									Additional values can be passed as additional parameters.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p>
							<span class="type">String</span> String containing the attribute including values, or empty 
							string if no valid values are passed.
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$max = 10;
$min = false;
$HTML->attribute("class", "main", ($max ? "max:".$max ; ""), $min);</code>
							<p>Will return:</p>
							<code> class="main max:10"</code>
						</div>

						<div class="example">
							<code>$max = "";
$min = 0;
$HTML->attribute("class", "main", ($max ? "max:".$max ; ""), $min);</code>
							<p>Will return:</p>
							<code> class="main min:0"</code>
						</div>

						<div class="example">
							<code>$max = "";
$min = 0;
$HTML->attribute("class", ($max ? "max:".$max ; ""), $min);</code>
							<p>Will return and empty string, as both $max and $min resolves to nothing.</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>func_get_args</li>
								<li>count</li>
								<li>htmlentities</li>
								<li>stripslashes</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>None</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="HTML::toOptions">
				<div class="header">
					<h3>HTML::toOptions</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::toOptions</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								HTML::toOptions(
									<span class="type">Array</span> <span class="var">$multi_array</span> 
									, <span class="type">String</span> <span class="var">$value_index</span> 
									, <span class="type">String</span> <span class="var">$text_index</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Convert multi dimensional Array to valid options Array for selects and Radiobuttons
							– and optionally add additional options in the same go.
						</p>
						<p>
							Data exchanges in Janitor is done with associative Arrays. 
							Lists of datasets are Arrays of associative Arrays. To create a valid options
							Array from a list of datasets (which is commonly what you need), you might just need 
							two properties from each dataset, requiring you to iterate
							the whole list and create a new Array with the correct keys and values. That is what this
							function does.
						</p>
						<p>
							Note that it is valid to have Named indices, with an empty string as Key, which we use
							for default options (they have no value to send).
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$multi_array</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Array of Associative Array, in which to find
									specified keys and values.
								</div>
							</dd>
							<dt><span class="var">$value_index</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Key of Value in Associative Array, to use as options Key
								</div>
							</dd>
							<dt><span class="var">$text_index</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Key of Value in Associative Array, to use as options Value
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Additional options
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">add</span></dt>
										<dd>Additional options to add to the beginning of the new Options Array</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> Associative array of selected key values, prepended additional options.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$data_sets = &lsqb;
	[&quot;id&quot; =&gt; &quot;1&quot;, &quot;name&quot; =&gt; &quot;Tom&quot;, &quot;title&quot; =&gt; &quot;Naive, hungry cat&quot;],
	[&quot;id&quot; =&gt; &quot;2&quot;, &quot;name&quot; =&gt; &quot;Jerry&quot;, &quot;title&quot; =&gt; &quot;Thrill seeking enthusiast&quot;],
	[&quot;id&quot; =&gt; &quot;3&quot;, &quot;name&quot; =&gt; &quot;Fido&quot;, &quot;title&quot; =&gt; &quot;Kind hearted puppy&quot;]
&rsqb;;

$HTML-&gt;toOptions($data_sets, &quot;id&quot;, &quot;name&quot;);</code>
							<p>Returns:</p>
							<code>[&quot;1&quot; =&gt; &quot;Top&quot;, &quot;2&quot; =&gt; &quot;Jerry&quot;, &quot;3&quot; =&gt; &quot;Fido&quot;]</code>
						</div>

						<div class="example">
							<code>$data_sets = &lsqb;
	[&quot;id&quot; =&gt; &quot;1&quot;, &quot;name&quot; =&gt; &quot;Tom&quot;, &quot;title&quot; =&gt; &quot;Naive, hungry cat&quot;],
	[&quot;id&quot; =&gt; &quot;2&quot;, &quot;name&quot; =&gt; &quot;Jerry&quot;, &quot;title&quot; =&gt; &quot;Thrill seeking enthusiast&quot;],
	[&quot;id&quot; =&gt; &quot;3&quot;, &quot;name&quot; =&gt; &quot;Fido&quot;, &quot;title&quot; =&gt; &quot;Kind hearted puppy&quot;]
&rsqb;;

$HTML-&gt;toOptions($data_sets, &quot;id&quot;, &quot;name&quot;, [&quot;add&quot; =&gt; [&quot;&quot; =&gt; &quot;Choose side&quot;]]);</code>
							<p>Returns:</p>
							<code>[&quot;&quot; =&gt; &quot;Choose side&quot;, &quot;1&quot; =&gt; &quot;Top&quot;, &quot;2&quot; =&gt; &quot;Jerry&quot;, &quot;3&quot; =&gt; &quot;Fido&quot;]</code>
						</div>

					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>is_array</li>
								<li>switch...case</li>
								<li>foreach</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>None</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="HTML::jsMedia">
				<div class="header">
					<h3>HTML::jsMedia</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::jsMedia</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								HTML::jsMedia(
									<span class="type">Array</span> <span class="var">$item</span> 
									[, <span class="type">String</span> <span class="var">$variant</span> ]
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

			<div class="function" id="HTML::jsData">
				<div class="header">
					<h3>HTML::jsData</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::jsData</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								HTML::jsData(
									<span class="type">Array</span> <span class="var">$_filter</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Create a data attributes string with backend endpoints for JavaScript interfaces.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_filter</span></dt>
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

			<div class="function" id="HTML::formStart">
				<div class="header">
					<h3>HTML::formStart</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::formStart</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								HTML::formStart(
									<span class="type">String</span> <span class="var">$action</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Create a start <span class="htmltag">form</span> tag, including hidden csrf-token input, 
							if the action is accessible for the current user.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Path to use as action value for the form. Optionally relative path, which will be appended to current controller path.
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Form settings
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">class</span></dt>
										<dd>Classname for form</dd>
										<dt><span class="value">id</span></dt>
										<dd>Id for form</dd>
										<dt><span class="value">target</span></dt>
										<dd>Target value for form, Default none.</dd>
										<dt><span class="value">method</span></dt>
										<dd>Method value for form, Default <span class="value">post</span>.</dd>
										<dt><span class="value">enctype</span></dt>
										<dd>Encoding for form, Default <span class="value">application/x-www-form-urlencoded</span></dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> HTML string for form as specified, or empty string if $action is not accessible to user.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$model->formStart("/update", array("class" => "autoForm i:autoForm"));</code>
							<p>Will return:</p>
							<code>&lt;form action=&quot;/update&quot; method=&quot;post&quot; class=&quot;autoForm i:autoForm&quot; enctype=&quot;application/x-www-form-urlencoded&quot;&gt;
	&lt;input type=&quot;hidden&quot; name=&quot;csrf-token&quot; value=&quot;6dc41813-dedc-4695-a0ba-56470f7b2020&quot; /&gt;</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>preg_match</li>
								<li>foreach</li>
								<li>switch</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::validatePath</li>
								<li>session()->value</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="HTML::formEnd">
				<div class="header">
					<h3>HTML::formEnd</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::formEnd</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								HTML::formEnd();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Create an end <span class="htmltag">form</span> tag, if <span class="value">formStart</span> has previously been called (and not been ended yet).</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>
						<p>None</p>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> End form tag, if "open" form exists, otherwise empty string.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						<p>None</p>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
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

			<div class="function" id="HTML::input">
				<div class="header">
					<h3>HTML::input</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::input</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								HTML::input(
									<span class="type">String</span> <span class="var">$name</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Create Templator compliant Form input HTML, using Model entities when available – if
							formStart has been invoked. The input
							method supports all the same input types as are available for Model creation.
						</p>
						<p>
							The method is primarily intended to be invoked through a Type Class, and in that case 
							it can utilize the defined Model entities – just use the entity name as input name, and the 
							method will use the properties you already defined to construct the input. Any entity property can 
							be overridden directly through the $_options Array, when invoking this method, if customisation is needed.
						</p>
						<p>
							The method can also be invoked directly through the HTML class, but in that case it will not 
							have access to Model entities. Any property can be set directly through the $_options Array, when
							invoking this method.
						</p>
						<p>
							<strong>Note:</strong> Only properties specified in the Model will be used for serverside validation.
							Any overrides or additions made when invoking the input method, will be limited to the rendering client.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$name</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Input name (or Model entity name).
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional settings.
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">label</span></dt>
										<dd>
											Label of the entity. 
											<br />(Not applicable for type <em>hidden</em>)
										</dd>
										<dt><span class="value">type</span></dt>
										<dd>Type of the entity. One of the predefined types, 
											<em>hidden</em>, 
											<em>string</em>, 
											<em>text</em>, 
											<em>select</em>, 
											<em>html</em>, 
											<em>files</em>, 
											<em>number</em>, 
											<em>integer</em>, 
											<em>email</em>, 
											<em>tel</em>, 
											<em>password</em>, 
											<em>date</em>, 
											<em>datetime</em>, 
											<em>checkbox</em>, 
											<em>radiobuttons</em>. Default is <em>string</em>.
											<br />(See <a href="class-model">Model Class documentation</a> for a full explanation)
										</dd>
										<dt><span class="value">value</span></dt>
										<dd>
											Value of entity.
										</dd>
										<dt><span class="value">options</span></dt>
										<dd>
											A named Array of options for selects and radiobuttons, following the format [option name => option value].
											<br />(Only applicable for type <em>select</em> and <em>radiobuttons</em>)
										</dd>
										<dt><span class="value">id</span></dt>
										<dd>
											A custom element <em>id</em> used when rendering the entity input. 
											As default an <em>input_#entity_name#</em> is generated.
										</dd>
										<dt><span class="value">class</span></dt>
										<dd>
											A custom className used when rendering the entity input – applied to input field.
											<br />(Not applicable for type <em>hidden</em>)
										</dd>
										<dt><span class="value">required</span></dt>
										<dd>
											Whether data is required for this entity. Default <em>false</em>.
											<br />(Not applicable for type <em>hidden</em>)
										</dd>
										<dt><span class="value">readonly</span></dt>
										<dd>
											Render this input as <em>readonly</em>. Default <em>false</em>.
											<br />(Not applicable for type <em>hidden</em>, <em>files</em> and <em>html</em>)
										</dd>
										<dt><span class="value">disabled</span></dt>
										<dd>
											Render this input as <em>disabled</em>. Default <em>false</em>.
											<br />(Not applicable for type <em>hidden</em>, <em>files</em> and <em>html</em>)
										</dd>
										<dt><span class="value">error_message</span></dt>
										<dd>
											An error message for client side validation.
											<br />(Not applicable for type <em>hidden</em>)
										</dd>
										<dt><span class="value">hint_message</span></dt>
										<dd>
											A hint message for client side validation.
											<br />(Not applicable for type <em>hidden</em>)
										</dd>
										<dt><span class="value">autocomplete</span></dt>
										<dd>
											Whether the browsers native autocomplete functionality should be turn on. Default <em>false</em>.
											<br />(Not applicable for type <em>hidden</em>, <em>checkbox</em>, <em>radiobuttons</em>, <em>select</em>, <em>html</em> and <em>files</em>)
										</dd>
										<dt><span class="value">pattern</span></dt>
										<dd>
											A regular expression pattern data must match for this entity.
											<br />(Not applicable for type <em>hidden</em>, <em>checkbox</em>, <em>radiobuttons</em>, <em>select</em> and <em>files</em>)
										</dd>
										<dt><span class="value">min</span></dt>
										<dd>
											Minimum abstract for this entity. Has different meanings depending on context - see input type overview in <a href="class-model">Model Class documentation</a>.
											<br />(Not applicable for type <em>hidden</em>, <em>checkbox</em>, <em>radiobuttons</em>, <em>select</em> and <em>files</em>)
										</dd>
										<dt><span class="value">max</span></dt>
										<dd>
											Maximum abstract for this entity. Has different meanings depending on context - see input type overview in <a href="class-model">Model Class documentation</a>.
											<br />(Not applicable for type <em>hidden</em>, <em>checkbox</em>, <em>radiobuttons</em> and <em>select</em>)
										</dd>
										<dt><span class="value">compare_to</span></dt>
										<dd>
											If the input value must match that of another. Typically used for email or password "repeat to confirm" inputs.
											<br />(Only applicable for type <em>string</em>, <em>email</em>, <em>tel</em> and <em>password</em>)
										</dd>
										<dt><span class="value">allowed_tags</span></dt>
										<dd>
											Tags and special content types, that are allowed in the HTML input.
											Default p,h1,h2,h3,h4,h5,h6,code,ul,image,download.
											<br />(See the full list below)
											<br />(Only applicable for type <em>html</em>)
										</dd>
										<dt><span class="value">media_add</span></dt>
										<dd>
											A custom save path for adding viewable media through the HTML editor.
											Default is to <em>addHTMLMedia</em> on current controller.
											<br />(Only applicable for type <em>html</em>)
										</dd>
										<dt><span class="value">media_delete</span></dt>
										<dd>
											A custom delete path for deleting viewable media through the HTML editor.
											Default is to <em>deleteHTMLMedia</em> on current controller.
											<br />(Only applicable for type <em>html</em>)
										</dd>
										<dt><span class="value">file_add</span></dt>
										<dd>
											A custom save path for adding downloadable files through the HTML editor.
											Default is to <em>addHTMLFile</em> on current controller.
											<br />(Only applicable for type <em>html</em>)
										</dd>
										<dt><span class="value">file_delete</span></dt>
										<dd>
											A custom delete path for deleting downloadable files through the HTML editor.
											Default is to <em>deleteHTMLFile</em> on current controller.
											<br />(Only applicable for type <em>html</em>)
										</dd>
									</dl>
								</div>
							</dd>
						</dl>

						<p class="note">
							<strong>Note:</strong> The $_options
							properties can and should primarily be defined via your model, rather than when invoking the input
							method.
						</p>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> HTML representing a Templator compliant input field – if form has been started (using HTML::formStart).</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>To create an input field for "name", using all properties from name entity defined in TypePost.</p>
							<code>$typePostClass->input("name");</code> 
						</div>

						<div class="example">
							<p>To create an input field for "classname", and making it required.</p>
							<code>$typePostClass->input("classname", ["required" => true]);</code> 
						</div>

						<div class="example">
							<p>To create an custom input field, special_token, for a string between 5 and 10 chars, with frontend validation only.</p>
							<code>$HTML->input("special_token", ["type" => "string", "required" => true, "min" => 5, "max" => 10]);</code> 
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>isset</li>
								<li>foreach</li>
								<li>switch...case</li>
								<li>preg_replace</li>
								<li>preg_match</li>
								<li>htmlentities</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>Page::validPath</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="HTML::output">
				<div class="header">
					<h3>HTML::output</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::output</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								HTML::output(
									<span class="type">String</span> <span class="var">$name</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							This method will output a model entity as a kind of readonly element. It will be encapsulated
							in a <span class="value">div.field</span>, but the entity value will be shown in a 
							<span class="htmltag">p</span> or a <span class="htmltag">ul</span>
							instead of in an input field.
						</p>
						<p>
							The value will also be included in a hidden input inside the <span class="value">div.field</span>.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$name</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Input name (or Model entity name).
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional settings.
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">label</span></dt>
										<dd>Label of the entity.</dd>
										<dt><span class="value">type</span></dt>
										<dd>Type of the entity. <span class="value">list</span> or <span class="value">p</span>. Default <span class="value">p</span>.</dd>
										<dt><span class="value">value</span></dt>
										<dd>Value of entity.</dd>
										<dt><span class="value">options</span></dt>
										<dd>
											An array of values to show in a list.
										</dd>
										<dt><span class="value">class</span></dt>
										<dd>
											A custom className used when rendering the entity.
										</dd>
										<dt><span class="value">id</span></dt>
										<dd>
											A custom element <em>id</em> used when rendering the entity <span class="htmltag">p</span> or <span class="htmltag">ul</span>. 
										</dd>
										<dt><span class="value">hint_message</span></dt>
										<dd>
											A hint message.
										</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> HTML representing a Templator compliant output field.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						<p>None</p>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>foreach</li>
								<li>switch...case</li>
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

			<div class="function" id="HTML::button">
				<div class="header">
					<h3>HTML::button</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::button</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								HTML::button(
									<span class="type">String</span> <span class="var">$value</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Create an HTML input type=button.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Value for input type=button.
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Button settings
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">type</span></dt>
										<dd>Type value of button input. <span class="value">button</span> or <span class="value">submit</span>. Default <span class="value">button</span></dd>
										<dt><span class="value">name</span></dt>
										<dd>Name value of button input.</dd>
										<dt><span class="value">class</span></dt>
										<dd>Classname value of button input.</dd>
										<dt><span class="value">wrapper</span></dt>
										<dd>HTML wrapper for input.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> HTML input type=button element – or empty string, if 
							<span class="value">HTML::formStart</span> has not been called first.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$model-&gt;button(&quot;Button text&quot;, [&quot;class&quot; =&gt; &quot;primary&quot;]);</code>
							<p>Returns</p>
							<code>&lt;input value=&quot;Button text&quot; type=&quot;button&quot; class=&quot;button primary&quot; /&gt;</code>
						</div>

						<div class="example">
							<code>$HTML-&gt;button(&quot;Button text&quot;, [&quot;class&quot; =&gt; &quot;primary&quot;, &quot;wrapper&quot; =&gt; &quot;li.input&quot;]);</code>
							<p>Returns</p>
							<code>&lt;li class=&quot;input&quot;&gt;&lt;input value=&quot;Button text&quot; type=&quot;button&quot; class=&quot;button primary&quot; /&gt;&lt;/li&gt;</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>isset</li>
								<li>foreach</li>
								<li>switch...case</li>
								<li>preg_match</li>
								<li>preg_match_all</li>
								<li>implode</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>None</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="HTML::submit">
				<div class="header">
					<h3>HTML::submit</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::submit</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								HTML::submit(
									<span class="type">String</span> <span class="var">$value</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Shorthand method to create submit buttons. Will simply invoke <a href="#HTML::button">HTML::button</a> 
							with type=submit.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Value for input type=submit.
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Button settings
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">type</span></dt>
										<dd>Type value of button input. <span class="value">button</span> or <span class="value">submit</span>. Default <span class="value">button</span></dd>
										<dt><span class="value">name</span></dt>
										<dd>Name value of button input.</dd>
										<dt><span class="value">class</span></dt>
										<dd>Classname value of button input.</dd>
										<dt><span class="value">wrapper</span></dt>
										<dd>HTML wrapper for input, stated in a selector style syntax, like <span class="value">li.readmore</span>.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p>
							<span class="type">String</span> HTML input type=submit element, optionally wrapped in 
							<span class="htmltag">$wrapper</span> – or empty string, if 
							<span class="value">HTML::formStart</span> has not been called first.
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$HTML-&gt;submit(&quot;Save text&quot;, [&quot;class&quot; =&gt; &quot;primary&quot; &quot;wrapper&quot; =&gt; &quot;li.input&quot;]);</code>
							<p>Returns</p>
							<code>&lt;li class=&quot;input&quot;&gt;&lt;input value=&quot;Save text&quot; type=&quot;submit&quot; class=&quot;button primary&quot; /&gt;&lt;/li&gt;</code>
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
							<p>None</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="HTML::link">
				<div class="header">
					<h3>HTML::link</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::link</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								HTML::link(
									<span class="type">String</span> <span class="var">$value</span> 
									, <span class="type">String</span> <span class="var">$action</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
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
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Text value of link.
								</div>
							</dd>
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> HREF value of link.
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional link settings
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">$id</span></dt>
										<dd>Name value of button input.</dd>
										<dt><span class="value">$class</span></dt>
										<dd>Classname value of link.</dd>
										<dt><span class="value">$target</span></dt>
										<dd>Target value for link.</dd>
										<dt><span class="value">$wrapper</span></dt>
										<dd>HTML wrapper for input, stated in a selector style syntax, like <span class="value">li.readmore</span>.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p>
							<span class="type">String</span> HTML string containing <span class="htmltag">a</span>,
							optionally wrapped in <span class="htmltag">$wrapper</span> – or empty string, if 
							<span class="value">$action</span> is not accessible to user.
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$HTML-&gt;link(&quot;Link text&quot;, &quot;/janitor/tests&quot;, [&quot;class&quot; =&gt; &quot;button&quot;, &quot;wrapper&quot; =&gt; &quot;li.link&quot;]);</code>
							<p>Returns</p>
							<code>&lt;li class=&quot;link&quot;&gt;&lt;a href=&quot;/janitor/tests&quot; class=&quot;button&quot;&gt;Link text&lt;/a&gt;&lt;/li&gt;</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>isset</li>
								<li>foreach</li>
								<li>switch...case</li>
								<li>preg_match</li>
								<li>preg_match_all</li>
								<li>implode</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::validatePath</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="HTML::navigationLink">
				<div class="header">
					<h3>HTML::navigationLink</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">HTML::navigationLink</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								HTML::navigationLink(
									<span class="type">Array</span> <span class="var">$node</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Create a HTML element for navigations. Includes a <span class="value">selected</span> class if 
							<span class="var">$node["link"]</span> is equal to current url. Includes
							a <span class="value">path</span> class if current url contains <span class="var">$node["link"]</span>.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$node</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Janitor navigation node data set.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p>
							<span class="type">String</span> HTML string with <span class="htmltag">li</span> and 
							<span class="htmltag">a</span>. Includes a <span class="value">selected</span> or a
							<span class="value">path</span>, if link value equals or is contained in current url.
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						<p>None</p>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>preg_match</li>
								<li>strpos</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Page::validatePath</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
