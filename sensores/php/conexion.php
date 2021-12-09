<?php
class conexion{
    const user=''; //nombre de usuario de BD
    const pass='';//contrasenia
    const db=''; //nombre de la base de datos
    const servidor='localhost';// nombre del host

    public function conectarDB(){
        $conectar= new mysqli( self:: servidor, self::user, self::pass, self::db);
        if($conectar->connect_error){
            die("Error en la conexion".$conectar->connect_error);
        }
        return $conectar;
    }
}
?>