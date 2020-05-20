<?php 
        class session{

            static $instance; 
            
            // Utilisation du design singleton pour éviter de créer un double session_start();
            static function getInstance() {
                if(!self::$instance) {
                    self::$instance = new session();
                }
                return self::$instance;
            }

            public function __construct() {
                session_start();
            }

        // $key = success or danger cause of bootstrap styles
            public function setFlash($key, $messageFlash) {
                $_SESSION['flash'][$key] = $messageFlash;
            }

        // On vérifie si dans le tableau de $_SESSION['flash'] possède des erreurs ...
            public function hasFlash(){
                return isset($_SESSION['flash']);
            }

        // Si il y en a dans ce cas, on les récupère ...
            public function getFlash(){
                $flash = $_SESSION['flash'];
                unset($_SESSION['flash']);
                return $flash;
            }
        }