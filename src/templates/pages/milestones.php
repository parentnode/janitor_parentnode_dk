<?php
global $action;
$IC = new Items();
$model = $IC->typeObject("todo");

$this->bodyClass("gettingstarted");
$this->pageTitle("Where we are heading ...");

$page = $IC->getItem(array("tags" => "page:milestones", "extend" => array("user" => true)));

$todolists = $IC->getItems(array("itemtype" => "todolist", "status" => 1, "order" => "position ASC", "extend" => true));
$todotags = $IC->getTags(array("context" => "todo"));

$todotags_priority = array("General", "Backend interface");

?>
<div class="scene milestones i:scene">

	<div class="article id:<?= $page["item_id"] ?>" itemscope itemtype="http://schema.org/Article">

		<h1 itemprop="headline"><?= $page["name"] ?></h1>

		<dl class="info">
			<dt class="published_at">Date published</dt>
			<dd class="published_at" itemprop="datePublished" content="<?= date("Y-m-d", strtotime($page["published_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($page["published_at"])) ?></dd>
			<dt class="modified_at">Date modified</dt>
			<dd class="modified_at" itemprop="dateModified" content="<?= date("Y-m-d", strtotime($page["modified_at"])) ?>"><?= date("Y-m-d, H:i", strtotime($page["published_at"])) ?></dd>
			<dt class="author">Author</dt>
			<dd class="author" itemprop="author" itemprop="name"><?= $page["user_nickname"] ?></dd>
			<dt class="publisher">Publisher</dt>
			<dd class="publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<ul class="publisher_info">
					<li class="name" itemprop="name">parentnode.dk</li>
					<li class="logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
						<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
						<span class="image_width" itemprop="width" content="720"></span>
						<span class="image_height" itemprop="height" content="405"></span>
					</li>
				</ul>
			</dd>
			<dt class="image_info">Image</dt>
			<dd class="image_info" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
				<span class="image_url" itemprop="url" content="<?= SITE_URL ?>/img/logo-large.png"></span>
				<span class="image_width" itemprop="width" content="720"></span>
				<span class="image_height" itemprop="height" content="405"></span>
			</dd>
		</dl>

		<div class="articlebody" itemprop="articleBody">
			<?= $page["html"] ?>

			<div class="todolists">
			<? if($todolists): ?>
				<ul class="todolists">
				<? foreach($todolists as $todolist): ?>
				
					<li class="todolist item_id:<?= $todolist["id"] ?>">
						<h2><?= $todolist["name"] ?></h2>
						<? if($todolist["description"]): ?>
							<p><?= nl2br($todolist["description"]) ?></p>
						<? endif; ?>
						<?

						$todolist_tags = $IC->getTags(array("item_id" => $todolist["id"], "context" => "todolist"));
						$todolist_tag = "todolist:".addslashes($todolist_tags[0]["value"]);

						// first loop through prioritized todotags
						foreach($todotags_priority as $priority):

							$query_tags = $todolist_tag.";todo:".$priority;
							$group_todos = $IC->getItems(array("itemtype" => "todo", "tags" => $query_tags, "extend" => array("tags" => true, "comments" => true)));

							if($group_todos): ?>
							<h3><?= $priority ?></h3>
							<ul class="todos">
								<? foreach($group_todos as $todo): ?>
								<li class="todo"><?= $todo["name"] ?><?= $todo["state"] != 10 ? (" (".$model->todo_state[$todo["state"]].")") : "" ?></li>
								<? endforeach; ?>
							</ul>
							<? endif;

						endforeach;

						foreach($todotags as $todotag):

							if(array_search($todotag["value"], $todotags_priority) === false) {

								$query_tags = $todolist_tag.";todo:".$todotag["value"];
								$group_todos = $IC->getItems(array("itemtype" => "todo", "tags" => $query_tags, "extend" => array("tags" => true, "comments" => true)));

								if($group_todos): ?>
								<h3><?= $todotag["value"] ?></h3>
								<ul class="todos">
									<? foreach($group_todos as $todo): ?>
									<li class="todo"><?= $todo["name"] ?><?= $todo["state"] != 10 ? (" (".$model->todo_state[$todo["state"]].")") : "" ?></li>
									<? endforeach; ?>
								</ul>
								<? endif;

							}

						endforeach;

					?>

					</li>
				<? endforeach; ?>
				</ul>

			<? else: ?>
				<p>No todos.</p>

			<? endif; ?>
			</div>

		</div>

	</div>

</div>
