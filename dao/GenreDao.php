<?php

class GenresDao {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getGenres(): array {
        $sql = "SELECT * FROM genres";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getGenreById(int $id): ?array {
        $sql = "SELECT * FROM genres WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addGenre(string $name, string $imageGenre): void {
        $sql = "INSERT INTO genres (name, image_genre) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $imageGenre]);
    }

    public function updateGenre(int $id, string $name, string $imageGenre): void {
        $sql = "UPDATE genres SET name = ?, image_genre = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $imageGenre, $id]);
    }

    public function deleteGenre(int $id): void {
        $sql = "DELETE FROM genres WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
