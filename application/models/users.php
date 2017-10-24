<?php

	class usersModel extends Model {

	    function getCompanyUserFrom( $iCompany, $iUserId  ) {
            $arrData[ 'FIELDS' ] = "U.USER_ID";
            $arrData[ 'TABLE' ] = COMPANY_USERS . " U";
            $arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
            //$arrData[ 'WHERE' ] .= " AND LOWER( U.COMPANY ) = '" . $iCompany . "'";
            $arrData[ 'WHERE' ] .= " AND U.PARENT = " . $iUserId;
           return $this->getData($arrData, true);
        }

		function validateUserEmail($strEmail ) {
			$arrData[ 'FIELDS' ] = "U.USER_ID, 'AGENT' ";
			$arrData[ 'TABLE' ] = AGENTS . " U";
			$arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
			$arrData[ 'WHERE' ] .= " AND LOWER( U.EMAILID ) = '" . strtolower($strEmail) . "'";
			$arrUser = $this->getData($arrData);

			if( $arrUser->USER_ID == '' ){
				$arrData[ 'FIELDS' ] = "U.USER_ID, 'CUSER' ";
				$arrData[ 'TABLE' ] = COMPANY_USERS . " U";
				$arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
				$arrData[ 'WHERE' ] .= " AND LOWER( U.EMAIL_ID ) = '" . strtolower($strEmail) . "'";
				$arrUser =  $this->getData($arrData);
			}
			return $arrUser;
		}

		function validateUser($strUserName, $strPassword = '') {
			$arrData[ 'FIELDS' ] = "U.USER_ID, U.PRE_FIX";
			$arrData[ 'TABLE' ] = CREDS . " U";
			$arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
			$arrData[ 'WHERE' ] .= " AND U.USER_NAME = '" . strtolower($strUserName) . "'";
			$arrData[ 'WHERE' ] .= ( $strPassword != '' ) ? " AND U.PASS_WORD = '" . $strPassword . "'" : "";
			$arrUser = $this->getData($arrData);

			if( $arrUser->USER_ID ) {
				$this->updateUserLL( $arrUser->USER_ID );
			}
			return $arrUser;
		}

		function updateUserLL( $strUserId ) {
			$arrData[ 'LOGIN_DT' ] = date('Y-m-d h:i:s');
			$this->updateData(CREDS, $arrData, "USER_ID = '" . $strUserId . "' ");
		}

		function getAgentDetails( $iUserId ) {
			$arrData[ 'FIELDS' ] = "U.*, C.NAME AS CNAME, C.WEBSITE, C.EMAIL AS CMAIL, C.PHONE AS CPHONE";
			$arrData[ 'TABLE' ] = AGENTS . " U, " . COMPANY . " C";
			$arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
			$arrData[ 'WHERE' ] .= " AND U.USER_ID = '" . $iUserId . "'";
			$arrData[ 'WHERE' ] .= " AND U.PARENT_CMPNY = C.ID";
			return $this->getData($arrData);
		}

		function getCompanyUserDetails( $iUserId, $isAdmin = 2 ) {
			if( $isAdmin >  1 ){
				$arrData[ 'FIELDS' ] = "U.*, C.NAME AS CNAME, C.WEBSITE, C.EMAIL AS CMAIL, C.PHONE AS CPHONE, C.SCS";
				$arrData[ 'TABLE' ] = COMPANY_USERS . " U, " . COMPANY . " C";
				$arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
				$arrData[ 'WHERE' ] .= " AND U.USER_ID = '" . $iUserId . "'";
				$arrData[ 'WHERE' ] .= " AND U.COMPANY = C.ID";
				return $this->getData($arrData);
			} else {
				$arrData[ 'FIELDS' ] = "U.*";
				$arrData[ 'TABLE' ] = COMPANY_USERS . " U";
				$arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
				$arrData[ 'WHERE' ] .= " AND U.USER_ID = '" . $iUserId . "'";
				//$arrData[ 'WHERE' ] .= " AND U.COMPANY = C.ID";
				return $this->getData($arrData);
			}

		}

		function loadRoleModules($iRoleId) {
			$arrData[ 'FIELDS' ] = "m.NAME";
			$arrData[ 'TABLE' ] = ROLES . " r, " . MODULES . " m";
			$arrData[ 'WHERE' ] = "r.ID = " . $iRoleId;
			$arrData[ 'WHERE' ] .= " AND m.ID in ( r.PERMISSIONS )";
			return $this->getData($arrData, true);
		}

		function loadRoleParentModules($iRoleId) {
			$arrData[ 'FIELDS' ] = "DISTINCT( m.parent_id ) AS PARENT,
								( SELECT m1.name  FROM " . MODULES . " m1 WHERE m1.id = m.parent_id ) AS name";
			$arrData[ 'TABLE' ] = MODULES . " m, " . ROLE_MODULE . " rm";
			$arrData[ 'WHERE' ] = "m.status = " . ACTIVE . " AND rm.status = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND rm.role_id = " . $iRoleId;
			$arrData[ 'WHERE' ] .= " AND rm.module_id = m.id";
			return $this->getData($arrData, true);
		}

		function getUserDetails($iUserId) {
			$arrData[ 'FIELDS' ] = "u.*";
			$arrData[ 'TABLE' ] = COMPANY_USERS . " u";
			$arrData[ 'WHERE' ] = "u.status = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND u.id = " . $iUserId;
			return $this->getData($arrData);
		}

        function getUserDetailsByUserId($iUser_Id) {
            $arrData[ 'FIELDS' ] = "u.*";
            $arrData[ 'TABLE' ] = COMPANY_USERS . " u";
            $arrData[ 'WHERE' ] = "u.status = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND u.USER_ID = " . $iUser_Id;
            return $this->getData($arrData);
        }

		function addUser($arrPost) {
			$arrData[ 'loginid' ] = $arrPost[ 'lname' ];
			$arrData[ 'pswd' ] = md5($arrPost[ 'lpwd' ]);
			$arrData[ 'fullname' ] = $arrPost[ 'fullname' ];
			$arrData[ 'shortname' ] = $arrPost[ 'shortname' ];
			$arrData[ 'role_id' ] = $arrPost[ 'roleid' ];
			$arrData[ 'designation' ] = $arrPost[ 'designation' ];
			$arrData[ 'address' ] = $arrPost[ 'address' ];
			$arrData[ 'manager_id' ] = $arrPost[ 'managerid' ];
			$arrData[ 'email_id' ] = $arrPost[ 'emailid' ];
			$arrData[ 'hand_phone' ] = $arrPost[ 'hand_phone' ];
			$arrData[ 'office_phone' ] = $arrPost[ 'office_phone' ];
			$arrData[ 'added_by' ] = $arrPost[ 'added_by' ];
			$arrData[ 'parent' ] = $arrPost[ 'parent' ];
			$arrData[ 'added_date' ] = $arrPost[ 'added_date' ];
			$iUser = $this->addData(USERS, $arrData);
			return $iUser;
		}

		function updateUser($arrPost) {
			$arrData[ 'loginid' ] = $arrPost[ 'lname' ];
			$arrData[ 'pswd' ] = $arrPost[ 'pwd' ];
			$arrData[ 'fullname' ] = $arrPost[ 'fullname' ];
			$arrData[ 'shortname' ] = $arrPost[ 'shortname' ];
			$arrData[ 'role_id' ] = $arrPost[ 'roleid' ];
			$arrData[ 'designation' ] = $arrPost[ 'designation' ];
			$arrData[ 'address' ] = $arrPost[ 'address' ];
			$arrData[ 'manager_id' ] = $arrPost[ 'managerid' ];
			$arrData[ 'email_id' ] = $arrPost[ 'emailid' ];
			$arrData[ 'hand_phone' ] = $arrPost[ 'hand_phone' ];
			$arrData[ 'office_phone' ] = $arrPost[ 'office_phone' ];
			$arrData[ 'profile_pic' ] = $arrPost[ 'image' ];
			$arrData[ 'updated_by' ] = $arrPost[ 'update_by' ];
			$arrData[ 'updated_date' ] = $arrPost[ 'updated_Date' ];
			$this->updateData(USERS, $arrData, "id = '" . $arrPost[ 'update_user_id' ] . "' ");
		}

		function updateUserProfile($arrPost) {
			$arrData[ 'fullname' ] = $arrPost[ 'fullname' ];
			$arrData[ 'shortname' ] = $arrPost[ 'shortname' ];
			$arrData[ 'address' ] = $arrPost[ 'address' ];
			$arrData[ 'email_id' ] = $arrPost[ 'emailid' ];
			$arrData[ 'hand_phone' ] = $arrPost[ 'hand_phone' ];
			$arrData[ 'office_phone' ] = $arrPost[ 'office_phone' ];
			$arrData[ 'profile_pic' ] = $arrPost[ 'image' ];
			$arrData[ 'updated_by' ] = $arrPost[ 'update_by' ];
			$arrData[ 'updated_date' ] = $arrPost[ 'updated_Date' ];
			$this->updateData(USERS, $arrData, "id = '" . $arrPost[ 'update_user_id' ] . "' ");
		}

		function checkUsername($loginName) {
			$arrData[ 'FIELDS' ] = "u.id";
			$arrData[ 'TABLE' ] = USERS . " u";
			$arrData[ 'WHERE' ] = "u.status = 1 AND u.loginid= '" . $loginName . "'";
			return $this->getData($arrData);
		}

		function getUsers($bList = true, $isArchieved = false, $role = '', $dsg = '' ) {
			if ( $bList ) {
				$arrData[ 'FIELDS' ] = "u.shortname, u.id";
			} else {
				$arrData[ 'FIELDS' ] = "u.*";
			}

			$arrData[ 'TABLE' ] = USERS . " u";

			if ( $isArchieved ) {
				$arrData[ 'WHERE' ] = "u.status = " . INACTIVE;
			} else {
				$arrData[ 'WHERE' ] = " u.status = " . ACTIVE;
			}

			if ( $role!= '' ) {
				$arrData[ 'WHERE' ] .= " AND u.role_id IN (" . $role . ")";
			}

			if ( $dsg != '' ) {
				$arrData[ 'WHERE' ] .= " AND LOWER( u.designation ) = '" . strtolower( $dsg ) . "'";
			}

			$arrData[ 'WHERE' ] .= " AND u.role_id > 1";
			$arrData[ 'ORDER' ] = "u.fullname";
			return $this->getData($arrData, true);
		}

		function deleteUser($userid) {
			$arrData[ 'status' ] = '0';
			$where = "id = '" . $userid . "' ";
			$this->updateData(USERS, $arrData, $where);

		}

		function getAllDesignations() {
			$arrData[ 'FIELDS' ] = "DISTINCT (designation ) AS DESI";
			$arrData[ 'TABLE' ] = USERS;
			$arrData[ 'WHERE' ] = "status = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND id > 1";
			return $this->getData($arrData, true);
		}

		/* Role & Modules related functions */
		function getSystemRole($iRoleId = 0, $strRoleName = '') {
			$arrData[ 'FIELDS' ] = "r.ID, r.ROLE_NAME, r.PERMISSIONS";
			$arrData[ 'TABLE' ] = ROLES . " r";
			$arrData[ 'WHERE' ] = "r.status = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND r.id > 1";
			$arrData[ 'WHERE' ] .= ( $iRoleId ) ? " AND r.id = " . $iRoleId : "";
			$arrData[ 'WHERE' ] .= ( $strRoleName != '' ) ? " AND lower( r.role_name ) = '" . strtolower($strRoleName) . "'" : "";

			if ( $iRoleId > 0 || $strRoleName != '' ) {
				return $this->getData($arrData);
			} else {
				return $this->getData($arrData, true);
			}
		}

		function deleteRole($iRoleId){
			$arrData[ 'status' ] = '0';
			$where = "ID = '" . $iRoleId . "' ";
			$this->updateData(ROLES, $arrData, $where);
		}

		function addNewRole($arrPost) {
			$arrData[ 'ROLE_NAME' ] = strtoupper( $arrPost[ 'new_role' ]);
			$arrData[ 'ADDED_BY' ] = $arrPost[ 'added_by' ];
			$arrData[ 'ADDED_ON' ] = $arrPost[ 'added_on' ];
			return $this->addData(ROLES, $arrData);
		}

		function loadSystemModules($strFilter = '', $iParent) {
			$arrData[ 'FIELDS' ] = "m.ID, m.NAME, m.PARENT_ID";
			$arrData[ 'TABLE' ] = MODULES . " m";
			$arrData[ 'WHERE' ] = "m.status = " . ACTIVE;
			if ( $strFilter == 'child' ) {
				$arrData[ 'WHERE' ] .= " AND m.parent_id > 0";
			}

			if ( $iParent > 0 ) {
				$arrData[ 'WHERE' ] .= " AND m.PARENT_ID = " . $iParent;
			}

			return $this->getData($arrData, true);
		}

		function setRoleModules($arrPost) {
			$arrData[ 'FIELDS' ] = "DISTINCT( m.`PARENT_ID` ) AS ID";
			$arrData[ 'TABLE' ] = MODULES . " m";
			$arrData[ 'WHERE' ] = "m.status = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND m.ID IN (" . $arrPost[ 'modules' ] . ")";
			$arrP = $this->getData($arrData, true);

			$strP = '';
			foreach ( $arrP as $arr ) {
				$strP .= $arr->ID . ",";
			}
			$strP = $strP . $arrPost[ 'modules' ];
			$arrUData = array();
			$arrUData[ 'PERMISSIONS' ] = $strP;
			$strWhere = "ID = " . $arrPost[ 'role_id' ];

			$this->updateData(ROLES, $arrUData, $strWhere);
		}

		function getRoleModules($iRoleId) {

			$arrData[ 'FIELDS' ] = "PERMISSIONS AS P";
			$arrData[ 'TABLE' ] = ROLES . " r";
			$arrData[ 'WHERE' ] = " r.ID = " . $iRoleId;
			$arrP = $this->getData($arrData);

			$arrData[ 'FIELDS' ] = "m.ID, m.NAME, m.M_CODE";
			$arrData[ 'TABLE' ] = MODULES . " m, " . ROLES . " r";
			$arrData[ 'WHERE' ] = "m.status = " . ACTIVE . " AND r.status = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND r.ID = " . $iRoleId;
			$arrData[ 'WHERE' ] .= " AND m.ID IN (" . $arrP->P . ")";
			return $this->getData($arrData, true);
		}

		/* End of Role & Modules related functions */
	}


	//