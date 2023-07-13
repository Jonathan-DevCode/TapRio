<?php
@session_start();
$uri = filter_input(INPUT_GET, 'rota', FILTER_SANITIZE_SPECIAL_CHARS);
$uri = explode("/", $uri);
$dominio_test = trim(str_replace("https://", '', str_replace('http://', '', Http::base())));

$Controller = (!isset($uri[0]) || $uri[0] == NULL ) ? 'Index' : $uri[0];
$Controller = ( is_string($Controller) ) ? $Controller : 'Index';
$Action = (isset($uri[1]) && strlen($uri[1]) > 0 && is_string($uri[1])) ? $uri[1] : 'indexAction';