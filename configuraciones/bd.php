<?php


    class BD {

        public static $instancia=null;
        public static function crearInstancia(){

            if( !isset(self::$instancia)){
                $opciones[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                self::$instancia = new PDO('mysql:host=localhost;dbname=soporteit', 'root', '', $opciones);
                
                
            }
            return self::$instancia;

        }

    }
   

?>


