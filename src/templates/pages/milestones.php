<?php
global $action;
$IC = new Items();
$model = $IC->typeObject("todo");

$this->bodyClass("gettingstarted");
$this->pageTitle("Where we are heading ...");

$page_item = $IC->getItem(array("tags" => "page:milestones", "extend" => array("user" => true, "tags" => true, "mediae" => true)));

$todolists = $IC->getItems(array("itemtype" => "todolist", "status" => 1, "order" => "position ASC", "extend" => true));
$todotags = $IC->getTags(array("context" => "todo"));

$todotags_priority = array("General", "Backend interface");

?>
<div class="scene milestones i:scene">

<? if($page_item && $page_item["status"]): 
	$media = $IC->sliceMedia($page_item); ?>
	<div class="article i:article" itemscope itemtype="http://schema.org/Article">

		<? if($media): ?>
		<div class="image item_id:<?= $page_item["item_id"] ?> format:<?= $media["format"] ?> variant:<?= $media["variant"] ?>"></div>
		<? endif; ?>


		<?= $HTML->articleTags($page_item, [
			"context" => false
		]) ?>


		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>


		<?= $HTML->articleInfo($page_item, "/pages/milestones", [
			"media" => $media, 
			"sharing" => true
		]) ?>


		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>

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
<? endif; ?>

</div>
