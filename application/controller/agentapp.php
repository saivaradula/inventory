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
				$arrPost['self_action'] = "New" ;
				$objAgentsModel->addAgents($arrPost);
				include EMAIL_TEMPLATES;
				$arrOptions['emailid'] = $_POST['email'];
				$arrOptions['subject'] = ADDAGENT_EMAIL_SUBJECT;

				$bIsEmailSent = $this->sendEmail($arrOptions['emailid'], ADDAGENT_TEMPLATE );
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



		public function sendapp() {
			require VIEW_PATH . '_templates/header.php';
			require VIEW_PATH . 'appagent/sendmail.php';
			require VIEW_PATH . '_templates/footer.php';
		}
	}