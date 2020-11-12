<?php

//Mathpix Configuration Settings
$mathpix_url = "https://api.mathpix.com/v3/latex";
$mathpix_app_id = "mathpix_app_id";
$mathpix_app_key = "key";
$mathpix_formats = "latex_simplified";
$mathpix_method = 'POST';
$mathpix_content_type = "application/json";

$mathpix_header_array = array("Content-Type: $mathpix_content_type", "app_id: $mathpix_app_id", "app_key: $mathpix_app_key" ,  "formats: $mathpix_formats");    //The array of headers of Mathpix Request


//SOLR Configuration Settings
$escapeCharacters = array('/','\\','+','-','&&','||','!','(',')','{','}','[',']','^','~','*','?',':');
$replacedCharacters = array('\/','\\\\','\+','\-','\&&','\||','\!','\(','\)','\{','\}','\[','\]','\^','\~','\*','\?','\:');

$search_field = "Mathpix_API_Latex";
$import_type = "delta-import";
$base_url = "base_url";
$search_url = $base_url . "select?q=";
$additionalParams = "&rows=20&sort=score+desc&fl=id+Mathpix_API_Response+score";
$index_url = $base_url . "dataimport?command=";


/*The fields of the table*/
$fields = array("Image_Id","Mathpix_API_Response","Vision_API_Response","created_at","updated_at");


//Format of the 'updates' array, for updating the response in DB.
$updates = array(
        "Mathpix_API_Response"=>"\"updated response\"",
        "Vision_API_Response"=>"\"no vision yet\"",
        "updated_at"=>"CURRENT_TIMESTAMP");
