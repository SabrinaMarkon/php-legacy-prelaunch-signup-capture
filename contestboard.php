<?php
include "control.php";
include "header.php";
if ($enablemembercontestboard != "yes")
{
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2">The Contest Leader Board is currently disabled.</td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
}
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading"><?php echo $sitename ?> Contest Leader Board</div></td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Contest Leader Board'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;

$contestboarddisplay = "";
$tsq = "select referid, count(referid) as cnt from contest where referid!='' group by referid order by cnt desc";
$tsr = mysql_query($tsq) or die(mysql_error());
$tsrows = mysql_num_rows($tsr);
if ($tsrows > 0)
{
$bg = 0;
while ($tsrowz = mysql_fetch_array($tsr))
{
if ($bg == 0)
	{
	$bgcolor = "#eeeeee";
	}
if ($bg != 0)
	{
	$bgcolor = "#d3d3d3";
	}
$cnt = $tsrowz["cnt"];
$referid = $tsrowz["referid"];
$contestboarddisplay = $contestboarddisplay . "<tr bgcolor=\"$bgcolor\"><td align=\"center\">$referid</td><td align=\"center\">$cnt</td></tr>";
if ($bgcolor == "#eeeeee")
	{
	$bg = 1;
	}
if ($bgcolor != "#d3d3d3")
	{
	$bg = 0;
	}
}
}
if ($tsrows < 1)
{
$contestboarddisplay = $contestboarddisplay . "<tr bgcolor=\"#eeeeee\"><td align=\"center\" colspan=\"2\">There are no members yet.</td></tr>";
} # if ($tsrows < 1)
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
<table cellpadding="2" cellspacing="2" border="0" align="center" bgcolor="#989898">
<?php
echo $contestboarddisplay;
?>
</table>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>