<?php

class MovieDao
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getMovies(): array
    {
        $sql = "SELECT m.*, d.name AS director_name, w.name AS genre_name, y.name AS actor_name
                FROM movies m 
                INNER JOIN directors d ON m.director_id = d.id
                INNER JOIN movieactors x ON m.id = x.movie_id
                INNER JOIN actors y ON x.actor_id = y.id
                INNER JOIN moviegenres z ON m.id = z.movie_id
                INNER JOIN genres w ON z.genre_id = w.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMovieById(int $id): ?array
    {
        $sql = "SELECT m.*, d.name AS director_name 
                FROM movies m 
                LEFT JOIN directors d ON m.director_id = d.id
                WHERE m.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addMovie(
        string $image,
        string $title,
        ?DateTime $releaseDate = null,
        string $description = "",
        ?int $directorId = null,
        string $link = "",
        int $duration = 0,
        float $rating = 0.0
    ): void {
        $sql = "INSERT INTO movies (image, title, release_date, description, director_id, link, duration, rating, visited) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$image, $title, $releaseDate?->format('Y-m-d'), $description, $directorId, $link, $duration, $rating]);
    }

    public function updateMovie(
        int $id,
        string $image,
        string $title,
        ?DateTime $releaseDate = null,
        string $description = "",
        ?int $directorId = null,
        string $link = "",
        int $duration = 0,
        float $rating = 0.0
    ): void {
        $sql = "UPDATE movies SET image = ?, title = ?, release_date = ?, description = ?, director_id = ?, link = ?, duration = ?, rating = ? 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$image, $title, $releaseDate?->format('Y-m-d'), $description, $directorId, $link, $duration, $rating, $id]);
    }

    public function deleteMovie(int $id): void
    {
        $sql = "DELETE FROM movies WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
