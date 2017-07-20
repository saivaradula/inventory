<?php


	define('ADDAGENTURL', URL . "agents/startup" );
	define('ADDAGENT_EMAIL_SUBJECT', "Submit your details for Agent Role - AI" );

	$strAddAgentTemplate = '
	 <html>
	    <head>
	        <title>Welcome to AI</title>
	    </head>
	    <body>
	        <h1>Thanks you for showing interest in us!</h1>
	        <br /><br />
	        <p>Dear Guest,</p>
	        <p>Please click the <a target="_blank" href="' . ADDAGENTURL . "/" . $arrPost['userid'] .'">' . ADDAGENTURL  .'</a> for submitting your details to us.</p>
	        <p>Once we receive your details, we will verify and you will be one of our team.
	        </p>
	        <br />
	        <p>-The AI Team.</p>

	    </body>
	    </html>
	    ';

	define('ADDAGENT_TEMPLATE', $strAddAgentTemplate );
