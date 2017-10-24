<?php
if( move_uploaded_file($tmp_name, IMP_DATA . "/" . $name) ) {

    $handle = fopen(IMP_DATA . "/" . $name, "r");
    $i =0;

    $bProceed = 0;

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        if( $data[0] != 'PO_NUMBER' ){
            if( $data[0] != '' ){
                if( $data[1] != '' ){
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
        $handle = fopen(IMP_DATA . "/" . $name, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if( $data[0] != 'PO_NUMBER' ){
                $arrEsc = explode("`", $data[1]);
                $data[1] = ($arrEsc[1] != '' ) ? $arrEsc[1] : $arrEsc[0];
                if( $data[1] != '' ){
                    $arrVData[$i] = $data[1];
                    $i++;
                }
            }
        }

        if( $this->showDups($arrVData) == 1 ) {
            $strMsg = "Data Import failed. Your data contains duplicate entries. Please check uploaded CSV file and re-upload again.";
        } else {
            // remove duplicate IMEI from array which are already in DB.
            $strChkImp = '';
            for( $i=0; $i < count($arrVData); $i++ ){
                $strChkImp .= "'" . $arrVData[$i] . "', ";
            }
            $strChkImp = substr($strChkImp, 0, strlen($strChkImp)-2);
            $arrRes = $objInvModel->getImportRecord($strChkImp);
            //var_dump($arrRes ); exit;
            //echo count( $arrRes );


            //if( $arrRes !== false ){
            if( count( $arrRes ) ){
                $strMsg = "Data Import failed. Your CSV data contains 
                                            IMEI numbers which are already uploaded on <strong>" . $this->revDateTime($arrRes->added_on) . "</strong>";
            } else {
                $handle = fopen(IMP_DATA . "/" . $name, "r");
                $arrData['added_on'] = $this->now();
                $arrData['added_by'] = $this->loggedInUserId();
                $arrData['company'] = $this->getLoggedInUserCompanyID();
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if( $data[0] != 'PO_NUMBER' ){
                        if( $data[1] != '' ){
                            $arrData['po_num'] = $data[0];
                            $arrEsc = explode("`", $data[1]);
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