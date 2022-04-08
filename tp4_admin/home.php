<?php
session_start();

  if(!isset($_SESSION["email"]) || $_SESSION['role'] !== 'admin'){
    header("Location: ../index.php");
    exit(); 
  }

require_once('../connect.php');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Catalogue Admin</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <?php if ( $_SESSION['role'] == 'admin'): ?>
            <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
        <?php else: ?>
            <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Login</a></li>
        <?php endif; ?>
    </ul>
  </div>
</nav>

</body>
</html>
