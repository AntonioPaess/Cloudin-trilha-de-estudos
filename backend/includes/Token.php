<?php
include('../dbcon.php');

function getStoreInfo($userId) {
    global $database;
    
    try {
        $reference = $database->getReference('stores/' . $userId);
        $snapshot = $reference->getValue();
        
        return $snapshot ? $snapshot : null;
    } catch (Exception $e) {
        
        return null;
    }
}

function isLightColor($hex) {
    // Remove o # se existir
    $hex = ltrim($hex, '#');
    
    // Converte hex para RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    // Calcula a luminosidade
    $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    
    // Retorna true se for uma cor clara (brightness > 128)
    return $brightness > 128;
}