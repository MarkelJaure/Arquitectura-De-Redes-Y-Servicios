<?php

$arrayAbecedario = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

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
