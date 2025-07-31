<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Authentication Routes
$routes->get('/', 'Auth::index');
$routes->get('auth', 'Auth::index');
$routes->get('b0/super-admin', 'Auth::superAdminLogin');
$routes->get('dashboard', 'Auth::index'); // Redirect to login if accessing dashboard directly
$routes->post('auth/login', 'Auth::login');
$routes->post('b0/super-admin', 'Auth::superAdminLoginProcess');
$routes->get('auth/logout', 'Auth::logout');

// Super Admin Routes
$routes->group('super-admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'SuperAdmin::dashboard');
    $routes->get('restoran', 'SuperAdmin::restoran');
    $routes->get('restoran/create', 'SuperAdmin::restoranCreate');
    $routes->post('restoran/create', 'SuperAdmin::restoranCreate');
    $routes->get('restoran/edit/(:num)', 'SuperAdmin::restoranEdit/$1');
    $routes->post('restoran/edit/(:num)', 'SuperAdmin::restoranEdit/$1');
    $routes->get('restoran/delete/(:num)', 'SuperAdmin::restoranDelete/$1');
    $routes->get('admin', 'SuperAdmin::admin');
    $routes->get('admin/create', 'SuperAdmin::adminCreate');
    $routes->post('admin/create', 'SuperAdmin::adminCreate');
    $routes->get('admin/delete/(:num)', 'SuperAdmin::adminDelete/$1');
});

// Admin Restoran Routes
$routes->group('admin', ['filter' => 'admin_restoran'], function($routes) {
    // routes...

    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('kategori', 'Admin::kategori');
    $routes->get('kategori/create', 'Admin::kategoriCreate');
    $routes->post('kategori/create', 'Admin::kategoriCreate');
    $routes->get('kategori/edit/(:num)', 'Admin::kategoriEdit/$1');
    $routes->post('kategori/edit/(:num)', 'Admin::kategoriEdit/$1');
    $routes->get('kategori/delete/(:num)', 'Admin::kategoriDelete/$1');
    $routes->get('menu', 'Admin::menu');
    $routes->get('menu/create', 'Admin::menuCreate');
    $routes->post('menu/create', 'Admin::menuCreate');
    $routes->get('menu/edit/(:num)', 'Admin::menuEdit/$1');
    $routes->post('menu/edit/(:num)', 'Admin::menuEdit/$1');
    $routes->get('menu/delete/(:num)', 'Admin::menuDelete/$1');
    $routes->get('pesanan', 'Admin::pesanan');
    $routes->get('pesanan/detail/(:num)', 'Admin::pesananDetail/$1');
    $routes->post('pesanan/update-status/(:num)', 'Admin::pesananUpdateStatus/$1');
    $routes->get('qrcode', 'QRCodeController::index');
    $routes->get('qrcode/display/(:num)', 'QRCodeController::display/$1');
    $routes->get('qrcode/download/(:num)', 'QRCodeController::download/$1');
    $routes->get('qrcode/generate-meja/(:num)/(:num)', 'QRCodeController::generateMeja/$1/$2');
    $routes->get('qrcode/download-meja/(:num)/(:num)', 'QRCodeController::downloadMeja/$1/$2');
    $routes->get('meja', 'MejaController::index');
    $routes->get('meja/create', 'MejaController::create');
    $routes->post('meja/store', 'MejaController::store');
    $routes->get('meja/edit/(:num)', 'MejaController::edit/$1');
    $routes->post('meja/update/(:num)', 'MejaController::update/$1');
    $routes->get('meja/delete/(:num)', 'MejaController::delete/$1');
});

// Customer Routes (Public)
$routes->get('customer/menu/(:num)', 'Customer::menu/$1');
$routes->get('customer/menu/(:num)/meja/(:num)', 'Customer::menu/$1/$2');
$routes->post('customer/add-to-cart', 'Customer::addToCart');
$routes->get('customer/cart', 'Customer::cart');
$routes->post('customer/update-cart', 'Customer::updateCart');
$routes->get('customer/remove-from-cart/(:num)', 'Customer::removeFromCart/$1');
$routes->get('customer/identity', 'Customer::identityForm');
$routes->post('customer/submit-identitas', 'Customer::submitIdentitas');
$routes->get('customer/checkout', 'Customer::checkout');
$routes->post('customer/checkout', 'Customer::checkout');
$routes->get('customer/completion/(:num)', 'Customer::completion/$1');
$routes->get('customer/order/(:num)', 'Customer::order/$1');
$routes->get('customer/clear-cart', 'Customer::clearCart');

// QR Code Routes
$routes->get('qrcode/generate/(:num)', 'QRCodeController::generate/$1');
