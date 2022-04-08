<?php

session_start();
include("./connect.php");

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$nom = $_FILES['fileToUpload']['name'];
$size = $_FILES['fileToUpload']['size'];
$path = 'uploads/' . $nom;

// Verifier si l'image a été uploadé 
// Verifier extension du fichier 
// verifier la taille 
// verifier le type MIME du fichier
// Verifier si le fichier existe déja dans le dossier 
if(isset($_POST["submit"])) {
    if ($_FILES["fileToUpload"]["size"] < 800000 &&
        $imageFileType = "jpg" && $imageFileType = "png" &&
        !file_exists($target_file) &&
        getimagesize($_FILES["fileToUpload"]["tmp_name"])) {
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            echo "L'image a bien été uploadée";
            $sql = "INSERT INTO files"." (nom, type, path, size)"." VALUES "."('$nom','$imageFileType ','$path','$size')";
                         if ($conn->query($sql)==TRUE) {
                             echo "";
                           }else {
                            echo "Error: ".$sql."<br>".$conn->error;
                           }
            $_SESSION['message'] = "Image ajoutée avec succès !";
            header('Location: ./admin.php');


    } else {
        $_SESSION['erreur'] = "Erreur lors tu chargement de l'image !";
        header('Location: ./admin.php');
    }
} else {
    echo "Erreur";
}

?>