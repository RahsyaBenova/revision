<?php
class Jabatan
{
    private $db;
    private static $instance = null;

    private function __construct()
    {
        $this->db = Koneksi::connect();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Jabatan();
        }
        return self::$instance;
    }

    public function getAllJabatan()
    {
        $stmt = $this->db->prepare("SELECT * FROM jabatan ORDER BY kode_jabatan ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJabatanById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM jabatan WHERE kode_jabatan = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateJabatan($kode_jabatan, $nama_jabatan, $gapok, $tunjangan_jabatan)
    {
        $stmt = $this->db->prepare("UPDATE jabatan SET nama_jabatan = :nama_jabatan, gapok = :gapok, tunjangan_jabatan = :tunjangan_jabatan WHERE kode_jabatan = :kode_jabatan");
        $stmt->bindParam(':kode_jabatan', $kode_jabatan, PDO::PARAM_STR);
        $stmt->bindParam(':nama_jabatan', $nama_jabatan, PDO::PARAM_STR);
        $stmt->bindParam(':gapok', $gapok, PDO::PARAM_INT);
        $stmt->bindParam(':tunjangan_jabatan', $tunjangan_jabatan, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addJabatan($kode_jabatan, $nama_jabatan, $gapok, $tunjangan_jabatan)
    {
        $stmt = $this->db->prepare("INSERT INTO jabatan (kode_jabatan, nama_jabatan, gapok, tunjangan_jabatan) VALUES (:kode_jabatan, :nama_jabatan, :gapok, :tunjangan_jabatan)");
        $stmt->bindParam(':kode_jabatan', $kode_jabatan, PDO::PARAM_STR);
        $stmt->bindParam(':nama_jabatan', $nama_jabatan, PDO::PARAM_STR);
        $stmt->bindParam(':gapok', $gapok, PDO::PARAM_INT);
        $stmt->bindParam(':tunjangan_jabatan', $tunjangan_jabatan, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteJabatan($id)
    {
        $stmt = $this->db->prepare("DELETE FROM jabatan WHERE kode_jabatan = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
?>
