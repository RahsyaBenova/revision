<?php

class Auth
{
    private $db;

    private $error;

    private static $instance = null;


    public function __construct($db_conn)
    {
        $this->db = $db_conn;

        @session_start();
    }

    public static function getInstance($pdo)
    {
        if (self::$instance == null) {
            self::$instance = new Auth($pdo);
        }

        return self::$instance;
    }

    //Menambhakan data apabila user belum mempunyai akun
    public function register($nama, $username, $password, $level)
    {
        try {

            $this->cekUsername($username);
            // enkripsi
            $hashPasswd = password_hash($password, PASSWORD_DEFAULT);
            //Masukkan user baru ke database
            $stmt = $this->db->prepare("INSERT INTO users(nama, username, password, level) 
                                        VALUES(:nama, :username, :pass, :level)");
            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":pass", $hashPasswd);
            $stmt->bindParam(":level", $level);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] == 23000) {
                $this->error = "Username sudah digunakan!";
                return false;
            } else {
                echo $e->getMessage();
                return false;
            }
        }
    }


    //fungsi login 
    public function login($username, $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            // mysqli_real_escape_string($this->db,$username);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $data = $stmt->fetch();

            //jika data ada pada table

            if ($stmt->rowCount()  > 0) {

                //cek password
                if (password_verify($password, $data["password"])) {
                    $_SESSION['user_session'] = $data['id'];
                    $_SESSION['nama'] = $user['nama'];
                    $_SESSION['level'] = $user['level'];
                    return true;
                } else {
                    $this->error = '1';
                    return false;
                }
            } else {
                $this->error = '1';
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // cek apabila user sudah login atau belum
    public function isLoggedIn()
    {
        //apakah user_session sudah ada di session
        if (isset($_SESSION["user_session"])) {
            return true;
        }
    }

    // mendapatkan data user yang login saat ini
    public function getUser()
{
    if (!$this->isLoggedIn()) {
        return false;
    }
    try {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(":id", $_SESSION['user_session']);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['level'] = $user['level'];
        }

        return $user;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}


    //logout
    public function logout()
    {
        //hapus Session
        unset($_SESSION['user_session']);
        unset($_SESSION['nama']);
        unset($_SESSION['level']);
        session_destroy();
        return true;
    }

    public function cekUsername($username)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $stmt->fetch();
            if ($stmt->rowCount()  > 0) {
                echo "Yo";
                return true;
            } else {
                echo "Oi";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function forgotPassword($username, $password, $level)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $this->NewPassword($username, $password);
                echo "Username Dan Email sesuai passowrd diganti";
                return true;
            } else {
                echo "Username Dan Email yang dimasukkan tidak sesuai";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function NewPassword($username, $password)
    {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE username = :username");
            $stmt->bindParam(":password", $hash);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

            // Error message function
        public function getError()
        {
            return $this->error;
        }
}
