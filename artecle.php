<?php
require 'conn.php';


class Article {
  
   public $user_id ;
    public $conn;
    public $table_name = "articles";  
    public $title;
    public $content;
    public $idtheme;
    public $image;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addArticle() {
        
        if (empty($this->title) || empty($this->content)) {
            echo "Title and content are required.";
            return false;
        }
        
        $query = "INSERT INTO " . $this->table_name . " (title, content, idUser ,theme_id ,img) VALUES (:title, :content ,:user_id, :idtheme ,:image)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':idtheme', $this->idtheme);
        $stmt->bindParam(':image', $this->image);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getArticles() {
        if (!$this->conn instanceof PDO) {
            echo 'Connection is not a valid PDO object';
            return [];
        }
    
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);  
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
