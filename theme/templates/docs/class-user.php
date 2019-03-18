<div class="scene docpage i:docpage">
	<h1>The User Class</h1>
	<p>Short (or long) explanation</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="_functionname_">
				<div class="header">
					<h3>User::confirmUsername</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">confirmUsername</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Integer|Array|False</span> = 
								confirmUsername(
									<span class="type">String</span> <span class="var">$username</span>, 
									<span class="type">String</span> <span class="var">$verification_code</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get relevant user data and check verification before activating user.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$username</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> The username to be verified
								</div>
							</dd>
							<dt><span class="var">$verification_code</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> The verification code associated with the username
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Integer</span> <span class="value">$user_id</span> if the username is succesfully confirmed. The username will be verified and the user will be activated (<span class="value">status = 1</span>).</p>
						<p><span class="type">Array</span> with the value <span class="value">"status" => "USER_VERIFIED"</span> if the username is already verified.</p>
						<p><span class="type">False</span> if confirmation fails (wrong user id and/or wrong verification code).</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
						</div>
					</div>

					<div class="uses">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query</li>
								<li>Page::addLog</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
