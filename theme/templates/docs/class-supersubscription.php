<div class="scene docpage i:docpage">
	<h1>The SuperSubscription Class</h1>
	<p>Subscription creation and manipulation</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="SuperSubscription::addSubscription">
				<div class="header">
					<h3>SuperSubscription::addSubscription</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">addSubscription</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								SuperSubscription::addSubscription(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Add subscription to item for specified user.</p>
						<p>Will only add paid subscription if order_id is passed.</p>
						<p>Will not add subscription if subscription already exists, but returns existing subscription instead.</p>
						<p>/#controller#/addSubscription/</p>
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
										<dd><span class="type">String</span> "addSubscription"</dd>
									</dl>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Parameters in $_POST</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">user_id</span></dt>
										<dd><span class="type">Integer</span> Id for the user that will subscribe to the item (Required)</dd>
										<dt><span class="value">item_id</span></dt>
										<dd><span class="type">Integer</span> Id for the item to which the user will be subscribed (Required)</dd>
										<!-- <dt><span class="value">payment_method</span></dt>
										<dd></dd> -->
										<dt><span class="value">order_id</span></dt>
										<dd><span class="type">Integer</span> Must be passed to create a paid subscription.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> Subscription object. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>1: Add subscription to free item (without price)</h5>
							<code>$SuperSubscriptionClass = new SuperSubscription();
$_POST["user_id"] = $user_id;
$_POST["item_id"] = $item_id;
$subscription = $SuperSubscriptionClass->addSubscription($action);</code>
						</div>
						<div class="example">
							<h5>2: Add paid subscription</h5>
							<code>$SuperSubscriptionClass = new SuperSubscription();
$_POST["user_id"] = $user_id;
$_POST["item_id"] = $item_id;
$_POST["order_id"] = $order_id;
$subscription = $SuperSubscriptionClass->addSubscription($action);</code>
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
								<li>SuperSubscription::getSubscriptions</li>
								<li>SuperSubscription::updateSubscriptions</li>
								<li>Subscription::calculateSubscriptionExpiry</li>
								<li>SuperMember::getMembership</li>
								<li>Items::getItem</li>
								<li>Items::typeObject</li>
								<li>Type#ItemType#::subscribed</li>
								<li>SuperShop::getOrders</li>
								<li>Query::sql</li>
								<li>Page::addLog</li>
								<li></li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="SuperSubscription::getSubscriptions">
				<div class="header">
					<h3>SuperSubscription::getSubscriptions</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">getSubscriptions</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								SuperSubscription::getSubscriptions( [
								<span class="type">Array</span> <span class="var">$_options</span>
								] );
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Get subscriptions for specified user.</p>
						<p>Passing no parameters in $_options will return all subscriptions.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array|false</span> Optional parameters.
								</div>
								<!-- optional details -->
								<div class="details">
										<!-- write parameter details -->
										<h5>Options</h5>
										<dl class="options">
											<!-- specific options -->
											<dt><span class="value">user_id</span></dt>
											<dd>Get all subscriptions for specified user. If combined with item_id: get specific subscription for specific user.</dd>
											<dt><span class="value">item_id</span></dt>
											<dd>Get all subscriptions for specified item.</dd>
											<dt><span class="value">subscription_id</span></dt>
											<dd>Get subscription by subscription_id.</dd>
										</dl>
									</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> One or several subscription objects. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>1: Get all subscriptions</h5>
							<code>$SuperSubscriptionClass = new SuperSubscription();
$subscriptions = $SuperSubscriptionClass->getSubscriptions();</code>
						</div>
						
						<div class="example">
							<h5>2a: Get all subscriptions for specific user.</h5>
							<code>$SuperSubscriptionClass = new SuperSubscription();
$subscriptions = $SuperSubscriptionClass->getSubscriptions(["user_id"] => $user_id);</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Items::getItem</li>
								<li>SuperMember::getMembership</li>
								<li>SuperShop::getOrders</li>
								<li>Query::sql</li>
								<li>Query::result</li>
								<li>Query::results</li>
								<li>Page::paymentMethods</li>
								<li>Page::addLog</li>
							</ul>
						</div>

					</div>

				</div>
			</div>
			
			<div class="function" id="SuperSubscription::updateSubscription">
				<div class="header">
					<h3>SuperSubscription::updateSubscription</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">updateSubscription</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								SuperSubscription::updateSubscription(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Update subscription for specified user.</p>
						<p>/#controller#/updateSubscription/#subscription_id#</p>
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
										<dd><span class="type">String</span> "updateSubscription"</dd>
										<dt><span class="value">$action[1]</span></dt>
										<dd><span class="type">Integer</span> #subscription_id#</dd>
									</dl>
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Parameters in $_POST</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">item_id</span></dt>
										<dd><span class="type">Integer</span> Id for the new item to which the user will be subscribed. Item must have a subscription_method. If passed without an order_id, it will create an orderless subscription.</dd>
										<dt><span class="value">expires_at</span></dt>
										<dd><span class="type">String</span> Expiry date.</dd>
										<dt><span class="value">subscription_renewal</span></dt>
										<dd><span class="type">Boolean</span>, indicating whether the function call is a periodical renewal of the subscription. If passed, the subscription's expiry date will be recalculated (if it had an expiry date in the first place).</dd>
										<dt><span class="value">switch_membership</span></dt>
										<dd><span class="type">Boolean</span>, indicating whether the function call comes from the Member::switchMembership or SuperMember::switchMembership. If passed, the subscription's expiry date will be recalculated.</dd>
										<dt><span class="value">order_id</span></dt>
										<dd><span class="type">Integer</span> If passed without an item_id, the existing item must have price, and the existing subscription may not have an existing order – or the function returns <span class="value">false</span>.</dd>
										<!-- <dt><span class="value">custom_price</span></dt>
										<dd></dd> -->
										<!-- <dt><span class="value">payment_method</span></dt>
										<dd></dd> -->
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array|false</span> Subscription object. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
								<h5>Change subscription item – to free item (without price)</h5>
								<code>$SubscriptionClass = new Subscription();
						$_POST["item_id"] = $item_id;
						$subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $subscription_id]);</code>
								<p>This will create a callback to #ItemType#::subscribed</p>
							</div>
							<div class="example">
								<h5>Change subscription item – to paid item</h5>
								<code>$SubscriptionClass = new Subscription();
						$_POST["item_id"] = $item_id;
						$_POST["order_id"] = $order_id;
						$subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $subscription_id]);</code>
								<p>This will create a callback to #ItemType#::subscribed</p>
							</div>
							<div class="example">
								<h5>Update expiry date</h5>
								<code>$SubscriptionClass = new Subscription();
						$_POST["expires_at"] = "2020-03-02 00:00:00";
						$subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $subscription_id]);</code>
							</div>
							<div class="example">
								<h5>Update order_id</h5>
								<code>$SubscriptionClass = new Subscription();
						$_POST["order_id"] = $order_id;
						$subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $subscription_id]);</code>
								<p>May be used if the order for the subscription were accidentally deleted.</p>
							</div>
						<div class="example">
							<h5>Renew subscription</h5>
							<code>$SubscriptionClass = new Subscription();
$_POST["subscription_renewal"] = 1;
$subscription = $SubscriptionClass->updateSubscription(["updateSubscription", $subscription_id]);</code>
							<p>Used when a cronjob periodically renews subscriptions. A new expiry date is automatically calculated.</p>
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
								<li>SuperSubscription::getSubscriptions</li>
								<li>SuperSubscription::calculateSubscriptionExpiry</li>
								<li>SuperMember::getMembership</li>
								<li>Items::getItem</li>
								<li>Items::typeObject</li>
								<li>Type#ItemType#::subscribed</li>
								<li>Type#ItemType#::subscription_renewed</li>
								<li>Query::sql</li>
								<li>Page::addLog</li>
								<li></li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="SuperSubscription::deleteSubscription">
				<div class="header">
					<h3>SuperSubscription::deleteSubscription</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">deleteSubscription</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Boolean</span> = 
								SuperSubscription::deleteSubscription(
									<span class="type">Array</span> <span class="var">$action</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Delete specified subscription for current user.</p>
						<p>/#controller#/deleteSubscription/#subscription_id#</p>
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
										<dd><span class="type">String</span> "deleteSubscription"</dd>
										<dt><span class="value">$action[1]</span></dt>
										<dd><span class="type">Integer</span> #subscription_id#</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Boolean</span> True on successful deletion. False on error.</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<code>$SuperSubscriptionClass = new SuperSubscription();
$result = $SuperSubscriptionClass->deleteSubscription(["deleteSubscription", $subscription_id]);</code>
						</div>
						
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="php">
							<!-- list php functions used by function -->
							<h5>PHP</h5>
							<ul>
								<li>count</li>
								<li>method_exists</li>
							</ul>
						</div>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Session::value</li>
								<li>Query::sql</li>
								<li>SuperSubscription::getSubscriptions</li>
								<li>Items::getItem</li>
								<li>Items::typeObject</li>
								<li>Type#ItemType#::unsubscribed</li>
								<li>Page::addLog</li>
								<li></li>
							</ul>
						</div>

					</div>

				</div>
			</div>

			<div class="function" id="SuperSubscription::renewSubscriptions">
					<div class="header">
						<h3>SuperSubscription::renewSubscriptions</h3>
					</div>
					<div class="body">
						<div class="definition">
							<h4>Definition</h4>
							<dl class="definition">
								<dt class="name">Name</dt>
								<dd class="name">renewSubscriptions</dd>
								<dt class="syntax">Syntax</dt>
								<dd class="syntax"><span class="type">Boolean</span> = 
									SuperSubscription::renewSubscriptions(
										<span class="type">Array</span> <span class="var">$action</span> 
									);
								</dd>
							</dl>
						</div>
	
						<div class="description">
							<h4>Description</h4>
							<p>Renew subscription for specified user or all users.</p>
							<p>/#controller#/renewSubscriptions[/#user_id#]</p>
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
											<dd><span class="type">String</span> "renewSubscriptions"</dd>
											<dt><span class="value">$action[1]</span></dt>
											<dd><span class="type">Integer</span> #user_id# (Optional) Include to renew subscription for specific user. Omit to renew subscription for all users.</dd>
										</dl>
									</div>
								</dd>
							</dl>
						</div>
	
						<div class="return">
							<h4>Return values</h4>
							<p><span class="type">Boolean</span> True on success. False on error.</p>
						</div>
	
						<div class="examples">
							<h4>Examples</h4>
	
							<div class="example">
								<h5>1: Renew all subscriptions that are expiring on current date</h5>
								<code>$SuperSubscriptionClass = new SuperSubscription();
$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions"]);</code>
							</div>
							<div class="example">
								<h5>2: Renew all of a specific user's subscriptions that are expiring on current date</h5>
								<code>$SuperSubscriptionClass = new SuperSubscription();
$result = $SuperSubscriptionClass->renewSubscriptions(["renewSubscriptions", $user_id]);</code>
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
									<li>Subscription::calculateSubscriptionExpiry</li>
									<li>Items::getItem</li>
									<li>SuperShop::getPrice</li>
									<li>SuperShop::addCart</li>
									<li>SuperShop::addToNewInternalCart</li>
									<li>SuperShop::newOrderFromCart</li>
									<li>Query::sql</li>
									<li>Query::result</li>
									<li>Page::addLog</li>
									<li>MailGateway::send</li>
									<li></li>
								</ul>
							</div>
	
						</div>
	
					</div>
				</div>

			


		</div>
	</div>

</div>
