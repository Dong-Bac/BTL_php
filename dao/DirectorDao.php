<?php

class DirectorsDao {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getDirectors(): array {
        $sql = "SELECT * FROM directors";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getDirectorById(int $id): ?array {
        $sql = "SELECT * FROM directors WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addDirector(string $name, ?string $birthdate = null, ?string $address = null): void {
        // Calculate age only if birthdate is provided
        $age = null;
        if ($birthdate !== null) {
            // Replace with your preferred age calculation logic (consider libraries)
            // This is a simplified example
            $birthDateObj = new DateTime($birthdate);
            $now = new DateTimeImmutable();
            $interval = $now->diff($birthDateObj);
            $age = $interval->y;
        }

        $sql = "INSERT INTO directors (name, birthdate, address, age) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $birthdate, $address, $age]);
    }

    public function updateDirector(int $id, string $name, ?string $birthdate = null, ?string $address = null): void {
        // Calculate age only if birthdate is provided (similar logic as addDirector)
        $age = null;
        if ($birthdate !== null) {
            $birthDateObj = new DateTime($birthdate);
            $now = new DateTimeImmutable();
            $interval = $now->diff($birthDateObj);
            $age = $interval->y;
        }

        $sql = "UPDATE directors SET name = ?, birthdate = ?, address = ?, age = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $birthdate, $address, $age, $id]);
    }

    public function deleteDirector(int $id): void {
        $sql = "DELETE FROM directors WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
