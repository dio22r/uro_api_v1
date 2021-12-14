<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

$routes->post('/api/login', 'UserController::login'); // **
$routes->get('/api/logout', 'UserController::logout'); // **
$routes->post('/api/register', 'UserController::register'); // **
$routes->get('/api/aktivasi/(:segment)', 'UserController::aktivasi/$1'); // **
$routes->post('/api/aktivasi', 'UserController::resend_aktivasi'); // **
$routes->post('/api/forgot', 'UserController::forgot_password'); // **
$routes->get('/api/reset_password/(:segment)', 'UserController::reset_password/$1'); // **

$routes->get('/api/check-login', 'UserController::checklogin');

// $routes->get('/api/view_email', 'UserController::view_email');

$routes->get('/api/user', 'UserController::show'); // **
$routes->post('/api/user/profile', 'UserController::update'); // **
$routes->post('/api/user/akun', 'UserController::update_akun'); // **
$routes->post('/api/user/password', 'UserController::update_password'); // **

$routes->get('/api/proyekku', 'ProyekkuController::index'); // **
$routes->get('/api/proyekku/(:num)', 'ProyekkuController::show/$1'); // **

// level manager
$routes->post('/api/proyekku', 'ProyekkuController::create'); // **
$routes->put('/api/proyekku/(:num)', 'ProyekkuController::update/$1'); // **
$routes->delete('/api/proyekku/(:num)', 'ProyekkuController::delete/$1'); // **


$routes->get('/api/proyekku/(:num)/tugas', 'TindakanController::index/$1'); // **
$routes->get('/api/proyekku/tugas/(:num)', 'TindakanController::show/$1'); // **

$routes->get('/api/proyekku/(:num)/member', 'ProjectmemberController::index/$1');

// level manager
$routes->post('/api/proyekku/(:num)/tugas', 'TindakanController::create/$1'); // **
$routes->put('/api/proyekku/tugas/(:num)', 'TindakanController::update/$1'); // **


$routes->get('/api/proyekku/tugas/(:num)/detail', 'TindakanDetailController::index/$1'); // **
$routes->post('/api/proyekku/tugas/(:num)/detail', 'TindakanDetailController::insert/$1'); // **
$routes->get('/api/proyekku/tugas/detail/(:num)', 'TindakanDetailController::show/$1'); // **
$routes->put('/api/proyekku/tugas/detail/(:num)', 'TindakanDetailController::update/$1'); // **
$routes->delete('/api/proyekku/tugas/detail/(:num)', 'TindakanDetailController::delete/$1'); // **

$routes->get('/api/tugasku', 'TugaskuController::index'); // **

$routes->get('/api/rekanku', 'RekankuController::index'); // **
$routes->get('/api/rekanku/(:num)', 'RekankuController::show/$1'); // **



// $routes->get('/api/tugasku/(:num)', 'TugaskuController::show/$1'); 


/**
 * 
 * Equivalent to the following:
 * $routes->get('photos/new',             'Photos::new');
 * $routes->post('photos',                'Photos::create');
 * $routes->get('photos',                 'Photos::index');
 * $routes->get('photos/(:segment)',      'Photos::show/$1');
 * $routes->get('photos/(:segment)/edit', 'Photos::edit/$1');
 * $routes->put('photos/(:segment)',      'Photos::update/$1');
 * $routes->patch('photos/(:segment)',    'Photos::update/$1');
 * $routes->delete('photos/(:segment)',   'Photos::delete/$1')
 * $routes->resource('photos', ['except' => 'new,edit']);
 */


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
