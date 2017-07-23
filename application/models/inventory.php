<?php
	class inventoryModel extends Model {



	    function getImpRec( $strPO ) {
            $arrData[ 'FIELDS' ] = "*";
            $arrData[ 'TABLE' ] = IMP . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;

            $arrData[ 'WHERE' ] .= " AND I.po_number = '" . $strPO . "'";
            return $this->getData($arrData, true);
        }

        function importActivatedRecord( $arrPost ) {
            $arrData['imei'] = $arrPost['imei'];
            $arrData['added_on'] = $arrPost['added_on'];
            $this->addData(ACTIVATE, $arrData);
        }

	    function importRecord( $arrPost ) {
            $arrData['po_number'] = $arrPost['po_num'];
            $arrData['imei'] = $arrPost['imei'];
            $arrData['added_on'] = $arrPost['added_on'];
            $this->addData(IMP, $arrData);
        }

	    function getPONumberByImei( $strIMEI, $iUserId ) {
            $arrData[ 'FIELDS' ] = "I.PO_NUMBER";
            $arrData[ 'TABLE' ] = INV . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND I.ASSIGNED_TO = '" . $iUserId . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI IN " . $strIMEI;
            $arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = 'SHIPPED_IN'";
            return $this->getData($arrData, false);
        }

        function checkInvBelongsAssignToLoc( $strIMEI, $iUserId ) {
            $arrData[ 'FIELDS' ] = "I.IMEI";
            $arrData[ 'TABLE' ] = INV . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND I.ASSIGNED_TO = ( SELECT ID FROM " . LOCATION . " L WHERE L.MANAGER = '" . $iUserId . "') ";
            $arrData[ 'WHERE' ] .= " AND I.IMEI IN " . $strIMEI;
            $arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = 'SHIPPED_IN'";
            return $this->getData($arrData, true);
        }

	    function checkInvBelongsAssignTo( $strIMEI, $iUserId ) {
            $arrData[ 'FIELDS' ] = "I.IMEI";
            $arrData[ 'TABLE' ] = INV . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND I.ASSIGNED_TO = '" . $iUserId . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI IN " . $strIMEI;

            $arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = 'SHIPPED_IN'";
            return $this->getData($arrData, true);
        }

	    function checkInvBelongsTo( $strIMEI, $iUserId, $strUserType, $strType ) {
            $arrData[ 'FIELDS' ] = "I.IMEI";
            $arrData[ 'TABLE' ] = INV . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND I.MODIFIED_BY = '" . $iUserId . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI IN " . $strIMEI;
            $arrData[ 'WHERE' ] .= " AND I.USER_TYPE = '" . $strUserType . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = '"  . $strType . "'";
            return $this->getData($arrData, true);
        }

		function shipCheckInventory( $strIMEI, $iUserId, $strUserType ) {
			$arrData[ 'FIELDS' ] = "I.IMEI";
			$arrData[ 'TABLE' ] = INV . " I";
			$arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND I.MODIFIED_BY = '" . $iUserId . "'";
			$arrData[ 'WHERE' ] .= " AND I.IMEI IN " . $strIMEI;
			$arrData[ 'WHERE' ] .= " AND I.USER_TYPE = '" . $strUserType . "'";
			$arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = 'SHIPPED_IN'";
			return $this->getData($arrData, true);
		}

        function shipReceiveInventory( $strIMEI, $iUserId, $strUserType ) {
            $arrData[ 'FIELDS' ] = "I.IMEI";
            $arrData[ 'TABLE' ] = INV . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND I.MODIFIED_BY = '" . $iUserId . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI IN " . $strIMEI;
            $arrData[ 'WHERE' ] .= " AND I.USER_TYPE = '" . $strUserType . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = 'RECEIVE'";
            return $this->getData($arrData, true);
        }

        function returnCheckInventory( $strIMEI, $iUserId, $strUserType ) {
            $arrData[ 'FIELDS' ] = "I.IMEI";
            $arrData[ 'TABLE' ] = INV . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND I.MODIFIED_BY = '" . $iUserId . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI IN " . $strIMEI;
            $arrData[ 'WHERE' ] .= " AND I.USER_TYPE = '" . $strUserType . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = 'RETURNED'";
            return $this->getData($arrData, true);
        }

        function assignCheckInventory( $strIMEI, $iUserId, $strUserType ) {
            $arrData[ 'FIELDS' ] = "I.IMEI";
            $arrData[ 'TABLE' ] = INV . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND I.MODIFIED_BY = '" . $iUserId . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI IN " . $strIMEI;
            $arrData[ 'WHERE' ] .= " AND I.USER_TYPE = '" . $strUserType . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = 'ASSIGNED'";
            return $this->getData($arrData, true);
        }

		function checkInventory( $strIMEI, $iUserId, $strUserType ) {
			$arrData[ 'FIELDS' ] = "I.IMEI";
			$arrData[ 'TABLE' ] = INV . " I";
			$arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
			$arrData[ 'WHERE' ] .= " AND I.MODIFIED_BY = '" . $iUserId . "'";
			$arrData[ 'WHERE' ] .= " AND I.IMEI IN " . $strIMEI;
			$arrData[ 'WHERE' ] .= " AND I.USER_TYPE = '" . $strUserType . "'";
			$arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = 'CHECKED_IN'";
			return $this->getData($arrData, true);
		}

		function getPONumber( $strPON ) {
            $arrData[ 'FIELDS' ] = "I.PO_NUMBER";
            $arrData[ 'TABLE' ] = INV . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND I.IMEI = '" . $strPON . "'";
            return $this->getData($arrData);
        }

		function shipInventory($arrPost) {
			$arrUData[ 'ASSIGNED_TO' ] = $arrPost[ 'assigned_to' ];;
			$strWhere = "IMEI = '" . $arrPost[ 'imei' ] . "'";
			$arrUData[ 'IMEI_STATUS' ] = $arrPost[ 'status' ];
			$arrUData[ 'MODIFIED_ON' ] = $arrPost[ 'modified_on' ];
			$arrUData[ 'MODIFIED_BY' ] = $arrPost[ 'modified_by' ];
			if( $arrPost['have_access'] != '' ) {
                $arrUData['HAVE_ACCESS'] = $arrPost['have_access'];
            }
            if( $arrPost['user_id'] != '' ) {
                $arrUData['USER_ID'] = $arrPost['user_id'];
            }

            $arrUData['PO_NUMBER'] = $arrPost['ponumber'];
            //$arrUData['TRACKING'] = $arrPost['tracking'];
			$this->updateData(INV, $arrUData, $strWhere);
		}

		function updateInventory( $arrPost ) {
			$arrUData[ 'ASSIGNED_TO' ] = $arrPost[ 'assigned_to' ];
            $strWhere = "IMEI = '" . $arrPost[ 'imei' ] . "'";
			$arrUData[ 'IMEI_STATUS' ] = $arrPost[ 'status' ];
			//$arrUData[ 'PO_NUMBER' ] = $arrPost[ 'ponumber' ];
			$arrUData[ 'USER_TYPE' ] = $arrPost[ 'user_type' ];
            $arrUData['USER_ID'] = $arrPost['user_id'];
            $arrUData['MODIFIED_ON'] = $arrPost['modified_on'];
            $arrUData['MODIFIED_BY'] = $arrPost['have_access'];
            $arrUData['HAVE_ACCESS'] = $arrPost['have_access'];
			$this->updateData(INV, $arrUData, $strWhere);
		}

		function addInventory($arrPost) {
			$arrData['USER_TYPE'] = $arrPost['user_type'];
			$arrData['IMEI_STATUS'] = $arrPost['status'];
			$arrData['USER_ID'] = $arrPost['user_id'];
			$arrData['MODIFIED_ON'] = $arrPost['modified_on'];
			$arrData['PO_NUMBER'] = $arrPost['ponumber'];
			$arrData['PER_PO_NUMBER'] = $arrPost['ponumber'];
			$arrData['ADDED_BY'] = $arrPost['added_by'];
			$arrData['MODIFIED_BY'] = $arrPost['modified_by'];
			$arrData['ADDED_ON'] = $arrPost['added_on'];
			$arrData['IMEI'] = $arrPost['imei'];
			$arrData['ASSIGNED_TO'] = $arrPost['assigned_to'];
			$arrData['UNIQUE_ID'] = $arrPost['unique'];
			$arrData['HAVE_ACCESS'] = $arrPost['have_access'];
			$this->addData(INV, $arrData);
		}

		function getPOPONUM($iUserId) {
            $arrData[ 'FIELDS' ] = " P.PO_NUMBER";
            $arrData[ 'TABLE' ] = INV_PO . " P, " . INV . " I";
            $arrData[ 'WHERE' ] = "P.ADDED_BY = " . $iUserId;
            $arrData[ 'WHERE' ] .= " AND P.MODIFIED_BY = " . $iUserId;
            $arrData[ 'WHERE' ] .= " AND I.UNIQUE_ID = P.UNIQUE_ID ";
            return $this->getData($arrData);
        }

		function addPO( $arrPost ) {
			$arrData['USER_TYPE'] = $arrPost['user_type'];
			$arrData['PO_STATUS'] = $arrPost['status'];
			$arrData['PO_NUMBER'] = $arrPost['ponumber'];
			$arrData['ADDED_BY'] = $arrPost['added_by'];
			$arrData['ADDED_ON'] = $arrPost['added_on'];
			$arrData['ASSIGNED_TO'] = $arrPost['assigned_to'];
			$arrData['UNIQUE_ID'] = $arrPost['unique'];
			$this->addData(INV_PO, $arrData);
		}

		function isInvenCheckedIn( $iIMEI) {
            $arrData[ 'FIELDS' ] = "I.ID, I.IMEI, I.UNIQUE_ID, I.HAVE_ACCESS";
            $arrData[ 'TABLE' ] = INV . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND I.IMEI = '" . $iIMEI . "'";
            return $this->getData($arrData);
        }

		function getInventory( $arrOptions, $isCheck = false ){

			$arrData[ 'FIELDS' ] = "I.ID, I.IMEI, I.IMEI_STATUS, I.UNIQUE_ID, I.HAVE_ACCESS,
					( SELECT U.NAME FROM " . LOCATION . " U WHERE U.ID = I.ASSIGNED_TO  ) AS ASSIGNEDTO,
					( SELECT U.NAME FROM " . COMPANY_USERS . " U WHERE U.USER_ID = I.ASSIGNED_TO  ) AS ASSIGNEDTOUSER,
					( SELECT U.NAME FROM " . COMPANY_USERS . " U WHERE U.USER_ID = I.USER_ID  ) AS CU,
					( SELECT CONCAT( U.FIRST_NAME, \" \", U.LAST_NAME ) FROM " . AGENTS . " U WHERE U.USER_ID = I.USER_ID  ) AS CUA,
					( SELECT U.NAME FROM " . COMPANY_USERS . " U WHERE U.USER_ID = I.ADDED_BY  ) AS ADDEDBY, I.ADDED_ON, I.MODIFIED_ON";
			$arrData[ 'TABLE' ] = INV . " I";
			$arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;

			$arrData['FIELDS'] .= ( $arrOptions['user_id'] != '' ) ? ", 
			    ( SELECT P.PO_NUMBER FROM inventory_po P WHERE P.ADDED_BY = " . $arrOptions['user_id'] . " 
			        AND I.MODIFIED_BY = " . $arrOptions['user_id'] . " 
			        AND I.UNIQUE_ID = P.UNIQUE_ID
			        ORDER BY P.ID DESC LIMIT 0,1
			         ) AS PO_NUMBER" : "";

			/*if( $arrOptions['isReceive'] == 1 ){
                $arrData['FIELDS'] .= ( $arrOptions['user_id'] != '' ) ? ", 
			    ( SELECT P.PO_NUMBER FROM inventory_po P WHERE P.ADDED_BY = " . $arrOptions['user_id'] . " 
			        AND I.UNIQUE_ID = P.UNIQUE_ID ) AS PO_NUMBER" : "";
            }*/

            if( !$isCheck )
			    //$arrData[ 'WHERE' ] .= " AND ( I.USER_ID = " . $arrOptions['user_id'] . " OR I.ADDED_BY = " . $arrOptions['user_id'] . " )";
			    $arrData[ 'WHERE' ] .= " AND I.HAVE_ACCESS LIKE '%" . $arrOptions['user_id'] . "%' ";


			$arrData[ 'WHERE' ] .= ( $arrOptions['added_by'] != '' ) ? " AND I.ADDED_BY = '" . $arrOptions['added_by'] . "'" : "";

			if($arrOptions['EXACT'] == true ) {
				$arrData[ 'WHERE' ] .= ( $arrOptions['ponumber'] != '' ) ? " AND I.PO_NUMBER = '" . $arrOptions['ponumber'] . "'" : "";
			} else {
				$arrData[ 'WHERE' ] .= ( $arrOptions['ponumber'] != '' ) ? " AND I.PO_NUMBER LIKE '%" . $arrOptions['ponumber'] . "%'" : "";
			}


            $arrData[ 'WHERE' ] .= ( $arrOptions['per_ponumber'] != '' ) ? " AND I.PER_PO_NUMBER = '" . $arrOptions['per_ponumber'] . "'" : "";

			$arrData[ 'WHERE' ] .= ( $arrOptions['imei'] != '' ) ? " AND I.IMEI = '" . $arrOptions['imei'] . "'" : "";

			$arrData[ 'WHERE' ] .= ( $arrOptions['q_status'] != '' ) ? " AND I.IMEI_STATUS = '" . $arrOptions['q_status'] . "'" : "";

			return $this->getData($arrData, true);
		}

		function getPO( $arrOptions ){
			$arrData[ 'FIELDS' ] = "I.PO_NUMBER, I.PO_STATUS,
					( SELECT COUNT(K.IMEI) FROM " . INV . " K WHERE K.PO_NUMBER = I.PO_NUMBER ) AS NUM_INV,
					( SELECT U.NAME FROM " . LOCATION . " U WHERE U.ID = I.ASSIGNED_TO  ) AS ASSIGNEDTO,
					( SELECT U.NAME FROM " . COMPANY_USERS . " U WHERE U.USER_ID = I.ADDED_BY  ) AS ADDEDBY, I.ADDED_ON";
			$arrData[ 'TABLE' ] = INV_PO . " I";
			$arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
			$arrData[ 'WHERE' ] .= ( $arrOptions['added_by'] ) ? " AND I.ADDED_BY = '" . $arrOptions['added_by'] . "'" : "";
			if($arrOptions['EXACT'] == true ) {
				$arrData[ 'WHERE' ] .= ( $arrOptions['ponumber'] != '' ) ? " AND I.PO_NUMBER = '" . $arrOptions['ponumber'] . "'" : "";
			} else {
				$arrData[ 'WHERE' ] .= ( $arrOptions['ponumber'] != '' ) ? " AND I.PO_NUMBER LIKE '%" . $arrOptions['ponumber'] . "%'" : "";
			}

			$arrData[ 'WHERE' ] .= ( $arrOptions['q_status'] != '' ) ? " AND I.PO_STATUS = '" . $arrOptions['q_status'] . "'" : "";
			return $this->getData($arrData, true);
		}
	}