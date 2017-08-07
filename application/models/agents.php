<?php
	class agentsModel extends Model {

	    function getAgentPromocodes( $strChkPImp ) {
            $arrData[ 'FIELDS' ] = "U.USER_ID ";
            $arrData[ 'TABLE' ] = AGENTS . " U";
            $arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
            $arrData[ 'WHERE' ] .= " AND U.PROMOCODE IN (" . $strChkPImp . ")";
            $arrUser = $this->getData($arrData, true);
            return $arrUser;
        }

        function validatePromocode($strPromocode ) {
            $arrData[ 'FIELDS' ] = "U.USER_ID, 'AGENT' ";
            $arrData[ 'TABLE' ] = AGENTS . " U";
            $arrData[ 'WHERE' ] = "U.STATUS = " . ACTIVE ;
            $arrData[ 'WHERE' ] .= " AND LOWER( U.PROMOCODE ) = '" . strtolower($strPromocode) . "'";
            $arrUser = $this->getData($arrData);
            return $arrUser;
        }

		function deleteAgentRecord($iUserId) {
			$arrData[ 'STATUS' ] = INACTIVE;
			$this->updateData(AGENTS, $arrData, "USER_ID = '" . $iUserId . "' ");
		}

		function getAgent( $strAgent ) {
			$arrData[ 'FIELDS' ] = "A.*";
			$arrData[ 'TABLE' ] = AGENTS . " A";
			$arrData[ 'WHERE' ] = "A.USER_ID = '" . $strAgent . "'";
			return $this->getData($arrData);
		}

		function getAgents( $arrOptions = array() ) {
			$arrData[ 'FIELDS' ] = "A.FIRST_NAME, A.LAST_NAME, A.EMAILID, A.Q_STATUS, A.ID, A.USER_ID, A.PHONE, A.PROMOCODE";
			$arrData[ 'FIELDS' ] .= ", ( SELECT C.NAME  FROM " . COMPANY . " C   WHERE
			                             A.PARENT_CMPNY = C.ID   ) AS COMPANY";
			$arrData[ 'TABLE' ] = AGENTS . " A";
			$arrData[ 'WHERE' ] = "STATUS = " . ACTIVE;
			$arrData[ 'WHERE' ] .= ($arrOptions['q_status']) ? " AND A.Q_STATUS = '" . $arrOptions['q_status'] . "'" : "";
			$arrData[ 'WHERE' ] .= ($arrOptions['agent_type']) ? " AND A.AGENT_TYPE = '" . $arrOptions['agent_type'] . "'" : "";
			$arrData[ 'WHERE' ] .= ($arrOptions['company']) ? " AND A.PARENT_CMPNY = '" . $arrOptions['company'] . "'" : "";
			$arrData[ 'WHERE' ] .= ($arrOptions['created'] > 0) ? " AND A.CREATED_BY = '" . $arrOptions['created'] . "'" : "";
			$arrData[ 'WHERE' ] .= ($arrOptions['action'] != '' ) ? " AND A.ACTION = '" . $arrOptions['action'] . "'" : "";
			$arrData[ 'WHERE' ] .= ($arrOptions['location'] != '' ) ? " AND A.LOCATION_ID = '" . $arrOptions['location'] . "'" : "";
			$arrData[ 'WHERE' ] .= ($arrOptions['id'] != '' ) ? " AND A.USER_ID = '" . $arrOptions['id'] . "'" : "";

			return $this->getData($arrData, true);
		}

		function updateAgent( $arrPost ) {
			$arrData['FIRST_NAME'] = $arrPost['firstname'];
			$arrData['LAST_NAME'] = $arrPost['lastname'];

			$arrData['STATE'] = $arrPost['state'];
			$arrData['ZIPCODE'] = $arrPost['zipcode'];
			$arrData['USAC_FORM'] = $arrPost['usac'];
			$arrData['BATCH_DATE'] = $arrPost['batchdate'];
			$arrData['AG_GROUP'] = $arrPost['group'];
			$arrData['DMA'] = $arrPost['dma'];
			$arrData['BATCH_YEAR'] = $arrPost['batchyear'];
			$arrData['ENROLLMENT_NUMBER'] = $arrPost['enrollnumber'];
			$arrData['ENROLLMENT_CHANNEL'] = $arrPost['enrollchannel'];
			$arrData['Q_STATUS'] = $arrPost['qstatus'];

			$arrData['STATUS_ID'] = $arrPost['status_id'];
            $arrData['PROMOCODE'] = $arrPost['promocode'];

			if( $arrPost['HEADSHOT_FILE']!= '' ){
				$arrData['HEADSHOT_FILE'] = $arrPost['HEADSHOT_FILE'];
			}

			if( $arrPost['GOVID_FILE'] != '' ){
				$arrData['GOVID_FILE'] = $arrPost['GOVID_FILE'];
			}

			if( $arrPost['DISCLOSURE_FILE'] != '' ){
				$arrData['DISCLOSURE_FILE'] = $arrPost['DISCLOSURE_FILE'];
			}

			if( $arrPost['BG_AUTH_FILE'] != '' ){
				$arrData['BG_AUTH_FILE'] = $arrPost['BG_AUTH_FILE'];
			}

			if( $arrPost['COMP_CERT_FILE'] != '' ){
				$arrData['COMP_CERT_FILE'] = $arrPost['COMP_CERT_FILE'];
			}

			$arrData['PHONE'] = $arrPost['phone'];
			//$arrData['SELF_ACTION'] = $arrPost['saction'];
			$this->updateData(AGENTS, $arrData, "USER_ID = '" . $arrPost['userid'] . "' ");
		}

		function addAgents( $arrPost ) {
			$arrData['FIRST_NAME'] = $arrPost['firstname'];
			$arrData['LAST_NAME'] = $arrPost['lastname'];
			$arrData['EMAILID'] = $arrPost['email'];
			$arrData['STATE'] = $arrPost['state'];
			$arrData['ZIPCODE'] = $arrPost['zipcode'];
			$arrData['USAC_FORM'] = $arrPost['usac'];
			$arrData['BATCH_DATE'] = $arrPost['batchdate'];
			$arrData['AG_GROUP'] = $arrPost['group'];
			$arrData['DMA'] = $arrPost['dma'];
			$arrData['BATCH_YEAR'] = $arrPost['batchyear'];
			$arrData['PARENT_CMPNY'] = $arrPost['parent'];
			$arrData['LOCATION_ID'] = $arrPost['location'];
			$arrData['PROMOCODE'] = $arrPost['promocode'];

			$arrData['ENROLLMENT_NUMBER'] = $arrPost['enrollnumber'];
			$arrData['ENROLLMENT_CHANNEL'] = $arrPost['enrollchannel'];
			$arrData['Q_STATUS'] = 'QUALIFIED';
			$arrData['STATUS_ID'] = 1;
			$arrData['CREATED_ON'] = $arrPost['createdon'];
			$arrData['CREATED_BY'] = $arrPost['createdby'];
			$arrData['HEADSHOT_FILE'] = $arrPost['HEADSHOT_FILE'];
			$arrData['GOVID_FILE'] = $arrPost['GOVID_FILE'];
			$arrData['DISCLOSURE_FILE'] = $arrPost['DISCLOSURE_FILE'];
			$arrData['BG_AUTH_FILE'] = $arrPost['BG_AUTH_FILE'];
			$arrData['COMP_CERT_FILE'] = $arrPost['COMP_CERT_FILE'];
			$arrData['USER_ID'] = $arrPost['userid'];
			$arrData['PHONE'] = $arrPost['phone'];
			$arrData['ACTION'] = $arrPost['action'];

			$this->addData(AGENTS, $arrData);
		}
	}