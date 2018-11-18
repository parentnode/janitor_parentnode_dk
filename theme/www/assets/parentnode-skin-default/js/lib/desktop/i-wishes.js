Util.Objects["wishes"] = new function() {
	this.init = function(scene) {
//		u.bug("scene init:" + u.nodeId(scene))


		scene.image_width = 250;


		scene.resized = function() {
//			u.bug("scene.resized:" + u.nodeId(this));


			// resize text nodes
			if(this.nodes.length && this.has_images) {
				var text_width = this.nodes[0].offsetWidth - this.image_width;
				for(i = 0; node = this.nodes[i]; i++) {
					u.as(node.text_mask, "width", text_width+"px", false);
				}
			}

			// refresh dom
			this.offsetHeight;
		}

		scene.scrolled = function() {
//			u.bug("scrolled")
		}

		scene.ready = function() {
//			u.bug("scene.ready:" + u.nodeId(this));

			page.cN.scene = this;

			this.ul_wishes = u.qs("ul.wishes", this);

			// does this list have images
			this.has_images = u.hc(this.ul_wishes, "images");
			this.confirm_reserve_text = this.ul_wishes.getAttribute("data-confirm-reserve") || "Save";


			this.nodes = u.qsa("li.item", this);
			if(this.nodes.length) {

				var text_width = this.nodes[0].offsetWidth - this.image_width;
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

						u.as(node.text_mask, "width", text_width+"px", false);
						if(node.image_format) {
							u.as(node.image_mask, "backgroundImage", "url(/images/"+node.item_id+"/"+node.image_variant+"/"+this.image_width+"x."+node.image_format+")");
						}
						// or fallback image
						else {
							u.as(node.image_mask, "backgroundImage", "url(/images/0/missing/"+this.image_width+"x.png)");
						}

						node._header = u.qs("h3", node);
						if(node._header) {
							u.ae(node.text_mask, node._header);
						}
						node._info = u.qs("dl.info", node);
						if(node._info) {
							u.ae(node.text_mask, node._info);
						}

						node._actions = u.qs("ul.actions", node);
						if(node._actions) {
							u.ae(node.text_mask, node._actions);
						}

						node._description = u.qs("div.description", node);
						if(node._description) {
							u.ae(node.text_mask, node._description);
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
								u.request(this, this.action, {"method":this.method, "params":u.f.getParams(this)});

							}
							else {

								this.actions["reserve"].value = this.node.scene.confirm_reserve_text;

								u.ass(this.fields["reserved"], {
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
							u.request(this, this.form.action, {"method":this.form.method, "params":u.f.getParams(this.form)});
						}
					}

				}
			}

			page.resized();
		}

		// scene is ready
		scene.ready();
	}
}
