<?php
  /**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */

  require_once 'src/Animal.php';


  $server = 'mysql:host=localhost:8889;dbname=animal_shelter_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class AnimalTest extends PHPUnit_Framework_TestCase
  {
    protected function tearDown()
     {
         Animal::deleteAll();
     }
    function test_save()
    {
      $test_animal = new Animal("Rover", "Male", "Dog");
      $executed = $test_animal->save();
      $this->assertTrue($executed, "Task not successfully saved to database");
    }
    function test_getAll()
    {
      $test_animal = new Animal("Rover", "Male", "Dog", null);
      $executed = $test_animal->save();
      $test_animal2 = new Animal("Cindy", "Female", "Cat", null);
      $executed2 = $test_animal2->save();

      $result = Animal::getALL();
      $this->assertEquals([$test_animal, $test_animal2], $result);
    }
    function test_deleteAll()
    {
      $test_animal = new Animal("Rover", "Male", "Dog");
      $executed = $test_animal->save();
      $test_animal2 = new Animal("Cindy", "Female", "Cat");
      $executed2 = $test_animal2->save();
      Animal::deleteAll();
      $result =Animal::getAll();
      $this->assertEquals([], $result);
    }
    function test_getId()
    {
      $test_animal = new Animal("Rover", "Male", "Dog");
      $executed = $test_animal->save();
      $result = $test_animal->getId();
      $this->assertTrue(is_numeric($result));
    }
    function test_find(){
      $test_animal = new Animal("Rover", "Male", "Dog");
      $executed = $test_animal->save();
      $test_animal2 = new Animal("Cindy", "Female", "Cat");
      $executed2 = $test_animal2->save();
      $id = $test_animal->getId();
      $result = Animal::find($id);
      $this->assertEquals($test_animal, $result);
    }
  }

 ?>
