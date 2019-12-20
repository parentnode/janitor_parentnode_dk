<?php
/**
* This file contains customized HTML-element output functions
*/
class HTML extends HTMLCore {

	function frontendComments($item, $add_path) {
		global $page;

		$_ = '';

		$_ .= '<div class="comments i:comments item_id:'.$item["item_id"].'"';
		$_ .= '	data-comment-add="'.$page->validPath($add_path).'"';
		$_ .= '	data-csrf-token="'.session()->value("csrf").'"';
		$_ .= '	>';
		$_ .= '	<h2 class="comments">Comments</h2>';
		if($item["comments"]):
			$_ .= '<ul class="comments">';
			foreach($item["comments"] as $comment):
			$_ .= '<li class="comment comment_id:'.$comment["id"].'" itemprop="comment" itemscope itemtype="https://schema.org/Comment">';
				$_ .= '<ul class="info">';
					$_ .= '<li class="published_at" itemprop="datePublished" content="'.date("Y-m-d", strtotime($comment["created_at"])).'">'.date("Y-m-d, H:i", strtotime($comment["created_at"])).'</li>';
					$_ .= '<li class="author" itemprop="author">'.$comment["nickname"].'</li>';
				$_ .= '</ul>';
				$_ .= '<p class="comment" itemprop="text">'. $comment["comment"].'</p>';
			$_ .= '</li>';
			endforeach;
		$_ .= '</ul>';
		else:
		$_ .= '<p>No comments yet</p>';
		endif;
		$_ .= '</div>';
		
		return $_;

	}


	function articleInfo($item, $url, $_options) {

		$media = false;
		$sharing = false;

		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {
					case "media"            : $media              = $_value; break;
					case "sharing"          : $sharing            = $_value; break;
				}
			}
		}

		$_ = '';

		$_ .= '<ul class="info">';
		$_ .= '	<li class="published_at" itemprop="datePublished" content="'. date("Y-m-d", strtotime($item["published_at"])) .'">'. date("Y-m-d, H:i", strtotime($item["published_at"])) .'</li>';
		$_ .= '	<li class="modified_at" itemprop="dateModified" content="'. date("Y-m-d", strtotime($item["modified_at"])) .'"></li>';
		$_ .= '	<li class="author" itemprop="author">'. (isset($item["user_nickname"]) ? $item["user_nickname"] : SITE_NAME) .'</li>';
		$_ .= '	<li class="main_entity'. ($sharing ? ' share' : '') .'" itemprop="mainEntityOfPage" content="'. SITE_URL.$url .'"></li>';
		$_ .= '	<li class="publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">';
		$_ .= '		<ul class="publisher_info">';
		$_ .= '			<li class="name" itemprop="name">parentnode.dk</li>';
		$_ .= '			<li class="logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">';
		$_ .= '				<span class="image_url" itemprop="url" content="'. SITE_URL .'/img/logo-large.png"></span>';
		$_ .= '				<span class="image_width" itemprop="width" content="720"></span>';
		$_ .= '				<span class="image_height" itemprop="height" content="405"></span>';
		$_ .= '			</li>';
		$_ .= '		</ul>';
		$_ .= '	</li>';
		$_ .= '	<li class="image_info" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';

		if($media):
			$_ .= '		<span class="image_url" itemprop="url" content="'. SITE_URL .'/images/'. $item["item_id"] .'/'. $media["variant"] .'/720x.'. $media["format"] .'"></span>';
			$_ .= '		<span class="image_width" itemprop="width" content="720"></span>';
			$_ .= '		<span class="image_height" itemprop="height" content="'. floor(720 / ($media["width"] / $media["height"])) .'"></span>';
		else:
			$_ .= '		<span class="image_url" itemprop="url" content="'. SITE_URL .'/img/logo-large.png"></span>';
			$_ .= '		<span class="image_width" itemprop="width" content="720"></span>';
			$_ .= '		<span class="image_height" itemprop="height" content="405"></span>';
		endif;

		$_ .= '	</li>';

		if(isset($item["location"]) && $item["location"] && $item["latitude"] && $item["longitude"]):
			$_ .= '	<li class="place" itemprop="contentLocation" itemscope itemtype="http://schema.org/Place">';
			$_ .= '		<ul class="geo" itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">';
			$_ .= '			<li class="name" itemprop="name">'.$item["location"].'</li>';
			$_ .= '			<li class="latitude" itemprop="latitude" content="'.round($item["latitude"], 5).'"></li>';
			$_ .= '			<li class="longitude" itemprop="longitude" content="'.round($item["longitude"], 5).'"></li>';
			$_ .= '		</ul>';
			$_ .= '	</li>';
		endif;

		$_ .= '</ul>';

		return $_;

	}


	// $context should be array of allowed contexts
	// - if $context is false, no tags are shown (except editing and default tag)
	// $default should be array with url and text
	// $url should be url to prefix tag links
	// $editing defines if editing link is shown
	function articleTags($item, $_options = false) {

		$context = false;
		$default = false;
		$url = false;
		$editing = true;
		$schema = "articleSection";


		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {
					case "context"           : $context             = $_value; break;
					case "default"           : $default             = $_value; break;

					case "url"               : $url                 = $_value; break;
					
					case "editing"           : $editing             = $_value; break;
					case "schema"            : $schema              = $_value; break;

				}
			}
		}



		$_ = '';


		// editing tag
		if($item["tags"] && $editing):
			$editing_tag = arrayKeyValue($item["tags"], "context", "editing");
			if($editing_tag !== false):
				$_ .= '<li class="editing" title="This post is work in progress">'.($item["tags"][$editing_tag]["value"] == "true" ? "Still editing" : $item["tags"][$editing_tag]["value"]).'</li>';
			endif;
		endif;

		// default tag
		if(is_array($default)):
			$_ .= '<li><a href="'.$default[0].'">'.$default[1].'</a></li>';
		endif;

		// item tag list
		if($item["tags"] && $context):
			foreach($item["tags"] as $item_tag):
				if(array_search($item_tag["context"], $context) !== false):
					$_ .= '<li'.($schema ? ' itemprop="'.$schema.'"' : '').'>';
					if($url):
						$_ .= '<a href="'.$url."/".urlencode($item_tag["value"]).'">';
					endif;
					$_ .= $item_tag["value"];
					if($url):
						$_ .= '</a>';
					endif;
					$_ .= '</li>';
				endif;
			endforeach;
		endif;


		// only print tags ul if it has content
		if($_) {
			$_ = '<ul class="tags">'.$_.'</ul>';
		}


		return $_;
	}


	// Create pagination element
	function pagination($pagination_items, $_options = false) {


		// Make links for page or sindex
		$type = "page";


		// Default both directions
		$direction = false;

		// Default show total
		$show_total = true;

		// Default base url
		$base_url = $this->path;

		// Default class
		$class = "pagination";

		$labels = [
			"next" => "Next", 
			"prev" => "Previous", 
			"total" => "Page {current_page} of {page_count} pages"
		];

		// overwrite defaults
		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {

					case "type"              : $type               = $_value; break;

					case "direction"         : $direction          = $_value; break;

					case "show_total"        : $show_total         = $_value; break;

					case "base_url"          : $base_url           = $_value; break;

					case "class"             : $class              = $_value; break;

					case "labels"            : $labels             = $_value; break;

				}
			}
		}


		$_ = '';

		// No pagination unless matching elements
		if(($pagination_items["next"] && ($direction === "next" || !$direction)) || ($pagination_items["prev"] && ($direction === "prev" || !$direction))) {

			$_ .= '<div class="'.$class.'">'."\n";
			$_ .= "\t".'<ul>'."\n";


			if(($direction === "prev" || !$direction) && $pagination_items["prev"]) {

				$labels["prev"] = preg_replace("/\{name\}/", $pagination_items["prev"]["name"], $labels["prev"]);

				if($pagination_items["prev"]) {
					if($type == "page" && $pagination_items["current_page"] > 0) {
						$_ .= "\t\t".'<li class="previous"><a href="'.$base_url.'/page/'.($pagination_items["current_page"]-1).'">'.$labels["prev"].'</a></li>'."\n";
					}
					else {
						$_ .= "\t\t".'<li class="previous"><a href="'.$base_url.'/'.$pagination_items["prev"]["sindex"].'">'.$labels["prev"].'</a></li>'."\n";
					}
				}
				else {
					$_ .= "\t\t".'<li class="previous"><a class="disabled">'.$labels["prev"].'</a></li>'."\n";
				}
			}


			if($show_total) {

				$labels["total"] = preg_replace("/\{current_page\}/", $pagination_items["current_page"], $labels["total"]);
				$labels["total"] = preg_replace("/\{page_count\}/", $pagination_items["page_count"], $labels["total"]);

				$_ .= "\t\t".'<li class="pages">'.$labels["total"].'</li>'."\n";
			}


			if(($direction === "next" || !$direction) && $pagination_items["next"]) {

				// print_r($pagination_items);
				$labels["next"] = preg_replace("/\{name\}/", $pagination_items["next"]["name"], $labels["next"]);

				if($pagination_items["next"]) {
					// Page based
					if($type == "page" && $pagination_items["current_page"] < $pagination_items["page_count"]) {
						$_ .= "\t\t".'<li class="next"><a href="'.$base_url.'/page/'.($pagination_items["current_page"]+1).'">'.$labels["next"].'</a></li>'."\n";
					}
					// Sindex based
					else {
						$_ .= "\t\t".'<li class="next"><a href="'.$base_url.'/'.$pagination_items["next"]["sindex"].'">'.$labels["next"].'</a></li>'."\n";
					}
				}
				else {
					$_ .= "\t\t".'<li class="next"><a class="disabled">'.$labels["next"].'</a></li>'."\n";
				}
			}


			$_ .= "\t".'</ul>'."\n";
			$_ .= '</div>'."\n";

		}

		return $_;
	}

}

// create standalone instance to make HTML available without model
$HTML = new HTML();

?>