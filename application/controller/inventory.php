<?php
ob_start();
//ini_set('display_errors', 1 );
	class Inventory extends Controller {

        public function clean() {
            $objCleanModel = $this->loadModel('clean');
            $objCleanModel->cleanInventory();
            require VIEW_PATH . '_templates/header.php';
            $strD = "Data Cleaning Complete";
            require VIEW_PATH . 'home/index.php';
            require VIEW_PATH . '_templates/footer.php';
        }

        function removeDups($array) {
            $array_temp = array();
            $bDup = 0;
            foreach($array as $val) {
                if (!in_array($val, $array_temp)){
                    $array_temp[] = $val;
                }
            }
            return $array_temp;
        }

        function showDups($array) {
            $array_temp = array();
            $bDup = 0;
            foreach($array as $val) {
                if (!in_array($val, $array_temp)){
                    $array_temp[] = $val;
                }  else {
                    $bDup = 1;
                }
            }
            return $bDup;
        }

	    public function activation() {
            require VIEW_PATH . '_templates/header.php';
            $objInvModel = $this->loadModel('inventory');
            $objLogModel = $this->loadModel('log');
            $objAgentModel = $this->loadModel('agents');

            $strMsg = '';
            $bProceed = 0;

            if( $_POST['import'] == 1 ) {
                $bProceed = 1;

                switch ($_FILES['importeddata']['type']) {
                    case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" : {
                        break;
                    }

                    case "application/vnd.ms-excel" : {
                        break;
                    }

                    default : {
                        $strMsg = "Invalid Data File. Please upload ONLY CSV/XLS file.";
                        $bProceed = 0;
                    }
                }



                if( $_FILES['importeddata']['error'] > 0 ) {
                    $strMsg = "Error in Uploaded file. Please verify and re-upload file.";
                    $bProceed = 0;
                }

                if( $bProceed ) {
                    $tmp_name = $_FILES["importeddata"]["tmp_name"];
                    $name = basename($_FILES["importeddata"]["name"]);

                    $strType =  end( explode(".", $name));

                    if ($strType == 'csv') {
                        include 'csv_act.php';
                    } else {
                        include 'xls_act.php';
                    }


                }
            }

            $arrUnActivated = $objInvModel->getActData($this->getLoggedInUserCompanyID(), $this->loggedInUserId());

            for( $i=0; $i < count($arrUnActivated); $i++ ){
                $arrUnActivated[$i]->added_on = $this->revDateTimeWT($arrUnActivated[$i]->added_on);
            }
            require VIEW_PATH . 'inventory/activate.php';
            require VIEW_PATH . '_templates/footer.php';
        }

	    public function import() {
            require VIEW_PATH . '_templates/header.php';
            $objInvModel = $this->loadModel('inventory');
            $objLogModel = $this->loadModel('log');
            $objCompModel = $this->loadModel('company');
            $objUserModel = $this->loadModel('users');

            $strMsg = '';
            $bProceed = 0;

            if( $_POST['import'] == 1 ) {
                $bProceed = 1;



                switch ($_FILES['importeddata']['type']) {
                    case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" : {
                        break;
                    }

                    case "application/vnd.ms-excel" : {
                        break;
                    }

                    default : {
                        $strMsg = "Invalid Data File. Please upload ONLY CSV/XLS file.";
                        $bProceed = 0;
                    }
                }



                if( $_FILES['importeddata']['error'] > 0 ) {
                    $strMsg = "Error in Uploaded file. Please verify and re-upload file.";
                    $bProceed = 0;
                }

                if( $bProceed ) {
                    $tmp_name = $_FILES["importeddata"]["tmp_name"];
                    $name = basename($_FILES["importeddata"]["name"]);
                    $strType =  end( explode(".", $name));

                    if ($strType == 'csv') {
                        include 'csv_import.php';
                    } else {
                        include 'xls_import.php';
                    }

                }
            }

            require VIEW_PATH . 'inventory/import.php';
            require VIEW_PATH . '_templates/footer.php';

        }

        function addUpthisMgrIdtoHaveAcess($iUserId, $iLID, $objInvModel ) {
            # first get Inv with LID as location_id and does not have $iUserId.
            $arrInv = $objInvModel->getInvWithLidNotUserId( $iUserId, $iLID);
           // print_r( $arrInv );
            foreach ($arrInv AS $arrI ) {
                $strHA = $iUserId . " " . $arrI->HAVE_ACCESS;
                $objInvModel->updateInvAccess( $arrI->ID, $strHA);
            }
        }

        function getInvList() {

            $objInvModel = $this->loadModel('inventory');
            $objLogModel = $this->loadModel('log');
            $objCompModel = $this->loadModel('company');
            $objUserModel = $this->loadModel('users');
            $objC = new Controller();


                $strPO = $this->getParameters(0);
            $bSearch = 0;
            if( $_POST['ponumber'] != '' ){
                //  $bSearch = 1;
            }

            if( $_POST['q_status'] != '' ){
                //$bSearch = 1;
            }

            if( $_SESSION['IS_SELF'] == 1 ){
                $arrOptions['l_id'] = $_SESSION['L_ID'];
            }
            if( $bSearch ) {
                $arrOptions['ponumber'] = $_POST['ponumber'];
                $arrOptions['q_status'] = $_POST['q_status'];
                $arrInventory = $objInvModel->getInventoryBySearch($arrOptions);

                foreach ( $arrInventory AS $arrInv ) {
                    $arrInv->LOG = $this->getIMEILog( $objLogModel, $arrInv->IMEI );
                    $arrInv->ADDED_ON = $this->revDateTime($arrInv->ADDED_ON);
                    switch ($arrInv->IMEI_STATUS) {
                        case "CHECKED_IN" :
                            $arrInv->IMEI_STATUS = "Checked In";
                            break;
                        case "SHIPPED_IN" :
                            $arrInv->IMEI_STATUS = "Shipped";
                            break;
                        case "RECEIVE" :
                            $arrInv->IMEI_STATUS = "Checked In";
                            break;
                    }
                    $arrInv->PO_NUMBER = $_POST['ponumber'];
                }

            } else {
                $objLocModel = $this->loadModel('location');
                $arrOptions['user_id_s'] = '';
                $arrOptions['user_id'] = '';
                $arrOptions['ponumber'] = $_POST['ponumber'];
                $arrOptions['q_status'] = $_POST['q_status'];
                if( $_POST['shpto_manager'] != ''){

                    $arrU = $objLocModel->getLocationManager( $_POST['shpto_manager'] );
                    if( $arrU->MANAGER > 0 ){
                        $arrOptions['user_id'] = $arrU->MANAGER;
                    } else {
                        // this is for subcontractor only.
                        if($this->getLoggedUserRoleID() == SUBCONTRACTOR ) {
                            $arrU = $objLocModel->getLocationSubCnt( $_POST['shpto_manager'] );
                            if( $arrU->IS_SELF) {
                                $arrOptions['user_id_s'] = $arrU->SUBCONTRACTOR;
                            } else {
                                $arrOptions['user_id'] = -5;
                            }
                        } else {
                            $arrOptions['user_id'] = -5;
                        }
                    }
                } else {
                    if( $this->getLoggedUserRoleID() == MANAGER ) {
                       // print_r( $_SESSION );
                        if( $_SESSION['IS_SELF'] ) {
                            $arrU = $objLocModel->getLocationSubCnt( $_SESSION['L_ID'] );
                            $arrOptions['user_id_s'] = $arrU->SUBCONTRACTOR;
                        } else {
                            //$arrOptions['l_id'] = $_SESSION['L_ID'];
                            // update Inventory access field which has this L_ID as assigned to.
                            $this->addUpthisMgrIdtoHaveAcess( $this->loggedInUserId(), $_SESSION['L_ID'], $objInvModel );
                            $arrOptions['user_id'] = $this->loggedInUserId();
                        }
                        //
                    } else {
                        $arrOptions['user_id'] = $this->loggedInUserId();
                    }

                }

                $arrOptions['user_type'] = $this->getLoggedUserRole();
                //$arrInventory = $objInvModel->getPO($arrOptions);
                    $arrInventory = $objInvModel->getInventory($arrOptions);

                $arrOptions['limit_per_page'] = 10;
                $iTotalRecords = count( $arrInventory ) ;
                $iTotalPages = ceil( $iTotalRecords / $arrOptions['limit_per_page'] );

                if(!isset($_POST['page'])) {
                    $_POST['page'] = 1;
                }

                if( strlen($_POST['page'] ) == 0 ){
                    $_POST['page'] = 1;
                }

                if( $_POST['page'] <= 1 ){
                    $_POST['page'] = 1;
                    $arrOptions['low_limit'] =  ( $_POST['page'] - 1 ) * $arrOptions['limit_per_page'] ;
                } else {
                    $arrOptions['low_limit'] =  ( ( $_POST['page'] - 1 ) * $arrOptions['limit_per_page'] ) + 1;
                }

                if( $_POST['page'] > $iTotalPages ){
                    $_POST['page'] = $iTotalPages;
                }

                $arrOptions['low_limit'] =  ( $_POST['page'] - 1 ) * $arrOptions['limit_per_page'];
                $arrInventory = $objInvModel->getInventory($arrOptions);

                foreach ( $arrInventory AS $arrInv ) {
                    $arrInv->ADDED_ON = $this->revDateTime($arrInv->ADDED_ON);
                    $arrInv->MODIFIED_ON = $this->revDateTime($arrInv->MODIFIED_ON);

                    switch( $arrInv->IMEI_STATUS ) {
                        case "CHECKED_IN" : $arrInv->IMEI_STATUS = "Checked In"; break;
                        case "SHIPPED_IN" : $arrInv->IMEI_STATUS = "Shipped"; break;
                        case "RECEIVE" : $arrInv->IMEI_STATUS = "Re Checked In"; break;
                    }

                    if( $arrInv->PO_NUMBER == '' ) {
                        $arrLPO = $objInvModel->getPONumber($arrInv->IMEI);
                        $arrInv->PO_NUMBER = $arrLPO->PO_NUMBER;
                    }
                    $arrInv->LOG = $this->getIMEILog( $objLogModel, $arrInv->IMEI );
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

            require VIEW_PATH . 'inventory/inv.php';
        }

		public function index() {
            //ini_set('display_errors', 1 );

            require VIEW_PATH . '_templates/header.php';
			$objInvModel = $this->loadModel('inventory');
			$objLogModel = $this->loadModel('log');
			$objCompModel = $this->loadModel('company');
			$objUserModel = $this->loadModel('users');



			if( $_POST['action'] ){
				switch( $_POST['action'] ) {

                    case "edit" : {

                        $arrPost['IMEI'] = $_POST['imei'];
                        $arrPost['pre_imei'] = $_POST['pre_imei'];
                        $arrPost['ponumber'] = $_POST['ponumber'];
                        $arrPost['pre_po'] = $_POST['pre_po'];
                        $arrPost['id'] = $_POST['id'];

                        if( $_POST['pre_imei'] != $_POST['imei'] ) {
                            $objInvModel->updateInventoryByID( $arrPost );
                        }

                        if( $_POST['pre_po'] != $_POST['ponumber'] ) {
                            $arrPost['pre_po'] = $_POST['pre_po'];
                            $arrPost['ponumber'] = $_POST['ponumber'];
                            $objInvModel->updatePOByID( $arrPost );
                        }

                        break;
                    }

                    case "receive": {
                        $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
                        $arrIMEI = array_map('trim',$arrIMEI);
                        $arrIMEI = array_unique($arrIMEI);
                        $_POST['imei'] = $arrIMEI;
                        $arrPost['status'] = "RECEIVE";

                        if( $_POST['isM'] == 1 ){
                            //$arrPost['ponumber'] = $_POST['ponumber'];
                        } else {
                            $arrPost['ponumber'] = $_POST['ponumber'];
                        }



                        $arrPost['user_type'] = $this->getLoggedUserRole();
                        $arrPost['user_id'] = $this->loggedInUserId();
                        $arrU = $objUserModel->getUserDetailsByUserId(  $this->loggedInUserId() );
                        $arrPost['modified_on'] = $this->now();
                        $arrPost['modified_by'] = $this->loggedInUserId();
                        $arrPost['desc'] = "Received by "  . $arrU->NAME . " ( " . $arrU->ROLE_NAME . ")";
                        $arrPost[ 'assigned_to' ] = 0;

                        $iSubCntMgr = 0;
                        if($_SESSION['IS_SELF']) {
                            if($this->getLoggedUserRoleID() == MANAGER ) {
                                $iSubCntMgr = 1;
                            }
                        }

                        if($iSubCntMgr) {
                            $objLocModel = $this->loadModel('location');
                            $arrU = $objLocModel->getLocationSubCnt($_SESSION['L_ID']);
                            $strHA = $arrU->SUBCONTRACTOR;
                        } else {
                            $strHA = '';
                        }

                        for($i=0; $i < count($_POST['imei']); $i++){
                            if( $_POST['imei'][$i] != '' ) {
                                $arrC = $objInvModel->isInvenCheckedIn( $_POST['imei'][$i] );
                                $arrPost['imei'] = $_POST['imei'][$i];
                                    //$arrPost['added_on'] = $this->now();
                                    $arrPost['modified_by'] = $this->loggedInUserId();
                                    $arrPost['have_access'] = $strHA . " " . $this->loggedInUserId();
                                    $arrPost['unique'] = $arrC->UNIQUE_ID;
                                    $objInvModel->updateInventory($arrPost);
                                    $arrPost['ponumber'] = $arrC->PO_NUMBER;
                                $objLogModel->logInventory($arrPost);
                            }
                        }

                        if( $_POST['isM'] == 1 ){
                            //$arrPost['ponumber'] = $_POST['ponumber'];
                        } else {
                            $arrCOptions['ponumber'] = $_POST['ponumber'];
                            $arrCOptions['EXACT'] = true;
                            $arrGotPO = $objInvModel->getPO($arrCOptions);
                            if( count($arrGotPO) == 0 ){
                                $arrPOPost = $arrPost;
                                $arrPOPost['added_on'] = $this->now();
                                $arrPOPost['added_by'] = $this->loggedInUserId();
                                $objInvModel->addPO($arrPOPost);
                            }
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
                        $arrPost['reason'] = $_POST['reason'];
                        $arrPost['reason_small'] = $_POST['reason_small'];

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


					    $strAdditionalAcceess = '';
					    if( $this->getLoggedUserRoleID() == STAFF ){
					        // get logged in user director's id.
                            $arrR = $objCompModel->getCompanyDirector( $this->getLoggedInUserCompanyID() );
                            $strAdditionalAcceess = $arrR->USER_ID;
                        }

                        if($this->getLoggedUserRoleID() == MANAGER ) {
					        if($_SESSION['IS_SELF']) {
                                $objLocModel = $this->loadModel('location');
                                $arrU = $objLocModel->getLocationSubCnt( $_SESSION['L_ID'] );
                                $strAdditionalAcceess = $arrU->SUBCONTRACTOR;
                            }
                        }

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

                        $arrCOptions['ponumber'] = $_POST['ponumber'];
                        $arrCOptions['EXACT'] = true;
                        $arrGotPO = $objInvModel->getPO($arrCOptions);
                        if( count($arrGotPO) > 0 ){
                            $iUnique = $arrGotPO[0]->UNIQUE_ID;
                        }
						for($i=0; $i < count($_POST['imei']); $i++){
							if( $_POST['imei'][$i] != '' ) {
								$arrC = $objInvModel->isInvenCheckedIn( $_POST['imei'][$i] );
                                $arrPost['imei'] = $_POST['imei'][$i];
								if( $arrC->IMEI == $_POST['imei'][$i] ){
                                    $arrPost['unique'] = $arrC->UNIQUE_ID;
                                    //$arrPost['have_access'] = $arrC->HAVE_ACCESS . " " . $this->loggedInUserId();
                                    if( $strAdditionalAcceess != '' ){
                                        $arrPost['have_access'] = $this->loggedInUserId() . ", " . $strAdditionalAcceess;
                                    } else {
                                        $arrPost['have_access'] = $this->loggedInUserId();
                                    }

                                    $arrPost['modified_by'] = $this->loggedInUserId();
									$objInvModel->updateInventory( $arrPost );
								} else {
                                    $arrPost['added_on'] = $this->now();
                                    $arrPost['added_by'] = $this->loggedInUserId();
                                    $arrPost['modified_by'] = $this->loggedInUserId();
                                    $arrPost['unique'] = $iUnique;
                                    if( $strAdditionalAcceess != '' ){
                                        $arrPost['have_access'] = $this->loggedInUserId() . ", " . $strAdditionalAcceess;
                                    } else {
                                        $arrPost['have_access'] = $this->loggedInUserId();
                                    }
									$objInvModel->addInventory($arrPost);
								}
								$objLogModel->logInventory($arrPost);
							}
						}

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
                        //ini_set('display_errors', 1 );
                        $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
                        $arrIMEI = array_map('trim',$arrIMEI);
                        $arrIMEI = array_unique($arrIMEI);
                        $_POST['imei'] = $arrIMEI;
                        $strHvAcess = '';

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
                            /*if( $arrU->IS_SELF ) {
                                $arrPost['assigned_to'] =  $_POST['shpto_subc'];
                                $arrUSCNT = $objUserModel->getUserDetailsByUserId(  $arrPost['assigned_to'] );
                                $strHvAcess = $arrUSCNT->USER_ID;
                            }*/
                            $strHvAcess = $arrU->USER_ID;

                            $arrPost['desc'] = "Shipped to "  . $arrU->NAME;

                            if( $_POST['shpto_subc'] > 0 ){
                                $arrUS = $objUserModel->getUserDetailsByUserId(  $_POST['shpto_subc'] );
                                $strHvAcess .= " " . $arrUS->USER_ID;

                                //if( $arrU->NAME == '' ) {
                                    if( $arrU->IS_SELF ) {
                                        $arrPost['assigned_to'] =  $_POST['shpto_subc'];
                                    } else {
                                        $arrPost['desc'] = "Shipped to "  . $arrUS->NAME . " ( " . $arrUS->ROLE_NAME . ")";
                                    }
                                //}
                            }
						} else {
                            $arrPost['assigned_to'] =  $_POST['shpto_subc'];
                            $arrU = $objUserModel->getUserDetailsByUserId(  $arrPost['assigned_to'] );
                            $strHvAcess = $arrU->USER_ID;
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
                                $arrPost['have_access'] = $arrC->HAVE_ACCESS . " " . $strHvAcess;
								$arrPost['imei'] = $_POST['imei'][$i];

								$objInvModel->shipInventory($arrPost);
								$objLogModel->logInventory($arrPost);
							}
						}
						break;
					}

                    case "assign" : {
                        //ini_set('display_errors', 1 );
                        $strAddAccess = '';
                        $arrIMEI = preg_split("/\\r\\n|\\r|\\n/", $_POST['imei']);
                        $arrIMEI = array_map('trim',$arrIMEI);
                        $arrIMEI = array_unique($arrIMEI);
                        $_POST['imei'] = $arrIMEI;

                        $arrPost['status'] = "ASSIGNED";

                        if( $_POST['isM'] == 1 ){
                            //$arrPost['ponumber'] = $_POST['ponumber'];
                        } else {
                            //$arrPost['ponumber'] = date('YmdHims');
                        }
                        $arrPost['user_type'] = $this->getLoggedUserRole();
                        $arrPost['added_by'] = $this->loggedInUserId();
                        $arrPost['modified_on'] = $this->now();
                        $arrPost['assigned_to'] =  $_POST['shpto_subc'];
                        if( $_POST['shpto_manager'] != '' ) {
                            $arrPost['assigned_to'] =  $_POST['shpto_manager'];
                        }

                        if( $this->getLoggedUserRoleID() == MANAGER  || $this->getLoggedUserRoleID() == SUBCONTRACTOR ){
                            // Assigning to Agent.
                            $objAgentModel = $this->loadModel('agents');
                            $arrO['id'] = $arrPost['assigned_to'];
                            $arrU = $objAgentModel->getAgents( $arrO );
                            $arrPost['desc'] = "Assigned to Agent "  . $arrU[0]->FIRST_NAME . " " . $arrU[0]->LAST_NAME . " ( AGENT ) ";
                            $arrPost['user_id'] =  $arrPost['assigned_to'];
                            $arrPost['modified_by'] = $this->loggedInUserId();
                        } else {
                            //$arrU = $objUserModel->getUserDetailsByUserId(  $arrPost['assigned_to'] );
                            $objLocationModel = $this->loadModel('location');
                            $arrU = $objLocationModel->getLocationManager( $arrPost['assigned_to'] );
                            $strAddAccess = $arrU->MANAGER;
                            $arrPost['user_type'] = 'MANAGER';
                            $arrPost[ 'modified_on' ] = $this->now();
                            $arrPost[ 'modified_by' ] = $arrU->MANAGER;
                            $arrPost['desc'] = "Assigned to Manager - "  . $arrU->MANAGER_NAME . " ( ". $arrU->LOCATION_NAME . " ) " ;
                        }


                        //$objInvModel->addPO($arrPost);

                        for($i=0; $i < count($_POST['imei']); $i++){
                            if( $_POST['imei'][$i] != '' ) {
                                $arrPost['imei'] = $_POST['imei'][$i];
                                if( $strAddAccess != '' ) {
                                    $arr = $objInvModel->getInventoryAccess( $arrPost['imei'] );
                                    $arrPost['have_access'] = $arr->HAVE_ACCESS . ", " . $strAddAccess;
                                }
                                $objInvModel->shipInventory($arrPost);
                                $objLogModel->logInventory($arrPost);
                            }
                        }
                        break;
                    }
				}
				header("Location: /inventory");
			}
            $iLocDD = 0;
			$sm = 6;
			switch ($this->getLoggedUserRoleID()) {
                case DIRECTOR: { $sm = 7;break;}
            }
			if( $this->getLoggedUserRoleID() == SUBCONTRACTOR){
			    // get location of sub contractor.
                $iLocDD = 1;
                $objLocModel = $this->loadModel('location');
                $arrObjLocation = $objLocModel->getLocationByUserId($this->loggedInUserId(), $this->getLoggedUserRole(), 'all');
            }
            require VIEW_PATH . 'inventory/index.php';
			require VIEW_PATH . '_templates/footer.php';
		}

		public function getIMEILog( $objLogModel, $strIMEI) {
            $arrLog = $objLogModel->getLog( $strIMEI );
            $strLog = '<ul>';
            /*for( $i=0; $i< count( $arrLog ); $i++ ){
                $strLog .= "<li>" . $arrLog[$i]->DESCRIPTION . " </li>";
            }*/
            if( $arrLog->IMEI_STATUS == 'ASSIGNED'){
                $strLog .= "<li>" . $arrLog->DESCRIPTION . "</li>";
            } else {
                $strLog .= "<li>" . $arrLog->DESCRIPTION . " with PO Number - <span style='font-size:10px'> " . $arrLog->PO_NUMBER . " </span> </li>";
            }

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
            $iRoleId = $this->getLoggedUserRoleID();
            if($iRoleId == MANAGER ){
                require VIEW_PATH . 'inventory/receiveM.php';
            } else {
                require VIEW_PATH . 'inventory/receive.php';
            }

            require VIEW_PATH . '_templates/footer.php';
        }

		public function shipping(){
			require VIEW_PATH . '_templates/header.php';
            $objCompanyModel = $this->loadModel('company');
            $iAdmin = 0;
            $bSubC = $_SESSION['HAS_SCS'];

            if( $bSubC ) {
                if( $this->getLoggedUserRole() == 'DIRECTOR' ){
                    $bSubC = 1;
                } else {
                    $bSubC = 0;
                }
            }

            if ( $this->isSuperAdmin() ) {
                $iAdmin = 1;
                $bSubC = 1;
                $arrObjC = $objCompanyModel->getCompanies('COMPANY');
            }


			if( $bSubC ) { // only for directors and above
                if( $iAdmin == 0 ){
                    $arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);
                }
			} else { // for below directors level.
				$objLocModel = $this->loadModel('location');

				//$arrObjCMUsers = $objCompanyModel->getCompanyUsers('MANAGER', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);
				//$arrObjLocation = $objLocModel->getLocationByUserId($this->loggedInUserId(), $this->getLoggedUserRole(), 'shipping');

                if( $this->getLoggedUserRoleID() == SUPERADMIN ) {
                    $arrObjLocation = $objLocModel->getLocationsList( $this->getLoggedInUserCompanyID(),
                        -1, $this->loggedInUserId(), $this->getLoggedUserRoleID() );
                    $iAdmin = 1 ;
                } else {

                    $arrObjLocation = $objLocModel->getLocationByUserId($this->loggedInUserId(), $this->getLoggedUserRole(), 'shipping');
                    //$arrObjLocation = $objLocModel->getLocationsList( $this->getLoggedInUserCompanyID(),
                      //$_SESSION['HAS_SCS'], $this->loggedInUserId(), $this->getLoggedUserRoleID() );
                }

			}
			require VIEW_PATH . 'inventory/shipping.php';
			require VIEW_PATH . '_templates/footer.php';
		}

        public function assign(){
            require VIEW_PATH . '_templates/header.php';
            $objCompanyModel = $this->loadModel('company');
            $bSubC = $_SESSION['HAS_SCS'];
            $bShowLocDet = 1;
            if( $this->getLoggedUserRoleID() == MANAGER || $this->getLoggedUserRoleID() == SUBCONTRACTOR ) {
                $bShowLocDet = 0;
            }
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

                if( $this->getLoggedUserRoleID() == MANAGER ) {
                    // get Agents.
                    $arrL = $objCompanyModel->getManagerLocation($this->loggedInUserId());
                    $strSelTxt = "Select Agent";
                    $objAgentModel = $this->loadModel('agents');
                    $arrOptions['location'] = $arrL->ID;
                    $arrOptions['q_status'] = 'QUALIFIED';
                    $arrObj = $objAgentModel->getAgents( $arrOptions );
                    for( $i=0; $i < count($arrObj); $i++ ) {
                        $arrObj[$i]->NAME = $arrObj[$i]->FIRST_NAME . " " . $arrObj[$i]->LAST_NAME;
                        $arrObj[$i]->ID = $arrObj[$i]->USER_ID;
                    }
                } else {

                    $arrL = $objCompanyModel->getSubCntSelfLocation($this->loggedInUserId());
                    $strSelTxt = "Select Agent";
                    $objAgentModel = $this->loadModel('agents');
                    $arrOptions['location'] = $arrL->ID;
                    $arrOptions['q_status'] = 'QUALIFIED';
                    $arrObj = $objAgentModel->getAgents( $arrOptions );
                    for( $i=0; $i < count($arrObj); $i++ ) {
                        $arrObj[$i]->NAME = $arrObj[$i]->FIRST_NAME . " " . $arrObj[$i]->LAST_NAME;
                        $arrObj[$i]->ID = $arrObj[$i]->USER_ID;
                    }

                    /*$strSelTxt = "Select Location";
                    $arrObj = $objLocModel->getLocationByUserId($this->loggedInUserId(), $this->getLoggedUserRole(), 'assign');*/
                }

            }

            $iIsSelf = $_SESSION['IS_SELF'];

            require VIEW_PATH . 'inventory/assign.php';
            require VIEW_PATH . '_templates/footer.php';
        }

        public function edit() {
            require VIEW_PATH . '_templates/header.php';
            $invId = $this->getParameters();

            $objInvModel = $this->loadModel('inventory');
            $arrInv = $objInvModel->getInvById( $invId );

            require VIEW_PATH . 'inventory/edit.php';
            require VIEW_PATH . '_templates/footer.php';
        }

        public function deleteInv() {
            $invId = $this->getParameters();
            $objInvModel = $this->loadModel('inventory');
            $arrInv = $objInvModel->deleteInvById( $invId );
            header("Location: /inventory");
        }

	}