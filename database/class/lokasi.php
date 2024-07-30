<?php
class Lokasi
{
    private $db;

    // Singleton instance
    private static $instance = null;

    private function __construct()
    {
        $this->db = Koneksi::connect();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Lokasi();
        }
        return self::$instance;
    }

    public function create($kode_lokasi, $nama_lokasi)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tb_lokasi (kode_lokasi, nama_lokasi) VALUES (:kode_lokasi, :nama_lokasi)");
            $stmt->bindParam(':kode_lokasi', $kode_lokasi);
            $stmt->bindParam(':nama_lokasi', $nama_lokasi);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function read()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_lokasi ORDER BY kode_lokasi ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function update($kode_lokasi, $nama_lokasi)
    {
        try {
            $stmt = $this->db->prepare("UPDATE tb_lokasi SET nama_lokasi = :nama_lokasi WHERE kode_lokasi = :kode_lokasi");
            $stmt->bindParam(':kode_lokasi', $kode_lokasi);
            $stmt->bindParam(':nama_lokasi', $nama_lokasi);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($kode_lokasi)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM tb_lokasi WHERE kode_lokasi = :kode_lokasi");
            $stmt->bindParam(':kode_lokasi', $kode_lokasi);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
