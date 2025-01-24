-- Table des variétés de thé
CREATE TABLE variete_the (
    id_variete INT PRIMARY KEY AUTO_INCREMENT,
    nom_variete VARCHAR(100) NOT NULL,
    occupation_surface DECIMAL(12,2) NOT NULL, -- surface occupée par un pied (m2)
    rendement_par_pied DECIMAL(12,2) NOT NULL, -- kg de feuilles par mois
    prix_unitaire DECIMAL(12,2) NOT NULL
);

-- Table des parcelles
CREATE TABLE parcelle (
    id_parcelle INT PRIMARY KEY AUTO_INCREMENT,
    surface DECIMAL(10,2) NOT NULL,
    id_variete INT,
    FOREIGN KEY (id_variete) REFERENCES variete_the(id_variete)
);

-- Table des cueilleurs
CREATE TABLE cueilleur (
    id_cueilleur INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    genre VARCHAR(10),
    date_naissance DATE
);

-- Table des catégories de dépenses
CREATE TABLE categorie_depense (
    id_categorie INT PRIMARY KEY AUTO_INCREMENT,
    nom_categorie VARCHAR(100) NOT NULL
);

-- Table de configuration des salaires
CREATE TABLE salaire (
    id_salaire INT PRIMARY KEY AUTO_INCREMENT,
    id_cueilleur INT REFERENCES cueilleur(id_cueilleur),
    prix_kg DECIMAL(10,2) NOT NULL
);

-- Table des dépenses
CREATE TABLE depense (
    id_depense INT PRIMARY KEY AUTO_INCREMENT,
    date_depense DATE NOT NULL,
    id_categorie INT,
    montant DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES categorie_depense(id_categorie)
);
-- Table des cueillettes
CREATE TABLE cueillette (
    id_cueillette INT PRIMARY KEY AUTO_INCREMENT,
    date_cueillette DATE NOT NULL,
    id_cueilleur INT,
    id_parcelle INT,
    quantite DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_cueilleur) REFERENCES cueilleur(id_cueilleur),
    FOREIGN KEY (id_parcelle) REFERENCES parcelle(id_parcelle)
);


-- Table des utilisateurs (pour l'authentification)
CREATE TABLE utilisateur (
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

CREATE TABLE periode_regeneration(
    id_regeneration INT PRIMARY KEY AUTO_INCREMENT,
    id_variete INT REFERENCES variete_the(id_variete),
    mois INT NOT NULL 
);

CREATE TABLE renumeration(
    id_renumeration INT PRIMARY AUTO_INCREMENT ,
    id_cueilleur INT REFERENCES cueilleur(id_cueilleur),
    poids_min DECIMAL (10,2) NOT NULL,
    bonus DECIMAL (10,2) NOT NULL,
    mallus DECIMAL (10,2) NOT NULL
);