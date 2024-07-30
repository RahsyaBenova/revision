<?php

class Golongan
{
    private $conn;

    // Singleton instance
    private static $instance = null;

    private function __construct()
    {
        $this->conn = Koneksi::connect();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Golongan();
        }
        return self::$instance;
    }

    public function create($kode_golongan, $nama_golongan, $tunjangan_si, $tunjangan_anak, $uang_makan, $askes)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tb_golongan (kode_golongan, nama_golongan, tunjangan_si, tunjangan_anak, uang_makan, askes) VALUES (:kode_golongan, :nama_golongan, :tunjangan_si, :tunjangan_anak, :uang_makan, :askes)");
            $stmt->bindParam(':kode_golongan', $kode_golongan);
            $stmt->bindParam(':nama_golongan', $nama_golongan);
            $stmt->bindParam(':tunjangan_si', $tunjangan_si);
            $stmt->bindParam(':tunjangan_anak', $tunjangan_anak);
            $stmt->bindParam(':uang_makan', $uang_makan);
            $stmt->bindParam(':askes', $askes);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function read()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tb_golongan ORDER BY kode_golongan ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function update($kode_golongan, $nama_golongan, $tunjangan_si, $tunjangan_anak, $uang_makan, $askes)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE tb_golongan SET nama_golongan = :nama_golongan, tunjangan_si = :tunjangan_si, tunjangan_anak = :tunjangan_anak, uang_makan = :uang_makan, askes = :askes WHERE kode_golongan = :kode_golongan");
            $stmt->bindParam(':kode_golongan', $kode_golongan);
            $stmt->bindParam(':nama_golongan', $nama_golongan);
            $stmt->bindParam(':tunjangan_si', $tunjangan_si);
            $stmt->bindParam(':tunjangan_anak', $tunjangan_anak);
            $stmt->bindParam(':uang_makan', $uang_makan);
            $stmt->bindParam(':askes', $askes);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($kode_golongan)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tb_golongan WHERE kode_golongan = :kode_golongan");
            $stmt->bindParam(':kode_golongan', $kode_golongan);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
