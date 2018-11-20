<?php
/**
* @package animated.rackspace
* This file contains rackspace api helpers
*/


/**
 * Copyright 2012-2014 Rackspace US, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// avoid timeouts
set_time_limit(0);

// inclide rackspace class
require(LOCAL_PATH . '/includes/php-opencloud-1.15/vendor/autoload.php');

use OpenCloud\Rackspace;
use OpenCloud\ObjectStore\Constants\UrlType;
use Guzzle\Http\Exception\CurlException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use OpenCloud\ObjectStore\Exception\ObjectNotFoundException;
use OpenCloud\Common\Exceptions\EndpointError;

use Guzzle\Plugin\Log\LogPlugin;



class JanitorRackspace {

	/**
	* Init, set varnames, validation rules
	*/
	function __construct() {}


	function getService($username, $apikey, $location) {


		try {

			// 1. Instantiate a Rackspace client. You can replace {authUrl} with
			// Rackspace::US_IDENTITY_ENDPOINT or similar
			$client = new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, array(
				'username' => $username,
				'apiKey'   => $apikey
			));

		}
		catch(CurlException $e) {
			return false;
		}
		catch(ClientErrorResponseException $e) {
			return false;
		}
		catch(EndpointError $e) {
			return false;
		}

		// $client->addSubscriber(LogPlugin::getDebugPlugin(true, fopen('/srv/rackspace/sdk-'.date("Ymd").'.log', 'w+')));


		try {

			// Obtain an Object Store service object from the client.
			$service = $client->objectStoreService(null, $location);

			return $service;

		}
		catch (ObjectNotFoundException $e) {
			return false;
		}
		catch(CurlException $e) {
			return false;
		}
		catch(ClientErrorResponseException $e) {
			return false;
		}
		catch(EndpointError $e) {
			return false;
		}
	}


	function getCdnContainers($service) {

		try{

			$cdn_service = $service->getCdnService();
			$cdn_containers = $cdn_service->listContainers();
			return $cdn_containers;

		}
		catch (ObjectNotFoundException $e) {
			return false;
		}
		catch(CurlException $e) {
			return false;
		}
		catch(ClientErrorResponseException $e) {
			return false;
		}
		catch(EndpointError $e) {
			return false;
		}

	}


	function getLoggingContainer($service) {

		try {

			$container = $service->getContainer('.CDN_ACCESS_LOGS');
			return $container;
		}
		catch (ObjectNotFoundException $e) {
			return false;
		}
		catch(CurlException $e) {
			return false;
		}
		catch(ClientErrorResponseException $e) {
			return false;
		}
		catch(EndpointError $e) {
			return false;
		}

	}

	function getObjects($container, $params) {

		try {

			$objects = $container->objectList($params);
			return $objects;
		}
		catch (ObjectNotFoundException $e) {
			return false;
		}
		catch(CurlException $e) {
			return false;
		}
		catch(ClientErrorResponseException $e) {
			return false;
		}
		catch(EndpointError $e) {
			return false;
		}

	}


	function getContainer($service, $name) {

		try {

			$container = $service->getContainer($name);
			return $container;
		}
		catch (ObjectNotFoundException $e) {
			return false;
		}
		catch(CurlException $e) {
			return false;
		}
		catch(ClientErrorResponseException $e) {
			return false;
		}
		catch(EndpointError $e) {
			return false;
		}

	}


	function getOrCreateContainer($service, $name) {

		$container = $this->getContainer($service, $name);
		if(!$container) {

			try {

				$container = $service->createContainer($name);
				return $container;

			}
			catch (ObjectNotFoundException $e) {
				return false;
			}
			catch(CurlException $e) {
				return false;
			}
			catch(ClientErrorResponseException $e) {
				return false;
			}
			catch(EndpointError $e) {
				return false;
			}

		}

		return $container;

	}

	function enableCdn($container) {
		
		try {
		
			// Enable CDN on container
			$container->enableCdn();

			// Get CDN enabled container
			$container = $container->getCdn();

			// Enable CDN logging
			$container->enableCdnLogging();

			return $container;

		}
		catch (CdnNotAvailableError $e) {
			return false;
		}
		catch (ObjectNotFoundException $e) {
			return false;
		}
		catch(CurlException $e) {
			return false;
		}
		catch(ClientErrorResponseException $e) {
			return false;
		}
		catch(EndpointError $e) {
			return false;
		}

	}

	function uploadFile($container, $filename, $file, $headers = []) {

		try {

			$object = $container->uploadObject(basename($file), fopen($file, 'r+'), $headers);
			return $object;
		}

		catch(RuntimeException $e) {
			print_r($e);
			return false;
		}
		catch(ObjectNotFoundException $e) {
			return false;
		}
		catch(CurlException $e) {
			return false;
		}
		catch(ClientErrorResponseException $e) {
			return false;
		}
		catch(EndpointError $e) {
			return false;
		}

	}

}

?>