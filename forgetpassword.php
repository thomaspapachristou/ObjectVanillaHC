
<?php 

  //  We check the information and we store the information in an array
  // On vérifie les informations et on stocke les informations dans un tableau
  if(!empty ($_POST) && !empty($_POST['email'])) {

      require_once 'db/DB.php';
      require_once 'functions.php';
      
      $request = $pdo->prepare('SELECT * FROM users WHERE email = ? AND date_account IS NOT NULL');
      $request->execute([$_POST['email']]);
      $user = $request->fetch();

     if ($user) {

        session_start();
        $reset_token = string_random(60);
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        $_SESSION['flash']['success'] = 'Un email de confirmation a bien été envoyé pour la rénitialisation de votre mot de passe !'; // Intégration d'un modal à l'avenir ... 
        $state = sendMail($_POST['email'],'Renitialisation de mot de passe',"Afin de finaliser la procedure...Merci de cliquer sur ce lien : \n\n http://localhost/resetpassword.php?id={$user->id}&token=$reset_token");
        header('Location: index.php');
        exit();

  }else{
      $_SESSION['flash']['danger'] = 'L\'adresse email n\'est pas valide';
  }
}

?>
  
  <?php require 'header.php' ?>

  <div class="bg">

    <h1> Mot de passe oublié </h1>

    <div class="container" style="position: relative; top: 30%;">
        <form action="" method="POST">

            <div class="form-group">
              <label for="exampleInputEmail1">ADRESSE MAIL</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Votre e-mail ou pseudo..." name="email">
            </div>

            <button type="submit" class="btn btn-primary">Envoyez-moi un email !</button>
          </form>
      </div>
    </div>


<?php require 'footer.php' ?>