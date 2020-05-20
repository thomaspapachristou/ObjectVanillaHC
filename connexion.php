<?php 
    session_start();  
    require_once 'functions.php';
    
    verification_cookie();
    if (isset($_SESSION['auth'])) {
      header('Location: account.php');
        exit(); 
    }

  //  We check the information and we store the information in an array
  // On vérifie les informations et on stocke les informations dans un tableau
  if(!empty ($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {

      require_once 'db/DB.php';
      require_once 'functions.php';

      $request = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :username) AND date_account IS NOT NULL');
      $request->execute(['username' => $_POST['username']]);
      $user = $request->fetch();


  // Check auto du hashage pour éviter d'écrire la blinde de ligne et d'avoir des erreurs de sécu
  if(password_verify($_POST['password'], $user->password)) {
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = 'Connexion acceptée ! Redirection en cours ...'; // Intégration d'un modal à l'avenir ... 
        
        // Gestion des cookies en les sécurisant
        if($_POST['remember']) {
            $remember_token = string_random(250);
            $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
            setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'wolfouf' ), time() + 60 * 60 * 24 * 7);
        } 

        header('Location: account.php');
        exit();
  }else{
      $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrect';
  }
}

?>
  
  <?php require 'header.php' ?>

  <div class="bg">

    <div class="container" style="position: relative; top: 30%;">
        <form action="" method="POST">

            <div class="form-group">
              <label for="exampleInputEmail1">PSEUDO OU ADRESSE MAIL</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Votre e-mail ou pseudo..." name="username">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Mot de passe <a href="forgetpassword.php" style = "color : cyan; text-decoration : underline;"> (Mot de passe oublié ?)</a></label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Votre mot de passe, vous ne l'avez pas oublié j'espère ?!" name="password">
            </div>

            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="inlineFormCheckMD" name="remember" value="1"/>
              <label class="form-check-label" for="inlineFormCheckMD">Se souvenir de moi </label>
            </div>

            <button type="submit" class="btn btn-primary">CONNEXION</button>
          </form>
      </div>
    </div>


<?php require 'footer.php' ?>