<?php
class MovieGenre {
  public int $id;
  public int $movieId;
  public int $genreId;

  public function __construct(int $id, int $movieId, int $genreId) {
    $this->id = $id;
    $this->movieId = $movieId;
    $this->genreId = $genreId;
  }
}
