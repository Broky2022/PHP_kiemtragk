<?php
require_once 'models/SinhVien.php';
require_once 'config/Database.php';

class SinhVienController {
    private $sinhVienModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->sinhVienModel = new SinhVien($this->db);
    }

    public function index() {
        $sinhviens = $this->sinhVienModel->getAllSinhVien();
        require_once 'views/sinhvien/index.php';
    }

    public function view($maSV) {
        $sinhvien = $this->sinhVienModel->getSinhVienById($maSV);
        if (!$sinhvien) {
            $_SESSION['message'] = 'Không tìm thấy sinh viên!';
            $_SESSION['message_type'] = 'danger';
            header('Location: index.php?controller=sinhvien&action=index');
            exit;
        }
        require_once 'views/sinhvien/view.php';
    }

    public function create() {
        require_once 'views/sinhvien/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'];
            $hoTen = $_POST['hoTen'];
            $gioiTinh = $_POST['gioiTinh'];
            $ngaySinh = $_POST['ngaySinh'];
            $maNganh = $_POST['maNganh'];
            
            // Xử lý upload ảnh
            $hinh = '';
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] === 0) {
                $uploadDir = 'img/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileExtension = pathinfo($_FILES['hinh']['name'], PATHINFO_EXTENSION);
                $fileName = time() . '_' . $maSV . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['hinh']['tmp_name'], $uploadFile)) {
                    $hinh = $fileName;
                }
            }

            if ($this->sinhVienModel->addSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh)) {
                $_SESSION['message'] = 'Thêm sinh viên thành công!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Có lỗi xảy ra khi thêm sinh viên!';
                $_SESSION['message_type'] = 'danger';
            }
            header('Location: index.php?controller=sinhvien&action=index');
            exit;
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function edit($maSV) {
        $sinhvien = $this->sinhVienModel->getSinhVienById($maSV);
        if (!$sinhvien) {
            $_SESSION['message'] = 'Không tìm thấy sinh viên!';
            $_SESSION['message_type'] = 'danger';
            header('Location: index.php?controller=sinhvien&action=index');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoTen = $_POST['hoTen'];
            $gioiTinh = $_POST['gioiTinh'];
            $ngaySinh = $_POST['ngaySinh'];
            $maNganh = $_POST['maNganh'];
            
            // Xử lý upload ảnh
            $hinh = $sinhvien['Hinh']; // Giữ nguyên ảnh cũ nếu không upload ảnh mới
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] === 0) {
                // Xóa ảnh cũ nếu tồn tại
                if (!empty($sinhvien['Hinh']) && file_exists('img/' . $sinhvien['Hinh'])) {
                    unlink('img/' . $sinhvien['Hinh']);
                }

                // Upload ảnh mới
                $uploadDir = 'img/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileExtension = pathinfo($_FILES['hinh']['name'], PATHINFO_EXTENSION);
                $fileName = time() . '_' . $maSV . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['hinh']['tmp_name'], $uploadFile)) {
                    $hinh = $fileName;
                }
            }

            if ($this->sinhVienModel->updateSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh)) {
                $_SESSION['message'] = 'Cập nhật sinh viên thành công!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Có lỗi xảy ra khi cập nhật sinh viên!';
                $_SESSION['message_type'] = 'danger';
            }
            header('Location: index.php?controller=sinhvien&action=index');
            exit;
        }
        require_once 'views/sinhvien/edit.php';
    }

    public function delete($maSV) {
        // Lấy thông tin sinh viên để xóa ảnh
        $sinhvien = $this->sinhVienModel->getSinhVienById($maSV);
        if ($sinhvien && !empty($sinhvien['Hinh'])) {
            $imagePath = 'img/' . $sinhvien['Hinh'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($this->sinhVienModel->deleteSinhVien($maSV)) {
            $_SESSION['message'] = 'Xóa sinh viên thành công!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Có lỗi xảy ra khi xóa sinh viên!';
            $_SESSION['message_type'] = 'danger';
        }
        header('Location: index.php?controller=sinhvien&action=index');
        exit;
    }
}
?> 