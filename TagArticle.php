<?php
class TagArticle {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Get all tags for an article
    public function getArticleTags($articleId) {
        $query = "SELECT t.* 
                 FROM tags t 
                 JOIN tag_article ta ON t.tag_id = ta.tag_id 
                 WHERE ta.article_id = ?
                 ORDER BY t.name";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Add a tag to an article
    public function addTagToArticle($articleId, $tagId) {
        // Check if relationship already exists
        if ($this->isTagLinked($articleId, $tagId)) {
            return false;
        }
        
        $query = "INSERT INTO tag_article (article_id, tag_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$articleId, $tagId]);
    }
    
    // Remove a tag from an article
    public function removeTagFromArticle($articleId, $tagId) {
        $query = "DELETE FROM tag_article WHERE article_id = ? AND tag_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$articleId, $tagId]);
    }
    
    // Check if a tag is already linked to an article
    public function isTagLinked($articleId, $tagId) {
        $query = "SELECT COUNT(*) FROM tag_article WHERE article_id = ? AND tag_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$articleId, $tagId]);
        return $stmt->fetchColumn() > 0;
    }
    
    // Get all tags that can be added to an article
    // (i.e., tags that aren't already linked to the article)
    public function getAvailableTags($articleId) {
        $query = "SELECT t.* 
                 FROM tags t 
                 WHERE t.tag_id NOT IN (
                     SELECT tag_id 
                     FROM tag_article 
                     WHERE article_id = ?
                 )
                 ORDER BY t.name";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get articles by tag
    public function getArticlesByTag($tagId, $limit = 10, $offset = 0) {
        $query = "SELECT a.* 
                 FROM articles a 
                 JOIN tag_article ta ON a.article_id = ta.article_id 
                 WHERE ta.tag_id = ? 
                 ORDER BY a.created_at DESC 
                 LIMIT ? OFFSET ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$tagId, $limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Count articles with a specific tag
    public function countArticlesByTag($tagId) {
        $query = "SELECT COUNT(*) 
                 FROM tag_article 
                 WHERE tag_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$tagId]);
        return $stmt->fetchColumn();
    }
    
    // Remove all tags from an article
    public function removeAllTagsFromArticle($articleId) {
        $query = "DELETE FROM tag_article WHERE article_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$articleId]);
    }
    
    // Add multiple tags to an article
    public function addMultipleTagsToArticle($articleId, array $tagIds) {
        try {
            $this->conn->beginTransaction();
            
            foreach ($tagIds as $tagId) {
                if (!$this->isTagLinked($articleId, $tagId)) {
                    $query = "INSERT INTO tag_article (article_id, tag_id) VALUES (?, ?)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->execute([$articleId, $tagId]);
                }
            }
            
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Get popular tags (most used)
    public function getPopularTags($limit = 10) {
        $query = "SELECT t.*, COUNT(ta.article_id) as usage_count 
                 FROM tags t 
                 LEFT JOIN tag_article ta ON t.tag_id = ta.tag_id 
                 GROUP BY t.tag_id 
                 ORDER BY usage_count DESC 
                 LIMIT ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}