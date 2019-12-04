Util.Objects["wishes"] = new function() {
	this.init = function(scene) {
		// u.bug("scene init:", scene);

		scene.resized = function() {
			// u.bug("scene.resized:", this);
		}

		scene.scrolled = function() {
			// u.bug("scene.scrolled:", this);
		}

		scene.ready = function() {
			// u.bug("scene.ready:", this);

			this.ul_wishes = u.qs("ul.wishes", this);

			// does this list have images
			this.has_images = u.hc(this.ul_wishes, "images");
			this.confirm_reserve_text = this.ul_wishes.getAttribute("data-confirm-reserve") || "Save";


			this.nodes = u.qsa("li.item", this);
			if(this.nodes.length) {

				var i, node;
				for(i = 0; node = this.nodes[i]; i++) {

					node.scene = this;

					if(this.has_images) {

						node.item_id = u.cv(node, "id");
						node.image_format = u.cv(node, "format");
						node.image_variant = u.cv(node, "variant");

						// restructure content
						node.image_mask = u.ae(node, "div", {"class":"image"});
						node.text_mask = u.ae(node, "div", {"class":"text"});

//						u.as(node.text_mask, "width", text_width+"px", false);
						if(node.image_format) {
							u.ae(node.image_mask, "img", {"src":"/images/"+node.item_id+"/"+node.image_variant+"/"+this.image_width+"x."+node.image_format});
						}

						node._header = u.qs("h3", node);
						if(node._header) {
							u.ae(node.text_mask, node._header);
						}
						node._info = u.qs("dl.info", node);
						if(node._info) {
							u.ae(node.text_mask, node._info);
						}

						node._description = u.qs("div.description", node);
						if(node._description) {
							u.ae(node.text_mask, node._description);
						}

						node._actions = u.qs("ul.actions", node);
						if(node._actions) {
							u.ae(node.text_mask, node._actions);
						}

					}


					// initialize forms
					node.reserve_form = u.qs("li.reserve form", node);
					if(node.reserve_form) {
						node.reserve_form.node = node;

						u.f.init(node.reserve_form);

						node.reserve_form.submitted = function() {

							if(this.is_active) {

								this.response = function(response) {
									page.notify(response);

									if(response.cms_status == "success") {
										location.reload(true);
									}
								}
								u.request(this, this.action, {"method":this.method, "data":this.getData()});

							}
							else {

								this.actions["reserve"].value = this.node.scene.confirm_reserve_text;

								u.ass(this.inputs["reserved"].field, {
									"display":"block"
								});

								this.is_active = true;

							}

						}
					}


					node.li_unreserve = u.qs("li.unreserve", node);
					node.form_unreserve = u.qs("li.unreserve form", node);
					if(node.li_unreserve && node.form_unreserve) {

						node.li_unreserve.confirmed = function() {

							this.response = function(response) {
								page.notify(response);

								if(response.cms_status == "success") {
									location.reload(true);
								}
							}
							u.request(this, this.form.action, {"method":this.form.method, "data":this.getData()});
						}
					}

				}
			}

			u.showScene(this);

		}

		// Map scene – page will call scene.ready
		page.cN.scene = scene;

	}
}
