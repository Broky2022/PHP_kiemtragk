<?php
session_start();
require_once('controllers/SinhVienController.php');
require_once('controllers/HocPhanController.php');
require_once('controllers/AuthController.php');

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'sinhvien';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($controller) {
    case 'sinhvien':
        $controller = new SinhVienController();
        break;
    case 'hocphan':
        $controller = new HocPhanController();
        break;
    case 'auth':
        $controller = new AuthController();
        break;
    default:
        $controller = new SinhVienController();
}

if (method_exists($controller, $action)) {
    if (isset($_GET['id'])) {
        $controller->$action($_GET['id']);
    } else {
        $controller->$action();
    }
} else {
    $controller->index();
}
?>
