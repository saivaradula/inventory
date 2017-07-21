<?php

//ini_set('display_errors', 1 );
	class Inventory extends Controller {

		public function index() {

			require VIEW_PATH . '_templates/header.php';
			$objInvModel = $this->loadModel('inventory');
			$objLogModel = $this->loadModel('log');
			$objCompModel = $this->loadModel('company');
			$objUserModel = $this->loadModel('users');



			if( $_POST['action'] ){

				switch( $_POST['action'] ) {

                    case "receive": {

                        $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
                        $arrIMEI = array_map('trim',$arrIMEI);
                        $arrIMEI = array_unique($arrIMEI);
                        $_POST['imei'] = $arrIMEI;

                        $arrPost['status'] = "RECEIVE";
                        $arrPost['ponumber'] = $_POST['ponumber'];
                        $arrPost['user_type'] = $this->getLoggedUserRole();
                        $arrPost['user_id'] = $this->loggedInUserId();
                        $arrU = $objUserModel->getUserDetailsByUserId(  $this->loggedInUserId() );
                        $arrPost['modified_on'] = $this->now();
                        $arrPost['modified_by'] = $this->loggedInUserId();
                        $arrPost['desc'] = "Received by "  . $arrU->NAME . " ( " . $arrU->ROLE_NAME . ")";
                        $arrPost[ 'assigned_to' ] = 0;

                        for($i=0; $i < count($_POST['imei']); $i++){
                            if( $_POST['imei'][$i] != '' ) {
                                $arrC = $objInvModel->isInvenCheckedIn( $_POST['imei'][$i] );
                                $arrPost['imei'] = $_POST['imei'][$i];
                                    $arrPost['added_on'] = $this->now();
                                    $arrPost['modified_by'] = $this->loggedInUserId();
                                    $arrPost['have_access'] = $this->loggedInUserId();
                                    $arrPost['unique'] = $arrC->UNIQUE_ID;
                                    $objInvModel->updateInventory($arrPost);
                                $objLogModel->logInventory($arrPost);
                            }
                        }

                        $arrCOptions['ponumber'] = $_POST['ponumber'];
                        $arrCOptions['EXACT'] = true;
                        $arrGotPO = $objInvModel->getPO($arrCOptions);
                        if( count($arrGotPO) == 0 ){
                            $arrPOPost = $arrPost;
                            $arrPOPost['added_on'] = $this->now();
                            $arrPOPost['added_by'] = $this->loggedInUserId();
                            $objInvModel->addPO($arrPOPost);
                        }

                        break;
                    }

				    case "return" : {

                        $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
                        $arrIMEI = array_map('trim',$arrIMEI);
                        $arrIMEI = array_unique($arrIMEI);
                        $_POST['imei'] = $arrIMEI;

                        $arrPost['status'] = "SHIPPED [R]";
                        $arrPost['ponumber'] = date('YmdHims');
                        $arrPost['user_type'] = $this->getLoggedUserRole();
                        $arrPost[ 'assigned_to' ] = $_POST['shpto_manager'];
                        $arrPost['user_id'] = $this->loggedInUserId();
                        $arrPost['modified_by'] = $this->loggedInUserId();
                        $arrPost['modified_on'] = $this->now();
                        $arrPost['added_on'] = $this->now();
                        $arrPost['added_by'] = $this->loggedInUserId();

                        $arrU = $objUserModel->getUserDetailsByUserId( $_POST['shpto_manager'] );
                        $arrPost['desc'] = "Returned to " . $arrU->NAME . " ( " . $arrU->ROLE_NAME . ") ";

                        $arrCPost['imei'] = $_POST['imei'][0];

                        $arrUserT  = $objCompModel->getCUserDetails( $_POST['shpto_manager'] );
                        $arrPost['user_type'] = $arrUserT->ROLE_NAME;

                        //Get Unique Number from Checkin.
                        $arrCPost['imei'] = $_POST['imei'][0];
                        $arrC = $objInvModel->getInventory( $arrCPost, true );
                        $arrPost['unique'] = $arrC[0]->UNIQUE_ID;

                        $arrPost['tracking'] = date('YmdHims');

                        for($i=0; $i < count($_POST['imei']); $i++) {
                            if( $_POST['imei'][$i] != '' ) {
                                $arrC = $objInvModel->isInvenCheckedIn( $_POST['imei'][$i] );
                                $arrPost['have_access'] = $arrC->HAVE_ACCESS . " " . $arrU->USER_ID;
                                $arrPost['imei'] = $_POST['imei'][$i];
                                $objInvModel->shipInventory($arrPost);
                                $objLogModel->logInventory($arrPost);
                            }
                        }
                        break;
                    }

					case "chekin" : {

                        /*print_r( $_POST );
                        echo "<br /><br />";
                        $skuList = explode(PHP_EOL, $_POST['imei']);
                        $skuList2 = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
                        print_r( $skuList );
                        print_r( $skuList2 );*/

                        $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
                        $arrIMEI = array_map('trim',$arrIMEI);
                        $arrIMEI = array_unique($arrIMEI);
                        $_POST['imei'] = $arrIMEI;


						$iUnique = $this->randomNumber();
						$arrPost['status'] = "CHECKED_IN";
						$arrPost['ponumber'] = $_POST['ponumber'];
						$arrPost['user_type'] = $this->getLoggedUserRole();
						$arrPost['user_id'] = $this->loggedInUserId();
                        $arrU = $objUserModel->getUserDetailsByUserId(  $this->loggedInUserId() );
						$arrPost['modified_on'] = $this->now();
						$arrPost['desc'] = "Checked in by "  . $arrU->NAME . " ( " . $arrU->ROLE_NAME . ")";
						$arrPost[ 'assigned_to' ] = 0;
                        //$arrPost['tracking'] = date('YmdHims');

						for($i=0; $i < count($_POST['imei']); $i++){
							if( $_POST['imei'][$i] != '' ) {
								$arrC = $objInvModel->isInvenCheckedIn( $_POST['imei'][$i] );
                                $arrPost['imei'] = $_POST['imei'][$i];
								if( $arrC->IMEI == $_POST['imei'][$i] ){
                                    $arrPost['unique'] = $arrC->UNIQUE_ID;
                                    //$arrPost['have_access'] = $arrC->HAVE_ACCESS . " " . $this->loggedInUserId();
                                    $arrPost['have_access'] = $this->loggedInUserId();
                                    $arrPost['modified_by'] = $this->loggedInUserId();
									$objInvModel->updateInventory( $arrPost );
								} else {
                                    $arrPost['added_on'] = $this->now();
                                    $arrPost['added_by'] = $this->loggedInUserId();
                                    $arrPost['modified_by'] = $this->loggedInUserId();
                                    $arrPost['unique'] = $iUnique;
                                    $arrPost['have_access'] = $this->loggedInUserId();
									$objInvModel->addInventory($arrPost);
								}
								$objLogModel->logInventory($arrPost);
							}
						}

                        $arrCOptions['ponumber'] = $_POST['ponumber'];
                        $arrCOptions['EXACT'] = true;
                        $arrGotPO = $objInvModel->getPO($arrCOptions);
                        if( count($arrGotPO) == 0 ){
                            $arrPOPost = $arrPost;
                            $arrPOPost['added_on'] = $this->now();
                            $arrPOPost['added_by'] = $this->loggedInUserId();
                            $objInvModel->addPO($arrPOPost);
                        }
						$arrCOptions = array();
						break;
					}

					case "shipin" : {

                        $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
                        $arrIMEI = array_map('trim',$arrIMEI);
                        $arrIMEI = array_unique($arrIMEI);
                        $_POST['imei'] = $arrIMEI;

						$arrPost['status'] = "SHIPPED_IN";
						$arrPost['ponumber'] = date('YmdHims');
						$arrPost['tracking'] = date('YmdHims');
						$arrPost['user_type'] = $this->getLoggedUserRole();
						$arrPost['assigned_to'] =  $_POST['shpto_subc'];
                        $arrPost['user_id'] = $this->loggedInUserId();
                        $arrPost['modified_on'] = $this->now();
                        $arrPost['added_on'] = $this->now();
                        $arrPost['added_by'] = $this->loggedInUserId();

						if( $_POST['shpto_manager'] != '' ) {
							$arrPost['assigned_to'] =  $_POST['shpto_manager'];
                            $objLocModel = $this->loadModel('location');
                            $arrU = $objLocModel->getLocation( $arrPost['assigned_to'] );
                            $arrPost['desc'] = "Shipped to "  . $arrU->NAME;

						} else {
                            $arrU = $objUserModel->getUserDetailsByUserId(  $arrPost['assigned_to'] );
                            $arrPost['desc'] = "Shipped to "  . $arrU->NAME . " ( " . $arrU->ROLE_NAME . ")";
                        }

						//Get Unique Number from Checkin.
                        $arrCPost['imei'] = $_POST['imei'][0];
                        $arrC = $objInvModel->getInventory( $arrCPost, true );
                        $arrPost['unique'] = $arrC[0]->UNIQUE_ID;

                        $arrPost['modified_by'] = $this->loggedInUserId();
						for($i=0; $i < count($_POST['imei']); $i++) {
							if( $_POST['imei'][$i] != '' ) {
                                $arrC = $objInvModel->isInvenCheckedIn( $_POST['imei'][$i] );
                                $arrPost['have_access'] = $arrC->HAVE_ACCESS . " " . $arrU->USER_ID;
								$arrPost['imei'] = $_POST['imei'][$i];

								$objInvModel->shipInventory($arrPost);
								$objLogModel->logInventory($arrPost);
							}
						}
						break;
					}

                    case "assign" : {

                        $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
                        $arrIMEI = array_map('trim',$arrIMEI);
                        $arrIMEI = array_unique($arrIMEI);
                        $_POST['imei'] = $arrIMEI;

                        $arrPost['status'] = "ASSIGNED";
                        $arrPost['ponumber'] = date('YmdHims');
                        $arrPost['user_type'] = $this->getLoggedUserRole();
                        $arrPost['added_by'] = $this->loggedInUserId();
                        $arrPost['modified_on'] = $this->now();
                        $arrPost['assigned_to'] =  $_POST['shpto_subc'];
                        if( $_POST['shpto_manager'] != '' ) {
                            $arrPost['assigned_to'] =  $_POST['shpto_manager'];
                        }

                        if( $this->getLoggedUserRoleID() == MANAGER ){
                            // Assigning to Agent.
                            $objAgentModel = $this->loadModel('agents');
                            $arrO['id'] = $arrPost['assigned_to'];
                            $arrU = $objAgentModel->getAgents( $arrO );
                            $arrPost['desc'] = "Assigned to Agent "  . $arrU[0]->FIRST_NAME . " " . $arrU[0]->LAST_NAME . " ( AGENT ) ";
                            $arrPost['user_id'] =  $arrPost['assigned_to'];
                        } else {
                            $arrU = $objUserModel->getUserDetailsByUserId(  $arrPost['assigned_to'] );
                            $arrPost['desc'] = "Assigned to Manager "  . $arrU->NAME . " ( " . $arrU->ROLE_NAME . ") ";
                        }


                        $objInvModel->addPO($arrPost);
                        $arrPost['modified_by'] = $this->loggedInUserId();
                        for($i=0; $i < count($_POST['imei']); $i++){
                            if( $_POST['imei'][$i] != '' ) {
                                $arrPost['imei'] = $_POST['imei'][$i];
                                $objInvModel->shipInventory($arrPost);
                                $objLogModel->logInventory($arrPost);
                            }
                        }
                        break;
                    }
				}

				//header("Location: /inventory");
			}
			$strPO = $this->getParameters(0);

			if( $strPO != '' ) {
				$arrOptions['ponumber'] = $strPO;
				$arrOptions['added_by'] = $this->loggedInUserId();
				$arrInventory = $objInvModel->getInventory($arrOptions);

				foreach ( $arrInventory AS $arrInv ) {
					$arrInv->ADDED_ON = $this->revDateTime($arrInv->ADDED_ON);
					switch( $arrInv->IMEI_STATUS ) {
						case "CHECKED_IN" : $arrInv->IMEI_STATUS = "Checked In"; break;
						case "SHIPPED_IN" : $arrInv->IMEI_STATUS = "Shipped"; break;
                        case "RECEIVE" : $arrInv->IMEI_STATUS = "Checked In"; break;
					}

					if( $arrInv->IMEI_STATUS == 'SHIPPED [R]'){
                        $arrLPO = $objInvModel->getPOPONUM( $this->loggedInUserId() );
                        $arrInv->PO_NUMBER = $arrLPO->PO_NUMBER;
                    }

					if( $arrInv->PO_NUMBER == '' ) {
					    // GET the latest pO number from inventory instead inv_po
                        $arrLPO = $objInvModel->getPONumber($arrInv->IMEI);
                        $arrInv->PO_NUMBER = $arrLPO->PO_NUMBER;
                    }
				}
				require VIEW_PATH . 'inventory/poinv.php';
			} else {

				$arrOptions['ponumber'] = $_POST['ponumber'];
				$arrOptions['q_status'] = $_POST['q_status'];
				$arrOptions['user_id'] = $this->loggedInUserId();
				//$arrInventory = $objInvModel->getPO($arrOptions);
				$arrInventory = $objInvModel->getInventory($arrOptions);
				//print_r( $arrInventory );

				foreach ( $arrInventory AS $arrInv ) {
					$arrInv->ADDED_ON = $this->revDateTime($arrInv->ADDED_ON);
					$arrInv->MODIFIED_ON = $this->revDateTime($arrInv->MODIFIED_ON);
					$arrInv->LOG = $this->getIMEILog( $objLogModel, $arrInv->IMEI );
					switch( $arrInv->IMEI_STATUS ) {
						case "CHECKED_IN" : $arrInv->IMEI_STATUS = "Checked In"; break;
						case "SHIPPED_IN" : $arrInv->IMEI_STATUS = "Shipped"; break;
						case "RECEIVE" : $arrInv->IMEI_STATUS = "Checked In"; break;
					}

                    /*if( $arrInv->IMEI_STATUS == 'SHIPPED [R]'){
                        $arrLPO = $objInvModel->getPOPONUM( $this->loggedInUserId() );
                        $arrInv->PO_NUMBER = $arrLPO->PO_NUMBER;
                    }*/

                    if( $arrInv->PO_NUMBER == '' ) {
                        // GET the latest pO number from inventory instead inv_po
                        $arrLPO = $objInvModel->getPONumber($arrInv->IMEI);
                        $arrInv->PO_NUMBER = $arrLPO->PO_NUMBER;
                    }
				}
                $bShowShippin = true;
                if( $this->getLoggedUserRoleID() == MANAGER ){
                    $bShowShippin = false;
                }

                $bShowAssign = false;
                if( $this->getLoggedUserRoleID() >= SUBCONTRACTOR ){
                    $bShowAssign = true;
                }

				require VIEW_PATH . 'inventory/index.php';
			}

			require VIEW_PATH . '_templates/footer.php';
		}

		public function getIMEILog( $objLogModel, $strIMEI) {
            $arrLog = $objLogModel->getLog( $strIMEI );
            $strLog = '<ul>';
            /*for( $i=0; $i< count( $arrLog ); $i++ ){
                $strLog .= "<li>" . $arrLog[$i]->DESCRIPTION . " </li>";
            }*/
            $strLog .= "<li>" . $arrLog->DESCRIPTION . " with PO Number - <span style='font-size:10px'> " . $arrLog->PO_NUMBER . " </span> </li>";
            $strLog .= '</ul>';
            return $strLog;
        }

        public function returnItem() {
            require VIEW_PATH . '_templates/header.php';
            $objCompanyModel = $this->loadModel('company');
            $iRoleId = $this->getLoggedUserRoleID();
            $arrObjSUsers = $objCompanyModel->getUserSubContractor($this->loggedInUserId());
            $arrObjCUsers = $objCompanyModel->getUserDirector($this->loggedInUserId());
            require VIEW_PATH . 'inventory/return.php';
            require VIEW_PATH . '_templates/footer.php';
        }

		public function checkin(){
			require VIEW_PATH . '_templates/header.php';
            $iRoleId = $this->getLoggedUserRoleID();
			require VIEW_PATH . 'inventory/checkin.php';
			require VIEW_PATH . '_templates/footer.php';
		}

        public function receive(){
            require VIEW_PATH . '_templates/header.php';
            require VIEW_PATH . 'inventory/receive.php';
            require VIEW_PATH . '_templates/footer.php';
        }

		public function shipping(){
			require VIEW_PATH . '_templates/header.php';
			$objCompanyModel = $this->loadModel('company');
			$bSubC = $_SESSION['HAS_SCS'];

            if( $bSubC ) {
			    if( $this->getLoggedUserRole() == 'DIRECTOR' ){
			        $bSubC = 1;
                } else {
                    $bSubC = 0;
                }
            }

			if( $bSubC ) { // only for directors and above
				$arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);
			} else { // for below directors level.
				$objLocModel = $this->loadModel('location');
				//$arrObjCMUsers = $objCompanyModel->getCompanyUsers('MANAGER', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);
				$arrObjLocation = $objLocModel->getLocationByUserId($this->loggedInUserId(), $this->getLoggedUserRole(), 'shipping');
			}
			require VIEW_PATH . 'inventory/shipping.php';
			require VIEW_PATH . '_templates/footer.php';
		}

        public function assign(){
            require VIEW_PATH . '_templates/header.php';
            $objCompanyModel = $this->loadModel('company');
            $bSubC = $_SESSION['HAS_SCS'];

            if( $bSubC ) {
                if( $this->getLoggedUserRole() == 'DIRECTOR' ){
                    $bSubC = 1;
                } else {
                    $bSubC = 0;
                }
            }

            if( $bSubC ) { // only for directors and above
                $arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);
            } else { // for below directors level.
                $objLocModel = $this->loadModel('location');
                $arrL = $objCompanyModel->getManagerLocation($this->loggedInUserId());
                if( $this->getLoggedUserRoleID() == MANAGER ) {
                    // get Agents.
                    $strSelTxt = "Select Agent";
                    $objAgentModel = $this->loadModel('agents');
                    $arrOptions['location'] = $arrL->ID;
                    $arrObj = $objAgentModel->getAgents( $arrOptions );
                    for( $i=0; $i < count($arrObj); $i++ ) {
                        $arrObj[$i]->NAME = $arrObj[$i]->FIRST_NAME . " " . $arrObj[$i]->FIRST_NAME;
                        $arrObj[$i]->ID = $arrObj[$i]->USER_ID;
                    }
                } else {
                    $strSelTxt = "Select Location";
                    $arrObj = $objLocModel->getLocationByUserId($this->loggedInUserId(), $this->getLoggedUserRole(), 'assign');
                }

            }

            require VIEW_PATH . 'inventory/assign.php';
            require VIEW_PATH . '_templates/footer.php';
        }


	}