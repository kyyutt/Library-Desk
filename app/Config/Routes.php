<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('admin', static function($routes){
    $routes->get('dashboard', 'Home::index');
    $routes->group('members', static function($routes) {
        $routes->get('/', 'Members::index'); // Rute untuk melihat semua anggota
        $routes->get('create', 'Members::create'); // Rute untuk membuat anggota baru
        $routes->post('store', 'Members::store'); // Rute untuk menyimpan anggota baru
        $routes->get('edit/(:num)', 'Members::edit/$1'); // Rute untuk mengedit anggota
        $routes->post('update/(:num)', 'Members::update/$1'); // Rute untuk memperbarui anggota
        $routes->get('delete/(:num)', 'Members::delete/$1'); // Rute untuk menghapus anggota
    });
    $routes->group('books', static function($routes) {
        $routes->get('/', 'Books::index'); // Rute untuk melihat semua anggota
        $routes->get('create', 'Books::create'); // Rute untuk membuat anggota baru
        $routes->post('store', 'Books::store'); // Rute untuk menyimpan anggota baru
        $routes->get('edit/(:num)', 'Books::edit/$1'); // Rute untuk mengedit anggota
        $routes->post('update/(:num)', 'Books::update/$1'); // Rute untuk memperbarui anggota
        $routes->get('delete/(:num)', 'Books::delete/$1'); // Rute untuk menghapus anggota
    });
    $routes->group('categories', static function($routes) {
        $routes->get('/', 'Categories::index'); // Rute untuk melihat semua anggota
        $routes->get('create', 'Categories::create'); // Rute untuk membuat anggota baru
        $routes->post('store', 'Categories::store'); // Rute untuk menyimpan anggota baru
        $routes->get('edit/(:num)', 'Categories::edit/$1'); // Rute untuk mengedit anggota
        $routes->post('update/(:num)', 'Categories::update/$1'); // Rute untuk memperbarui anggota
        $routes->get('delete/(:num)', 'Categories::delete/$1'); // Rute untuk menghapus anggota
    });
    $routes->group('loans', static function($routes) {
        $routes->get('/', 'Loans::index'); // Rute untuk melihat semua anggota
        $routes->get('create', 'Loans::create'); // Rute untuk membuat anggota baru
        $routes->post('store', 'Loans::store'); // Rute untuk menyimpan anggota baru
        $routes->get('edit/(:num)', 'Loans::edit/$1'); // Rute untuk mengedit anggota
        $routes->post('update/(:num)', 'Loans::update/$1'); // Rute untuk memperbarui anggota
        $routes->get('delete/(:num)', 'Loans::delete/$1'); // Rute untuk menghapus anggota
    });
});