<?php
/**
* This file contains definitions
*
* @package Config
*/
header("Content-type: text/html; charset=UTF-8");
error_reporting(E_ALL);

/**
* Required site information
*/
define("SITE_UID", "JANI");
define("SITE_NAME", "Janitor");
define("SITE_URL", (isset($_SERVER["HTTPS"]) ? "https" : "http")."://".$_SERVER["SERVER_NAME"]);
define("SITE_EMAIL", "info@parentnode.dk");

/**
* Optional constants
*/
define("DEFAULT_PAGE_DESCRIPTION", "Janitor is a PHP content distribution framework, with a unique focus on frontend development");
define("DEFAULT_PAGE_IMAGE", "/img/logo-large.png");

define("DEFAULT_LANGUAGE_ISO", "EN");
define("DEFAULT_COUNTRY_ISO", "DK");
define("DEFAULT_CURRENCY_ISO", "DKK");


// // Enable items model
define("SITE_ITEMS", true);
// 
// // Enable shop model
define("SITE_SIGNUP", "/signup");

define("SITE_SUBSCRIPTIONS", true);
define("SITE_MEMBERS", true);

// Enable shop model
define("SITE_SHOP", true);
define("SHOP_ORDER_NOTIFIES", "martin@think.dk");

// Enable notifications (send collection email after N notifications)
define("SITE_COLLECT_NOTIFICATIONS", 100);

//define("SITE_INSTALL", true);

?>
