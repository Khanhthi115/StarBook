<?php
// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     $product = $connect->query("select * from order_detail where productId = $id");
//     if (mysqli_num_rows($product)!=0) {
//         $query = "update products set status=0 where id = $id";
//         $connect->query($query);
//     }else {
//         // delete product and its image
//         $connect->query("delete from products where id = $id");
//         unlink("../images/".$_GET['image']);
//     }
// }
?>
<?php
$status = $_GET['status'];
$query = "select * from orders where status = " . $_GET['status'];
$result = $connect->query($query);
?>
<h1>DANH SÁCH ĐƠN HÀNG <?= $status == 1 ? 'CHƯA XỬ LÝ' : ($status == 2 ? 'ĐANG XỬ LÝ' : ($status == 3 ? 'ĐÃ XỬ LÝ' : 'HỦY')) ?></h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Ngày tạo</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1; ?>
        <?php foreach ($result as $item) : ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= $item['id'] ?></td>
                <td><?= $item['order_date'] ?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="?option=order_detail&id=<?= $item['id'] ?>">Detail</a>
                    <!-- delete button only display when status <> 'HUY' -->
                    <a style="display: <?= $status == 4 ? 'none' : '' ?>" class="btn btn-sm btn-danger" href="?option=order&id=<?= $item['id'] ?>" onclick="return confirm('Are you sure to delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>