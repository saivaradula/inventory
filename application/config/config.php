<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 0);

	/*define('DB_TYPE', 'mysql');
	define('DB_HOST', '127.0.0.1');
	define('DB_NAME', 'aoipdb');
	define('DB_USER', 'root');
	define('DB_PASS', '');	
	date_default_timezone_set("US/Eastern");

	

	define('URL', 'http://aio.localhost.com/');*/
	
	
	
	define('DB_TYPE', 'mysql');
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'aoipdbqa');
	define('DB_USER', 'root');
	define('DB_PASS', 'root');


	date_default_timezone_set("US/Eastern");


	define('URL', 'http://ec2-52-207-228-156.compute-1.amazonaws.com/');
	
	define( 'PUBLIC_URL', URL . 'public/' );
	define( 'VIEW_PATH', 'application/views/' );
	define( 'PDFLIB', 'application/libs/tcpdf');
	define( 'AGENTFILES', 'application/agentfiles/');
	define( 'EMAIL_TEMPLATES', 'application/libs/email_templates.php');
	define( 'IMP_DATA', 'public/imei_data');
