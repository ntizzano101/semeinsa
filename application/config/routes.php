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
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

##ROUTES PARA CLIENTES
$route['clientes'] = 'clientes';
$route['clientes/ver/(:num)'] = 'clientes/ver/$1';
$route['clientes/insertar'] = 'clientes/grabar';
##ETIQUETAS
$route['etiquetas'] = 'clientes/etiquetas';
$route['clientes/etiqueta_insertar'] = 'clientes/etiqueta_grabar';
$route['clientes/etiqueta_editar/(:num)'] = 'clientes/etiqueta_editar/$1';
$route['clientes/etiqueta_mostrar_borrar/(:num)'] = 'clientes/etiqueta_mostrar_borrar/$1';
$route['clientes/etiqueta_borrar'] = 'clientes/etiqueta_borrar';

##ROUTES PARA PROVEEDORES
$route['proveedores'] = 'proveedores';
$route['proveedores/proveedores_grabar'] = 'proveedores/proveedores_grabar';

##ROUTES PARA LOGUIN
$route['ingreso'] = 'login/ingreso';
$route['cambiar_contrasena'] = 'login/cambiar_contrasena';
$route['salir'] = 'login/salida';

#ROUTES PARA ARTICULOS
$route['articulos'] = 'articulos';
$route['articulos/insertar'] = 'articulos/grabar';

$route['rubros'] = 'articulos/rubros';
$route['articulos/rubro_insertar'] = 'articulos/rubro_grabar';
$route['articulos/rubro_editar/(:num)'] = 'articulos/rubro_editar/$1';

$route['categorias'] = 'articulos/categorias';
$route['articulos/categoria_insertar'] = 'articulos/categoria_grabar';
$route['articulos/categoria_editar/(:num)'] = 'articulos/categoria_editar/$1';

#ROUTES PARA FACTURAS  - PROVEEDORES
$route['facturas'] = 'facturas';
$route['facturas/ingresar'] = 'facturas/ingresar';
$route['facturas/borrar'] = 'facturas/borrar';
$route['facturas/ver'] = 'facturas/ver';

#ROUTES PARA CUENTA CORRIENTE
$route['ctacte/ctacte/(:num)'] = 'ctacte/ctacte/$1';

#ROUTES PARA VENTAS  - CLIENTES
$route['ventas'] = 'ventas';
$route['ventas/ingresar'] = 'ventas/ingresar';
$route['ventas/borrar'] = 'ventas/borrar';
$route['ventas/ver'] = 'vetnas/ver';
$route['ventas/listar'] = 'ventas/listar';
$route['ventas/comprobante(:num)'] = 'ventas/comprobante/$1';
//TABLERO

//*******ROUTES CURSOS*************
/*
$route['cursos'] = 'Cursos_Controller/listado';
$route['cursos/nuevo'] = 'Cursos_Controller/nuevo_curso';
$route['cursos/editar/(:num)'] = 'Cursos_Controller/editar_curso/$1';
$route['cursos/conf_eliminar/(:num)'] = 'Cursos_Controller/conf_eliminar_curso/$1';
$route['cursos/eliminar/(:num)'] = 'Cursos_Controller/eliminar_curso/$1';
*/