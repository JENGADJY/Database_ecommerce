<?php
require_once 'vendor/autoload.php';

use Faker\Factory as Faker;

$host = 'localhost';
$dbname = 'projet_sql';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$faker = Faker::create();

// Fonction pour insérer des adresses
function insertAddresses($pdo, $faker, $n) {
    for ($i = 0; $i < $n; $i++) {
        $stmt = $pdo->prepare("INSERT INTO adresse (Street, nombre, zip, Country) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $faker->streetName,
            $faker->buildingNumber,
            $faker->postcode,
            $faker->country
        ]);
    }
}

// Fonction pour insérer des utilisateurs
function insertUsers($pdo, $faker, $n) {
    for ($i = 0; $i < $n; $i++) {
        $stmt = $pdo->prepare("INSERT INTO `User` (nom, prenom, email, numero, id_adress) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $faker->lastName,
            $faker->firstName,
            $faker->email,
            $faker->phoneNumber,
            rand(1, $n)
        ]);
    }
}

// Fonction pour insérer des avis
function insertReviews($pdo, $faker, $n) {
    for ($i = 0; $i < $n; $i++) {
        $stmt = $pdo->prepare("INSERT INTO review (id_user, review, note) VALUES (?, ?, ?)");
        $stmt->execute([
            rand(1, $n),
            $faker->text,
            rand(0, 5)
        ]);
    }
}

// Fonction pour insérer des produits
function insertProducts($pdo, $faker, $n) {
    for ($i = 0; $i < $n; $i++) {
        $stmt = $pdo->prepare("INSERT INTO Produit (prix, stock, description, id_review) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $faker->randomFloat(2, 5, 100),
            rand(1, 100),
            $faker->text,
            rand(1, $n)
        ]);
    }
}

// Fonction pour insérer des paiements
function insertPayments($pdo, $faker, $n) {
    for ($i = 0; $i < $n; $i++) {
        $stmt = $pdo->prepare("INSERT INTO paiement (type, total, status, date) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $faker->creditCardType,
            $faker->randomFloat(2, 20, 500),
            $faker->randomElement(['Paid', 'Pending', 'Failed']),
            $faker->date
        ]);
    }
}

// Fonction pour insérer des éléments de panier (cart_id)
function insertCartItems($pdo, $n) {
    for ($i = 0; $i < $n; $i++) {
        $stmt = $pdo->prepare("INSERT INTO cart_id (id_produit, quantite) VALUES (?, ?)");
        $stmt->execute([
            rand(1, $n),
            rand(1, 5)
        ]);
    }
}

// Fonction pour insérer des paniers (Cart)
function insertCarts($pdo, $n) {
    for ($i = 0; $i < $n; $i++) {
        $stmt = $pdo->prepare("INSERT INTO Cart (total, id_user, cart_id) VALUES (?, ?, ?)");
        $stmt->execute([
            rand(20, 200),
            rand(1, $n),
            rand(1, $n)
        ]);
    }
}

// Fonction pour insérer des commandes
function insertOrders($pdo, $n) {
    for ($i = 0; $i < $n; $i++) {
        $stmt = $pdo->prepare("INSERT INTO Commande (id_user, id_adress, id_cart, id_paiement) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            rand(1, $n),
            rand(1, $n),
            rand(1, $n),
            rand(1, $n)
        ]);
    }
}

// Fonction pour insérer des factures
function insertInvoices($pdo, $n) {
    for ($i = 0; $i < $n; $i++) {
        $stmt = $pdo->prepare("INSERT INTO facture (id_user, id_commande) VALUES (?, ?)");
        $stmt->execute([
            rand(1, $n),
            rand(1, $n)
        ]);
    }
}

// Exécution des fonctions
insertAddresses($pdo, $faker, 10);
insertUsers($pdo, $faker, 10);
insertReviews($pdo, $faker, 10);
insertProducts($pdo, $faker, 10);
insertPayments($pdo, $faker, 10);
insertCartItems($pdo, 10);
insertCarts($pdo, 10);
insertOrders($pdo, 10);
insertInvoices($pdo, 10);

echo "Données fictives insérées avec succès.";

?>
