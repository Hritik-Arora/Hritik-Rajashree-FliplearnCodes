<?php

require_once "Manager.php";
require_once "APIRequest.php";
require_once "TableStore.class.php";
require_once "SolrInteraction.php";
require_once "DBInteractionNew.php";

class Factory {
	public function getManagerObj() {
		return (new Manager($this->getDBObj(), $this->getAPIObj(),$this->getSolrObj()));
	}

	private function getAPIObj() {
		return (new APIRequest());
	}

	private function getDBObj() {
		return (new TableStore($this->getDBConn()));
	}
    
    private function getSolrObj() {
        return (new SolrInteraction());
    }
    
    private function getDBConn(){
        return (new DBInteractionNew());
    }
}
