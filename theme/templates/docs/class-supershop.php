<div class="scene docpage i:docpage">
	<h1>The SuperShop Class</h1>
	<p>Cart and Order helper class</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="_functionname_">
				<div class="header">
					<h3>SuperShop::getUnpaidOrders</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">SuperShop::getUnpaidOrders</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								SuperShop::getUnpaidOrders(
									<span class="type">Array</span> <span class="var">$_options</span> 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Returns all unpaid orders specified by $_options. Returns all unpaid orders if $_options is not specified.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$_options</span></dt>
							<dd>
								<div class="summary">
									<span class="type">Array</span> Associative array containing search criteria of which unpaid orders to return.
								</div>
								<!-- optional details -->
								<div class="details">
									<!-- write parameter details -->
									<h5>Options</h5>
									<dl class="options">
										<!-- specific options -->
										<dt><span class="value">user_id</span></dt>
										<dd>User id of unpaid orders to return.</dd>
										<dt><span class="value">item_id</span></dt>
										<dd>Item id of unpaid orders to return.</dd>
										<dt><span class="value">itemtype</span></dt>
										<dd>Itemtype of the unpaid orders to return.</dd>
									</dl>
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
							<p><span class="type">Array</span> Array of unpaid orders.</p>
							<p><span class="type">False</span> if the function fails (wrong user id, itemtype or item id).</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>Ex. 1a: Get unpaid orders with specific user id.</h5>
							<code>$SC = new SuperShop();
$unpaid_orders = $SC->getUnpaidOrders(array("user_id" => 13));</code>
							<p>Get all unpaid orders that belong to user with user id 13. Return value:</p>
							<code>Array
(
	[id] => 130,
	[user_id] => 13,
	[order_no] => "WEB19",
	[country] => "DK",
	[currency] => "DKK",
	[status] => 0,
	[payment_status] => 0,
	[shipping_status] => 0,
	[delivery_name] => 
	[delivery_att] => 
	[delivery_address1] =>
	[delivery_address2] =>
	[delivery_city] =>
	[delivery_postal] =>
	[delivery_state] =>
	[delivery_country] =>
	[billing_name] => "testuser@test.com",
	[billing_att] =>
	[billing_address1] =>
	[billing_address2] =>
	[billing_city] =>
	[billing_postal] =>
	[billing_state] =>
	[billing_country] =>
	[comment] =>
	[created_at] => "2019-04-16 18:51:55",
	[modified_at] => "2019-04-16 18:52:30"
)</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>
						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Query</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
