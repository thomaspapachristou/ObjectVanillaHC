 <?php

    $user_id = $_GET['id'];
    $token =  trim(strip_tags($_GET['token']));


    //  IF "user_id" NOT NUMERIC
    if(!is_numeric($user_id)){
        die('corrupted request');
    }
    // IF "$token" < 70 THEN...
    if(strlen($token) < 70){
        die('corrupted request');
    }

    require 'db/DB.php';

    $request = $pdo -> prepare ('SELECT * FROM users WHERE id = :id');
    $request -> execute(array(':id' => $user_id));
    $user = $request -> fetch();

    // $user -> token || $user['token]
        if ($user && $user ->confirmation_token == $token) {

            // session_start();
            $request = $pdo -> prepare('UPDATE users SET confirmation_token = NULL, date_account = NOW() WHERE id = :id') -> execute(array(':id' => $user_id));
            $_SESSION['auth'] = $user && $_SESSION['flash']['success'] = "Votre compte est dorénavant fonctionnel, dès à présent vous pouvez partager !";

            header('Location: connexion.php');
            
        } else {
            $_SESSION['flash']['danger'] = "Le lien auquel vous essayez d'accéder n'est plus valide car le compte est déjà activé.";
            header('Location: index.php');

        }
