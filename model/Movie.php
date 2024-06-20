<?php
class Movie {
  public int $id;
  public string $imageUrl;
  public string $title;
  public DateTime $releaseDate; // Or nullable DateTime if release date is optional
  public string $description;
  public int $directorId;
  public string $link;
  public int $duration;
  public float $rating;
  public int $visitedCount;

  public function __construct(int $id, string $imageUrl, string $title, ?DateTime $releaseDate = null,
                                string $description = "", int $directorId = 0, string $link = "", int $duration = 0,
                                float $rating = 0.0) {
        $this->id = $id;
        $this->imageUrl = $imageUrl;
        $this->title = $title;
        $this->releaseDate = $releaseDate;
        $this->description = $description;
        $this->directorId = $directorId;
        $this->link = $link;
        $this->duration = $duration;
        $this->rating = $rating;
    }
}
