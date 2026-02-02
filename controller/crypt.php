<?php
/**
 * Clase utilitaria para cifrar y descifrar textos.
 *
 * @package ProyectoTienda - Controller
 */

define("ENCRYPT_METHOD", "AES-256-CBC");
define("SECRET_KEY", "12345");
define("SECRET_IV", "67890");

class Crypt
{
    /**
     * Encripta una cadena de texto.
     *
     * @param string $string Texto en claro que se desea encriptar.
     * @return string|false Texto encriptado en base64 o false en caso de error.
     */
    public static function Encriptar($string)
    {
        $output = false;

        $key = hash("sha256", SECRET_KEY);    
        $iv  = substr(hash("sha256", SECRET_IV), 0, 16);

        $output = openssl_encrypt($string, ENCRYPT_METHOD, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;       
    }

    /**
     * Desencripta una cadena previamente encriptada.
     *
     * @param string $string Texto encriptado en base64.
     * @return string|false Texto original desencriptado o false en caso de error.
     */
    public static function Desencriptar($string)
    {
        $output = false;

        $key = hash("sha256", SECRET_KEY);    
        $iv  = substr(hash("sha256", SECRET_IV), 0, 16);

        $output = base64_decode($string);
        $output = openssl_decrypt($output, ENCRYPT_METHOD, $key, 0, $iv);

        return $output;        
    }
}
