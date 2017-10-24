<?php
if( move_uploaded_file($tmp_name, IMP_DATA . "/" . $name) ) {

    $handle = fopen(IMP_DATA . "/" . $name, "r");
    $i =0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if( $data[0] != 'IMEI' ){
            $arrEsc = explode("`", $data[0]);
            $data[0] = ($arrEsc[1] != '' ) ? $arrEsc[1] : $arrEsc[0];
            if( $data[0] != '' ){
                $arrVData[$i] = $data[0];
                $i++;
            }
        }
    }

    $handle = fopen(IMP_DATA . "/" . $name, "r");
    $i =0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if( $data[0] != 'IMEI' ){
            $arrEsc = explode("`", $data[0]);
            $data[0] = ($arrEsc[1] != '' ) ? $arrEsc[1] : $arrEsc[0];
            if( $data[0] != '' ){
                $arrPData[$i] = $data[1];

                $i++;
            }
        }
    }

    $arrPData = $this->removeDups($arrPData);


    if( $this->showDups($arrVData) == 1 ) {
        $strMsg = "Data Import failed. Your data contains duplicate entries. 
                                    Please check uploaded CSV file and re-upload again.";
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

            //echo $strChkPImp; exit;
            $arrRes = $objAgentModel->getAgentPromocodes($strChkPImp);


            if( count($arrRes) == count( $arrPData ) ){
                $handle = fopen(IMP_DATA . "/" . $name, "r");
                $arrData['added_on'] = $this->now();
                $arrData['added_by'] = $this->loggedInUserId();
                $arrData['company'] = $this->getLoggedInUserCompanyID();
                $i = 0;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if( $data[0] != 'IMEI' ){
                        $arrEsc = explode("`", $data[0]);
                        $data[0] = ($arrEsc[1] != '' ) ? $arrEsc[1] : $arrEsc[0];
                        $arrData['imei'] = $data[0];
                        $arrData['promocode'] = $data[1];
                        $objInvModel->importActivatedRecord($arrData);
                    }
                }
                $strMsg = "Data Import Success. Please Activate by Checking data.";
            } else {
                $strMsg = "Data Import failed. Your CSV data contains Invalid PROMOCODES";
            }
        }

    }

    /*// Read CSV and add to DB.
    $handle = fopen(IMP_DATA . "/" . $name, "r");
    $arrData['added_on'] = $this->now();
    $i = 0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if( $data[0] != 'IMEI' ){
            $arrData['imei'] = $data[0];
            $objInvModel->importActivatedRecord($arrData);

        }
    }
    $strMsg = "Data Import Success. Please Activate by Checking data.";*/
}