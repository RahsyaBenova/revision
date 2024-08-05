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

    public function isLoggedIn()
    {
        return isset($_SESSION["user_session"]);
    }

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
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function logout()
    {
        unset($_SESSION['user_session'], $_SESSION['nama'], $_SESSION['level']);
        session_destroy();
        return true;
    }

    public function cekUsername($username)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function register($nama, $email, $username, $password, $level)
    {
        if (empty($nama)) {
            $this->error = "Nama diperlukan";
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = "Email tidak valid";
            return false;
        }

        if (strlen($password) < 8) {
            $this->error = "Password harus memiliki minimal 8 karakter";
            return false;
        }

        if (!preg_match("/[a-z]/i", $password)) {
            $this->error = "Password harus mengandung setidaknya satu huruf";
            return false;
        }

        if (!preg_match("/[0-9]/", $password)) {
            $this->error = "Password harus mengandung setidaknya satu angka";
            return false;
        }

        if ($this->cekUserExistence($username, $email)) {
            $this->error = "Username atau email sudah digunakan!";
            return false;
        }

        $hashPasswd = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $this->db->prepare("INSERT INTO users(nama, email, username, password, level) VALUES(:nama, :email, :username, :pass, :level)");
            $stmt->bindParam(":nama", $nama);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":pass", $hashPasswd);
            $stmt->bindParam(":level", $level);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] == 23000) {
                $this->error = "Email atau username sudah digunakan!";
            } else {
                $this->error = $e->getMessage();
            }
            return false;
        }
    }

    public function login($username, $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $data = $stmt->fetch();

            if ($stmt->rowCount() > 0) {
                if (password_verify($password, $data["password"])) {
                    $_SESSION['user_session'] = $data['id'];
                    $_SESSION['nama'] = $data['nama'];
                    $_SESSION['level'] = $data['level'];
                    return true;
                } else {
                    $this->error = 'Password salah';
                    return false;
                }
            } else {
                $this->error = '7';
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function cekUserExistence($username, $email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function sendPasswordReset($email)
    {
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

        try {
            $stmt = $this->db->prepare("UPDATE users SET reset_token_hash = :token_hash, reset_token_expires_at = :expiry WHERE email = :email");
            $stmt->bindParam(":token_hash", $token_hash);
            $stmt->bindParam(":expiry", $expiry);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if ($stmt->rowCount()) {
                $mail = require __DIR__ . "/mailer.php";
                $mail->setFrom("whoamirange@gmail.com");
                $mail->addAddress($email);
                $mail->Subject = "Password Reset";
                $mail->Body = "Click <a href=\"http://localhost/revision/index.php?auth=reset&token=$token\">here</a> to reset your password.";

                try {
                    $mail->send();
                    return "<script>window.location.href = 'http://localhost/revision/index.php?auth=login&&error=4';</script>";
                } catch (Exception $e) {
                    $this->error = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                    return false;
                }
            } else {
                $this->error = "No user found with that email address.";
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function verifyResetToken($token)
    {
        $token_hash = hash("sha256", $token);

        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE reset_token_hash = :token_hash");
            $stmt->bindParam(":token_hash", $token_hash);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && strtotime($user["reset_token_expires_at"]) > time()) {
                return $user;
            } else {
                header("Location: http://localhost/revision/index.php?auth=login&&error=6");
                exit;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function updatePassword($user_id, $password)
    {
        $hashPasswd = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $this->db->prepare("UPDATE users SET password = :password, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = :user_id");
            $stmt->bindParam(":password", $hashPasswd);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function getError()
    {
        return $this->error;
    }
}
?>
