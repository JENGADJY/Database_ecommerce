CREATE TABLE adresse (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    Street VARCHAR(40),
    nombre INTEGER,
    zip TEXT,
    Country VARCHAR(40)
);

CREATE TABLE User (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(40),
    prenom VARCHAR(40),
    email TEXT,
    numero TEXT,
    id_adress INTEGER,
    FOREIGN KEY (id_adress) REFERENCES adresse(id)
);

CREATE TABLE review (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_user INTEGER,
    review TEXT,
    note INTEGER CHECK (note >= 0 AND note <= 5),
    FOREIGN KEY (id_user) REFERENCES User(id)
);

CREATE TABLE Produit (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    prix DECIMAL,
    stock INTEGER,
    description TEXT,
    id_review INTEGER,
    FOREIGN KEY (id_review) REFERENCES review(id)
);

CREATE TABLE paiement (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(40),
    total DECIMAL,
    status VARCHAR(40),
    date DATE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Cart (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    total DECIMAL,
    id_user INTEGER,
    cart_id INTEGER,
    FOREIGN KEY (id_user) REFERENCES User(id)
);

CREATE TABLE cart_id (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_produit INTEGER,
    quantite INTEGER,
    FOREIGN KEY (id_produit) REFERENCES Produit(id)
);


ALTER TABLE Cart
ADD FOREIGN KEY (cart_id) REFERENCES cart_id(id);


CREATE TABLE Commande (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_user INTEGER,
    id_adress INTEGER,
    id_cart INTEGER,
    id_paiement INTEGER,
    FOREIGN KEY (id_user) REFERENCES User(id),
    FOREIGN KEY (id_adress) REFERENCES adresse(id),
    FOREIGN KEY (id_cart) REFERENCES Cart(id),
    FOREIGN KEY (id_paiement) REFERENCES paiement(id)
);

CREATE TABLE facture (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_user INTEGER,
    id_commande INTEGER,
    FOREIGN KEY (id_user) REFERENCES User(id),
    FOREIGN KEY (id_commande) REFERENCES Commande(id)
);
