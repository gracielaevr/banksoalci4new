<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Beranda::index');
$routes->setAutoRoute(true);
$routes->get('subtopic1/(:any)', 'Subtopic1::index/$1');
$routes->get('start/(:any)', 'Start::index/$1');