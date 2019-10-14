<div class="scene docpage i:docpage">
	<h1>Model Class</h1>
	<h2>Data modeling and validation</h2>

	<p>
		 In Janitor the Model bridges the gab between data storage and input. When you define a model, you have to consider
		 both, because in the end they are unseparable. If no one puts in any data, there is nothing to store. So the Model
		 is covering storage, transaction and input aspects all together. Read more about the 
		 <a href="concept-model">Janitor Model Concept</a>.
	</p>
	<p>
		The Janitor model is made up of a number of different data/input types, and this class provides the functionality for
		composing your own data models for your custom items, but also for other classes which may need to receive or store validated
		user input.
	</p>
	<p>
		The Core Janitor Model is inherited by all <a href="class-itemtype">itemtypes</a> and classes with an associated model. By extending the
		model class, your own classes are extended with capability to define data properties, input type support and 
		validation.
	</p>
	<p>
		The Model class in turn extends the <a href="class-html">HTML Class</a>, providing form and input rendering capabilities, also based on the
		specification provided in your model, but always leaving room for customisation.
	</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="Model::addToModel">
				<div class="header">
					<h3>Model::addToModel</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Model::addToModel</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								Model::addToModel(
									<span class="type">String</span> <span class="var">$name</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							The <em>addToModel</em> method is typically used in type class constructors, but can be used in any
							class which extends the Model class, and allows the class to define and receive specific input conditions
							and validate any received data. 
							It is used to compose the data model of that specific type class. Each addition to your model is referred to
							as an (model) entity, and you'll end up with the 
						</p>
						<p>
							As a minimum, you must define the entity <em>name</em>, and in addition you can specify 
							one of the predefined input <em>type</em>'s listed below, special validation conditions
							such as <em>min</em>/<em>max</em> values, input <em>pattern</em>, <em>hint_message</em> and 
							<em>error_messages</em> – and much more. See the full options list below.
						</p>
						<p>
							Any model entity, can be modified during runtime, or be rendered using a different type
							than originally defined, so that you can fine tune your interface for custom workflow needs.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$name</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Name of entity to add to model
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span>  Optional settings
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">label</span></dt>
										<dd>
											Label of the entity. 
											Used for rendering inputs for the entity. 
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
											<em>radiobuttons</em>, 
											<em>tag</em>, 
											<em>user_id</em>, 
											<em>item_id</em>. Default is <em>string</em>.
											<br />(See expanded explanation below)
										</dd>
										<dt><span class="value">value</span></dt>
										<dd>
											Value of entity if posted or set.
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
										<dt><span class="value">error_message</span></dt>
										<dd>
											An error message used when rendering the entity input.
											<br />(Not applicable for type <em>hidden</em>)
										</dd>
										<dt><span class="value">hint_message</span></dt>
										<dd>
											A hint message used when rendering the entity input.
											<br />(Not applicable for type <em>hidden</em>)
										</dd>
										<dt><span class="value">autocomplete</span></dt>
										<dd>
											Whether the browsers native autocomplete functionality should be turn on. Default <em>false</em>.
											<br />(Not applicable for type <em>hidden</em>, <em>checkbox</em>, <em>radiobuttons</em>, <em>select</em>, <em>html</em> and <em>files</em>)
										</dd>
										<dt><span class="value">unique</span></dt>
										<dd>
											 Whether the data value must be unique for this entity. 
											 Set to a database table, to enforce enable checking for uniqueness against 
											 the database.
											<br />(Not applicable for type <em>hidden</em>, <em>checkbox</em>, <em>radiobuttons</em>, <em>select</em>, <em>html</em> and <em>files</em>)
										</dd>
										<dt><span class="value">pattern</span></dt>
										<dd>
											A regular expression pattern data must match for this entity.
											<br />(Not applicable for type <em>hidden</em>, <em>checkbox</em>, <em>radiobuttons</em>, <em>select</em> and <em>files</em>)
										</dd>
										<dt><span class="value">min</span></dt>
										<dd>
											Minimum abstract for this entity. Has different meanings depending on context - see input type overview below.
											<br />(Not applicable for type <em>hidden</em>, <em>checkbox</em>, <em>radiobuttons</em>, <em>select</em> and <em>files</em>)
										</dd>
										<dt><span class="value">max</span></dt>
										<dd>
											Maximum abstract for this entity. Has different meanings depending on context - see input type overview below.
											<br />(Not applicable for type <em>hidden</em>, <em>checkbox</em>, <em>radiobuttons</em> and <em>select</em>)
										</dd>
										<dt><span class="value">compare_to</span></dt>
										<dd>
											If the input value must match that of another. Typically used for email or password "repeat to confirm" inputs.
											<br />(Only applicable for type <em>string</em>, <em>email</em>, <em>tel</em> and <em>password</em>)
										</dd>
										<dt><span class="value">min_width</span></dt>
										<dd>
											Minimum width of uploaded images and videos, stated as an integer of pixels.
											<br />(Only applicable for type <em>files</em> and <em>html</em>)
										</dd>
										<dt><span class="value">min_height</span></dt>
										<dd>
											Minimum height of uploaded images and videos, stated as an integer of pixels.
											<br />(Only applicable for type <em>files</em> and <em>html</em>)
										</dd>
										<dt><span class="value">allowed_formats</span></dt>
										<dd>
											File formats allowed for upload. Stated as the allowed file extension,
											fx. jpg or png.
											More allowed proportions can be comma separated, fx. jpg,png.
											Though all formats are supported, anything other than image, video, audio
											pdf or zip uploads, will automatically be zipped and provided as as zip file.
											Default gif,jpg,png,mp4,mov,m4v,mp3,pdf,zip.
											<br />(Only applicable for type <em>files</em> and <em>html</em>)
										</dd>
										<dt><span class="value">allowed_proportions</span></dt>
										<dd>
											Image and video proportions allowed for upload. Stated as a 4 decimal representation of
											the proportion (width/height), fx. 1.7778 or round(4/3, 4). 
											More allowed proportions can be comma separated, fx. 1.7778,1.3333.
											<br />(Only applicable for type <em>files</em> and <em>html</em>)
										</dd>
										<dt><span class="value">allowed_sizes</span></dt>
										<dd>
											Image and video sizes allowed for upload. State as WIDTHxHEIGHT, fx. 540x288 or 1000x400.
											More allowed sizes can be comma separated, fx. 540x288,1000x400.
											<br />(Only applicable for type <em>files</em> and <em>html</em>)
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
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Void</span></p>
					</div>

					<div class="inputtypes">
						<h4>Data and Input types</h4>
						<p>
							Each data and input type may interpret a property differently, due to the nature of the type. 
							For example, the <em>min</em> property
							means minimum length for a string type, while it means minimum value for an integer type. Find
							the nuances below.
						</p>
						<p>
							Most of the input types can be directly linked to the classic HTML input types, while others
							are a kind a pseudo input types, constructed on top of the classic HTML input types.
						</p>


						<h5><span class="value">hidden</span></h5>
						<p>
							The hidden input type is just that. A hidden input. 
							Equivalent to a <span class="htmltag">input type=&quot;hidden&quot;</span>.
						</p>
						<dl class="options">
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
						</dl>


						<h5><span class="value">string</span></h5>
						<p>
							Regular string input of maximum 255 characters. No other limitations apply.
							Equivalent to a <span class="htmltag">input type=&quot;text&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Field element className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">autocomplete</span></dt>
							<dd>Allow autocomplete</dd>
							<dt><span class="value">unique</span></dt>
							<dd>Require value to be unique</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum length of value</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum length of value</dd>
							<dt><span class="value">compare_to</span></dt>
							<dd>Name of entity to compare value to</dd>
						</dl>


						<h5><span class="value">text</span></h5>
						<p>
							Multiline text input. 
							Equivalent to a <span class="htmltag">textarea</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Element field className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">autocomplete</span></dt>
							<dd>Allow autocomplete</dd>
							<dt><span class="value">unique</span></dt>
							<dd>Require value to be unique</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum length of value</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum length of value</dd>
						</dl>


						<h5><span class="value">select</span></h5>
						<p>
							Select type input, also known as an options dropdown. 
							Equivalent to a <span class="htmltag">select</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Element field className in HTML</dd>
							<dt><span class="value">options</span></dt>
							<dd>Array of options</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
						</dl>


						<h5><span class="value">html</span></h5>
						<p>
							HTML Editor based input. Expects value to be correctly formatted HTML.
							Equivalent to a (very advanced) <span class="htmltag">textarea</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Element field className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum length of value</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum length of value</dd>
							<dt><span class="value">min_width</span></dt>
							<dd>Minimum width of uploaded viewable media</dd>
							<dt><span class="value">min_height</span></dt>
							<dd>Minimum height of uploaded viewable media</dd>
							<dt><span class="value">allowed_formats</span></dt>
							<dd>Allowed file formats allowed</dd>
							<dt><span class="value">allowed_proportions</span></dt>
							<dd>Allowed image and video proportions</dd>
							<dt><span class="value">allowed_sizes</span></dt>
							<dd>Allowed image and video sizes</dd>
							<dt><span class="value">allowed_tags</span></dt>
							<dd>Allowed tags and special content types</dd>
							<dt><span class="value">media_add</span></dt>
							<dd>A custom media save path</dd>
							<dt><span class="value">media_delete</span></dt>
							<dd>A custom media delete path</dd>
							<dt><span class="value">file_add</span></dt>
							<dd>A custom file save path</dd>
							<dt><span class="value">file_delete</span></dt>
							<dd>A custom file delete path</dd>
						</dl>


						<h5><span class="value">files</span></h5>
						<p>
							File or files input.
							Equivalent to a <span class="htmltag">input type=&quot;file&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Element field className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum number of files. Default 1.</dd>
							<dt><span class="value">min_width</span></dt>
							<dd>Minimum width of uploaded viewable media</dd>
							<dt><span class="value">min_height</span></dt>
							<dd>Minimum height of uploaded viewable media</dd>
							<dt><span class="value">allowed_formats</span></dt>
							<dd>Allowed file formats allowed</dd>
							<dt><span class="value">allowed_proportions</span></dt>
							<dd>Allowed image and video proportions</dd>
							<dt><span class="value">allowed_sizes</span></dt>
							<dd>Allowed image and video sizes</dd>
						</dl>


						<h5><span class="value">number</span></h5>
						<p>
							Numeric input. Integers and floats.
							Equivalent to a <span class="htmltag">input type=&quot;number&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Field element className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">autocomplete</span></dt>
							<dd>Allow autocomplete</dd>
							<dt><span class="value">unique</span></dt>
							<dd>Require value to be unique</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum numeric limit of value</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum numeric limit of value</dd>
						</dl>


						<h5><span class="value">integer</span></h5>
						<p>
							Numeric input. Integers only.
							Equivalent to a <span class="htmltag">input type=&quot;number&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Field element className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">autocomplete</span></dt>
							<dd>Allow autocomplete</dd>
							<dt><span class="value">unique</span></dt>
							<dd>Require value to be unique</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum numeric limit of value</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum numeric limit of value</dd>
						</dl>

						<h5><span class="value">email</span></h5>
						<p>
							Email input.
							Equivalent to a <span class="htmltag">input type=&quot;email&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Field element className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">autocomplete</span></dt>
							<dd>Allow autocomplete</dd>
							<dt><span class="value">unique</span></dt>
							<dd>Require value to be unique</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum length of value</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum length of value</dd>
							<dt><span class="value">compare_to</span></dt>
							<dd>Name of entity to compare value to</dd>
						</dl>

						<h5><span class="value">tel</span></h5>
						<p>
							Phone number input.
							Equivalent to a <span class="htmltag">input type=&quot;tel&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Field element className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">autocomplete</span></dt>
							<dd>Allow autocomplete</dd>
							<dt><span class="value">unique</span></dt>
							<dd>Require value to be unique</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum length of value</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum length of value</dd>
							<dt><span class="value">compare_to</span></dt>
							<dd>Name of entity to compare value to</dd>
						</dl>


						<h5><span class="value">password</span></h5>
						<p>
							Password input.
							Equivalent to a <span class="htmltag">input type=&quot;password&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Field element className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">autocomplete</span></dt>
							<dd>Allow autocomplete</dd>
							<dt><span class="value">unique</span></dt>
							<dd>Require value to be unique</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum length of value</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum length of value</dd>
							<dt><span class="value">compare_to</span></dt>
							<dd>Name of entity to compare value to</dd>
						</dl>


						<h5><span class="value">date</span></h5>
						<p>
							Date input.
							Equivalent to a <span class="htmltag">input type=&quot;date&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Field element className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">autocomplete</span></dt>
							<dd>Allow autocomplete</dd>
							<dt><span class="value">unique</span></dt>
							<dd>Require value to be unique</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum date</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum date</dd>
						</dl>


						<h5><span class="value">datetime</span></h5>
						<p>
							Datetime input.
							Equivalent to a <span class="htmltag">input type=&quot;datetime&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Field element className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">autocomplete</span></dt>
							<dd>Allow autocomplete</dd>
							<dt><span class="value">unique</span></dt>
							<dd>Require value to be unique</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum date or datetime</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum date or datetime</dd>
						</dl>


						<h5><span class="value">checkbox</span></h5>
						<p>
							A single checkbox.
							Equivalent to a <span class="htmltag">input type=&quot;checkbox&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Element field className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
						</dl>


						<h5><span class="value">radiobuttons</span></h5>
						<p>
							Set of radiobuttons.
							Equivalent to a <span class="htmltag">input type=&quot;radio&quot;</span>.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Element field className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">options</span></dt>
							<dd>Array of options</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
						</dl>


						<h5><span class="value">tag</span></h5>
						<p>
							Tag input. Custom entity for tag input. Will accept a valid tag or a tag id.
						</p>
						<h6>Options</h6>
						<dl class="options">
							<dt><span class="value">label</span></dt>
							<dd>Label of entity</dd>
							<dt><span class="value">value</span></dt>
							<dd>Value of entity</dd>
							<dt><span class="value">id</span></dt>
							<dd>Element id in HTML</dd>
							<dt><span class="value">class</span></dt>
							<dd>Field element className in HTML</dd>
							<dt><span class="value">required</span></dt>
							<dd>Is data required</dd>
							<dt><span class="value">error_message</span></dt>
							<dd>Error message</dd>
							<dt><span class="value">hint_message</span></dt>
							<dd>Hint message</dd>
							<dt><span class="value">autocomplete</span></dt>
							<dd>Allow autocomplete</dd>
							<dt><span class="value">pattern</span></dt>
							<dd>Regex pattern to match</dd>
							<dt><span class="value">min</span></dt>
							<dd>Minimum length of value</dd>
							<dt><span class="value">max</span></dt>
							<dd>Maximum length of value</dd>
						</dl>


						<h5><span class="value">user_id</span></h5>
						<p>
							user_id input. Custom entity for user_id input validation. Will accept a valid user_id only.
							This type cannot be rendered directly, and therefor a renderable type must be specified 
							when creating a form input, for entities of type user_id.
						</p>
						<p>
							This is commonly being used to validate values sent from the frontend using an input
							type hidden, or a select.
						</p>
						<p>
							The options available for user_id, depends entirely on the needed rendering types.
						</p> 

						<h5><span class="value">item_id</span></h5>
						<p>
							item_id input. Custom entity for item_id input. Will accept a valid item_id only.
							This type cannot be rendered directly, and therefor a renderable type must be specified 
							when creating a form input, for entities of type item_id.
						</p>
						<p>
							This is commonly being used to validate values sent from the frontend using an input
							type hidden, or a select.
						</p>
						<p>
							The options available for item_id, depends entirely on the needed rendering types.
						</p> 

					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>In Itemtype Class constructor</h5>

							<p>Shortest possible, "name", type string:</p>
							<code>$this->addToModel("name"));</code>

							<p>A required string entity with the name "lastname":</p>
							<code>$this->addToModel("lastname", [
	"type" => "string",
	"label" => "Enter lastname",
	"required" => true,
	"hint_message" => "Type lastname now. Later not an option.",
	"error_message" => "Lastname must be string or it is confusing."
]);</code>


							<p>A select entity with the name "favorite_color":</p>
							<code>$this->addToModel("selected_option", [
	"type" => "select",
	"label" => "Choose your favorite color",
	"options" => ["" => "Select option", "1" => "White", "2" => "Light gray"],
	"hint_message" => "Select a color",
	"error_message" => "Color must be selected"
]);</code>


							<p>A required radiobuttons entity with the name "gender":</p>
							<code>$this->addToModel("gender", [
	"type" => "radiobuttons",
	"label" => "Gender",
	"options" => ["yes" => "Yes", "no" => "No"],
	"required" => true,
	"hint_message" => "Choose gender",
	"error_message" => "One must be selected"
]);</code>


							<p>A required files entity with the name "screenshots":</p>
							<code>$this->addToModel("screenshots", [
	"type" => "files",
	"label" => "Screenshots",
	"required" => true,
	"max" => 20,
	"min_height" => 1000,
	"allowed_proportions" => round(16/9, 4),
	"hint_message" => "Type * files",
	"error_message" => "Files must be added"
]);</code>

						</div>

					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>foreach</li>
								<li>switch...case</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Model::setProperty</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Model::getPostedEntities">
				<div class="header">
					<h3>Model::getPostedEntities</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Model::getPostedEntities</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								Model::getPostedEntities();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Get posted values for all entities in the model of the class the method is invoked on.
						</p>
						<p>
							This method will look in the $_POST array for any entities of it's model, and map values
							to the model entity value property.
						</p>
						<p>
							When getting posted values with this method, you are sure to get any value posted, in
							a sanitized format. The values will also be available for built in validation.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>
						<p>None</p>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p>
							<span class="type">Void</span> The method populates the model entities but does not 
							return anything.
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>
								If you add a <span class="var">name</span> property to your model, like this:
							</p>
							<code>$model->addToModel("name", ["type" => "string"]);</code>
							<p>
								Then getPostedEntities can be used to retrieve any data posted to this property
								and make it available via your class, like this:
							</p>
							<code>$_POST["name"] = "Test name";
$model->getPostedEntities();

print $model->getProperty("name", "value");</code>
							<p>Outputs <span class="value">Test Name</span></p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>if...else</li>
								<li>foreach</li>
								<li>isset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>getPostPassword</li>
								<li>getPost</li>
								<li>Model::getProperty</li>
								<li>Model::setProperty</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Model::validateList">
				<div class="header">
					<h3>Model::validateList</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Model::validateList</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Model::validateList(
									<span class="type">Array</span> <span class="var">$list</span> 
									[, <span class="type">Integer</span> <span class="var">$item_id</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Validate a list of model entity names. Receives Array of names to validate, and optionally an
							item_id for <em>unique</em> checks.
						</p>
						<p>
							If validation identifies errors, all values are sanitised for screenrendering and false is returned.
						</p>
						<p>
							If you are seeking to validate newly posted values, remember to invoke
							<em>getPostedEntities</em> first – only then will the values be available in
							the model.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$list</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Array of entity names to check
								</div>
							</dd>
							<dt><span class="var">$item_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> Optional item_id to use for <em>unique</em> validation
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> true on successful validation without errors. false on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>To validate the entities "name", "title" and "phone":</p>
							<code>$this->validateList("name","title","phone");</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>foreach</li>
								<li>count</li>
								<li>isset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>prepareForHTML</li>
								<li>Model::getProperty</li>
								<li>Model::setProperty</li>
								<li>Model::validate</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Model::validate">
				<div class="header">
					<h3>Model::validate</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Model::validate</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Model::validate(
									<span class="type">String</span> <span class="var">$name</span> 
									[, <span class="type">Integer</span> <span class="var">$item_id</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Validate the value of a model entity, based on specified validation rules.</p>
						<p>
							Adds an error message to the global message handler, in case of error.
						</p>
						<p>
							If you are seeking to validate newly posted values, remember to invoke
							<em>getPostedEntities</em> first – only then will the values be available in
							the model.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$name</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Name of entity names to check
								</div>
							</dd>
							<dt><span class="var">$item_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> Optional item_id to use for <em>unique</em> validation
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> true on success, false on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>To validate the entities "title":</p>
							<code>$this->validate("title");</code>
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
								<li>message()->addMessage</li>
								<li>Model::getProperty</li>
								<li>Model::setProperty</li>
								<li>Model::isUnique</li>
								<li>Model::isString</li>
								<li>Model::isHTML</li>
								<li>Model::isFiles</li>
								<li>Model::isNumber</li>
								<li>Model::isInteger</li>
								<li>Model::isEmail</li>
								<li>Model::isTelephone</li>
								<li>Model::isPassword</li>
								<li>Model::isDate</li>
								<li>Model::isDatetime</li>
								<li>Model::isChecked</li>
								<li>Model::isTag</li>
								<li>Model::isUser</li>
								<li>Model::isItem</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Model::getModel">
				<div class="header">
					<h3>Model::getModel</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Model::getModel</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Model::getModel();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get the internal model entity array, with all current properties.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>
						<p>None</p>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> Current model entity Array.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						<p>None</p>
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

			<div class="function" id="Model::setProperty">
				<div class="header">
					<h3>Model::setProperty</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Model::setProperty</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								Model::setProperty(
									<span class="type">String</span> <span class="var">$name</span> 
									, <span class="type">String</span> <span class="var">$property</span>
									, <span class="type">Mixed</span> <span class="var">$value</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Set or update property in Internal Model entity Array. Can be used to override a value
							at any point in the process. The supported properties can be found under <em>addToModel</em>.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$name</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Name of entity for property to set
								</div>
							</dd>
							<dt><span class="var">$property</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Property to set
								</div>
							</dd>
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Mixed</span> Array or String containing value.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Void</span></p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$postModel->setProperty("headline", "hint_message", "Oh no, third time? Really?");</code>
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

			<div class="function" id="Model::getProperty">
				<div class="header">
					<h3>Model::getProperty</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Model::getProperty</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Mixed</span> = 
								Model::getProperty(
									<span class="type">String</span> <span class="var">$name</span> 
									, <span class="type">String</span> <span class="var">$property</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Get property value of name, from current Model entity array. Will use the default_values as fallback values
							if specified property has not been set.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$name</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Name of entity for property to get
								</div>
							</dd>
							<dt><span class="var">$property</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Property to get
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Mixed</span> String or Array with value, or false if none exists.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$postModel->getProperty("headline", "value");</code>
						</div>
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

		</div>
	</div>

</div>
