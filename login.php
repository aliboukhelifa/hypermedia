<?php
session_start();

function is_connected(){
   if (session_status() === PHP_SESSION_NONE) {
      session_start();
   }
   $user = $_SESSION['email'] ?? null;
   if($user === null) {
      return null;
   }

   include("./connect.php");
   $sel=$conn->prepare("select * from account where email=?");
   $sel->execute(array($user));
   $tab=$sel->fetch();
   return $user ?: null;
}

function is_connected_admin(){
   if(is_connected() && $_SESSION['role'] === 'admin'){
      return true;
   } 
   return false;
}

if(is_connected_admin()) {
   header('location: ./tp4_admin/home.php');
}elseif (is_connected() !== null) {
   header('location: ./index.php');
}

function valid_inputs($inputs){
   $inputs = trim($inputs);
   $inputs = stripslashes($inputs);
   $inputs = htmlspecialchars($inputs);
   $inputs = strip_tags($inputs);
   return $inputs;
}

if (isset($_POST['email'])){
   include("connect.php");
   $email=valid_inputs($_POST["email"]);
   $password= valid_inputs($_POST['password']);
   $sel=$conn->prepare("select * from account where email=?");
   $sel->execute(array($email));
   $tab=$sel->fetch();
   
   $is_password_correct = password_verify($_POST['password'], $tab['password']);
   if($tab && $is_password_correct){
         $_SESSION['user_id'] = $tab['user_id'];
         $_SESSION['email']= $tab['email'];
         $_SESSION['role']=$tab['role'];
      if ($tab['role'] === 'admin') {
         header("location:./admin.php");
         exit();
      }else{
         header("location: ./index.php");
         exit();
      } 
   }else{
      $erreur = "Wrong email or password.";
   }
}
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <link rel="stylesheet" href="./css/login.css" />
   </head>
   <body>
<form class="box" action="" method="post" name="login">
<h1 class="box-logo box-title">
      <img src="./img/logo.png" alt="hypertext markup language" height="150" width="350" />
   </a>
</h1>
<h1 class="box-title">Catalogue d'images Ali</h1>
<input type="email" class="box-input" name="email" placeholder="Email" required>
<input type="password" class="box-input" name="password" placeholder="Password" required>
<input type="submit" value="Connexion" name="submit" class="box-button">
<?php if (! empty($erreur)) { ?>
    <p class="errorMessage"><?php echo $erreur; ?></p>
<?php } ?>
</form>
</body>
</html>