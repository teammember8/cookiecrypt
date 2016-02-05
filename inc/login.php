<?php

if (!empty($_POST['login']) && is_string($_POST['login']) &&
	!empty($_POST['password']) && is_string($_POST['password']))  # Authentication failed
		echo '<div style="color : #ff000c;"><strong>/!\ #fail, wrong login/password</strong><br /><br /></div>';
?>

Please login using the form below.<br /><br />

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
		<td colspan="2" style="text-align: center"><input type="submit" value="Connect" /></td>
	</tr>
</table>
</form>

<a href="?page=register">Register</a>
