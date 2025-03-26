<?php
include 'views/shares/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Danh sách sinh viên</h1>
        <a href="index.php?controller=sinhvien&action=create" class="btn btn-primary">Thêm sinh viên</a>
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

    <?php if ($sinhviens && $sinhviens->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Mã SV</th>
                        <th>Họ tên</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Hình</th>
                        <th>Mã ngành</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($sv = $sinhviens->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sv['MaSV']); ?></td>
                        <td><?php echo htmlspecialchars($sv['HoTen']); ?></td>
                        <td><?php echo htmlspecialchars($sv['GioiTinh']); ?></td>
                        <td><?php echo htmlspecialchars($sv['NgaySinh']); ?></td>
                        <td>
                            <?php if (!empty($sv['Hinh'])): ?>
                                <img src="img/<?php echo htmlspecialchars($sv['Hinh']); ?>" alt="Ảnh sinh viên" style="max-width: 50px;">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($sv['MaNganh']); ?></td>
                        <td>
                            <a href="index.php?controller=sinhvien&action=view&id=<?php echo $sv['MaSV']; ?>" 
                               class="btn btn-info btn-sm">Chi tiết</a>
                            <a href="index.php?controller=sinhvien&action=edit&id=<?php echo $sv['MaSV']; ?>" 
                               class="btn btn-warning btn-sm">Sửa</a>
                            <a href="index.php?controller=sinhvien&action=delete&id=<?php echo $sv['MaSV']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')">Xóa</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Không có sinh viên nào.</div>
    <?php endif; ?>
</div>

<?php
include 'views/shares/footer.php';
?> 