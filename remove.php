<?php
include "db.php";
include "header.php";
$r = $_REQUEST["r"];
$action = $_POST["action"];
$q1 = "select * from earlysignups where email=\"$r\"";
$r1 = mysql_query($q1);
$rows1 = mysql_num_rows($r1);
if ($rows1 < 1)
{
?>
<!-- CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">ERROR</div></td></tr>
<tr><td colspan="2"><br>The email address you entered, <?php echo $r ?> was not found. Please <a href="mailto:<?php echo $adminemail ?>">Contact Us</a> for assistance if you are having difficulty opting out. If you also forward us a copy of the mail you received this helps us to find your address to delete it if you are getting this error but are sure you're still receiving mail from us.
</td></tr>
<tr><td align="center" colspan="2">
<form action="remove.php" method="post">
Remove Email:&nbsp;<input type="text" name="r" maxlength="255" size="25" value="<?php echo $r ?>" class="typein">&nbsp;<input type="submit" value="Remove Email" class="sendit">
</form>
</td></tr>
</table>
<!-- END CONTENT //-->
<?php
include "footer.php";
exit;
}
if ($rows1 > 0)
{
if ($action == "confirm")
	{
		while ($rowz1 = mysql_fetch_array($r1))
		{
		$id = $rowz1["id"];
		$deleteuserid = $rowz1["userid"];


		$q2 = "delete from earlysignups where email=\"$r\" or id=\"$id\"";
		$r2 = mysql_query($q2);

		$q3 = "update earlysignups set referid=\"$defaultreferid\" where referid=\"$deleteuserid\"";
		$r3 = mysql_query($q3);
		}
		?>
		<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
		<tr><td align="center" colspan="2"><br><div class="heading">YOUR ADDRESS WAS REMOVED COMPLETELY FROM OUR SYSTEM</div></td></tr>
		</table>
		<!-- END CONTENT //-->
		<?php
		include "footer.php";
		exit;
	} # if ($action == "confirm")
else
	{
?>
<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">Are you sure you want to be removed?</div></td></tr>
<tr><td align="center" colspan="2"><br>This action is irreversible, and you will lose any earnings and referrals you have made!</td></tr>
</td></tr>
<tr><td align="center" colspan="2">
<form action="remove.php" method="post">
<input type="hidden" name="r" maxlength="255" size="25" value="<?php echo $r ?>" class="typein"><input type="hidden" name="action" value="confirm"><input type="submit" value="REMOVE ME" class="sendit">
</form>
</td></tr>
</table>
<?php
include "footer.php";
exit;
	} # else
} # if ($rows1 > 0)
?>