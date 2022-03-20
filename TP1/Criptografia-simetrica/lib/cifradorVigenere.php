<?php
require 'cifrador.php';

$theCount = 0;

function cifrarVigenere($aMessage, $aKey, $isCifrarActivated)
{
    global $theCount;

    $theCount = 0;
    $somePalabras = explode(" ", $aMessage);
    $theKeys = changePalabraToArrayOfKeys($aKey);

    for ($n = 0; $n < count($somePalabras); $n++) {
        $somePalabras[$n] = cifrarPalabra($somePalabras[$n], $theKeys, $isCifrarActivated);
    }

    return join(" ", $somePalabras);
}

function cifrarPalabra($aPalabra, $theKeys, $isCifrarActivated)
{
    global $theCount;

    $newPalabra = str_split($aPalabra);
    for ($i = 0; $i < count($newPalabra); $i++) {
        echo $newPalabra[$i];
        echo " -> ";
        echo $theKeys[$theCount % count($theKeys)];
        echo " -> ";
        $newPalabra[$i] = desplazarLetra($aPalabra[$i], $theKeys[$theCount % count($theKeys)], $isCifrarActivated);
        $theCount += 1;
        echo $newPalabra[$i];
        echo "<br>";
    }

    return join("", $newPalabra);
}

function changePalabraToArrayOfKeys($aPalabra)
{
    global $arrayAbecedario;

    $someKeys = array();

    foreach (str_split($aPalabra) as $aLetra) {
        array_push($someKeys, array_search($aLetra, $arrayAbecedario));
    }

    foreach ($someKeys as $Key) {
        echo $Key . ", ";
    }
    echo "<br>";
    return $someKeys;
}
