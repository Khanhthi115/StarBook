<div class="login-container">
    <h1>Đăng nhập trang quản trị</h1>
    <section style="color: red; text-align: center; margin-bottom: 20px;"><?= isset($alert) ? $alert : '' ?></section>
    <form method="post">
        <section class="admin-container">
            <section>
                <label>Username: </label><input type="text" name="username">
            </section>
            <section>
                <label>Password: </label><input type="password" name="password">
            </section>
            <section><input class="btn btn-success" type="submit" value="Đăng nhập"></section>
        </section>
    </form>
</div>