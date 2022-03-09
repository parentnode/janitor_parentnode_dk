<?php

require_once('includes/sms/twilio/vendor/autoload.php');
use Twilio\Rest\Client;


class JanitorTwilio {

	function __construct($_settings) {


		# Instantiate the client.
		$this->sid = $_settings["sid"];
		$this->token = $_settings["token"];
		$this->from = $_settings["from"];
		$this->client = new Client($this->sid, $this->token);

	}

	function send($_options) {

		$to = false;
		$from = false;
		$body = false;

		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {

					case "to"                    : $to                    = $_value; break;
					case "from"                  : $from                  = $_value; break;
					case "body"                  : $body                  = $_value; break;

				}
			}
		}

		// since dash ("–") cannot be encoded with the GSM-7 standard, we convert dashes to hyphens ("-"). 
		// If we don't, Twilio will fall back to UCS-2 encoding, which contains much fewer characters per text than GSM-7, causing texting to be more costly
		if($body) {
			$body = str_replace("–", "-", $body);
		}

		$sms_options = [];
		$sms_options["from"] = $from;
		$sms_options["body"] = $body;

		try {
			return $this->client->messages->create($to, $sms_options);
		}
		catch(HttpClientException $e) {
			return false;
		}
		// Catch general exception
		catch(Exception $e) {
			return false;
		}

	}

	function fetchMessage($sid) {

		try {
			return $this->client->messages($sid)->fetch();
		}
		catch(HttpClientException $e) {
			return false;
		}
		// Catch general exception
		catch(Exception $e) {
			return false;
		}
	}

}
