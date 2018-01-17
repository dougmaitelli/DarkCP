<?php
	$hostname_database = 'localhost';
	$database_database = 'dark';
	$username_database = 'root';
	$password_database = '';
	$prefix_database = 'dark';
	$database = mysql_pconnect($hostname_database, $username_database, $password_database) or trigger_error(mysql_error(),E_USER_ERROR);
	mysql_select_db($database_database, $database);
	?>