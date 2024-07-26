<?php
class Koneksi
{
    private static $dbName = 'db_kepegawaian';
    private static $dbHost = 'localhost';
    private static $dbUser = 'root';
    private static $dbPass = '';

    private static $instance = null;

    public function __construct()
    {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        //Mengganti Pesan error
        // set_exception_handler(function ($e) {
        //     error_log($e->getMessage());
        //     exit('something Wrong');
        // });

        if (self::$instance == null) {
            try {
                self::$instance = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUser, self::$dbPass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>