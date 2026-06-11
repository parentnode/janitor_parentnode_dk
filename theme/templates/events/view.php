<?php
global $IC;
global $action;
global $itemtype;
$model = $IC->typeObject($itemtype);

$ticket_model = $IC->typeObject("ticket");

$countries = $this->countries();
$location = false;
$next = false;
$prev = false;

$sindex = $action[0];


$pagination_pattern = [
	"pattern" => [
		"itemtype" => "event", 
		"status" => 1, 
		"extend" => [
			"tags" => true, 
			"user" => true, 
			"mediae" => true,
			"comments" => true, 
			"readstate" => true,
			"prices" => true
		],
		"where" => "event.starting_at > NOW()",
		"order" => "event.starting_at ASC"
	],
	"sindex" => $sindex,
	"limit" => 1
];


// Get posts
$pagination_items = $IC->paginate($pagination_pattern);


if($pagination_items && $pagination_items["range_items"]) {

	$item = $pagination_items["range_items"][0];
	$this->sharingMetaData($item);

	// get host info
	$location = $model->getLocations(["id" => $item["location"]]);


	// set related pattern
	$related_pattern = [
		"itemtype" => $item["itemtype"], 
		"status" => 1, 
		"tags" => $item["tags"], 
		"exclude" => $item["id"]
	];
	$related_title = "Related events";

}
else {

	// itemtype pattern for missing item
	$related_pattern = ["itemtype" => $itemtype];
	$related_title = "Other events";

}


$related_pattern["where"] = "event.starting_at > NOW()";

// add base pattern properties
$related_pattern["limit"] = 5;
$related_pattern["extend"] = [
	"tags" => true, 
	"mediae" => true
];

// get related items
$related_items = $IC->getRelatedItems($related_pattern);


?>

<div class="scene event i:eventitem">

<? if($item):
	$media = $IC->sliceMediae($item, "single_media");
	$eventtype_tag = arrayKeyValue($item["tags"], "context", "eventtype"); ?>

	<div class="article i:article id:<?= $item["item_id"] ?> event<?= $eventtype_tag !== false ? " ".$item["tags"][$eventtype_tag]["value"] : "" ?>" itemscope itemtype="http://schema.org/Event"
		data-csrf-token="<?= session()->value("csrf") ?>"
		>

		<?= HTML()->renderSnippet("snippets/media.php", [
			"item" => $item,
			"media" => $media,
		]) ?>


		<?= HTML()->renderSnippet("snippets/tags.php", [
			"item" => $item,
			"context" => [$itemtype],
			"default" => [HTML()->path, "Posts"]
		]) ?>


		<h1 itemprop="name"><?= $item["name"] ?></h1>


		<?= HTML()->renderSnippet("snippets/info.php", [
			"item" => $item,
			"media" => $media,
			"sharing" => true
		]) ?>


		<dl class="event_status" itemprop="eventStatus" content="<?= $model->event_status_schema_values[$item["event_status"]] ?>">
			<dt>Event status</dt>
			<dd class="<?= strtolower($model->event_status_schema_values[$item["event_status"]]) ?>"><?= $model->event_status_options[$item["event_status"]] ?></dd>
		</dl>


		<dl class="occurs_at">
			<dt class="starting_at">Starts</dt>
			<dd class="starting_at" itemprop="startDate" content="<?= date("Y-m-d H:i", strtotime($item["starting_at"])) ?>"><?= date("F j, Y - H:i", strtotime($item["starting_at"])) ?></dd>
			<? if($item["ending_at"]): ?>
			<dt class="ending_at">Ends</dt>
			<dd class="ending_at" itemprop="endDate" content="<?= date("Y-m-d H:i", strtotime($item["ending_at"])) ?>"><?= date("F j, Y - H:i", strtotime($item["ending_at"])) ?></dd>
			<? endif; ?>
		</dl>

		<dl class="event_attendance">
			<dt>Attendance</dt>
			<dd class="event_attendance_mode" itemprop="eventAttendanceMode" content="<?= $model->event_attendance_mode_schema_values[$item["event_attendance_mode"]] ?>"><?= $model->event_attendance_mode_options[$item["event_attendance_mode"]] ?></dd>

<? if($item["event_attendance_limit"]): ?>
			<dt>Max participants</dt>
	<? if($item["event_attendance_mode"] != 3): ?>
			<dd class="event_attendance_limit" itemprop="maximumPhysicalAttendeeCapacity" content="<?= $item["event_attendance_limit"] ?>"><?= $item["event_attendance_limit"] ?></dd>
	<? else: ?>
			<dd class="event_attendance_limit" itemprop="maximumVirtualAttendeeCapacity" content="<?= $item["event_attendance_limit"] ?>"><?= $item["event_attendance_limit"] ?></dd>
	<? endif; ?>

<? endif; ?>
		</dl>

		<h2>Description</h2>
		<div class="articlebody" itemprop="description">
			<?= $item["html"] ?>
		</div>



		<? if($location): ?>
		<div class="location">
			<h2>Location</h2>

			<? if($location["location_type"] == 1): ?>

			<ul class="location" itemprop="location" itemscope itemtype="https://schema.org/Place">
				<li class="name" itemprop="name"><?= $location["location"] ?></li>
				<li class="address" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
					<ul>
						<li class="streetaddress" itemprop="streetAddress"><?= 
								($location["location_address1"] ? $location["location_address1"] : "") . 
								(($location["location_address1"] && $location["location_address2"]) ? ", " : "") . 
								($location["location_address2"] ? $location["location_address2"] : "")
						?></li>
						<li class="city"><span class="postal" itemprop="postalCode"><?= 
								$location["location_postal"] ? $location["location_postal"] : "" 
							?></span> <span class="locality" itemprop="addressLocality"><?= 
								$location["location_city"] ? $location["location_city"]  : ""
						?></span></li>
						<li class="country" itemprop="addressCountry"><?= 
							$location["location_country"] ? $countries[arrayKeyValue($countries, "id", $location["location_country"])]["name"] : ""
						?></li>
					</ul>
				</li>
				<? if($location["location_googlemaps"]): ?>
				<li class="googlemaps" itemprop="hasMap" content="<?= $location["location_googlemaps"] ?>"><a href="<?= $location["location_googlemaps"] ?>" target="_blank">Map</a></li>
				<? endif; ?>
				<? if($location["location_comment"]): ?>
				<li class="location_comment"><?= $location["location_comment"] ?></li>
				<? endif; ?>
			</ul>

			<? else: ?>

			<ul class="location" itemprop="location" itemscope itemtype="https://schema.org/VirtualLocation">
				<li class="name" itemprop="name"><?= $location["location"] ?></li>
				<? if($location["location_url"]): ?>
				<li class="url" itemprop="url" content="<?= $location["location_url"] ?>"><a href="<?= $location["location_url"] ?>" target="_blank"><?= $location["location_url"] ?></a></li>
				<? endif; ?>
				<? if($location["location_comment"]): ?>
				<li class="location_comment"><?= $location["location_comment"] ?></li>
				<? endif; ?>
			</ul>

			<? endif; ?>

		</div>
		<? endif; ?>


		<?= HTML()->renderSnippet("snippets/pagination.php", [
			"items" => $pagination_items,
			"type" => "sindex",
			"show_total" => false,
			"labels" => ["prev" => "{name}", "next" => "{name}"]
		]) ?>


	</div>


<? else: ?>

	<div class="article">
		<h1>Technology has limits</h1>
		<p>We could not find the specified post.</p>
	</div>

<? endif; ?>


<?= HTML()->renderSnippet("snippets/related.php", [
	"items" => $related_items,
]) ?>


</div>
