<?php
$DBhost = "localhost";
$DBuser = "phpsites_demopre";
$DBpass = "Em5Sq~_ax#nVmcI)Xz";
$DBName = "phpsites_demoprelaunch";
$connection = mysql_connect($DBhost, $DBuser, $DBpass) or die("Unable to connect to server");
@mysql_select_db($DBName) or die(mysql_error());
$settings = mysql_query("select * from adminsettings");
$settingrecord = mysql_fetch_array($settings);
while ($settingrecord = mysql_fetch_array($settings)) 
{
$setting[$settingrecord["name"]] = $settingrecord["setting"];
}
extract($setting);
extract($_REQUEST);
?>