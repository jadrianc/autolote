<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['getAsignacionesByOni'] = 'Reportes/getAsignacionesByOni/$1/$2';
$route['reporteAsignacionP'] = 'Reportes/reporteAsignacionP/$1/$2';
$route['marcas/index'] = '/marcas';
$route['marcas/getById'] = 'marcas/getById/$1';
$route['marcas/getAll'] = 'marcas/getAll';
$route['marcas/store'] = 'marcas/store';
$route['marcas/update'] = 'marcas/update';
$route['marcas/delete'] = 'marcas/delete/$1';
$route['marcas'] = 'marcas';

$route['clases/index'] = '/clases';
$route['clases/getById'] = 'clases/getById/$1';
$route['clases/getAll'] = 'clases/getAll';
$route['clases/store'] = 'clases/store';
$route['clases/update'] = 'clases/update';
$route['clases/delete'] = 'clases/delete/$1';
$route['clases'] = 'clases';


$route['subclases/index'] = '/subclases';
$route['subclases/getById'] = 'subclases/getById/$1/$2';
$route['subclases/getAll'] = 'subclases/getAll';
$route['subclases/store'] = 'subclases/store';
$route['subclases/update'] = 'subclases/update';
$route['subclases/delete'] = 'subclases/delete/$1';
$route['subclases'] = 'subclases';


$route['tiposadquisicion/index'] = '/tiposadquisicion';
$route['tiposadquisicion/getById'] = 'tiposadquisicion/getById/$1';
$route['tiposadquisicion/getAll'] = 'tiposadquisicion/getAll';
$route['tiposadquisicion/store'] = 'tiposadquisicion/store';
$route['tiposadquisicion/update'] = 'tiposadquisicion/update';
$route['tiposadquisicion/delete'] = 'tiposadquisicion/delete/$1';
$route['tiposadquisicion'] = 'tiposadquisicion';

$route['estados/index'] = '/estados';
$route['estados/getById'] = 'estados/getById/$1';
$route['estados/getAll'] = 'estados/getAll';
$route['estados/store'] = 'estados/store';
$route['estados/update'] = 'estados/update';
$route['estados/delete'] = 'estados/delete/$1';
$route['estados'] = 'estados';

$route['proveedores/index'] = '/proveedores';
$route['proveedores/getById'] = 'proveedores/getById';
$route['proveedores/getAll'] = 'proveedores/getAll';
$route['proveedores/store'] = 'proveedores/store';
$route['proveedores/update'] = 'proveedores/update';
$route['proveedores/delete'] = 'proveedores/delete';
$route['proveedores'] = 'proveedores';

$route['registrobienes'] = 'registrobienes';
$route['centroscostos'] = 'centroscostos';

$route['personal'] = 'personal';

$route['activosfijos'] = 'activosfijos';
$route['activosfijos/store'] = 'activosfijos/store';
$route['activosfijos/buscar'] = 'activosfijos/getActivoFijo';

$route['contables'] = 'contables';


$route['roles/index'] = '/roles';
$route['roles/getById'] = 'roles/getById/$1';
$route['roles/getAll'] = 'roles/getAll';
$route['roles/store'] = 'roles/store';
$route['roles/update'] = 'roles/update';
$route['roles/delete'] = 'roles/delete/$1';
$route['roles'] = 'roles';


$route['usuarios/index'] = '/usuarios';
$route['usuarios/getById'] = 'usuarios/getById/$1';
$route['usuarios/getAll'] = 'usuarios/getAll';
$route['usuarios/store'] = 'usuarios/store';
$route['usuarios/update'] = 'usuarios/update';
$route['usuarios/delete'] = 'usuarios/delete/$1';
$route['usuarios'] = 'usuarios';

$route['inventarioTecnico/index'] = '/inventariotecnico';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
