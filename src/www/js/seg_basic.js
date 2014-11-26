
/*seg_basic_include.js*/

/*seg_basic_include.js*/

/*i-unsupported.js*/
function unsupported() {
	document.body.innerHTML = '<h1 style="text-align: center; margin: 20% 15% 15%; font-family: Arial; color: #333333">Your browser is NOT supported. It is more outdated than steam-engines, typewriters and VHS tapes, so stop acting surprised.</h1><p style="text-align: center; margin: 0 10%; font-family: Arial; color: #333333">or<br />(you changed your UserAgent)<br />(we are working on it)<br />(we made an error - <a href="mailto:info@parentnode.dk">let us know</a>)</p>';
}
window.onload = unsupported;

/*ga.js*/
u.ga_account = 'UA-49739795-1';
u.ga_domain = 'janitor.parentnode.dk';


/*u.js*/
if(!u || !Util) {
	var u, Util = u = new function() {};
	u.version = 0.8;
	u.bug = function() {};
	u.nodeId = function() {};
	u.stats = new function() {this.pageView = function(){};this.event = function(){};this.customVar = function(){};}
}


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


