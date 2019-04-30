
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

								<!-- action details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Action parameters</h5>
									<dl class="options">
										<!-- specific actions -->
										<dt><span class="value">$action[0]</span></dt>
										<dd>"cancel"|arbritary parameter</dd>
										<dt><span class="value">$action[1]</span></dt>
										<dd>user_id of user to delete</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> with the value <span class="value">"error" => "unpaid_orders"</span> if the user has unpaid orders. The user is not deleted.</p>
						<p><span class="type">False</span> if the user was not deleted. (Exactly two action parameters were not received.)</p>
						<p><span class="type">True</span> if the user was successfully deleted.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>Example 1</h5>
							<code>$user =
( 
	[id] => 26,
	[user_group_id] => 3,
	[firstname] => 
	[lastname] => 
	[nickname] => "e.haabegaard@gmail.com", 
	[status] => 1,
	[language] => 
	[created_at] => 2019-04-08 12:58:38, 
	[modified_at] => 
	[last_login_at] => 2019-04-10 14:56:59, 
	[mobile] => 
	[email] => e.haabegaard@gmail.com, 
	[addresses] => 
	[maillists] => 
	[membership] => 
)
$UC = new SuperUser();
$result = $UC->cancel(["cancel", 26]);
</code>
							<p>Returns an array with information about the result of the function call. All account information of the user is deleted.</p>
							<code>$result = true
$user = 
(
	id] => 26,
	[user_group_id] => NULL,
	[firstname] => NULL,
	[lastname] => NULL,
	[nickname] => NULL,
	[status] => -1,
	[language] => NULL,
	[created_at] => 2019-04-08 12:58:38,
	[modified_at] => 
	[last_login_at] => 2019-04-10 14:56:59,
	[mobile] => NULL,
	[email] => NULL,
	[addresses] => NULL,
	[maillists] => NULL,
	[membership] => NULL	
)</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>defined</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Page::addLog</li>
								<li>Payments::deleteGatewayUserId</li>
								<li>Shop::getUnpaidOrders</li>
								<li>SuperUser::flushUserSession</li>
								<li>Query::sql</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

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
										<!-- specific options -->
										<dt><span class="value">username_id</span></dt>
										<dd>Returns specific username</dd>
										<dt><span class="value">user_id</span></dt>
										<dd>Returns all usernames for user</dd>
										<dt><span class="value">type</span></dt>
										<dd>Values can be 'email' or 'mobile'. Requires user_id to be passed. Returns first username of type for user_id.</dd>
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
						<p><span class="type">Array|False</span> Returns array with one or more objects, each object containing user_id, username_id username, verification_code, nickname, created_at, reminded_at, and total_reminders. False on error.</p>
						<div class="example"><code>$UC = new SuperUser();

$unverified_usernames = $UC->getUnverifiedUsernames();
</code>
<p>Get all unverified usernames.</p>
								<li>none</li>
								<li>Query class</li>
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
