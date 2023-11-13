<?php
// if (empty($_SESSION['wishlist'])) {
//     $_SESSION['wishlist'] = array();
// }

// if (isset($_GET['action'])) {
//     $id = isset($_GET['id']) ? $_GET['id'] : '';
//     switch ($_GET['action']) {
//         case 'add':
//             if (!in_array($id, $_SESSION['wishlist'])) {
//                 $_SESSION['wishlist'][] = $id;
//             }
//             header("location: ?option=wishlist");
//             break;
//         case 'remove':
//             $index = array_search($id, $_SESSION['wishlist']);
//             if ($index !== false) {
//                 unset($_SESSION['wishlist'][$index]);
//             }
//             header("location: ?option=wishlist");
//             break;
//     }
// }
?>

<?php
if (isset($_SESSION['member'])) {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'add') {
            // Kiểm tra xem sản phẩm đã tồn tại trong danh sách yêu thích của người dùng hay chưa
            $productId = $_GET['id'];
            $result = $connect->query("SELECT * FROM `products` WHERE `id` = $productId");
            $result = mysqli_fetch_array($result);
            $member = $_SESSION['member'];
            $memberId = $connect->query("SELECT `id` FROM `member` WHERE `username` = '$member'");
            $memberId = mysqli_fetch_array($memberId);
            $memberId = $memberId['id'];
            $checkQuery = "SELECT * FROM `wishlist` WHERE `member_id` = '$memberId' AND `product_id` = $productId";
            $checkStatement = $connect->query($checkQuery);
            if (mysqli_num_rows($checkStatement) != 0) {
                //confirm('Đã có sản phẩm này trong wishlist');
                header("location: ?option=wishlist");
            } else {
                // Nếu sản phẩm chưa tồn tại, thêm vào danh sách yêu thích
                $productName = $result['name'];
                $productPrice = $result['price'];
                $productImg = $result['image'];
                $insertQuery = "INSERT INTO `wishlist` (`member_id`, `product_id`, `product_name`, `product_image`, `product_price`) 
                                VALUES ($memberId, $productId, '$productName', '$productImg', $productPrice)";
                $insertStatement = $connect->query($insertQuery);
                header("location: ?option=wishlist");
            }
        } else if ($_GET['action'] === 'remove') {
            $Id = $_GET['id'];
            $deleteQuery = "DELETE FROM `wishlist` WHERE `id` = $Id";
            $deleteStatement = $connect->query($deleteQuery);
            header("location: ?option=wishlist");
        }
    }
} else {
    header("location: ?option=signin");
}
?>


<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="../images/background_show_products.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Danh sách yêu thích</h2>
                    <div class="breadcrumb__option">
                        <a href="?option=home">Trang Chủ</a>
                        <span>Danh sách yêu thích</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->


<!-- Breadcrumb Section Begin -->
<!-- (Dùng mã HTML hiện tại) -->
<!-- Wishlist Section Begin -->
<section class="wishlist spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                // Kiểm tra xem người dùng đã đăng nhập hay chưa
                if (isset($_SESSION['member'])) {
                ?>
                    <div>
                        <table class="wishlist__table">
                            <?php
                            $member = $_SESSION['member'];
                            $memberId = $connect->query("SELECT `id` FROM `member` WHERE `username` = '$member'");
                            $memberId = mysqli_fetch_array($memberId);
                            $memberId = $memberId['id'];
                            $query = "SELECT * FROM `wishlist` WHERE member_id IN ($memberId)";
                            $result = $connect->query($query);
                            if (mysqli_num_rows($result) != 0) {
                            ?>
                                <thead>
                                    <tr>
                                        <th class="wishlist__product">Tên Sách</th>
                                        <th>Giá</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($result as $item) :
                                    ?>
                                        <tr>
                                            <td class="wishlist__item">
                                                <img width="100px" src="../images/<?= $item['product_image'] ?>" alt="">
                                                <a href="?option=detail_product&id=<?= $item['product_id'] ?>">
                                                    <h5>
                                                        <?= $item['product_name'] ?>
                                                    </h5>
                                                </a>
                                            </td>
                                            <td class="wishlist__price">
                                                <?= number_format($item['product_price'], 0, ',', '.') ?>đ
                                            </td>
                                            <td class="wishlist__remove">
                                                <span class="icon_close" 
                                                onclick="if (confirm('Bạn có chắc chắn muốn xóa sản phẩm khỏi wishlist?')) location='?option=wishlist&action=remove&id=<?= $item['id'] ?>';"></span>
                                            </td>
                                        </tr>
                                <?php
                                    endforeach;
                                } else {
                                    echo '<h3 style="text-align: center;">Danh sách yêu thích trống</h3></td></tr>';
                                }
                                ?>
                                </tbody>
                        </table>
                    </div>
                <?php
                } else {
                    // Hiển thị thông báo nếu chưa đăng nhập
                    echo '<h3 style="text-align: center;">Vui lòng đăng nhập để xem danh sách yêu thích</h3>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- Wishlist Section End -->