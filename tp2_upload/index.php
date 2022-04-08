<?php

// Check the current page 
if(isset($_GET['page']) && !empty($_GET['page'])){
  $currentPage = (int) strip_tags($_GET['page']);
}else{
  $currentPage = 1; 
}

session_start();
require_once('../connect.php');

$sql = 'SELECT COUNT(*) AS nb_img FROM files;';
$query = $conn->prepare($sql);
$query->execute();
$result = $query->fetch(); 

$nbImg = (int) $result['nb_img'];

// Number of images per page 
$perPage = 10; 

//  Calculate the numbe of pages
$pages = ceil($nbImg/$perPage); 

// Calculate the first departement per page 
$firstOfPage = ($currentPage * $perPage) - $perPage; 

// sql query to retrieve all departments
$sql = 'SELECT * FROM files LIMIT :per_page OFFSET :first_of_page;';

// Prepare our query for execution with pdo
$query = $conn->prepare($sql);

$query->bindValue(':first_of_page', $firstOfPage, PDO::PARAM_INT);
$query->bindValue(':per_page', $perPage, PDO::PARAM_INT);

// Execution 
$query->execute();

// Recover the result of the execution in an associative array
$images = $query->fetchall(PDO::FETCH_ASSOC);

// Close the db connexion
$conn = null; 



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/upload.css" />

    <!-- Get bootstrap style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<main class="container">
    <div class="row">
            <section class="col-12">
            <form action="upload.php" method="post" enctype="multipart/form-data">
              <h1>Selectionner une image</h1>
              <input type="file" name="fileToUpload" id="fileToUpload">
              <input type="submit" value="Upload Image" name="submit">
              <p>Seules jpg png taille max 8 Mo</p>
            </form>

      <?php
          if(!empty($_SESSION['erreur'])){
            echo '<div class="alert alert-danger" role="alert">'. $_SESSION['erreur'].' </div>';
            $_SESSION['erreur'] = "";
          }
        ?>
        <?php
          if(!empty($_SESSION['message'])){
            echo '<div class="alert alert-success" role="alert">'. $_SESSION['message'].' </div>';
            $_SESSION['message'] = "";
          }
      ?>

            <h1> Mon catalogue d'images </h1>
                <div class="images-block">
                    <?php if(count($images) > 0) {
                        foreach($images as $row) {
                            echo '<img src=' . $row['path'] .'>';
                        }
                    }
                    ?>

                </div> <br>
                <nav>
                    <ul class="pagination">
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="./?page=<?= $currentPage-1 ?>" class="page-link"> Previous </a>
                        </li>

                        <?php for($page = 1; $page <= $pages; $page++): ?>
                            <li class="page-item  <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor ?>   

                        <li class="page-item  <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="./?page=<?= $currentPage+1 ?>" class="page-link"> Next </a>
                        </li>
                    </ul> 
                </nav>
            </section>
        </div>
    </main>
    

</body>
</html>