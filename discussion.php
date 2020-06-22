
<head><meta http-equiv="refresh" content="10;url=discussion.php">
<?php
session_start();

if(!empty($_POST['deco']))
{
	unset($_SESSION['login']);
	unset($_SESSION['password']);
	unset($_SESSION['profil']);
}
	$db= mysqli_connect("localhost", "root", "", "discussion"); 
	$query="SELECT login, date, id_utilisateur, message FROM `utilisateurs` ,`messages` WHERE utilisateurs.id = id_utilisateur ORDER BY `messages`.`id` ASC";
	$result= mysqli_query($db, $query);
	$query1="SELECT id, message FROM `messages`";
	$result1= mysqli_query($db, $query1);
	
	
?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href ="index.css"/>
<link href="accueil.css" rel="stylesheet">
<title>Discussion</title>
<link href="https://fonts.googleapis.com/css?family=Francois+One&display=swap" rel="stylesheet">
<link rel="icon" href="goku-nuage.png"/>
</head>

<body class="discussion">
	
<?php
if((isset($_SESSION['login']))&&(isset($_SESSION['password'])))
{
?>

<header>	
	<ul class="ul2">
		<li><a href="index.php">Accueil</a></li>

<div class="boutondeco">
<form class="déconnexion" method="post" action="discussion.php">
<input type="submit" name="deco" value="Déconnexion">
</form>
</div>
</ul>

<?php
}
else
{
?>

 <header> <div class="topnav">
  <a href="index.php">Accueil</a>

</div></header>
<?php	
}
if(!empty($_POST['deco']))
{
unset($_SESSION['login']);
unset($_SESSION['password']);
}

?>
	
</header>

<article class="espacecommentaire">
<table>
<tr>
<td><strong>Utilisateur(s)</strong></td>
<td><strong>Messages</strong></td>
</tr>
	
<?php
while(($row = mysqli_fetch_array($result))&& ($row1 = mysqli_fetch_array($result1))){
?>
	<tr>
		<td><?php echo "Posté par : ";echo "<strong>".$row['login']."</strong>"; echo " le "; echo $row['date'];?></td>
		<td><?php echo $row['message'];?></td>
		
		<?php
		
		if(isset($_SESSION['login']))
		{
		if(($_SESSION['login'] == $row['login'])||($_SESSION['login']=="admin"))
		{
		?>

		<td>
		<form method="post">
		<input type="submit" name="effacer" value="Supprimer">
		<input type="hidden" name="moi" value="<?php echo $row1['id'] ?>">  
		</form>
		<?php
		} 
		if(isset($_POST['effacer']))
		{
			$message= $_POST['moi'];
			$query2="DELETE FROM `messages` WHERE message . id = '$message'";
			$result2= mysqli_query($db, $query2);
			$_SESSION['delete']=true;
			header ('location: discussion.php');			
			
		}
		}
	}
		?>

		</td>
	</tr>

<?php

if(!isset($_SESSION['login']))
{
    header('Location: connexion.php');    
}

$login=$_SESSION['login'];

$requeteid="SELECT id FROM utilisateurs WHERE login='$login'";
$query=mysqli_query($db, $requeteid);
$id=mysqli_fetch_array($query);

?>

<div class="ajtcomm"><h2>Ajoutez votre messages:</h2>    

<form class="formulaire1" name="inscription" method="post" action="discussion.php">
    
      Votre commentaire: <br><textarea name="message"></textarea></br>

      <input type="submit" name="valider" value="OK"/>
      </form>
      <?php

      if(isset($_POST['valider']))
{

 $message=$_POST['message'];
 $id=$id['id'];
 $time="SELECT date FROM messages, utilisateurs WHERE id_utilisateur='$id' ORDER BY messages.id DESC ";
 $req2=mysqli_query($db , $time);
 $req3=mysqli_fetch_array($req2);
 $req4=mysqli_num_rows($req2);

 if($req4 > 0)
 {
 date_default_timezone_set('Europe/Paris');
 $date1=date_create(date("Y-m-d H:i:s"));
 $date2=date_create($req3['date']);


if( date_timestamp_get($date1)-date_timestamp_get($date2) < 10)
{

    echo "Veuillez attendre au moins 10 secondes";
}
else 
{
    $requete="INSERT INTO `messages` (`id`, `message`, `id_utilisateur`, `date`) VALUES (NULL, '$message', '$id', CURRENT_TIMESTAMP())";
    mysqli_query($db, $requete);
    header('location: discussion.php');
}
}
else 
{
    $requete="INSERT INTO `messages` (`id`, `message`, `id_utilisateur`, `date`) VALUES (NULL, '$message', '$id', CURRENT_TIMESTAMP())";
    mysqli_query($db, $requete);
    header('location: discussion.php');
}

}

 ?>
		<?php

mysqli_close($db);
?>
</table>
</article>

<?php
	
?>

<footer>

<p class="page">
Discussion &emsp;
Remy.I ©  &emsp;  2020  &emsp; Tous droits réservés.  
</p>

</footer>

</body>

</html>
