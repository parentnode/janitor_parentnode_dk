<?php

// require_once("includes/googlemaps/google-maps-services-php/vendor/autoload.php");
//
//
// use \yidas\googleMaps\Client;
// use Guzzle\Http\Exception\CurlException;


class JanitorGoogleMaps {

	// Mailer settings
	private $api_key;


	function __construct($_settings) {

		$this->api_key = $_settings["api-key"];

	}

	function getApiKey() {
		return $this->api_key;
	}

	function getDirections($from, $to, $_options = false) {

		// //get form data for directions
		// $origin=$this->input->post('start');
		// $dest=$this->input->post('end');
		// $user=$this->session->userdata('trail_id');
		// $query=$this->db->get_where('trail', array('user_id' => $user));
		//
		// foreach($query->result() as $result)
		// {
		// 	$query2=$this->db->get_where('locations', array('id' => $result->point));
		//
		// 	$url='http://maps.googleapis.com/maps/api/directions/xml?';
		// 	$url .= 'origin='.urlencode($origin); //origin from form
		// 	$url .= '&destination='.urlencode($dest).'&waypoints='; //destination from form
		//
		// 	foreach ($query2->result() as $result)
		// 	{
		// 		$url.=urlencode($result->address).','.urlencode($result->city).','.urlencode($result->state);
		// 		$url.='|';
		// 	}
		// 	$url=substr($url, 0, -1); //removing the last |
		// 	$url .='&sensor=false';
		//
		//
		// }
		// //curl the $url
		// echo $url;
		// $results=$this->curl->simple_get($url);
		// $results=new SimpleXMLElement($results);
		// $data['directions']=$results;
		// $data['origin']=$origin;
		// $data['dest']=$dest;
		//
		// //echo the directions
		// $this->load->view('directions', $data);
	
	}


	function findBestRoute($from, $to, $_options = false) {

		$optimize = "true";
		$departure_time = time();
		$mode = "driving";
		$traffic_model = "best_guess";
		
		$waypoints = false;


		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {

					case "optimize"              : $optimize                = $_value; break;

					case "waypoints"             : $waypoints               = $_value; break;

					case "departure_time"        : $departure_time          = $_value; break;
					case "mode"               	 : $mode                    = $_value; break;
					case "traffic_model"         : $traffic_model           = $_value; break;

				}
			}
		}




		$url = "https://maps.googleapis.com/maps/api/directions/json?";

		$url .= "destination=".urlencode($from)."&";
		$url .= "origin=".urlencode($to)."&";


		if($mode) {
			$url .= "mode=".$mode."&";
		}

		if($traffic_model) {
			$url .= "traffic_model=".$traffic_model."&";
		}

		if($departure_time) {
			$url .= "departure_time=".$departure_time."&";
		}

		if($waypoints) {
			$url .= "waypoints="; 

			// Add optimize to waypoints
			if($optimize) {
				$url .= "optimize:".$optimize."|";
			}

			$locations = [];

			foreach($waypoints as $waypoint) {

				$address = "";

				if(isset($waypoint["via"])) {
					$address .= "via:";
				}

				$address .= $waypoint["location"];
				$locations[] = $address;

			}

			$url .= urlencode(implode("|", $locations));

		}

		// Make API request
		$response = $this->request($url);

		if($response && $response["status"] == "OK") {
			// debug([$response]);

			$best_route = [];

			// total travelling time
			$total_travel_time = 0;
			foreach($response["routes"][0]["waypoint_order"] as $i => $waypoint_order) {
				$total_travel_time += ceil($response["routes"][0]["legs"][$i]["duration"]["value"] / 60);

				$waypoints[$waypoint_order]["travel_time"] = ceil($response["routes"][0]["legs"][$i]["duration"]["value"] / 60);
				$best_route["waypoints"][] = $waypoints[$waypoint_order];
			}

			// Include origin and destination
			$best_route["from"]["location"] = $from;
			$best_route["from"]["travel_time"] = 0;
			$best_route["to"]["location"] = $to;
			$best_route["to"]["travel_time"] = ceil($response["routes"][0]["legs"][count($response["routes"][0]["legs"])-1]["duration"]["value"] / 60);

			// Include driving home time
			$total_travel_time += $best_route["to"]["travel_time"];
			$best_route["total_travel_time"] = $total_travel_time;


			return $best_route;
		}

		return false;
	}

	function request($url) {


		$url .= "&key=".$this->api_key;

		// debug(["url", $url]);

		$response = curl()->request($url);
		if($response["http_code"] == 200) {
			return json_decode($response["body"], true);
		}

		return false;

	}

	// Respond with exception data
	function exceptionResponder($exception) {
		$error = "";

		$errors = $exception->getErrors();
		if($errors) {
			if(isset($errors["message"])) {
				$error = $errors["message"];
			}
			else if(is_array($errors)) {
				foreach($errors as $err) {
					$error .= $err["message"]."\n";
				}
			}
		}

		return ["status" => "error", "message" => $error];
	}

	// Handle any stripe exception and notify Admin
	function exceptionHandler($action, $exception) {
		$error = "";

		$errors = $exception->getErrors();
		if($errors) {
			if(isset($errors["message"])) {
				$error = $errors["message"];
			}
			else if(is_array($errors)) {
				foreach($errors as $err) {
					$error .= $err["message"]."\n";
				}
			}
		}

		// Add log entry
		global $page;
		$page->addLog($action." failed: message:".$error, "JanitorGoogleApi");

		// Send mail to admin
		mailer()->send([
			"subject" => SITE_URL." - $action - Google Api exception (".$error.")", 
			"message" => "Exception thrown when $action: \n" . print_r($errors, true),
			"template" => "system"
		]);

	}

}
