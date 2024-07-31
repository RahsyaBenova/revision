<?php
class Keuangan
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
            self::$instance = new Keuangan();
        }
        return self::$instance;
    }

    public function addKeuangan($tanggal, $keterangan, $pemasukan, $pengeluaran)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tb_keuangan (tanggal, keterangan, pemasukan, pengeluaran) VALUES (:tanggal, :keterangan, :pemasukan, :pengeluaran)");
            $stmt->bindParam(':tanggal', $tanggal);
            $stmt->bindParam(':keterangan', $keterangan);
            $stmt->bindParam(':pemasukan', $pemasukan);
            $stmt->bindParam(':pengeluaran', $pengeluaran);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteKeuangan($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM tb_keuangan WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getAllKeuangan()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_keuangan");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getKeuanganById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_keuangan WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateKeuangan($id, $tanggal, $keterangan, $pemasukan, $pengeluaran)
    {
        try {
            $stmt = $this->db->prepare("UPDATE tb_keuangan SET tanggal = :tanggal, keterangan = :keterangan, pemasukan = :pemasukan, pengeluaran = :pengeluaran WHERE id = :id");
            $stmt->bindParam(':tanggal', $tanggal);
            $stmt->bindParam(':keterangan', $keterangan);
            $stmt->bindParam(':pemasukan', $pemasukan);
            $stmt->bindParam(':pengeluaran', $pengeluaran);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}
?>
