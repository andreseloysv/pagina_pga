<?php

$pieces = explode("/", $_GET['q']);
$node_id = $pieces[1]; // piece1
$node = node_load($node_id);

$carpeta = "index";
if (($node->type == 'page')) {
    $carpeta = (($node->title));
}


$files = file_scan_directory(getcwd() . "/themes/mi_tema/images/imagenes_banner/" . $carpeta, '.png');
$lista_archivos = array();
foreach ($files as $value) {
    $pieces = explode("/", $value->filename);
    $lista_archivos[] = $pieces[10];
}

if ($lista_archivos == null) {
    $files = file_scan_directory(getcwd() . "/themes/mi_tema/images/imagenes_banner/index", '.png');
    $lista_archivos = array();
    foreach ($files as $value) {
	$pieces = explode("/", $value->filename);
	$lista_archivos[] = $pieces[10];
    }
    $carpeta = "index";
}
?>