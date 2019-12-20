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

			<div class="function" id="JanitorHTML::editActions">
				<div class="header">
					<h3>JanitorHTML::editActions</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">JanitorHTML::editActions</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">String</span> = 
								JanitorHTML::editActions(
									<span class="type">Array</span> <span class="var">$item</span> 
									[, <span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							This method returns an HTML snippet string, with a <span class"htmltag">ul.actions</span> 
							containing the default actions for an <em>edit</em> form.
						</p>
						<p>
							This method requires the presence of a global <span class="var">$model</span> instance
							to be available. This is the case for default edit views, where the instance of the current
							itemtype class would be available in <span class="var">$model</span>.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$item</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Item data array representing the item currently being edited.
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional settings.
								</div>
								<p>No settings defined at this point</p>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">String</span> String with HTML snippet of actions list for edit templates.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$JML->editActions($item);</code>
							<p>Returns a string similar to:</p>
							<code>&lt;ul class=&quot;actions&quot;&gt;
	&lt;li class=&quot;save&quot;&gt;&lt;input value=&quot;Update&quot; type=&quot;submit&quot; class=&quot;button primary key:s&quot; /&gt;&lt;/li&gt;
&lt;/ul&gt;</code>
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
								<li>HTML::submit</li>
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
