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

    public function getDangKyByMaSV($maSV) {
        $query = "SELECT dk.MaDK, dk.NgayDK, hp.MaHP, hp.TenHP, hp.SoTinChi 
                 FROM DangKy dk 
                 INNER JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK 
                 INNER JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP 
                 WHERE dk.MaSV = ?
                 ORDER BY dk.NgayDK DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $maSV);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function getTongTinChi($maSV) {
        $query = "SELECT SUM(hp.SoTinChi) as TongTC 
                 FROM DangKy dk 
                 INNER JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK 
                 INNER JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP 
                 WHERE dk.MaSV = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $maSV);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['TongTC'] ?? 0;
    }
    
    public function checkDaDangKy($maSV, $maHP) {
        $query = "SELECT COUNT(*) as count 
                 FROM DangKy dk 
                 INNER JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK 
                 WHERE dk.MaSV = ? AND ctdk.MaHP = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $maSV, $maHP);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
    
    public function dangKyHocPhan($maSV, $maHP) {
        $this->db->begin_transaction();
        try {
            // Tạo đăng ký mới
            $query1 = "INSERT INTO DangKy (MaSV, NgayDK) VALUES (?, NOW())";
            $stmt1 = $this->db->prepare($query1);
            $stmt1->bind_param("s", $maSV);
            $stmt1->execute();
            
            $maDK = $this->db->insert_id;
            
            // Thêm chi tiết đăng ký
            $query2 = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bind_param("is", $maDK, $maHP);
            $stmt2->execute();
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
    
    public function checkDangKyBelongsToSinhVien($maDK, $maSV) {
        $query = "SELECT COUNT(*) as count FROM DangKy WHERE MaDK = ? AND MaSV = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $maDK, $maSV);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
    
    public function huyDangKy($maDK) {
        $this->db->begin_transaction();
        try {
            // Xóa chi tiết đăng ký
            $query1 = "DELETE FROM ChiTietDangKy WHERE MaDK = ?";
            $stmt1 = $this->db->prepare($query1);
            $stmt1->bind_param("i", $maDK);
            $stmt1->execute();
            
            // Xóa đăng ký
            $query2 = "DELETE FROM DangKy WHERE MaDK = ?";
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bind_param("i", $maDK);
            $stmt2->execute();
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
}
?> 