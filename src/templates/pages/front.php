<div class="scene front i:front">

	<div class="article" itemscope itemtype="http://schema.org/Article">
		<h1 itemprop="name">the Janitor</h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", filemtime(__FILE__)) ?>"><?= date("Y-m-d, H:i", filemtime(__FILE__)) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author">Martin Kæstel Nielsen</dd>
		</dl>

		<div class="articlebody" itemprop="articleBody">
			<h2>
				Welcome to the basement. It's dark and it is ok - no one wants to know how, as long as it works.
			</h2>
			<p>
				Janitor is a PHP content management framework and distribution system, with a unique focus on frontend development.
				It has been designed from ground up to facilitate the frontend development process. Implementing the unique 
				combination of the <a href="http://modulator.parentnode.dk" target="_blank">Modulator</a> markup model, the
				<a href="http://detector.parentnode.dk" target="_blank">Detector</a> segments and a very user friendly 
				<a href="http://detector.parentnode.dk" target="_blank">Manipulator</a> enhanced backend interface, Janitor 
				is ready to distribute content to any HTML capable browser.
			</p>
			<p>
				Adding a simple Items based data model for custom content, image, video and audio conversion and scaling,
				users and roles, a bunch of default content models, auto inheritance and ease of customization Janitor 
				is a powerful and simple full range CMF/CDS.
			</p>
			<p>
				Janitor is NOT a CMS. It is designed, to build custom CMS' for custom needs.
			</p>

			<p>
				As a frontend programmer, I have always had a hard time with backend systems. They tend to enforce their
				arrogant lack of understanding HTML, CSS and JavaScript on the frontend development. In my opinion it is
				an epic failure that these monsters get to dictate the frontned output, when it should be the other way around.
				I mean what is more important in the end: The website or the backend?
			</p>
			<p>
				That is why I decided to build Janitor.
			</p>

			<p class="note">
				We are currently in the process of writing the documentation, while working on the release of
				Janitor 0.8. Until then, we apoligize the lack of online documentation.
			</p>

		</div>

	</div>

</div>
