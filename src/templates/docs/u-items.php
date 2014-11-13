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
						<p>Get item data from items db</p>
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
										<dt><span class="value">id</span></dt>
										<dd>id of item to fetch</dd>
										<dt><span class="value">sindex</span></dt>
										<dd>sindex of item to fetch</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> Array of items or false if no items.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$item = $IC->getItem(array("id" => 13));</code>
							<p>Get a single Item based on the id 13.</p>
						</div>
						<div class="example"><code>$IC = new Item();
$item = $IC->getItem(array("sindex" => "item_name"));</code>
							<p>Get a single Item based on the sindex "item_name".</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

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

			<div class="function" id="Item::getCompleteItem">
				<div class="header">
					<h3>Item::getCompleteItem</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getCompleteItem</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array </span> = 
								Item::getCompleteItem(
									<span class="type">Array</span> <span class="var">$_options</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get complete data of item</p>
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
										<dt><span class="value">id</span></dt>
										<dd>id of item to fetch</dd>
										<dt><span class="value">sindex</span></dt>
										<dd>sindex of item to fetch</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Array</span> Array of item or false if no item.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						
						<div class="example"><code>$IC = new Item();
$item = $IC->getCompleteItem(array("id" => 6));</code>

						<div class="example"><code>$IC = new Item();
$item = $IC->getCompleteItem(array("sindex" => "item_name"));</code>

						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>?</li>
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
						<h4>Returns</h4>
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
						<p>Get all matching items</p>
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
										<dt><span class="value">order</span></dt>
										<dd>Any Sql to order</dd>
										<dt><span class="value">status</span></dt>
										<dd>Returns items with a status of 1 or 0</dd>
										<dt><span class="value">tags</span></dt>
										<dd>Returns all items with specific tag</dd>
										<dt><span class="value">sindex</span></dt>
										<dd>Returns items with specific sindex</dd>
										<dt><span class="value">itemtype</span></dt>
										<dd>Returns post based on an itemtype</dd>
										<dt><span class="value">limit</span></dt>
										<dd>The amount of items to return</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
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
						<h4>Returns</h4>
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
						<p>Can receive items array to use for finding previous item(s) or receive query syntax to perform getItems request on it own</p>
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
						<h4>Returns</h4>
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
						<h4>Returns</h4>
						<p><span class="type">Array|false</span> Array of tags or false if nothing found.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$IC = new Item();
$item = $IC->getItem(array("sindex" => "item_name"));
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

					<div class="uses">
						<h4>Uses</h4>

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
						<h4>Returns</h4>
						<p><span class="type">Array</span> of prices</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>_blank for now</code>
							<p>Get price in Euro from $item_id</p>
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