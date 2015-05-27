<?php
if(!isset($_SESSION))
{
session_start();
}
include "db.php";
if ($_REQUEST["loginusername"])
{
$_SESSION["loginusername"] = $_REQUEST["loginusername"];
$_SESSION["loginpassword"] = $_REQUEST["loginpassword"];
}
$loginq = "select * from earlysignups where userid=\"".$_SESSION["loginusername"]."\" and password=\"".$_SESSION["loginpassword"]."\"";
$loginr = mysql_query($loginq);
$loginrows = mysql_num_rows($loginr);
	if ($loginrows < 1)
	{
	unset($_SESSION["loginusername"]);
	unset($_SESSION["loginpassword"]);
	session_destroy();
	$show = "<div class=\"message\">Incorrect Login</div>";
	@header("Location: " . $domain . "/login.php?show=" . $show);
	exit;
	}
	if ($loginrows > 0)
	{
	$id = mysql_result($loginr,0,"id");
	$userid = mysql_result($loginr,0,"userid");
	$password = mysql_result($loginr,0,"password");
	$referid = mysql_result($loginr,0,"referid");
	$firstname = mysql_result($loginr,0,"firstname");
	$lastname = mysql_result($loginr,0,"lastname");
	$email = mysql_result($loginr,0,"email");
	$signupdate = mysql_result($loginr,0,"signupdate");
	$signupip = mysql_result($loginr,0,"signupip");
	$verified = mysql_result($loginr,0,"verified");
	$verifieddate = mysql_result($loginr,0,"verifieddate");
	$lastmailedreferrals = mysql_result($loginr,0,"lastmailedreferrals");
	}
extract($_REQUEST);
?>