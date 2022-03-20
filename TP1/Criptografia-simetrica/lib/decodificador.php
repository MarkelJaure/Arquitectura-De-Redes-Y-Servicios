<?php
require 'cifrador.php';

function descifrarAFuerzaBruta($aMessage)
{
    $somePosiblesResults = getAllPosiblesMessages($aMessage);
    $aDiccionario = readDiccionario();
    $someCounts = array();
    foreach ($somePosiblesResults as $aPosibleResult) {
        $somePalabrasOfPosibleResult = explode(" ", $aPosibleResult);
        $countOfMatches = 0;

        foreach ($somePalabrasOfPosibleResult as $aPalabra) {
            if (matchPalabraWithDiccionario($aPalabra, $aDiccionario)) {
                $countOfMatches += 1;
            }
        }

        array_push($someCounts, $countOfMatches);
    }
    $largest = max($someCounts);
    $indexOfLargest = array_search($largest, $someCounts);
    $bestPossibleMessage = $somePosiblesResults[$indexOfLargest];



    return array($bestPossibleMessage, $indexOfLargest);
}

function matchPalabraWithDiccionario($aPalabra, $aDiccionario)
{
    $aResult = array_search($aPalabra . "\n", $aDiccionario);
    return is_int($aResult);
}



function readDiccionario()
{
    $aDiccionario = array();

    if (!file_exists("lib/diccionario.txt")) {
        die("File not found");
    }

    if ($file = fopen("lib/diccionario.txt", "r")) {
        while (!feof($file)) {
            $line = fgets($file);
            array_push($aDiccionario, $line);
        }
        fclose($file);
    } else {
        echo 'fopen failed. reason: ', $php_errormsg;
    }
    return $aDiccionario;
}

function getAllPosiblesMessages($aMessage)
{
    global $arrayAbecedario;
    $somePosiblesResults = array();
    for ($aKey = 0; $aKey < count($arrayAbecedario); $aKey++) {
        array_push($somePosiblesResults, cifrar($aMessage, $aKey, False));
    }

    return $somePosiblesResults;
}
