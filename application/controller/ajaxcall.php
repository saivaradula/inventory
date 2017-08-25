<?php
//ini_set('display_errors', 1 );
	class AjaxCall extends Controller {

	    public function activate() {
            $objInvModel = $this->loadModel('inventory');
            $objLogModel = $this->loadModel('log');
            $arrID = explode( ",", $_POST['id']);
            foreach($arrID AS $key => $value ) {
                if( $value != '' ){
                    $strID .= "'" . trim( $value ). "', ";
                }
            }
            $strID = substr($strID, 0, strlen( $strID ) - 6 );
            $arrP['modified_on'] = $this->now();
            $arrP['modified_by'] = $this->loggedInUserId();
            $objInvModel->setActive( $strID, $arrP );

            $arrPost['user_type'] = $this->getLoggedUserRole();
            $arrPost['status'] = 'ACTIVATED';
            $arrPost['user_id'] = $this->loggedInUserId();
            $arrPost['modified_on'] = $this->now();
            $arrPost['assigned_to'] = 0;
            $arrPost['desc'] = "IMEI has been activated.";
            $arrPost['reason'] = '';
            foreach($arrID AS $key => $value ) {
                $value = trim($value);
                ///echo $value . "<br />";
                if( $value != '' ){
                    $arrInv = $objInvModel->getImeiDetails($value);
                    $arrPost['imei'] = $value;
                    $arrPost['unique'] = $arrInv->UNIQUE_ID;
                    $arrPost['ponumber'] = $arrInv->PO_NUMBER;
                    $arrPost['tracking'] = $arrInv->TRACKING;
                    $objLogModel->logInventory($arrPost);
                }
            }

           //


        }

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
            $arrImpRec = $objInvModel->getImpRec( $_POST['po'], $this->loggedInUserId(), $this->getLoggedInUserCompanyID() );
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

            $x = is_array($arrUnMInv);

            if( $x === false ) {
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



            $arrMImp = array_diff($arrSMyInv, $arrSImpRec);
            $arrMImp = array_values($arrMImp);
            $strMImpInv = '';
            for( $i=0; $i < count( $arrMImp ); $i++ ){
                $strMImpInv .= $arrMImp[$i] . ", ";
            }
            $strMImpInv = substr($strMImpInv, 0, strlen($strMImpInv) - 2);
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

		function getSubContofCompy() {
            $cid = $_POST['id'];
            $objCompanyModel = $this->loadModel('company');
            $arrR = $objCompanyModel->doesCompanyHasSCS($cid);
            if( $arrR->SCS ){
                $arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $cid,
                    $this->loggedInUserId(), $arrOptions);
                ?>
                <select class="form-control required" id="subc" name="subc">
                    <option value="">Select</option>
                    <?php foreach ( $arrObjCUsers AS $arrObjCm ) { ?>
                        <option value="<?php echo $arrObjCm->USER_ID?>"><?php echo $arrObjCm->USER_LOGIN_ID?></option>
                    <?php } ?>
                </select>
                <?php
            } else {
                echo 0;
            }

        }

        function getLocOfCompy() {
            $cid = $_POST['id'];
            $sub = $_POST['sub'];
            $objCompanyModel = $this->loadModel('company');
            $arrL = $objCompanyModel->getCompanyLocations($cid, $sub);
            ?>
                <select class="form-control required" id="location" name="location">
                    <option value="">Select</option>
                    <?php foreach ( $arrL AS $arrObjCm ) { ?>
                        <option value="<?php echo $arrObjCm->ID?>" class="<?php echo $arrObjCm->SUBCONTRACTOR?>">
                            <?php echo $arrObjCm->NAME?></option>
                    <?php } ?>
                </select>
            <?php
        }

        function getManagerOfCompany() {
            $cid = $_POST['id'];
            $objCompanyModel = $this->loadModel('company');
            $arrL = $objCompanyModel->getCompanyManagers($cid);
            ?>
            <select class="form-control required" id="manager" name="manager">
                <option value="">Select</option>
                <?php foreach ( $arrL AS $arrObjCm ) { ?>
                    <option value="<?php echo $arrObjCm->ID?>" class="<?php echo $arrObjCm->SUBCONTRACTOR?>">
                        <?php echo $arrObjCm->NAME?></option>
                <?php } ?>
            </select>
            <?php
        }
	}