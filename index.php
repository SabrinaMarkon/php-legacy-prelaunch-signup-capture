<?php
session_start();
include "db.php";
$action = $_POST["action"];
if ($action == "join")
{
$userid = $_POST["userid"];
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$referid = $_POST["referid"];

	if (!$userid)
	{
	$error .= "<div>Please return and enter a username.</div>";
	}
	if(!$password)
	{
	$error .= "<div>Please return and enter a password.</div>";
	}
	if(!$firstname)
	{
	$error .= "<div>Please return and enter your first name.</div>";
	}
	if(!$lastname)
	{
	$error .= "<div>Please return and enter your last name.</div>";
	}
	if(!$email)
	{
	$error .= "<div>Please return and enter your email address.</div>";
	}
	$dupq = "select * from earlysignups where userid=\"$userid\" or email=\"$email\"";
	$dupr = mysql_query($dupq);
	$duprows = mysql_num_rows($dupr);
	if ($duprows > 0)
	{
	$error .= "<div>The username or email address you chose is already registered.</div>";
	}

$new_email_array= explode ("@", $email);
$new_email_domain = $new_email_array[1];
if ($emailsignupmethod == "denyallexcept")
{
$q2 = "select * from emailsignupcontrol where emaildomain='$email' or emaildomain='$new_email_domain'";
$r2 = mysql_query($q2);
$rows2 = mysql_num_rows($r2);
if ($rows2 < 1)
	{
	$q3 = "select * from emailsignupcontrol order by id";
	$r3 = mysql_query($q3);
	$rows3 = mysql_num_rows($r3);
	if ($rows3 > 0)
		{
		$allalloweddomains = "<ul style=\"text-align: left;\">";
		while ($rowz3 = mysql_fetch_array($r3))
			{
			$alloweddomain = $rowz3["emaildomain"];
			$allalloweddomains = $allalloweddomains . "<li>" . $alloweddomain . "</li>";
			}
		$allalloweddomains = $allalloweddomains . "</ul>";
		$error .="<br><div>Email address is not in the list of allowed domains:<br>".$allalloweddomains."</div>";
		} # if ($rows3 > 0)
	} # if ($rows2 < 1)
} # if ($emailsignupmethod == "denyallexcept")
if ($emailsignupmethod != "denyallexcept")
{
$q2 = "select * from emailsignupcontrol where emaildomain='$email' or emaildomain='$new_email_domain'";
$r2 = mysql_query($q2);
$rows2 = mysql_num_rows($r2);
if ($rows2 > 0)
	{
	$error .="<div>Email address is in the list of banned domains. Please signup using a different one.</div>";
	} # if ($rows2 < 1)
} # if ($emailsignupmethod != "denyallexcept")

include_once "./securimage/securimage.php";
$securimage = new Securimage();
if ($securimage->check($_POST['captcha_code']) == false) {
$error .= "<div>Captcha code was incorrect.</div>";
}

	if(!$error == "")
	{
	include "header.php";
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><b>Signup Error</b></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="javascript: history.back()">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}
$signupip = $_SERVER['REMOTE_ADDR'];
$q = "insert into earlysignups (userid,password,firstname,lastname,email,referid,signupip,signupdate) values (\"$userid\",\"$password\",\"$firstname\",\"$lastname\",\"$email\",\"$referid\",\"$signupip\",NOW())";
$r = mysql_query($q) or die(mysql_error());
$q2 = "select * from earlysignups where userid=\"$userid\"";
$r2 = mysql_query($q2);
$rows2 = mysql_num_rows($r2);
if ($rows2 > 0)
	{
	$newid = mysql_result($r2,0,"id");
	}

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

					$toadmin = $adminemail;
					$headersadmin .= "From: $sitename <$adminemail>\n";
					$headersadmin .= "Reply-To: <$adminemail>\n";
					$headersadmin .= "X-Sender: <$adminemail>\n";
					$headersadmin .= "X-Mailer: PHP5\n";
					$headersadmin .= "X-Priority: 3\n";
					$headersadmin .= "Return-Path: <$adminemail>\n";
					$subjectadmin = "New Prelaunch Member In " . $sitename;
					$messageadmin = "This is a notification that a new prelaunch member has joined $sitename:\n\n
					User ID: $newid\n
					Username: $userid\n
					Name: $firstname $lastname\n
					Sponsor: $referid\n
					Email: $email\n
					IP: $signupip\n\n
					$sitename\n
					$domain
					";
					@mail($toadmin, $subjectadmin, wordwrap(stripslashes($messageadmin)),$headersadmin, "-f$adminemail");

include "header.php";
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><b>Signup Successful!</b></td></tr>
<tr><td colspan="2" align="center"><br><a href="login.php?referid=<?php echo $referid ?>">Login</a> with Username <?php echo $userid ?> and Password <?php echo $password ?><?php echo $signupip ?></td></tr>
<tr><td colspan="2" align="center"><br><a href="index.php?referid=<?php echo $referid ?>">MAIN</a></td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
} # if ($action == "join")
$referid = $_REQUEST["referid"];
if ($referid == "")
{
$referid = $defaultreferid;
}
include "header.php";
?>
<table cellpadding="0" cellspacing="0" border="0" align="center" width="90%">
<tr><td colspan="2"><br>
<div style="text-align: center;">
<?php
$query1 = "select * from pages where name='Prelaunch Signup Home Page'";
$result1 = mysql_query($query1);
$line1 = mysql_fetch_array($result1);
$htmlcode = $line1["htmlcode"];
echo $htmlcode;
?>
</div> 
</td></tr>

<tr><td align="center" colspan="2">
<?php
$membercountq = "select * from earlysignups";
$membercountr = mysql_query($membercountq);
$membercountrows = mysql_num_rows($membercountr);
echo "<b>" . $membercountrows . " Registered Members</b>";
?>
</td></tr>


<tr><td align="center" colspan="2"><br><br><div class="heading">Signup</div></td></tr>
<tr><td align="center" colspan="2"><br>

<table cellpadding="2" cellspacing="2" border="0" align="center" bgcolor="#989898">
<form action="index.php" method="post">
<tr bgcolor="#eeeeee"><td>Username</td><td><input type="text" name="userid" size="25" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Password:</td><td><input type="text" name="password" size="25" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>First Name:</td><td><input type="text" name="firstname" size="25" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Last Name:</td><td><input type="text" name="lastname" size="25" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Email:</td><td><input type="text" name="email" size="25" maxlength="255"></td></tr>
<tr bgcolor="#eeeeee"><td>Your Sponsor:</td><td><?php echo $referid ?></td></tr>
<tr bgcolor="#eeeeee"><td colspan="2" align="center">
<div style="width:200px;">
<img id="siimage" align="left" style="padding-right: 0px; margin-right: 0px;" src="securimage/securimage_show.php?sid=441bf97042694d0f2bfc5b9697d3e5b1" />
<a tabindex="-1" style="border-style: none" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = 'securimage/securimage_show.php?sid=' + Math.random(); return false"><img src="securimage/images/refresh.gif" alt="Reload Image" border="0" onclick="this.blur()"></a>
</div></td></tr>
<tr bgcolor="#eeeeee"><td colspan="2" align="center">
Verify Code:&nbsp;<input type="text" name="captcha_code" size="4" maxlength="4">
</td></tr>
<tr bgcolor="#eeeeee"><td colspan="2" align="center">By submitting the form, you agree to our <a href="terms.php?referid=<?php echo $referid ?>" target="_blank">Terms and Conditions</a></td></tr>
<tr bgcolor="#d3d3d3"><td colspan="2" align="center"><input type="hidden" name="referid" value="<?php echo $referid ?>">
<input type="hidden" name="action" value="join">
<input type="submit" value="JOIN">
</form></td></tr>
</table>

<br><br>
<center><a href="login.php?referid=<?php echo $referid ?>">Member Login</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="mailto:<?php echo $adminemail ?>">Support</a></center>



<br><br>
<!-- DELETE BELOW -->
<script type="text/javascript">
function ajaxFunction(){
    var ajaxRequest;  // The variable that makes Ajax possible!
   
    try{
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e){
        // Internet Explorer Browsers
        try{
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try{
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e){
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var ajaxDisplay = document.getElementById('ajaxDiv');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
        }
    }
    var order_domain_name = document.getElementById('order_domain_name').value;
    var order_domain_extension = document.getElementById('order_domain_extension').value;
   
    var queryString = "?order_domain_name=" + order_domain_name + "&order_domain_extension=" + order_domain_extension;
    ajaxRequest.open("GET", "script_domain_checker.php" + queryString, true);
    ajaxRequest.send(null);
}
</script>
<br>
<a href="http://demoprelaunch.phpsitescripts.com/admin" target="_blank"><img src="http://phpsitescripts.com/images/demo.png" border="0"></a>
<br><br><br>
Please check out our interactive DEMO of the Prelaunch Member Capture Site Script v2.3 as an admin <a href="http://demoprelaunch.phpsitescripts.com/admin" target="_blank">HERE</a> (admin login details are already in the login form for you). <br><br>Examine our DEMO site as a member <a href="http://demoprelaunch.phpsitescripts.com/login.php" target="_blank">HERE</a> (demo member details are already in the login form)</b><br><br>
<div style="text-align:left;padding-left:100px;">SCRIPT REQUIREMENTS:<br>
<ul>
<li>Unix/Linux (CentOS most CPanel servers run is good)</li>
<li>PHP 5.2 or Greater Version</li>
<li>MySQL Database Support</li>
<li>Ioncube Loader</li>
<li>GD Library</li>
<li>cURL</li>
</ul>
</div>
<br><br>
<table cellpadding="10" cellspacing="2" border="0" align="center" width="600" style="border:2px dashed #f00;background:#fff;">
<tr><td colspan="2" align="center"><br><font size="6" color="ff0000">Buy This Prelaunch Member Capture Site Script v2.3 Now For Only $79.00!</font></td</tr>
<form action="http://phpsitescripts.com/sales_order.php" method="post">
<tr><td align="right">Licence:</td><td>Single Site License for Prelaunch Member Capture Site Script v2.3</td></tr>
<tr><td align="right">URL of Premade Site you want to adopt:<br>(or leave blank)</td><td valign="top"><input type="text" name="order_premadesiteurl" size="50" maxlength="500"></td></tr>
<tr><td align="right">Register Domain for your site's License URL:<br>(or leave blank)</td><td style="width:350px;" valign="top"><input type="text" name="order_domain_name" id="order_domain_name" size="25" maxlength="500" style="font-size:12px;">
<select name="order_domain_extension" id="order_domain_extension" onchange="javascript:document.getElementById('ajaxDiv').innerHTML=''" style="font-size:12px;">
<option value="info">.info - FREE FOREVER!</option>
<option value="com">.com - 8.00/year</option>
<option value="us">.us - 8.00/year</option>
<option value="net">.net - 8.00/year</option>
<option value="biz">.biz - 8.00/year</option>
<option value="org">.org - 8.00/year</option>
<option value="me">.me - 8.00/year</option>
<option value="ws">.ws - 8.00/year</option>
<option value="co">.co - 8.00/year</option>
<option value="ca">.ca - 8.00/year</option>
</select>
<input type="button" value="Check Availability (may take a moment)" onclick="ajaxFunction()" style="font-size:12px;"><br><span id="ajaxDiv"></span>
<span id="domain_price"></span>
</td></tr>
<tr><td align="right">License Key URL:<br>(exact url where you will install the script. If registering a new domain, this should match the url in that field)</td><td valign="top"><input type="text" name="order_licenseurl" size="50" maxlength="500"></td></tr>

<tr><td align="right">Order Hosting for your Script:<br>(kindly allow time for setup after purchase)</td><td valign="top">
<select name="order_hosting" style="font-size:12px;width:322px;">
<option value="No Hosting Needed (zipped script or premade site only)">No Hosting Needed (zipped script or premade site only)</option>
<option value="Shared Hosting for ONE domain - adds 9.99/month to order">Shared Hosting for ONE domain - adds 9.99/month to order</option>
<option value="Dedicated VPS Hosting 4 GB RAM - adds 99.99/month to order">Dedicated VPS Hosting 4 GB RAM - adds 99.99/month to order</option>
</select>
</td></tr>

<tr><td align="right">UserID:</td><td><input type="text" name="userid" size="50" maxlength="255"></td></tr>
<tr><td align="right">Password:</td><td><input type="text" name="password" size="50" maxlength="255"></td></tr>
<tr><td align="right">First Name:</td><td><input type="text" name="firstname" size="50" maxlength="255"></td></tr>
<tr><td align="right">Last Name:</td><td><input type="text" name="lastname" size="50" maxlength="255"></td></tr>
<tr><td align="right">Email:</td><td><input type="text" name="email" size="50" maxlength="255"></td></tr>
<?php
$cq = "select * from countries order by country_id";
$cr = mysql_query($cq);
$crows = mysql_num_rows($cr);
if ($crows > 0)
{
?>
<tr><td align="right">Country:</td><td><select name="country" style="width:322px;" class="pickone">
<?php
	while ($crowz = mysql_fetch_array($cr))
	{
	$country_name = $crowz["country_name"];
?>
<option value="<?php echo $country_name ?>" <?php if ($country_name == "United States") { echo "selected"; } ?>><?php echo $country_name ?></option>
<?php
	}
?>
</select>
</td></tr>
<?php
}
?>
<tr><td align="right">Your Sponsor:</td><td><?php echo $referid ?></td></tr>
<tr><td colspan="2" align="center">
<input type="hidden" name="order_script" value="prelaunch_capture_site_v2.3">
<input type="hidden" name="referid" value="<?php echo $referid ?>">
<input type="image" src="http://phpsitescripts.com/images/btn.png" border="0" name="submit" alt="Order!">
</form><br>&nbsp;
</td></tr>
</table>

<br>
<font color="#ff0000" style="background:#ff0;">IMPORTANT:</font> After payment please allow us up to 24 hours to process your order. Please whitelist sabrina@phpsitescripts.com.
<!-- DELETE ABOVE -->




</td></tr>
</table>
<?php
include "footer.php";
exit;
?>
