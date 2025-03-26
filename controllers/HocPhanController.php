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
            if ($this->dangKyModel->checkDaDangKy($maSV, $maHP)) {
                $_SESSION['message'] = 'Bạn đã đăng ký học phần này rồi!';
                $_SESSION['message_type'] = 'warning';
                header('Location: index.php?controller=hocphan&action=index');
                exit;
            }

            // Tạo đăng ký mới
            if ($this->dangKyModel->dangKyHocPhan($maSV, $maHP)) {
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

    public function dangkyhocphan() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['message'] = 'Vui lòng đăng nhập để xem danh sách đăng ký!';
            $_SESSION['message_type'] = 'warning';
            header('Location: index.php?controller=auth&action=showLoginForm');
            exit;
        }

        $maSV = $_SESSION['user_id'];
        $dangKyList = $this->dangKyModel->getDangKyByMaSV($maSV);
        $tongTinChi = $this->dangKyModel->getTongTinChi($maSV);
        
        require_once 'views/hocphan/dangkyhocphan.php';
    }

    public function huydangky() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['message'] = 'Vui lòng đăng nhập để hủy đăng ký!';
            $_SESSION['message_type'] = 'warning';
            header('Location: index.php?controller=auth&action=showLoginForm');
            exit;
        }

        if (isset($_GET['id'])) {
            $maDK = $_GET['id'];
            $maSV = $_SESSION['user_id'];

            // Kiểm tra xem đăng ký có thuộc về sinh viên này không
            if (!$this->dangKyModel->checkDangKyBelongsToSinhVien($maDK, $maSV)) {
                $_SESSION['message'] = 'Bạn không có quyền hủy đăng ký này!';
                $_SESSION['message_type'] = 'danger';
            } else {
                if ($this->dangKyModel->huyDangKy($maDK)) {
                    $_SESSION['message'] = 'Hủy đăng ký học phần thành công!';
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['message'] = 'Có lỗi xảy ra khi hủy đăng ký học phần!';
                    $_SESSION['message_type'] = 'danger';
                }
            }
        }
        
        header('Location: index.php?controller=hocphan&action=dangkyhocphan');
        exit;
    }

    public function xoatatca() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['message'] = 'Vui lòng đăng nhập để xóa đăng ký!';
            $_SESSION['message_type'] = 'warning';
            header('Location: index.php?controller=auth&action=showLoginForm');
            exit;
        }

        $maSV = $_SESSION['user_id'];
        if ($this->dangKyModel->xoaTatCaDangKy($maSV)) {
            $_SESSION['message'] = 'Đã xóa tất cả học phần đã đăng ký!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Có lỗi xảy ra khi xóa đăng ký học phần!';
            $_SESSION['message_type'] = 'danger';
        }
        
        header('Location: index.php?controller=hocphan&action=dangkyhocphan');
        exit;
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maHP = $_POST['maHP'];
            $tenHP = $_POST['tenHP'];
            $soTinChi = $_POST['soTinChi'];

            if ($this->hocPhanModel->addHocPhan($maHP, $tenHP, $soTinChi)) {
                $_SESSION['message'] = 'Thêm học phần thành công!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Có lỗi xảy ra khi thêm học phần!';
                $_SESSION['message_type'] = 'danger';
            }
            header('Location: index.php?controller=hocphan&action=index');
            exit;
        }
        require_once 'views/hocphan/create.php';
    }

    public function edit($maHP) {
        $hocphan = $this->hocPhanModel->getHocPhanById($maHP);
        if (!$hocphan) {
            $_SESSION['message'] = 'Không tìm thấy học phần!';
            $_SESSION['message_type'] = 'danger';
            header('Location: index.php?controller=hocphan&action=index');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenHP = $_POST['tenHP'];
            $soTinChi = $_POST['soTinChi'];

            if ($this->hocPhanModel->updateHocPhan($maHP, $tenHP, $soTinChi)) {
                $_SESSION['message'] = 'Cập nhật học phần thành công!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Có lỗi xảy ra khi cập nhật học phần!';
                $_SESSION['message_type'] = 'danger';
            }
            header('Location: index.php?controller=hocphan&action=index');
            exit;
        }
        require_once 'views/hocphan/edit.php';
    }

    public function delete($maHP) {
        if ($this->hocPhanModel->deleteHocPhan($maHP)) {
            $_SESSION['message'] = 'Xóa học phần thành công!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Có lỗi xảy ra khi xóa học phần!';
            $_SESSION['message_type'] = 'danger';
        }
        header('Location: index.php?controller=hocphan&action=index');
        exit;
    }
}
?> 