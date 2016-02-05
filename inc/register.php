<?php

$keys = array('login', 'password', 'password2', 'name', 'firstname');

$submitted = TRUE;

foreach($keys as $key)
{
	if (empty($_POST[$key]) || !is_string($key))
	{
		$submitted = FALSE;
		break;
	}
}

if ($submitted)
{
	if ($_POST['password'] != $_POST['password2'])
		echo '<div style="color : #ff000c;"><strong>[ERROR] Passwords are not the same</strong><br/><br/></div>';
	elseif (!ctype_alnum($_POST['login']))
		echo '<div style="color : #ff000c;"><strong>[ERROR] Login *must* be alphanumerical only</strong><br /><br /></div>';
	elseif (!ctype_alnum($_POST['name']))
		echo '<div style="color : #ff000c;"><strong>[ERROR] Name *must* be alphanumerical only</strong><br /><br /></div>';
	elseif (!ctype_alnum($_POST['firstname']))
		echo '<div style="color : #ff000c;"><strong>[ERROR] Firstname *must* be alphanumerical only</strong><br /><br /></div>';
	else
	{
		$login     = mysql_real_escape_string($_POST['login']);
		$password  = hash('sha256', $_POST['password']);
		$name      = mysql_real_escape_string($_POST['name']);
		$firstname = mysql_real_escape_string($_POST['firstname']);

		mysql_query("INSERT INTO users (name, firstname, login, password)
					 VALUES ('$name', '$firstname', '$login', '$password')") or die(mysql_error());

		if (mysql_affected_rows() == 1) # Registration successful
		{
			print "Registration successful, redirecting to index in 5seconds...";
			print "<script>window.setTimeout(\"location=('".CHALL_ADDR."');\",5000);</script>";
		}
		else 							# Registration failed
			echo '<div style="color : #ff000c;"><strong>/!\ #fail, registration failed, login already present</strong><br /><br /></div>';
	}
}

?>

Please register using the form below.<br /><br />

<form method="POST" action="">
<table style="margin-left : auto; margin-right : auto;">
	<tr>
		<td><label for="login">Login:</label></td>
		<td><input type="text" name="login" /></td>
	</tr>
	<tr>
		<td><label for="password">Password:</label></td>
		<td><input type="password" name="password" /></td>
	</tr>
	<tr>
		<td><label for="password2">Password confirmation:</label></td>
		<td><input type="password" name="password2" /></td>
	</tr>
	<tr>
		<td><label for="name">Name:</label></td>
		<td><input type="text" name="name" /></td>
	</tr>
	<tr>
		<td><label for="firstname">Firstname:</label></td>
		<td><input type="text" name="firstname" /></td>
	</tr>
		<td colspan="2" style="text-align: center"><input type="submit" value="Register" /></td>
	</tr>
</form>
