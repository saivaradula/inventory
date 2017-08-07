<?php
class cleanModel extends Model {
    function cleanData() {
        $this->deleteData('', INV, false);
        $this->deleteData('', INV_PO, false);
        $this->deleteData('', LOG, false);
        $this->deleteData('', LOCATION, false);
        $this->deleteData('', AGENTS, false);
        $this->deleteData('', IMP, false);
        $this->deleteData('', ACTIVATE, false);
        $this->deleteData('ID > 2', COMPANY_USERS, false);
        $this->deleteData('ID > 1', CREDS, false);
    }

    function cleanInventory() {
        $this->deleteData('', INV, false);
        $this->deleteData('', INV_PO, false);
        $this->deleteData('', LOG, false);
        $this->deleteData('', IMP, false);
        $this->deleteData('', ACTIVATE, false);

    }

}