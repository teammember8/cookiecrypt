<?php

function encrypt_cookie($data)
{
	return mcrypt_encrypt(MCRYPT_RIJNDAEL_256,
						  md5(ENCRYPTION_KEY),
						  $data,
						  "ecb");
}

function decrypt_cookie($data)
{
	return mcrypt_decrypt(MCRYPT_RIJNDAEL_256,
						  md5(ENCRYPTION_KEY),
						  $data,
						  "ecb");
}

function check_login()
{
	if (!empty($_POST['login']) && is_string($_POST['login']) &&
		!empty($_POST['password']) && is_string($_POST['password']))
	{
		$login    = mysql_real_escape_string($_POST['login']);
		$password = hash('sha256', $_POST['password']);

		$sql = mysql_query("SELECT name, firstname, uid, login FROM users WHERE login='$login' AND password='$password'") or die(mysql_error());
		
		if (mysql_num_rows($sql) == 1) # Authentication successful
		{
			$res = mysql_fetch_array($sql);

			$data = sprintf("name=%s,firstname=%s,uid=%s,login=%s,connect_time=%d",
							$res['name'],
							$res['firstname'],
							$res['uid'],
							$res['login'],
							time());

			$crypted = base64_encode(encrypt_cookie($data));

			setcookie('auth_cookiecrypt', $crypted, time() + 60 * 60 * 24 * 30, '/', SITE_ADDR, FALSE, TRUE);
			die("Authentication successful, redirecting to index... <script>window.setTimeout(\"location=('".CHALL_ADDR."');\",5000);</script>");
		}
	}
}

function getUserInfos($cookie)
{
	$data = decrypt_cookie(base64_decode($cookie));
	$array = explode(',', $data);

	$infos = array();

	# Ex: $value: "name=Doe,firstname=John,uid=42,login=jdoe,connect_time=1331854292"
	# => $infos = array(
	# 		'name' => 'Doe',
	# 		'firstname' => 'John',
	# 		'uid' => '42',
	# 		'login' => 'jdoe',
	# 		'connect_time' => '1331854292"
	#    );

	foreach ($array as $value)
	{
		$tab = explode('=', $value);
		$infos[$tab[0]] = $tab[1];
	}

	foreach (array('name', 'firstname', 'uid', 'login', 'connect_time') as $key)
		if (!array_key_exists($key, $infos))
			die("Cookie Decryption failed");

	return $infos;
}

?>
