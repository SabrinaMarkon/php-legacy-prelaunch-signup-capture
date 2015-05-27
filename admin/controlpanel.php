<?php
include "control.php";
include "../header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
?>
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	extended_valid_elements : "a[href|target|name],font[face|size|color|style],span[class|align|style]"
});
</script>
<!-- /tinyMCE --> 
<?php
$action = $_REQUEST["action"];
$orderedby = $_REQUEST["orderedby"];
$show = "";
if ($orderedby == "id")
{
$orderedbyq = "id";
}
if ($orderedby == "userid")
{
$orderedbyq = "userid";
}
elseif ($orderedby == "password")
{
$orderedbyq = "password";
}
elseif ($orderedby == "firstname")
{
$orderedbyq = "firstname";
}
elseif ($orderedby == "lastname")
{
$orderedbyq = "lastname";
}
elseif ($orderedby == "email")
{
$orderedbyq = "email";
}
elseif ($orderedby == "referid")
{
$orderedbyq = "referid";
}
elseif ($orderedby == "signupdate")
{
$orderedbyq = "signupdate";
}
elseif ($orderedby == "signupip")
{
$orderedbyq = "signupip";
}
elseif ($orderedby == "verified")
{
$orderedbyq = "verified";
}
elseif ($orderedby == "howmanydayssincelastverificationsent")
{
$orderedbyq = "howmanydayssincelastverificationsent desc";
}
else
{
$orderedbyq = "id";
}
if ($action == "savesettings")
{
$adminuserid = $_POST["adminuseridp"];
$adminpassword = $_POST["adminpasswordp"];
$adminname = $_POST["adminnamep"];
$domain = $_POST["domainp"];
$sitename = $_POST["sitenamep"];
$adminemail = $_POST["adminemailp"];
$enablememberleaderboard = $_POST["enablememberleaderboardp"];
$enablemembercontestboard = $_POST["enablemembercontestboardp"];
$deleteunverifieddays= $_POST["deleteunverifieddaysp"];
$howoftensponsorscanmailreferrals= $_POST["howoftensponsorscanmailreferralsp"];
$chatwithuslink = $_POST["chatwithuslinkp"];
$defaultreferid = $_POST["defaultreferidp"];
$disclaimer = $_POST["disclaimerp"];
$disclaimer = stripslashes($disclaimer);
$disclaimer = str_replace("\\","",$disclaimer);
$update = mysql_query("update adminsettings set setting='$adminuserid' where name='adminuserid'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminpassword' where name='adminpassword'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminname' where name='adminname'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$domain' where name='domain'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$sitename' where name='sitename'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminemail' where name='adminemail'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$enablememberleaderboard' where name='enablememberleaderboard'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$enablemembercontestboard' where name='enablemembercontestboard'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$deleteunverifieddays' where name='deleteunverifieddays'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$howoftensponsorscanmailreferrals' where name='howoftensponsorscanmailreferrals'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$disclaimer' where name='disclaimer'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$chatwithuslink' where name='chatwithuslink'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$defaultreferid' where name='defaultreferid'") or die(mysql_error());
$_SESSION["loginusernameadmin"] = $adminuserid;
$_SESSION["loginpasswordadmin"] = $adminpassword;
$adminuserid = $adminuseridp;
$adminpassword = $adminpasswordp;
$show = "Settings Saved!";
} # if ($action == "savesettings")
######################################################
if ($action == "delete")
{
$deleteid = $_POST["deleteid"];
$deleteuserid = $_POST["deleteuserid"];
$q = "delete from earlysignups where id=\"$deleteid\"";
$r = mysql_query($q);
$show = "Member " . $deleteuserid . " Deleted";
} # if ($action == "delete")
######################################################
if ($action == "save")
{
$saveid = $_POST["saveid"];
$userid = $_POST["userid"];
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$referid = $_POST["referid"];
$howmanydayssincelastverificationsent = $_POST["howmanydayssincelastverificationsent"];
	if (!$userid)
	{
	$error = "<div>Please return and enter a userid.</div>";
	}
	if(!$password)
	{
	$error .= "<div>Please return and enter a password.</div>";
	}
	if(!$firstname)
	{
	$error .= "<div>Please return and enter a first name.</div>";
	}
	if(!$lastname)
	{
	$error .= "<div>Please return and enter a last name.</div>";
	}
	if(!$email)
	{
	$error .= "<div>Please return and enter an email address.</div>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="70%">
	<tr><td align="center" colspan="2"><b>New Member Signup Error</b></td></tr>
	<tr><td colspan="2"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="controlpanel.php?orderedby=<?php echo $orderedbyq ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
	$savememberq = "update earlysignups set userid='$userid',password='$password',firstname='$firstname',lastname='$lastname',email='$email',referid='$referid',howmanydayssincelastverificationsent='$howmanydayssincelastverificationsent' where id='$saveid'";
	$savememberr = mysql_query($savememberq) or die(mysql_error());
$show = "Member " . $userid . " Saved!";
} # if ($action == "save")
######################################################
if ($action == "search")
{
$searchfor = $_REQUEST["searchfor"];
$searchby = $_REQUEST["searchby"];
if ($searchfor == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="70%">
	<tr><td align="center" colspan="2"><b>Error</b></td></tr>
	<tr><td colspan="2" align="center"><br>Search field was left blank</td></tr>
	<tr><td colspan="2" align="center"><br><a href="controlpanel.php?orderedby=<?php echo $orderedbyq ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
$q = "select * from earlysignups where $searchby=\"$searchfor\" order by $orderedbyq";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="70%">
	<tr><td align="center" colspan="2"><b>No Results Found</b></td></tr>
	<tr><td colspan="2" align="center"><br><a href="controlpanel.php?orderedby=<?php echo $orderedbyq ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
if ($rows > 0)
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="70%">
	<tr><td align="center" colspan="2"><b>Search Results</b></td></tr>

	<tr><td colspan="2" align="center"><table cellpadding="0" cellspacing="1" border="0" align="center" bgcolor="#989898" width="600">

	<tr bgcolor="#d3d3d3" style="font-size: 10px;">
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=id&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">ID</a></td>
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=userid&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Username</a></td>
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=password&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Password</a></td>
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=firstname&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">First&nbsp;Name</a></td>
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=lastname&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Last&nbsp;Name</a></td>
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=email&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Email</a></td>
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=verified&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Verified</a></td>
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=howmanydayssincelastverificationsent&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Days Since Verification Email Sent</a></td>
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=referid&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Sponsor</a></td>
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=signupip&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Signup IP</a></td>
	<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=signupdate&action=search&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Signup Date</a></td>
	<td align="center"><font style="font-size: 10px;">SAVE</font></td>
	<td align="center"><font style="font-size: 10px;">RESEND VERIFICATION</font></td>
	<td align="center"><font style="font-size: 10px;">DELETE</font></td>
	</tr>
	<?php
	while ($rowz = mysql_fetch_array($r))
		{
		$id = $rowz["id"];
		$userid = $rowz["userid"];
		$password = $rowz["password"];
		$firstname = $rowz["firstname"];
		$lastname = $rowz["lastname"];
		$email = $rowz["email"];
		$referid = $rowz["referid"];
		$signupdate = $rowz["signupdate"];
		$signupdate = formatDate($signupdate);
		$signupip = $rowz["signupip"];
		$verified = $rowz["verified"];
		$verifieddate = $rowz["verifieddate"];
		$howmanydayssincelastverificationsent = $rowz["howmanydayssincelastverificationsent"];
		?>
		<form action="controlpanel.php" method="post">
		<tr bgcolor="#eeeeee" style="font-size: 10px;">
		<td align="center"><?php echo $id ?></td>
		<td align="center"><input type="text" name="userid" value="<?php echo $userid ?>" size="8" maxlength="255" class="typein" style="font-size: 10px;"></td>
		<td align="center"><input type="text" name="password" value="<?php echo $password ?>" size="8" maxlength="255" class="typein" style="font-size: 10px;"></td>
		<td align="center"><input type="text" name="firstname" value="<?php echo $firstname ?>" size="8" maxlength="255" class="typein" style="font-size: 10px;"></td>
		<td align="center"><input type="text" name="lastname" value="<?php echo $lastname ?>" size="8" maxlength="255" class="typein" style="font-size: 10px;"></td>
		<td align="center"><input type="text" name="email" value="<?php echo $email ?>" size="8" maxlength="255" class="typein" style="font-size: 10px;"></td>
		<td align="center"><?php echo $verified ?></td>
		<td align="center">
		<?php
			if ($verified == "yes")
			{
			echo "N/A";
			}
			if ($verified != "yes")
			{
			echo $howmanydayssincelastverificationsent;
			}
		?>
		</td>

		<td align="center">
		<select name="referid" class="pickone" style="font-size: 10px;">
		<?php
		$refq = "select * from earlysignups order by userid";
		$refr = mysql_query($refq);
		$refrows = mysql_num_rows($refr);
		if ($refrows < 1)
				{
				echo "<option value=\"admin\">admin</option>";
				}
		if ($refrows > 0)
				{
				?>
				<option value="admin" <?php if ($referid == "admin") { echo "selected"; } ?>>admin</option>
				<?php
					while ($refrowz = mysql_fetch_array($refr))
					{
					$ref = $refrowz["userid"];
					?>
					<option value="<?php echo $ref ?>" <?php if ($ref == $referid) { echo "selected"; } ?>><?php echo $ref ?></option>
					<?php
					}
				}
		?>
		</select>
		</td>

		<td align="center"><?php echo $signupip ?></td>
		<td align="center"><?php echo $signupdate ?></td>

		<td align="center">
		<input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>">
		<input type="hidden" name="saveid" value="<?php echo $id ?>">
		<input type="hidden" name="action" value="save">
		<input type="submit" value="SAVE" style="font-size: 10px;">
		</form>
		</td>

		<form action="controlpanel.php" method="post">
		<td align="center">
		<input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>">
		<input type="hidden" name="resenduserid" value="<?php echo $userid ?>">
		<input type="hidden" name="resendpassword" value="<?php echo $password ?>">
		<input type="hidden" name="resendfirstname" value="<?php echo $firstname ?>">
		<input type="hidden" name="resendlastname" value="<?php echo $lastname ?>">
		<input type="hidden" name="resendemail" value="<?php echo $email ?>">
		<input type="hidden" name="resendid" value="<?php echo $id ?>">
		<input type="hidden" name="action" value="resendvalidationemail">
		<input type="submit" value="RESEND" style="font-size: 10px;">
		</form>
		</td>

		<form action="controlpanel.php" method="post">
		<td align="center">
		<input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>">
		<input type="hidden" name="deleteuserid" value="<?php echo $userid ?>">
		<input type="hidden" name="deleteid" value="<?php echo $id ?>">
		<input type="hidden" name="action" value="delete">
		<input type="submit" value="DELETE" style="font-size: 10px;">
		</form>
		</td>

		</tr>
		<?php
		} # while ($rowz = mysql_fetch_array($r))
	?>
	</table></td></tr>
	<tr><td colspan="2" align="center"><br><a href="controlpanel.php?orderedby=<?php echo $orderedbyq ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	} # if ($rows > 0)
} # if ($action == "search")
######################################################
if ($action == "resendallverificationemails")
{
$rq = "select * from earlysignups where verified!=\"yes\" order by id";
$rr = mysql_query($rq);
$rrows = mysql_num_rows($rr);
if ($rrows < 1)
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="70%">
	<tr><td align="center" colspan="2"><b>There Are No Unverified Members</b></td></tr>
	<tr><td colspan="2" align="center"><br><a href="controlpanel.php?orderedby=<?php echo $orderedbyq ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
if ($rrows > 0)
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="70%">
	<tr><td align="center" colspan="2"><b>Resending Verification Emails...</b></td></tr>
	<tr><td align="center" colspan="2"><br></td></tr>
	<?php
	while ($rrowz = mysql_fetch_array($rr))
		{
		$id = $rrowz["id"];
		$userid = $rrowz["userid"];
		$password = $rrowz["password"];
		$firstname = $rrowz["firstname"];
		$lastname = $rrowz["lastname"];
		$email = $rrowz["email"];

		$tomember = $email;
		$headersmember .= "From: $sitename <$adminemail>\n";
		$headersmember .= "Reply-To: <$adminemail>\n";
		$headersmember .= "X-Sender: <$adminemail>\n";
		$headersmember .= "X-Mailer: PHP5\n";
		$headersmember .= "X-Priority: 3\n";
		$headersmember .= "Return-Path: <$adminemail>\n";
		$subjectmember = "Welcome to " . $sitename;
		$messagemember = "Dear ".$firstname." ".$lastname.",\n\nThank you for signing up for our ".$sitename." prelaunch!\nYour account details are below:\n\n"
		   ."User ID: $newid\n"
		   ."Username: ".$userid."\nPassword: ".$password."\n\n"
		   ."Please verify your email address by clicking this link ".$domain."/verify.php?userid=".$userid."&email=".$email."\n\n"
		   ."Your unique affiliate URL is: ".$domain."/index.php?referid=".$userid ."\n\n"
		   ."Your login URL is: ".$domain."/login.php\n\n"
		   ."Thank you!\n\n\n"
		   .$sitename." Admin\n"
		   .$adminemail."\n\n\n\n";
		@mail($tomember, $subjectmember, wordwrap(stripslashes($messagemember)),$headersmember, "-f$adminemail");

		$lastverificationq = "update earlysignups set howmanydayssincelastverificationsent=0 where id=\"$id\"";
		$lastverificationr = mysql_query($lastverificationq);
		?>
		<tr><td align="center" colspan="2">Verification email sent to User ID#<?php echo $id ?> with Username <?php echo $userid ?> at <a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></td></tr>
		<?php
		} # while ($rrowz = mysql_fetch_array($rr))
		?>
		<tr><td colspan="2" align="center"><br><a href="controlpanel.php?orderedby=<?php echo $orderedbyq ?>">RETURN</a></td></tr>
		</table>
		<br><br>
		<?php
		include "../footer.php";
		exit;
	} # if ($rrows > 0)
} # if ($action == "resendallverificationemails")
######################################################
if ($action == "resendvalidationemail")
{
$userid = $_POST["resenduserid"];
$password = $_POST["resendpassword"];
$firstname = $_POST["resendfirstname"];
$lastname = $_POST["resendlastname"];
$email = $_POST["resendemail"];
$id = $_POST["resendid"];

					$tomember = $email;
					$headersmember .= "From: $sitename <$adminemail>\n";
					$headersmember .= "Reply-To: <$adminemail>\n";
					$headersmember .= "X-Sender: <$adminemail>\n";
					$headersmember .= "X-Mailer: PHP5\n";
					$headersmember .= "X-Priority: 3\n";
					$headersmember .= "Return-Path: <$adminemail>\n";
					$subjectmember = "Welcome to " . $sitename;
					$messagemember = "Dear ".$firstname." ".$lastname.",\n\nThank you for signing up for our ".$sitename." prelaunch!\nYour account details are below:\n\n"
					   ."User ID: $newid\n"
					   ."Username: ".$userid."\nPassword: ".$password."\n\n"
					   ."Please verify your email address by clicking this link ".$domain."/verify.php?userid=".$userid."&email=".$email."\n\n"
					   ."Your unique affiliate URL is: ".$domain."/index.php?referid=".$userid ."\n\n"
					   ."Your login URL is: ".$domain."/login.php\n\n"
					   ."Thank you!\n\n\n"
					   .$sitename." Admin\n"
					   .$adminemail."\n\n\n\n";
					@mail($tomember, $subjectmember, wordwrap(stripslashes($messagemember)),$headersmember, "-f$adminemail");

		$lastverificationq = "update earlysignups set howmanydayssincelastverificationsent=0 where id=\"$id\"";
		$lastverificationr = mysql_query($lastverificationq);
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="70%">
	<tr><td align="center" colspan="2"><b>Verification Email Resent!</b></td></tr>
	<tr><td align="center" colspan="2"><br>Email was sent to Username <?php echo $userid ?> at Email Address <a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></td></tr>
	<tr><td colspan="2" align="center"><br><a href="controlpanel.php?orderedby=<?php echo $orderedbyq ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
} # if ($action == "resendvalidationemail")
######################################################
if ($action == "searchandresendvalidation")
{
$searchfor = $_REQUEST["searchfor"];
$searchby = $_REQUEST["searchby"];
if ($searchfor == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="70%">
	<tr><td align="center" colspan="2"><b>Error</b></td></tr>
	<tr><td colspan="2" align="center"><br>Verification search form field was left blank</td></tr>
	<tr><td colspan="2" align="center"><br><a href="controlpanel.php?orderedby=<?php echo $orderedbyq ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
$q = "select * from earlysignups where $searchby=\"$searchfor\" order by $orderedbyq";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="70%">
	<tr><td align="center" colspan="2"><b>No Results Found</b></td></tr>
	<tr><td colspan="2" align="center"><br><a href="controlpanel.php?orderedby=<?php echo $orderedbyq ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
if ($rows > 0)
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="70%">
	<tr><td align="center" colspan="2"><b>Resending Verification Emails...</b></td></tr>
	<tr><td align="center" colspan="2"><br></td></tr>
	<?php
	while ($rowz = mysql_fetch_array($r))
		{
		$id = $rowz["id"];
		$userid = $rowz["userid"];
		$password = $rowz["password"];
		$firstname = $rowz["firstname"];
		$lastname = $rowz["lastname"];
		$email = $rowz["email"];

		$tomember = $email;
		$headersmember .= "From: $sitename <$adminemail>\n";
		$headersmember .= "Reply-To: <$adminemail>\n";
		$headersmember .= "X-Sender: <$adminemail>\n";
		$headersmember .= "X-Mailer: PHP5\n";
		$headersmember .= "X-Priority: 3\n";
		$headersmember .= "Return-Path: <$adminemail>\n";
		$subjectmember = "Welcome to " . $sitename;
		$messagemember = "Dear ".$firstname." ".$lastname.",\n\nThank you for signing up for our ".$sitename." prelaunch!\nYour account details are below:\n\n"
		   ."User ID: $newid\n"
		   ."Username: ".$userid."\nPassword: ".$password."\n\n"
		   ."Please verify your email address by clicking this link ".$domain."/verify.php?userid=".$userid."&email=".$email."\n\n"
		   ."Your unique affiliate URL is: ".$domain."/index.php?referid=".$userid ."\n\n"
		   ."Your login URL is: ".$domain."/login.php\n\n"
		   ."Thank you!\n\n\n"
		   .$sitename." Admin\n"
		   .$adminemail."\n\n\n\n";
		@mail($tomember, $subjectmember, wordwrap(stripslashes($messagemember)),$headersmember, "-f$adminemail");

		$lastverificationq = "update earlysignups set howmanydayssincelastverificationsent=0 where id=\"$id\"";
		$lastverificationr = mysql_query($lastverificationq);
		?>
		<tr><td align="center" colspan="2">Verification email sent to User ID#<?php echo $id ?> with Username <?php echo $userid ?> at <a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></td></tr>
		<?php
		} # while ($rowz = mysql_fetch_array($r))
		?>
		<tr><td colspan="2" align="center"><br><a href="controlpanel.php?orderedby=<?php echo $orderedbyq ?>">RETURN</a></td></tr>
		</table>
		<br><br>
		<?php
		include "../footer.php";
		exit;
	} # if ($rows > 0)
} # if ($action == "searchandresendvalidation")
######################################################
?>
<br><br>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><b>Admin Control Panel</div></td></tr>
<tr><td align="center" colspan="2"><br>
<?php
include "adminnav.php";
?>
</td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>
<tr><td align="center" colspan="2"><br>
<form action="controlpanel.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" bgcolor="#989898" align="center">
<tr bgcolor="#d3d3d3"><td colspan="2" align="center"><b>BASIC SETTINGS</b></td></tr>
<tr bgcolor="#eeeeee"><td>Admin Login ID:</td><td><input type="text" class="typein" name="adminuseridp" value="<?php echo $adminuserid ?>" class="typein" size="55" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Admin Login Password:</td><td><input type="text" class="typein" name="adminpasswordp" value="<?php echo $adminpassword ?>" class="typein" size="55" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Admin Name:</td><td><input type="text" class="typein" name="adminnamep" value="<?php echo $adminname ?>" class="typein" size="55" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Default Sponsor Username:</td><td><input type="text" class="typein" name="defaultreferidp" value="<?php echo $defaultreferid ?>" class="typein" size="55" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Website Main Domain URL (with http:// and NO trailing slash):</td><td><input type="text" class="typein" name="domainp" value="<?php echo $domain ?>" class="typein" size="55" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Website Name:</td><td><input type="text" class="typein" name="sitenamep" value="<?php echo $sitename ?>" class="typein" size="55" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Admin Support Email:</td><td><input type="text" class="typein" name="adminemailp" value="<?php echo $adminemail ?>" class="typein" size="55" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Members Area Chat-With-Us Link (leave blank to disable):</td><td><input type="text" class="typein" name="chatwithuslinkp" value="<?php echo $chatwithuslink ?>" class="typein" size="55" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Enable Members Area Referral Leader Board Page:</td><td><select name="enablememberleaderboardp"><option value="yes" <?php if ($enablememberleaderboard == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($enablememberleaderboard != "yes") { echo "selected"; } ?>>NO</option></select></td></tr>
<tr bgcolor="#eeeeee"><td>Enable Members Area Contest Page:</td><td><select name="enablemembercontestboardp"><option value="yes" <?php if ($enablemembercontestboard == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($enablemembercontestboard != "yes") { echo "selected"; } ?>>NO</option></select></td></tr>
<tr bgcolor="#eeeeee"><td>Delete Unverified Signups After How Many Days?:</td><td>
<select name="deleteunverifieddaysp">
<?php
for ($i=1;$i<=100;$i++)
{
?>
<option value="<?php echo $i ?>" <?php if ($deleteunverifieddays == $i) { echo "selected"; } ?>><?php echo $i ?></option>
<?php
}
?>
</select>
</td></tr>
<tr bgcolor="#eeeeee"><td>Sponsors May Email Their Downlines How Often?:</td><td>
Every <select name="howoftensponsorscanmailreferralsp">
<?php
for ($j=1;$j<=30;$j++)
{
?>
<option value="<?php echo $j ?>" <?php if ($howoftensponsorscanmailreferrals == $j) { echo "selected"; } ?>><?php echo $j ?></option>
<?php
}
?>
</select> Day(s)
</td></tr>
<tr bgcolor="#eeeeee"><td valign="top">Email Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea cols="50" rows="10" name="disclaimerp"><?php echo $disclaimer ?></textarea></td></tr>
<tr bgcolor="#d3d3d3"><td colspan="2" align="center">
<input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>">
<input type="hidden" name="action" value="savesettings">
<input type="submit" name="submit" value="SAVE" class="sendit"></form>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>
<style type="text/css">
<!--
div.pagination {
	padding: 3px;
	margin: 3px;
}
div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #eeeeee;
	text-decoration: none;
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #808080;
	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #808080;	
	font-weight: bold;
	background-color: #808080;
	color: #FFF;
	}
div.pagination span.disabled {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #EEE;
	color: #DDD;
	}
-->
</style>
<table width="600" border="0" cellpadding="2" cellspacing="2" bgcolor="#989898" align="center">
<tr bgcolor="#d3d3d3"><td colspan="2" align="center"><b>PRELAUNCH MEMBER LIST</b></td></tr>
<?php
$q = "select * from earlysignups order by $orderedbyq";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
?>
<tr bgcolor="#eeeeee"><td colspan="2" align="center">There are no members yet.</td></tr>
<?php
}
if ($rows > 0)
{
################################################################
$pagesize = 200;

	$page = (empty($_GET['p']) || !isset($_GET['p']) || !is_numeric($_GET['p'])) ? 1 : $_GET['p'];
	$s = ($page-1) * $pagesize;
	$queryexclude1 = $q ." LIMIT $s, $pagesize";
	$resultexclude=mysql_query($queryexclude1);
	$numrows = @mysql_num_rows($resultexclude);
	if($numrows == 0){
		$queryexclude1 = $q ." LIMIT $pagesize";
		$resultexclude=mysql_query($queryexclude1);
	}
	$count = 0;
	$pagetext = "<center><br>Total Members: <b>" . $rows . "</b><br>";

	if($rows > $pagesize){ // show the page bar
		$pagecount = ceil($rows/$pagesize);
		$pagetext .= "<div class='pagination'> ";
		if($page>1){ //show previoust link
			$pagetext .= "<a href='?p=".($page-1)."&orderedby=$orderedbyq' title='previous page'>previous</a>";
		}
		for($i=1;$i<=$pagecount;$i++){
			if($page == $i){
				$pagetext .= "<span class='current'>".$i."</span>";
			}else{
				$pagetext .= "<a href='?p=".$i."&orderedby=$orderedbyq'>".$i."</a>";
			}
		}
		if($page<$pagecount){ //show previoust link
			$pagetext .= "<a href='?p=".($page+1)."&orderedby=$orderedbyq' title='next page'>next</a>";
		}			
		$pagetext .= " </div><br>";
	}
################################################################
?>
<tr><td colspan="2" align="center"><table cellpadding="0" cellspacing="1" border="0" align="center" bgcolor="#989898" width="100%">

<form action="controlpanel.php" method="post">
<tr bgcolor="#d3d3d3" style="font-size: 10px;"><td align="center" colspan="15">
<input type="hidden" name="action" value="resendallverificationemails"><input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>"><input type="submit" value="RESEND ALL PENDING VERIFICATION EMAILS">
</form></td></tr>


<form action="controlpanel.php" method="post">
<tr bgcolor="#d3d3d3"><td align="center" colspan="15">Resend Verification Email For:&nbsp;<input type="text" name="searchfor" size="25" maxlength="255">&nbsp;&nbsp;Which Is A:&nbsp;
<select name="searchby">
<option value="id">User ID#</option>
<option value="userid">Username</option>
<option value="firstname">First Name</option>
<option value="lastname">Last Name</option>
<option value="email">Email Address</option>
</select>
&nbsp;&nbsp;
<input type="hidden" name="action" value="searchandresendvalidation"><input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>"><input type="submit" value="RESEND"></form></td></tr>


<form action="controlpanel.php" method="post">
<tr bgcolor="#d3d3d3"><td align="center" colspan="15">Search For:&nbsp;<input type="text" name="searchfor" size="25" maxlength="255">&nbsp;&nbsp;In:&nbsp;
<select name="searchby">
<option value="id">User ID#</option>
<option value="userid">Username</option>
<option value="firstname">First Name</option>
<option value="lastname">Last Name</option>
<option value="email">Email</option>
<option value="verified">Verified</option>
<option value="howmanydayssincelastverificationsent">Days Since Last Verification Email Sent</option>
</select>
&nbsp;&nbsp;
<input type="hidden" name="action" value="search"><input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>"><input type="submit" value="SEARCH"></form></td></tr>

<tr bgcolor="#eeeeee" style="font-size: 10px;"><td align="center" colspan="15"><div style="width: 600px; overflow: auto;"><?php echo $pagetext ?></div></td></tr>

<tr bgcolor="#d3d3d3" style="font-size: 10px;">
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=id">ID</a></td>
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=userid">Username</a></td>
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=password">Password</a></td>
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=firstname">First&nbsp;Name</a></td>
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=lastname">Last&nbsp;Name</a></td>
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=email">Email</a></td>
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=verified">Verified</a></td>
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=howmanydayssincelastverificationsent">Days Since Verification Email Sent</a></td>
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=referid">Sponsor</a></td>
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=signupip">Signup IP</a></td>
<td align="center"><a style="font-size: 10px;" href="controlpanel.php?orderedby=signupdate">Signup Date</a></td>
<td align="center"><font style="font-size: 10px;">SAVE</font></td>
<td align="center"><font style="font-size: 10px;">LOGIN</font></td>
<td align="center"><font style="font-size: 10px;">RESEND VERIFICATION</font></td>
<td align="center"><font style="font-size: 10px;">DELETE</font></td>
</tr>

<?php
	while ($rowz = mysql_fetch_array($resultexclude))
	{
	$id = $rowz["id"];
	$userid = $rowz["userid"];
	$password = $rowz["password"];
	$firstname = $rowz["firstname"];
	$lastname = $rowz["lastname"];
	$email = $rowz["email"];
	$referid = $rowz["referid"];
	$signupdate = $rowz["signupdate"];
	$signupdate = formatDate($signupdate);
	$signupip = $rowz["signupip"];
	$verified = $rowz["verified"];
	$verifieddate = $rowz["verifieddate"];
	$howmanydayssincelastverificationsent = $rowz["howmanydayssincelastverificationsent"];
?>
<form action="controlpanel.php" method="post">
<tr bgcolor="#eeeeee" style="font-size: 10px;">
<td align="center"><?php echo $id ?></td>
<td align="center"><input type="text" name="userid" value="<?php echo $userid ?>" size="8" maxlength="255" class="typein" style="font-size: 10px;"></td>
<td align="center"><input type="text" name="password" value="<?php echo $password ?>" size="8" maxlength="255" class="typein" style="font-size: 10px;"></td>
<td align="center"><input type="text" name="firstname" value="<?php echo $firstname ?>" size="8" maxlength="255" class="typein" style="font-size: 10px;"></td>
<td align="center"><input type="text" name="lastname" value="<?php echo $lastname ?>" size="8" maxlength="255" class="typein" style="font-size: 10px;"></td>
<td align="center"><input type="text" name="email" value="<?php echo $email ?>" size="8" maxlength="255" class="typein" style="font-size: 10px;"></td>
<td align="center"><?php echo $verified ?></td>
<td align="center">
<?php
	if ($verified == "yes")
	{
	echo "N/A";
	}
	if ($verified != "yes")
	{
	echo $howmanydayssincelastverificationsent;
	}
?>
</td>

<td align="center">
<select name="referid" class="pickone" style="font-size: 10px;">
<?php
$refq = "select * from earlysignups order by userid";
$refr = mysql_query($refq);
$refrows = mysql_num_rows($refr);
if ($refrows < 1)
		{
		echo "<option value=\"admin\">admin</option>";
		}
if ($refrows > 0)
		{
		?>
		<option value="admin" <?php if ($referid == "admin") { echo "selected"; } ?>>admin</option>
		<?php
			while ($refrowz = mysql_fetch_array($refr))
			{
			$ref = $refrowz["userid"];
			?>
			<option value="<?php echo $ref ?>" <?php if ($ref == $referid) { echo "selected"; } ?>><?php echo $ref ?></option>
			<?php
			}
		}
?>
</select>
</td>

<td align="center"><?php echo $signupip ?></td>
<td align="center"><?php echo $signupdate ?></td>

<td align="center">
<input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>">
<input type="hidden" name="saveid" value="<?php echo $id ?>">
<input type="hidden" name="action" value="save">
<input type="submit" value="SAVE" style="font-size: 10px;">
</form>
</td>

<form action="<?php echo $domain ?>/members.php" method="post" target="_blank">
<td align="center">
<input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>">
<input type="hidden" name="loginusername" value="<?php echo $userid ?>">
<input type="hidden" name="loginpassword" value="<?php echo $password ?>">
<input type="submit" value="LOGIN" style="font-size: 10px;">
</form>
</td>

<form action="controlpanel.php" method="post">
<td align="center">
<input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>">
<input type="hidden" name="resenduserid" value="<?php echo $userid ?>">
<input type="hidden" name="resendpassword" value="<?php echo $password ?>">
<input type="hidden" name="resendfirstname" value="<?php echo $firstname ?>">
<input type="hidden" name="resendlastname" value="<?php echo $lastname ?>">
<input type="hidden" name="resendemail" value="<?php echo $email ?>">
<input type="hidden" name="resendid" value="<?php echo $id ?>">
<input type="hidden" name="action" value="resendvalidationemail">
<input type="submit" value="RESEND" style="font-size: 10px;">
</form>
</td>

<form action="controlpanel.php" method="post">
<td align="center">
<input type="hidden" name="orderedby" value="<?php echo $orderedbyq ?>">
<input type="hidden" name="deleteuserid" value="<?php echo $userid ?>">
<input type="hidden" name="deleteid" value="<?php echo $id ?>">
<input type="hidden" name="action" value="delete">
<input type="submit" value="DELETE" style="font-size: 10px;">
</form>
</td>

</tr>
<?php
	} # while ($rowz = mysql_fetch_array($r))
?>

</table></td></tr>
<?php
} # if ($rows > 0)
?>
</table>
</td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
?>