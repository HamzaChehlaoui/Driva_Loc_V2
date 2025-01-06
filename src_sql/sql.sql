CREATE DATABASE drive_loc ;

CREATE TABLE Role (
	idRole INT AUTO_INCREMENT PRIMARY KEY,
	nomeRole VARCHAR(255) NOT NULL UNIQUE
    );

INSERT INTO Role (nomeRole) VALUES ('Admin');
INSERT INTO Role (nomeRole) VALUES ('Client');

CREATE TABLE User (
    idUser INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL ,
    emeil VARCHAR(255) NOT NULL ,
    motDepasse VARCHAR(255) NOT NULL  ,
    adresse VARCHAR(255) ,  
    releId INT ,
    FOREIGN KEY (roleId) REFERENCES Role(idRole)

);

CREATE TABLE Categorie (
        idCategorie INT AUTO_INCREMENT PRIMARY KEY ,
        nom VARCHAR(255) NOT NULL,
        description TEXT
);

CREATE TABLE Vehicule (
    idVehicule INT AUTO_INCREMENT PRIMARY KEY ,
    modele VARCHAR(255) NOT NULL ,
    prix   DECIMAL(10, 2) NOT NULL ,
    disponible varchar(255) NOT NULL ,
    categorieId INT ,
    FOREIGN KEY (categorieId) REFERENCES Categorie(idCategorie)
);

CREATE TABLE Avis (
    idAvis INT AUTO_INCREMENT PRIMARY KEY ,
    note INT NOT NULL ,
    commentaire TEXT ,
    dateAvis DATE,
    vehiculeId INT ,
    userId INT ,
    FOREIGN KEY (vehiculeId) REFERENCES Vehicule(idVehicule),
    FOREIGN KEY (userId) REFERENCES user(iduser)
);

CREATE TABLE Reservation (
    idReservation INT AUTO_INCREMENT PRIMARY KEY,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL,
    statut VARCHAR(255) NOT NULL,
    vehiculeId INT,
    userId INT,
    FOREIGN KEY (vehiculeId) REFERENCES Vehicule(idVehicule),
    FOREIGN KEY (userId) REFERENCES User(idUser)
);

ALTER TABLE vehicule 
ADD COLUMN img VARCHAR(255);