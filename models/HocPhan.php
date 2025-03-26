<?php
class HocPhan {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllHocPhan() {
        $query = "SELECT * FROM HocPhan ORDER BY MaHP";
        return $this->db->query($query);
    }

    public function getHocPhanById($maHP) {
        $query = "SELECT * FROM HocPhan WHERE MaHP = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $maHP);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addHocPhan($maHP, $tenHP, $soTinChi) {
        $query = "INSERT INTO HocPhan (MaHP, TenHP, SoTinChi) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssi", $maHP, $tenHP, $soTinChi);
        return $stmt->execute();
    }

    public function updateHocPhan($maHP, $tenHP, $soTinChi) {
        $query = "UPDATE HocPhan SET TenHP = ?, SoTinChi = ? WHERE MaHP = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sis", $tenHP, $soTinChi, $maHP);
        return $stmt->execute();
    }

    public function deleteHocPhan($maHP) {
        // Kiểm tra xem học phần có được đăng ký không
        $query1 = "SELECT COUNT(*) as count FROM ChiTietDangKy WHERE MaHP = ?";
        $stmt1 = $this->db->prepare($query1);
        $stmt1->bind_param("s", $maHP);
        $stmt1->execute();
        $result = $stmt1->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            return false; // Không thể xóa vì học phần đã được đăng ký
        }
        
        // Nếu không có đăng ký, thực hiện xóa
        $query2 = "DELETE FROM HocPhan WHERE MaHP = ?";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bind_param("s", $maHP);
        return $stmt2->execute();
    }
}
?> 