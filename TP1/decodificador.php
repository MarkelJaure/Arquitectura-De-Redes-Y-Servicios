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
    $fh = fopen('diccionario.txt', 'r');
    while ($line = fgets($fh)) {
        array_push($aDiccionario, $line);
    }
    fclose($fh);
    return $aDiccionario;
}