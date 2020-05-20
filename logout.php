<?php 
        // session_start(); 
        // unset($_SESSION['auth']);
        // $_SESSION['flash']['success'] = "Votre session a expiré suite à une déconnexion volontaire";
        // header('Location : index.php');
  
        
session_start();
setcookie('remember', NULL, -1);
$_SESSION=array();//on efface toutes les variables de la session
session_destroy(); // Puis on détruit la session
header("location: index.php" ) ; // On renvoie ensuite sur la page d'accueil
        
        ?>