<?php
include "control.php";
include "header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
$action = $_POST["action"];
if ($action == "send")
{
	$fromfield = $_POST['fromfield'];
	$subjectfield = $_POST['subjectfield'];
	$messagefield = $_POST['messagefield'];
	if(!$fromfield)
	{
	$error .= "<li>Please return and enter your name to appear in the from field of your message.</li>";
	}
	if(!$subjectfield)
	{
	$error .= "<li>Please return and enter the subject of your email.</li>";
	}
	if(!$messagefield)
	{
	$error .= "<li>Please return and enter a message body for your email.</li>";
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
	$q = "select * from earlysignups where verified=\"yes\" and referid=\"$userid\" order by email";
	$r = mysql_query($q);
	$rows = mysql_num_rows($r);
	if ($rows < 1)
	{
		?>
		<!-- PAGE CONTENT //-->
		<table cellpadding="4" cellspacing="0" border="0" align="center">
		<tr><td align="center" colspan="2"><div class="heading">ERROR</div></td></tr>
		<tr><td colspan="2" align="center"><br>You don't have any referrals yet to email.</td></tr>
		<tr><td align="center" colspan="2"><br><a href="members.php">Return To Main Page</a></td></tr>
		</table>
		<!-- END PAGE CONTENT //-->
		<?php
		include "footer.php";
		exit;
	}
	if ($rows > 0)
	{
		$mq = "select * from earlysignups where userid=\"$userid\" and lastmailedreferrals<DATE_SUB(NOW(), INTERVAL $howoftensponsorscanmailreferrals DAY)";
		$mr = mysql_query($mq);
		$mrows = mysql_num_rows($mr);
		if ($mrows > 0)
		{
		?>
		<!-- PAGE CONTENT //-->
		<table cellpadding="4" cellspacing="0" border="0" align="center">
		<tr><td align="center" colspan="2"><div class="heading">ERROR</div></td></tr>
		<tr><td colspan="2" align="center"><br>You emailed your downline less than <?php echo $howoftensponsorscanmailreferrals ?> day(s) ago, on <?php echo formatDate($lastmailedreferrals); ?>.</td></tr>
		<tr><td align="center" colspan="2"><br><a href="members.php">Return To Main Page</a></td></tr>
		</table>
		<!-- END PAGE CONTENT //-->
		<?php
		include "footer.php";
		exit;
		}
		if ($mrows < 1)
		{
		?>
		<!-- PAGE CONTENT //-->
		<table cellpadding="4" cellspacing="0" border="0" align="center">
		<tr><td align="center" colspan="2"><div class="heading">SENDING YOUR MESSAGE PLEASE WAIT . . .</div></td></tr>
		<?php
			while ($rowz = mysql_fetch_array($r))
				{
				$subject = "";
				$message = "";
				$from = "";
				$refid = $rowz["id"];
				$refemail = $rowz["email"];
				$reffirstname = $rowz["firstname"];
				$reflastname = $rowz["lastname"];
				$reffullname = $reffirstname . " " . $reflastname;
				$removelink = "<br><br>" . $disclaimer . "<br>" . "<a href=" . $domain . "/remove.php?r=" . $refemail . ">" . $domain . "/remove.php?r=" . $refemail . "</a><br>";

				$to = $refemail;
				$subject = ereg_replace ("~FIRSTNAME~", $reffirstname, $subjectfield);
				$subject = ereg_replace ("~LASTNAME~", $reflastname, $subject);
				$subject = stripslashes($subject);
				$from = stripslashes($fromfield);
				$message = ereg_replace ("~FIRSTNAME~", $reffirstname, $messagefield);
				$message = ereg_replace ("~LASTNAME~", $reflastname, $message);
				$message = stripslashes($message);

				$message = $message . $removelink;

				$headers = "From: $from <$adminemail>\n" .
						   "MIME-Version: 1.0\n" .
						   "Content-Type: text/html; charset=windows-1252\n" .
						   "X-Mailer: PHP - $title\n" .
							"Return-Path: $adminemail\n";

				@mail ($to, $subject, $message, $headers, "-f" . $adminemail);
				echo "<tr><td colspan=2 align=center><br>Message sent to " . $reffullname . "</td></tr>";
						} # while ($rowz = mysql_fetch_array($r))
				$timeq = "update earlysignups set lastmailedreferrals=NOW() where userid=\"$userid\"";
				$timer = mysql_query($timeq);
				?>
				<tr><td align="center" colspan="2"><br>SEND COMPLETED!</td></tr>
				<tr><td align="center" colspan="2"><br><a href="members.php">Return To Main Page</a></td></tr>
				</table>
				<!-- END PAGE CONTENT //-->
				<?php
				include "footer.php";
				exit;
		} # if ($mrows < 1)
	} # if ($rows > 0)
} # if ($action == "send")
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading">Mail Your Downline!</div></td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Mail Downline Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>

<tr><td align="center">
<?php
include "membernav.php";
?>
</td></tr>

<tr><td><br><br>
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="./jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	extended_valid_elements : "a[href|target|name],font[face|size|color|style],span[class|align|style]"
});
</script>
<!-- /tinyMCE --> 
<table cellpadding="2" cellspacing="2" border="0" align="center" bgcolor="#989898" width="600">
<?php
$mq = "select * from earlysignups where userid=\"$userid\" and lastmailedreferrals<DATE_SUB(NOW(), INTERVAL $howoftensponsorscanmailreferrals DAY)";
$mr = mysql_query($mq);
$mrows = mysql_num_rows($mr);
if ($mrows < 1)
{
?>
<tr bgcolor="#d3d3d3"><td align="center" colspan="2">You emailed your downline less than <?php echo $howoftensponsorscanmailreferrals ?> day(s) ago, on <?php echo formatDate($lastmailedreferrals); ?>.</td></tr>
<?php
}
if ($mrows > 0)
{
	$q = "select * from earlysignups where verified=\"yes\" and referid=\"$userid\" order by email";
	$r = mysql_query($q);
	$rows = mysql_num_rows($r);
	if ($rows < 1)
	{
	?>
	<tr bgcolor="#d3d3d3"><td align="center" colspan="2">You don't have any verified referrals yet to send mail to.</td></tr>
	<?php
	}
	if ($rows > 0)
	{
	?>
	<form action="maildownline.php" method="post" name="theform">
	<tr bgcolor="#d3d3d3"><td colspan="2">You may use the personalization variables ~FIRSTNAME~ or ~LASTNAME~ anywhere in your subject or message body, typed EXACTLY as shown (case sensitive)</td></tr>
	<tr bgcolor="#eeeeee"><td colspan="2" align="center" >Your Name That Should Appear In The From Field In The Recipient Inboxes:</td></tr>
	<tr bgcolor="#eeeeee"><td align="center"><input type="text" class="typein" name="fromfield" maxlength="255" size="95"></td></tr>
	<tr bgcolor="#eeeeee"><td colspan="2" align="center" >Subject Of Your Email:</td></tr>
	<tr bgcolor="#eeeeee"><td align="center"><input type="text" class="typein" name="subjectfield" maxlength="255" size="95"></td></tr>
	<tr bgcolor="#eeeeee"><td colspan="2" align="center" >Your Message Body:</td></tr><tr><td colspan="2" align="center"><textarea name="messagefield" maxlength="50000" rows="15" cols="72"></textarea></td></tr>
	<tr bgcolor="#d3d3d3"><td colspan="2" align="center"><input type="hidden" name="action" value="send"><input type="submit" value="SEND EMAIL" class="sendit" style="width: 150px;"></form></td></tr>
	<?php
	} # if ($rows > 0)
} # if ($mrows > 0)
?>
</table>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>