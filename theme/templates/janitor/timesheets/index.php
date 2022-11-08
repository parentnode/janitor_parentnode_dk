<?

global $toggl;
global $togglReport;


global $timesheet;

$missing_project = false;
$missing_client = false;


// Get reports for the last three years
// $project_ids = "177174365,177348428";
$project_ids = false;
$client_ids = "42890218";

$entries = [];
$_entries = $timesheet->getReports(["client_ids" => $client_ids, "project_ids" => $project_ids, "since" => gmdate("c", strtotime("-3 year")), "until" => gmdate("c", strtotime("-2 year"))]);
$entries = array_merge($_entries, $entries);
$_entries = $timesheet->getReports(["client_ids" => $client_ids, "project_ids" => $project_ids, "since" => gmdate("c", strtotime("-2 year")), "until" => gmdate("c", strtotime("-1 year"))]);
$entries = array_merge($_entries, $entries);
$_entries = $timesheet->getReports(["client_ids" => $client_ids, "project_ids" => $project_ids, "since" => gmdate("c", strtotime("-1 year")), "until" => gmdate("c", time())]);
$entries = array_merge($_entries, $entries);


?>
<div class="scene toggloverview i:toggloverview">
	<h1>Toggl reports</h1>
	<h2>Fetched a total of <?= count($entries) ?> entries</h2>

<?
	// print_r($entries);


	// Sort data
	$data["clients"] = [];

	foreach($entries as $entry) {

		if(!$entry->client) {
			$missing_client = true;
		}

		if(!$entry->project) {
			$missing_project = true;
		}

		if(!isset($data["clients"][$entry->client])) {
			$data["clients"][$entry->client] = [];
		}

		if(!isset($data["clients"][$entry->client][$entry->project])) {
			$data["clients"][$entry->client][$entry->project] = [];
		}

		if(!isset($data["clients"][$entry->client][$entry->project][$entry->user])) {
			$data["clients"][$entry->client][$entry->project][$entry->user] = [];
		}

		array_push($data["clients"][$entry->client][$entry->project][$entry->user], [
			"id" => $entry->id, 
			"date" => date("d/m/Y", strtotime($entry->start)), 
			"description" => $entry->description, 
			"dur" => round($entry->dur/1000/60)
		]);

		// Sort clients alphabetically
		arsort($data["clients"]);
	}
?>

<? if($missing_client || $missing_project): ?>
	<div class="warning">
	<p class="system_warning">
	<? if($missing_client): ?>
		THERE ARE ENTRIES WITHOUT CLIENT ASSOCIATION<br />
	<? endif; ?>
	<? if($missing_project): ?>
		THERE ARE ENTRIES WITHOUT PROJECT ASSOCIATION<br />
	<? endif; ?>
		– PLEASE FIX THIS BEFORE CONTINUING
	</p>
	</div>
<? endif; ?>

<?
	foreach($data["clients"] as $client => $projects):
		$total_client_hours = 0;
?>
	<div class="item client <?= supernormalize($client) ?> i:moveTotals">
		<h2<?= !$client ? ' class="error"' : '' ?>><?= $client ? $client : "NO CLIENT" ?></h2>

<?
 		foreach($projects as $project => $users):
			$total_project_hours = 0;
?>
		<div class="item project <?= supernormalize($client) ?> <?= supernormalize($project) ?>">
			<h3<?= !$project ? ' class="error"' : '' ?>><?= $project ? $project : "NO PROJECT" ?></h3>

			<ul class="users">
<?
				foreach($users as $user => $timeentries):
					$total = 0;
					$total_rounded = 0;
?>
				<li class="user <?= supernormalize($client) ?> <?= supernormalize($project) ?> <?= supernormalize($user) ?>">
					<h4><?= $user ?></h4>

					<div class="all_items i:defaultList i:timeentries selectable filters"
						data-csrf-token="<?= session()->value("csrf") ?>"
						data-invoiced="<?= security()->validPath("/index/tag/afregnet") ?>"
						data-written_off="<?= security()->validPath("/index/tag/afskrevet") ?>"
					>
						<ul class="items">

<?
					foreach($timeentries as $entry):
						$total = $total + $entry["dur"];
						$total_rounded = $total_rounded + ($entry["dur"]%15 ? 15 - $entry["dur"]%15 : 0) + $entry["dur"];
?>
							<li class="item id:<?= $entry["id"] ?>">
								<h3>
									<span class="date"><?= $entry["date"] ?></span>
									<span class="duration"><span class="minutes"><?= $entry["dur"] ?></span> min.</span>
									<span class="description"><?= $entry["description"] ?></span>
								</h3>
							</li>

<? 					endforeach; ?>
				
						</ul>

						<h5 class="total_selection">SELECTION TOTAL: <span class="hours">0</span> hours (<span class="minutes">0</span> min.) / <span class="hours15">0</span> hours (<span class="minutes15">0</span> min.)</h5>
						<h5 class="total">TOTAL: <span class="hours"><?= ceil($total/60) ?></span> hours (<span class="minutes"><?= $total ?></span> min.) / <span class="hours15"><?= ceil($total_rounded/60) ?></span> hours (<span class="minutes15"><?= $total_rounded ?></span> min.)</h5>
					</div>

					<div class="total user"><?= ceil($total/60) ?></span> hours</div>
				</li>

<?			
					$total_project_hours += ceil($total/60);

				endforeach;
?>
			</ul>
			<div class="total project"><?= $total_project_hours ?></span> hours</div>

		</div>
<?
			$total_client_hours += $total_project_hours;

		endforeach;
?>
		<div class="total client"><?= $total_client_hours ?></span> hours</div>

	</div>

<?	endforeach; ?>


<?	//print_r($data); ?>
</div>
