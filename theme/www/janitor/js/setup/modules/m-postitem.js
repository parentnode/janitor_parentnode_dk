Util.Modules["postitem"] = new function() {
	this.init = function(div) {


		// Add new controller
		var form_new = u.qs("form.new", div);
		if(form_new) {
			form_new.div = div;

			u.f.init(form_new);

			form_new.submitted = function() {

				u.ac(this, "submitting");

				this.response = function(response) {
					// u.bug("response", response);

					page.notify(response);
					u.rc(this, "submitting");

					if(response.cms_status === "success" && response.cms_object) {
						this.div.initController(u.ae(this.div.ul_controllers, "li", {"html": "<h4>"+response.cms_object+"</h4>"}));

						this.div.updateControllerDeleteState();

						this.reset();
					}

				}

				u.request(this, this.action, {
					"method": this.method,
					"data": this.getData()
				});
				
			}

		}


		// Existing controllers
		div.ul_controllers = u.qs("ul.controllers", div);

		div.csrf_token = div.ul_controllers.getAttribute("data-csrf-token");
		div.delete_url = div.ul_controllers.getAttribute("data-delete-action");
		div.confirm_value = div.ul_controllers.getAttribute("data-confirm-value");
		div.button_value = div.ul_controllers.getAttribute("data-button-value");
		div.button_name = div.ul_controllers.getAttribute("data-button-name");


		// Inject delete button
		div.initController = function(li) {

			if(!li.is_ready) {
				li.is_ready = true;
				li.div = this;

				var ul_actions = u.ae(li, "ul", {"class": "actions"});
				var li_delete = u.ae(ul_actions, "li", {
					"class": "delete",
					"data-csrf-token": this.csrf_token,
					"data-form-action": this.delete_url,
					"data-inputs": encodeURI(JSON.stringify({"controller_path": u.text(li).trim()})),
					"data-confirm-value": this.confirm_value,
					"data-button-value": this.button_value,
					"data-button-name": this.button_name,
				});
				li_delete.li = li;

				u.m.oneButtonForm.init(li_delete);

				li_delete.confirmed = function(response) {
					// u.bug("res", response);

					if(response.cms_status === "success") {
						this.li.parentNode.removeChild(this.li);

						this.li.div.updateControllerDeleteState();
					}

				}

			}

		}
		
		// Disable delete when only one controller is left
		div.updateControllerDeleteState = function() {
			if(this.ul_controllers.children.length > 1) {
				u.rc(this.ul_controllers, "no_delete");
			}
			else {
				u.ac(this.ul_controllers, "no_delete");
			}
		}


		// Find existing controllers and initialize
		var existing_controllers = u.qsa("li", div.ul_controllers);
		var i, li;
		for(i = 0; i < existing_controllers.length; i++) {
			li = existing_controllers[i];
			div.initController(li);
		}

		// Update delete state
		div.updateControllerDeleteState();
	}
}
