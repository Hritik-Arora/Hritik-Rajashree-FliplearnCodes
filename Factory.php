<?php

require_once "Manager.php";
require_once "APIRequest.php";
require_once "TableStore.class.php";

class Factory {
	function getManagerObj() {
		return (new Manager($this->getDBObj(), $this->getAPIObj()));
	}

	function getAPIObj() {
		return (new APIRequest());
	}

	function getDBObj() {
		return (new TableStore());
	}
}
