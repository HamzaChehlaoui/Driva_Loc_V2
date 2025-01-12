<?php
class Comment {
    private $conn;
    private $table_name = "comments";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getCommentsByArticleId($articleId) {
        $query = "SELECT c.comment_id, c.content, c.created_at, c.idUser
                  FROM " . $this->table_name . " c
                  LEFT JOIN user u ON c.idUser = u.idUser
                  WHERE c.article_id = :article_id
                  ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addComment($idUser, $articleId, $content) {
        // First verify article exists
        $articleCheck = $this->conn->prepare("SELECT article_id FROM articles WHERE article_id = ?");
        $articleCheck->execute([$articleId]);
        if (!$articleCheck->fetch()) {
            return false;
        }

        // Then add the comment
        $query = "INSERT INTO " . $this->table_name . " (idUser, article_id, content, created_at)
                  VALUES (:idUser, :article_id, :content, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->bindParam(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteComment($commentId, $userId) {
        // First verify comment exists and belongs to user
        $check = $this->conn->prepare("SELECT comment_id FROM comments WHERE comment_id = ? AND idUser = ?");
        $check->execute([$commentId, $userId]);
        if (!$check->fetch()) {
            return false;
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE comment_id = :comment_id AND idUser = :idUser";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $stmt->bindParam(':idUser', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function editComment($commentId, $userId, $newContent) {
        // First verify comment exists and belongs to user
        $check = $this->conn->prepare("SELECT c.comment_id, a.article_id 
                                     FROM comments c 
                                     JOIN articles a ON c.article_id = a.article_id 
                                     WHERE c.comment_id = ? AND c.idUser = ?");
        $check->execute([$commentId, $userId]);
        if (!$check->fetch()) {
            return false;
        }

        $query = "UPDATE " . $this->table_name . " 
                 SET content = :content, updated_at = NOW() 
                 WHERE comment_id = :comment_id AND idUser = :idUser";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':content', $newContent, PDO::PARAM_STR);
        $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $stmt->bindParam(':idUser', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function validateComment($commentId, $userId) {
        $query = "SELECT c.*, a.article_id 
                 FROM comments c 
                 JOIN articles a ON c.article_id = a.article_id 
                 WHERE c.comment_id = :comment_id AND c.idUser = :idUser";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $stmt->bindParam(':idUser', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}