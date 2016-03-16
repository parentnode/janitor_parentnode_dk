<?php
$this->bodyClass("gettingstarted");
$this->pageTitle("Architecture of Janitor");
?>
<div class="scene gettingstarted i:scene">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="headline">Architecture of Janitor</h1>

		<ul class="info">
			<li class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></li>
			<li class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></li>
			<li class="author" itemprop="author">Martin Kæstel Nielsen</li>
			<li class="main_entity share" itemprop="mainEntityOfPage"><?= SITE_URL."/pages/architecture" ?></li>
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

			<p>Part of milestone for v0.8 - Check the
				<a href="/pages/milestones">Milestones</a> for more information.
			</p>

		</div>
	</div>

</div>
