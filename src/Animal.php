<?php
  class Animal
  {
    public $name;
    public $gender;
    public $breed;
    public $date_admitted;
    private $id;

    function __construct($name,$gender,$breed,$date_admitted=null, $id=null)
    {
      $this->name = $name;
      $this->gender = $gender;
      $this->breed = $breed;
      $this->date_admitted = $date_admitted;
      $this->id = $id;
    }
    function save()
{
      $executed = $GLOBALS['DB']->exec("INSERT INTO animals (name, gender, breed, date_admitted) VALUES ('{$this->name}','{$this->gender}','{$this->breed}', NOW());");
      if ($executed) {
            $this->id = $GLOBALS['DB']->lastInsertId();
            return true;
      } else {
            return false;
      }
}
    static function getAll()
    {
      $returned_animals = $GLOBALS['DB']->query("SELECT * FROM animals;");
      $animals = array();
      foreach($returned_animals as $animal){
        $name = $animal['name'];
        $gender = $animal['gender'];
        $breed = $animal['breed'];
        $id = $animal['id'];
        $new_animal = new Animal($name, $gender, $breed, null, $id);
        array_push($animals, $new_animal);
      }
      return $animals;
    }
    static function deleteAll()
    {
      $executed = $GLOBALS['DB']->exec("DELETE FROM animals;");
      if($executed){
        return true;
      }else{
        return false;
      }
    }
    function getId()
    {
        return $this->id;
    }
    static function find($search_id)
    {
        $returned_animals = $GLOBALS['DB']->prepare('SELECT * FROM animals WHERE id = :id');
        $returned_animals->bindParam(':id', $search_id, PDO::PARAM_STR);
        $returned_animals->execute();
        foreach ($returned_animals as $animal){
          $name = $animal['name'];
          $gender = $animal['gender'];
          $breed = $animal['breed'];
          $date = $animal['date_admitted'];
          $id = $animal['id'];
          if ($id == $search_id){
            $found_animal = new Animal($name, $gender, $breed, null, $id);
          }
          return $found_animal;
        }
    }
  }
?>
