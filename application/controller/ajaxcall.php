<?php

	class AjaxCall extends Controller {
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