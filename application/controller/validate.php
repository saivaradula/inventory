<?php


	class Validate extends Controller {
		public function index() {
			
		}

		public function checkBlgChekinIMEI() {
            $objInvModel = $this->loadModel('inventory');
            $arrIMEI = explode(",", $_POST['imei']);
            $arrIMEI = array_map('trim',$arrIMEI);
            $arrIMEI = array_unique($arrIMEI);

            $iPC = 0;
            for( $i=0;$i <= count($arrIMEI); $i++){
                if( $arrIMEI[$i] != '' ){
                    $iPC = $iPC + 1;
                    $strIMEI .= "'"  . $arrIMEI[$i] . "',";
                }
            }

            $strIMEI = substr($strIMEI, 0, strlen($strIMEI)-1);
            $strIMEI = "(" . $strIMEI . ")";
            if($this->getLoggedUserRoleID() == MANAGER ) {
                $arrR = $objInvModel->checkInvBelongsAssignToLoc($strIMEI, $this->loggedInUserId());
            } else {
                $arrR = $objInvModel->checkInvBelongsAssignTo($strIMEI, $this->loggedInUserId());
            }



            if( count( $arrR ) != $iPC ) {
                $objJSON = json_encode( array('proceed' => false, 'reason' => 'Some of IMEI are not shipped to you yet.' ) );
            } else {
                $arrPO = $objInvModel->getPONumberByImei($strIMEI, $this->loggedInUserId());
                if( $arrPO->PO_NUMBER != $_POST['ponumber']) {

                    $objJSON = json_encode( array('proceed' => false, 'reason' => 'Invalid PO Number' ) );
                } else {
                    $objJSON = json_encode( array('proceed' => true ) );
                }
            }
            echo $objJSON;
        }

		public function checkBlgShipIMEI() {
            $objInvModel = $this->loadModel('inventory');
            $arrIMEI = explode(",", $_POST['imei']);
            $arrIMEI = array_map('trim',$arrIMEI);
            $arrIMEI = array_unique($arrIMEI);

            $iPC = 0;
            for( $i=0;$i <= count($arrIMEI); $i++){
                if( $arrIMEI[$i] != '' ){

                    $iPC = $iPC + 1;
                    $strIMEI .= "'"  . $arrIMEI[$i] . "',";
                }
            }
            $strIMEI = substr($strIMEI, 0, strlen($strIMEI)-1);
            $strIMEI = "(" . $strIMEI . ")";
            $arrR = $objInvModel->checkInvBelongsTo($strIMEI, $this->loggedInUserId(), $this->getLoggedUserRole(), $_POST['prevcheckaction']);


            if( count( $arrR ) != $iPC ) {
                $objJSON = json_encode( array('proceed' => false ) );
            } else {
                $objJSON = json_encode( array('proceed' => true ) );
            }
            echo $objJSON;
        }

		public function assignCheckIMEI() {
            $objInvModel = $this->loadModel('inventory');
            $arrIMEI = explode(",", $_POST['imei']);
            $arrIMEI = array_map('trim',$arrIMEI);
            $arrIMEI = array_unique($arrIMEI);
            //print_r(array_count_values($arrIMEI));
            for($i=0;$i<count($arrIMEI);$i++){
                if( $arrIMEI[$i] != '' ){
                    $strIMEI .= "'"  . $arrIMEI[$i] . "',";
                }
            }
            $strIMEI = substr($strIMEI, 0, strlen($strIMEI)-1);
            $strIMEI = "(" . $strIMEI . ")";
            $arrR = $objInvModel->assignCheckInventory($strIMEI, $this->loggedInUserId(), $this->getLoggedUserRole());
            //echo $arrR;
            if( count($arrR) ){
                $arrR['proceed'] = false;
                $objJSON = json_encode($arrR);
            } else {
                $objJSON = json_encode( array('proceed' => true ) );
            }
            echo $objJSON;
        }


		public function returnIMEI() {
            $objInvModel = $this->loadModel('inventory');
            $arrIMEI = explode(",", $_POST['imei']);
            $arrIMEI = array_map('trim',$arrIMEI);
            $arrIMEI = array_unique($arrIMEI);
            //print_r(array_count_values($arrIMEI));
            for($i=0;$i<count($arrIMEI);$i++){
                if( $arrIMEI[$i] != '' ){
                    $strIMEI .= "'"  . $arrIMEI[$i] . "',";
                }
            }
            $strIMEI = substr($strIMEI, 0, strlen($strIMEI)-1);
            $strIMEI = "(" . $strIMEI . ")";
            $arrR = $objInvModel->returnCheckInventory($strIMEI, $this->loggedInUserId(), $this->getLoggedUserRole());
            //echo $arrR;
            if( count($arrR) ){
                $arrR['proceed'] = false;
                $objJSON = json_encode($arrR);
            } else {
                $objJSON = json_encode( array('proceed' => true ) );
            }
            echo $objJSON;
        }

		public function shipIMEI() {
			$objInvModel = $this->loadModel('inventory');
            $arrIMEI = explode(",", $_POST['imei']);
            $arrIMEI = array_map('trim',$arrIMEI);
            $arrIMEI = array_unique($arrIMEI);
            //print_r(array_count_values($arrIMEI));
            for($i=0;$i<count($arrIMEI);$i++){
                if( $arrIMEI[$i] != '' ){
                    $strIMEI .= "'"  . $arrIMEI[$i] . "',";
                }
            }

			$strIMEI = substr($strIMEI, 0, strlen($strIMEI)-1);
			$strIMEI = "(" . $strIMEI . ")";
			$arrR = $objInvModel->shipCheckInventory($strIMEI, $this->loggedInUserId(), $this->getLoggedUserRole());
			//echo $arrR;
			if( count($arrR) ){
				$arrR['proceed'] = false;
				$objJSON = json_encode($arrR);
			} else {
				$objJSON = json_encode( array('proceed' => true ) );
			}
			echo $objJSON;
		}

        public function receiveIMEI() {
            $objInvModel = $this->loadModel('inventory');

            $arrIMEI = explode(",", $_POST['imei']);
            $arrIMEI = array_map('trim',$arrIMEI);
            $arrIMEI = array_unique($arrIMEI);
            //print_r(array_count_values($arrIMEI));
            for($i=0;$i<count($arrIMEI);$i++){
                if( $arrIMEI[$i] != '' ){
                    $strIMEI .= "'"  . $arrIMEI[$i] . "',";
                }
            }

            $strIMEI = substr($strIMEI, 0, strlen($strIMEI)-1);
            $strIMEI = "(" . $strIMEI . ")";
            $arrR = $objInvModel->shipReceiveInventory($strIMEI, $this->loggedInUserId(), $this->getLoggedUserRole());
            if( count($arrR) ){
                $arrR['proceed'] = false;
                $objJSON = json_encode($arrR);
            } else {
                $objJSON = json_encode( array('proceed' => true ) );
            }
            echo $objJSON;
        }

		public function checkIMEI() {
			$objInvModel = $this->loadModel('inventory');

			$arrIMEI = explode(",", $_POST['imei']);
            $arrIMEI = array_map('trim',$arrIMEI);
            $arrIMEI = array_unique($arrIMEI);
            //print_r(array_count_values($arrIMEI));
			for($i=0;$i<count($arrIMEI);$i++){
				if( $arrIMEI[$i] != '' ){
					$strIMEI .= "'"  . $arrIMEI[$i] . "',";
				}
			}
			$strIMEI = substr($strIMEI, 0, strlen($strIMEI)-1);
			$strIMEI = "(" . $strIMEI . ")";
			$arrR = $objInvModel->checkInventory($strIMEI, $this->loggedInUserId(), $this->getLoggedUserRole());
			if( count($arrR) ){
				$arrR['proceed'] = false;
				$objJSON = json_encode($arrR);
			} else {
				$objJSON = json_encode( array('proceed' => true ) );
			}
			echo $objJSON;
		}

		function checkUserEmail() {
			$objUserModel = $this->loadModel('users');

			$arrUser = $objUserModel->validateUserEmail($this->validateUserInput($_POST['em']));
			if( $arrUser->USER_ID != '' ){
				echo 1;
			} else {
				echo 0;
			}
		}

		public function checkUser() {
			$objUserModel = $this->loadModel('users');
			$arrUser = $objUserModel->validateUser($this->validateUserInput($_POST['loginname']));
			if( $arrUser->USER_ID != '' ){
				echo 1;
			} else {
				echo 0;
			}
		}

		public function login() {
			$strUserId = $this->validateUserInput($_POST[ 'userid' ]);
			$objUserModel = $this->loadModel('users');

			$arrLoggedUser = $objUserModel->validateUser($strUserId, $_POST[ 'lpassword' ]);

			if ( $arrLoggedUser->USER_ID ) {

				switch( $arrLoggedUser->PRE_FIX ) {
					case "SU" : { // SUPER ADMIN
						$arrLoggedUser = $objUserModel->getCompanyUserDetails( $arrLoggedUser->USER_ID, SUPERADMIN );
						$this->setUser($arrLoggedUser);
						break;
					}
					case "DIR" : // DIRECTORS
					case "SBC" : // SUB CONTRACTORS
					case "MGR" : // MANAGERS
					case "STF" :{ // STAFF
						$arrLoggedUser = $objUserModel->getCompanyUserDetails( $arrLoggedUser->USER_ID );
						$this->setUser($arrLoggedUser);
						break;
					}

					case "AG" : { // AGENTS
						$arrLoggedUser = $objUserModel->getAgentDetails( $arrLoggedUser->USER_ID );
						$this->setAgent($arrLoggedUser);
						break;
					}
				}
				$this->loginUser();
				if( $arrLoggedUser->ROLE_NAME == 'SUPERADMIN'){
					$this->loadAllowedModules($objUserModel->loadSystemModules());
				} else {
					$this->loadAllowedModules($objUserModel->getRoleModules($arrLoggedUser->ROLE_ID));
				}
				echo 1;
			} else {
				echo 0;
			}
		}
	}