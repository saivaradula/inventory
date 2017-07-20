<?php
	ob_start();
	class Admin extends Controller {
		public function index() {
			require VIEW_PATH . '_templates/header.php';
			require VIEW_PATH . 'home/index.php';
			require VIEW_PATH . '_templates/footer.php';
		}

		/* admin users */

		function users() {
			require VIEW_PATH . '_templates/header.php';
			require VIEW_PATH . 'home/index.php';
			require VIEW_PATH . '_templates/footer.php';
		}
		/* end of admin users */

		/* roles */

		public function roles() {
			require VIEW_PATH . '_templates/header.php';
			$objUserModel = $this->loadModel('users');
			$objArrRoles = $objUserModel->getSystemRole();
			$objArrModules = $objUserModel->loadSystemModules();


			for ( $i = 0; $i < count($objArrModules); $i++ ) {
				if ( $objArrModules[ $i ]->PARENT_ID == 0 ) {
					$arrModules[ $objArrModules[ $i ]->ID ] [ 'NAME' ] = $objArrModules[ $i ]->NAME;
				} else {
					$arrModules[ $objArrModules[ $i ]->PARENT_ID ][ 'CHILDS' ] [ $objArrModules[ $i ]->ID ] = $objArrModules[ $i ]->NAME;
				}
			}

			$arrModules = array_values($arrModules);
			require VIEW_PATH . 'roles/index.php';
			require VIEW_PATH . '_templates/footer.php';
		}

		public function getrolemodules() {
			$iRole = $_POST['role_id'];
			$objUserModel = $this->loadModel('users');

			$objArrRoleModules = $objUserModel->getRoleModules($_POST[ 'role_id' ]);
			for ( $i = 0; $i < count($objArrRoleModules); $i++ ) {
				$arrModules[ $i ] = $objArrRoleModules[ $i ]->ID;
			}
			echo json_encode($arrModules);

		}

		function addrolemodules() {
			$objUserModel = $this->loadModel('users');
			$arrPost[ 'role_id' ] = $_POST[ 'role_id' ];
			$arrPost[ 'modules' ] = $_POST[ 'm' ];

			echo $objUserModel->setRoleModules($arrPost);
		}

		function addnewrole(){
			$arrPost[ 'new_role' ] = $this->validateUserInput($_POST[ 'new_role' ]);
			$arrPost[ 'added_by' ] = $this->loggedInUserId();
			$arrPost[ 'added_on' ] = $this->now();
			$objUserModel = $this->loadModel('users');
			$objArrRole = $objUserModel->getSystemRole(0, $arrPost[ 'new_role' ]);
			if ( $objArrRole->id ) {
				echo json_encode(0);
			} else {
				$iRole = $objUserModel->addNewRole($arrPost);
				if ( $iRole ) {
					$objArrRoles = $objUserModel->getSystemRole();
					echo json_encode($objArrRoles);
				} else {
					echo json_encode(-1);
				}
			}
		}

		function deleterole(){
			$objUserModel = $this->loadModel('users');
			$objUserModel->deleteRole($_POST[ 'role_id' ]);
			$objArrRoles = $objUserModel->getSystemRole();
			echo json_encode($objArrRoles);
		}

		/* end of roles */

		/* company */

		function addcompany() {
			$objCompanyModel = $this->loadModel('company');
			if( $_POST['company_name'] != '' ){
				$objCompanyModel->addCompany($this->validateUserInput($_POST));
				header('Location: /admin/company');
			}
			require VIEW_PATH . '_templates/header.php';
			require VIEW_PATH . 'company/addcompany.php';
			require VIEW_PATH . '_templates/footer.php';

		}

		function company() {
			require VIEW_PATH . '_templates/header.php';
			$objCompanyModel = $this->loadModel('company');

			switch( $this->getParameters() ) {
				case "edit" : {

				    if( $_POST['company_name']){
					    $objCompanyModel->updateCompany($this->validateUserInput($_POST));
					    header('Location: /admin/company');
					}

					$arrObjC = $objCompanyModel->getCompanies('COMPANY', $this->getParameters(2));
					require VIEW_PATH . 'company/edit.php';

					break;
				}

				case "view" : {
					$arrObjC = $objCompanyModel->getCompanies('COMPANY', $this->getParameters(2));
					require VIEW_PATH . 'company/view.php';
					break;
				}

				case "delete" : {
					$arrObjC = $objCompanyModel->delCompanies($this->getParameters(2));
					header('Location: /admin/company');
					break;
				}

				default : {
					$arrObjC = $objCompanyModel->getCompanies('COMPANY');
					require VIEW_PATH . 'company/index.php';
					break;
				}
			}
			require VIEW_PATH . '_templates/footer.php';
		}

		function companyUsers(){
			require VIEW_PATH . '_templates/header.php';
			$objCompanyModel = $this->loadModel('company');
			$arrObjCUsers = $objCompanyModel->getCompanyUsers('COMPANY');
			$arrObjC = $objCompanyModel->getCompanies('COMPANY');
			require VIEW_PATH . 'company/users.php';
			require VIEW_PATH . '_templates/footer.php';
		}

		function addcuser() {
			$objCompanyModel = $this->loadModel('company');
			$objCompanyModel->addCompanyUser($this->validateUserInput($_POST));
			header('Location: /admin/companyusers');
		}

		function addCompanyUser() {
			require VIEW_PATH . '_templates/header.php';
			$objCompanyModel = $this->loadModel('company');
			$arrObjC = $objCompanyModel->getCompanies('COMPANY');
			require VIEW_PATH . 'company/add.php';
			require VIEW_PATH . '_templates/footer.php';
		}

		/* end of company */


	}