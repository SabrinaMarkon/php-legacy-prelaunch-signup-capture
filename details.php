<?php
include "db.php";
include "header.php";
$referid = $_REQUEST["referid"];
if ($referid == "")
{
$referid = $defaultreferid;
}
?>
<br><br>
<table cellpadding="0" cellspacing="0" border="0" align="center" width="90%">
<tr><td align="center" colspan="2"><div class="heading">Program Details</div></td></tr>
<tr><td colspan="2"><br>
<div style="text-align: center;">
<?php
$query1 = "select * from pages where name='Program Details'";
$result1 = mysql_query($query1);
$line1 = mysql_fetch_array($result1);
$htmlcode = $line1["htmlcode"];
echo $htmlcode;
?>
</div> 
</td></tr>
</table>
<center><a href="index.php?referid=<?php echo $referid ?>">MAIN PAGE</a></center>
<br>
<?php
include "footer.php";
exit;
?>
