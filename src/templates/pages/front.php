<div class="scene front i:front">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">the Janitor</h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="modified_at">Date modified</dt>
			<dd class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", strtotime($page["modified_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($page["published_at"])) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author">Martin Kæstel Nielsen</dd>
		</dl>

		<div class="articlebody" itemprop="articleBody">
			<h2>
				Welcome to the basement. It's dusky but it is ok - no one really wants to know how, as long as it works.
			</h2>
			<p>
				Janitor is currently in v0.7.6.
			</p>
			<p>
				Janitor is an open source PHP content management and distribution developer toolkit, with a unique focus on frontend development.
				It has been designed from ground up to facilitate the frontend development process. Implementing the unique 
				combination of the <a href="http://modulator.parentnode.dk" target="_blank">Modulator</a> markup model, the
				<a href="http://detector.parentnode.dk" target="_blank">Detector</a> segments and a very user friendly 
				<a href="http://manipulator.parentnode.dk" target="_blank">Manipulator</a> enhanced backend interface, Janitor 
				is ready to distribute content to any HTML capable browser.
			</p>
			<p>
				A simple Items based data model for custom content. Image, video and audio conversion and scaling.
				Users and roles. A bunch of default content models to get started. Auto inheritance and ease of customization.
				Janitor is a powerful and simple full range developer toolkit.
			</p>
			<p>
				Janitor is NOT a CMS. It is designed to build optimized custom CMS' for custom needs.
			</p>

			<h3>Why is Janitor here</h3>
			<p>
				As a frontend programmer, I have always had a hard time with backend systems. They tend to enforce their
				arrogant lack of understanding HTML, CSS and JavaScript on the frontend development. In my opinion it is
				an epic failure that these monsters get to dictate the frontned output, when it should be the other way around.
				I mean, what is more important in the end: The website or the backend?
			</p>
			<p>
				I needed a system that was designed to work to my advantage. That is why I decided to build Janitor.
			</p>

			<h3>Github</h3>
			<p><a href="http://github.com/parentnode/janitor" target="_blank">Janitor is public on GitHub</a>.</p>


			<p class="note">
				We are currently in the process of updating the documentation. Until it is finished, we apoligize 
				the incomplete online documentation. Check the
				<a href="/pages/milestones">Milestones</a> for more information.
			</p>

		</div>

	</div>

	<div class="usedby">
		<h2>Selected clients</h2>
		<ul>
			<li class="oeo" title="oeo.dk">oeo.dk</li>
			<li class="landskabsarkitekter" title="Danske Landskabsarkitekter">Danske Landskabsarkitekter</li>
			<li class="metro" title="Copenhagen Metro">Copenhagen Metro</li>
			<li class="urbangreen" title="Urban Green">Urban Green</li>
			<li class="distortion" title="Distortion">Distortion</li>
		</ul>
	</div>

</div>
