<?php

function verifyPasswordStrength($requestData)
{
    $noMatchingRules = [];
    
    $rules = '';
    for ($i = 0; $i < count($requestData["rules"]); $i++) {
        $rules .= $requestData["rules"][$i]["rule"].',';
    }

    if ((strripos($rules,'minSize') >= 0) && (strripos($rules,'minSize') != false)) {
        $ruleValue = getCurrentRule($requestData, 'minSize');

        echo 'cheguei aq';
        if (strlen($requestData["password"]) < $ruleValue) {
            $noMatchingRules[] = 'minSize';
        }
    }

    if ((strripos($rules,'minUppercase') >= 0) && (strripos($rules,'minUppercase') != false)) {
        $ruleValue = getCurrentRule($requestData, 'minUppercase');

        if (countUpperCases($requestData["password"]) < $ruleValue) {
            $noMatchingRules[] = 'minUppercase';
        }
    }

    if ((strripos($rules,'minLowercase') >= 0) && (strripos($rules,'minLowercase') != false)) {
        $ruleValue = getCurrentRule($requestData, 'minLowercase');

        if (countLowerCases($requestData["password"]) < $ruleValue) {
            $noMatchingRules[] = 'minLowercase';
        }
    }

    if ((strripos($rules,'minDigit') >= 0) && (strripos($rules,'minDigit') != false)) {
        $ruleValue = getCurrentRule($requestData, 'minDigit');

        if (countDigits($requestData["password"]) < $ruleValue) {
            $noMatchingRules[] = 'minDigit';
        }
    }

    if ((strripos($rules,'minSpecialChars') >= 0) && (strripos($rules,'minSpecialChars') != false)) {
        $ruleValue = getCurrentRule($requestData, 'minSpecialChars');

        if (countSpecialCharacters($requestData["password"]) < $ruleValue) {
            $noMatchingRules[] = 'minSpecialChars';
        }
    }

    if ((strripos($rules,'noRepeted') >= 0) && (strripos($rules,'noRepeted') != false)) {
        $ruleValue = getCurrentRule($requestData, 'noRepeted');

        if (noRepeted($requestData["password"]) > 0) {
            $noMatchingRules[] = 'noRepeted';
        }
    }

    return $noMatchingRules;
}

function getCurrentRule($requestData,string $rule)
{
    $currentRule = '';
    $ruleValue = [];

    for ($i = 0; $i < count($requestData["rules"]); $i++) {
        $currentRule = $requestData["rules"][$i]["rule"];
        if ($currentRule == $rule){
            $ruleValue = ['value' =>$requestData["rules"][$i]["value"]];
            break;
        }
    }

    return $ruleValue;
}

function countUpperCases(string $string) 
{
    $upperCases = preg_match_all("/[A-Z]/", $string);

    return $upperCases;
}

function countLowerCases(string $string)
{
    $lowerCases = preg_match_all("/[a-z]/", $string);

    return $lowerCases;
}

function countDigits(string $string)
{
    $digits = preg_match_all("/[0-9]/", $string);

    return $digits;
}

function countSpecialCharacters(string $string)
{
    $specialChars = preg_match_all("/\W/", $string);

    return $specialChars;
}

function noRepeted(string $string)
{
    $repetitions = preg_match_all('/([a-zA-Z])\1+/', $string);

    return $repetitions;
}

function validateRequest($noMatchingRules)
{
    if (count($noMatchingRules) > 0) {
        $resultArray = array('verify' => false, 'noMatch' => $noMatchingRules);

        return json_encode($resultArray);
    } else {
        $resultArray = array('verify' => true, 'noMatch' => []);

        return json_encode($resultArray);
    }
}