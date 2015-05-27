<a href="members.php">Main</a>
&nbsp;&nbsp;|&nbsp;&nbsp;<a href="promote.php">Promotional Ad Copy</a>
<?php
if ($enablememberleaderboard == "yes")
{
?>
&nbsp;&nbsp;|&nbsp;&nbsp;<a href="leaderboard.php">Referral Leaders</a>
<?php
}
if ($enablemembercontestboard == "yes")
{
?>
&nbsp;&nbsp;|&nbsp;&nbsp;<a href="contestboard.php">Referral Contest</a>
<?php
}
?>
&nbsp;&nbsp;|&nbsp;&nbsp;<a href="personalreferrals.php">Your Personal Referrals</a>
&nbsp;&nbsp;|&nbsp;&nbsp;<a href="maildownline.php">Email Your Downline</a>
<?php
if ($chatwithuslink != "")
{
?>
&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $chatwithuslink ?>">Chat With Us!</a>
<?php
}
?>
&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $domain ?>">Logout</a>
