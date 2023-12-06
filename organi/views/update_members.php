<?php
if (isset($_SESSION['member'])) {
    $query  = "select * from `member` where `username`='" . mysqli_real_escape_string($connect, $_SESSION['member']) . "'";
    $member = mysqli_fetch_array($connect->query($query));
    $memberId = $member['id'];
}
if (isset($_POST['tinh'])) {
    $fullname = $_POST['fullname'];
    $phonenumber = $_POST['phonenumber'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    if (strlen($phonenumber) !== 10 || !is_numeric($phonenumber)) {
        echo "<script>alert('Số điện thoại không hợp lệ. Vui lòng nhập lại!')</script>";
    } else {
        $connect->query("update member set fullname = '$fullname', 
                        `phonenumber` = '$phonenumber', `address` = '$address', `email` = '$email' 
                        where id = " . $memberId);
        header("Location: ?option=update_members");
    }
    
}

?>
<div class="container">
    <div class="row gutters my-5">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="account-settings">
                        <div class="user-profile text-center">
                            <div class="user-avatar">
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                            </div>
                            <h5 class="user-name my-3"><?= $member['fullname'] ?></h5>
                            <h6 class="user-email"><?= $member['email'] ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card h-100">

                <div class="card-body my-5">
                    <form action="" method="post">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Thông tin cá nhân</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="fullName">Họ và tên</label>

                                    <input name="fullname" type="text" class="form-control" id="fullName"
                                        placeholder="Nhập họ tên" value="<?= $member['fullname'] ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="eMail">Email</label>
                                    <input name="email" type="email" class="form-control" id="eMail"
                                        placeholder="Nhập email" value=<?= $member['email'] ?>>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input name="phonenumber" type="text" class="form-control" id="phone"
                                        placeholder="Nhập số điện thoại" value=<?= $member['phonenumber'] ?>>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="website">Địa chỉ</label>
                                    <input name="address" type="text" class="form-control" id="website"
                                        placeholder="Nhập địa chỉ" value=<?= $member['address'] ?>>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right">
                                    <input type="submit" class="btn btn-primary" value="Update" name="tinh" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>