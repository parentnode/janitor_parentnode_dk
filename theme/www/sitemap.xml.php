<?php
$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}

include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");
$query = new Query();
$IC = new Items();

print '<?xml version="1.0" encoding="UTF-8"?>';

?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?
// FRONT PAGE
$item = $IC->getItem(array("tags" => "page:front"));
?>
	<url>
		<loc><?= SITE_URL ?>/</loc>
		<lastmod><?= date("Y-m-d", strtotime($item["modified_at"])) ?></lastmod>
		<changefreq>weekly</changefreq>
		<priority>1</priority>
	</url>
<?
// GETTING STARTED PAGE
$item = $IC->getItem(array("tags" => "page:getting-started"));
?>
	<url>
		<loc><?= SITE_URL ?>/getting-started</loc>
		<lastmod><?= date("Y-m-d", strtotime($item["modified_at"])) ?></lastmod>
		<changefreq>weekly</changefreq>
		<priority>1</priority>
	</url>
<?
// DOCS PAGE
$item = $IC->getItem(array("tags" => "page:documentation"));
?>
	<url>
		<loc><?= SITE_URL ?>/docs</loc>
		<lastmod><?= date("Y-m-d", strtotime($item["modified_at"])) ?></lastmod>
		<changefreq>weekly</changefreq>
		<priority>1</priority>
	</url>
</urlset>