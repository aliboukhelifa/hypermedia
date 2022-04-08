<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <title>Lecture de dossiers recurives</title>
</head>

<body>
    <div class="links">
        <a href="../index.php">Catalogue</a>
    </div>
    <div>
        <?php
        // Fixer le temps d'expiration du script après 500 secondes
        set_time_limit(500);
        $path = "../docs";
        echo '<p class="parent"><i class="fa fa-folder-open"></i> Docs </p>';
        // Appeler la fonction pour la première fois pour parcourir le répértoire docs
        explorerDir($path);

        function explorerDir($path)
        {
            echo '<ul>';
            // Ouvrir le répertoire
            $folder = opendir($path);

            // Récupérer le nom de chaque entrée du dossier (fichier ou dossier)
            // Tant qu'on a une entrée la boucle ne s'arrête pas jusqu'au dernier élément
            while ($entree = readdir($folder)) {
                // Si le nom de l'entrée n'est pas "." qui veut dire le dossier courant ou ".." le dossier précédent
                if ($entree != "." && $entree != "..") {

                    // Si l'entrée est un dossier
                    if (is_dir($path . "/" . $entree)) {
                        echo '<li class="container"> <p><i class="fa fa-folder-open"></i> ' . $entree . '</p>';

                        // Récupérer le chemin du dossier courant
                        $sav_path = $path;

                        // Concaténer le chemin du dossier docs avec le celui du dossier courant (exemple : docs/dir1)
                        $path .= "/" . $entree;

                        // Appeler la fonction pour parcourir le sous-dossier courant	
                        explorerDir($path);

                        // Affecter au path le chemin du dossier parent du dossier courant (c'est-à-dire revenir vers l'arrière)
                        $path = $sav_path;
                    }
                    // Si l'entrée est un fichier
                    else {
                        if (pathinfo($entree, PATHINFO_EXTENSION) == 'jpg' || pathinfo($entree, PATHINFO_EXTENSION) == 'png') {
                            echo '<li class="container"><p><i class="fa fa-picture-o" aria-hidden="true"></i> ' . $entree . '</p>';
                        } elseif (pathinfo($entree, PATHINFO_EXTENSION) == 'htm') {
                            echo '<li class="container"><p><i class="fa fa-code" aria-hidden="true"></i> ' . $entree . '</p>';
                        } elseif (pathinfo($entree, PATHINFO_EXTENSION) == 'txt') {
                            echo '<li class="container"><p><i class="fa fa-file-text-o" aria-hidden="true"></i> ' . $entree . '</p>';
                        }
                        // Récupérer le chemin complet du fichier courant
                        $path_source = $path . "/" . $entree;

                        // Récupérer l'extension et la taille de l'image
                        $extension = pathinfo($entree, PATHINFO_EXTENSION);
                        $size = filesize($path_source);
                        $accepted_extensions = ["png", "jpeg", "jpg", "pjpeg"];

                        // Vérifier si le fichier est une image		
                        if (in_array($extension, $accepted_extensions)) {

                            // Connexion à la base de données
                            include("C:\wamp64\www\hypermedia\connect.php");

                            // Insertion des informations de l'image dans la base de données
                            $query = 'INSERT INTO files (name, type, path, size) VALUES (?, ?, ?, ?);';
                            $statement = $conn->prepare($query);
                            $statement->execute(array($entree, $extension, $path_source, $size));
                        }
                    }
                }
            }
            closedir($folder);
            echo '</ul>';
        }
        ?>
    </div>

</body>

</html>