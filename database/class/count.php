<?php

class count
{
    private $db;

    private static $instance = null;

    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    public static function getInstance($pdo)
    {
        if (self::$instance == null) {
            self::$instance = new count($pdo);
        }

        return self::$instance;
    }

    //menghitung total data
    public function countData($table)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM $table");
        $stmt->execute();
        return  $stmt->fetch(PDO::FETCH_COLUMN);
    }

}