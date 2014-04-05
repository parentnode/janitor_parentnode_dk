
/*seg_mobile_light_include.js*/

/*u.js*/
if(!u || !Util) {
	var u, Util = u = new function() {};
	u.version = 0.8;
	u.bug = function() {};
	u.nodeId = function() {};
	u.stats = new function() {this.pageView = function(){};this.event = function(){};this.customVar = function(){};}
}


/*ga.js*/
u.ga_account = 'UA-49732426-1';
u.ga_domain = 'detector.parentnode.dk';


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

