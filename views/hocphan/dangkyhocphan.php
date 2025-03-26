<?php
include 'views/shares/header.php';
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Danh sách học phần đã đăng ký</h2>
        </div>
        <div class="card-body">
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

            <?php if (isset($dangKyList) && !empty($dangKyList)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Mã học phần</th>
                                <th>Tên học phần</th>
                                <th>Số tín chỉ</th>
                                <th>Ngày đăng ký</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dangKyList as $dk): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($dk['MaHP']); ?></td>
                                    <td><?php echo htmlspecialchars($dk['TenHP']); ?></td>
                                    <td><?php echo htmlspecialchars($dk['SoTinChi']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($dk['NgayDK'])); ?></td>
                                    <td>
                                        <a href="index.php?controller=dangky&action=huy&id=<?php echo $dk['MaDK']; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Bạn có chắc chắn muốn hủy đăng ký học phần này?')">
                                            Hủy đăng ký
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <p><strong>Tổng số tín chỉ đã đăng ký:</strong> <?php echo $tongTinChi; ?></p>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    Bạn chưa đăng ký học phần nào.
                    <a href="index.php?controller=hocphan&action=index" class="btn btn-primary ms-3">
                        Đăng ký ngay
                    </a>
                </div>
            <?php endif; ?>

            <div class="mt-3">
                <a href="index.php?controller=hocphan&action=index" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Đăng ký thêm học phần
                </a>
            </div>
        </div>
    </div>
</div>

<?php
include 'views/shares/footer.php';
?> 