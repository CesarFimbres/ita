<?php
    class Connection{
        public static function Conectar(){
            define('server', 'localhost');
            define('db', 'catalogo'); 
            define('user', 'root');
            define('password', '');	
            $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');			
            try{
                $conn = new PDO("mysql:host=".server."; dbname=".db, user, password, $options);
                return $conn;
            }catch (Exception $e){
                die("Ups! hubo un error en la conexión es: ". $e->getMessage());
            }
        }
    }
?>