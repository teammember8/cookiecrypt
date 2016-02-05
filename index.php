<?php

# Configuration

define('BDD_HOST',     'localhost');
define('BDD_USERNAME', 'cookiecrypt_user');
define('BDD_PASSWORD', 'oyFlpmNkbswYkuQAc8b9vZ82kLeU9X6gUerRWGgD6Y_');
define('BDD_DATABASE', 'db_cookiecrypt');

define('SITE_ADDR',    'localhost'); # Edit in logout.php too
define('CHALL_ADDR',   'http://localhost/index.php');

# Indeed not the same online
define('CHALLENGE_PASSWORD', 'FIXME');

# Choose it completly random and very long, keep it secret
define('ENCRYPTION_KEY', 'FIXME');

$whitelist = array('register', 'login');

mysql_connect(BDD_HOST, BDD_USERNAME, BDD_PASSWORD);
mysql_select_db(BDD_DATABASE);

require_once dirname(__FILE__).'/inc/functions.php';

# Connect user if necessary

if (empty($_COOKIE['auth_cookiecrypt']))
	check_login();

# Main

require_once dirname(__FILE__).'/inc/header.php';

if (!empty($_COOKIE['auth_cookiecrypt']) && is_string($_COOKIE['auth_cookiecrypt']))
	require_once dirname(__FILE__).'/inc/member.php';
elseif (!empty($_GET['page']) && is_string($_GET['page']) && in_array($_GET['page'], $whitelist))
	require_once dirname(__FILE__).'/inc/'.$_GET['page'].'.php';
else
	require_once dirname(__FILE__).'/inc/login.php';

require_once dirname(__FILE__).'/inc/footer.php';

?>
