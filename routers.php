<?php
global $routes;
$routes = array();

$routes['/produto/{id}'] = '/produto/abrir/:id';
$routes['/{titulo}'] = '/produto/abrir/:titulo';
