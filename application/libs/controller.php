<?php

	class Controller {
		/* ************************************ Model Declaration ************************************************* */
		public function loadModel($model_name) {
			if ( file_exists('application/models/' . strtolower($model_name) . '.php') ) {
				require 'application/models/' . strtolower($model_name) . '.php';
				$strObj = $model_name . "Model";
				return new $strObj();
			}
		}

		/* *************** common functions *********************** */

		function sendEmail( $arrOptions, $strTemplate ) {

			//print_r($arrOptions);
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			$headers .= 'From: CodexWorld<sender@example.com>' . "\r\n";

			if(mail($arrOptions['emailid'], $arrOptions['subject'], $strTemplate,$headers)):
				return true;
			else:
				return false;
			endif;

		}

		function getParameters($i = 1){
			$url = rtrim($_GET[ 'url' ], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', $url);
			return $url[ $i + 1 ];
		}

		function userFullName(){
			return $_SESSION['USER_NAME'];
		}

		function validateUserInput($arrUserInput) {
			if ( is_array($arrUserInput) ) {
				foreach ( $arrUserInput as $key => $value ) {
					$value = trim($value);
					$value = addslashes($value);
					$value = htmlspecialchars($value);
					$arrUserInput[ $key ] = $value;
				}
			} else {
				$arrUserInput = trim($arrUserInput);
				$arrUserInput = addslashes($arrUserInput);
				$arrUserInput = htmlspecialchars($arrUserInput);
			}
			return $arrUserInput;
		}

		function isUserLogged() {
			return ( $_SESSION[ 'IS_USER_LOGGED' ] ) ? true : false;
		}

		function loginUser() {
			$_SESSION[ 'IS_USER_LOGGED' ] = true;
			$_SESSION['LIMIT_PER_PAGE'] = 25;
			return true;
		}

		function loggedInUserId() {
			return $_SESSION[ 'USER_ID' ];
		}

		function getUserIncId() {
			return $_SESSION['ID'];
		}

		function getLoggedUserRole() {
			return $_SESSION[ 'LOGGED_IN_AS' ];
		}

		function getLoggedUserRoleID() {
			return $_SESSION[ 'ROLE_ID' ];
		}

		function getLoggedInUserCompanyID(){
			return $_SESSION[ 'COMPANY' ];
		}

		function isSuperAdmin() {
			return ( $_SESSION[ 'ROLE_NAME' ] == 'SUPERADMIN' ) ? true : false;
		}

		function setAgent( $arrUser ) {
			$_SESSION[ 'USER_ID' ] = $arrUser->USER_ID;
			$_SESSION[ 'ID' ] = $arrUser->ID;
			$_SESSION[ 'USER_NAME' ] = $arrUser->FIRST_NAME . " " . $arrUser->LAST_NAME;
			$_SESSION[ 'LOGGED_IN_AS' ] = 'AGENT';
			$_SESSION[ 'ROLE_NAME' ] = 'AGENT';
			$_SESSION[ 'PROFILE_PIC' ] = '';
			$_SESSION[ 'DESIGNATION' ] = 'AGENT';
			$_SESSION[ 'EMAIL' ] = $arrUser->EMAILID;
			$_SESSION[ 'COMPANY' ] = $arrUser->PARENT_CMPNY;
			$_SESSION[ 'COMPANY_NAME' ] = $arrUser->CNAME;
			$_SESSION[ 'CWEB' ] = $arrUser->WEBSITE;
			$_SESSION[ 'CMAIL' ] = $arrUser->CMAIL;
			$_SESSION[ 'CPHONE' ] = $arrUser->CPHONE;
		}

		function setUser($arrUser) {
			$_SESSION[ 'USER_ID' ] = $arrUser->USER_ID;
			$_SESSION[ 'ID' ] = $arrUser->ID;
			$_SESSION[ 'USER_NAME' ] = $arrUser->NAME;
			$_SESSION[ 'LOGGED_IN_AS' ] = $arrUser->ROLE_NAME;
			$_SESSION[ 'ROLE_ID' ] = $arrUser->ROLE_ID;
			$_SESSION[ 'ROLE_NAME' ] = $arrUser->ROLE_NAME;
			$_SESSION[ 'PROFILE_PIC' ] = $arrUser->PROFILE_PIC;
			$_SESSION[ 'DESIGNATION' ] = $arrUser->ROLE_NAME;
			$_SESSION[ 'EMAIL' ] = $arrUser->EMAIL_ID;
			$_SESSION[ 'COMPANY' ] = $arrUser->COMPANY;
			$_SESSION[ 'COMPANY_NAME' ] = $arrUser->CNAME;
			$_SESSION[ 'CWEB' ] = $arrUser->WEBSITE;
			$_SESSION[ 'CMAIL' ] = $arrUser->CMAIL;
			$_SESSION[ 'CPHONE' ] = $arrUser->CPHONE;

			if($_SESSION['USER_ID'] == SUPERADMIN ) {
				$_SESSION[ 'HAS_SCS' ] = 1;
			} else {
				$_SESSION[ 'HAS_SCS' ] = $arrUser->SCS;
			}
		}

		function doesContainSubC() {
			if( $_SESSION[ 'HAS_SCS' ] )
				return true;
			else
				return false;
		}

		function getRequestedPage() {
			$arrURI = explode('/', $_SERVER[ 'REQUEST_URI' ]);
			$arrRedirect = explode('?redirect=', $arrURI[ count($arrURI) - 1 ]);
			return strtoupper($arrRedirect[ 0 ]);
		}

		function isAllowedModule($strModuleName) {
			if ( $this->isSuperAdmin() ) {
				return true;
			} else {
				return ( in_array(strtoupper($strModuleName), $_SESSION[ 'ALLOWED' ]) ) ? true : false;
			}
		}

		function isAllowedParentModule($strModuleName) {
			if ( $this->isSuperAdmin() ) {
				return true;
			} else {
				return ( in_array(strtolower($strModuleName), $_SESSION[ 'MODULES' ]) ) ? true : false;
			}
		}

		function userReadDate($strDate) {
			return strftime("%L, %d/%m/%Y", strtotime($strDate));
		}

		function now($strTime = '') {
			switch ( strtolower($strTime) ) {
				case "time" : {
					return date('h:i:s');
					break;
				}
				case "date" : {
					return date('Y-m-d');
					break;
				}
				default : {
				return date('Y-m-d h:i:s');
				break;
				}
			}
		}

		function randomNumber() {
		    return date('Ymdhis') . rand(9,9999);
        }

		function revDate($strDate, $strSprt = '-') {
			$arrDate = explode($strSprt, $strDate);
			return $arrDate[ 2 ] . "/" . $arrDate[ 1 ] . "/" . $arrDate[ 0 ];
		}

		function revDateTime($strDate, $strSprt = '-') {
			$arrDateTime = explode(" ", $strDate);
			$arrDate = explode($strSprt, $arrDateTime[ 0 ]);
			return $arrDate[ 2 ] . "/" . $arrDate[ 1 ] . "/" . $arrDate[ 0 ] . " " . substr( $arrDateTime[1], 0, 5);
		}

		function revDateTimeWT($strDate, $strSprt = '-') {
			$arrDateTime = explode(" ", $strDate);
			$arrDate = explode($strSprt, $arrDateTime[ 0 ]);
			return $arrDate[ 2 ] . "/" . $arrDate[ 1 ] . "/" . $arrDate[ 0 ];
		}

		function displayFullDateTime($strDate, $strSprt = '-') {
			return date("h:ia D, jS M, Y", strtotime($strDate));
		}

		function swapDate($strDate) {
			$arrDate = explode('/', $strDate);
			return trim($arrDate[ 2 ]) . "-" . trim($arrDate[ 1 ]) . "-" . trim($arrDate[ 0 ]);
		}

		function stripString($strString) {
			if ( strlen($strString) > 20 ) {
				$strString = substr($strString, 0, 20) . "...";
			}
			return $strString;
		}

		function loadModules($arrModules) {
			$_SESSION[ 'MODULES' ] = array();
			foreach ( $arrModules as $strValues ) {
				array_push($_SESSION[ 'MODULES' ], strtolower($strValues->NAME));
			}
		}

		function loadAllowedModules($arrModules) {
			$_SESSION[ 'ALLOWED' ] = array();
			foreach ( $arrModules as $strValues ) {
				array_push($_SESSION[ 'ALLOWED' ], strtoupper($strValues->M_CODE));
			}
		}

		function uploadPic($arrFiles, $storePath, $iWidth = 128, $iHeight = 128, $isWidth = 32, $isHeight = 32) {
			include 'simpleimage.php';
			$image = new SimpleImage();
			$image->load($arrFiles[ 'tmp_name' ]);
			$strNewImageName = date('Ymdhis_') . rand(0, 9999);
			$arrImgDetails = pathinfo($arrFiles[ "name" ]);
			$strNewImageName = $strNewImageName . "." . $arrImgDetails[ 'extension' ];
			$image->save("public/images/$storePath/" . $strNewImageName); // Main Image.
			$image->resize($iWidth, $iHeight);
			$image->save("public/images/$storePath/thumbs/" . $strNewImageName); // thumb Image.
			$image->resize($isWidth, $isHeight);
			$image->save("public/images/$storePath/profile/" . $strNewImageName); // thumb Image.
			return $strNewImageName;
		}

		function uploadDocument($arrFiles, $storePath, $strLN) {
			$name = preg_replace("/[^A-Z0-9._-]/i", "_", $arrFiles["name"]);
			$parts = pathinfo($name);
			$name = $strLN. "_" . date('Ymdhis') . "." . $parts["extension"];
			if( move_uploaded_file($arrFiles["tmp_name"], $storePath  . $name) ) {
				return $name;
			}

		}
		/* *************** end of functions ************************ */
	}
