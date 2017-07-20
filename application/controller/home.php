<?php

	class Home extends Controller {
		public function pagenotfound() {
			require VIEW_PATH . '_templates/404.php';
		}

		public function index() {
			//print_r( $_SESSION );
			require VIEW_PATH . '_templates/header.php';
			require VIEW_PATH . 'home/index.php';
			require VIEW_PATH . '_templates/footer.php';
		}

		public function info() {
			phpinfo();
		}

		public function clean() {
            $objCleanModel = $this->loadModel('clean');
            $objCleanModel->cleanData();
            require VIEW_PATH . '_templates/header.php';
            $strD = "Data Cleaning Complete";
            require VIEW_PATH . 'home/index.php';
            require VIEW_PATH . '_templates/footer.php';
        }
    }