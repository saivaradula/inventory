<?php
class Reports extends Controller {
    function index() {
        require VIEW_PATH . '_templates/header.php';
        require VIEW_PATH . '_templates/footer.php';
    }

    function basic() {
        require VIEW_PATH . '_templates/header.php';
        $objLocationModel = $this->loadModel('location');
        $objCompanyModel = $this->loadModel('company');
        $objUserModel = $this->loadModel('users');
        //$arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);
        $arrObjC = $objCompanyModel->getCompanies('COMPANY');
        require VIEW_PATH . 'reports/b.php';
        require VIEW_PATH . '_templates/footer.php';
    }

    function getBasicReport() {
        //var_dump( $_POST );
        //ini_set('display_errors', 1 );
        $objReportsModel = $this->loadModel('reports');
        $objUserModel = $this->loadModel('users');
        $objCompanyModel = $this->loadModel('company');
        $objLocationModel = $this->loadModel('location');

        if( $_POST['company'] != '' ) {
            $arrCU = $objCompanyModel->getCompanyDirector( $_POST['company'] );
            $iHaveAccess = $arrCU->USER_ID;
        }
        if( $_POST['subc'] != '' ){
            $iHaveAccess = $_POST['subc'];
        }
        if( $_POST['location'] != '' ) {
            $arrLU = $objLocationModel->getLocationManager( $_POST['location'] );
            $iHaveAccess = $arrLU->MANAGER;
        }
        $arrOptions['HVACESS'] = $iHaveAccess;

        if( $_POST['ponumber'] != '' ) {
            $arrOptions['ponumber'] = $_POST['ponumber'];
        }

        if( $_POST['q_status'] != '' ) {
            $arrOptions['q_status'] = $_POST['q_status'];
        }

        $arrInventory = $objReportsModel->getIMEIByHaveAccess( $arrOptions );

        $arrOptions['limit_per_page'] = 10;
        $iTotalRecords = count( $arrInventory ) ;
        $iTotalPages = ceil( $iTotalRecords / $arrOptions['limit_per_page'] );

        if(!isset($_POST['page'])) {
            $_POST['page'] = 1;
        }

        if( strlen($_POST['page'] ) == 0 ){
            $_POST['page'] = 1;
        }

        if( $_POST['page'] <= 1 ){
            $_POST['page'] = 1;
            $arrOptions['low_limit'] =  ( $_POST['page'] - 1 ) * $arrOptions['limit_per_page'] ;
        } else {
            $arrOptions['low_limit'] =  ( ( $_POST['page'] - 1 ) * $arrOptions['limit_per_page'] ) + 1;
        }

        if( $_POST['page'] > $iTotalPages ){
            $_POST['page'] = $iTotalPages;
        }

        $arrOptions['low_limit'] =  ( $_POST['page'] - 1 ) * $arrOptions['limit_per_page'];
        $arrInventory = $objReportsModel->getIMEIByHaveAccess( $arrOptions );
        require VIEW_PATH . 'reports/bp.php';
    }
}