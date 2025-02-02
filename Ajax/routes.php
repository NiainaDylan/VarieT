<?php

use app\models\ReservationModel;
use flight\Engine;
use flight\net\Router;
//use Flight;
use app\controllers\UserController;
use app\controllers\ReservationController;
use app\controllers\HabitationController;
use app\controllers\PhotoController;





/** 
 * @var Router $router 
 * @var Engine $app
 */


$router->get('/', function(){
	$data['color'] = "black";
	Flight::render('login',$data);
});

$router->get("/welcome" , function(){
	session_start();
	if(isset($_SESSION['user']['id_utilisateur'])){
		Flight::render("welcome" );
	} else {
		Flight::redirect("/");	
	}
});
$router->get("/admin" , function(){
	$data['color'] = "black";
	Flight::render('loginAdmin',$data);
}); 



$user=new UserController();

$router->post('/login', [$user, 'login']);
$router->post('/inscription' , [$user , 'signIn']);
$router->post('/loginAdmin', [$user, 'loginAdmin']);
$router->get('/deconnexion',[$user,'deconnexion']);

$reservation= new ReservationController();

$router->get("/list-habitation" , [$reservation , 'listHabitation']);
$router->get("/form-reservation" , [$reservation , 'habitation']);
$router->post("/reservation",[$reservation,'reservation']);
$router->get("/more-image" , [$reservation , 'showImage']);


$habitation=new HabitationController();
$router->get('/admin-habitation-list',[$habitation,'getAllHabitation']);
$router->get("/list" , function(){
	Flight::render('crud-habitation');
});

$router->get('/add-dwelling',[$habitation,'formInsertHabitation']);
$router->post('/add-dwelling',[$habitation,'insertHabitation']);
$router->get('/delete-dwelling',[$habitation,'deleteHabitation']);
$router->get('/update',[$habitation,'formUpdateHabitation']);
$router->post('/update-dwelling',[$habitation,'updateHabitation']);
$router->get("/add-photo" , function(){
	$data['id']=Flight::request()->query['id'];
	Flight::render('add-photo-habitation',$data);
});

$router->post('/add-photo',[$habitation,'insertPhoto']);

$router->get('/list-photo',[$habitation,'listPhoto']);

$router->get('/delete-photo',[$habitation,'deletePhoto']);

