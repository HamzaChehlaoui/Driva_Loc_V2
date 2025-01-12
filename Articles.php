<?php
// classes/Article.php
class Article {
    private $conn;
    private $table_name = "articles";

    public function __construct($db) {
        $this->conn = $db;
    }
    public function getFilteredArticles($search = '', $theme = null, $tag = null, $limit = null, $offset = null) {
        $sql = "SELECT DISTINCT a.* FROM articles a 
                LEFT JOIN tag_article ta ON a.article_id = ta.article_id 
                WHERE (a.status = 'approved' OR a.idUser = :userId)";
        
        $params = [':userId' => $_SESSION['idUser'] ?? 0];
        
        if ($search) {
            $sql .= " AND (a.title LIKE :search OR a.contents LIKE :search)";
            $params[':search'] = "%$search%";
        }
        
        if ($theme) {
            $sql .= " AND a.theme_id = :theme";
            $params[':theme'] = $theme;
        }
        
        if ($tag) {
            $sql .= " AND ta.tag_id = :tag";
            $params[':tag'] = $tag;
        }
        
        $sql .= " ORDER BY a.created_at DESC";
        
        // Add LIMIT and OFFSET directly to the SQL string instead of binding them
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
            
            if ($offset !== null) {
                $sql .= " OFFSET " . (int)$offset;
            }
        }
        
        $stmt = $this->conn->prepare($sql);
        
        // Execute with params
        foreach ($params as $key => $val) {
            if (is_int($val)) {
                $stmt->bindValue($key, $val, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $val, PDO::PARAM_STR);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalFilteredArticles($search = '', $theme = null, $tag = null) {
        $sql = "SELECT COUNT(DISTINCT a.article_id) as total FROM articles a 
                LEFT JOIN tag_article ta ON a.article_id = ta.article_id 
                WHERE (a.status = 'approved' OR a.idUser = :userId)";
        
        $params = [':userId' => $_SESSION['idUser'] ?? 0];
        
        if ($search) {
            $sql .= " AND (a.title LIKE :search OR a.contents LIKE :search)";
            $params[':search'] = "%$search%";
        }
        
        if ($theme) {
            $sql .= " AND a.theme_id = :theme";
            $params[':theme'] = $theme;
        }
        
        if ($tag) {
            $sql .= " AND ta.tag_id = :tag";
            $params[':tag'] = $tag;
        }
        
        $stmt = $this->conn->prepare($sql);
        
        foreach ($params as $key => $val) {
            if (is_int($val)) {
                $stmt->bindValue($key, $val, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $val, PDO::PARAM_STR);
            }
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function createArticle($title, $content, $userId, $themeId, $tags, $image = null) {
        try {
            $this->conn->beginTransaction();
            
            $sql = "INSERT INTO articles (title, contents, idUser, theme_id, img, status) 
                    VALUES (?, ?, ?, ?, ?, 'pending')";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$title, $content, $userId, $themeId, $image]);
            $articleId = $this->conn->lastInsertId();
            
            // Insert tags - only if we have valid tags
            if (is_array($tags) && !empty($tags)) {
                $tagSql = "INSERT INTO tag_article (article_id, tag_id) VALUES (?, ?)";
                $tagStmt = $this->conn->prepare($tagSql);
                foreach ($tags as $tagId) {
                    if (is_numeric($tagId) && $tagId > 0) {  // Additional validation
                        $tagStmt->execute([$articleId, $tagId]);
                    }
                }
            }
            
            $this->conn->commit();
            return $articleId;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function updateArticle($id, $title, $contents, $theme_id, $img = null) {
        $query = "UPDATE " . $this->table_name . " 
                 SET title = ?, contents = ?, theme_id = ?" .
                 ($img ? ", img = ?" : "") .
                 " WHERE article_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $contents);
        $stmt->bindParam(3, $theme_id);
        
        $paramIndex = 4;
        if($img) {
            $stmt->bindParam($paramIndex++, $img);
        }
        $stmt->bindParam($paramIndex, $id);
        
        return $stmt->execute();
    }

    public function deleteArticle($id) {
        $this->deleteArticleTags($id);
        $this->deleteArticleComments($id);
        $this->deleteArticleFavorites($id);
        
        $query = "DELETE FROM " . $this->table_name . " WHERE article_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function getArticleById($id) {
        $query = "SELECT a.*, u.nom as author_name 
                 FROM " . $this->table_name . " a 
                 LEFT JOIN user u ON a.idUser = u.idUser 
                 WHERE a.article_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllTags() {
        $query = "SELECT * FROM tags ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleTags($article_id) {
        $query = "SELECT t.* 
                 FROM tags t 
                 JOIN tag_article ta ON t.tag_id = ta.tag_id 
                 WHERE ta.article_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $article_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addArticleTag($article_id, $tag_id) {
        $query = "INSERT INTO tag_article (article_id, tag_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $article_id);
        $stmt->bindParam(2, $tag_id);
        return $stmt->execute();
    }

    private function deleteArticleTags($article_id) {
        $query = "DELETE FROM tag_article WHERE article_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $article_id);
        return $stmt->execute();
    }

    private function deleteArticleComments($article_id) {
        $query = "DELETE FROM comments WHERE article_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $article_id);
        return $stmt->execute();
    }

    private function deleteArticleFavorites($article_id) {
        $query = "DELETE FROM favorites WHERE article_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $article_id);
        return $stmt->execute();
    }
  
        
        
        
        public function approveArticle($articleId, $reviewerId) {
            $sql = "UPDATE articles 
                    SET status = 'approved', 
                        reviewed_by = ?, 
                        reviewed_at = CURRENT_TIMESTAMP 
                    WHERE article_id = ?";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$reviewerId, $articleId]);
        }
        
        public function rejectArticle($articleId, $reviewerId) {
            $sql = "UPDATE articles 
                    SET status = 'rejected', 
                        reviewed_by = ?, 
                        reviewed_at = CURRENT_TIMESTAMP 
                    WHERE article_id = ?";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$reviewerId, $articleId]);
        }
        
        
    }

