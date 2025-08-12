     <!-- views sửa và xóa tài khoản người dùng sửa dc vai trò nữa -->

<?php
// admin/views/sua_taikhoan.php
// admin/views/xoa_taikhoan.php
?>  
<h2>Sửa Tài Khoản</h2>
<form method="POST">
    <div>
        <label for="name">Ten</label><br>
        <input type="text" id="ten" name="ten" value="<?= $nguoidung['ten'] ?>" required>
    </div>

    <div>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= $nguoidung['email'] ?>" required>
    </div>  

    <div>   
        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="mat_khau" name="mat_khau" required>
    </div>

    <div>
        <label for="role">Vai trò:</label><br>
        <select id="vai_tro" name="vai_tro">
            <option value="admin" <?= $nguoidung['vai_tro'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= $nguoidung['vai_tro'] === 'user' ? 'selected' : '' ?>>User</option>
        </select>
    </div>

    <button type="submit">Sửa</button>
</form> 