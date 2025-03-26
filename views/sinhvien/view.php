<?php require_once('views/shares/header.php'); ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Chi tiết sinh viên</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <?php if (!empty($sinhvien['Hinh'])): ?>
                        <img src="img/<?php echo htmlspecialchars($sinhvien['Hinh']); ?>" 
                             alt="Ảnh sinh viên" 
                             class="img-fluid rounded mb-3">
                    <?php else: ?>
                        <div class="alert alert-info">Không có ảnh</div>
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <th style="width: 150px;">Mã sinh viên:</th>
                            <td><?php echo htmlspecialchars($sinhvien['MaSV']); ?></td>
                        </tr>
                        <tr>
                            <th>Họ tên:</th>
                            <td><?php echo htmlspecialchars($sinhvien['HoTen']); ?></td>
                        </tr>
                        <tr>
                            <th>Giới tính:</th>
                            <td><?php echo htmlspecialchars($sinhvien['GioiTinh']); ?></td>
                        </tr>
                        <tr>
                            <th>Ngày sinh:</th>
                            <td><?php echo date('d/m/Y', strtotime($sinhvien['NgaySinh'])); ?></td>
                        </tr>
                        <tr>
                            <th>Mã ngành:</th>
                            <td><?php echo htmlspecialchars($sinhvien['MaNganh']); ?></td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="index.php?controller=sinhvien&action=edit&id=<?php echo $sinhvien['MaSV']; ?>" 
                           class="btn btn-warning">Sửa</a>
                        <a href="index.php?controller=sinhvien&action=index" 
                           class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('views/shares/footer.php'); ?> 