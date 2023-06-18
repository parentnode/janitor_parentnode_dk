<?php
/**
* This file contains definitions
*
* @package Config
*/
header("Content-type: text/html; charset=UTF-8");
error_reporting(E_ALL);

define("VERSION", "0.7.9.2");
define("UI_BUILD", "20230618-131346");

define("SITE_UID", "JANI");
define("SITE_NAME", "Janitor");
define("SITE_URL", (isset($_SERVER["HTTPS"]) ? "https" : "http")."://".$_SERVER["SERVER_NAME"]);
define("SITE_EMAIL", "info@parentnode.dk");

define("DEFAULT_PAGE_DESCRIPTION", "Janitor is a PHP content distribution framework, with a unique focus on frontend development");
define("DEFAULT_PAGE_IMAGE", "/img/logo-large.png");

define("DEFAULT_LANGUAGE_ISO", "EN");
define("DEFAULT_COUNTRY_ISO", "DK");
define("DEFAULT_CURRENCY_ISO", "DKK");

define("SITE_LOGIN_URL", "/login");

define("SITE_SIGNUP", "1");
define("SITE_SIGNUP_URL", "/signup");

define("SITE_ITEMS", true);

define("SITE_SHOP", true);
define("SHOP_ORDER_NOTIFIES", "test.parentnode@gmail.com");

define("SITE_SUBSCRIPTIONS", true);

define("SITE_MEMBERS", true);

define("SITE_COLLECT_NOTIFICATIONS", 100);

