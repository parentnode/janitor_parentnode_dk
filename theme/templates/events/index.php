<?php
global $IC;
global $action;
global $itemtype;
$model = $IC->typeObject($itemtype);

$page_item = $IC->getItem(array("tags" => "page:events", "status" => 1, "extend" => array("user" => true, "mediae" => true, "tags" => true)));
if($page_item) {
	$this->sharingMetaData($page_item);
}

// year/month can be passed to define starting point
if(count($action) == 2) {
	$year = parseInt($action[0]);
	$month = parseInt($action[1]);
}
else {
	$year = date("Y");
	$month = date("m");
}

$date = date("d");

$items = $IC->getItems([
	"itemtype" => $itemtype, 
	"status" => 1, 
	"where" => $itemtype.".starting_at > '".date("Y-m-d", mktime(0,0,0, $month, $date, $year))."'", 
	"order" => $itemtype.".starting_at ASC", 
	"extend" => true
]);

// get 4 past events
$past_items = $IC->getItems([
	"itemtype" => $itemtype, 
	"status" => 1, 
	"where" => $itemtype.".starting_at < '".date("Y-m-d", mktime(0,0,0, $month, $date, $year))."'", 
	"order" => $itemtype.".starting_at ASC", 
	"extend" => true,
	"limit" => 4,
]);


?>

<div class="scene events i:eventitems" data-year="<?= $year ?>" data-month="<?= $month ?>">

<? if($page_item): 
	$media = $IC->sliceMediae($page_item, "single_media"); ?>
	<div class="article i:article id:<?= $page_item["item_id"] ?>" itemscope itemtype="http://schema.org/Article">

		<?= HTML()->renderSnippet("snippets/media.php", [
			"item" => $page_item,
			"media" => $media,
		]) ?>


		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>


		<?= HTML()->renderSnippet("snippets/info.php", [
			"item" => $page_item,
			"url" => HTML()->path,
			"media" => $media,
			"sharing" => true
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>

	</div>

<? else:?>

	<div class="article">
		<h1>Events</h1>
	</div>

<? endif; ?>


	<div class="all_events">
		<h2>Upcoming events</h2>

<?	if($items): ?>

		<ul class="items events">
<?		foreach($items as $item): ?>
			<li class="item event item_id:<?= $item["item_id"] ?>">

				<dl class="occurs_at">
					<dt class="starting_at">Starts</dt>
					<dd class="starting_at" content="<?= date("Y-m-d H:i", strtotime($item["starting_at"])) ?>"><?= date("l, F j, Y - H:i", strtotime($item["starting_at"])) ?></dd>
				</dl>

				<h3><? if($item["event_status"] != 1): 
					?><span class="event_status <?= strtolower($model->event_status_schema_values[$item["event_status"]]) ?>"><?= strtoupper($model->event_status_options[$item["event_status"]]).": " ?></span><?
				endif; ?><a href="<?= HTML()->path ?>/<?= $item["sindex"] ?>"><?= strip_tags($item["name"]) ?></a></h3>

<?				if($item["description"]): ?>
				<div class="description">
					<p><? if($item["event_status"] != 1):
						?><span class="event_status <?= strtolower($model->event_status_schema_values[$item["event_status"]]) ?>"><?= strtoupper($model->event_status_options[$item["event_status"]]).": " ?></span><?
					endif; ?><?= nl2br($item["description"]) ?></p>
				</div>
<?				endif; ?>

			</li>
<?		endforeach; ?>
		</ul>

<?	else: ?>

		<p>No scheduled events.</p>

<?	endif; ?>

	</div>


<?	if($past_items): ?>
	<div class="all_events past_events">
		<h2>Previous events</h2>

		<ul class="items events">
<?		foreach($past_items as $item): ?>
			<li class="item event item_id:<?= $item["item_id"] ?>">

				<dl class="occurs_at">
					<dt class="starting_at">Started at</dt>
					<dd class="starting_at" content="<?= date("Y-m-d H:i", strtotime($item["starting_at"])) ?>"><?= date("l, F j, Y - H:i", strtotime($item["starting_at"])) ?></dd>
				</dl>

				<h3><? if($item["event_status"] != 1): 
					?><span class="event_status <?= strtolower($model->event_status_schema_values[$item["event_status"]]) ?>"><?= strtoupper($model->event_status_options[$item["event_status"]]).": " ?></span><?
				endif; ?><a href="<?= HTML()->path ?>/<?= $item["sindex"] ?>"><?= strip_tags($item["name"]) ?></a></h3>

<?				if($item["description"]): ?>
				<div class="description">
					<p><? if($item["event_status"] != 1):
						?><span class="event_status <?= strtolower($model->event_status_schema_values[$item["event_status"]]) ?>"><?= strtoupper($model->event_status_options[$item["event_status"]]).": " ?></span><?
					endif; ?><?= nl2br($item["description"]) ?></p>
				</div>
<?				endif; ?>

			</li>
<?		endforeach; ?>
		</ul>

	</div>

<?	endif; ?>

</div>
