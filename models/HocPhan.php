<?php
class HocPhan {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllHocPhan() {
        $query = "SELECT * FROM HocPhan";
        $result = $this->db->query($query);
        $hocphans = array();
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $hocphans[] = $row;
            }
        }
        return $hocphans;
    }

    public function getHocPhanById($maHP) {
        $query = "SELECT * FROM HocPhan WHERE MaHP = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $maHP);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?> 