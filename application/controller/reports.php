<?php
class Reports extends Controller {
    function index() {
        require VIEW_PATH . '_templates/header.php';
        require VIEW_PATH . '_templates/footer.php';
    }

    function basic1() {
        require VIEW_PATH . '_templates/header.php';
        require VIEW_PATH . 'reports/b.php';
        require VIEW_PATH . '_templates/footer.php';
    }

    function basic() {
        //ini_set('display_errors', 1 );
        require VIEW_PATH . '_templates/header.php';
        $objInvModel = $this->loadModel('inventory');
        $objLogModel = $this->loadModel('log');
        $objCompModel = $this->loadModel('company');
        $objUserModel = $this->loadModel('users');
        $objLocModel = $this->loadModel('location');
        $objReportsModel = $this->loadModel('reports');

        //$arrObjCUsers = $objCompanyModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);

        $iAdmin = 0;
        $bLDD = 1;
        $bSubC = $_SESSION['HAS_SCS'];

        if( $bSubC ) {
            if( $this->getLoggedUserRole() == 'DIRECTOR' ){
                $bSubC = 1;
            } else {
                $bSubC = 0;
            }
        }

        if( $this->getLoggedUserRole() == 'MANAGER' ){
            $bLDD = 0;
        }

        if ( $this->isSuperAdmin() ) {
            $iAdmin = 1;
            $bSubC = 1;
            $arrObjC = $objCompModel->getCompanies('COMPANY');
        }

        if( $bSubC ) { // only for directors and above
            if( $iAdmin == 0 ){
                $arrObjCUsers = $objCompModel->getCompanyUsers('SUB CONTRACTOR', $this->getLoggedInUserCompanyID(), $this->loggedInUserId(), $arrOptions);
            }
        } else { // for below directors level.
            $arrObjLocation = $objLocModel->getLocationByUserId($this->loggedInUserId(), $this->getLoggedUserRole(), 'shipping');
        }

        $iCompany = $this->getLoggedInUserCompanyID();
        $iSubCID = $this->loggedInUserId();
        $iRoleId = $this->getLoggedUserRoleID();


        require VIEW_PATH . 'reports/b.php';
        require VIEW_PATH . '_templates/footer.php';
    }

    function getChildUsers( $iHaveAccess, $objUserModel, $iCompany, $iUserId ) {
        $arrUsers = $objUserModel->getCompanyUserFrom( $iCompany, $iUserId );
        $iHaveAccess .= $iUserId . ",";
        for( $i=0; $i <= count( $arrUsers ); $i++ ){
            if( $arrUsers[$i]->USER_ID != '' ) {
                //$iHaveAccess .= $arrUsers[$i]->USER_ID . ",";
                $iHaveAccess = $this->getChildUsers( $iHaveAccess, $objUserModel, $iCompany, $arrUsers[$i]->USER_ID );
            }
        }
        return $iHaveAccess;
    }

    public function getIMEILog( $objLogModel, $strIMEI) {
        $arrLog = $objLogModel->getLog( $strIMEI );
        $strLog = '<ul>';
        /*for( $i=0; $i< count( $arrLog ); $i++ ){
            $strLog .= "<li>" . $arrLog[$i]->DESCRIPTION . " </li>";
        }*/
        if( $arrLog->IMEI_STATUS == 'ASSIGNED'){
            $strLog .= "<li>" . $arrLog->DESCRIPTION . "</li>";
        } else {
            $strLog .= "<li>" . $arrLog->DESCRIPTION . " with PO Number - <span style='font-size:10px'> " . $arrLog->PO_NUMBER . " </span> </li>";
        }

        $strLog .= '</ul>';
        return $strLog;
    }


    function getBasicReport() {
        //print_r( $_POST );
        //ini_set('display_errors', 1 );
        $objReportsModel = $this->loadModel('reports');
        $objUserModel = $this->loadModel('users');
        $objCompanyModel = $this->loadModel('company');
        $objLocationModel = $this->loadModel('location');
        $objAgentsModel = $this->loadModel('agents');

        $iCompany = $this->getLoggedInUserCompanyID();
        $iUserId = $this->loggedInUserId();
        $iRoleId = $this->getLoggedUserRoleID();

        if($_POST['promocode'] != ''){
            $arrAgent = $objAgentsModel->getAgentPromocodes( "'" . $_POST['promocode'] . "'" );
            if(count($arrAgent)) {
                $arrInventory = $objReportsModel->getIMEIByAgents( $arrAgent[0]->USER_ID );

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
                $arrInventory = $objReportsModel->getIMEIByAgents( "'" . $arrAgent[0]->USER_ID . "'");

                $objLogModel = $this->loadModel('log');
                foreach ( $arrInventory AS $arrInv ) {
                    $arrInv->LOG = $this->getIMEILog( $objLogModel, $arrInv->IMEI );
                }
            }

            require VIEW_PATH . 'reports/promocode.php';
        } else {
            if($_POST['IMEI'] != '' ) {
                //990000862471865
                $arrR = $objReportsModel->getIMEILog( $_POST['IMEI'] );
                require VIEW_PATH . 'reports/imei.php';
            } else {

                if( $_POST['company'] != '' ) {
                    $arrCU = $objCompanyModel->getCompanyDirector( $_POST['company'] );
                    $iUserId = $arrCU->USER_ID;
                }

                if( $_POST['subc'] != '' ){
                    $iUserId = $_POST['subc'];
                }

                if( $_POST['location'] != '' ) {
                    $arrLU = $objLocationModel->getLocationManager( $_POST['location'] );
                    $iUserId = $arrLU->MANAGER;
                }

                $iHaveAccess = '';
                if($iUserId > 0 ){
                    $iHaveAccess = $this->getChildUsers( $iHaveAccess, $objUserModel, $iCompany, $iUserId );
                    $iHaveAccess = substr( $iHaveAccess, 0, strlen($iHaveAccess)-2 );
                    $arrOptions['HVACESS'] = $iHaveAccess;
                } else {
                    $arrOptions['HVACESS'] = 0;
                }

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

                $objLogModel = $this->loadModel('log');
                foreach ( $arrInventory AS $arrInv ) {
                    $arrInv->LOG = $this->getIMEILog( $objLogModel, $arrInv->IMEI );
                }
                require VIEW_PATH . 'reports/bp.php';
            }
        }





    }
}