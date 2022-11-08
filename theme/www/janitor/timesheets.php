<?php
/**
* toggl-reports – Generate custom Toggl time reports for easier invoicing
* Copyright (C) 2018  Martin Kæstel Nielsen
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");
include_once("classes/helpers/timesheets.class.php");

$action = $page->actions();
$timesheet = new TimesheetsGateway();

$page->bodyClass("timesheet");
$page->pageTitle("Timesheets");


if(is_array($action) && count($action)) {

	// tag time entries
	if(count($action) == 2 && $action[0] == "tag" && security()->validateCsrfToken()) {

		$entries = explode(",", getPost("entries"));
//		print_r($entries);

		$result = $toggl->updateTagsForTimeEntries($entries, ["tags" => [$action[1]], "tag_action" => "add"]);

		$output = new Output();
		$output->screen($result);
		exit();

	}

}

// plain login
$page->page(array(
	"templates" => "janitor/timesheets/index.php",
	"type" => "janitor"
));

