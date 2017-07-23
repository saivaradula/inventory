<?php

	class AjaxCall extends Controller {

        public function getIMEILog( $objLogModel, $strIMEI) {
            $arrLog = $objLogModel->getLog( $strIMEI );
            $strLog = '<ul>';

            $strLog .= "<li>" . $arrLog->DESCRIPTION . "</li>";
            $strLog .= '</ul>';
            return $strLog;
        }

	    function getImportInv() {
            $objInvModel = $this->loadModel('inventory');
            $objLogModel = $this->loadModel('log');
            $arrImpRec = $objInvModel->getImpRec( $_POST['po']);
            $arrOption['per_ponumber'] = $_POST['po'];

            $arrMyInv = $objInvModel->getInventory($arrOption);


            for( $i=0; $i < count( $arrImpRec ); $i++ ){
                $arrSImpRec[] = $arrImpRec[$i]->imei;
            }


            for( $i=0; $i < count( $arrMyInv ); $i++ ){
                $arrSMyInv[] = $arrMyInv[$i]->IMEI;
                $arrMyInv[$i]->LOG = $this->getIMEILog( $objLogModel, $arrMyInv[$i]->IMEI );
            }


            $strMInv = '';
            for( $i=0; $i < count( $arrMyInv ); $i++ ){
                $strMInv .= "<a href='javascript:void(0)' class='tt' title='" . $arrMyInv[$i]->LOG . "'>" . $arrMyInv[$i]->IMEI . "</a>, ";
            }

            $strMInv = substr($strMInv, 0, strlen($strMInv) - 2);


            $arrUnMInv = array_diff($arrSImpRec, $arrSMyInv );
            $arrUnMInv = array_values($arrUnMInv);
            $strUMInv = '';
            if( count($arrUnMInv) == 0) {
                if( count( $arrSImpRec ) > 0){
                    $iUNC = count( $arrSImpRec );
                    for( $i=0; $i < count( $arrSImpRec ); $i++ ){
                        $strUMInv .= $arrSImpRec[$i] . ", ";
                    }
                }
            } else {
                $iUNC = count( $arrUnMInv );
                for( $i=0; $i < count( $arrUnMInv ); $i++ ){
                    $strUMInv .= $arrUnMInv[$i] . ", ";
                }
            }



            $strUMInv = substr($strUMInv, 0, strlen($strUMInv) - 2);

            require VIEW_PATH . 'inventory/impreport.php';
        }

		function getLocationManager() {
			$objLocationModel = $this->loadModel('location');
			$arrManager = $objLocationModel->getLocationManager($_POST['loc']);
			echo $arrManager->MANAGER_NAME;
		}

		function getLocationID() {
			$objLocModel = $this->loadModel('location');
			$arrObjLocation = $objLocModel->getLocation($_POST['id']);
			echo json_encode($arrObjLocation);
		}

		function getLocationBySubC() {
			$objLocModel = $this->loadModel('location');
			$arrOptions['subc'] = $_POST['subc'];

			if( $this->doesContainSubC() ) {
				$arrObjLocation = $objLocModel->getLocationByUserId($_POST['subc'], 'SUB CONTRACTOR');
			} else {
				$arrObjLocation = $objLocModel->getLocationByUserId($_POST['subc'], 'DIRECTOR');
			}

			switch( $this->getParameters(1) ) {
				case "dd" : {
					$strR = "<option value=''>Select Location</option>";
					foreach ( $arrObjLocation AS $arrObjCMm ) {
						$strR .= '<option value="' . $arrObjCMm->ID . '">';
						$strR .= $arrObjCMm->NAME;
						$strR .= '</option>';
					}
					echo $strR;
					break;
				}
			}
		}

		function getManagerBySubC() {

			$objCompanyModel = $this->loadModel('company');
			$arrOptions['subc'] = $_POST['subc'];
			$arrObjCMUsers = $objCompanyModel->getCompanyUsers('MANAGER', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);

			switch( $this->getParameters(1) ) {
				case "dd" : {
					$strR = "<option>Select Manager</option>";
					foreach ( $arrObjCMUsers AS $arrObjCMm ) {
						$strR .= '<option value="' . $arrObjCMm->USER_ID . '">';
							$strR .= $arrObjCMm->NAME;
						$strR .= '</option>';
					}
					echo $strR;
					break;
				}
			}
		}
	}