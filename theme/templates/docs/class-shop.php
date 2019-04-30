<div class="scene docpage i:docpage">
	<h1>The Shop Class</h1>
	<p>Cart and Order helper class</p>

	<div class="section functions">
		<div class="header">
			<h2>Functions</h2>
		</div>
		<div class="body">

			<div class="function" id="_functionname_">
				<div class="header">
					<h3>Shop::deleteItemtypeFromCart</h3>
				</div>
				<div class="body">
					<div class="definition">
						<h4>Definition</h4>
						<dl class="definition">
							<dt class="name">Name</dt>
							<dd class="name">Shop::deleteItemtypeFromCart</dd>
							<dt class="syntax">Syntax</dt>
							<dd class="syntax"><span class="type">Array|False</span> = 
								Shop::deleteItemtypeFromCart(
									<span class="type">String</span> <span class="var">$itemtype</span>, 
								);
							</dd>
						</dl>
					</div>

					<div class="description">
						<h4>Description</h4>
						<p>Delete items specified by itemtype from cart.</p>
					</div>

					<div class="parameters">
						<h4>Parameters</h4>

						<dl class="parameters">
							<dt><span class="var">$itemtype</span></dt>
							<dd>
								<div class="summary">
									<span class="type">String</span> The specified itemtype to be deleted from cart
								</div>
							</dd>
						</dl>
					</div>

					<div class="return">
						<h4>Return values</h4>
						<p><span class="type">Array</span> Returns the updated cart. Returns existing car if there is no item matching the specified itemtype.
						<p><span class="type">False</span> if function fails (no cart is found).</p>
					</div>

					<div class="examples">
						<h4>Examples</h4>

						<div class="example">
							<h5>Example 1</h5>
							<code>$cart = Array ( 
	[id] => 7,
	[user_id] => 2,
	[cart_reference] => "m9hi0spkcvfk",
	[country] => DK,
	[currency] => DKK,
	[delivery_address_id] => 
	[billing_address_id] => 
	[created_at] => 2019-03-28 16:58:39 
	[modified_at] => 2019-03-29 10:12:54 
	[items] => Array ( 
		[0] => Array ( 
			[id] => 262 
			[cart_id] => 7 
			[item_id] => 158 
			[quantity] => 1 
		) 
		[1] => Array ( 
			[id] => 263 
			[cart_id] => 7 
			[item_id] => 157 
			[quantity] => 1
		) 
	)
	[total_items] => 2 
) 
$itemtype = "membership";
$cart = $SC->deleteItemtypeFromCart($itemtype);</code>
							<p>Deletes item specified by itemtype. Returns updated cart.</p>
							<code>$cart = Array ( 
	[id] => 7,
	[user_id] => 2,
	[cart_reference] => "m9hi0spkcvfk",
	[country] => DK,
	[currency] => DKK,
	[delivery_address_id] => 
	[billing_address_id] => 
	[created_at] => 2019-03-28 16:58:39 
	[modified_at] => 2019-03-29 10:12:54 
	[items] => Array ( 
		[0] => Array ( 
			[id] => 262 
			[cart_id] => 7 
			[item_id] => 158 
			[quantity] => 1 
		) 
	)
	[total_items] => 1 
)</code>
						</div>
					</div>

					<div class="dependencies">
						<h4>Dependencies</h4>

						<div class="janitor">
							<!-- list janitor functions used by function -->
							<h5>Janitor</h5>
							<ul>
								<li>Item::getItem()</li>
								<li>Shop::getCart()</li>
								<li>Shop:deleteFromCart()</li>
							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>

</div>
