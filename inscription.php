
<!DOCTYPE html>
<html>

<head>
<link href="index.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Francois+One&display=swap" rel="stylesheet">
<title>Inscription</title>
<meta charset= "utf-8">
<link rel="icon" href="goku-nuage.png"/>
</head>

<body class="inscription">

<h1> Inscription </h1>

<header>	
<div class="en-tete">
<a href="index.php">Accueil</a> <a href="inscription.php">Inscription</a> <a href="connexion.php">Connexion</a> <a href="profil.php">Modifier profil</a> <a href="discussion.php">Discussion</a>
</div>
</header>

<?php


?>

<article class="form">

<form class="inscriptionform" method="post" action="inscription.php"> 

<?php

if(!empty($_POST['inscription']))
{
	$connexion= mysqli_connect("localhost", "root", "", "discussion");
	$login=$_POST['login'];
	$checkdups="SELECT  *from utilisateurs WHERE login='$login'";
    $checkdups2=mysqli_query($connexion, $checkdups) or die(mysqli_error($connexion));
    $checkdups3=mysqli_num_rows($checkdups2);
	
	if((($_POST['password']!=$_POST['passwordagain'])||($checkdups3>0))||(strlen($_POST['password'])< 5))
	{
		if(($_POST['password']!=$_POST['passwordagain'])&&($checkdups3>0))
		{
			?>

			<div class="affichage">
			<?php
			echo"*Mots de passes rentrés différents";
			?>

			</div>
			<div class="affichage">
			<?php
			echo"*Veuillez renseigner un autre login";
			mysqli_close($connexion);
			?>

			</div>
			<?php
		}
		else if((strlen($_POST['password'])< 5)&&($checkdups3>0))
		{  
			?>

			<div class="affichage">
			<?php
			echo"*Veuillez renseigner un autre login";
			?>

			</div>
			<div class="affichage">
			<?php
			echo"*Mots de passes trop courts";
			echo" 5 caractères minimum";
			mysqli_close($connexion);
			?>

			</div>
			<?php			
		}	
		else if($checkdups3>0)
		{	  
			?>

			<div class="affichage">
			<?php
			echo "*Veuillez renseigner un autre login";
			?>

			</div>
			<?php
			mysqli_close($connexion);	
		}
		else if($_POST['password']!=$_POST['passwordagain'])
		{  
			?>

			<div class="affichage">
			<?php
			echo"*Mots de passes rentrés différents";
			mysqli_close($connexion);
			?>

			</div>
			<?php			
		}
		else if(strlen($_POST['password']< 5))
		{  
			?>

			<div class="affichage">
			<?php
			echo"*Mots de passes trop courts";
			echo " 5 caractères minimum";
			mysqli_close($connexion);
			?>

			</div>
			<?php			
		}	
	}	
	else
	{	

			$hash = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);					
			$connexion= mysqli_connect("localhost", "root", "", "discussion"); 
			$query = 'INSERT INTO `utilisateurs`(`login`,`password`)VALUES
			("'.$_POST['login'].'", "'.$hash.'");';		
			mysqli_query($connexion, $query);		 
			mysqli_close($connexion);
			header('Location: connexion.php');	
			
			
	}
}
	
?>
		<p>Login:</p><input type="text" required placeholder="Login" name="login"></br>
		<p>Password:</p><input type="password" required placeholder="Password (5 caractères minimum)"  name="password"></br>
		<p>Confirm Password:</p><input type="password" required placeholder="Confirm Password"  name="passwordagain"></br></br>
		<input type="submit" value="Inscription" name="inscription"></br></br>
		<input type="reset" value="Effacer" name="reset">
	</form>

</article>

<footer>

<p class="page">
Discussion &emsp;
Remy.I  Adam.T Jeremy.B ©  &emsp; 2020  &emsp; Tous droits réservés.  
</p>

</footer>

</body>

</html>
