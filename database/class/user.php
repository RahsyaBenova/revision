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


    public function tambah($nama, $username, $password, $level)
    {
        try {

            if ($this->cekUsername($username)) {
                return false;
            }

            // enkripsi
            $hashPasswd = password_hash($password, PASSWORD_DEFAULT);
            //Masukkan users baru ke database
            $stmt = $this->db->prepare("INSERT INTO users(id ,nama, password, alamat, not_tlp, level) VALUES(NULL,:nama, :username , :pass, :level)");
            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":pass", $hashPasswd);
            $stmt->bindParam(":level", $level);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(array(":id" => $id));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }


    public function update($id, $nama, $username, $level)
    {
        try {

            $stmt = $this->db->prepare("UPDATE users SET nama = :nama, username = :username, level = :level WHERE id =:id ");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":level", $level);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id =:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return true;
    }

    //pengecekan sebelum ganti passsoerd apakah password yang lama sesuai dengan milik users
    public function confirmPassword($id, $oldPassword)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $data = $stmt->fetch();

            if ($stmt->rowCount() == 1) {
                if (password_verify($oldPassword, $data["password"])) {
                    return true;
                } else {
                    return false;
                }
            }

            // return true;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function resetPassword($id, $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $this->updatePassword($id, $password);
                return true;
            } else {
                echo "Username Dan Email yang dimasukkan tidak sesuai";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updatePassword($id, $password)
    {
        try {

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->bindParam(":password", $hash);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // apakah username dan email sudah pernah digunakan
    public function cekUsername($username)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getError()
    {
        return true;
    }
}
