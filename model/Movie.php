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
}
