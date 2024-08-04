<?php

class user
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
            self::$instance = new user($pdo);
        }
        return self::$instance;
    }


    public function getID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(array(":id" => $id));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }


    public function update($id, $nama, $username,$email, $level)
    {
        try {

            $stmt = $this->db->prepare("UPDATE users SET nama = :nama, username = :username, email = :email, level = :level WHERE id =:id ");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":level", $level);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahUser($nama, $username, $email, $password, $level) {
        $stmt = $this->db->prepare("INSERT INTO users (nama, username, email, password, level) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nama, $username, $email, password_hash($password, PASSWORD_BCRYPT), $level]);
    }

    public function hapusUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function getError()
    {
        return true;
    }
}
