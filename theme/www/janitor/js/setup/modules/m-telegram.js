Util.Modules["telegram"] = new function() {
	this.init = function(div) {

		var form = u.qs("form", div);
		u.f.init(form);

		form.submitted = function() {

			this.response = function(response) {
				page.notify(response);

			}
			u.request(this, this.action, {"method":"post", "data":this.getData()});
			
		}

	}
}
