<?php

//Mathpix Configuration Settings
$mathpix_url = "https://api.mathpix.com/v3/latex";
$mathpix_app_id = "nitigya_kuchhal_fliplearn_com";
$mathpix_app_key = "2e1adf3b5e31ef6d571e";
$mathpix_formats = "latex_simplified";
$mathpix_method = 'POST';
$mathpix_content_type = "application/json";

$mathpix_header_array = array("Content-Type: $mathpix_content_type", "app_id: $mathpix_app_id", "app_key: $mathpix_app_key" ,  "formats: $mathpix_formats");    //The array of headers of Mathpix Request


//SOLR Configuration Settings
$escapeCharacters = array('/','\\','+','-','&&','||','!','(',')','{','}','[',']','^','~','*','?',':');
$replacedCharacters = array('\/','\\\\','\+','\-','\&&','\||','\!','\(','\)','\{','\}','\[','\]','\^','\~','\*','\?','\:');

$search_field = "Mathpix_API_Response";
$import_type = "delta-import";
$base_url = "http://localhost:8983/solr/FliplearnDoubtsDb/";
$search_url = $base_url . "select?q=";
$additionalParams = "&rows=2&sort=score+desc&fl=id+Mathpix_API_Response+score";
$index_url = $base_url . "dataimport?command=";