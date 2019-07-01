<?php

$url = "http://localhost:8983/solr/FliplearnDoubtsDb/select?q=Mathpix_API_Response%3A\"";
        
$escapeCharacters = array('/','\\','+','-','&&','||','!','(',')','{','}','[',']','^','~','*','?',':');
        
$replacedCharacters = array('\/','\\\\','\+','\-','\&&','\||','\!','\(','\)','\{','\}','\[','\]','\^','\~','\*','\?','\:');

$additionalParams = "\"&sort=score+desc&fl=id+Mathpix_API_Response+score";