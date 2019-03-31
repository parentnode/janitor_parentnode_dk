<div class="scene docpage i:docpage">
	<h1>DOM</h1>
	<p>Extension of PHP DOM implementation.</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="DOM::createDom">
				<div class="header">
					<h3>DOM::createDom</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">createDom</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">DOMElement</span> = 
								DOM::createDom(
									<span class="type">String</span> <span class="var">$html_string</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Create a DOM from string of HTML.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$html_string</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> String to using in document body.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">DOMElement</span> Native PHP DOM element</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>DOM()->createDom("<span>hello world</span>");</code>
							<p>Returns a DOM object with the following structure:</p>
							<code>&lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD HTML 4.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/REC-html40/loose.dtd&quot;&gt;
&lt;html&gt;
	&lt;head&gt;
		&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=UTF-8&quot;&gt;
	&lt;/head&gt;
	&lt;body&gt;
		&lt;span&gt;Hello world&lt;/span&gt;
	&lt;/body&gt;
&lt;/html&gt;</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>DOMDocument</li>
								<li>mb_convert_encoding</li>
								<li>preg_match</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>DOMElement->loadHTML</li>
								<li>DOMElement->getElementsByTagName</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="DOM::stripAttributes">
				<div class="header">
					<h3>DOM::stripAttributes</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">stripAttributes</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								DOM::stripAttributes(
									<span class="type">String</span> <span class="var">$node</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Strip unwanted attributes from DOMElement and children.</p>
						<p>
							Only the following attributes are allowed:
							<span class="type">href</span>, <span class="type">class</span>, <span class="type">width</span>, <span class="type">height</span>, <span class="type">alt</span>, <span class="type">charset</span>.
							The href must start with <span class="value">/</span>, <span class="value">http://</span>, <span class="value">https://</span>, <span class="value">mailto:</span>, <span class="value">tel:</span>.
							Otherwise the href property will be removed.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$node</span></dt>
							<dd>
								<div class="summary">
									<span class="type">DOMElement</span> DOMElement to strip attributes from.
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
							<code>DOM()->createDom('&lt;span class=&quot;test&quot; style=&quot;color: red;&quot;&gt;hello world&lt;/span&gt;');
DOM()->stripAttributes($dom);</code>
							<p>DOM object <span class="var">$dom</span> now has the following structure:</p>
							<code>&lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD HTML 4.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/REC-html40/loose.dtd&quot;&gt;
&lt;html&gt;
	&lt;head&gt;
		&lt;meta&gt;
	&lt;/head&gt;
	&lt;body&gt;
		&lt;span class=&quot;test&quot;&gt;Hello world&lt;/span&gt;
	&lt;/body&gt;
&lt;/html&gt;</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>preg_match</li>
								<li>foreach</li>
								<li>if...else</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<ul>
								<li>DOMElement->removeAttribute</li>
								<li>DOMElement->getElementsByTagName</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
