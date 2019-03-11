<?
$UC = new User;

if ($UC->isVerified()) {
	print "VERIFIED";
	exit;
}

print "NOT_VERIFIED";
exit;

?>