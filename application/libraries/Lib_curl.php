<?php

Class Lib_curl {
    function url_execute($url){
    // create curl resource 
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url); 

    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output['sniff'] = curl_exec($ch);
    $output['test'] = curl_getinfo($ch);
    $result=$output['sniff'];
    $obj = json_decode($result, true);
    print_r($obj);

    // close curl resource to free up system resources 
    curl_close($ch); 

    }
}