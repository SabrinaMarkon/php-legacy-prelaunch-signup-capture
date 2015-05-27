<?php
include "../db.php";
$q1 = "update earlysignups set howmanydayssincelastverificationsent=0 where verified=\"yes\"";
$r1 = mysql_query($q1);
$q2 = "update earlysignups set howmanydayssincelastverificationsent=howmanydayssincelastverificationsent+1 where verified!=\"yes\"";
$r2 = mysql_query($q2);
$q3 = "select * from earlysignups where howmanydayssincelastverificationsent>=$deleteunverifieddays and verified!=\"yes\" order by id";
$r3 = mysql_query($q3);
$rows3 = mysql_num_rows($r3);
if ($rows3 > 0)
{
	while ($rowz3 = mysql_fetch_array($r3))
	{
		$id = $rowz3["id"];
		$userid = $rowz3["userid"];
		$q4 = "delete from earlysignups where id=\"$id\"";
		$r4 = mysql_query($q4);
		echo $id . " - " . $userid . "<br>";
	} # while ($rowz3 = mysql_fetch_array($r3))
} # if ($rows3 > 0)
exit;
?>