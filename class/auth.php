<?php 


class auth{

  private $db;

    public function __construct($db) {
      $this->db = $db; 
    }

    public function register($username, $password, $email) {
        $password = password_hash($password, PASSWORD_BCRYPT);
                  $token = str::random(70);
                  $this->db->query("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?", [
                    $username, 
                    $password, 
                    $email, 
                    $token
                  ]);                 
                  $user_id = $this->db->lastInsertId();
                  // dépendance de l'objet mail.php, à corriger
                  mail::sendMail($email,'Confirmation de votre compte',"Afin de valider votre compte...Merci de cliquer sur ce lien : \n\n http://localhost/inscriptionconfirm.php?id=$user_id&token=$token");
    }
}