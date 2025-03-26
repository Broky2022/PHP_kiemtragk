<?php require_once('views/shares/header.php'); ?>

<div class="card">
    <div class="card-header">
        <h2>Thêm sinh viên mới</h2>
    </div>
    <div class="card-body">
        <form action="index.php?controller=sinhvien&action=store" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="maSV" class="form-label">Mã sinh viên</label>
                <input type="text" class="form-control" id="maSV" name="maSV" required>
            </div>
            
            <div class="mb-3">
                <label for="hoTen" class="form-label">Họ tên</label>
                <input type="text" class="form-control" id="hoTen" name="hoTen" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Giới tính</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gioiTinh" id="nam" value="Nam" checked>
                        <label class="form-check-label" for="nam">Nam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gioiTinh" id="nu" value="Nữ">
                        <label class="form-check-label" for="nu">Nữ</label>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="ngaySinh" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" required>
            </div>
            
            <div class="mb-3">
                <label for="hinh" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="hinh" name="hinh">
            </div>
            
            <div class="mb-3">
                <label for="maNganh" class="form-label">Mã ngành</label>
                <input type="text" class="form-control" id="maNganh" name="maNganh" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Thêm sinh viên</button>
            <a href="index.php?controller=sinhvien&action=index" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>

<?php require_once('views/shares/footer.php'); ?> 