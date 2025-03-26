<?php
require_once 'models/HocPhan.php';
require_once 'models/DangKy.php';
require_once 'config/Database.php';

class HocPhanController {
    private $hocPhanModel;
    private $dangKyModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->hocPhanModel = new HocPhan($this->db);
        $this->dangKyModel = new DangKy($this->db);
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=showLoginForm');
            exit;
        }
        $hocphans = $this->hocPhanModel->getAllHocPhan();
        require_once 'views/hocphan/index.php';
    }

    public function dangky() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=showLoginForm');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maHP = $_POST['maHP'];
            $maSV = $_SESSION['user_id'];

            // Kiểm tra xem sinh viên đã đăng ký học phần này chưa
            if ($this->dangKyModel->checkExistingDangKy($maSV, $maHP)) {
                $_SESSION['message'] = 'Bạn đã đăng ký học phần này rồi!';
                $_SESSION['message_type'] = 'warning';
                header('Location: index.php?controller=hocphan&action=index');
                exit;
            }

            // Tạo đăng ký mới
            $maDK = $this->dangKyModel->createDangKy($maSV);
            if ($maDK && $this->dangKyModel->addChiTietDangKy($maDK, $maHP)) {
                $_SESSION['message'] = 'Đăng ký học phần thành công!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Có lỗi xảy ra khi đăng ký học phần!';
                $_SESSION['message_type'] = 'danger';
            }
            header('Location: index.php?controller=hocphan&action=index');
            exit;
        }
    }
}
?> 