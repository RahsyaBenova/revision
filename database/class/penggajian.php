<?php
class Gaji
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
            self::$instance = new Gaji();
        }
        return self::$instance;
    }

    public function getGajiPegawai()
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT tb_pegawai.nip, tb_pegawai.nama, jabatan.nama_jabatan, tb_golongan.nama_golongan, tb_pegawai.status, tb_pegawai.jumlah_anak, jabatan.gapok, jabatan.tunjangan_jabatan,
                        IF(tb_pegawai.status='menikah', tunjangan_si, 0) AS tjsi,
                        IF(tb_pegawai.status='menikah', tunjangan_anak*jumlah_anak, 0) AS tjanak,
                        uang_makan AS uangmakan,
                        askes,
                        (gapok + tunjangan_jabatan + IF(tb_pegawai.status='menikah', tunjangan_si, 0) + IF(tb_pegawai.status='menikah', tunjangan_anak*jumlah_anak, 0) + uang_makan + askes) AS totalgaji
                FROM tb_pegawai
                INNER JOIN tb_golongan ON tb_golongan.kode_golongan = tb_pegawai.kode_golongan
                INNER JOIN jabatan ON jabatan.kode_jabatan = tb_pegawai.kode_jabatan
                ORDER BY tb_pegawai.nama ASC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>
