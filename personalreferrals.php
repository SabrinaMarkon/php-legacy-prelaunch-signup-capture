<?php
include "control.php";
include "header.php";
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading">Your Personal Referrals</div></td></tr>

<tr><td><br>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Personal Referrals'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>

<tr><td align="center">
<?php
include "membernav.php";
?>
</td></tr>

<?php
$refq = "select * from earlysignups where referid=\"$userid\"";
$refr = mysql_query($refq);
$refrows = mysql_num_rows($refr);
if ($refrows > 0)
	{
	?>
	<tr><td align="center"><br>
	<table cellpadding="2" cellspacing="2" border="0" align="center" width="200" bgcolor="#989898">
	<?php
	while ($refrowz = mysql_fetch_array($refr))
	{
		$referral = $refrowz["userid"];
		?>
		<tr bgcolor="#eeeeee"><td align="center"><?php echo $referral ?></td></tr>
		<?php
	}
	?>
	</table>
	</td></tr>
	<?php
	} # if ($refrows > 0)
if ($refrows < 1)
	{
	?>
	<tr><td align="center"><br>
	<table cellpadding="2" cellspacing="2" border="0" align="center" width="300" bgcolor="#989898">
	<tr bgcolor="#eeeeee"><td align="center">You don't have any personal referrals yet.</td></tr>
	</table>
	</td></tr>
	<?php
	}
?>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>