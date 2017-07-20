<?php
require 'application/config/config.php';

/* // load application class */
require 'application/libs/application.php';
require 'application/libs/controller.php';
require 'application/libs/model.php';

/* load constants file. */
require 'application/libs/constants.php';
//require 'application/libs/email_templates.php';

/* // start the application */
$objApp = new Application();
