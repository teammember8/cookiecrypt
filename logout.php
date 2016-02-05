<?php

setcookie('auth_cookiecrypt', '', time() - 3600, '/', 'localhost', FALSE, TRUE);
header('location: index.php');
die('logout done');

?>
