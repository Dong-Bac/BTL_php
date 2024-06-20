<?php
class Actor {
    public int $id;
    public string $name;
    public DateTime $birthdate; // Or nullable DateTime if birthdate is optional

    function __construct($id, $name, $birthdate) {
      $this->id = $id;
      $this->name = $name;
      $this->birthdate = $birthdate;
    }
  }
