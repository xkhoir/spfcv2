<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 **/

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['filter' => 'islogin']);

$routes->group('auth', ['filter' => 'notlogin'], function ($routes) {
    $routes->get('login', 'AuthController::index');
    $routes->post('login_act', 'AuthController::login');
});


$routes->group('auth', ['filter' => 'islogin'], function ($routes) {
    $routes->get('logout', 'AuthController::logout');
});

$routes->group('master_user', ['filter' => 'issa'], function ($routes) {

    // Pegawai
    $routes->get('pegawai/datatables', 'PegawaiController::datatables');
    $routes->get('pegawai', 'PegawaiController::index');
    $routes->get('pegawai/create_pegawai', 'PegawaiController::create_pegawai');
    $routes->post('pegawai/store_pegawai', 'PegawaiController::store_pegawai');
    $routes->get('pegawai/edit_pegawai/(:any)', 'PegawaiController::edit_pegawai/$1');
    $routes->post('pegawai/update_pegawai/(:any)', 'PegawaiController::update_pegawai/$1');
    $routes->delete('pegawai/destroy_pegawai/(:any)', 'PegawaiController::destroy_pegawai/$1');

    // User
    $routes->get('user/datatables', 'UserController::datatables');
    $routes->get('user', 'UserController::index');
    $routes->get('user/create_user', 'UserController::create_user');
    $routes->post('user/store_user', 'UserController::store_user');
    $routes->get('user/edit_user/(:any)', 'UserController::edit_user/$1');
    $routes->post('user/update_user/(:any)', 'UserController::update_user/$1');
    $routes->delete('user/destroy_user/(:any)', 'UserController::destroy_user/$1');
});

$routes->group('master_kerusakan', ['filter' => 'issa'], function ($routes) {

    // Gejala
    $routes->get('gejala/datatables', 'GejalaController::datatables');
    $routes->get('gejala', 'GejalaController::index');
    $routes->get('gejala/create_gejala', 'GejalaController::create_gejala');
    $routes->post('gejala/store_gejala', 'GejalaController::store_gejala');
    $routes->get('gejala/edit_gejala/(:any)', 'GejalaController::edit_gejala/$1');
    $routes->post('gejala/update_gejala/(:any)', 'GejalaController::update_gejala/$1');
    $routes->delete('gejala/destroy_gejala/(:any)', 'GejalaController::destroy_gejala/$1');

    // Kerusakan
    $routes->get('kerusakan/datatables', 'KerusakanController::datatables');
    $routes->get('kerusakan', 'KerusakanController::index');
    $routes->get('kerusakan/create_kerusakan', 'KerusakanController::create_kerusakan');
    $routes->post('kerusakan/store_kerusakan', 'KerusakanController::store_kerusakan');
    $routes->get('kerusakan/edit_kerusakan/(:any)', 'KerusakanController::edit_kerusakan/$1');
    $routes->post('kerusakan/update_kerusakan/(:any)', 'KerusakanController::update_kerusakan/$1');
    $routes->delete('kerusakan/destroy_kerusakan/(:any)', 'KerusakanController::destroy_kerusakan/$1');
});

$routes->group('aturan', ['filter' => 'issa'], function ($routes) {
    $routes->get('datatables', 'AturanController::datatables');
    $routes->get('/', 'AturanController::index');
    $routes->get('create_aturan', 'AturanController::create_aturan');
    $routes->post('store_aturan', 'AturanController::store_aturan');
    $routes->get('edit_aturan/(:any)', 'AturanController::edit_aturan/$1');
    $routes->post('update_aturan/(:any)', 'AturanController::update_aturan/$1');
    $routes->delete('destroy_aturan/(:any)', 'AturanController::destroy_aturan/$1');
});

$routes->group('konsultasi', ['filter' => 'islogin'], function ($routes) {
    $routes->get('/', 'KonsultasiController::index');
    $routes->post('savequestion', 'KonsultasiController::saveQuestion');
    $routes->post('savekonsultasi', 'KonsultasiController::saveKonsultasi');
    // $routes->get('/', 'AturanController::index');
    // $routes->get('create_aturan', 'AturanController::create_aturan');
    // $routes->post('store_aturan', 'AturanController::store_aturan');
    // $routes->get('edit_aturan/(:any)', 'AturanController::edit_aturan/$1');
    // $routes->post('update_aturan/(:any)', 'AturanController::update_aturan/$1');
    // $routes->delete('destroy_aturan/(:any)', 'AturanController::destroy_aturan/$1');
});

$routes->group('perbaikan', ['filter' => 'islogin'], function ($routes) {
    $routes->get('datatables', 'PerbaikanController::datatables');
    $routes->get('/', 'PerbaikanController::index');
    $routes->get('create_perbaikan', 'PerbaikanController::create_perbaikan');
    $routes->post('store_perbaikan', 'PerbaikanController::store_perbaikan');
    $routes->get('edit_perbaikan/(:any)', 'PerbaikanController::edit_perbaikan/$1');
    $routes->get('update_perbaikan/(:any)', 'PerbaikanController::update_perbaikan/$1');
    $routes->get('report_perbaikan/(:any)', 'PerbaikanController::report/$1');
    $routes->delete('destroy_perbaikan/(:any)', 'PerbaikanController::destroy_perbaikan/$1');
});