<?php
if( move_uploaded_file($tmp_name, IMP_DATA . "/" . $name) ) {
    define( 'EXCEL_LIB', 'application/libs/excel');
    include EXCEL_LIB . '/Classes/PHPExcel.php';
    require_once EXCEL_LIB . '/Classes/PHPExcel/IOFactory.php';
    $handle = fopen(IMP_DATA . "/" . $name, "r");
    $objPHPExcel = PHPExcel_IOFactory::load(IMP_DATA . "/" . $name);
    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

    $j =0;

    for ($i=1; $i <= count($allDataInSheet); $i++ ) {
        if( $allDataInSheet[$i]['A'] != 'PO_NUMBER' ){
            if(  $allDataInSheet[$i]['A'] != '' ){
                if(  $allDataInSheet[$i]['B'] != '' ){
                    $bProceed = 1;
                } else {
                    $bProceed = 0;
                }
            } else {
                $bProceed = 0;
            }
        }
    }



    if( $bProceed  ) {
        for ($i=1; $i <= count($allDataInSheet); $i++ ) {
            if( $allDataInSheet[$i]['A'] != 'PO_NUMBER' ){
                $arrEsc = explode("`", $allDataInSheet[$i]['A']);
                $data[1] = ($arrEsc[1] != '' ) ? $arrEsc[1] : $arrEsc[0];
                if( $data[1] != '' ){
                    $arrVData[$j] = $data[1];
                    $j++;
                }
            }
        }


        if( $this->showDups($arrVData) == 1 ) {
            $strMsg = "Data Import failed. Your data contains duplicate entries. Please check uploaded XLS file and re-upload again.";
        } else {

            $strChkImp = '';
            for( $i=0; $i < count($arrVData); $i++ ){
                $strChkImp .= "'" . $arrVData[$i] . "', ";
            }
            $strChkImp = substr($strChkImp, 0, strlen($strChkImp)-2);
            $arrRes = $objInvModel->getImportRecord($strChkImp);

            if( count( $arrRes ) ){
                $strMsg = "Data Import failed. Your XLS data contains 
                    IMEI numbers which are already uploaded on <strong>" .
                        $this->revDateTime($arrRes->added_on) . "</strong>";
            } else {

                $arrData['added_on'] = $this->now();
                $arrData['added_by'] = $this->loggedInUserId();
                $arrData['company'] = $this->getLoggedInUserCompanyID();

                for ($i=1; $i <= count($allDataInSheet); $i++ ) {
                    if( $allDataInSheet[$i]['A'] != 'PO_NUMBER' ){
                        if( $allDataInSheet[$i]['B'] != '' ){
                            $arrData['po_num'] = $allDataInSheet[$i]['A'];
                            $arrEsc = explode("`", $allDataInSheet[$i]['B']);
                            $data[1] = ($arrEsc[1] != '' ) ? $arrEsc[1] : $arrEsc[0];

                            $arrData['imei'] = $data[1];
                            $objInvModel->importRecord($arrData);
                        }

                    }
                }
                $strMsg = "Data Import Success. Please verify data.";

            }
        }
    } else {
        $strMsg = "Error in Uploaded file. Please verify and re-upload file. Some data is empty!!";
    }


}