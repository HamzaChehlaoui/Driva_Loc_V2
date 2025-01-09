CREATE TABLE Articles (
    article_id INT AUTO_INCREMENT PRIMARY KEY,  
    title VARCHAR(255) NOT NULL,                
    content TEXT NOT NULL,                      
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    idUser INT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'  
     FOREIGN KEY (theme_id) REFERENCES Themes(theme_id)                           
);

ALTER TABLE articles 
ADD CONSTRAINT fk_theme_id 
FOREIGN KEY (theme_id) 
REFERENCES themes(theme_id);


CREATE TABLE Tags (
    tag_id INT AUTO_INCREMENT PRIMARY KEY,   
    name VARCHAR(100) NOT NULL UNIQUE          
);

CREATE TABLE Tag_Article (
    article_id INT,                          
    tag_id INT,                               
    PRIMARY KEY (article_id, tag_id),          
    FOREIGN KEY (article_id) REFERENCES Articles(article_id) ON DELETE CASCADE,  
    FOREIGN KEY (tag_id) REFERENCES Tags(tag_id) ON DELETE CASCADE               
);

CREATE TABLE Comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,  
    article_id INT,                             
    idUser INT,                               
    content TEXT NOT NULL,                      
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    FOREIGN KEY (article_id) REFERENCES Articles(article_id) ON DELETE CASCADE,  
    FOREIGN KEY (idUser) REFERENCES user(idUser) ON DELETE CASCADE              
);

CREATE TABLE Favorites (
    favorite_id INT AUTO_INCREMENT PRIMARY KEY,  
    idUser INT,                                
    article_id INT,                            
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    FOREIGN KEY (idUser) REFERENCES user(idUser) ON DELETE CASCADE,  
    FOREIGN KEY (article_id) REFERENCES Articles(article_id) ON DELETE CASCADE  
);

CREATE TABLE Themes (
    theme_id INT AUTO_INCREMENT PRIMARY KEY,   
    name VARCHAR(255) NOT NULL UNIQUE          
);

