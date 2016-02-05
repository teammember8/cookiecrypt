<?php

$infos = getUserInfos($_COOKIE['auth_cookiecrypt']);

printf('Welcome <em>%s %s</em>, you are logged as <strong>%s</strong> (%dh %s long)
		<a href="logout.php">logout</a></span><br/><br/>',
	   htmlentities($infos['name'], ENT_QUOTES),
	   htmlentities($infos['firstname'], ENT_QUOTES),
	   htmlentities($infos['login'], ENT_QUOTES),
	   (time() - (int) $infos['connect_time']) / (60 * 60),
	   date('i\m s\s', time() - (int) $infos['connect_time']));

if ((int) $infos['uid'] == 1)
	print 'Well done, password is <strong>'.CHALLENGE_PASSWORD.'</strong>';

?>
