Util.Objects["docsindex"] = new function() {
	this.init = function(scene) {

		var files = u.qsa(".files li", scene);
		var i, node;

		// initialize search field
		scene.div_search = u.qs(".search", scene);
		scene.div_search.h2 = u.ae(scene.div_search, "h2", {"html":"Search utilities and tools"});

		var form = u.f.addForm(scene.div_search, {"class":"labelstyle:inject"});
		var fieldset = u.f.addFieldset(form);
		var field = u.f.addField(fieldset, {"name":"search", "label":"Search term of minimum 3 chars"})
		u.f.init(form);

		// enable search
		field._input.div_search = scene.div_search;

		// content needs to be indexed
		// inject result container
		field._input.results = u.ae(scene.div_search, "div", {"class":"results"});
		for(i = 0; node = files[i]; i++) {

			u.ce(node, {"type":"link"});

			node.results = field._input.results;
			node.response = function(response) {

				var i, _function;
				var functions = u.qsa(".functions .function", response);
				for(i = 0; _function = functions[i]; i++) {
					
					_function.file_node = this;
					_function = this.results.appendChild(_function);

					u.ce(_function, {"type":"link"});
					_function.url = this.url+"#"+_function.id;

					// searchable areas
					_function._definition = u.qs(".definition", _function);
					_function._description = u.qs(".description", _function);
					u.as(_function, "display", "none");
				}
			}

			u.request(node, node.url);
		}

		// auto complete handler
		field._input._autocomplete = function() {

			var i, _function;

			// start search
			u.ac(this.div_search, "loading");

			// perform search
			for(i = 0; _function = this.results.childNodes[i]; i++) {
				if(
					this.value.length > 2 && 
					(
						escape(u.text(_function._definition).toLowerCase()).match(escape(this.value.toLowerCase())) || 
						escape(u.text(_function._description).toLowerCase()).match(escape(this.value.toLowerCase()))
					)
				) {
					u.as(_function, "display", "block");
				}
				else {
					u.as(_function, "display", "none");
				}
			}

			// done
			u.rc(this.div_search, "loading");

		}

		field._input._keyup = function(event) {

			// reset existing timer
			u.t.resetTimer(this.t_autocomplete);
			this.t_autocomplete = u.t.setTimer(this, this._autocomplete, 300);
		}

		field._input.focused = function() {
			u.e.addEvent(this, "keyup", this._keyup)
		}

		field._input.blurred = function() {
			u.t.resetTimer(this.t_autocomplete);
			u.e.removeEvent(this, "keyup", this._keyup)
		}

	}
}


Util.Objects["docpage"] = new function() {
	this.init = function(scene) {

		var i, func;
		var header, body;

		var sections = u.qsa(".section", scene);


		// loop through functions in page
		var functions = u.qsa(".function", scene);
		for(i = 0; func = functions[i]; i++) {
			func._header = u.qs(".header", func);
			func._header._func = func;
			func._body = u.qs(".body", func);
			func._body._func = func;


			u.e.click(func._header);
			func._header.clicked = function(event) {

				if(u.hc(this._func, "open")) {

					// ignore state
					u.deleteNodeCookie(this._func, "state");
					u.as(this._func._body, "display", "none");
					u.rc(this._func, "open");
				}
				else {

					// remember state
					u.saveNodeCookie(this._func, "state", "open");
					u.as(this._func._body, "display", "block");
					u.ac(this._func, "open");
				}
			}

			// check prev state
			if(u.getNodeCookie(func, "state") == "open") {
				func._header.clicked();
			}

		}

		// is specific function stated in url
		if(location.hash) {
			var selected_function = u.ge(location.hash.replace("#", ""))
			if(selected_function) {
				if(!u.hc(selected_function, "open")) {
					selected_function._header.clicked();
				}

				window.scrollTo(0, u.absY(selected_function));
			}
		}




		// add test link to segments section
		// var segments = u.qs(".segments", scene);
		// var test = u.ae(segments, "div", {"class":"test", "html":"Test utilities"});
		// u.e.click(test);
		// test.clicked = function() {
		// 	location.href = "/tests/" + location.href.split("/").pop();
		// }

//		alert("fis")
		

	}
}