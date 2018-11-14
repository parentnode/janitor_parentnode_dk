<div class="scene docpage i:docpage">
	<h1>Session</h1>
	<p>
		Internal Session helper class providing a simple get/set/reset interface to the Janitor Session storage.
		The Session class is automatically instanciated and globally available throught the session() reference function.
	</p>
	<p>
		This class is included as default.
	</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="Session::value">
				<div class="header">
					<h3>Session::value</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Session::value</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void|String</span> = 
								Session::value(
									<span class="type">String</span> <span class="var">$key</span> 
									[, <span class="type">Mixed</span> <span class="var">$value</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Get/Set function for internal Session storage. Use with only <span class="var">$key</span> parameter to get
							the stored session value. Use <span class="var">$value</span> parameter when update/set session value.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$key</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Key for session value
								</div>
							</dd>
							<dt><span class="var">$value</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Mixed</span> Optional Array/String value the set for Key
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Returns</h4>
						<p><span class="type">Void|String</span> Void on set, String on get.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>session()->value("user", "martin");</code>
							<p>Will save the value "martin" for the key "user" in the internal session storage</p>
						</div>

						<div class="example">
							<code>session()->value("user");</code>
							<p>Will return the value of the "user"-key in the internal session storage.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>json_encode</li>
								<li>json_decode</li>
								<li>isset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>none</p>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Session::reset">
				<div class="header">
					<h3>Session::reset</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Session::reset</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Void</span> = 
								Session::reset(
									[<span class="type">String</span> <span class="var">$key</span>]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>
							Reset session key or entire session storage. If <span class="var">$key</span> is omitted, 
							entire storage will be unset.
						</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$key</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> Optional Key to reset
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
							<code>session()->reset("user");</code>
							<p>Deletes the key "user" in the internal session storage</p>
						</div>

						<div class="example">
							<code>session()->reset();</code>
							<p>Will reset the entire internal session storage.</p>
						</div>
					</div>

					<div class="uses">
						<h4>Uses</h4>

						<div class="php">
							<h5>PHP</h5>
							<ul>
								<li>session_unset</li>
								<li>unset</li>
							</ul>
						</div>

						<div class="janitor">
							<h5>Janitor</h5>
							<p>none</p>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
