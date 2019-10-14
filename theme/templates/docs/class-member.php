<div class="scene docpage i:docpage">
	<h1>The Member Class</h1>
	<p>Member creation and manipulation</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="Member::addNewMembership">
				<div class="header">
					<h3>addNewMembership</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">addNewMembership</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								addNewMembership(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Add new membership to current user.</p>
						<p>Can be called via API, as opposed to Member::addMembership.</p>
						<p>/#controller#/addNewMembership/</p>
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
										<dd>"addNewMembership"</dd>
									</dl>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Parameters in $_POST</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">item_id</span></dt>
										<dd>item_id for Membership item (Required)</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> Order object. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$MC = new Member();

$_POST["item_id"] = $item_id;
$order = $MC->addNewMembership($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>unset</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Model::getPostedEntities</li>
								<li>Model::validateList</li>
								<li>Model::getProperty</li>
								<li>User::getUser</li>
								<li>Shop::addToNewInternalCart</li>
								<li>Shop::newOrderFromCart</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Member::addMembership">
				<div class="header">
					<h3>addMembership</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">addMembership</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								addMembership(
									<span class="type">Integer</span> <span class="var">$item_id</span>, 
									<span class="type">Integer</span> <span class="var">$subscription_id</span>, 
									<span class="type">Array|false</span> <span class="var">$_options</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Add membership to current user.</p>
						<p>Meant for internal use, as opposed to Member::addNewMembership.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$item_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> Id for membership item.
								</div>
							</dd>
							<dt><span class="var">$subscription_id</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Integer</span> Id for subscription.
								</div>
							</dd>
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array|false</span> Not in use. Exists to maintain compatibility with SuperMember::addMembership.
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> Membership object. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$MC = new Member();
$membership = $MC->addMembership($item_id, $subscription_id);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Member::getMembership</li>
								<li>Query::sql</li>
								<li>Page::addLog</li>
							</ul>
						</div>

					</div>

				</div>
			</div>
			<div class="function" id="Member::getMembership">
				<div class="header">
					<h3>getMembership</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getMembership</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								getMembership();
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get membership for current user.</p>
						<p>Includes membership item and order.</p>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> Membership object. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example"><code>$MC = new Member();
$membership = $MC->getMembership();</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>session()->value</li>
								<li>Query::sql</li>
								<li>Query::result</li>
								<li>Items::getItems</li>
								<li>Shop::getOrders</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Member::updateMembership">
				<div class="header">
					<h3>updateMembership</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">updateMembership</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								updateMembership(
									<span class="type">Array</span> <span class="var">$options = false</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Update membership for current user.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array|False</span> Optional parameters.
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">subscription_id</span></dt>
										<dd>To be used if reactivating an inactive membership</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> Membership object. False on non-existing membership. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<p>Normal use:</p>
							<code>$MC = new Member();
$membership = $MC->updateMembership();</code>
						</div>
						<div class="example">
							<p>Reactivating an inactive (cancelled) membership:</p>
							<code>$MC = new Member();
$membership = $MC->updateMembership(["subscription_id" => $subscription_id]);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>session()->value()</li>
								<li>Subscription::getSubscriptions</li>
								<li>Member::getMembership</li>
								<li>Query::sql</li>
								<li>Page::addLog</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Member::cancelMembership">
				<div class="header">
					<h3>cancelMembership</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">cancelMembership</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								cancelMembership(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Cancel membership of current user.</p>
						<p>Removes subscription_id from membership and deletes related subscription. Sends a notification email to administrator.</p>
						<p>/#controller#/cancelMembership/#member_id#</p>
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
										<dd>"cancelMembership"</dd>
										<dt><span class="value">$action[1]</span></dt>
										<dd>#member_id#</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> True on successful cancellation. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$MC = new Member();
$order = $MC->cancelMembership($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>session()->value()</li>
								<li>Member::getMembership</li>
								<li>Subscription::deleteSubscription</li>
								<li>Page::addLog</li>
								<li>mailer()->send()</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Member::upgradeMembership">
				<div class="header">
					<h3>upgradeMembership</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">upgradeMembership</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								upgradeMembership(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Upgrade membership for current user.</p>
						<p>Adds new order with custom price (new_price - current_price). Gets existing membership order and copies info to new membership order, then adds manual order line.</p>
						<p>/#controller#/upgradeMembership/</p>
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
										<dd>"upgradeMembership"</dd>
									</dl>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Parameters in $_POST</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">item_id</span></dt>
										<dd>item_id for Membership item (Required)</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> True on successful upgrade. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$MC = new Member();
$_POST["item_id"] = $item_id;
$upgrade_success = $MC->upgradeMembership($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>preg_match</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Model::getProperty</li>
								<li>Member::getMembership</li>
								<li>Shop::getPrice</li>
								<li>Shop::getNewOrderNumber</li>
								<li>Shop::getOrders</li>
								<li>Subscription::getSubscriptions</li>
								<li>Subscription::calculateSubscriptionExpiry</li>
								<li>Items::getItem</li>
								<li>Items::typeObject</li>
								<li>Query::sql</li>
								<li>Query::result</li>
								<li>Page::addLog</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="Member::switchMembership">
				<div class="header">
					<h3>switchMembership</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">switchMembership</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								switchMembership(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Switch membership for current user.</p>
						<p>/#controller#/switchMembership/</p>
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
										<dd>"switchNewMembership"</dd>
									</dl>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Parameters in $_POST</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">item_id</span></dt>
										<dd>item_id for new Membership item (Required)</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> Order object. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$MC = new Member();
$_POST["item_id"] = $item_id;
$order = $MC->switchMembership($action);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>count</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>session()->value()</li>
								<li>Model::getPostedEntities</li>
								<li>Model::validateList</li>
								<li>Model::getProperty</li>
								<li>Member::getMembership</li>
								<li>Shop::addToNewInternalCart</li>
								<li>Shop::newOrderFromCart</li>
							</ul>
						</div>

					</div>

				</div>
			</div>




		</div>
	</div>

</div>
