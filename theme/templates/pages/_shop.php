<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("Getting started with Janitor");
?>
<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="headline">Shop architecture</h1>

		<ul class="info">
			<li class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></li>
			<li class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"></li>
			<li class="author" itemprop="author">Martin Kæstel Nielsen</li>
			<li class="main_entity share" itemprop="mainEntityOfPage" content="<?= SITE_URL."/getting-starting" ?>"></li>
			<li class="publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<ul class="publisher_info">
					<li class="name" itemprop="name">parentnode.dk</li>
					<li class="logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
						<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
						<span class="image_width" itemprop="width" content="720"></span>
						<span class="image_height" itemprop="height" content="405"></span>
					</li>
				</ul>
			</li>
			<li class="image_info" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
				<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
				<span class="image_width" itemprop="width" content="720"></span>
				<span class="image_height" itemprop="height" content="405"></span>
			</li>
		</ul>

		<div class="articlebody" itemprop="articleBody">

			<p>
				The Shop module consists of a cart, checkout (login/signup) and order flow.
			</p>
			<p>I'm a user - I want to:</p>

			subscribe to a free membership
			- click join
			- skip cart
			- complete checkout
			- confirmation

			subscribe to a paid membership
			- click join
			- skip cart
			- complete checkout
			- payment


			subscribe to an item without a price, without subscription method
			- click subscribe
			- confirmation

			subscribe to an item with a price, without subscription method
			- click subscribe


			subscribe to an item without a price, with subscription method

			subscribe to an item with a price, with subscription method

			
			buy an item
			- click buy
			- add to cart
			- complete checkout
			- payment

			

			<ol>
				<li>
					<h2>User subscribes to an item</h2>

					(this interface should only)

					a - the item is itemtype = membership


					a - the item has a price

						* the item is added to the cart

						* the cart becomes an order
						* the order is paid
						* the order is shipped

						* subscription [is not created until order is shipped]

						SHOUD SUBSCRIPTION BE CREATED HERE?


					b - the item does not have price

						* the subscription is added

				</li>
				<li>
	
					<h2>2: User buys an item</h2>

						* the item is added to the cart
						* the cart becomes an order
						* the order is paid
						* the order is shipped


					a - the item has a subscription method
				</li>
			</ol>

		</div>
	</div>

</div>
