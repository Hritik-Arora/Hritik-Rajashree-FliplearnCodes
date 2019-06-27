<?php

require_once "dbConn.php";
require_once "Factory.php";
require_once "config.php";



$doubt_image = "Q4.png";            //The image whose API response we want to store



$objFactory = new Factory();

//Manager Object Created
$objManager = $objFactory->getManagerObj();
//Getting work done from Manager
$objManager->getWorkDone($doubt_image,$mathpix_url,$mathpix_header_array,'','POST', $table_name);