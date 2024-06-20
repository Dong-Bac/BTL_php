<?php

class MovieActorsDao {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getMovieActors(int $movieId = null): array {
        $sql = "SELECT ma.*, a.name AS actor_name FROM movieactors ma LEFT JOIN actors a ON ma.actor_id = a.id";
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

    public function addMovieActor(int $movieId, int $actorId): void {
        $sql = "INSERT INTO movieactors (movie_id, actor_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$movieId, $actorId]);
    }

    public function deleteMovieActor(int $movieId, int $actorId): void {
        $sql = "DELETE FROM movieactors WHERE movie_id = ? AND actor_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$movieId, $actorId]);
    }
}
