<h1>Đăng nhập trang quản trị</h1>
<section style="color: red;"><?= isset($alert) ? $alert : '' ?></section>
<form method="post">
    <section>
        <section>
            <label>Username: </label><input type="text" name="username">
        </section>
        <section>
            <label>Password: </label><input type="password" name="password">
        </section>
        <section><input type="submit" value="Đăng nhập"></section>
    </section>
</form>