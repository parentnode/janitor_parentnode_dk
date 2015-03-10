
/*seg_tv_include.js*/

/*seg_tv_include.js*/

/*seg_desktop_tv.js*/


/*u-settings.js*/
u.site_name = "Janitor";

/*ga.js*/
u.ga_account = 'UA-49739795-1';
u.ga_domain = 'janitor.parentnode.dk';


/*u-googleanalytics.js*/
if(u.ga_account) {
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', u.ga_account, u.ga_domain);
    ga('send', 'pageview');
	u.stats = new function() {
		this.pageView = function(url) {
			ga('send', 'pageview', url);
		}
		this.event = function(node, action, label) {
			ga('_trackEvent', location.href.replace(document.location.protocol + "//" + document.domain, ""), action, (label ? label : this.nodeSnippet(node)));
		}
		this.customVar = function(slot, name, value, scope) {
			//       slot,		
			//       name,		
			//       value,	
			//       scope		
		}
		this.nodeSnippet = function(e) {
			if(e.textContent != undefined) {
				return u.cutString(e.textContent.trim(), 20) + "(<"+e.nodeName+">)";
			}
			else {
				return u.cutString(e.innerText.trim(), 20) + "(<"+e.nodeName+">)";
			}
		}
	}
}


/*u-form-geolocation-desktop_light.js*/
Util.Form.customInit["location"] = function(form, field) {
	field._inputs = u.qsa("input", field);
	field._input = field._inputs[0];
	for(j = 0; input = field._inputs[j]; j++) {
		input.field = field;
		form.fields[input.name] = input;
		input._label = u.qs("label[for="+input.id+"]", field);
		input.val = u.f._value;
		u.e.addEvent(input, "keyup", u.f._updated);
		u.e.addEvent(input, "change", u.f._changed);
		u.f.inputOnEnter(input);
		u.f.activateInput(input);
	}
	u.f.validate(field._input);
}
Util.Form.customValidate["location"] = function(iN) {
	var loc_fields = 0;
	if(iN.field._input) {
		loc_fields++;
		min = 1;
		max = 255;
		if(
			iN.field._input.val().length >= min &&
			iN.field._input.val().length <= max
		) {
			u.f.fieldCorrect(iN.field._input);
		}
		else {
			u.f.fieldError(iN.field._input);
		}
	}
	if(iN.field.lat_input) {
		loc_fields++;
		min = -90;
		max = 90;
		if(
			!isNaN(iN.field.lat_input.val()) && 
			iN.field.lat_input.val() >= min && 
			iN.field.lat_input.val() <= max
		) {
			u.f.fieldCorrect(iN.field.lat_input);
		}
		else {
			u.f.fieldError(iN.field.lat_input);
		}
	}
	if(iN.field.lon_input) {
		loc_fields++;
		min = -180;
		max = 180;
		if(
			!isNaN(iN.field.lon_input.val()) && 
			iN.field.lon_input.val() >= min && 
			iN.field.lon_input.val() <= max
		) {
			u.f.fieldCorrect(iN.field.lon_input);
		}
		else {
			u.f.fieldError(iN.field.lon_input);
		}
	}
	if(u.qsa("input.error", iN.field).length) {
		u.rc(iN.field, "correct");
		u.ac(iN.field, "error");
	}
	else if(u.qsa("input.correct", iN.field).length == loc_fields) {
		u.ac(iN.field, "correct");
		u.rc(iN.field, "error");
	}
}


/*u-form-htmleditor-desktop_light.js*/
Util.Form.customInit["html"] = function(form, field) {
	field._input = u.qs("textarea", field);
	field._input.field = field;
	form.fields[field._input.name] = field._input;
	field._input._label = u.qs("label[for="+field._input.id+"]", field);
	field._input.val = u.f._value;
	u.e.addEvent(field._input, "keyup", u.f._updated);
	u.e.addEvent(field._input, "change", u.f._changed);
	u.f.inputOnEnter(field._input);
	u.f.activateInput(field._input);
	u.f.validate(field._input);
}
Util.Form.customValidate["html"] = function(iN) {
	min = Number(u.cv(iN.field, "min"));
	max = Number(u.cv(iN.field, "max"));
	min = min ? min : 1;
	max = max ? max : 10000000;
	pattern = iN.getAttribute("pattern");
	if(
		u.text(iN.field._viewer) &&
		u.text(iN.field._viewer).length >= min && 
		u.text(iN.field._viewer).length <= max && 
		(!pattern || iN.val().match("^"+pattern+"$"))
	) {
		u.f.fieldCorrect(iN);
	}
	else {
		u.f.fieldError(iN);
	}
}


/*i-page-desktop_light.js*/
u.bug_console_only = true;
Util.Objects["page"] = new function() {
	this.init = function(page) {
		page.hN = u.qs("#header");
		page.hN.service = u.qs(".servicenavigation", page.hN);
		page.logo = u.ie(page.hN, "a", {"class":"logo", "html":u.eitherOr(u.site_name, "Frontpage")});
		u.ce(page.logo);
		page.logo.clicked = function(event) {
			location.href = '/';
		}
		page.cN = u.qs("#content", page);
		page.nN = u.qs("#navigation", page);
		page.nN.list = u.qs("ul", page.nN);
		page.nN = u.ie(page.hN, page.nN);
		page.fN = u.qs("#footer");
		page.fN.service = u.qs(".servicenavigation", page.fN);
		page.fN.slogan = u.qs("p", page.fN);
		u.ce(page.fN.slogan);
		page.fN.slogan.clicked = function(event) {
			window.open("http://parentnode.dk");
		}
		page.ready = function() {
			if(!u.hc(this, "ready")) {
				u.ac(this, "ready");
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
						var bn_details = u.ae(terms, "a", {"class":"details", "html":"Details", "href":"/terms"});
						u.ce(bn_details, {"type":"link"});
					}
				}
			}
		}
		page.ready();
	}
}
window.onload = u.init;


/*i-login-desktop_light.js*/
Util.Objects["login"] = new function() {
	this.init = function(scene) {
		scene.resized = function() {
		}
		scene.scrolled = function() {
		}
		scene.ready = function() {
			this._form = u.qs("form", this);
			u.f.init(this._form);
			page.cN.scene = this;
		}
		scene.ready();
	}
}


/*i-signup-desktop_light.js*/
Util.Objects["signup"] = new function() {
	this.init = function(scene) {
		scene.resized = function() {
		}
		scene.scrolled = function() {
		}
		scene.ready = function() {
			this._form = u.qs("form", this);
			u.f.init(this._form);
			page.cN.scene = this;
		}
		scene.ready();
	}
}


/*i-newsletter-desktop_light.js*/
Util.Objects["newsletter"] = new function() {
	this.init = function(scene) {
		scene.resized = function() {
		}
		scene.scrolled = function() {
		}
		scene.ready = function() {
			this._form = u.qs("form", this);
			u.f.init(this._form);
			page.cN.scene = this;
		}
		scene.ready();
	}
}



/*i-documentation-desktop_light.js*/
Util.Objects["docpage"] = new function() {
	this.init = function(scene) {
		var i, func;
		var header, body;
		var sections = u.qsa(".section", scene);
		var functions = u.qsa(".function", scene);
		for(i = 0; func = functions[i]; i++) {
			func._header = u.qs(".header", func);
			func._header._func = func;
			func._body = u.qs(".body", func);
			u.as(func._body, "display", "none");
			func._body._func = func;
			u.e.click(func._header);
			func._header.clicked = function(event) {
				if(u.hc(this._func, "open")) {
					u.deleteNodeCookie(this._func, "state");
					u.as(this._func._body, "display", "none");
					u.rc(this._func, "open");
				}
				else {
					u.saveNodeCookie(this._func, "state", "open");
					u.as(this._func._body, "display", "block");
					u.ac(this._func, "open");
				}
			}
			if(u.getNodeCookie(func, "state") == "open") {
				func._header.clicked();
			}
		}
		if(location.hash) {
			var selected_function = u.ge(location.hash.replace("#", ""))
			if(selected_function) {
				if(!u.hc(selected_function, "open")) {
					selected_function._header.clicked();
				}
				window.scrollTo(0, u.absY(selected_function));
			}
		}
		scene._files = u.qs("div.includefiles", scene);
		if(scene._files) {
			scene._files._header = u.qs("div.header", scene._files);
			scene._files._header._files = scene._files;
			scene._files._body = u.qs("div.body", scene._files);
			u.as(scene._files._body, "display", "none");
			scene._files._body._files = scene._files;
			u.e.click(scene._files._header);
			scene._files._header.clicked = function(event) {
				if(u.hc(this._files, "open")) {
				u.as(this._files._body, "display", "none");
					u.rc(this._files, "open");
				}
				else {
					u.as(this._files._body, "display", "block");
					u.ac(this._files, "open");
				}
			}
		}
		scene._segments = u.qs("div.segmentsupport", scene);
		if(scene._segments) {
			scene._segments._header = u.qs("div.header", scene._segments);
			scene._segments._header._segments = scene._segments;
			scene._segments._body = u.qs("div.body", scene._segments);
			u.as(scene._segments._body, "display", "none");
			scene._segments._body._segments = scene._segments;
			u.e.click(scene._segments._header);
			scene._segments._header.clicked = function(event) {
				if(u.hc(this._segments, "open")) {
				u.as(this._segments._body, "display", "none");
					u.rc(this._segments, "open");
				}
				else {
					u.as(this._segments._body, "display", "block");
					u.ac(this._segments, "open");
				}
			}
		}
	}
}
