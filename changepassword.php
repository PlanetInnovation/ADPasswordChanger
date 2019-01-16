<html>
<HEAD>
<TITLE>Change your AD password</TITLE>
</HEAD>
<body>

<h1>AD Password changer</h1>

<font face=Arial size=-1>
<form action="changepassword.php" method="post">
<table width=440 border=0 bgcolor=#D8D8D8>
<tr bgcolor=gray><td colspan=2><center><font face=Arial size=-1><b>Password details</b></center></td></tr>
<tr><td align=right><font face=Arial size=-1>&nbsp;AD username:</td><td><input type="text" name="adusername"></td></tr>
<tr><td align=right><font face=Arial size=-1>Current password:</td><td><input type="password" name="oldpassword"></td></tr>
<tr><td align=right><font face=Arial size=-1>New password:</td><td><input type="password" name="newpassword1"></td></tr>
<tr><td align=right><font face=Arial size=-1>&nbsp;Retype new password:</td><td><input type="password" name="newpassword2"></td></tr>
<tr><td colspan=2 align=center><font face=Arial size=-1><input type="submit" value="Change password"></form></td></tr>
</table>

<BR>



<?php

$adusername = $_POST['adusername'];
$oldpassword = $_POST['oldpassword'];
$newpassword1 = $_POST['newpassword1'];
$newpassword2 = $_POST['newpassword2'];

# check that passwords match
if ($newpassword1 != $newpassword2) {
	echo "ERROR: PASSWORDS DO NOT MATCH";
	exit;
}


# perform input validation

# for username
# note that we only allow a single hyphen
if (!preg_match("/^[a-zA-Z0-9]{1,20}-?[a-zA-Z0-9]{2,20}/",$adusername)) {
	echo "ERROR: Username is not valid";
	exit;
}

# for old password
if (!preg_match("/[a-zA-Z0-9_@#!]{12,40}/",$oldpassword)) {
        echo "ERROR: Your old password has invalid characters. Please contact IT for help changing your password.";
        exit;
}

# for new password
if (!preg_match("/[a-zA-Z0-9_@#!]{12,40}/",$newpassword1)) {
        echo "ERROR: New password has invalid characters, or is not long enough. Please use only UPPERCASE/lowercase letters, numbers, or the following special characters _ @ # !";
        exit;
}



# pass credentials to password change script
# note that we re-use password1 rather than specifying password2 seperatley here
# since we've already checked they match and we only perform input validation on password1	
$pwcommandoutput = exec("/var/www/html/changepassword.sh $adusername $oldpassword $newpassword1 $newpassword1");


# setup strings for feedback
if (strpos($pwcommandoutput,'Password changed for user') !== false) {
    $finalborder = "#7ACC7A";
    $finalbg = "#CCFFCC";
    $finaltext = "green";
} else {
    $pwcommandoutput = "ERROR: Password not changed";
    $finalborder = "#E60000";
    $finalbg = "#FF9494";
    $finaltext = "red";
}



?>

<table bgcolor=<?php echo $finalbg ?> width=440 style="border: 2pt solid <?php echo $finalborder ?>; border-Collapse: collapse">
<tr height=43><td cellspacing=0 cellpadding=0 align=center><font color=<?php echo $finaltext ?>><?php echo $pwcommandoutput ?></font></td></tr>
</table>






</body>
</html> 
