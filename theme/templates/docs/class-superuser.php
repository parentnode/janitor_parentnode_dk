<div class="scene docpage i:docpage">
	<h1>The SuperUser Class</h1>
	<p>Short (or long) explanation</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="SuperUser::getUsernames">
				<div class="header">
					<h3>SuperUser::getUsernames</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getUsernames</dd>
							<!-- <dt class="shorthand">Shorthand</dt> -->
							<!-- <dd class="shorthand">_functionshorthand_</dd> -->
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								SuperUser::getUsernames(
									<span class="type">Array</span> <span class="var">$_options</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get usernames or specific username</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Filtering options
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">username_id</span></dt>
										<dd>Returns specific username</dd>
										<dt><span class="value">user_id</span></dt>
										<dd>Returns all usernames for user</dd>
										<dt><span class="value">type</span></dt>
										<dd>Values can be 'email' or 'mobile'. Requires user_id to be passed. Returns first username of type for user_id.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|False</span> Returns username object containing id, user_id, username, type, verified, and verification_code. If several username objects are returned, they will be nested in an array. False on error or if no options are passed.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$UC = new SuperUser();

$username_id = 42;

$result = $UC->getUsernames(["username_id" => $username_id]);
$username = $result["username"];
</code>
<p>Get username object with specific username_id and save the username string in $username.</p>

						</div>
						<div class="example"><code>$UC = new SuperUser();

$user_id = 7;

$result = $UC->getUsernames(["user_id" => $user_id]);

foreach ($result as $username) {
	$usernames[] = $username["username"];
}
</code>
<p>Get all username objects for user_id, and save the username strings in $usernames.</p>
						</div>
						<div class="example"><code>$UC = new SuperUser();

$user_id = 7;
$type = "email";

$result = $UC->getUsernames(["user_id" => $user_id, "type" => $type]);

$email = $result["username"];

</code>
<p>Get first username object of the type 'email' for user_id, and save the username string in $username.</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

								
						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>none</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query functions</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="SuperUser::getUnverifiedUsernames">
				<div class="header">
					<h3>SuperUser::getUnverifiedUsernames</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getUnverifiedUsernames</dd>
							<!-- <dt class="shorthand">Shorthand</dt> -->
							<!-- <dd class="shorthand">_functionshorthand_</dd> -->
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								SuperUser::getUnverifiedUsernames(
									[<span class="type">Array</span> <span class="var">$_options</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get all (or a subset of) unverified usernames;</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Optional filters
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">type</span></dt>
										<dd>Get unverified usernames of specific type. Can be "email" or "mobile".</dd>
										<dt><span class="value">user_id</span></dt>
										<dd>Get unverified usernames for specific user</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|False</span> Returns array with one or more objects, each object containing user_id, username_id username, verification_code, nickname, created_at, reminded_at, and total_reminders. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$UC = new SuperUser();

$unverified_usernames = $UC->getUnverifiedUsernames();
</code>
<p>Get all unverified usernames.</p>
						</div>
						<div class="example"><code>$UC = new SuperUser();

$unverified_emails = $UC->getUnverifiedUsernames(["type" => "email"]);
</code>
<p>Get all unverified emails.</p>
						</div>
						<div class="example"><code>$UC = new SuperUser();
$user_id = 42;

$unverified_emails = $UC->getUnverifiedUsernames(["type" => "email", "user_id" => $user_id]);
</code>
<p>Get all unverified emails for specific user id.</p>
						</div>
						<div class="example"><code>$UC = new SuperUser();
$user_id = 42;

$unverified_usernames = $UC->getUnverifiedUsernames(["user_id" => $user_id]);
</code>
<p>Get all unverified usernames for specific user id.</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>none</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query class</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="SuperUser::sendVerificationLink">
				<div class="header">
					<h3>SuperUser::sendVerificationLink</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">SuperUser::sendVerificationLink</dd>
							<!-- <dt class="shorthand">Shorthand</dt>
							<dd class="shorthand">_functionshorthand_</dd> -->
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								SuperUser::sendVerificationLink(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Send verification link to username_id. A specific template can be posted. Default template is signup_reminder.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Function name in $action[0]. Username_id in $action[1].
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|False</span> $verification_status with "verified", "reminded_at", and "total_reminders". False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$UC = new SuperUser();
$username_id = 7;

$verification_status = $UC->sendVerificationLink(["sendVerificationLink", $username_id]);
</code>
<p>Send verification link to username and get verification status.</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>count()</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query functions</li>
								<li>Mailer functions</li>
								<li>Message functions</li>
								<li>SuperUser::getUsernames</li>
								<li>SuperUser::getUserInfo</li>
								<li>SuperUser::getUser</li>
								<li>SuperUser::getUser</li>
								<li>getPost</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="SuperUser::sendVerificationLinks">
				<div class="header">
					<h3>SuperUser::sendVerificationLinks</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">SuperUser::sendVerificationLinks</dd>
							<!-- <dt class="shorthand">Shorthand</dt>
							<dd class="shorthand">_functionshorthand_</dd> -->
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array</span> = 
								SuperUser::sendVerificationLinks(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Send verification links to list of users.</p>
						<p>Expects a comma separated string of username_ids from $_POST.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> $verification_statuses with each $verification_status containing "verified", "reminded_at", "total_reminders", and "username_id".</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$UC = new SuperUser;
$verification_statuses = $UC->sendVerificationLinks(["sendVerificationLinks"]);					
</code>
<p>Send verification links to list of usernames and get verification statuses. A comma-separated string of username_ids is retrieved from $_POST.</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>explode()</li>
								<li>array_push()</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>SuperUser::sendVerificationLink</li>
								<li>getPost</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="SuperUser::getVerificationStatus">
				<div class="header">
					<h3>SuperUser::getVerificationStatus</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">SuperUser::getVerificationStatus</dd>
							<!-- <dt class="shorthand">Shorthand</dt>
							<dd class="shorthand">_functionshorthand_</dd> -->
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								SuperUser::getVerificationStatus(
									<span class="type">Integer</span> <span class="var">$username_id</span> 
									<span class="type">Integer</span> <span class="var">$user_id</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get verification status for username.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$username_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> The unique id of the username
								</div>
							</dd>
							<dt><span class="var">$user_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> The user_id to which the username_id belongs
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|False</span> Array with verification status and number of verification links that have been send. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$UC = new SuperUser;

$username_id = 42;
$user_id = 7;

$verification_status = $UC->getVerificationStatus($username_id, $user_id);					
</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>count()</li>
								<li>end()</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query functions</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="SuperUser::setVerificationStatus">
				<div class="header">
					<h3>SuperUser::setVerificationStatus</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">SuperUser::setVerificationStatus</dd>
							<!-- <dt class="shorthand">Shorthand</dt> -->
							<!-- <dd class="shorthand">_functionshorthand_</dd> -->
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								SuperUser::setVerificationStatus(
									<span class="type">Integer</span> <span class="var">$username_id</span> 
									<span class="type">Integer</span> <span class="var">$user_id</span> 
									<span class="type">Integer</span> <span class="var">$verification_status</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Set verification status for username</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$username_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> The unique id of the username
								</div>
							</dd>
							<dt><span class="var">$user_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> The user_id to which the username_id belongs
								</div>
							</dd>
							<dt><span class="var">$verification_status</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> 1 for verified; 0 for unverified.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|False</span> Array with status code indicating whether username is verified/not verified. False on error. </p>
					</div>

					<div class="example"><code>$UC = new SuperUser;

$username_id = 42;
$user_id = 7;
$verification_status = 1;

$verification_status = $UC->setVerificationStatus($username_id, $user_id, $verification_status);					
</code>
						</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>none</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query functions</li>
								<li>Message functions</li>
							</ul>
						</div>

					</div>

				</div>
			</div>
			<div class="function" id="SuperUser::updateEmail">
				<div class="header">
					<h3>SuperUser::updateEmail</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">SuperUser::updateEmail</dd>
							<!-- <dt class="shorthand">Shorthand</dt>
							<dd class="shorthand">_functionshorthand_</dd> -->
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|True|False</span> = 
								SuperUser::updateEmail(
									<span class="type">String</span> <span class="var">format</span> 
									[, <span class="type">Mixed</span> <span class="var">timestamp</span> ]
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Update usernames from posted values.</p>
						<p>Expects $email and $username_id from $_POST.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$action</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> $username_id in $action[1].
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|True|False</span> Returns status code indicating whether email was updated/unchanged/already existing. Returns true if email was deleted (updated to blank). False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$UC = new SuperUser;

$username_id = 42;

$result = $UC->updateEmail(["updateEmail", $username_id]);					
</code>
<p>Update $username to $email. $email is retrieved from $_POST.</p>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>count()</li>
								<li>isset()</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Model::getProperty</li>
								<li>getPost</li>
								<li>SuperUser::getUsernames</li>
								<li>SuperUser::getUsers</li>
								<li>SuperUser::setVerificationStatus</li>
								<li>Message functions</li>
								<li>Query functions</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
