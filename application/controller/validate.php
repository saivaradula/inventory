<?php

	class Validate extends Controller {
		public function index() {
			
		}

		public function checkEditCheckin() {

            $objInvModel = $this->loadModel('inventory');
            if ($_POST['pre_imei'] != $_POST['imei']) {
                // Check IMEI..
                $strIMEI = "('"  . $_POST['imei'] . "')";
                $arrR = $objInvModel->checkInventory($strIMEI, $this->loggedInUserId(), $this->getLoggedUserRole());

                if( count($arrR) ) {
                    $arrR['proceed'] = false;
                    $arrR['reason'] = "IMEI already Exists.";
                } else {
                    $arrR['proceed'] = true;
                }

            } else {
                $arrR['proceed'] = true;
            }
            $objJSON = json_encode($arrR);
            echo $objJSON;
        }

		public function checkBlgChekinIMEI() {
            $objInvModel = $this->loadModel('inventory');
            $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
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
                if($this->getLoggedUserRoleID() == MANAGER ) {
                    $arrPO = $objInvModel->getPONumberByImeiToLOC($strIMEI, $this->loggedInUserId());
                } else {
                    $arrPO = $objInvModel->getPONumberByImei($strIMEI, $this->loggedInUserId());
                }
                //$arrPO = $objInvModel->getPONumberByImei($strIMEI, $this->loggedInUserId());
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
            $objLocModel = $this->loadModel('location');
            $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
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

            /*if( $this->getLoggedUserRoleID() == SUPERADMIN ) {
                $objJSON = json_encode( array('proceed' => true ) );
            } else {*/
                if( $this->getLoggedUserRoleID() == DIRECTOR ) {
                    $arrR = $objInvModel->checkInvBelongsTo($strIMEI, $this->loggedInUserId(), 'STAFF_DIRECTOR', $_POST['prevcheckaction']);
                } else {
                    $iSubCntMgr = 0;
                    if($_SESSION['IS_SELF']) {
                        if($this->getLoggedUserRoleID() == MANAGER ) {
                            $iSubCntMgr = 1;
                        }
                    }

                    if($iSubCntMgr) {
                        $arrU = $objLocModel->getLocationSubCnt( $_SESSION['L_ID'] );
                        $arrR = $objInvModel->checkInvBelongsTo($strIMEI, $arrU->SUBCONTRACTOR, 'STAFF_DIRECTOR', "'CHECKED_IN', 'RECEIVE'");
                    } else {
                        $arrR = $objInvModel->checkInvBelongsTo($strIMEI, $this->loggedInUserId(), $this->getLoggedUserRole(), $_POST['prevcheckaction']);
                    }
                }


                if( count( $arrR ) != $iPC ) {
                    $objJSON = json_encode( array('proceed' => false ) );
                } else {
                    $objJSON = json_encode( array('proceed' => true ) );
                }
            // }
            echo $objJSON;
        }

		public function assignCheckIMEI() {
            $objInvModel = $this->loadModel('inventory');
            $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
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


            if( count($arrR) ){
                if( $_SESSION['IS_SELF'] ){
                    if($arrR[0]->ASSIGNED_TO == $_SESSION['L_ID']){
                        $objJSON = json_encode( array('proceed' => true ) );
                    } else {
                        $arrR['proceed'] = false;
                        $objJSON = json_encode($arrR);
                    }
                } else{
                    $arrR['proceed'] = false;
                    $objJSON = json_encode($arrR);
                }
            } else {
                $objJSON = json_encode( array('proceed' => true ) );
            }
            echo $objJSON;


        }

		public function returnIMEI() {
            $objInvModel = $this->loadModel('inventory');
            $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
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
            // if this belongs to returner.



            $iSubCntMgr = 0;
            if( $_SESSION['IS_SELF'] ){
                if($this->getLoggedUserRoleID() == MANAGER ) {
                    $iSubCntMgr = 1;
                }
            }

            if( $iSubCntMgr ){
                $objLocModel = $this->loadModel('location');
                $arrU = $objLocModel->getLocationSubCnt( $_SESSION['L_ID'] );
                $iUsr = $arrU->SUBCONTRACTOR;
            } else {
                $iUsr = $this->loggedInUserId();
            }

            $arrR = $objInvModel->returnBelongInventory($strIMEI, $iUsr, $this->getLoggedUserRoleID() );

            if( count( $arrR ) == 0 ){
                $arrR['proceed'] = false;
                $arrR['error'] = 'Some of IMEI does not belong to You';
                $objJSON = json_encode($arrR);
            } else {
                $arrR = $objInvModel->returnCheckInventory($strIMEI, $iUsr, $this->getLoggedUserRole());
                if( count($arrR) ){
                    $arrR['proceed'] = false;
                    $arrR['error'] = 'Some of IMEI does not belong to You';
                    $objJSON = json_encode($arrR);
                } else {
                    $objJSON = json_encode( array('proceed' => true ) );
                }
            }




            echo $objJSON;
        }

		public function shipIMEI() {

			$objInvModel = $this->loadModel('inventory');
            $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
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

			/*if( $this->getLoggedUserRoleID() == SUPERADMIN ) {
                $objJSON = json_encode( array('proceed' => true ) );
            } else {*/
                $arrR = $objInvModel->shipCheckInventory($strIMEI, $this->loggedInUserId(), $this->getLoggedUserRole());
                //echo $arrR;
                if( count($arrR) ){
                    $arrR['proceed'] = false;
                    $objJSON = json_encode($arrR);
                } else {
                    $objJSON = json_encode( array('proceed' => true ) );
                }
            //}
			echo $objJSON;
		}

        public function receiveIMEI() {
            $objInvModel = $this->loadModel('inventory');
            $objLocModel = $this->loadModel('location');

            $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
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
            $iSubCntMgr = 0;
            if($_SESSION['IS_SELF']) {
                if($this->getLoggedUserRoleID() == MANAGER ) {
                    $iSubCntMgr = 1;
                }
            }

            if( $iSubCntMgr ){
                $arrU = $objLocModel->getLocationSubCnt( $_SESSION['L_ID'] );
                $iUsr = $arrU->SUBCONTRACTOR;
            } else {
                $iUsr = $this->loggedInUserId();
            }

            $arrR = $objInvModel->recheckinBelongToYou( $strIMEI, $iUsr );
            if( count( $arrR ) ){
                $arrR = $objInvModel->shipReceiveInventory($strIMEI, $iUsr, $this->getLoggedUserRole());
                if( count($arrR) ){
                    $arrR['proceed'] = false;
                    $arrR['reason'] = "Some of IMEIs are already received.";
                    $objJSON = json_encode($arrR);
                } else {
                    $objJSON = json_encode( array('proceed' => true ) );
                }
            } else {
                $arrR['proceed'] = false;
                $arrR['reason'] = "Some of IMEIs does not belong to you.";
                $objJSON = json_encode($arrR);
            }

            echo $objJSON;
        }

		public function checkIMEI() {

		    $objInvModel = $this->loadModel('inventory');
            $objLocModel = $this->loadModel('location');
            $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
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
				$arrR['reason'] = "Below IMEI already checked in.";
                //$objInvModel->checkInventoryBelongToMe( $strIMEI, $this->loggedInUserId() );
                if($this->getLoggedUserRoleID() == MANAGER ) {
                    if( $_SESSION['IS_SELF'] ){
                        // get location sub contractor.
                        $arrU = $objLocModel->getLocationSubCnt( $_SESSION['L_ID'] );
                        $arrR1 = $objInvModel->checkInvBelongsAssignTo($strIMEI, $arrU->SUBCONTRACTOR);
                    } else {
                        $arrR1 = $objInvModel->checkInvBelongsAssignToLoc($strIMEI, $this->loggedInUserId());
                    }
                } else {
                    $arrR1 = $objInvModel->checkInvBelongsAssignTo($strIMEI, $this->loggedInUserId());
                }



                if( count( $arrR1 ) ){
                    if($this->getLoggedUserRoleID() == MANAGER ) {
                        if( $_SESSION['IS_SELF'] ){
                            $arrPO = $objInvModel->getPONumberByImei($strIMEI, $arrU->SUBCONTRACTOR);
                        } else {
                            $arrPO = $objInvModel->getPONumberByImeiToLOC($strIMEI, $this->loggedInUserId());
                        }
                    } else {
                        $arrPO = $objInvModel->getPONumberByImei($strIMEI, $this->loggedInUserId());
                    }

                    if( $arrPO->PO_NUMBER != $_POST['ponumber']) {
                        $objJSON = json_encode( array('proceed' => false, 'reason' => 'Invalid PO Number' ) );
                    } else {
                        $objJSON = json_encode( array('proceed' => true ) );
                    }
                } else {
                    $objJSON = json_encode($arrR);
                }

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

		function checkPromocode(){
            $objUserModel = $this->loadModel('agents');
            $arrUser = $objUserModel->validatePromocode($this->validateUserInput($_POST['em']));

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
					case "EMP" : // SUB CONTRACTORS
					case "STF" :{ // STAFF
						$arrLoggedUser = $objUserModel->getCompanyUserDetails( $arrLoggedUser->USER_ID );
						$this->setUser($arrLoggedUser);
						break;
					}

                    case "MGR" : { // MANAGERS
                        $objLocationModel = $this->loadModel('location');
                        $arrLoggedUser = $objUserModel->getCompanyUserDetails( $arrLoggedUser->USER_ID );
                        $this->setUser($arrLoggedUser);
                        $arrGetLocation = $objLocationModel->getUserLocation(  $arrLoggedUser->USER_ID );
                        $_SESSION[ 'L_NAME' ] = $arrGetLocation->NAME;
                        $_SESSION[ 'IS_SELF' ] = $arrGetLocation->IS_SELF;
                        $_SESSION[ 'L_ID' ] = $arrGetLocation->ID;
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