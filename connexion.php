
<?php

if(isset($_POST['Valider']))
{

$user=htmlspecialchars(trim($_POST['login']));
$pass=htmlspecialchars(trim($_POST['password']));

$base=mysqli_connect("localhost","root","","discussion");
$req= "SELECT * FROM utilisateurs WHERE login='$user'";
$result= mysqli_query($base,$req);
$row= mysqli_fetch_array($result);


if(password_verify($_POST['password'],$row['password']))
  {
    session_start();
      echo 'Vous êtes connecté ', $user . ' !';
      $_SESSION['login']=$user;
      $_SESSION['password']=$pass;
      header('Location: index.php');
  }
  else
  {
    echo 'Login ou password incorrect';
  }

}

?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="index.css">
	<title>Connexion</title>
  <meta charset= "utf-8">
  <link href="https://fonts.googleapis.com/css?family=Francois+One&display=swap" rel="stylesheet">
  <link rel="icon" href="goku-nuage.png"/>
</head>

<body>

<h1> Connexion </h1>

<div class="en-tete">
<a href="index.php">Accueil</a> <a href="inscription.php">Inscription</a> <a href="connexion.php">Connexion</a> <a href="profil.php">Modifier profil</a> <a href="discussion.php">Discussion</a>
</div>
     
<section id="adam">
<div class="dispositon">
<form class="form1" action="" method="post">
<p>Login:</p> <input  required type="text" name="login">
<p>Password:</p><input required type ="password" name="password">
<input required class="button" type="submit" name="Valider"> 
</div>
</section>

<footer>

<p class="page">
Discussion &emsp;
Remy.I  Adam.T Jeremy.B ©  &emsp; 2020  &emsp; Tous droits réservés.  
</p>

</footer>

</body> 

</html>
