<?php
  require_once __DIR__.'/../vendor/autoload.php';
  require_once __DIR__.'/../src/Animal.php';


  $app = new Silex\Application();

  $server = 'mysql:host=localhost:8889;dbname=animal_shelter';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server,$username,$password);

  $app->register(new\Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

  $app->get('/', function() use ($app){
    return $app['twig']->render('index.html.twig');
  });
  $app->get('/admin', function() use ($app){
    return $app['twig']->render('admin.html.twig');
  });
  $app->post('/admin', function() use ($app){
    $animal = new Animal($_POST['name'], $_POST['gender'], $_POST['breed']);
    $animal->save();
    return $app['twig']->render("admin.html.twig", array('kyle'=> Animal::getAll()));
  });
  $app->get('/animals', function()use ($app){
    return $app['twig']->render('animals.html.twig', array('steve'=> Animal::getAll()));
  });
  $app->post('/delete', function() use ($app){
    Animal::deleteAll();
    return $app['twig']->render('admin.html.twig');
  });
  return $app;
 ?>
