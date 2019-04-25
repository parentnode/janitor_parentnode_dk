<div class="scene docpage i:docpage">
	<h1>The SuperUser Class</h1>
	<p>Getting, creating and manipulating users.</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="_functionname_">
				<div class="header">
					<h3>SuperUser::cancel</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">SuperUser::cancel</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|Boolean</span> = 
								SuperUser::cancel(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Deletes all information of a given user. Users with unpaid orders can not be deleted.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
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

		</div>
	</div>

</div>
