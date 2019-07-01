<?php

require_once "Manager.php";
require_once "APIRequest.php";
require_once "TableStore.class.php";
require_once "SolrInteraction.php";

class Factory {
	function getManagerObj() {
		return (new Manager($this->getDBObj(), $this->getAPIObj(),$this->getSolrObj()));
	}

	function getAPIObj() {
		return (new APIRequest());
	}

	function getDBObj() {
		return (new TableStore());
	}
    
    function getSolrObj() {
        return (new SolrInteraction());
    }
}
