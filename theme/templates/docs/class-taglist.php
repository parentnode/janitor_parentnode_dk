<div class="scene docpage i:docpage">
	<h1>The Taglist Class</h1>
	<p>A taglist is a sortable collection of tags. It allows you to create a list of selected tags and 	arrange them in the order you choose. With the taglist you can then create lists of tag-related content, ordered by the taglist, rather than the default order of tags.</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="Taglist::getAllTags">
				<div class="header">
					<h3>Taglist::getAllTags</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Taglist::getAllTags</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								Taglist::getAllTags();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all the tags from the entire system.</p>

					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">None</span></dt>
							<dd>
								<div class="summary">
									<p>None</p>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> An array of at least one tag object. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$TC = new Taglist();

$tags = $TC->getAllTags();</code>
							<p>Get all the tags from the entire system. Return value:</p>
							<code>Array
(
    [0] => Array
        (
            [id] => 168
            [context] => test
            [value] => tag1
            [description] => 
        )
    [1] => Array
        (
            [id] => 169
            [context] => test
            [value] => tag2
            [description] => 
        )
    [2] => Array
        (
            [id] => 170
            [context] => test
            [value] => tag3
            [description] => 
        )
)
</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li><p>None</p></li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list php functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::results</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="function" id="Taglist::getTaglists">
				<div class="header">
					<h3>Taglist::getTaglists</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Taglist::getTaglists</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								Taglist::getTaglists();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all the taglists from the entire system.</p>

					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">None</span></dt>
							<dd>
								<div class="summary">
									<p>None</p>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> An array of at least one taglist object. False on either empty array or error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$TC = new Taglist();

$taglists = $TC->getTaglists();</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>Query</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list php functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::results</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="function" id="Taglist::getTaglist">
				<div class="header">
					<h3>Taglist::getTaglist</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Taglist::getTaglist</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								Taglist::getTaglist( 
									<span class="type">Array</span> <span class="var">$_options = false</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get a specific taglist, specified in the parameter by the taglist_id or handle.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array|false</span> Options array
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">taglist_id</span></dt>
										<dd>Get taglist object for taglist_id.</dd>
										<dt><span class="value">handle</span></dt>
										<dd>Get taglist object for handle.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> An array of one taglist object. False on either error or an empty array.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>
						<p>Get taglist for taglist_id</p>
						<div class="example">
							<code>$TC = new Taglist();
$taglist = $TC->getTaglist(["taglist_id" => $taglist_id]);</code>
						</div>
						<p>Get taglist for handle</p>
						<div>
							<code>$TC = new Taglist();
$taglist = $TC->getTaglist(["handle" => $handle]);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>foreach</li>
								<li>switch...case</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list php functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::results</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="function" id="Taglist::addTaglistTag">
				<div class="header">
					<h3>Taglist::addTaglistTag</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Taglist::addTaglistTag</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Taglist::addTaglistTag(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Add a specific tag to a specific taglist. Specifications are sent through the action parameter.</p>
						<p>/#controller#/addTaglistTag/#taglist_id#/#tag_id#</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Action array.
								</div>
								<!-- action details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Action parameters</h5>
									<dl class="options">
										<!-- specific actions -->
										<dt><span class="value">$action[0]</span></dt>
										<dd>"addTaglistTag"</dd>
										<dt><span class="value">$action[1]</span></dt>
										<dd>#taglist_id#</dd>
										<dt><span class="value">$action[2]</span></dt>
										<dd>#tag_id#</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> True on successful addition of a specific tag to a specific tagliat. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$TC = new Taglist();
$TC->addTaglistTag($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>Query</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list php functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::results</li>
								<li>Query::checkDbExistence</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="function" id="Taglist::removeTaglistTag">
				<div class="header">
					<h3>Taglist::removeTaglistTag</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Taglist::removeTaglistTag</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Taglist::removeTaglistTag(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Remove a specific tag from a specific taglist. Specifications are sent through the action parameter.</p>
						<p>/#controller#/removeTaglistTag/#taglist_id#/#tag_id#</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Action array.
								</div>
								<!-- action details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Action parameters</h5>
									<dl class="options">
										<!-- specific actions -->
										<dt><span class="value">$action[0]</span></dt>
										<dd>"removeTaglistTag"</dd>
										<dt><span class="value">$action[1]</span></dt>
										<dd>#taglist_id#</dd>
										<dt><span class="value">$action[2]</span></dt>
										<dd>#tag_id#</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> True on successful deletion of a specific tag from a specific tagliat. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$TC = new Taglist();
$TC->removeTaglistTag($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>Query</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list php functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::results</li>
								<li>Query::checkDbExistence</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="function" id="Taglist::updateTaglist">
				<div class="header">
					<h3>Taglist::updateTaglist</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Taglist::updateTaglist</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Taglist::updateTaglist(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Update a specific taglist. Specification is sent through the action parameter.</p>
						<p>User input information is in $_POST</p>
						<p>/#controller#/updateTaglist/#taglist_id#</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Action array.
								</div>
								<!-- action details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Action parameters</h5>
									<dl class="options">
										<!-- specific actions -->
										<dt><span class="value">$action[0]</span></dt>
										<dd>"updateTaglist"</dd>
										<dt><span class="value">$action[1]</span></dt>
										<dd>#taglist_id#</dd>
									</dl>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Parameters in $_POST</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">$_POST["name"]</span></dt>
										<dd>$_POST["name"] for updating the name of the taglist</dd>
									</dl>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">$_POST["handle"]</span></dt>
										<dd>$_POST["handle"] for updating the handle of the taglist</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> True on successful update of a specific tagliat. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$TC = new Taglist();
$TC->updateTaglist($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>Query</li>
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list php functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::results</li>
								<li>Query::checkDbExistence</li>
								<li>Model::getPostedEntities</li>
								<li>Model::validateList</li>
								<li>Model::getProperty</li>
								<li>Model::getPostedEntities</li>
								<li>superNormalize</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="function" id="Taglist::saveTaglist">
				<div class="header">
					<h3>Taglist::saveTaglist</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Taglist::saveTaglist</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Taglist::saveTaglist(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Save a taglist.</p>
						<p>User input information is in $_POST</p>
						<p>/#controller#/saveTaglist</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Action array.
								</div>
								<!-- action details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Action parameters</h5>
									<dl class="options">
										<!-- specific actions -->
										<dt><span class="value">$action[0]</span></dt>
										<dd>"updateTaglist"</dd>
									</dl>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Parameters in $_POST</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">$_POST["name"]</span></dt>
										<dd>$_POST["name"] for saving taglist</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> True on successful save of a tagliat. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$TC = new Taglist();
$TC->saveTaglist($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>Query</li>
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list php functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::results</li>
								<li>Query::checkDbExistence</li>
								<li>Model::getPostedEntities</li>
								<li>Model::validateList</li>
								<li>Model::getProperty</li>
								<li>Model::getPostedEntities</li>
								<li>superNormalize</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="function" id="Taglist::deleteTaglist">
				<div class="header">
					<h3>Taglist::deleteTaglist</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Taglist::deleteTaglist</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Taglist::deleteTaglist(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Delete a specific taglist. Specification is sent through the action parameter.</p>
						<p>/#controller#/deleteTaglist/#taglist_id#</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Action array.
								</div>
								<!-- action details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Action parameters</h5>
									<dl class="options">
										<!-- specific actions -->
										<dt><span class="value">$action[0]</span></dt>
										<dd>"deleteTaglist"</dd>
										<dt><span class="value">$action[1]</span></dt>
										<dd>#taglist_id#</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> True on successful deletion of a specific tagliat. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$TC = new Taglist();
$TC->deleteTaglist($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>Query</li>
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list php functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::results</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="function" id="Taglist::duplicateTaglist">
				<div class="header">
					<h3>Taglist::duplicateTaglist</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Taglist::duplicateTaglist</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								Taglist::duplicateTaglist(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Duplicate a specific taglist. Specification is sent through the action parameter.</p>
						<p>Information is in $_POST</p>
						<p>/#controller#/duplicateTaglist/#taglist_id#</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Action array.
								</div>
								<!-- action details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Action parameters</h5>
									<dl class="options">
										<!-- specific actions -->
										<dt><span class="value">$action[0]</span></dt>
										<dd>"duplicateTaglist"</dd>
										<dt><span class="value">$action[1]</span></dt>
										<dd>#taglist_id#</dd>
									</dl>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Parameters in $_POST</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">$_POST["name"]</span></dt>
										<dd>$_POST["name"] for duplicating the name of the taglist</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|False</span> An array of the duplicated taglist. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$TC = new Taglist();
$TC->duplicateTaglist($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>Query</li>
								<li>count</li>
								<li>unset</li>
								<li>date</li>
								<li>array</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list php functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Taglist::getTaglist</li>
								<li>Taglist::saveTaglist</li>
								<li>Taglist::addTaglistTag</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="function" id="Taglist::updateOrder">
				<div class="header">
					<h3>Taglist::updateOrder</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Taglist::updateOrder</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								Taglist::updateOrder(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Update order of the tags of a specific taglist. Specification is sent through the action parameter.</p>
						<p>/#controller#/updateOrder/#taglist_id#</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Action array.
								</div>
								<!-- action details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Action parameters</h5>
									<dl class="options">
										<!-- specific actions -->
										<dt><span class="value">$action[0]</span></dt>
										<dd>"updateOrder"</dd>
										<dt><span class="value">$action[1]</span></dt>
										<dd>#taglist_id#</dd>
									</dl>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Parameters in $_POST</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">$_POST["order"]</span></dt>
										<dd>$_POST["order"] for getting the changed order of the tags of a specific taglist</dd>
									</dl>
								</div>

							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> True on successfully updating tag orders of a specific tagliat. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$TC = new Taglist();
$TC->updateOrder($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>Query</li>
								<li>count</li>
								<li>explode</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list php functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query::sql</li>
								<li>Query::results</li>
								<li>getPost</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

        </div>
    </div>
</div>