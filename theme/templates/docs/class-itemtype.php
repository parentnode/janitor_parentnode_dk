<div class="scene docpage i:docpage">
	<h1>Itemtype Class</h1>
	<h2>Data manipulation methods</h2>

	<p>
		All content in Janitor is stored as Items of different types. You can define your own itemtypes (for customized
		data models) or use one of the
		built-in types. All item <em>type</em> classes extends the Itemtype class, which again extends the Model class. 
		These together provides the data modelling, manipulation and validation functionality.
	</p>
	<p>
		The Itemtype class provides generic ways of creating, updating and deleting your Items as well as
		adding any standard item properties, like tags, media, comments, prices or subscription method.
	</p>
	<p>
		While this functionality is fully covered by the default Janitor templates and the interface components offered
		in the Janitor HTML (JML) class, this documentation allows you to build custom flows. The following methods 
		should always be invoked through an instance of a <em>type</em> class, which provides
		the correct <em>itemtype</em> context.
	</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="Itemtype::save">
				<div class="header">
					<h3>Itemtype::save</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::save</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|false</span> = 
								Itemtype::save(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Creates a new item and add the values POST'ed alongside the request – if values validate
							according to model defined in type class.
						</p>
						<p>
							The method will look for any entities defined in the applied <em>type</em> class, or inherited
							from the Model class. If a value is passed (and it validates), it will be added to the new item. 
						</p>
						<p>
							A unique <em>sindex</em> value will be generated upon save, to provide a SEO-friendly id,
							which can be used to reference the item in URL's. Please note, that the sindex value might change
							when values of the item is modified at a later point.
						</p>
						<p>
							A callback to an optional <em>saved</em> method is invoked after generic save has completed.
							To receive this callback, declare a <em>saved</em> method in your <em>type</em> class.
						</p>
						<p>
							For completely customized save operations, the <em>save</em> method can be overwritten in
							your <em>type</em> class.
						</p>
						<p>
							This is an API-method. It is designed to receive an Array of current REST parameters as it's
							only parameter. In addition to the REST instructions, all other values are sent as inputs
							via POST. The <em>save</em> method should only be invoked through a <em>type</em> class instance.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"save"</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_POST</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Values which can sent via POST 
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">published_at</span></dt>
										<dd>Timestamp for time of publishing</dd>
										<dt><span class="value">status</span></dt>
										<dd>Status of the new item</dd>
										<dt><span class="value">#entity-name#</span></dt>
										<dd>Set the value of an entity that exists in the model</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_FILES[<span class="value">variant</span>]</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> File(s) to add to the item according to entity specification.
								</div>
								<div class="details">
									<h5>Values provided for each file</h5>
									<dl class="options">
										<dt><span class="value">name</span></dt>
										<dd>Name of media</dd>
										<dt><span class="value">tmp_name</span></dt>
										<dd>Temp path to uploaded media file</dd>
										<dt><span class="value">type</span></dt>
										<dd>Mimetype, like image/jpeg, video/mp4)</dd>
										<dt><span class="value">error</span></dt>
										<dd>Only populated in case of an error</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p>
							<span class="type">Array|false</span> Returns an array containing the newly created item on success.
							False is returned if item creating fails.
						</p>
						<p>
							One or more status messages will also be added to the message object, 
							depending on success or failure.
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						<div class="example">
							<h5>Saving an item</h5>
							<p>If we fill the POST Array, to simulate a POST request to your script, like this:</p>
							<code>$_POST["name"] = "Name of new post item";
$_POST["description"] = "Description of new post item";</code>
							<p>
								Invoking the following methods, will create a new post item, with the <em>name</em> and
								<em>description</em> properties filled out.
							</p>
							<code>$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->save(["save"]);</code>
						</div>

						<div class="example">
							<h5>Uploading a file on save</h5>
							<p>
								If the following values were present after a POST request to your script, and the path in tmp_name actually
								pointing to said png:</p>
							<code>$_POST["name"] = "New post item with file";
$_POST["description"] = "Wow, I've got a file";
$_FILES["mediae"] = [
	"type" => ["image/png"], 
	"name" => ["file.png"], 
	"tmp_name" => ["/tmp/xyz-abc"], 
	"error" => [""]
];</code>
							<p>
								Invoking the following methods, will create a new post item, with the <em>name</em> and
								<em>description</em> properties filled out and a file added to the general media collection.
							</p>
							<code>$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->save(["save"]);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>foreach</li>
								<li>preg_match</li>
								<li>implode</li>
								<li>method_exists</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Itemtype::saveItem</li>
								<li>Itemtype::status</li>
								<li>Itemtype::sindex</li>
								<li>Itemtype::addMedia</li>
								<li>Itemtype::addSingleMedia</li>
								<li>Model::getPostedEntities</li>
								<li>Model::validateList</li>
								<li>Model::getModel</li>
								<li>Model::getProperty</li>
								<li>Query::checkDbExistence</li>
								<li>Query::sql</li>
								<li>Items::getItem</li>
								<li>Log::addLog</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::update">
				<div class="header">
					<h3>Itemtype::update</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::update</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|false</span> = 
								Itemtype::update(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Updates an item using the values POST'ed alongside the request – if values validate
							according to model defined in type class.
						</p>
						<p>
							The method will look for any entities defined in the applied <em>type</em> class, or inherited
							from the Model class. If a value is passed (and it validates), it will be updated on the selected item. 
						</p>
						<p>
							If the <em>name</em> value is changed, a unique <em>sindex</em> value will be generated upon update, to provide a SEO-friendly id,
							which can be used to reference the item in URL's.
						</p>
						<p>
							A callback to an optional <em>updated</em> method is invoked after generic update has completed.
							To receive this callback, declare a <em>updated</em> method in your <em>type</em> class.
						</p>
						<p>
							For completely customized update operations, the <em>update</em> method can be overwritten in
							your <em>type</em> class.
						</p>
						<p>
							This is an API-method. It is designed to receive an Array of current REST parameters as it's
							only parameter. In addition to the REST instructions, all other values are sent as inputs
							via POST. The <em>update</em> method should only be invoked through a <em>type</em> class instance.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"update"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_POST</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Values which can sent via POST 
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">published_at</span></dt>
										<dd>Timestamp for time of publishing</dd>
										<dt><span class="value">#entity-name#</span></dt>
										<dd>Set the value of an entity that exists in the model</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_FILES[<span class="value">variant</span>]</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> File(s) to add to the item according to entity specification.
								</div>
								<div class="details">
									<h5>Values provided for each file</h5>
									<dl class="options">
										<dt><span class="value">name</span></dt>
										<dd>Name of media</dd>
										<dt><span class="value">tmp_name</span></dt>
										<dd>Temp path to uploaded media file</dd>
										<dt><span class="value">type</span></dt>
										<dd>Mimetype, like image/jpeg, video/mp4)</dd>
										<dt><span class="value">error</span></dt>
										<dd>Only populated in case of an error</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p>
							<span class="type">Array|false</span> Returns an array containing the updated item on success.
							False is returned if item update fails.
						</p>
						<p>
							One or more status messages will also be added to the message object, 
							depending on success or failure.
						</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						<div class="example">
							<h5>Updating simple values</h5>
							<p>With the a POST request like this:</p>
							<code>$_POST["name"] = "Updated name of post item 221";
$_POST["description"] = "Updated description of post item 221";</code>
							<p>
								Invoking the following methods, will update the post item with item_id = 221, setting
								the <em>name</em> and
								<em>description</em> properties as filled out.
							</p>
							<code>$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->update(["update", 221]);</code>
						</div>


						<div class="example">
							<h5>Uploading two files</h5>
							<p>
								If the following values were included in a POST request to your script, and the paths in tmp_name actually
								pointing to said png and jpg:</p>
							<code>$_POST["name"] = "New post item with files";
$_POST["description"] = "Wow, I've got two files";
$_FILES["mediae"] = [
	"type" => ["image/png", "image/jpeg"],
	"name" => ["file png", "file jpg"],
	"tmp_name" => ["/tmp/tests/test.png", "/tmp/tests/test.jpg"],
	"error" => ["", ""]
];</code>
							<p>
								Invoking the following methods, will update a the post item, with the values from <em>name</em> and
								<em>description</em> and add the files to the general media collection.
							</p>	
							<code>$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->update(["update", 221]);</code>
						</div>


					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>foreach</li>
								<li>preg_match</li>
								<li>implode</li>
								<li>method_exists</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Itemtype::saveItem</li>
								<li>Itemtype::status</li>
								<li>Itemtype::sindex</li>
								<li>Itemtype::addMedia</li>
								<li>Itemtype::addSingleMedia</li>
								<li>Model::getPostedEntities</li>
								<li>Model::validateList</li>
								<li>Model::getModel</li>
								<li>Model::getProperty</li>
								<li>Query::checkDbExistence</li>
								<li>Query::versionControl</li>
								<li>Query::sql</li>
								<li>Items::getItem</li>
								<li>Log::addLog</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::status">
				<div class="header">
					<h3>Itemtype::status</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::status</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Itemtype::status(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							All items can exist in two states: enabled or disabled. This is also referred to as the
							status of the item. This method allows you to change the current status of the item.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"status"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
										<dt><span class="value">2</span></dt>
										<dd>status (0 or 1)</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> <span class="value">true</span> on successful change, <span class="value">false</span> on failure.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>Changing item status</h5>
							<p>To enable an item:</p>
							<code>$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->status(["status", 221, 1]);</code>
							<p>To disable an item:</p>
							<code>$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->status(["status", 221, 0]);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>isset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Message::addMessage</li>
								<li>Log::addLog</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::owner">
				<div class="header">
					<h3>Itemtype::owner</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::owner</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Itemtype::owner(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Change the owner of an item. An item will always have one primary owner – use this method to change it.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"owner"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_POST</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Values which can sent via POST 
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">item_ownership</span></dt>
										<dd>user_id for new item owner</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> <span class="value">true</span> on successful change, <span class="value">false</span> on failure</p>.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>Changing item owner</h5>
							<p>To set owner of item 221 to user_id 5:</p>

							<code>$_POST["item_ownership"] = 5;

$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->owner(["owner", 221]);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Model::getPostedEntities</li>
								<li>Model::getProperty</li>
								<li>Query::sql</li>
								<li>Log::addLog</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::delete">
				<div class="header">
					<h3>Itemtype::delete</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::delete</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Itemtype::delete(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Deletes an item and all related information and assets – if this is allowed for the specified item. 
							An item which has related subscriptions cannot be deleted.
						</p>
						<p>
							A callback to an optional <em>deleting</em> method is invoked just before generic delete is executed.
							To receive this callback, declare a <em>deleting</em> method in your <em>type</em> class.
						</p>
						<p>
							A callback to an optional <em>deleted</em> method is invoked after generic delete has completed.
							To receive this callback, declare a <em>deleted</em> method in your <em>type</em> class.
						</p>
						<p>
							For completely customized delete operations, the <em>delete</em> method can be overwritten in
							your <em>type</em> class.
						</p>
						<p>
							This is an API-method. It is designed to receive an Array of current REST parameters as it's
							only parameter. In addition to the REST instructions, all other values are sent as inputs
							via POST. The <em>delete</em> method should only be invoked through a <em>type</em> class instance.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"delete"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> returns true on success, false on failure.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>To delete the item with item_id = 221:</p>
							<code>$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->delete(["delete", 221]);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>method_exists</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>FileSystem::removeDirRecursively</li>
								<li>Query::sql</li>
								<li>Log::addLog</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::addTag">
				<div class="header">
					<h3>Itemtype::addTag</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::addTag</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Mixed</span> = 
								Itemtype::addTag(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Add a tag to an item based on tag_id or string with valid tag syntax - if it has not already
							been added to the same item. Creates tag if it doens't already exist globally.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"addTag"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_POST</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Values which can sent via POST 
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">tags</span></dt>
										<dd>Tag string or id</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Mixed</span> Tag data <span class="value">array</span> on success, <span class="value">false</span> on error (or if tag already exists on item).</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>Adding a tag, based on a valid tag string</h5>
							<p>
								If the following values were included in a POST request to your script, and the paths in tmp_name actually
								pointing to said png and jpg:</p>
							<code>$_POST["tags"] = "post:My first tag";</code>
							<p>
								Invoking the following methods, will add a "post:My first tag"-tag to item 221.
							</p>	
							<code>$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->addTag(["addTag", 221]);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>preg_match</li>
								<li>is_numeric</li>
								<li>isset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Model::getPostedEntities</li>
								<li>Model::validateList</li>
								<li>Model::getProperty</li>
								<li>Query::sql</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::deleteTag">
				<div class="header">
					<h3>Itemtype::deleteTag</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::deleteTag</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Itemtype::deleteTag(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Delete tag from item. The tag itself will not be deleted – only the association with the specified item.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"deleteTag"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
										<dt><span class="value">2</span></dt>
										<dd>tag_id</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> <span class="value">true</span> on success, <span class="value">false</span> on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>To delete the tag with tag_id 21 from item with item_id = 221:</p>
							<code>$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->deleteTag(["deleteTag", 221, 21]);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>preg_match</li>
								<li>is_numeric</li>
								<li>isset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::result</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::upload">
				<div class="header">
					<h3>Itemtype::upload</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::upload</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Itemtype::upload(
									<span class="type">Integer</span> <span class="var">$item_id</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Internal upload handler with complex asset validation. The method is only uploading
							validated files to the private library folder. No data will be added to the database.
						</p>
						<p>
							This method is used as the internal uploader for addMedia, addSingleMedia
							and other API methods in Janitor, that deals with uploading of files.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$item_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> item_id to add uploads to
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional settings
								</div>
								<div class="details">
									<h5>Options</h5>
									<dl class="options">
										<dt><span class="value">input_name</span></dt>
										<dd>Name of input used for upload (Defaults to <em>mediae</em>)</dd>
										<dt><span class="value">variant</span></dt>
										<dd>Variant to use for upload</dd>
										<dt><span class="value">auto_add_variant</span></dt>
										<dd>Automatically add variant to uploads</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_FILES[<span class="value">variant</span>]</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> File(s) to add to the item according to entity specification.
								</div>
								<div class="details">
									<h5>Values provided for each file</h5>
									<dl class="options">
										<dt><span class="value">name</span></dt>
										<dd>Name of media</dd>
										<dt><span class="value">tmp_name</span></dt>
										<dd>Temp path to uploaded media file</dd>
										<dt><span class="value">type</span></dt>
										<dd>Mimetype, like image/jpeg, video/mp4)</dd>
										<dt><span class="value">error</span></dt>
										<dd>Only populated in case of an error</dd>
									</dl>
								</div>
							</dd>

						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> Array with successful upload values.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>No examples</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>foreach</li>
								<li>switch ... case</li>
								<li>preg_match</li>
								<li>filesize</li>
								<li>ZipArchive</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Itemtype::getPostedEntities</li>
								<li>Itemtype::validateList</li>
								<li>Itemtype::identifyUploads</li>
								<li>FileSystem::removeDirRecursively</li>
								<li>FileSystem::makeDirRecursively</li>
								<li>Message::addMessage</li>
								<li>randomKey</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::addMedia">
				<div class="header">
					<h3>Itemtype::addMedia</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::addMedia</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|false</span> = 
								Itemtype::addMedia(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Upload, validate and add one or more files to item.</p>
						<p>
							Subsequent uploads will be added to previously uploaded files.
						</p>
						<p>
							This is an API-method. It is designed to receive an Array of current REST parameters as it's
							only parameter. In addition to the REST instructions, all other values are sent as inputs
							via POST. The <em>addMedia</em> method should only be invoked through a <em>type</em> class instance.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"addMedia"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
										<dt><span class="value">2</span></dt>
										<dd>variant</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_FILES[<span class="value">variant</span>]</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> File(s) to add to the item according to entity specification.
								</div>
								<div class="details">
									<h5>Values provided for each file</h5>
									<dl class="options">
										<dt><span class="value">name</span></dt>
										<dd>Name of media</dd>
										<dt><span class="value">tmp_name</span></dt>
										<dd>Temp path to uploaded media file</dd>
										<dt><span class="value">type</span></dt>
										<dd>Mimetype, like image/jpeg, video/mp4)</dd>
										<dt><span class="value">error</span></dt>
										<dd>Only populated in case of an error</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> Array of uploaded asset data. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>No examples</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>foreach</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Itemtype::upload</li>
								<li>Model::getPostedEntities</li>
								<li>Query::checkDbExistence</li>
								<li>Query::sql</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::addSingleMedia">
				<div class="header">
					<h3>Itemtype::addSingleMedia</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::addSingleMedia</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|false</span> = 
								Itemtype::addSingleMedia(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Upload, validate and add one single files to item.</p>
						<p>
							Subsequent uploads will delete previously uploaded files.
						</p>
						<p>
							This is an API-method. It is designed to receive an Array of current REST parameters as it's
							only parameter. In addition to the REST instructions, all other values are sent as inputs
							via POST. The <em>addSingleMedia</em> method should only be invoked through a <em>type</em> class instance.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"addMedia"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
										<dt><span class="value">2</span></dt>
										<dd>variant</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_FILES[<span class="value">variant</span>]</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> File to add to the item according to entity specification. 
									On single file entities new
									uploads will overwrite any previous uploads.
								</div>
								<div class="details">
									<h5>Values provided for each file</h5>
									<dl class="options">
										<dt><span class="value">name</span></dt>
										<dd>Name of media</dd>
										<dt><span class="value">tmp_name</span></dt>
										<dd>Temp path to uploaded media file</dd>
										<dt><span class="value">type</span></dt>
										<dd>Mimetype, like image/jpeg, video/mp4)</dd>
										<dt><span class="value">error</span></dt>
										<dd>Only populated in case of an error</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> Array of uploaded asset data. False on error.</p>
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
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Itemtype::upload</li>
								<li>Model::getPostedEntities</li>
								<li>Query::checkDbExistence</li>
								<li>Query::sql</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::deleteMedia">
				<div class="header">
					<h3>Itemtype::deleteMedia</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::deleteMedia</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Itemtype::deleteMedia(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Delete media from item, including all images generated from this media.</p>
						<p>
							This is an API-method. It is designed to receive an Array of current REST parameters as it's
							only parameter. In addition to the REST instructions, all other values are sent as inputs
							via POST. The <em>updateMediaName</em> method should only be invoked through a <em>type</em> class instance.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"deleteMedia"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
										<dt><span class="value">2</span></dt>
										<dd>variant</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> true if deletion succeeded, false if it failed.</p>
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
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>FileSystem::removeDirRecursively
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::updateMediaName">
				<div class="header">
					<h3>Itemtype::updateMediaName</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::updateMediaName</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Itemtype::updateMediaName(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Update name of media using the value of <span class="var">name</span> which must be POST'ed alongside the request.</p>
						<p>
							This is an API-method. It is designed to receive an Array of current REST parameters as it's
							only parameter. In addition to the REST instructions, all other values are sent as inputs
							via POST. The <em>updateMediaName</em> method should only be invoked through a <em>type</em> class instance.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"updateMediaName"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
										<dt><span class="value">2</span></dt>
										<dd>variant</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_POST</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Values which can sent via POST 
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">name</span></dt>
										<dd>New name for media</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> <span class="value">true</span> upon successful name update, <span class="value">false</span> on failure.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>Imagine that the following value was included in a POST request to your script:</p>
							<code>$_POST["name"] = "New media name";</code>
							<p>
								Invoking the following method, will update the name of media <span class="value">single_media</span> 
								for item_id <span class="value">221</span> to <span class="value">New media name</em>.
							</p>
							<code>$IC = new Items();
$post_model = $IC->typeObject("post");
$post_model->updateMediaName(["updateMediaName", 221, "single_media"]);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>getPost</li>
								<li>Query::sql</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::updateMediaOrder">
				<div class="header">
					<h3>Itemtype::updateMediaOrder</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::updateMediaOrder</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Itemtype::updateMediaOrder(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Changes order of the media in a media collection.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"updateMediaOrder"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_POST</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Values which can sent via POST 
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">order</span></dt>
										<dd>Comma separated list of media id's in desired order</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> <span class="value">true</span> if update was successful, <span class="value">false</span> on failure.</p>
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
								<li>count</li>
								<li>explode</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>getPost</li>
								<li>Query::sql</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::addComment">
				<div class="header">
					<h3>Itemtype::addComment</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::addComment</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Mixed</span> = 
								Itemtype::addComment(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Add a user contributed comment to item. Will add the id of the current user to the comment entry.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"addComment"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_POST</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Values which can sent via POST 
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">item_comment</span></dt>
										<dd>Comment text</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Mixed</span> Comment data <span class="value">array</span> on success, <span class="value">false</span> on failure.</p>
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
								<li>count</li>
								<li>date</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::lastInsertId</li>
								<li>Model::getPostedEntities</li>
								<li>Model::validateList</li>
								<li>Model::getProperty</li>
								<li>Items::getComments</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::updateComment">
				<div class="header">
					<h3>Itemtype::updateComment</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::updateComment</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Itemtype::updateComment(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Update existing comment.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"updateComment"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
										<dt><span class="value">2</span></dt>
										<dd>comment_id</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_POST</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Values which can sent via POST 
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">item_comment</span></dt>
										<dd>Updated comment text</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> <span class="value">true</span> on success, <span class="value">false</span> on failure.</p>
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
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Model::getPostedEntities</li>
								<li>Model::validateList</li>
								<li>Model::getProperty</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Itemtype::deleteComment">
				<div class="header">
					<h3>Itemtype::deleteComment</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Itemtype::deleteComment</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Itemtype::deleteComment(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Delete comment entirely.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> of REST parameters sent in current request
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">0</span></dt>
										<dd>"deleteComment"</dd>
										<dt><span class="value">1</span></dt>
										<dd>item_id</dd>
										<dt><span class="value">2</span></dt>
										<dd>comment_id</dd>
									</dl>
								</div>
							</dd>
							<dt><span class="var">$_POST</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Values which can sent via POST 
								</div>
								<div class="details">
									<h5>Values</h5>
									<dl class="options">
										<dt><span class="value">item_comment</span></dt>
										<dd>Updated comment text</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> <span class="value">true</span> on success, <span class="value">false</span> on failure.</p>
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
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Message::addMessage</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
