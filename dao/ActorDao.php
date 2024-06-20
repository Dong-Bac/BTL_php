<?php

class ActorDao {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getActors(): array {
        $sql = "SELECT * FROM actors";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getActorById(int $id): ?array {
        $sql = "SELECT * FROM actors WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addActor(string $name, ?string $birthdate = null): void {
        $sql = "INSERT INTO actors (name, birthdate) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $birthdate]);
    }

    public function updateActor(int $id, string $name, ?string $birthdate = null): void {
        $sql = "UPDATE actors SET name = ?, birthdate = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $birthdate, $id]);
    }

    public function deleteActor(int $id): void {
        $sql = "DELETE FROM actors WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
