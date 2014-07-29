u.bug_console_only = true;

Util.Objects["page"] = new function() {
	this.init = function(page) {

		// header reference
		page.hN = u.qs("#header");
		page.hN.service = u.qs(".servicenavigation", page.hN);

		// add logo to navigation
		page.logo = u.ie(page.hN, "a", {"class":"logo", "html":"Modulator"});
		u.ce(page.logo);
		page.logo.clicked = function(event) {
			location.href = '/';
		}

		// content reference
		page.cN = u.qs("#content", page);

		// navigation reference
		page.nN = u.qs("#navigation", page);
		page.nN.list = u.qs("ul", page.nN);
		page.nN = u.ie(page.hN, page.nN);

		// footer reference
		page.fN = u.qs("#footer");
		// move li to #header .servicenavigation
		page.fN.service = u.qs(".servicenavigation", page.fN);

		page.fN.slogan = u.qs("p", page.fN);
		u.ce(page.fN.slogan);
		page.fN.slogan.clicked = function(event) {
			window.open("http://parentnode.dk");
		}


		// Page is ready - called from several places, evaluates when page is ready to be shown
		page.ready = function() {
//				u.bug("page ready")

			// page is ready to be shown - only initalize if not already shown
			if(!u.hc(this, "ready")) {

				// page is ready
				u.addClass(this, "ready");

				// show terms notification
				if(!u.getCookie("terms_v1")) {
					var terms = u.ie(document.body, "div", {"class":"terms_notification"});
					u.ae(terms, "h3", {"html":"We love <br />cookies and privacy"});
					var bn_accept = u.ae(terms, "a", {"class":"accept", "html":"Accept"});
					bn_accept.terms = terms;
					u.ce(bn_accept);
					bn_accept.clicked = function() {
						this.terms.parentNode.removeChild(this.terms);
						u.saveCookie("terms_v1", true, {"expiry":new Date(new Date().getTime()+(1000*60*60*24*365)).toGMTString()});
					}

					if(!location.href.match(/\/terms/)) {
						var bn_details = u.ae(terms, "a", {"class":"details", "html":"Details"});
						u.ce(bn_details, {"type":"link"});
						bn_details.clicked = function() {
							location.href = "/terms";
						}
					}
				}
			}
		}

		// ready to start page builing process
		page.ready();

	}
}

window.onload = u.init;

