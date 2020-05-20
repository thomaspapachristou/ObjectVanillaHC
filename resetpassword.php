  <?php 
    if(isset($_GET['id']) && isset($_GET['token'])) {
        
        require 'db/DB.php';
        require 'functions.php';
        $request = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
        $request->execute([$_GET['id'], $_GET['token']]);
        $user = $request->fetch();

        if($user) {
            if(!empty($_POST)) {
              if (!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE users SET password = ?, reset_token = NULL')->execute([$password]);
                session_start();
                $_SESSION ['flash']['success'] = 'Votre mot de passe a bien été modifié';
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();

              }
            }

        }else{
            session_start();
            $_SESSION['flash']['danger'] = "Erreur : La page n'existe pas";
            header('Location: connexion.php');
            exit();
        }

    } else {
        header('Location: login.php');
        exit();
    }
?>

  <?php require 'header.php' ?>

<div class="bg">

  <div class="container" style="position: relative; top: 30%;">
      <form action="" method="POST">

          <div class="form-group">
            <label for="exampleInputPassword1">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="..." name="password">
          </div>

          
          <div class="form-group">
            <label for="exampleInputPassword1">Confirmez votre nouveau mot de passe</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="..." name="password_confirm">
          </div>


          <button type="submit" class="btn btn-primary">ENVOYER</button>
        </form>
    </div>
  </div>


<?php require 'footer.php' ?>