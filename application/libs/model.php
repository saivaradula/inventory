<?php

	class Model {
		public $objDBConn = NULL;

		function __construct() { $this->openDatabaseConnection(); }

		private function openDatabaseConnection() {
			$options = array( PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING );
			$this->objDBConn = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
		}

		public function addData($strTable, $arrDetails) {
			foreach ( $arrDetails as $strColumn => $strValue ) {
				$strFields .= $strColumn . ", ";
				$strFieldValues .= '"' . $strValue . '", ';
			}
			$strFields = substr(trim($strFields), 0, -1);
			$strFieldValues = substr(trim($strFieldValues), 0, -1);
			$strQuery = "INSERT INTO " . $strTable . " (" . $strFields . ") VALUES ( " . $strFieldValues . ") ";
			//echo $strQuery . "<br />"; exit;
			$this->objDBConn->query($strQuery);
			return $this->objDBConn->LastInsertId();
		}

		public function updateData($table, $arrDetails, $where) {
			foreach ( $arrDetails as $strColumn => $strValue ) {
				$fields .= $strColumn . " = '" . $strValue . "', ";
			}
			$fields = substr(trim($fields), 0, -1);
			$strQuery = "UPDATE " . $table . " SET " . $fields . ' WHERE ' . $where;
			//echo $strQuery . "<br />";exit;
			$objStmt = $this->objDBConn->query($strQuery);
			return $objStmt->execute();
		}

		public function getData($arrData, $getAll = false) {
			$fields = ( $arrData [ 'FIELDS' ] == '' ) ? "*" : $arrData [ 'FIELDS' ];
			$table = $arrData [ 'TABLE' ];
			$where = ( $arrData [ 'WHERE' ] ) ? " WHERE " . $arrData [ 'WHERE' ] : "";
			$orderby = '';
			$limit = '';
			$groupby = '';
			if ( $arrData [ 'ORDER' ] != '' ) {
				$orderby = " ORDER BY " . $arrData [ 'ORDER' ];
			}
			if ( $arrData [ 'GROUP' ] != '' ) {
				$groupby = " GROUP BY " . $arrData [ 'GROUP' ];
			}

			if( $arrData['LIMIT_PER_PAGE'] != '' ) {
				$limit = " LIMIT " . $arrData [ 'LIMIT' ] . ", " . $arrData['LIMIT_PER_PAGE'];
			} else {
				if ( is_int($arrData [ 'LIMIT' ]) ) {
					$limit = " LIMIT " . $arrData [ 'LIMIT' ] . ", " . DEFAULT_RECORDS;
				}
			}

			$strQuery = "SELECT " . $fields . " FROM " . $table . $where . $groupby . $orderby . $limit;
            //echo $strQuery . "<br /<br />";
			$objStmt = $this->objDBConn->prepare($strQuery);
			$objStmt->execute();
			return ( $getAll ) ? $objStmt->fetchAll() : $objStmt->fetch();
		}

		public function deleteData($where, $table, $bKeepRecord = true) {
			$strQuery = "UPDATE " . $table . " SET status = " . INACTIVE . " WHERE " . $where;
			if ( !$bKeepRecord ) {
			    if( $where != '' ) { $strQuery = "DELETE FROM " . $table . " WHERE " . $where;}
			    else { $strQuery = "DELETE FROM " . $table; }
			}
			$objStmt = $this->objDBConn->query($strQuery);
			return $objStmt->execute();
		}

		public function getCount($strPrimaryKey = 'id', $arrData) {
			$where = ( $arrData [ 'WHERE' ] ) ? " WHERE " . $arrData [ 'WHERE' ] : "";
			$strQuery = "SELECT count( " . $strPrimaryKey . ") AS RECORDS FROM " . $arrData [ 'TABLE' ] . $where;
			$objStmt = $this->objDBConn->prepare($strQuery);
			$objStmt->execute();
			return $objStmt->fetch();
		}

		public function executeQuery($strQuery) {
			$objStmt = $this->objDBConn->prepare($strQuery);
			$objStmt->execute();
		}
	}