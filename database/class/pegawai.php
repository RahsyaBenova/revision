<?php
class Pegawai
{
    private $db;
    private static $instance = null;

    public static function getInstance($pdo)
    {
        if (self::$instance == null) {
            self::$instance = new Pegawai($pdo);
        }
        return self::$instance;
    }

    private function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function getAllPegawai()
    {
        $query = "SELECT tb_pegawai.*, jabatan.nama_jabatan, tb_golongan.nama_golongan, tb_lokasi.nama_lokasi
                  FROM tb_pegawai 
                  INNER JOIN jabatan ON tb_pegawai.kode_jabatan=jabatan.kode_jabatan 
                  INNER JOIN tb_golongan ON tb_pegawai.kode_golongan=tb_golongan.kode_golongan
                  INNER JOIN tb_lokasi ON tb_pegawai.kode_lokasi=tb_lokasi.kode_lokasi 
                  ORDER BY tb_pegawai.nama ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPegawaiById($id)
    {
        $query = "SELECT * FROM tb_pegawai WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllJabatan()
    {
        $query = "SELECT * FROM jabatan ORDER BY kode_jabatan ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllGolongan()
    {
        $query = "SELECT * FROM tb_golongan ORDER BY kode_golongan ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllLokasi()
    {
        $query = "SELECT * FROM tb_lokasi ORDER BY kode_lokasi ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahPegawai($nama, $nip, $status, $kode_jabatan, $kode_golongan, $kode_lokasi, $jumlah_anak, $foto)
    {
        $query = "INSERT INTO tb_pegawai (nama, nip, status, foto, kode_golongan, kode_jabatan, jumlah_anak, kode_lokasi) 
                  VALUES (:nama, :nip, :status, :foto, :kode_golongan, :kode_jabatan, :jumlah_anak, :kode_lokasi)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':nip', $nip);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':kode_golongan', $kode_golongan);
        $stmt->bindParam(':kode_jabatan', $kode_jabatan);
        $stmt->bindParam(':jumlah_anak', $jumlah_anak);
        $stmt->bindParam(':kode_lokasi', $kode_lokasi);
        
        return $stmt->execute();
    }

    public function updatePegawai($id, $nama, $nip, $status, $kode_jabatan, $kode_golongan, $kode_lokasi, $jumlah_anak, $foto)
    {
        $query = "UPDATE tb_pegawai 
                  SET nama = :nama, nip = :nip, status = :status, foto = :foto, 
                      kode_golongan = :kode_golongan, kode_jabatan = :kode_jabatan, 
                      jumlah_anak = :jumlah_anak, kode_lokasi = :kode_lokasi
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':nip', $nip);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':kode_golongan', $kode_golongan);
        $stmt->bindParam(':kode_jabatan', $kode_jabatan);
        $stmt->bindParam(':jumlah_anak', $jumlah_anak);
        $stmt->bindParam(':kode_lokasi', $kode_lokasi);

        return $stmt->execute();
    }

    public function hapusPegawai($id)
    {
        $query = "DELETE FROM tb_pegawai WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getGajiPegawai()
    {
        $query = "SELECT tb_pegawai.nip, tb_pegawai.nama, jabatan.nama_jabatan, tb_golongan.nama_golongan, tb_pegawai.status, tb_pegawai.jumlah_anak, jabatan.gapok, jabatan.tunjangan_jabatan,
                         IF(tb_pegawai.status='menikah', tunjangan_si, 0) AS tjsi,
                         IF(tb_pegawai.status='menikah', tunjangan_anak*jumlah_anak, 0) AS tjanak,
                         uang_makan AS uangmakan,
                         askes,
                         (gapok + tunjangan_jabatan + 
                          IF(tb_pegawai.status='menikah', tunjangan_si, 0) +
                          IF(tb_pegawai.status='menikah', tunjangan_anak * jumlah_anak, 0) +
                          uang_makan + askes) AS totalgaji
                  FROM tb_pegawai
                  INNER JOIN tb_golongan ON tb_golongan.kode_golongan = tb_pegawai.kode_golongan
                  INNER JOIN jabatan ON jabatan.kode_jabatan = tb_pegawai.kode_jabatan
                  ORDER BY tb_pegawai.nama ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
