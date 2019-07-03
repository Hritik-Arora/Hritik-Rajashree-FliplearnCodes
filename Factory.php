<?php

require_once "Manager.php";
require_once "APIRequest.php";
require_once "TableStore.class.php";
require_once "SolrInteraction.php";

class Factory {
	public function getManagerObj() {
		return (new Manager($this->getDBObj(), $this->getAPIObj(),$this->getSolrObj()));
	}

	private function getAPIObj() {
		return (new APIRequest());
	}

	private function getDBObj() {
		return (new TableStore());
	}
    
    private function getSolrObj() {
        return (new SolrInteraction());
    }
}
