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