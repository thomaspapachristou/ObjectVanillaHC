<?php

// app.php regroupe toutes les classes qui seront statiques afin d'éviter de les appeler à chaque fichier
// Pour en faire l'appel, on écrit (exemple) || app::getDatabase
    class app{
        static $db = null;
        
        static function getDatabase(){
            if(!self::$db) {
                self::$db = new database('admin', 'admin', 'headenclouds');
            }
            
            return self::$db;
        }

        static function redirect($location){
            header("Location: $location");
        }
    }