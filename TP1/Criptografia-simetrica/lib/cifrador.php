<?php

$arrayAbecedario = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

function cifrar($aMessage, $aKey, $isCifrarActivated)
{
    $somePalabras = explode(" ", $aMessage);

    for ($n = 0; $n < count($somePalabras); $n++) {

        $somePalabras[$n] = desplazarPalabra($somePalabras[$n], $aKey, $isCifrarActivated);
    }

    return join(" ", $somePalabras);
}

function desplazarPalabra($aPalabra, $aKey, $isCifrarActivated)
{
    $newPalabra = stringToChars($aPalabra);
    for ($i = 0; $i < count($newPalabra); $i++) {
        $newPalabra[$i] = desplazarLetra($aPalabra[$i], $aKey, $isCifrarActivated);
    }

    return join("", $newPalabra);
}

function desplazarLetra($aLetra, $aKey, $isCifrarActivated)
{
    global $arrayAbecedario;

    $indexOfLetra = array_search($aLetra, $arrayAbecedario);
    $newIndexOfLetra = getNewIndex($indexOfLetra, $aKey, $isCifrarActivated);
    $newLetra = $arrayAbecedario[$newIndexOfLetra];

    return $newLetra;
}

function getNewIndex($indexOfLetra, $aKey, $isCifrarActivated)
{
    global $arrayAbecedario;
    $modOfarrayAbecedario = count($arrayAbecedario);

    if ($isCifrarActivated) {
        return ((int)$indexOfLetra + $aKey) % $modOfarrayAbecedario;
    } else {
        $abs = ((int)$indexOfLetra - $aKey) % $modOfarrayAbecedario;
        if ($abs < 0) {
            $abs += $modOfarrayAbecedario;
        }
        return $abs;
    }
}

function stringToChars($aString)
{
    $arrayChars = array();

    for ($i = 0, $length = mb_strlen($aString, 'UTF-8'); $i < $length; $i++) {
        $arrayChars[] = mb_substr($aString, $i, 1, 'UTF-8');
    }

    return $arrayChars;
}
