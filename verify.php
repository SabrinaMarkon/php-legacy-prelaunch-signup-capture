<?php
include "db.php";
$userid = $_GET["userid"];
$email = $_GET["email"];
$show = "";
if ((empty($userid)) or (empty($email)))
{
$show = "Invalid link";
}
$q = "select * from earlysignups where userid=\"$userid\" and email=\"$email\"";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
$show = "Invalid link";
}
$id = mysql_result($r,0,"id");
if ($show != "")
{
include "header.php";
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
<tr><td align="center" colspan="2">
<?php
echo $show;
?>
</td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
}
$password = mysql_result($r,0,"password");
$sponsor = mysql_result($r,0,"referid");
$q2 = "update earlysignups set verified=\"yes\",verifieddate=NOW() where userid=\"$userid\"";
$r2 = mysql_query($q2);
# contest
$cq = "insert into contest (userid,referid,dateadded) values (\"$userid\",\"$sponsor\",NOW())";
$cr = mysql_query($cq);

# email sponsor
	$referq = "select * from earlysignups where userid=\"$sponsor\"";
	$referr = mysql_query($referq);
	$referrows = mysql_num_rows($referr);
	if ($referrows > 0)
		{
		$sponsorfirstname = mysql_result($referr,0,"firstname");
		$sponsorlastname = mysql_result($referr,0,"lastname");
		$sponsoremail = mysql_result($referr,0,"email");

		$headerssponsor .= "From: $sitename <$adminemail>\n";
		$headerssponsor .= "Reply-To: <$adminemail>\n";
		$headerssponsor .= "X-Sender: <$adminemail>\n";
		$headerssponsor .= "X-Mailer: PHP5\n";
		$headerssponsor .= "X-Priority: 3\n";
		$headerssponsor .= "Return-Path: <$adminemail>\n";
		$subjectsponsor = "You've Made a new " . $sitename . " Referral!";
		$messagesponsor = "Dear $sponsorfirstname $sponsorlastname,\n\nThis is a notification that a new verified member has joined $sitename under you:\n\n
		User ID: $newid\n
		Username: $userid\n
		Name: $firstname $lastname\n\n
		$sitename\n
		$domain
		";
		@mail($sponsoremail, $subjectsponsor, wordwrap(stripslashes($messagesponsor)),$headerssponsor, "-f$adminemail");
		} # if ($referrows > 0)

@header("Location: " . $domain . "/members.php?loginusername=" . $id . "&loginpassword=" . $password . "&newlogin=1");
exit;
?>