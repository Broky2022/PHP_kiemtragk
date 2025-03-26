<?php
class DangKy {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createDangKy($maSV) {
        $ngayDK = date('Y-m-d');
        $query = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $ngayDK, $maSV);
        
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function addChiTietDangKy($maDK, $maHP) {
        $query = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $maDK, $maHP);
        return $stmt->execute();
    }

    public function checkExistingDangKy($maSV, $maHP) {
        $query = "SELECT * FROM DangKy dk 
                 JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK 
                 WHERE dk.MaSV = ? AND ctdk.MaHP = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $maSV, $maHP);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
?> 