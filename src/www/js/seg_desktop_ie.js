
/*seg_desktop_ie_include.js*/

/*seg_desktop_ie_include.js*/

/*seg_desktop_ie.js*/
if(!u || !Util) {
	var u, Util = u = new function() {};
	u.version = 0.8;
	u.bug = function() {};
	u.nodeId = function() {};
	u.stats = new function() {this.pageView = function(){};this.event = function(){};this.customVar = function(){};}
}
Util.debugURL = function(url) {
	if(u.bug_force) {
		return true;
	}
	return document.domain.match(/.local$/);
}
Util.nodeId = function(node, include_path) {
		if(!include_path) {
			return node.id ? node.nodeName+"#"+node.id : (node.className ? node.nodeName+"."+node.className : (node.name ? node.nodeName + "["+node.name+"]" : node.nodeName));
		}
		else {
			if(node.parentNode && node.parentNode.nodeName != "HTML") {
				return u.nodeId(node.parentNode, include_path) + "->" + u.nodeId(node);
			}
			else {
				return u.nodeId(node);
			}
		}
	return "Unindentifiable node!";
}
Util.bug = function(message, corner, color) {
	if(u.debugURL()) {
		if(!u.bug_console_only) {
			var option, options = new Array([0, "auto", "auto", 0], [0, 0, "auto", "auto"], ["auto", 0, 0, "auto"], ["auto", "auto", 0, 0]);
			if(isNaN(corner)) {
				color = corner;
				corner = 0;
			}
			if(typeof(color) != "string") {
				color = "black";
			}
			option = options[corner];
			if(!document.getElementById("debug_id_"+corner)) {
				var d_target = u.ae(document.body, "div", {"class":"debug_"+corner, "id":"debug_id_"+corner});
				d_target.style.position = u.bug_position ? u.bug_position : "absolute";
				d_target.style.zIndex = 16000;
				d_target.style.top = option[0];
				d_target.style.right = option[1];
				d_target.style.bottom = option[2];
				d_target.style.left = option[3];
				d_target.style.backgroundColor = u.bug_bg ? u.bug_bg : "#ffffff";
				d_target.style.color = "#000000";
				d_target.style.textAlign = "left";
				if(d_target.style.maxWidth) {
					d_target.style.maxWidth = u.bug_max_width ? u.bug_max_width+"px" : "auto";
				}
				d_target.style.padding = "3px";
			}
			if(typeof(message) != "string") {
				message = message.toString();
			}
			var debug_div = document.getElementById("debug_id_"+corner);
			message = message ? message.replace(/\>/g, "&gt;").replace(/\</g, "&lt;").replace(/&lt;br&gt;/g, "<br>") : "Util.bug with no message?";
			u.ae(debug_div, "div", {"style":"color: " + color, "html": message});
		}
		if(typeof(console) == "object") {
			console.log(message);
		}
	}
}
Util.xInObject = function(object) {
	if(u.debugURL()) {
		var x, s = "--- start object ---<br>";
		for(x in object) {
			if(object[x] && typeof(object[x]) == "object" && typeof(object[x].nodeName) == "string") {
				s += x + "=" + object[x]+" -> " + u.nodeId(object[x], 1) + "<br>";
			}
			else if(object[x] && typeof(object[x]) == "function") {
				s += x + "=function<br>";
			}
			else {
				s += x + "=" + object[x]+"<br>";
			}
		}
		s += "--- end object ---"
		u.bug(s);
	}
}
Util.Animation = u.a = new function() {
	this.support3d = function() {
		if(this._support3d === undefined) {
			var node = document.createElement("div");
			try {
				var test = "translate3d(10px, 10px, 10px)";
				node.style[this.variant() + "Transform"] = test;
				if(node.style[this.variant() + "Transform"] == test) {
					this._support3d = true;
				}
				else {
					this._support3d = false;
				}
			}
			catch(exception) {
				this._support3d = false;
			}
		}
		return this._support3d;
	}
	this.variant = function() {
		if(this._variant === undefined) {
			if(document.body.style.webkitTransform != undefined) {
				this._variant = "webkit";
			}
			else if(document.body.style.MozTransform != undefined) {
				this._variant = "Moz";
			}
			else if(document.body.style.oTransform != undefined) {
				this._variant = "o";
			}
			else if(document.body.style.msTransform != undefined) {
				this._variant = "ms";
			}
			else {
				this._variant = "";
			}
		}
		return this._variant;
	}
	this.transition = function(node, transition) {
		try {		
			node.style[this.variant() + "Transition"] = transition;
			if(this.variant() == "Moz") {
				u.e.addEvent(node, "transitionend", this._transitioned);
			}
			else {
				u.e.addEvent(node, this.variant() + "TransitionEnd", this._transitioned);
			}
			var duration = transition.match(/[0-9.]+[ms]+/g);
			if(duration) {
				node.duration = duration[0].match("ms") ? parseFloat(duration[0]) : (parseFloat(duration[0]) * 1000);
			}
			else {
				node.duration = false;
				if(transition.match(/none/i)) {
					node.transitioned = null;
				}
			}
		}
		catch(exception) {
			u.bug("Exception ("+exception+") in u.a.transition(" + node + "), called from: "+arguments.callee.caller);
		}
	}
	this._transitioned = function(event) {
		if(event.target == this && typeof(this.transitioned) == "function") {
			this.transitioned(event);
		}
	}
	this.removeTransform = function(node) {
		node.style[this.variant() + "Transform"] = "none";
	}
	this.translate = function(node, x, y) {
		if(this.support3d()) {
			node.style[this.variant() + "Transform"] = "translate3d("+x+"px, "+y+"px, 0)";
		}
		else {
			node.style[this.variant() + "Transform"] = "translate("+x+"px, "+y+"px)";
		}
		node._x = x;
		node._y = y;
		node.offsetHeight;
	}
	this.rotate = function(node, deg) {
		node.style[this.variant() + "Transform"] = "rotate("+deg+"deg)";
		node._rotation = deg;
		node.offsetHeight;
	}
	this.scale = function(node, scale) {
		node.style[this.variant() + "Transform"] = "scale("+scale+")";
		node._scale = scale;
		node.offsetHeight;
	}
	this.setOpacity = function(node, opacity) {
		node.style.opacity = opacity;
		node._opacity = opacity;
		node.offsetHeight;
	}
	this.setWidth = function(node, width) {
		width = width.toString().match(/\%|auto|px/) ? width : (width + "px");
		node.style.width = width;
		node._width = width;
		node.offsetHeight;
	}
	this.setHeight = function(node, height) {
		height = height.toString().match(/\%|auto|px/) ? height : (height + "px");
		node.style.height = height;
		node._height = height;
		node.offsetHeight;
	}
	this.setBgPos = function(node, x, y) {
		x = x.toString().match(/\%|auto|px|center|top|left|bottom|right/) ? x : (x + "px");
		y = y.toString().match(/\%|auto|px|center|top|left|bottom|right/) ? y : (y + "px");
		node.style.backgroundPosition = x + " " + y;
		node._bg_x = x;
		node._bg_y = y;
		node.offsetHeight;
	}
	this.setBgColor = function(node, color) {
		node.style.backgroundColor = color;
		node._bg_color = color;
		node.offsetHeight;
	}
	this.rotateScale = function(node, deg, scale) {
		node.style[this.variant() + "Transform"] = "rotate("+deg+"deg) scale("+scale+")";
		node._rotation = deg;
		node._scale = scale;
		node.offsetHeight;
	}
	this.scaleRotateTranslate = function(node, scale, deg, x, y) {
		if(this.support3d()) {
			node.style[this.variant() + "Transform"] = "scale("+scale+") rotate("+deg+"deg) translate3d("+x+"px, "+y+"px, 0)";
		}
		else {
			node.style[this.variant() + "Transform"] = "scale("+scale+") rotate("+deg+"deg) translate("+x+"px, "+y+"px)";
		}
		node._rotation = deg;
		node._scale = scale;
		node._x = x;
		node._y = y;
		node.offsetHeight;
	}
}
Util.saveCookie = function(name, value, options) {
	expiry = false;
	path = false;
	if(typeof(options) == "object") {
		var argument;
		for(argument in options) {
			switch(argument) {
				case "expiry"	: expiry	= (typeof(options[argument]) == "string" ? options[argument] : "Mon, 04-Apr-2020 05:00:00 GMT"); break;
				case "path"		: path		= options[argument]; break;
			}
		}
	}
	document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) +";" + (path ? "path="+path+";" : "") + (expiry ? "expires="+expiry+";" : "")
}
Util.getCookie = function(name) {
	var matches;
	return (matches = document.cookie.match(encodeURIComponent(name) + "=([^;]+)")) ? decodeURIComponent(matches[1]) : false;
}
Util.deleteCookie = function(name, options) {
	path = false;
	if(typeof(options) == "object") {
		var argument;
		for(argument in options) {
			switch(argument) {
				case "path"	: path	= options[argument]; break;
			}
		}
	}
	document.cookie = encodeURIComponent(name) + "=;" + (path ? "path="+path+";" : "") + "expires=Thu, 01-Jan-70 00:00:01 GMT";
}
Util.saveNodeCookie = function(node, name, value) {
	var ref = u.cookieReference(node);
	var mem = JSON.parse(u.getCookie("man_mem"));
	if(!mem) {
		mem = {};
	}
	if(!mem[ref]) {
		mem[ref] = {};
	}
	mem[ref][name] = (value !== false && value !== undefined) ? value : "";
	u.saveCookie("man_mem", JSON.stringify(mem), {"path":"/"});
}
Util.getNodeCookie = function(node, name) {
	var ref = u.cookieReference(node);
	var mem = JSON.parse(u.getCookie("man_mem"));
	if(mem && mem[ref]) {
		if(name) {
			return mem[ref][name] ? mem[ref][name] : "";
		}
		else {
			return mem[ref];
		}
	}
	return false;
}
Util.deleteNodeCookie = function(node, name) {
	var ref = u.cookieReference(node);
	var mem = JSON.parse(u.getCookie("man_mem"));
	if(mem && mem[ref]) {
		if(name) {
			delete mem[ref][name];
		}
		else {
			delete mem[ref];
		}
	}
	u.saveCookie("man_mem", JSON.stringify(mem), {"path":"/"});
}
Util.cookieReference = function(node) {
	var ref;
	if(node.id) {
		ref = node.nodeName + "#" + node.id;
	}
	else {
		var id_node = node;
		while(!id_node.id) {
			id_node = id_node.parentNode;
		}
		if(id_node.id) {
			ref = id_node.nodeName + "#"+id_node.id + " " + (node.name ? (node.nodeName + "["+node.name+"]") : (node.className ? (node.nodeName+"."+node.className) : node.nodeName));
		}
	}
	return ref;
}
Util.date = function(format, timestamp, months) {
	var date = timestamp ? new Date(timestamp) : new Date();
	if(isNaN(date.getTime())) {
		if(!timestamp.match(/[A-Z]{3}\+[0-9]{4}/)) {
			if(timestamp.match(/ \+[0-9]{4}/)) {
				date = new Date(timestamp.replace(/ (\+[0-9]{4})/, " GMT$1"));
			}
		}
		if(isNaN(date.getTime())) {
			date = new Date();
		}
	}
	var tokens = /d|j|m|n|F|Y|G|H|i|s/g;
	var chars = new Object();
	chars.j = date.getDate();
	chars.d = (chars.j > 9 ? "" : "0") + chars.j;
	chars.n = date.getMonth()+1;
	chars.m = (chars.n > 9 ? "" : "0") + chars.n;
	chars.F = months ? months[date.getMonth()] : "";
	chars.Y = date.getFullYear();
	chars.G = date.getHours();
	chars.H = (chars.G > 9 ? "" : "0") + chars.G;
	var i = date.getMinutes();
	chars.i = (i > 9 ? "" : "0") + i;
	var s = date.getSeconds();
	chars.s = (s > 9 ? "" : "0") + s;
	return format.replace(tokens, function (_) {
		return _ in chars ? chars[_] : _.slice(1, _.length - 1);
	});
};
Util.querySelector = u.qs = function(query, scope) {
	scope = scope ? scope : document;
	return scope.querySelector(query);
}
Util.querySelectorAll = u.qsa = function(query, scope) {
	scope = scope ? scope : document;
	return scope.querySelectorAll(query);
}
Util.getElement = u.ge = function(identifier, scope) {
	var node, i, regexp;
	if(document.getElementById(identifier)) {
		return document.getElementById(identifier);
	}
	scope = scope ? scope : document;
	regexp = new RegExp("(^|\\s)" + identifier + "(\\s|$|\:)");
	for(i = 0; node = scope.getElementsByTagName("*")[i]; i++) {
		if(regexp.test(node.className)) {
			return node;
		}
	}
	return scope.getElementsByTagName(identifier).length ? scope.getElementsByTagName(identifier)[0] : false;
}
Util.getElements = u.ges = function(identifier, scope) {
	var node, i, regexp;
	var nodes = new Array();
	scope = scope ? scope : document;
	regexp = new RegExp("(^|\\s)" + identifier + "(\\s|$|\:)");
	for(i = 0; node = scope.getElementsByTagName("*")[i]; i++) {
		if(regexp.test(node.className)) {
			nodes.push(node);
		}
	}
	return nodes.length ? nodes : scope.getElementsByTagName(identifier);
}
Util.parentNode = u.pn = function(node, node_type) {
	if(node_type) {
		if(node.parentNode) {
			var parent = node.parentNode;
		}
		while(parent.nodeName.toLowerCase() != node_type.toLowerCase()) {
			if(parent.parentNode) {
				parent = parent.parentNode;
			}
			else {
				return false;
			}
		}
		return parent;
	}
	else {
		return node.parentNode;
	}
}
Util.previousSibling = u.ps = function(node, exclude) {
	node = node.previousSibling;
	while(node && (node.nodeType == 3 || node.nodeType == 8 || exclude && (u.hc(node, exclude) || node.nodeName.toLowerCase().match(exclude)))) {
		node = node.previousSibling;
	}
	return node;
}
Util.nextSibling = u.ns = function(node, exclude) {
	node = node.nextSibling;
	while(node && (node.nodeType == 3 || node.nodeType == 8 || exclude && (u.hc(node, exclude) || node.nodeName.toLowerCase().match(exclude)))) {
		node = node.nextSibling;
	}
	return node;
}
Util.childNodes = u.cn = function(node, exclude) {
	var i, child;
	var children = new Array();
	for(i = 0; child = node.childNodes[i]; i++) {
		if(child && child.nodeType != 3 && child.nodeType != 8 && (!exclude || (!u.hc(child, exclude) && !child.nodeName.toLowerCase().match(exclude) ))) {
			children.push(child);
		}
	}
	return children;
}
Util.appendElement = u.ae = function(parent, node_type, attributes) {
	try {
		var node = (typeof(node_type) == "object") ? node_type : document.createElement(node_type);
		node = parent.appendChild(node);
		if(attributes) {
			var attribute;
			for(attribute in attributes) {
				if(attribute == "html") {
					node.innerHTML = attributes[attribute];
				}
				else {
					node.setAttribute(attribute, attributes[attribute]);
				}
			}
		}
		return node;
	}
	catch(exception) {
		u.bug("Exception ("+exception+") in u.ae, called from: "+arguments.callee.caller.name);
		u.bug("node:" + u.nodeId(parent, 1));
		u.xInObject(attributes);
	}
	return false;
}
Util.insertElement = u.ie = function(parent, node_type, attributes) {
	try {
		var node = (typeof(node_type) == "object") ? node_type : document.createElement(node_type);
		node = parent.insertBefore(node, parent.firstChild);
		if(attributes) {
			var attribute;
			for(attribute in attributes) {
				if(attribute == "html") {
					node.innerHTML = attributes[attribute];
				}
				else {
					node.setAttribute(attribute, attributes[attribute]);
				}
			}
		}
		return node;
	}
	catch(exception) {
		u.bug("Exception ("+exception+") in u.ie, called from: "+arguments.callee.caller);
		u.bug("node:" + u.nodeId(parent, 1));
		u.xInObject(attributes);
	}
	return false;
}
Util.wrapElement = u.we = function(node, node_type, attributes) {
	try {
		var wrapper_node = node.parentNode.insertBefore(document.createElement(node_type), node);
		if(attributes) {
			var attribute;
			for(attribute in attributes) {
				wrapper_node.setAttribute(attribute, attributes[attribute]);
			}
		}	
		wrapper_node.appendChild(node);
		return wrapper_node;
	}
	catch(exception) {
		u.bug("Exception ("+exception+") in u.we, called from: "+arguments.callee.caller);
		u.bug("node:" + u.nodeId(node, 1));
		u.xInObject(attributes);
	}
	return false;
}
Util.wrapContent = u.wc = function(node, node_type, attributes) {
	try {
		var wrapper_node = document.createElement(node_type);
		if(attributes) {
			var attribute;
			for(attribute in attributes) {
				wrapper_node.setAttribute(attribute, attributes[attribute]);
			}
		}	
		while(node.childNodes.length) {
			wrapper_node.appendChild(node.childNodes[0]);
		}
		node.appendChild(wrapper_node);
		return wrapper_node;
	}
	catch(exception) {
		u.bug("Exception ("+exception+") in u.wc, called from: "+arguments.callee.caller);
		u.bug("node:" + u.nodeId(node, 1));
		u.xInObject(attributes);
	}
	return false;
}
Util.textContent = u.text = function(node) {
	return node.textContent;
}
Util.clickableElement = u.ce = function(node, options) {
	var a = (node.nodeName.toLowerCase() == "a" ? node : u.qs("a", node));
	if(a) {
		u.ac(node, "link");
		if(a.getAttribute("href") !== null) {
			node.url = a.href;
			a.removeAttribute("href");
		}
	}
	else {
		u.ac(node, "clickable");
	}
	if(typeof(u.e.click) == "function") {
		u.e.click(node);
		if(typeof(options) == "object") {
			var argument;
			for(argument in options) {
				switch(argument) {
					case "type"			: node._click_type		= options[argument]; break;
					case "method"		: node._click_method	= options[argument]; break;
				}
			}
			if(node._click_type == "link") {
				node.clicked = function(event) {
					if(event.metaKey || event.ctrlKey) {
						window.open(this.url);
					}
					else {
						if(typeof(page.navigate) == "function") {
							page.navigate(this.url);
						}
						else {
							location.href = this.url;
						}
					}
				}
			}
		}
	}
	return node;
}
Util.classVar = u.cv = function(node, var_name) {
	try {
		var regexp = new RegExp(var_name + ":[?=\\w/\\#~:.?+=?&%@!\\-]*");
		if(node.className.match(regexp)) {
			return node.className.match(regexp)[0].replace(var_name + ":", "");
		}
	}
	catch(exception) {
		u.bug("Exception ("+exception+") in u.cv, called from: "+arguments.callee.caller);
	}
	return false;
}
u.getIJ = u.cv;
Util.setClass = u.sc = function(node, classname) {
	try {
		var old_class = node.className;
		node.className = classname;
		node.offsetTop;
		return old_class;
	}
	catch(exception) {
		u.bug("Exception ("+exception+") in u.setClass, called from: "+arguments.callee.caller);
	}
	return false;
}
Util.hasClass = u.hc = function(node, classname) {
	try {
		if(classname) {
			var regexp = new RegExp("(^|\\s)(" + classname + ")(\\s|$)");
			if(regexp.test(node.className)) {
				return true;
			}
		}
	}
	catch(exception) {
		u.bug("Exception ("+exception+") in u.hasClass("+u.nodeId(node)+"), called from: "+arguments.callee.caller);
	}
	return false;
}
Util.addClass = u.ac = function(node, classname, dom_update) {
	try {
		if(classname) {
			var regexp = new RegExp("(^|\\s)" + classname + "(\\s|$)");
			if(!regexp.test(node.className)) {
				node.className += node.className ? " " + classname : classname;
				dom_update === false ? false : node.offsetTop;
			}
			return node.className;
		}
	}
	catch(exception) {
		u.bug("Exception ("+exception+") in u.addClass, called from: "+arguments.callee.caller);
	}
	return false;
}
Util.removeClass = u.rc = function(node, classname, dom_update) {
	try {
		if(classname) {
			var regexp = new RegExp("(\\b)" + classname + "(\\s|$)", "g");
			node.className = node.className.replace(regexp, " ").trim().replace(/[\s]{2}/g, " ");
			dom_update === false ? false : node.offsetTop;
			return node.className;
		}
	}
	catch(exception) {
		u.bug("Exception ("+exception+") in u.removeClass, called from: "+arguments.callee.caller);
	}
	return false;
}
Util.toggleClass = u.tc = function(node, classname, _classname, dom_update) {
	try {
		var regexp = new RegExp("(^|\\s)" + classname + "(\\s|$|\:)");
		if(regexp.test(node.className)) {
			u.rc(node, classname, false);
			if(_classname) {
				u.ac(node, _classname, false);
			}
		}
		else {
			u.ac(node, classname, false);
			if(_classname) {
				u.rc(node, _classname, false);
			}
		}
		dom_update === false ? false : node.offsetTop;
		return node.className;
	}
	catch(exception) {
		u.bug("Exception ("+exception+") in u.toggleClass, called from: "+arguments.callee.caller);
	}
	return false;
}
Util.applyStyle = u.as = function(node, property, value, dom_update) {
	node.style[property] = value;
	dom_update === false ? false : node.offsetTop;
}
Util.applyStyles = u.ass = function(node, styles, dom_update) {
	if(styles) {
		var style;
		for(style in styles) {
			node.style[style] = styles[style];
		}
	}
	dom_update === false ? false : node.offsetTop;
}
Util.getComputedStyle = u.gcs = function(node, property) {
	node.offsetHeight;
	if(document.defaultView && document.defaultView.getComputedStyle) {
		return document.defaultView.getComputedStyle(node, null).getPropertyValue(property);
	}
	return false;
}
Util.hasFixedParent = u.hfp = function(node) {
	while(node.nodeName.toLowerCase() != "body") {
		if(u.gcs(node.parentNode, "position").match("fixed")) {
			return true;
		}
		node = node.parentNode;
	}
	return false;
}
Util.Events = u.e = new function() {
	this.event_pref = typeof(document.ontouchmove) == "undefined" || navigator.maxTouchPoints > 1 ? "mouse" : "touch";
	this.kill = function(event) {
		if(event) {
			event.preventDefault();
			event.stopPropagation();
		}
	}
	this.addEvent = function(node, type, action) {
		try {
			node.addEventListener(type, action, false);
		}
		catch(exception) {
			alert("exception in addEvent:" + node + "," + type + ":" + exception);
		}
	}
	this.removeEvent = function(node, type, action) {
		try {
			node.removeEventListener(type, action, false);
		}
		catch(exception) {
			u.bug("exception in removeEvent:" + node + "," + type + ":" + exception);
		}
	}
	this.addStartEvent = this.addDownEvent = function(node, action) {
		u.e.addEvent(node, (this.event_pref == "touch" ? "touchstart" : "mousedown"), action);
	}
	this.removeStartEvent = this.removeDownEvent = function(node, action) {
		u.e.removeEvent(node, (this.event_pref == "touch" ? "touchstart" : "mousedown"), action);
	}
	this.addMoveEvent = function(node, action) {
		u.e.addEvent(node, (this.event_pref == "touch" ? "touchmove" : "mousemove"), action);
	}
	this.removeMoveEvent = function(node, action) {
		u.e.removeEvent(node, (this.event_pref == "touch" ? "touchmove" : "mousemove"), action);
	}
	this.addEndEvent = this.addUpEvent = function(node, action) {
		u.e.addEvent(node, (this.event_pref == "touch" ? "touchend" : "mouseup"), action);
		if(node.snapback && u.e.event_pref == "mouse") {
			u.e.addEvent(node, "mouseout", this._snapback);
		}
	}
	this.removeEndEvent = this.removeUpEvent = function(node, action) {
		u.e.removeEvent(node, (this.event_pref == "touch" ? "touchend" : "mouseup"), action);
		if(node.snapback && u.e.event_pref == "mouse") {
			u.e.removeEvent(node, "mouseout", this._snapback);
		}
	}
	this.resetClickEvents = function(node) {
		u.t.resetTimer(node.t_held);
		u.t.resetTimer(node.t_clicked);
		this.removeEvent(node, "mouseup", this._dblclicked);
		this.removeEvent(node, "touchend", this._dblclicked);
		this.removeEvent(node, "mousemove", this._cancelClick);
		this.removeEvent(node, "touchmove", this._cancelClick);
		this.removeEvent(node, "mouseout", this._cancelClick);
		this.removeEvent(node, "mousemove", this._move);
		this.removeEvent(node, "touchmove", this._move);
	}
	this.resetEvents = function(node) {
		this.resetClickEvents(node);
		if(typeof(this.resetDragEvents) == "function") {
			this.resetDragEvents(node);
		}
	}
	this.resetNestedEvents = function(node) {
		while(node && node.nodeName != "HTML") {
			this.resetEvents(node);
			node = node.parentNode;
		}
	}
	this._inputStart = function(event) {
		this.event_var = event;
		this.input_timestamp = event.timeStamp;
		this.start_event_x = u.eventX(event);
		this.start_event_y = u.eventY(event);
		this.current_xps = 0;
		this.current_yps = 0;
		this.swiped = false;
		if(this.e_click || this.e_dblclick || this.e_hold) {
			var node = this;
			while(node) {
				if(node.e_drag || node.e_swipe) {
					u.e.addMoveEvent(this, u.e._cancelClick);
					break;
				}
				else {
					node = node.parentNode;
				}
			}
			u.e.addMoveEvent(this, u.e._move);
			if(u.e.event_pref == "touch") {
				u.e.addMoveEvent(this, u.e._cancelClick);
			}
			u.e.addEndEvent(this, u.e._dblclicked);
			if(u.e.event_pref == "mouse") {
				u.e.addEvent(this, "mouseout", u.e._cancelClick);
			}
		}
		if(this.e_hold) {
			this.t_held = u.t.setTimer(this, u.e._held, 750);
		}
		if(this.e_drag || this.e_swipe) {
			u.e.addMoveEvent(this, u.e._pick);
			u.e.addEndEvent(this, u.e._drop);
		}
		if(this.e_scroll) {
			u.e.addMoveEvent(this, u.e._scrollStart);
			u.e.addEndEvent(this, u.e._scrollEnd);
		}
		if(typeof(this.inputStarted) == "function") {
			this.inputStarted(event);
		}
	}
	this._cancelClick = function(event) {
		u.e.resetClickEvents(this);
		if(typeof(this.clickCancelled) == "function") {
			this.clickCancelled(event);
		}
	}
	this._move = function(event) {
		if(typeof(this.moved) == "function") {
			this.moved(event);
		}
	}
	this.hold = function(node) {
		node.e_hold = true;
		u.e.addStartEvent(node, this._inputStart);
	}
	this._held = function(event) {
		u.stats.event(this, "held");
		u.e.resetNestedEvents(this);
		if(typeof(this.held) == "function") {
			this.held(event);
		}
	}
	this.click = this.tap = function(node) {
		node.e_click = true;
		u.e.addStartEvent(node, this._inputStart);
	}
	this._clicked = function(event) {
		u.stats.event(this, "clicked");
		u.e.resetNestedEvents(this);
		if(typeof(this.clicked) == "function") {
			this.clicked(event);
		}
	}
	this.dblclick = this.doubletap = function(node) {
		node.e_dblclick = true;
		u.e.addStartEvent(node, this._inputStart);
	}
	this._dblclicked = function(event) {
		if(u.t.valid(this.t_clicked) && event) {
			u.stats.event(this, "dblclicked");
			u.e.resetNestedEvents(this);
			if(typeof(this.dblclicked) == "function") {
				this.dblclicked(event);
			}
			return;
		}
		else if(!this.e_dblclick) {
			this._clicked = u.e._clicked;
			this._clicked(event);
		}
		else if(!event) {
			this._clicked = u.e._clicked;
			this._clicked(this.event_var);
		}
		else {
			u.e.resetNestedEvents(this);
			this.t_clicked = u.t.setTimer(this, u.e._dblclicked, 400);
		}
	}
}
u.e.addDOMReadyEvent = function(action) {
	if(document.readyState && document.addEventListener) {
		if((document.readyState == "interactive" && !u.browser("ie")) || document.readyState == "complete" || document.readyState == "loaded") {
			action();
		}
		else {
			var id = u.randomString();
			window["DOMReady_" + id] = action;
			eval('window["_DOMReady_' + id + '"] = function() {window["DOMReady_'+id+'"](); u.e.removeEvent(document, "DOMContentLoaded", window["_DOMReady_' + id + '"])}');
			u.e.addEvent(document, "DOMContentLoaded", window["_DOMReady_" + id]);
		}
	}
	else {
		u.e.addOnloadEvent(action);
	}
}
u.e.addOnloadEvent = function(action) {
	if(document.readyState && (document.readyState == "complete" || document.readyState == "loaded")) {
		action();
	}
	else {
		var id = u.randomString();
		window["Onload_" + id] = action;
		eval('window["_Onload_' + id + '"] = function() {window["Onload_'+id+'"](); u.e.removeEvent(window, "load", window["_Onload_' + id + '"])}');
		u.e.addEvent(window, "load", window["_Onload_" + id]);
	}
}
u.e.addResizeEvent = function(node, action) {
}
u.e.removeResizeEvent = function(node, action) {
}
u.e.addScrollEvent = function(node, action) {
}
u.e.removeScrollEvent = function(node, action) {
}
u.e.resetDragEvents = function(node) {
	this.removeEvent(node, "mousemove", this._pick);
	this.removeEvent(node, "touchmove", this._pick);
	this.removeEvent(node, "mousemove", this._drag);
	this.removeEvent(node, "touchmove", this._drag);
	this.removeEvent(node, "mouseup", this._drop);
	this.removeEvent(node, "touchend", this._drop);
	this.removeEvent(node, "mouseout", this._drop_mouse);
	this.removeEvent(node, "mousemove", this._scrollStart);
	this.removeEvent(node, "touchmove", this._scrollStart);
	this.removeEvent(node, "mousemove", this._scrolling);
	this.removeEvent(node, "touchmove", this._scrolling);
	this.removeEvent(node, "mouseup", this._scrollEnd);
	this.removeEvent(node, "touchend", this._scrollEnd);
}
u.e.overlap = function(node, boundaries, strict) {
	if(boundaries.constructor.toString().match("Array")) {
		var boundaries_start_x = Number(boundaries[0]);
		var boundaries_start_y = Number(boundaries[1]);
		var boundaries_end_x = Number(boundaries[2]);
		var boundaries_end_y = Number(boundaries[3]);
	}
	else if(boundaries.constructor.toString().match("HTML")) {
		var boundaries_start_x = u.absX(boundaries) - u.absX(node);
		var boundaries_start_y =  u.absY(boundaries) - u.absY(node);
		var boundaries_end_x = Number(boundaries_start_x + boundaries.offsetWidth);
		var boundaries_end_y = Number(boundaries_start_y + boundaries.offsetHeight);
	}
	var node_start_x = Number(node._x);
	var node_start_y = Number(node._y);
	var node_end_x = Number(node_start_x + node.offsetWidth);
	var node_end_y = Number(node_start_y + node.offsetHeight);
	if(strict) {
		if(node_start_x >= boundaries_start_x && node_start_y >= boundaries_start_y && node_end_x <= boundaries_end_x && node_end_y <= boundaries_end_y) {
			return true;
		}
		else {
			return false;
		}
	} 
	else if(node_end_x < boundaries_start_x || node_start_x > boundaries_end_x || node_end_y < boundaries_start_y || node_start_y > boundaries_end_y) {
		return false;
	}
	return true;
}
u.e.drag = function(node, boundaries, settings) {
	node.e_drag = true;
	if(node.childNodes.length < 2 && node.innerHTML.trim() == "") {
		node.innerHTML = "&nbsp;";
	}
	node.drag_strict = true;
	node.drag_elastica = 0;
	node.drag_dropout = true;
	node.show_bounds = false;
	node.callback_picked = "picked";
	node.callback_moved = "moved";
	node.callback_dropped = "dropped";
	if(typeof(settings) == "object") {
		var argument;
		for(argument in settings) {
			switch(argument) {
				case "strict"			: node.drag_strict			= settings[argument]; break;
				case "elastica"			: node.drag_elastica		= Number(settings[argument]); break;
				case "dropout"			: node.drag_dropout			= settings[argument]; break;
				case "show_bounds"		: node.show_bounds			= settings[argument]; break; 
				case "vertical_lock"	: node.vertical_lock		= settings[argument]; break;
				case "horizontal_lock"	: node.horizontal_lock		= settings[argument]; break;
				case "callback_picked"	: node.callback_picked		= settings[argument]; break;
				case "callback_moved"	: node.callback_moved		= settings[argument]; break;
				case "callback_dropped"	: node.callback_dropped		= settings[argument]; break;
			}
		}
	}
	if((boundaries.constructor && boundaries.constructor.toString().match("Array")) || (boundaries.scopeName && boundaries.scopeName != "HTML")) {
		node.start_drag_x = Number(boundaries[0]);
		node.start_drag_y = Number(boundaries[1]);
		node.end_drag_x = Number(boundaries[2]);
		node.end_drag_y = Number(boundaries[3]);
	}
	else if((boundaries.constructor && boundaries.constructor.toString().match("HTML")) || (boundaries.scopeName && boundaries.scopeName == "HTML")) {
		node.start_drag_x = u.absX(boundaries) - u.absX(node);
		node.start_drag_y = u.absY(boundaries) - u.absY(node);
		node.end_drag_x = node.start_drag_x + boundaries.offsetWidth;
		node.end_drag_y = node.start_drag_y + boundaries.offsetHeight;
	}
	if(node.show_bounds) {
		var debug_bounds = u.ae(document.body, "div", {"class":"debug_bounds"})
		debug_bounds.style.position = "absolute";
		debug_bounds.style.background = "red"
		debug_bounds.style.left = (u.absX(node) + node.start_drag_x - 1) + "px";
		debug_bounds.style.top = (u.absY(node) + node.start_drag_y - 1) + "px";
		debug_bounds.style.width = (node.end_drag_x - node.start_drag_x) + "px";
		debug_bounds.style.height = (node.end_drag_y - node.start_drag_y) + "px";
		debug_bounds.style.border = "1px solid white";
		debug_bounds.style.zIndex = 9999;
		debug_bounds.style.opacity = .5;
		if(document.readyState && document.readyState == "interactive") {
			debug_bounds.innerHTML = "WARNING - injected on DOMLoaded"; 
		}
		u.bug("node: "+u.nodeId(node)+" in (" + u.absX(node) + "," + u.absY(node) + "), (" + (u.absX(node)+node.offsetWidth) + "," + (u.absY(node)+node.offsetHeight) +")");
		u.bug("boundaries: (" + node.start_drag_x + "," + node.start_drag_y + "), (" + node.end_drag_x + ", " + node.end_drag_y + ")");
	}
	node._x = node._x ? node._x : 0;
	node._y = node._y ? node._y : 0;
	node.locked = ((node.end_drag_x - node.start_drag_x == node.offsetWidth) && (node.end_drag_y - node.start_drag_y == node.offsetHeight));
	node.only_vertical = (node.vertical_lock || (!node.locked && node.end_drag_x - node.start_drag_x == node.offsetWidth));
	node.only_horizontal = (node.horizontal_lock || (!node.locked && node.end_drag_y - node.start_drag_y == node.offsetHeight));
	u.e.addStartEvent(node, this._inputStart);
}
u.e._pick = function(event) {
	var init_speed_x = Math.abs(this.start_event_x - u.eventX(event));
	var init_speed_y = Math.abs(this.start_event_y - u.eventY(event));
	if((init_speed_x > init_speed_y && this.only_horizontal) || 
	   (init_speed_x < init_speed_y && this.only_vertical) ||
	   (!this.only_vertical && !this.only_horizontal)) {
		u.e.resetNestedEvents(this);
	    u.e.kill(event);
		this.move_timestamp = event.timeStamp;
		this.move_last_x = this._x;
		this.move_last_y = this._y;
		if(u.hasFixedParent(this)) {
			this.start_input_x = u.eventX(event) - this._x - u.scrollX(); 
			this.start_input_y = u.eventY(event) - this._y - u.scrollY();
		}
		else {
			this.start_input_x = u.eventX(event) - this._x; 
			this.start_input_y = u.eventY(event) - this._y;
		}
		this.current_xps = 0;
		this.current_yps = 0;
		u.a.transition(this, "none");
		u.e.addMoveEvent(this, u.e._drag);
		u.e.addEndEvent(this, u.e._drop);
		if(typeof(this[this.callback_picked]) == "function") {
			this[this.callback_picked](event);
		}
	}
	if(this.drag_dropout && u.e.event_pref == "mouse") {
		u.e.addEvent(this, "mouseout", u.e._drop_mouse);
	}
}
u.e._drag = function(event) {
	if(u.hasFixedParent(this)) {
		this.current_x = u.eventX(event) - this.start_input_x - u.scrollX();
		this.current_y = u.eventY(event) - this.start_input_y - u.scrollY();
	}
	else {
		this.current_x = u.eventX(event) - this.start_input_x;
		this.current_y = u.eventY(event) - this.start_input_y;
	}
	this.current_xps = Math.round(((this.current_x - this.move_last_x) / (event.timeStamp - this.move_timestamp)) * 1000);
	this.current_yps = Math.round(((this.current_y - this.move_last_y) / (event.timeStamp - this.move_timestamp)) * 1000);
	this.move_timestamp = event.timeStamp;
	this.move_last_x = this.current_x;
	this.move_last_y = this.current_y;
	if(!this.locked && this.only_vertical) {
		this._y = this.current_y;
	}
	else if(!this.locked && this.only_horizontal) {
		this._x = this.current_x;
	}
	else if(!this.locked) {
		this._x = this.current_x;
		this._y = this.current_y;
	}
	if(this.e_swipe) {
		if(this.current_xps && (Math.abs(this.current_xps) > Math.abs(this.current_yps) || this.only_horizontal)) {
			if(this.current_xps < 0) {
				this.swiped = "left";
			}
			else {
				this.swiped = "right";
			}
		}
		else if(this.current_yps && (Math.abs(this.current_xps) < Math.abs(this.current_yps) || this.only_vertical)) {
			if(this.current_yps < 0) {
				this.swiped = "up";
			}
			else {
				this.swiped = "down";
			}
		}
	}
	if(!this.locked) {
		if(u.e.overlap(this, [this.start_drag_x, this.start_drag_y, this.end_drag_x, this.end_drag_y], true)) {
			u.a.translate(this, this._x, this._y);
		}
		else if(this.drag_elastica) {
			this.swiped = false;
			this.current_xps = 0;
			this.current_yps = 0;
			var offset = false;
			if(!this.only_vertical && this._x < this.start_drag_x) {
				offset = this._x < this.start_drag_x - this.drag_elastica ? - this.drag_elastica : this._x - this.start_drag_x;
				this._x = this.start_drag_x;
				this.current_x = this._x + offset + (Math.round(Math.pow(offset, 2)/this.drag_elastica));
			}
			else if(!this.only_vertical && this._x + this.offsetWidth > this.end_drag_x) {
				offset = this._x + this.offsetWidth > this.end_drag_x + this.drag_elastica ? this.drag_elastica : this._x + this.offsetWidth - this.end_drag_x;
				this._x = this.end_drag_x - this.offsetWidth;
				this.current_x = this._x + offset - (Math.round(Math.pow(offset, 2)/this.drag_elastica));
			}
			else {
				this.current_x = this._x;
			}
			if(!this.only_horizontal && this._y < this.start_drag_y) {
				offset = this._y < this.start_drag_y - this.drag_elastica ? - this.drag_elastica : this._y - this.start_drag_y;
				this._y = this.start_drag_y;
				this.current_y = this._y + offset + (Math.round(Math.pow(offset, 2)/this.drag_elastica));
			}
			else if(!this.horizontal && this._y + this.offsetHeight > this.end_drag_y) {
				offset = (this._y + this.offsetHeight > this.end_drag_y + this.drag_elastica) ? this.drag_elastica : (this._y + this.offsetHeight - this.end_drag_y);
				this._y = this.end_drag_y - this.offsetHeight;
				this.current_y = this._y + offset - (Math.round(Math.pow(offset, 2)/this.drag_elastica));
			}
			else {
				this.current_y = this._y;
			}
			if(offset) {
				u.a.translate(this, this.current_x, this.current_y);
			}
		}
		else {
			this.swiped = false;
			this.current_xps = 0;
			this.current_yps = 0;
			if(this._x < this.start_drag_x) {
				this._x = this.start_drag_x;
			}
			else if(this._x + this.offsetWidth > this.end_drag_x) {
				this._x = this.end_drag_x - this.offsetWidth;
			}
			if(this._y < this.start_drag_y) {
				this._y = this.start_drag_y;
			}
			else if(this._y + this.offsetHeight > this.end_drag_y) { 
				this._y = this.end_drag_y - this.offsetHeight;
			}
			u.a.translate(this, this._x, this._y);
		}
	}
	if(typeof(this[this.callback_moved]) == "function") {
		this[this.callback_moved](event);
	}
}
u.e._drop = function(event) {
	u.e.resetEvents(this);
	if(this.e_swipe && this.swiped) {
		if(this.swiped == "left" && typeof(this.swipedLeft) == "function") {
			this.swipedLeft(event);
		}
		else if(this.swiped == "right" && typeof(this.swipedRight) == "function") {
			this.swipedRight(event);
		}
		else if(this.swiped == "down" && typeof(this.swipedDown) == "function") {
			this.swipedDown(event);
		}
		else if(this.swiped == "up" && typeof(this.swipedUp) == "function") {
			this.swipedUp(event);
		}
	}
	else if(!this.drag_strict && !this.locked) {
		this.current_x = Math.round(this._x + (this.current_xps/2));
		this.current_y = Math.round(this._y + (this.current_yps/2));
		if(this.only_vertical || this.current_x < this.start_drag_x) {
			this.current_x = this.start_drag_x;
		}
		else if(this.current_x + this.offsetWidth > this.end_drag_x) {
			this.current_x = this.end_drag_x - this.offsetWidth;
		}
		if(this.only_horizontal || this.current_y < this.start_drag_y) {
			this.current_y = this.start_drag_y;
		}
		else if(this.current_y + this.offsetHeight > this.end_drag_y) {
			this.current_y = this.end_drag_y - this.offsetHeight;
		}
		this.transitioned = function() {
			this.transitioned = null;
			u.a.transition(this, "none");
			if(typeof(this.projected) == "function") {
				this.projected(event);
			}
		}
		if(this.current_xps || this.current_yps) {
			u.a.transition(this, "all 1s cubic-bezier(0,0,0.25,1)");
		}
		else {
			u.a.transition(this, "all 0.2s cubic-bezier(0,0,0.25,1)");
		}
		u.a.translate(this, this.current_x, this.current_y);
	}
	if(typeof(this[this.callback_dropped]) == "function") {
		this[this.callback_dropped](event);
	}
}
u.e._drop_mouse = function(event) {
	if(event.target == this) {
		this._drop = u.e._drop;
		this._drop(event);
	}
}
u.e.swipe = function(node, boundaries, settings) {
	node.e_swipe = true;
	u.e.drag(node, boundaries, settings);
}
Util.flashDetection = function(version) {
	var flash_version = false;
	var flash = false;
	if(navigator.plugins && navigator.plugins["Shockwave Flash"] && navigator.plugins["Shockwave Flash"].description && navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]) {
		flash = true;
		var Pversion = navigator.plugins["Shockwave Flash"].description.match(/\b([\d]+)\b/);
		if(Pversion.length > 1 && !isNaN(Pversion[1])) {
			flash_version = Pversion[1];
		}
	}
	else if(window.ActiveXObject) {
		try {
			var AXflash, AXversion;
			AXflash = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
			if(AXflash) {
				flash = true;
				AXversion = AXflash.GetVariable("$version").match(/\b([\d]+)\b/);
				if(AXversion.length > 1 && !isNaN(AXversion[1])) {
					flash_version = AXversion[1];
				}
			}
		}
		catch(exception) {}
	}
	if(flash_version || (flash && !version)) {
		if(!version) {
			return true;
		}
		else {
			if(!isNaN(version)) {
				return flash_version == version;
			}
			else {
				return eval(flash_version + version);
			}
		}
	}
	else {
		return false;
	}
}
Util.flash = function(node, url, settings) {
	var width = "100%";
	var height = "100%";
	var background = "transparent";
	var id = "flash_" + new Date().getHours() + "_" + new Date().getMinutes() + "_" + new Date().getMilliseconds();
	var allowScriptAccess = "always";
	var menu = "false";
	var scale = "showall";
	var wmode = "transparent";
	if(typeof(settings) == "object") {
		var argument;
		for(argument in settings) {
			switch(argument) {
				case "id"					: id				= settings[argument]; break;
				case "width"				: width				= Number(settings[argument]); break;
				case "height"				: height			= Number(settings[argument]); break;
				case "background"			: background		= settings[argument]; break;
				case "allowScriptAccess"	: allowScriptAccess = settings[argument]; break;
				case "menu"					: menu				= settings[argument]; break;
				case "scale"				: scale				= settings[argument]; break;
				case "wmode"				: wmode				= settings[argument]; break;
			}
		}
	}
	html = '<object';
	html += ' id="'+id+'"';
	html += ' width="'+width+'"';
	html += ' height="'+height+'"';
	if(u.browser("explorer")) {
		html += ' classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"';
	}
	else {
		html += ' type="application/x-shockwave-flash"';
		html += ' data="'+url+'"';
	}
	html += '>';
	html += '<param name="allowScriptAccess" value="'+allowScriptAccess+'" />';
	html += '<param name="movie" value="'+url+'" />';
	html += '<param name="quality" value="high" />';
	html += '<param name="bgcolor" value="'+background+'" />';
	html += '<param name="play" value="true" />';
	html += '<param name="wmode" value="'+wmode+'" />';
	html += '<param name="menu" value="'+menu+'" />';
	html += '<param name="scale" value="'+scale+'" />';
	html += '</object>';
	var temp_node = document.createElement("div");
	temp_node.innerHTML = html;
	node.insertBefore(temp_node.firstChild, node.firstChild);
	var flash_object = u.qs("#"+id, node);
	return flash_object;
}
Util.Form = u.f = new function() {
	this.customInit = {};
	this.customValidate = {};
	this.customSend = {};
	this.init = function(form, settings) {
		var i, j, field, action, input;
		form.form_send = "params";
		form.ignore_inputs = "ignoreinput";
		if(typeof(settings) == "object") {
			var argument;
			for(argument in settings) {
				switch(argument) {
					case "ignore_inputs"	: form.ignore_inputs	= settings[argument]; break;
					case "form_send"		: form.form_send		= settings[argument]; break;
				}
			}
		}
		form.onsubmit = function(event) {return false;}
		form.setAttribute("novalidate", "novalidate");
		form._submit = this._submit;
		form.fields = {};
		form.tab_order = [];
		form.actions = {};
		var fields = u.qsa(".field", form);
		for(i = 0; field = fields[i]; i++) {
			var abbr = u.qs("abbr", field);
			if(abbr) {
				abbr.parentNode.removeChild(abbr);
			}
			var error_message = field.getAttribute("data-error");
			if(error_message) {
				u.ae(field, "div", {"class":"error", "html":error_message})
			}
			field._indicator = u.ae(field, "div", {"class":"indicator"});
			field._help = u.qs(".help", field);
			field._hint = u.qs(".hint", field);
			field._error = u.qs(".error", field);
			var not_initialized = true;
			var custom_init;
			for(custom_init in this.customInit) {
				if(field.className.match(custom_init)) {
					this.customInit[custom_init](field);
					not_initialized = false;
				}
			}
			if(not_initialized) {
				if(u.hc(field, "string|email|tel|number|integer|password")) {
					field._input = u.qs("input", field);
					field._input.field = field;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					this.formIndex(form, field._input);
				}
				else if(u.hc(field, "text")) {
					field._input = u.qs("textarea", field);
					field._input.field = field;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					this.formIndex(form, field._input);
					if(u.hc(field, "autoexpand")) {
						this.autoExpand(field._input)
					}
				}
				else if(u.hc(field, "select")) {
					field._input = u.qs("select", field);
					field._input.field = field;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					this.formIndex(form, field._input);
				}
				else if(u.hc(field, "checkbox|boolean")) {
					field._input = u.qs("input[type=checkbox]", field);
					field._input.field = field;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					this.formIndex(form, field._input);
				}
				else if(u.hc(field, "radio|radio_buttons")) {
					field._input = u.qsa("input", field);
					for(j = 0; input = field._input[j]; j++) {
						input.field = field;
						input._label = u.qs("label[for="+input.id+"]", field);
						this.formIndex(form, input);
					}
				}
				else if(u.hc(field, "date|datetime")) {
					field._input = u.qsa("select,input", field);
					for(j = 0; input = field._input[j]; j++) {
						input.field = field;
						input._label = u.qs("label[for="+input.id+"]", field);
						this.formIndex(form, input);
					}
				}
				else if(u.hc(field, "tags")) {
					field._input = u.qs("input", field);
					field._input.field = field;
					field._input._label = u.qs("label\[for\="+field._input.id+"\]", field);
					this.formIndex(form, field._input);
				}
				else if(u.hc(field, "prices")) {
					field._input = u.qs("input", field);
					field._input.field = field;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					this.formIndex(form, field._input);
				}
				else if(u.hc(field, "files")) {
					field._input = u.qs("input", field);
					field._input.field = field;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					this.formIndex(form, field._input);
				}
				else if(u.hc(field, "location")) {
					field._input = u.qsa("input", field);
					for(j = 0; input = field._input[j]; j++) {
						input.field = field;
						input._label = u.qs("label[for="+input.id+"]", field);
						this.formIndex(form, input);
					}
					if(navigator.geolocation) {
						this.geoLocation(field);
					}
				}
			}
		}
		var hidden_fields = u.qsa("input[type=hidden]", form);
		for(i = 0; hidden_field = hidden_fields[i]; i++) {
			if(!form.fields[hidden_field.name]) {
				form.fields[hidden_field.name] = hidden_field;
				hidden_field.val = this._value;
			}
		}
		var actions = u.qsa(".actions li, .actions", form);
		for(i = 0; action = actions[i]; i++) {
			action._input = u.qs("input,a", action);
			if(action._input.type && action._input.type == "submit") {
				action._input.onclick = function(event) {
					u.e.kill(event ? event : window.event);
				}
			}
			u.ce(action._input);
			action._input.clicked = function(event) {
				u.e.kill(event);
				if(!u.hc(this, "disabled")) {
					if(this.type && this.type.match(/submit/i)) {
						this.form._submit_button = this;
						this.form._submit_input = false;
						this.form._submit(event, this);
					}
				}
			}
			this.buttonOnEnter(action._input);
			this.activateButton(action._input);
			var action_name = action._input.name ? action._input.name : action.className;
				form.actions[action_name] = action._input;
			if(typeof(u.k) == "object" && u.hc(action._input, "key:[a-z0-9]+")) {
				u.k.addKey(u.cv(action._input, "key"), action._input);
			}
		}
		if(!actions.length) {
			var p_ul = u.pn(form, "ul");
			if(u.hc(p_ul, "actions")) {
				u.bug("valid pure button form found")
				var input = u.qs("input,a", form);
				if(input.type && input.type == "submit") {
					input.onclick = function(event) {
						u.e.kill(event ? event : window.event);
					}
				}
				u.ce(input);
				input.clicked = function(event) {
					u.e.kill(event);
					if(!u.hc(this, "disabled")) {
						if(this.type && this.type.match(/submit/i)) {
							this.form._submit_button = this;
							this.form._submit_input = false;
							this.form._submit(event, this);
						}
					}
				}
				this.buttonOnEnter(input);
				this.activateButton(input);
				if(input.name) {
					form.actions[input.name] = input;
				}
				if(typeof(u.k) == "object" && u.hc(input, "key:[a-z0-9]+")) {
					u.k.addKey(u.cv(input, "key"), input);
				}
			}
		}
	}
	this._value = function(value) {
		if(value !== undefined) {
			this.value = value;
			u.f.validate(this);
		}
		return this.value;
	}
	this._value_radio = function(value) {
		if(value) {
			for(i = 0; option = this.form[this.name][i]; i++) {
				if(option.value == value) {
					option.checked = true;
					u.f.validate(this);
				}
			}
		}
		else {
			var i, option;
			for(i = 0; option = this.form[this.name][i]; i++) {
				if(option.checked) {
					return option.value;
				}
			}
		}
		return false;
	}
	this._value_checkbox = function(value) {
		if(value) {
			this.checked = true
			u.f.validate(this);
		}
		else {
			if(this.checked) {
				return this.value;
			}
		}
		return false;
	}
	this._value_select = function(value) {
		if(value !== undefined) {
			var i, option;
			for(i = 0; option = this.options[i]; i++) {
				if(option.value == value) {
					this.selectedIndex = i;
					u.f.validate(this);
					return i;
				}
			}
			return false;
		}
		else {
			return this.options[this.selectedIndex].value;
		}
	}
	this.inputOnEnter = function(node) {
		node.keyPressed = function(event) {
			if(this.nodeName.match(/input/i) && (event.keyCode == 40 || event.keyCode == 38)) {
				this._submit_disabled = true;
			}
			else if(this.nodeName.match(/input/i) && this._submit_disabled && (
				event.keyCode == 46 || 
				(event.keyCode == 39 && u.browser("firefox")) || 
				(event.keyCode == 37 && u.browser("firefox")) || 
				event.keyCode == 27 || 
				event.keyCode == 13 || 
				event.keyCode == 9 ||
				event.keyCode == 8
			)) {
				this._submit_disabled = false;
			}
			else if(event.keyCode == 13 && !this._submit_disabled) {
				u.e.kill(event);
				this.blur();
				this.form.submitInput = this;
				this.form.submitButton = false;
				this.form._submit(event, this);
			}
		}
		u.e.addEvent(node, "keydown", node.keyPressed);
	}
	this.buttonOnEnter = function(node) {
		node.keyPressed = function(event) {
			if(event.keyCode == 13 && !u.hc(this, "disabled")) {
				u.e.kill(event);
				this.form.submit_input = false;
				this.form.submit_button = this;
				this.form._submit(event);
			}
		}
		u.e.addEvent(node, "keydown", node.keyPressed);
	}
	this.formIndex = function(form, iN) {
		iN.tab_index = form.tab_order.length;
		form.tab_order[iN.tab_index] = iN;
		if(iN.field && iN.name) {
			form.fields[iN.name] = iN;
			if(iN.nodeName.match(/input/i) && iN.type && iN.type.match(/text|email|tel|number|password|datetime|date/)) {
				iN.val = this._value;
				u.e.addEvent(iN, "keyup", this._updated);
				u.e.addEvent(iN, "change", this._changed);
				this.inputOnEnter(iN);
			}
			else if(iN.nodeName.match(/textarea/i)) {
				iN.val = this._value;
				u.e.addEvent(iN, "keyup", this._updated);
				u.e.addEvent(iN, "change", this._changed);
			}
			else if(iN.nodeName.match(/select/i)) {
				iN.val = this._value_select;
				u.e.addEvent(iN, "change", this._updated);
				u.e.addEvent(iN, "keyup", this._updated);
				u.e.addEvent(iN, "change", this._changed);
			}
			else if(iN.type && iN.type.match(/checkbox/)) {
				iN.val = this._value_checkbox;
				if(u.browser("explorer", "<=8")) {
					iN.pre_state = iN.checked;
					iN._changed = u.f._changed;
					iN._updated = u.f._updated;
					iN._clicked = function(event) {
						if(this.checked != this.pre_state) {
							this._changed(window.event);
							this._updated(window.event);
						}
						this.pre_state = this.checked;
					}
					u.e.addEvent(iN, "click", iN._clicked);
				}
				else {
					u.e.addEvent(iN, "change", this._updated);
					u.e.addEvent(iN, "change", this._changed);
				}
				this.inputOnEnter(iN);
			}
			else if(iN.type && iN.type.match(/radio/)) {
				iN.val = this._value_radio;
				if(u.browser("explorer", "<=8")) {
					iN.pre_state = iN.checked;
					iN._changed = u.f._changed;
					iN._updated = u.f._updated;
					iN._clicked = function(event) {
						var i, input;
						if(this.checked != this.pre_state) {
							this._changed(window.event);
							this._updated(window.event);
						}
						for(i = 0; input = this.field._input[i]; i++) {
							input.pre_state = input.checked;
						}
					}
					u.e.addEvent(iN, "click", iN._clicked);
				}
				else {
					u.e.addEvent(iN, "change", this._updated);
					u.e.addEvent(iN, "change", this._changed);
				}
				this.inputOnEnter(iN);
			}
			else if(iN.type && iN.type.match(/file/)) {
				iN.val = function(value) {
					if(value !== undefined) {
						alert('adding values manually to input type="file" is not supported')
					}
					else {
						var i, file, files = [];
						for(i = 0; file = this.files[i]; i++) {
							files.push(file);
						}
						return files.join(",");
					}
				}
				u.e.addEvent(iN, "keyup", this._updated);
				u.e.addEvent(iN, "change", this._changed);
			}
			this.activateField(iN);
			this.validate(iN);
		}
	}
	this._changed = function(event) {
		this.used = true;
		if(typeof(this.changed) == "function") {
			this.changed(this);
		}
		if(typeof(this.form.changed) == "function") {
			this.form.changed(this);
		}
	}
	this._updated = function(event) {
		if(event.keyCode != 9 && event.keyCode != 13 && event.keyCode != 16 && event.keyCode != 17 && event.keyCode != 18) {
			if(this.used || u.hc(this.field, "error")) {
				u.f.validate(this);
			}
			if(typeof(this.updated) == "function") {
				this.updated(this);
			}
			if(typeof(this.form.updated) == "function") {
				this.form.updated(this);
			}
		}
	}
	this._validate = function() {
		u.f.validate(this);
	}
	this._submit = function(event, iN) {
		for(name in this.fields) {
			if(this.fields[name].field) {
				this.fields[name].used = true;
				u.f.validate(this.fields[name]);
			}
		}
		if(u.qs(".field.error", this)) {
			if(typeof(this.validationFailed) == "function") {
				this.validationFailed();
			}
		}
		else {
			if(typeof(this.submitted) == "function") {
				this.submitted(iN);
			}
			else {
				this.submit();
			}
		}
	}
	this._focus = function(event) {
		this.field.focused = true;
		u.ac(this.field, "focus");
		u.ac(this, "focus");
		u.as(this.field, "zIndex", 99);
		if(this.field._help) {
			var f_h =  this.field.offsetHeight;
			var f_p_t = parseInt(u.gcs(this.field, "padding-top"));
			var f_p_b = parseInt(u.gcs(this.field, "padding-bottom"));
			var f_h_h = this.field._help.offsetHeight;
			u.as(this.field._help, "top", (((f_h - (f_p_t + f_p_b)) / 2) + 2) - (f_h_h / 2) + "px");
		}
		if(typeof(this.focused) == "function") {
			this.focused();
		}
		if(typeof(this.form.focused) == "function") {
			this.form.focused(this);
		}
	}
	this._blur = function(event) {
		this.field.focused = false;
		u.rc(this.field, "focus");
		u.rc(this, "focus");
		u.as(this.field, "zIndex", 90);
		if(this.field._help) {
			u.as(this.field._help, "top", ((this.offsetTop + this.offsetHeight/2 + 2) - (this.field._help.offsetHeight/2)) + "px")
		}
		this.used = true;
		if(typeof(this.blurred) == "function") {
			this.blurred();
		}
		if(typeof(this.form.blurred) == "function") {
			this.form.blurred(this);
		}
	}
	this._button_focus = function(event) {
		u.ac(this, "focus");
		if(typeof(this.focused) == "function") {
			this.focused();
		}
		if(typeof(this.form.focused) == "function") {
			this.form.focused(this);
		}
	}
	this._button_blur = function(event) {
		u.rc(this, "focus");
		if(typeof(this.blurred) == "function") {
			this.blurred();
		}
		if(typeof(this.form.blurred) == "function") {
			this.form.blurred(this);
		}
	}
	this._default_value_focus = function() {
		u.rc(this, "default");
		if(this.val() == this.default_value) {
			this.val("");
		}
	}
	this._default_value_blur = function() {
		if(this.val() == "") {
			u.ac(this, "default");
			this.val(this.default_value);
		}
	}
	this.activateField = function(iN) {
		u.e.addEvent(iN, "focus", this._focus);
		u.e.addEvent(iN, "blur", this._blur);
		u.e.addEvent(iN, "blur", this._validate);
		if(iN.form.labelstyle || u.hc(iN.form, "labelstyle:[a-z]+")) {
			iN.form.labelstyle = iN.form.labelstyle ? iN.form.labelstyle : u.cv(iN.form, "labelstyle");
			if(iN.form.labelstyle == "inject" && (!iN.type || !iN.type.match(/file|radio|checkbox/))) {
				iN.default_value = iN._label.innerHTML;
				u.e.addEvent(iN, "focus", this._default_value_focus);
				u.e.addEvent(iN, "blur", this._default_value_blur);
				if(iN.val() == "") {
					iN.val(iN.default_value);
					u.ac(iN, "default");
				}
			}
		}
	}
	this.activateButton = function(button) {
		u.e.addEvent(button, "focus", this._button_focus);
		u.e.addEvent(button, "blur", this._button_blur);
	}
 	this.isDefault = function(iN) {
		if(iN.default_value && iN.val() == iN.default_value) {
			return true;
		}
		return false;
	}
	this.fieldError = function(iN) {
		u.rc(iN, "correct");
		u.rc(iN.field, "correct");
		if(iN.used || !this.isDefault(iN) && iN.val()) {
			u.ac(iN, "error");
			u.ac(iN.field, "error");
			if(iN.field._help) {
				u.as(iN.field._help, "top", ((iN.offsetTop + iN.offsetHeight/2 + 2) - (iN.field._help.offsetHeight/2)) + "px")
			}
			if(typeof(iN.validationFailed) == "function") {
				iN.validationFailed();
			}
		}
	}
	this.fieldCorrect = function(iN) {
		if(!this.isDefault(iN) && iN.val()) {
			u.ac(iN, "correct");
			u.ac(iN.field, "correct");
			u.rc(iN, "error");
			u.rc(iN.field, "error");
		}
		else {
			u.rc(iN, "correct");
			u.rc(iN.field, "correct");
			u.rc(iN, "error");
			u.rc(iN.field, "error");
		}
	}
	this.autoExpand = function(iN) {
		var current_height = parseInt(u.gcs(iN, "height"));
		var current_value = iN.val();
		iN.val("");
		u.as(iN, "overflow", "hidden");
		iN.autoexpand_offset = 0;
		if(parseInt(u.gcs(iN, "height")) != iN.scrollHeight) {
			iN.autoexpand_offset = iN.scrollHeight - parseInt(u.gcs(iN, "height"));
		}
		iN.val(current_value);
		iN.setHeight = function() {
			u.bug("iN.setHeight:" + u.nodeId(this));
			var textarea_height = parseInt(u.gcs(this, "height"));
			if(this.val()) {
				if(u.browser("webkit") || u.browser("firefox", ">=29")) {
					if(this.scrollHeight - this.autoexpand_offset > textarea_height) {
						u.a.setHeight(this, this.scrollHeight);
					}
				}
				else if(u.browser("opera") || u.browser("explorer")) {
					if(this.scrollHeight > textarea_height) {
						u.a.setHeight(this, this.scrollHeight);
					}
				}
				else {
					u.a.setHeight(this, this.scrollHeight);
				}
			}
		}
		u.e.addEvent(iN, "keyup", iN.setHeight);
		iN.setHeight();
	}
	this.geoLocation = function(field) {
		u.ac(field, "geolocation");
		var bn_geolocation = u.ae(field, "div", {"class":"geolocation"});
		bn_geolocation.field = field;
		u.ce(bn_geolocation);
		bn_geolocation.clicked = function() {
			window._geoLocationField = this.field;
			window._foundLocation = function(position) {
				var lat = position.coords.latitude;
				var lon = position.coords.longitude;
				var lat_input = u.qs("div.latitude input", window._geolocationField);
				var lon_input = u.qs("div.longitude input", window._geolocationField);
				lat_input.val(lat);
				lat_input.focus();
				lon_input.val(lon);
				lon_input.focus();
			}
			window._noLocation = function() {
				alert('Could not find location');
			}
			navigator.geolocation.getCurrentPosition(window._foundLocation, window._noLocation);
		}
	}
	this.validate = function(iN) {
		var min, max, pattern;
		var not_validated = true;
		if(!u.hc(iN.field, "required") && (iN.val() == "" || this.isDefault(iN))) {
			this.fieldCorrect(iN);
			return true;
		}
		else if(u.hc(iN.field, "required") && (iN.val() == "" || this.isDefault(iN))) {
			this.fieldError(iN);
			return false;
		}
		var custom_validate;
		for(custom_validate in u.f.customValidate) {
			if(u.hc(iN.field, custom_validate)) {
				u.f.customValidate[custom_validate](iN);
				not_validated = false;
			}
		}
		if(not_validated) {
			if(u.hc(iN.field, "password")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 8;
				max = max ? max : 20;
				pattern = iN.getAttribute("pattern");
				if(
					iN.val().length >= min && 
					iN.val().length <= max && 
					(!pattern || iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "number")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 0;
				max = max ? max : 99999999999999999999999999999;
				pattern = iN.getAttribute("pattern");
				if(
					!isNaN(iN.val()) && 
					iN.val() >= min && 
					iN.val() <= max && 
					(!pattern || iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "integer")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 0;
				max = max ? max : 99999999999999999999999999999;
				pattern = iN.getAttribute("pattern");
				if(
					!isNaN(iN.val()) && 
					Math.round(iN.val()) == iN.val() && 
					iN.val() >= min && 
					iN.val() <= max && 
					(!pattern || iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "tel")) {
				pattern = iN.getAttribute("pattern");
				if(
					!pattern && iN.val().match(/^([\+0-9\-\.\s\(\)]){5,18}$/) ||
					(pattern && iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "email")) {
				if(
					!pattern && iN.val().match(/^([^<>\\\/%$])+\@([^<>\\\/%$])+\.([^<>\\\/%$]{2,20})$/) ||
					(pattern && iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "text")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 1;
				max = max ? max : 10000000;
				pattern = iN.getAttribute("pattern");
				if(
					iN.val().length >= min && 
					iN.val().length <= max && 
					(!pattern || iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "select")) {
				if(iN.val()) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "checkbox|boolean|radio|radio_buttons")) {
				if(iN.val()) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "string")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 1;
				max = max ? max : 255;
				pattern = iN.getAttribute("pattern");
				if(
					iN.val().length >= min &&
					iN.val().length <= max && 
					(!pattern || iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "date")) {
				pattern = iN.getAttribute("pattern");
				if(
					!pattern && iN.val().match(/^([\d]{4}[\-\/\ ]{1}[\d]{2}[\-\/\ ][\d]{2})$/) ||
					(pattern && iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "datetime")) {
				pattern = iN.getAttribute("pattern");
				if(
					!pattern && iN.val().match(/^([\d]{4}[\-\/\ ]{1}[\d]{2}[\-\/\ ][\d]{2} [\d]{2}[\-\/\ \:]{1}[\d]{2}[\-\/\ \:]{0,1}[\d]{0,2})$/) ||
					(pattern && iN.val().match(pattern))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "tags")) {
				if(
					!pattern && iN.val().match(/\:/) ||
					(pattern && iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "prices")) {
				if(
					!isNaN(iN.val())
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "location")) {
				if(u.hc(iN, "location")) {
					min = min ? min : 1;
					max = max ? max : 255;
					if(
						iN.val().length >= min &&
						iN.val().length <= max
					) {
						this.fieldCorrect(iN);
					}
					else {
						this.fieldError(iN);
					}
				}
				if(u.hc(iN, "latitude")) {
					min = min ? min : -90;
					max = max ? max : 90;
					if(
						!isNaN(iN.val()) && 
						iN.val() >= min && 
						iN.val() <= max
					) {
						this.fieldCorrect(iN);
					}
					else {
						this.fieldError(iN);
					}
				}
				if(u.hc(iN, "longitude")) {
					min = min ? min : -180;
					max = max ? max : 180;
					if(
						!isNaN(iN.val()) && 
						iN.val() >= min && 
						iN.val() <= max
					) {
						this.fieldCorrect(iN);
					}
					else {
						this.fieldError(iN);
					}
				}
				if(u.qsa(".correct", iN.field).length != 3) {
					u.rc(iN.field, "correct");
					u.ac(iN.field, "error");
				}
			}
			else if(u.hc(iN.field, "files")) {
				u.bug("files:" + iN.files.length);
				if(
					1
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
		}
		if(u.hc(iN.field, "error")) {
			return false;
		}
		else {
			return true;
		}
	}
	this.getParams = function(form, settings) {
		var send_as = "params";
		var ignore_inputs = "ignoreinput";
		if(typeof(settings) == "object") {
			var argument;
			for(argument in settings) {
				switch(argument) {
					case "ignore_inputs"	: ignore_inputs		= settings[argument]; break;
					case "send_as"			: send_as			= settings[argument]; break;
				}
			}
		}
		var i, input, select, textarea, param;
			var params = new Object();
		if(form._submit_button && form._submit_button.name) {
			params[form._submit_button.name] = form._submit_button.value;
		}
		var inputs = u.qsa("input", form);
		var selects = u.qsa("select", form)
		var textareas = u.qsa("textarea", form)
		for(i = 0; input = inputs[i]; i++) {
			if(!u.hc(input, ignore_inputs)) {
				if((input.type == "checkbox" || input.type == "radio") && input.checked) {
					if(!this.isDefault(input)) {
						params[input.name] = input.value;
					}
				}
				else if(input.type == "file") {
					if(!this.isDefault(input)) {
						params[input.name] = input.value;
					}
				}
				else if(!input.type.match(/button|submit|reset|file|checkbox|radio/i)) {
					if(!this.isDefault(input)) {
						params[input.name] = input.value;
					}
					else {
						params[input.name] = "";
					}
				}
			}
		}
		for(i = 0; select = selects[i]; i++) {
			if(!u.hc(select, ignore_inputs)) {
				if(!this.isDefault(select)) {
					params[select.name] = select.options[select.selectedIndex].value;
				}
			}
		}
		for(i = 0; textarea = textareas[i]; i++) {
			if(!u.hc(textarea, ignore_inputs)) {
				if(!this.isDefault(textarea)) {
					params[textarea.name] = textarea.value;
				}
				else {
					params[textarea.name] = "";
				}
			}
		}
		if(send_as && typeof(this.customSend[send_as]) == "function") {
			return this.customSend[send_as](params, form);
		}
		else if(send_as == "json") {
			return u.f.convertNamesToJsonObject(params);
		}
		else if(send_as == "object") {
			return params;
		}
		else {
			var string = "";
			for(param in params) {
					string += (string ? "&" : "") + param + "=" + encodeURIComponent(params[param]);
			}
			return string;
		}
	}
}
u.f.convertNamesToJsonObject = function(params) {
 	var indexes, root, indexes_exsists, param;
	var object = new Object();
	for(param in params) {
	 	indexes_exsists = param.match(/\[/);
		if(indexes_exsists) {
			root = param.split("[")[0];
			indexes = param.replace(root, "");
			if(typeof(object[root]) == "undefined") {
				object[root] = new Object();
			}
			object[root] = this.recurseName(object[root], indexes, params[param]);
		}
		else {
			object[param] = params[param];
		}
	}
	return object;
}
u.f.recurseName = function(object, indexes, value) {
	var index = indexes.match(/\[([a-zA-Z0-9\-\_]+)\]/);
	var current_index = index[1];
	indexes = indexes.replace(index[0], "");
 	if(indexes.match(/\[/)) {
		if(object.length !== undefined) {
			var i;
			var added = false;
			for(i = 0; i < object.length; i++) {
				for(exsiting_index in object[i]) {
					if(exsiting_index == current_index) {
						object[i][exsiting_index] = this.recurseName(object[i][exsiting_index], indexes, value);
						added = true;
					}
				}
			}
			if(!added) {
				temp = new Object();
				temp[current_index] = new Object();
				temp[current_index] = this.recurseName(temp[current_index], indexes, value);
				object.push(temp);
			}
		}
		else if(typeof(object[current_index]) != "undefined") {
			object[current_index] = this.recurseName(object[current_index], indexes, value);
		}
		else {
			object[current_index] = new Object();
			object[current_index] = this.recurseName(object[current_index], indexes, value);
		}
	}
	else {
		object[current_index] = value;
	}
	return object;
}
u.f.addForm = function(node, settings) {
	var form_name = "js_form";
	var form_action = "#";
	var form_method = "post";
	var form_class = "";
	if(typeof(settings) == "object") {
		var argument;
		for(argument in settings) {
			switch(argument) {
				case "name"			: form_name				= settings[argument]; break;
				case "action"		: form_action			= settings[argument]; break;
				case "method"		: form_method			= settings[argument]; break;
				case "class"		: form_class			= settings[argument]; break;
			}
		}
	}
	var form = u.ae(node, "form", {"class":form_class, "name": form_name, "action":form_action, "method":form_method});
	return form;
}
u.f.addFieldset = function(node) {
	return u.ae(node, "fieldset");
}
u.f.addField = function(node, settings) {
	var field_type = "string";
	var field_label = "Value";
	var field_name = "js_name";
	var field_value = "";
	var field_class = "";
	if(typeof(settings) == "object") {
		var argument;
		for(argument in settings) {
			switch(argument) {
				case "type"			: field_type			= settings[argument]; break;
				case "label"		: field_label			= settings[argument]; break;
				case "name"			: field_name			= settings[argument]; break;
				case "value"		: field_value			= settings[argument]; break;
				case "class"		: field_class			= settings[argument]; break;
			}
		}
	}
	var input_id = "input_"+field_type+"_"+field_name;
	var field = u.ae(node, "div", {"class":"field "+field_type+" "+field_class});
	if(field_type == "string") {
		var label = u.ae(field, "label", {"for":input_id, "html":field_label});
		var input = u.ae(field, "input", {"id":input_id, "value":field_value, "name":field_name, "type":"text"});
	}
	else if(field_type == "email" || field_type == "number" || field_type == "tel") {
		var label = u.ae(field, "label", {"for":input_id, "html":field_label});
		var input = u.ae(field, "input", {"id":input_id, "value":field_value, "name":field_name, "type":field_type});
	}
	else if(field_type == "select") {
		u.bug("Select not implemented yet")
	}
	else {
		u.bug("input type not implemented yet")
	}
	return field;
}
u.f.addAction = function(node, settings) {
	var action_type = "submit";
	var action_name = "js_name";
	var action_value = "";
	var action_class = "";
	if(typeof(settings) == "object") {
		var argument;
		for(argument in settings) {
			switch(argument) {
				case "type"			: action_type			= settings[argument]; break;
				case "name"			: action_name			= settings[argument]; break;
				case "value"		: action_value			= settings[argument]; break;
				case "class"		: action_class			= settings[argument]; break;
			}
		}
	}
	var p_ul = node.nodeName.toLowerCase() == "ul" ? node : u.pn(node, "ul");
	if(!u.hc(p_ul, "actions")) {
		p_ul = u.ae(node, "ul", {"class":"actions"});
	}
	var p_li = node.nodeName.toLowerCase() == "li" ? node : u.pn(node, "li");
	if(p_ul != p_li.parentNode) {
		p_li = u.ae(p_ul, "li", {"class":action_name});
	}
	else {
		p_li = node;
	}
	var action = u.ae(p_li, "input", {"type":action_type, "class":action_class, "value":action_value, "name":action_name})
	return action;
}
Util.absoluteX = u.absX = function(node) {
	if(node.offsetParent) {
		u.bug("node.offsetParent, node.offsetLeft + u.absX(node.offsetParent):" + node.offsetLeft + ", " + u.nodeId(node.offsetParent))
		return node.offsetLeft + u.absX(node.offsetParent);
	}
	u.bug("node.offsetLeft:" + node.offsetLeft)
	return node.offsetLeft;
}
Util.absoluteY = u.absY = function(node) {
	if(node.offsetParent) {
		return node.offsetTop + u.absY(node.offsetParent);
	}
	return node.offsetTop;
}
Util.relativeX = u.relX = function(node) {
	if(u.gcs(node, "position").match(/absolute/) == null && node.offsetParent && u.gcs(node.offsetParent, "position").match(/relative|absolute|fixed/) == null) {
		return node.offsetLeft + u.relX(node.offsetParent);
	}
	return node.offsetLeft;
}
Util.relativeY = u.relY = function(node) {
	if(u.gcs(node, "position").match(/absolute/) == null && node.offsetParent && u.gcs(node.offsetParent, "position").match(/relative|absolute|fixed/) == null) {
		return node.offsetTop + u.relY(node.offsetParent);
	}
	return node.offsetTop;
}
Util.actualWidth = u.actualW = function(node) {
	return parseInt(u.gcs(node, "width"));
}
Util.actualHeight = u.actualH = function(node) {
	return parseInt(u.gcs(node, "height"));
}
Util.eventX = function(event){
	return (event.targetTouches ? event.targetTouches[0].pageX : event.pageX);
}
Util.eventY = function(event){
	return (event.targetTouches ? event.targetTouches[0].pageY : event.pageY);
}
Util.browserWidth = u.browserW = function() {
	return document.documentElement.clientWidth;
}
Util.browserHeight = u.browserH = function() {
	return document.documentElement.clientHeight;
}
Util.htmlWidth = u.htmlW = function() {
	return document.body.offsetWidth + parseInt(u.gcs(document.body, "margin-left")) + parseInt(u.gcs(document.body, "margin-right"));
}
Util.htmlHeight = u.htmlH = function() {
	return document.body.offsetHeight + parseInt(u.gcs(document.body, "margin-top")) + parseInt(u.gcs(document.body, "margin-bottom"));
}
Util.pageScrollX = u.scrollX = function() {
	return window.pageXOffset;
}
Util.pageScrollY = u.scrollY = function() {
	return window.pageYOffset;
}
Util.History = u.h = new function() {
	this.popstate = ("onpopstate" in window);
	this.catchEvent = function(node, callback) {
		this.node = node;
		this.node.callback = callback;
		var hashChanged = function(event) {
			if(!location.hash || !location.hash.match(/^#\//)) {
				location.hash = "#/"
				return;
			}
			var url = u.h.getCleanHash(location.hash);
			u.h.node.callback(url);
		}
		var urlChanged = function(event) {
			var url = u.h.getCleanUrl(location.href);
			u.h.node.callback(url);
		}
		if(this.popstate) {
			window.onpopstate = urlChanged;
		}
		else if("onhashchange" in window && !u.browser("explorer", "<=7")) {
			window.onhashchange = hashChanged;
		}
		else {
			u.current_hash = window.location.hash;
			window.onhashchange = hashChanged;
			setInterval(
				function() {
					if(window.location.hash !== u.current_hash) {
						u.current_hash = window.location.hash;
						window.onhashchange();
					}
				}, 200
			);
		}
	}
	this.getCleanUrl = function(string, levels) {
		string = string.replace(location.protocol+"//"+document.domain, "").match(/[^#$]+/)[0];
		if(!levels) {
			return string;
		}
		else {
			var i, return_string = "";
			var path = string.split("/");
			levels = levels > path.length-1 ? path.length-1 : levels;
			for(i = 1; i <= levels; i++) {
				return_string += "/" + path[i];
			}
			return return_string;
		}
	}
	this.getCleanHash = function(string, levels) {
		string = string.replace("#", "");
		if(!levels) {
			return string;
		}
		else {
			var i, return_string = "";
			var hash = string.split("/");
			levels = levels > hash.length-1 ? hash.length-1 : levels;
			for(i = 1; i <= levels; i++) {
				return_string += "/" + hash[i];
			}
			return return_string;
		}
	}
}
Util.Objects = u.o = new Object();
Util.init = function(scope) {
	var i, node, nodes, object;
	scope = scope && scope.nodeName ? scope : document;
	nodes = u.ges("i\:([_a-zA-Z0-9])+");
	for(i = 0; node = nodes[i]; i++) {
		while((object = u.cv(node, "i"))) {
			u.rc(node, "i:"+object);
			if(object && typeof(u.o[object]) == "object") {
				u.o[object].init(node);
			}
		}
	}
}
Util.random = function(min, max) {
	return Math.round((Math.random() * (max - min)) + min);
}
Util.numToHex = function(num) {
	return num.toString(16);
}
Util.hexToNum = function(hex) {
	return parseInt(hex,16);
}
Util.round = function(number, decimals) {
	var round_number = number*Math.pow(10, decimals);
	return Math.round(round_number)/Math.pow(10, decimals);
}
u.navigation = function(options) {
	page._nav_path = page._nav_path ? page._nav_path : u.h.getCleanUrl(location.href);
	page._nav_history = page._nav_history ? page._nav_history : [];
	page._navigate = function(url) {
		url = u.h.getCleanUrl(url);
		page._nav_history.unshift(url);
		u.stats.pageView(url);
		if(!this._nav_path || ((this._nav_path != u.h.getCleanHash(location.hash, 1) && !u.h.popstate) || (this._nav_path != u.h.getCleanUrl(location.href, 1) && u.h.popstate))) {
			if(this.cN && typeof(this.cN.navigate) == "function") {
				this.cN.navigate(url);
			}
		}
		else {
			if(this.cN.scene && this.cN.scene.parentNode && typeof(this.cN.scene.navigate) == "function") {
				this.cN.scene.navigate(url);
			}
			else if(this.cN && typeof(this.cN.navigate) == "function") {
				this.cN.navigate(url);
			}
		}
		if(!u.h.popstate) {
			this._nav_path = u.h.getCleanHash(location.hash, 1);
		}
		else {
			this._nav_path = u.h.getCleanUrl(location.href, 1);
		}
	}
	page.navigate = function(url, node) {
		this.history_node = node ? node : false;
		if(u.h.popstate) {
			history.pushState({}, url, url);
			page._navigate(url);
		}
		else {
			location.hash = u.h.getCleanUrl(url);
		}
	}
	if(location.hash.length && location.hash.match(/^#!/)) {
		location.hash = location.hash.replace(/!/, "");
	}
	if(!u.h.popstate) {
		if(location.hash.length < 2) {
			page.navigate(location.href, page);
			page._nav_path = u.h.getCleanUrl(location.href);
			u.init(page.cN);
		}
		else if(u.h.getCleanHash(location.hash) != u.h.getCleanUrl(location.href) && location.hash.match(/^#\//)) {
			page._nav_path = u.h.getCleanUrl(location.href);
			page._navigate();
		}
		else {
			u.init(page.cN);
		}
	}
	else {
		if(u.h.getCleanHash(location.hash) != u.h.getCleanUrl(location.href) && location.hash.match(/^#\//)) {
			page._nav_path = u.h.getCleanHash(location.hash);
			page.navigate(u.h.getCleanHash(location.hash), page);
		}
		else {
			u.init(page.cN);
		}
	}
	page._initHistory = function() {
		u.h.catchEvent(page, page._navigate);
	}
	u.t.setTimer(page, page._initHistory, 100);
	page.historyBack = function() {
		if(this._nav_history.length > 1) {
			this._nav_history.shift();
			return this._nav_history.shift();
		}
		else {
			return "/";
		}
	}
}
Util.period = function(format, time) {
	var seconds = 0;
	if(typeof(time) == "object") {
		var argument;
		for(argument in time) {
			switch(argument) {
				case "seconds"		: seconds = time[argument]; break;
				case "milliseconds" : seconds = Number(time[argument])/1000; break;
				case "minutes"		: seconds = Number(time[argument])*60; break;
				case "hours"		: seconds = Number(time[argument])*60*60 ; break;
				case "days"			: seconds = Number(time[argument])*60*60*24; break;
				case "months"		: seconds = Number(time[argument])*60*60*24*(365/12); break;
				case "years"		: seconds = Number(time[argument])*60*60*24*365; break;
			}
		}
	}
	var tokens = /y|n|o|O|w|W|c|d|e|D|g|h|H|l|m|M|r|s|S|t|T|u|U/g;
	var chars = new Object();
	chars.y = 0; 
	chars.n = 0; 
	chars.o = (chars.n > 9 ? "" : "0") + chars.n; 
	chars.O = 0; 
	chars.w = 0; 
	chars.W = 0; 
	chars.c = 0; 
	chars.d = 0; 
	chars.e = 0; 
	chars.D = Math.floor(((seconds/60)/60)/24);
	chars.g = Math.floor((seconds/60)/60)%24;
	chars.h = (chars.g > 9 ? "" : "0") + chars.g;
	chars.H = Math.floor((seconds/60)/60);
	chars.l = Math.floor(seconds/60)%60;
	chars.m = (chars.l > 9 ? "" : "0") + chars.l;
	chars.M = Math.floor(seconds/60);
	chars.r = Math.floor(seconds)%60;
	chars.s = (chars.r > 9 ? "" : "0") + chars.r;
	chars.S = Math.floor(seconds);
	chars.t = Math.round((seconds%1)*10);
	chars.T = Math.round((seconds%1)*100);
	chars.T = (chars.T > 9 ? "": "0") + Math.round(chars.T);
	chars.u = Math.round((seconds%1)*1000);
	chars.u = (chars.u > 9 ? chars.u > 99 ? "" : "0" : "00") + Math.round(chars.u);
	chars.U = Math.round(seconds*1000);
	return format.replace(tokens, function (_) {
		return _ in chars ? chars[_] : _.slice(1, _.length - 1);
	});
};
Util.popup = function(url, settings) {
	var width = "330";
	var height = "150";
	var name = "popup" + new Date().getHours() + "_" + new Date().getMinutes() + "_" + new Date().getMilliseconds();
	var extra = "";
	if(typeof(settings) == "object") {
		var argument;
		for(argument in settings) {
			switch(argument) {
				case "name"		: name		= settings[argument]; break;
				case "width"	: width		= Number(settings[argument]); break;
				case "height"	: height	= Number(settings[argument]); break;
				case "extra"	: extra		= settings[argument]; break;
			}
		}
	}
	var p;
	p = "width=" + width + ",height=" + height;
	p += ",left=" + (screen.width-width)/2;
	p += ",top=" + ((screen.height-height)-20)/2;
	p += extra ? "," + extra : ",scrollbars";
	document[name] = window.open(url, name, p);
	return document[name];
}
u.preloader = function(node, files, options) {
	var callback, callback_min_delay
	if(typeof(options) == "object") {
		var argument;
		for(argument in options) {
			switch(argument) {
				case "callback"				: callback				= options[argument]; break;
				case "callback_min_delay"	: callback_min_delay	= options[argument]; break;
			}
		}
	}
	if(!u._preloader_queue) {
		u._preloader_queue = document.createElement("div");
		u._preloader_processes = 0;
		if(u.e && u.e.event_pref == "touch") {
			u._preloader_max_processes = 1;
		}
		else {
			u._preloader_max_processes = 1;
		}
	}
	if(node && files) {
		var entry, file;
		var new_queue = u.ae(u._preloader_queue, "ul");
		new_queue._callback = callback;
		new_queue._node = node;
		new_queue._files = files;
		new_queue.nodes = new Array();
		new_queue._start_time = new Date().getTime();
		for(i = 0; file = files[i]; i++) {
			entry = u.ae(new_queue, "li", {"class":"waiting"});
			entry.i = i;
			entry._queue = new_queue
			entry._file = file;
		}
		u.ac(node, "waiting");
		if(typeof(node.waiting) == "function") {
			node.waiting();
		}
	}
	u._queueLoader();
	return u._preloader_queue;
}
u._queueLoader = function() {
	if(u.qs("li.waiting", u._preloader_queue)) {
		while(u._preloader_processes < u._preloader_max_processes) {
			var next = u.qs("li.waiting", u._preloader_queue);
			if(next) {
				if(u.hc(next._queue._node, "waiting")) {
					u.rc(next._queue._node, "waiting");
					u.ac(next._queue._node, "loading");
					if(typeof(next._queue._node.loading) == "function") {
						next._node._queue.loading();
					}
				}
				u._preloader_processes++;
				u.rc(next, "waiting");
				u.ac(next, "loading");
				next.loaded = function(event) {
					this.image = event.target;
					this._image = this.image;
					this._queue.nodes[this.i] = this;
					u.rc(this, "loading");
					u.ac(this, "loaded");
					u._preloader_processes--;
					if(!u.qs("li.waiting,li.loading", this._queue)) {
						u.rc(this._queue._node, "loading");
						if(typeof(this._queue._callback) == "function") {
							this._queue._node._callback = this._queue._callback;
							this._queue._node._callback(this._queue.nodes);
						}
						else if(typeof(this._queue._node.loaded) == "function") {
							this._queue._node.loaded(this._queue.nodes);
						}
					}
					u._queueLoader();
				}
				u.loadImage(next, next._file);
			}
			else {
				break
			}
		}
	}
}
u.loadImage = function(node, src) {
	var image = new Image();
	image.node = node;
	u.ac(node, "loading");
    u.e.addEvent(image, 'load', u._imageLoaded);
	u.e.addEvent(image, 'error', u._imageLoadError);
	image.src = src;
}
u._imageLoaded = function(event) {
	u.rc(this.node, "loading");
	if(typeof(this.node.loaded) == "function") {
		this.node.loaded(event);
	}
}
u._imageLoadError = function(event) {
	u.rc(this.node, "loading");
	u.ac(this.node, "error");
	if(typeof(this.node.loaded) == "function" && typeof(this.node.failed) != "function") {
		this.node.loaded(event);
	}
	else if(typeof(this.node.failed) == "function") {
		this.node.failed(event);
	}
}
u._imageLoadProgress = function(event) {
	u.bug("progress")
	if(typeof(this.node.progress) == "function") {
		this.node.progress(event);
	}
}
u._imageLoadDebug = function(event) {
	u.bug("event:" + event.type);
	u.xInObject(event);
}
Util.createRequestObject = u.createRequestObject = function() {
	return new XMLHttpRequest();
}
Util.request = u.request = function(node, url, settings) {
	var request_id = u.randomString(6);
	node[request_id] = {};
	node[request_id].request_url = url;
	node[request_id].request_method = "GET";
	node[request_id].request_async = true;
	node[request_id].request_params = "";
	node[request_id].request_headers = false;
	node[request_id].response_callback = "response";
	if(typeof(settings) == "object") {
		var argument;
		for(argument in settings) {
			switch(argument) {
				case "method"		: node[request_id].request_method		= settings[argument]; break;
				case "params"		: node[request_id].request_params		= settings[argument]; break;
				case "async"		: node[request_id].request_async		= settings[argument]; break;
				case "headers"		: node[request_id].request_headers		= settings[argument]; break;
				case "callback"		: node[request_id].response_callback	= settings[argument]; break;
			}
		}
	}
	if(node[request_id].request_method.match(/GET|POST|PUT|PATCH/i)) {
		node[request_id].HTTPRequest = this.createRequestObject();
		node[request_id].HTTPRequest.node = node;
		node[request_id].HTTPRequest.request_id = request_id;
		if(node[request_id].request_async) {
			node[request_id].HTTPRequest.onreadystatechange = function() {
				if(this.readyState == 4) {
					u.validateResponse(this);
				}
			}
		}
		try {
			if(node[request_id].request_method.match(/GET/i)) {
				var params = u.JSONtoParams(node[request_id].request_params);
				node[request_id].request_url += params ? ((!node[request_id].request_url.match(/\?/g) ? "?" : "&") + params) : "";
				node[request_id].HTTPRequest.open(node[request_id].request_method, node[request_id].request_url, node[request_id].request_async);
				node[request_id].HTTPRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				var csfr_field = u.qs('meta[name="csrf-token"]');
				if(csfr_field && csfr_field.content) {
					node[request_id].HTTPRequest.setRequestHeader("X-CSRF-Token", csfr_field.content);
				}
				if(typeof(node[request_id].request_headers) == "object") {
					var header;
					for(header in node[request_id].request_headers) {
						node[request_id].HTTPRequest.setRequestHeader(header, node[request_id].request_headers[header]);
					}
				}
				node[request_id].HTTPRequest.send("");
			}
			else if(node[request_id].request_method.match(/POST|PUT|PATCH/i)) {
				var params;
				if(typeof(node[request_id].request_params) == "object" && !node[request_id].request_params.constructor.toString().match(/FormData/i)) {
					params = JSON.stringify(node[request_id].request_params);
				}
				else {
					params = node[request_id].request_params;
				}
				node[request_id].HTTPRequest.open(node[request_id].request_method, node[request_id].request_url, node[request_id].request_async);
				node[request_id].HTTPRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				var csfr_field = u.qs('meta[name="csrf-token"]');
				if(csfr_field && csfr_field.content) {
					node[request_id].HTTPRequest.setRequestHeader("X-CSRF-Token", csfr_field.content);
				}
				if(typeof(node[request_id].request_headers) == "object") {
					var header;
					for(header in node[request_id].request_headers) {
						node[request_id].HTTPRequest.setRequestHeader(header, node[request_id].request_headers[header]);
					}
				}
				node[request_id].HTTPRequest.send(params);
			}
		}
		catch(exception) {
			node[request_id].HTTPRequest.exception = exception;
			u.validateResponse(node[request_id].HTTPRequest);
			return;
		}
		if(!node[request_id].request_async) {
			u.validateResponse(node[request_id].HTTPRequest);
		}
	}
	else if(node[request_id].request_method.match(/SCRIPT/i)) {
		var key = u.randomString();
		document[key] = new Object();
		document[key].node = node;
		document[key].request_id = request_id;
		document[key].responder = function(response) {
			var response_object = new Object();
			response_object.node = this.node;
			response_object.request_id = this.request_id;
			response_object.responseText = response;
			u.validateResponse(response_object);
		}
		var params = u.JSONtoParams(node[request_id].request_params);
		node[request_id].request_url += params ? ((!node[request_id].request_url.match(/\?/g) ? "?" : "&") + params) : "";
		node[request_id].request_url += (!node[request_id].request_url.match(/\?/g) ? "?" : "&") + "callback=document."+key+".responder";
		u.ae(u.qs("head"), "script", ({"type":"text/javascript", "src":node[request_id].request_url}));
	}
	return request_id;
}
Util.JSONtoParams = function(json) {
	if(typeof(json) == "object") {
		var params = "", param;
		for(param in json) {
			params += (params ? "&" : "") + param + "=" + json[param];
		}
		return params
	}
	var object = u.isStringJSON(json);
	if(object) {
		return u.JSONtoParams(object);
	}
	return json;
}
Util.isStringJSON = function(string) {
	if(string.trim().substr(0, 1).match(/[\{\[]/i) && string.trim().substr(-1, 1).match(/[\}\]]/i)) {
		try {
			var test = JSON.parse(string);
			if(typeof(test) == "object") {
				test.isJSON = true;
				return test;
			}
		}
		catch(exception) {}
	}
	return false;
}
Util.isStringHTML = function(string) {
	if(string.trim().substr(0, 1).match(/[\<]/i) && string.trim().substr(-1, 1).match(/[\>]/i)) {
		try {
			var test = document.createElement("div");
			test.innerHTML = string;
			if(test.childNodes.length) {
				var body_class = string.match(/<body class="([a-z0-9A-Z_: ]+)"/);
				test.body_class = body_class ? body_class[1] : "";
				var head_title = string.match(/<title>([^$]+)<\/title>/);
				test.head_title = head_title ? head_title[1] : "";
				test.isHTML = true;
				return test;
			}
		}
		catch(exception) {}
	}
	return false;
}
Util.evaluateResponseText = function(responseText) {
	var object;
	if(typeof(responseText) == "object") {
		responseText.isJSON = true;
		return responseText;
	}
	else {
		var response_string;
		if(responseText.trim().substr(0, 1).match(/[\"\']/i) && responseText.trim().substr(-1, 1).match(/[\"\']/i)) {
			response_string = responseText.trim().substr(1, responseText.trim().length-2);
		}
		else {
			response_string = responseText;
		}
		var json = u.isStringJSON(response_string);
		if(json) {
			return json;
		}
		var html = u.isStringHTML(response_string);
		if(html) {
			return html;
		}
		return responseText;
	}
}
Util.validateResponse = function(response){
	var object = false;
	if(response) {
		try {
			if(response.status && !response.status.toString().match(/403|404|500/)) {
				object = u.evaluateResponseText(response.responseText);
			}
			else if(response.responseText) {
				object = u.evaluateResponseText(response.responseText);
			}
		}
		catch(exception) {
			response.exception = exception;
		}
	}
	if(object) {
		if(typeof(response.node[response.node[response.request_id].response_callback]) == "function") {
			response.node[response.node[response.request_id].response_callback](object, response.request_id);
		}
	}
	else {
		if(typeof(response.node.ResponseError) == "function") {
			response.node.ResponseError(response);
		}
		if(typeof(response.node.responseError) == "function") {
			response.node.responseError(response);
		}
	}
}
Util.cutString = function(string, length) {
	var matches, match, i;
	if(string.length <= length) {
		return string;
	}
	else {
		length = length-3;
	}
	matches = string.match(/\&[\w\d]+\;/g);
	if(matches) {
		for(i = 0; match = matches[i]; i++){
			if(string.indexOf(match) < length){
				length += match.length-1;
			}
		}
	}
	return string.substring(0, length) + (string.length > length ? "..." : "");
}
Util.prefix = function(string, length, prefix) {
	string = string.toString();
	prefix = prefix ? prefix : "0";
	while(string.length < length) {
		string = prefix + string;
	}
	return string;
}
Util.randomString = function(length) {
	var key = "", i;
	length = length ? length : 8;
	var pattern = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ".split('');
	for(i = 0; i < length; i++) {
		key += pattern[u.random(0,35)];
	}
	return key;
}
Util.uuid = function() {
	var chars = '0123456789abcdef'.split('');
	var uuid = [], rnd = Math.random, r, i;
	uuid[8] = uuid[13] = uuid[18] = uuid[23] = '-';
	uuid[14] = '4';
	for(i = 0; i < 36; i++) {
		if(!uuid[i]) {
			r = 0 | rnd()*16;
			uuid[i] = chars[(i == 19) ? (r & 0x3) | 0x8 : r & 0xf];
		}
 	}
	return uuid.join('');
}
Util.stringOr = u.eitherOr = function(value, replacement) {
	if(value !== undefined && value !== null) {
		return value;
	}
	else {
		return replacement ? replacement : "";
	}	
}
Util.browser = function(model, version) {
	var current_version = false;
	if(model.match(/\bexplorer\b|\bie\b/i)) {
		if(window.ActiveXObject && navigator.userAgent.match(/(MSIE )(\d+.\d)/i)) {
			current_version = navigator.userAgent.match(/(MSIE )(\d+.\d)/i)[2];
		}
		else if(navigator.userAgent.match(/Trident\/[\d+]\.\d[^$]+rv:(\d+.\d)/i)) {
			current_version = navigator.userAgent.match(/Trident\/[\d+]\.\d[^$]+rv:(\d+.\d)/i)[1];
		}
	}
	else if(model.match(/\bfirefox\b|\bgecko\b/i)) {
		if(window.navigator.mozIsLocallyAvailable) {
			current_version = navigator.userAgent.match(/(Firefox\/)(\d+\.\d+)/i)[2];
		}
	}
	else if(model.match(/\bwebkit\b/i)) {
		if(document.body.style.webkitTransform != undefined) {
			current_version = navigator.userAgent.match(/(AppleWebKit\/)(\d+.\d)/i)[2];
		}
	}
	else if(model.match(/\bchrome\b/i)) {
		if(window.chrome && document.body.style.webkitTransform != undefined) {
			current_version = navigator.userAgent.match(/(Chrome\/)(\d+)(.\d)/i)[2];
		}
	}
	else if(model.match(/\bsafari\b/i)) {
		if(!window.chrome && document.body.style.webkitTransform != undefined) {
			current_version = navigator.userAgent.match(/(Version\/)(\d+)(.\d)/i)[2];
		}
	}
	else if(model.match(/\bopera\b/i)) {
		if(window.opera) {
			if(navigator.userAgent.match(/Version\//)) {
				current_version = navigator.userAgent.match(/(Version\/)(\d+)(.\d)/i)[2];
			}
			else {
				current_version = navigator.userAgent.match(/(Opera[\/ ]{1})(\d+)(.\d)/i)[2];
			}
		}
	}
	if(current_version) {
		if(!version) {
			return current_version;
		}
		else {
			if(!isNaN(version)) {
				return current_version == version;
			}
			else {
				return eval(current_version + version);
			}
		}
	}
	else {
		return false;
	}
}
Util.segment = function(segment) {
	if(!u.current_segment) {
		var scripts = document.getElementsByTagName("script");
		var script, i, src;
		for(i = 0; script = scripts[i]; i++) {
			seg_src = script.src.match(/\/seg_([a-z_]+)/);
			if(seg_src) {
				u.current_segment = seg_src[1];
			}
		}
	}
	if(segment) {
		return segment == u.current_segment;
	}
	return u.current_segment;
}
Util.system = function(os, version) {
}
Util.support = function(property) {
	if(document.documentElement) {
		property = property.replace(/(-\w)/g, function(word){return word.replace(/-/, "").toUpperCase()});
		return property in document.documentElement.style;
	}
	return false;
}
Util.windows = function() {
	return (navigator.userAgent.indexOf("Windows") >= 0) ? true : false;
}
Util.osx = function() {
	return (navigator.userAgent.indexOf("OS X") >= 0) ? true : false;
}
Util.Timer = u.t = new function() {
	this._timers = new Array();
	this.setTimer = function(node, action, timeout) {
		var id = this._timers.length;
		this._timers[id] = {"_a":action, "_n":node, "_t":setTimeout("u.t._executeTimer("+id+")", timeout)};
		return id;
	}
	this.resetTimer = function(id) {
		if(this._timers[id]) {
			clearTimeout(this._timers[id]._t);
			this._timers[id] = false;
		}
	}
	this._executeTimer = function(id) {
		var node = this._timers[id]._n;
		node._timer_action = this._timers[id]._a;
		node._timer_action();
		node._timer_action = null;
		this._timers[id] = false;
	}
	this.setInterval = function(node, action, interval) {
		var id = this._timers.length;
		this._timers[id] = {"_a":action, "_n":node, "_i":setInterval("u.t._executeInterval("+id+")", interval)};
		return id;
	}
	this.resetInterval = function(id) {
		if(this._timers[id]) {
			clearInterval(this._timers[id]._i);
			this._timers[id] = false;
		}
	}
	this._executeInterval = function(id) {
		var node = this._timers[id]._n;
		node._interval_action = this._timers[id]._a;
		node._interval_action();
		node._timer_action = null;
	}
	this.valid = function(id) {
		return this._timers[id] ? true : false;
	}
	this.resetAllTimers = function() {
		var i, t;
		for(i = 0; i < this._timers.length; i++) {
			if(this._timers[i] && this._timers[i]._t) {
				this.resetTimer(i);
			}
		}
	}
	this.resetAllIntervals = function() {
		var i, t;
		for(i = 0; i < this._timers.length; i++) {
			if(this._timers[i] && this._timers[i]._i) {
				this.resetInterval(i);
			}
		}
	}
}
Util.getVar = function(param, url) {
	var string = url ? url.split("#")[0] : location.search;
	var regexp = new RegExp("[\&\?\b]{1}"+param+"\=([^\&\b]+)");
	var match = string.match(regexp);
	if(match && match.length > 1) {
		return match[1];
	}
	else {
		return "";
	}
}
u.a.transition = function(node, transition) {
	var duration = transition.match(/[0-9.]+[ms]+/g);
	if(duration) {
		node.duration = duration[0].match("ms") ? parseFloat(duration[0]) : (parseFloat(duration[0]) * 1000);
	}
	else {
		node.duration = false;
		if(transition.match(/none/i)) {
			node.transitioned = null;
		}
	}
	if(u.support(this.variant()+"Transition")) {
		node.style[this.variant()+"Transition"] = "none";
	}
}
u.a.translate = function(node, x, y) {
	var update_frequency = 25;
	node._x = node._x ? node._x : 0;
	node._y = node._y ? node._y : 0;
	if(node.duration && (node._x != x || node._y != y)) {
		node.x_start = node._x;
		node.y_start = node._y;
		node.translate_transitions = node.duration/update_frequency;
		node.translate_progress = 0;
		node.x_change = (x - node.x_start) / node.translate_transitions;
		node.y_change = (y - node.y_start) / node.translate_transitions;
		node.translate_transitionTo = function(event) {
			++this.translate_progress;
			var new_x = (Number(this.x_start) + Number(this.translate_progress * this.x_change));
			var new_y = (Number(this.y_start) + Number(this.translate_progress * this.y_change));
			this.style["msTransform"] = "translate("+ new_x + "px, " + new_y +"px)";
			this.offsetHeight;
			if(this.translate_progress < this.translate_transitions) {
				this.t_translate_transition = u.t.setTimer(this, this.translate_transitionTo, update_frequency);
			}
			else {
				this.style["msTransform"] = "translate("+ this._x + "px, " + this._y +"px)";
				if(typeof(this.transitioned) == "function") {
					this.transitioned(event);
				}
			}
		}
		node.translate_transitionTo();
	}
	else {
		node.style["msTransform"] = "translate("+ x + "px, " + y +"px)";
	}
	node._x = x;
	node._y = y;
	node.offsetHeight;
}
u.a.rotate = function(node, deg) {
	var update_frequency = 25;
	node._rotation = node._rotation ? node._rotation : 0;
	if(node.duration && node._rotation != deg) {
		node.rotate_start = node._rotation;
		node.rotate_transitions = node.duration/update_frequency;
		node.rotate_progress = 0;
		node.rotate_change = (deg - node.rotate_start) / node.rotate_transitions;
		node.rotate_transitionTo = function(event) {
			++this.rotate_progress;
			var new_deg = (Number(this.rotate_start) + Number(this.rotate_progress * this.rotate_change));
			this.style["msTransform"] = "rotate("+ new_deg + "deg)";
			this.offsetHeight;
			if(this.rotate_progress < this.rotate_transitions) {
				this.t_rotate_transition = u.t.setTimer(this, this.rotate_transitionTo, update_frequency);
			}
			else {
				this.style["msTransform"] = "rotate("+ this._rotation + "deg)";
				if(typeof(this.transitioned) == "function") {
					this.transitioned(event);
				}
			}
		}
		node.rotate_transitionTo();
	}
	else {
		node.style["msTransform"] = "rotate("+ deg + "deg)";
	}
	node._rotation = deg;
	node.offsetHeight;
}
u.a.scale = function(node, scale) {
	var update_frequency = 25;
	node._scale = node._scale ? node._scale : 0;
	if(node.duration && node._scale != scale) {
		node.scale_start = node._scale;
		node.scale_transitions = node.duration/update_frequency;
		node.scale_progress = 0;
		node.scale_change = (scale - node.scale_start) / node.scale_transitions;
		node.scale_transitionTo = function(event) {
			++this.scale_progress;
			var new_scale = (Number(this.scale_start) + Number(this.scale_progress * this.scale_change));
			this.style["msTransform"] = "scale("+ new_scale +")";
			this.offsetHeight;
			if(this.scale_progress < this.scale_transitions) {
				this.t_scale_transition = u.t.setTimer(this, this.scale_transitionTo, update_frequency);
			}
			else {
				this.style["msTransform"] = "scale("+ this._scale +")";
				if(typeof(this.transitioned) == "function") {
					this.transitioned(event);
				}
			}
		}
		node.scale_transitionTo();
	}
	else {
		node.style["msTransform"] = "scale("+ scale +")";
	}
	node._scale = scale;
	node.offsetHeight;
}
u.a.setOpacity = function(node, opacity) {
	var update_frequency = 25;
	node._opacity = node._opacity ? node._opacity : u.gcs(node, "opacity");
	if(node.duration && node._opacity != opacity) {
		node.opacity_start = node._opacity;
		node.opacity_transitions = node.duration/update_frequency;
		node.opacity_change = (opacity - node.opacity_start) / node.opacity_transitions;
		node.opacity_progress = 0;
		node.opacity_transitionTo = function(event) {
			++this.opacity_progress;
			var new_opacity = (Number(this.opacity_start) + Number(this.opacity_progress * this.opacity_change));
			u.as(this, "opacity", new_opacity);
			this.offsetHeight;
			if(this.opacity_progress < this.opacity_transitions) {
				this.t_opacity_transition = u.t.setTimer(this, this.opacity_transitionTo, update_frequency);
			}
			else {
				this.style.opacity = this._opacity;
				if(typeof(this.transitioned) == "function") {
					this.transitioned(event);
				}
			}
		}
		node.opacity_transitionTo();
	}
	else {
		node.style.opacity = opacity;
	}
	node._opacity = opacity;
	node.offsetHeight;
}
u.a.setWidth = function(node, width) {
	var update_frequency = 25;
	node._width = node._width ? node._width : u.gcs(node, "width").match("px") ? u.gcs(node, "width").replace("px", "") : 0;
	if(node.duration && node._width != width) {
		node.width_start = node._width;
		node.width_transitions = node.duration/update_frequency;
		node.width_change = (width - node.width_start) / node.width_transitions;
		node.width_progress = 0;
		node.width_transitionTo = function(event) {
			++this.width_progress;
			var new_width = (Number(this.width_start) + Number(this.width_progress * this.width_change));
			u.as(this, "width", new_width+"px");
			this.offsetHeight;
			if(this.width_progress < this.width_transitions) {
				this.t_width_transition = u.t.setTimer(this, this.width_transitionTo, update_frequency);
			}
			else {
				u.as(this, "width", this._width);
				if(typeof(this.transitioned) == "function") {
					this.transitioned(event);
				}
			}
		}
		node.width_transitionTo();
	}
	else {
		var new_width = width.toString().match(/\%|auto/) ? width : width + "px";
		u.as(node, "width", new_width);
	}
	node._width = width;
	node.offsetHeight;
}
u.a.setHeight = function(node, height) {
	var update_frequency = 25;
	node._height = node._height ? node._height : u.gcs(node, "height").match("px") ? u.gcs(node, "height").replace("px", "") : 0;
	if(node.duration && node._height != height) {
		node.height_start = node._height;
		node.height_transitions = node.duration/update_frequency;
		node.height_change = (height - node.height_start) / node.height_transitions;
		node.height_progress = 0;
		node.height_transitionTo = function(event) {
			++this.height_progress;
			var new_height = (Number(this.height_start) + Number(this.height_progress * this.height_change));
			u.as(this, "height", new_height+"px");
			this.offsetHeight;
			if(this.height_progress < this.height_transitions) {
				this.t_height_transition = u.t.setTimer(this, this.height_transitionTo, update_frequency);
			}
			else {
				u.as(this, "height", this._height);
				if(typeof(this.transitioned) == "function") {
					this.transitioned(event);
				}
			}
		}
		node.height_transitionTo();
	}
	else {
		var new_height = height.toString().match(/\%|auto/) ? height : height + "px";
		u.as(node, "height", new_height);
	}
	node._height = height;
	node.offsetHeight;
}
u.a.setBgPos = function(node, x, y) {
	var update_frequency = 25;
	var current_bg_x = u.gcs(node, "background-position-x");
	var current_bg_y = u.gcs(node, "background-position-y");
	node._bg_x = node._bg_x ? node._bg_x : current_bg_x.match("px") ? current_bg_x.replace("px", "") : x;
	node._bg_y = node._bg_y ? node._bg_y : current_bg_y.match("px") ? current_bg_y.replace("px", "") : y;
	if(node.duration && (node._bg_x != x || node._bg_y != y)) {
		node._bg_same_x = false;
		node._bg_same_y = false;
		node.bg_transitions = node.duration/update_frequency;
		if(node._bg_x != x) {
			node.bg_start_x = node._bg_x;
			node.bg_change_x = (x - node.bg_start_x) / node.bg_transitions;
		}
		else {
			node._bg_same_x = true;
		}
		if(node._bg_y != y) {
			node.bg_start_y = node._bg_y;
			node.bg_change_y = (y - node.bg_start_y) / node.bg_transitions;
		}
		else {
			node._bg_same_y = true;
		}
		node.bg_progress = 0;
		node.bg_transitionTo = function(event) {
			++this.bg_progress;
			var new_x, new_y;
			if(!this._bg_same_x) {
				new_x = Math.round((Number(this.bg_start_x) + Number(this.bg_progress * this.bg_change_x)));
			}
			else {
				new_x = this._bg_x;
			}
			if(!this._bg_same_y) {
				new_y = Math.round((Number(this.bg_start_y) + Number(this.bg_progress * this.bg_change_y)));
			}
			else {
				new_y = this._bg_y;
			}
			var new_bg_x = new_x.toString().match(/\%|top|left|right|center|bottom/) ? new_x : (new_x + "px");
			var new_bg_y = new_y.toString().match(/\%|top|left|right|center|bottom/) ? new_y : (new_y + "px");
			u.as(this, "backgroundPosition", new_bg_x + " " + new_bg_y);
			this.offsetHeight;
			if(this.bg_progress < this.bg_transitions) {
				this.t_bg_transition = u.t.setTimer(this, this.bg_transitionTo, update_frequency);
			}
			else {
				var new_bg_x = x.toString().match(/\%|top|left|right|center|bottom/) ? this._bg_x : (this._bg_x + "px");
				var new_bg_y = y.toString().match(/\%|top|left|right|center|bottom/) ? this._bg_y : (this._bg_y + "px");
				u.as(this, "backgroundPosition", new_bg_x + " " + new_bg_y);
				if(typeof(this.transitioned) == "function") {
					this.transitioned(event);
				}
			}
		}
		node.bg_transitionTo();
	}
	else {
		var new_bg_x = x.toString().match(/\%|top|left|right|center|bottom/) ? x : (x + "px");
		var new_bg_y = y.toString().match(/\%|top|left|right|center|bottom/) ? y : (y + "px");
		u.as(node, "backgroundPosition", new_bg_x + " " + new_bg_y);
	}
	node._bg_x = x;
	node._bg_y = y;
	node.offsetHeight;
}
u.a.setBgColor = function(node, color) {
	var update_frequency = 100;
	if(isNaN(node._bg_color_r) || isNaN(node._bg_color_g) || isNaN(node._bg_color_b)) {
		var current_bg_color = u.gcs(node, "background-color");
		var matches;
		var current_bg_color_r, current_bg_color_g, current_bg_color_b;
		var new_bg_color_r = false;
		var new_bg_color_g = false;
		var new_bg_color_b = false;
		if(current_bg_color.match(/#[\da-fA-F]{3,6}/)) {
			if(current_bg_color.length == 7) {
				matches = current_bg_color.match(/#([\da-fA-F]{2})([\da-fA-F]{2})([\da-fA-F]{2})/);
			}
			else {
				matches = current_bg_color.match(/#([\da-fA-F]{1}),[ ]?([\da-fA-F]{1}),[ ]?([\da-fA-F]{1})/);
			}
			current_bg_color_r = u.hexToNum(matches[1]);
			current_bg_color_g = u.hexToNum(matches[2]); 
			current_bg_color_b = u.hexToNum(matches[3]);
		}
		else if(current_bg_color.match(/rgb\([\d]{1,3},[ ]?[\d]{1,3},[ ]?[\d]{1,3}\)/)) {
			matches = current_bg_color.match(/rgb\(([\d]{1,3}),[ ]?([\d]{1,3}),[ ]?([\d]{1,3})\)/);
			current_bg_color_r = matches[1];
			current_bg_color_g = matches[2];
			current_bg_color_b = matches[3];
		}
		else if(current_bg_color.match(/rgba\([\d]{1,3},[ ]?[\d]{1,3},[ ]?[\d]{1,3},[ ]?[\d\.]+\)/)) {
			matches = current_bg_color.match(/rgba\(([\d]{1,3}),[ ]?([\d]{1,3}),[ ]?([\d]{1,3}),[ ]?([\d\.]+)\)/);
			current_bg_color_r = matches[1];
			current_bg_color_g = matches[2];
			current_bg_color_b = matches[3];
		}
	}
	if(color.match(/#[\da-fA-F]{3,6}/)) {
		if(color.length == 7) {
			matches = color.match(/#([\da-fA-F]{2})([\da-fA-F]{2})([\da-fA-F]{2})/);
		}
		else {
			matches = color.match(/#([\da-fA-F]{1}),[ ]?([\da-fA-F]{1}),[ ]?([\da-fA-F]{1})/);
		}
		new_bg_color_r = u.hexToNum(matches[1]);
		new_bg_color_g = u.hexToNum(matches[2]);
		new_bg_color_b = u.hexToNum(matches[3]);
	}
	node._bg_color_r = !isNaN(node._bg_color_r) ? node._bg_color_r : !isNaN(current_bg_color_r) ? current_bg_color_r : false;
	node._bg_color_g = !isNaN(node._bg_color_g) ? node._bg_color_g : !isNaN(current_bg_color_g) ? current_bg_color_g : false;
	node._bg_color_b = !isNaN(node._bg_color_b) ? node._bg_color_b : !isNaN(current_bg_color_b) ? current_bg_color_b : false;
	if(node.duration && 
	node._bg_color_r !== false && 
	node._bg_color_g !== false && 
	node._bg_color_b !== false && 
	new_bg_color_r !== false && 
	new_bg_color_g !== false && 
	new_bg_color_b !== false &&
	(new_bg_color_r != node._bg_color_r ||
	new_bg_color_g != node._bg_color_g ||
	new_bg_color_b != node._bg_color_b)) {
		node.bg_color_r_start = node._bg_color_r;
		node.bg_color_g_start = node._bg_color_g;
		node.bg_color_b_start = node._bg_color_b;
		node.bg_color_transitions = node.duration/update_frequency;
		node.bg_color_r_change = (new_bg_color_r - node.bg_color_r_start) / node.bg_color_transitions;
		node.bg_color_g_change = (new_bg_color_g - node.bg_color_g_start) / node.bg_color_transitions;
		node.bg_color_b_change = (new_bg_color_b - node.bg_color_b_start) / node.bg_color_transitions;
		node.bg_color_progress = 0;
		node.bg_color_transitionTo = function(event) {
			++this.bg_color_progress;
			var new_bg_color_r = Math.round(Number(this.bg_color_r_start) + Number(this.bg_color_progress * this.bg_color_r_change));
			var new_bg_color_g = Math.round(Number(this.bg_color_g_start) + Number(this.bg_color_progress * this.bg_color_g_change));
			var new_bg_color_b = Math.round(Number(this.bg_color_b_start) + Number(this.bg_color_progress * this.bg_color_b_change));
			var bg_hex_r = u.prefix(u.numToHex(new_bg_color_r), 2);
			var bg_hex_g = u.prefix(u.numToHex(new_bg_color_g), 2);
			var bg_hex_b = u.prefix(u.numToHex(new_bg_color_b), 2);
			u.as(this, "backgroundColor", "#" + bg_hex_r + bg_hex_g + bg_hex_b);
			this.offsetHeight;
			if(this.bg_color_progress < this.bg_color_transitions) {
				this.t_bg_color_transition = u.t.setTimer(this, this.bg_color_transitionTo, update_frequency);
			}
			else {
				u.as(this, "backgroundColor", this._bg_color);
				if(typeof(this.transitioned) == "function") {
					this.transitioned(event);
				}
			}
		}
		node.bg_color_transitionTo();
	}
	else {
		node.style.backgroundColor = color;
	}
	node._bg_color = color;
	node.offsetHeight;
}
u.a.rotateScale = function(node, deg, scale) {
	node.style[u.a.variant() + "Transform"] = "rotate("+deg+"deg) scale("+scale+")";
	node._rotation = deg;
	node._scale = scale;
	node.offsetHeight;
}
u.a.scaleRotateTranslate = function(node, scale, deg, x, y) {
	node.style[u.a.variant() + "Transform"] = "scale("+scale+") rotate("+deg+"deg) translate("+x+"px, "+y+"px)";
	node._rotation = deg;
	node._scale = scale;
	node._x = x;
	node._y = y;
	node.offsetHeight;
}


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


/*u-form.js*/
Util.Form = u.f = new function() {
	this.customInit = {};
	this.customValidate = {};
	this.customSend = {};
	this.init = function(form, _options) {
		var i, j, field, action, input, hidden_field;
		form._focus_z_index = 50;
		form._validation = true;
		form._debug_init = false;
		if(typeof(_options) == "object") {
			var _argument;
			for(_argument in _options) {
				switch(_argument) {
					case "validation"       : form._validation      = _options[_argument]; break;
					case "focus_z"          : form._focus_z_index   = _options[_argument]; break;
					case "debug"            : form._debug_init      = _options[_argument]; break;
				}
			}
		}
		form.onsubmit = function(event) {return false;}
		form.setAttribute("novalidate", "novalidate");
		form.DOMsubmit = form.submit;
		form.submit = this._submit;
		form.fields = {};
		form.actions = {};
		form.labelstyle = u.cv(form, "labelstyle");
		var fields = u.qsa(".field", form);
		for(i = 0; field = fields[i]; i++) {
			field._base_z_index = u.gcs(field, "z-index");
			field._help = u.qs(".help", field);
			field._hint = u.qs(".hint", field);
			field._error = u.qs(".error", field);
			if(typeof(u.f.fixFieldHTML) == "function") {
				u.f.fixFieldHTML(field);
			}
			field._indicator = u.ae(field, "div", {"class":"indicator"});
			field._initialized = false;
			var custom_init;
			for(custom_init in this.customInit) {
				if(field.className.match(custom_init)) {
					this.customInit[custom_init](field);
					field._initialized = true;
				}
			}
			if(!field._initialized) {
				if(u.hc(field, "string|email|tel|number|integer|password|date|datetime")) {
					field._input = u.qs("input", field);
					field._input.field = field;
					form.fields[field._input.name] = field._input;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					field._input.val = this._value;
					u.e.addEvent(field._input, "keyup", this._updated);
					u.e.addEvent(field._input, "change", this._changed);
					this.inputOnEnter(field._input);
					this.activateInput(field._input);
					this.validate(field._input);
				}
				else if(u.hc(field, "text")) {
					field._input = u.qs("textarea", field);
					field._input.field = field;
					form.fields[field._input.name] = field._input;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					field._input.val = this._value;
					if(u.hc(field, "autoexpand")) {
						this.autoExpand(field._input);
					}
					u.e.addEvent(field._input, "keyup", this._updated);
					u.e.addEvent(field._input, "change", this._changed);
					this.activateInput(field._input);
					this.validate(field._input);
				}
				else if(u.hc(field, "html")) {
					field._input = u.qs("textarea", field);
					field._input.field = field;
					form.fields[field._input.name] = field._input;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					field._input.val = this._value;
					this.textEditor(field);
					this.validate(field._input);
				}
				else if(u.hc(field, "select")) {
					field._input = u.qs("select", field);
					field._input.field = field;
					form.fields[field._input.name] = field._input;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					field._input.val = this._value_select;
					u.e.addEvent(field._input, "change", this._updated);
					u.e.addEvent(field._input, "keyup", this._updated);
					u.e.addEvent(field._input, "change", this._changed);
					this.activateInput(field._input);
					this.validate(field._input);
				}
				else if(u.hc(field, "checkbox|boolean")) {
					field._input = u.qs("input[type=checkbox]", field);
					field._input.field = field;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					form.fields[field._input.name] = field._input;
					field._input.val = this._value_checkbox;
					if(u.browser("explorer", "<=8")) {
						field._input.pre_state = field._input.checked;
						field._input._changed = this._changed;
						field._input._updated = this._updated;
						field._input._update_checkbox_field = this._update_checkbox_field;
						field._input._clicked = function(event) {
							if(this.checked != this.pre_state) {
								this._changed(window.event);
								this._updated(window.event);
								this._update_checkbox_field(window.event);
							}
							this.pre_state = this.checked;
						}
						u.e.addEvent(field._input, "click", field._input._clicked);
					}
					else {
						u.e.addEvent(field._input, "change", this._changed);
						u.e.addEvent(field._input, "change", this._updated);
						u.e.addEvent(field._input, "change", this._update_checkbox_field);
					}
					this.inputOnEnter(field._input);
					this.activateInput(field._input);
					this.validate(field._input);
				}
				else if(u.hc(field, "radiobuttons")) {
					field._inputs = u.qsa("input", field);
					field._input = field._inputs[0];
					form.fields[field._input.name] = field._input;
					for(j = 0; input = field._inputs[j]; j++) {
						input.field = field;
						input._label = u.qs("label[for="+input.id+"]", field);
						input.val = this._value_radiobutton;
						if(u.browser("explorer", "<=8")) {
							input.pre_state = input.checked;
							input._changed = this._changed;
							input._updated = this._updated;
							input._clicked = function(event) {
								var i, input;
								if(this.checked != this.pre_state) {
									this._changed(window.event);
									this._updated(window.event);
								}
								for(i = 0; input = this.field._input[i]; i++) {
									input.pre_state = input.checked;
								}
							}
							u.e.addEvent(input, "click", input._clicked);
						}
						else {
							u.e.addEvent(input, "change", this._changed);
							u.e.addEvent(input, "change", this._updated);
						}
						this.inputOnEnter(input);
						this.activateInput(input);
					}
					this.validate(field._input);
				}
				else if(u.hc(field, "files")) {
					field._input = u.qs("input", field);
					field._input.field = field;
					form.fields[field._input.name] = field._input;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					u.e.addEvent(field._input, "change", this._updated);
					u.e.addEvent(field._input, "change", this._changed);
					this.fileUpload(field);
					this.validate(field._input);
				}
				else if(u.hc(field, "location")) {
					field._inputs = u.qsa("input", field);
					field._input = field._inputs[0];
					for(j = 0; input = field._inputs[j]; j++) {
						input.field = field;
						form.fields[input.name] = input;
						input._label = u.qs("label[for="+input.id+"]", field);
						input.val = this._value;
						u.e.addEvent(input, "keyup", this._updated);
						u.e.addEvent(input, "change", this._changed);
						this.inputOnEnter(input);
						this.activateInput(input);
					}
					if(navigator.geolocation) {
						this.geoLocation(field);
					}
					this.validate(field._input);
				}
				else if(u.hc(field, "tags")) {
					field._input = u.qs("input", field);
					field._input.field = field;
					form.fields[field._input.name] = field._input;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					field._input.val = this._value;
					u.e.addEvent(field._input, "keyup", this._updated);
					u.e.addEvent(field._input, "change", this._changed);
					this.inputOnEnter(field._input);
					this.activateInput(field._input);
					this.validate(field._input);
				}
				else if(u.hc(field, "prices")) {
					field._input = u.qs("input", field);
					field._input.field = field;
					form.fields[field._input.name] = field._input;
					field._input._label = u.qs("label[for="+field._input.id+"]", field);
					field._input.val = this._value;
					u.e.addEvent(field._input, "keyup", this._updated);
					u.e.addEvent(field._input, "change", this._changed);
					this.inputOnEnter(field._input);
					this.activateInput(field._input);
					this.validate(field._input);
				}
				else {
					u.bug("UNKNOWN FIELD IN FORM INITIALIZATION:" + u.nodeId(field));
				}
			}
		}
		var hidden_fields = u.qsa("input[type=hidden]", form);
		for(i = 0; hidden_field = hidden_fields[i]; i++) {
			if(!form.fields[hidden_field.name]) {
				form.fields[hidden_field.name] = hidden_field;
				hidden_field.val = this._value;
			}
		}
		var actions = u.qsa(".actions li input[type=button],.actions li input[type=submit],.actions li a.button", form);
		for(i = 0; action = actions[i]; i++) {
			action.form = form;
			this.activateButton(action);
		}
		if(form._debug_init) {
			u.bug(u.nodeId(form) + ", fields:");
			u.xInObject(form.fields);
			u.bug(u.nodeId(form) + ", actions:");
			u.xInObject(form.actions);
		}
	}
	this._submit = function(event, iN) {
		for(name in this.fields) {
			if(this.fields[name].field) {
				this.fields[name].used = true;
				u.f.validate(this.fields[name]);
			}
		}
		if(u.qs(".field.error", this)) {
			if(typeof(this.validationFailed) == "function") {
				this.validationFailed();
			}
		}
		else {
			if(typeof(this.submitted) == "function") {
				this.submitted(iN);
			}
			else {
				this.DOMsubmit();
			}
		}
	}
	this._value = function(value) {
		if(value !== undefined) {
			this.value = value;
			if(value !== this.default_value) {
				u.rc(this, "default");
				if(this.pseudolabel) {
					u.as(this.pseudolabel, "display", "none");
				}
			}
			u.f.validate(this);
		}
		return (this.value != this.default_value) ? this.value : "";
	}
	this._value_radiobutton = function(value) {
		var i, option;
		if(value !== undefined) {
			for(i = 0; option = this.form[this.name][i]; i++) {
				if(option.value == value || (option.value == "true" && value) || (option.value == "false" && value === false)) {
					option.checked = true;
					u.f.validate(this);
				}
			}
		}
		else {
			for(i = 0; option = this.form[this.name][i]; i++) {
				if(option.checked) {
					return option.value;
				}
			}
		}
		return "";
	}
	this._value_checkbox = function(value) {
		if(value !== undefined) {
			if(value) {
				this.checked = true
				u.ac(this.field, "checked");
			}
			else {
				this.checked = false;
				u.rc(this.field, "checked");
			}
			u.f.validate(this);
		}
		else {
			if(this.checked) {
				return this.value;
			}
		}
		return "";
	}
	this._value_select = function(value) {
		if(value !== undefined) {
			var i, option;
			for(i = 0; option = this.options[i]; i++) {
				if(option.value == value) {
					this.selectedIndex = i;
					u.f.validate(this);
					return i;
				}
			}
			return false;
		}
		else {
			return this.default_value != this.options[this.selectedIndex].value ? this.options[this.selectedIndex].value : "";
		}
	}
	this.inputOnEnter = function(node) {
		node.keyPressed = function(event) {
			if(this.nodeName.match(/input/i) && (event.keyCode == 40 || event.keyCode == 38)) {
				this._submit_disabled = true;
			}
			else if(this.nodeName.match(/input/i) && this._submit_disabled && (
				event.keyCode == 46 || 
				(event.keyCode == 39 && u.browser("firefox")) || 
				(event.keyCode == 37 && u.browser("firefox")) || 
				event.keyCode == 27 || 
				event.keyCode == 13 || 
				event.keyCode == 9 ||
				event.keyCode == 8
			)) {
				this._submit_disabled = false;
			}
			else if(event.keyCode == 13 && !this._submit_disabled) {
				u.e.kill(event);
				this.blur();
				this.form.submitInput = this;
				this.form.submitButton = false;
				this.form.submit(event, this);
			}
		}
		u.e.addEvent(node, "keydown", node.keyPressed);
	}
	this.buttonOnEnter = function(node) {
		node.keyPressed = function(event) {
			if(event.keyCode == 13 && !u.hc(this, "disabled")) {
				u.e.kill(event);
				this.form.submit_input = false;
				this.form.submit_button = this;
				this.form.submit(event);
			}
		}
		u.e.addEvent(node, "keydown", node.keyPressed);
	}
	this._changed = function(event) {
		this.used = true;
		if(typeof(this.changed) == "function") {
			this.changed(this);
		}
		else if(this.field._input && typeof(this.field._input.changed) == "function") {
			this.field._input.changed(this);
		}
		if(typeof(this.form.changed) == "function") {
			this.form.changed(this);
		}
	}
	this._updated = function(event) {
		if(event.keyCode != 9 && event.keyCode != 13 && event.keyCode != 16 && event.keyCode != 17 && event.keyCode != 18) {
			if(this.used || u.hc(this.field, "error")) {
				u.f.validate(this);
			}
			if(typeof(this.updated) == "function") {
				this.updated(this);
			}
			else if(this.field._input && typeof(this.field._input.updated) == "function") {
				this.field._input.updated(this);
			}
			if(typeof(this.form.updated) == "function") {
				this.form.updated(this);
			}
		}
	}
	this._update_checkbox_field = function(event) {
		if(this.checked) {
			u.ac(this.field, "checked");
		}
		else {
			u.rc(this.field, "checked");
		}
	}
	this._validate = function(event) {
		u.f.validate(this);
	}
	this._mouseenter = function(event) {
		u.ac(this.field, "hover");
		u.ac(this, "hover");
		u.as(this.field, "zIndex", this.field._input.form._focus_z_index);
		u.f.positionHint(this.field);
	}
	this._mouseleave = function(event) {
		u.rc(this.field, "hover");
		u.rc(this, "hover");
		u.as(this.field, "zIndex", this.field._base_z_index);
		u.f.positionHint(this.field);
	}
	this._focus = function(event) {
		this.field.focused = true;
		this.focused = true;
		u.ac(this.field, "focus");
		u.ac(this, "focus");
		u.as(this.field, "zIndex", this.form._focus_z_index);
		u.f.positionHint(this.field);
		if(typeof(this.focused) == "function") {
			this.focused();
		}
		else if(this.field._input && typeof(this.field._input.focused) == "function") {
			this.field._input.focused(this);
		}
		if(typeof(this.form.focused) == "function") {
			this.form.focused(this);
		}
	}
	this._blur = function(event) {
		this.field.focused = false;
		this.focused = false;
		u.rc(this.field, "focus");
		u.rc(this, "focus");
		u.as(this.field, "zIndex", this.field._base_z_index);
		u.f.positionHint(this.field);
		this.used = true;
		if(typeof(this.blurred) == "function") {
			this.blurred();
		}
		else if(this.field._input && typeof(this.field._input.blurred) == "function") {
			this.field._input.blurred(this);
		}
		if(typeof(this.form.blurred) == "function") {
			this.form.blurred(this);
		}
	}
	this._button_focus = function(event) {
		u.ac(this, "focus");
		if(typeof(this.focused) == "function") {
			this.focused();
		}
		if(typeof(this.form.focused) == "function") {
			this.form.focused(this);
		}
	}
	this._button_blur = function(event) {
		u.rc(this, "focus");
		if(typeof(this.blurred) == "function") {
			this.blurred();
		}
		if(typeof(this.form.blurred) == "function") {
			this.form.blurred(this);
		}
	}
	this._changed_state = function() {
		u.f.updateDefaultState(this);
	}
	this.positionHint = function(field) {
		if(field._help) {
			var f_h =  field.offsetHeight;
			var f_p_t = parseInt(u.gcs(field, "padding-top"));
			var f_p_b = parseInt(u.gcs(field, "padding-bottom"));
			var f_b_t = parseInt(u.gcs(field, "border-top-width"));
			var f_b_b = parseInt(u.gcs(field, "border-bottom-width"));
			var f_h_h = field._help.offsetHeight;
			if(u.hc(field, "html")) {
				var l_h = field._input._label.offsetHeight;
				var help_top = (((f_h - (f_p_t + f_p_b + f_b_b + f_b_t)) / 2)) - (f_h_h / 2) + l_h;
				u.as(field._help, "top", help_top + "px");
			}
			else {
				var help_top = (((f_h - (f_p_t + f_p_b + f_b_b + f_b_t)) / 2) + 2) - (f_h_h / 2)
				u.as(field._help, "top", help_top + "px");
			}
		}
	}
	this.activateInput = function(iN) {
		u.e.addEvent(iN, "focus", this._focus);
		u.e.addEvent(iN, "blur", this._blur);
		if(u.e.event_pref == "mouse") {
			u.e.addEvent(iN, "mouseenter", this._mouseenter);
			u.e.addEvent(iN, "mouseleave", this._mouseleave);
		}
		u.e.addEvent(iN, "blur", this._validate);
		if(iN.form.labelstyle == "inject") {
			if(!iN.type || !iN.type.match(/file|radio|checkbox/)) {
				iN.default_value = u.text(iN._label);
				u.e.addEvent(iN, "focus", this._changed_state);
				u.e.addEvent(iN, "blur", this._changed_state);
				if(iN.type.match(/number|integer/)) {
					iN.pseudolabel = u.ae(iN.parentNode, "span", {"class":"pseudolabel", "html":iN.default_value});
					iN.pseudolabel.iN = iN;
					u.as(iN.pseudolabel, "top", iN.offsetTop+"px");
					u.as(iN.pseudolabel, "left", iN.offsetLeft+"px");
					u.ce(iN.pseudolabel)
					iN.pseudolabel.inputStarted = function(event) {
						u.e.kill(event);
						this.iN.focus();
					}
				}
				u.f.updateDefaultState(iN);
			}
		}
		else {
			iN.default_value = "";
		}
	}
	this.activateButton = function(action) {
		if(action.type && action.type == "submit") {
			action.onclick = function(event) {
				u.e.kill(event ? event : window.event);
			}
		}
		u.ce(action);
		action.clicked = function(event) {
			u.e.kill(event);
			if(!u.hc(this, "disabled")) {
				if(this.type && this.type.match(/submit/i)) {
					this.form._submit_button = this;
					this.form._submit_input = false;
					this.form.submit(event, this);
				}
			}
		}
		this.buttonOnEnter(action);
		var action_name = action.name ? action.name : action.parentNode.className;
		if(action_name) {
			action.form.actions[action_name] = action;
		}
		if(typeof(u.k) == "object" && u.hc(action, "key:[a-z0-9]+")) {
			u.k.addKey(action, u.cv(action, "key"));
		}
		u.e.addEvent(action, "focus", this._button_focus);
		u.e.addEvent(action, "blur", this._button_blur);
	}
	this.updateDefaultState = function(iN) {
		if(iN.focused || iN.val() !== "") {
			u.rc(iN, "default");
			if(iN.val() === "") {
				iN.val("");
			}
			if(iN.pseudolabel) {
				u.as(iN.pseudolabel, "display", "none");
			}
		}
		else {
			if(iN.val() === "") {
				u.ac(iN, "default");
				if(iN.pseudolabel) {
					iN.val(iN.default_value);
					u.as(iN.pseudolabel, "display", "block");
				}
				else {
					iN.val(iN.default_value);
				}
			}
		}
	}
	this.fieldError = function(iN) {
		u.rc(iN, "correct");
		u.rc(iN.field, "correct");
		if(iN.used || iN.val() !== "") {
			u.ac(iN, "error");
			u.ac(iN.field, "error");
			this.positionHint(iN.field);
			if(typeof(iN.validationFailed) == "function") {
				iN.validationFailed();
			}
		}
	}
	this.fieldCorrect = function(iN) {
		if(iN.val() !== "") {
			u.ac(iN, "correct");
			u.ac(iN.field, "correct");
			u.rc(iN, "error");
			u.rc(iN.field, "error");
		}
		else {
			u.rc(iN, "correct");
			u.rc(iN.field, "correct");
			u.rc(iN, "error");
			u.rc(iN.field, "error");
		}
	}
	this.autoExpand = function(iN) {
		var current_height = parseInt(u.gcs(iN, "height"));
		var current_value = iN.val();
		iN.value = "";
		u.as(iN, "overflow", "hidden");
		iN.autoexpand_offset = 0;
		if(parseInt(u.gcs(iN, "height")) != iN.scrollHeight) {
			iN.autoexpand_offset = iN.scrollHeight - parseInt(u.gcs(iN, "height"));
		}
		iN.value = current_value;
		iN.setHeight = function() {
			var textarea_height = parseInt(u.gcs(this, "height"));
			if(this.val()) {
				if(u.browser("webkit") || u.browser("firefox", ">=29")) {
					if(this.scrollHeight - this.autoexpand_offset > textarea_height) {
						u.a.setHeight(this, this.scrollHeight);
					}
				}
				else if(u.browser("opera") || u.browser("explorer")) {
					if(this.scrollHeight > textarea_height) {
						u.a.setHeight(this, this.scrollHeight);
					}
				}
				else {
					u.a.setHeight(this, this.scrollHeight);
				}
			}
		}
		u.e.addEvent(iN, "keyup", iN.setHeight);
		iN.setHeight();
	}
	this.fileUpload = function(field) {
		u.e.addEvent(field._input, "focus", this._focus);
		u.e.addEvent(field._input, "blur", this._blur);
		if(u.e.event_pref == "mouse") {
			u.e.addEvent(field._input, "dragenter", this._focus);
			u.e.addEvent(field._input, "dragleave", this._blur);
			u.e.addEvent(field._input, "mouseenter", this._mouseenter);
			u.e.addEvent(field._input, "mouseleave", this._mouseleave);
		}
		u.e.addEvent(field._input, "blur", this._validate);
		field._input.val = function(value) {
			if(value !== undefined) {
				this.value = value;
			}
			else {
				if(this.value && this.files && this.files.length) {
					var i, file, files = [];
					for(i = 0; file = this.files[i]; i++) {
						files.push(file);
					}
					return files;
				}
				else if(this.value) {
					return this.value;
				}
				else if(u.hc(this, "uploaded")){
					return true;
				}
				return "";
			}
		}
	}
	this.geoLocation = function(field) {
 		u.ac(field, "geolocation");
		field.lat_input = u.qs("div.latitude input", field);
		field.lat_input.autocomplete = "off";
		field.lat_input.field = field;
		field.lon_input = u.qs("div.longitude input", field);
		field.lon_input.autocomplete = "off";
		field.lon_input.field = field;
		field.showMap = function() {
			if(!window._mapsiframe) {
				var lat = this.lat_input.val() !== "" ? this.lat_input.val() : 0;
				var lon = this.lon_input.val() !== "" ? this.lon_input.val() : 0;
				var maps_url = "https://maps.googleapis.com/maps/api/js" + (u.gapi_key ? "?key="+u.gapi_key : "");
				var html = '<html><head>';
				html += '<style type="text/css">body {margin: 0;}#map {width: 300px; height: 300px;}} </style>';
				html += '<script type="text/javascript" src="'+maps_url+'"></script>';
				html += '<script type="text/javascript">';
				html += 'var map, marker;';
				html += 'var initialize = function() {';
				html += '	window._map_loaded = true;';
				html += '	var mapOptions = {center: new google.maps.LatLng('+lat+', '+lon+'),zoom: 15};';
				html += '	map = new google.maps.Map(document.getElementById("map"),mapOptions);';
				html += '	marker = new google.maps.Marker({position: new google.maps.LatLng('+lat+', '+lon+'), draggable:true});';
				html += '	marker.setMap(map);';
				html += '	marker.dragend = function(event_type) {';
				html += '		var lat_marker = Math.round(marker.getPosition().lat()*100000)/100000;';
				html += '		var lon_marker = Math.round(marker.getPosition().lng()*100000)/100000;';
				html += '		field.lon_input.val(lon_marker);';
				html += '		field.lat_input.val(lat_marker);';
				html += '	};';
				html += '	marker.addListener("dragend", marker.dragend);';
				html += '};';
				html += 'var centerMap = function(lat, lon) {';
				html += '	var loc = new google.maps.LatLng(lat, lon);';
				html += '	map.setCenter(loc);';
				html += '	marker.setPosition(loc);';
				html += '};';
				html += 'google.maps.event.addDomListener(window, "load", initialize);';
				html += '</script>';
				html += '</head><body><div id="map"></div></body></html>';
				window._mapsiframe = u.ae(document.body, "iframe", {"id":"geolocationmap"});
				window._mapsiframe.doc = window._mapsiframe.contentDocument? window._mapsiframe.contentDocument: window._mapsiframe.contentWindow.document;
				window._mapsiframe.doc.open();
				window._mapsiframe.doc.write(html);
				window._mapsiframe.doc.close();
			}
			else {
				this.updateMap();
			}
			window._mapsiframe.contentWindow.field = this;
			u.as(window._mapsiframe, "left", (u.absX(this.bn_geolocation)+this.bn_geolocation.offsetWidth+10)+"px");
			u.as(window._mapsiframe, "top", (u.absY(this.bn_geolocation) + (this.bn_geolocation.offsetHeight/2) -(window._mapsiframe.offsetHeight/2))+"px");
		}
		field.updateMap = function() {
			if(window._mapsiframe && window._mapsiframe.contentWindow && window._mapsiframe.contentWindow._map_loaded) {
				window._mapsiframe.contentWindow.centerMap(this.lat_input.val(), this.lon_input.val());
			}
		}
		field.move_map = function(event) {
			var factor;
			if(this._move_direction) {
				if(event && event.shiftKey) {
					factor = 0.001;
				}
				else {
					factor = 0.0001;
				}
				if(this._move_direction == "38") {
					this.lat_input.val(u.round(parseFloat(this.lat_input.val())+factor, 6));
				}
				else if(this._move_direction == "40") {
					this.lat_input.val(u.round(parseFloat(this.lat_input.val())-factor, 6));
				}
				else if(this._move_direction == "39") {
					this.lon_input.val(u.round(parseFloat(this.lon_input.val())+factor, 6));
				}
				else if(this._move_direction == "37") {
					this.lon_input.val(u.round(parseFloat(this.lon_input.val())-factor, 6));
				}
				this.updateMap();
			}
		}
		field.hideMap = function() {
			u.t.resetTimer(this.t_hide_map);
			if(window._mapsiframe) {
				document.body.removeChild(window._mapsiframe);
				window._mapsiframe = null;
			}
		}
		field._end_move_map = function(event) {
			this.field._move_direction = false;
		}
		field._start_move_map = function(event) {
			if(event.keyCode.toString().match(/37|38|39|40/)) {
				this.field._move_direction = event.keyCode;
				this.field.move_map(event);
			}
		}
		u.e.addEvent(field.lat_input, "keydown", field._start_move_map);
		u.e.addEvent(field.lon_input, "keydown", field._start_move_map);
		u.e.addEvent(field.lat_input, "keyup", field._end_move_map);
		u.e.addEvent(field.lon_input, "keyup", field._end_move_map);
		field.lat_input.updated = field.lon_input.updated = function() {
			this.field.updateMap();
		}
		field.lat_input.focused = field.lon_input.focused = function() {
			u.t.resetTimer(this.field.t_hide_map);
			this.field.showMap();
		}
		field.lat_input.blurred = field.lon_input.blurred = function() {
			this.field.t_hide_map = u.t.setTimer(this.field, this.field.hideMap, 800);
		}
		field.bn_geolocation = u.ae(field, "div", {"class":"geolocation"});
		field.bn_geolocation.field = field;
		u.ce(field.bn_geolocation);
		field.bn_geolocation.clicked = function() {
			u.a.transition(this, "all 0.5s ease-in-out");
			this.transitioned = function() {
				var new_scale;
				if(this._scale == 1.4) {
					new_scale = 1;
				}
				else {
					new_scale = 1.4;
				}
				u.a.scale(this, new_scale);
			}
			this.transitioned();
			window._geoLocationField = this.field;
			window._foundLocation = function(position) {
				var lat = position.coords.latitude;
				var lon = position.coords.longitude;
				window._geoLocationField.lat_input.val(u.round(lat, 6));
				window._geoLocationField.lon_input.val(u.round(lon, 6));
				window._geoLocationField.lat_input.focus();
				window._geoLocationField.lon_input.focus();
				window._geoLocationField.showMap();
				u.a.transition(window._geoLocationField.bn_geolocation, "none");
				u.a.scale(window._geoLocationField.bn_geolocation, 1);
			}
			window._noLocation = function() {
				alert('Could not find location');
			}
			navigator.geolocation.getCurrentPosition(window._foundLocation, window._noLocation);
		}
	}
	this.textEditor = function(field) {
		u.bug("init editor")
		var hint_has_been_shown = u.getCookie("html-editor-hint-v1", {"path":"/"});
		if(!hint_has_been_shown) {
			var editor_hint = u.ie(field, "div", {"class":"html_editor_hint"});
			var editor_hint_open = u.ae(editor_hint, "div", {"class":"open", "html":"I'd like to know more about the Editor"});
			var editor_hint_content = u.ae(editor_hint, "div", {"class":"html_editor_hint_content"});
			editor_hint_open.editor_hint_content = editor_hint_content;
			u.ce(editor_hint_open);
			editor_hint_open.clicked = function() {
				if(this.editor_hint_content.is_shown) {
					this.innerHTML = "I'd like to know more about the Editor";
					u.as(editor_hint_content, "display", "none");
					this.editor_hint_content.is_shown = false;
				}
				else {
					this.innerHTML = "Hide help for now";
					u.as(editor_hint_content, "display", "block");
					this.editor_hint_content.is_shown = true;
				}
			}
			u.ae(editor_hint_content, "p", {"html":"If you are new to using the Janitor HTML editor here are a few tips to working better with the editor."});
			u.ae(editor_hint_content, "p", {"html":"This HTML editor has been developed to maintain a strict control of the design - therefore it looks different from other HTML editors. The features available are aligned with the design of the specific page, and the Editor might not have the same features available in every context."});
			u.ae(editor_hint_content, "h4", {"html":"General use:"});
			u.ae(editor_hint_content, "p", {"html":"All HTML nodes can be deleted using the Trashcan in the Right side. The Editor allways requires one node to exist and you cannot delete the last remaining node."});
			u.ae(editor_hint_content, "p", {"html":"HTML nodes can be re-ordered by dragging the bubble in the Left side."});
			u.ae(editor_hint_content, "p", {"html":"You can add new nodes by clicking on the + below the editor. The options availble are the ones allowed for the current content type."});
			u.ae(editor_hint_content, "h4", {"html":"Text nodes:"});
			u.ae(editor_hint_content, "p", {"html":"&lt;H1&gt;,&lt;H2&gt;,&lt;H3&gt;,&lt;H4&gt;,&lt;H5&gt;,&lt;H6&gt;,&lt;P&gt;,&lt;CODE&gt;"});
			u.ae(editor_hint_content, "p", {"html":"Text nodes are for headlines and paragraphs - regular text."});
			u.ae(editor_hint_content, "p", {"html":"You can activate the inline formatting tool by selecting text in your Text node."});
			u.ae(editor_hint_content, "p", {"html":"If you press ENTER inside a Text node, a new Text node will be created below the current one."});
			u.ae(editor_hint_content, "p", {"html":"If you press BACKSPACE twice inside an empty Text node it will be deleted"});
			u.ae(editor_hint_content, "h4", {"html":"List nodes:"});
			u.ae(editor_hint_content, "p", {"html":"&lt;UL&gt;,&lt;OL&gt;"});
			u.ae(editor_hint_content, "p", {"html":"There are two types of list nodes: Unordered lists (UL w/ bullets) and Ordered lists (OL w/ numbers). Each of them can have one or many List items."});
			u.ae(editor_hint_content, "p", {"html":"You can activate the inline formatting tool by selecting text in your List item."});
			u.ae(editor_hint_content, "p", {"html":"If you press ENTER inside a List item, a new List item will be created below the current one."});
			u.ae(editor_hint_content, "p", {"html":"If you press BACKSPACE twice inside an empty List item it will be deleted. If it is the last List item in the List node, the List node will be deleted as well."});
			u.ae(editor_hint_content, "h4", {"html":"File nodes:"});
			u.ae(editor_hint_content, "p", {"html":"Drag you file to the node or click the node to select your file."});
			u.ae(editor_hint_content, "p", {"html":"If you add other file-types than PDF's, the file will be zipped on the server and made availble for download as ZIP file."});
			var editor_hint_close = u.ae(editor_hint_content, "div", {"class":"close", "html":"I got it, don't tell me again"});
			u.ce(editor_hint_close);
			editor_hint_close.editor_hint = editor_hint;
			editor_hint_close.clicked = function() {
				u.saveCookie("html-editor-hint-v1", 1, {"path":"/"});
				this.editor_hint.parentNode.removeChild(this.editor_hint);
			}
		}
		field.text_support = "h1,h2,h3,h4,h5,h6,p,code";
		field.list_support = "ul,ol";
		field.media_support = "png,jpg,mp4";
		field.ext_video_support = "youtube,vimeo";
		field.file_support = "download"; 
		field.allowed_tags = u.cv(field, "tags");
		if(!field.allowed_tags) {
			u.bug("allowed_tags not specified")
			return;
		}
		field.filterAllowedTags = function(type) {
			tags = this.allowed_tags.split(",");
			this[type+"_allowed"] = new Array();
			var tag, i;
			for(i = 0; tag = tags[i]; i++) {
				if(tag.match(this[type+"_support"].split(",").join("|"))) {
					this[type+"_allowed"].push(tag);
				}
			}
		}
		field.filterAllowedTags("text");
		field.filterAllowedTags("list");
		field.filterAllowedTags("media");
		field.filterAllowedTags("ext_video");
		field.filterAllowedTags("file");
		field.file_add_action = field.getAttribute("data-file-add");
		field.file_delete_action = field.getAttribute("data-file-delete");
		field.item_id;
		var item_id_match = field._input.form.action.match(/\/([0-9]+)(\/|$)/);
		if(item_id_match) {
			field.item_id = item_id_match[1];
		}
		field._viewer = u.ae(field, "div", {"class":"viewer"});
		field._editor = u.ae(field, "div", {"class":"editor"});
		field._editor.field = field;
		field._editor.dropped = function() {
			this.field.update();
		}
		field.addOptions = function() {
			this.bn_show_raw = u.ae(this._input._label, "span", {"html":"(RAW HTML)"});
			this.bn_show_raw.field = this;
			u.ce(this.bn_show_raw);
			this.bn_show_raw.clicked = function() {
				if(u.hc(this.field._input, "show")) {
					u.rc(this.field._input, "show");
				}
				else {
					u.ac(this.field._input, "show");
				}
			}
			this.options = u.ae(this, "ul", {"class":"options"});
			this.bn_add = u.ae(this.options, "li", {"class":"add", "html":"+"});
			this.bn_add.field = field;
			u.ce(this.bn_add);
			this.bn_add.clicked = function(event) {
				if(u.hc(this.field.options, "show")) {
					u.rc(this.field.options, "show");
				}
				else {
					u.ac(this.field.options, "show");
				}
			}
			if(this.text_allowed.length) {
				this.bn_add_text = u.ae(this.options, "li", {"class":"text", "html":"Text ("+this.text_allowed.join(", ")+")"});
				this.bn_add_text.field = field;
				u.ce(this.bn_add_text);
				this.bn_add_text.clicked = function(event) {
					this.field.addTextTag(this.field.text_allowed[0]);
					u.rc(this.field.options, "show");
				}
			}
			if(this.list_allowed.length) {
				this.bn_add_list = u.ae(this.options, "li", {"class":"list", "html":"List ("+this.list_allowed.join(", ")+")"});
				this.bn_add_list.field = field;
				u.ce(this.bn_add_list);
				this.bn_add_list.clicked = function(event) {
					this.field.addListTag(this.field.list_allowed[0]);
					u.rc(this.field.options, "show");
				}
			}
			if(this.media_allowed.length) {
				this.bn_add_media = u.ae(this.options, "li", {"class":"list", "html":"Media ("+this.media_allowed.join(", ")+")"});
				this.bn_add_media.field = field;
				u.ce(this.bn_add_media);
				this.bn_add_media.clicked = function(event) {
					this.field.addMediaTag();
					u.rc(this.field.options, "show");
				}
			}
			if(this.ext_video_allowed.length) {
				this.bn_add_ext_video = u.ae(this.options, "li", {"class":"video", "html":"External video ("+this.ext_video_allowed.join(", ")+")"});
				this.bn_add_ext_video.field = field;
				u.ce(this.bn_add_ext_video);
				this.bn_add_ext_video.clicked = function(event) {
					this.field.addExternalVideoTag();
					u.rc(this.field.options, "show");
				}
			}
			if(this.file_allowed.length && this.item_id && this.file_add_action && this.file_delete_action) {
				this.bn_add_file = u.ae(this.options, "li", {"class":"file", "html":"Downloadable file"});
				this.bn_add_file.field = field;
				u.ce(this.bn_add_file);
				this.bn_add_file.clicked = function(event) {
					this.field.addFileTag();
					u.rc(this.field.options, "show");
				}
			}
			else if(this.file_allowed.length) {
				u.bug("some information is missing to support file upload:\nitem_id="+this.item_id+"\nfile_add_action="+this.file_add_action+"\nfile_delete_action="+this.file_delete_action);
			}
		}
		field.update = function() {
			this.updateViewer();
			this.updateContent();
		}
		field.updateViewer = function() {
			var tags = u.qsa("div.tag", this);
			var i, tag, j, list, li, lis, div, p, a;
			this._viewer.innerHTML = "";
			for(i = 0; tag = tags[i]; i++) {
				if(u.hc(tag, this.text_allowed.join("|"))) {
					u.ae(this._viewer, tag._type.val(), {"html":tag._input.val()});
				}
				else if(u.hc(tag, this.list_allowed.join("|"))) {
					list = u.ae(this._viewer, tag._type.val());
					lis = u.qsa("div.li", tag);
					for(j = 0; li = lis[j]; j++) {
						li = u.ae(list, tag._type.val(), {"html":li._input.val()});
					}
				}
				else if(u.hc(tag, this.ext_video_allowed.join("|"))) {
					div = u.ae(this._viewer, "div", {"class":tag._type.val()+" video_id:"+tag._video_id});
				}
				else if(u.hc(tag, "file")) {
					div = u.ae(this._viewer, "div", {"class":"file item_id:"+tag._item_id+" variant:"+tag._variant+" name:"+tag._name + " filesize:"+tag._filesize});
					p = u.ae(div, "p", {"html":"DOWNLOAD: "});
					a = u.ae(p, "a", {"href":"/download/"+tag._item_id+"/"+tag._variant+"/"+tag._name, "html":tag._name + " ("+u.round(tag._filesize/1000, 2)+" Kb)"});
				}
			}
		}
		field.updateContent = function() {
			var tags = u.qsa("div.tag", this);
			this._input.val("");
			var i, node, tag, type, value, j, html = "";
			for(i = 0; tag = tags[i]; i++) {
				if(u.hc(tag, this.text_allowed.join("|"))) {
					type = tag._type.val();
					html += "<"+type+">"+tag._input.val()+"</"+type+">\n";
				}
				else if(u.hc(tag, this.list_allowed.join("|"))) {
					type = tag._type.val();
					html += "<"+type+">\n";
					lis = u.qsa("div.li", tag);
					for(j = 0; li = lis[j]; j++) {
						html += "\t<li>"+li._input.val()+"</li>\n";
					}
					html += "</"+type+">\n";
				}
				else if(u.hc(tag, this.ext_video_allowed.join("|"))) {
					html += '<div class="'+tag._type.val()+' video_id:'+tag._video_id+'"></div>\n';
				}
				else if(u.hc(tag, "file")) {
					html += '<div class="file item_id:'+tag._item_id+' variant:'+tag._variant+' name:'+tag._name+' filesize:'+tag._filesize+'">'+"\n";
					html += '\t<p>DOWNLOAD: <a href="/download/'+tag._item_id+'/'+tag._variant+'/'+tag._name+'">'+tag._name+" ("+u.round(tag._filesize/1000, 2)+" Kb)</a></p>";
					html += "</div>\n";
				}
			}
			this._input.val(html);
		}
		field.createTag = function(allowed_tags, type) {
			var tag = u.ae(this._editor, "div", {"class":"tag"});
			tag.field = this;
			tag._drag = u.ae(tag, "div", {"class":"drag"});
			tag._drag.field = this;
			tag._drag.tag = tag;
			this.createTagSelector(tag, allowed_tags);
			tag._type.val(type);
			tag._remove = u.ae(tag, "div", {"class":"remove"});
			tag._remove.field = this;
			tag._remove.tag = tag;
			u.ce(tag._remove);
			tag._remove.clicked = function() {
				this.field.deleteTag(this.tag);
			}
			return tag;
		}
		field.deleteTag = function(tag) {
			if(u.qsa("div.tag", this).length > 1) {
				if(u.hc(tag, "file")) {
					this.deleteFile(tag);
				}
				tag.parentNode.removeChild(tag);
				u.sortable(this._editor, {"draggables":"tag", "targets":"editor"});
				this.update();
				this._input.form.submit();
			}
		}
		field.createTagSelector = function(tag, allowed_tags) {
			var i, allowed_tag;
			tag._type = u.ae(tag, "ul", {"class":"type"});
			tag._type.field = this;
			tag._type.tag = tag;
			for(i = 0; allowed_tag = allowed_tags[i]; i++) {
				u.ae(tag._type, "li", {"html":allowed_tag, "class":allowed_tag});
			}
			tag._type.val = function(value) {
				if(value !== undefined) {
					var i, option;
					for(i = 0; option = this.childNodes[i]; i++) {
						if(u.text(option) == value) {
							if(this.selected_option) {
								u.rc(this.selected_option, "selected");
								u.rc(this.tag, u.text(this.selected_option));
							}
							u.ac(option, "selected");
							this.selected_option = option;
							u.ac(this.tag, value);
							return option;
						}
					}
					u.ac(this.childNodes[0], "selected");
					this.selected_option = this.childNodes[0];
					u.ac(this.tag, u.text(this.childNodes[0]));
					return this.childNodes[0];
				}
				else {
					return u.text(this.selected_option);
				}
			}
			if(allowed_tags.length > 1) {
				u.ce(tag._type);
				tag._type.clicked = function(event) {
					u.t.resetTimer(this.t_autohide);
					if(u.hc(this, "open")) {
						u.rc(this, "open");
						u.rc(this.tag, "focus");
						u.as(this, "top", 0);
						if(event.target) {
							this.val(u.text(event.target));
						}
						u.e.removeEvent(this, "mouseout", this.autohide);
						u.e.removeEvent(this, "mouseover", this.delayautohide);
						this.field.update();
					}
					else {
						u.ac(this, "open");
						u.ac(this.tag, "focus");
						u.as(this, "top", -(this.selected_option.offsetTop) + "px");
						u.e.addEvent(this, "mouseout", this.autohide);
						u.e.addEvent(this, "mouseover", this.delayautohide);
					}
				}
				tag._type.hide = function() {
					u.rc(this, "open");
					u.rc(this.tag, "focus");
					u.as(this, "top", 0);
					u.e.removeEvent(this, "mouseout", this.autohide);
					u.e.removeEvent(this, "mouseover", this.delayautohide);
					u.t.resetTimer(this.t_autohide);
				}
				tag._type.autohide = function(event) {
					u.t.resetTimer(this.t_autohide);
					this.t_autohide = u.t.setTimer(this, this.hide, 800);
				}
				tag._type.delayautohide = function(event) {
					u.t.resetTimer(this.t_autohide);
				}
			}
		}
		field.addExternalVideoTag = function() {}
		field.addMediaTag = function() {}
		field.addFileTag = function(value) {
			var tag = this.createTag(["file"], "file");
			tag._text = u.ae(tag, "div", {"class":"text"});
			if(value) {
				tag._variant = u.cv(node, "variant");
				tag._name = u.cv(node, "name");
				tag._item_id = u.cv(node, "item_id");
				tag._filesize = u.cv(node, "filesize");
				tag._label = u.ae(tag._text, "label", {"class":"done", "html":tag._name + " ("+u.round(tag._filesize/1000, 2)+" Kb)"});
			}
			else {
				tag._label = u.ae(tag._text, "label", {"html":"Drag file here"});
				tag._input = u.ae(tag._text, "input", {"type":"file", "name":"htmleditor_file"});
				tag._input.tag = tag;
				tag._input.field = this;
				tag._input.val = function(value) {
					u.bug("this shouldn't be called from anywhere")
				}
				u.e.addEvent(tag._input, "change", this._file_updated);
				u.e.addEvent(tag._input, "focus", this._focused_content);
				u.e.addEvent(tag._input, "blur", this._blurred_content);
				if(u.e.event_pref == "mouse") {
					u.e.addEvent(tag._input, "mouseenter", u.f._mouseenter);
					u.e.addEvent(tag._input, "mouseleave", u.f._mouseleave);
				}
			}
			u.sortable(this._editor, {"draggables":"tag", "targets":"editor"});
			return tag;
		}
		field.deleteFile = function(tag) {
			var form_data = new FormData();
			form_data.append("csrf-token", this._input.form.fields["csrf-token"].val());
			tag.response = function(response) {
				page.notify(response);
				if(response.cms_status && response.cms_status == "success") {
					this.field.update();
				}
			}
			u.request(tag, this.file_delete_action+"/"+tag._item_id+"/"+tag._variant, {"method":"post", "params":form_data});
		}
		field.addListTag = function(type, value) {
			var tag = this.createTag(this.list_allowed, type);
			this.addListItem(tag, value);
			u.sortable(this._editor, {"draggables":"tag", "targets":"editor"});
			return tag;
		}
		field.addListItem = function(tag, value) {
			var li = u.ae(tag, "div", {"class":"li"});
			li.tag = tag;
			li.field = this;
			li._input = u.ae(li, "div", {"class":"text", "contentEditable":true});
			li._input.li = li;
			li._input.tag = tag;
			li._input.field = this;
			li._input.val = function(value) {
				if(value !== undefined) {
					this.innerHTML = value;
				}
				return this.innerHTML;
			}
			li._input.val(u.stringOr(value));
			u.e.addEvent(li._input, "keydown", this._changing_content);
			u.e.addEvent(li._input, "keyup", this._changed_content);
			u.e.addEvent(li._input, "mouseup", this._changed_content);
			u.e.addEvent(li._input, "focus", this._focused_content);
			u.e.addEvent(li._input, "blur", this._blurred_content);
			if(u.e.event_pref == "mouse") {
				u.e.addEvent(li._input, "mouseenter", u.f._mouseenter);
				u.e.addEvent(li._input, "mouseleave", u.f._mouseleave);
			}
			u.e.addEvent(li._input, "paste", this._pasted_content);
			return li;
		}
		field.addTextTag = function(type, value) {
			var tag = this.createTag(this.text_allowed, type);
			tag._input = u.ae(tag, "div", {"class":"text", "contentEditable":true});
			tag._input.tag = tag;
			tag._input.field = this;
			tag._input.val = function(value) {
				if(value !== undefined) {
					this.innerHTML = value;
				}
				return this.innerHTML;
			}
			tag._input.val(u.stringOr(value));
			u.e.addEvent(tag._input, "keydown", this._changing_content);
			u.e.addEvent(tag._input, "keyup", this._changed_content);
			u.e.addEvent(tag._input, "mouseup", this._changed_content);
			u.e.addEvent(tag._input, "focus", this._focused_content);
			u.e.addEvent(tag._input, "blur", this._blurred_content);
			if(u.e.event_pref == "mouse") {
				u.e.addEvent(tag._input, "mouseenter", u.f._mouseenter);
				u.e.addEvent(tag._input, "mouseleave", u.f._mouseleave);
			}
			u.e.addEvent(tag._input, "paste", this._pasted_content);
			tag.addNew = function() {
				this.field.addTextItem(this.field.text_allowed[0]);
			}
			u.sortable(this._editor, {"draggables":"tag", "targets":"editor"});
			return tag;
		}
		field._focused_content = function(event) {
			this.field.focused = true;
			u.ac(this.tag, "focus");
			u.ac(this.field, "focus");
			u.as(this.field, "zIndex", this.field._input.form._focus_z_index);
			u.f.positionHint(this.field);
			if(event.rangeOffset == 1) {
				var range = document.createRange();
				range.selectNodeContents(this);
				range.collapse(false);
				var selection = window.getSelection();
				selection.removeAllRanges();
				selection.addRange(range);
			}
		}
		field._blurred_content = function() {
			this.field.focused = false;
			u.rc(this.tag, "focus");
			u.rc(this.field, "focus");
			u.as(this.field, "zIndex", this.field._base_z_index);
			u.f.positionHint(this.field);
			this.field.hideSelectionOptions();
		}
		field._file_updated = function(event) {
			var form_data = new FormData();
			form_data.append(this.name, this.files[0], this.value);
			form_data.append("csrf-token", this.form.fields["csrf-token"].val());
			this.response = function(response) {
				page.notify(response);
				if(response.cms_status && response.cms_status == "success") {
					this.parentNode.removeChild(this);
					this.tag._label.innerHTML = response.cms_object["name"] + " ("+ u.round((response.cms_object["filesize"]/1000), 2) +"Kb)";
					this.tag._variant = response.cms_object["variant"];
					this.tag._filesize = response.cms_object["filesize"]
					this.tag._name = response.cms_object["name"]
					this.tag._item_id = response.cms_object["item_id"]
					u.ac(this.tag._label, "done");
					this.tag.field.update();
					this.tag.field._input.form.submit();
				}
			}
			u.request(this, this.field.file_add_action+"/"+this.field.item_id, {"method":"post", "params":form_data});
		}
		field._changing_content = function(event) {
			if(event.keyCode == 13) {
				u.e.kill(event);
			}
		}
		field._changed_content = function(event) {
			var selection = window.getSelection(); 
			if(event.keyCode == 13) {
				u.e.kill(event);
				if(!event.ctrlKey && !event.metaKey) {
					if(u.hc(this.tag, this.field.list_allowed.join("|"))) {
						var new_li = this.field.addListItem(this.tag);
						var next_li = u.ns(this.li);
						if(next_li) {
							this.tag.insertBefore(new_li, next_li);
						}
						else {
							this.tag.appendChild(new_li);
						}
						new_li._input.focus();
					}
					else {
						var new_tag = this.field.addTextTag(this.field.text_allowed[0]);
						var next_tag = u.ns(this.tag);
						if(next_tag) {
							this.tag.parentNode.insertBefore(new_tag, next_tag);
						}
						else {
							this.tag.parentNode.appendChild(new_tag);
						}
						new_tag._input.focus();
					}
				}
				else {
					if(selection && selection.isCollapsed) {
						var br = document.createElement("br");
						range = selection.getRangeAt(0);
						range.insertNode(br);
						range.collapse(false);
						var selection = window.getSelection();
						selection.removeAllRanges();
						selection.addRange(range);
					}
				}
			}
			else if(event.keyCode == 8) {
				if(this.is_deletable) {
					u.e.kill(event);
					var all_tags = u.qsa("div.tag", this.field);
					var all_lis = u.qsa("div.li", this.tag);
					var prev = this.field.findPreviousInput(this);
					if(u.hc(this.tag, this.field.list_allowed.join("|"))) {
						if(all_tags.length > 1 || all_lis.length > 1) {
							this.tag.removeChild(this.li);
							if(!u.qsa("div.li", this.tag).length) {
								this.tag.parentNode.removeChild(this.tag);
							}
						}
					}
					else {
						if(all_tags.length > 1) {
							this.tag.parentNode.removeChild(this.tag);
						}
					}
					u.sortable(this.field._editor, {"draggables":"tag", "targets":"editor"});
					if(prev) {
						prev.focus();
					}
				}
				else if(!this.val() || !this.val().replace(/<br>/, "")) {
					this.is_deletable = true;
				}
				else if(selection.anchorNode != this && selection.anchorNode.innerHTML == "") {
					selection.anchorNode.parentNode.removeChild(selection.anchorNode);
				}
			}
			else {
				this.is_deletable = false;
			}
			this.field.hideSelectionOptions();
			if(selection && !selection.isCollapsed) {
				var node = selection.anchorNode;
				while(node != this) {
					if(node.nodeName == "HTML" || !node.parentNode) {
						break;
					}
					node = node.parentNode;
				}
				if(node == this) {
					this.field.showSelectionOptions(this, selection);
				}
			}
			// 	
			this.field.update();
		}
		field._pasted_content = function(event) {
			u.e.kill(event);
			var i, node;
			var paste_content = event.clipboardData.getData("text/plain");
			if(paste_content !== "") {
				var paste_parts = paste_content.split(/\n\r|\n|\r/g);
				var text_nodes = [];
				for(i = 0; text = paste_parts[i]; i++) {
					text_nodes.push(document.createTextNode(text));
					text_nodes.push(document.createElement("br"));
				}
 				var text_node = document.createTextNode(paste_content);
				for(i = text_nodes.length-1; node = text_nodes[i]; i--) {
					window.getSelection().getRangeAt(0).insertNode(node);
				}
				var range = document.createRange();
				range.selectNodeContents(this);
				range.collapse(false);
				var selection = window.getSelection();
				selection.removeAllRanges();
				selection.addRange(range);
			}
		}
		field.findPreviousInput = function(iN) {
			var prev = false;
			if(u.hc(iN.tag, this.list_allowed.join("|"))) {
				prev = u.ps(iN.li, "drag|remove|type");
			}
			if(!prev) {
				prev = u.ps(iN.tag);
				if(prev && u.hc(prev, this.list_allowed.join("|"))) {
					var items = u.qsa("div.li", prev);
					prev = items[items.length-1];
				}
			}
			if(!prev) {
				prev = u.qs("div.tag", this);
				if(u.hc(prev, this.list_allowed.join("|"))) {
					prev = u.qs("div.li", prev);
				}
			}
			return prev ? prev._input : false;
		}
		field.hideSelectionOptions = function() {
			if(this.selection_options && !this.selection_options.is_active) {
				this.selection_options.parentNode.removeChild(this.selection_options);
				this.selection_options = null;
			}
			this.update();
		}
		field.showSelectionOptions = function(node, selection) {
			var x = u.absX(node);
			var y = u.absY(node);
			this.selection_options = u.ae(document.body, "div", {"id":"selection_options"});
			u.as(this.selection_options, "top", y+"px");
			u.as(this.selection_options, "left", (x + node.offsetWidth) +"px");
			var ul = u.ae(this.selection_options, "ul", {"class":"options"});
			this.selection_options._link = u.ae(ul, "li", {"class":"link", "html":"Link"});
			this.selection_options._link.field = this;
			this.selection_options._link.selection = selection;
			u.ce(this.selection_options._link);
			this.selection_options._link.inputStarted = function(event) {
				u.e.kill(event);
				this.field.selection_options.is_active = true;
			}
			this.selection_options._link.clicked = function(event) {
				u.e.kill(event);
				this.field.addAnchorTag(this.selection);
			}
			this.selection_options._em = u.ae(ul, "li", {"class":"em", "html":"Itallic"});
			this.selection_options._em.field = this;
			this.selection_options._em.selection = selection;
			u.ce(this.selection_options._em);
			this.selection_options._em.inputStarted = function(event) {
				u.e.kill(event);
			}
			this.selection_options._em.clicked = function(event) {
				u.e.kill(event);
				this.field.addEmTag(this.selection);
			}
			this.selection_options._strong = u.ae(ul, "li", {"class":"strong", "html":"Bold"});
			this.selection_options._strong.field = this;
			this.selection_options._strong.selection = selection;
			u.ce(this.selection_options._strong);
			this.selection_options._strong.inputStarted = function(event) {
				u.e.kill(event);
			}
			this.selection_options._strong.clicked = function(event) {
				u.e.kill(event);
				this.field.addStrongTag(this.selection);
			}
		}
		field.deleteOption = function(node) {
			node.over = function(event) {
				u.t.resetTimer(this.t_out);
				if(!this.bn_delete) {
					this.bn_delete = u.ae(document.body, "span", {"class":"delete_selection", "html":"X"});
					this.bn_delete.node = this;
					this.bn_delete.over = function(event) {
						u.t.resetTimer(this.node.t_out);
					}
					this.bn_delete.out = function(event) {
						this.node.t_out = u.t.setTimer(this.node, this.node.reallyout, 300);
					}
					u.e.addEvent(this.bn_delete, "mouseover", this.bn_delete.over);
					u.e.addEvent(this.bn_delete, "mouseout", this.bn_delete.out);
					u.ce(this.bn_delete);
					this.bn_delete.clicked = function() {
						u.e.kill(event);
						if(this.node.field.selection_options) {
							this.node.field.selection_options.is_active = false;
							this.node.field.hideSelectionOptions();
						}
						var fragment = document.createTextNode(this.node.innerHTML);
						this.node.parentNode.replaceChild(fragment, this.node);
						this.node.reallyout();
						this.node.field.update();
					}
					u.as(this.bn_delete, "top", (u.absY(this)-5)+"px");
					u.as(this.bn_delete, "left", (u.absX(this)+this.offsetWidth-5)+"px");
				}
			}
			node.out = function(event) {
				u.t.resetTimer(this.t_out);
				this.t_out = u.t.setTimer(this, this.reallyout, 300);
			}
			node.reallyout = function(event) {
				if(this.bn_delete) {
					document.body.removeChild(this.bn_delete);
					this.bn_delete = null;
				}
			}
			u.e.addEvent(node, "mouseover", node.over);
			u.e.addEvent(node, "mouseout", node.out);
		}
		field.activateInlineFormatting = function(input) {
			var i, node;
			var inline_tags = u.qsa("a,strong,em,span", input);
			for(i = 0; node = inline_tags[i]; i++) {
				node.field = input.field;
				this.deleteOption(node);
			}
		}
		field.anchorOptions = function(node) {
			var form = u.f.addForm(this.selection_options, {"class":"labelstyle:inject"});
			u.ae(form, "h3", {"html":"Link options"});
			var fieldset = u.f.addFieldset(form);
			var input_url = u.f.addField(fieldset, {"label":"url", "name":"url"});
			var input_target = u.f.addField(fieldset, {"type":"checkbox", "label":"New window?", "name":"target"});
			var bn_save = u.f.addAction(form, {"value":"Create link", "class":"button"});
			u.f.init(form);
			form.a = node;
			form.field = this;
			form.submitted = function() {
				if(this.fields["url"].val() && this.fields["url"].val() != this.fields["url"].default_value) {
					this.a.href = this.fields["url"].val();
				}
				if(this.fields["target"].val() && this.fields["target"].val() != this.fields["target"].default_value) {
					this.a.target = "_blank";
				}
				this.field.selection_options.is_active = false;
				this.field.hideSelectionOptions();
			}
		}
		field.addAnchorTag = function(selection) {
			var range, a, url, target;
			var a = document.createElement("a");
			a.field = this;
			range = selection.getRangeAt(0);
			range.surroundContents(a);
			selection.removeAllRanges();
			this.anchorOptions(a);
			this.deleteOption(a);
		}
		field.addStrongTag = function(selection) {
			var range, a, url, target;
			var strong = document.createElement("strong");
			strong.field = this;
			range = selection.getRangeAt(0);
			range.surroundContents(strong);
			selection.removeAllRanges();
			this.deleteOption(strong);
			this.hideSelectionOptions();
		}
		field.addEmTag = function(selection) {
			var range, a, url, target;
			var em = document.createElement("em");
			em.field = this;
			range = selection.getRangeAt(0);
			range.surroundContents(em);
			selection.removeAllRanges();
			this.deleteOption(em);
			this.hideSelectionOptions();
		}
		field.spanOptions = function(node) {}
		field.addSpanTag = function(selection) {
			var span = document.createElement("span");
			span.field = this;
			var range = selection.getRangeAt(0);
			range.surroundContents(span);
			selection.removeAllRanges();
			this.deleteOption(span);
			this.hideSelectionOptions();
		}
		field._viewer.innerHTML = field._input.val();
		var value, node, i, tag, j, lis, li;
		var nodes = u.cn(field._viewer, "br");
		if(nodes.length) {
			for(i = 0; node = field._viewer.childNodes[i]; i++) {
				if(node.nodeName == "#text") {
					if(node.nodeValue.trim()) {
						var fragments = node.nodeValue.trim().split(/\n\r\n\r|\n\n|\r\r/g);
						if(fragments) {
							for(index in fragments) {
								value = fragments[index].replace(/\n\r|\n|\r/g, "<br>");
								tag = field.addTextTag("p", fragments[index]);
								field.activateInlineFormatting(tag._input);
							}
						}
						else {
							value = node.nodeValue; 
							tag = field.addTextTag("p", value);
							field.activateInlineFormatting(tag._input);
						}
					}
				}
				else if(node.nodeName.toLowerCase().match(field.text_allowed.join("|"))) {
					value = node.innerHTML.replace(/\n\r|\n|\r/g, "<br>"); 
					tag = field.addTextTag(node.nodeName.toLowerCase(), value);
					field.activateInlineFormatting(tag._input);
				}
				else if(node.nodeName.toLowerCase().match(field.list_allowed.join("|"))) {
					var lis = u.qsa("li", node);
					value = lis[0].innerHTML.replace(/\n\r|\n|\r/g, "<br>");
					tag = field.addListTag(node.nodeName.toLowerCase(), value);
					var li = u.qs("div.li", tag);
					field.activateInlineFormatting(li._input);
					if(lis.length > 1) {
						for(j = 1; li = lis[j]; j++) {
							value = li.innerHTML.replace(/\n\r|\n|\r/g, "<br>");
							li = field.addListItem(tag, value);
							field.activateInlineFormatting(li._input);
						}
					}
				}
				else if(u.hc(node, "file")) {
					field.addFileTag(node);
				}
				else if(node.nodeName.toLowerCase().match(/dl|ul|ol/)) {
					var children = u.cn(node);
					for(j = 0; child = children[j]; j++) {
						value = child.innerHTML.replace(/\n\r|\n|\r/g, "");
						tag = field.addTextTag(field.text_allowed[0], value);
						field.activateInlineFormatting(tag._input);
					}
				}
				else if(node.nodeName.toLowerCase().match(/h1|h2|h3|h4|h5|code/)) {
					value = node.innerHTML.replace(/\n\r|\n|\r/g, "");
					tag = field.addTextTag(field.text_allowed[0], value);
					field.activateInlineFormatting(tag._input);
				}
				else {
					alert("HTML contains unautorized node:" + node.nodeName + "\nIt has been altered to conform with SEO and design.");
				}
			}
		}
		else {
			value = field._viewer.innerHTML.replace(/\<br[\/]?\>/g, "\n");
			tag = field.addTextTag(field.text_allowed[0], value);
			field.activateInlineFormatting(tag._input);
		}
		u.sortable(field._editor, {"draggables":"tag", "targets":"editor"});
		field.updateViewer();
		field.addOptions();
	}
	this.validate = function(iN) {
		if(!iN.form._validation) {
			return true;
		}
		var min, max, pattern;
		var validated = false;
		if(!u.hc(iN.field, "required") && iN.val() === "") {
			this.fieldCorrect(iN);
			return true;
		}
		else if(u.hc(iN.field, "required") && iN.val() === "") {
			this.fieldError(iN);
			return false;
		}
		var custom_validate;
		for(custom_validate in u.f.customValidate) {
			if(u.hc(iN.field, custom_validate)) {
				u.f.customValidate[custom_validate](iN);
				validated = true;
			}
		}
		if(!validated) {
			if(u.hc(iN.field, "password")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 8;
				max = max ? max : 20;
				pattern = iN.getAttribute("pattern");
				if(
					iN.val().length >= min && 
					iN.val().length <= max && 
					(!pattern || iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "number")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 0;
				max = max ? max : 99999999999999999999999999999;
				pattern = iN.getAttribute("pattern");
				if(
					!isNaN(iN.val()) && 
					iN.val() >= min && 
					iN.val() <= max && 
					(!pattern || iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "integer")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 0;
				max = max ? max : 99999999999999999999999999999;
				pattern = iN.getAttribute("pattern");
				if(
					!isNaN(iN.val()) && 
					Math.round(iN.val()) == iN.val() && 
					iN.val() >= min && 
					iN.val() <= max && 
					(!pattern || iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "tel")) {
				pattern = iN.getAttribute("pattern");
				if(
					!pattern && iN.val().match(/^([\+0-9\-\.\s\(\)]){5,18}$/) ||
					(pattern && iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "email")) {
				if(
					!pattern && iN.val().match(/^([^<>\\\/%$])+\@([^<>\\\/%$])+\.([^<>\\\/%$]{2,20})$/) ||
					(pattern && iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "text")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 1;
				max = max ? max : 10000000;
				pattern = iN.getAttribute("pattern");
				if(
					iN.val().length >= min && 
					iN.val().length <= max && 
					(!pattern || iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "html")) {
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
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "select")) {
				if(iN.val() !== "") {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "checkbox|boolean|radiobuttons")) {
				if(iN.val()) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "string")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 1;
				max = max ? max : 255;
				pattern = iN.getAttribute("pattern");
				if(
					iN.val().length >= min &&
					iN.val().length <= max && 
					(!pattern || iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "date")) {
				pattern = iN.getAttribute("pattern");
				if(
					!pattern && iN.val().match(/^([\d]{4}[\-\/\ ]{1}[\d]{2}[\-\/\ ][\d]{2})$/) ||
					(pattern && iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "datetime")) {
				pattern = iN.getAttribute("pattern");
				if(
					!pattern && iN.val().match(/^([\d]{4}[\-\/\ ]{1}[\d]{2}[\-\/\ ][\d]{2} [\d]{2}[\-\/\ \:]{1}[\d]{2}[\-\/\ \:]{0,1}[\d]{0,2})$/) ||
					(pattern && iN.val().match(pattern))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "tags")) {
				if(
					!pattern && iN.val().match(/\:/) ||
					(pattern && iN.val().match("^"+pattern+"$"))
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "prices")) {
				if(
					!isNaN(iN.val())
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "location")) {
				var loc_fields = 0;
				if(iN.field._input) {
					loc_fields++;
					min = 1;
					max = 255;
					if(
						iN.field._input.val().length >= min &&
						iN.field._input.val().length <= max
					) {
						this.fieldCorrect(iN.field._input);
					}
					else {
						this.fieldError(iN.field._input);
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
						this.fieldCorrect(iN.field.lat_input);
					}
					else {
						this.fieldError(iN.field.lat_input);
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
						this.fieldCorrect(iN.field.lon_input);
					}
					else {
						this.fieldError(iN.field.lon_input);
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
			else if(u.hc(iN.field, "files")) {
				min = Number(u.cv(iN.field, "min"));
				max = Number(u.cv(iN.field, "max"));
				min = min ? min : 1;
				max = max ? max : 10000000;
				if(
					u.hc(iN, "uploaded") ||
					(iN.val().length >= min && 
					iN.val().length <= max)
				) {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
		}
		if(u.hc(iN.field, "error")) {
			return false;
		}
		else {
			return true;
		}
	}
}
u.f.getParams = function(form, _options) {
	var send_as = "params";
	var ignore_inputs = "ignoreinput";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "ignore_inputs"    : ignore_inputs     = _options[_argument]; break;
				case "send_as"          : send_as           = _options[_argument]; break;
			}
		}
	}
	var i, input, select, textarea, param, params;
	if(send_as == "formdata" && (typeof(window.FormData) == "function" || typeof(window.FormData) == "object")) {
		params = new FormData();
	}
	else {
		if(send_as == "formdata") {
			send_as == "params";
		}
		params = new Object();
		params.append = function(name, value, filename) {
			this[name] = value;
		}
	}
	if(form._submit_button && form._submit_button.name) {
		params.append(form._submit_button.name, form._submit_button.value);
	}
	var inputs = u.qsa("input", form);
	var selects = u.qsa("select", form)
	var textareas = u.qsa("textarea", form)
	for(i = 0; input = inputs[i]; i++) {
		if(!u.hc(input, ignore_inputs)) {
			if((input.type == "checkbox" || input.type == "radio") && input.checked) {
				if(typeof(input.val) == "function") {
					params.append(input.name, input.val());
				}
				else {
					params.append(input.name, input.value);
				}
			}
			else if(input.type == "file") {
				var f, file, files;
				if(typeof(input.val) == "function") {
					files = input.val();
				}
				else {
					files = input.value;
				}
				if(files) {
					for(f = 0; file = files[f]; f++) {
						params.append(input.name, file, file.name);
					}
				}
				else {
					params.append(input.name, "");
				}
			}
			else if(!input.type.match(/button|submit|reset|file|checkbox|radio/i)) {
				if(typeof(input.val) == "function") {
					params.append(input.name, input.val());
				}
				else {
					params.append(input.name, input.value);
				}
			}
		}
	}
	for(i = 0; select = selects[i]; i++) {
		if(!u.hc(select, ignore_inputs)) {
			if(typeof(select.val) == "function") {
				params.append(select.name, select.val());
			}
			else {
				params.append(select.name, select.options[select.selectedIndex].value);
			}
		}
	}
	for(i = 0; textarea = textareas[i]; i++) {
		if(!u.hc(textarea, ignore_inputs)) {
			if(typeof(textarea.val) == "function") {
				params.append(textarea.name, textarea.val());
			}
			else {
				params.append(textarea.name, textarea.value);
			}
		}
	}
	if(send_as && typeof(this.customSend[send_as]) == "function") {
		return this.customSend[send_as](params, form);
	}
	else if(send_as == "json") {
		return u.f.convertNamesToJsonObject(params);
	}
	else if(send_as == "formdata") {
		return params;
	}
	else if(send_as == "object") {
		params.append = null;
		return params;
	}
	else {
		var string = "";
		for(param in params) {
			if(typeof(params[param]) != "function") {
				string += (string ? "&" : "") + param + "=" + encodeURIComponent(params[param]);
			}
		}
		return string;
	}
}
u.f.convertNamesToJsonObject = function(params) {
 	var indexes, root, indexes_exsists, param;
	var object = new Object();
	for(param in params) {
	 	indexes_exsists = param.match(/\[/);
		if(indexes_exsists) {
			root = param.split("[")[0];
			indexes = param.replace(root, "");
			if(typeof(object[root]) == "undefined") {
				object[root] = new Object();
			}
			object[root] = this.recurseName(object[root], indexes, params[param]);
		}
		else {
			object[param] = params[param];
		}
	}
	return object;
}
u.f.recurseName = function(object, indexes, value) {
	var index = indexes.match(/\[([a-zA-Z0-9\-\_]+)\]/);
	var current_index = index[1];
	indexes = indexes.replace(index[0], "");
 	if(indexes.match(/\[/)) {
		if(object.length !== undefined) {
			var i;
			var added = false;
			for(i = 0; i < object.length; i++) {
				for(exsiting_index in object[i]) {
					if(exsiting_index == current_index) {
						object[i][exsiting_index] = this.recurseName(object[i][exsiting_index], indexes, value);
						added = true;
					}
				}
			}
			if(!added) {
				temp = new Object();
				temp[current_index] = new Object();
				temp[current_index] = this.recurseName(temp[current_index], indexes, value);
				object.push(temp);
			}
		}
		else if(typeof(object[current_index]) != "undefined") {
			object[current_index] = this.recurseName(object[current_index], indexes, value);
		}
		else {
			object[current_index] = new Object();
			object[current_index] = this.recurseName(object[current_index], indexes, value);
		}
	}
	else {
		object[current_index] = value;
	}
	return object;
}
u.f.addForm = function(node, settings) {
u.bug("addform")
	var form_name = "js_form";
	var form_action = "#";
	var form_method = "post";
	var form_class = "";
	if(typeof(settings) == "object") {
		var argument;
		for(argument in settings) {
			switch(argument) {
				case "name"			: form_name				= settings[argument]; break;
				case "action"		: form_action			= settings[argument]; break;
				case "method"		: form_method			= settings[argument]; break;
				case "class"		: form_class			= settings[argument]; break;
			}
		}
	}
	var form = u.ae(node, "form", {"class":form_class, "name": form_name, "action":form_action, "method":form_method});
	return form;
}
u.f.addFieldset = function(node) {
	return u.ae(node, "fieldset");
}
u.f.addField = function(node, settings) {
	var field_type = "string";
	var field_label = "Value";
	var field_name = "js_name";
	var field_value = "";
	var field_class = "";
	if(typeof(settings) == "object") {
		var argument;
		for(argument in settings) {
			switch(argument) {
				case "type"			: field_type			= settings[argument]; break;
				case "label"		: field_label			= settings[argument]; break;
				case "name"			: field_name			= settings[argument]; break;
				case "value"		: field_value			= settings[argument]; break;
				case "class"		: field_class			= settings[argument]; break;
			}
		}
	}
	var input_id = "input_"+field_type+"_"+field_name;
	var field = u.ae(node, "div", {"class":"field "+field_type+" "+field_class});
	if(field_type == "string") {
		var label = u.ae(field, "label", {"for":input_id, "html":field_label});
		var input = u.ae(field, "input", {"id":input_id, "value":field_value, "name":field_name, "type":"text"});
	}
	else if(field_type == "email" || field_type == "number" || field_type == "tel") {
		var label = u.ae(field, "label", {"for":input_id, "html":field_label});
		var input = u.ae(field, "input", {"id":input_id, "value":field_value, "name":field_name, "type":field_type});
	}
	else if(field_type == "checkbox") {
		var input = u.ae(field, "input", {"id":input_id, "value":"true", "name":field_name, "type":field_type});
		var label = u.ae(field, "label", {"for":input_id, "html":field_label});
	}
	else if(field_type == "select") {
		u.bug("Select not implemented yet")
	}
	else {
		u.bug("input type not implemented yet")
	}
	return field;
}
u.f.addAction = function(node, settings) {
	var action_type = "submit";
	var action_name = "js_name";
	var action_value = "";
	var action_class = "";
	if(typeof(settings) == "object") {
		var argument;
		for(argument in settings) {
			switch(argument) {
				case "type"			: action_type			= settings[argument]; break;
				case "name"			: action_name			= settings[argument]; break;
				case "value"		: action_value			= settings[argument]; break;
				case "class"		: action_class			= settings[argument]; break;
			}
		}
	}
	var p_ul = node.nodeName.toLowerCase() == "ul" ? node : u.pn(node, "ul");
	if(!u.hc(p_ul, "actions")) {
		p_ul = u.ae(node, "ul", {"class":"actions"});
	}
	var p_li = node.nodeName.toLowerCase() == "li" ? node : u.pn(node, "li");
	if(p_ul != p_li.parentNode) {
		p_li = u.ae(p_ul, "li", {"class":action_name});
	}
	else {
		p_li = node;
	}
	var action = u.ae(p_li, "input", {"type":action_type, "class":action_class, "value":action_value, "name":action_name})
	return action;
}


/*u-events-browser.js*/
u.e.addDOMReadyEvent = function(action) {
	if(document.readyState && document.addEventListener) {
		if((document.readyState == "interactive" && !u.browser("ie")) || document.readyState == "complete" || document.readyState == "loaded") {
			action();
		}
		else {
			var id = u.randomString();
			window["DOMReady_" + id] = action;
			eval('window["_DOMReady_' + id + '"] = function() {window["DOMReady_'+id+'"](); u.e.removeEvent(document, "DOMContentLoaded", window["_DOMReady_' + id + '"])}');
			u.e.addEvent(document, "DOMContentLoaded", window["_DOMReady_" + id]);
		}
	}
	else {
		u.e.addOnloadEvent(action);
	}
}
u.e.addOnloadEvent = function(action) {
	if(document.readyState && (document.readyState == "complete" || document.readyState == "loaded")) {
		action();
	}
	else {
		var id = u.randomString();
		window["Onload_" + id] = action;
		eval('window["_Onload_' + id + '"] = function() {window["Onload_'+id+'"](); u.e.removeEvent(window, "load", window["_Onload_' + id + '"])}');
		u.e.addEvent(window, "load", window["_Onload_" + id]);
	}
}
u.e.addWindowResizeEvent = function(node, action) {
	var id = u.randomString();
	u.ac(node, id);
	eval('window["_Onresize_' + id + '"] = function() {var node = u.qs(".'+id+'"); node._Onresize_'+id+' = '+action+'; node._Onresize_'+id+'();}');
	u.e.addEvent(window, "resize", window["_Onresize_" + id]);
	return id;
}
u.e.removeWindowResizeEvent = function(node, id) {
	u.rc(node, id);
	u.e.removeEvent(window, "resize", window["_Onresize_" + id]);
}
u.e.addWindowScrollEvent = function(node, action) {
	var id = u.randomString();
	u.ac(node, id);
	eval('window["_Onscroll_' + id + '"] = function() {var node = u.qs(".'+id+'"); node._Onscroll_'+id+' = '+action+'; node._Onscroll_'+id+'();}');
	u.e.addEvent(window, "scroll", window["_Onscroll_" + id]);
	return id;
}
u.e.removeWindowScrollEvent = function(node, id) {
	u.rc(node, id);
	u.e.removeEvent(window, "scroll", window["_Onscroll_" + id]);
}
u.e.addWindowMoveEvent = function(node, action) {
	var id = u.randomString();
	u.ac(node, id);
	eval('window["_Onmove_' + id + '"] = function(event) {var node = u.qs(".'+id+'"); node._Onmove_'+id+' = '+action+'; node._Onmove_'+id+'(event);}');
	u.e.addMoveEvent(window, window["_Onmove_" + id]);
	return id;
}
u.e.removeWindowMoveEvent = function(node, id) {
	u.rc(node, id);
	u.e.removeMoveEvent(window, window["_Onmove_" + id]);
}
u.e.addWindowEndEvent = function(node, action) {
	var id = u.randomString();
	u.ac(node, id);
	eval('window["_Onend_' + id + '"] = function(event) {var node = u.qs(".'+id+'"); node._Onend_'+id+' = '+action+'; node._Onend_'+id+'(event);}');
	u.e.addEndEvent(window, window["_Onend_" + id]);
	return id;
}
u.e.removeWindowEndEvent = function(node, id) {
	u.rc(node, id);
	u.e.removeEndEvent(window, window["_Onend_" + id]);
}


/*i-page-desktop.js*/
u.bug_console_only = true;
Util.Objects["page"] = new function() {
	this.init = function(page) {
			page.style_tag = document.createElement("style");
			page.style_tag.setAttribute("media", "all")
			page.style_tag.setAttribute("type", "text/css")
			page.style_tag = u.ae(document.head, page.style_tag);
			page.hN = u.qs("#header");
			page.hN.service = u.qs(".servicenavigation", page.hN);
			page.cN = u.qs("#content", page);
			page.nN = u.qs("#navigation", page);
			page.nN = u.ie(page.hN, page.nN);
			page.fN = u.qs("#footer");
			page.fN.service = u.qs(".servicenavigation", page.fN);
			page.fN.slogan = u.qs("p", page.fN);
			if(page.fN.slogan) {
				u.ce(page.fN.slogan);
				page.fN.slogan.clicked = function(event) {
					window.open("http://parentnode.dk");
				}
			}
			page.logo = u.ie(page.hN, "a", {"class":"logo", "html":u.eitherOr(u.site_name, "Frontpage")});
			page.logo.url = '/';
			page.logo.font_size = parseInt(u.gcs(page.logo, "font-size"));
			page.logo.font_size_gap = page.logo.font_size-14;
			page.logo.top_offset = u.absY(page.nN) + parseInt(u.gcs(page.nN, "padding-top"));
			page.style_tag.sheet.insertRule("#header a.logo {}", 0);
			page.logo.css_rule = page.style_tag.sheet.cssRules[0];
			page.resized = function() {
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
				if(page.cN && page.cN.scene) {
					if(typeof(page.cN.scene.resized) == "function") {
						page.cN.scene.resized();
					}
				}
			}
			page.scrolled = function() {
				page.scrolled_y = u.scrollY();
				if(page.scrolled_y < page.logo.top_offset) {
					page.logo.is_reduced = false;
					var reduce_font = (1-(page.logo.top_offset-page.scrolled_y)/page.logo.top_offset) * page.logo.font_size_gap;
					page.logo.css_rule.style.setProperty("font-size", (page.logo.font_size-reduce_font)+"px", "important");
				}
				else if(!page.logo.is_reduced) {
					page.logo.is_reduced = true;
					page.logo.css_rule.style.setProperty("font-size", (page.logo.font_size-page.logo.font_size_gap)+"px", "important");
				}
				if(page.nN.top_offset && page.scrolled_y < page.nN.top_offset) {
					page.nN.is_reduced = false;
					var factor = (1-(page.nN.top_offset-page.scrolled_y)/page.nN.top_offset);
					var reduce_font = factor * page.nN.font_size_gap;
					page.nN.list.css_rule.style.setProperty("font-size", (page.nN.font_size-reduce_font)+"px", "important");
					var reduce_top = factor * page.nN.top_offset_gap;
					page.nN.css_rule.style.setProperty("top", (page.nN.top_offset-reduce_top)+"px", "important");
				}
				else if(page.nN.top_offset && !page.nN.is_reduced) {
					page.nN.is_reduced = true;
					page.nN.list.css_rule.style.setProperty("font-size", (page.nN.font_size-page.nN.font_size_gap)+"px", "important");
					page.nN.css_rule.style.setProperty("top", (page.nN.top_offset-page.nN.top_offset_gap)+"px", "important");
				}
				if(page.cN && page.cN.scene && typeof(page.cN.scene.scrolled) == "function") {
					page.cN.scene.scrolled();
				}
			}
			page.ready = function() {
				if(!this.is_ready) {
					this.is_ready = true;
					u.e.addEvent(window, "resize", page.resized);
					u.e.addEvent(window, "scroll", page.scrolled);
					this.initNavigation();
					this.resized();
					if(!u.getCookie("terms_v1")) {
					}
				}
			}
			page.initNavigation = function() {
				var i, node;
				page.nN.list = u.qs("ul", page.nN);
				page.nN.list.nodes = u.qsa("li", page.nN);
				if(page.nN.list.nodes.length) {
					page.nN.font_size = parseInt(u.gcs(page.nN.list.nodes[1], "font-size"));
					page.nN.font_size_gap = page.nN.font_size-14;
					page.nN.top_offset = u.absY(page.nN) + parseInt(u.gcs(page.nN, "padding-top"));
					page.nN.top_offset_gap = page.nN.top_offset-10;
					page.style_tag.sheet.insertRule("#navigation {}", 0);
					page.nN.css_rule = page.style_tag.sheet.cssRules[0];
					page.style_tag.sheet.insertRule("#navigation ul li {}", 0);
					page.nN.list.css_rule = page.style_tag.sheet.cssRules[0];
					this.hN.nodes = u.qsa("#navigation li,.servicenavigation li,a.logo", page.hN);
					for(i = 0; node = this.hN.nodes[i]; i++) {
						u.ce(node, {"type":"link"});
						node._mousedover = function() {
							this.transitioned = function() {
								this.transitioned = function() {
									this.transitioned = function() {
										u.a.transition(this, "none");
									}
									u.a.transition(this, "all 0.1s ease-in-out");
									u.a.scale(this, 1.2);
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
								u.a.transition(this, "all 0.1s ease-in");
								u.a.scale(this, 1);
							}
							u.a.transition(this, "all 0.1s ease-in");
							u.a.scale(this, 0.8);
						}
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
			}
			page.ready();
	}
}
u.e.addDOMReadyEvent(u.init);


/*i-login-desktop.js*/
Util.Objects["login"] = new function() {
	this.init = function(scene) {
		u.bug("scene init:" + u.nodeId(scene))
		scene.resized = function() {
		}
		scene.scrolled = function() {
		}
		scene.ready = function() {
			this._form = u.qs("form", this);
			u.f.init(this._form);
			page.cN.scene = this;
			page.resized();
		}
		scene.ready();
	}
}


/*i-article-desktop.js*/
Util.Objects["articlelist"] = new function() {
	this.init = function(list) {
		list.popstate = ("onpopstate" in window);
		list.items = u.qsa(".item", list);
		list.scrolled = function() {
			var scroll_y = u.scrollY()
			var browser_h = u.browserH();
			var screen_middle = browser_h/2;
			var i, node, node_y, list_y;
			list_y = u.absY(this);
			if(this._prev && list_y + browser_h > scroll_y) {
				this.loadPrev();
			}
			else if(this._next && list_y + this.offsetHeight < scroll_y + (browser_h*2)) {
				this.loadNext();
			}
			for(i = 0; node = this.items[i]; i++) {
				node_y = u.absY(node);
				if(!node._ready && node_y - 200 < scroll_y+browser_h && node_y + 200 > scroll_y) {
					u.o.article.init(node);
					node._ready = true;
				}
				if(this.popstate && node._ready && node.hardlink) {
					if(node_y <= scroll_y + screen_middle && node_y + node.offsetHeight > scroll_y + screen_middle) {
						history.replaceState({}, node.hardlink, node.hardlink);
					}
				}
			}
		}
		u.e.addWindowScrollEvent(list, list.scrolled);
		var next_link = u.qs(".pagination li.next a", list.parentNode);
		var prev_link = u.qs(".pagination li.previous a", list.parentNode);
		list._prev = prev_link ? prev_link.href : false;
		list._next = next_link ? next_link.href : false;
		list.loadPrev = function() {
			if(this._prev) {
				u.bug("load prev function")
				this.response = function(response) {
					var items = u.qsa(".item", response);
					var i, node;
					for(i = items.length; i; i--) {
						node = u.ie(this, items[i-1]);
						u.bug("u.scrollY:" + u.scrollY())
						window.scrollTo(0, u.scrollY()+node.offsetHeight);
					}
					var prev_link = u.qs(".pagination li.previous a", response);
					this._prev = prev_link ? prev_link.href : false;
					this.items = u.qsa(".item", this);
				}
				u.request(this, this._prev);
				this._prev = false;
			}
		}
		list.loadNext = function() {
			if(this._next) {
				this.response = function(response) {
					var items = u.qsa(".item", response);
					var i;
					for(i = 0; i < items.length; i++) {
						u.ae(this, items[i]);
					}
					var next_link = u.qs(".pagination li.next a", response);
					this._next = next_link ? next_link.href : false;
					this.items = u.qsa(".item", this);
				}
				u.request(this, this._next);
				this._next = false;
			}
		}
		if(list._prev) {
			list.content_y = u.absY(u.qs("h1"));
			list.start_y = u.absY(list.items[0]);
			window.scrollTo(0, list.start_y-list.content_y);
		}
		else if(u.scrollY()) {
			window.scrollTo(0, 0);
		}
		list.scrolled();
	}
}
Util.Objects["article"] = new function() {
	this.init = function(article) {
		var hardlink = u.qs("dd.hardlink a", article);
		article.hardlink = hardlink ? hardlink.href : false;
		var i, image;
		article._images = u.qsa("div.image", article);
		for(i = 0; image = article._images[i]; i++) {
			image._id = u.cv(image, "image_id");
			image._format = u.cv(image, "format");
			image._variant = u.cv(image, "variant");
			if(image._id && image._format) {
				image._image_src = "/images/" + image._id + "/" + (image._variant ? image._variant+"/" : "") + image.offsetWidth + "x." + image._format;
				image._image = u.ie(image, "img");
				u.a.setOpacity(image, 0);
				image.loaded = function(queue) {
					if(u.absY(this) < u.scrollY()) {
						window.scrollTo(0, u.scrollY()+queue[0].image.height)
					}
					this._image.src = queue[0].image.src;
					u.a.transition(this, "all 0.5s ease-in-out");
					u.a.setOpacity(this, 1);
				}
				u.preloader(image, [image._image_src]);
				u.ce(image);
				image.clicked = function() {
					if(u.hc(this, "fullsize")) {
						u.a.transition(this._image, "all 0.3s ease-in-out");
						u.rc(this, "fullsize");
						this._image.src = this._image_src;
					}
					else {
						u.a.transition(this._image, "all 0.3s ease-in-out");
						u.ac(this, "fullsize");
						if(this._fullsize_src) {
							this._image.src = this._fullsize_src;
						}
						else {
							this._fullsize_width = 1300;
							this._fullsize_src = "/images/" + this._id + "/" + (this._variant ? this._variant+"/" : "") + this._fullsize_width + "x." + this._format;
							this.response = function() {
								this._image.src = this._fullsize_src;
							}
							this.responseError = function() {
								this._fullsize_width = this._fullsize_width-200;
								this._fullsize_src = "/images/" + this._id + "/" + (this._variant ? this._variant+"/" : "") + this._fullsize_width + "x." + this._format;
								u.request(this, this._fullsize_src);
							}
							u.request(this, this._fullsize_src);
						}
					}
				}
			}
		}
		article.geolocation = u.qs("dl.geo", article);
		if(article.geolocation) {
			article.geolocation.article = article;
			u.bug("article.geolocation:" + article.geolocation)
			var dd_longitude = u.qs("dd.longitude", article.geolocation);
			var dd_latitude = u.qs("dd.latitude", article.geolocation);
			if(dd_longitude && dd_latitude) {
				article.geo_longitude = parseFloat(dd_longitude.innerHTML);
				article.geo_latitude = parseFloat(dd_latitude.innerHTML);
				article.showMap = function() {
					if(!this.geomap) {
						this.geomap = u.ae(this, "div", {"class":"geomap"});
						this.insertBefore(this.geomap, u.qs("dl.info", this));
						var maps_url = "https://maps.googleapis.com/maps/api/js" + (u.gapi_key ? "?key="+u.gapi_key : "");
						var html = '<html><head>';
						html += '<style type="text/css">body {margin: 0;}#map {height: 100%;}</style>';
						html += '<script type="text/javascript" src="'+maps_url+'"></script>';
						html += '<script type="text/javascript">';
						html += 'var map, marker;';
						html += 'var initialize = function() {';
						html += '	window._map_loaded = true;';
						html += '	var mapOptions = {center: new google.maps.LatLng('+this.geo_latitude+', '+this.geo_longitude+'),zoom: 12};';
						html += '	map = new google.maps.Map(document.getElementById("map"),mapOptions);';
						html += '	marker = new google.maps.Marker({position: new google.maps.LatLng('+this.geo_latitude+', '+this.geo_longitude+'), draggable:true});';
						html += '	marker.setMap(map);';
						html += '};';
						html += 'google.maps.event.addDomListener(window, "load", initialize);';
						html += '</script>';
						html += '</head><body><div id="map"></div></body></html>';
						this.mapsiframe = u.ae(this.geomap, "iframe");
						this.mapsiframe.doc = this.mapsiframe.contentDocument? this.mapsiframe.contentDocument: this.mapsiframe.contentWindow.document;
						this.mapsiframe.doc.open();
						this.mapsiframe.doc.write(html);
						this.mapsiframe.doc.close();
					}
				}
				article.geolocation.clicked = function() {
					this.article.showMap();
				}
				u.ce(article.geolocation);
				u.ac(article.geolocation, "active");
			}
		}
		// 	
		// 	
		// 	
	}
}



/*i-documentation-desktop.js*/
Util.Objects["docsindex"] = new function() {
	this.init = function(scene) {
		var files = u.qsa(".files li", scene);
		var i, node;
		scene.div_search = u.qs(".search", scene);
		scene.div_search.h2 = u.ae(scene.div_search, "h2", {"html":"Search utilities and tools"});
		var form = u.f.addForm(scene.div_search, {"class":"labelstyle:inject"});
		var fieldset = u.f.addFieldset(form);
		var field = u.f.addField(fieldset, {"name":"search", "label":"Search term of minimum 3 chars"})
		u.f.init(form);
		field._input.div_search = scene.div_search;
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
					_function._definition = u.qs(".definition", _function);
					_function._description = u.qs(".description", _function);
					u.as(_function, "display", "none");
				}
			}
			u.request(node, node.url);
		}
		field._input._autocomplete = function() {
			var i, _function;
			u.ac(this.div_search, "loading");
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
			u.rc(this.div_search, "loading");
		}
		field._input._keyup = function(event) {
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
		var functions = u.qsa(".function", scene);
		for(i = 0; func = functions[i]; i++) {
			func._header = u.qs(".header", func);
			func._header._func = func;
			func._body = u.qs(".body", func);
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
	}
}
