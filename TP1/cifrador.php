<?php

$arrayAbecedario = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

function cifrar($aMessage, $aKey, $isCifrarActivated)
{

    global $arrayAbecedario;

    $somePalabras = explode(" ", $aMessage);

    for ($n = 0; $n < count($somePalabras); $n++) {

        $somePalabras[$n] = desplazarPalabra($somePalabras[$n], $aKey, $isCifrarActivated);
    }

    return join(" ", $somePalabras);
}

function desplazarPalabra($aPalabra, $aKey, $isCifrarActivated)
{
    $newPalabra = str_split($aPalabra);
    for ($i = 0; $i < count($newPalabra); $i++) {
        $newPalabra[$i] = desplazarLetra($aPalabra[$i], $aKey, $isCifrarActivated);
    }

    return join("", $newPalabra);
}

function desplazarLetra($aLetra, $aKey, $isCifrarActivated)
{
    global $arrayAbecedario;

    $indexOfLetra = array_search($aLetra, $arrayAbecedario);
    $modOfarrayAbecedario = count($arrayAbecedario);

    if ($isCifrarActivated) {
        $newLetra = $arrayAbecedario[((int)$indexOfLetra + $aKey) % $modOfarrayAbecedario];
    } else {
        $abs = ((int)$indexOfLetra - $aKey) % $modOfarrayAbecedario;
        if ($abs < 0) {
            $abs += $modOfarrayAbecedario;
        }
        $newLetra = $arrayAbecedario[$abs];
    }

    return $newLetra;
}

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

function getAllPosiblesMessages($aMessage)
{
    global $arrayAbecedario;
    $somePosiblesResults = array();

    for ($aKey = 0; $aKey < count($arrayAbecedario); $aKey++) {
        array_push($somePosiblesResults, cifrar($aMessage, $aKey, False));
    }

    return $somePosiblesResults;
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
