<?php

function getCurrentRule($requestData,string $rule)
{
    $currentRule = '';
    $ruleValue = [];

    for ($i = 0; $i < count($requestData["rules"]); $i++) {
        $currentRule = $requestData["rules"][$i]["rule"];
        if ($currentRule == $rule){
            $ruleValue = ['value' =>$requestData["rules"][$i]["value"]];
            echo 'rule value' . $ruleValue;
            break;
        }
    }

    return $ruleValue;
}

function countUpperCases(string $string) 
{
    $upperCases = mb_strlen(preg_replace(' /[^\p{Lu}]/u ','', $string));

    var_dump($upperCases);

    return $upperCases;
}