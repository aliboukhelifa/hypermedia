<?php
try{
    // Connexion to the database with pdo
    $conn = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=hypermedia_db', 'postgres','');
    $conn->exec('SET NAMES "UTF8"');
   // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo 'Erreur : '. $e->getMessage();
    die();
}

?>