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

$strAgentMailPromocodeTemplate = '
	 <html>
	    <head>
	        <title>PROMOCODE</title>
	    </head>
	    <body>
	        <h1>Here is your PROMOCODE!</h1>
	        <br /><br />
	        <p>Dear ' . $arrAgent->FIRST_NAME . ',</p>
	        <p>Congrats, Your application as Agent for 
	            Location Name:  ' .  $arrAgent->LOCATION .' has been approved.
	        </p>
	        <p>Your Promocode is  ' .  $arrAgent->PROMOCODE . '
	        </p>
	        <br />
	        <p>-The AI Team.</p>

	    </body>
	    </html>
	    ';

	define('AGENT_PROMOCODE_TEMP', $strAgentMailPromocodeTemplate );



$strAgentDetailtoOEMTemplate = '
	 <html>
	    <head>
	        <title>PROMOCODE</title>
	    </head>
	    <body>
	    <h2>Agent details for Verification.</h2>
	        <table>
	            <tr>
	                <th align="left">
                       Name
                    </th>
                    <td>
                       ' . $arrAgent->FIRST_NAME . '  ' . $arrAgent->LAST_NAME . '
                    </td>
                </tr>
                 <tr>
	                <th align="left">
                       Promocode
                    </th>
                    <td>
                       ' . $arrAgent->PROMOCODE . '
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Date of Birth
                    </th>
                    <td>
                       ' . $arrAgent->DOB . '
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Enrollment Number
                    </th>
                    <td>
                       ' . $arrAgent->ENROLLMENT_NUMBER . '
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Enrollment Channel
                    </th>
                    <td>
                       ' . $arrAgent->ENROLLMENT_CHANNEL . '
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       State
                    </th>
                    <td>
                       ' . $arrAgent->STATE . '
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Zipcode
                    </th>
                    <td>
                       ' . $arrAgent->ZIPCODE . '
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       USAC Form
                    </th>
                    <td>
                       ' . $arrAgent->USAC_FORM . '
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Phone
                    </th>
                    <td>
                       ' . $arrAgent->PHONE . '
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Group
                    </th>
                    <td>
                       ' . $arrAgent->AG_GROUP . '
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       DMA
                    </th>
                    <td>
                       ' . $arrAgent->DMA . '
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Email Id
                    </th>
                    <td>
                       ' . $arrAgent->EMAILID . '
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr />
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Headshotfile
                    </th>
                    <td>
                       <a title="View file" target="_blank" href="'. URL . AGENTFILES . $arrAgent->HEADSHOT_FILE . '"> Click to View </a>
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Gov ID File
                    </th>
                    <td>
                       <a title="View file" target="_blank" href="'. URL . AGENTFILES . $arrAgent->GOVID_FILE . '"> Click to View </a>
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Disclosure File
                    </th>
                    <td>
                       <a title="View file" target="_blank" href="'. URL . AGENTFILES . $arrAgent->DISCLOSURE_FILE . '"> Click to View </a>
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       BG Authentication File
                    </th>
                    <td>
                       <a title="View file" target="_blank" href="'. URL . AGENTFILES . $arrAgent->BG_AUTH_FILE . '"> Click to View </a>
                    </td>
                </tr>
                <tr>
	                <th align="left">
                       Certificate File
                    </th>
                    <td>
                       <a title="View file" target="_blank" href="'. URL . AGENTFILES . $arrAgent->COMP_CERT_FILE . '"> Click to View </a>
                    </td>
                </tr>
            </table>
	    </body>
	    </html>
	    ';

define('AGENT_DETAIL_TEMP', $strAgentDetailtoOEMTemplate );