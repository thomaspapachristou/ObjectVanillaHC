<?php 

spl_autoload_register('autoloader');

function autoloader($class){
    require "class/$class.php";
}