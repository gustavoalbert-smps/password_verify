<?php

include_once 'CurlConnection.php';

$curl = connect('http://localhost:8000/verify/');

$requestResult = json_decode(curl_exec($curl), true);

echo verifyPasswordStrength(end($requestResult));

function verifyPasswordStrength($requestData)
{
    $noMatchingRules = [];
    
    $rules = '';
    for ($i = 0; $i < count($requestData["rules"]); $i++) {
        $rules .= $requestData["rules"][$i]["rule"].',';
    }

    if (strripos($rules,'minSize')) {
        $currentRule = '';
        $fullRule = [];
        
        while ($currentRule != 'minSize') {
            for ($i = 0; $i < count($requestData["rules"]); $i++) {
                $currentRule = $requestData["rules"][$i]["rule"];
                $fullRule = ['rule' => $requestData["rules"][$i]["rule"],'value' =>$requestData["rules"][$i]["value"]];
            } 
        }

        if (count($requestData["password"]) < $fullRule["value"]) {
            $noMatchingRules[] = 'minSize';
        }
    }

    if (count($noMatchingRules) > 0) {
        $resultArray = array('verify' => false, 'noMatch' => $noMatchingRules);

        return json_encode($resultArray);
    } else {
        $resultArray = array('verify' => true, 'noMatch' => []);

        return json_encode($resultArray);
    }
}