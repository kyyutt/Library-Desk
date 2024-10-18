<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('admin', static function($routes){
    $routes->get('/', 'Home::index');
    $routes->group('members', static function($routes) {
        $routes->get('/', 'Members::index'); // Rute untuk melihat semua anggota
        $routes->get('create', 'Members::create'); // Rute untuk membuat anggota baru
        $routes->post('store', 'Members::store'); // Rute untuk menyimpan anggota baru
        $routes->get('edit/(:hash)', 'Members::edit/$1'); // Rute untuk mengedit anggota
        $routes->post('update/(:hash)', 'Members::update/$1'); // Rute untuk memperbarui anggota
        $routes->get('delete/(:hash)', 'Members::delete/$1'); // Rute untuk menghapus anggota
    });
    $routes->group('categories', static function($routes) {
        $routes->get('/', 'Categories::index'); // Rute untuk melihat semua anggota
        $routes->get('create', 'Categories::create'); // Rute untuk membuat anggota baru
        $routes->post('store', 'Categories::store'); // Rute untuk menyimpan anggota baru
        $routes->get('edit/(:hash)', 'Categories::edit/$1'); // Rute untuk mengedit anggota
        $routes->post('update/(:hash)', 'Categories::update/$1'); // Rute untuk memperbarui anggota
        $routes->get('delete/(:hash)', 'Categories::delete/$1'); // Rute untuk menghapus anggota
    });
    $routes->group('racks', static function($routes) {
        $routes->get('/', 'Racks::index'); // Rute untuk melihat semua anggota
        $routes->get('create', 'Racks::create'); // Rute untuk membuat anggota baru
        $routes->post('store', 'Racks::store'); // Rute untuk menyimpan anggota baru
        $routes->get('edit/(:hash)', 'Racks::edit/$1'); // Rute untuk mengedit anggota
        $routes->post('update/(:hash)', 'Racks::update/$1'); // Rute untuk memperbarui anggota
        $routes->get('delete/(:hash)', 'Racks::delete/$1'); // Rute untuk menghapus anggota
    });
    $routes->group('books', static function($routes) {
        $routes->get('/', 'Books::index'); // Rute untuk melihat semua anggota
        $routes->get('create', 'Books::create'); // Rute untuk membuat anggota baru
        $routes->post('store', 'Books::store'); // Rute untuk menyimpan anggota baru
        $routes->get('edit/(:hash)', 'Books::edit/$1'); // Rute untuk mengedit anggota
        $routes->post('update/(:hash)', 'Books::update/$1'); // Rute untuk memperbarui anggota
        $routes->get('delete/(:hash)', 'Books::delete/$1'); // Rute untuk menghapus anggota
        $routes->get('detail/(:hash)', 'Books::detail/$1');
    });
    
    $routes->group('loans', static function($routes) {
        $routes->get('/', 'Loans::index'); // Rute untuk melihat semua anggota
        $routes->get('create', 'Loans::create'); // Rute untuk membuat anggota baru
        $routes->post('store', 'Loans::store'); // Rute untuk menyimpan anggota baru
        $routes->get('edit/(:hash)', 'Loans::edit/$1'); // Rute untuk mengedit anggota
        $routes->post('update/(:hash)', 'Loans::update/$1'); // Rute untuk memperbarui anggota
        $routes->get('delete/(:hash)', 'Loans::delete/$1'); // Rute untuk menghapus anggota
    });
});