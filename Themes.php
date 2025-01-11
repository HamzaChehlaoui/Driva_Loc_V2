<?php
// classes/Theme.php
class Theme {
    private $conn;
    private $table_name = "themes";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllThemes() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getThemeById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE theme_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createTheme($name) {
        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $name);
        return $stmt->execute();
    }

    public function updateTheme($id, $name) {
        $query = "UPDATE " . $this->table_name . " SET name = ? WHERE theme_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $id);
        return $stmt->execute();
    }

    public function deleteTheme($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE theme_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }
}