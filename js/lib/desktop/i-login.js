Util.Objects["login"] = new function() {
	this.init = function(scene) {
		u.bug("scene init:", scene);


		scene.resized = function() {
//			u.bug("scene.resized:", this);


			// refresh dom
			//this.offsetHeight;
		}

		scene.scrolled = function() {
//			u.bug("scrolled:", this);
		}

		scene.ready = function() {
//			u.bug("scene.ready:", this);

			this._form = u.qs("form", this);
			u.f.init(this._form);

			this._form.fields["username"].focus();

			page.cN.scene = this;

			u.showScene(this);
			// accept cookies?
			page.acceptCookies();

			page.resized();
		}


		// scene is ready
		scene.ready();

	}

}
