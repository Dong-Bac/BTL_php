<?php
class Director {
  public int $id;
  public string $name;
  public DateTime $birthdate; // Or nullable DateTime if birthdate is optional
  public string $address; // Or nullable string if address is optional
  public int $age; // Or nullable int if age is optional
}
