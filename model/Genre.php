<?php
class Genre {
  public int $id;
  public string $name;
  public string $imageUrl;

  public function __construct(int $id, string $name, string $imageUrl = "") {
    $this->id = $id;
    $this->name = $name;
    $this->imageUrl = $imageUrl;
  }
}
