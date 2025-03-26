<?php require_once('views/shares/header.php'); ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Chỉnh sửa sinh viên</h2>
        </div>
        <div class="card-body">
            <form action="index.php?controller=sinhvien&action=edit&id=<?php echo $sinhvien['MaSV']; ?>" 
                  method="POST" 
                  enctype="multipart/form-data">
                <input type="hidden" name="maSV" value="<?php echo htmlspecialchars($sinhvien['MaSV']); ?>">
                
                <div class="mb-3">
                    <label for="hoTen" class="form-label">Họ tên</label>
                    <input type="text" class="form-control" id="hoTen" name="hoTen" 
                           value="<?php echo htmlspecialchars($sinhvien['HoTen']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Giới tính</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gioiTinh" id="nam" value="Nam"
                                   <?php echo $sinhvien['GioiTinh'] === 'Nam' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="nam">Nam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gioiTinh" id="nu" value="Nữ"
                                   <?php echo $sinhvien['GioiTinh'] === 'Nữ' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="nu">Nữ</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="ngaySinh" class="form-label">Ngày sinh</label>
                    <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" 
                           value="<?php echo htmlspecialchars($sinhvien['NgaySinh']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="hinh" class="form-label">Hình ảnh</label>
                    <?php if (!empty($sinhvien['Hinh'])): ?>
                        <div class="mb-2">
                            <img src="img/<?php echo htmlspecialchars($sinhvien['Hinh']); ?>" 
                                 alt="Ảnh hiện tại" 
                                 style="max-width: 200px;"
                                 class="img-thumbnail">
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="hinh" name="hinh" accept="image/*">
                    <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                </div>
                
                <div class="mb-3">
                    <label for="maNganh" class="form-label">Mã ngành</label>
                    <input type="text" class="form-control" id="maNganh" name="maNganh" 
                           value="<?php echo htmlspecialchars($sinhvien['MaNganh']); ?>" required>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('views/shares/footer.php'); ?> 