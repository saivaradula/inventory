<?php

class reportsModel extends Model {

    function getIMEIByHaveAccess( $arrOptions ) {

        $arrData[ 'FIELDS' ] = "DISTINCT ( I.ID ), I.IMEI, I.IMEI_STATUS, I.UNIQUE_ID, I.HAVE_ACCESS, I.PO_NUMBER,
					( SELECT U.NAME FROM " . LOCATION . " U WHERE U.ID = I.ASSIGNED_TO  ) AS ASSIGNEDTO,
					( SELECT U.NAME FROM " . COMPANY_USERS . " U WHERE U.USER_ID = I.ASSIGNED_TO  ) AS ASSIGNEDTOUSER,
					( SELECT U.NAME FROM " . COMPANY_USERS . " U WHERE U.USER_ID = I.USER_ID  ) AS CU,
					( SELECT CONCAT( U.FIRST_NAME, \" \", U.LAST_NAME ) FROM " . AGENTS . " U WHERE U.USER_ID = I.USER_ID  ) AS CUA,
					( SELECT U.NAME FROM " . COMPANY_USERS . " U WHERE U.USER_ID = I.ADDED_BY  ) AS ADDEDBY, I.ADDED_ON, I.MODIFIED_ON";
        $arrData[ 'TABLE' ] = INV . " I";

        if( $arrOptions['q_status']  ) {
            if( $arrOptions['q_status'] == 'ACTIVATED' ){
                $arrData[ 'WHERE' ] = "I.STATUS = " . INACTIVE;
                $arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = 'ACTIVATED'";
            } else {
                $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
                $arrData[ 'WHERE' ] .= " AND I.IMEI_STATUS = '" . $arrOptions['q_status'] . "'";
            }
        } else {
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
        }

        $arrData[ 'WHERE' ] .= ( $arrOptions['HVACESS'] != '' ) ? " AND I.HAVE_ACCESS IN ('" . $arrOptions['HVACESS'] . "')" : "";
        $arrData['FIELDS'] .= ( $arrOptions['user_id'] != '' ) ? ", 
			    ( SELECT P.PO_NUMBER FROM inventory_po P WHERE P.ADDED_BY = " . $arrOptions['user_id'] . " 
			        AND I.MODIFIED_BY = " . $arrOptions['user_id'] . " 
			        AND I.UNIQUE_ID = P.UNIQUE_ID
			        ORDER BY P.ID DESC LIMIT 0,1
			         ) AS PO_NUMBER" : "";

        if( $arrOptions['ponumber'] != '' ) {
            $arrData[ 'TABLE' ] .= ", " . LOG . " L";
            $arrData[ 'WHERE' ] .= " AND L.PO_NUMBER = '" . $arrOptions['ponumber'] . "'";
            $arrData[ 'WHERE' ] .= " AND I.IMEI = L.IMEI ";
            $arrData['ORDER'] = 'L.ID DESC';
        }

        $arrData[ 'WHERE' ] .= ( $arrOptions['per_ponumber'] != '' ) ? " AND I.PER_PO_NUMBER = '" . $arrOptions['per_ponumber'] . "'" : "";
        $arrData[ 'WHERE' ] .= ( $arrOptions['imei'] != '' ) ? " AND I.IMEI = '" . $arrOptions['imei'] . "'" : "";
        $arrData[ 'WHERE' ] .= ( $arrOptions['q_status'] != '' ) ? " AND I.IMEI_STATUS = '" . $arrOptions['q_status'] . "'" : "";

        if( isset( $arrOptions['low_limit'] ) ){
            $arrData['LIMIT_PER_PAGE'] = $arrOptions['limit_per_page'];
            $arrData [ 'LIMIT' ] = $arrOptions['low_limit'];
        }
        return $this->getData($arrData, true);

    }
}