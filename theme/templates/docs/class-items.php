<div class="scene docpage i:docpage">
	<h1>Items</h1>
	<p>
		What does items class do
	</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">


			<div class="function" id="Item::getUserClass">
					<div class="header">
						<h3>Item::getUserClass</h3>
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
		

			<div class="function" id="Item::getItem">
				<div class="header">
					<h3>Item::getItem</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getItem</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|false</span> = 
								Item::getItem(
									<span class="type">Array</span> <span class="var">$_options</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>getItem() fetches the data of a single Item from the "items" table in the database. It fetches the first Item that matches the criteria defined by the <span class="var">$_options</span> parameter.</p>
						<p>It is also possible to extend the fetched Item with more information from the database.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Associative array containing search criteria and the option to extend the fetched Item.
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">id</span></dt>
										<dd>id of Item to fetch</dd>
										<dt><span class="value">sindex</span></dt>
										<dd>sindex of Item to fetch</dd>
										<dt><span class="value">tags</span></dt>
										<dd>Match Item by one or more tags. Separate multiple tags with semicolon. Tag(s) can be combined with an itemtype.</dd>
										<dt><span class="value">itemtype</span></dt>
										<dd>Match Item by itemtype. Can only be used in combination with one or more tags.</dd>
										<dt><span class="value">extend</span></dt>
										<dd>If set, Janitor's Items::extendItem() function is called on the Item. See <a href="#Item::extendItem">documentation for extendItem()</a>.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> Array of item properties or false if no Item is found.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>Ex. 1a: Get Item with unique identifier</h5>
							<code>$IC = new Items();
$item = $IC->getItem(array("id" => 13));</code>
							<p>Get a single Item based on the id 13. Return value:</p>
							<code>Array
(
    [id] => 13
    [sindex] => my-post
    [status] => 1
    [itemtype] => post
    [user_id] => 2
    [created_at] => 2018-06-06 18:51:55
    [modified_at] => 2018-06-06 18:52:30
    [published_at] => 2018-06-06 18:51:55
)</code>
						</div>
						<div class="example">
							<h5>Ex. 1b: Get Item with unique identifier</h5>
							<code>$IC = new Items();
$item = $IC->getItem(array("sindex" => "my-post"));</code>
							<p>Get a single Item based on the sindex "my-post". Return value:</p>
							<code>Array
(
    [id] => 13
    [sindex] => my-post
    [status] => 1
    [itemtype] => post
    [user_id] => 2
    [created_at] => 2018-06-06 18:51:55
    [modified_at] => 2018-06-06 18:52:30
    [published_at] => 2018-06-06 18:51:55
)</code>
						</div>
						<div class="example">
							<h5>Ex. 2a: Get Item via filtering</h5>
							<code>$IC = new Items();
$item = $IC->getItem(array("tags" => "subject:cats;genre:thriller"));</code>
							<p>Get a single Item based on the tags "subject:cats" and "genre:thriller". Return value:</p>
							<code>Array
(
    [id] => 10
    [sindex] => my-thriller-about-cats
    [status] => 1
    [itemtype] => post
    [user_id] => 2
    [created_at] => 2018-06-07 13:45:12
    [modified_at] => 2018-06-07 13:52:30
    [published_at] => 2018-06-07 13:45:12
)</code>
						</div>
						<div class="example">
							<h5>Ex. 2b: Get Item via filtering</h5>
							<code>$IC = new Items();
$item = $IC->getItem(array("tags" => "subject:cats", "itemtype" => "gallery"));</code>
							<p>Get a single Item based on the tag "subject:cats" and the itemtype "gallery". Return value:</p>					
							<code>Array
(
    [id] => 9
    [sindex] => my-cats-gallery
    [status] => 1
    [itemtype] => post
    [user_id] => 2
    [created_at] => 2018-06-07 13:15:23
    [modified_at] => 2018-06-07 13:32:35
    [published_at] => 2018-06-07 13:15:23
)</code>
						</div>
						<div class="example">
						<h5>Ex. 3: Get Item and extend it</h5>
						<code>$IC = new Items();
$item = $IC->getItem(array("id" => 13, "extend" => true));</code>
							<p>Get a single Item based on the id 13 and extend it with its itemtype info (which is default for the extendItem() function). Return value:</p>
							<code>Array
(
    [id] => 13
    [sindex] => my-post
    [status] => 1
    [itemtype] => post
    [user_id] => 2
    [created_at] => 2018-06-06 18:51:55
    [modified_at] => 2018-06-06 18:52:30
    [published_at] => 2018-06-06 18:51:55
    [item_id] => 13
    [name] => My post
    [classname] => my_custom_CSS_class
    [description] => A short description of my post
    [html] => &lt;p&gtThe content of my post&lt;/p&gt
)</code>
						</div>

					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query</li>
							</ul>
						</div>

					</div>

				</div>
			</div>


			<div class="function" id="Item::getIdFromSindex">
				<div class="header">
					<h3>Item::getIdFromSindex</h3>
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


			<div class="function" id="Item::getSimpleType">
				<div class="header">
					<h3>Item::getSimpleType</h3>
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
						<p>Get item data from items db</p>
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

			<div class="function" id="Item::getRelatedItems">
					<div class="header">
						<h3>Item::getRelatedItems</h3>
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


			<div class="function" id="Item::extendItem">
				<div class="header">
					<h3>Item::extendItem</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">extendItem</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Item::extendItem(
									<span class="type">Array</span> <span class="var">item</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Extend item after already having base information.
						Defined to be able to limit queries when getting information.
						Default only gets type data. Optional data.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$item</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Array of an item
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Array of extra options
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">tags</span></dt>
										<dd>Extend your item with tags</dd>
										<dt><span class="value">prices</span></dt>
										<dd>Extend your item with prices</dd>
										<dt><span class="value">ratings</span></dt>
										<dd>Extend your item with ratings</dd>
										<dt><span class="value">comments</span></dt>
										<dd>Extend your item with comments</dd>
										<dt><span class="value">everything</span></dt>
										<dd>Extend your item with tags, prices, ratings, comments</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> returns array with the full item</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$IC = new Item();
$item = $IC->getItem(array("sindex" => "my_name"));
$item = $IC->extendItem($item);</code>
							<p>Get an item and then extend it.</p>
						</div>

					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

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


			<div class="function" id="Item::extendItems">
					<div class="header">
						<h3>Item::extendItems</h3>
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


			<div class="function" id="Item::getItems">
				<div class="header">
					<h3>Item::getItems</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getItems</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Item::GetItems(
									<span class="type">Array</span> <span class="var">$_options</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all matching items, and put them into an array.</p>
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
										<dt><span class="value">itemtype</span></dt>
										<dd>Returns post based on an itemtype</dd>
										<dt><span class="value">status</span></dt>
										<dd>Returns items with a status of 1 or 0</dd>
										<dt><span class="value">tags</span></dt>
										<dd>Returns all items with specific tag</dd>
										<dt><span class="value">sindex</span></dt>
										<dd>Returns items with specific sindex</dd>

										<dt><span class="value">where</span></dt>
										<dd>Add additional WHERE sql statement to query</dd>

										<dt><span class="value">order</span></dt>
										<dd>Any Sql to order</dd>
										<dt><span class="value">limit</span></dt>
										<dd>The amount of items to return</dd>

										<dt><span class="value">no_readstate</span></dt>
										<dd>Returns items that current user has not marked at read</dd>
										<dt><span class="value">user_id</span></dt>
										<dd>Returns items with given user_id</dd>

										<dt><span class="value">exclude</span></dt>
										<dd>Excludes item id's seperated via semi-colons(;) from query</dd>

										<dt><span class="value">extend</span></dt>
										<dd>Extend items with itemtype info before returning by using janitor function "Item::extendItem".<a href="#Item::extendItem"> Documentation for extendItem()</a></dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> Array of items</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$IC = new Item();
$items = $IC->getItems(array("itemtype" => "post", "status" => 1, "order" => "created_at DESC"));</code>
							<p>Get all items with itemtype "post", status 1 (published), and order by created_at date.</p>
						</div>

						<div class="example"><code>$IC = new Item();
$items = $IC->getItems(array("tags" => "javascript", "limit" => 99));</code>
							<p>Get all items with tag javascript, but don't get more than 99st.</p>
						</div>

						<div class="example"><code>$IC = new Item();
$items = $IC->getItems(["itemtype" => "people", "where" => "name = peter", "extend" => ["tags" => "true"]]);</code>
							<p>Get all items with itemtype "people", where table row "name" has the value "peter" and extend those items with specific itemtype definitions (in this case for "people") and tags.</p>
						</div>

					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

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


			<div class="function" id="Item::getNext">
				<div class="header">
					<h3>Item::getNext</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getNext</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Item::getNext(
									<span class="type">Number</span> <span class="var">$item_id</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Can receive items array to use for finding next item(s) or receive query syntax to perform getItems request on it own</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$item_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Number</span> The id of the item
								</div>
							</dd>

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
										<dt><span class="value">items</span></dt>
										<dd>Array of item(s)</dd>
										<dt><span class="value">count</span></dt>
										<dd>Max number of items</dd>
									</dl>
								</div>
							</dd>
							
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> List of next items</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$items = $IC->getItems(array("itemtype" => $itemtype, "status" => 1, "order" => "items.created_at DESC"));
$next = $IC->getNext(1, array("items" => $items));</code>
						<p>Return Next item array</p><code>Array
(
    [0] => Array
        (
            [id] => 50
            [sindex] => new_project
            [status] => 1
            [itemtype] => project
            [user_id] => 
            [created_at] => 2014-07-28 14:01:40
            [modified_at] => 2014-07-28 14:27:01
            [published_at] => 2014-07-28 14:01:40
        )

)</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

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


			<div class="function" id="Item::getPrev">
				<div class="header">
					<h3>Item::getPrev</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getPrev</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Item::getPrev(
									<span class="type">Number</span> <span class="var">$item_id</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Can receive items array to use for finding previous item(s) or receive query syntax to perform 
							getItems request on its own.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$item_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Number</span> The item id
								</div>
							</dd>

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
										<dt><span class="value">items</span></dt>
										<dd>Array of item(s)</dd>
										<dt><span class="value">count</span></dt>
										<dd>Max number of items</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> List of previous items</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$items = $IC->getItems(array("itemtype" => $itemtype, "status" => 1, "order" => "items.created_at ASC"));
$prev = $IC->getPrev(20, array("items" => $items));</code>
							<p>Return previous item array</p><code>Array
(
    [0] => Array
        (
            [id] => 51
            [sindex] => this_is_the_new_headline
            [status] => 1
            [itemtype] => project
            [user_id] => 
            [created_at] => 2014-07-28 14:29:01
            [modified_at] => 2014-07-28 14:31:52
            [published_at] => 2014-07-28 14:29:01
        )

)</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

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


			<div class="function" id="Item::paginate">
					<div class="header">
						<h3>Item::paginate</h3>
					</div>
					<div class="body">
						<div class="definition">
							<h4>Definition</h4>
							<dl class="definition">
								<dt class="name">Name</dt>
								<dd class="name">Item::paginate</dd>
								<dt class="syntax">Syntax</dt>
								<dd class="syntax"><span class="type">Array</span> = 
									Item::paginate(
										<span class="type">Array</span> <span class="var">$_options</span> 
									);
								</dd>
							</dl>
						</div>
	
						<div class="description">
							<h4>Description</h4>
							<p>Splits a list of items into smaller fragments and returns information required to create meaningful pagination.</p>
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
											<dt><span class="value">pattern</span></dt>
											<dd>Array of options to be sent to <a href=#Item::getItems>Item::getItems</a>, which returns the items to be paginated.</dd>
											<dt><span class="value">limit</span></dt>
											<dd>Maximal number of items per page. Default: 5.</dd>
											<dt><span class="value">sindex</span></dt>
											<dd>If passed <em>without</em> the <span class="value">direction</span> parameter, the pagination will start with the associated item.</dd>
											<dt><span class="value">direction</span></dt>
											<dd>Can be passed in combination with the <span class="value">sindex</span> parameter. If value is <span class="value">next</span>, pagination will start with the item that comes <em>after</em> the item with the specified sindex. If value is <span class="value">prev</span>, will show the items that come immediately <em>before</em> the item with the specified sindex. </dd>
										</dl>
									</div>
								</dd>
							</dl>
						</div>
	
						<div class="return">
							<h4>Return values</h4>
							<p><span class="type">Array</span> Array of items. Contains the subarrays <span class="value">range_items</span> (items in the specified range), <span class="value">next</span> (next items), and <span class="value">prev</span> (previous items). Also contains <span class="value">first_id</span> and <span class="value">last_id</span>, as well as <span class="value">first_sindex</span> and <span class="value">last_sindex</span>, for the items within the specified range. Lastly, it contains the <span class="value">total</span> number of items in the whole list.</p>
						</div>
	
						<div class="examples">
							<h4>Examples</h4>
							<div class="example">
								<h5>Example 1</h5>
								<code>$sindex = "test-item-aaa";
$items = $IC->paginate([
	"limit" => 2, 
	"pattern" => [
		"itemtype" => "tests", 
		"order" => "sindex ASC"
	],
	"sindex" => $sindex
]);</code>
								<p>Returns fragmented list of items with a limit of 2 items per fragment. The beginning of range_items is based on sindex. Sorting order is according to ascending sindex.</p><code>Array
	(
		["range_items"] => Array
			(
				[0] => Array 
					(
						[id] => 420,
						[sindex] => test-item-aaa,
						[status] => 0,
						[itemtype] => tests,
						[user_id] => 
						[created_at] => 2019-04-28 19:15:13,
						[modified_at] => 2019-04-28 19:15:13,
						[published_at] => 2019-04-28 19:15:13
					)
					
				[1] => Array
					(
						[id] => 421,
						[sindex] => test-item-bbb,
						[status] => 0,
						[itemtype] => tests,
						[user_id] => 
						[created_at] => 2019-04-28 19:15:13,
						[modified_at] => 2019-04-28 19:15:13,
						[published_at] => 2019-04-28 19:15:13,	
					)
					
			)
			
		["next"] => Array 
			(
				[0] => Array
					(
						[id] => 422,
						[sindex] => test-item-ccc,
						[status] => 0,
						[itemtype] => tests,
						[user_id] => 
						[created_at] => 2019-04-28 19:15:13,
						[modified_at] => 2019-04-28 19:15:13,
						[published_at] => 2019-04-28 19:15:13	
					)
				
			)
		["prev"] => Array ()
		[first_id] => 420,
		[last_id] => 421,
		[first_sindex] => test-item-aaa,
		[last_sindex] => test-item-bbb,
		[total] => 3 
	)</code>
							</div>
	
							<div class="example">
								<h5>Example 2</h5>
								<code>$sindex = "test-item-bbb";
$items = $IC->paginate(array(
	"limit" => 2, 
	"pattern" => array(
		"itemtype" => "tests", 
		"order" => "sindex ASC"
	),
	"sindex" => $sindex,
	"direction" => "prev"
));</code>
								<p>Returns fragmented list of items with a limit of 2 items per fragment. Sorting order of all items is according to ascending sindex. The item in range_items precedes the item with the specified sindex.
</p><code>Array
	(
		["range_items"] => Array
			(
				[0] => Array 
					(
						[id] => 420,
						[sindex] => test-item-aaa,
						[status] => 0,
						[itemtype] => tests,
						[user_id] => 
						[created_at] => 2019-04-28 19:15:13,
						[modified_at] => 2019-04-28 19:15:13,
						[published_at] => 2019-04-28 19:15:13
					)
				
			)
			
		["next"] => Array 
			(
				[0] => array
					(
						[id] => 421,
						[sindex] => test-item-bbb,
						[status] => 0,
						[itemtype] => tests,
						[user_id] => 
						[created_at] => 2019-04-28 19:15:13,
						[modified_at] => 2019-04-28 19:15:13,
						[published_at] => 2019-04-28 19:15:13,	
					)
					[1] => array
					(
						[id] => 422,
						[sindex] => test-item-ccc,
						[status] => 0,
						[itemtype] => tests,
						[user_id] => 
						[created_at] => 2019-04-28 19:15:13,
						[modified_at] => 2019-04-28 19:15:13,
						[published_at] => 2019-04-28 19:15:13	
					)
				
			)
		["prev"] => Array
			(
			)
		[first_id] => 420,
		[last_id] => 420,
		[first_sindex] => test-item-aaa,
		[last_sindex] => test-item-aaa,
		[total] => 3 
	)</code>
							</div>
						</div>
	
						<div class="dependencies">
							<h4>Dependencies</h4>
	
							<div class="php">
								<!-- list php functions used by function -->
								<h5>PHP</h5>
								<ul>
									<li>array</li>
									<li>count</li>
									<li>isset</li>
									<li>unset</li>
								</ul>
							</div>
	
							<div class="janitor">
								<!-- list janitor functions used by function -->
								<h5>Janitor</h5>
								<ul>
									<li>Items::extendItem</li>
									<li>Items::getIdFromSindex</li>
									<li>Items::getItems</li>
									<li>Items::getNext</li>
									<li>Items::getPrev</li>
								</ul>
							</div>
	
						</div>
	
					</div>
			</div>


			<div class="function" id="Item::getMediae">
					<div class="header">
						<h3>Item::getMediae</h3>
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


			<div class="function" id="Item::sliceMedia">
					<div class="header">
						<h3>Item::sliceMedia</h3>
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


			<div class="function" id="Item::getOwners">
					<div class="header">
						<h3>Item::getOwners</h3>
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


			<div class="function" id="Item::getTags">
				<div class="header">
					<h3>Item::getTags</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getTags</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|false</span> = 
								Item::getTags(
									<span class="type">Array</span> <span class="var">$_options</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get tag, optionally based on item_id, limited to context, or just check if specific tag exists</p>
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
										<dt><span class="value">$item_id</span></dt>
										<dd>Get tag based on $item_id</dd>
										<dt><span class="value">$tag_id</span></dt>
										<dd>Get tag based on it's id</dd>
										<dt><span class="value">context</span></dt>
										<dd>The tag context.</dd>
										<dt><span class="value">value</span></dt>
										<dd>The tag value.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> Array of tags or false if nothing found.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$IC = new Item();
$item = $IC->getItem(array("sindex" => "test-name"));
$tag = $IC->getTags(array("item" => $item[id]));</code>
							<p>Get the tag based on item.</p>
						</div>

						<div class="example"><code>$IC = new Item();
$tag = $IC->getTags(array("context" => "hello"));</code>
							<p>Get list of tags with the context of "hello".</p>
						</div>

						<div class="example"><code>$IC = new Item();
$tag = $IC->getTags(array("value" => "javascript"));</code>
							<p>Get list of tags with the value of "javascript".</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query</li>
							</ul>
						</div>

					</div>

				</div>
			</div>


			<div class="function" id="Item::getComments">
					<div class="header">
						<h3>Item::getComments</h3>
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


			<div class="function" id="Item::getPrices">
				<div class="header">
					<h3>Item::getPrices</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getPrices</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								Item::getPrices(
									<span class="type">Array</span> <span class="var">$_options</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get the price of item. </p>
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
										<dt><span class="value">$item_id</span></dt>
										<dd>Fetch the price from this item</dd>
										<dt><span class="value">$country</span></dt>
										<dd>Get price based on country</dd>
										<dt><span class="value">currency</span></dt>
										<dd>Get price based on currency</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> of prices</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>_blank for now</code>
							<p>Get price in Euro from $item_id</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

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


			<div class="function" id="Item::getSubscriptionMethod">
					<div class="header">
						<h3>Item::getSubscriptionMethod</h3>
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
