<?php
class Comment {
    private $conn;
    private $table_name = "comments";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to retrieve all comments for a specific article
    public function getCommentsByArticleId($articleId) {
        $query = "SELECT c.comment_id, c.content, c.created_at, c.idUser
                  FROM " . $this->table_name . " c
                  WHERE c.article_id = :article_id
                  ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to add a new comment
    public function addComment($idUser, $articleId, $content) {
        $query = "INSERT INTO " . $this->table_name . " (idUser, article_id, content, created_at)
                  VALUES (:idUser, :article_id, :content, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->bindParam(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Method to delete a comment
    public function deleteComment($commentId, $userId) {
        $query = "DELETE FROM " . $this->table_name . " WHERE comment_id = :comment_id AND idUser = :idUser";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $stmt->bindParam(':idUser', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Method to edit a comment
  
        public function editComment($commentId, $userId, $newComment) {
            $query = "UPDATE comments SET content = :content WHERE comment_id = :comment_id AND idUser = :idUser";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':content', $newComment);
            $stmt->bindParam(':comment_id', $commentId);
            $stmt->bindParam(':idUser', $userId);
            return $stmt->execute();
        }
    }
    

