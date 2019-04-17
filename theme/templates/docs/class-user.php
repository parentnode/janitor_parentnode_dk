<div class="scene docpage i:docpage">
	<h1>The User Class</h1>
	<p>User creation and manipulation.</p>

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
							<dd class="name">User::confirmUsername</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Integer|Array|False</span> = 
								User::confirmUsername(
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

					<div class="dependencies">
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

			<div class="function" id="_functionname_">
				<div class="header">
					<h3>User::setPassword</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">User::setPassword</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|Boolean</span> = 
								User::setPassword(
									<span class="type">Array</span> <span class="var">$action</span>
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Saves a new password posted by current user. If user has a password already, this is also posted for validation.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">array</span> action array
								</div>
								<!-- action details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Action parameters</h5>
									<dl class="options">
										<!-- specific actions -->
										<dt><span class="value">$action[0]</span></dt>
										<dd>"setPassword"|arbritary parameter</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> with the value <span class="value">"error" => "wrong_password"</span> if the old password is not successfully verified. The new password is not saved.</p>
						<p><span class="type">False</span> if the new password is not saved (password is not validated successfully or exactly one action parameter is not received.)</p>
						<p><span class="type">True</span> if the new password is successfully saved.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>Example 1</h5>
							<code>$_POST["old_password"] = "SuperSecretAndWrongOldPassword";
$_POST["new_password"] = "SuperSecretNewPassword";	
$UC = new User();
$result = $UC->setPassword($action);</code>
							<p>Returns an array with information about the result of the function call. The new password was not saved, since the old password was not succesfully verified.</p>
							<code>$result = 
(
	["error"] => "wrong_password"
)</code>
						</div>
						<div class="example">
							<h5>Example 2</h5>
							<code>$_POST["old_password"] = "SuperSecretAndCorrectOldPassword";
$_POST["new_password"] = "SuperSecretNewPassword";
$UC = new User();	
$result = $UC->setPassword($action);</code>
							<p>Returns true. The new password was succesfully saved.</p>
							<code>$result = true </code>
						</div>
						
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>password_hash</li>
								<li>password_verify</li>
							</ul>
						</div>
						
						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Model::getPostedEntities</li>
								<li>Model::getProperty</li>
								<li>Model::validateList</li>
								<li>Query::checkDbExistence</li>
								<li>Query::result</li>
								<li>Session::value</li>
								<li>User::hasPassword</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
