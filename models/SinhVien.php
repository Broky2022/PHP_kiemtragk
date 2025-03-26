<?php
require_once("config/database.php");

class SinhVien {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getAllSinhVien() {
        $query = "SELECT * FROM SinhVien";
        return $this->db->query($query);
    }
    
    public function getSinhVienById($maSV) {
        $query = "SELECT * FROM SinhVien WHERE MaSV = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $maSV);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function addSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh) {
        $query = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssss", $maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh);
        return $stmt->execute();
    }
    
    public function updateSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh) {
        $query = "UPDATE SinhVien SET HoTen = ?, GioiTinh = ?, NgaySinh = ?, Hinh = ?, MaNganh = ? WHERE MaSV = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssss", $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh, $maSV);
        return $stmt->execute();
    }
    
    public function deleteSinhVien($maSV) {
        $query = "DELETE FROM SinhVien WHERE MaSV = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $maSV);
        return $stmt->execute();
    }

    public function checkLogin($maSV) {
        $query = "SELECT * FROM SinhVien WHERE MaSV = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $maSV);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?> 