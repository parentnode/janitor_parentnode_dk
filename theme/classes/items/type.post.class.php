<?php
/**
* @package janitor.itemtypes
* This file contains itemtype functionality
*/

class TypePost extends Itemtype {


	public $db;


	/**
	* Init, set varnames, validation rules
	*/
	function __construct() {

		// construct ItemType before adding to model
		parent::__construct(get_class());


		// itemtype database
		$this->db = SITE_DB.".item_post";


		// Published
		$this->addToModel("published_at", array(
			"type" => "datetime",
			"label" => "Publish date (yyyy-mm-dd hh:mm)",
			"hint_message" => "Publication date and time of post. This will be shown on website. Leave empty for current time.",
			"error_message" => "Datetime must be of format (yyyy-mm-dd hh:mm)."
		));

		// Name
		$this->addToModel("name", array(
			"type" => "string",
			"label" => "Title",
			"searchable" => true,
			"required" => true,
			"hint_message" => "Title of your post.", 
			"error_message" => "Title must be filled out."
		));

		// Description
		$this->addToModel("description", array(
			"type" => "text",
			"label" => "Short SEO description",
			"max" => 155,
			"hint_message" => "Write a short description of the post for SEO and listings.",
			"error_message" => "Your post needs a description – max 155 characters."
		));

		// HTML
		$this->addToModel("html", array(
			"type" => "html",
			"label" => "Full post text",
			"searchable" => true,
			"allowed_tags" => "p,h2,h3,h4,ul,ol,code,download,jpg,png,button",
			"hint_message" => "Write your post content.",
			"error_message" => "No words? How weird."
		));

		// Class
		$this->addToModel("classname", [
			"type" => "string",
			"label" => "CSS Class",
			"pattern" => "[a-z]+[a-z\-\:]*",
			"hint_message" => "CSS class for custom styling. If you don't know what this is, just leave it empty. Must be a valid, implemented css-classname to have any effect.",
			"error_message" => "Invalid CSS class syntax",
		]);

		// Single media
		$this->addToModel("single_media", array(
			"type" => "files",
			"label" => "Add media here",
			"allowed_sizes" => "960x540",
			"max" => 1,
			"allowed_formats" => "png,jpg",
			"hint_message" => "Add single image by dragging it here. PNG or JPG allowed in 960x540.",
			"error_message" => "Media does not fit requirements."
		));

	}

}

?>