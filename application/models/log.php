<?php
	class logModel extends Model {
		function logInventory( $arrPost ) {
		    //print_r( $arrPost ); exit;
			$arrData['USER_TYPE'] = $arrPost['user_type'];
			$arrData['IMEI_STATUS'] = $arrPost['status'];
			$arrData['PO_NUMBER'] = $arrPost['ponumber'];
			$arrData['TRACKING'] = $arrPost['tracking'];
			$arrData['ADDED_BY'] = $arrPost['user_id'];
			$arrData['ADDED_ON'] = $arrPost['modified_on'];
			$arrData['IMEI'] = $arrPost['imei'];
			$arrData['ASSIGNED_TO'] = $arrPost['assigned_to'];
			$arrData['DESCRIPTION'] = $arrPost['desc'];
			$arrData['UNIQUE_ID'] = $arrPost['unique'];
			$this->addData(LOG, $arrData);
		}

		function getLog( $strIMEI ) {
            $arrData[ 'FIELDS' ] = "*";
            $arrData[ 'TABLE' ] = LOG . " I";
            $arrData[ 'WHERE' ] = "I.STATUS = " . ACTIVE;
            $arrData[ 'WHERE' ] .= " AND I.IMEI = '" . $strIMEI . "'";
            $arrData[ 'ORDER' ] = "I.ID DESC";
            //return $this->getData($arrData, true);
            return $this->getData($arrData);
        }
	}

?>