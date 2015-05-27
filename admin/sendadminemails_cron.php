<?php
include "../db.php";
$query3 = "select * from adminemails where sent=0 limit 1";
$result3 = mysql_query ($query3) or die (mysql_error());
$numrows2 = @ mysql_num_rows($result3);
if ($numrows2 < 1) 
{
exit;
}
$line3 = mysql_fetch_array($result3);
$subject = $line3["subject"];
$subject = stripslashes($subject);
$subject = str_replace('\\', '', $subject);
$adbody = $line3["adbody"];
$adbody = stripslashes($adbody);
$adbody = str_replace('\\', '', $adbody);
$fromfield = $line3["fromfield"];
$fromfield = stripslashes($fromfield);
$fromfield = str_replace('\\', '', $fromfield);
$url = $line3["url"];
$id = $line3["id"];
$query5 = "update adminemails set sent=1 where id=".$id;
$result5 = mysql_query ($query5) or die (mysql_error());   
$query6 = "update adminemails set datesent='".time()."' where id=".$id;
$result6 = mysql_query ($query6) or die (mysql_error());
$query4 = "select * from earlysignups where verified='yes'";
$result4 = mysql_query($query4);
while ($line4 = mysql_fetch_array($result4))
{
    $email = $line4["email"];
    $userid = $line4["userid"];
	$firstname = $line4["firstname"];
	$lastname = $line4["lastname"];
    $password = $line4["password"];
    $Subject = $subject;
    $Message = $adbody;
    $Message .= "<br><br>--------------------------------------------------------------<br><br>";
    $Message .= "<a href=\"".$url."\">Click Here to Visit! ".$url."</a>";
	$Message .= "<br><br>This " . $sitename . " Ad was submitted by the site admin.";
    $Message .= ".<br><br>";
    $Message .= "--------------------------------------------------------------<br><br>";
    $Message .= "<br><br>" . $disclaimer . "<br>" . "<a href=" . $domain . "/remove.php?r=" . $email . ">" . $domain . "/remove.php?r=" . $email . "</a><br>";
	
	$headers = "From: $fromfield<$adminemail>\n";
	$headers .= "Reply-To: <$adminemail>\n";
	$headers .= "X-Sender: <$adminemail>\n";
	$headers .= "X-Mailer: PHP4\n";
	$headers .= "X-Priority: 3\n";
	$headers .= "Return-Path: <$adminemail>\nContent-type: text/html; charset=iso-8859-1\n";

	$Message = str_replace("~LASTNAME~",$lastname,$Message);
	$Message = str_replace("~FIRSTNAME~",$firstname,$Message);
	$Subject = str_replace("~LASTNAME~",$lastname,$Subject);
	$Subject = str_replace("~FIRSTNAME~",$firstname,$Subject);

    @mail($email, $Subject, wordwrap(stripslashes($Message)),$headers, "-f$adminemail");

    $counter=$counter+1;

echo "Mail sent to " . $email . "<br>";
}
$ssq1 = "select * from adminemails where sent=1 and datesent<='".(time()-31*24*60*60)."'";
$ssr1 = mysql_query($ssq1) or die(mysql_error());
while($ssrowz1 = mysql_fetch_array($ssr1))
{
$ssq3 = "delete from adminemails where id='".$ssrowz1['id']."'";
$ssr3 = mysql_query($ssq3);
}
exit;
?>