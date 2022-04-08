<?php

// Check the current page 
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1; 
}

// Connexion to the db
require_once('../connect.php');

// The nomber of all departements 
$sql = 'SELECT COUNT(*) AS nb_departements FROM departement;';
$query = $conn->prepare($sql);
$query->execute();
$result = $query->fetch(); 

$nbDepartements = (int) $result['nb_departements'];

// Number of departements per page 
$perPage = 9; 

//  Calculate the numbe of pages
$pages = ceil($nbDepartements/$perPage); 

// Calculate the first departement per page 
$firstOfPage = ($currentPage * $perPage) - $perPage; 

// sql query to retrieve all departments
$sql = 'SELECT * FROM departement LIMIT :per_page OFFSET :first_of_page;';

// Prepare our query for execution with pdo
$query = $conn->prepare($sql);

$query->bindValue(':first_of_page', $firstOfPage, PDO::PARAM_INT);
$query->bindValue(':per_page', $perPage, PDO::PARAM_INT);


// Execution 
$query->execute();

// Recover the result of the execution in an associative array
$departements = $query->fetchall(PDO::FETCH_ASSOC);

// Close the db connexion
$conn = null; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Get bootstrap style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1> List of french departments </h1>
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Code</th>
                        <th> Departement Name</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach($departements as $departement){
                        ?>
                            <tr>
                                <td><?= $departement['id'] ?></td>
                                <td><?= $departement['dep_code'] ?></td>
                                <td><?= $departement['dep_name'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
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