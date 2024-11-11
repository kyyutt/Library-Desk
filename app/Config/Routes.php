<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// Define your custom routes here

$routes->group('auth', static function ($routes) {
    $routes->get('', 'Auth::index');  // Route GET ke halaman login
    $routes->post('login', 'Auth::login'); // Route POST untuk login
    $routes->get('logout', 'Auth::logout'); // Route GET untuk logout
});


$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->group('members', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Members::index'); // Rute untuk melihat semua anggota
    $routes->get('create', 'Members::create'); // Rute untuk membuat anggota baru
    $routes->post('store', 'Members::store'); // Rute untuk menyimpan anggota baru
    $routes->get('edit/(:hash)', 'Members::edit/$1'); // Rute untuk mengedit anggota
    $routes->post('update/(:hash)', 'Members::update/$1'); // Rute untuk memperbarui anggota
    $routes->get('delete/(:hash)', 'Members::delete/$1'); // Rute untuk menghapus anggota
    $routes->get('print/(:num)', 'Members::printCard/$1');
    $routes->get('detail/(:hash)', 'Members::detail/$1');
});
$routes->group('categories',  static function ($routes) {
    $routes->get('/', 'Categories::index'); // Rute untuk melihat semua anggota
    $routes->get('create', 'Categories::create'); // Rute untuk membuat anggota baru
    $routes->post('store', 'Categories::store'); // Rute untuk menyimpan anggota baru
    $routes->get('edit/(:hash)', 'Categories::edit/$1'); // Rute untuk mengedit anggota
    $routes->post('update/(:hash)', 'Categories::update/$1'); // Rute untuk memperbarui anggota
    $routes->get('delete/(:hash)', 'Categories::delete/$1'); // Rute untuk menghapus anggota
});
$routes->group('racks', static function ($routes) {
    $routes->get('/', 'Racks::index'); // Rute untuk melihat semua anggota
    $routes->get('create', 'Racks::create'); // Rute untuk membuat anggota baru
    $routes->post('store', 'Racks::store'); // Rute untuk menyimpan anggota baru
    $routes->get('edit/(:hash)', 'Racks::edit/$1'); // Rute untuk mengedit anggota
    $routes->post('update/(:hash)', 'Racks::update/$1'); // Rute untuk memperbarui anggota
    $routes->get('delete/(:hash)', 'Racks::delete/$1'); // Rute untuk menghapus anggota
});
$routes->group('books', static function ($routes) {
    $routes->get('/', 'Books::index'); // Rute untuk melihat semua anggota
    $routes->get('create', 'Books::create'); // Rute untuk membuat anggota baru
    $routes->post('store', 'Books::store'); // Rute untuk menyimpan anggota baru
    $routes->get('edit/(:hash)', 'Books::edit/$1'); // Rute untuk mengedit anggota
    $routes->post('update/(:hash)', 'Books::update/$1'); // Rute untuk memperbarui anggota
    $routes->get('delete/(:hash)', 'Books::delete/$1'); // Rute untuk menghapus anggota
    $routes->get('detail/(:hash)', 'Books::detail/$1');
});

$routes->group('loans', static function ($routes) {
    $routes->get('/', 'Loans::index'); // Route to view all loans
    $routes->get('create', 'Loans::create'); // Route to create a new loan
    $routes->post('store', 'Loans::store'); // Route to store new loan data
    $routes->get('return/(:num)', 'Loans::returnLoan/$1'); // Route to mark loan as returned, identified by ID
    $routes->get('extendDueDate/(:num)', 'Loans::extendDueDate/$1'); // Route to extend the due date of a loan, identified by ID
});
// Routes for Fine Settings
$routes->group('finesettings', function($routes) {
    $routes->get('/', 'FineSettings::index');               // Display all fine settings
    $routes->get('create', 'FineSettings::create');         // Show form to create a new fine setting
    $routes->post('store', 'FineSettings::store');          // Store new fine setting in database
    $routes->post('toggleActiveStatus/(:num)', 'FineSettings::toggleActiveStatus/$1'); // Toggle active status
});


$routes->group('reports', function($routes) {
    // Route for Book Logs Report
    $routes->get('book-logs', 'Report::bookLogs');

    // Route for Loan Reports
    $routes->get('loan-reports', 'Report::loanReports');

    // Route for Member Reports
    $routes->get('member-reports', 'Report::memberReports');
    $routes->get('export-member-report', 'Report::exportToExcel');
    $routes->get('export-pdf', 'Report::exportToPdf');


});

$routes->group('fines', static function ($routes) {
    $routes->get('/', 'Fines::index'); // Menampilkan daftar denda
    $routes->get('create/(:num)', 'Fines::create/$1'); // Form untuk menambah denda, loanId is required
    $routes->post('store', 'Fines::store'); // Menyimpan denda baru
    $routes->get('pay/(:num)', 'Fines::pay/$1');
    $routes->get('delete/(:num)', 'Fines::delete/$1'); // Add delete route if needed
    $routes->post('updateStatus/(:num)', 'Fines::updateStatus/$1'); // Add update status route if needed
});

$routes->group('reservations', static function ($routes) {
    $routes->get('/', 'Reservations::index'); // Rute untuk melihat semua anggota
    $routes->get('create', 'Reservations::create'); // Rute untuk membuat anggota baru
    $routes->post('store', 'Reservations::store'); // Rute untuk menyimpan anggota baru
    $routes->get('complete/(:num)', 'Reservations::complete/$1'); // Mark reservation as completed
    $routes->get('cancel/(:num)', 'Reservations::cancel/$1');
});
$routes->group('admins', static function ($routes) {
    $routes->get('/', 'Admins::index'); // Rute untuk melihat semua anggota
    $routes->get('create', 'Admins::create'); // Rute untuk membuat anggota baru
    $routes->post('store', 'Admins::store'); // Rute untuk menyimpan anggota baru
    $routes->get('edit/(:hash)', 'Admins::edit/$1'); // Rute untuk mengedit anggota
    $routes->post('update/(:hash)', 'Admins::update/$1'); // Rute untuk memperbarui anggota
    $routes->get('delete/(:hash)', 'Admins::delete/$1'); // Rute untuk menghapus anggota
});