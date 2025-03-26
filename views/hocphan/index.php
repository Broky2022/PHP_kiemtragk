<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?controller=auth&action=showLoginForm');
    exit;
}

include 'views/shares/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Danh sách học phần</h1>
        <div>
            <span class="me-3">Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="index.php?controller=auth&action=logout" class="btn btn-danger">Đăng xuất</a>
        </div>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show">
            <?php 
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Mã học phần</th>
                    <th>Tên học phần</th>
                    <th>Số tín chỉ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocphans as $hocphan): ?>
                <tr>
                    <td><?php echo htmlspecialchars($hocphan['MaHP']); ?></td>
                    <td><?php echo htmlspecialchars($hocphan['TenHP']); ?></td>
                    <td><?php echo htmlspecialchars($hocphan['SoTinChi']); ?></td>
                    <td>
                        <form action="index.php?controller=hocphan&action=dangky" method="POST" class="d-inline">
                            <input type="hidden" name="maHP" value="<?php echo $hocphan['MaHP']; ?>">
                            <button type="submit" class="btn btn-success btn-sm">Đăng ký</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include 'views/shares/footer.php';
?> 
