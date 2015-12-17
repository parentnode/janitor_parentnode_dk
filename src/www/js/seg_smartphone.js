
/*seg_smartphone_include.js*/

/*seg_smartphone_include.js*/

/*seg_mobile_touch.js*/
if(!u || !Util) {
	var u, Util = u = new function() {};
	u.version = 0.9;
	u.bug = u.nodeId = u.exception = function() {};
	u.stats = new function() {this.pageView = function(){};this.event = function(){};this.customVar = function(){};}
}
Util.debugURL = function(url) {
	if(u.bug_force) {
		return true;
	}
	return document.domain.match(/.local$/);
}
Util.nodeId = function(node, include_path) {
	try {
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
	}
	catch(exception) {
		u.exception("u.nodeId", arguments, exception);
	}
	return "Unindentifiable node!";
}
Util.exception = function(name, arguments, exception) {
	u.bug("Exception in: " + name + " (" + exception + ")");
	u.bug("Invoked with arguments:");
	u.xInObject(arguments);
	u.bug("Called from:");
	if(arguments.callee.caller.name) {
		u.bug("arguments.callee.caller.name:" + arguments.callee.caller.name)
	}
	else {
		u.bug("arguments.callee.caller:" + arguments.callee.caller.toString().substring(0, 250));
	}
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
Util.xInObject = function(object, _options) {
	if(u.debugURL()) {
		var return_string = false;
		var explore_objects = false;
		if(typeof(_options) == "object") {
			var _argument;
			for(_argument in _options) {
				switch(_argument) {
					case "return"     : return_string               = _options[_argument]; break;
					case "objects"    : explore_objects             = _options[_argument]; break;
				}
			}
		}
		var x, s = "--- start object ---\n";
		for(x in object) {
			if(explore_objects && object[x] && typeof(object[x]) == "object" && typeof(object[x].nodeName) != "string") {
				s += x + "=" + object[x]+" => \n";
				s += u.xInObject(object[x], true);
			}
			else if(object[x] && typeof(object[x]) == "object" && typeof(object[x].nodeName) == "string") {
				s += x + "=" + object[x]+" -> " + u.nodeId(object[x], 1) + "\n";
			}
			else if(object[x] && typeof(object[x]) == "function") {
				s += x + "=function\n";
			}
			else {
				s += x + "=" + object[x]+"\n";
			}
		}
		s += "--- end object ---\n";
		if(return_string) {
			return s;
		}
		else {
			u.bug(s);
		}
	}
}
Util.Animation = u.a = new function() {
	this.support3d = function() {
		if(this._support3d === undefined) {
			var node = document.createElement("div");
			try {
				var test = "translate3d(10px, 10px, 10px)";
				node.style[this.vendor("Transform")] = test;
				if(node.style[this.vendor("Transform")] == test) {
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
	this._vendor_exceptions = {
		"mozTransform":"MozTransform","mozTransition":"MozTransition","mozTransitionEnd":"transitionend","mozTransformOrigin":"MozTransformOrigin"
	};
	this._vendor_methods = {};
 	this.vendorMethod = function(method) {
		var vender_method = this._vendor+method;
		method = this._vendor ? method.replace(/^([a-z]{1})/, function(word){return word.toUpperCase()}) : method;
		if(this._vendor_exceptions[this._vendor+method]) {
			this._vendor_methods[vender_method] = this._vendor_exceptions[this._vendor+method];
			return;
		}
 		this._vendor_methods[vender_method] = this._vendor+method;
 		return;
	}
	this.vendor = function(method) {
		if(this._vendor === undefined) {
			if(document.documentElement.style.webkitTransform != undefined) {
				this._vendor = "webkit";
			}
			else if(document.documentElement.style.MozTransform != undefined) {
				this._vendor = "moz";
			}
			else if(document.documentElement.style.oTransform != undefined) {
				this._vendor = "o";
			}
			else if(document.documentElement.style.msTransform != undefined) {
				this._vendor = "ms";
			}
			else {
				this._vendor = "";
			}
		}
		if(!method) {
			return this._vendor;
		}
		if(this._vendor_methods[this._vendor+method] === undefined) {
			this.vendorMethod(method);
		}
		return this._vendor_methods[this._vendor+method];
	}
	this.transition = function(node, transition) {
		try {
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
			node.style[this.vendor("Transition")] = transition;
			u.e.addEvent(node, this.vendor("transitionEnd"), this._transitioned);
		}
		catch(exception) {
			u.exception("u.a.transition", arguments, exception);
		}
	}
	this._transitioned = function(event) {
		if(event.target == this && typeof(this.transitioned) == "function") {
			this.transitioned(event);
		}
		u.a.transition(this, "none");
	}
	this.removeTransform = function(node) {
		node.style[this.vendor("Transform")] = "none";
	}
	this.origin = function(node, x, y) {
		node.style[this.vendor("TransformOrigin")] = x +"px "+ y +"px";
		node._origin_x = x;
		node._origin_y = y;
		node.offsetHeight;
	}
	this.translate = function(node, x, y) {
		if(this.support3d()) {
			node.style[this.vendor("Transform")] = "translate3d("+x+"px, "+y+"px, 0)";
		}
		else {
			node.style[this.vendor("Transform")] = "translate("+x+"px, "+y+"px)";
		}
		node._x = x;
		node._y = y;
		node.offsetHeight;
	}
	this.rotate = function(node, deg) {
		node.style[this.vendor("Transform")] = "rotate("+deg+"deg)";
		node._rotation = deg;
		node.offsetHeight;
	}
	this.scale = function(node, scale) {
		node.style[this.vendor("Transform")] = "scale("+scale+")";
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
		node.style[this.vendor("Transform")] = "rotate("+deg+"deg) scale("+scale+")";
		node._rotation = deg;
		node._scale = scale;
		node.offsetHeight;
	}
	this.scaleRotateTranslate = function(node, scale, deg, x, y) {
		if(this.support3d()) {
			node.style[this.vendor("Transform")] = "scale("+scale+") rotate("+deg+"deg) translate3d("+x+"px, "+y+"px, 0)";
		}
		else {
			node.style[this.vendor("Transform")] = "scale("+scale+") rotate("+deg+"deg) translate("+x+"px, "+y+"px)";
		}
		node._rotation = deg;
		node._scale = scale;
		node._x = x;
		node._y = y;
		node.offsetHeight;
	}
	this._animationqueue = {};
	this.requestAnimationFrame = function(node, callback, duration) {
		var start = new Date().getTime();
		var id = u.randomString();
		u.a._animationqueue[id] = {};
		u.a._animationqueue[id].id = id;
		u.a._animationqueue[id].node = node;
		u.a._animationqueue[id].callback = callback;
		u.a._animationqueue[id].start = start;
		u.a._animationqueue[id].duration = duration;
		u.t.setTimer(u.a, function() {u.a.finalAnimationFrame(id)}, duration);
		if(!u.a._animationframe) {
			window._requestAnimationFrame = eval(this.vendor("requestAnimationFrame"));
			window._cancelAnimationFrame = eval(this.vendor("cancelAnimationFrame"));
			u.a._animationframe = function(timestamp) {
				var id, animation;
				for(id in u.a._animationqueue) {
					animation = u.a._animationqueue[id];
					animation.node[animation.callback]((timestamp-animation.start) / animation.duration);
				}
				if(Object.keys(u.a._animationqueue).length) {
					u.a._requestAnimationId = window._requestAnimationFrame(u.a._animationframe);
				}
			}
		}
		if(!u.a._requestAnimationId) {
			u.a._requestAnimationId = window._requestAnimationFrame(u.a._animationframe);
		}
		return id;
	}
	this.finalAnimationFrame = function(id) {
		var animation = u.a._animationqueue[id];
		animation.node[animation.callback](1);
		if(typeof(animation.node.transitioned) == "function") {
			animation.node.transitioned({});
		}
		delete animation;
		delete u.a._animationqueue[id];
		if(!Object.keys(u.a._animationqueue).length) {
			this.cancelAnimationFrame(id);
		}
	}
	this.cancelAnimationFrame = function(id) {
		if(id && u.a._animationqueue[id]) {
			delete u.a._animationqueue[id];
		}
		if(u.a._requestAnimationId) {
			window._cancelAnimationFrame(u.a._requestAnimationId);
			u.a._requestAnimationId = false;
		}
	}
}
Util.audioPlayer = function(_options) {
	var player = document.createElement("div");
	u.ac(player, "audioplayer");
	player._autoplay = false;
	player._controls = false;
	player._controls_playpause = false;
	player._controls_volume = false;
	player._controls_search = false;
	player._ff_skip = 2;
	player._rw_skip = 2;
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "autoplay"     : player._autoplay               = _options[_argument]; break;
				case "controls"     : player._controls               = _options[_argument]; break;
				case "playpause"    : player._controls_playpause     = _options[_argument]; break;
				case "volume"       : player._controls_volume        = _options[_argument]; break;
				case "search"       : player._controls_search        = _options[_argument]; break;
				case "ff_skip"      : player._ff_skip                = _options[_argument]; break;
				case "rw_skip"      : player._rw_skip                = _options[_argument]; break;
			}
		}
	}
	player.audio = u.ae(player, "audio");
	if(typeof(player.audio.play) == "function") {
		player.load = function(src, _options) {
			if(typeof(_options) == "object") {
				var _argument;
				for(_argument in _options) {
					switch(_argument) {
						case "autoplay"     : this._autoplay               = _options[_argument]; break;
						case "controls"     : this._controls               = _options[_argument]; break;
						case "playpause"    : this._controls_playpause     = _options[_argument]; break;
						case "volume"       : this._controls_volume        = _options[_argument]; break;
						case "search"       : this._controls_search        = _options[_argument]; break;
						case "ff_skip"      : this._ff_skip                = _options[_argument]; break;
						case "rw_skip"      : this._rw_skip                = _options[_argument]; break;
					}
				}
			}
			if(u.hc(this, "playing")) {
				this.stop();
			}
			this.setup();
			if(src) {
				this.audio.src = this.correctSource(src);
				this.audio.load();
				this.audio.controls = player._controls;
				this.audio.autoplay = player._autoplay;
			}
		}
		player.play = function(position) {
			if(this.audio.currentTime && position !== undefined) {
				this.audio.currentTime = position;
			}
			if(this.audio.src) {
				this.audio.play();
			}
		}
		player.loadAndPlay = function(src, _options) {
			var position = 0;
			if(typeof(_options) == "object") {
				var _argument;
				for(_argument in _options) {
					switch(_argument) {
						case "position"		: position		= _options[_argument]; break;
					}
				}
			}
			this.load(src, _options);
			this.play(position);
		}
		player.pause = function() {
			this.audio.pause();
		}
		player.stop = function() {
			this.audio.pause();
			if(this.audio.currentTime) {
				this.audio.currentTime = 0;
			}
		}
		player.ff = function() {
			if(this.audio.src && this.audio.currentTime && this.audioLoaded) {
				this.audio.currentTime = (this.audio.duration - this.audio.currentTime >= this._ff_skip) ? (this.audio.currentTime + this._ff_skip) : this.audio.duration;
				this.audio._timeupdate();
			}
		}
		player.rw = function() {
			if(this.audio.src && this.audio.currentTime && this.audioLoaded) {
				this.audio.currentTime = (this.audio.currentTime >= this._rw_skip) ? (this.audio.currentTime - this._rw_skip) : 0;
				this.audio._timeupdate();
			}
		}
		player.togglePlay = function() {
			if(u.hc(this, "playing")) {
				this.pause();
			}
			else {
				this.play();
			}
		}
		player.setup = function() {
			if(this.audio) {
				var audio = this.removeChild(this.audio);
				delete audio;
			}
			this.audio = u.ie(this, "audio");
			this.audio.player = this;
			this.setControls();
			this.currentTime = 0;
			this.duration = 0;
			this.audioLoaded = false;
			this.metaLoaded = false;
			this.audio._loadstart = function(event) {
				u.ac(this.player, "loading");
				if(typeof(this.player.loading) == "function") {
					this.player.loading(event);
				}
			}
			u.e.addEvent(this.audio, "loadstart", this.audio._loadstart);
			this.audio._canplaythrough = function(event) {
				u.rc(this.player, "loading");
				if(typeof(this.player.canplaythrough) == "function") {
					this.player.canplaythrough(event);
				}
			}
			u.e.addEvent(this.audio, "canplaythrough", this.audio._canplaythrough);
			this.audio._playing = function(event) {
				u.rc(this.player, "loading|paused");
				u.ac(this.player, "playing");
				if(typeof(this.player.playing) == "function") {
					this.player.playing(event);
				}
			}
			u.e.addEvent(this.audio, "playing", this.audio._playing);
			this.audio._paused = function(event) {
				u.rc(this.player, "playing|loading");
				u.ac(this.player, "paused");
				if(typeof(this.player.paused) == "function") {
					this.player.paused(event);
				}
			}
			u.e.addEvent(this.audio, "pause", this.audio._paused);
			this.audio._stalled = function(event) {
				u.rc(this.player, "playing|paused");
				u.ac(this.player, "loading");
				if(typeof(this.player.stalled) == "function") {
					this.player.stalled(event);
				}
			}
			u.e.addEvent(this.audio, "stalled", this.audio._paused);
			this.audio._ended = function(event) {
				u.rc(this.player, "playing|paused");
				if(typeof(this.player.ended) == "function") {
					this.player.ended(event);
				}
			}
			u.e.addEvent(this.audio, "ended", this.audio._ended);
			this.audio._loadedmetadata = function(event) {
				this.player.duration = this.duration;
				this.player.currentTime = this.currentTime;
				this.player.metaLoaded = true;
				if(typeof(this.player.loadedmetadata) == "function") {
					this.player.loadedmetadata(event);
				}
			}
			u.e.addEvent(this.audio, "loadedmetadata", this.audio._loadedmetadata);
			this.audio._loadeddata = function(event) {
				this.player.audioLoaded = true;
				if(typeof(this.player.loadeddata) == "function") {
					this.player.loadeddata(event);
				}
			}
			u.e.addEvent(this.audio, "loadeddata", this.audio._loadeddata);
			this.audio._timeupdate = function(event) {
				this.player.currentTime = this.currentTime;
				if(typeof(this.player.timeupdate) == "function") {
					this.player.timeupdate(event);
				}
			}
			u.e.addEvent(this.audio, "timeupdate", this.audio._timeupdate);
		}
	}
	else if(typeof(u.audioPlayerFallback) == "function") {
		player.removeChild(player.video);
		player = u.audioPlayerFallback(player);
	}
	else {
		player.load = function() {}
		player.play = function() {}
		player.loadAndPlay = function() {}
		player.pause = function() {}
		player.stop = function() {}
		player.ff = function() {}
		player.rw = function() {}
		player.togglePlay = function() {}
	}
	player.correctSource = function(src) {
		var param = src.match(/\?[^$]+/) ? src.match(/(\?[^$]+)/)[1] : "";
		src = src.replace(/\?[^$]+/, "");
		src = src.replace(/.mp3|.ogg|.wav/, "");
		if(this.flash) {
			return src+".mp3"+param;
		}
		if(this.audio.canPlayType("audio/mpeg")) {
			return src+".mp3"+param;
		}
		else if(this.audio.canPlayType("audio/ogg")) {
			return src+".ogg"+param;
		}
		else {
			return src+".wav"+param;
		}
	}
	player.setControls = function() {
		if(this.showControls) {
			if(u.e.event_pref == "mouse") {
				u.e.removeEvent(this, "mousemove", this.showControls);
				u.e.removeEvent(this.controls, "mouseenter", this._keepControls);
				u.e.removeEvent(this.controls, "mouseleave", this._unkeepControls);
			}
			else {
				u.e.removeEvent(this, "touchstart", this.showControls);
			}
		}
		if(this._controls_playpause || this._controls_zoom || this._controls_volume || this._controls_search) {
			if(!this.controls) {
				this.controls = u.ae(this, "div", {"class":"controls"});
				this.controls.player = this;
				this.controls._default_display = u.gcs(this.controls, "display");
				this.hideControls = function() {
					if(!this._keep) {
						this.t_controls = u.t.resetTimer(this.t_controls);
						u.a.transition(this.controls, "all 0.3s ease-out");
						u.a.setOpacity(this.controls, 0);
					}
				}
				this.showControls = function() {
					if(this.t_controls) {
						this.t_controls = u.t.resetTimer(this.t_controls);
					}
					else {
						u.a.transition(this.controls, "all 0.5s ease-out");
						u.a.setOpacity(this.controls, 1);
					}
					this.t_controls = u.t.setTimer(this, this.hideControls, 1500);
				}
				this._keepControls = function() {
					this.player._keep = true;
				}
				this._unkeepControls = function() {
					this.player._keep = false;
				}
			}
			else {
				u.as(this.controls, "display", this.controls._default_display);
			}
			if(this._controls_playpause) {
				if(!this.controls.playpause) {
					this.controls.playpause = u.ae(this.controls, "a", {"class":"playpause"});
					this.controls.playpause._default_display = u.gcs(this.controls.playpause, "display");
					this.controls.playpause.player = this;
					u.e.click(this.controls.playpause);
					this.controls.playpause.clicked = function(event) {
						this.player.togglePlay();
					}
				}
				else {
					u.as(this.controls.playpause, "display", this.controls.playpause._default_display);
				}
			}
			else if(this.controls.playpause) {
				u.as(this.controls.playpause, "display", "none");
			}
			if(this._controls_search) {
				if(!this.controls.search) {
					this.controls.search_ff = u.ae(this.controls, "a", {"class":"ff"});
					this.controls.search_ff._default_display = u.gcs(this.controls.search_ff, "display");
					this.controls.search_ff.player = this;
					this.controls.search_rw = u.ae(this.controls, "a", {"class":"rw"});
					this.controls.search_rw._default_display = u.gcs(this.controls.search_rw, "display");
					this.controls.search_rw.player = this;
					u.e.click(this.controls.search_ff);
					this.controls.search_ff.ffing = function() {
						this.t_ffing = u.t.setTimer(this, this.ffing, 100);
						this.player.ff();
					}
					this.controls.search_ff.inputStarted = function(event) {
						this.ffing();
					}
					this.controls.search_ff.clicked = function(event) {
						u.t.resetTimer(this.t_ffing);
					}
					u.e.click(this.controls.search_rw);
					this.controls.search_rw.rwing = function() {
						this.t_rwing = u.t.setTimer(this, this.rwing, 100);
						this.player.rw();
					}
					this.controls.search_rw.inputStarted = function(event) {
						this.rwing();
					}
					this.controls.search_rw.clicked = function(event) {
						u.t.resetTimer(this.t_rwing);
						this.player.rw();
					}
					this.controls.search = true;
				}
				else {
					u.as(this.controls.search_ff, "display", this.controls.search_ff._default_display);
					u.as(this.controls.search_rw, "display", this.controls.search_rw._default_display);
				}
			}
			else if(this.controls.search) {
				u.as(this.controls.search_ff, "display", "none");
				u.as(this.controls.search_rw, "display", "none");
			}
			if(this._controls_zoom && !this.controls.zoom) {}
			else if(this.controls.zoom) {}
			if(this._controls_volume && !this.controls.volume) {}
			else if(this.controls.volume) {}
			if(u.e.event_pref == "mouse") {
				u.e.addEvent(this.controls, "mouseenter", this._keepControls);
				u.e.addEvent(this.controls, "mouseleave", this._unkeepControls);
				u.e.addEvent(this, "mousemove", this.showControls);
			}
			else {
				u.e.addEvent(this, "touchstart", this.showControls);
			}
		}
		else if(this.controls) {
			u.as(this.controls, "display", "none");
		}
	}
	return player;
}
Util.saveCookie = function(name, value, _options) {
	expiry = false;
	path = false;
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "expiry"	: expiry	= (typeof(_options[_argument]) == "string" ? _options[_argument] : "Mon, 04-Apr-2020 05:00:00 GMT"); break;
				case "path"		: path		= _options[_argument]; break;
			}
		}
	}
	document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) +";" + (path ? "path="+path+";" : "") + (expiry ? "expires="+expiry+";" : "")
}
Util.getCookie = function(name) {
	var matches;
	return (matches = document.cookie.match(encodeURIComponent(name) + "=([^;]+)")) ? decodeURIComponent(matches[1]) : false;
}
Util.deleteCookie = function(name, _options) {
	path = false;
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "path"	: path	= _options[_argument]; break;
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
	try {
		scope = scope ? scope : document;
		return scope.querySelectorAll(query);
	}
	catch(exception) {
		u.exception("u.qsa", arguments, exception);
	}
	return [];
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
Util.parentNode = u.pn = function(node, _options) {
	var exclude = "";
	var include = "";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "include"      : include       = _options[_argument]; break;
				case "exclude"      : exclude       = _options[_argument]; break;
			}
		}
	}
	var exclude_nodes = exclude ? u.qsa(exclude) : [];
	var include_nodes = include ? u.qsa(include) : [];
	node = node.parentNode;
	while(node && (node.nodeType == 3 || node.nodeType == 8 || (exclude && (u.inNodeList(node, exclude_nodes))) || (include && (!u.inNodeList(node, include_nodes))))) {
		node = node.parentNode;
	}
	return node;
}
Util.previousSibling = u.ps = function(node, _options) {
	var exclude = "";
	var include = "";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "include"      : include       = _options[_argument]; break;
				case "exclude"      : exclude       = _options[_argument]; break;
			}
		}
	}
	var exclude_nodes = exclude ? u.qsa(exclude, node.parentNode) : [];
	var include_nodes = include ? u.qsa(include, node.parentNode) : [];
	node = node.previousSibling;
	while(node && (node.nodeType == 3 || node.nodeType == 8 || (exclude && (u.inNodeList(node, exclude_nodes))) || (include && (!u.inNodeList(node, include_nodes))))) {
		node = node.previousSibling;
	}
	return node;
}
Util.nextSibling = u.ns = function(node, _options) {
	var exclude = "";
	var include = "";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "include"      : include       = _options[_argument]; break;
				case "exclude"      : exclude       = _options[_argument]; break;
			}
		}
	}
	var exclude_nodes = exclude ? u.qsa(exclude, node.parentNode) : [];
	var include_nodes = include ? u.qsa(include, node.parentNode) : [];
	node = node.nextSibling;
	while(node && (node.nodeType == 3 || node.nodeType == 8 || (exclude && (u.inNodeList(node, exclude_nodes))) || (include && (!u.inNodeList(node, include_nodes))))) {
		node = node.nextSibling;
	}
	return node;
}
Util.childNodes = u.cn = function(node, _options) {
	var exclude = "";
	var include = "";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "include"      : include       = _options[_argument]; break;
				case "exclude"      : exclude       = _options[_argument]; break;
			}
		}
	}
	var exclude_nodes = exclude ? u.qsa(exclude, node) : [];
	var include_nodes = include ? u.qsa(include, node) : [];
	var i, child;
	var children = new Array();
	for(i = 0; child = node.childNodes[i]; i++) {
		if(child && child.nodeType != 3 && child.nodeType != 8 && (!exclude || (!u.inNodeList(child, exclude_nodes))) && (!include || (u.inNodeList(child, include_nodes)))) {
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
		u.exception("u.ae", arguments, exception);
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
		u.exception("u.ie", arguments, exception);
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
		u.exception("u.we", arguments, exception);
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
		u.exception("u.wc", arguments, exception);
	}
	return false;
}
Util.textContent = u.text = function(node) {
	try {
		return node.textContent;
	}
	catch(exception) {
		u.exception("u.text", arguments, exception);
	}
}
Util.clickableElement = u.ce = function(node, _options) {
	node._use_link = "a";
	node._click_type = "manual";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "use"			: node._use_link		= _options[_argument]; break;
				case "type"			: node._click_type		= _options[_argument]; break;
			}
		}
	}
	var a = (node.nodeName.toLowerCase() == "a" ? node : u.qs(node._use_link, node));
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
		if(node._click_type == "link") {
			node.clicked = function(event) {
				if(event && (event.metaKey || event.ctrlKey)) {
					window.open(this.url);
				}
				else {
					if(typeof(page) != "undefined" && typeof(page.navigate) == "function") {
						page.navigate(this.url);
					}
					else {
						location.href = this.url;
					}
				}
			}
		}
	}
	return node;
}
Util.classVar = u.cv = function(node, var_name) {
	try {
		var regexp = new RegExp(var_name + ":[?=\\w/\\#~:.,?+=?&%@!\\-]*");
		if(node.className.match(regexp)) {
			return node.className.match(regexp)[0].replace(var_name + ":", "");
		}
	}
	catch(exception) {
		u.exception("u.cv", arguments, exception);
	}
	return false;
}
Util.setClass = u.sc = function(node, classname) {
	try {
		var old_class = node.className;
		node.className = classname;
		node.offsetTop;
		return old_class;
	}
	catch(exception) {
		u.exception("u.sc", arguments, exception);
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
		u.exception("u.hc", arguments, exception);
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
		u.exception("u.ac", arguments, exception);
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
		u.exception("u.rc", arguments, exception);
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
		u.exception("u.tc", arguments, exception);
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
	property = property.replace(/([A-Z]{1})/g, function(word){return word.replace(/([A-Z]{1})/, "-$1").toLowerCase()});
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
Util.selectText = function(node) {
	var selection = window.getSelection();
	var range = document.createRange();
	range.selectNodeContents(node);
	selection.removeAllRanges();
	selection.addRange(range);
}
Util.inNodeList = function(node, list) {
	var i, list_node;
	for(i = 0; list_node = list[i]; i++) {
		if(list_node === node) {
			return true;
		}
	}
	return false;
}
Util.nodeWithin = u.nw = function(node, scope) {
	var node_key = u.randomString(8);
	var scope_key = u.randomString(8);
	u.ac(node, node_key);
	u.ac(scope, scope_key);
	if(u.qs("."+scope_key+" ."+node_key)) {
		u.rc(node, node_key);
		u.rc(scope, scope_key);
		return true;
	}
	u.rc(node, node_key);
	u.rc(scope, scope_key);
	return false;
}
Util.Events = u.e = new function() {
	this.event_pref = typeof(document.ontouchmove) == "undefined" || (navigator.maxTouchPoints > 1 && navigator.userAgent.match(/Windows/i)) ? "mouse" : "touch";
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
u.e.drag = function(node, boundaries, _options) {
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
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "strict"			: node.drag_strict			= _options[_argument]; break;
				case "elastica"			: node.drag_elastica		= Number(_options[_argument]); break;
				case "dropout"			: node.drag_dropout			= _options[_argument]; break;
				case "show_bounds"		: node.show_bounds			= _options[_argument]; break; 
				case "vertical_lock"	: node.vertical_lock		= _options[_argument]; break;
				case "horizontal_lock"	: node.horizontal_lock		= _options[_argument]; break;
				case "callback_picked"	: node.callback_picked		= _options[_argument]; break;
				case "callback_moved"	: node.callback_moved		= _options[_argument]; break;
				case "callback_dropped"	: node.callback_dropped		= _options[_argument]; break;
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
u.e.swipe = function(node, boundaries, _options) {
	node.e_swipe = true;
	u.e.drag(node, boundaries, _options);
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
Util.flash = function(node, url, _options) {
	var width = "100%";
	var height = "100%";
	var background = "transparent";
	var id = "flash_" + new Date().getHours() + "_" + new Date().getMinutes() + "_" + new Date().getMilliseconds();
	var allowScriptAccess = "always";
	var menu = "false";
	var scale = "showall";
	var wmode = "transparent";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "id"					: id				= _options[_argument]; break;
				case "width"				: width				= Number(_options[_argument]); break;
				case "height"				: height			= Number(_options[_argument]); break;
				case "background"			: background		= _options[_argument]; break;
				case "allowScriptAccess"	: allowScriptAccess = _options[_argument]; break;
				case "menu"					: menu				= _options[_argument]; break;
				case "scale"				: scale				= _options[_argument]; break;
				case "wmode"				: wmode				= _options[_argument]; break;
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
					this.customInit[custom_init](form, field);
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
						var current_height = parseInt(u.gcs(field._input, "height"));
						var current_value = field._input.val();
						field._input.value = "";
						u.as(field._input, "overflow", "hidden");
						field._input.autoexpand_offset = 0;
						if(parseInt(u.gcs(field._input, "height")) != field._input.scrollHeight) {
							field._input.autoexpand_offset = field._input.scrollHeight - parseInt(u.gcs(field._input, "height"));
						}
						field._input.value = current_value;
						field._input.setHeight = function() {
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
						u.e.addEvent(field._input, "keyup", field._input.setHeight);
						field._input.setHeight();
					}
					u.e.addEvent(field._input, "keyup", this._updated);
					u.e.addEvent(field._input, "change", this._changed);
					this.activateInput(field._input);
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
					u.e.addEvent(field._input, "focus", this._focus);
					u.e.addEvent(field._input, "blur", this._blur);
					if(u.e.event_pref == "mouse") {
						u.e.addEvent(field._input, "dragenter", this._focus);
						u.e.addEvent(field._input, "dragleave", this._blur);
						u.e.addEvent(field._input, "mouseenter", this._mouseenter);
						u.e.addEvent(field._input, "mouseleave", this._mouseleave);
					}
					u.e.addEvent(field._input, "blur", this._validate);
					field._input.val = this._value_file;
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
			if(!action.form) {
				action.form = form;
			}
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
	this._value_file = function(value) {
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
		this.field.is_focused = true;
		this.is_focused = true;
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
		this.field.is_focused = false;
		this.is_focused = false;
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
		if(iN.is_focused || iN.val() !== "") {
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
			else if(u.hc(iN.field, "select")) {
				if(iN.val() !== "") {
					this.fieldCorrect(iN);
				}
				else {
					this.fieldError(iN);
				}
			}
			else if(u.hc(iN.field, "checkbox|boolean|radiobuttons")) {
				if(iN.val() !== "") {
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
u.f.addForm = function(node, _options) {
	var form_name = "js_form";
	var form_action = "#";
	var form_method = "post";
	var form_class = "";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "name"			: form_name				= _options[_argument]; break;
				case "action"		: form_action			= _options[_argument]; break;
				case "method"		: form_method			= _options[_argument]; break;
				case "class"		: form_class			= _options[_argument]; break;
			}
		}
	}
	var form = u.ae(node, "form", {"class":form_class, "name": form_name, "action":form_action, "method":form_method});
	return form;
}
u.f.addFieldset = function(node) {
	return u.ae(node, "fieldset");
}
u.f.addField = function(node, _options) {
	var field_type = "string";
	var field_label = "Value";
	var field_name = "js_name";
	var field_value = "";
	var field_class = "";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "type"			: field_type			= _options[_argument]; break;
				case "label"		: field_label			= _options[_argument]; break;
				case "name"			: field_name			= _options[_argument]; break;
				case "value"		: field_value			= _options[_argument]; break;
				case "class"		: field_class			= _options[_argument]; break;
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
u.f.addAction = function(node, _options) {
	var action_type = "submit";
	var action_name = "js_name";
	var action_value = "";
	var action_class = "";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "type"			: action_type			= _options[_argument]; break;
				case "name"			: action_name			= _options[_argument]; break;
				case "value"		: action_value			= _options[_argument]; break;
				case "class"		: action_class			= _options[_argument]; break;
			}
		}
	}
	var p_ul = node.nodeName.toLowerCase() == "ul" ? node : u.pn(node, {"include":"ul"});
	if(!p_ul || !u.hc(p_ul, "actions")) {
		p_ul = u.ae(node, "ul", {"class":"actions"});
	}
	var p_li = node.nodeName.toLowerCase() == "li" ? node : u.pn(node, {"include":"li"});
	if(!p_li || p_ul != p_li.parentNode) {
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
		return node.offsetLeft + u.absX(node.offsetParent);
	}
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
	this.catchEvent = function(node, _options) {
		node.callback_urlchange = "navigate";
		if(typeof(_options) == "object") {
			var argument;
			for(argument in _options) {
				switch(argument) {
					case "callback"		: node.callback_urlchange		= _options[argument]; break;
				}
			}
		}
		this.node = node;
		var hashChanged = function(event) {
			if(!location.hash || !location.hash.match(/^#\//)) {
				location.hash = "#/"
				return;
			}
			var url = u.h.getCleanHash(location.hash);
			if(typeof(u.h.node[u.h.node.callback_urlchange]) == "function") {
				u.h.node[u.h.node.callback_urlchange](url);
			}
		}
		var urlChanged = function(event) {
			var url = u.h.getCleanUrl(location.href);
			if(event.state || (!event.state && event.path)) {
				if(typeof(u.h.node[u.h.node.callback_urlchange]) == "function") {
					u.h.node[u.h.node.callback_urlchange](url);
				}
			}
			else {
				history.replaceState({}, url, url);
			}
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
	this.resolveCurrentUrl = function() {
		return !location.hash ? this.getCleanUrl(location.href) : this.getCleanHash(location.hash);
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
Util.Keyboard = u.k = new function() {
	this.shortcuts = {};
	this.onkeydownCatcher = function(event) {
		u.k.catchKey(event);
	}
	this.addKey = function(node, key, _options) {
		node.callback_keyboard = "clicked";
		node.metakey_required = true;
		if(typeof(_options) == "object") {
			var argument;
			for(argument in _options) {
				switch(argument) {
					case "callback"		: node.callback_keyboard	= _options[argument]; break;
					case "metakey"		: node.metakey_required		= _options[argument]; break;
				}
			}
		}
		if(!this.shortcuts.length) {
			u.e.addEvent(document, "keydown", this.onkeydownCatcher);
		}
		if(!this.shortcuts[key.toString().toUpperCase()]) {
			this.shortcuts[key.toString().toUpperCase()] = new Array();
		}
		this.shortcuts[key.toString().toUpperCase()].push(node);
	}
	this.catchKey = function(event) {
		event = event ? event : window.event;
		var key = String.fromCharCode(event.keyCode);
		if(event.keyCode == 27) {
			key = "ESC";
		}
		if(this.shortcuts[key]) {
			var nodes, node, i;
			nodes = this.shortcuts[key];
			for(i = 0; node = nodes[i]; i++) {
				if(u.nodeWithin(node, document.body)) {
					if(node.offsetHeight && ((event.ctrlKey || event.metaKey) || (!node.metakey_required || key == "ESC"))) {
						u.e.kill(event);
						if(typeof(node[node.callback_keyboard]) == "function") {
							node[node.callback_keyboard](event);
						}
					}
				}
				else {
					this.shortcuts[key].splice(i, 1);
					if(!this.shortcuts[key].length) {
						delete this.shortcuts[key];
						break;
					}
					else {
						i--;
					}
				}
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
u.navigation = function(_options) {
	page._nav_path = page._nav_path ? page._nav_path : u.h.getCleanUrl(location.href, 1);
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
			page._navigate(u.h.getCleanHash(location.hash), page);
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
		u.h.catchEvent(page, {"callback":"_navigate"});
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
Util.popup = function(url, _options) {
	var width = "330";
	var height = "150";
	var name = "popup" + new Date().getHours() + "_" + new Date().getMinutes() + "_" + new Date().getMilliseconds();
	var extra = "";
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "name"		: name		= _options[_argument]; break;
				case "width"	: width		= Number(_options[_argument]); break;
				case "height"	: height	= Number(_options[_argument]); break;
				case "extra"	: extra		= _options[_argument]; break;
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
u.preloader = function(node, files, _options) {
	var callback_preloader_loaded = "loaded";
	var callback_preloader_loading = "loading";
	var callback_preloader_waiting = "waiting";
	node._callback_min_delay = 0;
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "loaded"               : callback_preloader_loaded       = _options[_argument]; break;
				case "loading"              : callback_preloader_loading      = _options[_argument]; break;
				case "waiting"              : callback_preloader_waiting      = _options[_argument]; break;
				case "callback_min_delay"   : node._callback_min_delay              = _options[_argument]; break;
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
			u._preloader_max_processes = 4;
		}
	}
	if(node && files) {
		var entry, file;
		var new_queue = u.ae(u._preloader_queue, "ul");
		new_queue._callback_loaded = callback_preloader_loaded;
		new_queue._callback_loading = callback_preloader_loading;
		new_queue._callback_waiting = callback_preloader_waiting;
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
		if(typeof(node[new_queue._callback_waiting]) == "function") {
			node[new_queue._callback_waiting](new_queue.nodes);
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
					if(typeof(next._queue._node[next._queue._callback_loading]) == "function") {
						next._queue._node[next._queue._callback_loading](next._queue.nodes);
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
						if(typeof(this._queue._node[this._queue._callback_loaded]) == "function") {
							this._queue._node[this._queue._callback_loaded](this._queue.nodes);
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
Util.createRequestObject = function() {
	return new XMLHttpRequest();
}
Util.request = function(node, url, _options) {
	var request_id = u.randomString(6);
	node[request_id] = {};
	node[request_id].request_url = url;
	node[request_id].request_method = "GET";
	node[request_id].request_async = true;
	node[request_id].request_params = "";
	node[request_id].request_headers = false;
	node[request_id].callback_response = "response";
	node[request_id].jsonp_callback = "callback";
	if(typeof(_options) == "object") {
		var argument;
		for(argument in _options) {
			switch(argument) {
				case "method"				: node[request_id].request_method		= _options[argument]; break;
				case "params"				: node[request_id].request_params		= _options[argument]; break;
				case "async"				: node[request_id].request_async		= _options[argument]; break;
				case "headers"				: node[request_id].request_headers		= _options[argument]; break;
				case "callback"				: node[request_id].callback_response	= _options[argument]; break;
				case "jsonp_callback"		: node[request_id].jsonp_callback		= _options[argument]; break;
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
				if(!params.constructor.toString().match(/FormData/i)) {
					node[request_id].HTTPRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				}
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
		node[request_id].request_url += (!node[request_id].request_url.match(/\?/g) ? "?" : "&") + node[request_id].jsonp_callback + "=document."+key+".responder";
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
		if(typeof(response.node[response.node[response.request_id].callback_response]) == "function") {
			response.node[response.node[response.request_id].callback_response](object, response.request_id);
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
u.scrollTo = function(node, _options) {
	node.callback_scroll_to = "scrolledTo";
	node.callback_scroll_cancelled = "scrolledToCancelled";
	var offset_y = 0;
	var offset_x = 0;
	var scroll_to_x = 0;
	var scroll_to_y = 0;
	var to_node = false;
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "callback"             : node.callback_scroll_to           = _options[_argument]; break;
				case "callback_cancelled"   : node.callback_scroll_cancelled    = _options[_argument]; break;
				case "offset_y"             : offset_y                           = _options[_argument]; break;
				case "offset_x"             : offset_x                           = _options[_argument]; break;
				case "node"              : to_node                               = _options[_argument]; break;
				case "x"                    : scroll_to_x                        = _options[_argument]; break;
				case "y"                    : scroll_to_y                        = _options[_argument]; break;
				case "scrollIn"             : scrollIn                           = _options[_argument]; break;
			}
		}
	}
	if(to_node) {
		node._to_x = u.absX(to_node);
		node._to_y = u.absY(to_node);
	}
	else {
		node._to_x = scroll_to_x;
		node._to_y = scroll_to_y;
	}
	node._to_x = offset_x ? node._to_x - offset_x : node._to_x;
	node._to_y = offset_y ? node._to_y - offset_y : node._to_y;
	if(node._to_y > (node == window ? document.body.scrollHeight : node.scrollHeight)-u.browserH()) {
		node._to_y = (node == window ? document.body.scrollHeight : node.scrollHeight)-u.browserH();
	}
	if(node._to_x > (node == window ? document.body.scrollWidth : node.scrollWidth)-u.browserW()) {
		node._to_x = (node == window ? document.body.scrollWidth : node.scrollWidth)-u.browserW();
	}
	node._to_x = node._to_x < 0 ? 0 : node._to_x;
	node._to_y = node._to_y < 0 ? 0 : node._to_y;
	node._x_scroll_direction = node._to_x - u.scrollX();
	node._y_scroll_direction = node._to_y - u.scrollY();
	node._scroll_to_x = u.scrollX();
	node._scroll_to_y = u.scrollY();
	node.scrollToHandler = function(event) {
		u.t.resetTimer(this.t_scroll);
		this.t_scroll = u.t.setTimer(this, this._scrollTo, 50);
	}
	u.e.addEvent(node, "scroll", node.scrollToHandler);
	node.cancelScrollTo = function() {
		u.t.resetTimer(this.t_scroll);
		u.e.removeEvent(this, "scroll", this.scrollToHandler);
		this._scrollTo = null;
	}
	node._scrollTo = function(start) {
		var s_x = u.scrollX();
		var s_y = u.scrollY();
		if(s_y == this._scroll_to_y && s_x == this._scroll_to_x) {
			if(this._x_scroll_direction > 0 && this._to_x > s_x) {
				this._scroll_to_x = Math.ceil(s_x + (this._to_x - s_x)/4);
			}
			else if(this._x_scroll_direction < 0 && this._to_x < s_x) {
				this._scroll_to_x = Math.floor(s_x - (s_x - this._to_x)/4);
			}
			else {
				this._scroll_to_x = this._to_x;
			}
			if(this._y_scroll_direction > 0 && this._to_y > s_y) {
				this._scroll_to_y = Math.ceil(s_y + (this._to_y - s_y)/4);
			}
			else if(this._y_scroll_direction < 0 && this._to_y < s_y) {
				this._scroll_to_y = Math.floor(s_y - (s_y - this._to_y)/4);
			}
			else {
				this._scroll_to_y = this._to_y;
			}
			if(this._scroll_to_x == this._to_x && this._scroll_to_y == this._to_y) {
				this.cancelScrollTo();
				this.scrollTo(this._to_x, this._to_y);
				if(typeof(this[this.callback_scroll_to]) == "function") {
					this[this.callback_scroll_to]();
				}
				return;
			}
			this.scrollTo(this._scroll_to_x, this._scroll_to_y);
		}
		else {
			this.cancelScrollTo();
			if(typeof(this[this.callback_scroll_cancelled]) == "function") {
				this[this.callback_scroll_cancelled]();
			}
		}	
	}
	node._scrollTo();
}
u.sortable = function(scope, _options) {
	scope.callback_picked = "picked";
	scope.callback_moved = "moved";
	scope.callback_dropped = "dropped";
	scope.draggables;	
	scope.targets;	
	scope.layout;
	scope.allow_nesting = false;
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "picked"				: scope.callback_picked		= _options[_argument]; break;
				case "moved"				: scope.callback_moved		= _options[_argument]; break;
				case "dropped"				: scope.callback_dropped	= _options[_argument]; break;
				case "draggables"			: scope.draggables			= _options[_argument]; break;
				case "targets"				: scope.targets				= _options[_argument]; break;
				case "layout"				: scope.layout				= _options[_argument]; break;
				case "allow_nesting"		: scope.allow_nesting		= _options[_argument]; break;
			}
		}
	}
	scope._sortablepick = function(event) {
		if(!this.d_node.scope._sorting_disabled) {
			u.e.kill(event);
			if(!this.d_node.scope._dragged) {
				var d_node = this.d_node.scope._dragged = this.d_node;
				d_node.start_opacity = u.gcs(d_node, "opacity");
				d_node.start_position = u.gcs(d_node, "position");
				d_node.start_width = u.gcs(d_node, "width");
				d_node.start_height = u.gcs(d_node, "height");
				if(!d_node.scope.tN) {
					d_node.scope.tN = document.createElement(d_node.nodeName);
				}
				u.sc(d_node.scope.tN, "target " + d_node.className);
				u.as(d_node.scope.tN, "height", u.actualHeight(d_node)+"px");
				u.as(d_node.scope.tN, "width", u.actualWidth(d_node)+"px");
				u.as(d_node.scope.tN, "opacity", d_node.start_opacity - 0.5);
				d_node.scope.tN.innerHTML = d_node.innerHTML;
				u.as(d_node, "width", u.actualWidth(d_node) + "px");
				u.as(d_node, "opacity", d_node.start_opacity - 0.3);
				d_node.mouse_ox = u.eventX(event) - u.absX(d_node);
				d_node.mouse_oy = u.eventY(event) - u.absY(d_node);
				u.as(d_node, "position", "absolute");
				u.as(d_node, "left", (u.eventX(event) - d_node.rel_ox) - d_node.mouse_ox+"px");
				u.as(d_node, "top", (u.eventY(event) - d_node.rel_oy) - d_node.mouse_oy+"px");
				u.ac(d_node, "dragged");
				d_node._event_move_id = u.e.addWindowMoveEvent(d_node, d_node.scope._sortabledrag);
				d_node._event_end_id = u.e.addWindowEndEvent(d_node, d_node.scope._sortabledrop);
				d_node.parentNode.insertBefore(d_node.scope.tN, d_node);
				if(typeof(d_node.scope[d_node.scope.callback_picked]) == "function") {
					d_node.scope[d_node.scope.callback_picked](event);
				}
			}
		}
	}
	scope._sortabledrag = function(event) {
		u.e.kill(event);
		var i, node;
		var event_x = u.eventX(event);
		var event_y = u.eventY(event);
		if(this.scope._dragged == this) {
			this.d_left = event_x - this.mouse_ox;
			this.d_top = event_y - this.mouse_oy;
				u.as(this, "position", "absolute");
				u.as(this, "left", this.d_left - this.rel_ox+"px");
				u.as(this, "top", this.d_top - this.rel_oy+"px");
				u.as(this, "bottom", "auto");
				this.scope.detectAndInject(event_x, event_y);
		}
		if(typeof(this.scope[this.scope.callback_moved]) == "function") {
			this.scope[this.scope.callback_moved](event);
		}
	}
	scope._sortabledrop = function(event) {
		u.e.kill(event);
		u.e.removeWindowMoveEvent(this, this._event_move_id);
		u.e.removeWindowEndEvent(this, this._event_end_id);
		this.scope.tN = this.scope.tN.parentNode.replaceChild(this, this.scope.tN);
		u.as(this, "position", this.start_position);
		u.as(this, "opacity", this.start_opacity);
		u.as(this, "left", "");
		u.as(this, "top", "");
		u.as(this, "bottom", "");
		u.as(this, "width", "");
		u.as(this.scope, "width", "");
		u.as(this.scope, "height", "");
		if(!this.scope.draggables) {
			this.scope.draggable_nodes = u.qsa("li", this.scope);
		}
		else {
			this.scope.draggable_nodes = u.qsa("."+this.scope.draggables, this.scope);
		}
		if(typeof(this.scope[this.scope.callback_dropped]) == "function") {
			this.scope[this.scope.callback_dropped](event);
		}
		this.rel_ox = u.absX(this) - u.relX(this);
		this.rel_oy = u.absY(this) - u.relY(this);
		u.rc(this, "dragged");
		this.scope._dragged = false;
	}
	scope.detectAndInject = function(event_x, event_y) {
		for(i = this.draggable_nodes.length-1; node = this.draggable_nodes[i]; i--) {
			if(node != this._dragged && node != this.tN && (!this.targets || u.hc(node.parentNode, this.targets))) {
				if(this.layout == "vertical") {
					var o_top = u.absY(node);
					var o_height = this.draggable_node_height;
				 	if(event_y > o_top && event_y < o_top + o_height) {
						if(this.allow_nesting) {
							var no_nesting_offset = o_height/3 > 7 ? 7 : o_height/3;
							if(i === 0 && event_y > o_top && event_y < o_top + no_nesting_offset) {
								node.parentNode.insertBefore(this.tN, node);
							}
							else
							if(event_y > o_top && event_y > (o_top + o_height) - ((no_nesting_offset)*2)) {
								var next = u.ns(node);
								if(next) {
									node.parentNode.insertBefore(this.tN, next);
								}
								else {
									node.parentNode.appendChild(this.tN);
								}
							}
							else {
								var sub_nodes = u.qs("ul" + this.targets ? ("."+this.targets) : "", node);
								if(!sub_nodes) {
									sub_nodes = u.ae(node, "ul", {"class":this.targets});
								}
								sub_nodes.appendChild(this.tN);
							}
							break;
						}
						else {
							if(event_y > o_top && event_y < o_top + o_height/2) {
								node.parentNode.insertBefore(this.tN, node);
							}
							else {
								var next = u.ns(node);
								if(next) {
									node.parentNode.insertBefore(this.tN, next);
								}
								else {
									node.parentNode.appendChild(this.tN);
								}
							}
							break;
						}
					}
				}
				else {
					var o_left = u.absX(node);
					var o_top = u.absY(node);
					var o_width = node.offsetWidth;
					var o_height = node.offsetHeight;
				 	if(event_x > o_left && event_x < o_left + o_width && event_y > o_top && event_y < o_top + o_height) {
						if(event_x > o_left && event_x < o_left + o_width/2) {
							node.parentNode.insertBefore(this.tN, node);
						}
						else {
							var next = u.ns(node);
							if(next) {
								node.parentNode.insertBefore(this.tN, next);
							}
							else {
								node.parentNode.appendChild(this.tN);
							}
						}
						break;
					}
				}
			}
		}
	}
	scope.getStructure = function() {
		if(!this.draggables) {
			this.draggable_nodes = u.qsa("li", this);
		}
		else {
			this.draggable_nodes = u.qsa("."+this.draggables, this);
		}
		var structure = [];
		var i, node, id, relation, position;
		for(i = 0; node = this.draggable_nodes[i]; i++) {
			id = u.cv(node, "node_id");
			relation = this.getRelation(node);
			position = this.getPositionInList(node);
			structure.push({"id":id, "relation":relation, "position":position});
		}
		return structure;
	}
	scope.getPositionInList = function(node) {
		var pos = 1;
		var test_node = node;
		while(u.ps(test_node)) {
			test_node = u.ps(test_node);
			pos++;
		}
		return pos;
	}
	scope.getRelation = function(node) {
		if(!node.parentNode.relation_id) {
			var li_relation = u.pn(node, {"include":"li"});
			if(u.inNodeList(li_relation, this.draggable_nodes)) {
				node.parentNode.relation_id = u.cv(li_relation, "id");
			}
			else {
				node.parentNode.relation_id = 0;
			}
		}
		return node.parentNode.relation_id;
	}
	scope.disableNodeDrag = function(node) {
		u.bug("disableNodeDrag:" + u.nodeId(node))
		u.e.removeStartEvent(node.drag, this._sortablepick);
	}
	var i, j, d_node;
	if(!scope.draggables) {
		scope.draggable_nodes = u.qsa("li", scope);
	}
	else {
		scope.draggable_nodes = u.qsa("."+scope.draggables, scope);
	}
	if(!scope.draggable_nodes.length) {
		return;
	}
	scope.draggable_node_height = scope.draggable_nodes[0].offsetHeight;
	if(!scope.targets) {
		scope.target_nodes = u.qsa("ul", scope);
	}
	else {
		scope.target_nodes = u.qsa("."+scope.targets, scope);
	}
	if((!scope.targets || u.hc(scope, scope.targets))) {
		if(scope.target_nodes.length) {
			var temp_scope = scope.target_nodes;
			scope.target_nodes = [scope];
			var target_node;
			for(i = 0; target_node = temp_scope[i]; i++) {
				scope.target_nodes.push(target_node);
			} 
		}
		else {
			scope.target_nodes = [scope];
		}
	}
	if(!scope.layout && scope.draggable_nodes.length) {
		scope.layout = scope.offsetWidth < scope.draggable_nodes[0].offsetWidth*2 ? "vertical" : "horizontal";
	}
	for(i = 0; d_node = scope.draggable_nodes[i]; i++) {
		d_node.scope = scope;
		d_node.dragme = true;
		d_node.rel_ox = u.absX(d_node) - u.relX(d_node);
		d_node.rel_oy = u.absY(d_node) - u.relY(d_node);
		d_node.drag = u.qs(".drag", d_node);
		if(!d_node.drag) {
			d_node.drag = d_node;
		}
		d_node.drag.d_node = d_node;
		var drag_children = u.qsa("*", d_node.drag);
		if(drag_children) {
			for(j = 0; child = drag_children[j]; j++) {
				child.d_node = d_node;
			}
		}
		u.e.removeStartEvent(d_node.drag, scope._sortablepick);
		u.e.addStartEvent(d_node.drag, scope._sortablepick);
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
Util.svg = function(svg_object) {
	var svg, shape, svg_shape;
	if(svg_object.id && u._svg_cache[svg_object.id]) {
		svg = u._svg_cache[svg_object.id].cloneNode(true);
	}
	if(!svg) {
		svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
		if(svg_object.width) {
			svg.setAttributeNS(null, "width", svg_object.width);
		}
		if(svg_object.height) {
			svg.setAttributeNS(null, "height", svg_object.height);
		}
		if(svg_object.id) {
			svg.setAttributeNS(null, "id", svg_object.id);
		}
		if(svg_object.node) {
			svg.node = svg_object.node;
		}
		for(shape in svg_object.shapes) {
			Util.svgShape(svg, svg_object.shapes[shape]);
		}
		if(svg_object.id) {
			u._svg_cache[svg_object.id] = svg.cloneNode(true);
		}
	}
	if(svg_object.node) {
		svg_object.node.appendChild(svg);
	}
	return svg;
}
Util.svgShape = function(svg, svg_object) {
	svg_shape = document.createElementNS("http://www.w3.org/2000/svg", svg_object["type"]);
	svg_object["type"] = null;
	delete svg_object["type"];
	for(detail in svg_object) {
		svg_shape.setAttributeNS(null, detail, svg_object[detail]);
	}
	return svg.appendChild(svg_shape);
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
		if(navigator.userAgent.match(/(Firefox\/)(\d+\.\d+)/i)) {
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
	var current_version = false;
	if(os.match(/\bwindows\b/i)) {
		if(navigator.userAgent.match(/(Windows NT )(\d+.\d)/i)) {
			current_version = navigator.userAgent.match(/(Windows NT )(\d+.\d)/i)[2];
		}
	}
	else if(os.match(/\bios\b/i)) {
		if(navigator.userAgent.match(/(OS )(\d+[._]{1}\d)( like Mac OS X)/i)) {
			current_version = navigator.userAgent.match(/(OS )(\d+[._]{1}\d)( like Mac OS X)/i)[2].replace("_", ".");
		}
	}
	else if(os.match(/\bandroid\b/i)) {
		if(navigator.userAgent.match(/(Android )(\d+.\d)/i)) {
			current_version = navigator.userAgent.match(/(Android )(\d+.\d)/i)[2];
		}
	}
	else if(os.match(/\bmac\b/i)) {
		if(navigator.userAgent.match(/(Macintosh; Intel Mac OS X )(\d+[._]{1}\d)/i)) {
			current_version = navigator.userAgent.match(/(Macintosh; Intel Mac OS X )(\d+[._]{1}\d)/i)[2].replace("_", ".");
		}
	}
	else if(os.match(/\blinux\b/i)) {
		if(navigator.userAgent.match(/linux|x11/i)) {
			current_version = true;
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
u.textscaler = function(node, _settings) {
	if(typeof(_settings) != "object") {
		_settings = {
			"*":{
				"unit":"rem",
				"min_size":1,
				"min_width":200,
				"max_size":40,
				"max_width":3000
			}
		};
	}
	node.text_key = u.randomString(8);
	u.ac(node, node.text_key);
	node.text_settings = JSON.parse(JSON.stringify(_settings));
	node.scaleText = function() {
		var tag;
		for(tag in this.text_settings) {
			var settings = this.text_settings[tag];
			if(settings.min_width <= window._man_text._width && settings.max_width >= window._man_text._width) {
				var font_size = settings.min_size + (settings.size_factor * (window._man_text._width - settings.min_width) / settings.width_factor);
				settings.css_rule.style.setProperty("font-size", font_size + settings.unit, "important");
			}
			else if(settings.max_width < window._man_text._width) {
				settings.css_rule.style.setProperty("font-size", settings.max_size + settings.unit, "important");
			}
			else if(settings.min_width > window._man_text._width) {
				settings.css_rule.style.setProperty("font-size", settings.min_size + settings.unit, "important");
			}
		}
	}
	node.cancelTextScaling = function() {
		u.e.removeEvent(window, "resize", window._man_text.scale);
	}
	if(!window._man_text) {
		var man_text = {};
		man_text.nodes = [];
		var style_tag = document.createElement("style");
		style_tag.setAttribute("media", "all")
		style_tag.setAttribute("type", "text/css")
		man_text.style_tag = u.ae(document.head, style_tag);
		man_text.style_tag.appendChild(document.createTextNode(""))
		window._man_text = man_text;
		window._man_text._width = u.browserW();
		window._man_text.scale = function() {
			window._man_text._width = u.browserW();
			var i, node;
			for(i = 0; node = window._man_text.nodes[i]; i++) {
				if(node.parentNode) { 
					node.scaleText();
				}
				else {
					window._man_text.nodes.splice(window._man_text.nodes.indexOf(node), 1);
					if(!window._man_text.nodes.length) {
						u.e.removeEvent(window, "resize", window._man_text.scale);
					}
				}
			}
		}
		u.e.addEvent(window, "resize", window._man_text.scale);
		window._man_text.precalculate = function() {
			var i, node, tag;
			for(i = 0; node = window._man_text.nodes[i]; i++) {
				if(node.parentNode) { 
					var settings = node.text_settings;
					for(tag in settings) {
						settings[tag].width_factor = settings[tag].max_width-settings[tag].min_width;
						settings[tag].size_factor = settings[tag].max_size-settings[tag].min_size;
					}
				}
			}
		}
	}
	var tag;
	for(tag in node.text_settings) {
		selector = "."+node.text_key + ' ' + tag + ' ';
		node.css_rules_index = window._man_text.style_tag.sheet.insertRule(selector+'{}', 0);
		node.text_settings[tag].css_rule = window._man_text.style_tag.sheet.cssRules[0];
	}
	window._man_text.nodes.push(node);
	window._man_text.precalculate();
	node.scaleText();
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
		if(typeof(this._timers[id]._a) == "function") {
			node._timer_action = this._timers[id]._a;
			node._timer_action();
			node._timer_action = null;
		}
		else if(typeof(node[this._timers[id]._a]) == "function") {
			node[this._timers[id]._a]();
		}
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
		if(typeof(this._timers[id]._a) == "function") {
			node._interval_action = this._timers[id]._a;
			node._interval_action();
			node._interval_action = null;
		}
		else if(typeof(node[this._timers[id]._a]) == "function") {
			node[this._timers[id]._a]();
		}
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
Util.videoPlayer = function(_options) {
	var player = document.createElement("div");
	u.ac(player, "videoplayer");
	player._autoplay = false;
	player._controls = false;
	player._controls_playpause = false;
	player._controls_zoom = false;
	player._controls_volume = false;
	player._controls_search = false;
	player._ff_skip = 2;
	player._rw_skip = 2;
	if(typeof(_options) == "object") {
		var _argument;
		for(_argument in _options) {
			switch(_argument) {
				case "autoplay"     : player._autoplay               = _options[_argument]; break;
				case "controls"     : player._controls               = _options[_argument]; break;
				case "playpause"    : player._controls_playpause     = _options[_argument]; break;
				case "zoom"         : player._controls_zoom          = _options[_argument]; break;
				case "volume"       : player._controls_volume        = _options[_argument]; break;
				case "search"       : player._controls_search        = _options[_argument]; break;
				case "ff_skip"      : player._ff_skip                = _options[_argument]; break;
				case "rw_skip"      : player._rw_skip                = _options[_argument]; break;
			}
		}
	}
	player.video = u.ae(player, "video");
	if(typeof(player.video.play) == "function") {
		player.load = function(src, _options) {
			if(typeof(_options) == "object") {
				var _argument;
				for(_argument in _options) {
					switch(_argument) {
						case "autoplay"     : this._autoplay               = _options[_argument]; break;
						case "controls"     : this._controls               = _options[_argument]; break;
						case "playpause"    : this._controls_playpause     = _options[_argument]; break;
						case "zoom"         : this._controls_zoom          = _options[_argument]; break;
						case "volume"       : this._controls_volume        = _options[_argument]; break;
						case "search"       : this._controls_search        = _options[_argument]; break;
						case "fullscreen"   : this._controls_fullscreen    = _options[_argument]; break;
						case "ff_skip"      : this._ff_skip                = _options[_argument]; break;
						case "rw_skip"      : this._rw_skip                = _options[_argument]; break;
					}
				}
			}
			if(u.hc(this, "playing")) {
				this.stop();
			}
			this.setup();
			if(src) {
				this.video.src = this.correctSource(src);
				this.video.load();
				this.video.controls = player._controls;
				this.video.autoplay = player._autoplay;
			}
		}
		player.play = function(position) {
			if(this.video.currentTime && position !== undefined) {
				this.video.currentTime = position;
			}
			if(this.video.src) {
				this.video.play();
			}
		}
		player.loadAndPlay = function(src, _options) {
			var position = 0;
			if(typeof(_options) == "object") {
				var _argument;
				for(_argument in _options) {
					switch(_argument) {
						case "position"		: position		= _options[_argument]; break;
					}
				}
			}
			this.load(src, _options);
			this.play(position);
		}
		player.pause = function() {
			this.video.pause();
		}
		player.stop = function() {
			this.video.pause();
			if(this.video.currentTime) {
				this.video.currentTime = 0;
			}
		}
		player.ff = function() {
			if(this.video.src && this.video.currentTime && this.videoLoaded) {
				this.video.currentTime = (this.video.duration - this.video.currentTime >= this._ff_skip) ? (this.video.currentTime + this._ff_skip) : this.video.duration;
				this.video._timeupdate();
			}
		}
		player.rw = function() {
			if(this.video.src && this.video.currentTime && this.videoLoaded) {
				this.video.currentTime = (this.video.currentTime >= this._rw_skip) ? (this.video.currentTime - this._rw_skip) : 0;
				this.video._timeupdate();
			}
		}
		player.togglePlay = function() {
			if(u.hc(this, "playing")) {
				this.pause();
			}
			else {
				this.play();
			}
		}
		player.setup = function() {
			if(this.video) {
				var video = this.removeChild(this.video);
				delete video;
			}
			this.video = u.ie(this, "video");
			this.video.player = this;
			this.setControls();
			this.currentTime = 0;
			this.duration = 0;
			this.videoLoaded = false;
			this.metaLoaded = false;
			this.video._loadstart = function(event) {
				u.ac(this.player, "loading");
				if(typeof(this.player.loading) == "function") {
					this.player.loading(event);
				}
			}
			u.e.addEvent(this.video, "loadstart", this.video._loadstart);
			this.video._canplaythrough = function(event) {
				u.rc(this.player, "loading");
				if(typeof(this.player.canplaythrough) == "function") {
					this.player.canplaythrough(event);
				}
			}
			u.e.addEvent(this.video, "canplaythrough", this.video._canplaythrough);
			this.video._playing = function(event) {
				u.rc(this.player, "loading|paused");
				u.ac(this.player, "playing");
				if(typeof(this.player.playing) == "function") {
					this.player.playing(event);
				}
			}
			u.e.addEvent(this.video, "playing", this.video._playing);
			this.video._paused = function(event) {
				u.rc(this.player, "playing|loading");
				u.ac(this.player, "paused");
				if(typeof(this.player.paused) == "function") {
					this.player.paused(event);
				}
			}
			u.e.addEvent(this.video, "pause", this.video._paused);
			this.video._stalled = function(event) {
				u.rc(this.player, "playing|paused");
				u.ac(this.player, "loading");
				if(typeof(this.player.stalled) == "function") {
					this.player.stalled(event);
				}
			}
			u.e.addEvent(this.video, "stalled", this.video._paused);
			this.video._ended = function(event) {
				u.rc(this.player, "playing|paused");
				if(typeof(this.player.ended) == "function") {
					this.player.ended(event);
				}
			}
			u.e.addEvent(this.video, "ended", this.video._ended);
			this.video._loadedmetadata = function(event) {
				this.player.duration = this.duration;
				this.player.currentTime = this.currentTime;
				this.player.metaLoaded = true;
				if(typeof(this.player.loadedmetadata) == "function") {
					this.player.loadedmetadata(event);
				}
			}
			u.e.addEvent(this.video, "loadedmetadata", this.video._loadedmetadata);
			this.video._loadeddata = function(event) {
				this.player.videoLoaded = true;
				if(typeof(this.player.loadeddata) == "function") {
					this.player.loadeddata(event);
				}
			}
			u.e.addEvent(this.video, "loadeddata", this.video._loadeddata);
			this.video._timeupdate = function(event) {
				this.player.currentTime = this.currentTime;
				if(typeof(this.player.timeupdate) == "function") {
					this.player.timeupdate(event);
				}
			}
			u.e.addEvent(this.video, "timeupdate", this.video._timeupdate);
		}
	}
	else if(typeof(u.videoPlayerFallback) == "function") {
		player.removeChild(player.video);
		player = u.videoPlayerFallback(player);
	}
	else {
		player.load = function() {}
		player.play = function() {}
		player.loadAndPlay = function() {}
		player.pause = function() {}
		player.stop = function() {}
		player.ff = function() {}
		player.rw = function() {}
		player.togglePlay = function() {}
	}
	player.correctSource = function(src) {
		var param = src.match(/\?[^$]+/) ? src.match(/(\?[^$]+)/)[1] : "";
		src = src.replace(/\?[^$]+/, "");
		src = src.replace(/\.m4v|\.mp4|\.webm|\.ogv|\.3gp|\.mov/, "");
		if(this.flash) {
			return src+".mp4"+param;
		}
		else if(this.video.canPlayType("video/mp4")) {
			return src+".mp4"+param;
		}
		else if(this.video.canPlayType("video/ogg")) {
			return src+".ogv"+param;
		}
		else if(this.video.canPlayType("video/3gpp")) {
			return src+".3gp"+param;
		}
		else {
			return src+".mov"+param;
		}
	}
	player.setControls = function() {
		if(this.showControls) {
			if(u.e.event_pref == "mouse") {
				u.e.removeEvent(this, "mousemove", this.showControls);
				u.e.removeEvent(this.controls, "mouseenter", this._keepControls);
				u.e.removeEvent(this.controls, "mouseleave", this._unkeepControls);
			}
			else {
				u.e.removeEvent(this, "touchstart", this.showControls);
			}
		}
		if(this._controls_playpause || this._controls_zoom || this._controls_volume || this._controls_search) {
			if(!this.controls) {
				this.controls = u.ae(this, "div", {"class":"controls"});
				this.controls.player = this;
				this.controls._default_display = u.gcs(this.controls, "display");
				this.hideControls = function() {
					if(!this._keep) {
						this.t_controls = u.t.resetTimer(this.t_controls);
						u.a.transition(this.controls, "all 0.3s ease-out");
						u.a.setOpacity(this.controls, 0);
					}
				}
				this.showControls = function() {
					if(this.t_controls) {
						this.t_controls = u.t.resetTimer(this.t_controls);
					}
					else {
						u.a.transition(this.controls, "all 0.5s ease-out");
						u.a.setOpacity(this.controls, 1);
					}
					this.t_controls = u.t.setTimer(this, this.hideControls, 1500);
				}
				this._keepControls = function() {
					this.player._keep = true;
				}
				this._unkeepControls = function() {
					this.player._keep = false;
				}
			}
			else {
				u.as(this.controls, "display", this.controls._default_display);
			}
			if(this._controls_playpause) {
				if(!this.controls.playpause) {
					this.controls.playpause = u.ae(this.controls, "a", {"class":"playpause"});
					this.controls.playpause._default_display = u.gcs(this.controls.playpause, "display");
					this.controls.playpause.player = this;
					u.e.click(this.controls.playpause);
					this.controls.playpause.clicked = function(event) {
						this.player.togglePlay();
					}
				}
				else {
					u.as(this.controls.playpause, "display", this.controls.playpause._default_display);
				}
			}
			else if(this.controls.playpause) {
				u.as(this.controls.playpause, "display", "none");
			}
			if(this._controls_search) {
				if(!this.controls.search) {
					this.controls.search_ff = u.ae(this.controls, "a", {"class":"ff"});
					this.controls.search_ff._default_display = u.gcs(this.controls.search_ff, "display");
					this.controls.search_ff.player = this;
					this.controls.search_rw = u.ae(this.controls, "a", {"class":"rw"});
					this.controls.search_rw._default_display = u.gcs(this.controls.search_rw, "display");
					this.controls.search_rw.player = this;
					u.e.click(this.controls.search_ff);
					this.controls.search_ff.ffing = function() {
						this.t_ffing = u.t.setTimer(this, this.ffing, 100);
						this.player.ff();
					}
					this.controls.search_ff.inputStarted = function(event) {
						this.ffing();
					}
					this.controls.search_ff.clicked = function(event) {
						u.t.resetTimer(this.t_ffing);
					}
					u.e.click(this.controls.search_rw);
					this.controls.search_rw.rwing = function() {
						this.t_rwing = u.t.setTimer(this, this.rwing, 100);
						this.player.rw();
					}
					this.controls.search_rw.inputStarted = function(event) {
						this.rwing();
					}
					this.controls.search_rw.clicked = function(event) {
						u.t.resetTimer(this.t_rwing);
						this.player.rw();
					}
					this.controls.search = true;
				}
				else {
					u.as(this.controls.search_ff, "display", this.controls.search_ff._default_display);
					u.as(this.controls.search_rw, "display", this.controls.search_rw._default_display);
				}
			}
			else if(this.controls.search) {
				u.as(this.controls.search_ff, "display", "none");
				u.as(this.controls.search_rw, "display", "none");
			}
			if(this._controls_zoom && !this.controls.zoom) {}
			else if(this.controls.zoom) {}
			if(this._controls_volume && !this.controls.volume) {}
			else if(this.controls.volume) {}
			if(u.e.event_pref == "mouse") {
				u.e.addEvent(this.controls, "mouseenter", this._keepControls);
				u.e.addEvent(this.controls, "mouseleave", this._unkeepControls);
				u.e.addEvent(this, "mousemove", this.showControls);
			}
			else {
				u.e.addEvent(this, "touchstart", this.showControls);
			}
		}
		else if(this.controls) {
			u.as(this.controls, "display", "none");
		}
	}
	return player;
}


/*u-settings.js*/
u.site_name = "Janitor";
u.github_fork = {"url":"https://github.com/parentnode/janitor", "text":"Fork me on GitHub"};

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


/*u-form-geolocation.js*/
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
	if(navigator.geolocation) {
		u.f.geoLocation(field);
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
Util.Form.geoLocation = function(field) {
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
			html += '<style type="text/css">body {margin: 0;} #map {width: 300px; height: 300px;} #close {width: 25px; height: 25px; position: absolute; top: 0; left: 0; background: #ffffff; z-index: 10; border-bottom-right-radius: 10px; cursor: pointer;}</style>';
			html += '<script type="text/javascript" src="'+maps_url+'"></script>';
			html += '<script type="text/javascript">';
			html += 'var map, marker;';
			html += 'var initialize = function() {';
			html += '	window._map_loaded = true;';
			html += '	var close = document.getElementById("close");';
			html += '	close.onclick = function() {field.hideMap();};';
			html += '	var mapOptions = {center: new google.maps.LatLng('+lat+', '+lon+'),zoom: 15, streetViewControl: false, zoomControlOptions: {position: google.maps.ControlPosition.LEFT_CENTER}};';
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
			html += '</head><body><div id="map"></div><div id="close"></div></body></html>';
			window._mapsiframe = u.ae(document.body, "iframe", {"id":"geolocationmap"});
			window._mapsiframe.field = this;
			window._mapsiframe.doc = window._mapsiframe.contentDocument ? window._mapsiframe.contentDocument : window._mapsiframe.contentWindow.document;
			window._mapsiframe.doc.open();
			window._mapsiframe.doc.write(html);
			window._mapsiframe.doc.close();
		}
		else {
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
	field.moveMap = function(event) {
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
			this.field.moveMap(event);
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
	}
	field.bn_geolocation = u.ae(field, "div", {"class":"geolocation"});
	field.bn_geolocation.field = field;
	u.ce(field.bn_geolocation);
	field.bn_geolocation.clicked = function() {
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
			u.a.transition(window._geoLocationField.bn_geolocation, "none");
			u.a.scale(window._geoLocationField.bn_geolocation, 1);
			window._geoLocationField.showMap();
			window._geoLocationField.updateMap();
		}
		window._noLocation = function() {
			u.a.transition(window._geoLocationField.bn_geolocation, "none");
			u.a.scale(window._geoLocationField.bn_geolocation, 1);
			alert('Could not find location');
		}
		navigator.geolocation.getCurrentPosition(window._foundLocation, window._noLocation);
	}
}


/*u-form-htmleditor.js*/
Util.Form.customInit["html"] = function(form, field) {
	field._input = u.qs("textarea", field);
	field._input.field = field;
	form.fields[field._input.name] = field._input;
	field._input._label = u.qs("label[for="+field._input.id+"]", field);
	field._input.val = u.f._value;
	u.f.textEditor(field);
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
u.f.textEditor = function(field) {
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
	field.text_support = "h1,h2,h3,h4,h5,h6,p";
	field.code_support = "code";
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
			if(tag.match("^("+this[type+"_support"].split(",").join("|")+")$")) {
				this[type+"_allowed"].push(tag);
			}
		}
	}
	field.filterAllowedTags("text");
	field.filterAllowedTags("list");
	field.filterAllowedTags("media");
	field.filterAllowedTags("ext_video");
	field.filterAllowedTags("file");
	field.filterAllowedTags("code");
	field.file_add_action = field.getAttribute("data-file-add");
	field.file_delete_action = field.getAttribute("data-file-delete");
	field.media_add_action = field.getAttribute("data-media-add");
	field.media_delete_action = field.getAttribute("data-media-delete");
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
				u.rc(this.field, "optionsshown");
			}
			else {
				u.ac(this.field.options, "show");
				u.ac(this.field, "optionsshown");
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
		if(this.code_allowed.length) {
			this.bn_add_code = u.ae(this.options, "li", {"class":"code", "html":"Code"});
			this.bn_add_code.field = field;
			u.ce(this.bn_add_code);
			this.bn_add_code.clicked = function(event) {
				this.field.addCodeTag(this.field.code_allowed[0]);
				u.rc(this.field.options, "show");
			}
		}
		if(this.media_allowed.length && this.item_id && this.media_add_action && this.media_delete_action && !u.browser("IE", "<=9")) {
			this.bn_add_media = u.ae(this.options, "li", {"class":"list", "html":"Media ("+this.media_allowed.join(", ")+")"});
			this.bn_add_media.field = field;
			u.ce(this.bn_add_media);
			this.bn_add_media.clicked = function(event) {
				this.field.addMediaTag();
				u.rc(this.field.options, "show");
			}
		}
		else if(this.media_allowed.length) {
			u.bug("some information is missing to support media upload:\nitem_id="+this.item_id+"\nmedia_add_action="+this.media_add_action+"\nmedia_delete_action="+this.media_delete_action);
		}
		if(this.ext_video_allowed.length) {
			this.bn_add_ext_video = u.ae(this.options, "li", {"class":"video", "html":"External video ("+this.ext_video_allowed.join(", ")+")"});
			this.bn_add_ext_video.field = field;
			u.ce(this.bn_add_ext_video);
			this.bn_add_ext_video.clicked = function(event) {
				this.field.addExternalVideoTag(this.field.ext_video_allowed[0]);
				u.rc(this.field.options, "show");
			}
		}
		if(this.file_allowed.length && this.item_id && this.file_add_action && this.file_delete_action && !u.browser("IE", "<=9")) {
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
			else if(u.hc(tag, this.ext_video_allowed.join("|")) && tag._video_id) {
				div = u.ae(this._viewer, "div", {"class":tag._type.val()+" video_id:"+tag._video_id});
			}
			else if(u.hc(tag, "code")) {
				div = u.ae(this._viewer, "code", {"html":tag._input.val()});
			}
			else if(u.hc(tag, "file") && tag._variant) {
				div = u.ae(this._viewer, "div", {"class":"file item_id:"+tag._item_id+" variant:"+tag._variant+" name:"+tag._name + " filesize:"+tag._filesize});
				p = u.ae(div, "p");
				a = u.ae(p, "a", {"href":"/download/"+tag._item_id+"/"+tag._variant+"/"+tag._name, "html":tag._input.val()});
			}
			else if(u.hc(tag, "media") && tag._variant) {
				div = u.ae(this._viewer, "div", {"class":"media item_id:"+tag._item_id+" variant:"+tag._variant+" name:"+tag._name + " filesize:"+tag._filesize + " format:"+tag._format});
				p = u.ae(div, "p");
				a = u.ae(p, "a", {"href":"/images/"+tag._item_id+"/"+tag._variant+"/480x."+tag._format, "html":tag._input.val()});
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
			else if(u.hc(tag, this.ext_video_allowed.join("|")) && tag._video_id) {
				html += '<div class="'+tag._type.val()+' video_id:'+tag._video_id+'"></div>\n';
			}
			else if(u.hc(tag, "code")) {
				html += '<code>'+tag._input.val()+'</code>'+"\n";
			}
			else if(u.hc(tag, "media") && tag._variant) {
				html += '<div class="media item_id:'+tag._item_id+' variant:'+tag._variant+' name:'+tag._name+' filesize:'+tag._filesize+' format:'+tag._format+'">'+"\n";
				html += '\t<p><a href="/images/'+tag._item_id+'/'+tag._variant+'/480x.'+tag._format+'">'+tag._input.val()+"</a></p>";
				html += "</div>\n";
			}
			else if(u.hc(tag, "file") && tag._variant) {
				html += '<div class="file item_id:'+tag._item_id+' variant:'+tag._variant+' name:'+tag._name+' filesize:'+tag._filesize+'">'+"\n";
				html += '\t<p><a href="/download/'+tag._item_id+'/'+tag._variant+'/'+tag._name+'">'+tag._input.val()+"</a></p>";
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
			else if(u.hc(tag, "media")) {
				this.deleteMedia(tag);
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
					this.field.returnFocus(this.tag);
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
				this.field.returnFocus(this);
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
	field.addExternalVideoTag = function(type, node) {
		var tag = this.createTag(this.ext_video_allowed, type);
		tag._input = u.ae(tag, "div", {"class":"text", "contentEditable":true});
		tag._input.tag = tag;
		tag._input.field = this;
		if(node) {
			tag._video_id = u.cv(node, "video_id");
			tag._input.innerHTML = tag._video_id;
		}
		tag._input.val = function(value) {
			if(value !== undefined) {
				this.innerHTML = value;
			}
			return this.innerHTML;
		}
		u.e.addEvent(tag._input, "keydown", tag.field._changing_content);
		u.e.addEvent(tag._input, "keyup", this._changed_ext_video_content);
		u.e.addEvent(tag._input, "mouseup", this._changed_ext_video_content);
		u.e.addEvent(tag._input, "focus", tag.field._focused_content);
		u.e.addEvent(tag._input, "blur", tag.field._blurred_content);
		u.sortable(this._editor, {"draggables":"tag", "targets":"editor"});
		return tag;
	}
	field._changed_ext_video_content = function(event) {
		if(this.val() && !this.val().replace(/<br>/, "")) {
			this.val("");
		}
		this.tag._video_id = this.val();
		this.tag.field.update();
	}
	field.addMediaTag = function(node) {
		var tag = this.createTag(["media"], "media");
		tag._input = u.ae(tag, "div", {"class":"text"});
		tag._input.tag = tag;
		tag._input.field = this;
		if(node) {
			tag._name = u.cv(node, "name");
			tag._item_id = u.cv(node, "item_id");
			tag._filesize = u.cv(node, "filesize");
			tag._format = u.cv(node, "format");
			tag._variant = u.cv(node, "variant");
			tag._input.contentEditable = true;
			tag._input.innerHTML = u.qs("a", node).innerHTML;
			tag._image = u.ie(tag, "img");
			tag._image.src = "/images/"+tag._item_id+"/"+tag._variant+"/400x."+tag._format;
			tag._input.val = function(value) {
				if(value !== undefined) {
					this.innerHTML = value;
				}
				return this.innerHTML;
			}
			u.e.addEvent(tag._input, "keydown", tag.field._changing_content);
			u.e.addEvent(tag._input, "keyup", this._changed_media_content);
			u.e.addEvent(tag._input, "mouseup", this._changed_media_content);
			u.e.addEvent(tag._input, "focus", tag.field._focused_content);
			u.e.addEvent(tag._input, "blur", tag.field._blurred_content);
			u.ac(tag, "done");
		}
		else {
			tag._text = tag._input;
			tag._text.tag = tag;
			tag._text.field = this;
			tag._label = u.ae(tag._text, "label", {"html":"Drag media here"});
			tag._input = u.ae(tag._text, "input", {"type":"file", "name":"htmleditor_media[]"});
			tag._input.tag = tag;
			tag._input.field = this;
			tag._input.val = function(value) {return false;}
			u.e.addEvent(tag._input, "change", this._media_updated);
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
	field.deleteMedia = function(tag) {
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
	field._media_updated = function(event) {
		var form_data = new FormData();
		form_data.append(this.name, this.files[0], this.value);
		form_data.append("csrf-token", this.form.fields["csrf-token"].val());
		this.response = function(response) {
			page.notify(response);
			if(response.cms_status && response.cms_status == "success") {
				this.parentNode.removeChild(this.tag._label);
				this.parentNode.removeChild(this);
				this.tag._input = this.tag._text;
				this.tag._variant = response.cms_object["variant"];
				this.tag._filesize = response.cms_object["filesize"]
				this.tag._format = response.cms_object["format"]
				this.tag._width = response.cms_object["width"]
				this.tag._height = response.cms_object["height"]
				this.tag._name = response.cms_object["name"]
				this.tag._item_id = response.cms_object["item_id"]
				this.tag._input.contentEditable = true;
				this.tag._image = u.ie(this.tag, "img");
				this.tag._image.src = "/images/"+this.tag._item_id+"/"+this.tag._variant+"/400x."+this.tag._format;
				this.tag._input.innerHTML = this.tag._name + " ("+ u.round((this.tag._filesize/1000), 2) +"Kb)";
				this.tag._input.val = function(value) {
					if(value !== undefined) {
						this.innerHTML = value;
					}
					return this.innerHTML;
				}
				u.e.addEvent(this.tag._input, "keydown", this.tag.field._changing_content);
				u.e.addEvent(this.tag._input, "keyup", this.tag.field._changed_media_content);
				u.e.addEvent(this.tag._input, "mouseup", this.tag.field._changed_media_content);
				u.e.addEvent(this.tag._input, "focus", this.tag.field._focused_content);
				u.e.addEvent(this.tag._input, "blur", this.tag.field._blurred_content);
				u.ac(this.tag, "done");
				this.tag.field.update();
				this.tag.field._input.form.submit();
			}
		}
		u.request(this, this.field.media_add_action+"/"+this.field.item_id, {"method":"post", "params":form_data});
	}
	field._changed_media_content = function(event) {
		if(this.val() && !this.val().replace(/<br>/, "")) {
			this.val("");
		}
		this.field.update();
	}
	field.addFileTag = function(node) {
		var tag = this.createTag(["file"], "file");
		tag._input = u.ae(tag, "div", {"class":"text"});
		tag._input.tag = tag;
		tag._input.field = this;
		if(node) {
			tag._input.contentEditable = true;
			tag._variant = u.cv(node, "variant");
			tag._name = u.cv(node, "name");
			tag._item_id = u.cv(node, "item_id");
			tag._filesize = u.cv(node, "filesize");
			tag._input.innerHTML = u.qs("a", node).innerHTML;
			tag._input.val = function(value) {
				if(value !== undefined) {
					this.innerHTML = value;
				}
				return this.innerHTML;
			}
			u.e.addEvent(tag._input, "keydown", tag.field._changing_content);
			u.e.addEvent(tag._input, "keyup", this._changed_file_content);
			u.e.addEvent(tag._input, "mouseup", this._changed_file_content);
			u.e.addEvent(tag._input, "focus", tag.field._focused_content);
			u.e.addEvent(tag._input, "blur", tag.field._blurred_content);
			u.ac(tag, "done");
		}
		else {
			tag._text = tag._input;
			tag._text.tag = tag;
			tag._text.field = this;
			tag._label = u.ae(tag._text, "label", {"html":"Drag file here"});
			tag._input = u.ae(tag._text, "input", {"type":"file", "name":"htmleditor_file"});
			tag._input.tag = tag;
			tag._input.field = this;
			tag._input.val = function(value) {return false;}
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
	field._file_updated = function(event) {
		var form_data = new FormData();
		form_data.append(this.name, this.files[0], this.value);
		form_data.append("csrf-token", this.form.fields["csrf-token"].val());
		this.response = function(response) {
			page.notify(response);
			if(response.cms_status && response.cms_status == "success") {
				this.parentNode.removeChild(this.tag._label);
				this.parentNode.removeChild(this);
				this.tag._variant = response.cms_object["variant"];
				this.tag._filesize = response.cms_object["filesize"]
				this.tag._name = response.cms_object["name"]
				this.tag._item_id = response.cms_object["item_id"]
				this.tag._text.contentEditable = true;
				this.tag._text.innerHTML = this.tag._name + " ("+ u.round((this.tag._filesize/1000), 2) +"Kb)";
				this.tag._input = this.tag._text;
				this.tag._input.val = function(value) {
					if(value !== undefined) {
						this.innerHTML = value;
					}
					return this.innerHTML;
				}
				u.e.addEvent(this.tag._input, "keydown", this.tag.field._changing_content);
				u.e.addEvent(this.tag._input, "keyup", this.tag.field._changed_file_content);
				u.e.addEvent(this.tag._input, "mouseup", this.tag.field._changed_file_content);
				u.e.addEvent(this.tag._input, "focus", this.tag.field._focused_content);
				u.e.addEvent(this.tag._input, "blur", this.tag.field._blurred_content);
				u.ac(this.tag, "done");
				this.tag.field.update();
				this.tag.field._input.form.submit();
			}
		}
		u.request(this, this.field.file_add_action+"/"+this.field.item_id, {"method":"post", "params":form_data});
	}
	field._changed_file_content = function(event) {
		if(this.val() && !this.val().replace(/<br>/, "")) {
			this.val("");
		}
		this.field.update();
	}
	field.addCodeTag = function(type, value) {
		var tag = this.createTag(this.code_allowed, type);
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
		u.e.addEvent(tag._input, "keydown", this._changing_code_content);
		u.e.addEvent(tag._input, "keyup", this._code_updated);
		u.e.addEvent(tag._input, "mouseup", this._code_updated);
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
	field._changing_code_content = function(event) {
		if(event.keyCode == 13 || event.keyCode == 9) {
			u.e.kill(event);
		}
	}
	field._code_updated = function(event) {
		var selection = window.getSelection(); 
		if(event.keyCode == 13) {
			u.e.kill(event);
			if(selection && selection.isCollapsed) {
				var br = document.createTextNode("\n");
				range = selection.getRangeAt(0);
				range.insertNode(br);
				range.collapse(false);
				var selection = window.getSelection();
				selection.removeAllRanges();
				selection.addRange(range);
			}
		}
		if(event.keyCode == 9) {
			u.e.kill(event);
			if(selection && selection.isCollapsed) {
				var br = document.createTextNode("\t");
				range = selection.getRangeAt(0);
				range.insertNode(br);
				range.collapse(false);
				var selection = window.getSelection();
				selection.removeAllRanges();
				selection.addRange(range);
			}
		}
		else if(event.keyCode == 8) {
			if(this.is_deletable) {
				u.e.kill(event);
				var all_tags = u.qsa("div.tag", this.field);
				var prev = this.field.findPreviousInput(this);
				if(prev) {
					this.tag.parentNode.removeChild(this.tag);
					prev.focus();
				}
				u.sortable(this.field._editor, {"draggables":"tag", "targets":"editor"});
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
				var prev = this.field.findPreviousInput(this);
				if(u.hc(this.tag, this.field.list_allowed.join("|"))) {
					var all_lis = u.qsa("div.li", this.tag);
					if(prev) {
						this.tag.removeChild(this.li);
						if(!u.qsa("div.li", this.tag).length) {
							this.tag.parentNode.removeChild(this.tag);
						}
					}
				}
				else {
					if(prev) {
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
	field._focused_content = function(event) {
		this.field.is_focused = true;
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
		this.field.is_focused = false;
		u.rc(this.tag, "focus");
		u.rc(this.field, "focus");
		u.as(this.field, "zIndex", this.field._base_z_index);
		u.f.positionHint(this.field);
		this.field.hideSelectionOptions();
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
			prev = u.ps(iN.li, {"exclude":".drag,.remove,.type"});
		}
		if(!prev) {
			prev = u.ps(iN.tag);
			if(prev && u.hc(prev, this.list_allowed.join("|"))) {
				var items = u.qsa("div.li", prev);
				prev = items[items.length-1];
			}
			else if(prev && u.hc(prev, "file")) {
				if(!prev._variant) {
					var prev_iN = this.findPreviousInput(prev._input);
					if(prev_iN) {
						prev = prev_iN.tag;
					}
					else {
						prev = false;
					}
				}
			}
		}
		if(!prev) {
			prev = u.qs("div.tag", this);
			if(u.hc(prev, this.list_allowed.join("|"))) {
				prev = u.qs("div.li", prev);
			}
			else if(prev && u.hc(prev, "file")) {
				if(!prev._variant) {
					var prev_iN = this.findPreviousInput(prev._input);
					if(prev_iN) {
						prev = prev_iN.tag;
					}
					else {
						prev = false;
					}
				}
			}
		}
		return prev ? prev._input : false;
	}
	field.returnFocus = function(tag) {
		if(u.hc(tag, this.text_allowed.join("|"))) {
			tag._input.focus();
		}
		else if(u.hc(tag, "code")) {
			tag._input.focus();
		}
		else if(u.hc(tag, this.list_allowed.join("|"))) {
			var li = u.qs("div.li", tag);
			li._input.focus();
		}
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
	var nodes = u.cn(field._viewer, {"exclude":"br"});
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
			else if(node.nodeName.toLowerCase() == "code") {
				// 
				tag = field.addCodeTag(node.nodeName.toLowerCase(), node.innerHTML);
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
			else if(u.hc(node, "youtube|vimeo")) {
				field.addExternalVideoTag(node.className.match(field.ext_video_allowed.join("|")), node);
			}
			else if(u.hc(node, "file")) {
				field.addFileTag(node);
			}
			else if(u.hc(node, "media")) {
				field.addMediaTag(node);
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
				alert("HTML contains unautorized node:" + node.nodeName + "("+u.nodeId(node)+")" + "\nIt has been altered to conform with SEO and design.");
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


/*i-page.js*/
u.bug_force = true;
u.bug_console_only = true;
Util.Objects["page"] = new function() {
	this.init = function(page) {
		page.hN = u.qs("#header");
		page.hN.service = u.qs(".servicenavigation", page.hN);
		u.e.drag(page.hN, page.hN);
		page.logo = u.ie(page.hN, "a", {"class":"logo", "html":u.eitherOr(u.site_name, "Frontpage")});
		page.logo.url = '/';
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
			if(page.cN && page.cN.scene && typeof(page.cN.scene.scrolled) == "function") {
				page.cN.scene.scrolled();
			}
		}
		page.orientationchanged = function() {
			if(u.hc(page.bn_nav, "open")) {
				u.as(page.hN, "height", window.innerHeight + "px");
			}
		}
		page.ready = function() {
			if(!u.hc(this, "ready")) {
				u.addClass(this, "ready");
				u.e.addEvent(window, "resize", page.resized);
				u.e.addEvent(window, "scroll", page.scrolled);
				u.e.addEvent(window, "orientationchange", page.orientationchanged);
				this.initNavigation();
				this.resized();
				if(!u.getCookie("terms_v1")) {
					var terms = u.ie(page.cN, "div", {"class":"terms_notification"});
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
		page.initNavigation = function() {
			this.bn_nav = u.qs(".servicenavigation li.navigation", this.hN);
			u.ae(this.bn_nav, "div");
			u.ae(this.bn_nav, "div");
			u.ae(this.bn_nav, "div");
			u.ce(this.bn_nav);
			this.bn_nav.clicked = function(event) {
				if(u.hc(this, "open")) {
					u.rc(this, "open");
					u.as(page.hN, "height", "60px");
					u.as(page.nN, "display", "none");
				}
				else {
					u.ac(this, "open");
					u.as(page.hN, "height", window.innerHeight + "px");
					u.as(page.nN, "display", "block");
					page.nN.start_drag_y = (window.innerHeight - 100) - page.nN.offsetHeight;
					page.nN.end_drag_y = page.nN.offsetHeight;
				}
			}
			u.e.drag(this.nN, [0, (window.innerHeight - 100) - this.nN.offsetHeight, this.hN.offsetWidth, this.nN.offsetHeight], {"strict":false, "elastica":200, "vertical_lock":true});
			var i, node;
			this.hN.nodes = u.qsa("#navigation li,a.logo", page.hN);
			for(i = 0; node = this.hN.nodes[i]; i++) {
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
				if(u.e.event_pref == "mouse") {
					u.e.addEvent(node, "mouseover", node._mousedover);
					u.e.addEvent(node, "mouseout", node._mousedout);
				}
				else {
					u.e.addEvent(node, "touchstart", node._mousedover);
					u.e.addEvent(node, "touchend", node._mousedout);
				}
			}
		}
		page.ready();
	}
}
u.e.addDOMReadyEvent(u.init);


/*i-login.js*/
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
			page.resized();
		}
		scene.ready();
	}
}


/*i-signup.js*/
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
			page.resized();
		}
		scene.ready();
	}
}


/*i-newsletter.js*/
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
			page.resized();
		}
		scene.ready();
	}
}


/*i-article.js*/
Util.Objects["article"] = new function() {
	this.init = function(article) {
		var i, image;
		article._images = u.qsa("div.image,div.media", article);
		for(i = 0; image = article._images[i]; i++) {
			image._id = u.cv(image, "item_id");
			image._format = u.cv(image, "format");
			image._variant = u.cv(image, "variant");
			u.ce(image);
			u.rc(image, "link");
			if(image._id && image._format) {
				image._image_src = "/images/" + image._id + "/" + (image._variant ? image._variant+"/" : "") + "480x." + image._format;
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
			}
		}
		article.geolocation = u.qs("dl.geo", article);
		if(article.geolocation && typeof(u.injectGeolocation) == "function") {
			u.injectGeolocation(article);
		}
	}
}



/*i-documentation.js*/
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
		u.as(field._input, "width", (u.browserW()-60)+"px");
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
			u.svg({
				"node":func._header,
				"width": "15px",
				"height": "12px",
				"shapes":[
					{
						"type":"line",
						"x1":1,
						"y1":0,
						"x2":7,
						"y2":12
					},
					{
						"type":"line",
						"x1":6,
						"y1":12,
						"x2":12,
						"y2":0
					}
				]
			});
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
			func._uses = u.qs(".uses", func);
			u.as(func._uses, "height", "20px");
			func._uses._func = func;
			u.svg({
				"node":func._uses,
				"width": "15px",
				"height": "12px",
				"shapes":[
					{
						"type":"line",
						"x1":1,
						"y1":0,
						"x2":5,
						"y2":9
					},
					{
						"type":"line",
						"x1":4,
						"y1":9,
						"x2":8,
						"y2":0
					}
				]
			});
			u.e.click(func._uses);
			func._uses.clicked = function(event) {
				if(u.hc(this, "open")) {
					u.as(this, "height", "20px");
					u.rc(this, "open");
				}
				else {
					u.as(this, "height", "auto");
					u.ac(this, "open");
				}
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
			u.svg({
				"node":scene._files._header,
				"width": "15px",
				"height": "12px",
				"shapes":[
					{
						"type":"line",
						"x1":1,
						"y1":0,
						"x2":7,
						"y2":12
					},
					{
						"type":"line",
						"x1":6,
						"y1":12,
						"x2":12,
						"y2":0
					}
				]
			});
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
			u.svg({
				"node":scene._segments._header,
				"width": "15px",
				"height": "12px",
				"shapes":[
					{
						"type":"line",
						"x1":1,
						"y1":0,
						"x2":7,
						"y2":12
					},
					{
						"type":"line",
						"x1":6,
						"y1":12,
						"x2":12,
						"y2":0
					}
				]
			});
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
