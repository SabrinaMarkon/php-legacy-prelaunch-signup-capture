<?php
include "control.php";
include "header.php";
if ($_POST["newlogin"])
{
$newloginq = "update earlysignups set lastlogin=NOW() where userid=\"$userid\"";
$newloginr = mysql_query($newloginq);
}
$action = $_POST["action"];
if ($action == "save")
{
$savepassword = $_POST["savepassword"];
$savefirstname = $_POST["savefirstname"];
$savelastname = $_POST["savelastname"];
$saveemail = $_POST["saveemail"];
$oldemail = $_POST["oldemail"];

	if (!$savepassword)
	{
	$error = "<div>Please return and enter a password.</div>";
	}
	if(!$savefirstname)
	{
	$error .= "<div>Please return and enter a first name.</div>";
	}
	if(!$savelastname)
	{
	$error .= "<div>Please return and enter a last name.</div>";
	}
	if(!$saveemail)
	{
	$error .= "<div>Please return and enter an email address.</div>";
	}
	if(!$error == "")
	{
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" align="center">
	<tr><td align="center" colspan="2"><div class="heading">ERROR</div></td></tr>
	<tr><td colspan="2"><br>Please return to the form and correct the following problems:<br>
	<ul><?php echo $error ?></ul>
	</td></tr>
	<tr><td align="center" colspan="2"><br>
	<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
	</td></tr>

	<tr><td align="center" colspan="2"><br><a href="members.php">Return To Main Page</a></td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
	}
$q = "update earlysignups set password=\"$savepassword\",firstname=\"$savefirstname\",lastname=\"$savelastname\",email=\"$saveemail\" where id=\"$saveid\"";
$r = mysql_query($q);
$password = $savepassword;
$_SESSION["loginpassword"] = $savepassword;
if ($oldemail != $saveemail)
	{
	$q2 = "update earlysignups set verified=\"no\" where userid=\"$userid\"";
	$r2 = mysql_query($q2);
	$tomember = $saveemail;
	$headersmember .= "From: $sitename <$adminemail>\n";
	$headersmember .= "Reply-To: <$adminemail>\n";
	$headersmember .= "X-Sender: <$adminemail>\n";
	$headersmember .= "X-Mailer: PHP5\n";
	$headersmember .= "X-Priority: 3\n";
	$headersmember .= "Return-Path: <$adminemail>\n";
	$subjectmember = $sitename . " Re-Verification Email";
	$messagemember = "Dear ".$firstname." ".$lastname.",\n\n"
	   ."Please re-verify your email address by clicking this link ".$domain."/verify.php?userid=".$userid."&email=".$saveemail."\n\n"
	   ."Your login URL is: ".$domain."/login.php\n\n"
	   ."Thank you!\n\n\n"
	   .$sitename." Admin\n"
	   .$adminemail."\n\n\n\n";
	@mail($tomember, $subjectmember, wordwrap(stripslashes($messagemember)),$headersmember, "-f$adminemail");
	} # if ($oldemail != $email)
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" align="center">
<tr><td align="center" colspan="2"><div class="heading">Account Updated!</div></td></tr>
<?php
if ($oldemail != $saveemail)
	{
	?>
	<tr><td colspan="2" align="center"><br>You changed your email address, so will need to re-verify your address by clicking the link in the email that has been sent to your new address.</td></tr>
	<?php
	}
	?>
<tr><td align="center" colspan="2"><br><a href="members.php">Return To Main Page</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "save")
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading">Welcome <?php echo $firstname ?></div></td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td><br>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Members Area'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;

$affiliateurl = $domain . "/index.php?referid=" . $userid;

$refq = "select * from earlysignups where referid=\"$userid\"";
$refr = mysql_query($refq);
$referrals = mysql_num_rows($refr);

$sponsorq = "select * from earlysignups where userid=\"$userid\"";
$sponsorr = mysql_query($sponsorq);
$sponsorrows = mysql_num_rows($sponsorr);
if ($sponsorrows > 0)
{
$sponsor = mysql_result($sponsorr,0,"referid");
}
?>
</div>
</td></tr>


<tr><td align="center">
<?php
include "membernav.php";
?>
</td></tr>

<tr><td><br><br>
<form action="members.php" method="post">
<table cellpadding="2" cellspacing="2" border="0" align="center" bgcolor="#989898">
<tr bgcolor="#d3d3d3"><td>Your Affiliate URL:</td><td><a href="<?php echo $affiliateurl ?>" target="_blank"><?php echo $affiliateurl ?></a></td></tr>
<tr bgcolor="#eeeeee"><td>Referrals:</td><td><?php echo $referrals ?></td></tr>
<tr bgcolor="#eeeeee"><td>User ID# (for login):</td><td><?php echo $id ?></td></tr>
<tr bgcolor="#eeeeee"><td>Username</td><td><?php echo $userid ?></td></tr>
<tr bgcolor="#eeeeee"><td>Password:</td><td><input type="text" name="savepassword" value="<?php echo $password ?>" size="25" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>First Name:</td><td><input type="text" name="savefirstname" value="<?php echo $firstname ?>" size="25" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Last Name:</td><td><input type="text" name="savelastname" value="<?php echo $lastname ?>" size="25" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Email:</td><td><input type="text" name="saveemail" value="<?php echo $email ?>" size="25" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Sponsor:</td><td><?php echo $sponsor ?></td></tr>
<tr bgcolor="#d3d3d3"><td align="center" colspan="2"><input type="hidden" name="action" value="save">
<input type="hidden" name="saveid" value="<?php echo $id ?>">
<input type="hidden" name="oldemail" value="<?php echo $email ?>">
<input type="submit" value="SAVE"></form></td></tr>
</table>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>