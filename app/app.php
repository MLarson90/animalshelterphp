<?php
  require_once __DIR__.'/../vendor/autoload.php';
  require_once __DIR__.'/../src/Animal.php';

  session_start();

  $app = new Silex\Application();

  $server = 'mysql:host=localhost:8889;dbname=animal_shelter';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server,$username,$password);

  $app->register(new\Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));
  $app->get('/' function() use ($app){
    return $app['twig']->render('index.html.twig');
  })
 ?>
