<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
// control nya leafletdraw adalah index, controlnya leaflet draw prosedurnya adalah index
$routes->get('/', 'Leafletdraw::index');
$routes->post('leafletdraw/simpan_point', 'Leafletdraw::simpan_point');
$routes->post('leafletdraw/simpan_polyline', 'Leafletdraw::simpan_polyline');
$routes->post('leafletdraw/simpan_polygon', 'Leafletdraw::simpan_polygon');
//Route tambahan setelah reoute metode post simpan poin, polyline, polygon untuk mengambil data dari database
// route meneembak api di controller api
$routes->get('api/point', 'Api::point');
$routes->get('api/polyline', 'Api::polyline');
$routes->get('api/polygon', 'Api::polygon');
// service('auth')->routes($routes);
// mengarahkan metode kontroler edit point ke view edit point
$routes->get('/editpoint', 'Leafletdraw::edit_point');
$routes->post('leafletdraw/simpan_edit_point', 'Leafletdraw::simpan_edit_point');
// mengarahkan metode kontroler edit polyline ke view edit polyline
$routes->get('/editpolyline', 'Leafletdraw::edit_polyline');
$routes->post('leafletdraw/simpan_edit_polyline', 'Leafletdraw::simpan_edit_polyline');
// mengarahkan metode kontroler edit polygon ke view edit polygon
$routes->get('/editpolygon', 'Leafletdraw::edit_polygon');
$routes->post('leafletdraw/simpan_edit_polygon', 'Leafletdraw::simpan_edit_polygon');
// mengarahkan metode kontroler delete point ke view delete point
//parameter $1 adalah id yang dikirim dari view delete point
//any menerima semua jenis input sebagai nilai parameter efeknya adalah semua jenis input akan dihapus
//ketika /id dari point diakses akan kehapus
$routes->get('/deletepoint/(:any)', 'Leafletdraw::delete_point/$1');
//mengarahkan metode kontroler delete polyline ke view delete polyline
$routes->get('/deletepolyline/(:any)', 'Leafletdraw::delete_polyline/$1');
//mengarahkan metode kontroler delete polygon ke view delete polygon
$routes->get('/deletepolygon/(:any)', 'Leafletdraw::delete_polygon/$1');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
