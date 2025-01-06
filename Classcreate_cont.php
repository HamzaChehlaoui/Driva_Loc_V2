<?php
class User {
    private $conn;
    private $email;
    private $motDepasse;
    private $nom;
    private $adresse;
    private $roleId;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function setEmail($email) {
        $this->email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    public function setPassword($motDepasse) {
        $this->motDepasse = password_hash($motDepasse, PASSWORD_BCRYPT);
    }

    public function setFirstName($nom) {
        $this->nom = $nom;
    }

    public function setLastName($adresse) {
        $this->adresse = $adresse;
    }

    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    public function register() {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format!";
        }
            
        $stmt = $this->conn->prepare("INSERT INTO user (emeil, motDepasse, nom, adresse, roleId) VALUES (:emeil,:motDepasse, :nom, :adresse, :roleId)");
        
      
        $stmt->bindParam(':emeil', $this->email);
        $stmt->bindParam(':motDepasse', $this->motDepasse);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':adresse', $this->adresse);
        $stmt->bindParam(':roleId', $this->roleId);
    
        if ($stmt->execute()) {
            return "New record inserted successfully!";
        } else {
            return "Error: " . $stmt->errorInfo()[2];  
        }
    }
    
}
?>