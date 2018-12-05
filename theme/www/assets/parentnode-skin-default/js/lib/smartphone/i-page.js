// can be removed after updating to next version of Manipulator
u.bug_console_only = true;

Util.Objects["page"] = new function() {
	this.init = function(page) {

		window.page = page;

		// show parentnode comment in console
		u.bug_force = true;
		u.bug("This site is built using the combined powers of body, mind and spirit. Well, and also Manipulator, Janitor and Detector");
		u.bug("Visit https://parentnode.dk for more information");
//		u.bug("Free lunch for new contributers ;-)");
		u.bug_force = false;


		// header reference
		page.hN = u.qs("#header");
		page.hN.service = u.qs(".servicenavigation", page.hN);
		u.e.drag(page.hN, page.hN);


		// add logo to navigation
		page.logo = u.ie(page.hN, "a", {"class":"logo", "html":u.eitherOr(u.site_name, "Frontpage")});
		page.logo.url = '/';


		// content reference
		page.cN = u.qs("#content", page);


		// navigation reference
		page.nN = u.qs("#navigation", page);
		page.nN = u.ie(page.hN, page.nN);


		// footer reference
		page.fN = u.qs("#footer");
		page.fN.service = u.qs(".servicenavigation", page.fN);


		// global resize handler
		page.resized = function() {
//			u.bug("page resized");

			this.browser_h = u.browserH();
			this.browser_w = u.browserW();

			// adjust content height
			this.available_height = this.browser_h - this.hN.offsetHeight - this.fN.offsetHeight;
			u.as(this.cN, "min-height", "auto", false);
			if(this.available_height >= this.cN.offsetHeight) {
				u.as(this.cN, "min-height", this.available_height+"px", false);
			}

			// forward resize event to current scene
			if(this.cN && this.cN.scene && typeof(this.cN.scene.resized) == "function") {
				this.cN.scene.resized();
			}

			this.offsetHeight;
		}

		// iOS scroll fix
		page.fixiOSScroll = function() {

			u.ass(this.hN, {
				"position":"absolute",
			});


			u.ass(this.hN, {
				"position":"fixed",
			});

		}

		// global scroll handler
		page.scrolled = function() {

			// Fix issue with fixed element after scroll
			u.t.resetTimer(this.t_fix);
			this.t_fix = u.t.setTimer(this, "fixiOSScroll", 200);


			this.scrolled_y = u.scrollY();

			// forward scroll event to current scene
			if(this.cN && this.cN.scene && typeof(this.cN.scene.scrolled) == "function") {
				this.cN.scene.scrolled();
			}

		}

		// global orientationchange handler
		page.orientationchanged = function() {

			// resize navigation if it is open
			if(u.hc(page.bn_nav, "open")) {
				u.as(page.hN, "height", window.innerHeight + "px");
			}

			// forward scroll event to current scene
			if(page.cN && page.cN.scene && typeof(page.cN.scene.orientationchanged) == "function") {
				page.cN.scene.orientationchanged();
			}
		}



		// Page is ready - called from several places, evaluates when page is ready to be shown
		page.ready = function() {
//			u.bug("page ready");

			// page is ready to be shown - only initalize if not already shown
			if(!this.is_ready) {

				// page is ready
				this.is_ready = true;

				// set resize handler
				u.e.addWindowEvent(this, "resize", this.resized);
				// set scroll handler
				u.e.addWindowEvent(this, "scroll", this.scrolled);
				// set orientation change handler
				u.e.addWindowEvent(this, "orientationchange", this.orientationchanged);


				if(typeof(u.notifier) == "function") {
					u.notifier(this);
				}
				if(u.getCookie("smartphoneSwitch") == "on") {
					console.log("Back to desktop")
					var bn_switch = u.ae(document.body, "div", {id:"desktop_switch", html:"Back to desktop"});
					u.ce(bn_switch);
					bn_switch.clicked = function() {
						u.saveCookie("smartphoneSwitch", "off");
						location.href = location.href.replace(/[&]segment\=smartphone|segment\=smartphone[&]?/, "") + (location.href.match(/\?/) ? "&" : "?") + "segment=desktop";
					}
				}


				this.initNavigation();

				this.resized();

			}
		}

		// show accept cookies dialogue
		page.acceptCookies = function() {

			// show terms notification
			if(u.terms_version && !u.getCookie(u.terms_version)) {

				var terms_link = u.qs("li.terms a");

				// if terms link has been made clickable, the hraf is stored in parentNode.url
				if(terms_link && (terms_link.href || terms_link.parentNode.url)) {

					var terms_url = terms_link.href || terms_link.parentNode.url;
					var terms = u.ie(page.cN, "div", {"class":"terms_notification"});
					u.ae(terms, "h3", {"html":u.stringOr(u.txt["terms-headline"], "We love <br />cookies and privacy")});
					var bn_accept = u.ae(terms, "a", {"class":"accept", "html":u.stringOr(u.txt["terms-accept"], "Accept")});
					bn_accept.terms = terms;
					u.ce(bn_accept);
					bn_accept.clicked = function() {
						this.terms.parentNode.removeChild(this.terms);
	//					u.saveCookie(u.terms_version, true, {"expiry":new Date(new Date().getTime()+(1000*60*60*24*365)).toGMTString()});
						u.saveCookie(u.terms_version, true, {"path":"/", "expires":false});
					}

					if(!location.href.match(terms_url)) {
						var bn_details = u.ae(terms, "a", {"class":"details", "html":u.stringOr(u.txt["terms-details"], "Details"), "href":terms_url});
						u.ce(bn_details, {"type":"link"});
					}

					// show terms/cookie approval
					u.a.transition(terms, "all 0.5s ease-in");
					u.ass(terms, {
						"opacity": 1
					});

				}

			}

		}

		// initialize navigation elements
		page.initNavigation = function() {


			this.nN.list = u.qs("ul.navigation", this.nN);


			// create burger menu
			this.bn_nav = u.qs(".servicenavigation li.navigation", this.hN);
			if(this.bn_nav) {
				u.ae(this.bn_nav, "div");
				u.ae(this.bn_nav, "div");
				u.ae(this.bn_nav, "div");

				// enable nav link
				u.ce(this.bn_nav);
				this.bn_nav.clicked = function(event) {

					// close navigation
					if(u.hc(this, "open")) {
						u.rc(this, "open");

						var i, node;
						// set hide animation for nav nodes
						for(i = 0; node = page.nN.nodes[i]; i++) {

							u.a.transition(node, "all 0.2s ease-in "+(i*100)+"ms");
							u.ass(node, {
								"opacity": 0,
								"transform":"translate(0, -30px)"
							});
						}

						// hide navigation when hidden
						page.hN.transitioned = function() {
							u.ass(page.nN, {
								"display": "none"
							});
						}

						// collapse header
						u.a.transition(page.hN, "all 0.3s ease-in "+(page.nN.nodes.length*100)+"ms");
						u.ass(page.hN, {
							"height": "60px"
						});

					}
					// open navigation
					else {
						u.ac(this, "open");

						var i, node;
						// set initial animation state for nav nodes
						for(i = 0; node = page.nN.nodes[i]; i++) {
							u.ass(node, {
								"opacity": 0,
								"transform":"translate(0, 30px)"
							});
						}

						// set animation for header
						u.a.transition(page.hN, "all 0.3s ease-in");
						u.ass(page.hN, {
							"height": window.innerHeight+"px",
						});
						u.ass(page.nN, {
							"display": "block"
						});

						// set animation for nav nodes
						for(i = 0; node = page.nN.nodes[i]; i++) {

							u.a.transition(node, "all 0.3s ease-in "+(100 + (i*100))+"ms");
							u.ass(node, {
								"opacity": 1,
								"transform":"translate(0, 0)"
							});
						}
					}

					// update drag coordinates
					page.nN.start_drag_y = (window.innerHeight - 100) - page.nN.offsetHeight;
					page.nN.end_drag_y = page.nN.offsetHeight;

				}
				// enable dragging on navigation
				u.e.drag(this.nN, [0, (window.innerHeight - 100) - this.nN.offsetHeight, this.hN.offsetWidth, this.nN.offsetHeight], {"strict":false, "elastica":200, "vertical_lock":true});
			}


			// append footer servicenavigation to header servicenavigation
			if(page.fN.service) {
				nodes = u.qsa("li", page.fN.service);
				for(i = 0; node = nodes[i]; i++) {
					u.ae(page.nN.list, node);
				}
				page.fN.removeChild(page.fN.service);
			}

			// append header servicenavigation to header servicenavigation
			if(page.hN.service) {
				nodes = u.qsa("li:not(.navigation)", page.hN.service);
				for(i = 0; node = nodes[i]; i++) {
					u.ae(page.nN.list, node);
				}
			}

			var i, node, nodes;
			// enable animation on submenus and logo
			nodes = u.qsa("#navigation li,a.logo", page.hN);
			for(i = 0; node = nodes[i]; i++) {

				// build first living proof model of CEL clickableElementLink
				u.ce(node, {"type":"link"});

				// add over and out animation
				u.e.hover(node);
				node.over = function() {

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
				node.out = function() {

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

			}

			// get clean set of navigation nodes (for animation on open and close)
			page.nN.nodes = u.qsa("li", page.nN.list);

			if(page.hN.service) {
				u.ass(page.hN.service, {
					"opacity":1
				});
			}
		}


		// ready to start page builing process
		page.ready();

	}
}

u.e.addDOMReadyEvent(u.init);
