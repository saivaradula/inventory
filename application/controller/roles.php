<?php
	class Roles extends Controller {

		public function index() {
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

			$objUserModel->setRoleModules($arrPost);
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


	}