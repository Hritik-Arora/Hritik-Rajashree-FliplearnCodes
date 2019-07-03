<?php

require_once "dbConn.php";
require_once "Factory.php";



$doubt_image = "Q28.png";            //The image whose API response we want to store



$objFactory = new Factory();

//Manager Object Created
$objManager = $objFactory->getManagerObj();
//Getting work done from Manager
$objManager->getWorkDone($doubt_image, $table_name);

