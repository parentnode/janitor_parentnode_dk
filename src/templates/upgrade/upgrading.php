Update paths



RENAME


/src/www/admin
to 
/src/www/janitor


/src/templates/admin
to 
/src/templates/janitor


/src/templates/admin.header.php
to 
/src/templates/janitor.header.php


/src/templates/admin.footer.php
to 
/src/templates/janitor.footer.php



UPDATE


Alias "/janitor"
to
Alias "/janitor/admin"


Alias "/admin/js/lib/build"
to
Alias "/janitor/js/lib/build"


Alias "/admin/css/lib/build"
to
Alias "/janitor/css/lib/build"



SEARCH AND REPLACE


@import url(/janitor/
to
@import url(/janitor/admin/


@import url(/admin/
to
@import url(/janitor/


src="/janitor
to
src="/janitor/admin


src="/admin
to
src="/janitor


<a href="/admin">
to
<a href="/janitor">


"/admin/cms
to
"/janitor/admin/items


"/admin/user
to
"/janitor/admin/user


"/admin/navigation
to
"/janitor/admin/navigation


"/admin/shop
to
"/janitor/admin/shop


"/admin/tag
to
"/janitor/admin/tag


"/admin/
to
"/janitor/


"admin/"
to
"janitor/"


// /admin
to
// /janitor


"type" => "admin"
to
"type" => "janitor"


validAction
to
validPath


// MANUAL UPDATES
remove old alias' from apache conf
check specific apache log in apache conf
update autoconversion alias in apache conf
update 404 path in apache conf

modify DB user_access manually or run quickfix-access if site is already set up with users

check if SITE_MAIL exists in config.php (it should)
check values of DEFAULT_COUNTRY_ISO and DEFAULT_COUNTRY_ISO in config.php
check SITE_COLLECT_NOTIFICATIONS in config.php (should be declared)
check SITE_URL in config.php = define("SITE_URL", $_SERVER["SERVER_NAME"]);

Implement simplified connect_mail.php (without from + name)


page and post
Update paths in janitor.footer.php 
delete controllers and templates if exists (and remove css for backend)


in janitor list templates width images: 
image:".$media["format"] to format:".$media["format"]
and add image class manually




Run /setup

