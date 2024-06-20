<?php

class MovieGenresDao {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getMovieGenres(int $movieId = null): array {
        $sql = "SELECT mg.*, g.name AS genre_name FROM moviegenres mg LEFT JOIN genres g ON mg.genre_id = g.id";
        $params = [];

        if ($movieId !== null) {
            $sql .= " WHERE movie_id = ?";
            $params[] = $movieId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addMovieGenre(int $movieId, int $genreId): void {
        $sql = "INSERT INTO moviegenres (movie_id, genre_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$movieId, $genreId]);
    }

    public function deleteMovieGenre(int $movieId, int $genreId): void {
        $sql = "DELETE FROM moviegenres WHERE movie_id = ? AND genre_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$movieId, $genreId]);
    }
}
