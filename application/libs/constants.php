<?php
    /* database table */
    define( 'CREDS', 'credentials' );
    define( 'AGENTS', 'agents' );
    define( 'INV', 'inventory' );
    define( 'INV_PO', 'inventory_po' );
    define( 'LOG', 'inventory_log' );
    define( 'INV_CHKOUT', 'inventory_checked_out' );//
    define( 'COMPANY_USERS', 'company_users' );
    define( 'COMPANY', 'company' );
	define( 'LOCATION', 'locations' );

 //	define( 'USER_ROLES', 'user_roles' );
	define( 'ROLES', 'roles' );
	define ('MODULES', 'modules');

    /* STATUSES */
    define( 'ACTIVE', 1 );
    define( 'INACTIVE', 0 );

    /* Default Records */
    define('DEFAULT_RECORDS', 10);

	/* ROLES CONSTANTS */
	define( 'SUPERADMIN', 1 );
	define( 'DIRECTOR', 2 );
	define( 'SUBCONTRACTOR', 3 );
	define( 'MANAGER', 6 );
	define( 'STAFF', 4 );
	define( 'EMPLOYEE', 7 );
	define( 'AGENT', 5 );
?>