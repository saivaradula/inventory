<?php
if( move_uploaded_file($tmp_name, IMP_DATA . "/" . $name) ) {
    define( 'EXCEL_LIB', 'application/libs/excel');
    include EXCEL_LIB . '/Classes/PHPExcel.php';
    require_once EXCEL_LIB . '/Classes/PHPExcel/IOFactory.php';
    $objPHPExcel = PHPExcel_IOFactory::load(IMP_DATA . "/" . $name);
    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

    $j =0;
    for ($i=1; $i <= count($allDataInSheet); $i++ ) {
        if( $allDataInSheet[$i]['A'] != 'IMEI' ){
            $arrEsc = explode("`", $allDataInSheet[$i]['A'] );
            $data[0] = ($arrEsc[1] != '' ) ? $arrEsc[1] : $arrEsc[0];
            if( $data[0] != '' ){
                $arrVData[$i] = $data[0];
                $j++;
            }
        }
    }

    $j =0;
    for ($i=1; $i <= count($allDataInSheet); $i++ ) {
        if( $allDataInSheet[$i]['A'] != 'IMEI' ){
            $arrEsc = explode("`", $allDataInSheet[$i]['A']);
            $data[0] = ($arrEsc[1] != '') ? $arrEsc[1] : $arrEsc[0];
            if ($data[0] != '') {
                $arrPData[$i] = $allDataInSheet[$i]['B'];
                $j++;
            }
        }
    }

    $arrPData = $this->removeDups($arrPData);
    if( $this->showDups($arrVData) == 1 ) {
        $strMsg = "Data Import failed. Your data contains duplicate entries. 
                                    Please check uploaded CSV/XLS file and re-upload again.";
    } else {

        $strChkImp = '';
        $strChkPImp = '';

        for( $i=0; $i < count($arrVData); $i++ ){
            $strChkImp .= "'" . $arrVData[$i] . "', ";
        }

        for( $i=0; $i < count($arrPData); $i++ ){
            $strChkPImp .= "'" . $arrPData[$i] . "', ";
        }


        $strChkImp = substr($strChkImp, 0, strlen($strChkImp)-2);
        $strChkPImp = substr($strChkPImp, 0, strlen($strChkPImp)-2);

        $arrRes = $objInvModel->getImportActivationRecord($strChkImp);

        if( $arrRes !== false ){
            $strMsg = "Data Import failed. Your CSV data contains IMEI numbers which are already uploaded or Activated.";
        } else {
            $arrRes = $objAgentModel->getAgentPromocodes($strChkPImp);
            if( count($arrRes) == count( $arrPData ) ){
                //$handle = fopen(IMP_DATA . "/" . $name, "r");
                $arrData['added_on'] = $this->now();
                $arrData['added_by'] = $this->loggedInUserId();
                $arrData['company'] = $this->getLoggedInUserCompanyID();
                $j = 0;
                for ($i=1; $i <= count($allDataInSheet); $i++ ) {
                    if( $allDataInSheet[$i]['A'] != 'IMEI' ){
                        $arrEsc = explode("`", $allDataInSheet[$i]['A']);
                        $data[0] = ($arrEsc[1] != '' ) ? $arrEsc[1] : $arrEsc[0];
                        $arrData['imei'] = $allDataInSheet[$i]['A'];
                        $arrData['promocode'] = $allDataInSheet[$i]['B'];
                        $objInvModel->importActivatedRecord($arrData);
                    }
                }
                $strMsg = "Data Import Success. Please Activate by Checking data.";
            } else {
                $strMsg = "Data Import failed. Your CSV data contains Invalid PROMOCODES";
            }
        }

    }

}