<?php
require_once 'models/SinhVien.php';
require_once 'config/Database.php';

class AuthController {
    private $sinhVienModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->sinhVienModel = new SinhVien($this->db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'];
            $sinhVien = $this->sinhVienModel->checkLogin($maSV);

            if ($sinhVien) {
                $_SESSION['user_id'] = $sinhVien['MaSV'];
                $_SESSION['user_name'] = $sinhVien['HoTen'];
                header('Location: index.php?controller=hocphan&action=index');
                exit;
            } else {
                $_SESSION['error'] = 'Mã sinh viên không tồn tại!';
                header('Location: index.php?controller=auth&action=showLoginForm');
                exit;
            }
        }
    }

    public function showLoginForm() {
        require_once 'views/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?controller=auth&action=showLoginForm');
        exit;
    }
}
?> 