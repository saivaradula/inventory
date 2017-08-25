<?php
	ob_start();
	ini_set('display_errors', 0);

	class Users extends Controller {

		public function logout() {
			session_destroy();
			header("Location: /home");
			exit;
		}

		private function classifyStatus( $arrAgents ) {
			foreach( $arrAgents AS $arrAgent ){
				switch( $arrAgent->Q_STATUS ) {
					case "NOT_QUALIFIED" : {$arrAgent->Q_STATUS = 'Not Qualified'; break;}
					case "QUALIFIED" : {$arrAgent->Q_STATUS = 'Active'; break;}
					case "PENDING" : {$arrAgent->Q_STATUS = 'Pending'; break;}
				}
			}
			return $arrAgents;
		}

		public function location() {
			require VIEW_PATH . '_templates/header.php';

			if( !$this->isAllowedModule('LOC') ){
				require VIEW_PATH . '_templates/noaccess.php';
			}

			$bSubCShow = false;
            if($this->getLoggedUserRoleID() == SUPERADMIN ){$bSubCShow = true;} else {
                if( $_SESSION['HAS_SCS'] ){
                    if( $this->getLoggedUserRole() == 'DIRECTOR' ){
                        $bSubCShow = true;
                    }
                }
            }

			$objLocationModel = $this->loadModel('location');
			$objCompanyModel = $this->loadModel('company');
            $objUserModel = $this->loadModel('users');
			$arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(),
                    $this->loggedInUserId(), $arrOptions);

			if( $_POST['location_id'] != '' ){
				$arrPost = $this->validateUserInput($_POST);
				$arrPost['director'] = $this->loggedInUserId();
				//$arrPost['subc'] = $_POST['subc'];
				$arrPost['address'] = $_POST['address_1'] . " " . $_POST['address_1'] . " " . $_POST['zipcode'];
				//$arrPost['manager'] = 0;
                $arrPost['is_self'] = ( $_POST['is_self'] == 'on') ? 1: 0;
				$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();



                switch ($this->getLoggedUserRole()) {

                    case "SUPERADMIN" : {
                        $arrCD = $objCompanyModel->getCompanyDirector( $arrPost['company']);
                        $arrPost['director'] = $arrCD->USER_ID;
                        $arrPost['subc'] = $_POST['subc'];
                        break;
                    }

                    case "DIRECTOR" : {
                        $arrPost['director'] = $this->loggedInUserId();
                        $arrPost['subc'] = $_POST['subc'];
                        break;
                    }

                    case "SUB CONTRACTOR" : {
                        $arrPost['subc'] = $this->loggedInUserId();
                        $arrD = $objUserModel->getUserDetailsByUserId( $this->loggedInUserId() );
                        $arrPost['director'] = $arrD->PARENT;
                        break;
                    }
                }

				$objLocationModel->updateLocation( $arrPost );
				header("Location:" . URL . "users/location/");
			} else {
				if( $_POST['locname'] != '' ) {
					$arrPost = $this->validateUserInput($_POST);

					switch ($this->getLoggedUserRole()) {

                        case "SUPERADMIN" : {
                            $arrCD = $objCompanyModel->getCompanyDirector( $arrPost['company']);
                            $arrPost['director'] = $arrCD->USER_ID;
                            $arrPost['subc'] = $_POST['subc'];
                            break;
                        }

                        case "DIRECTOR" : {
                            $arrPost['director'] = $this->loggedInUserId();
                            $arrPost['subc'] = $_POST['subc'];
                            break;
                        }

                        case "SUB CONTRACTOR" : {
                            $arrPost['subc'] = $this->loggedInUserId();
                            $arrD = $objUserModel->getUserDetailsByUserId( $this->loggedInUserId() );

                            $arrPost['director'] = $arrD->PARENT;
                            break;
                        }
                    }
					//$arrPost['director'] = $this->loggedInUserId();

					$arrPost['manager'] = 0;
                    $arrPost['address'] = $_POST['address_1'] . " " . $_POST['address_1'] . " " . $_POST['zipcode'];
                    $arrPost['is_self'] = ( $_POST['is_self'] == 'on') ? 1: 0;
					$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();
					$arrPost['ADDED_BY'] = $this->loggedInUserId();
					$arrPost['ADDED_ON'] = $this->now();
					$objLocationModel->addLocation( $arrPost );
					header("Location:" . URL . "users/location/");
				}
			}


			switch( $this->getParameters() ){
				case "getLocationManager" : {
					$arrManager = $objLocationModel->getLocationManager($this->getParameters(2));
					echo $arrManager['MANAGER_NAME'];
					break;
				}
				case "add" : {
                    $iAdmin = 0;
                    if($this->getLoggedUserRoleID() == SUPERADMIN ){$iAdmin = 1;}
                    $arrObjC = $objCompanyModel->getCompanies('COMPANY');
					require VIEW_PATH . 'users/addlocation.php';
					break;
				}

				case "edit" : {
					$arrLoc = $objLocationModel->getLocation($this->getParameters(2));
					require VIEW_PATH . 'users/addlocation.php';
					break;
				}

				case "view" : {
					$arrLoc = $objLocationModel->getLocation($this->getParameters(2));
					require VIEW_PATH . 'users/viewlocation.php';
					break;
				}

				case "delete" : {
					$arrLoc = $objLocationModel->deleteLocation($this->getParameters(2));
					header("Location:" . URL . "users/location/");
					break;
				}

				default: {
                    $iAdmin = 0;
				    if( $this->getLoggedUserRoleID() == SUPERADMIN ) {
                        $arrLocations = $objLocationModel->getLocationsList( $this->getLoggedInUserCompanyID(),
                            -1, $this->loggedInUserId(), $this->getLoggedUserRoleID() );
                        $iAdmin = 1 ;
                    } else {
                        $arrLocations = $objLocationModel->getLocationsList( $this->getLoggedInUserCompanyID(),
                            $_SESSION['HAS_SCS'], $this->loggedInUserId(), $this->getLoggedUserRoleID() );
                    }

					require VIEW_PATH . 'users/location.php';
					break;
				}
			}
			require VIEW_PATH . '_templates/footer.php';
		}

		public function staff(){
			require VIEW_PATH . '_templates/header.php';
			$strType = "Staff";
            $iDisplayAddress = 1;
			$objUserModel = $this->loadModel('users');
			$objCompanyModel = $this->loadModel('company');
			$arrObjC = $objCompanyModel->getCompanies('COMPANY', $this->getLoggedInUserCompanyID());

            if($this->getLoggedUserRoleID() == SUPERADMIN ){$bSubCShow = true;} else {
                if( $_SESSION['HAS_SCS'] ){
                    if( $this->getLoggedUserRole() == 'DIRECTOR' ){
                        $bSubCShow = true;
                    }
                }
            }
            if( $this->isSuperAdmin() ){
                $bShowCmpny = true;
            }

			switch( $this->getParameters() ){

				case "delete" : {
					$objCompanyModel->actDeleteCUser( $this->getParameters(2) );
					header("Location:" . URL . "users/staff/");
					break;
				}

				case "view" : {
					$arrUser = $objCompanyModel->getCUserDetails( $this->getParameters(2) );
					require VIEW_PATH . 'users/view.php';
					break;
				}

				case "add" : {
					require VIEW_PATH . 'users/index.php';
					require VIEW_PATH . 'users/add.php';
					break;
				}

				case "edit" : {
					if($_POST['user_id'] != ''){
						$iUserId = $_POST['user_id'];
						$arrPost = $_POST;
						$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();
						$objCompanyModel->updateCUser( $arrPost );
						header('Location:' . URL . 'users/staff'); exit;
					} else {
						$iUserId = $this->getParameters(2);
					}
					$arrUser = $objCompanyModel->getCUserDetails( $iUserId );
					require VIEW_PATH . 'users/index.php';
					require VIEW_PATH . 'users/edit.php';
					break;
					break;
				}

				default : {
				if( $_POST['name'] != '' ){
					$arrPost = $_POST;
					$arrPost['added_on'] = $this->now();
					$arrPost['added_by'] = $this->loggedInUserId();
					$arrPost['parent'] = $this->loggedInUserId();
					$arrPost['pre_fix'] = "STF";
					$arrPost['role_name'] = 'STAFF';
					$arrPost['role_id'] = STAFF;
					$arrPost['user_id'] = date('Ymdhis');
					$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();
					$objCompanyModel->addCompanyUser($this->validateUserInput($arrPost));
					header("Location: /users/staff");
				}
				$arrOptions['q_company'] = $_POST['q_company'];
				$arrObjCUsers = $objCompanyModel->getCompanyUsers('STAFF', $this->getLoggedInUserCompanyID(),
                    $this->loggedInUserId(), $arrOptions);
				require VIEW_PATH . 'users/list.php';
				break;
				}
			}
			require VIEW_PATH . '_templates/footer.php';
		}

		public function employee(){
			require VIEW_PATH . '_templates/header.php';

			if( !$this->isAllowedModule('EMP') ){
				require VIEW_PATH . '_templates/noaccess.php';
			}

			$objUserModel = $this->loadModel('users');
			$objCompanyModel = $this->loadModel('company');
			$strType = "Employee";
            $iDisplayAddress = 1;
			$arrObjC = $objCompanyModel->getCompanies('COMPANY', $this->getLoggedInUserCompanyID());
			$bShowCmpny = false;
			if( $this->isSuperAdmin() ){
				$bShowCmpny = true;
			}


			switch( $this->getParameters() ){

				case "delete" : {
					$objCompanyModel->actDeleteCUser( $this->getParameters(2) );
					header("Location:" . URL . "users/employee/");
					break;
				}

				case "view" : {
					$arrUser = $objCompanyModel->getCUserDetails( $this->getParameters(2) );
                    $arrUser->DOB = $this->revDate( $arrUser->DOB );
					require VIEW_PATH . 'users/view.php';
					break;
				}
				case "add" : {
					if( $_POST['name'] != '' ){
						$arrPost = $_POST;
						$arrPost['added_on'] = $this->now();
						$arrPost['added_by'] = $this->loggedInUserId();
						$arrPost['pre_fix'] = "EMP";
						$arrPost['role_name'] = 'EMPLOYEE';
						$arrPost['role_id'] = EMPLOYEE;
						$arrPost['user_id'] = date('Ymdhis');
						$objCompanyModel->addCompanyUser($this->validateUserInput($arrPost));

						header("Location:" . URL . "users/employee/");
					}

					require VIEW_PATH . 'users/index.php';
					require VIEW_PATH . 'users/add.php';
					break;
				}

				case "edit" : {
					if($_POST['user_id'] != ''){
						$iUserId = $_POST['user_id'];
						$arrPost = $_POST;
						$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();
						$objCompanyModel->updateCUser( $arrPost );
						header('Location:' . URL . 'users/employee'); exit;
					} else {
						$iUserId = $this->getParameters(2);
					}
					$arrUser = $objCompanyModel->getCUserDetails( $iUserId );
					require VIEW_PATH . 'users/index.php';
					require VIEW_PATH . 'users/edit.php';
					break;
				}

				default : {

				if( $_POST['name'] != '' ){
					$arrPost = $_POST;
					$arrPost['added_on'] = $this->now();
					$arrPost['added_by'] = $this->loggedInUserId();
					$arrPost['pre_fix'] = "EMP";
					$arrPost['role_name'] = 'EMPLOYEE';
					$arrPost['role_id'] = EMPLOYEE;
					$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();
					$arrPost['user_id'] = date('Ymdhis');
					$objCompanyModel->addCompanyUser($this->validateUserInput($arrPost));
					sleep ( 2 );
					header("Location:" . URL . "users/employee/");
				}

				$arrOptions['q_company'] = $_POST['q_company'];
				$arrObjCUsers = $objCompanyModel->getCompanyUsers('EMPLOYEE', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);
				require VIEW_PATH . 'users/list.php';
				break;
				}
			}
			require VIEW_PATH . '_templates/footer.php';
		}

		public function manager(){
			require VIEW_PATH . '_templates/header.php';

			if( !$this->isAllowedModule('MGR') ){
				require VIEW_PATH . '_templates/noaccess.php';
			}

			$objUserModel = $this->loadModel('users');
			$objCompanyModel = $this->loadModel('company');
			$objLocationModel = $this->loadModel('location');

			$strType = "Manager";
            $iDisplayAddress = 1;
            $bShowCmpny = false;
			$arrObjC = $objCompanyModel->getCompanies('COMPANY', $this->getLoggedInUserCompanyID());
			$arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(),
                $this->loggedInUserId(), $arrOptions);
			//$arrLocations = $objLocationModel->getLocationsList( $this->getLoggedInUserCompanyID(), $_SESSION['HAS_SCS'], 0 , $this->getLoggedUserRoleID());
			$arrLocations = $objLocationModel->getLocationsList( $this->getLoggedInUserCompanyID(),
                $_SESSION['HAS_SCS'], $this->loggedInUserId(), $this->getLoggedUserRoleID() );

			$bSubCShow = false;

            if($this->getLoggedUserRoleID() == SUPERADMIN ){$bSubCShow = true;} else {
                if( $_SESSION['HAS_SCS'] ){
                    if( $this->getLoggedUserRole() == 'DIRECTOR' ){
                        $bSubCShow = true;
                    }
                }
            }


            if( $this->isSuperAdmin() ){
                $bShowCmpny = true;
            }

			switch( $this->getParameters() ){

				case "delete" : {
					$objCompanyModel->actDeleteCUser( $this->getParameters(2) );
					header("Location:" . URL . "users/manager/");
					break;
				}

				case "view" : {
					$arrUser = $objCompanyModel->getCUserDetails( $this->getParameters(2) );
					$arrL = $objCompanyModel->getManagerLocation( $this->getParameters(2) );
					$arrUser->LOCNAME = $arrL->NAME;
					$arrUser->DOB = $this->revDate( $arrUser->DOB );
					$arrUser->LOCSUBCONTRACTOR = $arrL->SUBNAME;
					$arrUser->LOCID = $arrL->ID;
					require VIEW_PATH . 'users/view.php';
					break;
				}
				case "add" : {
					require VIEW_PATH . 'users/index.php';
					require VIEW_PATH . 'users/add.php';
					break;
				}

				case "edit" : {
					if($_POST['user_id'] != ''){
						$iUserId = $_POST['user_id'];
						$arrPost = $_POST;
                        $arrPost['dob'] = $this->swapDate($arrPost['dob']);
						$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();
						$objCompanyModel->updateCUser( $arrPost );
						header('Location:' . URL . 'users/manager'); exit;
					} else {
						$iUserId = $this->getParameters(2);
					}
					$arrUser = $objCompanyModel->getCUserDetails( $iUserId );
                    $arrUser->DOB  = $this->revDate( $arrUser->DOB  );

					$arrL = $objCompanyModel->getManagerLocation( $iUserId );

					  $arrUser->LOCNAME = $arrL->NAME;
					  $arrUser->LOCSUBCONTRACTOR = $arrL->SUBCONTRACTOR;
					  $arrUser->LOCID = $arrL->ID;

					require VIEW_PATH . 'users/index.php';
					require VIEW_PATH . 'users/edit.php';
					break;
				}

				default : {

				if( $_POST['name'] != '' ){
					$arrPost = $_POST;
                    $arrPost['dob'] = $this->swapDate($arrPost['dob']);
					$arrPost['added_on'] = $this->now();
					$arrPost['added_by'] = $this->loggedInUserId();
					$arrPost['parent'] = $this->loggedInUserId();
					$arrPost['pre_fix'] = "MGR";
					$arrPost['role_name'] = 'MANAGER';
					$arrPost['role_id'] = MANAGER;
					$arrPost['user_id'] = date('Ymdhis');
					$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();
					$arrPost['location'] = $_POST['location'];
					if( $this->getLoggedUserRoleID() == SUBCONTRACTOR ){
                        $arrPost['subcontractor'] = $this->loggedInUserId();
                    } else {
                        $arrPost['subcontractor'] = $_POST['subc'];
                    }
					$objCompanyModel->addCompanyUser($this->validateUserInput($arrPost));
					header("Location:" . URL . "users/manager/");
				}
				$arrOptions['q_company'] = $_POST['q_company'];
				if( $this->getLoggedUserRoleID() == SUBCONTRACTOR ){
                    $arrOptions['subc'] = $this->loggedInUserId();
                }

                if( $this->isSuperAdmin() ){
                    $arrObjCUsers = $objCompanyModel->getCompanyUsers('MANAGER', $this->getLoggedInUserCompanyID(),
                        0, $arrOptions);
                } else {
                    $arrObjCUsers = $objCompanyModel->getCompanyUsers('MANAGER', $this->getLoggedInUserCompanyID(),
                        $this->loggedInUserId(), $arrOptions);
                }

				require VIEW_PATH . 'users/list.php';
				break;
				}
			}
			require VIEW_PATH . '_templates/footer.php';
		}

		public function director(){
			require VIEW_PATH . '_templates/header.php';

			if( !$this->isAllowedModule('DIR') ){
				require VIEW_PATH . '_templates/noaccess.php';
			}

			$objUserModel = $this->loadModel('users');
			$objCompanyModel = $this->loadModel('company');
			$strType = "Director";
            $iDisplayAddress = 1;
			$arrObjC = $objCompanyModel->getCompanies('COMPANY', $this->getLoggedInUserCompanyID());
			$bShowCmpny = false;
			if( $this->isSuperAdmin() ){
				$bShowCmpny = true;
			}

			switch( $this->getParameters() ){

				case "delete" : {
					$objCompanyModel->actDeleteCUser( $this->getParameters(2) );
					header("Location:" . URL . "users/director/");
					break;
				}

				case "view" : {
					$arrUser = $objCompanyModel->getCUserDetails( $this->getParameters(2) );
                    $arrUser->DOB = $this->revDate( $arrUser->DOB );
					require VIEW_PATH . 'users/view.php';
					break;
				}
				case "add" : {
					if( $_POST['name'] != '' ){
						$arrPost = $_POST;
						$arrPost['added_on'] = $this->now();
						$arrPost['added_by'] = $this->loggedInUserId();
						$arrPost['pre_fix'] = "DIR";
						$arrPost['role_name'] = 'DIRECTOR';
						$arrPost['role_id'] = DIRECTOR;
						$arrPost['user_id'] = date('Ymdhis');
						$objCompanyModel->addCompanyUser($this->validateUserInput($arrPost));
						header("Location:" . URL . "users/director/");
					}
					require VIEW_PATH . 'users/index.php';
					require VIEW_PATH . 'users/add.php';
					break;
				}

				case "edit" : {
					if($_POST['user_id'] != ''){
						$iUserId = $_POST['user_id'];
						$arrPost = $_POST;
						$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();
						$objCompanyModel->updateCUser( $arrPost );
						header('Location:' . URL . 'users/director'); exit;
					} else {
						$iUserId = $this->getParameters(2);
					}
					$arrUser = $objCompanyModel->getCUserDetails( $iUserId );
                    $arrUser->DOB  = $this->revDate( $arrUser->DOB  );
					require VIEW_PATH . 'users/index.php';
					require VIEW_PATH . 'users/edit.php';
					break;
				}

				default : {

					if( $_POST['name'] != '' ){
						$arrPost = $_POST;
                        $arrPost['dob'] = $this->swapDate($arrPost['dob']);
						$arrPost['added_on'] = $this->now();
						$arrPost['added_by'] = $this->loggedInUserId();
						$arrPost['parent'] = $this->loggedInUserId();
						$arrPost['pre_fix'] = "DIR";
						$arrPost['role_name'] = 'DIRECTOR';
						$arrPost['role_id'] = DIRECTOR;
						$arrPost['user_id'] = date('Ymdhis');
						$objCompanyModel->addCompanyUser($this->validateUserInput($arrPost));
						sleep ( 2 );
						header("Location:" . URL . "users/director/");
					}

					$arrOptions['q_company'] = $_POST['q_company'];
					$arrObjCUsers = $objCompanyModel->getCompanyUsers('DIRECTOR', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);
					require VIEW_PATH . 'users/list.php';
					break;
				}
			}
			require VIEW_PATH . '_templates/footer.php';
		}

		public function subcontractor(){
			require VIEW_PATH . '_templates/header.php';
			$strType = "Sub Contractor";
			$iDisplayAddress = 0;
			$objUserModel = $this->loadModel('users');
			$objCompanyModel = $this->loadModel('company');
			$arrObjC = $objCompanyModel->getCompanies('COMPANY', $this->getLoggedInUserCompanyID(), 1);
			$bShowCmpny = false;

			if( $this->isSuperAdmin() ){
				$bShowCmpny = true;
			}
			switch( $this->getParameters() ){

				case "delete" : {
					$objCompanyModel->actDeleteCUser( $this->getParameters(2) );
					header("Location:" . URL . "users/subcontractor/");
					break;
				}

				case "view" : {
					$arrUser = $objCompanyModel->getCUserDetails( $this->getParameters(2) );
                    $arrUser->DOB = $this->revDate( $arrUser->DOB );
					require VIEW_PATH . 'users/view.php';
					break;
				}

				case "add" : {

					require VIEW_PATH . 'users/index.php';
					require VIEW_PATH . 'users/add.php';
					break;
				}

				case "edit" : {
					if($_POST['user_id'] != ''){
						$arrPost = $_POST;
                        $arrPost['dob'] = $this->swapDate($arrPost['dob']);
						$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();
						$objCompanyModel->updateCUser( $arrPost );
						header('Location:' . URL . 'users/sub contractor'); exit;
					} else {
						$iUserId = $this->getParameters(2);
					}
					$arrUser = $objCompanyModel->getCUserDetails( $iUserId );
                    $arrUser->DOB  = $this->revDate( $arrUser->DOB  );
					require VIEW_PATH . 'users/index.php';
					require VIEW_PATH . 'users/edit.php';
					break;
					break;
				}

				default : {
					if( $_POST['name'] != '' ){
						$arrPost = $_POST;
                        $arrPost['dob'] = $this->swapDate($arrPost['dob']);

						$arrPost['added_on'] = $this->now();
						$arrPost['added_by'] = $this->loggedInUserId();
						$arrPost['parent'] = $this->loggedInUserId();
						$arrPost['pre_fix'] = "SBC";
						$arrPost['role_name'] = 'SUB CONTRACTOR';
						$arrPost['role_id'] = SUBCONTRACTOR;
						$arrPost['user_id'] = date('Ymdhis');
						$arrPost['company'] = ( $_POST['company'] != '' ) ? $_POST['company'] : $this->getLoggedInUserCompanyID();
                        if( $this->isSuperAdmin() ){
                            $arrDir = $objCompanyModel->getCompanyUsers('DIRECTOR', $this->getLoggedInUserCompanyID() );
                            $arrPost['parent'] = $arrDir[0]->USER_ID;
                        }
						$objCompanyModel->addCompanyUser($this->validateUserInput($arrPost));
						header("Location: /users/subcontractor");
					}
					$arrOptions['q_company'] = $_POST['q_company'];
                    if( $this->isSuperAdmin() ){
                        $arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(),
                            0, $arrOptions);
                    } else {
                        $arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(),
                            $this->loggedInUserId(), $arrOptions);
                    }

					require VIEW_PATH . 'users/list.php';
				break;
				}
			}
			require VIEW_PATH . '_templates/footer.php';
		}

		public function agent(){
		    //ini_set('display_errors', 1 );
			require VIEW_PATH . '_templates/header.php';
			$objAgentsModel = $this->loadModel('agents');
			$objCompanyModel = $this->loadModel('company');
            $objLocationModel = $this->loadModel('location');
			$arrObjC = $objCompanyModel->getCompanies('COMPANY', $this->getLoggedInUserCompanyID());
			switch(  $this->getParameters() ){

				case "edit": {

					if( $_POST['userid'] ){

						$arrPost = $this->validateUserInput($_POST);
						switch ($arrPost['qstatus']) {
                            case "PENDING" : $arrPost['status_id'] = 0; break;
                            case "QUALIFIED" : $arrPost['status_id'] = 1; break;
                            case "NOT_QUALIFIED" : $arrPost['status_id'] = -1; break;
                        }

						$arrPost['batchdate'] = $this->swapDate($arrPost['batchdate']);


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

                        $arrPost['subc'] = $arrPost['subc'];


						$objAgentsModel->updateAgent( $arrPost );
						header("Location: /users/agent");

					}

                    $iRole = $this->getLoggedUserRoleID();

					$arrAgent = $objAgentsModel->getAgent($this->getParameters(2));
					$arrAgent->BATCH_DATE  = $this->revDate( $arrAgent->BATCH_DATE  );
                    $shwLocation = 0;

					if( $this->getLoggedUserRoleID() == EMPLOYEE ){
					    $shwLocation = 1;
                        $iCompany = $this->getLoggedInUserCompanyID();
                        $arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);
                        $arrLocations = $objLocationModel->getLocationsList( $this->getLoggedInUserCompanyID(),
                            $_SESSION['HAS_SCS'], $this->loggedInUserId(), $this->getLoggedUserRoleID() );

                    }
					require VIEW_PATH . 'users/editagent.php';

					break;
				}

				case "sendemail" : {
					$strMsg = '';
					if( $_POST['email'] ){
						$arrPost = $this->validateUserInput($_POST);
						$arrPost['parent'] = $this->getLoggedInUserCompanyID();
						$arrPost['createdon'] = $this->now();
						$arrPost['createdby'] = $this->loggedInUserId();
						$arrPost['userid'] = date('Ymdhis') ;
						$arrPost['action'] = "SELF" ;
						$objAgentsModel->addAgents($arrPost);
						include EMAIL_TEMPLATES;
						$arrOptions['emailid'] = $_POST['email'];
						$arrOptions['subject'] = ADDAGENT_EMAIL_SUBJECT;
						$bIsEmailSent = $this->sendEmail($arrOptions['emailid'], ADDAGENT_TEMPLATE );
						if( $bIsEmailSent ){
							$strMsg = "Email sent to " . $_POST['email'] . " Successfully";
						} else {
							$strMsg = "Could not send email to " . $_POST['email'] . ". Please check with Email Configuration Server";
							$objAgentsModel->deleteAgentRecord($arrPost['userid']);
						}
					}

					$arrOptions['company'] = $this->getLoggedInUserCompanyID();
					$arrOptions['created'] =  $this->loggedInUserId();
					$arrOptions['action'] =  "SELF";
					$arrAgents = $objAgentsModel->getAgents($arrOptions);
					$arrAgents = $this->classifyStatus( $arrAgents );
					require VIEW_PATH . 'users/sendemail.php';
					break;
				}

				case "view" : {
					$arrAgent = $objAgentsModel->getAgent($this->getParameters(2));
					require VIEW_PATH . 'users/viewagent.php';
					break;
				}

				case "delete" : {
					$objAgentsModel->deleteAgentRecord( $this->getParameters(2) );
					header("Location:" . URL . "users/agent/");
					break;
				}

				case "add" : {

					$strRole = $this->getLoggedUserRole();
					$iRole = $this->getLoggedUserRoleID();
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
                        //$objLocModel = $this->loadModel('location');
                        if( $this->getLoggedUserRoleID() == MANAGER ) {
                            $arrL = $objCompanyModel->getManagerLocation($this->loggedInUserId());
                            //print_r( $arrL );
                        } else {
                            $strSelTxt = "Select Location";
                            $arrObj = $objLocationModel->getLocationsList( $this->getLoggedInUserCompanyID(), $bSubC);
                            //print_r( $arrObj );
                        }

                    }

					require VIEW_PATH . 'users/addagent.php';
					break;
				}

				case "filter" : {
					$arrOptions = $_POST;
					$arrOptions['company'] = $this->getLoggedInUserCompanyID();
					$arrOptions['created'] =  $this->loggedInUserId();
					$arrAgents = $objAgentsModel->getAgents( $arrOptions );
					$strF = ( $_POST['q_status'] != '' ) ? " Status" : "";
					$strF .= ( $_POST['agent_type'] != '' ) ? ( $strF != '' ) ? ", Role" : "Role" : "";
					$strF = "( Filtered By " . $strF . " )";
					$arrAgents = $objAgentsModel->getAgents( $arrOptions );
					$arrAgents = $this->classifyStatus( $arrAgents );
					require VIEW_PATH . '/users/agents.php';
					break;
				}

				default : {

					if( $_POST['firstname'] != '' ){
						$arrPost = $this->validateUserInput($_POST);
						if( $this->isSuperAdmin() ) {
							$arrPost['parent'] = $arrPost['company'];
							$arrPost['subc'] = $arrPost['subc'];
						} else {
							$arrPost['parent'] = $this->getLoggedInUserCompanyID();
						}
                        $arrPost['location'] = $arrPost['location'];
						$arrPost['createdon'] = $this->now();
						$arrPost['createdby'] = $this->loggedInUserId();
						$arrPost['userid'] = date('Ymdhis') ;
						$arrPost['batchdate'] = $this->swapDate($arrPost['batchdate']);

						$arrPost['HEADSHOT_FILE'] = ( $_FILES['headshotfile']['name'] != '' ) ? $this->uploadDocument( $_FILES['headshotfile'], AGENTFILES, $_POST['lastname'] . "_HSF" ) : "";
						$arrPost['GOVID_FILE'] = ( $_FILES['govidfile']['name'] != '' ) ? $this->uploadDocument( $_FILES['govidfile'], AGENTFILES, $_POST['lastname'] . "_GOVID" ) : "";
						$arrPost['DISCLOSURE_FILE'] = ( $_FILES['disclosurefile']['name'] != '' ) ? $this->uploadDocument( $_FILES['disclosurefile'], AGENTFILES, $_POST['lastname'] . "_DISF" ) : "";
						$arrPost['BG_AUTH_FILE'] = ( $_FILES['bgauthfile']['name'] != '' ) ? $this->uploadDocument( $_FILES['bgauthfile'], AGENTFILES, $_POST['lastname'] . "_BG" ) : "";
						$arrPost['COMP_CERT_FILE'] = ( $_FILES['compcertfile']['name'] != '' ) ? $this->uploadDocument( $_FILES['compcertfile'], AGENTFILES, $_POST['lastname'] . "_COMP" ) : "";

						$objAgentsModel->addAgents($arrPost);
						header('Location: /users/agent');

					}
                    if($this->getLoggedUserRoleID() > SUPERADMIN  ){
                        $arrOptions['company'] = $this->getLoggedInUserCompanyID();
                        //$arrOptions['created'] =  $this->loggedInUserId();
                        $arrOptions['location'] =  $_SESSION['L_ID'];
                    }

					$arrAgents = $objAgentsModel->getAgents($arrOptions);
					$arrAgents = $this->classifyStatus( $arrAgents );
					require VIEW_PATH . 'users/agents.php';
					break;
				}
			}
			require VIEW_PATH . '_templates/footer.php';
		}

	}