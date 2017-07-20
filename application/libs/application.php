<?php
	session_start();

	class Application {
		private $url_controller = NULL;
		private $url_action = NULL;
		private $url_parameter_1 = NULL;
		private $url_parameter_2 = NULL;
		private $url_parameter_3 = NULL;

		public function __construct() {
			$this->splitUrl();
			if ( file_exists('./application/controller/' . $this->url_controller . '.php') ) {

				if( $this->url_controller == 'validate' ) {
					require_once './application/controller/' . $this->url_controller . '.php';
					$this->url_controller = new $this->url_controller();
					if ( method_exists($this->url_controller, $this->url_action) ) {
						if ( isset( $this->url_parameter_3 ) ) {
							$this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
						} elseif ( isset( $this->url_parameter_2 ) ) {
							$this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
						} elseif ( isset( $this->url_parameter_1 ) ) {
							$this->url_controller->{$this->url_action}($this->url_parameter_1);
						} else {
							$this->url_controller->{$this->url_action}();
						}
					} else {
						require_once './application/controller/home.php';
						$home = new Home();
						$home->index();
					}
				} else if( $this->url_controller == 'agents' ) {

					require_once './application/controller/' . $this->url_controller . '.php';
					$this->url_controller = new $this->url_controller();

					if ( method_exists($this->url_controller, $this->url_action) ) {

						if ( isset( $this->url_parameter_3 ) ) {
							$this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
						} elseif ( isset( $this->url_parameter_2 ) ) {
							$this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
						} elseif ( isset( $this->url_parameter_1 ) ) {
							$this->url_controller->{$this->url_action}($this->url_parameter_1);
						} else {
							$this->url_controller->{$this->url_action}();
						}
					} else {
						$this->url_controller->index();
					}

				} else {
					if ( $_SESSION[ 'IS_USER_LOGGED' ] ) {
						require './application/controller/' . $this->url_controller . '.php';
						$this->url_controller = new $this->url_controller();

						if ( method_exists($this->url_controller, $this->url_action) ) {
							if ( isset( $this->url_parameter_3 ) ) {
								$this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
							} elseif ( isset( $this->url_parameter_2 ) ) {
								$this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
							} elseif ( isset( $this->url_parameter_1 ) ) {
								$this->url_controller->{$this->url_action}($this->url_parameter_1);
							} else {
								$this->url_controller->{$this->url_action}();
							}
						} else {
							$this->url_controller->index();
						}
					} else {
						/*
						require_once './application/controller/login.php';
						$objLogin = new Login();
						$objLogin->index();
						*/
						if( $this->url_controller != 'home' ){
							$d = $this->url_controller . "/" . $this->url_action;
							header("Location: /home?d=$d");
							exit;
						} else {
							require_once './application/controller/login.php';
							$objLogin = new Login();
							$objLogin->index();
						}

					}
				}
			} else {
				if( $this->url_controller == '' ) {
					if ( $_SESSION[ 'IS_USER_LOGGED' ] ) {
						require_once './application/controller/home.php';
						$home = new Home();
						$home->index();
					} else {
						require_once './application/controller/login.php';
						$objLogin = new Login();
						$objLogin->index();
					}
				} else {
					require_once './application/controller/home.php';
					$home = new Home();
					$home->pagenotfound();
				}
			}
		}

		/**
		 * Get and split the URL
		 */
		private function splitUrl() {
			if ( isset( $_GET[ 'url' ] ) ) {
				$url = rtrim($_GET[ 'url' ], '/');
				$url = filter_var($url, FILTER_SANITIZE_URL);
				$url = explode('/', $url);
				$this->url_controller = ( isset( $url[ 0 ] ) ? $url[ 0 ] : NULL );
				$this->url_action = ( isset( $url[ 1 ] ) ? $url[ 1 ] : NULL );
				$this->url_parameter_1 = ( isset( $url[ 2 ] ) ? $url[ 2 ] : NULL );
				$this->url_parameter_2 = ( isset( $url[ 3 ] ) ? $url[ 3 ] : NULL );
				$this->url_parameter_3 = ( isset( $url[ 4 ] ) ? $url[ 4 ] : NULL );

				/*	echo 'Controller: ' . $this->url_controller . '<br />';
					echo 'Action: ' . $this->url_action . '<br />';
					echo 'Parameter 1: ' . $this->url_parameter_1 . '<br />';
					echo 'Parameter 2: ' . $this->url_parameter_2 . '<br />';
					echo 'Parameter 3: ' . $this->url_parameter_3 . '<br />'; 
				exit;*/

			}
		}

		public function swapDate( $strDate ) {
			$arrDate = explode( '/', $strDate );
			return trim( $arrDate[ 2 ] ) . "-" . trim( $arrDate[ 1 ] ) . "-" . trim( $arrDate[ 0 ] );
		}
	}
