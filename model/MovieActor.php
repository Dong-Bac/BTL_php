<?php
class MovieActor {
  public int $id;
  public int $movieId;
  public int $actorId;

  public function __construct(int $id, int $movieId, int $actorId) {
    $this->id = $id;
    $this->movieId = $movieId;
    $this->actorId = $actorId;
  }
}
