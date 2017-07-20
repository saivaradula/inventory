<?php
	class locationModel extends Model {

		function getLocationByUserId($iUserId, $strUserType, $strType = 'shipping' ) {
			$arrData[ 'FIELDS' ] = "L.ID, L.NAME, L.ADDRESS, ( SELECT M.NAME FROM " . COMPANY_USERS . " M WHERE M.USER_ID = L.MANAGER AND M.STATUS = " . ACTIVE . " ) AS MANAGER_NAME";
			$arrData[ 'TABLE' ] = LOCATION . " L";
			switch( $strUserType ) {
				case "DIRECTOR" : $arrData[ 'WHERE' ] = "L.DIRECTOR = " . $iUserId; break;
				case "SUB CONTRACTOR" : $arrData[ 'WHERE' ] = "L.SUBCONTRACTOR = " . $iUserId; break;
				case "MANAGER" : $arrData[ 'WHERE' ] = "L.MANAGER = " . $iUserId; break;
			}
			if( $strUserType == 'SUB CONTRACTOR') {
                if( $strType == 'shipping' ) {
                    $arrData[ 'WHERE' ] .= " AND L.IS_SELF = " . INACTIVE;
                }

                if( $strType == 'assign' ) {
                    $arrData[ 'WHERE' ] .= " AND L.IS_SELF = " . ACTIVE;
                }
            }
			return $this->getData($arrData, true);
		}

		function addLocation( $arrPost ) {
			$arrData[ 'NAME' ] = strtoupper( $arrPost[ 'locname' ]);
			$arrData[ 'ADDRESS' ] = $arrPost[ 'address' ];
			$arrData[ 'DIRECTOR' ] = $arrPost[ 'director' ];
			$arrData[ 'MANAGER' ] = $arrPost[ 'manager' ];
			$arrData[ 'COMPANY' ] = $arrPost[ 'company' ];
			$arrData[ 'SUBCONTRACTOR' ] = $arrPost[ 'subc' ];
			$arrData[ 'ADDED_BY' ] = $arrPost[ 'ADDED_BY' ];
			$arrData[ 'ADDED_ON' ] = $arrPost[ 'ADDED_ON' ];
			$arrData[ 'IS_SELF' ] = $arrPost[ 'is_self' ];
			$arrData[ 'STATUS' ] = ACTIVE;
			return $this->addData(LOCATION, $arrData);
		}

		function getLocation( $iLid ) {
			$arrData[ 'FIELDS' ] = "L.*, 
			    ( SELECT M.NAME FROM " . COMPANY_USERS . " M WHERE M.USER_ID = L.MANAGER AND M.STATUS = " . ACTIVE . " ) AS MANAGER_NAME,
			    ( SELECT M.USER_ID FROM " . COMPANY_USERS . " M WHERE M.USER_ID = L.MANAGER AND M.STATUS = " . ACTIVE . " ) AS USER_ID";
			$arrData[ 'TABLE' ] = LOCATION . " L";
			$arrData[ 'WHERE' ] = " L.status = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND L.ID = " . $iLid;
			return $this->getData($arrData);
		}

		function updateLocation( $arrPost ) {
			$arrData[ 'NAME' ] = strtoupper( $arrPost[ 'locname' ]);
			$arrData[ 'ADDRESS' ] = $arrPost[ 'address' ];
			$arrData[ 'SUBCONTRACTOR' ] = $arrPost[ 'subc' ];
            $arrData[ 'IS_SELF' ] = $arrPost[ 'is_self' ];
			return $this->updateData(LOCATION, $arrData, "ID = " . $arrPost['location_id']);
		}

		function deleteLocation($iLid) {
			$arrData[ 'STATUS' ] = INACTIVE;
			$this->updateData(LOCATION, $arrData, "ID = '" . $iLid . "' ");
		}

		function getLocationManager($iLid = 0) {

			$arrData[ 'FIELDS' ] = "L.MANAGER, ( SELECT M.NAME FROM " . COMPANY_USERS . " M WHERE M.USER_ID = L.MANAGER AND M.STATUS = " . ACTIVE . " ) AS MANAGER_NAME";
			$arrData[ 'TABLE' ] = LOCATION . " L";
			if( $iLid ){
				$arrData[ 'WHERE' ] = "L.ID = " . $iLid;
				return $this->getData($arrData);
			} else {
				return $this->getData($arrData, true);
			}
		}

		function getLocationsList($iCmpny = 0, $bHasSubc = 1, $iUserId = 0, $iUserRoleId = 0 ) {


			if( $bHasSubc ) {
				$arrData[ 'FIELDS' ] = "L.NAME, L.ADDRESS, L.ID, L.SUBCONTRACTOR, U.NAME AS SCNAME,
					( SELECT M.NAME FROM " . COMPANY_USERS . " M WHERE M.USER_ID = L.MANAGER AND M.STATUS = " . ACTIVE . " ) AS MANAGER_NAME";
				$arrData[ 'TABLE' ] = COMPANY_USERS . " U, " . LOCATION . " L";
				$arrData[ 'WHERE' ] = "U.status = " . ACTIVE;
				$arrData[ 'WHERE' ] .= " AND L.status = " . ACTIVE;
				if( $iCmpny > 0 ){
					$arrData[ 'WHERE' ] .= " AND L.COMPANY = " . $iCmpny;
				}
				$arrData[ 'WHERE' ] .= " AND L.SUBCONTRACTOR = U.USER_ID";
				$arrData[ 'ORDER' ] = " U.ID DESC";
			} else {
				$arrData[ 'FIELDS' ] = "L.NAME, L.ADDRESS, L.ID,
				( SELECT M.NAME FROM " . COMPANY_USERS . " M WHERE M.USER_ID = L.MANAGER ) AS MANAGER_NAME";
				$arrData[ 'TABLE' ] = LOCATION . " L";
				$arrData[ 'WHERE' ] = " L.status = " . ACTIVE;
				if( $iCmpny > 0 ){
					$arrData[ 'WHERE' ] .= " AND L.COMPANY = " . $iCmpny;
				}
				$arrData[ 'ORDER' ] = " L.ID DESC";
			}

            /*if( $iUserRoleId <= DIRECTOR ){
                if( $iCmpny > 0 ){
                    $arrData[ 'WHERE' ] .= " AND L.ADDED_BY = " . $iUserId;
                }
			}*/

            if( $iUserRoleId == SUBCONTRACTOR ){
                $arrData[ 'WHERE' ] .= " AND L.SUBCONTRACTOR = " . $iUserId;
            }

			return $this->getData($arrData, true);
		}

	}
