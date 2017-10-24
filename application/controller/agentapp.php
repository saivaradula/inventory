<?php
	class AgentApp extends Controller {

		private function classifyStatus( $arrAgents ) {
			foreach( $arrAgents AS $arrAgent ){
				switch( $arrAgent->Q_STATUS ) {
					case "NOT_QUALIFIED" : {$arrAgent->Q_STATUS = 'Not Qualified'; break;}
					case "QUALIFIED" : {$arrAgent->Q_STATUS = 'Active'; break;}
					case "PENDING" : {$arrAgent->Q_STATUS = 'Pending'; break;}
				}

				switch( strtoupper( $arrAgent->SELF_ACTION ) ) {
					case "SUBMIT" : {$arrAgent->SELF_ACTION = 'Document Submitted'; break;}
					case "SAVE" : {$arrAgent->SELF_ACTION = 'Details Saved'; break;}
					default : {$arrAgent->SELF_ACTION = 'New Application'; break;}
				}
			}
			return $arrAgents;
		}

		function sendoememail() {
            $objAgentsModel = $this->loadModel('agents');
            $iUserId = $_POST['id'];
            $strOEMMail = $_POST['email'];
            $arrAgent = $objAgentsModel->getAgent($iUserId);
            $arrAgent->DOB = $this->USDateFormat( $arrAgent->DOB );
            $arrOptions['emailid'] = $strOEMMail;
            $arrOptions['subject'] = "Agent Details for Verification";
            include EMAIL_TEMPLATES;
            echo $this->sendEmail($arrOptions, AGENT_DETAIL_TEMP );
        }


		public function index() {
			require VIEW_PATH . '_templates/header.php';
			$objAgentsModel = $this->loadModel('agents');
			if( $_POST['email'] ){
				$arrPost = $this->validateUserInput($_POST);
				$arrPost['parent'] = $this->getLoggedInUserCompanyID();
				$arrPost['createdon'] = $this->now();
				$arrPost['createdby'] = $this->loggedInUserId();
				$arrPost['userid'] = date('Ymdhis') ;
				$arrPost['action'] = "SELF" ;
				$arrPost['q_status'] = "PENDING";
				$arrPost['self_action'] = "New" ;
				$objAgentsModel->addAgents($arrPost);
				include EMAIL_TEMPLATES;
				$arrOptions['emailid'] = $_POST['email'];
				$arrOptions['subject'] = ADDAGENT_EMAIL_SUBJECT;

				$bIsEmailSent = $this->sendEmail($arrOptions, ADDAGENT_TEMPLATE );
				if( $bIsEmailSent ){
					$strMsg = "Email sent to " . $_POST['email'] . " Successfully";
				} else {
					$strMsg = "Could not send email to " . $_POST['email'] . ". Please check with Email Configuration Server";
					//$objAgentsModel->deleteAgentRecord($arrPost['userid']);
				}
			}

			$arrOptions = array();
			$arrOptions['company'] = $this->getLoggedInUserCompanyID();
			$arrOptions['created'] =  $this->loggedInUserId();
			$arrOptions['action'] =  "SELF";
			$arrOptions['self_action'] = $_POST['self_action'];
			$arrAgents = $objAgentsModel->getAgents($arrOptions);
			$arrAgents = $this->classifyStatus( $arrAgents );
			require VIEW_PATH . 'appagent/index.php';
			require VIEW_PATH . '_templates/footer.php';
		}

		public function sendagentemail() {
            $objAgentsModel = $this->loadModel('agents');
            $iUserId = $_POST['id'];
            $arrAgent = $objAgentsModel->getAgent($iUserId);
            $arrOptions['emailid'] = $arrAgent->EMAILID;
            $arrOptions['subject'] = "Your Promocode As an Agent";

            include EMAIL_TEMPLATES;
            echo $this->sendEmail($arrOptions, AGENT_PROMOCODE_TEMP );
        }

		public function sendapp() {
			require VIEW_PATH . '_templates/header.php';
			require VIEW_PATH . 'appagent/sendmail.php';
			require VIEW_PATH . '_templates/footer.php';
		}
	}