<?php
	class companyModel extends Model {

	    function getCompanyManagers( $iCompany ) {
            $arrData[ 'FIELDS' ] = "U.USER_ID, U.NAME ";
            $arrData[ 'TABLE' ] = COMPANY_USERS . " U";
            $arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
            $arrData[ 'WHERE' ] .= " AND U.ROLE_NAME = 'MANAGER' " ;
            $arrData[ 'WHERE' ] .= " AND U.COMPANY = '" . $iCompany . "'";
            return $this->getData($arrData);
        }

        function getCompanyLocations( $iCompany, $iSubC ) {
            $arrData[ 'FIELDS' ] = "U.ID, U.NAME, U.SUBCONTRACTOR ";
            $arrData[ 'TABLE' ] = LOCATION . " U";
            $arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
            $arrData[ 'WHERE' ] .= " AND U.COMPANY = '" . $iCompany . "'";
            $arrData[ 'WHERE' ] .= ( $iSubC > 0 ) ? " AND U.SUBCONTRACTOR = '" . $iSubC . "'" : "";
            return $this->getData($arrData, true);
        }

	    function getCompanyDirector( $iCompany ) {
            $arrData[ 'FIELDS' ] = "U.USER_ID, U.NAME ";
            $arrData[ 'TABLE' ] = COMPANY_USERS . " U";
            $arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
            $arrData[ 'WHERE' ] .= " AND U.ROLE_NAME = 'DIRECTOR' " ;
            $arrData[ 'WHERE' ] .= " AND U.COMPANY = '" . $iCompany . "'";
            return $this->getData($arrData);
        }

	    function doesCompanyHasSCS( $iCompany ) {
            $arrData[ 'FIELDS' ] = "NAME, SCS";
            $arrData[ 'TABLE' ] = COMPANY;
            $arrData[ 'WHERE' ] = "status = " . ACTIVE;
            $arrData[ 'WHERE' ] .= ( $iCompany > 0 ) ? " AND ID = " . $iCompany: "";
            return $this->getData($arrData, false);
        }

		function addCompany($arrPost) {
			$arrData['NAME'] = $arrPost['company_name'];
			$arrData['EMAIL'] = $arrPost['email'];
			$arrData['ADDRESS'] = $arrPost['address'];
			$arrData['PHONE'] = $arrPost['phone'];
			$arrData['WEBSITE'] = $arrPost['website'];
			$arrData['TYPE'] = 'COMPANY';
			$arrData['SCS'] = ( $arrPost['scs'] == 'on' ) ? 1 : 0;
			$this->addData(COMPANY, $arrData);
		}

		function delCompanies( $iCompany ) {
			$arrData['STATUS'] = INACTIVE;
			$this->updateData(COMPANY, $arrData, "ID = '" . $iCompany. "' ");
		}

		function updateCompany( $arrPost ) {
			$arrData['NAME'] = $arrPost['company_name'];
			$arrData['EMAIL'] = $arrPost['email'];
			$arrData['ADDRESS'] = $arrPost['address'];
			$arrData['PHONE'] = $arrPost['phone'];
			$arrData['WEBSITE'] = $arrPost['website'];
			$arrData['TYPE'] = 'COMPANY';
			$arrData['SCS'] = ( $arrPost['scs'] == 'on' ) ? 1 : 0;
			$this->updateData(COMPANY, $arrData, "ID = '" . $arrPost['id_h'] . "' ");
		}


		function getCompanies($strType, $iCompany = 0, $isSCS = 0){
			$arrData[ 'FIELDS' ] = "ID, NAME, WEBSITE, PHONE, EMAIL, ADDRESS, SCS";
			$arrData[ 'TABLE' ] = COMPANY;
			$arrData[ 'WHERE' ] = "status = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND TYPE = '". $strType ."'";
			$arrData[ 'WHERE' ] .= ( $iCompany > 0 ) ? " AND ID = " . $iCompany: "";
			$arrData[ 'WHERE' ] .= ( $isSCS > 0 ) ? " AND SCS = 1" : "";
			return $this->getData($arrData, true);
		}

		function getCUserDetails($iUserId){
			$arrData[ 'FIELDS' ] = "U.*, C.USER_NAME, A.NAME AS CNAME";
			$arrData[ 'TABLE' ] = COMPANY_USERS . " U, " . CREDS . " C, " . COMPANY . " A";
			$arrData[ 'WHERE' ] = " U.USER_ID = ". $iUserId;
			$arrData[ 'WHERE' ] .= " AND U.USER_ID = C.USER_ID ";
			$arrData[ 'WHERE' ] .= " AND U.COMPANY = A.ID ";
			return $this->getData($arrData);
		}

		function getSubCntSelfLocation($iUserId) {
            $arrData[ 'FIELDS' ] = "L.ID, L.NAME";
            $arrData[ 'TABLE' ] = LOCATION . " L";
            $arrData[ 'WHERE' ] = "L.SUBCONTRACTOR = " . $iUserId;
            $arrData[ 'WHERE' ] .= " AND L.IS_SELF = " . ACTIVE;
            return $this->getData($arrData, false);
        }

		function getManagerLocation($iUserId) {
			$arrData[ 'FIELDS' ] = "L.NAME, L.ID, L.SUBCONTRACTOR, U.NAME AS SUBNAME";
			$arrData[ 'TABLE' ] = LOCATION . " L, " . COMPANY_USERS . " U";
			$arrData[ 'WHERE' ] = " L.MANAGER = ". $iUserId;
            if($_SESSION['HAS_SCS'] ) {
                $arrData[ 'WHERE' ] .= " AND L.SUBCONTRACTOR = U.USER_ID ";
            } else {
                $arrData[ 'WHERE' ] .= " AND L.MANAGER = U.USER_ID ";
            }

			return $this->getData($arrData);
		}


		function actDeleteCUser($iUserId){
			$arrData[ 'STATUS' ] = INACTIVE;
			$this->updateData(COMPANY_USERS, $arrData, "USER_ID = '" . $iUserId . "' ");
			$this->updateData(CREDS, $arrData, "USER_ID = '" . $iUserId . "' ");
		}

		function updateCUser( $arrPost ) {
			$arrData['NAME'] = $arrPost['name'];
			$arrData['EMAIL_ID'] =  $arrPost['email'];
			$arrData['PHONE'] =  $arrPost['phone'];
			$arrData['COMPANY'] =  $arrPost['company'];
            $arrData['DOB'] = $arrPost['dob'];
            $arrData['SOCIAL'] = $arrPost['social'];
            $arrData['ADDRESS_ONE'] = $arrPost['address_one'];
            $arrData['ADDRESS_TWO'] = $arrPost['address_two'];
            $arrData['STATE'] = $arrPost['state'];
            $arrData['ZIP_CODE'] = $arrPost['zipcode'];
            $arrData['DL'] = $arrPost['dl'];

			$this->updateData(COMPANY_USERS, $arrData, "USER_ID = '" . $arrPost['user_id'] . "' ");
			$arrData = array();
			if( $arrPost['password'] != '' ){
				$arrData['PASS_WORD'] =  md5( $arrPost['password'] );
				$this->updateData(CREDS, $arrData, "USER_ID = '" . $arrPost['user_id'] . "' ");
			}

			if( $arrPost['location'] != '' ) {

				/*$arrUP = array();
				$arrUP['MANAGER'] = '';
				$this->updateData(LOCATION, $arrUP, "MANAGER = '" .  $arrPost['user_id'] . "' ");*/

				$arrUP = array();
				$arrUP['MANAGER'] = $arrPost['user_id'];
				$this->updateData(LOCATION, $arrUP, "ID = '" .  $arrPost['location'] . "' ");

			}
		}



		function getUserSubContractor( $iUserId ) {
            $arrData[ 'FIELDS' ] = "(SELECT S.NAME FROM " . COMPANY_USERS . " S WHERE S.USER_ID = U.SUBCONTRACTOR) AS NAME,
                (SELECT S.USER_ID FROM " . COMPANY_USERS . " S WHERE S.USER_ID = U.SUBCONTRACTOR) AS ID
            ";
            $arrData[ 'TABLE' ] = COMPANY_USERS . " U";
            $arrData[ 'WHERE' ] = "U.status = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND U.USER_ID = " . $iUserId;
            return $this->getData($arrData, true);
        }

        function getUserDirector( $iUserId ) {
            $arrData[ 'FIELDS' ] = "(SELECT S.NAME FROM " . COMPANY_USERS . " S WHERE S.COMPANY = U.COMPANY
                AND S.ROLE_NAME = 'DIRECTOR' AND S.STATUS = 1 ) AS NAME,
                (SELECT S.USER_ID FROM " . COMPANY_USERS . " S WHERE S.COMPANY = U.COMPANY 
                AND S.ROLE_NAME = 'DIRECTOR' AND S.STATUS = 1 ) AS ID
                ";
            $arrData[ 'TABLE' ] = COMPANY_USERS . " U";
            $arrData[ 'WHERE' ] = "U.status = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND U.USER_ID = " . $iUserId;
            return $this->getData($arrData, true);
        }

		function getCompanyUsers($strType, $iCompany = 0, $iLoggedInUser = 0, $arrOptions = array() ) {
			$arrData[ 'FIELDS' ] = "U.NAME, U.EMAIL_ID, U.USER_ID, U.PHONE, C.NAME AS COMPANY";
			$arrData[ 'FIELDS' ] .= ", (SELECT CR.USER_NAME FROM " . CREDS . " CR WHERE U.USER_ID = CR.USER_ID AND CR.STATUS = 1 ) 
			                    AS USER_LOGIN_ID";

			//if( $iCompany == 0 ) {
                $arrData[ 'FIELDS' ] .= ", (SELECT S.NAME FROM " . COMPANY_USERS . " S WHERE S.USER_ID = U.SUBCONTRACTOR AND S.STATUS = 1 ) 
			                    AS SUBCONTRACTOR";
            //}

			$arrData[ 'TABLE' ] = COMPANY_USERS . " U, " . COMPANY . " C ";
			$arrData[ 'WHERE' ] = "U.status = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND C.status = " . ACTIVE;
			//$arrData[ 'WHERE' ] .= " AND U.ID > 1";
			$arrData[ 'WHERE' ] .= " AND U.COMPANY = C.ID ";
			$arrData[ 'WHERE' ] .= ( $arrOptions['q_company'] != '') ? " AND C.ID = " . $arrOptions['q_company'] : "";
			$arrData[ 'WHERE' ] .= ( $arrOptions['subc'] != '') ? " AND U.SUBCONTRACTOR = " . $arrOptions['subc'] : "";

			$arrData[ 'WHERE' ] .= " AND ROLE_NAME = '". $strType ."'";
			//if( $iLoggedInUser > DIRECTOR ) {
                $arrData[ 'WHERE' ] .= ( $iCompany > 0 ) ? " AND C.ID = " . $iCompany : "";
           // }
            if( $iLoggedInUser ){
                $arrData[ 'WHERE' ] .= ( $iLoggedInUser == SUBCONTRACTOR ) ? " AND U.ADDED_BY = '" . $iLoggedInUser . "'": "";
            }

			//$arrData[ 'WHERE' ] .= ( $iLoggedInUser <= SUBCONTRACTOR ) ? " AND U.PARENT = '" . $iLoggedInUser . "'": "";
			$arrData[ 'ORDER' ] = " U.ID DESC";
			return $this->getData($arrData, true);
		}

		function addCompanyUser($arrPost) {
			$arrData['NAME'] = $arrPost['name'];
			$arrData['ROLE_NAME'] = $arrPost['role_name'];
			$arrData['ROLE_ID'] = $arrPost['role_id'];
			$arrData['EMAIL_ID'] =  $arrPost['email'];
			$arrData['PHONE'] =  $arrPost['phone'];
			$arrData['COMPANY'] =  $arrPost['company'];
			$arrData['USER_ID'] = $arrPost['user_id'];
			$arrData['ADDED_ON'] = $arrPost['added_on'];
			$arrData['ADDED_BY'] = $arrPost['added_by'];
			$arrData['PARENT'] = $arrPost['parent'];
			$arrData['SUBCONTRACTOR'] = $arrPost['subcontractor'];
			$arrData['DOB'] = $arrPost['dob'];
			$arrData['SOCIAL'] = $arrPost['social'];
			$arrData['ADDRESS_ONE'] = $arrPost['address_one'];
			$arrData['ADDRESS_TWO'] = $arrPost['address_two'];
			$arrData['STATE'] = $arrPost['state'];
			$arrData['ZIP_CODE'] = $arrPost['zipcode'];
			$arrData['DL'] = $arrPost['dl'];

			$this->addData(COMPANY_USERS, $arrData);

			if( $arrPost['location'] != '' ) {
				$arrUP = array();
				$arrUP['MANAGER'] = $arrPost['user_id'];
				$this->updateData(LOCATION, $arrUP, "ID = '" .  $arrPost['location'] . "' ");
			}

			$arrData = array();
			$arrData['USER_NAME'] =  $arrPost['username'];
			$arrData['PASS_WORD'] =  md5( $arrPost['password'] );
			$arrData['PRE_FIX'] =  $arrPost['pre_fix'];
			$arrData['USER_ID'] =  $arrPost['user_id'];
			$this->addData(CREDS, $arrData);
		}

		function addAgencyUser($arrPost) {
			$strID =  'AG-' . date('Ymdhis');
			$arrData['NAME'] = $arrPost['name'];
			$arrData['ROLE_NAME'] = 'AGENCY';
			$arrData['ROLE_ID'] = AGENCY_ROLE;
			$arrData['EMAIL_ID'] =  $arrPost['email'];
			$arrData['PHONE'] =  $arrPost['phone'];
			$arrData['COMPANY'] =  $arrPost['company'];
			$arrData['USER_ID'] = $strID;
			$this->addData(COMPANY_USERS, $arrData);
			$arrData = array();
			$arrData['USER_NAME'] =  $arrPost['username'];
			$arrData['PASS_WORD'] =  md5( $arrPost['password'] );
			$arrData['PRE_FIX'] =  'AU';
			$arrData['USER_ID'] =  $strID;
			$this->addData(CREDS, $arrData);

		}
	}