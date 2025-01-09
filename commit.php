<?php 
       require('conn.php') ;
class commit {
    public $content;
    public $article_id;
    public $conn;
    private $table_name='comments';
    public $idUser ;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function addCommit(){
        if (empty($this->content) ) {
            echo "Title and content are required.";
            return false;
        }
        $query ="INSERT INTO " . $this->table_name  ."(article_id ,idUser, content) VALUES (:article_id ,:idUser ,:content )";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':article_id', $this->article_id);
        $stmt->bindParam(':idUser', $this->idUser);
        $stmt->bindParam(':content', $this->content);


        if($stmt->execute()){
            return true;
        }
        return false;
    
    }
    
    
}

?>