<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 0);

	define('DB_TYPE', 'mysql');
	define('DB_HOST', '127.0.0.1');
	define('DB_NAME', 'aio');
	define('DB_USER', 'root');
	define('DB_PASS', '');


	/* Set US/Eastern Time Zone */
	date_default_timezone_set("US/Eastern");

	/**
	 * Configuration for: Project URL
	 * Put your URL here, for local development "127.0.0.1" or "localhost" (plus sub-folder) is fine
	 */

	define('URL', 'http://aio.localhost.com/');
	//define('URL', 'http://aio.tech3sixty5.co.in/');
	define( 'PUBLIC_URL', URL . 'public/' );
	define( 'VIEW_PATH', 'application/views/' );
	define( 'PDFLIB', 'application/libs/tcpdf');
	define( 'AGENTFILES', 'application/agentfiles/');
	define( 'EMAIL_TEMPLATES', 'application/libs/email_templates.php');
