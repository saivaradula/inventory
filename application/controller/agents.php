<?php
	class Agents extends Controller {

		public function index() {

		}

		public function view( $iUserId = '', $objAgentsModel = '' ) {
			require VIEW_PATH . '_templates/agent_self_add.php';

			if( $this->getParameters(1) != ''){
				$iUserId = $this->getParameters(1);
				$objAgentsModel = $this->loadModel('agents');
			}

			$arrAgent = $objAgentsModel->getAgent($iUserId);
			$arrAgent->BATCH_DATE = $this->revDate($arrAgent->BATCH_DATE);
            $arrAgent->DOB = $this->revDate($arrAgent->DOB);
			require VIEW_PATH . 'agents/view.php';
			require VIEW_PATH . '_templates/footer.php';
		}

		public function startup($iUserId = '', $objAgentsModel = '') {
            //ini_set('display_errors', 1 );
			require VIEW_PATH . '_templates/agent_self_add.php';
			if( $this->getParameters(1) != ''){
				$iUserId = $this->getParameters(1);
				$objAgentsModel = $this->loadModel('agents');
			}

			$arrAgent = $objAgentsModel->getAgent($iUserId);

			if( $arrAgent->DOB != '0000-00-00'){
                $arrAgent->DOB = $this->revDate($arrAgent->DOB);
            } else {
                $arrAgent->DOB = '';
            }

			if( $arrAgent->SELF_ACTION == 'submit' ){
				require VIEW_PATH . 'agents/view.php';
			} else {
				require VIEW_PATH . 'agents/add.php';
			}
			require VIEW_PATH . '_templates/footer.php';
		}

		public function add() {
			$arrPost = $this->validateUserInput($_POST);
			$arrPost['batchdate'] = $this->swapDate($arrPost['batchdate']);
			$arrPost['dob'] = $this->swapDate($arrPost['dob']);

			if( $_FILES['headshotfile']['name'] != '' ){
				$arrPost['HEADSHOT_FILE'] = $this->uploadDocument( $_FILES['headshotfile'], AGENTFILES, $_POST['lastname'] . "_HSF" );
			}

			if( $_FILES['govidfile']['name'] != '' ){
				$arrPost['GOVID_FILE'] = $this->uploadDocument( $_FILES['govidfile'], AGENTFILES, $_POST['lastname'] . "_GOVID" );
			}

			if( $_FILES['disclosurefile']['name'] != '' ){
				$arrPost['DISCLOSURE_FILE'] = $this->uploadDocument( $_FILES['disclosurefile'], AGENTFILES, $_POST['lastname'] . "_DISF" );
			}

			if( $_FILES['bgauthfile']['name'] != '' ){
				$arrPost['BG_AUTH_FILE'] = $this->uploadDocument( $_FILES['bgauthfile'], AGENTFILES, $_POST['lastname'] . "_BG" );
			}

			if( $_FILES['compcertfile']['name'] != '' ){
				$arrPost['COMP_CERT_FILE'] = $this->uploadDocument( $_FILES['compcertfile'], AGENTFILES, $_POST['lastname'] . "_COMP" );
			}

			$objAgentsModel = $this->loadModel('agents');
			$objAgentsModel->updateAgent( $arrPost );

			if( $arrPost['saction'] == 'save' ) {
				$this->startup( $arrPost['userid'], $objAgentsModel);
			} else {
				$this->view( $arrPost['userid'], $objAgentsModel);
			}
		}

	}