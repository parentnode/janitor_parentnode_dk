
// generic 
Util.Modules["generic"] = new function() {
	this.init = function(div) {



	}
}

Util.Modules["timeentries"] = new function() {
	this.init = function(div) {
		u.bug("timeentries", div, div.list);


		div.total_selection_min = u.qs("h5.total_selection span.minutes", div);
		div.total_selection_hours = u.qs("h5.total_selection span.hours", div);

		div.total15_selection_min = u.qs("h5.total_selection span.minutes15", div);
		div.total15_selection_hours = u.qs("h5.total_selection span.hours15", div);

		// console.log(div.total_selection_min, div.total_selection_hours, div.total15_selection_min, div.total15_selection_hours)

		div.ul_actions = u.ae(div, "ul", {class:"actions"});
		
		div.selectionUpdated = function(inputs) {
			u.bug("selectionUpdated");

			this.selected_entries = inputs;
			if(inputs.length) {

				if(!this.action_add_invoiced_tag) {
					this.action_add_invoiced_tag = u.f.addAction(this.ul_actions, {type:"button", value:"Mark as invoiced", class:"button primary", name:"add"});
					this.action_add_invoiced_tag.div = this;

					u.ce(this.action_add_invoiced_tag);
					this.action_add_invoiced_tag.clicked = function(event) {

						var csrf_token = div.getAttribute("data-csrf-token");
						var action_invoiced = div.getAttribute("data-invoiced");

						this.response = function(response) {

							if(response && response.cms_status == "success") {
								// Show notification
								page.notify({cms_message:["Tagged"], isJSON:true});

								// Remove tagged items from list
								if(this.div.selected_entries && this.div.selected_entries.length) {
									for(var i = 0; i < this.div.selected_entries.length; i++) {
										this.div.selected_entries[i].parentNode.parentNode.removeChild(this.div.selected_entries[i].parentNode);
									}
								}
								this.div.bn_all.updateState();
//								console.log(this.inputs, this.div.selected_entries);
							}
							else {
								page.notify({cms_status:"error", cms_message:{"errors":["Error"]}, isJSON:true});
							}

						}

						u.request(this, action_invoiced, {method:"post", data:"csrf-token="+csrf_token+"&entries="+this.inputs.join(",")});
					}

				}

				if(!this.action_add_written_off_tag) {
					this.action_add_written_off_tag = u.f.addAction(this.ul_actions, {type:"button", value:"Mark as written off", class:"button secondary", name:"add"});
					this.action_add_written_off_tag.div = this;

					u.ce(this.action_add_written_off_tag);
					this.action_add_written_off_tag.clicked = function(event) {

						var csrf_token = div.getAttribute("data-csrf-token");
						var action_written_off = div.getAttribute("data-written_off");

						this.response = function(response) {

							if(response && response.cms_status == "success") {

								// Show notification
								page.notify({cms_message:["Tagged"], isJSON:true});

								// Remove tagged items from list
								if(this.div.selected_entries && this.div.selected_entries.length) {
									for(var i = 0; i < this.div.selected_entries.length; i++) {
										this.div.selected_entries[i].parentNode.parentNode.removeChild(this.div.selected_entries[i].parentNode);
									}
								}
								this.div.bn_all.updateState();
							}
							else {
								page.notify({cms_status:"error", cms_message:{"errors":["Error"]}, isJSON:true});
							}

						}

						u.request(this, action_written_off, {method:"post", data:"csrf-token="+csrf_token+"&entries="+this.inputs.join(",")});
					}

				}

				// Update selected values array
				var i, node, id, min, total_min = 0, total_min15 = 0;
				this.action_add_invoiced_tag.inputs = [];
				this.action_add_written_off_tag.inputs = [];
				for(i = 0; i < inputs.length; i++) {
					node = inputs[i].node;
					id = u.cv(node, "id");
					min = Math.abs(u.qs("span.duration span.minutes", node).innerHTML);
					total_min += min;
					total_min15 += (min%15 ? 15 - min%15 : 0) + min;
					this.action_add_invoiced_tag.inputs.push(id);
					this.action_add_written_off_tag.inputs.push(id);
					
				}

				this.total_selection_min.innerHTML = total_min;
				this.total_selection_hours.innerHTML = Math.ceil(total_min/60);

				this.total15_selection_min.innerHTML = total_min15;
				this.total15_selection_hours.innerHTML = Math.ceil(total_min15/60);

				// console.log(total_min, total_min15);
			}

			// Cleanup
			else {

				if(this.action_add_invoiced_tag) {
					this.action_add_invoiced_tag.parentNode.parentNode.removeChild(this.action_add_invoiced_tag.parentNode);
				}
				delete this.action_add_invoiced_tag;

				if(this.action_add_written_off_tag) {
					this.action_add_written_off_tag.parentNode.parentNode.removeChild(this.action_add_written_off_tag.parentNode);
				}
				delete this.action_add_written_off_tag;

			}


			// console.log(inputs.length, inputs);
			
		}

		// div.filtered = function() {
		// 	u.bug("filtered")
		//
		// 	this.bn_all.updateState();
		// 	this.bn_range._to.value = "";
		// 	this.bn_range._from.value = "";
		//
		// }

	}
	
}