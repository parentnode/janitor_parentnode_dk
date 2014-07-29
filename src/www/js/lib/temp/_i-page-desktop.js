u.bug_console_only = true;

Util.Objects["page"] = new function() {
	this.init = function(page) {

		//if(u.hc(page, "i:page")) {
			//alert("wop");
			// header reference
			page.hN = u.qs("#header");
			page.hN.service = u.qs(".servicenavigation", page.hN);

			// add logo to navigation
			page.logo = u.ie(page.hN, "a", {"class":"logo", "html":"Modulator"});
			page.logo.url = '/';

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


			// global resize handler 
			page.resized = function() {

				// adjust content height
				this.calc_height = u.browserH();
				this.calc_width = u.browserW();
				this.available_height = this.calc_height - page.hN.offsetHeight - page.fN.offsetHeight;

				u.as(page.cN, "height", "auto", false);
				if(this.available_height >= page.cN.offsetHeight) {
					u.as(page.cN, "height", this.available_height+"px", false);
				}

				if(this.calc_width > 1300) {
					u.ac(page, "fixed");
				}
				else {
					u.rc(page, "fixed");
				}

				// forward resize event to current scene
				if(page.cN && page.cN.scene) {

					if(typeof(page.cN.scene.resized) == "function") {
						page.cN.scene.resized();
					}

				}

			}

			// global scroll handler 
			page.scrolled = function() {

				// forward scroll event to current scene
				if(page.cN && page.cN.scene && typeof(page.cN.scene.scrolled) == "function") {
					page.cN.scene.scrolled();
				}

			}



			// Page is ready - called from several places, evaluates when page is ready to be shown
			page.ready = function() {
//				u.bug("page ready")

				// page is ready to be shown - only initalize if not already shown
				if(!u.hc(this, "ready")) {

					// page is ready
					u.addClass(this, "ready");

					// set resize handler
					u.e.addEvent(window, "resize", page.resized);
					// set scroll handler
					u.e.addEvent(window, "scroll", page.scrolled);

					this.initNavigation();

					this.resized();

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
							bn_details.url = "/terms";
							u.ce(bn_details, {"type":"link"});
						}
					}
				}
			}


			// initialize navigation elements
			page.initNavigation = function() {

				var i, node;
				// enable submenus where relevant
				this.hN.nodes = u.qsa("#navigation li,.servicenavigation li,a.logo", page.hN);
				for(i = 0; node = this.hN.nodes[i]; i++) {

					// build first living proof model of CEL clickableElementLink
					u.ce(node, {"type":"link"});


					node._mousedover = function() {

						this.transitioned = function() {

							this.transitioned = function() {
								u.a.transition(this, "none");
							}

							u.a.transition(this, "all 0.1s ease-in-out");
							u.a.scale(this, 1.15);
						}

						u.a.transition(this, "all 0.1s ease-in-out");
						u.a.scale(this, 1.22);
					}

					node._mousedout = function() {
						this.transitioned = function() {

							this.transitioned = function() {
								u.a.transition(this, "none");
							}

							u.a.transition(this, "all 0.1s ease-in-out");
							u.a.scale(this, 1);
						}

						u.a.transition(this, "all 0.1s ease-in-out");
						u.a.scale(this, 0.9);
					}

					// enable mouseover if mouse events are available
					if(u.e.event_pref == "mouse") {

						u.e.addEvent(node, "mouseover", node._mousedover);
						u.e.addEvent(node, "mouseout", node._mousedout);
					}
					else {

						u.e.addStartEvent(node, node._mousedover);
						u.e.addEndEvent(node, node._mousedout);
					}

				}

			}


			// ready to start page builing process
			page.ready();

		//}
	}
}

u.e.addDOMReadyEvent(u.init);

